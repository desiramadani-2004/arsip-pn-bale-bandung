<x-app-layout>
    <div class="flex flex-col md:flex-row w-full min-h-[calc(100vh-65px)] items-stretch bg-white">
        
        @php
            // Deteksi langsung apakah ada data anak bagian dari Controller
            $showFilterBagian = isset($kategoriSidebar) && $kategoriSidebar->count() > 0;
            $hasSidebarData = $showFilterBagian || (isset($listKategoriDokumen) && count($listKategoriDokumen) > 0);
        @endphp

        @if($hasSidebarData)
            <div class="w-full md:w-64 flex-shrink-0 bg-[#085a3a] text-white flex flex-col shadow-lg z-10">
                <div class="px-6 py-6">
                    <h3 class="font-bold text-emerald-400 text-xs uppercase tracking-wider mb-4">
                        {{ $showFilterBagian ? 'FILTER BAGIAN' : 'KATEGORI DOKUMEN' }}
                    </h3>
                    
                    <ul class="flex flex-col gap-2">
                        <li>
                            <a href="{{ route('arsip.index') }}"
                               class="flex items-center px-4 py-2.5 rounded-lg text-sm transition-all {{ !request('kategori_id') && !request('kategori_dokumen') ? 'bg-[#107c54] text-white font-bold shadow-sm' : 'text-emerald-100 hover:bg-[#0a6d46]' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                                Semua Dokumen
                            </a>
                        </li>
                    
                        {{-- ========================================== --}}
                        {{-- Tampilkan Accordion Bagian (Untuk Pimpinan/Sekretaris/Panitera) --}}
                        {{-- ========================================== --}}
                        @if($showFilterBagian)
                            @foreach($kategoriSidebar as $kategori)
                                <li>
                                    <details class="group list-none [&::-webkit-details-marker]:hidden" {{ request('kategori_id') == $kategori->id ? 'open' : '' }}>
                                        <summary class="flex items-center justify-between px-4 py-2.5 text-sm cursor-pointer rounded-lg transition-all {{ request('kategori_id') == $kategori->id && !request('kategori_dokumen') ? 'bg-[#107c54] text-white font-bold shadow-sm' : 'text-emerald-100 hover:bg-[#0a6d46]' }}">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                                </svg>
                                                {{ $kategori->nama_bagian }}
                                            </div>
                                            <span class="transition-transform duration-300 group-open:rotate-180">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </span>
                                        </summary>
                                        
                                        <div class="flex flex-col pl-9 mt-1 space-y-1 relative mb-2">
                                            <div class="absolute left-6 top-2 bottom-2 w-px bg-emerald-700"></div>

                                            <a href="{{ route('arsip.index', ['kategori_id' => $kategori->id]) }}"
                                               class="px-2 py-1.5 text-xs rounded-lg transition-colors {{ request('kategori_id') == $kategori->id && !request('kategori_dokumen') ? 'text-white font-bold' : 'text-emerald-200 hover:text-white' }}">
                                                Tampilkan Semua
                                            </a>
                                            
                                            @foreach($listKategoriDokumen ?? [] as $jenis)
                                                <a href="{{ route('arsip.index', ['kategori_id' => $kategori->id, 'kategori_dokumen' => $jenis]) }}"
                                                   class="px-2 py-1.5 text-xs rounded-lg transition-colors flex items-center {{ request('kategori_id') == $kategori->id && request('kategori_dokumen') == $jenis ? 'text-white font-bold bg-[#107c54]' : 'text-emerald-200 hover:text-white' }}">
                                                    <span class="w-1 h-1 rounded-full {{ request('kategori_id') == $kategori->id && request('kategori_dokumen') == $jenis ? 'bg-white' : 'bg-emerald-500' }} mr-2"></span>
                                                    {{ $jenis }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </details>
                                </li>
                            @endforeach

                        {{-- ========================================== --}}
                        {{-- Langsung List Kategori Dokumen (Untuk Staf biasa) --}}
                        {{-- ========================================== --}}
                        @else
                            @foreach($listKategoriDokumen ?? [] as $jenis)
                                <li>
                                    <a href="{{ route('arsip.index', ['kategori_dokumen' => $jenis]) }}"
                                       class="flex items-center px-4 py-2.5 text-sm rounded-lg transition-all {{ request('kategori_dokumen') == $jenis ? 'bg-[#107c54] text-white font-bold shadow-sm' : 'text-emerald-100 hover:bg-[#0a6d46]' }}">
                                        <svg class="w-4 h-4 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        {{ $jenis }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        @endif

        <div class="flex-grow p-6 md:p-10 overflow-y-auto">
            
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center animate-fade-in">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Daftar Dokumen Pengadilan</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Hak akses: <span class="text-emerald-700 font-bold uppercase">{{ $role }}</span>
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('arsip.cetak', request()->all()) }}" target="_blank" class="bg-white hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-4 text-sm rounded-lg border border-gray-300 transition shadow-sm flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 012-2H5a2 2 0 012 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Laporan
                    </a>
                    <a href="{{ route('arsip.create') }}" class="bg-[#085a3a] hover:bg-emerald-900 text-white font-bold py-2.5 px-4 text-sm rounded-lg shadow-md transition transform active:scale-95 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Arsip
                    </a>
                </div>
            </div>

            <form action="{{ route('arsip.index') }}" method="GET" class="mb-8 bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm">
                @if(request('kategori_id'))
                    <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
                @endif

                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Pencarian Cepat</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor, judul, atau deskripsi dokumen..." class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:ring-[#085a3a] focus:border-[#085a3a] h-[42px]">
                        </div>
                    </div>
                    
                    <div class="w-full md:w-64">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jenis Surat</label>
                        <select name="kategori_dokumen" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#085a3a] focus:border-[#085a3a] h-[42px]">
                            <option value="">Semua Jenis</option>
                            @foreach($listKategoriDokumen ?? [] as $jenis)
                                <option value="{{ $jenis }}" {{ request('kategori_dokumen') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end gap-2 md:w-auto">
                        <button type="submit" class="bg-[#085a3a] hover:bg-emerald-900 text-white px-6 py-2 rounded-lg text-sm font-bold transition h-[42px] shadow-sm">
                            Cari
                        </button>
                        <a href="{{ route('arsip.index', request('kategori_id') ? ['kategori_id' => request('kategori_id')] : []) }}" class="bg-white border border-gray-300 text-gray-600 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100 transition flex items-center justify-center h-[42px]">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
            
            <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
                <table class="min-w-full bg-white text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-500">
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Info Dokumen</th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Jenis & Bagian</th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Tgl Upload</th>
                            <th class="px-6 py-4 text-center font-bold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($arsips as $arsip)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800 text-base mb-1">{{ $arsip->nomor_dokumen }}</div>
                                    <div class="text-gray-500 truncate w-48 lg:w-72" title="{{ $arsip->judul_arsip }}">{{ $arsip->judul_arsip }}</div>
                                    
                                    {{-- BADGE RELEVANSI TF-IDF --}}
                                    @if(isset($arsip->relevansi))
                                        <div class="mt-2">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-800 border border-orange-200 shadow-sm" title="Skor Relevansi TF-IDF">
                                                <svg class="w-3 h-3 mr-1 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                                Relevansi: {{ $arsip->relevansi }}%
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="mb-2">
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-[11px] font-bold border border-emerald-100 uppercase">
                                            {{ $arsip->kategori_dokumen ?? 'Belum Dikategorikan' }}
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[11px] font-semibold border border-gray-200">
                                            {{ $arsip->kategori_bagian->nama_bagian ?? '-' }}
                                        </span>
                                    </div>
                                    @if($arsip->status_akses == 'public')
                                        <span class="inline-flex items-center text-[10px] font-bold text-blue-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span> PUBLIK
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-[10px] font-bold text-amber-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> INTERNAL
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $arsip->created_at->format('d/m/Y - H:i') }} WIB
                                </td>
                                
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    {{-- DIV UNTUK MENYEJAJARKAN SEMUA TOMBOL --}}
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openModal('{{ asset('storage/' . $arsip->file_path) }}')" type="button" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-[#085a3a] hover:text-white text-xs font-bold rounded-lg transition border border-emerald-200">
                                            BUKA
                                        </button>

                                        {{-- =============================================== --}}
                                        {{-- TAMBAHAN TOMBOL KOMENTAR --}}
                                        {{-- =============================================== --}}
                                        <a href="{{ route('arsip.show', $arsip->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white text-xs font-bold rounded-lg transition border border-blue-200">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            KOMENTAR
                                        </a>

                                        @php
                                            $userView = auth()->user();
                                            $roleView = strtolower($userView->grup ?? '');
                                            $namaAkunView = strtolower($userView->name ?? $userView->username ?? '');
                                            $isStafView = str_contains($namaAkunView, 'staf');
                                            $canEdit = false;

                                            if (in_array($roleView, ['pimpinan', 'ketua', 'wakil']) || $arsip->user_id == $userView->id) {
                                                $canEdit = true;
                                            } elseif (in_array($roleView, ['panitera', 'kepaniteraan']) && !$isStafView && optional($arsip->kategori_bagian)->kelompok == 'kepaniteraan') {
                                                $canEdit = true;
                                            } elseif (in_array($roleView, ['sekretaris', 'kesekretariatan']) && !$isStafView && optional($arsip->kategori_bagian)->kelompok == 'kesekretariatan') {
                                                $canEdit = true;
                                            }
                                        @endphp

                                        @if($canEdit)
                                            <a href="{{ route('arsip.edit', $arsip->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-50 text-amber-700 hover:bg-amber-500 hover:text-white text-xs font-bold rounded-lg transition border border-amber-200">
                                                EDIT
                                            </a>
                                            
                                            <form action="{{ route('arsip.destroy', $arsip->id) }}" method="POST" class="m-0 p-0 flex">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus dokumen ini?')" class="inline-flex items-center justify-center px-4 py-2 bg-red-50 text-red-700 hover:bg-red-600 hover:text-white text-xs font-bold rounded-lg transition border border-red-200">
                                                    HAPUS
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="text-xl font-bold text-gray-500">Data tidak ditemukan</p>
                                        <p class="text-sm mt-1">Coba kata kunci lain atau periksa filter bagian di sebelah kiri.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $arsips->links() }}
            </div>

        </div>
    </div>
    
    {{-- MODAL PREVIEW PDF --}}
    <div id="pdfModal" class="fixed inset-0 z-[999] hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white w-full max-w-5xl h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden relative">
            
            <div class="flex justify-between items-center bg-[#085a3a] text-white px-6 py-4">
                <h3 class="font-bold text-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                    Pratinjau Dokumen Arsip
                </h3>
                <button onclick="closeModal()" class="text-white hover:text-red-400 font-bold text-3xl transition">&times;</button>
            </div>

            <div class="flex-grow bg-gray-100 relative">
                <iframe id="pdfFrame" src="" class="w-full h-full border-none"></iframe>

                <div id="officeView" class="hidden absolute inset-0 flex flex-col items-center justify-center text-center p-10 bg-gray-50">
                    <div class="w-20 h-20 bg-emerald-100 text-[#085a3a] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Pratinjau Tidak Tersedia</h4>
                    <p class="text-gray-500 mb-6">Format dokumen ini tidak mendukung pratinjau langsung.</p>
                    <a id="downloadBtn" href="" download class="bg-[#085a3a] hover:bg-emerald-800 text-white px-8 py-3 rounded-xl font-bold transition flex items-center gap-2 shadow-lg">
                        Unduh Dokumen
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(fileUrl) {
            const modal = document.getElementById('pdfModal');
            const frame = document.getElementById('pdfFrame');
            const officeView = document.getElementById('officeView');
            const downloadBtn = document.getElementById('downloadBtn');
            
            const extension = fileUrl.split('.').pop().toLowerCase();

            if (extension === 'pdf') {
                frame.classList.remove('hidden');
                officeView.classList.add('hidden');
                frame.src = fileUrl;
            } else {
                frame.classList.add('hidden');
                officeView.classList.remove('hidden');
                downloadBtn.href = fileUrl;
            }

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
</x-app-layout>