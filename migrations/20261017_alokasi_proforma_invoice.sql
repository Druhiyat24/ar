-- ================================================================================
-- Create Invoice: Proforma Invoice dipakai memotong tagihan
-- Dibuat 2026-10-17.
--
-- LATARNYA
-- Proforma Invoice bertipe DP, CBD & PI NON SO dipanggil di layar Create
-- Invoice untuk memotong total tagihannya. Satu nomor PI boleh dipakai
-- berulang di beberapa invoice - tiap kali dipakai sebagiannya saja - jadi
-- pemakaiannya harus dicatat per invoice, bukan sekadar penanda "sudah
-- terpakai" di PI-nya.
--
-- Catatan ini juga yang nanti jadi sumber laporan alokasi PI: dari satu nomor
-- PI kelihatan dipakai di invoice mana saja dan berapa, serta sisanya.
--
-- AMAN DIULANG - tabelnya dibuat kalau belum ada, kolomnya ditambah kalau
-- belum ada.
--
-- CARA MEMUNDURKAN
--   DROP TABLE tbl_invoice_proforma_alokasi;
-- ================================================================================


CREATE TABLE IF NOT EXISTS tbl_invoice_proforma_alokasi (
    id INT NOT NULL AUTO_INCREMENT,
    id_book_invoice INT NOT NULL COMMENT 'invoice yang memakai',
    no_invoice VARCHAR(60) NULL COMMENT 'nomor invoicenya - memudahkan laporan',
    id_proforma INT NOT NULL COMMENT 'baris tbl_invoice_proforma yang dipakai',
    no_proforma_invoice VARCHAR(60) NOT NULL,
    type_pi VARCHAR(20) NULL COMMENT 'DP / CBD / PI NON SO',
    curr VARCHAR(10) NULL,
    nilai_pi DECIMAL(18,4) NOT NULL DEFAULT 0 COMMENT 'nilai PI yang boleh dipakai - nilai DP kalau ber-DP, selain itu totalnya',
    amount DECIMAL(18,4) NOT NULL DEFAULT 0 COMMENT 'yang dipakai invoice ini',
    bagian VARCHAR(10) NOT NULL DEFAULT 'ADVANCE' COMMENT 'DP = masuk Down Payment, ADVANCE = masuk Advance',
    created_by VARCHAR(100) NULL,
    created_at DATETIME NULL,
    PRIMARY KEY (id),
    KEY idx_alokasi_invoice (id_book_invoice),
    KEY idx_alokasi_pi (no_proforma_invoice)
) COMMENT 'Pemakaian Proforma Invoice (DP/CBD/PI NON SO) di tiap invoice';


-- --------------------------------------------------------------------------------
-- Periksa hasilnya
-- --------------------------------------------------------------------------------
SELECT COUNT(*) AS kolom_terpasang
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND table_name = 'tbl_invoice_proforma_alokasi';
