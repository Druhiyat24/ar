-- ============================================================================
-- Invoice EXIM Local: kolom Invoice Date.
-- Dijalankan MANUAL, sekali saja, SETELAH 20260916_invoice_exim_booking.sql.
--
-- Sampai sekarang Invoice Local tidak punya tanggal sendiri: yang tampil di
-- daftar & cetakan adalah tgl_book_inv, yaitu kapan booking dibuat. Akibatnya
-- tanggal dokumen tidak bisa diatur tim EXIM, dan tidak ikut berubah waktu
-- invoice diedit.
--
-- Kolomnya ditaruh di tbl_book_invoice_exim_pot karena tabel itu memang satu
-- baris per invoice EXIM dan sudah dipakai Local. Tidak memakai
-- tbl_book_invoice.tgl_inv: kolom itu milik alur AR - diisi waktu invoice
-- di-POST dan dikosongkan lagi kalau dikembalikan ke DRAFT.
--
-- Invoice Export tidak ikut: tanggalnya sudah ada di
-- tbl_book_invoice_exim_export_h.tgl_invoice, satu tempat dengan pihak-pihak
-- dan penutup dokumen yang juga cuma dipakai cetakan export.
-- ============================================================================

ALTER TABLE tbl_book_invoice_exim_pot
  ADD COLUMN tgl_invoice DATE NULL DEFAULT NULL
      COMMENT 'Invoice Date yang diisi di form Invoice Local - bukan tbl_book_invoice.tgl_inv'
      AFTER no_invoice;


-- CEK hasilnya:
--   SHOW COLUMNS FROM tbl_book_invoice_exim_pot LIKE 'tgl_invoice';

-- ----------------------------------------------------------------------------
-- ROLLBACK:
--   ALTER TABLE tbl_book_invoice_exim_pot DROP COLUMN tgl_invoice;
-- ----------------------------------------------------------------------------
