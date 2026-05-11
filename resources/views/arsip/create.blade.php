<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 flex items-center gap-3">
                        <div class="p-2 bg-emerald-100 rounded-lg text-[#085a3a] shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        Upload Arsip Baru
                    </h2>
                    <p class="mt-2 text-sm text-gray-500 ml-12">Lengkapi formulir di bawah ini untuk menyimpan dokumen ke dalam sistem e-Archive.</p>
                </div>
                <a href="{{ route('arsip.index') }}" class="text-sm font-semibold text-gray-500 hover:text-[#085a3a] transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xl shadow-emerald-900/5 border border-gray-100 overflow-hidden">
                <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data" id="form-arsip" onsubmit="cekNomorDulu(event)">
                    @csrf
                    
                    <div class="p-8 space-y-8">
                        
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Informasi Dokumen</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700">Nomor Dokumen <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                        </div>
                                        <input type="text" name="nomor_dokumen" placeholder="Contoh: 01/Pdt.G/2026/PN" required
                                            class="w-full pl-10 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#085a3a] focus:border-[#085a3a] focus:bg-white transition-all duration-200 py-3 shadow-sm">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700">Judul Arsip <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </div>
                                        <input type="text" name="judul_arsip" placeholder="Masukkan judul dokumen secara lengkap" required
                                            class="w-full pl-10 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#085a3a] focus:border-[#085a3a] focus:bg-white transition-all duration-200 py-3 shadow-sm">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700">Kategori Bagian <span class="text-red-500">*</span></label>
                                    <select name="kategori_bagian_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#085a3a] focus:border-[#085a3a] focus:bg-white transition-all duration-200 py-3 shadow-sm cursor-pointer">
                                        <option value="" disabled selected>-- Pilih Bagian --</option>
                                        @foreach($kategori as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->nama_bagian }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700">Kategori Dokumen <span class="text-red-500">*</span></label>
                                    <select name="kategori_dokumen" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#085a3a] focus:border-[#085a3a] focus:bg-white transition-all duration-200 py-3 shadow-sm cursor-pointer">
                                        <option value="" disabled selected>-- Pilih Kategori Dokumen --</option>
                                        <option value="Surat Keputusan">Surat Keputusan (SK)</option>
                                        <option value="Surat Permohonan">Surat Permohonan</option>
                                        <option value="Surat Edaran">Surat Edaran (SE)</option>
                                        <option value="Berita Acara">Berita Acara</option>
                                        <option value="AMPU">AMPU</option>
                                        <option value="Laporan">Laporan / Register</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                            <div class="md:col-span-1 flex flex-col">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Status Akses <span class="text-red-500">*</span></label>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-center gap-3 h-full">
                                    <label class="flex items-center p-2 border border-transparent rounded-lg hover:bg-white transition cursor-pointer group">
                                        <input type="radio" name="status_akses" value="private" checked class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500">
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-gray-800 group-hover:text-amber-600">Internal</span>
                                            <span class="block text-[11px] text-gray-500 leading-tight">Hanya Pegawai</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-2 border border-transparent rounded-lg hover:bg-white transition cursor-pointer group">
                                        <input type="radio" name="status_akses" value="public" class="w-4 h-4 text-[#085a3a] border-gray-300 focus:ring-[#085a3a]">
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-gray-800 group-hover:text-[#085a3a]">Publik</span>
                                            <span class="block text-[11px] text-gray-500 leading-tight">Bisa dilihat masyarakat</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="md:col-span-2 flex flex-col">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Ringkasan (Metadata) <span class="text-red-500">*</span></label>
                                <textarea name="deskripsi_metadata" required placeholder="Tambahkan keterangan tambahan untuk memudahkan pencarian..."
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#085a3a] focus:border-[#085a3a] focus:bg-white transition-all duration-200 p-4 shadow-sm resize-none h-full min-h-[120px]"></textarea>
                            </div>
                        </div>

                        <div class="space-y-2 pt-2">
                            <label class="block text-sm font-bold text-gray-700">Upload File Dokumen <span class="text-red-500">*</span></label>
                            
                            <div class="w-full relative">
                                <input type="file" name="file_arsip" id="file_arsip" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                
                                <div id="drop_zone" class="border-2 border-dashed border-gray-300 rounded-2xl p-10 text-center hover:bg-emerald-50 hover:border-emerald-500 transition-all duration-300 group bg-gray-50">
                                    <div class="flex flex-col items-center justify-center space-y-2 relative z-0" id="file_info">
                                        <div class="p-4 bg-white rounded-full shadow-sm group-hover:scale-110 transition-transform duration-300 mb-2">
                                            <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        </div>
                                        <div class="text-gray-600">
                                            <span class="font-bold text-[#085a3a] group-hover:underline">Klik di sini untuk upload</span> atau drag file
                                        </div>
                                        <p class="text-xs text-gray-500">Maksimal ukuran file: 10MB (PDF, Word, Excel, PPT)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex items-center justify-end gap-3 rounded-b-2xl">
                        <a href="{{ route('arsip.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-200 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-[#085a3a] hover:bg-emerald-800 shadow-lg shadow-emerald-900/20 transform hover:-translate-y-0.5 active:scale-95 transition-all flex items-center gap-2 z-20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan & Unggah Arsip
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('file_arsip').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const infoDiv = document.getElementById('file_info');
            const dropZone = document.getElementById('drop_zone');

            if (file) {
                // Konversi ukuran file
                let fileSize = file.size / 1024; // KB
                let sizeText = fileSize > 1024 ? (fileSize / 1024).toFixed(2) + ' MB' : fileSize.toFixed(2) + ' KB';

                // Tambahkan background hijau muda tipis ke kotak putus-putus
                dropZone.classList.add('bg-emerald-50', 'border-emerald-400');
                dropZone.classList.remove('bg-gray-50', 'border-gray-300');

                // Ubah tampilan isi kotak (UI Modern)
                infoDiv.innerHTML = `
                    <div class="p-3 bg-white rounded-full shadow-sm mb-2 border border-emerald-100">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="px-4 py-2 bg-white rounded-lg border border-emerald-200 shadow-sm inline-block">
                        <span class="text-sm font-bold text-gray-800 break-all">${file.name}</span>
                    </div>
                    <div class="inline-flex items-center gap-1 mt-1">
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[11px] font-bold rounded-md">Ukuran: ${sizeText}</span>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-2 font-medium">(Klik area ini jika ingin mengganti file)</p>
                `;
            } else {
                // Kembalikan ke tampilan awal jika dibatalkan
                dropZone.classList.remove('bg-emerald-50', 'border-emerald-400');
                dropZone.classList.add('bg-gray-50', 'border-gray-300');
                
                infoDiv.innerHTML = `
                    <div class="p-4 bg-white rounded-full shadow-sm group-hover:scale-110 transition-transform duration-300 mb-2">
                        <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <div class="text-gray-600">
                        <span class="font-bold text-[#085a3a] group-hover:underline">Klik di sini untuk upload</span> atau drag file
                    </div>
                    <p class="text-xs text-gray-500">Maksimal ukuran file: 10MB (PDF, Word, Excel, PPT)</p>
                `;
            }
        });
    </script>

    <script>
        function cekNomorDulu(event) {
            event.preventDefault(); 
            
            const inputNomor = document.querySelector('input[name="nomor_dokumen"]');
            const nomor = inputNomor ? inputNomor.value : '';

            if (!nomor) {
                document.getElementById('form-arsip').submit();
                return;
            }

            Swal.fire({
                title: 'Mengecek Nomor Dokumen...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/arsip/cek-nomor/${encodeURIComponent(nomor)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        Swal.fire({
                            title: 'Nomor Sudah Terpakai!',
                            text: "Arsip yang lama dengan nomor ini akan dihapus dan diganti yang baru. Tetap lanjutkan?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#085a3a', 
                            cancelButtonColor: '#ef4444', 
                            confirmButtonText: 'Ya, Timpa Dokumen!',
                            cancelButtonText: 'Batal',
                            customClass: {
                                confirmButton: 'shadow-md',
                                cancelButton: 'shadow-md'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('form-arsip').submit();
                            }
                        });
                    } else {
                        document.getElementById('form-arsip').submit();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('form-arsip').submit();
                });
        }
    </script>
</x-app-layout>