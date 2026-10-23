-- =====================================================================
-- URGENT - Cancel Invoice & Edit Invoice gagal (HTTP 500)
--
-- GEJALANYA
--   * Cancel Invoice: "Invoice ... was not cancelled. The server answered
--     with HTTP 500."
--   * Edit Invoice: Save berhenti di langkah "Clearing the previous rows
--     (HTTP 500)".
--
-- SEBABNYA
-- Kolom dp_cbd (Advance) ditambahkan ke tbl_invoice_pot dan
-- tbl_invoice_pot_knitting lewat migrasi 20261017b / paket 20261019.
-- Tabel ARSIP-nya tidak ikut ditambah, padahal:
--
--   * Cancel menyalin dengan  INSERT INTO tplog_batalinvoice_pot
--                             SELECT * FROM tbl_invoice_pot ...
--     Jumlah kolomnya beda -> MySQL menolak (error 1136).
--
--   * Edit menyalin per kolom ke tbl_invoice_pot_edit. Kolom dp_cbd tidak
--     ada di sana -> MySQL menolak (error 1054).
--
-- Dua-duanya berakhir sebagai HTTP 500, dan karena gagal di tengah,
-- tidak ada yang berubah - invoicenya aman.
--
-- Skrip ini menambahkan kolom yang kurang di tabel arsipnya. Tidak ada
-- data yang diubah.
--
-- AMAN DIULANG - kolomnya ditambah hanya kalau tabelnya ada dan kolomnya
-- memang belum ada.
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. Lihat dulu bedanya - belum mengubah apa pun
--    Hasilnya: kolom yang ada di tabel sumber tapi tidak ada di arsipnya.
--    Sesudah skrip ini dijalankan, hasilnya harus kosong.
-- ---------------------------------------------------------------------
SELECT  'tbl_invoice_pot -> tplog_batalinvoice_pot' AS pasangan, s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice_pot'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_pot_knitting -> tplog_batalinvoice_pot_knitting', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot_knitting'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice_pot_knitting'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_pot -> tbl_invoice_pot_edit', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tbl_invoice_pot_edit'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_detail -> tbl_invoice_detail_edit', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_detail'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tbl_invoice_detail_edit'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_detail -> tplog_batalinvoice_detail', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_detail'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice_detail'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_detail_knitting -> tplog_batalinvoice_detail_knitting', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_detail_knitting'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice_detail_knitting'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_book_invoice -> tplog_batalinvoice', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_book_invoice'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice'
                       AND a.column_name = s.column_name);


-- ---------------------------------------------------------------------
-- 2. Tambahkan kolom dp_cbd di tabel arsipnya
-- ---------------------------------------------------------------------

-- 2a. Arsip pembatalan - potongan garment
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables
                      WHERE table_schema = DATABASE() AND table_name = 'tplog_batalinvoice_pot')
             AND NOT EXISTS (SELECT 1 FROM information_schema.columns
                              WHERE table_schema = DATABASE()
                                AND table_name = 'tplog_batalinvoice_pot'
                                AND column_name = 'dp_cbd'),
    'ALTER TABLE tplog_batalinvoice_pot
       ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0
       COMMENT ''Advance - mengikuti tbl_invoice_pot'' AFTER dp',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2b. Arsip pembatalan - potongan knitting
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables
                      WHERE table_schema = DATABASE() AND table_name = 'tplog_batalinvoice_pot_knitting')
             AND NOT EXISTS (SELECT 1 FROM information_schema.columns
                              WHERE table_schema = DATABASE()
                                AND table_name = 'tplog_batalinvoice_pot_knitting'
                                AND column_name = 'dp_cbd'),
    'ALTER TABLE tplog_batalinvoice_pot_knitting
       ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0
       COMMENT ''Advance - mengikuti tbl_invoice_pot_knitting'' AFTER dp',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2c. Arsip saat Edit Invoice
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables
                      WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_pot_edit')
             AND NOT EXISTS (SELECT 1 FROM information_schema.columns
                              WHERE table_schema = DATABASE()
                                AND table_name = 'tbl_invoice_pot_edit'
                                AND column_name = 'dp_cbd'),
    'ALTER TABLE tbl_invoice_pot_edit
       ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0
       COMMENT ''Advance - mengikuti tbl_invoice_pot'' AFTER dp',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ---------------------------------------------------------------------
-- 3. Periksa hasilnya
--    Jalankan lagi query bagian 1 - hasilnya harus KOSONG.
--    Kalau masih ada baris yang keluar, kolom itu juga perlu ditambahkan
--    ke tabel arsipnya dengan cara yang sama seperti di bagian 2.
-- ---------------------------------------------------------------------
SELECT COUNT(*) AS kolom_arsip_yang_masih_kurang
  FROM (
    SELECT s.column_name
      FROM information_schema.columns s
     WHERE s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot'
       AND NOT EXISTS (SELECT 1 FROM information_schema.columns a
                        WHERE a.table_schema = DATABASE()
                          AND a.table_name IN ('tplog_batalinvoice_pot', 'tbl_invoice_pot_edit')
                          AND a.column_name = s.column_name
                          AND a.table_name = 'tplog_batalinvoice_pot')
    UNION ALL
    SELECT s.column_name
      FROM information_schema.columns s
     WHERE s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot'
       AND NOT EXISTS (SELECT 1 FROM information_schema.columns a
                        WHERE a.table_schema = DATABASE()
                          AND a.table_name = 'tbl_invoice_pot_edit'
                          AND a.column_name = s.column_name)
    UNION ALL
    SELECT s.column_name
      FROM information_schema.columns s
     WHERE s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot_knitting'
       AND NOT EXISTS (SELECT 1 FROM information_schema.columns a
                        WHERE a.table_schema = DATABASE()
                          AND a.table_name = 'tplog_batalinvoice_pot_knitting'
                          AND a.column_name = s.column_name)
  ) x;
