<x-layouts.app :title="'Detail Karyawan - ' . $karyawan->nama">

<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Detail Karyawan
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Informasi lengkap data karyawan {{ $karyawan->nama }}
                </p>
            </div>
            
            <a href="{{ route('admin.karyawan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-4">
            <!-- Foto Profil Sidebar -->
            <div class="lg:col-span-1 bg-gradient-to-b from-blue-600 to-blue-700 text-white p-8 flex flex-col items-center justify-center">
                <div class="relative mb-6">
                    <img src="{{ $karyawan->foto ? asset('storage/'.$karyawan->foto) : asset('images/default-avatar.png') }}"
                         alt="Foto {{ $karyawan->nama }}"
                         class="w-40 h-40 rounded-full border-4 border-white shadow-lg object-cover">
                    
                    <!-- Status Badge -->
                    <div class="absolute -top-2 -right-2">
                        @if($karyawan->status === 'Aktif')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 shadow-sm">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $karyawan->status }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 shadow-sm">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $karyawan->status }}
                            </span>
                        @endif
                    </div>
                </div>

                <h2 class="text-xl font-bold text-center mb-2">{{ $karyawan->nama }}</h2>
                <p class="text-blue-100 text-center mb-1">{{ $karyawan->jabatan->jabatan ?? '-' }}</p>
                <p class="text-blue-200 text-sm text-center">{{ $karyawan->divisi }}</p>

                <!-- Rating -->
                @if($karyawan->rating)
                    <div class="mt-4 flex items-center justify-center">
                        <div class="bg-blue-500 bg-opacity-20 px-3 py-1 rounded-full">
                            <span class="text-white font-semibold text-sm">
                                Rating: {{ $karyawan->rating->rating }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Detail Information -->
            <div class="lg:col-span-3 p-8">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Informasi Pribadi
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- ID Karyawan -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">ID Karyawan</div>
                            <div class="font-semibold text-gray-800">{{ $karyawan->id_karyawan }}</div>
                        </div>

                        <!-- Nama -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">Nama Lengkap</div>
                            <div class="font-semibold text-gray-800">{{ $karyawan->nama }}</div>
                        </div>

                        <!-- Divisi -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">Divisi</div>
                            <div class="font-semibold text-gray-800">{{ $karyawan->divisi }}</div>
                        </div>

                        <!-- Jabatan -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">Jabatan</div>
                            <div class="font-semibold text-gray-800">{{ $karyawan->jabatan->jabatan ?? '-' }}</div>
                        </div>

                        <!-- Umur -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">Umur</div>
                            <div class="font-semibold text-gray-800">{{ $karyawan->umur }} Tahun</div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">Jenis Kelamin</div>
                            <div class="font-semibold text-gray-800 flex items-center gap-2">
                                @if($karyawan->jenis_kelamin === 'Laki-laki')
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M15.5 2.5h6v6h-2v-2.59l-4.32 4.32a6.5 6.5 0 11-1.42-1.42L18.09 4.5H15.5v-2zM10 9a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/>
                                    </svg>
                                    Laki-laki
                                @else
                                    <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13 6.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm-1 8.5h-1v3h3v2h-3v3h-2v-3H6v-2h3v-3H8a5.5 5.5 0 110-11h4a5.5 5.5 0 110 11z"/>
                                    </svg>
                                    Perempuan
                                @endif
                            </div>
                        </div>

                        <!-- Tanggal Bergabung -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">Tanggal Bergabung</div>
                            <div class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($karyawan->created_at)->translatedFormat('d F Y') }}
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">Status Karyawan</div>
                            <div class="font-semibold">
                                @if($karyawan->status === 'Aktif')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Alamat
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="text-sm text-gray-500 mb-2">Alamat Lengkap</div>
                        <div class="font-semibold text-gray-800 leading-relaxed">{{ $karyawan->alamat }}</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.karyawan.edit', $karyawan->id_karyawan) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Data
                    </a>
                    
                    <form action="{{ route('admin.karyawan.destroy', $karyawan->id_karyawan) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>