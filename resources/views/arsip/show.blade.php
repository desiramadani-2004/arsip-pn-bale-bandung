<x-app-layout>
    <div class="py-8 px-4 md:px-8 max-w-7xl mx-auto min-h-[calc(100vh-65px)]">
        
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('arsip.index') }}" class="text-emerald-700 hover:text-[#085a3a] flex items-center gap-2 font-bold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Arsip
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            {{-- ========================================== --}}
            {{-- KOLOM KIRI: INFO DOKUMEN --}}
            {{-- ========================================== --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-lg text-xs font-bold uppercase tracking-wider">
                        {{ $arsip->kategori_dokumen ?? 'Umum' }}
                    </span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold uppercase tracking-wider">
                        {{ $arsip->kategori_bagian->nama_bagian ?? 'Semua Bagian' }}
                    </span>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $arsip->judul_arsip }}</h2>
                
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-100 mb-6">
                    <table class="text-sm text-gray-600 w-full">
                        <tbody>
                            <tr>
                                <td class="py-2 font-bold w-40 text-gray-700">Nomor Dokumen</td>
                                <td class="py-2">: <span class="font-mono bg-white px-2 py-1 border border-gray-200 rounded text-gray-800">{{ $arsip->nomor_dokumen }}</span></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-bold text-gray-700">Tanggal Diunggah</td>
                                <td class="py-2">: {{ $arsip->created_at->format('d F Y - H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-bold text-gray-700">Status Akses</td>
                                <td class="py-2">: 
                                    @if($arsip->status_akses == 'public')
                                        <span class="text-blue-600 font-bold">Publik</span>
                                    @else
                                        <span class="text-amber-600 font-bold">Internal</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex gap-3">
                    <a href="{{ asset('storage/' . $arsip->file_path) }}" target="_blank" class="bg-[#085a3a] hover:bg-emerald-900 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Buka Dokumen Penuh
                    </a>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- KOLOM KANAN: DISKUSI / KOMENTAR --}}
            {{-- ========================================== --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col h-[600px]">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Diskusi Dokumen
                </h3>
                
                {{-- Area List Komentar --}}
                <div class="flex-grow overflow-y-auto pr-2 space-y-4 mb-4">
                    @forelse($komentars as $komen)
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-[#085a3a] text-white flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($komen->user->name ?? $komen->user->username ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800">{{ $komen->user->name ?? $komen->user->username ?? 'User' }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $komen->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $komen->isi_komentar }}</p>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-center text-gray-400 mt-10">
                            <svg class="w-12 h-12 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                            <p class="text-sm font-medium">Belum ada diskusi.</p>
                            <p class="text-xs mt-1">Jadilah yang pertama memberikan komentar!</p>
                        </div>
                    @endforelse
                </div>

                {{-- Form Kirim Komentar --}}
                <div class="mt-auto pt-4 border-t border-gray-100">
                    @if(session('success'))
                        <div class="text-xs text-emerald-600 bg-emerald-50 p-2 rounded mb-3 text-center font-bold">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('arsip.komentar.store', $arsip->id) }}" method="POST">
                        @csrf
                        <textarea name="isi_komentar" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#085a3a] focus:ring-[#085a3a] text-sm resize-none" placeholder="Tulis komentar, revisi, atau catatan di sini..." required></textarea>
                        <button type="submit" class="mt-3 w-full bg-blue-600 text-white font-bold py-2.5 px-4 rounded-xl hover:bg-blue-700 transition shadow-sm flex justify-center items-center gap-2">
                            Kirim Komentar
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>