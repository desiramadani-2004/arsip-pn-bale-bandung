<?php

use App\Models\Arsip;
use App\Models\KategoriBagian;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator; // Wajib ditambahkan untuk custom pagination
use App\Http\Controllers\HakAksesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Depan (Publik) - Pencarian & Filter Sidebar
Route::get('/', function (Request $request) {
    $search = $request->search;
    $bagian = $request->bagian;

    // 1. Hitung statistik per bagian (hanya yang berstatus public)
    $kategoriStats = KategoriBagian::all()->map(function($kat) {
        $kat->total = Arsip::where('kategori_bagian_id', $kat->id)
                            ->where('status_akses', 'public')
                            ->count();
        return $kat;
    });

    // 2. Hitung total keseluruhan arsip publik
    $totalPublik = $kategoriStats->sum('total');

    // 3. Mulai Query Dasar
    $query = Arsip::with('kategori_bagian')->where('status_akses', 'public');

    // Filter Sidebar Kategori (Tetap jalan pakai Eloquent biasa)
    if ($bagian) {
        $query->where('kategori_bagian_id', $bagian);
    }

    // ==========================================================
    // 4. IMPLEMENTASI ALGORITMA TF-IDF & COSINE SIMILARITY
    // ==========================================================
    if ($search) {
        $semuaArsip = $query->get(); // Ambil data untuk dihitung matematis
        
        // a. Preprocessing Kata Kunci (Query)
        $queryText = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $search));
        $queryWords = array_filter(explode(' ', $queryText));
        
        if(empty($queryWords)) {
            // Kalau spasi doang, kembalikan ke standar
            $arsipPublik = $query->latest()->paginate(6)->withQueryString();
        } else {
            $documentVectors = [];
            $df = []; // Document Frequency

            // b. Preprocessing Dokumen & Hitung Term Frequency (TF)
            foreach ($semuaArsip as $arsip) {
                // Menggabungkan Nomor, Judul, dan Deskripsi untuk dianalisis
                $text = strtolower($arsip->nomor_dokumen . ' ' . $arsip->judul_arsip . ' ' . $arsip->deskripsi_metadata);
                $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
                $words = array_filter(explode(' ', $text));

                $termCounts = array_count_values($words); 
                $documentVectors[$arsip->id] = $termCounts;

                foreach (array_unique($words) as $word) {
                    if (!isset($df[$word])) $df[$word] = 0;
                    $df[$word]++;
                }
            }

            // c. Hitung Inverse Document Frequency (IDF)
            $N = count($semuaArsip);
            $idf = [];
            foreach ($df as $word => $count) {
                $idf[$word] = log10($N / $count);
            }

            // d. Buat Vektor Query
            $queryTermCounts = array_count_values($queryWords);
            $queryVector = [];
            foreach ($queryTermCounts as $word => $count) {
                $queryVector[$word] = $count * ($idf[$word] ?? 0); 
            }

            // e. Hitung Cosine Similarity
            $scoredArsips = collect();
            foreach ($semuaArsip as $arsip) {
                $dotProduct = 0;
                $docMagnitudeSq = 0;
                $queryMagnitudeSq = 0;

                // Hitung Dot Product
                foreach ($queryVector as $word => $wQuery) {
                    $tfDoc = $documentVectors[$arsip->id][$word] ?? 0;
                    $wDoc = $tfDoc * ($idf[$word] ?? 0); 
                    $dotProduct += ($wDoc * $wQuery);
                }
                
                // Hitung Magnitude Query
                foreach ($queryVector as $wQuery) {
                    $queryMagnitudeSq += pow($wQuery, 2);
                }

                // Hitung Magnitude Dokumen
                foreach ($documentVectors[$arsip->id] as $word => $tf) {
                    $wDoc = $tf * ($idf[$word] ?? 0);
                    $docMagnitudeSq += pow($wDoc, 2);
                }

                $docMagnitude = sqrt($docMagnitudeSq);
                $queryMagnitude = sqrt($queryMagnitudeSq);

                // Eksekusi Rumus Cosine Similarity
                $similarity = ($docMagnitude > 0 && $queryMagnitude > 0) ? ($dotProduct / ($docMagnitude * $queryMagnitude)) : 0;
                
                // Konversi ke persentase
                $arsip->similarity_score = round($similarity * 100, 2); 

                // Hanya tampilkan yang relevan (skor lebih dari 0)
                if ($arsip->similarity_score > 0) {
                    $scoredArsips->push($arsip);
                }
            }

            // Urutkan arsip dari persentase kemiripan tertinggi
            $sorted = $scoredArsips->sortByDesc('similarity_score')->values();
            
            // f. Buat Custom Pagination (Karena array PHP tidak bisa pakai ->paginate() bawaan)
            $page = $request->input('page', 1);
            $perPage = 6; 
            $arsipPublik = new LengthAwarePaginator(
                $sorted->forPage($page, $perPage),
                $sorted->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }
    } else {
        // JIKA TIDAK ADA PENCARIAN (NORMAL)
        $arsipPublik = $query->latest()->paginate(6)->withQueryString();
    }

    return view('welcome', compact('arsipPublik', 'kategoriStats', 'totalPublik'));
})->name('welcome');

// Grup Route yang memerlukan Login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/arsip/cetak', [ArsipController::class, 'cetak'])->name('arsip.cetak');
    Route::get('/arsip/cek-nomor/{nomor}', [App\Http\Controllers\ArsipController::class, 'cekNomor']);
    Route::resource('arsip', ArsipController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/arsip/{id}/komentar', [ArsipController::class, 'storeKomentar'])->name('arsip.komentar.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', UserController::class);
    Route::get('/hak-akses', [HakAksesController::class, 'index'])->name('hak-akses.index');
    Route::post('/hak-akses', [HakAksesController::class, 'store'])->name('hak-akses.store');   
});

require __DIR__.'/auth.php';