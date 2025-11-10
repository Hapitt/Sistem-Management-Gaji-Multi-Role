<x-layouts.app :title="'Tambah Rating'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Tambah Rating Baru
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Silakan isi informasi rating baru yang ingin ditambahkan.
                </p>
            </div>
            
            <a href="{{ route('admin.rating.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
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
            <form action="{{ route('admin.rating.store') }}" method="POST">
                @csrf

                @php
                    // Hitung total bonus saat ini
                    $totalBonus = \App\Models\Rating::sum('presentase_bonus');
                    $sisaBonus = 1 - $totalBonus; // sisa bonus dalam desimal
                    if($sisaBonus < 0) $sisaBonus = 0;
                @endphp

                <!-- Rating -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="md:col-span-1">
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">
                            Rating <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <input type="number" step="0.01" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('rating') border-red-500 @enderror" 
                               id="rating" name="rating" value="{{ old('rating') }}" 
                               placeholder="Masukkan nilai rating (contoh: 4.5)" required>
                        @error('rating')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Presentase Bonus -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="md:col-span-1">
                        <label for="presentase_bonus" class="block text-sm font-medium text-gray-700 mb-2">
                            Presentase Bonus <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500">
                            Nilai antara 0.01 - 1.00 (1% - 100%)
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <input type="number" step="0.01" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('presentase_bonus') border-red-500 @enderror" 
                                   id="presentase_bonus" name="presentase_bonus" value="{{ old('presentase_bonus') }}" 
                                   placeholder="Masukkan persentase bonus (contoh: 0.15)" 
                                   min="0.01" max="1" step="0.01" required>
                        </div>
                        
                        <!-- Info Sisa Bonus -->
                        <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-blue-700 font-medium">Sisa bonus yang tersedia:</span>
                                <span class="text-sm font-bold text-blue-800">{{ number_format($sisaBonus * 100, 2) }}%</span>
                            </div>
                            @if($sisaBonus > 0)
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $sisaBonus * 100 }}%"></div>
                                </div>
                            @else
                                <div class="w-full bg-red-200 rounded-full h-2 mt-2">
                                    <div class="bg-red-500 h-2 rounded-full" style="width: 100%"></div>
                                </div>
                                <p class="text-xs text-red-600 mt-1">Bonus sudah mencapai 100%. Tidak dapat menambah bonus baru.</p>
                            @endif
                        </div>

                        @error('presentase_bonus')
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
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Rating:</span>
                                    <span class="font-semibold text-gray-800 ml-2" id="previewRating">-</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Bonus:</span>
                                    <span class="font-semibold text-gray-800 ml-2" id="previewBonus">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            {{ $sisaBonus <= 0 ? 'disabled' : '' }}>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Tambah Rating
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingInput = document.getElementById('rating');
    const bonusInput = document.getElementById('presentase_bonus');
    const previewRating = document.getElementById('previewRating');
    const previewBonus = document.getElementById('previewBonus');

    function updatePreview() {
        // Update rating preview
        const ratingValue = ratingInput.value;
        previewRating.textContent = ratingValue ? ratingValue + ' ⭐' : '-';

        // Update bonus preview
        const bonusValue = bonusInput.value;
        if (bonusValue) {
            const percentage = (bonusValue * 100).toFixed(2);
            previewBonus.textContent = percentage + '%';
        } else {
            previewBonus.textContent = '-';
        }
    }

    ratingInput.addEventListener('input', updatePreview);
    bonusInput.addEventListener('input', updatePreview);

    // Initial preview update
    updatePreview();
});
</script>

</x-layouts.app>