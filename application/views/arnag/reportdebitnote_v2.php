<?php
/* ===========================================================================
   Debit Note - PDF desain baru.
   Dipakai untuk DN yang tanggalnya mulai Arnag::DN_PDF_DESAIN_BARU_SEJAK; DN
   sebelum tanggal itu tetap memakai template lama supaya dokumen yang sudah
   beredar tidak berubah tampilannya.
   Dirender mPDF, jadi tidak ada flex/grid - tata letaknya pakai tabel. Semua
   lingkaran (nilai CARING & tanda centang approve) memakai SVG karena
   border-radius pada elemen inline tidak didukung mPDF.
   Dari controller: $data_debit_note, $data_debit_note_det,
   $data_debit_note_det2, $alamat_bank.
   =========================================================================== */
ini_set('pcre.backtrack_limit', '3000000');

$esc = function ($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
};
$dn = $data_debit_note;
$alamat_bank = isset($alamat_bank) ? $alamat_bank : $dn['bank_address'];
$gbr = FCPATH . 'assets/build/img/';

// Kolom tambahan (Header 1-5) hanya muncul kalau namanya diisi waktu input.
// Header 4-5 baru terbaca setelah migrations/20260911_debitnote_header4_header5.sql
// dijalankan; sebelum itu isset()-nya gagal dan kolomnya cuma tidak muncul.
$kolom_header = array();
for ($h = 1; $h <= 5; $h++) {
    $nama = isset($dn['header' . $h]) ? trim((string) $dn['header' . $h]) : '';
    if ($nama !== '') {
        $kolom_header[$h] = $nama;
    }
}

// Satu baris detail bisa punya beberapa nilai per kolom tambahan, jadi
// nilainya dikumpulkan dulu supaya di tabel tinggal ditumpuk ke bawah.
// Angka yang pemisah ribuannya SPASI ("4 656") dipatahkan mPDF di spasi itu,
// dan "4" di satu baris lalu "656" di baris berikutnya terbaca sebagai dua
// angka. white-space: nowrap tidak menolong - mPDF tidak mematuhinya di sel
// tabel. Yang menolong: spasinya diganti spasi-tanpa-putus, jadi memang tidak
// ada tempat untuk patah.
//
// Hanya nilai yang berupa angka: kalimat di kolom tambahan tetap boleh turun
// baris, kalau tidak isinya malah meluber keluar kolom.
$tanpa_putus = function ($nilai) {
    if (!preg_match('/^[0-9.,\s]+$/', $nilai)) {
        return $nilai;
    }
    return preg_replace('/\s+/', '&nbsp;', $nilai);
};

// Kebalikannya: KATA YANG KEPANJANGAN justru diberi izin patah.
//
// mPDF punya dua ukuran yang tidak sejalan. Waktu MENCETAK ia mau mematahkan
// baris di tanda hubung (Mpdf.php:8096, "Break at Hard HYPHEN"). Tapi waktu
// MENGHITUNG LEBAR MINIMUM TABEL ia cuma memecah di spasi dan U+200B:
//     Mpdf.php:19190  $words = preg_split('/(\xe2\x80\x8b| )/', $line);
// Jadi bagi penghitung itu "XM8490-AL5485-...-AP0861" adalah SATU kata
// sepanjang 118 huruf. Lebar minimum tabelnya langsung melebihi kertas, dan
// jawaban mPDF atas itu MENGECILKAN HURUF SELURUH TABEL
// (shrink_tables_to_fit) - padahal kalau dicetak apa adanya sebenarnya muat.
// Itulah DN/NAG/1126/1026: seluruh tabelnya tercetak 4,36pt, 53% dari 8,25pt.
//
// U+200B (zero-width space) mendamaikan keduanya: penghitung lebar mengakui
// kata itu bisa dipatah, perender memakainya sebagai tempat patah
// (Mpdf.php:8091), dan hurufnya sendiri tidak memakan tempat dan tidak
// tercetak. Ini IZIN untuk patah, bukan perintah - selama kolomnya cukup
// lebar, katanya tetap utuh satu baris.
//
// AMBANGNYA 24 huruf, dan itu dari data: dari 16.347 isi kolom tambahan di
// basis data, 99,8% kata terpanjangnya <= 24. Angka 24 persis tempat nomor
// referensi tunggal berhenti ("PVH-EXP-NIR-DAMCO-23-003") lalu daftar yang
// disambung dimulai ("255K0065-67-70-71-72-76-77-78-79"). Jadi nomor yang
// memang satu kesatuan tidak tersentuh sama sekali.
//
// Dipakai pada nilai MENTAH, sebelum $esc - supaya tidak ada entitas HTML
// yang bisa terbelah di tengah.
$ambang_kata = 24;
$zwsp = "\xe2\x80\x8b";
$beri_titik_putus = function ($teks) use ($ambang_kata, $zwsp) {
    return preg_replace_callback('/\S+/u', function ($m) use ($ambang_kata, $zwsp) {
        $kata = $m[0];
        if (mb_strlen($kata, 'UTF-8') <= $ambang_kata) {
            return $kata;
        }
        // Titik putusnya SESUDAH pemisah, supaya tanda pemisah ikut tertinggal
        // di baris atas dan pembaca tahu tulisannya masih bersambung.
        $pecah = preg_replace('~([/\-_])~', '$1' . $zwsp, $kata);
        if ($pecah !== $kata) {
            return $pecah;
        }
        // Tidak ada pemisah sama sekali. Dipatah per sekian huruf sebagai
        // jalan terakhir: satu kata terbelah masih jauh lebih baik daripada
        // seluruh tabel mengecil.
        return implode($zwsp, preg_split('/(.{' . $ambang_kata . '})/u', $kata, -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY));
    }, $teks);
};

$isi_header = array();
foreach ($data_debit_note_det as $baris_det) {
    foreach ($kolom_header as $h => $nama_kolom) {
        $nilai = isset($baris_det['header' . $h]) ? trim((string) $baris_det['header' . $h]) : '';
        if ($nilai === '') {
            continue;
        }
        // Di-escape dulu, baru spasinya diganti - supaya &nbsp; tidak ikut
        // ter-escape jadi tulisan "&amp;nbsp;". Titik putusnya dipasang paling
        // awal, selagi tulisannya masih mentah.
        $isi_header[$baris_det['id_det']][$h][] = $tanpa_putus($esc($beri_titik_putus($nilai)));
    }
}

// Tanda "APPROVED" hanya dicetak kalau DN-nya sudah lolos second approval.
$sudah_second_approve = strtoupper(trim((string) (isset($dn['status']) ? $dn['status'] : ''))) === 'SECOND APPROVED';
// Kolom Supplier & Supplier Invoice bawaan tidak dipakai lagi - isinya sudah
// ditulis lewat kolom tambahan (Header 1-5), jadi setelah Description
// langsung kolom tambahan.
$jml_kolom = 4 + count($kolom_header);

// Lebar kolom TIDAK dipatok - mPDF yang membaginya dari isi tabel.
//
// Dulu di sini ada pembagian persen buatan sendiri. Ternyata justru itu salah
// satu sebab tabel tercetak kecil, bukan obatnya. Biangnya
// keep_table_proportions (bawaan mPDF, true): lebar persen pada sebuah kolom
// diperlakukan sebagai JANJI - kolom itu harus TEPAT sekian persen dari
// tabel. Begitu isi satu kolom butuh lebih dari jatah persennya, mPDF tidak
// melebarkan kolom itu saja, melainkan menyimpulkan seluruh TABELnya yang
// harus lebih lebar:
//     Mpdf.php:19861  $maxcalcmiw = max($maxcalcmiw, ($wc[$i]['miw'] * $sumpc / $wc[$i]['wpercent']));
//     Mpdf.php:19879  if (... $maxcalcmiw > $checkminwidth) && $this->keep_table_proportions)
// dan karena tabel selebar itu tidak muat di kertas, jawabannya MENGECILKAN
// HURUF SELURUH TABEL. Satu kolom yang jatahnya kurang sedikit sudah cukup
// untuk mengecilkan semuanya.
//
// Diukur pada isi DN/NAG/1126/1026 (uji_dn_tabel_kecil mengunci angkanya):
//     persen dipatok, tanpa titik putus :  52% ukuran huruf
//     persen dipatok, dengan titik putus:  94%
//     persen dibuang, tanpa titik putus :  55%
//     persen dibuang, dengan titik putus: 100%   <- yang dipakai sekarang
// Jadi dua-duanya perlu, dan sendiri-sendiri tidak cukup.
//
// Tanpa persen, mPDF memberi tiap kolom setidaknya selebar KATA TERPANJANGnya
// lalu membagi sisanya menurut panjang isi - persis yang dulu ditiru dengan
// tangan di sini, bedanya diukur dengan lebar huruf yang sebenarnya, bukan
// dikira-kira dari jumlah huruf. Yang masih jadi tugas kita tinggal satu:
// memastikan tidak ada kata yang panjangnya di luar akal. Itu urusan
// $beri_titik_putus di atas.

// Keterangan cukup diisi di baris pertama satu kelompok: baris di bawahnya yang
// keterangannya dikosongkan ikut keterangan di atasnya. Selnya disambung dengan
// menghapus garis antar-baris di kolom Description - bukan rowspan, karena
// rowspan di mPDF tidak bisa terpotong saat tabel pindah halaman.
// Contoh 10 baris, keterangan di baris 1 dan 6: baris 1-5 satu sel, 6-10 satu sel.
$baris_rincian = array_values($data_debit_note_det2);
$lanjutan = array();   // true = keterangan baris ini ikut baris di atasnya
$ada_induk = false;
foreach ($baris_rincian as $i => $baris) {
    $kosong = trim((string) $baris['deskripsi']) === '';
    $lanjutan[$i] = $kosong && $ada_induk;
    if (!$kosong) {
        $ada_induk = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Debit Note <?= $esc($dn['no_dn']); ?></title>
    <style>
        /* Kaki halaman didaftarkan lewat @page; kalau hanya mengandalkan tag
           sethtmlpagefooter, kakinya cuma ikut di halaman pertama. */
        @page {
            margin: 7mm 8mm 30mm 8mm;
            odd-footer-name: html_kaki;
            even-footer-name: html_kaki;
        }

        body { font-family: sans-serif; font-size: 11px; color: #222222; }

        /* ---- Kop surat ---- */
        .kepala td { vertical-align: top; padding: 0; }
        /* text-align ditaruh di sel-nya: mPDF tidak selalu menuruti text-align
           pada div yang ada di dalam sel tabel. */
        .kepala .tengah { text-align: center; }
        .nama-pt { font-size: 27px; font-weight: bold; }
        .alamat-pt { font-size: 14px; line-height: 1.5; margin-top: 4px; }

        /* ---- Judul ---- */
        .judul { text-align: center; font-size: 30px; font-weight: bold; color: #e2231a; margin-top: 18px; }
        .nomor { text-align: center; font-size: 16px; font-weight: bold; margin-top: 2px; }

        /* ---- Keterangan DN ---- */
        .info { width: 100%; font-size: 12px; margin-top: 20px; }
        .info td { padding: 2px 0; vertical-align: top; }
        .info .label { width: 104px; }
        .info .titik { width: 11px; }

        /* ---- Tabel rincian ---- */
        .rincian { width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 18px; }
        .rincian th { background: #f5f6f7; border: 1px solid #dcdcdc; padding: 7px 6px; font-weight: bold; text-align: center; }
        .rincian td { border: 1px solid #dcdcdc; padding: 7px 6px; vertical-align: top; }
        .rincian .angka { text-align: right; }
        /* Kolom tambahan TIDAK boleh white-space: nowrap.
           mPDF menerjemahkan nowrap jadi "lebar minimum sel = lebar penuh
           isinya" (Mpdf.php: if ($c['nowrap']) { $miw = $c['maw']; }). Satu
           saja isinya panjang - mis. Item atau Reference yang beberapa kata -
           lebar minimum tabelnya langsung melebihi lebar kertas, dan mPDF
           menjawabnya dengan MENGECILKAN HURUF SELURUH TABEL
           (shrink_tables_to_fit). Itu sebabnya sebagian DN tabelnya tercetak
           kecil sendiri sementara DN lain normal.
           Nomor tetap aman tanpa nowrap: mPDF cuma memutus baris di SPASI,
           jadi "26100876/TWN-FCL/IMP" tidak mungkin terbelah, dan angka yang
           pemisah ribuannya spasi sudah diganti spasi-tanpa-putus di atas. */
        /* Sel Description yang disambung dengan baris di atas/bawahnya. */
        .rincian td.sambung-atas { border-top: none; }
        .rincian td.sambung-bawah { border-bottom: none; }
        .rincian .total-label { text-align: center; font-weight: bold; }
        .rincian .total-nilai { text-align: right; font-weight: bold; background: #fdeef0; }

        /* ---- Pembayaran & tanda approve ---- */
        .bayar { width: 100%; margin-top: 30px; }
        .bayar td { vertical-align: top; }
        .judul-bayar { font-size: 13.5px; font-weight: bold; padding-left: 9px; border-left: 3px solid #e2231a; }
        .rek { width: 100%; font-size: 11.5px; margin-top: 9px; }
        .rek td { padding: 2px 0; vertical-align: top; }
        .rek .lbl { width: 118px; font-weight: bold; }
        .rek .titik { width: 11px; }
        .catatan-bayar { font-size: 12px; margin-top: 2px; }
        .sekat { border-left: 1px solid #e6e6e6; padding-left: 16px; }

        /* ---- Kaki halaman ---- */
        .kaki { width: 100%; font-size: 8.5px; border-top: 1px solid #f0cbcf; }
        .kaki .kiri { color: #8a8a8a; letter-spacing: 1.6px; padding-top: 4px; }
        .kaki .hal { color: #8a8a8a; text-align: center; font-size: 9px; padding-top: 4px; }
        /* Dancing Script didaftarkan di Arnag::_dn_mpdf_baru(). */
        .kaki .kanan { text-align: right; color: #e2231a; font-family: dancingscript; font-size: 22px; }
    </style>
</head>

<body>

    <htmlpagefooter name="kaki">
        <!-- Tingginya dipatok supaya kaki halaman tidak makan banyak ruang;
             SVG-nya memang preserveAspectRatio="none" jadi aman dilebarkan. -->
        <img src="<?= $gbr; ?>dn_footer_wave.svg" style="width: 194mm; height: 16mm;">
        <table class="kaki">
            <tr>
                <td class="kiri" width="40%">PT NIRWANA ALABARE GARMENT</td>
                <!-- Nomor halaman seperti template lama ({PAGENO}/{nbpg} diganti mPDF). -->
                <td class="hal" width="20%">{PAGENO} / {nbpg}</td>
                <td class="kanan" width="40%">Caring &#8212;</td>
            </tr>
        </table>
    </htmlpagefooter>

    <table class="kepala" width="100%">
        <tr>
            <!-- Lebar kolom ditulis dalam mm, bukan persen: kolom nama dipas-kan
                 dengan panjang tulisannya supaya yang rata tengah itu tidak
                 mengambang jauh dari logo. Lebarnya juga diatur supaya titik
                 tengah kolom nama jatuh di tengah halaman: 32 + 130/2 = 97mm
                 (32 + 130 + 32 = 194mm = lebar isi). -->
            <td width="32mm"><img src="<?= FCPATH; ?>nag_logo3.jpg" width="112"></td>
            <td width="130mm" class="tengah">
                <div class="nama-pt">PT. NIRWANA ALABARE GARMENT</div>
                <div class="alamat-pt">
                    Jl. Raya Rancaekek &#8211; Majalaya No. 289 Desa Solokan Jeruk<br>
                    Kecamatan Solokan Jeruk, Kabupaten Bandung 40382<br>
                    Telp. 022-85962081
                </div>
            </td>
            <td width="32mm" align="right"><img src="<?= $gbr; ?>dn_caring.svg" width="105"></td>
        </tr>
    </table>

    <div class="judul">DEBIT NOTE</div>
    <div class="nomor"><?= $esc($dn['no_dn']); ?></div>

    <table class="info">
        <tr>
            <td class="label">Date</td>
            <td class="titik">:</td>
            <td><?= $esc($dn['tgl_dn']); ?></td>
        </tr>
        <tr>
            <td class="label">Consignee</td>
            <td class="titik">:</td>
            <td><?= $esc($dn['customer']); ?></td>
        </tr>
        <tr>
            <td class="label">Address</td>
            <td class="titik">:</td>
            <td><?= nl2br($esc($dn['alamat'])); ?></td>
        </tr>
        <tr>
            <td class="label">Attn</td>
            <td class="titik">:</td>
            <td><?= $esc($dn['attn']); ?></td>
        </tr>
    </table>

    <table class="rincian">
        <thead>
            <tr>
                <th>Description</th>
                <?php foreach ($kolom_header as $h => $nama_kolom) : ?>
                    <th class="kolom-header"><?= $esc($nama_kolom); ?></th>
                <?php endforeach; ?>
                <th>Value <?= $esc($dn['from_curr']); ?></th>
                <th>Rate</th>
                <th>Value <?= $esc($dn['to_curr']); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($baris_rincian as $i => $baris) :
                $kelas_ket = trim(($lanjutan[$i] ? 'sambung-atas' : '') . ' ' . (!empty($lanjutan[$i + 1]) ? 'sambung-bawah' : ''));
            ?>
                <tr>
                    <td<?= $kelas_ket !== '' ? ' class="' . $kelas_ket . '"' : ''; ?>><?= $lanjutan[$i] ? '' : $esc($beri_titik_putus($baris['deskripsi'])); ?></td>
                    <?php foreach ($kolom_header as $h => $nama_kolom) : ?>
                        <td class="kolom-header"><?= isset($isi_header[$baris['id_det']][$h]) ? implode('<br>', $isi_header[$baris['id_det']][$h]) : ''; ?></td>
                    <?php endforeach; ?>
                    <td class="angka"><?= $esc($baris['amount']); ?></td>
                    <td class="angka"><?= $esc($baris['rate']); ?></td>
                    <td class="angka"><?= $esc($baris['amount2']); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="total-label" colspan="<?= $jml_kolom - 1; ?>">Grand Total</td>
                <td class="total-nilai"><?= $esc($dn['eqv_curr']); ?></td>
            </tr>
        </tbody>
    </table>

    <table class="bayar">
        <tr>
            <td width="54%">
                <!-- Spasinya harus &nbsp;: spasi biasa di awal baris dibuang HTML,
                     dan padding-left diabaikan mPDF untuk blok di dalam sel tabel -
                     jadi garis merahnya nempel ke huruf. -->
                <div class="judul-bayar">&nbsp;&nbsp;Please T/T The Payment To:</div>
                <table class="rek">
                    <tr>
                        <td class="lbl">Account Name</td>
                        <td class="titik">:</td>
                        <td><?= $esc($dn['beneficiary_name']); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Banker</td>
                        <td class="titik">:</td>
                        <td><?= $esc($dn['bank_name']); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Bank Address</td>
                        <td class="titik">:</td>
                        <td><?= nl2br($esc($alamat_bank)); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Account Number</td>
                        <td class="titik">:</td>
                        <td><?= $esc($dn['bank_account']); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Swift Code</td>
                        <td class="titik">:</td>
                        <td><?= $esc($dn['swift_code']); ?></td>
                    </tr>
                </table>
                <br>
                <div class="catatan-bayar">Please pay at full net Amount</div>
            </td>
            <td width="46%" class="sekat">
                <?php if ($sudah_second_approve) : ?>
                    <!-- Seluruh panel (kotak, ikon, teks) dibikin satu SVG. mPDF tidak
                         mengecat latar/garis blok yang berada di dalam sel tabel dengan
                         benar - hasilnya belang per baris teks. -->
                    <img src="<?= $gbr; ?>dn_approved.svg" width="285">
                <?php endif; ?>
            </td>
        </tr>
    </table>

</body>

</html>
