-- ============================================================================
-- LANJUTAN dari 20260916_invoice_exim_booking.sql.
-- Jalankan HANYA kalau migration itu sudah terlanjur dijalankan SEBELUM
-- perbaikan ini (tabelnya belum punya kolom id_baris).
--
-- Cek dulu - kalau hasilnya 0, berarti perlu menjalankan file ini:
--   SELECT COUNT(*) FROM information_schema.columns
--    WHERE table_schema = DATABASE()
--      AND table_name = 'tbl_book_invoice_exim_det'
--      AND column_name = 'id_baris';
--
-- Kalau tabelnya belum pernah dibuat sama sekali, JANGAN jalankan file ini -
-- cukup jalankan 20260916_invoice_exim_booking.sql yang sudah diperbaiki.
--
-- ---------------------------------------------------------------------------
-- Kenapa perlu:
--   Versi awal memakai id_bppb sebagai penentu baris. Itu benar untuk garment
--   (satu bppb = satu baris), TAPI SALAH untuk knitting: satu dokumen
--   official_out_h berisi BANYAK baris barcode, jadi id dokumennya berulang.
--   Akibatnya kunci unik lama (id_book_invoice, asal, id_bppb) akan menolak
--   baris knitting yang sebenarnya sah - datanya hilang diam-diam.
--
--   Perbaikannya: tambah kolom id_baris (pengenal baris rinci) dan pindahkan
--   kunci uniknya ke situ. id_bppb tetap ada karena itu yang dipakai nanti
--   untuk menandai SJ saat Create Invoice di AR.
--     NAG: id_bppb = bppb.id             | id_baris = bppb.id
--     NAK: id_bppb = official_out_h.id   | id_baris = official_out_barcode.id
-- ============================================================================

-- 1) Tambah kolom pengenal baris.
ALTER TABLE tbl_book_invoice_exim_det
  ADD COLUMN id_baris BIGINT NOT NULL DEFAULT 0
      COMMENT 'NAG: bppb.id | NAK: official_out_barcode.id'
      AFTER id_bppb;

-- 2) Kalau tabel sudah terlanjur berisi data (seharusnya masih kosong),
--    isi dulu id_baris dari id_bppb supaya baris lama tetap punya nilai.
--    Untuk baris NAG nilainya memang sama; baris NAK lama (kalau ada) perlu
--    diperiksa manual karena id dokumen tidak menunjuk satu baris.
UPDATE tbl_book_invoice_exim_det SET id_baris = id_bppb WHERE id_baris = 0;

-- 3) Ganti kunci uniknya.
ALTER TABLE tbl_book_invoice_exim_det
  DROP INDEX uq_bie_det_baris,
  ADD UNIQUE KEY uq_bie_det_baris (id_book_invoice, asal, id_baris);

-- 4) Cek hasilnya - id_baris harus muncul, dan kunci uniknya memakai id_baris:
--      SHOW COLUMNS FROM tbl_book_invoice_exim_det LIKE 'id_baris';
--      SHOW INDEX   FROM tbl_book_invoice_exim_det WHERE Key_name = 'uq_bie_det_baris';

-- ----------------------------------------------------------------------------
-- ROLLBACK:
--   ALTER TABLE tbl_book_invoice_exim_det
--     DROP INDEX uq_bie_det_baris,
--     ADD UNIQUE KEY uq_bie_det_baris (id_book_invoice, asal, id_bppb);
--   ALTER TABLE tbl_book_invoice_exim_det DROP COLUMN id_baris;
-- ----------------------------------------------------------------------------
