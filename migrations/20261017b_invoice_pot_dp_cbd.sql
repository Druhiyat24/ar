-- ================================================================================
-- Invoice: kolom Advance (DP/CBD from Invoice) di tabel potongan
-- Dibuat 2026-10-17.
--
-- LATARNYA
-- Layar Create Invoice punya dua potongan uang muka: Down Payment dan Advance
-- (dulu bernama "DP/CBD from Invoice"). Yang pertama tersimpan di kolom dp,
-- yang kedua TIDAK PERNAH tersimpan - kolomnya memang belum ada di
-- tbl_invoice_pot. Akibatnya Grand Total yang tersimpan sudah dikurangi
-- Advance, tapi potongannya sendiri tidak tercatat di mana pun, dan jurnalnya
-- tidak mungkin seimbang.
--
-- Sekarang Advance datang dari Proforma Invoice (DP/CBD/PI NON SO) yang
-- dipanggil di layar itu, jadi kolomnya diperlukan.
--
-- AMAN DIULANG - kolomnya ditambah kalau belum ada.
--
-- CARA MEMUNDURKAN
--   ALTER TABLE tbl_invoice_pot DROP COLUMN dp_cbd;
--   ALTER TABLE tbl_invoice_pot_knitting DROP COLUMN dp_cbd;
-- ================================================================================


SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_pot' AND column_name = 'dp_cbd'), 'ALTER TABLE tbl_invoice_pot ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0 COMMENT ''Advance - uang muka dari Proforma Invoice CBD/PI NON SO'' AFTER dp', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_pot_knitting') AND NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_pot_knitting' AND column_name = 'dp_cbd'), 'ALTER TABLE tbl_invoice_pot_knitting ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0 COMMENT ''Advance - uang muka dari Proforma Invoice CBD/PI NON SO'' AFTER dp', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- --------------------------------------------------------------------------------
-- Periksa hasilnya - keduanya harus 1
-- --------------------------------------------------------------------------------
SELECT table_name, COUNT(*) AS kolom_dp_cbd
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND table_name IN ('tbl_invoice_pot', 'tbl_invoice_pot_knitting')
   AND column_name = 'dp_cbd'
 GROUP BY table_name;
