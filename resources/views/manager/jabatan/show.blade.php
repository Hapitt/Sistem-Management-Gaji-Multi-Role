<x-layouts.app :title="'Detail Jabatan'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Detail Jabatan
                </h1>
                <p class="text-sm text-gray-500">
                    Informasi detail mengenai jabatan.
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('manager.jabatan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informasi Jabatan -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Jabatan</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Jabatan</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $jabatan->jabatan }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Gaji Pokok</label>
                        <p class="mt-1 text-lg font-semibold text-gray-500 italic">
                            Informasi gaji tidak tersedia untuk level manager
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Tunjangan</label>
                        <p class="mt-1 text-lg font-semibold text-gray-500 italic">
                            Informasi tunjangan tidak tersedia untuk level manager
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informasi Hak Akses -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Hak Akses Manager</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-blue-700">Dapat melihat daftar jabatan</span>
                    </div>
                    
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-blue-700">Dapat melihat detail jabatan</span>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span class="text-sm text-gray-500">Tidak dapat melihat informasi gaji</span>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span class="text-sm text-gray-500">Tidak dapat menambah, mengedit, atau menghapus</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>