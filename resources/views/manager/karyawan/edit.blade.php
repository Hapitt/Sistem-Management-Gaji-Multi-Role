<x-layouts.app :title="'Edit Rating - ' . $karyawan->nama">
    <div class="p-6 space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Edit Rating Karyawan
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Ubah rating untuk karyawan: <strong>{{ $karyawan->nama }}</strong>
                    </p>
                </div>
                <a href="{{ route('manager.karyawan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <form action="{{ route('manager.karyawan.update', $karyawan->id_karyawan) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Informasi Karyawan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Informasi Karyawan</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-sm font-medium text-gray-600">Nama:</span>
                                <span class="text-sm text-gray-800">{{ $karyawan->nama }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-sm font-medium text-gray-600">Divisi:</span>
                                <span class="text-sm text-gray-800">{{ $karyawan->divisi }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-sm font-medium text-gray-600">Jabatan:</span>
                                <span class="text-sm text-gray-800">{{ $karyawan->jabatan->jabatan ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-sm font-medium text-gray-600">Rating Saat Ini:</span>
                                <span class="text-sm font-medium 
                                    @if($karyawan->rating->rating >= 4) text-green-600
                                    @elseif($karyawan->rating->rating >= 3) text-yellow-600
                                    @else text-red-600
                                    @endif">
                                    ⭐ {{ $karyawan->rating->rating ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Rating -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Pilih Rating Baru</h3>
                        
                        <div class="space-y-4">
                            <!-- Rating Options -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Rating</label>
                                <div class="space-y-2">
                                    @foreach($ratings as $rating)
                                        <div class="flex items-center">
                                            <input type="radio" name="id_rating" value="{{ $rating->id_rating }}" 
                                                id="rating_{{ $rating->id_rating }}" 
                                                {{ $karyawan->id_rating == $rating->id_rating ? 'checked' : '' }}
                                                class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                                            <label for="rating_{{ $rating->id_rating }}" class="ml-3 flex items-center text-sm text-gray-700">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                                    @if($rating->rating >= 4) bg-green-100 text-green-800
                                                    @elseif($rating->rating >= 3) bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    ⭐ {{ $rating->rating }} 
                                                    <span class="ml-1 text-xs opacity-75">({{ $rating->presentase_bonus * 100 }}% bonus)</span>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @error('id_rating')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Preview Bonus -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Informasi Bonus</h4>
                                <p class="text-xs text-gray-600">
                                    Rating mempengaruhi persentase bonus yang diterima karyawan. 
                                    Rating lebih tinggi = bonus lebih besar.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('manager.karyawan.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Rating
                    </button>
                </div>
            </form>
        </div>

        <!-- Informasi Rating System -->
        <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
            <h3 class="text-lg font-medium text-blue-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Panduan Rating
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div class="text-center p-3 bg-white rounded-lg border border-blue-100">
                    <div class="text-lg font-bold text-green-600">⭐ 5</div>
                    <div class="text-xs text-gray-600 mt-1">Excellent</div>
                    <div class="text-xs font-medium text-green-600 mt-1">Bonus: {{ $ratings->where('rating', 5)->first()->presentase_bonus ?? 0 }}%</div>
                </div>
                <div class="text-center p-3 bg-white rounded-lg border border-blue-100">
                    <div class="text-lg font-bold text-green-600">⭐ 4</div>
                    <div class="text-xs text-gray-600 mt-1">Very Good</div>
                    <div class="text-xs font-medium text-green-600 mt-1">Bonus: {{ $ratings->where('rating', 4)->first()->presentase_bonus ?? 0 }}%</div>
                </div>
                <div class="text-center p-3 bg-white rounded-lg border border-blue-100">
                    <div class="text-lg font-bold text-yellow-600">⭐ 3</div>
                    <div class="text-xs text-gray-600 mt-1">Good</div>
                    <div class="text-xs font-medium text-yellow-600 mt-1">Bonus: {{ $ratings->where('rating', 3)->first()->presentase_bonus ?? 0 }}%</div>
                </div>
                <div class="text-center p-3 bg-white rounded-lg border border-blue-100">
                    <div class="text-lg font-bold text-red-600">⭐ 2</div>
                    <div class="text-xs text-gray-600 mt-1">Need Improvement</div>
                    <div class="text-xs font-medium text-red-600 mt-1">Bonus: {{ $ratings->where('rating', 2)->first()->presentase_bonus ?? 0 }}%</div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>