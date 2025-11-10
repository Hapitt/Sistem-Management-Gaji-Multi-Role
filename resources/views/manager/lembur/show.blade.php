<x-layouts.app :title="'Detail Tarif Lembur'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Detail Tarif Lembur
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Informasi detail mengenai tarif lembur.
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('manager.lembur.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
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
            <!-- Informasi Tarif Lembur -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Tarif</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Tarif Lembur per Jam</label>
                        <p class="mt-1 text-2xl font-bold text-blue-600">
                            Rp {{ number_format($lembur->tarif, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            Tarif yang berlaku untuk setiap jam lembur karyawan
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">ID Lembur</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $lembur->id_lembur }}</p>
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
                        <span class="text-sm text-blue-700">Dapat melihat daftar tarif lembur</span>
                    </div>
                    
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-blue-700">Dapat melihat detail tarif lembur</span>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span class="text-sm text-gray-500">Tidak dapat menambah tarif lembur</span>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span class="text-sm text-gray-500">Tidak dapat mengedit tarif lembur</span>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span class="text-sm text-gray-500">Tidak dapat menghapus tarif lembur</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Catatan -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div class="text-sm text-yellow-700">
                <strong>Perhatian:</strong> Untuk perubahan tarif lembur, silakan hubungi administrator atau bagian HRD.
            </div>
        </div>
    </div>
</div>

</x-layouts.app>