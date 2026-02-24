@extends('layouts.app')

@section('page-title')
    {{ $rab->judul_rab }}
@endsection

@section('title')
    Detail RAB: {{ $rab->judul_rab }}
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Info -->
        <div class="mb-6">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-[#1e3a8a] text-white p-6">
                    <h1 class="text-3xl font-bold mb-2">{{ $rab->judul_rab }}</h1>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-sm mt-4">
                        <div>
                            <p class="opacity-75">Nomor RAB</p>
                            <p class="font-bold">{{ $rab->nomor_rab }}</p>
                        </div>
                        <div>
                            <p class="opacity-75">Tanggal</p>
                            <p class="font-bold">{{ $rab->tanggal_rab->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="opacity-75">Tahun Anggaran</p>
                            <p class="font-bold">{{ $rab->tahun_anggaran }}</p>
                        </div>
                        <div>
                            <p class="opacity-75">Pembuat</p>
                            <p class="font-bold"><i class="fas fa-user"></i> {{ $rab->user->name }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600"><i class="fas fa-file-invoice-dollar"></i> Total Biaya</p>
                            <p class="text-3xl font-bold text-[#1e3a8a]">Rp {{ number_format($rab->total_jumlah, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600"><i class="fas fa-list"></i> Total Item</p>
                            <p class="text-3xl font-bold text-[#f59e0b]">{{ $rab->items->count() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600"><i class="fas fa-info-circle"></i> Status</p>
                            <div class="mt-2">
                                @if($rab->status === 'draft')
                                    <span class="inline-block px-3 py-1 text-sm bg-gray-200 text-gray-800 rounded font-bold"><i class="fas fa-file"></i> Draft</span>
                                @elseif($rab->status === 'submitted')
                                    <span class="inline-block px-3 py-1 text-sm bg-blue-200 text-blue-800 rounded font-bold"><i class="fas fa-paper-plane"></i> Submitted</span>
                                @elseif($rab->status === 'approved')
                                    <span class="inline-block px-3 py-1 text-sm bg-green-200 text-green-800 rounded font-bold"><i class="fas fa-check"></i> Approved</span>
                                @else
                                    <span class="inline-block px-3 py-1 text-sm bg-red-200 text-red-800 rounded font-bold"><i class="fas fa-times"></i> Rejected</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($rab->keterangan_rab)
                    <div class="p-6 bg-blue-50 border-l-4 border-[#3b82f6]">
                        <p class="text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-sticky-note"></i> Keterangan</p>
                        <p class="text-gray-700">{{ $rab->keterangan_rab }}</p>
                    </div>
                @endif

                @if($rab->agenda)
                    <div class="p-6 bg-green-50 border-l-4 border-green-500">
                        <p class="text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-calendar-alt"></i> Terkait dengan Agenda</p>
                        <p class="text-gray-700 font-semibold">{{ $rab->agenda->judul }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detail Items -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="bg-[#1e3a8a] text-white p-4">
                <h2 class="text-lg font-bold m-0"><i class="fas fa-table"></i> Detail Item RAB</h2>
            </div>

            <div class="overflow-x-auto p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-3 py-2 text-left text-sm font-bold text-gray-700" style="width: 5%">No</th>
                            <th class="border border-gray-300 px-3 py-2 text-left text-sm font-bold text-gray-700" style="width: 25%">Uraian Kegiatan / Item</th>
                            <th class="border border-gray-300 px-3 py-2 text-center text-sm font-bold text-gray-700" style="width: 10%">Volume</th>
                            <th class="border border-gray-300 px-3 py-2 text-center text-sm font-bold text-gray-700" style="width: 12%">Satuan</th>
                            <th class="border border-gray-300 px-3 py-2 text-right text-sm font-bold text-gray-700" style="width: 12%">Harga/Satuan</th>
                            <th class="border border-gray-300 px-3 py-2 text-right text-sm font-bold text-gray-700" style="width: 15%">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rab->items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-3 py-2 text-center font-semibold">{{ $loop->iteration }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $item->uraian }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center">{{ number_format($item->volume, 2) }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center">{{ $item->satuan }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-right font-bold text-[#1e3a8a]">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-3 py-4 text-center text-gray-500">
                                    Tidak ada item dalam RAB ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-[#1e3a8a] text-white font-bold">
                            <td colspan="5" class="border border-gray-300 px-3 py-3 text-right">TOTAL:</td>
                            <td class="border border-gray-300 px-3 py-3 text-right">Rp {{ number_format($rab->total_jumlah, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <a href="{{ route('rab.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if(auth()->id() === $rab->user_id || auth()->user()->role === 'admin')
                <a href="{{ route('rab.edit', $rab) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('rab.destroy', $rab) }}" method="POST" class="inline" onsubmit="return confirm('Hapus RAB ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
