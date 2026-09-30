-- ============================================================================
-- Invoice EXIM Export: kolom Invoice Date di header export.
-- Dijalankan MANUAL, sekali saja, SETELAH 20260917_invoice_exim_export.sql.
--
-- Kenapa tidak memakai tbl_book_invoice.tgl_inv:
-- kolom itu milik alur AR. AR mengisinya waktu invoice di-POST
-- (update_status_invoice), dan MENGOSONGKANNYA lagi saat invoice dikembalikan
-- ke DRAFT. Kalau tanggal dari form Export ditaruh di sana, tanggalnya bisa
-- hilang atau tertimpa tanpa ketahuan. Jadi disimpan di header export sendiri.
-- ============================================================================

ALTER TABLE tbl_book_invoice_exim_export_h
  ADD COLUMN tgl_invoice DATE NULL DEFAULT NULL
      COMMENT 'Invoice Date yang diisi di form Export - bukan tbl_book_invoice.tgl_inv'
      AFTER no_invoice_2;


-- CEK hasilnya:
--   SHOW COLUMNS FROM tbl_book_invoice_exim_export_h LIKE 'tgl_invoice';

-- ----------------------------------------------------------------------------
-- ROLLBACK:
--   ALTER TABLE tbl_book_invoice_exim_export_h DROP COLUMN tgl_invoice;
-- ----------------------------------------------------------------------------
