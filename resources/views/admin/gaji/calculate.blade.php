<x-layouts.app :title="'Hitung Gaji Karyawan'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Hitung Gaji Karyawan
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Silakan isi data berikut untuk menghitung dan menyimpan gaji karyawan.
                </p>
            </div>
            
            <a href="{{ route('admin.gaji.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Validation -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-start" role="alert">
            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="font-semibold">Terjadi kesalahan!</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Success Alert -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="p-6">
            <form action="{{ route('admin.gaji.store') }}" method="POST" id="gajiForm">
                @csrf

                <!-- Karyawan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="md:col-span-1">
                        <label for="id_karyawan" class="block text-sm font-medium text-gray-700 mb-2">
                            Karyawan <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <select name="id_karyawan" id="id_karyawan" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_karyawan') border-red-500 @enderror" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach ($karyawan as $k)
                                <option value="{{ $k->id_karyawan }}" {{ old('id_karyawan') == $k->id_karyawan ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_karyawan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tarif Lembur -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="md:col-span-1">
                        <label for="id_lembur" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarif Lembur <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <select name="id_lembur" id="id_lembur" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_lembur') border-red-500 @enderror" required>
                            <option value="">-- Pilih Tarif Lembur --</option>
                            @foreach ($lembur as $l)
                                <option value="{{ $l->id_lembur }}" data-tarif="{{ $l->tarif }}" {{ old('id_lembur') == $l->id_lembur ? 'selected' : '' }}>
                                    Rp {{ number_format($l->tarif, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_lembur')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lama Lembur -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="md:col-span-1">
                        <label for="lama_lembur" class="block text-sm font-medium text-gray-700 mb-2">
                            Lama Lembur (jam) <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <input type="number" id="lama_lembur" name="lama_lembur"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('lama_lembur') border-red-500 @enderror"
                            value="{{ old('lama_lembur') }}" 
                            placeholder="Masukkan jumlah jam lembur"
                            min="0" required>
                        @error('lama_lembur')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Periode -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="md:col-span-1">
                        <label for="periode" class="block text-sm font-medium text-gray-700 mb-2">
                            Periode <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500">
                            Pilih bulan dan tahun periode gaji
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <input type="date" id="periode" name="periode"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('periode') border-red-500 @enderror"
                            value="{{ old('periode') }}" required>
                        @error('periode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- Info Validasi Periode -->
                        <div id="periodeInfo" class="mt-2 hidden">
                            <div class="flex items-center text-sm" id="periodeMessage">
                                <!-- Message akan diisi oleh JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Calculation -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Preview Perhitungan
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="grid grid-cols-1 gap-3 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Lembur:</span>
                                    <span class="font-semibold text-blue-700" id="previewLembur">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Status Validasi:</span>
                                    <span class="font-semibold text-green-600" id="previewStatus">Belum dihitung</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <button type="submit" id="submitButton" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Hitung & Simpan Gaji
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const karyawanSelect = document.getElementById('id_karyawan');
    const tarifLemburSelect = document.getElementById('id_lembur');
    const lamaLemburInput = document.getElementById('lama_lembur');
    const periodeInput = document.getElementById('periode');
    const previewLembur = document.getElementById('previewLembur');
    const previewStatus = document.getElementById('previewStatus');
    const periodeInfo = document.getElementById('periodeInfo');
    const periodeMessage = document.getElementById('periodeMessage');
    const submitButton = document.getElementById('submitButton');
    const form = document.getElementById('gajiForm');

    let currentValidation = {
        isValid: false,
        message: '',
        type: '' // 'success', 'warning', 'error'
    };

    async function checkPeriodValidation() {
        const karyawanId = karyawanSelect.value;
        const periode = periodeInput.value;

        console.log('Checking period validation:', { karyawanId, periode });

        if (!karyawanId || !periode) {
            hidePeriodInfo();
            return;
        }

        try {
            // Gunakan route name yang benar
            const url = `{{ route('admin.gaji.checkPeriod') }}?karyawan_id=${karyawanId}&periode=${periode}`;
            console.log('Fetching URL:', url);
            
            const response = await fetch(url);
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Response data:', data);
            
            if (data.exists) {
                showPeriodInfo('Gaji untuk karyawan ini pada periode yang sama sudah ada!', 'error');
                currentValidation = { isValid: false, message: 'Period conflict', type: 'error' };
            } else {
                showPeriodInfo('Periode tersedia untuk karyawan ini', 'success');
                currentValidation = { isValid: true, message: 'Period available', type: 'success' };
            }
        } catch (error) {
            console.error('Error checking period:', error);
            showPeriodInfo('Error memeriksa periode. Silakan coba lagi.', 'error');
            currentValidation = { isValid: false, message: 'Check error', type: 'error' };
        }
        
        updateSubmitButton();
    }

    function showPeriodInfo(message, type) {
        periodeInfo.classList.remove('hidden');
        periodeMessage.innerHTML = '';
        
        const icon = type === 'success' ? 
            '<svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>' :
            '<svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
        
        const colorClass = type === 'success' ? 'text-green-600' : 'text-red-600';
        
        periodeMessage.innerHTML = `${icon}<span class="${colorClass}">${message}</span>`;
    }

    function hidePeriodInfo() {
        periodeInfo.classList.add('hidden');
        currentValidation = { isValid: false, message: '', type: '' };
        updateSubmitButton();
    }

    function updatePreview() {
        const selectedOption = tarifLemburSelect.options[tarifLemburSelect.selectedIndex];
        const lamaLembur = parseInt(lamaLemburInput.value) || 0;
        
        if (selectedOption.value && lamaLembur > 0) {
            const tarif = parseInt(selectedOption.getAttribute('data-tarif'));
            const totalLembur = tarif * lamaLembur;
            const formattedTotal = new Intl.NumberFormat('id-ID').format(totalLembur);
            
            previewLembur.textContent = 'Rp ' + formattedTotal;
            previewStatus.textContent = 'Siap dihitung';
            previewStatus.className = 'font-semibold text-green-600';
        } else {
            previewLembur.textContent = 'Rp 0';
            previewStatus.textContent = 'Belum dihitung';
            previewStatus.className = 'font-semibold text-gray-600';
        }
        
        updateSubmitButton();
    }

    function updateSubmitButton() {
        const isFormValid = 
            karyawanSelect.value && 
            tarifLemburSelect.value && 
            lamaLemburInput.value && 
            periodeInput.value &&
            currentValidation.isValid;

        console.log('Form validation:', {
            karyawan: karyawanSelect.value,
            lembur: tarifLemburSelect.value,
            lamaLembur: lamaLemburInput.value,
            periode: periodeInput.value,
            validation: currentValidation.isValid,
            totalValid: isFormValid
        });

        if (isFormValid) {
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    // Event listeners
    karyawanSelect.addEventListener('change', function() {
        console.log('Karyawan changed');
        checkPeriodValidation();
        updateSubmitButton();
    });

    periodeInput.addEventListener('change', function() {
        console.log('Periode changed');
        checkPeriodValidation();
        updateSubmitButton();
    });

    tarifLemburSelect.addEventListener('change', updatePreview);
    lamaLemburInput.addEventListener('input', updatePreview);

    // Form submission validation
    form.addEventListener('submit', function(e) {
        console.log('Form submitted, validation:', currentValidation);
        if (!currentValidation.isValid) {
            e.preventDefault();
            alert('Tidak dapat menyimpan gaji. Periode untuk karyawan ini sudah ada.');
        }
    });

    // Initial setup
    updatePreview();
    updateSubmitButton();

});
</script>

</x-layouts.app>