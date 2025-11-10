<x-layouts.app :title="'Edit Tarif Lembur'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Tarif Lembur
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Perbarui tarif lembur sesuai kebijakan perusahaan.
                </p>
            </div>
            
            <a href="{{ route('admin.lembur.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
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

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="p-6">
            <form action="{{ route('admin.lembur.update', $lembur->id_lembur) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Tarif Lembur -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="md:col-span-1">
                        <label for="tarif" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarif Lembur <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500">
                            Masukkan tarif lembur per jam
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="number" 
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tarif') border-red-500 @enderror" 
                                   id="tarif" name="tarif" 
                                   value="{{ old('tarif', $lembur->tarif) }}" 
                                   placeholder="Masukkan tarif lembur per jam" 
                                   min="0" required>
                        </div>
                        @error('tarif')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Preview Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Preview
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="grid grid-cols-1 gap-3 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Tarif Saat Ini:</span>
                                    <span class="font-semibold text-blue-600">
                                        Rp {{ number_format($lembur->tarif, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Tarif Baru:</span>
                                    <span class="font-semibold text-green-600" id="previewTarifBaru">
                                        Rp {{ number_format($lembur->tarif, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Per Jam:</span>
                                    <span class="font-semibold text-gray-800">Per jam</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.lembur.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors mr-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tarifInput = document.getElementById('tarif');
    const previewTarifBaru = document.getElementById('previewTarifBaru');

    function updatePreview() {
        const tarifValue = tarifInput.value;
        
        if (tarifValue) {
            const formattedTarif = new Intl.NumberFormat('id-ID').format(tarifValue);
            previewTarifBaru.textContent = 'Rp ' + formattedTarif;
            
            // Tambahkan efek visual jika ada perubahan
            if (tarifValue != {{ $lembur->tarif }}) {
                previewTarifBaru.classList.add('text-green-600');
                previewTarifBaru.classList.remove('text-blue-600');
            } else {
                previewTarifBaru.classList.add('text-blue-600');
                previewTarifBaru.classList.remove('text-green-600');
            }
        } else {
            previewTarifBaru.textContent = 'Rp {{ number_format($lembur->tarif, 0, ',', '.') }}';
            previewTarifBaru.classList.add('text-blue-600');
            previewTarifBaru.classList.remove('text-green-600');
        }
    }

    tarifInput.addEventListener('input', updatePreview);

    // Initial preview update
    updatePreview();
});
</script>

</x-layouts.app>