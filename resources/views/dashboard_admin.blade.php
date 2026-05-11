<x-app-layout>
    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pusat Kendali Sistem (Admin)</h1>
                <p class="text-gray-500 text-sm">Monitoring aktivitas E-Archive PN Bale Bandung</p>
            </div>
            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-bold text-xs uppercase tracking-widest">
                Otoritas: {{ $user->grup }}
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-green-700 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
                <h3 class="text-sm opacity-80 uppercase font-semibold">Total Pengguna</h3>
                <p class="text-5xl font-bold mt-2">{{ $totalUsers }}</p>
                <div class="mt-4 text-xs font-medium bg-white/20 inline-block px-2 py-1 rounded">Terdaftar di Sistem</div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-8 border-green-600">
                <h3 class="text-gray-400 text-sm uppercase font-semibold">Arsip Keseluruhan</h3>
                <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalArsipGlobal }}</p>
                <p class="text-xs text-gray-400 mt-2">Dari seluruh sub-bagian pengadilan</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center items-center text-center">
                <p class="text-sm text-gray-500 mb-3">Manajemen Akun</p>
                <a href="{{ route('users.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white w-full py-3 rounded-xl font-bold text-sm transition shadow-md">
                    Kelola Semua User →
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-orange-500 rounded mr-2"></span> Visualisasi Distribusi Data
                </h3>
                <div class="h-[300px]">
                    <canvas id="chartArsip"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <span class="w-2 h-6 bg-green-600 rounded mr-2"></span> Kepaniteraan
                </h3>
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">Pidana</span>
                        <span class="font-bold text-gray-800">{{ $statsBagian['pidana'] }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">Perdata</span>
                        <span class="font-bold text-gray-800">{{ $statsBagian['perdata'] }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">Hukum</span>
                        <span class="font-bold text-gray-800">{{ $statsBagian['hukum'] }}</span>
                    </div>
                </div>

                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <span class="w-2 h-6 bg-blue-600 rounded mr-2"></span> Kesekretariatan
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">Umum & Keuangan</span>
                        <span class="font-bold text-gray-800">{{ $statsBagian['umum'] }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">PTIP</span>
                        <span class="font-bold text-gray-800">{{ $statsBagian['ptip'] }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">Ortala</span>
                        <span class="font-bold text-gray-800">{{ $statsBagian['ortala'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <span class="w-2 h-6 bg-green-600 rounded mr-2"></span> User Terbaru
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-100">
                            @foreach($userTerbaru as $u)
                            <tr>
                                <td class="py-3 text-sm font-bold text-gray-700">{{ $u->name }}</td>
                                <td class="py-3 text-right text-[10px] text-gray-400">{{ $u->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <span class="w-2 h-6 bg-blue-600 rounded mr-2"></span> Upload Terbaru
                </h3>
                <div class="space-y-3">
                    @foreach($arsipTerbaru as $a)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-700 truncate mr-4">{{ $a->judul_arsip }}</span>
                        <span class="text-[10px] bg-green-50 text-green-600 px-2 py-1 rounded-full font-bold whitespace-nowrap">{{ $a->created_at->diffForHumans() }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartArsip').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pidana', 'Perdata', 'Hukum', 'Umum & Keu', 'PTIP', 'Ortala'],
                datasets: [{
                    label: 'Jumlah Dokumen',
                    data: [
                        {{ $statsBagian['pidana'] }}, 
                        {{ $statsBagian['perdata'] }}, 
                        {{ $statsBagian['hukum'] }}, 
                        {{ $statsBagian['umum'] }}, 
                        {{ $statsBagian['ptip'] }}, 
                        {{ $statsBagian['ortala'] }}
                    ],
                    backgroundColor: [
                        '#15803d', '#15803d', '#15803d', // Hijau untuk Kepaniteraan
                        '#2563eb', '#2563eb', '#2563eb'  // Biru untuk Kesekretariatan
                    ],
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: false }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</x-app-layout>