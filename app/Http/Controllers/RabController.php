<?php

namespace App\Http\Controllers;

use App\Models\Rab;
use App\Models\RabItem;
use App\Models\Agenda;
use Illuminate\Http\Request;

class RabController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $rabs = Rab::with('user', 'agenda')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $rabs = Rab::where('user_id', $user->id)->with('agenda')->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('rab.index', compact('rabs'));
    }

    public function create(Request $request)
    {
        $agendas = Agenda::where('status', 'active')->get();
        $selectedAgendaId = $request->query('agenda_id');
        return view('rab.create', compact('agendas', 'selectedAgendaId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_rab' => 'required|string|max:255',
            'nomor_rab' => 'required|string|unique:rabs,nomor_rab',
            'tanggal_rab' => 'required|date',
            'tahun_anggaran' => 'required|numeric|min:2020|max:2099',
            'keterangan_rab' => 'nullable|string',
            'agenda_id' => 'nullable|exists:agendas,id',
            'items' => 'required|array|min:1',
            'items.*.uraian' => 'required|string',
            'items.*.volume' => 'required|numeric|min:0.01',
            'items.*.satuan' => 'required|string',
            'items.*.harga_satuan' => 'required|numeric|min:0',
            'items.*.jumlah' => 'nullable|numeric',
        ]);

        // Hitung total jumlah
        $total_jumlah = 0;
        foreach ($request->items as $item) {
            $total_jumlah += $item['volume'] * $item['harga_satuan'];
        }

        // Buat RAB
        $rab = Rab::create([
            'user_id' => auth()->id(),
            'agenda_id' => $request->agenda_id,
            'judul_rab' => $validated['judul_rab'],
            'nomor_rab' => $validated['nomor_rab'],
            'tanggal_rab' => $validated['tanggal_rab'],
            'tahun_anggaran' => $validated['tahun_anggaran'],
            'keterangan_rab' => $validated['keterangan_rab'],
            'total_jumlah' => $total_jumlah,
            'status' => 'draft',
        ]);

        // Buat items RAB
        foreach ($request->items as $index => $item) {
            $jumlah = $item['volume'] * $item['harga_satuan'];
            RabItem::create([
                'rab_id' => $rab->id,
                'uraian' => $item['uraian'],
                'volume' => $item['volume'],
                'satuan' => $item['satuan'],
                'harga_satuan' => $item['harga_satuan'],
                'jumlah' => $jumlah,
            ]);
        }

        return redirect()->route('rab.show', $rab)->with('success', 'RAB berhasil dibuat!');
    }

    public function show(Rab $rab)
    {
        $rab->load('user', 'agenda', 'items');
        return view('rab.show', compact('rab'));
    }

    public function edit(Rab $rab)
    {
        if (auth()->id() !== $rab->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $agendas = Agenda::where('status', 'active')->get();
        $rab->load('items');
        return view('rab.edit', compact('rab', 'agendas'));
    }

    public function update(Request $request, Rab $rab)
    {
        if (auth()->id() !== $rab->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'judul_rab' => 'required|string|max:255',
            'nomor_rab' => 'required|string|unique:rabs,nomor_rab,' . $rab->id,
            'tanggal_rab' => 'required|date',
            'tahun_anggaran' => 'required|numeric|min:2020|max:2099',
            'keterangan_rab' => 'nullable|string',
            'agenda_id' => 'nullable|exists:agendas,id',
            'items' => 'required|array|min:1',
            'items.*.uraian' => 'required|string',
            'items.*.volume' => 'required|numeric|min:0.01',
            'items.*.satuan' => 'required|string',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        // Hitung total
        $total_jumlah = 0;
        foreach ($request->items as $item) {
            $total_jumlah += $item['volume'] * $item['harga_satuan'];
        }

        // Update RAB
        $rab->update([
            'judul_rab' => $validated['judul_rab'],
            'nomor_rab' => $validated['nomor_rab'],
            'tanggal_rab' => $validated['tanggal_rab'],
            'tahun_anggaran' => $validated['tahun_anggaran'],
            'keterangan_rab' => $validated['keterangan_rab'],
            'agenda_id' => $request->agenda_id,
            'total_jumlah' => $total_jumlah,
        ]);

        // Hapus items lama dan buat baru
        $rab->items()->delete();
        foreach ($request->items as $item) {
            $jumlah = $item['volume'] * $item['harga_satuan'];
            RabItem::create([
                'rab_id' => $rab->id,
                'uraian' => $item['uraian'],
                'volume' => $item['volume'],
                'satuan' => $item['satuan'],
                'harga_satuan' => $item['harga_satuan'],
                'jumlah' => $jumlah,
            ]);
        }

        return redirect()->route('rab.show', $rab)->with('success', 'RAB berhasil diperbarui!');
    }

    public function destroy(Rab $rab)
    {
        if (auth()->id() !== $rab->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $rab->delete();
        return redirect()->route('rab.index')->with('success', 'RAB berhasil dihapus!');
    }

    // Create RAB form khusus untuk upload ke agenda
    public function createForAgenda(Agenda $agenda)
    {
        // Cek akses - hanya karyawan atau admin yang bisa upload
        if (auth()->user()->role !== 'karyawan' && auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Cek agenda status
        if ($agenda->status === 'closed') {
            return redirect()->route('agenda.show', $agenda)->with('error', 'Agenda ini telah ditutup.');
        }

        return view('rab.upload-for-agenda', compact('agenda'));
    }

    // Store RAB untuk agenda spesifik
    public function storeForAgenda(Request $request, Agenda $agenda)
    {
        // Cek akses
        if (auth()->user()->role !== 'karyawan' && auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Cek agenda status
        if ($agenda->status === 'closed') {
            return redirect()->route('agenda.show', $agenda)->with('error', 'Agenda ini telah ditutup.');
        }

        $validated = $request->validate([
            'judul_rab' => 'required|string|max:255',
            'nomor_rab' => 'required|string|unique:rabs,nomor_rab',
            'tanggal_rab' => 'required|date',
            'tahun_anggaran' => 'required|numeric|min:2020|max:2099',
            'keterangan_rab' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.uraian' => 'required|string',
            'items.*.volume' => 'required|numeric|min:0.01',
            'items.*.satuan' => 'required|string',
            'items.*.harga_satuan' => 'required|numeric|min:0',
            'items.*.jumlah' => 'nullable|numeric',
        ]);

        // Hitung total jumlah
        $total_jumlah = 0;
        foreach ($request->items as $item) {
            $total_jumlah += $item['volume'] * $item['harga_satuan'];
        }

        // Buat RAB dengan agenda_id dari route parameter
        $rab = Rab::create([
            'user_id' => auth()->id(),
            'agenda_id' => $agenda->id,
            'judul_rab' => $validated['judul_rab'],
            'nomor_rab' => $validated['nomor_rab'],
            'tanggal_rab' => $validated['tanggal_rab'],
            'tahun_anggaran' => $validated['tahun_anggaran'],
            'keterangan_rab' => $validated['keterangan_rab'],
            'total_jumlah' => $total_jumlah,
            'status' => 'draft',
        ]);

        // Buat items RAB
        foreach ($request->items as $index => $item) {
            $jumlah = $item['volume'] * $item['harga_satuan'];
            RabItem::create([
                'rab_id' => $rab->id,
                'uraian' => $item['uraian'],
                'volume' => $item['volume'],
                'satuan' => $item['satuan'],
                'harga_satuan' => $item['harga_satuan'],
                'jumlah' => $jumlah,
            ]);
        }

        return redirect()->route('agenda.show', $agenda)->with('success', 'RAB berhasil diupload ke agenda!');
    }
}
