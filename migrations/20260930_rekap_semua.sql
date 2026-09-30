-- ===========================================================================
--  REKAP PERUBAHAN DATABASE - Invoice EXIM, Create Invoice AR & Debit Note
--  Dirakit dari migrations/20260911 s/d 20260929 menjadi satu berkas.
-- ===========================================================================
--
--  AMAN DIJALANKAN BERULANG. Tabel dibuat dengan CREATE TABLE IF NOT EXISTS,
--  dan tiap penambahan kolom/index diperiksa dulu ke information_schema - yang
--  sudah ada dilewati. Jadi tidak masalah kalau sebagian migrasi sudah pernah
--  dijalankan; yang belum saja yang akan jalan.
--
--  TIDAK ADA satu pun perintah yang menghapus tabel, kolom, atau baris.
--
--  Cara jalan (pilih salah satu):
--    mysql -u <user> -p <nama_db> < 20260930_rekap_semua.sql
--    atau tempel seluruh isinya di phpMyAdmin > SQL
--
--  BAGIAN 1  Tabel baru                        - wajib
--  BAGIAN 2  Kolom & index tambahan            - wajib
--  BAGIAN 3  Perbaikan data invoice lama       - opsional, lihat catatannya
--  BAGIAN 4  Pemeriksaan hasil                 - cuma SELECT, jalankan terakhir
--
--  Backup dulu sebelum menjalankan BAGIAN 3.
-- ===========================================================================


-- ===========================================================================
--  BAGIAN 1 - TABEL BARU
-- ===========================================================================
-- ------------------------------------------------------------------
-- Baris SJ milik booking Invoice EXIM.
-- (dari 20260916_invoice_exim_booking.sql)
-- ------------------------------------------------------------------
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

-- ------------------------------------------------------------------
-- Rekap uang booking Invoice EXIM (DP, Return, VAT, Grand Total).
-- (dari 20260916_invoice_exim_booking.sql)
-- ------------------------------------------------------------------
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

-- ------------------------------------------------------------------
-- Baris SO/WS - dipakai invoice yang dibuat sebelum SJ-nya terbit.
-- (dari 20260928_invoice_exim_so.sql)
-- ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_book_invoice_exim_so (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_book_invoice INT             NOT NULL              COMMENT 'tbl_book_invoice.id',
  no_invoice      VARCHAR(255)    NOT NULL              COMMENT 'tbl_book_invoice.no_invoice, biar mudah dibaca manusia',

  -- Satu baris = satu WS + satu WARNA. Size sengaja tidak dipisah: yang
  -- ditagih per warna, dan qty-nya pun diketik ulang.
  ws              VARCHAR(255)    NULL     DEFAULT NULL COMMENT 'act_costing.kpno - "WS#" di layar',
  so_number       VARCHAR(255)    NULL     DEFAULT NULL,
  so_date         DATE            NULL     DEFAULT NULL,
  styleno         VARCHAR(255)    NULL     DEFAULT NULL,
  product_group   VARCHAR(255)    NULL     DEFAULT NULL,
  product_item    VARCHAR(255)    NULL     DEFAULT NULL,
  color           VARCHAR(255)    NULL     DEFAULT NULL,
  curr            VARCHAR(25)     NULL     DEFAULT NULL,
  uom             VARCHAR(25)     NULL     DEFAULT NULL,

  -- qty_so  = qty pesanan (jumlah semua size warna itu), apa adanya dari SO.
  -- qty     = yang benar-benar ditagih di invoice ini. Boleh lebih kecil -
  --           pengiriman sering sebagian. Selisihnya = yang belum ditagih.
  qty_so          DOUBLE          NOT NULL DEFAULT 0,
  qty             DOUBLE          NOT NULL DEFAULT 0,
  unit_price      DOUBLE(16,4)    NOT NULL DEFAULT 0    COMMENT 'nilai SO / qty SO - harga per size boleh berbeda',
  disc            DOUBLE          NOT NULL DEFAULT 0    COMMENT 'persen, ikut baris Invoice Summary warnanya',
  total_price     DOUBLE(16,4)    NOT NULL DEFAULT 0    COMMENT 'qty x unit_price',

  id_so           BIGINT          NULL     DEFAULT NULL COMMENT 'so.id',
  -- Semua so_det yang diringkas jadi baris ini, dipisah koma. Dipakai waktu
  -- Edit untuk membaca ulang angkanya dari sumbernya.
  id_so_det       TEXT            NULL     DEFAULT NULL COMMENT 'daftar so_det.id, dipisah koma',

  -- Baris Invoice Summary tempat baris ini dijumlahkan. Sama artinya dengan
  -- kolom bernama sama di tbl_book_invoice_exim_det: memakai `urutan`, bukan
  -- id, karena baris summary ditulis ulang tiap invoice disimpan.
  urutan_summary  INT             NULL     DEFAULT NULL,

  created_by      VARCHAR(100)    NULL     DEFAULT NULL,
  created_at      DATETIME        NOT NULL,

  PRIMARY KEY (id),
  KEY idx_bie_so_book (id_book_invoice),
  KEY idx_bie_so_inv (no_invoice),
  KEY idx_bie_so_ws (ws)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------
-- Kode negara ISO - dipakai cetakan Invoice Export.
-- (dari 20260917_invoice_exim_export.sql)
-- ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS master_negara_kode (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_negara VARCHAR(100) NOT NULL              COMMENT 'sesuai yang tertulis di mastersupplier.country',
  kode        VARCHAR(2)   NOT NULL              COMMENT 'ISO 3166-1 alpha-2',
  PRIMARY KEY (id),
  UNIQUE KEY uq_negara_nama (nama_negara),
  KEY idx_negara_kode (kode)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------
-- Header Invoice Export: pihak-pihak, notes & reference.
-- (dari 20260917_invoice_exim_export.sql)
-- ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_book_invoice_exim_export_h (
  id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_book_invoice  INT             NOT NULL              COMMENT 'tbl_book_invoice.id',
  no_invoice       VARCHAR(255)    NOT NULL              COMMENT 'tbl_book_invoice.no_invoice',

  -- Baris 2: nomor kedua, dipakai kalau buyer minta penomoran sendiri.
  no_invoice_2     VARCHAR(255)    NULL     DEFAULT NULL,

  -- Baris 4 & 5: dipilih dari mastersupplier.
  id_shipper       VARCHAR(20)     NULL     DEFAULT NULL COMMENT 'mastersupplier.Id_Supplier',
  shipper_nama     VARCHAR(255)    NULL     DEFAULT NULL,
  shipper_alamat   TEXT            NULL     DEFAULT NULL,
  id_seller        VARCHAR(20)     NULL     DEFAULT NULL COMMENT 'mastersupplier.Id_Supplier',
  seller_nama      VARCHAR(255)    NULL     DEFAULT NULL,
  seller_alamat    TEXT            NULL     DEFAULT NULL,

  -- Baris 6 & 7: diketik bebas, tidak diambil dari master.
  purchaser_nama   VARCHAR(255)    NULL     DEFAULT NULL,
  purchaser_alamat TEXT            NULL     DEFAULT NULL,
  receiver_nama    VARCHAR(255)    NULL     DEFAULT NULL,
  receiver_alamat  TEXT            NULL     DEFAULT NULL,

  -- Baris 32-35.
  invoice_notes    TEXT            NULL     DEFAULT NULL,
  manufacturer_nama   VARCHAR(255) NULL     DEFAULT NULL COMMENT 'baris 33, isinya NAG',
  manufacturer_alamat TEXT         NULL     DEFAULT NULL,
  reference        VARCHAR(255)    NULL     DEFAULT NULL COMMENT 'baris 34, "REFF" di cetakan',
  -- Baris 35 (Invoice Type) TIDAK ditaruh di sini. tbl_type yang sudah ada
  -- isinya persis 'Commercial' dan 'Non - Commercial', dan Invoice Local pun
  -- sudah memakainya lewat tbl_book_invoice.id_type. Dibuat kolom sendiri di
  -- sini malah jadi dua sumber kebenaran untuk hal yang sama.

  created_by       VARCHAR(100)    NULL     DEFAULT NULL,
  created_at       DATETIME        NOT NULL,
  updated_by       VARCHAR(100)    NULL     DEFAULT NULL,
  updated_at       DATETIME        NULL     DEFAULT NULL,

  PRIMARY KEY (id),
  -- Satu booking hanya punya satu header export.
  UNIQUE KEY uq_bie_exp_h_book (id_book_invoice),
  KEY idx_bie_exp_h_inv (no_invoice)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------
-- Blok Shipment Details Invoice Export.
-- (dari 20260917_invoice_exim_export.sql)
-- ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_book_invoice_exim_export_ship (
  id                   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_book_invoice      INT             NOT NULL,
  no_invoice           VARCHAR(255)    NOT NULL,
  urutan               INT             NOT NULL DEFAULT 1 COMMENT 'urutan tampil & cetak',

  dest_purchase        VARCHAR(255)    NULL DEFAULT NULL COMMENT 'baris 8',
  style_no             VARCHAR(255)    NULL DEFAULT NULL COMMENT 'baris 9',
  brand                VARCHAR(255)    NULL DEFAULT NULL COMMENT 'baris 10, diisi dari so.brand lalu boleh diubah',
  chanel_description   VARCHAR(255)    NULL DEFAULT NULL COMMENT 'baris 11, mis. Retail',
  currency             VARCHAR(25)     NULL DEFAULT NULL COMMENT 'baris 12, dari so.curr',
  payment_term         VARCHAR(255)    NULL DEFAULT NULL COMMENT 'baris 13',
  final_destination    VARCHAR(10)     NULL DEFAULT NULL COMMENT 'baris 14, kode negara Receiver - boleh ditimpa manual',
  country_origin       VARCHAR(10)     NOT NULL DEFAULT 'ID' COMMENT 'baris 15, pasti ID',
  ship_mode            VARCHAR(20)     NULL DEFAULT NULL COMMENT 'baris 16, Ocean / Air',
  term_of_sale         VARCHAR(255)    NULL DEFAULT NULL COMMENT 'baris 17',
  transfer_point       VARCHAR(100)    NOT NULL DEFAULT 'JAKARTA,ID' COMMENT 'baris 18',
  port_of_loading      VARCHAR(100)    NOT NULL DEFAULT 'JAKARTA,ID' COMMENT 'baris 19',
  total_gross_weight   DOUBLE(16,3)    NOT NULL DEFAULT 0 COMMENT 'baris 20, KGS',
  total_net_weight     DOUBLE(16,3)    NOT NULL DEFAULT 0 COMMENT 'baris 21, KGS',
  total_net_net_weight DOUBLE(16,3)    NOT NULL DEFAULT 0 COMMENT 'baris 22, KGS',
  total_carton         DOUBLE(16,2)    NOT NULL DEFAULT 0 COMMENT 'baris 23',
  product_description  TEXT            NULL DEFAULT NULL COMMENT 'baris 24',

  created_by           VARCHAR(100)    NULL DEFAULT NULL,
  created_at           DATETIME        NOT NULL,

  PRIMARY KEY (id),
  KEY idx_bie_exp_ship_book (id_book_invoice),
  KEY idx_bie_exp_ship_inv (no_invoice)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------
-- Invoice Summary Export - satu baris per warna.
-- (dari 20260917_invoice_exim_export.sql)
-- ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_book_invoice_exim_export_det (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_book_invoice INT             NOT NULL,
  no_invoice      VARCHAR(255)    NOT NULL,
  urutan          INT             NOT NULL DEFAULT 1,

  color_code      VARCHAR(255)    NULL DEFAULT NULL COMMENT 'baris 25, boleh berisi beberapa kode dipisah koma',
  color_name      VARCHAR(500)    NULL DEFAULT NULL COMMENT 'baris 26, boleh berisi beberapa nama dipisah koma',
  total_pieces    DOUBLE          NOT NULL DEFAULT 0 COMMENT 'baris 27, diketik manual',
  -- Baris 28. BUKAN ketikan: hasil penjumlahan qty semua baris FG/OUT yang
  -- masuk ke baris summary ini. Hasilnya tetap disimpan supaya cetakan lama
  -- tidak ikut berubah kalau baris SJ-nya kelak dikoreksi.
  qty_invoiced    DOUBLE          NOT NULL DEFAULT 0 COMMENT 'baris 28, jumlah qty FG/OUT',

  -- Diisi awal dari so_det.price. Ini yang masuk ke tbl_book_invoice.value,
  -- sama seperti Invoice Local.
  unit_cost_cm    DOUBLE(16,4)    NOT NULL DEFAULT 0 COMMENT 'baris 29',
  -- Diisi awal dari so_det.fob apa adanya (sering kosong), lalu BOLEH DIUBAH.
  -- Kolom fob di SO belum bisa dijadikan patokan, jadi angkanya ditentukan di
  -- layar ini, bukan diambil mentah.
  unit_cost_fob   DOUBLE(16,4)    NOT NULL DEFAULT 0 COMMENT 'baris 30',

  disc            DOUBLE          NOT NULL DEFAULT 0 COMMENT 'baris 31, persen',

  -- Hasil hitungan ikut disimpan supaya cetakan lama tidak berubah kalau
  -- rumusnya suatu saat disesuaikan.
  total_cm        DOUBLE(16,4)    NOT NULL DEFAULT 0 COMMENT 'qty x unit_cost_cm setelah diskon',
  total_fob       DOUBLE(16,4)    NOT NULL DEFAULT 0 COMMENT 'qty x unit_cost_fob setelah diskon',

  created_by      VARCHAR(100)    NULL DEFAULT NULL,
  created_at      DATETIME        NOT NULL,

  PRIMARY KEY (id),
  KEY idx_bie_exp_det_book (id_book_invoice),
  KEY idx_bie_exp_det_inv (no_invoice)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------
-- Riwayat Invoice EXIM - potret tiap kali disimpan (create, edit ke-1, dst).
-- (dari 20260929_invoice_exim_riwayat.sql)
-- ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tbl_book_invoice_exim_log` (
  `id`              BIGINT(20)   NOT NULL AUTO_INCREMENT,
  `id_book_invoice` INT(11)      NOT NULL,
  `no_invoice`      VARCHAR(50)  DEFAULT NULL,
  `shipp`           VARCHAR(20)  DEFAULT NULL COMMENT 'Local / Export',
  `revisi`          INT(11)      NOT NULL DEFAULT 0 COMMENT '0 = saat dibuat',
  `aksi`            VARCHAR(20)  NOT NULL COMMENT 'CREATE / UPDATE / CANCEL',
  `ringkas`         VARCHAR(255) DEFAULT NULL COMMENT 'sebaris: jumlah baris & grand total',
  `isi`             LONGTEXT     DEFAULT NULL COMMENT 'potret JSON, siap ditampilkan',
  `created_by`      VARCHAR(100) DEFAULT NULL,
  `created_at`      DATETIME     DEFAULT NULL,
  PRIMARY KEY (`id`),
  -- Satu invoice tidak boleh punya dua revisi bernomor sama. Nomornya diambil
  -- di dalam transaksi yang sudah memegang kunci baris invoice-nya, jadi dua
  -- user yang menyimpan bersamaan tidak bisa dapat nomor yang sama.
  UNIQUE KEY `uq_exim_log_revisi` (`id_book_invoice`, `revisi`),
  KEY `idx_exim_log_invoice` (`no_invoice`),
  KEY `idx_exim_log_waktu` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Potret Invoice EXIM tiap kali disimpan';

-- ------------------------------------------------------------------
-- Supporting document Create Invoice AR.
-- (dari 20260923b_invoice_supporting_document.sql)
-- ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_invoice_doc (
  id            INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  id_inv        INT           NOT NULL             COMMENT 'tbl_book_invoice.id',
  no_invoice    VARCHAR(255)  NOT NULL             COMMENT 'tbl_book_invoice.no_invoice (untuk dibaca manusia)',
  original_name VARCHAR(255)  NOT NULL             COMMENT 'nama file asli dari user',
  file_name     VARCHAR(100)  NOT NULL             COMMENT 'nama file di server (acak)',
  file_path     VARCHAR(255)  NOT NULL             COMMENT 'path relatif dari root aplikasi',
  file_ext      VARCHAR(10)   NOT NULL,
  file_size     INT UNSIGNED  NOT NULL DEFAULT 0   COMMENT 'byte',
  mime_type     VARCHAR(100)  NULL     DEFAULT NULL,
  uploaded_by   VARCHAR(100)  NULL     DEFAULT NULL COMMENT 'username',
  uploaded_at   DATETIME      NOT NULL,
  PRIMARY KEY (id),
  KEY idx_invoice_doc_id_inv (id_inv),
  KEY idx_invoice_doc_no_inv (no_invoice)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------
-- Supporting document Debit Note.
-- (dari 20260911_debitnote_supporting_document.sql)
-- ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_debitnote_doc (
  id            INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  id_dn         INT           NOT NULL             COMMENT 'tbl_debitnote_h.id',
  no_dn         VARCHAR(50)   NOT NULL             COMMENT 'tbl_debitnote_h.no_dn (untuk dibaca manusia)',
  original_name VARCHAR(255)  NOT NULL             COMMENT 'nama file asli dari user',
  file_name     VARCHAR(100)  NOT NULL             COMMENT 'nama file di server (acak)',
  file_path     VARCHAR(255)  NOT NULL             COMMENT 'path relatif dari root aplikasi',
  file_ext      VARCHAR(10)   NOT NULL,
  file_size     INT UNSIGNED  NOT NULL DEFAULT 0   COMMENT 'byte',
  mime_type     VARCHAR(100)  NULL     DEFAULT NULL,
  uploaded_by   VARCHAR(100)  NULL     DEFAULT NULL COMMENT 'username',
  uploaded_at   DATETIME      NOT NULL,
  PRIMARY KEY (id),
  KEY idx_debitnote_doc_id_dn (id_dn),
  KEY idx_debitnote_doc_no_dn (no_dn)
) ENGINE=InnoDB;

-- Isi master kode negara. INSERT IGNORE: baris yang sudah ada dilewati,
-- dan penambahan negara baru nanti tidak akan menimpa yang sudah dipakai.
INSERT IGNORE INTO master_negara_kode (nama_negara, kode) VALUES
  ('INDONESIA', 'ID'),
  ('CHINA', 'CN'),
  ('HONG KONG', 'HK'),
  ('HONGKONG', 'HK'),
  ('VIETNAM', 'VN'),
  ('TAIWAN', 'TW'),
  ('USA', 'US'),
  ('US', 'US'),
  ('UNITED STATES OF AMERICA', 'US'),
  ('AMERIKA', 'US'),
  ('KOREA', 'KR'),
  ('SOUTH KOREA', 'KR'),
  ('KOREA, REPUBLIC OF (SOUTH', 'KR'),
  ('(KOREA, REPUBLIC)', 'KR'),
  ('SINGAPORE', 'SG'),
  ('INDIA', 'IN'),
  ('JAPAN', 'JP'),
  ('JEPANG', 'JP'),
  ('SRI LANKA', 'LK'),
  ('SRILANKA', 'LK'),
  ('MALAYSIA', 'MY'),
  ('BANGLADESH', 'BD'),
  ('ITALY', 'IT'),
  ('AUSTRALIA', 'AU'),
  ('PRANCIS', 'FR'),
  ('FRANCE', 'FR'),
  ('UK', 'GB'),
  ('ENGLAND', 'GB'),
  ('CANADA', 'CA'),
  ('DUBAI', 'AE'),
  ('NEW ZEALAND', 'NZ'),
  ('THAILAND', 'TH'),
  ('SWEDEN', 'SE'),
  ('SWEDIA', 'SE'),
  ('GERMANY', 'DE'),
  ('CAMBODIA', 'KH'),
  ('POLANDIA', 'PL'),
  ('PAKISTAN', 'PK'),
  ('BRUNEI DARUSSALAM', 'BN'),
  ('SWISS', 'CH'),
  ('BENIN', 'BJ'),
  ('MAURITIUS', 'MU'),
  ('CYPRUS', 'CY'),
  ('TURKIYE', 'TR'),
  ('KSA', 'SA'),
  ('KENYA', 'KE'),
  -- Ini sebenarnya nama kota yang terlanjur diisi di kolom negara. Dipetakan
  -- supaya tidak jadi kosong, tapi sumbernya sebaiknya dirapikan.
  ('NEW YORK', 'US'),
  ('WASHINGTON', 'US'),
  ('LONDON', 'GB'),
  ('MANILA', 'PH'),
  ('ISTANBUL', 'TR'),
  ('BANDUNG', 'ID');


-- ===========================================================================
--  BAGIAN 2 - KOLOM & INDEX TAMBAHAN
--
--  ALTER TABLE tidak punya "IF NOT EXISTS" untuk kolom di MySQL, jadi tiap
--  penambahan diperiksa dulu ke information_schema. Yang sudah ada dilewati
--  (dijalankan sebagai 'DO 0' - perintah kosong).
-- ===========================================================================

-- id baris SJ. Tabel yang dibuat BAGIAN 1 sudah punya; ini untuk database
-- yang tabelnya dibuat sebelum migrasi 20260916b (dari 20260916b).
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_det') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_det'
                 AND COLUMN_NAME  = 'id_baris') = 0,
             'ALTER TABLE `tbl_book_invoice_exim_det` ADD COLUMN id_baris BIGINT NOT NULL DEFAULT 0 COMMENT ''NAG: bppb.id | NAK: official_out_barcode.id'' AFTER id_bppb',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Baris lama diisi dari id_bppb - dulu keduanya memang sama.
UPDATE tbl_book_invoice_exim_det SET id_baris = id_bppb WHERE id_baris = 0;

-- PO konsumen knitting (dari 20260920).
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_det') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_det'
                 AND COLUMN_NAME  = 'po_konsumen') = 0,
             'ALTER TABLE `tbl_book_invoice_exim_det` ADD COLUMN po_konsumen VARCHAR(255) NULL DEFAULT NULL COMMENT ''NAK: sales_orders.po_konsumen - kolom PO di PDF knitting'' AFTER so_number',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Service charge yang dikunci saat booking (dari 20260923).
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_det') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_det'
                 AND COLUMN_NAME  = 'service_charge') = 0,
             'ALTER TABLE `tbl_book_invoice_exim_det` ADD COLUMN service_charge DOUBLE(16,4) NULL DEFAULT NULL COMMENT ''act_others SERVICE CHARGE milik costing baris ini - NULL kalau bukan FG/OUT'' AFTER total_price',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Invoice Date Invoice Local (dari 20260919).
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_pot') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_pot'
                 AND COLUMN_NAME  = 'tgl_invoice') = 0,
             'ALTER TABLE `tbl_book_invoice_exim_pot` ADD COLUMN tgl_invoice DATE NULL DEFAULT NULL COMMENT ''Invoice Date yang diisi di form Invoice Local - bukan tbl_book_invoice.tgl_inv'' AFTER no_invoice',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Invoice Date Invoice Export (dari 20260918).
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_export_h') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_export_h'
                 AND COLUMN_NAME  = 'tgl_invoice') = 0,
             'ALTER TABLE `tbl_book_invoice_exim_export_h` ADD COLUMN tgl_invoice DATE NULL DEFAULT NULL COMMENT ''Invoice Date yang diisi di form Export - bukan tbl_book_invoice.tgl_inv'' AFTER no_invoice_2',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Satuan Total Pieces - PCS atau SET (dari 20260921).
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_export_det') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_book_invoice_exim_export_det'
                 AND COLUMN_NAME  = 'total_pieces_unit') = 0,
             'ALTER TABLE `tbl_book_invoice_exim_export_det` ADD COLUMN total_pieces_unit VARCHAR(10) NULL DEFAULT NULL COMMENT ''PCS = ikut Qty Invoiced, SET = diketik user, NULL = baris lama'' AFTER total_pieces',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Kaitan baris Debit Note ke Invoice Export EXIM (dari 20260925).
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det'
                 AND COLUMN_NAME  = 'id_invoice_exim') = 0,
             'ALTER TABLE `tbl_debitnote_det` ADD COLUMN id_invoice_exim INT NULL DEFAULT NULL COMMENT ''tbl_book_invoice.id - invoice export EXIM asal baris ini'' AFTER id_memo_det',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Nomor invoicenya, disalin saat DN dibuat (dari 20260925).
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det'
                 AND COLUMN_NAME  = 'no_invoice_exim') = 0,
             'ALTER TABLE `tbl_debitnote_det` ADD COLUMN no_invoice_exim VARCHAR(255) NULL DEFAULT NULL COMMENT ''nomor invoicenya saat DN dibuat - sengaja disalin, bukan di-join'' AFTER id_invoice_exim',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Index penanda "sudah ditagih DN" di daftar Invoice Export EXIM.
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det') = 1
          AND (SELECT COUNT(*) FROM information_schema.STATISTICS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det'
                 AND INDEX_NAME   = 'idx_dn_det_inv_exim') = 0,
             'ALTER TABLE `tbl_debitnote_det` ADD KEY idx_dn_det_inv_exim (id_invoice_exim)',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ------------------------------------------------------------------
-- Header 4 & 5 Debit Note (dari 20260911). Sudah lama - ada di sini
-- supaya satu berkas ini cukup untuk database mana pun.
-- ------------------------------------------------------------------
-- tbl_debitnote_h.header4
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_h') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_h'
                 AND COLUMN_NAME  = 'header4') = 0,
             'ALTER TABLE `tbl_debitnote_h` ADD COLUMN header4 VARCHAR(255) NULL DEFAULT NULL',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- tbl_debitnote_h.header5
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_h') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_h'
                 AND COLUMN_NAME  = 'header5') = 0,
             'ALTER TABLE `tbl_debitnote_h` ADD COLUMN header5 VARCHAR(255) NULL DEFAULT NULL',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- tbl_debitnote_det.header4
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det'
                 AND COLUMN_NAME  = 'header4') = 0,
             'ALTER TABLE `tbl_debitnote_det` ADD COLUMN header4 TEXT NULL DEFAULT NULL',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- tbl_debitnote_det.header5
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det'
                 AND COLUMN_NAME  = 'header5') = 0,
             'ALTER TABLE `tbl_debitnote_det` ADD COLUMN header5 TEXT NULL DEFAULT NULL',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- tbl_debitnote_det_edit.header4
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det_edit') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det_edit'
                 AND COLUMN_NAME  = 'header4') = 0,
             'ALTER TABLE `tbl_debitnote_det_edit` ADD COLUMN header4 TEXT NULL DEFAULT NULL',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- tbl_debitnote_det_edit.header5
SET @s := IF((SELECT COUNT(*) FROM information_schema.TABLES
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det_edit') = 1
          AND (SELECT COUNT(*) FROM information_schema.COLUMNS
               WHERE TABLE_SCHEMA = DATABASE()
                 AND TABLE_NAME   = 'tbl_debitnote_det_edit'
                 AND COLUMN_NAME  = 'header5') = 0,
             'ALTER TABLE `tbl_debitnote_det_edit` ADD COLUMN header5 TEXT NULL DEFAULT NULL',
             'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ===========================================================================
--  BAGIAN 3 - PERBAIKAN DATA INVOICE LAMA (OPSIONAL)
--
--  Invoice yang tersimpan SEBELUM perbaikan pembacaan angka berkoma bisa
--  punya rekap uang lebih kecil dari jumlah baris SJ-nya (mis. "33,948,900"
--  terbaca 33). Perbaikan ini menyalin angka dari rekap booking Invoice EXIM,
--  dan HANYA menyentuh baris yang memang meleset lebih dari 1.
--
--  Jalankan SELECT pemeriksaannya dulu. Kalau hasilnya kosong, tidak ada yang
--  perlu diperbaiki - BAGIAN 3 boleh dilewati seluruhnya.
--  Backup dulu sebelum menjalankan UPDATE-nya.
-- ===========================================================================

-- Salinan lengkapnya ada di migrations/20260924_perbaiki_invoice_pot_koma.sql
-- (berisi SELECT pemeriksaan sebelum & sesudah, plus UPDATE-nya).


-- ===========================================================================
--  BAGIAN 4 - PEMERIKSAAN HASIL (cuma SELECT)
--
--  Semua baris harus berbunyi OK. Kalau ada yang BELUM, berarti bagian di
--  atasnya belum jalan - periksa pesan errornya.
-- ===========================================================================
SELECT 'tabel' AS jenis, nama AS objek,
       IF((SELECT COUNT(*) FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = nama) > 0, 'OK', 'BELUM') AS hasil
  FROM (
    SELECT 'tbl_book_invoice_exim_det'        AS nama UNION ALL
    SELECT 'tbl_book_invoice_exim_pot'                UNION ALL
    SELECT 'tbl_book_invoice_exim_so'                 UNION ALL
    SELECT 'tbl_book_invoice_exim_log'                UNION ALL
    SELECT 'tbl_book_invoice_exim_export_h'           UNION ALL
    SELECT 'tbl_book_invoice_exim_export_ship'        UNION ALL
    SELECT 'tbl_book_invoice_exim_export_det'         UNION ALL
    SELECT 'master_negara_kode'                       UNION ALL
    SELECT 'tbl_invoice_doc'                          UNION ALL
    SELECT 'tbl_debitnote_doc'
  ) t

UNION ALL

SELECT 'kolom', CONCAT(tabel, '.', kolom),
       IF((SELECT COUNT(*) FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = tabel AND COLUMN_NAME = kolom) > 0,
          'OK', 'BELUM')
  FROM (
    SELECT 'tbl_book_invoice_exim_det'        AS tabel, 'id_baris'          AS kolom UNION ALL
    SELECT 'tbl_book_invoice_exim_det',              'po_konsumen'                UNION ALL
    SELECT 'tbl_book_invoice_exim_det',              'service_charge'             UNION ALL
    SELECT 'tbl_book_invoice_exim_pot',              'tgl_invoice'                UNION ALL
    SELECT 'tbl_book_invoice_exim_export_h',         'tgl_invoice'                UNION ALL
    SELECT 'tbl_book_invoice_exim_export_det',       'total_pieces_unit'          UNION ALL
    SELECT 'tbl_debitnote_det',                      'id_invoice_exim'            UNION ALL
    SELECT 'tbl_debitnote_det',                      'no_invoice_exim'            UNION ALL
    SELECT 'tbl_debitnote_h',                        'header4'                    UNION ALL
    SELECT 'tbl_debitnote_det',                      'header4'
  ) k

UNION ALL

SELECT 'index', 'tbl_debitnote_det.idx_dn_det_inv_exim',
       IF((SELECT COUNT(*) FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_debitnote_det'
              AND INDEX_NAME = 'idx_dn_det_inv_exim') > 0, 'OK', 'BELUM')

UNION ALL

SELECT 'isi', 'master_negara_kode',
       IF((SELECT COUNT(*) FROM master_negara_kode) > 0, 'OK', 'BELUM');