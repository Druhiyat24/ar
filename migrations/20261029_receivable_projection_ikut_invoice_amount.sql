-- =====================================================================
-- Receivable Amount di History Projection Report - disamakan dengan
-- rumus baru, yaitu dikunci ke kolom Invoice Amount.
--
-- MASALAHNYA
--   Dokumen history yang disimpan dengan rumus lama memajang Receivable
--   Amount yang tidak nyambung ke Invoice Amount-nya:
--
--     a. Invoice NAG   -> yang tersimpan nilai PENUH invoice, padahal
--                         Invoice Amount-nya sudah berkurang kena alokasi.
--     b. Invoice NAK   -> yang terbaca baris potongan yang nyangkut di
--        (knitting)      tbl_invoice_pot, bukan tbl_invoice_pot_knitting.
--                         Nilainya bisa jauh berbeda; contoh invoice
--                         0074/L/NAK/0726: 30,91 USD vs 9,53 USD yang benar.
--
-- RUMUS BARUNYA (sama persis dengan Model_report::_attach_receivable_breakdown)
--     Total Invoice = amount x rate
--     VAT           = Total Invoice x (vat / grand_total)
--     Tax Base      = Total Invoice - VAT
--     PPh 23        = Tax Base x mtax.percentage / 100
--     Collection    = Total Invoice - PPh 23
--
-- YANG TIDAK BERUBAH
--   Kolom tanggal (Projected Cash Inflow) dan Total Collection Amount di
--   daftar History dihitung dari RASIO collection/total_invoice, bukan dari
--   nilainya. Rasionya tidak bergeser - sudah diuji ke seluruh 3.074 baris
--   history, selisih terbesarnya 0,0000004. Jadi angka proyeksi kasnya tetap
--   sama persis; yang berubah hanya lima kolom tampilan.
--
-- CARA MENJALANKAN - BERURUTAN, JANGAN DILOMPAT
--   Langkah 1 & 2 cuma melihat, aman dijalankan kapan saja.
--   Langkah 3 baru mengubah data, dan ada cadangannya.
-- =====================================================================


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu berapa baris yang akan berubah
-- ---------------------------------------------------------------------
SELECT h.doc_number,
       DATE(h.created_at)                                  AS disimpan,
       h.periode_dari, h.periode_sampai, h.type,
       COUNT(*)                                            AS baris,
       SUM(ABS(d.total_invoice - d.amount * d.rate) > 1)   AS akan_berubah
FROM   tbl_history_projection_h   h
JOIN   tbl_history_projection_det d ON d.doc_number = h.doc_number
GROUP  BY h.doc_number
HAVING akan_berubah > 0
ORDER  BY h.created_at;


-- ---------------------------------------------------------------------
-- LANGKAH 2 - lihat angka sebelum & sesudahnya, sebelum diubah
--             (ganti nomor dokumennya sesuai hasil langkah 1)
-- ---------------------------------------------------------------------
SELECT d.no_invoice, d.curr, d.amount, d.rate,
       d.total_invoice                      AS total_sekarang,
       ROUND(d.amount * d.rate, 2)          AS total_seharusnya,
       d.tax_base                           AS tax_base_sekarang,
       ROUND(d.amount * d.rate
             - ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2), 2)
                                            AS tax_base_seharusnya
FROM   tbl_history_projection_det d
LEFT   JOIN (
        SELECT bi.no_invoice, pk.vat, pk.grand_total AS gt, bi.id_pph
        FROM   tbl_book_invoice bi
        JOIN   tbl_invoice_pot_knitting pk ON pk.id_book_invoice = bi.id
        WHERE  bi.profit_center = 'NAK'
        UNION ALL
        SELECT bi.no_invoice, p.vat, p.grand_total, bi.id_pph
        FROM   tbl_book_invoice bi
        JOIN   tbl_invoice_pot p ON p.id_book_invoice = bi.id
        WHERE  bi.profit_center <> 'NAK'
        UNION ALL
        SELECT nb.no_inv, np.vat, np.grand_total, nb.id_pph
        FROM   tbl_invoice_nb nb
        JOIN   tbl_invoice_nb_pot np ON np.no_inv = nb.no_inv
       ) c ON c.no_invoice = d.no_invoice
WHERE  d.doc_number = 'PR/0926/00001'
AND    ABS(d.total_invoice - d.amount * d.rate) > 1
ORDER  BY d.no_invoice;


-- ---------------------------------------------------------------------
-- LANGKAH 3 - cadangkan, lalu perbaiki
-- ---------------------------------------------------------------------

-- 3a. Cadangan. Kalau hasilnya tidak sesuai, datanya bisa dikembalikan dari
--     tabel ini. Dibuat sekali; kalau sudah ada, baris ini dilewati sendiri.
CREATE TABLE IF NOT EXISTS tbl_history_projection_det_sebelum_20261029
    LIKE tbl_history_projection_det;

INSERT IGNORE INTO tbl_history_projection_det_sebelum_20261029
SELECT * FROM tbl_history_projection_det;

-- 3b. Perbaikannya.
UPDATE tbl_history_projection_det d
LEFT   JOIN (
        SELECT bi.no_invoice, pk.vat, pk.grand_total AS gt, bi.id_pph
        FROM   tbl_book_invoice bi
        JOIN   tbl_invoice_pot_knitting pk ON pk.id_book_invoice = bi.id
        WHERE  bi.profit_center = 'NAK'
        UNION ALL
        SELECT bi.no_invoice, p.vat, p.grand_total, bi.id_pph
        FROM   tbl_book_invoice bi
        JOIN   tbl_invoice_pot p ON p.id_book_invoice = bi.id
        WHERE  bi.profit_center <> 'NAK'
        UNION ALL
        SELECT nb.no_inv, np.vat, np.grand_total, nb.id_pph
        FROM   tbl_invoice_nb nb
        JOIN   tbl_invoice_nb_pot np ON np.no_inv = nb.no_inv
       ) c ON c.no_invoice = d.no_invoice
LEFT   JOIN mtax m ON m.idtax = c.id_pph
SET    d.total_invoice     = ROUND(d.amount * d.rate, 2),
       d.tax_vat           = ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2),
       d.tax_base          = ROUND(d.amount * d.rate, 2)
                             - ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2),
       d.income_tax_23     = ROUND(
                               (ROUND(d.amount * d.rate, 2)
                                - ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2))
                               * COALESCE(m.percentage, 0) / 100, 2),
       d.collection_amount = ROUND(d.amount * d.rate, 2)
                             - ROUND(
                                 (ROUND(d.amount * d.rate, 2)
                                  - ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2))
                                 * COALESCE(m.percentage, 0) / 100, 2);


-- ---------------------------------------------------------------------
-- LANGKAH 4 - pemeriksaan sesudahnya. Ketiganya HARUS 0.
-- ---------------------------------------------------------------------
SELECT SUM(ABS(total_invoice - amount * rate) > 0.02)              AS total_tidak_pas,
       SUM(ABS((tax_base + tax_vat) - total_invoice) > 0.02)       AS dpp_ppn_tidak_pas,
       SUM(ABS(collection_amount - (total_invoice - income_tax_23)) > 0.02)
                                                                   AS collection_tidak_pas
FROM   tbl_history_projection_det;


-- Kalau hasilnya salah dan mau dikembalikan:
--   DELETE FROM tbl_history_projection_det;
--   INSERT INTO tbl_history_projection_det
--       SELECT * FROM tbl_history_projection_det_sebelum_20261029;
--
-- Kalau sudah yakin benar, cadangannya boleh dibuang:
--   DROP TABLE tbl_history_projection_det_sebelum_20261029;
