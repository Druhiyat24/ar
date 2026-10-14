-- ============================================================================
-- Invoice Export: penanda "Invoice Summary sudah dirapikan dari AR".
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Baris Invoice Summary (tbl_book_invoice_exim_export_det) disusun otomatis
-- per warna oleh menu Invoice EXIM. Untuk sebagian PO/style satu warna
-- terpecah jadi beberapa baris, dan sekarang tim AR boleh merapikannya
-- langsung dari layar Create / Edit Invoice Export di AR.
--
-- Kenapa perlu penanda: di cetakan, Extended Line Total biasanya diambil dari
-- JUMLAH NILAI BARIS SJ-nya, bukan dari qty x unit cost baris summary. Baris
-- SJ dikaitkan ke baris summary lewat NOMOR URUT (tbl_book_invoice_exim_det.
-- urutan_summary) - lihat migrations/20260917_invoice_exim_export.sql. Begitu
-- AR menggabung atau memecah baris, nomor urut itu tidak lagi menunjuk warna
-- yang sama: nilai antar baris jadi tertukar.
--
-- Jadi sesudah summary-nya dirapikan dari AR, penanda ini dinyalakan dan
-- cetakan menghitung nilai tiap baris dari qty x unit cost baris itu sendiri.
-- Invoice yang tidak pernah disentuh AR tetap dicetak seperti semula.
--
-- Aman dijalankan kapan saja: kolomnya NOT NULL DEFAULT 0, jadi semua invoice
-- lama otomatis "belum dirapikan". Selama migrasi ini BELUM dijalankan
-- aplikasi tetap berjalan - kolomnya dilewati (lihat Model_nag::kolom_ada).
-- ============================================================================

-- 1) Cek dulu tabelnya:
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_h;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'tbl_book_invoice_exim_export_h') AND NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_book_invoice_exim_export_h' AND column_name = 'summary_ar'), 'ALTER TABLE tbl_book_invoice_exim_export_h ADD COLUMN summary_ar TINYINT(1) NOT NULL DEFAULT 0 COMMENT ''1 = baris Invoice Summary sudah dirapikan dari AR''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2) Cek hasilnya - kolomnya harus muncul dan semuanya masih 0:
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_h;
--      SELECT summary_ar, COUNT(*) FROM tbl_book_invoice_exim_export_h GROUP BY summary_ar;
--
--    Dan pastikan tabel lain TIDAK ikut berubah:
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_det;
--      SHOW COLUMNS FROM tbl_book_invoice_exim_det;

-- ----------------------------------------------------------------------------
-- ROLLBACK:
--   ALTER TABLE tbl_book_invoice_exim_export_h DROP COLUMN summary_ar;
-- ----------------------------------------------------------------------------
