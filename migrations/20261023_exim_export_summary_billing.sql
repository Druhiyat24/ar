-- =====================================================================
-- Invoice EXIM Export knitting: nilai BILLING di baris Invoice Summary
--
-- LATARNYA
-- Knitting punya dua angka untuk SJ yang sama:
--   * KIRIM (shipment) - satuan & qty yang benar-benar dikirim. Ini yang
--     dipakai menu Invoice EXIM di layar maupun cetakannya.
--   * TAGIH (billing)  - satuan & qty yang ditagihkan ke customer. Ini
--     yang harus dipakai AR.
--
-- Baris SJ-nya sudah membawa keduanya (tbl_book_invoice_exim_det:
-- qty_tagih, unit_price_tagih, total_price_tagih sejak migrasi 20261008).
-- Baris Invoice Summary belum - isinya baru angka kirim, padahal baris
-- itulah yang ditarik AR waktu invoicenya dibuat.
--
-- Kolom di bawah menampung angka billing baris summary. Yang lama tidak
-- diubah sama sekali, jadi tampilan & cetakan EXIM tetap memakai angka
-- kirim seperti sekarang.
--
-- Kosong / nol berarti baris itu memang tidak punya angka billing
-- tersendiri (garment) - pemakainya jatuh ke angka kirim.
--
-- AMAN DIULANG - kolomnya ditambah kalau belum ada, dan pengisiannya
-- hanya menyentuh baris yang masih kosong.
--
-- CARA MEMUNDURKAN
--   ALTER TABLE tbl_book_invoice_exim_export_det
--     DROP COLUMN qty_invoiced_tagih, DROP COLUMN unit_tagih,
--     DROP COLUMN total_cm_tagih,     DROP COLUMN total_fob_tagih;
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. Kolomnya
-- ---------------------------------------------------------------------
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns
                          WHERE table_schema = DATABASE()
                            AND table_name = 'tbl_book_invoice_exim_export_det'
                            AND column_name = 'qty_invoiced_tagih'),
    'ALTER TABLE tbl_book_invoice_exim_export_det
       ADD COLUMN qty_invoiced_tagih DECIMAL(18,4) NOT NULL DEFAULT 0
       COMMENT ''qty billing baris ini - 0 berarti ikut qty kirim''
       AFTER qty_invoiced',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns
                          WHERE table_schema = DATABASE()
                            AND table_name = 'tbl_book_invoice_exim_export_det'
                            AND column_name = 'unit_tagih'),
    'ALTER TABLE tbl_book_invoice_exim_export_det
       ADD COLUMN unit_tagih VARCHAR(20) NULL DEFAULT NULL
       COMMENT ''satuan billing - kosong berarti ikut satuan kirim''
       AFTER qty_invoiced_tagih',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns
                          WHERE table_schema = DATABASE()
                            AND table_name = 'tbl_book_invoice_exim_export_det'
                            AND column_name = 'total_cm_tagih'),
    'ALTER TABLE tbl_book_invoice_exim_export_det
       ADD COLUMN total_cm_tagih DECIMAL(18,4) NOT NULL DEFAULT 0
       COMMENT ''total CM billing - 0 berarti ikut total CM kirim''
       AFTER total_cm',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns
                          WHERE table_schema = DATABASE()
                            AND table_name = 'tbl_book_invoice_exim_export_det'
                            AND column_name = 'total_fob_tagih'),
    'ALTER TABLE tbl_book_invoice_exim_export_det
       ADD COLUMN total_fob_tagih DECIMAL(18,4) NOT NULL DEFAULT 0
       COMMENT ''total FOB billing - 0 berarti ikut total FOB kirim''
       AFTER total_fob',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ---------------------------------------------------------------------
-- 2. Lihat dulu invoice mana yang akan terisi - belum mengubah apa pun
--    Hanya baris summary yang punya baris SJ knitting (qty_tagih > 0).
-- ---------------------------------------------------------------------
SELECT  b.no_invoice,
        s.urutan,
        s.color_name,
        s.qty_invoiced                      AS qty_kirim,
        ROUND(SUM(d.qty_tagih), 4)          AS qty_billing,
        s.total_cm                          AS total_cm_kirim,
        ROUND(SUM(d.total_price_tagih), 4)  AS total_cm_billing
FROM    tbl_book_invoice_exim_export_det AS s
JOIN    tbl_book_invoice                 AS b ON b.id = s.id_book_invoice
JOIN    tbl_book_invoice_exim_det        AS d
          ON d.id_book_invoice = s.id_book_invoice
         AND d.urutan_summary  = s.urutan
WHERE   IFNULL(d.qty_tagih, 0) > 0
GROUP BY b.no_invoice, s.id, s.urutan, s.color_name, s.qty_invoiced, s.total_cm
ORDER BY b.no_invoice, s.urutan;


-- ---------------------------------------------------------------------
-- 3. Isi nilai billing invoice yang sudah terbuat
--    Diambil dari baris SJ-nya sendiri, dikaitkan lewat urutan summary -
--    cara yang sama dengan yang dipakai waktu invoicenya disimpan.
--
--    Baris yang nilai billingnya sudah terisi tidak disentuh, jadi skrip
--    ini aman dijalankan ulang dan tidak menimpa koreksi manual.
-- ---------------------------------------------------------------------
UPDATE  tbl_book_invoice_exim_export_det AS s
JOIN    (SELECT d.id_book_invoice,
                d.urutan_summary,
                ROUND(SUM(d.qty_tagih), 4)         AS qty_tagih,
                ROUND(SUM(d.total_price_tagih), 4) AS total_tagih,
                MIN(NULLIF(TRIM(d.uom_tagih), ''))  AS uom_tagih
           FROM tbl_book_invoice_exim_det AS d
          WHERE IFNULL(d.qty_tagih, 0) > 0
            AND d.urutan_summary IS NOT NULL
          GROUP BY d.id_book_invoice, d.urutan_summary) AS t
          ON t.id_book_invoice = s.id_book_invoice
         AND t.urutan_summary  = s.urutan
SET     s.qty_invoiced_tagih = t.qty_tagih,
        s.unit_tagih         = t.uom_tagih,
        s.total_cm_tagih     = t.total_tagih,
        -- FOB billing mengikuti perbandingan FOB : CM yang sudah ada di
        -- baris itu. Kalau CM kirimnya nol, perbandingannya tidak bisa
        -- dihitung - FOB billing disamakan dengan CM billing.
        s.total_fob_tagih    = CASE
                                   WHEN IFNULL(s.total_cm, 0) <> 0
                                       THEN ROUND(t.total_tagih * (IFNULL(s.total_fob, 0) / s.total_cm), 4)
                                   ELSE t.total_tagih
                               END
WHERE   IFNULL(s.qty_invoiced_tagih, 0) = 0;


-- ---------------------------------------------------------------------
-- 4. Periksa hasilnya
-- ---------------------------------------------------------------------

-- 4a. Berapa baris summary yang sekarang punya nilai billing.
SELECT COUNT(*) AS baris_summary_dengan_billing
  FROM tbl_book_invoice_exim_export_det
 WHERE IFNULL(qty_invoiced_tagih, 0) > 0;

-- 4b. Masih ada baris SJ knitting yang baris summary-nya belum terisi?
--     Hasilnya harus kosong.
SELECT  b.no_invoice, d.urutan_summary, ROUND(SUM(d.qty_tagih), 4) AS qty_billing
FROM    tbl_book_invoice_exim_det AS d
JOIN    tbl_book_invoice          AS b ON b.id = d.id_book_invoice
JOIN    tbl_book_invoice_exim_export_det AS s
          ON s.id_book_invoice = d.id_book_invoice
         AND s.urutan          = d.urutan_summary
WHERE   IFNULL(d.qty_tagih, 0) > 0
  AND   IFNULL(s.qty_invoiced_tagih, 0) = 0
GROUP BY b.no_invoice, d.urutan_summary
ORDER BY b.no_invoice, d.urutan_summary;
