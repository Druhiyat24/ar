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
    /** Kolom tetap lembar Projection, sama urutannya dengan unduhan proyeksi. */
    private static $KOLOM_PROYEKSI = array(
        'No', 'Customer', 'Invoice No', 'Invoice Date', 'Destination', 'Order Type',
        'Due Date', 'Expected Collection Date', 'Payment Term', 'Currency',
        'Invoice Amount', 'Rate', 'Tax Base', 'VAT', 'Total Invoice',
        'Income Tax Art 23', 'Collection Amount',
    );

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
            array(36, 22, 46, 20, 16), 0, array('A1:B1'));
        $x->lembar('AR Collection Realization & Variance Report',
            $this->lembar_utama($hasil),
            array(38, 20, 13, 13, 8, 14, 15, 11, 18, 14, 15, 11, 18, 20, 12, 11, 11, 32, 19, 16, 19),
            6, array('F5:I5', 'J5:M5', 'N5:U5'));
        $x->lembar('Projection', $this->lembar_proyeksi($hasil), array(), 1);
        $x->lembar('Realization', $this->lembar_realisasi($hasil), array(), 4);
        return $x;
    }

    public function nama_berkas($hasil)
    {
        $doc = isset($hasil['header']['doc_number']) ? $hasil['header']['doc_number'] : 'realization';
        return 'AR Collection Realization ' . str_replace('/', '-', $doc) . '.xlsx';
    }

    /* ---------------- penolong sel ---------------- */

    private function t($v, $gaya = '')  { return array('v' => $v, 't' => 's', 's' => $gaya); }
    private function n($v, $gaya = 'angka') { return array('v' => (float) $v, 't' => 'n', 's' => $gaya); }
    private function h($v, $gaya = 'kepala') { return array('v' => $v, 't' => 's', 's' => $gaya); }

    /** Tanggal kosong atau 0000-00-00 ditulis strip, bukan 1899. */
    private function d($v, $gaya = 'tanggal')
    {
        if (empty($v) || $v === '0000-00-00') { return $this->t('-', 'tengah'); }
        return array('v' => substr($v, 0, 10), 't' => 'd', 's' => $gaya);
    }

    /** Angka yang memang belum ada ditulis strip - bukan nol yang menyesatkan. */
    private function n_atau_strip($v, $gaya = 'angka')
    {
        return ($v === null) ? $this->t('-', 'tengah') : $this->n($v, $gaya);
    }

    /* ---------------- 1. Executive Summary ---------------- */

    private function lembar_ringkas($hasil)
    {
        $h = $hasil['header'];
        $r = $hasil['ringkas'];

        $b = array();
        $b[] = array($this->t('AR COLLECTION', 'judul'), $this->t('PERFORMANCE DASHBOARD', 'judul'));
        $b[] = array();
        $b[] = array($this->t('Doc Number', 'tebal'), $this->t($h['doc_number']));
        $b[] = array($this->t('Reporting Period', 'tebal'), $this->d($h['periode_sampai']));
        $b[] = array($this->t('Period Covered', 'tebal'), $this->d($h['periode_dari']), $this->d($h['periode_sampai']));
        $b[] = array();
        $b[] = array($this->h('Performance Indicator'), $this->h('Amount (IDR)'), $this->h('Interpretation'));

        $baris = array(
            array('Projected Collection',           $this->n($r['projected']),        'Projected IDR at projected rate'),
            array('Actual Collection',              $this->n($r['actual']),           'Actual IDR at actual rate'),
            array('Collection Achievement (IDR)',   $this->n_atau_strip($r['achievement'], 'persen'),
                                                    'Includes FX impact; OCY % available per invoice'),
            array('Collection Variance (Excl. FX)', $this->n($r['variance_excl_fx']),  'OCY difference translated at projected rate'),
            array('FX Variance (Cash Flow)',        $this->n($r['fx_variance']),       'FX difference on realized OCY'),
            array('Total Collection Variance',      $this->n($r['total_variance']),    'Actual minus projected'),
            array('Reconciliation Check',           $this->n($r['rekonsiliasi']),      'Should equal zero'),
            array('Projected Amount Not Collected', $this->n($r['not_collected']),     'Fully unpaid projected invoices'),
            array('Unplanned Collections',          $this->n($r['unplanned']),         'Collection without planned date'),
            array('Invoices Not Collected',         $this->n($r['jml_not_collected'], 'angka0'), 'Invoice count'),
            array('Invoices Partially Collected',   $this->n($r['jml_partial'], 'angka0'),       'Invoice count'),
        );
        foreach ($baris as $x) { $b[] = array($this->t($x[0]), $x[1], $this->t($x[2])); }

        $b[] = array();
        $b[] = array($this->t('Summary Buyer', 'tebal'));
        $b[] = array($this->h('Name'), $this->h('Projected'), $this->h('Realization'),
                     $this->h('Variance'), $this->h('Achievement'));
        foreach ($hasil['ringkas']['buyer'] as $x) {
            $b[] = array($this->t($x['customer']), $this->n($x['projected']), $this->n($x['actual']),
                         $this->n($x['variance']), $this->n_atau_strip($x['achievement'], 'persen'));
        }
        $b[] = array($this->t('TOTAL', 'tebal'), $this->n($r['projected'], 'tebal_angka'),
                     $this->n($r['actual'], 'tebal_angka'), $this->n($r['total_variance'], 'tebal_angka'),
                     $this->n_atau_strip($r['achievement'], 'persen'));

        return $b;
    }

    /* ---------------- 2. lembar utama, per invoice ---------------- */

    private function lembar_utama($hasil)
    {
        $h = $hasil['header'];

        $b = array();
        $b[] = array($this->t('AR COLLECTION REALIZATION & VARIANCE REPORT', 'judul'));
        $b[] = array($this->t('Doc Number : ' . $h['doc_number']));
        // Tanggal laporannya sengaja di A3 - di lembar kerja tim AR sel inilah
        // yang jadi acuan Days Past Due.
        $b[] = array($this->d($h['periode_sampai']),
                     $this->t('Period : ' . $h['periode_dari'] . ' s/d ' . $h['periode_sampai']));
        $b[] = array();

        $kosong = $this->t('');
        $b[] = array($kosong, $kosong, $kosong, $kosong, $kosong,
                     $this->h('Projection', 'kepala_hijau'), $kosong, $kosong, $kosong,
                     $this->h('Realization', 'kepala_biru'), $kosong, $kosong, $kosong,
                     $this->h('Result', 'kepala_kuning'));
        $b[] = array(
            $this->h('Customer Name'), $this->h('Invoice No'), $this->h('Invoice Date'),
            $this->h('Due Date'), $this->h('Currency'),
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
                $this->d($r['inv_date']), $this->d($r['due_date']), $this->t($r['curr'], 'tengah'),
                $this->d($r['proj_date']), $this->n($r['proj_ocy']), $this->n($r['proj_rate']),
                $this->n($r['proj_idr']),
                $this->d($r['real_date']), $this->n($r['real_ocy']), $this->n($r['real_rate']),
                $this->n($r['real_idr']),
                $this->t($r['status']),
                $this->n_atau_strip($r['achievement'], 'persen'),
                $this->n_atau_strip($r['date_variance'], 'angka0'),
                $this->n_atau_strip($r['days_past_due'], 'angka0'),
                $this->t($r['explanation']),
                $this->n($r['variance_excl_fx']), $this->n($r['fx_variance']),
                $this->n($r['total_variance']),
            );
        }

        $k = $this->t('');
        $b[] = array($this->t('TOTAL', 'tebal'), $k, $k, $k, $k, $k, $k, $k,
                     $this->n($jml['proj'], 'tebal_angka'), $k, $k, $k,
                     $this->n($jml['real'], 'tebal_angka'), $k, $k, $k, $k, $k,
                     $this->n($jml['excl'], 'tebal_angka'), $this->n($jml['fx'], 'tebal_angka'),
                     $this->n($jml['total'], 'tebal_angka'));

        return $b;
    }

    /* ---------------- 3. lembar Projection ---------------- */

    private function lembar_proyeksi($hasil)
    {
        $h = $hasil['header'];

        // Kolom per tanggal, sama dengan unduhan Projection Report - nilainya
        // jatuh di kolom Expected Collection Date-nya.
        $tanggal = array();
        $jalan = strtotime($h['periode_dari']);
        $henti = strtotime($h['periode_sampai']);
        while ($jalan <= $henti && count($tanggal) < 400) {
            $tanggal[] = date('Y-m-d', $jalan);
            $jalan = strtotime('+1 day', $jalan);
        }

        $kepala = array();
        foreach (self::$KOLOM_PROYEKSI as $k) { $kepala[] = $this->h($k); }
        foreach ($tanggal as $t) { $kepala[] = $this->h($t, 'kepala_hijau'); }

        $b = array($kepala);
        $no = 1;
        foreach ($hasil['proyeksi'] as $r) {
            // Nilai kolom tanggal = Collection Amount, dihitung amount_idr x
            // (collection / total invoice) - sama persis dengan unduhan
            // Projection Report, supaya dokumen lama tetap keluar angka benar.
            $ti  = (float) $r['total_invoice'];
            $net = $ti != 0 ? (float) $r['amount_idr'] * (float) $r['collection_amount'] / $ti
                            : (float) $r['amount_idr'];

            $baris = array(
                $this->n($no++, 'angka0'), $this->t($r['customer']), $this->t($r['no_invoice']),
                $this->d($r['inv_date']), $this->t($r['shipp'], 'tengah'),
                $this->t($r['type_so'] ? $r['type_so'] : '-', 'tengah'),
                $this->d($r['duedate']), $this->d($r['duedate_update']),
                $this->n($r['top'], 'angka0'), $this->t($r['curr'], 'tengah'),
                $this->n($r['amount']), $this->n($r['rate']),
                $this->n($r['tax_base']), $this->n($r['tax_vat']), $this->n($r['total_invoice']),
                $this->n($r['income_tax_23']), $this->n($r['collection_amount']),
            );
            foreach ($tanggal as $t) {
                $baris[] = $this->n(substr((string) $r['duedate_update'], 0, 10) === $t ? $net : 0);
            }
            $b[] = $baris;
        }

        return $b;
    }

    /* ---------------- 4. lembar Realization ---------------- */

    private function lembar_realisasi($hasil)
    {
        $h = $hasil['header'];

        $b = array();
        $b[] = array($this->t('LIST ALOKASI', 'judul'));
        $b[] = array($this->t('Period : ' . $h['periode_dari'] . ' To ' . $h['periode_sampai']));
        $b[] = array();

        $kepala = array();
        foreach (self::$KOLOM_REALISASI as $k) { $kepala[] = $this->h($k); }
        $b[] = $kepala;

        foreach ($hasil['realisasi'] as $r) {
            $b[] = array(
                $this->t($r['no_alk']), $this->d($r['tgl_alk']), $this->t($r['customer']),
                $this->t($r['doc_number']), $this->t($r['bank']), $this->t($r['account'], 'tengah'),
                $this->t($r['curr'], 'tengah'), $this->t($r['no_ref']), $this->d($r['ref_date']),
                $this->n($r['total']), $this->n($r['rate']), $this->n($r['eqp_idr']),
                $this->n($r['amount']), $this->n($r['amount_idr']),
                $this->n($r['income_tax_23']), $this->n($r['comission']),
                $this->n($r['bank_adm']), $this->n($r['others']), $this->n($r['collection_amount']),
                $this->t($r['keterangan']), $this->d($r['create_date']),
                $this->t($r['create_by']), $this->t($r['status'], 'tengah'),
            );
        }

        return $b;
    }
}
