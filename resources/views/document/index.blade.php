@extends('layouts.app')

@section('page-title')
    Dokumen Saya
@endsection

@section('title')
    Dokumen Saya - Management Dokumen
@endsection

@section('content')
    @if(auth()->user()->role === 'admin')
        <div class="mb-6 flex gap-3">
            <a href="{{ route('document.create') }}" class="bg-[#3b82f6] hover:bg-[#1e3a8a] text-white px-4 py-2 rounded font-semibold transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Upload Dokumen Baru
            </a>
        </div>
    @else
        <div class="mb-6 bg-blue-100 border-l-4 border-[#3b82f6] text-blue-700 p-4 rounded">
            <i class="fas fa-info-circle"></i> <strong>Informasi:</strong> Untuk upload dokumen, silakan masuk ke agenda yang tersedia.
        </div>
    @endif

    @if($documents->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-[#1e3a8a] text-white p-4">
                <h5 class="text-lg font-bold m-0"><i class="fas fa-file-upload"></i> Daftar Dokumen</h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#1e3a8a] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Nama Dokumen</th>
                            <th class="px-6 py-3 text-left font-semibold">Jenis Dokumen</th>
                            <th class="px-6 py-3 text-left font-semibold">Tahun</th>
                            <th class="px-6 py-3 text-left font-semibold">Status</th>
                            <th class="px-6 py-3 text-left font-semibold">Tanggal Dibuat</th>
                            <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($documents as $document)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"><i class="fas fa-file"></i> <strong>{{ $document->nama_dokumen }}</strong></td>
                                <td class="px-6 py-4">{{ $document->jenis_dokumen }}</td>
                                <td class="px-6 py-4">{{ $document->tahun ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($document->status === 'approved')
                                        <span class="inline-block px-3 py-1 text-xs bg-green-500 text-white rounded"><i class="fas fa-check-circle"></i> Disetujui</span>
                                    @elseif($document->status === 'pending')
                                        <span class="inline-block px-3 py-1 text-xs bg-[#f59e0b] text-white rounded"><i class="fas fa-hourglass-half"></i> Menunggu</span>
                                    @else
                                        <span class="inline-block px-3 py-1 text-xs bg-red-500 text-white rounded"><i class="fas fa-times-circle"></i> Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $document->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('document.show', $document) }}" class="bg-cyan-500 hover:bg-cyan-600 text-white px-3 py-1 rounded text-sm inline-block"><i class="fas fa-eye"></i> Lihat</a>
                                    @if($document->status === 'pending' && auth()->user()->id === $document->user_id)
                                        <form action="{{ route('document.destroy', $document) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <i class="fas fa-inbox text-gray-400 text-6xl mb-4 block"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Dokumen</h3>
            <p class="text-gray-600 mb-6">Anda belum memiliki dokumen. Mulai dengan upload dokumen baru.</p>
            <a href="{{ route('document.create') }}" class="bg-[#3b82f6] hover:bg-[#1e3a8a] text-white px-6 py-3 rounded font-semibold transition">
                <i class="fas fa-plus"></i> Upload Dokumen
            </a>
        </div>
    @endif
@endsection
