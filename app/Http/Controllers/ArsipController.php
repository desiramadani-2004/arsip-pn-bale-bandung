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

        $search = strtolower($request->search);
        $kategori_id = $request->kategori_id;
        $kategori_dokumen = $request->kategori_dokumen;

        $query = Arsip::with('kategori_bagian');
        $kategoriSidebar = collect();
        $listKategoriDokumen = $this->getListKategoriDokumen();

        // ================= FILTER HAK AKSES =================
        $hakAksesLihat = HakAkses::where('grup_pengakses', $grupUser)
            ->where('bisa_lihat', 1)
            ->pluck('grup_pemilik')
            ->toArray();
        $hakAksesLihat[] = $grupUser;

        $hakAksesKomentar = HakAkses::where('grup_pengakses', $grupUser)
            ->where('bisa_komentar', 1)
            ->pluck('grup_pemilik')
            ->toArray();

        if (in_array($role, ['pimpinan', 'ketua', 'wakil'])) {
            $kategoriSidebar = KategoriBagian::all();
        } else {
            $kategoriSidebar = KategoriBagian::whereIn('nama_bagian', $hakAksesLihat)->get();
            $query->whereIn('kategori_bagian_id', $kategoriSidebar->pluck('id'));
        }

        if ($kategori_id) {
            $query->where('kategori_bagian_id', $kategori_id);
        }

        if ($kategori_dokumen) {
            $query->where('kategori_dokumen', $kategori_dokumen);
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

        if (in_array($role, ['pimpinan', 'ketua', 'wakil'])) {
            $kategori = KategoriBagian::all();
        } else {
            // Kita coba cari yang namanya sama persis dulu
            $kategori = KategoriBagian::where('nama_bagian', $grupUser)->get();
            // Kalau nggak ketemu (karena typo di database), baru munculkan semua biar user bisa pilih manual
            if ($kategori->isEmpty()) {
                $kategori = KategoriBagian::all();
            }
        }

        $listKategoriDokumen = $this->getListKategoriDokumen();
        return view('arsip.create', compact('kategori', 'listKategoriDokumen'));
    }

    /**
     * Simpan Data
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

        $pemilikDokumen = $arsip->kategori_bagian->nama_bagian;
        if (!in_array($role, ['pimpinan', 'ketua', 'wakil']) && $pemilikDokumen !== $grupUser) {
            abort(403, 'Anda hanya bisa mengubah dokumen milik bagian Anda sendiri.');
        }

        if (in_array($role, ['pimpinan', 'ketua', 'wakil'])) {
            $kategori = KategoriBagian::all();
        } else {
            $kategori = KategoriBagian::where('nama_bagian', $grupUser)->get();
            if ($kategori->isEmpty()) {
                $kategori = KategoriBagian::all();
            }
        }

        $listKategoriDokumen = $this->getListKategoriDokumen();
        return view('arsip.edit', compact('arsip', 'kategori', 'listKategoriDokumen'));
    }

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

    public function destroy(Arsip $arsip)
    {
        if ($arsip->file_path && Storage::disk('public')->exists($arsip->file_path)) {
            Storage::disk('public')->delete($arsip->file_path);
        }
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil dihapus!');
    }

    /**
     * Tampilkan Detail Arsip & Komentar (PERBAIKAN ERROR MERAH)
     */
    public function show($id)
    {
        // Cari data arsip
        $arsip = Arsip::with('kategori_bagian')->findOrFail($id);

        // Ambil data komentar (Kita pakai \App\Models\Komentar biar pasti ketemu)
        $komentars = \App\Models\Komentar::with('user')
            ->where('arsip_id', $id)
            ->latest()
            ->get();

        // Pastikan variabel 'komentars' masuk ke compact
        return view('arsip.show', compact('arsip', 'komentars'));
    }

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

    public function cetak(Request $request)
    {
        $user = auth()->user();
        $grupUser = $user->grup;
        $role = strtolower($grupUser);

        $query = Arsip::with('kategori_bagian');
        $hakAksesLihat = HakAkses::where('grup_pengakses', $grupUser)->where('bisa_lihat', 1)->pluck('grup_pemilik')->toArray();
        $hakAksesLihat[] = $grupUser;

        if (!in_array($role, ['pimpinan', 'ketua', 'wakil'])) {
            $query->whereHas('kategori_bagian', function ($q) use ($hakAksesLihat) {
                $q->whereIn('nama_bagian', $hakAksesLihat);
            });
        }

        if ($request->kategori_id) {
            $query->where('kategori_bagian_id', $request->kategori_id);
        }
        $arsips = $query->latest()->get();

        return view('arsip.cetak', compact('arsips'));
    }

    public function cekNomor($nomor)
    {
        $exists = Arsip::where('nomor_dokumen', $nomor)->exists();
        return response()->json(['exists' => $exists]);
    }
}