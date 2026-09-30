-- ============================================================================
-- Invoice EXIM Export: satuan "Total Pieces (Custom Units)" per baris
-- Invoice Summary - PCS atau SET.
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Kenapa perlu:
--   PCS -> Total Pieces otomatis sama dengan Qty Invoiced (jumlah FG/OUT).
--   SET -> Total Pieces WAJIB diketik user (jumlah set-nya).
--   Total (FOB) dihitung dari Total Pieces ini (Total Pieces x Unit Cost FOB),
--   bukan dari Qty Invoiced. Satuannya harus tersimpan supaya waktu invoice
--   dibuka lagi / dicetak, aplikasi tahu angka mana yang dipakai.
--
-- Baris lama (dibuat sebelum migrasi ini) nilainya NULL dan tetap dihitung
-- seperti dulu (Qty Invoiced x Unit Cost FOB), jadi cetakan lama tidak berubah.
--
-- Selama migrasi ini BELUM dijalankan, Save / Edit / Print Invoice Export
-- menampilkan pesan "Run migrations/20260921_invoice_exim_export_satuan.sql
-- first" - sama seperti migrasi Export sebelumnya.
-- ============================================================================

-- 1) Cek dulu tabelnya sudah ada (dibuat oleh 20260917_invoice_exim_export.sql):
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_det;

ALTER TABLE tbl_book_invoice_exim_export_det
  ADD COLUMN total_pieces_unit VARCHAR(10) NULL DEFAULT NULL
      COMMENT 'PCS = ikut Qty Invoiced, SET = diketik user, NULL = baris lama (FOB pakai Qty Invoiced)'
      AFTER total_pieces;

-- 2) Cek hasilnya - kolom total_pieces_unit harus muncul setelah total_pieces:
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_det;

-- ----------------------------------------------------------------------------
-- ROLLBACK:
--   ALTER TABLE tbl_book_invoice_exim_export_det DROP COLUMN total_pieces_unit;
-- ----------------------------------------------------------------------------
