-- ============================================================================
-- Invoice EXIM: kolom service_charge di baris SJ.
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Angkanya TIDAK ditampilkan di layar dan tidak ikut hitungan invoice. Ini
-- catatan biaya jasa per baris FG/OUT, diambil saat booking disimpan supaya
-- nilainya terkunci pada angka yang berlaku hari itu - kalau costing-nya
-- diperbaiki tahun depan, booking lama tidak ikut berubah.
--
-- Sumbernya (khusus FG/OUT, karena cuma dia yang punya costing):
--   act_costing ac  -> WS-nya (ac.kpno) dan produknya (masterproduct)
--   act_others  ao  -> ao.cost_no = ac.cost_no AND ao.mattype = 'SERVICE CHARGE'
--   nilainya        -> IF(ao.curr = 'IDR', ao.val_idr, ao.val_usd)
--
-- Baris tanpa costing (GK/OUT, GEN/OUT, WIP/OUT, GACC/OUT, SCR/OUT, SPCK/OUT)
-- dan baris knitting (OFC/OUT) tetap NULL - memang tidak punya service charge.
-- ============================================================================

ALTER TABLE tbl_book_invoice_exim_det
  ADD COLUMN service_charge DOUBLE(16,4) NULL DEFAULT NULL
      COMMENT 'act_others SERVICE CHARGE milik costing baris ini - NULL kalau bukan FG/OUT'
      AFTER total_price;


-- CEK hasilnya - kolomnya harus muncul dan boleh NULL:
--   SHOW COLUMNS FROM tbl_book_invoice_exim_det LIKE 'service_charge';
--
-- Dan pastikan tabel sumbernya memang seperti yang dipakai query di atas:
--   SHOW COLUMNS FROM act_others;    -- ada cost_no, mattype, curr, val_idr, val_usd
--   SHOW COLUMNS FROM act_costing;   -- ada cost_no, kpno, id_product

-- ----------------------------------------------------------------------------
-- ROLLBACK:
--   ALTER TABLE tbl_book_invoice_exim_det DROP COLUMN service_charge;
-- ----------------------------------------------------------------------------
