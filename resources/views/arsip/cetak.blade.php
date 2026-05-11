<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan E-Archive - PN Bale Bandung</title>
    <style>
        body { font-family: 'Times New Roman', serif; line-height: 1.4; color: #000; margin: 0; padding: 10px; }
        
        /* Kop Surat Resmi */
        .kop-surat { text-align: center; border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 20px; position: relative; }
        .logo-ma { position: absolute; left: 0; top: 0; width: 80px; } /* Sesuaikan posisi jika ada logo */
        .kop-surat h2 { margin: 0; font-size: 16px; font-weight: normal; text-transform: uppercase; }
        .kop-surat h1 { margin: 2px 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .kop-surat p { margin: 0; font-size: 11px; font-style: italic; }
        
        .judul-laporan { text-align: center; margin-bottom: 25px; }
        .judul-laporan h3 { text-decoration: underline; text-transform: uppercase; margin-bottom: 5px; font-size: 16px; }
        .judul-laporan p { margin: 0; font-size: 12px; font-weight: bold; }
        
        /* Tabel Data */
        table { width: 100%; border-collapse: collapse; font-size: 11px; table-layout: fixed; }
        th { background-color: #f0f0f0; border: 1px solid #000; padding: 10px 5px; text-align: center; text-transform: uppercase; }
        td { border: 1px solid #000; padding: 8px 5px; vertical-align: top; word-wrap: break-word; }
        .center { text-align: center; }
        
        /* Footer TTD */
        .footer-container { margin-top: 40px; }
        .ttd-box { float: right; width: 250px; text-align: center; }
        .ttd-space { height: 70px; }
        
        /* Penomoran Halaman untuk Print */
        @page { size: A4; margin: 1cm; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .bg-emerald-50 { background-color: transparent !important; }
        }

        .btn-print {
            padding: 10px 25px;
            background: #065f46;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="kop-surat">
        <h2>PENGADILAN TINGGI BANDUNG</h2>
        <h1>PENGADILAN NEGERI BALE BANDUNG KELAS IA</h1>
        <p>Jl. Raya Soreang – Banjaran KM. 15 Soreang Kab. Bandung</p>
        <p>Telp: (022) 5891357 | Fax: (022) 5891157</p>
        <p>Website: www.pn-balebandung.go.id | Email: pnbalebandung@yahoo.co.id</p>
    </div>

    <div class="judul-laporan">
        <h3>LAPORAN DATA E-ARCHIVE</h3>
        <p>REKAPITULASI DAFTAR ARSIP DOKUMEN DIGITAL</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 140px;">Nomor Dokumen</th>
                <th>Judul Arsip / Nama Dokumen</th>
                <th style="width: 110px;">Bagian</th>
                <th style="width: 70px;">Akses</th>
                <th style="width: 80px;">Tgl Upload</th>
            </tr>
        </thead>
        <tbody>
            @forelse($arsips as $index => $arsip)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td><strong>{{ $arsip->nomor_dokumen }}</strong></td>
                <td>{{ $arsip->judul_arsip }}</td>
                <td class="center">{{ $arsip->kategori_bagian->nama_bagian ?? '-' }}</td>
                <td class="center">{{ strtoupper($arsip->status_akses) }}</td>
                <td class="center">{{ $arsip->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="center">Data arsip tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-container">
        <div style="font-size: 10px; float: left;">
            Dicetak melalui Sistem E-Archive PN Bale Bandung<br>
            Waktu Cetak: {{ date('d/m/Y H:i') }}<br>
            Oleh: {{ auth()->user()->name }}
        </div>

        <div class="ttd-box">
            <p>Soreang, {{ date('d F Y') }}</p>
            <p>Petugas Pengelola Arsip,</p>
            <div class="ttd-space"></div>
            <p><strong><u>{{ auth()->user()->name }}</u></strong></p>
            <p>NIP. ........................................</p>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="no-print" style="margin-top: 60px; text-align: center; border-top: 1px solid #ddd; padding-top: 20px;">
        <button onclick="window.print()" class="btn-print">CETAK DOKUMEN</button>
        <a href="{{ route('arsip.index') }}" style="margin-left: 15px; color: #666; font-size: 14px; text-decoration: none;">&larr; Kembali ke Daftar Arsip</a>
    </div>

</body>
</html>