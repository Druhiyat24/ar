-- =====================================================================
-- Alokasi yang tersimpan TANPA JURNAL - jurnalnya dibangun ulang.
--
-- APA YANG TERJADI
--   Layar Alokasi menyimpan satu dokumen lewat EMPAT kiriman terpisah:
--     1. kepala alokasi      -> simpanalokasi
--     2. baris alokasi       -> simpan_alokasi_detail
--     3. jurnal sisi debit   -> at_debit_inv
--     4. jurnal sisi kredit  -> at_credit_inv
--   Kiriman nomor 1 dulu memuat ulang halamannya sendiri begitu dijawab
--   server (window.location.href = window.location.href di dalam
--   simpanalokasi() pada crud-nag.js). Pindah halaman MEMBATALKAN semua
--   kiriman yang masih di jalan - dan yang berangkat paling akhir justru
--   jurnalnya. Jadi dokumennya tersimpan, barisnya tersimpan, jurnalnya
--   hilang separuh atau hilang sama sekali.
--
--   Sesudah keempat langkahnya dibuat menunggu jawaban server
--   (commit a49d35f, 29 Okt 2026) urutannya jadi lebih panjang, sehingga
--   pemuatan ulang itu hampir selalu mendahului langkah 3 & 4 - itu
--   sebabnya nomor-nomor BARU justru tidak punya jurnal sama sekali,
--   sedangkan yang lama biasanya cuma kehilangan sisi kreditnya.
--
--   Penyebabnya sudah dibereskan di crud-nag.js. Berkas ini mengurus
--   dokumen yang sudah terlanjur tersimpan tanpa jurnal.
--
-- CARA KERJANYA
--   Jurnalnya dibangun ulang dari data yang MEMANG tersimpan - kepala
--   alokasi (tbl_alokasi) dan barisnya (tbl_alokasi_detail) - dengan rumus
--   yang sama persis dengan yang dipakai layarnya. Tidak ada angka yang
--   dikarang.
--
-- AMAN DIULANG. Tiap sisi hanya ditulis kalau belum ada:
--   sisi pos silang  -> dilihat dari ada tidaknya baris ber-COA 1.90.02
--   sisi barisnya    -> dilihat dari ada tidaknya baris ber-COA selain itu
--   Jadi dokumen yang cuma kehilangan sisi kredit hanya ditambahi sisi itu.
--
--   Penjaga itu bersandar pada satu sifat bagan akunnya: 1.90.02 adalah akun
--   PENAMPUNG, tidak pernah jadi akun tujuan sebuah baris alokasi - baris
--   alokasi selalu memakai akun piutang / uang muka invoice yang dilunasi.
--   Kalau suatu hari ada baris alokasi ber-COA 1.90.02, penjaga sisi barisnya
--   tidak lagi mengenali bahwa sisi itu sudah ditulis, dan menjalankan berkas
--   ini dua kali akan mendobelkannya.
--
-- JALANKAN LANGKAH 1 & 2 DULU, LIHAT HASILNYA, baru langkah 3 & 4.
-- =====================================================================


-- Dokumen yang mau diperbaiki. Dipisah koma, tanpa spasi.
-- Tambahkan nomor lain di sini kalau LANGKAH 1 menemukan yang lain.
SET @dokumen := '0018/ALK/NAG/1026,0019/ALK/NAG/1026,0020/ALK/NAG/1026,0021/ALK/NAG/1026,0001/ALK/NAG/1126,0002/ALK/NAG/1126';


-- ---------------------------------------------------------------------
-- LANGKAH 1 - seluruh kerusakannya, bukan cuma yang di daftar atas.
--
-- Tiap alokasi yang belum dibatalkan diperiksa: jurnalnya ada? dua sisinya
-- ada? seimbang? Yang keluar di sini yang bermasalah. Kalau ada nomor yang
-- belum tercantum di @dokumen, tambahkan dulu sebelum lanjut.
--
-- 'tidak ada jurnal'  -> langkah 3 & 4 akan mengisi dua-duanya
-- 'kredit hilang'     -> langkah 4 saja yang mengisi
-- 'debit hilang'      -> langkah 3 saja yang mengisi
-- 'tidak seimbang'    -> JANGAN diperbaiki berkas ini, dan berkas ini memang
--                        tidak akan menyentuhnya: dua sisinya ada, yang salah
--                        NILAInya. Penyebab yang sudah dikenal - mata uang &
--                        kurs yang dulu ikut dropdown "Payment With", dan
--                        nilai minus yang masuk debit - sudah dibedah di
--                        migrations/20261021_cek_jurnal_alokasi.sql, yang
--                        hanya membaca. Pakai berkas itu untuk yang ini.
-- ---------------------------------------------------------------------
SELECT a.no_alk,
       a.tgl_alk,
       a.curr,
       a.amount                                   AS nilai_alokasi,
       IFNULL(j.baris, 0)                         AS baris_jurnal,
       IFNULL(j.debit_idr, 0)                     AS jurnal_debit,
       IFNULL(j.credit_idr, 0)                    AS jurnal_kredit,
       CASE
           WHEN IFNULL(j.baris, 0) = 0                  THEN 'tidak ada jurnal'
           WHEN IFNULL(j.baris_pos_silang, 0) = 0       THEN 'debit hilang'
           WHEN IFNULL(j.baris_lain, 0) = 0             THEN 'kredit hilang'
           WHEN ROUND(j.debit_idr) <> ROUND(j.credit_idr) THEN 'tidak seimbang'
           ELSE 'lengkap'
       END                                        AS keadaan
  FROM tbl_alokasi AS a
  LEFT JOIN (SELECT no_journal,
                    COUNT(*)                                AS baris,
                    SUM(IF(no_coa  = '1.90.02', 1, 0))      AS baris_pos_silang,
                    SUM(IF(no_coa <> '1.90.02', 1, 0))      AS baris_lain,
                    SUM(debit_idr)                          AS debit_idr,
                    SUM(credit_idr)                         AS credit_idr
               FROM tbl_list_journal
              WHERE no_journal LIKE '%/ALK/%'
              GROUP BY no_journal) AS j
         ON j.no_journal = a.no_alk
 WHERE IFNULL(a.status, '') <> 'Cancel'
HAVING keadaan <> 'lengkap'
 ORDER BY a.tgl_alk, a.no_alk;


-- ---------------------------------------------------------------------
-- LANGKAH 2 - baris yang akan dipakai membangun jurnalnya.
--
-- Kolom 'dari_proforma' penting: baris yang berasal dari Proforma Invoice
-- jurnalnya DIPECAH - uang muka sebesar DPP saja, PPN-nya ke PPN KELUARAN.
-- LANGKAH 4 sudah memecahnya sendiri dengan porsi yang sama dengan
-- layarnya (twot / total dari tbl_invoice_proforma). Kolom ini cuma supaya
-- pemecahannya bisa dicocokkan.
-- ---------------------------------------------------------------------
SELECT d.no_alk,
       d.coa,
       IFNULL(c.nama_coa, '(tidak ada di mastercoa_v2)') AS nama_coa,
       d.cost_center,
       d.no_ref,
       d.ref_date,
       d.amount,
       d.profit_center,
       IF(pi.no_proforma_invoice IS NULL, '-', 'ya')     AS dari_proforma,
       IF(pi.no_proforma_invoice IS NULL
          OR IFNULL(pi.total, 0) <= 0
          OR IFNULL(pi.twot, 0) <= 0, 1,
          ROUND(pi.twot / pi.total, 6))                  AS porsi_dpp
  FROM tbl_alokasi_detail AS d
  LEFT JOIN mastercoa_v2 AS c ON c.no_coa = d.coa
  LEFT JOIN tbl_invoice_proforma AS pi ON pi.no_proforma_invoice = d.no_ref
 WHERE FIND_IN_SET(d.no_alk, @dokumen)
 ORDER BY d.no_alk, d.id;


-- ---------------------------------------------------------------------
-- LANGKAH 3 - sisi POS SILANG PIUTANG USAHA (COA 1.90.02).
--
-- Satu baris per profit center, nilainya jumlah seluruh barisnya -
-- persis seperti at_debit_alokasi() di crud-nag.js. Jumlah yang minus
-- tidak ditulis apa adanya: sisinya yang dibalik, nilainya tetap positif.
--
-- Kursnya dari kepala alokasi, dan 1 kalau mata uangnya rupiah.
-- ---------------------------------------------------------------------
INSERT INTO tbl_list_journal
    (no_journal, tgl_journal, type_journal, no_coa, nama_coa,
     no_costcenter, nama_costcenter, reff_doc, reff_date, buyer, no_ws,
     curr, rate, debit, credit, debit_idr, credit_idr, status, keterangan,
     create_by, approve_by, cancel_by, profit_center)
SELECT x.no_alk, x.tgl_alk, 'Alokasi', '1.90.02', 'POS SILANG PIUTANG USAHA',
       '-', '-', '-', NULL, x.buyer, '',
       x.curr, x.rate,
       IF(x.jml > 0,  x.jml, 0),
       IF(x.jml < 0, -x.jml, 0),
       IF(x.jml > 0, ROUND( x.jml * x.rate, 2), 0),
       IF(x.jml < 0, ROUND(-x.jml * x.rate, 2), 0),
       'POST',
       CONCAT('PELUNASAN PIUTANG USAHA DARI ', x.buyer),
       '', '', '', x.pc
  FROM (SELECT h.no_alk,
               h.tgl_alk,
               h.curr,
               h.rate,
               h.buyer,
               IFNULL(NULLIF(TRIM(d.profit_center), ''), '-') AS pc,
               ROUND(SUM(d.amount), 2)                        AS jml
          FROM (SELECT a.no_alk,
                       MIN(a.tgl_alk)  AS tgl_alk,
                       MIN(a.curr)     AS curr,
                       IF(MIN(a.curr) = 'IDR', 1, MIN(a.rate)) AS rate,
                       IFNULL(MIN(ms.Supplier), '')            AS buyer
                  FROM tbl_alokasi AS a
                  LEFT JOIN mastersupplier AS ms ON ms.Id_Supplier = a.customer
                 WHERE FIND_IN_SET(a.no_alk, @dokumen)
                   AND IFNULL(a.status, '') <> 'Cancel'
                 GROUP BY a.no_alk) AS h
         INNER JOIN tbl_alokasi_detail AS d ON d.no_alk = h.no_alk
         WHERE NOT EXISTS (SELECT 1 FROM tbl_list_journal AS j
                            WHERE j.no_journal = h.no_alk
                              AND j.no_coa     = '1.90.02')
         GROUP BY h.no_alk, h.tgl_alk, h.curr, h.rate, h.buyer,
                  IFNULL(NULLIF(TRIM(d.profit_center), ''), '-')
        HAVING ROUND(SUM(d.amount), 2) <> 0) AS x;


-- ---------------------------------------------------------------------
-- LANGKAH 4 - sisi barisnya (COA uang muka / piutang tiap baris).
--
-- Satu baris jurnal per baris alokasi - persis seperti at_credit_alokasi()
-- di crud-nag.js, termasuk tiga hal yang mudah terlewat:
--
--   * Baris bernilai nol dilewati, bukan ditulis nol-nol.
--   * Baris bernilai minus dibalik sisinya, nilainya tetap positif; dan
--     nomor rujukannya ikut dilepas (jadi '-') seperti di layarnya.
--   * Baris dari Proforma Invoice DIPECAH: uang muka sebesar DPP, sisanya
--     PPN KELUARAN. Porsinya twot/total dibulatkan 6 angka - sama dengan
--     dpp_rasio yang dikirim layarnya - lalu bagian PPN-nya diambil dari
--     SELISIHnya, bukan dihitung sendiri, supaya jumlahnya tetap sama
--     persis dengan yang dilunasi.
--
-- Nama COA & nama cost centernya diambil dari master, sama seperti yang
-- dilakukan _lengkapi_nama_jurnal() di Model_nag.
-- ---------------------------------------------------------------------
INSERT INTO tbl_list_journal
    (no_journal, tgl_journal, type_journal, no_coa, nama_coa,
     no_costcenter, nama_costcenter, reff_doc, reff_date, buyer, no_ws,
     curr, rate, debit, credit, debit_idr, credit_idr, status, keterangan,
     create_by, approve_by, cancel_by, profit_center)
WITH basis AS (
    SELECT h.no_alk, h.tgl_alk, h.curr, h.rate, h.buyer,
           d.id                                               AS id_baris,
           d.coa                                              AS coa_pokok,
           IFNULL(c.nama_coa, '')                             AS nama_pokok,
           IFNULL(NULLIF(TRIM(d.cost_center), ''), '-')       AS no_cc,
           IFNULL(cc.cc_name, '-')                            AS nama_cc,
           IFNULL(NULLIF(TRIM(d.no_ref), ''), '-')            AS no_ref,
           d.ref_date,
           IFNULL(NULLIF(TRIM(d.profit_center), ''), '-')     AS pc,
           ROUND(d.amount, 2)                                 AS nilai_penuh,
           IF(TRIM(IFNULL(d.keterangan, '')) IN ('', '-'),
              CONCAT('PELUNASAN PIUTANG USAHA DARI ', h.buyer),
              TRIM(d.keterangan))                             AS keterangan,
           -- Porsi DPP: 1 kalau barisnya bukan dari Proforma Invoice, atau
           -- proformanya tidak punya nilai tanpa pajak.
           IF(pi.no_proforma_invoice IS NULL
              OR IFNULL(pi.total, 0) <= 0
              OR IFNULL(pi.twot, 0) <= 0, 1,
              ROUND(pi.twot / pi.total, 6))                    AS rasio,
           (SELECT no_coa   FROM mastercoa_v2
             WHERE inv_type LIKE '%PPN INV%' LIMIT 1)          AS coa_ppn,
           (SELECT nama_coa FROM mastercoa_v2
             WHERE inv_type LIKE '%PPN INV%' LIMIT 1)          AS nama_ppn
      FROM (SELECT a.no_alk,
                   MIN(a.tgl_alk)  AS tgl_alk,
                   MIN(a.curr)     AS curr,
                   IF(MIN(a.curr) = 'IDR', 1, MIN(a.rate)) AS rate,
                   IFNULL(MIN(ms.Supplier), '')            AS buyer
              FROM tbl_alokasi AS a
              LEFT JOIN mastersupplier AS ms ON ms.Id_Supplier = a.customer
             WHERE FIND_IN_SET(a.no_alk, @dokumen)
               AND IFNULL(a.status, '') <> 'Cancel'
             GROUP BY a.no_alk) AS h
     INNER JOIN tbl_alokasi_detail AS d  ON d.no_alk  = h.no_alk
      LEFT JOIN mastercoa_v2       AS c  ON c.no_coa  = d.coa
      LEFT JOIN b_master_cc        AS cc ON cc.no_cc  = d.cost_center
      LEFT JOIN tbl_invoice_proforma AS pi ON pi.no_proforma_invoice = d.no_ref
     WHERE ROUND(d.amount, 2) <> 0
       AND NOT EXISTS (SELECT 1 FROM tbl_list_journal AS j
                        WHERE j.no_journal = h.no_alk
                          AND j.no_coa    <> '1.90.02')
)
SELECT y.no_alk, y.tgl_alk, 'Alokasi', y.no_coa, y.nama_coa,
       y.no_cc, y.nama_cc,
       IF(y.nilai < 0, '-', y.no_ref),
       IF(y.nilai < 0, NULL, y.ref_date),
       y.buyer, '',
       y.curr, y.rate,
       IF(y.nilai < 0, -y.nilai, 0),
       IF(y.nilai > 0,  y.nilai, 0),
       IF(y.nilai < 0, ROUND(-y.nilai * y.rate, 2), 0),
       IF(y.nilai > 0, ROUND( y.nilai * y.rate, 2), 0),
       'POST', y.keterangan, '', '', '', y.pc
  FROM (
        -- bagian pokok: seluruh nilainya, atau DPP-nya kalau dipecah
        SELECT b.no_alk, b.tgl_alk, b.curr, b.rate, b.buyer, b.id_baris,
               b.coa_pokok AS no_coa, b.nama_pokok AS nama_coa,
               b.no_cc, b.nama_cc, b.no_ref, b.ref_date, b.pc, b.keterangan,
               1 AS urut,
               ROUND(b.nilai_penuh * b.rasio, 2) AS nilai
          FROM basis AS b
        UNION ALL
        -- bagian PPN: SELISIHnya, supaya jumlah keduanya tepat
        SELECT b.no_alk, b.tgl_alk, b.curr, b.rate, b.buyer, b.id_baris,
               b.coa_ppn AS no_coa, IFNULL(b.nama_ppn, '') AS nama_coa,
               b.no_cc, b.nama_cc, b.no_ref, b.ref_date, b.pc, b.keterangan,
               2 AS urut,
               b.nilai_penuh - ROUND(b.nilai_penuh * b.rasio, 2) AS nilai
          FROM basis AS b
         WHERE b.rasio < 1
           AND IFNULL(b.coa_ppn, '') <> ''
       ) AS y
 WHERE y.nilai <> 0
 ORDER BY y.no_alk, y.id_baris, y.urut;


-- ---------------------------------------------------------------------
-- LANGKAH 5 - periksa hasilnya.
--
-- Yang pertama: tiap dokumen harus 'lengkap' dan 'cocok'.
--   'cocok' = sisi POS SILANGnya sama dengan nilai alokasi di kepalanya -
--   itu patokan terakhir bahwa jurnalnya sebesar yang betul-betul dialokasikan.
--   Untuk dokumen valas pembandingnya nilai rupiah (eqp_idr).
--
--   Yang dibandingkan sengaja bukan jumlah SELURUH debit: baris alokasi yang
--   nilainya minus ikut tercatat di sisi debit juga, jadi jumlah seluruh debit
--   memang lebih besar dari nilai alokasinya - dan itu benar, bukan selisih.
-- Yang kedua: barisnya, untuk dicocokkan mata & dicetak kalau perlu.
-- ---------------------------------------------------------------------
SELECT a.no_alk,
       a.curr,
       a.amount                 AS nilai_alokasi,
       a.eqp_idr                AS nilai_alokasi_idr,
       SUM(j.debit_idr)         AS jurnal_debit,
       SUM(j.credit_idr)        AS jurnal_kredit,
       SUM(IF(j.no_coa = '1.90.02', j.debit_idr - j.credit_idr, 0)) AS pos_silang,
       IF(ROUND(SUM(j.debit_idr)) = ROUND(SUM(j.credit_idr)),
          'lengkap', 'TIDAK SEIMBANG')                       AS keadaan,
       IF(ROUND(SUM(IF(j.no_coa = '1.90.02', j.debit_idr - j.credit_idr, 0)))
          = ROUND(IF(a.curr = 'IDR', a.amount, a.eqp_idr)),
          'cocok', 'PERIKSA')                                AS banding_kepala
  FROM tbl_alokasi AS a
 INNER JOIN tbl_list_journal AS j ON j.no_journal = a.no_alk
 WHERE FIND_IN_SET(a.no_alk, @dokumen)
 GROUP BY a.no_alk, a.curr, a.amount, a.eqp_idr
 ORDER BY a.no_alk;

SELECT no_journal, tgl_journal, no_coa, nama_coa, no_costcenter,
       reff_doc, curr, rate, debit, credit, debit_idr, credit_idr,
       profit_center, keterangan
  FROM tbl_list_journal
 WHERE FIND_IN_SET(no_journal, @dokumen)
 ORDER BY no_journal, id;
