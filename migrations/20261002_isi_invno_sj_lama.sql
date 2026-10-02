-- ===========================================================================
--  ISI NOMOR INVOICE DI SJ UNTUK INVOICE EXIM YANG SUDAH TERLANJUR DIBUAT
-- ===========================================================================
--  Sejak perubahan ini, tiap Invoice EXIM (Local & Export) menandai SJ-nya
--  dengan nomor invoicenya. Invoice yang dibuat SEBELUM itu belum tertandai -
--  berkas ini mengisinya mundur.
--
--  Tiga sasaran, karena SJ-nya memang tersimpan di tempat berbeda:
--    BAGIAN 2  bppb.invno  untuk SJ garment (dicocokkan lewat id)
--    BAGIAN 3  bppb.invno  untuk SJ knitting (dicocokkan lewat NOMOR SJ-nya,
--                          karena id_bppb baris knitting berisi
--                          official_out_h.id - bukan bppb.id)
--    BAGIAN 4  official_out_h di database KNITTING (PostgreSQL) - beda server,
--              jadi perintahnya DIHASILKAN di sini lalu dijalankan di sana
--
--  AMAN DIJALANKAN BERULANG. Yang diisi hanya baris yang invno-nya masih
--  kosong; baris yang sudah terisi TIDAK ditimpa, jadi nomor yang ditulis
--  proses lain tidak tertimpa. Invoice berstatus CANCEL dilewati.
--
--  Jalankan BAGIAN 1 dulu untuk melihat berapa yang akan berubah.
--  Backup sebelum menjalankan BAGIAN 2 & 3.
--
--  Dijalankan di database AR/signalbit_erp (yang memuat tbl_book_invoice).
-- ===========================================================================


-- ===========================================================================
--  BAGIAN 1 - PEMERIKSAAN AWAL (cuma SELECT, jalankan dulu)
--
--  "akan_diisi" = baris SJ yang invno-nya masih kosong & akan terisi.
--  "sudah_terisi" = sudah ada isinya, sengaja TIDAK disentuh.
-- ===========================================================================
SELECT 'garment (lewat id)' AS sasaran,
       COUNT(*)                                             AS baris_sj,
       SUM(IFNULL(p.invno, '') = '')                        AS akan_diisi,
       SUM(IFNULL(p.invno, '') <> '' AND p.invno <> b.no_invoice) AS sudah_terisi_lain,
       SUM(p.invno = b.no_invoice)                          AS sudah_benar
  FROM tbl_book_invoice_exim_det d
  INNER JOIN tbl_book_invoice b ON b.id = d.id_book_invoice
  INNER JOIN bppb p             ON p.id = d.id_bppb
 WHERE UPPER(IFNULL(d.asal, '')) = 'NAG'
   AND UPPER(IFNULL(b.status, '')) NOT IN ('CANCEL', 'CANCELED', 'CANCELLED')

UNION ALL

SELECT 'knitting (lewat nomor SJ)',
       COUNT(*),
       SUM(IFNULL(p.invno, '') = ''),
       SUM(IFNULL(p.invno, '') <> '' AND p.invno <> b.no_invoice),
       SUM(p.invno = b.no_invoice)
  FROM tbl_book_invoice_exim_det d
  INNER JOIN tbl_book_invoice b ON b.id = d.id_book_invoice
  INNER JOIN bppb p             ON p.bppbno     = d.bppb_number
                                OR p.bppbno_int = d.bppb_number
 WHERE UPPER(IFNULL(d.asal, '')) = 'NAK'
   AND IFNULL(d.bppb_number, '') <> ''
   AND UPPER(IFNULL(b.status, '')) NOT IN ('CANCEL', 'CANCELED', 'CANCELLED');


-- Daftar rincinya - dipakai memeriksa beberapa baris sebelum dijalankan.
SELECT b.no_invoice, b.shipp, b.status, d.asal,
       d.bppb_number AS nomor_sj, p.id AS id_bppb, p.invno AS invno_sekarang
  FROM tbl_book_invoice_exim_det d
  INNER JOIN tbl_book_invoice b ON b.id = d.id_book_invoice
  INNER JOIN bppb p ON (UPPER(IFNULL(d.asal, '')) = 'NAG' AND p.id = d.id_bppb)
                    OR (UPPER(IFNULL(d.asal, '')) = 'NAK'
                        AND IFNULL(d.bppb_number, '') <> ''
                        AND (p.bppbno = d.bppb_number OR p.bppbno_int = d.bppb_number))
 WHERE UPPER(IFNULL(b.status, '')) NOT IN ('CANCEL', 'CANCELED', 'CANCELLED')
   AND IFNULL(p.invno, '') = ''
 ORDER BY b.no_invoice, d.asal, p.id
 LIMIT 50;


-- ===========================================================================
--  BAGIAN 2 - SJ GARMENT (bppb, dicocokkan lewat id)
-- ===========================================================================
UPDATE bppb p
 INNER JOIN tbl_book_invoice_exim_det d ON d.id_bppb = p.id
 INNER JOIN tbl_book_invoice b          ON b.id = d.id_book_invoice
   SET p.invno = b.no_invoice
 WHERE UPPER(IFNULL(d.asal, '')) = 'NAG'
   AND UPPER(IFNULL(b.status, '')) NOT IN ('CANCEL', 'CANCELED', 'CANCELLED')
   -- Yang sudah ada isinya tidak ditimpa.
   AND IFNULL(p.invno, '') = '';


-- ===========================================================================
--  BAGIAN 3 - SJ KNITTING (bppb, dicocokkan lewat NOMOR SJ-nya)
--
--  Nomornya bisa tersimpan di bppbno atau bppbno_int, jadi dua-duanya dicoba.
--  Nomor SJ cukup khas sehingga tidak mungkin mengenai baris lain.
-- ===========================================================================
UPDATE bppb p
 INNER JOIN tbl_book_invoice_exim_det d ON p.bppbno     = d.bppb_number
                                        OR p.bppbno_int = d.bppb_number
 INNER JOIN tbl_book_invoice b          ON b.id = d.id_book_invoice
   SET p.invno = b.no_invoice
 WHERE UPPER(IFNULL(d.asal, '')) = 'NAK'
   AND IFNULL(d.bppb_number, '') <> ''
   AND UPPER(IFNULL(b.status, '')) NOT IN ('CANCEL', 'CANCELED', 'CANCELLED')
   AND IFNULL(p.invno, '') = '';


-- Kalau ada SJ yang invno-nya sudah berisi nomor LAIN (lihat kolom
-- "sudah_terisi_lain" di BAGIAN 1) dan memang mau ditimpa, buang baris
--   AND IFNULL(p.invno, '') = ''
-- di BAGIAN 2 & 3. Periksa dulu daftarnya - nomor itu bisa saja benar.


-- ===========================================================================
--  BAGIAN 4 - SJ KNITTING DI DATABASE KNITTING (official_out_h)
--
--  Databasenya terpisah (PostgreSQL), jadi tidak bisa di-join dari sini.
--  Query di bawah MENGHASILKAN perintah UPDATE-nya: jalankan, salin seluruh
--  kolom hasilnya, lalu tempel & jalankan di database knitting.
--
--  PERIKSA DULU nama kolomnya di database knitting:
--
--    SELECT column_name FROM information_schema.columns
--     WHERE table_name = 'official_out_h' AND column_name ILIKE '%inv%';
--
--  Kalau namanya bukan "no_invoice", ganti di query bawah ini - dan samakan
--  juga dengan tetapan KOLOM_INVNO_NAK di InvoiceEximController.
-- ===========================================================================
SELECT CONCAT(
           'UPDATE official_out_h SET no_invoice = ''',
           REPLACE(b.no_invoice, '''', ''''''),
           ''' WHERE id = ', d.id_bppb,
           ' AND COALESCE(no_invoice, '''') = '''';'
       ) AS perintah_untuk_database_knitting
  FROM tbl_book_invoice_exim_det d
  INNER JOIN tbl_book_invoice b ON b.id = d.id_book_invoice
 WHERE UPPER(IFNULL(d.asal, '')) = 'NAK'
   AND UPPER(IFNULL(b.status, '')) NOT IN ('CANCEL', 'CANCELED', 'CANCELLED')
 GROUP BY d.id_bppb, b.no_invoice
 ORDER BY b.no_invoice;


-- ===========================================================================
--  BAGIAN 5 - PEMERIKSAAN HASIL (cuma SELECT)
--
--  "belum_terisi" harus 0. Kalau masih ada isinya, lihat daftar di BAGIAN 1 -
--  biasanya karena nomor SJ-nya tidak ketemu di bppb.
-- ===========================================================================
SELECT d.asal,
       COUNT(*)                        AS baris_sj,
       SUM(p.invno = b.no_invoice)     AS sudah_benar,
       SUM(IFNULL(p.invno, '') = '')   AS belum_terisi
  FROM tbl_book_invoice_exim_det d
  INNER JOIN tbl_book_invoice b ON b.id = d.id_book_invoice
  INNER JOIN bppb p ON (UPPER(IFNULL(d.asal, '')) = 'NAG' AND p.id = d.id_bppb)
                    OR (UPPER(IFNULL(d.asal, '')) = 'NAK'
                        AND IFNULL(d.bppb_number, '') <> ''
                        AND (p.bppbno = d.bppb_number OR p.bppbno_int = d.bppb_number))
 WHERE UPPER(IFNULL(b.status, '')) NOT IN ('CANCEL', 'CANCELED', 'CANCELLED')
 GROUP BY d.asal;


-- Baris NAK yang nomor SJ-nya TIDAK ketemu di bppb - perlu dilihat sendiri.
SELECT b.no_invoice, d.bppb_number AS nomor_sj_tidak_ketemu
  FROM tbl_book_invoice_exim_det d
  INNER JOIN tbl_book_invoice b ON b.id = d.id_book_invoice
 WHERE UPPER(IFNULL(d.asal, '')) = 'NAK'
   AND IFNULL(d.bppb_number, '') <> ''
   AND UPPER(IFNULL(b.status, '')) NOT IN ('CANCEL', 'CANCELED', 'CANCELLED')
   AND NOT EXISTS (SELECT 1 FROM bppb p
                    WHERE p.bppbno = d.bppb_number OR p.bppbno_int = d.bppb_number)
 GROUP BY b.no_invoice, d.bppb_number;


-- ===========================================================================
--  BAGIAN 6 - PEMERIKSAAN DI DATABASE KNITTING (dijalankan di PostgreSQL)
--
--  Berapa SJ knitting yang sudah bernomor invoice. Bandingkan jumlahnya dengan
--  banyaknya perintah yang dihasilkan BAGIAN 4.
-- ===========================================================================
-- SELECT COUNT(*) AS sudah_bernomor
--   FROM official_out_h
--  WHERE COALESCE(no_invoice, '') <> '';

