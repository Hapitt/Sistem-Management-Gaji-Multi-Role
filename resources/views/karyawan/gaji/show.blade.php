<x-layouts.app :title="'Detail Gaji'">

<div class="p-4 space-y-4 text-gray-900">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-xl font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Detail Gaji
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Informasi lengkap gaji periode {{ date('F Y', strtotime($gaji->periode)) }}
                </p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('karyawan.gaji.index') }}" class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>

                <a href="{{ route('karyawan.gaji.cetak', $gaji->id_gaji) }}"
                class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9v2a2 2 0 002 2h8a2 2 0 002-2V9m-2-4H8a2 2 0 00-2 2v2h12V7a2 2 0 00-2-2zM6 15h12v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Cetak Struk
                </a>
            </div>
        </div>
    </div>

    <!-- Detail Gaji -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Informasi Utama -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
            <h2 class="text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Karyawan
            </h2>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Nama:</span>
                    <span class="text-sm font-semibold">{{ $gaji->karyawan->nama }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Divisi:</span>
                    <span class="text-sm font-semibold">{{ $gaji->karyawan->divisi }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Jabatan:</span>
                    <span class="text-sm font-semibold">{{ $gaji->karyawan->jabatan->jabatan ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Rating:</span>
                    <span class="text-sm font-semibold">{{ $gaji->karyawan->rating->rating ?? '-' }} ⭐</span>
                </div>
            </div>
        </div>

        <!-- Informasi Periode -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
            <h2 class="text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Informasi Periode
            </h2>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Periode:</span>
                    <span class="text-sm font-semibold">{{ date('F Y', strtotime($gaji->periode)) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Status:</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Sudah Diserahkan
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Tanggal Diserahkan:</span>
                    <span class="text-sm font-semibold">
                        @if($gaji->tanggal_serah)
                            {{ $gaji->tanggal_serah->format('d M Y H:i') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rincian Gaji -->
    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
        <h2 class="text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Rincian Gaji
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Komponen Gaji -->
            <div class="space-y-3">
                <div class="flex justify-between items-center p-2 bg-blue-50 rounded">
                    <span class="text-sm text-gray-700">Lama Lembur:</span>
                    <span class="text-sm font-semibold text-blue-700">{{ $gaji->lama_lembur }} jam</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-green-50 rounded">
                    <span class="text-sm text-gray-700">Total Lembur:</span>
                    <span class="text-sm font-semibold text-green-700">Rp {{ number_format($gaji->total_lembur, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-blue-50 rounded">
                    <span class="text-sm text-gray-700">Total Bonus:</span>
                    <span class="text-sm font-semibold text-blue-700">Rp {{ number_format($gaji->total_bonus, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-purple-50 rounded">
                    <span class="text-sm text-gray-700">Total Tunjangan:</span>
                    <span class="text-sm font-semibold text-purple-700">Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Total -->
            <div class="flex flex-col justify-center items-center p-4 bg-gradient-to-r from-green-500 to-green-600 rounded text-white">
                <span class="text-base font-medium mb-1">Total Pendapatan</span>
                <span class="text-2xl font-bold">Rp {{ number_format($gaji->total_pendapatan, 0, ',', '.') }}</span>
                <span class="text-xs mt-1 text-green-100">Periode {{ date('F Y', strtotime($gaji->periode)) }}</span>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>