-- ============================================================================
-- Invoice EXIM Export: tabel untuk booking invoice export yang dibuat dari
-- aplikasi nds_wip (menu Export Import > Invoice > Invoice Export).
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Kenapa tabel sendiri lagi (sudah ada _exim_det & _exim_pot untuk Local):
-- bentuk dokumennya beda. Invoice Local itu dua lapis - header lalu daftar
-- baris SJ. Invoice Export tiga lapis:
--
--     tbl_book_invoice                 header dasar (nomor, tanggal, status)
--       + _exim_export_h               pihak-pihak & penutup dokumen
--       + _exim_export_ship  (banyak)  blok pengiriman: style, berat, karton
--       + _exim_export_det   (banyak)  Invoice Summary per warna
--       + _exim_det          (banyak)  baris SJ asalnya + penanda summary
--       + _exim_pot                    rekap uang
--
-- Baris SJ tetap disimpan di tbl_book_invoice_exim_det seperti Local. Itu
-- yang jadi bukti asal angkanya, dan yang nanti dibaca Create Invoice di AR
-- untuk menandai bppb / official_out_h sebagai sudah di-invoice.
-- ============================================================================

-- 1) CEK DULU tipe kolom acuan, samakan kalau ternyata berbeda:
--      SHOW COLUMNS FROM tbl_book_invoice WHERE Field IN ('id', 'no_invoice');


-- ============================================================ 1. pemetaan ==
-- Kode negara untuk kolom Final Destination.
--
-- mastersupplier.country isinya NAMA negara yang diketik bebas, bukan kode.
-- Isinya berantakan: HONG KONG & HONGKONG, USA & US & AMERIKA, JAPAN & JEPANG,
-- bahkan nama kota (NEW YORK, LONDON, BANDUNG). Jadi pemetaannya dibuat dari
-- nama apa adanya ke kode ISO, bukan sebaliknya - dan di layar tetap boleh
-- ditimpa manual, karena daftar ini tidak akan pernah lengkap.
CREATE TABLE IF NOT EXISTS master_negara_kode (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_negara VARCHAR(100) NOT NULL              COMMENT 'sesuai yang tertulis di mastersupplier.country',
  kode        VARCHAR(2)   NOT NULL              COMMENT 'ISO 3166-1 alpha-2',
  PRIMARY KEY (id),
  UNIQUE KEY uq_negara_nama (nama_negara),
  KEY idx_negara_kode (kode)
) ENGINE=InnoDB;

-- Isi awal: diambil dari nilai country yang BENAR-BENAR ada di mastersupplier
-- saat migrasi ini dibuat, jadi hari pertama langsung kepakai.
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
-- Sengaja TIDAK dipetakan karena memang bukan negara: 'EROPA', '-'.
-- Keduanya akan tampil kosong di layar dan diisi manual.


-- ======================================================= 2. header export ==
-- Satu baris per invoice. Isinya bagian dokumen yang cuma muncul sekali:
-- pihak-pihak di atas, dan blok penutup di bawah.
--
-- Nama & alamat tiap pihak DISIMPAN SEBAGAI TEKS walaupun id-nya juga dicatat.
-- Alasannya: invoice itu dokumen yang sudah beredar keluar. Kalau alamat di
-- mastersupplier diperbaiki tahun depan, cetakan ulang invoice lama tidak
-- boleh ikut berubah.
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


-- ==================================================== 3. blok pengiriman ==
-- Baris 8-24 dari daftar. BOLEH LEBIH DARI SATU.
--
-- Praktiknya tim exim menggabung beberapa nilai dalam satu baris dipisah koma,
-- jadi biasanya isinya cuma satu baris. Tabel ini tetap dibuat banyak-baris
-- supaya yang butuh memisah tidak mentok.
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


-- ==================================================== 4. Invoice Summary ==
-- Baris 25-31. Ini yang tercetak di blok "Invoice Summary".
--
-- Perhatikan: satu baris di sini BUKAN satu baris SJ. Di contoh cetakan, lima
-- warna digabung jadi satu baris ("13, 15, 19, 20, 21" / "BLACK COFFEE, ...")
-- dengan satu qty dan satu unit cost. Jadi baris di sini dirakit oleh user,
-- bukan disalin mentah dari SJ.
--
-- Dua harga disimpan berdampingan supaya cetakan FOB dan CM berasal dari SATU
-- data yang sama - tidak mungkin dua versi isinya berbeda:
--   unit_cost_cm  dipakai cetakan CM, ini yang jadi dasar penagihan tim AR
--   unit_cost_fob dipakai cetakan FOB, untuk perizinan barang keluar BC
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


-- ========================================== 5. penanda baris SJ ==
-- Di cetakan, blok Invoice Summary TIDAK menampilkan nomor FG/OUT. Tapi baris
-- SJ-nya tetap harus tersimpan: itu asal angka Qty Invoiced, dan itu juga yang
-- nanti dibaca Create Invoice di AR untuk menandai bppb / official_out_h.
--
-- Jadi tiap baris SJ dicatat masuk ke baris summary yang mana.
--
-- Penandanya memakai `urutan`, bukan id baris summary. Alasannya: saat invoice
-- diedit, baris summary dihapus lalu ditulis ulang, sehingga id auto-increment-
-- nya berubah tiap kali disimpan. `urutan` tidak berubah, dan angkanya sama
-- dengan yang dilihat user di layar.
ALTER TABLE tbl_book_invoice_exim_det
  ADD COLUMN urutan_summary INT NULL DEFAULT NULL
      COMMENT 'baris Invoice Summary tempat qty baris ini dijumlahkan - NULL untuk invoice Local'
      AFTER id_baris,
  ADD KEY idx_bie_det_summary (id_book_invoice, urutan_summary);


-- ================================================= 6. rekap versi FOB ==
-- tbl_book_invoice_exim_pot sudah menampung rekap uang versi CM (dipakai
-- bersama Invoice Local). Untuk export ditambah dua kolom versi FOB, supaya
-- semua angka uang tetap berkumpul di satu tempat.
--
-- Keduanya NULL untuk Invoice Local - memang tidak dipakai di sana.
ALTER TABLE tbl_book_invoice_exim_pot
  ADD COLUMN total_fob       DOUBLE(16,4) NULL DEFAULT NULL
      COMMENT 'jumlah total_fob semua baris summary - NULL untuk invoice Local'
      AFTER grand_total,
  ADD COLUMN grand_total_fob DOUBLE(16,4) NULL DEFAULT NULL
      COMMENT 'total_fob setelah potongan - NULL untuk invoice Local'
      AFTER total_fob;


-- 7) CEK hasilnya:
--      SHOW COLUMNS FROM master_negara_kode;
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_h;
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_ship;
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_det;
--      SHOW COLUMNS FROM tbl_book_invoice_exim_det;      -- ada urutan_summary
--      SHOW COLUMNS FROM tbl_book_invoice_exim_pot;      -- ada total_fob
--      SELECT COUNT(*) FROM master_negara_kode;          -- harusnya 52
--
--    Dan pastikan tabel lama TIDAK ikut berubah:
--      SHOW COLUMNS FROM tbl_invoice_detail;
--      SHOW COLUMNS FROM tbl_invoice_pot;
--      SHOW COLUMNS FROM so_det;

-- ----------------------------------------------------------------------------
-- ROLLBACK (kalau perlu dibatalkan - tidak menyentuh tabel lama sama sekali):
--   DROP TABLE IF EXISTS tbl_book_invoice_exim_export_det;
--   DROP TABLE IF EXISTS tbl_book_invoice_exim_export_ship;
--   DROP TABLE IF EXISTS tbl_book_invoice_exim_export_h;
--   DROP TABLE IF EXISTS master_negara_kode;
--   ALTER TABLE tbl_book_invoice_exim_pot
--     DROP COLUMN grand_total_fob,
--     DROP COLUMN total_fob;
--   ALTER TABLE tbl_book_invoice_exim_det
--     DROP KEY idx_bie_det_summary,
--     DROP COLUMN urutan_summary;
-- ----------------------------------------------------------------------------
