<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Pengguna Sistem</h1>
            
            <a href="{{ route('users.create') }}" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg font-bold text-sm shadow-md transition-colors inline-block">
                + Tambah User Baru
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 border-b-2 border-gray-200">
                    <tr class="text-gray-600 text-xs uppercase font-extrabold tracking-wider">
                        <th class="p-4 border-r border-gray-200 last:border-0">Nama Lengkap</th>
                        <th class="p-4 border-r border-gray-200 last:border-0">Username/Email</th>
                        <th class="p-4 border-r border-gray-200 last:border-0">Grup/Bagian</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $u)
                    <tr class="hover:bg-emerald-50 transition-colors duration-200">
                        <td class="p-4 text-sm font-bold text-gray-800 border-r border-gray-200 last:border-0">{{ $u->name }}</td>
                        <td class="p-4 text-sm text-gray-600 border-r border-gray-200 last:border-0">{{ $u->email ?? $u->username }}</td>
                        <td class="p-4 text-sm uppercase font-bold text-emerald-700 border-r border-gray-200 last:border-0">{{ $u->grup }}</td>
                        <td class="p-4 flex justify-center gap-2">
                            
                            <a href="{{ route('users.edit', $u->id) }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1 rounded-md text-xs font-bold transition-colors inline-block border border-yellow-200">
                                Edit
                            </a>
                            
                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="inline-block">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded-md text-xs font-bold transition-colors btn-delete border border-red-200" data-name="{{ $u->name }}">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tangkap semua tombol hapus
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    const userName = this.getAttribute('data-name');

                    Swal.fire({
                        title: 'Hapus User?',
                        html: `Apakah kamu yakin ingin menghapus user <strong>${userName}</strong>?<br>Data tidak dapat dikembalikan!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#047857', // Sesuai warna tema E-Archive
                        cancelButtonColor: '#ef4444', 
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true, // Tombol batal di kiri
                        customClass: {
                            popup: 'rounded-2xl shadow-xl border border-gray-100'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Lanjutkan proses hapus jika dikonfirmasi
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>