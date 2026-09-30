-- ============================================================================
-- Create Invoice: tabel supporting document (menu arnag/create_invoice)
-- Dijalankan MANUAL, sekali saja.
--
-- Bentuknya sengaja dibuat sama persis dengan tbl_debitnote_doc supaya
-- perawatannya seragam - lihat migrations/20260911_debitnote_supporting_document.sql
--
-- Aplikasi aman sebelum maupun sesudah file ini dijalankan: selama tabelnya
-- belum ada, invoice tetap tersimpan, hanya dokumennya yang tidak ikut
-- tersimpan (user diberi tahu lewat pesan setelah save).
--
-- File fisiknya disimpan di folder uploads/invoice/<tahun>/<bulan>/ dengan
-- nama acak; tabel ini mencatat file mana milik invoice mana.
-- ============================================================================

-- 1) CEK DULU tipe kolom id & no_invoice di tbl_book_invoice, lalu samakan
--    tipe id_inv / no_invoice di bawah kalau berbeda:
--      SHOW COLUMNS FROM tbl_book_invoice WHERE Field IN ('id', 'no_invoice');
--    Charset/collation sengaja tidak ditulis supaya ikut default database.

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

-- 2) Cek hasilnya:
--      SHOW COLUMNS FROM tbl_invoice_doc;

-- ----------------------------------------------------------------------------
-- ROLLBACK (kalau perlu dibatalkan - file di folder uploads/invoice tidak
-- ikut terhapus):
--   DROP TABLE IF EXISTS tbl_invoice_doc;
-- ----------------------------------------------------------------------------
