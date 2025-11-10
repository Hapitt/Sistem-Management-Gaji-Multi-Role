<x-layouts.app :title="'Daftar Gaji Karyawan'">

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

    @if(request('serah'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Filter status: <strong>{{ request('serah') == 'sudah' ? 'Sudah Diserahkan' : 'Belum Diserahkan' }}</strong></span>
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
                    Daftar Gaji Karyawan
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola gaji karyawan perusahaan secara efisien.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Search Form -->
                <form action="{{ route('admin.gaji.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                    <div class="flex">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari nama karyawan..." 
                               class="px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
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
                    
                    <!-- Filter Status Serah -->
                    <select name="serah" 
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="sudah" {{ request('serah') == 'sudah' ? 'selected' : '' }}>Sudah Diserahkan</option>
                        <option value="belum" {{ request('serah') == 'belum' ? 'selected' : '' }}>Belum Diserahkan</option>
                    </select>

                </form>

                <!-- Add Button -->
                <a href="{{ route('admin.gaji.calculate') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors whitespace-nowrap">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Hitung Gaji
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-medium">No</th>
                        <th class="px-4 py-3 font-medium">Nama Karyawan</th>
                        <th class="px-4 py-3 font-medium">Tarif Lembur</th>
                        <th class="px-4 py-3 font-medium">Periode</th>
                        <th class="px-4 py-3 font-medium">Lama Lembur</th>
                        <th class="px-4 py-3 font-medium">Total Lembur</th>
                        <th class="px-4 py-3 font-medium">Total Bonus</th>
                        <th class="px-4 py-3 font-medium">Total Tunjangan</th>
                        <th class="px-4 py-3 font-medium">Total Pendapatan</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 text-center font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($gaji as $index => $row)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $gaji->firstItem() + $index }}</td>
                            <td class="px-4 py-3">
                                <span class="font-semibold">{{ $row->karyawan->nama ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                     {{ number_format($row->lembur->tarif ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                    {{ date('M Y', strtotime($row->periode)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                    {{ $row->lama_lembur }} jam
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-green-600">
                                {{ number_format($row->total_lembur, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-blue-600">
                                {{ number_format($row->total_bonus, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-purple-600">
                                {{ number_format($row->total_tunjangan, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 font-bold text-green-700 text-base">
                                {{ number_format($row->total_pendapatan, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                @if($row->serahkan === 'sudah')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Diserahkan
                                        @if($row->tanggal_serah)
                                            <br></span>
                                        @endif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Belum
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-1">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.gaji.edit', $row->id_gaji) }}" 
                                       class="inline-flex items-center px-2 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded transition-colors" 
                                       title="Edit Gaji">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.gaji.destroy', $row->id_gaji) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus data gaji ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded transition-colors" 
                                                title="Hapus Gaji">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>

                                    <!-- Cetak PDF Button -->
                                    <a href="{{ route('admin.gaji.cetak', $row->id_gaji) }}" 
                                       class="inline-flex items-center px-2 py-1 bg-green-100 hover:bg-green-200 text-green-700 rounded transition-colors" 
                                       title="Cetak Struk PDF">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </a>

                                    <!-- Serahkan Button - Hanya untuk gaji yang belum diserahkan -->
                                    @if($row->serahkan === 'belum')
                                        <form action="{{ route('admin.gaji.serahkan', $row->id_gaji) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menyerahkan struk gaji ini kepada {{ $row->karyawan->nama }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-2 py-1 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded transition-colors" 
                                                    title="Serahkan ke Karyawan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>Tidak ada data gaji untuk periode atau pencarian tersebut.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row justify-between items-center p-4 border-t border-gray-200 text-sm text-gray-500">
            <div>
                Menampilkan {{ $gaji->count() }} dari total {{ $gaji->total() }} Gaji Karyawan
            </div>
            <div class="mt-3 sm:mt-0">
                {{ $gaji->links() }}
            </div>
        </div>
    </div>
</div>

</x-layouts.app>