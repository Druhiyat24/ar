-- ============================================================================
-- Debit Note: tabel supporting document (menu create_debitnote)
-- Dijalankan MANUAL, sekali saja.
--
-- Aplikasi aman sebelum maupun sesudah file ini dijalankan: selama tabelnya
-- belum ada, Debit Note tetap tersimpan, hanya dokumennya yang tidak ikut
-- tersimpan (user dapat pesan di swal setelah save).
--
-- File fisiknya disimpan di folder uploads/debitnote/<tahun>/<bulan>/ dengan
-- nama acak; tabel ini mencatat file mana milik Debit Note mana.
-- ============================================================================

-- 1) CEK DULU tipe kolom no_dn & id di tbl_debitnote_h, lalu samakan tipe
--    id_dn / no_dn di bawah kalau berbeda:
--      SHOW COLUMNS FROM tbl_debitnote_h WHERE Field IN ('id', 'no_dn');
--    Charset/collation sengaja tidak ditulis supaya ikut default database
--    (sama dengan tabel lain, aman untuk JOIN ke tbl_debitnote_h).

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

-- 2) Cek hasilnya:
--      SHOW COLUMNS FROM tbl_debitnote_doc;

-- ----------------------------------------------------------------------------
-- ROLLBACK (kalau perlu dibatalkan - file di folder uploads/debitnote tidak
-- ikut terhapus):
--   DROP TABLE IF EXISTS tbl_debitnote_doc;
-- ----------------------------------------------------------------------------
