-- =====================================================================
-- Kembalikan Receivable Amount history SELAIN PR/0926/00001.
--
-- 20261029_receivable_projection_ikut_invoice_amount.sql menulis ulang
-- SELURUH isi tbl_history_projection_det (UPDATE-nya tanpa WHERE). Yang
-- diminta cuma satu dokumen: PR/0926/00001. Berkas ini mengembalikan
-- dokumen yang lain ke nilai aslinya dari tabel cadangan.
--
-- SYARAT: tbl_history_projection_det_sebelum_20261029 masih ada. Itu
-- cadangan yang dibuat langkah 3a berkas sebelumnya - JANGAN di-DROP
-- sebelum berkas ini dijalankan dan diperiksa.
--
-- AKIBATNYA, supaya tidak kaget: dokumen selain PR/0926/00001 kembali
-- memajang Receivable Amount yang tidak nyambung ke Invoice Amount-nya -
-- nilai penuh invoice untuk baris NAG, dan baris potongan yang ketuker
-- untuk baris knitting. Itu memang isi aslinya waktu dokumen disimpan.
-- Dokumen BARU yang disimpan mulai sekarang tetap memakai rumus baru,
-- karena yang diperbaiki di kodenya tidak ikut dikembalikan.
-- =====================================================================


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu: berapa baris per dokumen yang akan dikembalikan
-- ---------------------------------------------------------------------
SELECT d.doc_number,
       COUNT(*)                                            AS baris,
       SUM(ABS(d.total_invoice - s.total_invoice) > 0.02)  AS akan_dikembalikan
FROM   tbl_history_projection_det d
JOIN   tbl_history_projection_det_sebelum_20261029 s ON s.id = d.id
WHERE  d.doc_number <> 'PR/0926/00001'
GROUP  BY d.doc_number
HAVING akan_dikembalikan > 0
ORDER  BY d.doc_number;


-- ---------------------------------------------------------------------
-- LANGKAH 2 - kembalikan. PR/0926/00001 sengaja dilewati.
-- ---------------------------------------------------------------------
UPDATE tbl_history_projection_det d
JOIN   tbl_history_projection_det_sebelum_20261029 s ON s.id = d.id
SET    d.tax_base          = s.tax_base,
       d.tax_vat           = s.tax_vat,
       d.total_invoice     = s.total_invoice,
       d.income_tax_23     = s.income_tax_23,
       d.collection_amount = s.collection_amount
WHERE  d.doc_number <> 'PR/0926/00001';


-- ---------------------------------------------------------------------
-- LANGKAH 3 - pemeriksaan. Yang boleh beda dari cadangan HANYA
--             PR/0926/00001; dokumen lain harus 0.
-- ---------------------------------------------------------------------
SELECT d.doc_number,
       SUM(ABS(d.total_invoice     - s.total_invoice)     > 0.02
         OR ABS(d.tax_base         - s.tax_base)          > 0.02
         OR ABS(d.tax_vat          - s.tax_vat)           > 0.02
         OR ABS(d.income_tax_23    - s.income_tax_23)     > 0.02
         OR ABS(d.collection_amount- s.collection_amount) > 0.02) AS beda_dari_cadangan
FROM   tbl_history_projection_det d
JOIN   tbl_history_projection_det_sebelum_20261029 s ON s.id = d.id
GROUP  BY d.doc_number
HAVING beda_dari_cadangan > 0
ORDER  BY d.doc_number;
-- Hasil yang benar: cuma satu baris, PR/0926/00001.


-- LANGKAH 4 - PR/0926/00001 sendiri harus tetap pas.
--             Ketiganya harus 0.
SELECT SUM(ABS(total_invoice - amount * rate) > 0.02)                      AS total_tidak_pas,
       SUM(ABS((tax_base + tax_vat) - total_invoice) > 0.02)               AS dpp_ppn_tidak_pas,
       SUM(ABS(collection_amount - (total_invoice - income_tax_23)) > 0.02) AS collection_tidak_pas
FROM   tbl_history_projection_det
WHERE  doc_number = 'PR/0926/00001';


-- Sesudah langkah 3 & 4 benar, cadangannya boleh dibuang:
--   DROP TABLE tbl_history_projection_det_sebelum_20261029;
