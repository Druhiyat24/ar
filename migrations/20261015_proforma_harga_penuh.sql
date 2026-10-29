-- ============================================================================
-- Proforma Invoice: harga satuan & total disimpan apa adanya, tidak dibulatkan.
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Harga di SO (so_det.price) bertipe DOUBLE dan banyak yang berdesimal panjang,
-- terutama harga rupiah - mis. 11711.7117117, 51818.1818181, 27027.027027.
-- Di alur Proforma Invoice harga & totalnya dibulatkan ke 2 angka BERKALI-KALI:
--
--   1. query sumber SO-nya                     -> ROUND(price, 2), ROUND(qty*price, 2)
--   2. kolom tabel sementara & tabel detailnya  -> DOUBLE(16,2)
--   3. query baca tabel sementara              -> FORMAT(..., 2)
--   4. baris tabel di layar dibaca ulang waktu disimpan
--   5. query cetakan                           -> FORMAT(..., 2)
--
-- Nomor 1, 3, 4 dan 5 sudah dibereskan di kodenya: angka yang DISIMPAN dibawa
-- apa adanya (lewat atribut data-price / data-total di selnya), sedangkan yang
-- MUNCUL di layar dan di PDF tetap 2 angka supaya enak dibaca. Jadi kalau nanti
-- diminta total apa adanya, databasenya tidak perlu diubah lagi.
--
-- Migrasi ini membereskan nomor 2: selama kolomnya masih DOUBLE(16,2), MySQL
-- membulatkan sendiri waktu baris disimpan - sebagus apa pun querynya.
--
-- Qty SENGAJA dibiarkan seperti semula: qty memang bilangan cacah.
--
-- Aman dijalankan kapan saja: DOUBLE menampung semua yang muat di DOUBLE(16,2),
-- jadi baris lama tidak berubah nilainya. Yang sudah terlanjur tersimpan
-- membulat TIDAK ikut dipulihkan - angkanya memang sudah hilang; proforma baru
-- yang akan benar.
-- ============================================================================

-- 1) Cek dulu tipe kolomnya sekarang:
--      SELECT table_name, column_name, column_type
--        FROM information_schema.columns
--       WHERE table_schema = DATABASE()
--         AND column_name IN ('price', 'unit_price', 'total', 'total_price')
--         AND (table_name = 'tbl_so_det_proforma_temp'
--           OR table_name LIKE 'tbl_invoice_proforma_detail%')
--       ORDER BY table_name, column_name;

-- Tabel sementara per so_det - isinya yang dipajang & yang disimpan.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_so_det_proforma_temp' AND column_name = 'price' AND column_type <> 'double'), 'ALTER TABLE tbl_so_det_proforma_temp MODIFY price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Tabel sementara per so_det - total apa adanya (qty x harga).
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_so_det_proforma_temp' AND column_name = 'total' AND column_type <> 'double'), 'ALTER TABLE tbl_so_det_proforma_temp MODIFY total DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Tabel sementara per SO.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_temp' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_temp MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Tabel sementara per SO.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_temp' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_temp MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Detail PI per so_det - ini yang dicetak di PDF.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_so MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Detail PI per so_det - ini yang dicetak di PDF.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_so MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Detail PI per SO.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Detail PI per SO.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Proforma DP/CBD memakai tabelnya sendiri - ikut disamakan.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so_dp_cbd' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_so_dp_cbd MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Proforma DP/CBD per so_det.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so_dp_cbd' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_so_dp_cbd MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Proforma DP/CBD per SO.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_dp_cbd' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_dp_cbd MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Proforma DP/CBD per SO.
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_dp_cbd' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_dp_cbd MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2) Cek hasilnya - semuanya harus bertipe double (tanpa (16,2)): jalankan lagi
--    query di bagian 1.
--
-- 3) Lalu buat satu Proforma Invoice dari SO yang harganya berdesimal panjang,
--    bandingkan harga & totalnya dengan so_det.price:
--      SELECT d.no_so, d.unit_price, d.total_price, s.price, s.qty * s.price
--        FROM tbl_invoice_proforma_detail_so d
--  INNER JOIN so_det s ON s.id = d.id_so_det
--       WHERE d.no_invoice_proforma = '<nomor PI>';
--    Di layar & di PDF angkanya tetap tampil 2 desimal - itu memang disengaja.

-- ----------------------------------------------------------------------------
-- ROLLBACK (mengembalikan ke DOUBLE(16,2)) - ini MEMBULATKAN lagi angka yang
-- sudah tersimpan penuh, jadi lakukan hanya kalau memang perlu:
--   ALTER TABLE tbl_so_det_proforma_temp MODIFY price DOUBLE(16,2) NULL DEFAULT NULL;
--   ALTER TABLE tbl_so_det_proforma_temp MODIFY total DOUBLE(16,2) NULL DEFAULT NULL;
--   ... dan seterusnya untuk tabel tbl_invoice_proforma_detail% di atas.
-- ----------------------------------------------------------------------------
