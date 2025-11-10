<x-layouts.app :title="'Daftar Gaji Saya'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Alert Pencarian -->
    @if(request('search'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <span>Menampilkan hasil pencarian untuk: <strong>{{ request('search') }}</strong></span>
        </div>
    @endif

    @if(request('periode'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Menampilkan gaji untuk periode: <strong>{{ date('F Y', strtotime(request('periode') . '-01')) }}</strong></span>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Daftar Gaji Saya
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Lihat riwayat gaji yang sudah diserahkan kepada Anda.
                </p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('karyawan.gaji.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                <div class="flex">
                    <input type="month" 
                           name="periode" 
                           value="{{ request('periode') }}"
                           class="px-3 py-2 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-32"
                           title="Filter berdasarkan periode">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-r-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="font-medium text-blue-800">Informasi</h3>
                <p class="text-sm text-blue-600 mt-1">
                    Anda hanya dapat melihat gaji yang sudah diserahkan oleh admin. Jika ada periode yang belum muncul, 
                    silakan hubungi admin untuk proses penyerahan gaji.
                </p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-medium">No</th>
                        <th class="px-4 py-3 font-medium">Periode</th>
                        <th class="px-4 py-3 font-medium">Lama Lembur</th>
                        <th class="px-4 py-3 font-medium">Total Lembur</th>
                        <th class="px-4 py-3 font-medium">Total Bonus</th>
                        <th class="px-4 py-3 font-medium">Total Tunjangan</th>
                        <th class="px-4 py-3 font-medium">Total Pendapatan</th>
                        <th class="px-4 py-3 font-medium">Tanggal Diserahkan</th>
                        <th class="px-4 py-3 text-center font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($gaji as $index => $row)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $gaji->firstItem() + $index }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700">
                                    {{ date('F Y', strtotime($row->periode)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $row->lama_lembur }} jam
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-green-600">
                                Rp {{ number_format($row->total_lembur, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-blue-600">
                                Rp {{ number_format($row->total_bonus, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-purple-600">
                                Rp {{ number_format($row->total_tunjangan, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 font-bold text-green-700 text-base">
                                Rp {{ number_format($row->total_pendapatan, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                @if($row->tanggal_serah)
                                    {{ $row->tanggal_serah->format('d M Y H:i') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <!-- Detail Button -->
                                    <a href="{{ route('karyawan.gaji.show', $row->id_gaji) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors text-sm" 
                                       title="Lihat Detail Gaji">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="text-lg font-medium text-gray-500 mb-2">Belum ada data gaji</div>
                                    <p class="text-sm text-gray-400 mb-4">
                                        @if(request('search') || request('periode'))
                                            Tidak ada gaji yang sesuai dengan pencarian Anda.
                                        @else
                                            Belum ada gaji yang diserahkan kepada Anda.
                                        @endif
                                    </p>
                                    @if(request('search') || request('periode'))
                                        <a href="{{ route('karyawan.gaji.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Tampilkan Semua Gaji
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row justify-between items-center p-4 border-t border-gray-200 text-sm text-gray-500">
            <div>
                Menampilkan {{ $gaji->count() }} dari total {{ $gaji->total() }} Gaji
            </div>
            <div class="mt-3 sm:mt-0">
                {{ $gaji->links() }}
            </div>
        </div>
    </div>
</div>

</x-layouts.app>