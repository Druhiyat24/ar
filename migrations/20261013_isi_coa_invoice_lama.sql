-- ============================================================================
-- Isi no_coa & nama_coa invoice lama di tbl_book_invoice.
-- Dijalankan MANUAL di database aplikasi AR.
--
-- Kenapa perlu: Sales Report membaca Group & Relationship lewat no_coa
-- invoice-nya. Invoice yang no_coa-nya belum terisi karena itu dua kolom itu
-- kosong di laporan. (Laporannya sendiri sudah diberi cadangan lewat kategori
-- customer, tapi no_coa yang terisi tetap lebih baik - kolom itu juga dipakai
-- jurnal dan laporan lain.)
--
-- Aturan COA-nya BUKAN karangan: persis yang dipakai query jurnal invoice
-- (Model_nag::jurnal_invoice), yaitu baris piutang di mastercoa_v2 -
-- inv_type mengandung 'INV_debit' - yang cocok:
--
--     shipp_tipe  = tbl_book_invoice.shipp          (Local / Export)
--     cus_ctg     ~ kategori customer               (Related / Third)
--
-- Kategori customernya diambil dari tbl_ctg_supplier yang status-nya 'Y';
-- customer yang TIDAK terdaftar di situ dianggap 'Third' - itu juga aturan
-- yang dipakai jurnal.
--
-- Kolom so_tipe SENGAJA tidak ikut jadi syarat. Di jurnal dia dipakai, tapi
-- untuk invoice lama type_so-nya banyak yang NULL sehingga tidak akan pernah
-- cocok; sementara untuk tiap pasangan (shipp, kategori) baris piutangnya
-- memang cuma SATU, jadi so_tipe tidak menambah pembeda apa pun. Lihat
-- pemeriksaan di BAGIAN 1.
--
-- Aman diulang: yang diisi hanya baris yang no_coa-nya masih kosong/NULL.
-- Invoice yang COA-nya sudah terisi - termasuk yang sengaja dipasang COA lain
-- seperti piutang lain-lain - TIDAK disentuh.
-- ============================================================================


-- =========================== BAGIAN 1. periksa dulu ==========================
-- Jalankan ketiganya LEBIH DAHULU, jangan langsung ke BAGIAN 2.

-- 1a. Tiap pasangan (shipp, kategori) harus ketemu PERSIS SATU baris COA.
--     Kalau ada yang jml-nya bukan 1, JANGAN diteruskan - berarti master
--     COA-nya berubah dan aturan di migrasi ini perlu disesuaikan dulu.
--
--      SELECT coa.shipp_tipe, coa.cus_ctg, COUNT(*) AS jml,
--             GROUP_CONCAT(coa.no_coa) AS daftar_coa
--        FROM mastercoa_v2 coa
--       WHERE coa.inv_type LIKE '%INV_debit%'
--       GROUP BY coa.shipp_tipe, coa.cus_ctg;

-- 1b. Berapa yang akan terisi, dan jadi COA apa.
--
--      SELECT a.shipp, IFNULL(sc.supplier_ctg,'Third') AS kategori,
--             coa.no_coa, coa.nama_coa, COUNT(*) AS jml_invoice
--        FROM tbl_book_invoice a
--        LEFT JOIN (SELECT id_supplier, supplier_ctg FROM tbl_ctg_supplier
--                    WHERE status = 'Y' GROUP BY id_supplier) sc
--               ON sc.id_supplier = a.id_customer
--       INNER JOIN mastercoa_v2 coa
--               ON coa.inv_type LIKE '%INV_debit%'
--              AND coa.shipp_tipe = a.shipp
--              AND coa.cus_ctg LIKE CONCAT('%', IFNULL(sc.supplier_ctg,'Third'), '%')
--       WHERE IFNULL(a.no_coa,'') = ''
--       GROUP BY a.shipp, kategori, coa.no_coa, coa.nama_coa;

-- 1c. Yang TIDAK akan terisi - shipp-nya di luar Local/Export. Daftar ini
--     harus kosong; kalau ada isinya, invoice itu perlu diperiksa manual.
--
--      SELECT a.id, a.no_invoice, a.shipp, a.type_so, a.profit_center, a.status
--        FROM tbl_book_invoice a
--       WHERE IFNULL(a.no_coa,'') = ''
--         AND NOT EXISTS (SELECT 1 FROM mastercoa_v2 coa
--                          WHERE coa.inv_type LIKE '%INV_debit%'
--                            AND coa.shipp_tipe = a.shipp)
--       ORDER BY a.id;


-- ============================= BAGIAN 2. isi datanya =========================

UPDATE tbl_book_invoice a LEFT JOIN (SELECT id_supplier, supplier_ctg FROM tbl_ctg_supplier WHERE status = 'Y' GROUP BY id_supplier) sc ON sc.id_supplier = a.id_customer INNER JOIN mastercoa_v2 coa ON coa.inv_type LIKE '%INV_debit%' AND coa.shipp_tipe = a.shipp AND coa.cus_ctg LIKE CONCAT('%', IFNULL(sc.supplier_ctg, 'Third'), '%') SET a.no_coa = coa.no_coa, a.nama_coa = coa.nama_coa WHERE IFNULL(a.no_coa, '') = '';


-- =========================== BAGIAN 3. periksa hasilnya ======================
-- 3a. Sisa yang masih kosong - idealnya 0 (atau sama dengan daftar 1c).
--
--      SELECT COUNT(*) AS masih_kosong FROM tbl_book_invoice WHERE IFNULL(no_coa,'') = '';
--
-- 3b. Sebarannya sekarang:
--
--      SELECT no_coa, nama_coa, COUNT(*) FROM tbl_book_invoice GROUP BY no_coa, nama_coa ORDER BY no_coa;
--
-- 3c. Buka report/frm_sales_report untuk periode yang tadi bermasalah -
--     kolom Group & Relationship-nya harus terisi semua.

-- ----------------------------------------------------------------------------
-- ROLLBACK: tidak ada pembalik otomatis - sesudah dijalankan, baris yang tadinya
-- kosong tidak bisa dibedakan lagi dari yang memang sudah terisi. Kalau ragu,
-- simpan dulu daftarnya sebelum BAGIAN 2 dijalankan:
--
--   CREATE TABLE bak_coa_invoice_20261013 AS
--     SELECT id, no_coa, nama_coa FROM tbl_book_invoice WHERE IFNULL(no_coa,'') = '';
--
-- Memulihkannya:
--
--   UPDATE tbl_book_invoice a INNER JOIN bak_coa_invoice_20261013 b ON b.id = a.id
--      SET a.no_coa = b.no_coa, a.nama_coa = b.nama_coa;
-- ----------------------------------------------------------------------------
