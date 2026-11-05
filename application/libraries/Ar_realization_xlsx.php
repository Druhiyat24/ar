<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!class_exists('Xlsx_ringkas')) {
    require_once APPPATH . 'libraries/Xlsx_ringkas.php';
}

/**
 * Menyusun unduhan AR Collection Realization & Variance Report - empat lembar
 * dalam satu berkas, susunannya mengikuti lembar kerja tim AR:
 *
 *   1. Executive Summary  indikator kinerja + rekap per buyer
 *   2. AR Collection Realization & Variance  satu baris per invoice
 *   3. Projection   isi dokumen proyeksinya apa adanya
 *   4. Realization  satu baris per baris alokasi yang menunjuk ke dokumen
 *
 * Yang disusun di sini CUMA tata letaknya. Semua angkanya sudah dihitung di
 * Model_report::realization_report(), supaya layar dan unduhannya tidak
 * mungkin berbeda angka.
 */
class Ar_realization_xlsx
{
    /**
     * Kolom lembar Projection - susunannya SAMA PERSIS dengan modal Detail di
     * History Projection, jadi tim AR tidak perlu membaca dua susunan berbeda
     * untuk dokumen yang sama.
     *
     * Dua belas kolom keterangan di depan, lalu kelompok Receivable Amount,
     * lalu satu kolom per tanggal dalam periodenya.
     */
    private static $KOLOM_PROYEKSI = array(
        'No', 'Customer', 'Invoice No', 'Invoice Date', 'Destination', 'Order Type',
        'Due Date', 'Expected Collection Date', 'Payment Term', 'Currency',
        'Invoice Amount', 'Rate',
    );

    /** Kelompok "Receivable Amount" - lima kolom sesudah Rate. */
    private static $KOLOM_RECV = array(
        'Tax Base', 'VAT', 'Total Invoice', 'Income Tax Art 23', 'Collection Amount',
    );

    /**
     * Dua kolom penutup lembar Projection (diminta tim AR 5 Nov 2026).
     *
     * Di UJUNG, sesudah kolom tanggal - bukan diselipkan di antara dua belas
     * kolom keterangan di depan. Alasannya satu: susunan lembar ini sengaja
     * sama persis dengan modal Detail di layar History Projection, dan di
     * layar itu keduanya juga di ujung.
     */
    private static $KOLOM_EKOR = array('Type', 'Bank & Acc No');

    private static $KOLOM_REALISASI = array(
        'No Alokasi', 'Alokasi Date', 'Customer', 'Document Number', 'Bank', 'Account',
        'Curr', 'No Reference', 'Reference Date', 'Total', 'Rate', 'Equivalent IDR',
        'Amount Alokasi', 'Equivalent IDR', 'Income Tax Art 23', 'Comission',
        'Bank Adm', 'Others', 'Collection Amount', 'Description',
        'Create Date', 'Create By', 'Status',
    );

    public function berkas($hasil)
    {
        $x = new Xlsx_ringkas();
        $x->lembar('Executive Summary', $this->lembar_ringkas($hasil),
            array(36, 22, 46, 20, 16), 0, array('A1:C1'));
        // Type & Bank & Acc No disisipkan sesudah Currency - menemani empat
        // kolom keterangan lain di depan, bukan di ujung seperti di lembar
        // Projection. Di lembar ini tidak ada kolom tanggal, jadi "ujung"
        // berarti di belakang kolom selisih; keterangan dokumen tidak ada
        // urusannya di sana. Kolom kelompoknya ikut bergeser dua: Projection
        // H5:K5, Realization L5:O5, Result P5:W5.
        $x->lembar('AR Collection Realization & Variance Report',
            $this->lembar_utama($hasil),
            array(38, 20, 13, 13, 8, 12, 26, 14, 15, 11, 18, 14, 15, 11, 18, 20, 12, 11, 11, 32, 19, 16, 19),
            6, array('A5:A6', 'B5:B6', 'C5:C6', 'D5:D6', 'E5:E6', 'F5:F6', 'G5:G6',
                     'H5:K5', 'L5:O5', 'P5:W5'));
        // Lebar kolomnya diisi - dengan lebar bawaan, nama customer dan nomor
        // dokumen terpotong dan harus dilebarkan satu-satu tiap kali dibuka.
        // Dirakit, bukan ditulis tetap: jumlah kolom tanggalnya ikut periode,
        // dan dua kolom penutupnya duduk SESUDAH tanggal-tanggal itu.
        $x->lembar('Projection', $this->lembar_proyeksi($hasil),
            array_merge(
                array(5, 38, 20, 13, 12, 12, 13, 15, 8, 9, 16, 11, 16, 14, 16, 15, 17),
                array_fill(0, count($this->tanggal_periode($hasil['header'])), 14),
                array(12, 26)
            ),
            self::PROY_JUDUL + 2, $this->gabung_proyeksi($hasil));
        $x->lembar('Realization', $this->lembar_realisasi($hasil),
            array(20, 13, 38, 28, 24, 18, 7, 22, 13, 16, 11, 16, 16, 16, 15, 12, 12, 12, 17, 36, 13, 12, 9), 4);
        return $x;
    }

    public function nama_berkas($hasil)
    {
        $doc = isset($hasil['header']['doc_number']) ? $hasil['header']['doc_number'] : 'realization';
        return 'AR Collection Realization ' . str_replace('/', '-', $doc) . '.xlsx';
    }

    /* ---------------- penolong sel ---------------- */

    /**
     * Bawaannya BERGARIS - sel isi tabel memang mayoritas isi berkas ini.
     * Yang di luar tabel (judul, keterangan dokumen) menyebut gayanya sendiri.
     */
    private function t($v, $gaya = 'garis')  { return array('v' => $v, 't' => 's', 's' => $gaya); }
    private function n($v, $gaya = 'garis_angka') { return array('v' => (float) $v, 't' => 'n', 's' => $gaya); }
    private function h($v, $gaya = 'kepala') { return array('v' => $v, 't' => 's', 's' => $gaya); }

    /** Tanggal kosong atau 0000-00-00 ditulis strip, bukan 1899. */
    private function d($v, $gaya = 'garis_tanggal')
    {
        if (empty($v) || $v === '0000-00-00') { return $this->t('-', 'garis_tengah'); }
        return array('v' => substr($v, 0, 10), 't' => 'd', 's' => $gaya);
    }

    /** Angka yang memang belum ada ditulis strip - bukan nol yang menyesatkan. */
    private function n_atau_strip($v, $gaya = 'garis_angka')
    {
        return ($v === null) ? $this->t('-', 'garis_tengah') : $this->n($v, $gaya);
    }

    /** Sel kosong tanpa garis - pengisi di luar tabel. */
    private function kosong() { return array('v' => '', 't' => 's', 's' => ''); }

    /* ---------------- 1. Executive Summary ---------------- */

    private function lembar_ringkas($hasil)
    {
        $h = $hasil['header'];
        $r = $hasil['ringkas'];

        $b = array();
        // Judulnya satu sel, bukan dua yang digabung: kalau dua, teks sel
        // kedua hilang begitu rentangnya digabung.
        $b[] = array($this->t('AR COLLECTION PERFORMANCE DASHBOARD', 'judul'));
        $b[] = array();
        $b[] = array($this->t('Doc Number', 'tebal'), $this->t($h['doc_number'], ''));
        $b[] = array($this->t('Reporting Period', 'tebal'), $this->d($h['periode_sampai'], 'tanggal'));
        $b[] = array($this->t('Period Covered', 'tebal'), $this->d($h['periode_dari'], 'tanggal'),
                     $this->d($h['periode_sampai'], 'tanggal'));
        $b[] = array();
        $b[] = array($this->h('Performance Indicator'), $this->h('Amount (IDR)'), $this->h('Interpretation'));

        $baris = array(
            array('Projected Collection',           $this->n($r['projected']),        'Projected IDR at projected rate'),
            array('Actual Collection',              $this->n($r['actual']),           'Actual IDR at actual rate'),
            array('Collection Achievement (IDR)',   $this->n_atau_strip($r['achievement'], 'garis_persen'),
                                                    'Includes FX impact; OCY % available per invoice'),
            array('Collection Variance (Excl. FX)', $this->n($r['variance_excl_fx']),  'OCY difference translated at projected rate'),
            array('FX Variance (Cash Flow)',        $this->n($r['fx_variance']),       'FX difference on realized OCY'),
            array('Total Collection Variance',      $this->n($r['total_variance']),    'Actual minus projected'),
            array('Reconciliation Check',           $this->n($r['rekonsiliasi']),      'Should equal zero'),
            array('Projected Amount Not Collected', $this->n($r['not_collected']),     'Fully unpaid projected invoices'),
            array('Unplanned Collections',          $this->n($r['unplanned']),         'Collection without planned date'),
            array('Invoices Not Collected',         $this->n($r['jml_not_collected'], 'garis_angka0'), 'Invoice count'),
            array('Invoices Partially Collected',   $this->n($r['jml_partial'], 'garis_angka0'),       'Invoice count'),
        );
        foreach ($baris as $x) { $b[] = array($this->t($x[0]), $x[1], $this->t($x[2])); }

        $b[] = array();
        $b[] = array($this->t('Summary Buyer', 'tebal'));
        $b[] = array($this->h('Name'), $this->h('Projected'), $this->h('Realization'),
                     $this->h('Variance'), $this->h('Achievement'));
        foreach ($hasil['ringkas']['buyer'] as $x) {
            $b[] = array($this->t($x['customer']), $this->n($x['projected']), $this->n($x['actual']),
                         $this->n($x['variance']), $this->n_atau_strip($x['achievement'], 'garis_persen'));
        }
        $b[] = array($this->t('TOTAL', 'garis_total'), $this->n($r['projected'], 'garis_total_angka'),
                     $this->n($r['actual'], 'garis_total_angka'),
                     $this->n($r['total_variance'], 'garis_total_angka'),
                     $this->n_atau_strip($r['achievement'], 'garis_total_persen'));

        return $b;
    }

    /* ---------------- 2. lembar utama, per invoice ---------------- */

    private function lembar_utama($hasil)
    {
        $h = $hasil['header'];

        $b = array();
        $b[] = array($this->t('AR COLLECTION REALIZATION & VARIANCE REPORT', 'judul'));
        $b[] = array($this->t('Doc Number : ' . $h['doc_number'], 'tebal'));
        // Tanggal laporannya sengaja di A3 - di lembar kerja tim AR sel inilah
        // yang jadi acuan Days Past Due.
        $b[] = array($this->d($h['periode_sampai'], 'tanggal'),
                     $this->t('Period : ' . $h['periode_dari'] . ' s/d ' . $h['periode_sampai'], ''));
        $b[] = array();

        // Nama kelompoknya rata KIRI: selnya digabung, jadi yang menyambung
        // cuma garisnya - teksnya duduk di tepi kelompoknya.
        // Nama lima kolom depannya ditulis DI BARIS INI, bukan di bawahnya:
        // rentangnya digabung menurun, dan Excel membaca sel paling atas.
        $b[] = array($this->h('Customer Name'), $this->h('Invoice No'),
                     $this->h('Invoice Date'), $this->h('Due Date'), $this->h('Currency'),
                     $this->h('Type'), $this->h('Bank & Acc No'),
                     $this->h('Projection', 'kepala_hijau_kiri'),
                     $this->h('', 'kepala_hijau_kiri'), $this->h('', 'kepala_hijau_kiri'),
                     $this->h('', 'kepala_hijau_kiri'),
                     $this->h('Realization', 'kepala_biru_kiri'),
                     $this->h('', 'kepala_biru_kiri'), $this->h('', 'kepala_biru_kiri'),
                     $this->h('', 'kepala_biru_kiri'),
                     $this->h('Result', 'kepala_kuning_kiri'),
                     $this->h('', 'kepala_kuning_kiri'), $this->h('', 'kepala_kuning_kiri'),
                     $this->h('', 'kepala_kuning_kiri'), $this->h('', 'kepala_kuning_kiri'),
                     $this->h('', 'kepala_kuning_kiri'), $this->h('', 'kepala_kuning_kiri'),
                     $this->h('', 'kepala_kuning_kiri'));
        $kepala_kosong = $this->h('');
        $b[] = array(
            $kepala_kosong, $kepala_kosong, $kepala_kosong, $kepala_kosong, $kepala_kosong,
            $kepala_kosong, $kepala_kosong,
            $this->h('Collection Date', 'kepala_hijau'), $this->h('Amount in OCY', 'kepala_hijau'),
            $this->h('Rate', 'kepala_hijau'), $this->h('Amount Eqv Idr', 'kepala_hijau'),
            $this->h('Collection Date', 'kepala_biru'), $this->h('Amount in OCY', 'kepala_biru'),
            $this->h('Rate', 'kepala_biru'), $this->h('Amount Eqv Idr', 'kepala_biru'),
            $this->h('Collection Status', 'kepala_kuning'),
            $this->h('Collection Achievement %', 'kepala_kuning'),
            $this->h('Collection Date Variance', 'kepala_kuning'),
            $this->h('Days Past Due', 'kepala_kuning'),
            $this->h('Variance Explanation', 'kepala_kuning'),
            $this->h('Collection Variance (Excl. FX)', 'kepala_kuning'),
            $this->h('FX Variance', 'kepala_kuning'),
            $this->h('Total Variance', 'kepala_kuning'),
        );

        $jml = array('proj' => 0, 'real' => 0, 'excl' => 0, 'fx' => 0, 'total' => 0);
        foreach ($hasil['invoice'] as $r) {
            $jml['proj']  += $r['proj_idr'];
            $jml['real']  += $r['real_idr'];
            $jml['excl']  += $r['variance_excl_fx'];
            $jml['fx']    += $r['fx_variance'];
            $jml['total'] += $r['total_variance'];

            $b[] = array(
                $this->t($r['customer']), $this->t($r['no_invoice']),
                $this->d($r['inv_date']), $this->d($r['due_date']), $this->t($r['curr'], 'garis_tengah'),
                $this->t($r['doc_type'] !== '' ? $r['doc_type'] : '-', 'garis_tengah'),
                $this->t($r['bank_acc'] !== '' ? $r['bank_acc'] : '-'),
                $this->d($r['proj_date']), $this->n($r['proj_ocy']), $this->n($r['proj_rate']),
                $this->n($r['proj_idr']),
                $this->d($r['real_date']), $this->n($r['real_ocy']), $this->n($r['real_rate']),
                $this->n($r['real_idr']),
                $this->t($r['status']),
                $this->n_atau_strip($r['achievement'], 'garis_persen'),
                $this->n_atau_strip($r['date_variance'], 'garis_angka0'),
                $this->n_atau_strip($r['days_past_due'], 'garis_angka0'),
                $this->t($r['explanation']),
                $this->n($r['variance_excl_fx']), $this->n($r['fx_variance']),
                $this->n($r['total_variance']),
            );
        }

        // Sel kosongnya DIHITUNG, bukan ditulis satu-satu: dua kolom
        // keterangan baru menggeser semua kolom angka dua langkah ke kanan,
        // dan deretan $k yang ditulis tangan adalah tempat kesalahan itu
        // paling mudah lolos - hasilnya angka total mendarat di bawah kolom
        // yang salah tanpa ada yang error.
        $k = $this->t('', 'garis_total');
        $b[] = array_merge(
                     array($this->t('TOTAL', 'garis_total')),
                     array_fill(0, 9, $k),
                     array($this->n($jml['proj'], 'garis_total_angka')),
                     array_fill(0, 3, $k),
                     array($this->n($jml['real'], 'garis_total_angka')),
                     array_fill(0, 5, $k),
                     array($this->n($jml['excl'], 'garis_total_angka'),
                           $this->n($jml['fx'], 'garis_total_angka'),
                           $this->n($jml['total'], 'garis_total_angka'))
                 );

        return $b;
    }

    /* ---------------- 3. lembar Projection ---------------- */

    /** Tanggal yang jadi kolom - dibatasi 400 supaya periode ngawur tidak
     *  membuat berkasnya meledak. */
    private function tanggal_periode($h)
    {
        $tanggal = array();
        $jalan = strtotime($h['periode_dari']);
        $henti = strtotime($h['periode_sampai']);
        while ($jalan <= $henti && count($tanggal) < 400) {
            $tanggal[] = date('Y-m-d', $jalan);
            $jalan = strtotime('+1 day', $jalan);
        }
        return $tanggal;
    }

    /**
     * Tiga baris judul + satu baris kosong di atas tabelnya - susunannya sama
     * dengan unduhan History Projection, jadi kepala tabelnya mulai baris 5.
     */
    const PROY_JUDUL = 4;

    /** Sel gabungan kepala lembar Projection, mis. M5:Q5. */
    public function gabung_proyeksi($hasil)
    {
        $jml_tgl = count($this->tanggal_periode($hasil['header']));
        $tetap = count(self::$KOLOM_PROYEKSI);
        $recv  = count(self::$KOLOM_RECV);
        $r1 = self::PROY_JUDUL + 1;        // baris kepala pertama
        $r2 = self::PROY_JUDUL + 2;        // baris kepala kedua

        // Kolom keterangan di depan menembus dua baris kepalanya.
        $gabung = array();
        for ($i = 1; $i <= $tetap; $i++) {
            $huruf = Xlsx_ringkas::huruf_kolom($i);
            $gabung[] = $huruf . $r1 . ':' . $huruf . $r2;
        }
        // huruf_kolom() menghitung dari 1 (1 = A), sedangkan hitungan kolom
        // di atas dari 0 - jadi semuanya digeser satu.
        $gabung[] = Xlsx_ringkas::huruf_kolom($tetap + 1) . $r1 . ':'
            . Xlsx_ringkas::huruf_kolom($tetap + $recv) . $r1;
        if ($jml_tgl > 0) {
            $a = $tetap + $recv + 1;
            $gabung[] = Xlsx_ringkas::huruf_kolom($a) . $r1 . ':'
                . Xlsx_ringkas::huruf_kolom($a + $jml_tgl - 1) . $r1;
        }
        // Dua kolom penutup menembus dua baris kepalanya, sama seperti kolom
        // keterangan di depan. Letaknya dihitung dari tiga hitungan di atas,
        // jadi periode sepanjang apa pun tetap ketemu.
        $ekor = $tetap + $recv + $jml_tgl;
        for ($i = 1; $i <= count(self::$KOLOM_EKOR); $i++) {
            $huruf = Xlsx_ringkas::huruf_kolom($ekor + $i);
            $gabung[] = $huruf . $r1 . ':' . $huruf . $r2;
        }
        return $gabung;
    }

    private function lembar_proyeksi($hasil)
    {
        $h = $hasil['header'];
        $tanggal = $this->tanggal_periode($h);
        $kosong = $this->kosong();

        // Judulnya disamakan dengan unduhan History Projection - lembar ini
        // memang isi dokumen proyeksi yang sama.
        $b = array();
        $b[] = array($this->t('PROJECTION REPORT — HISTORY', 'judul'));
        $b[] = array($this->t('Doc Number : ' . $h['doc_number'], 'tebal'));
        $b[] = array($this->t('Period     : ' . date('d M Y', strtotime($h['periode_dari']))
            . ' s/d ' . date('d M Y', strtotime($h['periode_sampai'])), ''));
        $b[] = array();

        // Baris 1 - nama kelompoknya. Dua belas kolom keterangan di depan
        // dikosongkan; namanya ada di baris kedua, menembus dua baris.
        // Nama kelompoknya rata KIRI - selnya digabung, yang menyambung cuma
        // garisnya.
        $atas = array();
        foreach (self::$KOLOM_PROYEKSI as $k) { $atas[] = $this->h($k); }
        $atas[] = $this->h('Receivable Amount', 'kepala_biru_kiri');
        for ($i = 1; $i < count(self::$KOLOM_RECV); $i++) { $atas[] = $this->h('', 'kepala_biru_kiri'); }
        if ($tanggal) {
            $atas[] = $this->h('Projected Cash Inflow from Accounts Receivable', 'kepala_hijau_kiri');
            for ($i = 1; $i < count($tanggal); $i++) { $atas[] = $this->h('', 'kepala_hijau_kiri'); }
        }
        foreach (self::$KOLOM_EKOR as $k) { $atas[] = $this->h($k); }

        // Baris 2 - nama kolom di dalam kelompoknya.
        $bawah = array();
        foreach (self::$KOLOM_PROYEKSI as $k) { $bawah[] = $this->h(''); }
        foreach (self::$KOLOM_RECV as $k) { $bawah[] = $this->h($k, 'kepala_biru'); }
        foreach ($tanggal as $t) { $bawah[] = $this->h($t, 'kepala_hijau'); }
        foreach (self::$KOLOM_EKOR as $k) { $bawah[] = $this->h(''); }

        $b[] = $atas;
        $b[] = $bawah;

        $jml = array('tax_base' => 0, 'tax_vat' => 0, 'total_invoice' => 0,
                     'income_tax_23' => 0, 'collection_amount' => 0);
        $jml_tgl = array();
        foreach ($tanggal as $t) { $jml_tgl[$t] = 0; }

        $no = 1;
        foreach ($hasil['proyeksi'] as $r) {
            // Nilai kolom tanggal = Collection Amount, dihitung amount_idr x
            // (collection / total invoice) - rumus yang sama dengan modal
            // Detail, supaya dokumen lama tetap keluar angka benar.
            $ti  = (float) $r['total_invoice'];
            $net = $ti != 0 ? (float) $r['amount_idr'] * (float) $r['collection_amount'] / $ti
                            : (float) $r['amount_idr'];

            $jml['tax_base']          += (float) $r['tax_base'];
            $jml['tax_vat']           += (float) $r['tax_vat'];
            $jml['total_invoice']     += (float) $r['total_invoice'];
            $jml['income_tax_23']     += (float) $r['income_tax_23'];
            $jml['collection_amount'] += (float) $r['collection_amount'];

            $baris = array(
                $this->n($no++, 'garis_angka0'), $this->t($r['customer']), $this->t($r['no_invoice']),
                $this->d($r['inv_date']), $this->t($r['shipp'], 'garis_tengah'),
                $this->t($r['type_so'] ? $r['type_so'] : '-', 'garis_tengah'),
                $this->d($r['duedate']), $this->d($r['duedate_update']),
                $this->n($r['top'], 'garis_angka0'), $this->t($r['curr'], 'garis_tengah'),
                $this->n($r['amount']), $this->n($r['rate']),
                $this->n($r['tax_base']), $this->n($r['tax_vat']), $this->n($r['total_invoice']),
                $this->n($r['income_tax_23']), $this->n($r['collection_amount']),
            );
            foreach ($tanggal as $t) {
                $nilai = substr((string) $r['duedate_update'], 0, 10) === $t ? $net : 0;
                $jml_tgl[$t] += $nilai;
                $baris[] = $this->n($nilai);
            }
            // Dari potret dokumennya. Dokumen yang dibuat sebelum kedua kolom
            // ini ada menyimpannya NULL - di situ yang tampil strip.
            $baris[] = $this->t(!empty($r['doc_type']) ? $r['doc_type'] : '-', 'garis_tengah');
            $baris[] = $this->t(!empty($r['bank_acc']) ? $r['bank_acc'] : '-');
            $b[] = $baris;
        }

        // Baris TOTAL, sama seperti di modal Detail.
        $total = array($this->t('TOTAL', 'garis_total'));
        for ($i = 1; $i < count(self::$KOLOM_PROYEKSI); $i++) { $total[] = $this->t('', 'garis_total'); }
        $total[] = $this->n($jml['tax_base'], 'garis_total_angka');
        $total[] = $this->n($jml['tax_vat'], 'garis_total_angka');
        $total[] = $this->n($jml['total_invoice'], 'garis_total_angka');
        $total[] = $this->n($jml['income_tax_23'], 'garis_total_angka');
        $total[] = $this->n($jml['collection_amount'], 'garis_total_angka');
        foreach ($tanggal as $t) { $total[] = $this->n($jml_tgl[$t], 'garis_total_angka'); }
        foreach (self::$KOLOM_EKOR as $k) { $total[] = $this->t('', 'garis_total'); }
        $b[] = $total;

        return $b;
    }

    /* ---------------- 4. lembar Realization ---------------- */

    private function lembar_realisasi($hasil)
    {
        $h = $hasil['header'];

        $b = array();
        $b[] = array($this->t('LIST ALOKASI', 'judul'));
        $b[] = array($this->t('Period : ' . $h['periode_dari'] . ' To ' . $h['periode_sampai'], ''));
        $b[] = array();

        $kepala = array();
        foreach (self::$KOLOM_REALISASI as $k) { $kepala[] = $this->h($k); }
        $b[] = $kepala;

        foreach ($hasil['realisasi'] as $r) {
            $b[] = array(
                $this->t($r['no_alk']), $this->d($r['tgl_alk']), $this->t($r['customer']),
                $this->t($r['doc_number']), $this->t($r['bank']), $this->t($r['account'], 'garis_tengah'),
                $this->t($r['curr'], 'garis_tengah'), $this->t($r['no_ref']), $this->d($r['ref_date']),
                $this->n($r['total']), $this->n($r['rate']), $this->n($r['eqp_idr']),
                $this->n($r['amount']), $this->n($r['amount_idr']),
                $this->n($r['income_tax_23']), $this->n($r['comission']),
                $this->n($r['bank_adm']), $this->n($r['others']), $this->n($r['collection_amount']),
                $this->t($r['keterangan']), $this->d($r['create_date']),
                $this->t($r['create_by']), $this->t($r['status'], 'garis_tengah'),
            );
        }

        return $b;
    }
}
