-- ================================================================================
-- Kwitansi: Debit Note ikut bisa ditarik
-- 20 Oktober 2026
--
-- Sebelumnya Create Kwitansi hanya bisa menarik invoice (tbl_book_invoice dan
-- tbl_invoice_nb). Sekarang Debit Note juga bisa, dan satu kwitansi boleh
-- berisi campuran beberapa invoice + beberapa DN.
--
-- Yang ditambahkan:
--   1. tbl_debitnote_h.no_kwt   - penanda DN sudah masuk kwitansi, supaya
--                                 tidak bisa ditarik dua kali. Caranya sama
--                                 persis dengan tbl_book_invoice.no_kwt dan
--                                 tbl_invoice_nb.no_kwt yang sudah ada.
--   2. tbl_kwitansi_detail.sumber - 'INV' atau 'DN', dipakai layar & cetakan
--                                 untuk tahu baris itu invoice atau DN.
--   3. tbl_kwt_temp.sumber      - sama, untuk tabel sementara waktu memilih.
--
-- Jalankan sekali di database AR, sesudah kodenya diperbarui.
--
-- AMAN DIULANG: tiap ALTER diperiksa dulu, kolom yang sudah ada dilewati.
-- Selama berkas ini BELUM dijalankan, aplikasi tetap jalan seperti biasa -
-- kwitansi tetap bisa dibuat dari invoice, hanya bagian Debit Note-nya yang
-- belum muncul (lihat Model_nag::kwt_dn_siap).
-- ================================================================================

-- --------------------------------------------------------------------------------
-- 1. Penanda DN sudah dipakai di kwitansi
-- --------------------------------------------------------------------------------
SET @ada := (SELECT COUNT(*) FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME   = 'tbl_debitnote_h'
                AND COLUMN_NAME  = 'no_kwt');
SET @sql := IF(@ada = 0,
  'ALTER TABLE tbl_debitnote_h
     ADD COLUMN no_kwt VARCHAR(100) NULL DEFAULT NULL
         COMMENT ''nomor kwitansi yang memakai DN ini - kosong berarti belum ditarik'',
     ADD KEY idx_dn_h_no_kwt (no_kwt)',
  'SELECT ''tbl_debitnote_h.no_kwt sudah ada - dilewati''');
PREPARE jalan FROM @sql; EXECUTE jalan; DEALLOCATE PREPARE jalan;

-- --------------------------------------------------------------------------------
-- 2. Asal baris kwitansi: invoice atau debit note
--    Baris lama dibiarkan NULL dan dibaca sebagai 'INV' oleh aplikasinya -
--    semua kwitansi lama memang isinya invoice.
-- --------------------------------------------------------------------------------
SET @ada := (SELECT COUNT(*) FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME   = 'tbl_kwitansi_detail'
                AND COLUMN_NAME  = 'sumber');
SET @sql := IF(@ada = 0,
  'ALTER TABLE tbl_kwitansi_detail
     ADD COLUMN sumber VARCHAR(10) NULL DEFAULT NULL
         COMMENT ''INV = invoice, DN = debit note. NULL (baris lama) dibaca INV''',
  'SELECT ''tbl_kwitansi_detail.sumber sudah ada - dilewati''');
PREPARE jalan FROM @sql; EXECUTE jalan; DEALLOCATE PREPARE jalan;

-- --------------------------------------------------------------------------------
-- 3. Tabel sementara waktu memilih di layar Create Kwitansi
-- --------------------------------------------------------------------------------
SET @ada := (SELECT COUNT(*) FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME   = 'tbl_kwt_temp'
                AND COLUMN_NAME  = 'sumber');
SET @sql := IF(@ada = 0,
  'ALTER TABLE tbl_kwt_temp
     ADD COLUMN sumber VARCHAR(10) NULL DEFAULT NULL
         COMMENT ''INV = invoice, DN = debit note''',
  'SELECT ''tbl_kwt_temp.sumber sudah ada - dilewati''');
PREPARE jalan FROM @sql; EXECUTE jalan; DEALLOCATE PREPARE jalan;

-- --------------------------------------------------------------------------------
-- 4. Cek hasilnya - ketiganya harus muncul:
--      SHOW COLUMNS FROM tbl_debitnote_h      LIKE 'no_kwt';
--      SHOW COLUMNS FROM tbl_kwitansi_detail  LIKE 'sumber';
--      SHOW COLUMNS FROM tbl_kwt_temp         LIKE 'sumber';
-- --------------------------------------------------------------------------------

-- ================================================================================
-- ROLLBACK (kwitansi yang sudah berisi DN akan kehilangan penandanya):
--   ALTER TABLE tbl_debitnote_h     DROP KEY idx_dn_h_no_kwt, DROP COLUMN no_kwt;
--   ALTER TABLE tbl_kwitansi_detail DROP COLUMN sumber;
--   ALTER TABLE tbl_kwt_temp        DROP COLUMN sumber;
-- ================================================================================
