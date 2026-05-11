<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ __('E-ARCHIVE') }}</h2>
                    <span class="px-2.5 py-1 bg-amber-100/80 text-amber-800 text-[10px] font-bold rounded-md uppercase tracking-widest border border-amber-200/50">
                        @if(auth()->user()->grup == 'pimpinan')
                            Mode Pantauan Pimpinan
                        @else
                            Otoritas Bagian {{ strtoupper(auth()->user()->grup) }}
                        @endif
                    </span>
                </div>
            </div>
            <a href="{{ route('arsip.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-[#085a3a] hover:bg-emerald-800 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-900/20 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Arsip Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 relative">
                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold text-gray-800 mb-2 flex items-center gap-2">
                        Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }}! <span class="text-4xl origin-bottom-right hover:rotate-12 transition-transform duration-300 cursor-default">👋</span>
                    </h2>
                    <p class="text-sm text-gray-500 font-medium">
                        @if(auth()->user()->grup == 'pimpinan')
                            Menampilkan agregat data dari <span class="font-bold text-[#085a3a] bg-emerald-50 px-2 py-0.5 rounded-md uppercase text-[11px] tracking-wider border border-emerald-100">Seluruh Bagian</span>.
                        @else
                            Menampilkan ringkasan berkas untuk grup <span class="font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md uppercase text-[11px] tracking-wider border border-amber-100">{{ auth()->user()->grup }}</span>.
                        @endif
                    </p>
                </div>
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-emerald-100/40 rounded-full blur-3xl"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                <div class="relative bg-gradient-to-br from-[#085a3a] to-emerald-700 rounded-2xl p-6 shadow-xl shadow-emerald-900/10 overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="flex justify-between items-start mb-4">
                            <span class="text-emerald-100 text-xs font-bold tracking-wider uppercase">Total Arsip</span>
                            <div class="p-2 bg-white/20 rounded-lg text-white backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-4xl font-black text-white">{{ $totalArsip }}</h3>
                            <span class="text-emerald-100 text-sm font-medium">Berkas</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg shadow-gray-200/50 border border-gray-100 flex flex-col justify-between group hover:border-emerald-200 transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 text-xs font-bold tracking-wider uppercase">Akses Publik</span>
                        <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2 mb-1">
                            <h3 class="text-4xl font-black text-gray-800">{{ $arsipPublik }}</h3>
                            <span class="text-gray-400 text-sm font-medium">Terbuka</span>
                        </div>
                        <p class="text-[10px] font-bold text-emerald-600 bg-emerald-50 inline-block px-2 py-0.5 rounded uppercase tracking-wider">Dapat Diakses Masyarakat</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg shadow-gray-200/50 border border-gray-100 flex flex-col justify-between group hover:border-red-200 transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 text-xs font-bold tracking-wider uppercase">Internal Saja</span>
                        <div class="p-2 bg-red-50 rounded-lg text-red-500 group-hover:bg-red-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2 mb-1">
                            <h3 class="text-4xl font-black text-gray-800">{{ $arsipInternal }}</h3>
                            <span class="text-gray-400 text-sm font-medium">Rahasia</span>
                        </div>
                        <p class="text-[10px] font-bold text-red-500 bg-red-50 inline-block px-2 py-0.5 rounded uppercase tracking-wider">Terbatas Pada Aplikasi</p>
                    </div>
                </div>

                <div class="relative bg-gradient-to-br from-teal-500 to-teal-700 rounded-2xl p-6 shadow-xl shadow-teal-900/10 overflow-hidden group">
                    <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <span class="text-teal-50 text-xs font-bold tracking-wider uppercase mb-4">Penyimpanan</span>
                        <div>
                            <div class="flex items-baseline gap-1 mb-1">
                                <h3 class="text-4xl font-black text-white">{{ $totalStorageMB }}</h3>
                                <span class="text-teal-100 text-sm font-bold">MB</span>
                            </div>
                            <p class="text-[10px] font-bold text-teal-800 bg-white/90 inline-block px-2 py-0.5 rounded backdrop-blur-sm mt-1 uppercase tracking-wider">Total Pemakaian File</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mb-10">
                <div class="flex justify-between items-center mb-4 px-2">
                    <h3 class="text-lg font-extrabold text-gray-800">Statistik Kategori Dokumen</h3>
                    <button onclick="toggleGrafik()" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-100/80 text-[#085a3a] hover:bg-emerald-200 text-sm font-bold rounded-xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Tampilkan Grafik
                    </button>
                </div>
                
                <div id="wadahGrafik" style="display: none;" class="bg-white rounded-3xl p-6 shadow-xl shadow-gray-200/40 border border-gray-100 transition-all duration-300">
                    <div class="relative h-64 w-full">
                        <canvas id="grafikKategori"></canvas>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">
                            @if(auth()->user()->grup == 'pimpinan')
                                Entri Terbaru (Global)
                            @else
                                Entri Terbaru Bagian {{ auth()->user()->grup }}
                            @endif
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Menampilkan dokumen terakhir yang diunggah.</p>
                    </div>
                    <a href="{{ route('arsip.index') }}" class="group flex items-center gap-1 text-sm font-bold text-[#085a3a] hover:text-emerald-700 transition-colors bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-xl">
                        Semua Data 
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider w-2/5">Informasi Dokumen</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Ukuran</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Tgl Upload</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Privasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            
                            @forelse($arsipTerbaru as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-800 group-hover:text-[#085a3a] transition-colors">{{ $item->judul_arsip }}</span>
                                        <span class="text-[11px] font-medium text-gray-400 mt-0.5">{{ $item->nomor_dokumen }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase">
                                        {{ $item->kategori_bagian->nama_bagian ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-gray-500">
                                    {{ $item->file_size ? round($item->file_size / 1024, 2) . ' KB' : '0 KB' }}
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-gray-500">
                                    {{ $item->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-8 py-4 text-right">
                                    @if($item->status_akses == 'public')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-100 ml-auto uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Publik
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-red-50 text-red-600 text-[10px] font-bold border border-red-100 ml-auto uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                            Private
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center"> 
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 bg-gray-50 rounded-full mb-3">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-500">Belum ada dokumen yang tersedia</p>
                                        <p class="text-xs text-gray-400 mt-1">Dokumen yang baru diupload akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labelKategori = {!! json_encode($dataGrafik->pluck('kategori_dokumen')) !!};
        const dataJumlah = {!! json_encode($dataGrafik->pluck('total')) !!};
        
        let grafikKategori = null;

        function toggleGrafik() {
            const wadah = document.getElementById('wadahGrafik');
            
            if (wadah.style.display === 'none') {
                wadah.style.display = 'block';
                
                // Cek apakah grafik sudah dirender sebelumnya
                if (!grafikKategori) {
                    renderGrafik();
                }
            } else {
                wadah.style.display = 'none';
            }
        }

        function renderGrafik() {
            const ctx = document.getElementById('grafikKategori').getContext('2d');
            grafikKategori = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelKategori,
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: dataJumlah,
                        backgroundColor: [
                            '#059669', // Emerald 600
                            '#3b82f6', // Blue 500
                            '#f59e0b', // Amber 500
                            '#ef4444', // Red 500
                            '#8b5cf6', // Violet 500
                            '#14b8a6'  // Teal 500
                        ],
                        borderRadius: 6, // Biar ujung bar membulat
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Angka Y-Axis selalu bulat
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>