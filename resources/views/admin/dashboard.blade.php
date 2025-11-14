<x-layouts.app :title="__('Admin Dashboard')">

<div class="p-6 space-y-6">

    <div class="mb-4 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 p-5 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold mb-1">Selamat Datang, {{ $user->name }} ! 👋</h2>
                <p class="text-purple-100 text-sm md:text-base">Semoga hari Anda menyenangkan dan produktif</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-blue-400 opacity-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                </svg>
            </div>
        </div>
    </div>
    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 4 CARD -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <h5 class="text-lg font-semibold text-gray-700">Total Karyawan</h5>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $totalKaryawan }}
                <span class="text-sm font-normal text-gray-600">Orang</span>
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-briefcase text-green-900"></i>
                </div>
                <h5 class="text-lg font-semibold text-gray-700">Total Jabatan</h5>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $totalJabatan }} <span class="text-sm font-normal text-gray-600">Jabatan</span></p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-money-bill-wave text-yellow-600"></i>
                </div>
                <h5 class="text-lg font-semibold text-gray-700">Total Gaji</h5>
            </div>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-clock text-purple-600"></i>
                </div>
                <h5 class="text-lg font-semibold text-gray-700">Total Lembur</h5>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $totalLembur }} <span class="text-sm font-normal text-gray-600">Jam</span></p>
        </div>
    </div>

    <!-- 2 CHART -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-area text-blue-600 text-sm"></i>
                    </div>
                    <span class="font-semibold text-gray-800 text-lg">Kinerja Karyawan</span>
                </div>
            </div>
            <div class="p-6">
                <!-- Bar Chart Vertical -->
                <div class="flex items-end justify-between h-64 space-x-2">
                    @php
                        $kinerjaData = [80, 75, 82, 80, 85, 88, 90, 80, 92, 95];
                        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'];
                    @endphp
                    
                    @foreach($kinerjaData as $index => $value)
                        <div class="flex-1 flex flex-col items-center group">
                            <div class="relative w-full">
                                <!-- Tooltip -->
                                <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10 shadow-lg">
                                    {{ $value }}%
                                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                                </div>
                                <!-- Bar -->
                                <div class="w-full bg-gradient-to-t from-blue-500 to-blue-400 rounded-t-lg hover:from-blue-600 hover:to-blue-500 transition-all duration-300 cursor-pointer shadow-sm" 
                                     style="height: {{ $value * 2.4 }}px">
                                </div>
                            </div>
                            <span class="text-xs text-gray-600 mt-2 font-medium">{{ $bulan[$index] }}</span>
                        </div>
                    @endforeach
                </div>
                
                <!-- Legend -->
                <div class="flex items-center justify-center mt-6 space-x-2 bg-blue-50 py-2 rounded-lg">
                    <div class="w-3 h-3 bg-blue-500 rounded shadow-sm"></div>
                    <span class="text-sm text-gray-700 font-medium">Persentase Kinerja (%)</span>
                </div>
            </div>
        </div>
        
        <!-- CHART PENDAPATAN PERUSAHAAN (Line Chart) -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-line text-green-600 text-sm"></i>
                    </div>
                    <span class="font-semibold text-gray-800 text-lg">Pendapatan Perusahaan</span>
                </div>
            </div>
            <div class="p-6">
                <!-- Area Chart dengan SVG -->
                <div class="relative h-64 bg-gray-50 rounded-lg p-4">
                    @php
                        $pendapatanData = [12000000, 15000000, 13000000, 17000000, 19000000, 21000000, 25000000, 30000000, 32000000, 35000000];
                        $maxPendapatan = max($pendapatanData);
                    @endphp
                    
                    <!-- Grid Lines -->
                    <div class="absolute inset-4 left-16 flex flex-col justify-between">
                        @for($i = 0; $i <= 4; $i++)
                            <div class="border-t border-gray-300 relative">
                                <span class="absolute -left-14 -top-2 text-xs text-gray-600 font-medium whitespace-nowrap">
                                    Rp {{ number_format(($maxPendapatan / 4) * (4 - $i) / 1000000, 0) }}M
                                </span>
                            </div>
                        @endfor
                    </div>

                    
                    <!-- Line Chart dengan SVG -->
                    <svg class="absolute top-4 left-16 right-4 bottom-4 w-[calc(100%-5rem)] h-[calc(100%-2rem)]"
                        viewBox="0 0 400 240" preserveAspectRatio="none">

                        <!-- Area Fill Gradient -->
                        <defs>
                            <linearGradient id="areaGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:rgb(16, 185, 129);stop-opacity:0.4" />
                                <stop offset="100%" style="stop-color:rgb(16, 185, 129);stop-opacity:0.05" />
                            </linearGradient>
                        </defs>
                        
                        @php
                            $points = [];
                            foreach($pendapatanData as $index => $value) {
                                $x = ($index / (count($pendapatanData) - 1)) * 400;
                                $y = 240 - (($value / $maxPendapatan) * 240);
                                $points[] = "$x,$y";
                            }
                            $pathPoints = implode(' ', $points);
                        @endphp
                        
                        <!-- Area Background -->
                        <polygon points="0,240 {{ $pathPoints }} 400,240" fill="url(#areaGradient)" />
                        
                        <!-- Line -->
                        <polyline 
                            points="{{ $pathPoints }}" 
                            fill="none" 
                            stroke="rgb(16, 185, 129)" 
                            stroke-width="3"
                            class="drop-shadow-sm"
                        />
                        
                        <!-- Points with Hover Effect -->
                        @foreach($pendapatanData as $index => $value)
                            @php
                                $x = ($index / (count($pendapatanData) - 1)) * 400;
                                $y = 240 - (($value / $maxPendapatan) * 240);
                            @endphp
                            <g class="cursor-pointer">
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="5" fill="white" stroke="rgb(16, 185, 129)" stroke-width="2.5" class="hover:r-7 transition-all drop-shadow-md">
                                </circle>
                                <title>Rp {{ number_format($value, 0, ',', '.') }}</title>
                            </g>
                        @endforeach
                    </svg>
                </div>
                
                <!-- X-Axis Labels -->
                <div class="flex justify-between mt-3 px-5">
                    @foreach($bulan as $b)
                        <span class="text-xs text-gray-600 font-medium">{{ $b }}</span>
                    @endforeach
                </div>
                
                <!-- Legend -->
                <div class="flex items-center justify-center mt-4 space-x-2 bg-green-50 py-2 rounded-lg">
                    <div class="w-3 h-3 bg-green-500 rounded shadow-sm"></div>
                    <span class="text-sm text-gray-700 font-medium">Total Pendapatan (Rp)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL KARYAWAN TERBARU -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-users text-indigo-600 text-sm"></i>
                </div>
                <span class="font-semibold text-gray-800 text-lg">Karyawan Terbaru</span>
            </div>
            <div class="text-sm text-gray-600 bg-white px-3 py-1 rounded-full border">
                Menampilkan {{ $karyawans->firstItem() ?? 0 }} - {{ $karyawans->lastItem() ?? 0 }} dari {{ $karyawans->total() }} karyawan
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Divisi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Umur</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Alamat</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($karyawans as $k)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-semibold text-gray-900">{{ $k->nama }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $k->divisi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $k->umur }} <span class="text-gray-500 text-sm">tahun</span></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($k->jenis_kelamin == 'Laki-laki')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-mars mr-1"></i> Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                                        <i class="fas fa-venus mr-1"></i> Perempuan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700 max-w-xs truncate" title="{{ $k->alamat }}">
                                {{ $k->alamat }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl mb-2 text-gray-300"></i>
                                <div>Tidak ada data karyawan</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if($karyawans->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-lg">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Menampilkan {{ $karyawans->firstItem() }} sampai {{ $karyawans->lastItem() }} dari {{ $karyawans->total() }} data
                </div>
                
                <div class="flex space-x-1">
                    @if ($karyawans->onFirstPage())
                        <span class="px-3 py-2 rounded bg-gray-100 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $karyawans->previousPageUrl() }}" class="px-3 py-2 rounded bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    @foreach ($karyawans->getUrlRange(1, $karyawans->lastPage()) as $page => $url)
                        @if ($page == $karyawans->currentPage())
                            <span class="px-3 py-2 rounded bg-blue-500 text-white font-semibold shadow-sm">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 rounded bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($karyawans->hasMorePages())
                        <a href="{{ $karyawans->nextPageUrl() }}" class="px-3 py-2 rounded bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-3 py-2 rounded bg-gray-100 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

</x-layouts.app>