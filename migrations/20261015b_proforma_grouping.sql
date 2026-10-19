-- ============================================================================
-- Proforma Invoice: baris SO-nya dikelompokkan sesuai pilihan user.
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Sebelum ini barisnya SELALU per warna + size (satu baris per so_det), dan
-- cetakannya punya dua versi - Summary & Detail. Sekarang user yang memilih
-- bentuk barisnya waktu memilih SO:
--
--   PRODUCT             satu baris per produk
--   PRODUCT_COLOR       dipecah per warna
--   PRODUCT_SIZE        dipecah per size
--   PRODUCT_COLOR_SIZE  dipecah per warna & size (bentuk lama)
--
-- Harga SELALU ikut jadi penentu: dua harga tidak pernah digabung, apa pun
-- pilihan pengelompokannya.
--
-- Yang disimpan adalah baris yang DILIHAT user - jadi cetakannya tinggal
-- mencetak apa adanya, dan cukup satu PDF.
--
-- Dua hal yang perlu kolom baru:
--   1. grouping        - pilihan user, supaya cetakan & layar Edit tahu
--                        bentuk barisnya;
--   2. id_so_det_list  - daftar id so_det yang diwakili satu baris. Dipakai
--                        waktu menandai SO terpakai (so_det.no_pi): satu baris
--                        bisa mewakili puluhan so_det, dan semuanya harus
--                        ikut ditandai.
--
-- Aman dijalankan berulang: kolomnya ditambah hanya kalau memang belum ada,
-- dan baris lama tetap terbaca (kolomnya NULL = bentuk lama, per warna & size).
-- ============================================================================

-- 1) Cek dulu:
--      SHOW COLUMNS FROM tbl_invoice_proforma LIKE 'grouping';
--      SHOW COLUMNS FROM tbl_so_det_proforma_temp LIKE 'id_so_det_list';

-- Pilihan pengelompokan - Proforma Invoice biasa.
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'grouping'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN grouping VARCHAR(20) NULL DEFAULT NULL COMMENT ''bentuk baris SO: PRODUCT, PRODUCT_COLOR, PRODUCT_SIZE, PRODUCT_COLOR_SIZE''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Pilihan pengelompokan - Proforma DP & CBD.
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_dp_cbd' AND column_name = 'grouping'), 'ALTER TABLE tbl_invoice_proforma_dp_cbd ADD COLUMN grouping VARCHAR(20) NULL DEFAULT NULL COMMENT ''bentuk baris SO: PRODUCT, PRODUCT_COLOR, PRODUCT_SIZE, PRODUCT_COLOR_SIZE''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Tabel sementara per baris tampil.
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_so_det_proforma_temp' AND column_name = 'id_so_det_list'), 'ALTER TABLE tbl_so_det_proforma_temp ADD COLUMN id_so_det_list TEXT NULL DEFAULT NULL COMMENT ''id so_det yang diwakili baris ini, dipisah koma''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Detail PI - satu baris bisa mewakili banyak so_det.
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so' AND column_name = 'id_so_det_list'), 'ALTER TABLE tbl_invoice_proforma_detail_so ADD COLUMN id_so_det_list TEXT NULL DEFAULT NULL COMMENT ''id so_det yang diwakili baris ini, dipisah koma''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Detail PI DP/CBD - idem.
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so_dp_cbd' AND column_name = 'id_so_det_list'), 'ALTER TABLE tbl_invoice_proforma_detail_so_dp_cbd ADD COLUMN id_so_det_list TEXT NULL DEFAULT NULL COMMENT ''id so_det yang diwakili baris ini, dipisah koma''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Jenis proformanya - Proforma Invoice biasa.
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'type_pi'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN type_pi VARCHAR(20) NULL DEFAULT NULL COMMENT ''jenis proforma: PI, PI NON SO, DP, CBD''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Jenis proformanya - Proforma DP & CBD.
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_dp_cbd' AND column_name = 'type_pi'), 'ALTER TABLE tbl_invoice_proforma_dp_cbd ADD COLUMN type_pi VARCHAR(20) NULL DEFAULT NULL COMMENT ''jenis proforma: PI, PI NON SO, DP, CBD''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2) Cek hasilnya:
--      SELECT table_name, column_name, column_type
--        FROM information_schema.columns
--       WHERE table_schema = DATABASE()
--         AND column_name IN ('grouping', 'id_so_det_list', 'type_pi')
--       ORDER BY table_name;
--
-- 3) Proforma lama tidak perlu diapa-apakan: grouping NULL dibaca sebagai
--    PRODUCT_COLOR_SIZE (bentuk lama), dan barisnya memang sudah tersimpan
--    per warna & size.

-- ----------------------------------------------------------------------------
-- ROLLBACK:
--   ALTER TABLE tbl_invoice_proforma DROP COLUMN grouping, DROP COLUMN type_pi;
--   ALTER TABLE tbl_invoice_proforma_dp_cbd DROP COLUMN grouping, DROP COLUMN type_pi;
--   ALTER TABLE tbl_so_det_proforma_temp DROP COLUMN id_so_det_list;
--   ALTER TABLE tbl_invoice_proforma_detail_so DROP COLUMN id_so_det_list;
--   ALTER TABLE tbl_invoice_proforma_detail_so_dp_cbd DROP COLUMN id_so_det_list;
--   Catatan: tanpa kolomnya, kodenya kembali ke bentuk lama (per warna & size)
--   dan penandaan SO memakai id baris pertama saja.
-- ----------------------------------------------------------------------------
