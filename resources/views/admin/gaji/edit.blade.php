<x-layouts.app :title="'Edit Gaji Karyawan'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Gaji Karyawan
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Perbarui data perhitungan gaji karyawan berikut dengan benar.
                </p>
            </div>
        </div>
    </div>

    <!-- Alert Error -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <strong class="font-semibold">Terjadi kesalahan!</strong>
            </div>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-4">
            <!-- Foto Karyawan -->
            <div class="lg:col-span-1 bg-gradient-to-br from-blue-600 to-blue-800 text-white p-8 flex flex-col items-center justify-center">
                <div class="relative mb-4">
                    <img src="{{ $gaji->karyawan->foto ? asset('storage/'.$gaji->karyawan->foto) : asset('Logo.png') }}"
                         alt="Foto Karyawan"
                         class="rounded-full border-4 border-white shadow-lg w-32 h-32 object-cover">
                    <span class="absolute -top-2 -right-2 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full shadow-sm">
                        {{ $gaji->karyawan->status }}
                    </span>
                </div>
                <h3 class="text-xl font-bold text-center">{{ $gaji->karyawan->nama }}</h3>
                <p class="text-blue-100 text-center mt-1">{{ $gaji->karyawan->jabatan->jabatan ?? '-' }}</p>
                <p class="text-blue-200 text-sm text-center">{{ $gaji->karyawan->divisi ?? '-' }}</p>
                
                <!-- Info Gaji Saat Ini -->
                <div class="mt-6 p-4 bg-blue-500/20 rounded-lg w-full">
                    <h4 class="font-semibold text-sm mb-2">Info Gaji Saat Ini:</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span>Periode:</span>
                            <span class="font-semibold">{{ date('F Y', strtotime($gaji->periode)) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total:</span>
                            <span class="font-bold">Rp {{ number_format($gaji->total_pendapatan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Status:</span>
                            <span class="font-semibold {{ $gaji->serahkan === 'sudah' ? 'text-green-300' : 'text-yellow-300' }}">
                                {{ $gaji->serahkan === 'sudah' ? 'Diserahkan' : 'Belum Diserahkan' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Edit Gaji -->
            <div class="lg:col-span-3 p-8">
                <!-- PERBAIKAN: Ganti route action ke 'admin.gaji.update' -->
                <form action="{{ route('admin.gaji.update', $gaji->id_gaji) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Karyawan -->
                        <div class="space-y-2">
                            <label for="id_karyawan" class="block text-sm font-semibold text-gray-700">
                                Karyawan <span class="text-red-500">*</span>
                            </label>
                            <select name="id_karyawan" id="id_karyawan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_karyawan') border-red-500 @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id_karyawan }}"
                                        {{ old('id_karyawan', $gaji->id_karyawan) == $k->id_karyawan ? 'selected' : '' }}>
                                        {{ $k->nama }} - {{ $k->jabatan->jabatan ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_karyawan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tarif Lembur -->
                        <div class="space-y-2">
                            <label for="id_lembur" class="block text-sm font-semibold text-gray-700">
                                Tarif Lembur <span class="text-red-500">*</span>
                            </label>
                            <select name="id_lembur" id="id_lembur"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_lembur') border-red-500 @enderror" required>
                                <option value="">-- Pilih Tarif Lembur --</option>
                                @foreach ($lembur as $l)
                                    <option value="{{ $l->id_lembur }}"
                                        data-tarif="{{ $l->tarif }}"
                                        {{ old('id_lembur', $gaji->id_lembur) == $l->id_lembur ? 'selected' : '' }}>
                                        Rp {{ number_format($l->tarif, 0, ',', '.') }} per jam
                                    </option>
                                @endforeach
                            </select>
                            @error('id_lembur')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lama Lembur -->
                        <div class="space-y-2">
                            <label for="lama_lembur" class="block text-sm font-semibold text-gray-700">
                                Lama Lembur (jam) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="lama_lembur" name="lama_lembur" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('lama_lembur') border-red-500 @enderror"
                                value="{{ old('lama_lembur', $gaji->lama_lembur) }}" 
                                placeholder="Masukkan jam lembur" required>
                            @error('lama_lembur')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Periode -->
                        <div class="space-y-2">
                            <label for="periode" class="block text-sm font-semibold text-gray-700">
                                Periode <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="periode" name="periode"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('periode') border-red-500 @enderror"
                                value="{{ old('periode', $gaji->periode) }}" required>
                            @error('periode')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview Perhitungan -->
                    <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <h4 class="font-semibold text-lg text-gray-800 mb-4">Preview Perhitungan Gaji</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <div class="text-sm text-gray-500">Total Lembur</div>
                                <div class="text-lg font-bold text-blue-600" id="preview-total-lembur">
                                    Rp {{ number_format($gaji->total_lembur, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <div class="text-sm text-gray-500">Total Bonus</div>
                                <div class="text-lg font-bold text-purple-600" id="preview-total-bonus">
                                    Rp {{ number_format($gaji->total_bonus, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <div class="text-sm text-gray-500">Total Tunjangan</div>
                                <div class="text-lg font-bold text-green-600" id="preview-total-tunjangan">
                                    Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <div class="text-sm text-gray-500">Total Pendapatan</div>
                                <div class="text-lg font-bold text-green-700" id="preview-total-pendapatan">
                                    Rp {{ number_format($gaji->total_pendapatan, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-3 text-center">
                            * Perhitungan akan diperbarui otomatis setelah disimpan
                        </p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-end mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.gaji.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan & Hitung Ulang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk real-time preview (opsional) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lamaLemburInput = document.getElementById('lama_lembur');
    const tarifLemburSelect = document.getElementById('id_lembur');
    
    function updatePreview() {
        const lamaLembur = parseInt(lamaLemburInput.value) || 0;
        const selectedOption = tarifLemburSelect.options[tarifLemburSelect.selectedIndex];
        const tarifLembur = selectedOption ? parseInt(selectedOption.getAttribute('data-tarif')) || 0 : 0;
        
        const totalLembur = lamaLembur * tarifLembur;
        
        document.getElementById('preview-total-lembur').textContent = 
            'Rp ' + totalLembur.toLocaleString('id-ID');
    }
    
    lamaLemburInput.addEventListener('input', updatePreview);
    tarifLemburSelect.addEventListener('change', updatePreview);
});
</script>

</x-layouts.app>