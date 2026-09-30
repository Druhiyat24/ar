-- ============================================================================
-- Invoice EXIM: tabel detail & potongan untuk booking yang dibuat dari
-- aplikasi nds_wip (menu Export Import > Invoice > Invoice Local).
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Alurnya:
--   1. nds_wip menyimpan header booking ke tbl_book_invoice dengan status DRAFT
--      (tabel yang sudah ada, tidak diubah strukturnya).
--   2. Baris SJ-nya masuk ke tbl_book_invoice_exim_det (tabel baru di bawah),
--      BUKAN ke tbl_invoice_detail.
--   3. Angka potongannya masuk ke tbl_book_invoice_exim_pot (tabel baru),
--      BUKAN ke tbl_invoice_pot.
--   4. Status di bppb / official_out_h SENGAJA belum disentuh. Penandaan SJ
--      sebagai "sudah di-invoice" baru dilakukan saat Create Invoice di AR.
--
-- Kenapa tabel sendiri, bukan menumpang tabel invoice yang sudah ada: booking
-- dari EXIM belum jadi invoice. Kalau ditaruh di tbl_invoice_detail, proses
-- lama di AR (yang menganggap isi tabel itu sudah pasti milik invoice) bisa
-- ikut memproses baris yang belum waktunya.
-- ============================================================================

-- 1) CEK DULU tipe kolom acuan, lalu samakan kalau ternyata berbeda:
--      SHOW COLUMNS FROM tbl_book_invoice WHERE Field IN ('id', 'no_invoice');
--      SHOW COLUMNS FROM bppb            WHERE Field = 'id';      -- sumber NAG
--    Charset/collation sengaja tidak ditulis supaya ikut default database,
--    sama seperti tabel lain, aman untuk JOIN ke tbl_book_invoice.


-- ---------------------------------------------------------------- detail --
-- Satu baris = satu baris SJ yang dipilih user. Kolomnya mengikuti
-- tbl_invoice_detail supaya gampang dipindahkan saat Create Invoice di AR,
-- ditambah kolom `asal` (sumber SJ-nya dari mana).
CREATE TABLE IF NOT EXISTS tbl_book_invoice_exim_det (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_book_invoice INT             NOT NULL              COMMENT 'tbl_book_invoice.id',
  no_invoice      VARCHAR(255)    NOT NULL              COMMENT 'tbl_book_invoice.no_invoice, biar mudah dibaca manusia',

  -- Penentu sumber. NAG & NAK punya penomoran id sendiri-sendiri, jadi id
  -- saja tidak cukup untuk menunjuk satu baris - harus berpasangan dengan asal.
  asal            VARCHAR(3)      NOT NULL              COMMENT 'NAG = garment (bppb), NAK = knitting (official_out_h)',

  -- id_bppb = dokumen SJ-nya (dipakai saat Create Invoice di AR untuk menandai
  -- SJ sebagai sudah di-invoice). id_baris = baris rincinya.
  -- Keduanya dipisah karena di knitting SATU dokumen (official_out_h) berisi
  -- BANYAK baris barcode, jadi id dokumen saja tidak unik per baris.
  id_bppb         BIGINT          NOT NULL              COMMENT 'NAG: bppb.id | NAK: official_out_h.id',
  id_baris        BIGINT          NOT NULL              COMMENT 'NAG: bppb.id | NAK: official_out_barcode.id',
  id_so           BIGINT          NULL     DEFAULT NULL COMMENT 'NAG: so_det.id_so | NAK: official_out_h.no_so',

  so_number       VARCHAR(255)    NULL     DEFAULT NULL,
  bppb_number     VARCHAR(255)    NULL     DEFAULT NULL COMMENT 'nomor SJ',
  sj_date         DATE            NULL     DEFAULT NULL,
  shipp_number    VARCHAR(255)    NULL     DEFAULT NULL,
  ws              VARCHAR(255)    NULL     DEFAULT NULL,
  styleno         VARCHAR(255)    NULL     DEFAULT NULL,
  product_group   VARCHAR(255)    NULL     DEFAULT NULL,
  product_item    VARCHAR(255)    NULL     DEFAULT NULL,
  color           VARCHAR(255)    NULL     DEFAULT NULL,
  size            VARCHAR(255)    NULL     DEFAULT NULL,
  curr            VARCHAR(25)     NULL     DEFAULT NULL,
  uom             VARCHAR(25)     NULL     DEFAULT NULL,
  qty             DOUBLE          NOT NULL DEFAULT 0,
  unit_price      DOUBLE(16,4)    NOT NULL DEFAULT 0,
  disc            DOUBLE          NOT NULL DEFAULT 0    COMMENT 'persen, diisi per baris di modal Add SJ',
  total_price     DOUBLE(16,4)    NOT NULL DEFAULT 0,

  created_by      VARCHAR(100)    NULL     DEFAULT NULL COMMENT 'username pembuat booking',
  created_at      DATETIME        NOT NULL,

  PRIMARY KEY (id),
  KEY idx_bie_det_book (id_book_invoice),
  KEY idx_bie_det_inv (no_invoice),
  KEY idx_bie_det_sj (asal, id_bppb),
  -- Satu baris SJ tidak boleh masuk dua kali di booking yang sama. Penjagaan
  -- ini sudah ada di layar, ini lapis keduanya di database.
  -- Dikunci pada id_baris (bukan id_bppb): di knitting satu dokumen SJ memang
  -- boleh menyumbang banyak baris.
  UNIQUE KEY uq_bie_det_baris (id_book_invoice, asal, id_baris)
) ENGINE=InnoDB;


-- -------------------------------------------------------------- potongan --
-- Satu baris per booking. Kolomnya mengikuti tbl_invoice_pot, ditambah dp_cbd
-- dan vat_persen (keduanya ada di layar EXIM tapi tidak ada di tabel lama).
CREATE TABLE IF NOT EXISTS tbl_book_invoice_exim_pot (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_book_invoice INT             NOT NULL              COMMENT 'tbl_book_invoice.id',
  no_invoice      VARCHAR(255)    NOT NULL,

  total           DOUBLE(16,4)    NOT NULL DEFAULT 0    COMMENT 'jumlah Total Price baris terpilih',
  discount        DOUBLE(16,4)    NOT NULL DEFAULT 0    COMMENT 'jumlah (disc% x total price) per baris',
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
  -- Satu booking hanya punya satu baris potongan.
  UNIQUE KEY uq_bie_pot_book (id_book_invoice)
) ENGINE=InnoDB;


-- 2) Cek hasilnya - kedua tabel harus muncul dengan kolom di atas:
--      SHOW COLUMNS FROM tbl_book_invoice_exim_det;
--      SHOW COLUMNS FROM tbl_book_invoice_exim_pot;
--
--    Dan pastikan tabel lama TIDAK ikut berubah:
--      SHOW COLUMNS FROM tbl_invoice_detail;
--      SHOW COLUMNS FROM tbl_invoice_pot;

-- ----------------------------------------------------------------------------
-- ROLLBACK (kalau perlu dibatalkan - tidak menyentuh tabel lama sama sekali):
--   DROP TABLE IF EXISTS tbl_book_invoice_exim_det;
--   DROP TABLE IF EXISTS tbl_book_invoice_exim_pot;
-- ----------------------------------------------------------------------------
