-- ================================================================================
-- MENU - "Report Uang Muka Penjualan" GANTI NAMA jadi "Unearned Revenue"
-- Dibuat 2026-11-03.
--
-- LATARNYA
-- Laporannya tetap laporan yang sama, hanya namanya yang diselaraskan dengan
-- istilah akuntansinya: Unearned Revenue. Permintaannya juga supaya menunya
-- tidak lagi bersarang ("Sub Ledger" lalu "Uang Muka Penjualan") melainkan
-- langsung satu baris, dan duduk DI ATAS menu Projection.
--
-- YANG DISENTUH
--   1. Kolom menu di tbl_user_role untuk base_url 'arnag/frm_report_uang_muka'.
--      ALAMATNYA TIDAK DIUBAH - hak akses yang sudah dibagikan tetap menempel,
--      tidak ada user yang kehilangan atau mendapat akses baru.
--   2. Kalau baris menunya belum ada sama sekali (migrasi 20261023e belum
--      pernah dijalankan di server ini), barisnya dibuat sekalian beserta hak
--      aksesnya - disalin dari Report Proforma Invoice, sama seperti dulu.
--
-- YANG TIDAK PERLU MIGRASI
-- Bentuk menunya (satu baris, di atas Projection) diatur di program, bukan di
-- database: lihat application/views/templates/sidebar.php. Urutan baris di
-- tbl_user_role tidak menentukan apa-apa karena query menunya tidak memakai
-- ORDER BY - jadi tempatnya memang harus dipastikan di sidebar.
--
-- AMAN DIULANG. Semua langkahnya bersyarat, menjalankannya dua kali tidak
-- membuat menu atau hak akses ganda.
--
-- CARA MEMUNDURKAN
--   UPDATE tbl_user_role SET menu = 'Report Uang Muka Penjualan'
--    WHERE base_url = 'arnag/frm_report_uang_muka';
-- ================================================================================


-- --------------------------------------------------------------------------------
-- LANGKAH 0 - lihat dulu keadaan sekarang
-- Harapannya satu baris, namanya masih "Report Uang Muka Penjualan".
-- --------------------------------------------------------------------------------
-- SELECT r.id, r.menu, r.base_url, r.menu_status, r.status, COUNT(a.user) AS jumlah_user
--   FROM tbl_user_role r
--   LEFT JOIN tbl_user_access a ON a.menu_id = r.id
--  WHERE r.base_url = 'arnag/frm_report_uang_muka'
--  GROUP BY r.id, r.menu, r.base_url, r.menu_status, r.status;


-- --------------------------------------------------------------------------------
-- LANGKAH 1 - kalau baris menunya belum ada, dibuat
-- Menyusul kalau migrasi 20261023e belum pernah jalan di server ini. Kalau
-- barisnya sudah ada, langkah ini tidak menambah apa-apa.
-- --------------------------------------------------------------------------------
INSERT INTO tbl_user_role (menu, base_url, menu_status, status, ctg_menu)
SELECT 'Unearned Revenue', 'arnag/frm_report_uang_muka', 'report', 'Y', NULL
  FROM (SELECT 1) AS pancingan
 WHERE NOT EXISTS (
       SELECT 1 FROM tbl_user_role WHERE base_url = 'arnag/frm_report_uang_muka');


-- --------------------------------------------------------------------------------
-- LANGKAH 2 - hak aksesnya, disalin dari Report Proforma Invoice
-- Hanya berlaku untuk user yang belum punya. Yang sudah punya tidak digandakan.
-- --------------------------------------------------------------------------------
INSERT INTO tbl_user_access (user, menu_id, base_url)
SELECT a.user,
       (SELECT id FROM tbl_user_role
         WHERE base_url = 'arnag/frm_report_uang_muka' ORDER BY id LIMIT 1),
       'arnag/frm_report_uang_muka'
  FROM tbl_user_access a
 INNER JOIN tbl_user_role r ON r.id = a.menu_id
 WHERE r.base_url = 'arnag/frm_report_invoice_dpcbd'
   AND NOT EXISTS (
       SELECT 1 FROM tbl_user_access b
        WHERE b.user = a.user AND b.base_url = 'arnag/frm_report_uang_muka')
 GROUP BY a.user;


-- --------------------------------------------------------------------------------
-- LANGKAH 3 - nama menunya diganti
-- Inti berkas ini. Alamatnya tetap, jadi hak aksesnya tidak tersentuh.
-- --------------------------------------------------------------------------------
UPDATE tbl_user_role
   SET menu = 'Unearned Revenue'
 WHERE base_url = 'arnag/frm_report_uang_muka'
   AND menu <> 'Unearned Revenue';


-- --------------------------------------------------------------------------------
-- LANGKAH 4 - periksa hasilnya
-- Seharusnya tetap satu baris, namanya "Unearned Revenue", menu_status 'report',
-- status 'Y', dan jumlah user-nya sama dengan sebelum migrasi.
-- --------------------------------------------------------------------------------
SELECT r.id, r.menu, r.base_url, r.menu_status, r.status,
       COUNT(a.user) AS jumlah_user
  FROM tbl_user_role r
  LEFT JOIN tbl_user_access a ON a.menu_id = r.id
 WHERE r.base_url = 'arnag/frm_report_uang_muka'
 GROUP BY r.id, r.menu, r.base_url, r.menu_status, r.status;

-- Tidak boleh ada lagi menu yang namanya menyebut uang muka atau sub ledger.
SELECT id, menu, base_url
  FROM tbl_user_role
 WHERE menu LIKE '%Uang Muka%' OR menu LIKE '%Sub Ledger%';
