<x-layouts.app :title="__('Dashboard Karyawan')">
    <!-- Welcome Card -->
    <div class="sticky top-0 z-10 mb-4 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 p-5 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold mb-1">Selamat Datang, {{ $userName }}! 👋</h2>
                <p class="text-blue-100 text-sm md:text-base">Semoga hari Anda menyenangkan dan produktif</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-blue-400 opacity-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Content yang bisa di-scroll -->
    <div class="space-y-6">
        <!-- Info Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="rounded-xl bg-white p-6 shadow-md border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="rounded-full bg-blue-100 p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Profil Saya</h3>
                </div>
                <p class="text-sm text-gray-600 mb-1"><span class="font-medium">Email:</span> {{ $userEmail }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">Role:</span> 
                    <span class="capitalize px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $userRole }}</span>
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="rounded-xl bg-white p-6 shadow-md border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="rounded-full bg-green-100 p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Status</h3>
                </div>
                <p class="text-2xl font-bold text-gray-800">Aktif</p>
                <p class="text-sm text-gray-600 mt-1">Akun Anda dalam kondisi baik</p>
            </div>

            <!-- Last Login -->
            <div class="rounded-xl bg-white p-6 shadow-md border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="rounded-full bg-purple-100 p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Waktu</h3>
                </div>
                <p class="text-lg font-semibold text-gray-800">{{ now()->format('d M Y') }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ now()->format('H:i') }} WIB</p>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="rounded-xl bg-white p-6 shadow-md border border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Menu Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Menu Item 1 -->
                <a href="{{ route('karyawan.karyawan.index') }}" class="flex flex-col items-center p-6 rounded-lg border border-gray-200 hover:border-blue-500 hover:shadow-lg transition-all duration-200 group">
                    <div class="rounded-full bg-blue-100 p-4 mb-4 group-hover:bg-blue-500 transition-colors duration-200">
                        <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-gray-800 text-center">Daftar Karyawan</span>
                    <span class="text-sm text-gray-500 mt-1 text-center">Lihat data karyawan</span>
                </a>

                <!-- Menu Item 2 -->
                <a href="{{ route('karyawan.jabatan.index') }}" class="flex flex-col items-center p-6 rounded-lg border border-gray-200 hover:border-green-500 hover:shadow-lg transition-all duration-200 group">
                    <div class="rounded-full bg-green-100 p-4 mb-4 group-hover:bg-green-500 transition-colors duration-200">
                        <svg class="w-8 h-8 text-green-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-gray-800 text-center">Daftar Jabatan</span>
                    <span class="text-sm text-gray-500 mt-1 text-center">Lihat daftar jabatan</span>
                </a>

                <!-- Menu Item 3 -->
                <a href="{{ route('karyawan.gaji.index') }}" class="flex flex-col items-center p-6 rounded-lg border border-gray-200 hover:border-yellow-500 hover:shadow-lg transition-all duration-200 group">
                    <div class="rounded-full bg-yellow-100 p-4 mb-4 group-hover:bg-yellow-500 transition-colors duration-200">
                        <svg class="w-8 h-8 text-yellow-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-gray-800 text-center">Data Gaji Saya</span>
                    <span class="text-sm text-gray-500 mt-1 text-center">Lihat riwayat gaji</span>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>