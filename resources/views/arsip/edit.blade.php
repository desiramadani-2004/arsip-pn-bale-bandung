<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight border-l-4 border-amber-500 pl-4">
            Edit Arsip: <span class="text-emerald-700">{{ $arsip->nomor_dokumen }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-xl border border-gray-100">
                <form action="{{ route('arsip.update', $arsip->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-5">
                        <label class="block font-bold text-gray-700 mb-1">Nomor Dokumen</label>
                        <input type="text" name="nomor_dokumen" value="{{ $arsip->nomor_dokumen }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>

                    <div class="mb-5">
                        <label class="block font-bold text-gray-700 mb-1">Judul Arsip</label>
                        <input type="text" name="judul_arsip" value="{{ $arsip->judul_arsip }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>

                    <div class="mb-5">
                        <label class="block font-bold text-gray-700 mb-1">Status Akses</label>
                        <select name="status_akses" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition">
                            <option value="private" {{ $arsip->status_akses == 'private' ? 'selected' : '' }}>Internal (Private)</option>
                            <option value="public" {{ $arsip->status_akses == 'public' ? 'selected' : '' }}>Terbuka (Public)</option>
                        </select>
                    </div>

                    <div class="mb-8">
                        <label class="block font-bold text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi_metadata" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition">{{ $arsip->deskripsi_metadata }}</textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('arsip.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 px-4 py-2 transition">Batal</a>
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transform transition hover:-translate-y-0.5 active:scale-95">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>