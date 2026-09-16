-- ============================================================================
-- Debit Note: kolom Header 4 & Header 5 (menu create_debitnote)
-- Dijalankan MANUAL, sekali saja.
--
-- Aplikasi aman sebelum maupun sesudah file ini dijalankan:
-- Model_nag::simpandn_h() mengecek dulu kolomnya - selama header4/header5
-- belum ada, kedua field itu tidak ikut disimpan (data lain tetap tersimpan).
-- ============================================================================

-- 1) CEK DULU tipe kolom header yang sudah ada. Kalau tipe header3 berbeda
--    dengan yang dipakai di bawah, samakan tipe header4/header5 dengannya.
--
--      SHOW COLUMNS FROM tbl_debitnote_h        LIKE 'header%';
--      SHOW COLUMNS FROM tbl_debitnote_det      LIKE 'header%';
--      SHOW COLUMNS FROM tbl_debitnote_det_edit LIKE 'header%';
--
-- 2) tbl_debitnote_det_edit WAJIB ikut ditambah, dan kolom baru ditaruh di
--    PALING BELAKANG di kedua tabel (tanpa AFTER). Arnag::hapus_dn_det()
--    menyalin data lewat:
--      INSERT INTO tbl_debitnote_det_edit SELECT * FROM tbl_debitnote_det ...
--    jadi jumlah & urutan kolom kedua tabel harus tetap sama - kalau tidak,
--    proses edit Debit Note akan error.

-- Nama kolom (judul) Header 4/5 di header Debit Note
ALTER TABLE tbl_debitnote_h
  ADD COLUMN header4 VARCHAR(255) NULL DEFAULT NULL,
  ADD COLUMN header5 VARCHAR(255) NULL DEFAULT NULL;

-- Isi kolom Header 4/5 per baris detail
ALTER TABLE tbl_debitnote_det
  ADD COLUMN header4 TEXT NULL DEFAULT NULL,
  ADD COLUMN header5 TEXT NULL DEFAULT NULL;

-- Tabel salinan detail waktu edit (harus sama persis dengan tbl_debitnote_det)
ALTER TABLE tbl_debitnote_det_edit
  ADD COLUMN header4 TEXT NULL DEFAULT NULL,
  ADD COLUMN header5 TEXT NULL DEFAULT NULL;

-- 3) Cek hasilnya - header4 & header5 harus muncul di ketiga tabel:
--      SHOW COLUMNS FROM tbl_debitnote_h        LIKE 'header%';
--      SHOW COLUMNS FROM tbl_debitnote_det      LIKE 'header%';
--      SHOW COLUMNS FROM tbl_debitnote_det_edit LIKE 'header%';

-- ----------------------------------------------------------------------------
-- ROLLBACK (kalau perlu dibatalkan):
--   ALTER TABLE tbl_debitnote_h        DROP COLUMN header4, DROP COLUMN header5;
--   ALTER TABLE tbl_debitnote_det      DROP COLUMN header4, DROP COLUMN header5;
--   ALTER TABLE tbl_debitnote_det_edit DROP COLUMN header4, DROP COLUMN header5;
-- ----------------------------------------------------------------------------
