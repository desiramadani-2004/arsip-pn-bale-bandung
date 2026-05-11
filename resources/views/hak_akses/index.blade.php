<x-app-layout>
    <div class="p-6">
        <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pengaturan Hak Akses Dokumen</h1>
                <p class="text-gray-500 text-sm">Atur kewenangan melihat dan komentar dokumen antar bagian.</p>
            </div>
            <button type="submit" form="formHakAkses" class="px-5 py-2.5 bg-emerald-700 text-white rounded-xl font-bold text-sm hover:bg-emerald-800 shadow-md transition transform hover:-translate-y-0.5">
                Simpan Pengaturan
            </button>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form id="formHakAkses" action="{{ route('hak-akses.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($grupList as $pemilik)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                            <h3 class="font-bold text-gray-800 text-sm">Dokumen: <span class="text-emerald-700">{{ $pemilik }}</span></h3>
                        </div>
                        
                        <div class="p-3">
                            <div class="space-y-1">
                                @foreach($grupList as $pengakses)
                                    @if($pemilik !== $pengakses)
                                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg border border-transparent hover:border-gray-100 transition">
                                            <span class="text-xs font-bold text-gray-600 w-1/2">{{ $pengakses }}</span>
                                            
                                            <div class="flex gap-3 w-1/2 justify-end">
                                                <label class="inline-flex items-center cursor-pointer" title="Izinkan Melihat">
                                                    <input type="checkbox" name="akses[{{ $pemilik }}][{{ $pengakses }}][lihat]" value="1" 
                                                        {{ isset($hakAkses[$pemilik][$pengakses]['lihat']) && $hakAkses[$pemilik][$pengakses]['lihat'] ? 'checked' : '' }}
                                                        class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 cursor-pointer">
                                                    <span class="ml-1.5 text-[11px] text-gray-500 font-bold uppercase tracking-wider">Lihat</span>
                                                </label>

                                                <label class="inline-flex items-center cursor-pointer" title="Izinkan Komentar">
                                                    <input type="checkbox" name="akses[{{ $pemilik }}][{{ $pengakses }}][komentar]" value="1"
                                                        {{ isset($hakAkses[$pemilik][$pengakses]['komentar']) && $hakAkses[$pemilik][$pengakses]['komentar'] ? 'checked' : '' }}
                                                        class="rounded border-gray-300 text-amber-500 shadow-sm focus:ring-amber-500 cursor-pointer">
                                                    <span class="ml-1.5 text-[11px] text-gray-500 font-bold uppercase tracking-wider">Komen</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
</x-app-layout>