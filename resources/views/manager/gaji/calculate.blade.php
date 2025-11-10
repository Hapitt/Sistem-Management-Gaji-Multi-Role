<x-layouts.app :title="'Hitung Gaji Karyawan'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Hitung Gaji Karyawan - Divisi {{ $managerDivisi }}
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Hitung gaji untuk karyawan di divisi {{ $managerDivisi }}.
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('manager.gaji.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Informasi Hak Akses -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-blue-700">
                <strong>Hak Akses Manager:</strong> Anda hanya dapat menambah gaji untuk karyawan di divisi <strong>{{ $managerDivisi }}</strong> 
                dan tidak dapat menambah gaji untuk diri sendiri.
            </div>
        </div>
    </div>

    <!-- Form Hitung Gaji -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <form action="{{ route('manager.gaji.store') }}" method="POST" id="gajiForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <!-- Pilih Karyawan -->
                    <div>
                        <label for="id_karyawan" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Karyawan <span class="text-red-500">*</span>
                        </label>
                        <select name="id_karyawan" id="id_karyawan" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_karyawan') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawan as $k)
                                <option value="{{ $k->id_karyawan }}" 
                                        {{ old('id_karyawan') == $k->id_karyawan ? 'selected' : '' }}>
                                    {{ $k->nama }} - {{ $k->divisi }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_karyawan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Hanya menampilkan karyawan di divisi {{ $managerDivisi }} (kecuali diri sendiri)
                        </p>
                    </div>

                    <!-- Pilih Tarif Lembur -->
                    <div>
                        <label for="id_lembur" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarif Lembur <span class="text-red-500">*</span>
                        </label>
                        <select name="id_lembur" id="id_lembur" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_lembur') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Tarif Lembur --</option>
                            @foreach($lembur as $l)
                                <option value="{{ $l->id_lembur }}" 
                                        {{ old('id_lembur') == $l->id_lembur ? 'selected' : '' }}>
                                    Rp {{ number_format($l->tarif, 0, ',', '.') }} per jam
                                </option>
                            @endforeach
                        </select>
                        @error('id_lembur')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <!-- Periode Gaji -->
                    <div>
                        <label for="periode" class="block text-sm font-medium text-gray-700 mb-2">
                            Periode Gaji <span class="text-red-500">*</span>
                        </label>
                        <input type="month" 
                               name="periode" 
                               id="periode"
                               value="{{ old('periode') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('periode') border-red-500 @enderror"
                               required>
                        @error('periode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="periode-message" class="mt-1 text-xs"></div>
                    </div>

                    <!-- Lama Lembur -->
                    <div>
                        <label for="lama_lembur" class="block text-sm font-medium text-gray-700 mb-2">
                            Lama Lembur (jam) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="lama_lembur" 
                               id="lama_lembur"
                               value="{{ old('lama_lembur') }}"
                               min="0"
                               step="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('lama_lembur') border-red-500 @enderror"
                               placeholder="Masukkan jumlah jam lembur"
                               required>
                        @error('lama_lembur')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Masukkan total jam lembur dalam 1 bulan
                        </p>
                    </div>
                </div>
            </div>

            <!-- Preview Perhitungan (akan diisi oleh JavaScript) -->
            <div id="preview-perhitungan" class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200 hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Preview Perhitungan Gaji</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="text-center p-3 bg-white rounded-lg border border-gray-200">
                        <div class="text-sm text-gray-600">Gaji Pokok</div>
                        <div class="text-lg font-bold text-blue-600" id="preview-gaji-pokok">-</div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-lg border border-gray-200">
                        <div class="text-sm text-gray-600">Total Lembur</div>
                        <div class="text-lg font-bold text-green-600" id="preview-total-lembur">-</div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-lg border border-gray-200">
                        <div class="text-sm text-gray-600">Total Bonus</div>
                        <div class="text-lg font-bold text-purple-600" id="preview-total-bonus">-</div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-lg border border-gray-200">
                        <div class="text-sm text-gray-600">Total Pendapatan</div>
                        <div class="text-lg font-bold text-green-700" id="preview-total-pendapatan">-</div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="reset" 
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                    Reset
                </button>
                <button type="submit" 
                        id="submit-btn"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Hitung & Simpan Gaji
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi Tambahan -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div class="text-sm text-yellow-700">
                <strong>Perhatian:</strong> 
                <ul class="list-disc list-inside mt-1 space-y-1">
                    <li>Pastikan data yang dimasukkan sudah benar sebelum menyimpan</li>
                    <li>Gaji yang sudah disimpan tidak dapat diubah</li>
                    <li>Periksa kembali periode gaji untuk menghindari duplikasi</li>
                    <li>Setelah gaji disimpan, Anda dapat menyerahkannya langsung ke karyawan yang bersangkutan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const karyawanSelect = document.getElementById('id_karyawan');
    const periodeInput = document.getElementById('periode');
    const lamaLemburInput = document.getElementById('lama_lembur');
    const tarifLemburSelect = document.getElementById('id_lembur');
    const periodeMessage = document.getElementById('periode-message');
    const submitBtn = document.getElementById('submit-btn');
    const previewSection = document.getElementById('preview-perhitungan');

    // Data karyawan untuk perhitungan
    const karyawanData = {
        @foreach($karyawan as $k)
            '{{ $k->id_karyawan }}': {
                gaji_pokok: {{ $k->jabatan->gaji_pokok ?? 0 }},
                tunjangan: {{ $k->jabatan->tunjangan ?? 0 }},
                presentase_bonus: {{ $k->rating->presentase_bonus ?? 0 }}
            },
        @endforeach
    };

    // Data tarif lembur
    const tarifLemburData = {
        @foreach($lembur as $l)
            '{{ $l->id_lembur }}': {{ $l->tarif }},
        @endforeach
    };

    // Fungsi untuk memeriksa periode
    function checkPeriod() {
        const karyawanId = karyawanSelect.value;
        const periode = periodeInput.value;

        if (karyawanId && periode) {
            fetch('{{ route("manager.gaji.check-period") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    karyawan_id: karyawanId,
                    periode: periode
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    periodeMessage.innerHTML = `<span class="text-red-600">❌ ${data.message}</span>`;
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    periodeMessage.innerHTML = `<span class="text-green-600">✅ ${data.message}</span>`;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                periodeMessage.innerHTML = `<span class="text-yellow-600">⚠️ Gagal memeriksa periode</span>`;
            });
        } else {
            periodeMessage.innerHTML = '';
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    // Fungsi untuk menghitung preview gaji
    function calculatePreview() {
        const karyawanId = karyawanSelect.value;
        const tarifLemburId = tarifLemburSelect.value;
        const lamaLembur = parseInt(lamaLemburInput.value) || 0;

        if (karyawanId && tarifLemburId && karyawanData[karyawanId] && tarifLemburData[tarifLemburId]) {
            const data = karyawanData[karyawanId];
            const tarifLembur = tarifLemburData[tarifLemburId];

            const gajiPokok = data.gaji_pokok;
            const totalLembur = lamaLembur * tarifLembur;
            const totalBonus = gajiPokok * data.presentase_bonus;
            const totalTunjangan = data.tunjangan;
            const totalPendapatan = gajiPokok + totalLembur + totalBonus + totalTunjangan;

            // Update preview
            document.getElementById('preview-gaji-pokok').textContent = 'Rp ' + gajiPokok.toLocaleString('id-ID');
            document.getElementById('preview-total-lembur').textContent = 'Rp ' + totalLembur.toLocaleString('id-ID');
            document.getElementById('preview-total-bonus').textContent = 'Rp ' + totalBonus.toLocaleString('id-ID');
            document.getElementById('preview-total-pendapatan').textContent = 'Rp ' + totalPendapatan.toLocaleString('id-ID');

            // Tampilkan preview
            previewSection.classList.remove('hidden');
        } else {
            previewSection.classList.add('hidden');
        }
    }

    // Event listeners
    karyawanSelect.addEventListener('change', function() {
        checkPeriod();
        calculatePreview();
    });

    periodeInput.addEventListener('change', checkPeriod);
    lamaLemburInput.addEventListener('input', calculatePreview);
    tarifLemburSelect.addEventListener('change', calculatePreview);

    // Validasi form sebelum submit
    document.getElementById('gajiForm').addEventListener('submit', function(e) {
        const karyawanId = karyawanSelect.value;
        const periode = periodeInput.value;
        const lamaLembur = lamaLemburInput.value;
        const tarifLembur = tarifLemburSelect.value;

        if (!karyawanId || !periode || !lamaLembur || !tarifLembur) {
            e.preventDefault();
            alert('Harap lengkapi semua field yang wajib diisi!');
            return;
        }

        // Tampilkan loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;
    });
});
</script>

</x-layouts.app>