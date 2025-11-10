<x-layouts.app :title="'Detail Jabatan - ' . $jabatan->jabatan">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold flex items-center gap-2 mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $jabatan->jabatan }}
                    </h1>
                    <p class="text-blue-100">Detail informasi jabatan</p>
                </div>
                
                <a href="{{ route('admin.jabatan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="p-6">
            <!-- Section Title -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Informasi Jabatan
                </h2>
            </div>

            <!-- Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- ID Jabatan -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-sm text-gray-500 mb-1">ID Jabatan</div>
                    <div class="font-semibold text-gray-800">{{ $jabatan->id_jabatan }}</div>
                </div>

                <!-- Nama Jabatan -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-sm text-gray-500 mb-1">Nama Jabatan</div>
                    <div class="font-semibold text-gray-800">{{ $jabatan->jabatan }}</div>
                </div>

                <!-- Gaji Pokok -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-sm text-gray-500 mb-1">Gaji Pokok</div>
                    <div class="font-semibold text-green-600 text-lg">
                        Rp {{ number_format($jabatan->gaji_pokok, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Tunjangan -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-sm text-gray-500 mb-1">Tunjangan</div>
                    <div class="font-semibold text-blue-600 text-lg">
                        Rp {{ number_format($jabatan->tunjangan, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Tanggal Dibuat -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-sm text-gray-500 mb-1">Tanggal Dibuat</div>
                    <div class="font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($jabatan->created_at)->translatedFormat('d F Y, H:i') }}
                    </div>
                </div>

                <!-- Terakhir Diperbarui -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-sm text-gray-500 mb-1">Terakhir Diperbarui</div>
                    <div class="font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($jabatan->updated_at)->translatedFormat('d F Y, H:i') }}
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 pt-6 mt-6 border-t border-gray-200">
                <a href="{{ route('admin.jabatan.edit', $jabatan->id_jabatan) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Jabatan
                </a>
                
                <form action="{{ route('admin.jabatan.destroy', $jabatan->id_jabatan) }}" method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jabatan ini?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Jabatan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>