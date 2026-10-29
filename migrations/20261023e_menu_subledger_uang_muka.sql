-- ================================================================================
-- MENU - Report "Sub Ledger - Uang Muka Penjualan"
-- Dibuat 2026-10-23.
--
-- LATARNYA
-- Layar laporannya sudah ada di program (arnag/frm_report_uang_muka), tapi menu
-- AR datang dari database (tbl_user_role + tbl_user_access) - jadi tanpa berkas
-- ini layarnya tidak muncul di sidebar siapa pun.
--
-- YANG DISENTUH
--   1. Satu baris menu baru di tbl_user_role (kelompok 'report', sama seperti
--      laporan AR lainnya).
--   2. Hak aksesnya DISALIN dari Report Proforma Invoice - siapa yang sekarang
--      boleh membuka laporan itu, dia pula yang boleh membuka laporan ini.
--      Tidak ada user yang kehilangan atau mendapat akses lain.
--   3. Nama menu laporan proforma invoice diselaraskan dengan judul layarnya
--      yang sudah berubah ("Report Invoice DP & CBD" -> "Report Proforma
--      Invoice"). Alamatnya tidak diubah.
--
-- AMAN DIULANG. Langkah 1 & 2 memakai saringan "belum ada", jadi menjalankannya
-- dua kali tidak membuat menu atau hak akses ganda.
--
-- CARA MEMUNDURKAN
--   DELETE FROM tbl_user_access WHERE base_url = 'arnag/frm_report_uang_muka';
--   DELETE FROM tbl_user_role  WHERE base_url = 'arnag/frm_report_uang_muka';
--   UPDATE tbl_user_role SET menu = 'Report Invoice DP & CBD'
--    WHERE base_url = 'arnag/frm_report_invoice_dpcbd';
-- ================================================================================


-- --------------------------------------------------------------------------------
-- LANGKAH 0 - lihat dulu keadaan sekarang
-- Baris pertama = menu laporan yang jadi acuan hak aksesnya.
-- --------------------------------------------------------------------------------
-- SELECT r.id, r.menu, r.base_url, r.menu_status, COUNT(a.user) AS jumlah_user
--   FROM tbl_user_role r
--   LEFT JOIN tbl_user_access a ON a.menu_id = r.id
--  WHERE r.base_url IN ('arnag/frm_report_invoice_dpcbd', 'arnag/frm_report_uang_muka')
--  GROUP BY r.id, r.menu, r.base_url, r.menu_status;


-- --------------------------------------------------------------------------------
-- LANGKAH 1 - baris menunya
-- Disamakan dengan laporan AR lain: menu_status 'report', status 'Y'.
-- --------------------------------------------------------------------------------
INSERT INTO tbl_user_role (menu, base_url, menu_status, status, ctg_menu)
SELECT 'Report Uang Muka Penjualan', 'arnag/frm_report_uang_muka', 'report', 'Y', NULL
  FROM (SELECT 1) AS pancingan
 WHERE NOT EXISTS (
       SELECT 1 FROM tbl_user_role WHERE base_url = 'arnag/frm_report_uang_muka');


-- --------------------------------------------------------------------------------
-- LANGKAH 2 - hak aksesnya, disalin dari Report Proforma Invoice
-- Kalau laporan acuannya belum dibagikan ke siapa pun, langkah ini tidak
-- menambah apa-apa - bagikan menunya seperti biasa lewat pengaturan user.
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
-- LANGKAH 3 - nama menu laporan proforma invoice diselaraskan
-- Judul layarnya sudah "Report Proforma Invoice"; menunya ikut, alamatnya tetap.
-- --------------------------------------------------------------------------------
UPDATE tbl_user_role
   SET menu = 'Report Proforma Invoice'
 WHERE base_url = 'arnag/frm_report_invoice_dpcbd'
   AND menu <> 'Report Proforma Invoice';


-- --------------------------------------------------------------------------------
-- LANGKAH 4 - periksa hasilnya
-- Seharusnya kedua laporan muncul, jumlah user-nya sama, dan nama menu
-- proforma invoice-nya sudah berubah.
-- --------------------------------------------------------------------------------
SELECT r.id, r.menu, r.base_url, r.menu_status, r.status,
       COUNT(a.user) AS jumlah_user
  FROM tbl_user_role r
  LEFT JOIN tbl_user_access a ON a.menu_id = r.id
 WHERE r.base_url IN ('arnag/frm_report_invoice_dpcbd', 'arnag/frm_report_uang_muka')
 GROUP BY r.id, r.menu, r.base_url, r.menu_status, r.status
 ORDER BY r.base_url;
