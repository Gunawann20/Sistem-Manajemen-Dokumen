@extends('layouts.app')

@section('page-title')
    Approval Menunggu
@endsection

@section('title')
    Dokumen Menunggu Approval
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-[#1e3a8a] text-white p-4 flex justify-between items-center">
            <h5 class="text-lg font-bold m-0"><i class="fas fa-hourglass-half"></i> Dokumen Menunggu Approval ({{ $folders->count() }})</h5>
            <a href="{{ route('admin.history') }}" class="bg-[#f59e0b] hover:bg-[#d97706] px-4 py-2 rounded text-sm font-semibold transition">
                <i class="fas fa-history"></i> Riwayat
            </a>
        </div>
        <div class="p-6">
            @if($folders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-[#1e3a8a] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">Nama Dokumen</th>
                                <th class="px-6 py-3 text-left font-semibold">Uploader</th>
                                <th class="px-6 py-3 text-left font-semibold">Jenis Dokumen</th>
                                <th class="px-6 py-3 text-left font-semibold">Tahun</th>
                                <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($folders as $document)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <i class="fas fa-file"></i>
                                        <strong>{{ $document->nama_dokumen }}</strong>
                                        @if($document->keterangan)
                                            <br>
                                            <small class="text-gray-500">{{ Str::limit($document->keterangan, 50) }}</small>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <i class="fas fa-user"></i> {{ $document->user?->name ?? 'User Dihapus' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-3 py-1 text-xs bg-[#3b82f6] text-white rounded font-semibold">
                                            {{ $document->jenis_dokumen }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $document->tahun ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $document->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('document.show', $document) }}" class="bg-cyan-500 hover:bg-cyan-600 text-white px-2 py-1 rounded text-xs font-semibold mr-2">
                                            <i class="fas fa-eye"></i> Review
                                        </a>
                                        <form action="{{ route('admin.approve', $document) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs font-semibold mr-2" onclick="return confirm('Setujui dokumen ini?')">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reject', $document) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold" onclick="return confirm('Tolak dokumen ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $folders->links() }}
                </div>
            @else
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded text-center py-8">
                    <i class="fas fa-check-circle text-3xl mb-2 block"></i>
                    <p class="font-semibold">Tidak ada dokumen menunggu approval</p>
                    <p class="text-sm mt-1">Semua dokumen telah disetujui atau ditolak</p>
                </div>
            @endif
        </div>
    </div>
@endsection

