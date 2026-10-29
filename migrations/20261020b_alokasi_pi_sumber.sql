-- ================================================================================
-- Alokasi Proforma Invoice: dari kotak mana PI-nya dipanggil
-- 20 Oktober 2026
--
-- Di layar Create Invoice, PI sekarang dipanggil lewat DUA kotak:
--   Proforma Invoice        - PI yang SO-nya ikut ditagih invoice itu,
--   Other Proforma Invoice  - seluruh PI yang masih outstanding, tanpa filter
--                             SO maupun customer.
--
-- Kotak kedua sengaja longgar supaya PI lama tetap bisa dipakai, jadi di
-- catatan alokasinya harus kelihatan yang mana dipanggil dari kotak mana.
-- Kolom `sumber` itu penandanya: 'PI' atau 'OTHER'.
--
-- Jalankan sekali di database AR. AMAN DIULANG - kolomnya cuma ditambah kalau
-- memang belum ada, dan baris lama diisi 'PI' sekali saja (waktu dibuat,
-- semuanya memang lewat kotak yang sekarang jadi kotak atas).
-- ================================================================================


-- --------------------------------------------------------------------------------
-- 1. Kolom penandanya
-- --------------------------------------------------------------------------------
SET @ada := (SELECT COUNT(*) FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = 'tbl_invoice_proforma_alokasi'
                AND COLUMN_NAME = 'sumber');

SET @s := IF(@ada = 0,
  'ALTER TABLE tbl_invoice_proforma_alokasi ADD COLUMN sumber VARCHAR(10) NOT NULL DEFAULT ''PI'' COMMENT ''PI = kotak Proforma Invoice (SO-nya ikut ditagih), OTHER = kotak Other Proforma Invoice'' AFTER bagian',
  'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- --------------------------------------------------------------------------------
-- 2. Baris lama
--    Sebelum ada kotak kedua, semua alokasi datang dari kotak yang sekarang
--    jadi kotak atas - jadi diisi 'PI'. Yang sudah terisi tidak disentuh.
-- --------------------------------------------------------------------------------
UPDATE tbl_invoice_proforma_alokasi
   SET sumber = 'PI'
 WHERE sumber IS NULL OR TRIM(sumber) = '';


-- --------------------------------------------------------------------------------
-- 3. Periksa hasilnya
-- --------------------------------------------------------------------------------
SELECT sumber, COUNT(*) AS jumlah, IFNULL(SUM(amount), 0) AS total_dipakai
  FROM tbl_invoice_proforma_alokasi
 GROUP BY sumber;


-- ================================================================================
-- CARA MEMUNDURKAN
--   ALTER TABLE tbl_invoice_proforma_alokasi DROP COLUMN sumber;
-- ================================================================================
