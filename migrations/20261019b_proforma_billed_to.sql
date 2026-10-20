-- ================================================================================
-- Proforma Invoice: kolom Billed To
-- Dibuat 2026-10-19.
--
-- LATARNYA
-- Yang ditagih tidak selalu sama dengan customer pemilik SO - cetakan invoice
-- sudah memisahkan "Purchaser / Invoice To" dari "Ship To". Proforma Invoice
-- ikut membawa keterangan itu supaya cetakannya bisa menyebut siapa yang
-- ditagih.
--
-- Kosong berarti sama dengan customernya.
--
-- AMAN DIULANG - kolomnya ditambah kalau belum ada.
--
-- CARA MEMUNDURKAN
--   ALTER TABLE tbl_invoice_proforma DROP COLUMN billed_to;
-- ================================================================================


SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'billed_to'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN billed_to VARCHAR(20) NULL DEFAULT NULL COMMENT ''id customer yang ditagih - kosong berarti sama dengan customernya'' AFTER id_customer', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- --------------------------------------------------------------------------------
-- Periksa hasilnya - harus 1
-- --------------------------------------------------------------------------------
SELECT COUNT(*) AS kolom_billed_to
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND table_name = 'tbl_invoice_proforma'
   AND column_name = 'billed_to';
