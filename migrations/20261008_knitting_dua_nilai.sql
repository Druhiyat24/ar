-- ===========================================================================
--  INVOICE EXIM KNITTING: DUA NILAI (TAGIH & KIRIM)
-- ===========================================================================
--  Invoice knitting memang punya DUA angka, seperti layar knitting AR lama:
--  kolom "Total Price" & "Total Price Shipment" di tabel detailnya, lalu dua
--  kartu ringkasan "Total" dan "Total Shipment".
--
--  Di Invoice EXIM, kolom yang SUDAH ADA (uom/qty/unit_price/total_price)
--  berisi nilai KIRIM - itu yang dipakai sejak penyesuaian satuan SO, dan
--  invoice yang sudah tersimpan memakai angka itu. Kolom baru di bawah ini
--  menampung nilai TAGIH-nya, jadi tidak ada satu pun invoice lama yang
--  berubah nilainya.
--
--  Dijalankan di database signalbit_erp.
--  AMAN DIJALANKAN BERULANG - tiap bagian diperiksa dulu.
-- ===========================================================================


-- ===========================================================================
--  BAGIAN 1 - KOLOM NILAI TAGIH DI BARIS SJ
-- ===========================================================================
SET @s := IF((SELECT COUNT(*) FROM information_schema.tables
               WHERE table_schema = DATABASE()
                 AND table_name = 'tbl_book_invoice_exim_det') > 0
          AND (SELECT COUNT(*) FROM information_schema.columns
                WHERE table_schema = DATABASE()
                  AND table_name = 'tbl_book_invoice_exim_det'
                  AND column_name = 'uom_tagih') = 0,
    'ALTER TABLE tbl_book_invoice_exim_det
       ADD COLUMN uom_tagih         VARCHAR(25)  NULL DEFAULT NULL
           COMMENT ''satuan tagih - knitting saja (detail_so.id_unit_sales_order)'',
       ADD COLUMN qty_tagih         DOUBLE       NOT NULL DEFAULT 0,
       ADD COLUMN unit_price_tagih  DOUBLE(16,4) NOT NULL DEFAULT 0,
       ADD COLUMN total_price_tagih DOUBLE(16,4) NOT NULL DEFAULT 0',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ===========================================================================
--  BAGIAN 2 - RINGKASAN NILAI TAGIH
--
--  Bentuknya sama persis dengan tbl_book_invoice_exim_pot - yang membedakan
--  cuma angkanya. Dipisah jadi tabel sendiri, bukan kolom tambahan, supaya
--  ringkasan yang lama tidak ikut tersentuh sama sekali.
-- ===========================================================================
CREATE TABLE IF NOT EXISTS tbl_book_invoice_exim_pot_tagih (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_book_invoice INT             NOT NULL              COMMENT 'tbl_book_invoice.id',
  no_invoice      VARCHAR(255)    NOT NULL,

  total           DOUBLE(16,4)    NOT NULL DEFAULT 0    COMMENT 'jumlah Total Price Tagih baris terpilih',
  discount        DOUBLE(16,4)    NOT NULL DEFAULT 0,
  dp              DOUBLE(16,4)    NOT NULL DEFAULT 0,
  dp_cbd          DOUBLE(16,4)    NOT NULL DEFAULT 0    COMMENT 'DP/CBD from Invoice',
  retur           DOUBLE(16,4)    NOT NULL DEFAULT 0,
  twot            DOUBLE(16,4)    NOT NULL DEFAULT 0    COMMENT 'total - discount - dp - dp_cbd - retur',
  vat_persen      DECIMAL(5,2)    NOT NULL DEFAULT 0    COMMENT '0, 11, atau 12',
  vat             DOUBLE(16,4)    NOT NULL DEFAULT 0    COMMENT 'twot x vat_persen',
  grand_total     DOUBLE(16,4)    NOT NULL DEFAULT 0    COMMENT 'twot + vat',

  created_by      VARCHAR(100)    NULL     DEFAULT NULL,
  created_at      DATETIME        NOT NULL,

  PRIMARY KEY (id),
  -- Satu booking hanya punya satu baris ringkasan tagih.
  UNIQUE KEY uq_bie_pot_tagih_book (id_book_invoice)
) ENGINE=InnoDB;


-- ===========================================================================
--  BAGIAN 3 - PEMERIKSAAN
--
--  Keempat kolom harus ADA, dan tabel ringkasannya harus ADA.
-- ===========================================================================
SELECT 'kolom nilai tagih di baris SJ' AS bagian,
       COUNT(*) AS ada, 4 AS harusnya
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND table_name = 'tbl_book_invoice_exim_det'
   AND column_name IN ('uom_tagih', 'qty_tagih', 'unit_price_tagih', 'total_price_tagih')

UNION ALL

SELECT 'tabel ringkasan nilai tagih', COUNT(*), 1
  FROM information_schema.tables
 WHERE table_schema = DATABASE()
   AND table_name = 'tbl_book_invoice_exim_pot_tagih';
