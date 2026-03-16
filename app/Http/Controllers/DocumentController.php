<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $documents = Document::with('user')->paginate(10);
        } else {
            $documents = Document::where('user_id', $user->id)->paginate(10);
        }

        return view('document.index', compact('documents'));
    }

    public function create()
    {
        $user = auth()->user();
        $agenda_id = request()->query('agenda_id');
        $agenda = null;
        
        // Karyawan harus upload melalui agenda
        if ($user->role === 'karyawan' && !$agenda_id) {
            return redirect()->route('agenda.index')->with('info', 'Silakan pilih agenda terlebih dahulu untuk upload dokumen.');
        }
        
        if ($agenda_id) {
            $agenda = \App\Models\Agenda::find($agenda_id);
            if (!$agenda) {
                return redirect()->route('agenda.index')->withErrors(['error' => 'Agenda tidak ditemukan']);
            }
            
            // Karyawan hanya bisa upload ke agenda yang aktif
            if ($user->role === 'karyawan' && $agenda->status === 'closed') {
                return redirect()->route('agenda.index')->withErrors(['error' => 'Agenda ini sudah ditutup, tidak bisa upload lagi.']);
            }
        }

        return view('document.create', compact('agenda'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Karyawan harus upload ke agenda
        if ($user->role === 'karyawan') {
            $validated = $request->validate([
                'nama_dokumen' => 'required|string|max:255',
                'jenis_dokumen' => 'required|in:RKAKL,RAPK,SPJ,LKJ,LAKIP',
                'tahun' => 'required|numeric|min:2020|max:2099',
                'keterangan' => 'nullable|string',
                'agenda_id' => 'required|exists:agendas,id',
            ]);
            
            // Cek agenda aktif
            $agenda = \App\Models\Agenda::find($validated['agenda_id']);
            if ($agenda->status === 'closed') {
                return redirect()->back()->withErrors(['error' => 'Agenda ini sudah ditutup.']);
            }
        } else {
            $validated = $request->validate([
                'nama_dokumen' => 'required|string|max:255',
                'jenis_dokumen' => 'required|in:RKAKL,RAPK,SPJ,LKJ,LAKIP',
                'tahun' => 'required|numeric|min:2020|max:2099',
                'keterangan' => 'nullable|string',
                'agenda_id' => 'nullable|exists:agendas,id',
            ]);
        }

        // Check if files are uploaded
        if (!$request->hasFile('documents') || count($request->file('documents')) === 0) {
            return back()->withErrors(['documents' => 'Silakan pilih minimal satu file untuk di-upload'])->withInput();
        }

        // Validate files
        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:51200',
        ]);

        // Upload each file
        $uploadCount = 0;
        foreach ($request->file('documents') as $file) {
            $filePath = $file->store('documents', 'public');
            Document::create([
                'user_id' => auth()->id(),
                'agenda_id' => $validated['agenda_id'] ?? null,
                'nama_dokumen' => $request->nama_dokumen . ' - ' . $file->getClientOriginalName(),
                'jenis_dokumen' => $request->jenis_dokumen,
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'ukuran_file' => $file->getSize(),
                'tahun' => $request->tahun,
                'keterangan' => $request->keterangan,
                'status' => 'pending',
            ]);
            $uploadCount++;
        }

        if ($validated['agenda_id']) {
            return redirect()->route('agenda.show', $validated['agenda_id'])->with('success', "$uploadCount file(s) berhasil di-upload!");
        }

        return redirect()->route('document.index')->with('success', "$uploadCount file(s) berhasil di-upload dan menunggu persetujuan admin!");
    }

    public function show(Document $document)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $document->user_id) {
            abort(403);
        }

        return view('document.show', compact('document'));
    }

    public function destroy(Document $document)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $document->user_id) {
            abort(403);
        }

        // Only allow deletion if pending
        if ($document->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya file dengan status pending yang dapat dihapus']);
        }

        $document->delete();
        return redirect()->route('document.index')->with('success', 'File berhasil dihapus!');
    }

    public function download(Document $document)
    {
        // Authorization: admin bisa download semua, user hanya file mereka sendiri
        if (auth()->user()->role !== 'admin' && auth()->user()->id !== $document->user_id && auth()->user()->role !== 'karyawan') {
            abort(403);
        }

        $filePath = storage_path('app/public/' . $document->file_path);
        
        // Check file exists
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan: ' . $document->file_path);
        }
        
        // Direct download berdasarkan file extension
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        
        if ($extension === 'pdf') {
            // PDF file - direct download
            return response()->download($filePath, pathinfo($document->file_path, PATHINFO_FILENAME) . '.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        } elseif ($extension === 'html') {
            // HTML file - download as attachment
            return response()->download($filePath, pathinfo($document->file_path, PATHINFO_FILENAME) . '.html', [
                'Content-Type' => 'text/html; charset=UTF-8',
            ]);
        } else {
            // Other file types - generic download
            return response()->download($filePath);
        }
    }

    public function approve(Document $document)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $document->update([
            'status' => 'approved',
            'admin_id' => auth()->id(),
            'keterangan' => 'Disetujui',
        ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'File berhasil disetujui!']);
        }

        return back()->with('success', 'File berhasil disetujui!');
    }

    public function showRejectForm(Document $document)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('document.reject-form', compact('document'));
    }

    public function reject(Request $request, Document $document)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $document->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(),
            'keterangan' => $request->input('keterangan', 'Ditolak'),
        ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'File berhasil ditolak!']);
        }

        return back()->with('success', 'File berhasil ditolak!');
    }
}
