-- ============================================================================
-- Invoice EXIM: simpan PO konsumen di baris SJ.
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Kenapa perlu: cetakan invoice khusus knitting menampilkan kolom "PO" -
-- nomor PO milik konsumen, asalnya dari sales_orders.po_konsumen di database
-- knitting. Nilainya ikut disalin saat booking disimpan supaya cetakan tidak
-- perlu menembak database knitting lagi (dan tetap benar walaupun SO-nya
-- kemudian diubah).
--
-- Aman dijalankan kapan saja: kolomnya NULL-able, tanpa default, dan tidak
-- dipakai proses lain. Selama migrasi ini BELUM dijalankan, aplikasi tetap
-- berjalan - kolomnya dilewati saat menyimpan dan kolom PO di cetakan diisi
-- tanda "-".
-- ============================================================================

-- 1) Cek dulu tabelnya sudah ada (dibuat oleh 20260916_invoice_exim_booking.sql):
--      SHOW COLUMNS FROM tbl_book_invoice_exim_det;

ALTER TABLE tbl_book_invoice_exim_det
  ADD COLUMN po_konsumen VARCHAR(255) NULL DEFAULT NULL
      COMMENT 'NAK: sales_orders.po_konsumen - dipakai kolom PO di PDF knitting'
      AFTER so_number;

-- 2) Cek hasilnya - kolom po_konsumen harus muncul setelah so_number:
--      SHOW COLUMNS FROM tbl_book_invoice_exim_det;

-- ----------------------------------------------------------------------------
-- ROLLBACK:
--   ALTER TABLE tbl_book_invoice_exim_det DROP COLUMN po_konsumen;
-- ----------------------------------------------------------------------------
