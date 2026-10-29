-- =====================================================================
-- BERSIHKAN catatan pemakaian uang muka milik invoice yang sudah batal.
--
-- Gejalanya: di Create Invoice, kartu Others memajang Used Elsewhere yang
-- masih terisi padahal invoice yang memakainya sudah di-Cancel. Contoh
-- yang dilaporkan tim AR:
--
--   BM/BCA1979/NAG/1026/00001   value 100.000.000
--                               used elsewhere 16.015.135,14
--                               remaining       83.984.864,86
--
-- Sebabnya: Cancel Invoice mengembalikan bookingnya ke DRAFT dan menghapus
-- seluruh isi invoicenya (tbl_invoice_pot, tbl_invoice_detail), TAPI baris
-- di tbl_invoice_proforma_alokasi ikut tertinggal. Uang mukanya jadi
-- tertahan di invoice yang sudah tidak ada isinya dan tidak akan pernah
-- bisa dipakai lagi.
--
-- Programnya sudah diperbaiki: mulai sekarang Cancel Invoice dan Reverse
-- Invoice ikut menghapus barisnya (Arnag::_jalankan_cancel_invoice() dan
-- Arnag::rvs_invoice() memanggil Model_nag::lepas_alokasi_pi()), dan
-- penghitungan sisanya juga tidak lagi menghitung invoice berstatus
-- CANCEL. Berkas ini untuk baris yang TERLANJUR tertinggal sebelum
-- perbaikan itu dipasang.
--
-- Yang dianggap tertinggal ada dua macam:
--
--   (a) bookingnya berstatus CANCEL  - invoicenya dibatalkan dari layar
--       Booking Invoice;
--   (b) bookingnya DRAFT dan sama sekali tidak punya baris isi lagi
--       (tbl_invoice_detail maupun tbl_invoice_detail_knitting kosong)
--       - inilah bekas Cancel Invoice dari List Invoice.
--
-- Booking DRAFT yang MASIH punya baris isi TIDAK ikut dihapus: itu invoice
-- yang sedang dikerjakan, uang mukanya memang sedang dipakai.
--
-- CARA PAKAI: jalankan langkah 1, periksa hasilnya bersama tim AR, baru
-- jalankan langkah 2. Langkah 3 untuk memastikan hasilnya.
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. PERIKSA DULU - baris mana yang akan dihapus
--
--    Periksa kolom "alasan" dan "no_invoice": yang muncul di sini harus
--    benar-benar invoice yang sudah dibatalkan. Kalau ada satu saja yang
--    ternyata masih dipakai, JANGAN lanjut ke langkah 2 - laporkan dulu.
-- ---------------------------------------------------------------------
SELECT pa.id,
       pa.id_book_invoice,
       bi.no_invoice,
       IFNULL(bi.status, '(booking tidak ada)') AS status_booking,
       bi.tgl_inv,
       pa.no_proforma_invoice,
       pa.curr,
       pa.amount,
       CASE
           WHEN bi.id IS NULL THEN 'booking invoicenya sudah tidak ada'
           WHEN IFNULL(bi.status, '') LIKE 'CANCEL%' THEN 'booking dibatalkan'
           ELSE 'bekas Cancel Invoice - bookingnya kosong'
       END AS alasan
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE bi.id IS NULL
    OR IFNULL(bi.status, '') LIKE 'CANCEL%'
    OR (UPPER(IFNULL(bi.status, '')) = 'DRAFT'
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail AS d
                         WHERE d.id_book_invoice = bi.id)
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail_knitting AS dk
                         WHERE dk.id_book_invoice = bi.id))
 ORDER BY pa.no_proforma_invoice, pa.id;


-- ---------------------------------------------------------------------
--    Ringkasannya per uang muka - inilah angka yang akan berubah di
--    kolom Used Elsewhere / Remaining layar Create Invoice.
-- ---------------------------------------------------------------------
SELECT pa.no_proforma_invoice,
       pa.curr,
       COUNT(*)         AS baris,
       SUM(pa.amount)   AS akan_dilepas
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE bi.id IS NULL
    OR IFNULL(bi.status, '') LIKE 'CANCEL%'
    OR (UPPER(IFNULL(bi.status, '')) = 'DRAFT'
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail AS d
                         WHERE d.id_book_invoice = bi.id)
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail_knitting AS dk
                         WHERE dk.id_book_invoice = bi.id))
 GROUP BY pa.no_proforma_invoice, pa.curr
 ORDER BY pa.no_proforma_invoice;


-- ---------------------------------------------------------------------
-- 2. HAPUS barisnya
--
--    Baru jalankan kalau hasil langkah 1 sudah diperiksa.
--
--    Tidak perlu diarsipkan: riwayat pembatalan invoicenya sudah tercatat
--    di tbl_log, dan baris ini memang ditulis ulang tiap kali invoicenya
--    disimpan. Laporan Sub Ledger pun sudah tidak menghitungnya.
-- ---------------------------------------------------------------------
DELETE pa
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE bi.id IS NULL
    OR IFNULL(bi.status, '') LIKE 'CANCEL%'
    OR (UPPER(IFNULL(bi.status, '')) = 'DRAFT'
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail AS d
                         WHERE d.id_book_invoice = bi.id)
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail_knitting AS dk
                         WHERE dk.id_book_invoice = bi.id));


-- ---------------------------------------------------------------------
-- 3. PERIKSA HASILNYA - harus 0 baris
-- ---------------------------------------------------------------------
SELECT COUNT(*) AS sisa_yang_masih_nyangkut
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE bi.id IS NULL
    OR IFNULL(bi.status, '') LIKE 'CANCEL%'
    OR (UPPER(IFNULL(bi.status, '')) = 'DRAFT'
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail AS d
                         WHERE d.id_book_invoice = bi.id)
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail_knitting AS dk
                         WHERE dk.id_book_invoice = bi.id));


-- ---------------------------------------------------------------------
--    Dan inilah sisa uang muka BM yang dilaporkan tim AR. Sesudah
--    langkah 2, "terpakai" harus tinggal pemakaian invoice yang memang
--    masih hidup.
-- ---------------------------------------------------------------------
SELECT pa.no_proforma_invoice,
       pa.curr,
       SUM(pa.amount) AS terpakai,
       GROUP_CONCAT(DISTINCT bi.no_invoice ORDER BY bi.no_invoice
                    SEPARATOR ', ') AS dipakai_invoice
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE pa.no_proforma_invoice = 'BM/BCA1979/NAG/1026/00001'
 GROUP BY pa.no_proforma_invoice, pa.curr;
