<x-layouts.app :title="'Detail Rating - ' . $rating->rating">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Card Utama -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2 flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Rating {{ $rating->rating }}
                    </h3>
                    <p class="text-indigo-100">Detail informasi rating</p>
                </div>
                
                <a href="{{ route('admin.rating.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
                </a>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6 bg-gray-50">
            <h4 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Informasi Rating
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- ID Rating -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <div class="text-sm text-gray-500 mb-1">ID Rating</div>
                    <div class="text-base font-semibold text-gray-800">{{ $rating->id_rating }}</div>
                </div>

                <!-- Rating -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <div class="text-sm text-gray-500 mb-1">Rating</div>
                    <div class="text-base font-semibold text-blue-600 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        {{ $rating->rating }}
                    </div>
                </div>

                <!-- Presentase Bonus -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <div class="text-sm text-gray-500 mb-1">Presentase Bonus</div>
                    <div class="text-base font-semibold text-green-600">
                        {{ number_format($rating->presentase_bonus * 100, 2, ',', '.') }}%
                    </div>
                </div>

                <!-- Tanggal Dibuat -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <div class="text-sm text-gray-500 mb-1">Tanggal Dibuat</div>
                    <div class="text-base font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($rating->created_at)->translatedFormat('d F Y, H:i') }}
                    </div>
                </div>

                <!-- Terakhir Diperbarui -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm md:col-span-2">
                    <div class="text-sm text-gray-500 mb-1">Terakhir Diperbarui</div>
                    <div class="text-base font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($rating->updated_at)->translatedFormat('d F Y, H:i') }}
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 pt-6 mt-6 border-t border-gray-200">
                <a href="{{ route('admin.rating.edit', $rating->id_rating) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Rating
                </a>
                
                <form action="{{ route('admin.rating.destroy', $rating->id_rating) }}" method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus rating ini?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Rating
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>