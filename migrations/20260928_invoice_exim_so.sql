-- ============================================================================
-- Invoice EXIM Export: baris SO (WS) - dipakai kalau SJ-nya belum terbit.
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Kenapa perlu: barangnya belum keluar, tapi nomor invoice sudah diminta
-- buyer. Jadi invoice boleh dimulai dari WS/SO dulu; SJ-nya dilengkapi
-- belakangan. Sekarang yang WAJIB di Invoice Export adalah baris SO ini -
-- baris SJ jadi pelengkap.
--
-- Kenapa tabel sendiri, bukan menumpang tbl_book_invoice_exim_det:
--   1. Baris SO punya dua angka yang tidak ada di baris SJ - qty SO asli dan
--      qty yang ditagih (pengiriman bisa sebagian) - plus daftar so_det yang
--      diringkas jadi satu warna.
--   2. tbl_book_invoice_exim_det juga dibaca aplikasi AR (repo lain) untuk
--      menandai SJ sebagai sudah di-invoice. Menaruh baris yang BUKAN SJ di
--      sana berarti menitipkan kewajiban menyaring 'asal <> WS' ke kode yang
--      tidak tahu apa-apa soal WS - lupa satu tempat saja, baris SO terhitung
--      sebagai SJ.
--   3. id_bppb di tabel itu NOT NULL; baris SO tidak punya SJ, jadi harus
--      diisi angka semu.
--
-- Aman dijalankan kapan saja: tabel baru, tidak menyentuh tabel mana pun yang
-- sudah ada. Selama migrasi ini BELUM dijalankan, Save Invoice Export dengan
-- baris WS ditolak dengan pesan yang menyebut berkas ini - alur SJ yang lama
-- tetap berjalan seperti biasa.
-- ============================================================================

-- 1) CEK DULU tipe kolom acuan, samakan kalau ternyata berbeda:
--      SHOW COLUMNS FROM tbl_book_invoice WHERE Field IN ('id', 'no_invoice');

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

-- 2) CEK hasilnya:
--      SHOW COLUMNS FROM tbl_book_invoice_exim_so;
--
--    Dan pastikan tabel lama TIDAK ikut berubah:
--      SHOW COLUMNS FROM tbl_book_invoice_exim_det;
--      SHOW COLUMNS FROM tbl_book_invoice_exim_export_det;

-- ----------------------------------------------------------------------------
-- ROLLBACK (tidak menyentuh tabel lain sama sekali):
--   DROP TABLE IF EXISTS tbl_book_invoice_exim_so;
-- ----------------------------------------------------------------------------
