<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Archive | PN Bale Bandung</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .bg-emerald-gradient {
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <nav class="bg-white border-b border-gray-200 fixed w-full z-50 top-0 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="{{ asset('images/logo-pnbb.jpg') }}" alt="Logo PN Bale Bandung" class="h-12 w-auto drop-shadow-sm transform hover:scale-105 transition-transform">
                        
                        <div class="ml-3">
                            <span class="block text-xl font-black tracking-tight text-emerald-900 uppercase leading-none">E-Archive</span>
                            <span class="text-[10px] font-bold text-amber-600 tracking-widest uppercase">PN Bale Bandung</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-900 transition text-[11px] uppercase tracking-widest">Dashboard Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-2.5 bg-emerald-800 border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-emerald-900 transition shadow-lg transform hover:scale-105">
                            Login Pegawai
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto pt-28 px-4 sm:px-6 lg:px-8 mb-12">
        <div class="flex flex-col md:flex-row gap-8">
            
            <aside class="w-full md:w-72 flex-shrink-0">
                <div class="sticky top-28 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-emerald-50 px-5 py-4 border-b border-emerald-100">
                            <h3 class="font-black text-emerald-900 text-xs uppercase tracking-widest text-center">Unit Kerja / Bagian</h3>
                        </div>
                        <nav class="p-3 space-y-1">
                            <a href="{{ url('/') }}" class="flex items-center px-4 py-3 rounded-xl text-sm transition {{ !request('bagian') && !request('search') ? 'bg-emerald-700 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                                <span class="mr-3"></span> Beranda Utama
                            </a>
                            @foreach(\App\Models\KategoriBagian::all() as $kat)
                                <a href="{{ url('/?bagian=' . $kat->id) }}" class="flex justify-between items-center px-4 py-3 rounded-xl text-sm transition {{ request('bagian') == $kat->id ? 'bg-emerald-700 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                                    <span>{{ $kat->nama_bagian }}</span>
                                    <svg class="w-4 h-4 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                </a>
                            @endforeach
                        </nav>
                    </div>
                    
                    <div class="bg-emerald-gradient rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-20 transform rotate-12">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-200 mb-2 text-center">Keterbukaan Informasi</p>
                        <p class="text-xs leading-relaxed text-center font-medium opacity-90">Arsip yang ditampilkan telah melalui proses verifikasi untuk publikasi resmi.</p>
                    </div>
                </div>
            </aside>

            <main class="flex-1">
                <div class="mb-10">
                    <form action="{{ url('/') }}" method="GET" class="flex gap-3">
                        @if(request('bagian'))
                            <input type="hidden" name="bagian" value="{{ request('bagian') }}">
                        @endif
                        <div class="relative flex-1 group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition group-focus-within:text-emerald-600">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari nomor perkara, nomor dokumen, atau kata kunci judul..." 
                                class="block w-full pl-12 pr-4 py-4 border-2 border-gray-100 rounded-2xl bg-white text-gray-800 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 shadow-sm transition-all text-sm font-medium">
                        </div>
                        <button type="submit" class="px-8 py-4 bg-emerald-800 text-white rounded-2xl font-black text-sm hover:bg-emerald-900 transition-all shadow-lg hover:shadow-emerald-200 uppercase tracking-widest">
                            Cari
                        </button>
                    </form>
                </div>

                @if(!request('bagian') && !request('search'))
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-2 h-6 bg-amber-500 rounded-full mr-3"></div>
                        <h2 class="text-lg font-extrabold text-emerald-950 uppercase tracking-tight">Statistik Data Publik</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <div class="bg-emerald-gradient rounded-2xl p-6 text-white shadow-xl shadow-emerald-100 flex flex-col justify-center">
                            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mb-1">Total Arsip</p>
                            <p class="text-4xl font-black tracking-tighter">{{ $totalPublik }} <span class="text-sm font-normal opacity-70">Dokumen</span></p>
                        </div>
                        
                        @foreach($kategoriStats as $stat)
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:border-emerald-300 transition-all group">
                            <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-2 group-hover:text-emerald-600">{{ $stat->nama_bagian }}</p>
                            <div class="flex items-end gap-2">
                                <p class="text-3xl font-black text-emerald-900">{{ $stat->total }}</p>
                                <p class="text-xs font-bold text-gray-400 mb-1.5 italic">File</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="bg-white shadow-xl shadow-gray-200/50 border border-gray-100 rounded-3xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-white">
                        <h2 class="text-sm font-black text-emerald-900 uppercase tracking-widest">
                            @if(request('search'))
                                🔍 Hasil Pencarian: "{{ request('search') }}"
                            @elseif(request('bagian'))
                                Folder: {{ \App\Models\KategoriBagian::find(request('bagian'))->nama_bagian }}
                            @else
                                Arsip Terbaru
                            @endif
                        </h2>
                        
                        @if(request('search') || request('bagian'))
                            <a href="{{ url('/') }}" class="text-[10px] bg-red-50 text-red-600 font-black py-2 px-4 rounded-full hover:bg-red-100 transition uppercase tracking-tighter flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Reset Filter
                            </a>
                        @endif
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50/50 text-left text-[11px] font-black text-emerald-800 uppercase tracking-[0.15em]">
                                    <th class="px-8 py-5">Informasi Dokumen</th>
                                    <th class="px-8 py-5">Unit Kerja</th>
                                    <th class="px-8 py-5">Tanggal</th>
                                    <th class="px-8 py-5 text-center">Akses</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($arsipPublik as $arsip)
                                <tr class="hover:bg-emerald-50/40 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="text-sm font-extrabold text-emerald-950 group-hover:text-emerald-700 transition">{{ $arsip->nomor_dokumen }}</div>
                                        <div class="text-xs text-gray-500 mt-1 line-clamp-1 font-medium italic">{{ $arsip->judul_arsip }}</div>
                                        @if(isset($arsip->similarity_score))
                                            <div class="mt-2 inline-block px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-widest rounded-md border border-amber-200">
                                                🎯 Relevansi: {{ $arsip->similarity_score }}%
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-md text-[10px] font-black bg-gray-100 text-gray-600 uppercase border border-gray-200">
                                            {{ $arsip->kategori_bagian->nama_bagian }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-xs font-bold text-gray-600 uppercase tracking-tighter">
                                            {{ $arsip->created_at->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <button type="button" onclick="openModal('{{ asset('storage/' . $arsip->file_path) }}')" 
                                           class="inline-flex items-center justify-center px-5 py-2.5 bg-white border-2 border-emerald-700 text-emerald-700 font-black text-[10px] uppercase rounded-xl hover:bg-emerald-700 hover:text-white transition-all shadow-sm active:scale-95">
                                            <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10z"/></svg>
                                            Buka Dokumen
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center">
                                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">Tidak ada data ditemukan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-8">
                    {{ $arsipPublik->links() }}
                </div>
            </main>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-emerald-900 font-black text-sm uppercase tracking-[0.2em] mb-1">
                Pengadilan Negeri Bale Bandung Kelas IA
            </p>
            <p class="text-gray-400 text-[11px] font-medium uppercase tracking-widest mb-4">
                Sistem Manajemen Arsip Digital v2.0
            </p>
            <div class="flex justify-center items-center gap-2">
                <div class="h-[1px] w-8 bg-gray-200"></div>
                <p class="text-gray-400 text-[9px] uppercase tracking-[0.3em]">
                    Supported by <span class="text-emerald-600 font-bold">Digitech University</span>
                </p>
                <div class="h-[1px] w-8 bg-gray-200"></div>
            </div>
        </div>
    </footer>

    <div id="pdfModal" class="fixed inset-0 z-[999] hidden bg-black/60 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300">
    
        <div class="bg-white w-full max-w-5xl h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden relative">
            
            <div class="flex justify-between items-center bg-emerald-800 text-white px-6 py-4">
                <h3 class="font-bold text-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                    Pratinjau Dokumen Arsip
                </h3>
                <button onclick="closeModal()" class="text-white hover:text-red-400 font-bold text-3xl transition">&times;</button>
            </div>

            <div class="flex-grow bg-gray-100">
                <iframe id="pdfFrame" src="" class="w-full h-full border-none"></iframe>
            </div>
        </div>
    </div>

    <script>
        function openModal(pdfUrl) {
            const modal = document.getElementById('pdfModal');
            const frame = document.getElementById('pdfFrame');
            
            frame.src = pdfUrl;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
        }

        function closeModal() {
            const modal = document.getElementById('pdfModal');
            const frame = document.getElementById('pdfFrame');
            
            modal.classList.add('hidden');
            frame.src = ''; 
            document.body.style.overflow = 'auto'; 
        }

        document.getElementById('pdfModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>