<x-layouts.app :title="'Daftar Karyawan'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Alert pencarian -->
    @if(request('search'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <span>Menampilkan hasil pencarian untuk: <strong>{{ request('search') }}</strong></span>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Daftar Karyawan
                </h1>
                <p class="text-sm text-gray-500">
                    Lihat dan kelola rating seluruh data karyawan perusahaan.
                </p>
            </div>
        </div>

        <!-- Search & Filter -->
        <form action="{{ route('manager.karyawan.index') }}" method="GET" class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-3">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Karyawan</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama karyawan..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
            </div>

            <!-- Filter Jabatan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Jabatan</label>
                <select name="jabatan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Semua Jabatan</option>
                    @foreach($jabatans as $j)
                        <option value="{{ $j->id_jabatan }}" {{ (isset($filterJabatan) && $filterJabatan == $j->id_jabatan) ? 'selected' : '' }}>
                            {{ $j->jabatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Rating -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Rating</label>
                <select name="rating" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Semua Rating</option>
                    @foreach($ratings as $r)
                        <option value="{{ $r->id_rating }}" {{ (isset($filterRating) && $filterRating == $r->id_rating) ? 'selected' : '' }}>
                            {{ $r->rating }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
                <a href="{{ route('manager.karyawan.index') }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Alert sukses -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama</th>
                        <th class="px-4 py-3 font-medium">Divisi</th>
                        <th class="px-4 py-3 font-medium">Jabatan</th>
                        <th class="px-4 py-3 font-medium">Rating</th>
                        <th class="px-4 py-3 font-medium">Umur</th>
                        <th class="px-4 py-3 font-medium">Jenis Kelamin</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 text-center font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($karyawans as $k)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $k->nama }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">{{ $k->divisi }}</span>
                            </td>
                            <td class="px-4 py-3">{{ $k->jabatan->jabatan ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if($k->rating->rating >= 4) bg-green-100 text-green-700
                                    @elseif($k->rating->rating >= 3) bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    ⭐ {{ $k->rating->rating ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $k->umur }} tahun</td>
                            <td class="px-4 py-3">
                                @if($k->jenis_kelamin === 'Laki-laki')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M15.5 2.5h6v6h-2v-2.59l-4.32 4.32a6.5 6.5 0 11-1.42-1.42L18.09 4.5H15.5v-2zM10 9a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/>
                                        </svg>
                                        L
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-700">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M13 6.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm-1 8.5h-1v3h3v2h-3v3h-2v-3H6v-2h3v-3H8a5.5 5.5 0 110-11h4a5.5 5.5 0 110 11z"/>
                                        </svg>
                                        P
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($k->status === 'Aktif')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('manager.karyawan.edit', $k->id_karyawan) }}" class="inline-flex items-center px-2 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded transition-colors" title="Edit Rating">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center p-4 border-t border-gray-200 text-sm text-gray-500">
            <div>
                Menampilkan {{ $karyawans->count() }} dari total {{ $karyawans->total() }} Karyawan
            </div>
            <div class="mt-3 sm:mt-0">
                {{ $karyawans->links() }}
            </div>
        </div>
    </div>
</div>

</x-layouts.app>