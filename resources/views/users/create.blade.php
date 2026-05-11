<x-app-layout>
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah User Baru</h1>
            <p class="text-gray-500 text-sm">Tambahkan pengguna baru untuk akses sistem E-Archive.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
            <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" required placeholder="Contoh: Budi Santoso">
                    @error('name') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: budi123">
                        @error('username') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" required placeholder="budi@pnbalebandung.go.id">
                        @error('email') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">No HP (WhatsApp Aktif)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold bg-gray-100 border border-gray-300 rounded-l-lg px-3">
                            +62
                        </span>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full pl-16 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" required placeholder="81234567890">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Wajib diisi untuk menerima notifikasi revisi dokumen.</p>
                    @error('no_hp') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Grup / Bagian</label>
                    <select name="grup" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" required>
                        <option value="">-- Pilih Grup --</option>
                        <option value="Admin" {{ old('grup') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Pimpinan" {{ old('grup') == 'Pimpinan' ? 'selected' : '' }}>Pimpinan (Ketua/Wakil)</option>
                        <option value="Kepaniteraan" {{ old('grup') == 'Kepaniteraan' ? 'selected' : '' }}>Kepaniteraan (Panitera)</option>
                        <option value="Kepaniteraan Pidana" {{ old('grup') == 'Kepaniteraan Pidana' ? 'selected' : '' }}>Kepaniteraan Pidana</option>
                        <option value="Kepaniteraan Perdata" {{ old('grup') == 'Kepaniteraan Perdata' ? 'selected' : '' }}>Kepaniteraan Perdata</option>
                        <option value="Kepaniteraan Hukum" {{ old('grup') == 'Kepaniteraan Hukum' ? 'selected' : '' }}>Kepaniteraan Hukum</option>
                        <option value="Kesekretariatan" {{ old('grup') == 'Kesekretariatan' ? 'selected' : '' }}>Kesekretariatan (Sekretaris)</option>
                        <option value="Umum dan Keuangan" {{ old('grup') == 'Umum dan Keuangan' ? 'selected' : '' }}>Sub Bagian Umum dan Keuangan</option>
                        <option value="Ortala" {{ old('grup') == 'Ortala' ? 'selected' : '' }}>Sub Bagian Ortala</option>
                        <option value="PTIP" {{ old('grup') == 'PTIP' ? 'selected' : '' }}>Sub Bagian PTIP</option>
                    </select>
                    @error('grup') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" required>
                        @error('password') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" required>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-200 transition">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-700 text-white rounded-xl font-bold text-sm hover:bg-emerald-800 shadow-md transition transform hover:-translate-y-0.5">Simpan User Baru</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>