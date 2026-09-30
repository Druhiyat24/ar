-- ============================================================================
-- Debit Note: sumber baru "Invoice Export EXIM".
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Create Debit Note sebelumnya punya tiga sumber baris:
--   1. Manual          - Add Row, diketik sendiri
--   2. Memo EXIM       - Add Memo   (memo_h / memo_det)
--   3. Request DN      - No Request (req_dn_h)
-- Sekarang ditambah yang keempat: beberapa Invoice Export EXIM dipilih
-- sekaligus, tiap invoice jadi satu baris Debit Note berisi
-- Invoice Number, REFF, PO, Qty Inv, dan Price.
--
-- Kenapa perlu kolom baru: baris hasil pilihan itu harus tetap bisa
-- ditelusuri ke invoice asalnya - untuk menandai invoice mana saja yang sudah
-- pernah ditagih lewat Debit Note, dan supaya layar Edit bisa menampilkan
-- sumber DN-nya seperti "No Memo" / "No Request".
--
-- Nomor invoice ikut disimpan, bukan cuma id-nya. Debit Note itu dokumen yang
-- sudah beredar keluar: kalau invoice-nya kelak dihapus atau nomornya diubah,
-- baris DN lama tidak boleh ikut berubah.
--
-- Aman dijalankan kapan saja: kedua kolomnya NULL-able, tanpa default, dan
-- tidak dipakai proses lain. Selama migrasi ini BELUM dijalankan aplikasi
-- tetap berjalan - kolomnya dilewati saat menyimpan (lihat
-- Model_nag::buang_kolom_belum_ada) dan tombol "Add Invoice Export" di layar
-- Create Debit Note memberi tahu migrasi ini harus dijalankan dulu.
-- ============================================================================

-- 1) Cek dulu tabelnya:
--      SHOW COLUMNS FROM tbl_debitnote_det;

ALTER TABLE tbl_debitnote_det
  ADD COLUMN id_invoice_exim INT NULL DEFAULT NULL
      COMMENT 'tbl_book_invoice.id - invoice export EXIM asal baris ini'
      AFTER id_memo_det,
  ADD COLUMN no_invoice_exim VARCHAR(255) NULL DEFAULT NULL
      COMMENT 'nomor invoice-nya saat DN dibuat - sengaja disalin, bukan di-join'
      AFTER id_invoice_exim,
  ADD KEY idx_dn_det_inv_exim (id_invoice_exim);

-- 2) Cek hasilnya - kedua kolom harus muncul setelah id_memo_det:
--      SHOW COLUMNS FROM tbl_debitnote_det;
--
--    Dan pastikan tabel lain TIDAK ikut berubah:
--      SHOW COLUMNS FROM tbl_debitnote_h;
--      SHOW COLUMNS FROM tbl_book_invoice;
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_h;

-- ----------------------------------------------------------------------------
-- ROLLBACK:
--   ALTER TABLE tbl_debitnote_det
--     DROP KEY idx_dn_det_inv_exim,
--     DROP COLUMN no_invoice_exim,
--     DROP COLUMN id_invoice_exim;
-- ----------------------------------------------------------------------------
