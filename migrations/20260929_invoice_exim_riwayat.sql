-- ---------------------------------------------------------------------------
-- Riwayat perubahan Invoice EXIM (Local & Export)
-- ---------------------------------------------------------------------------
-- Masalahnya: setiap kali invoice di-update, baris detailnya dihapus lalu
-- ditulis ulang (tbl_book_invoice_exim_det / _so / _pot / _export_det /
-- _export_ship). Cara itu memang paling aman karena SJ-nya boleh berubah
-- total, tapi akibatnya keadaan sebelumnya hilang - tidak ada lagi jejak
-- invoice ini tadinya berisi apa.
--
-- Tabel ini menyimpan POTRET tiap kali invoice disimpan:
--   revisi 0  = saat dibuat (Create)
--   revisi 1  = edit pertama
--   revisi 2  = edit kedua, dan seterusnya
--
-- Potretnya ditaruh sebagai JSON di kolom `isi`, dalam bentuk yang sudah siap
-- ditampilkan (label + nilai). Jadi kalau nanti tabel invoice-nya bertambah
-- kolom, tabel riwayat ini tidak perlu ikut diubah, dan potret lama tetap
-- terbaca apa adanya - memang begitu keadaannya waktu itu.
--
-- Jalankan manual:
--   mysql -u <user> -p <nama_db> < 20260929_invoice_exim_riwayat.sql

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

-- Periksa:
--   SHOW CREATE TABLE tbl_book_invoice_exim_log;
--   SELECT id_book_invoice, no_invoice, revisi, aksi, ringkas, created_by, created_at
--     FROM tbl_book_invoice_exim_log ORDER BY id_book_invoice, revisi;
--
-- Batalkan (semua riwayat ikut terhapus):
--   DROP TABLE tbl_book_invoice_exim_log;
