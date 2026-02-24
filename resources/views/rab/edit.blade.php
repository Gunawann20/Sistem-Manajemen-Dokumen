@extends('layouts.app')

@section('page-title')
    Edit RAB
@endsection

@section('title')
    Edit Rencana Anggaran Biaya (RAB)
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-[#1e3a8a] mb-2"><i class="fas fa-file-invoice-dollar"></i> Edit RAB</h1>
            <p class="text-gray-600">Ubah detail Rencana Anggaran Biaya</p>
        </div>

        <form action="{{ route('rab.update', $rab) }}" method="POST" id="rabForm" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section: Informasi Umum -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-[#1e3a8a] text-white p-4">
                    <h2 class="text-lg font-bold m-0"><i class="fas fa-info-circle"></i> Informasi Umum RAB</h2>
                </div>
                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="judul_rab" class="block text-sm font-bold text-gray-700 mb-2">
                            Judul RAB <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="judul_rab" 
                            id="judul_rab"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent @error('judul_rab') border-red-500 @enderror"
                            placeholder="Contoh: RAB Pengadaan Komputer Tahun 2026"
                            value="{{ old('judul_rab', $rab->judul_rab) }}"
                            required>
                        @error('judul_rab')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_rab" class="block text-sm font-bold text-gray-700 mb-2">
                            Nomor RAB <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nomor_rab" 
                            id="nomor_rab"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent @error('nomor_rab') border-red-500 @enderror"
                            placeholder="Contoh: RAB-2026-001"
                            value="{{ old('nomor_rab', $rab->nomor_rab) }}"
                            required>
                        @error('nomor_rab')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_rab" class="block text-sm font-bold text-gray-700 mb-2">
                            Tanggal RAB <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="tanggal_rab" 
                            id="tanggal_rab"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent @error('tanggal_rab') border-red-500 @enderror"
                            value="{{ old('tanggal_rab', $rab->tanggal_rab->format('Y-m-d')) }}"
                            required>
                        @error('tanggal_rab')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="tahun_anggaran" class="block text-sm font-bold text-gray-700 mb-2">
                            Tahun Anggaran <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="tahun_anggaran" 
                            id="tahun_anggaran"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent @error('tahun_anggaran') border-red-500 @enderror"
                            placeholder="2026"
                            value="{{ old('tahun_anggaran', $rab->tahun_anggaran) }}"
                            min="2020"
                            max="2099"
                            required>
                        @error('tahun_anggaran')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="agenda_id" class="block text-sm font-bold text-gray-700 mb-2">
                            Agenda Terkait (Opsional)
                        </label>
                        <select 
                            name="agenda_id" 
                            id="agenda_id"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent @error('agenda_id') border-red-500 @enderror">
                            <option value="">-- Pilih Agenda --</option>
                            @foreach($agendas as $agenda)
                                <option value="{{ $agenda->id }}" {{ old('agenda_id', $rab->agenda_id) == $agenda->id ? 'selected' : '' }}>
                                    {{ $agenda->judul }}
                                </option>
                            @endforeach
                        </select>
                        @error('agenda_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-gray-600 mt-1">RAB akan ditampilkan sebagai bagian dari agenda jika dipilih</p>
                    </div>

                    <div class="lg:col-span-2">
                        <label for="keterangan_rab" class="block text-sm font-bold text-gray-700 mb-2">
                            Keterangan / Deskripsi
                        </label>
                        <textarea 
                            name="keterangan_rab" 
                            id="keterangan_rab"
                            rows="3"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent @error('keterangan_rab') border-red-500 @enderror"
                            placeholder="Deskripsi atau keterangan tambahan untuk RAB ini (opsional)">{{ old('keterangan_rab', $rab->keterangan_rab) }}</textarea>
                        @error('keterangan_rab')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Detail Item RAB -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-[#1e3a8a] text-white p-4 flex justify-between items-center">
                    <h2 class="text-lg font-bold m-0"><i class="fas fa-list"></i> Detail Item RAB</h2>
                    <button type="button" id="addRowBtn" class="bg-[#f59e0b] hover:bg-[#d97706] px-4 py-2 rounded text-sm font-semibold transition">
                        <i class="fas fa-plus"></i> Tambah Item
                    </button>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full border-collapse" id="rabTable">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-bold text-gray-700" style="width: 5%">No</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-bold text-gray-700" style="width: 25%">Uraian Kegiatan / Item</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-bold text-gray-700" style="width: 10%">Volume</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-bold text-gray-700" style="width: 12%">Satuan</th>
                                <th class="border border-gray-300 px-3 py-2 text-right text-sm font-bold text-gray-700" style="width: 15%">Harga/Satuan</th>
                                <th class="border border-gray-300 px-3 py-2 text-right text-sm font-bold text-gray-700" style="width: 15%">Jumlah</th>
                                <th class="border border-gray-300 px-3 py-2 text-center text-sm font-bold text-gray-700" style="width: 8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rabTableBody">
                            @forelse($rab->items as $item)
                                <tr class="rab-item-row" data-row="{{ $loop->index }}">
                                    <td class="border border-gray-300 px-3 py-2 text-center row-number">{{ $loop->iteration }}</td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <input type="text" name="items[{{ $loop->index }}][uraian]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent" placeholder="Masukkan uraian kegiatan" value="{{ $item->uraian }}" required>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <input type="number" name="items[{{ $loop->index }}][volume]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent volume-input" placeholder="0" step="0.01" value="{{ $item->volume }}" required>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <input type="text" name="items[{{ $loop->index }}][satuan]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent" placeholder="Satuan" value="{{ $item->satuan }}" required>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <input type="number" name="items[{{ $loop->index }}][harga_satuan]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent harga-input" placeholder="0" step="0.01" value="{{ $item->harga_satuan }}" required>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-right">
                                        <input type="number" name="items[{{ $loop->index }}][jumlah]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent jumlah-input" placeholder="0" step="0.01" value="{{ $item->jumlah }}" readonly>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-center">
                                        <button type="button" class="delete-row-btn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="rab-item-row" data-row="0">
                                    <td class="border border-gray-300 px-3 py-2 text-center">1</td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <input type="text" name="items[0][uraian]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent" placeholder="Masukkan uraian kegiatan" required>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <input type="number" name="items[0][volume]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent volume-input" placeholder="0" step="0.01" required>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <input type="text" name="items[0][satuan]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent" placeholder="Satuan" required>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2">
                                        <input type="number" name="items[0][harga_satuan]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent harga-input" placeholder="0" step="0.01" required>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-right">
                                        <input type="number" name="items[0][jumlah]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent jumlah-input" placeholder="0" step="0.01" readonly>
                                    </td>
                                    <td class="border border-gray-300 px-3 py-2 text-center">
                                        <button type="button" class="delete-row-btn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100">
                                <td colspan="5" class="border border-gray-300 px-3 py-2 text-right font-bold">TOTAL:</td>
                                <td class="border border-gray-300 px-3 py-2 text-right font-bold">
                                    <input type="number" id="totalJumlah" name="total_jumlah" class="w-full px-2 py-1 border border-gray-300 rounded bg-yellow-50 font-bold" placeholder="0" readonly>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Submission Buttons -->
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-gradient-to-r from-[#3b82f6] to-[#1e3a8a] hover:from-[#1e3a8a] hover:to-[#0f172a] text-white font-bold py-3 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-save"></i> Update RAB
                </button>
                <a href="{{ route('rab.show', $rab) }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg text-center transition">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        const tableBody = document.getElementById('rabTableBody');
        const addRowBtn = document.getElementById('addRowBtn');
        const rabForm = document.getElementById('rabForm');
        let rowCount = {{ $rab->items->count() }};

        // Function untuk menambah baris baru
        function addNewRow() {
            const newRow = document.createElement('tr');
            newRow.className = 'rab-item-row';
            newRow.dataset.row = rowCount;
            newRow.innerHTML = `
                <td class="border border-gray-300 px-3 py-2 text-center row-number">${rowCount + 1}</td>
                <td class="border border-gray-300 px-3 py-2">
                    <input type="text" name="items[${rowCount}][uraian]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent" placeholder="Masukkan uraian kegiatan" required>
                </td>
                <td class="border border-gray-300 px-3 py-2">
                    <input type="number" name="items[${rowCount}][volume]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent volume-input" placeholder="0" step="0.01" required>
                </td>
                <td class="border border-gray-300 px-3 py-2">
                    <input type="text" name="items[${rowCount}][satuan]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent" placeholder="Satuan" required>
                </td>
                <td class="border border-gray-300 px-3 py-2">
                    <input type="number" name="items[${rowCount}][harga_satuan]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent harga-input" placeholder="0" step="0.01" required>
                </td>
                <td class="border border-gray-300 px-3 py-2 text-right">
                    <input type="number" name="items[${rowCount}][jumlah]" class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-[#3b82f6] focus:border-transparent jumlah-input" placeholder="0" step="0.01" readonly>
                </td>
                <td class="border border-gray-300 px-3 py-2 text-center">
                    <button type="button" class="delete-row-btn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold transition">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
            attachRowListeners(newRow);
            rowCount++;
            updateRowNumbers();
        }

        // Function untuk attach listeners ke baris
        function attachRowListeners(row) {
            const volumeInput = row.querySelector('.volume-input');
            const hargaInput = row.querySelector('.harga-input');
            const jumlahInput = row.querySelector('.jumlah-input');
            const deleteBtn = row.querySelector('.delete-row-btn');

            // Hitung jumlah saat volume atau harga berubah
            [volumeInput, hargaInput].forEach(input => {
                input.addEventListener('change', () => {
                    const volume = parseFloat(volumeInput.value) || 0;
                    const harga = parseFloat(hargaInput.value) || 0;
                    jumlahInput.value = (volume * harga).toFixed(2);
                    updateTotal();
                });
            });

            // Hapus baris
            deleteBtn.addEventListener('click', () => {
                if (tableBody.querySelectorAll('tr').length > 1) {
                    row.remove();
                    updateRowNumbers();
                    updateTotal();
                } else {
                    alert('Minimal harus ada 1 item RAB!');
                }
            });
        }

        // Update nomor urut baris
        function updateRowNumbers() {
            tableBody.querySelectorAll('tr').forEach((row, index) => {
                row.querySelector('.row-number').textContent = index + 1;
            });
        }

        // Update total jumlah
        function updateTotal() {
            const jumlahInputs = tableBody.querySelectorAll('.jumlah-input');
            let total = 0;
            jumlahInputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('totalJumlah').value = total.toFixed(2);
        }

        // Event listeners
        addRowBtn.addEventListener('click', addNewRow);

        // Attach listeners ke semua baris
        document.querySelectorAll('.rab-item-row').forEach(row => {
            attachRowListeners(row);
        });

        // Form validation dan submit
        rabForm.addEventListener('submit', function(e) {
            const items = tableBody.querySelectorAll('tr');
            if (items.length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 item RAB!');
                return false;
            }

            // Validasi setiap item
            let hasError = false;
            items.forEach((row, index) => {
                const uraian = row.querySelector('input[name*="[uraian]"]').value.trim();
                const volume = parseFloat(row.querySelector('input[name*="[volume]"]').value) || 0;
                const satuan = row.querySelector('input[name*="[satuan]"]').value.trim();
                const harga = parseFloat(row.querySelector('input[name*="[harga_satuan]"]').value) || 0;

                if (!uraian || volume === 0 || !satuan || harga === 0) {
                    alert(`Item ${index + 1} harus lengkap dengan uraian, volume, satuan, dan harga!`);
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault();
                return false;
            }
        });

        // Initial calculation
        updateTotal();
    </script>
@endsection
