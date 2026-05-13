<?php

namespace App\Http\Controllers;

use App\Models\KategoriBagian;
use App\Models\Arsip;
use App\Models\HakAkses;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ArsipController extends Controller
{
    /**
     * Daftar Kategori Dokumen Berdasarkan Form
     */
    private function getListKategoriDokumen()
    {
        return [
            'Surat Keputusan (SK)',
            'Surat Permohonan',
            'Surat Edaran (SE)',
            'Berita Acara',
            'AMPU',
            'Laporan / Register',
            'Lainnya'
        ];
    }

    /**
     * Tampilkan Daftar Arsip
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $grupUser = $user->grup;
        $role = strtolower($grupUser);

        if ($role == 'admin') {
            return redirect()->route('dashboard')->with('error', 'Admin tidak memiliki akses ke Manajemen Arsip.');
        }

        $search = $request->filled('search') ? strtolower($request->search) : null;
        $kategori_id = $request->kategori_id;
        $kategori_dokumen = $request->kategori_dokumen;

        $query = Arsip::with('kategori_bagian');
        $listKategoriDokumen = $this->getListKategoriDokumen();

        // ================= LOGIKA HAK AKSES PINTAR =================
        // Ambil daftar grup yang diberi izin akses dari tabel HakAkses
        $hakAksesLihat = HakAkses::whereRaw('LOWER(grup_pengakses) = ?', [strtolower($grupUser)])
            ->where('bisa_lihat', 1)
            ->pluck('grup_pemilik')
            ->toArray();
        
        // Masukkan grup sendiri ke dalam daftar akses
        $hakAksesLihat[] = $grupUser;

        $hakAksesKomentar = HakAkses::whereRaw('LOWER(grup_pengakses) = ?', [strtolower($grupUser)])
            ->where('bisa_komentar', 1)
            ->pluck('grup_pemilik')
            ->toArray();

        // Filter kategori yang muncul di Sidebar
        $semuaKategori = KategoriBagian::all();
        
        if (in_array($role, ['pimpinan', 'ketua', 'wakil'])) {
            $kategoriSidebar = $semuaKategori;
        } else {
            $kategoriSidebar = $semuaKategori->filter(function ($kategori) use ($hakAksesLihat) {
                $namaDB = strtolower(trim($kategori->nama_bagian));
                foreach ($hakAksesLihat as $hak) {
                    $hakAkses = strtolower(trim($hak));
                    if (str_contains($namaDB, $hakAkses) || str_contains($hakAkses, $namaDB)) {
                        return true;
                    }
                }
                return false;
            });

            // Terapkan filter ke query utama
            if ($kategoriSidebar->isNotEmpty()) {
                $query->whereIn('kategori_bagian_id', $kategoriSidebar->pluck('id'));
            } else {
                $query->whereRaw('1 = 0'); // Paksa kosong jika tidak ada akses
            }
        }

        // Filter berdasarkan Bagian
        if ($kategori_id) {
            $query->where('kategori_bagian_id', $kategori_id);
        }

        // Filter berdasarkan Jenis Dokumen
        if ($kategori_dokumen) {
            $query->where('kategori_dokumen', 'LIKE', '%' . trim($kategori_dokumen) . '%');
        }

        // ================= PENCARIAN TF-IDF =================
        if ($search) {
            $searchTerms = array_filter(explode(' ', $search));
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->orWhere('nomor_dokumen', 'like', "%{$term}%")
                      ->orWhere('judul_arsip', 'like', "%{$term}%")
                      ->orWhere('kategori_dokumen', 'like', "%{$term}%")
                      ->orWhere('deskripsi_metadata', 'like', "%{$term}%");
                }
            });

            $arsipsRaw = $query->get();

            if ($arsipsRaw->isNotEmpty()) {
                $totalDocs = $arsipsRaw->count();
                $idf = [];

                foreach ($searchTerms as $term) {
                    $docCountWithTerm = 0;
                    foreach ($arsipsRaw as $doc) {
                        $text = strtolower($doc->nomor_dokumen . ' ' . $doc->judul_arsip . ' ' . $doc->kategori_dokumen . ' ' . $doc->deskripsi_metadata);
                        if (str_contains($text, $term)) {
                            $docCountWithTerm++;
                        }
                    }
                    $idf[$term] = $docCountWithTerm > 0 ? log10($totalDocs / $docCountWithTerm) : 0;
                }

                $maxScore = 0.0001;
                foreach ($arsipsRaw as $doc) {
                    $text = strtolower($doc->nomor_dokumen . ' ' . $doc->judul_arsip . ' ' . $doc->kategori_dokumen . ' ' . $doc->deskripsi_metadata);
                    $totalWords = str_word_count($text) ?: 1;

                    $docScore = 0;
                    foreach ($searchTerms as $term) {
                        $termCount = substr_count($text, $term);
                        $tf = $termCount / $totalWords;
                        $docScore += ($tf * $idf[$term]);
                    }
                    $doc->relevance_score = $docScore;
                    if ($docScore > $maxScore) {
                        $maxScore = $docScore;
                    }
                }

                foreach ($arsipsRaw as $doc) {
                    $doc->relevansi = round(($doc->relevance_score / $maxScore) * 100, 2);
                }

                $arsipsSorted = $arsipsRaw->sortByDesc('relevance_score')->values();
                $perPage = 10;
                $page = Paginator::resolveCurrentPage() ?: 1;
                
                $arsips = new LengthAwarePaginator(
                    $arsipsSorted->forPage($page, $perPage),
                    $arsipsSorted->count(),
                    $perPage,
                    $page,
                    ['path' => Paginator::resolveCurrentPath()]
                );
                $arsips->appends($request->all());
            } else {
                $arsips = $query->paginate(10);
            }
        } else {
            $arsips = $query->latest()->paginate(10);
        }

        return view('arsip.index', compact('arsips', 'kategoriSidebar', 'role', 'listKategoriDokumen', 'grupUser', 'hakAksesKomentar'));
    }

    /**
     * Tampilkan Form Upload
     */
    public function create()
    {
        $user = auth()->user();
        $grupUser = $user->grup;
        $role = strtolower($grupUser);

        if ($role == 'admin') {
            return redirect()->route('dashboard')->with('error', 'Admin tidak memiliki akses ke Manajemen Arsip.');
        }

        $semuaKategori = KategoriBagian::all();
        
        if (in_array($role, ['pimpinan', 'ketua', 'wakil'])) {
            $kategori = $semuaKategori;
        } else {
            // Filter otomatis upload berdasarkan kemiripan grup
            $kategori = $semuaKategori->filter(function ($k) use ($grupUser) {
                $namaDB = strtolower(trim($k->nama_bagian));
                $grup = strtolower(trim($grupUser));
                return (str_contains($namaDB, $grup) || str_contains($grup, $namaDB));
            });

            if ($kategori->isEmpty()) {
                $kategori = $semuaKategori;
            }
        }

        $listKategoriDokumen = $this->getListKategoriDokumen();
        
        return view('arsip.create', compact('kategori', 'listKategoriDokumen'));
    }

    /**
     * Simpan Data Arsip
     */
    public function store(Request $request)
    {
        if (strtolower(auth()->user()->grup) == 'admin') {
            abort(403, 'Admin tidak diizinkan menambah arsip.');
        }

        $request->validate([
            'nomor_dokumen' => 'required',
            'judul_arsip' => 'required',
            'kategori_bagian_id' => 'required',
            'kategori_dokumen' => 'required',
            'status_akses' => 'required',
            'file_arsip' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $arsipLama = Arsip::where('nomor_dokumen', $request->nomor_dokumen)->first();
        $path = null;
        $fileSize = null;

        if ($request->hasFile('file_arsip')) {
            $file = $request->file('file_arsip');
            $fileSize = $file->getSize();

            if ($arsipLama && $arsipLama->file_path) {
                Storage::disk('public')->delete($arsipLama->file_path);
            }
            $path = $file->storeAs('dokumen_arsip', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        Arsip::updateOrCreate(
            ['nomor_dokumen' => $request->nomor_dokumen],
            [
                'judul_arsip' => $request->judul_arsip,
                'kategori_bagian_id' => $request->kategori_bagian_id,
                'kategori_dokumen' => $request->kategori_dokumen,
                'deskripsi_metadata' => $request->deskripsi_metadata,
                'file_path' => $path ?? ($arsipLama->file_path ?? null),
                'file_size' => $fileSize ?? ($arsipLama->file_size ?? null),
                'user_id' => auth()->id(),
                'status_akses' => $request->status_akses,
            ]
        );

        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil disimpan!');
    }

    /**
     * Tampilkan Form Edit
     */
    public function edit(Arsip $arsip)
    {
        $user = auth()->user();
        $grupUser = $user->grup;
        $role = strtolower($grupUser);

        if ($role == 'admin') {
            return redirect()->route('dashboard')->with('error', 'Admin tidak memiliki akses.');
        }

        // Cek kepemilikan dokumen (Fuzzy Match)
        $namaBagianDokumen = strtolower(trim($arsip->kategori_bagian->nama_bagian));
        $namaGrupUser = strtolower(trim($grupUser));
        
        $punyaAkses = (str_contains($namaBagianDokumen, $namaGrupUser) || str_contains($namaGrupUser, $namaBagianDokumen));

        if (!in_array($role, ['pimpinan', 'ketua', 'wakil']) && !$punyaAkses) {
            abort(403, 'Anda hanya bisa mengubah dokumen milik bagian Anda sendiri.');
        }

        $semuaKategori = KategoriBagian::all();
        
        if (in_array($role, ['pimpinan', 'ketua', 'wakil'])) {
            $kategori = $semuaKategori;
        } else {
            $kategori = $semuaKategori->filter(function ($k) use ($grupUser) {
                $nDB = strtolower(trim($k->nama_bagian));
                $gUser = strtolower(trim($grupUser));
                return (str_contains($nDB, $gUser) || str_contains($gUser, $nDB));
            });
            
            if ($kategori->isEmpty()) { 
                $kategori = $semuaKategori; 
            }
        }

        $listKategoriDokumen = $this->getListKategoriDokumen();
        
        return view('arsip.edit', compact('arsip', 'kategori', 'listKategoriDokumen'));
    }

    /**
     * Update Data Arsip
     */
    public function update(Request $request, Arsip $arsip)
    {
        if (strtolower(auth()->user()->grup) == 'admin') {
            abort(403, 'Admin tidak diizinkan mengubah arsip.');
        }

        $request->validate([
            'nomor_dokumen' => 'required',
            'judul_arsip' => 'required',
            'status_akses' => 'required',
        ]);

        $data = [
            'nomor_dokumen' => $request->nomor_dokumen,
            'judul_arsip' => $request->judul_arsip,
            'deskripsi_metadata' => $request->deskripsi_metadata,
            'status_akses' => $request->status_akses,
        ];

        if ($request->has('kategori_bagian_id')) {
            $data['kategori_bagian_id'] = $request->kategori_bagian_id;
        }
        if ($request->has('kategori_dokumen')) {
            $data['kategori_dokumen'] = $request->kategori_dokumen;
        }

        if ($request->hasFile('file_arsip')) {
            if ($arsip->file_path && Storage::disk('public')->exists($arsip->file_path)) {
                Storage::disk('public')->delete($arsip->file_path);
            }
            $file = $request->file('file_arsip');
            $data['file_size'] = $file->getSize();
            $data['file_path'] = $file->storeAs('dokumen_arsip', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        $arsip->update($data);
        
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil diperbarui!');
    }

    /**
     * Hapus Data Arsip
     */
    public function destroy(Arsip $arsip)
    {
        if ($arsip->file_path && Storage::disk('public')->exists($arsip->file_path)) {
            Storage::disk('public')->delete($arsip->file_path);
        }
        $arsip->delete();
        
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil dihapus!');
    }

    /**
     * Tampilkan Detail Arsip & Komentar
     */
    public function show($id)
    {
        $arsip = Arsip::with('kategori_bagian')->findOrFail($id);
        $komentars = Komentar::with('user')
            ->where('arsip_id', $id)
            ->latest()
            ->get();

        return view('arsip.show', compact('arsip', 'komentars'));
    }

    /**
     * Simpan Komentar
     */
    public function storeKomentar(Request $request, $id)
    {
        $request->validate(['isi_komentar' => 'required|string']);

        Komentar::create([
            'arsip_id' => $id,
            'user_id' => auth()->id(),
            'isi_komentar' => $request->isi_komentar,
        ]);

        return redirect()->back()->with('success', 'Komentar dikirim!');
    }

    /**
     * Cetak Daftar Arsip
     */
    public function cetak(Request $request)
    {
        $user = auth()->user();
        $grupUser = $user->grup;
        $role = strtolower($grupUser);

        $query = Arsip::with('kategori_bagian');
        
        // Logika Hak Akses Pintar untuk Cetak
        $hakAksesLihat = HakAkses::whereRaw('LOWER(grup_pengakses) = ?', [strtolower($grupUser)])
            ->where('bisa_lihat', 1)
            ->pluck('grup_pemilik')
            ->toArray();
            
        $hakAksesLihat[] = $grupUser;

        if (!in_array($role, ['pimpinan', 'ketua', 'wakil'])) {
            $semuaKategori = KategoriBagian::all();
            $kategoriDiizinkan = $semuaKategori->filter(function ($k) use ($hakAksesLihat) {
                $nDB = strtolower(trim($k->nama_bagian));
                foreach ($hakAksesLihat as $h) {
                    $hA = strtolower(trim($h));
                    if (str_contains($nDB, $hA) || str_contains($hA, $nDB)) return true;
                }
                return false;
            })->pluck('id');

            $query->whereIn('kategori_bagian_id', $kategoriDiizinkan);
        }

        if ($request->kategori_id) {
            $query->where('kategori_bagian_id', $request->kategori_id);
        }
        
        $arsips = $query->latest()->get();

        return view('arsip.cetak', compact('arsips'));
    }

    /**
     * Cek Duplikasi Nomor Dokumen via AJAX
     */
    public function cekNomor($nomor)
    {
        $exists = Arsip::where('nomor_dokumen', $nomor)->exists();
        return response()->json(['exists' => $exists]);
    }
}