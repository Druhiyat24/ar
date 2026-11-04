-- =====================================================================
-- Perbaikan TANGGAL SJ satu baris invoice EXIM.
--
--   Invoice : 0059/E/NAG/1126
--   No SJ   : FG/OUT/1126/07728      (tersimpan di kolom shipp_number)
--
-- KENAPA DUA TABEL YANG DIUBAH
--   Invoice EXIM menyimpan baris SJ-nya di tbl_book_invoice_exim_det.
--   Begitu invoicenya dibuat lewat Create Invoice, barisnya DISALIN ke
--   tbl_invoice_detail. Laporan membaca dua-duanya:
--
--     Sales Report (3 menu)  -> tbl_invoice_detail.sj_date
--     Unearned Revenue       -> tbl_book_invoice_exim_det.sj_date
--                               (Model_nag::_sql_tgl_sj_invoice, dipakai
--                               kalau tbl_book_invoice.sj_date kosong -
--                               dan untuk invoice ekspor memang kosong)
--
--   Kalau cuma salah satu yang dibetulkan, dua laporan itu akan memajang
--   tanggal yang berbeda untuk invoice yang sama.
--
-- YANG SENGAJA TIDAK DISENTUH
--   bppb.bppbdate - itu catatan pengiriman milik ERP garment, bukan milik
--   modul AR. Kalau yang salah tanggal di ERP-nya, betulkan di sana lalu
--   pakai LANGKAH 2B supaya invoicenya menyalin ulang dari situ.
--
-- AMAN DIULANG, DAN AMAN KALAU TERLANJUR DIJALANKAN SEBELUM DIISI:
--   selama @tgl_baru masih NULL tidak ada satu baris pun yang berubah.
-- =====================================================================


-- ---------------------------------------------------------------------
-- ISI DULU DI SINI
-- ---------------------------------------------------------------------
SET @no_invoice = '0059/E/NAG/1126';
SET @no_sj      = 'FG/OUT/1126/07728';

-- Tanggal SJ yang benar. GANTI NULL di bawah ini, contoh: '2026-11-03'
SET @tgl_baru   = NULL;


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu keadaan sekarang.
--
-- Tiga baris pertama harus memunculkan nomor SJ yang dimaksud. Kalau
-- "baris exim" 0, berarti nomor SJ-nya beda tulisan - cek dulu dengan
-- LANGKAH 1B sebelum lanjut.
-- ---------------------------------------------------------------------
SELECT 'exim_det' AS tabel, e.id, e.no_invoice, e.bppb_number, e.shipp_number,
       e.sj_date, e.id_bppb
  FROM tbl_book_invoice_exim_det e
 WHERE e.no_invoice = @no_invoice
   AND (e.shipp_number = @no_sj OR e.bppb_number = @no_sj);

SELECT 'invoice_detail' AS tabel, d.id, i.no_invoice, d.bppb_number, d.shipp_number,
       d.sj_date, d.id_bppb
  FROM tbl_invoice_detail d
  JOIN tbl_book_invoice i ON i.id = d.id_book_invoice
 WHERE i.no_invoice = @no_invoice
   AND (d.shipp_number = @no_sj OR d.bppb_number = @no_sj);

-- Header invoicenya. Untuk invoice ekspor sj_date-nya biasanya NULL -
-- itu normal, laporannya mengambil dari baris SJ-nya.
SELECT 'header' AS tabel, i.id, i.no_invoice, i.status, i.sj_date, i.tgl_inv, i.tgl_book_inv
  FROM tbl_book_invoice i
 WHERE i.no_invoice = @no_invoice;

-- Tanggal menurut catatan pengiriman ERP-nya, buat pembanding.
SELECT 'sumber ERP' AS tabel, b.id, b.bppbno, DATE(b.bppbdate) AS bppbdate, b.invno
  FROM bppb b
  JOIN tbl_book_invoice_exim_det e ON e.id_bppb = b.id
 WHERE e.no_invoice = @no_invoice
   AND (e.shipp_number = @no_sj OR e.bppb_number = @no_sj)
 GROUP BY b.id;


-- ---------------------------------------------------------------------
-- LANGKAH 1B - kalau LANGKAH 1 tidak memunculkan barisnya.
-- Lihat semua SJ milik invoice ini, lalu cocokkan tulisan nomornya.
-- ---------------------------------------------------------------------
-- SELECT e.id, e.bppb_number, e.shipp_number, e.sj_date, e.qty
--   FROM tbl_book_invoice_exim_det e
--  WHERE e.no_invoice = @no_invoice
--  ORDER BY e.shipp_number, e.id;


-- =====================================================================
-- PILIH SALAH SATU: LANGKAH 2A (tanggal diketik) ATAU 2B (ikut ERP).
-- =====================================================================

-- ---------------------------------------------------------------------
-- LANGKAH 2A - pakai tanggal yang diisi di @tgl_baru.
--
-- Dua-duanya dijalankan. Yang kedua tidak berpengaruh kalau invoicenya
-- belum pernah dibuat lewat Create Invoice (barisnya memang belum ada).
-- ---------------------------------------------------------------------
UPDATE tbl_book_invoice_exim_det e
   SET e.sj_date = DATE(@tgl_baru)
 WHERE e.no_invoice = @no_invoice
   AND (e.shipp_number = @no_sj OR e.bppb_number = @no_sj)
   AND @tgl_baru IS NOT NULL;

UPDATE tbl_invoice_detail d
  JOIN tbl_book_invoice i ON i.id = d.id_book_invoice
   SET d.sj_date = CAST(CONCAT(DATE(@tgl_baru), ' 00:00:00') AS DATETIME)
 WHERE i.no_invoice = @no_invoice
   AND (d.shipp_number = @no_sj OR d.bppb_number = @no_sj)
   AND @tgl_baru IS NOT NULL;


-- ---------------------------------------------------------------------
-- LANGKAH 2B - salin ulang dari catatan pengiriman ERP-nya.
--
-- Dipakai kalau yang salah dulu salinannya, bukan tanggal aslinya -
-- misalnya tanggal SJ-nya sudah dibetulkan di ERP sesudah invoicenya
-- dibooking. Tidak perlu mengisi @tgl_baru.
-- Buang tanda komentarnya kalau cara ini yang dipakai.
-- ---------------------------------------------------------------------
-- UPDATE tbl_book_invoice_exim_det e
--   JOIN bppb b ON b.id = e.id_bppb
--    SET e.sj_date = DATE(b.bppbdate)
--  WHERE e.no_invoice = @no_invoice
--    AND (e.shipp_number = @no_sj OR e.bppb_number = @no_sj)
--    AND b.bppbdate IS NOT NULL;
--
-- UPDATE tbl_invoice_detail d
--   JOIN tbl_book_invoice i ON i.id = d.id_book_invoice
--   JOIN bppb b ON b.id = d.id_bppb
--    SET d.sj_date = CAST(CONCAT(DATE(b.bppbdate), ' 00:00:00') AS DATETIME)
--  WHERE i.no_invoice = @no_invoice
--    AND (d.shipp_number = @no_sj OR d.bppb_number = @no_sj)
--    AND b.bppbdate IS NOT NULL;


-- ---------------------------------------------------------------------
-- LANGKAH 3 (hanya kalau perlu) - header invoicenya.
--
-- Jangan dijalankan kalau sj_date header-nya NULL: untuk invoice ekspor
-- memang begitu, dan kalau diisi justru header-nya yang akan dipakai
-- laporan, bukan baris SJ-nya. Jalankan HANYA kalau LANGKAH 1 tadi
-- menunjukkan header-nya memang terisi dan ikut salah.
-- ---------------------------------------------------------------------
-- UPDATE tbl_book_invoice i
--    SET i.sj_date = DATE(@tgl_baru)
--  WHERE i.no_invoice = @no_invoice
--    AND i.sj_date IS NOT NULL
--    AND @tgl_baru IS NOT NULL;


-- ---------------------------------------------------------------------
-- LANGKAH 4 - periksa hasilnya. Tanggal di kedua tabel harus sama.
-- ---------------------------------------------------------------------
SELECT 'exim_det' AS tabel, e.id, e.shipp_number, DATE(e.sj_date) AS sj_date
  FROM tbl_book_invoice_exim_det e
 WHERE e.no_invoice = @no_invoice
   AND (e.shipp_number = @no_sj OR e.bppb_number = @no_sj)
UNION ALL
SELECT 'invoice_detail', d.id, d.shipp_number, DATE(d.sj_date)
  FROM tbl_invoice_detail d
  JOIN tbl_book_invoice i ON i.id = d.id_book_invoice
 WHERE i.no_invoice = @no_invoice
   AND (d.shipp_number = @no_sj OR d.bppb_number = @no_sj);

-- Tanggal yang akan dipakai laporan untuk invoice ini, sesudah perbaikan.
SELECT i.no_invoice,
       i.sj_date                                   AS tgl_header,
       MIN(e.sj_date)                              AS tgl_baris_exim,
       MIN(DATE(d.sj_date))                        AS tgl_baris_invoice,
       COALESCE(i.sj_date, MIN(e.sj_date), MIN(DATE(d.sj_date))) AS tgl_dipakai_laporan
  FROM tbl_book_invoice i
  LEFT JOIN tbl_book_invoice_exim_det e ON e.id_book_invoice = i.id
  LEFT JOIN tbl_invoice_detail d        ON d.id_book_invoice = i.id
 WHERE i.no_invoice = @no_invoice
 GROUP BY i.id;
