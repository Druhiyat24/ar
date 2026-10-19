-- ================================================================================
-- MENU - Second Approval: "Invoice DP & CBD" jadi "Proforma Invoice"
-- Dibuat 2026-10-16.
--
-- LATARNYA
-- DP & CBD sudah jadi salah satu jenis Proforma Invoice (satu layar input, satu
-- daftar, satu tabel). Approval-nya pun jadi satu: layar Approval Proforma
-- Invoice sekarang memuat PI, PI NON SO, DP & CBD sekaligus, dengan nilai yang
-- mengikuti jenisnya - DP/CBD memakai nilai DP-nya.
--
-- Menu First Approval ditulis langsung di tampilannya, jadi sudah ikut berubah
-- begitu programnya diperbarui. Menu Second Approval datang dari database
-- (tbl_user_role + tbl_user_access), jadi berkas inilah yang mengubahnya.
--
-- YANG DISENTUH
-- Cuma baris menunya - hak akses tiap user tidak diubah, jadi siapa yang boleh
-- membuka menu itu tetap sama persis.
--
-- AMAN DIULANG. Baris yang sudah berubah tidak cocok lagi dengan saringannya.
--
-- CARA MEMUNDURKAN
--   UPDATE tbl_user_role SET menu = 'Approval Invoice DP & CBD'
--    WHERE menu = 'Approval Proforma Invoice' AND menu_status = 'main_menu_3';
--   UPDATE tbl_user_access SET base_url = 'arnag/approval_invoice_dpcbd'
--    WHERE base_url = 'arnag/approval_proformainvoice';
-- ================================================================================


-- --------------------------------------------------------------------------------
-- LANGKAH 0 - lihat dulu baris mana yang akan berubah
-- --------------------------------------------------------------------------------
-- SELECT a.id, a.menu, a.menu_status, COUNT(b.user) AS jumlah_user
--   FROM tbl_user_role a LEFT JOIN tbl_user_access b ON b.menu_id = a.id
--  WHERE a.menu_status = 'main_menu_3' AND a.menu LIKE '%DP%CBD%'
--  GROUP BY a.id, a.menu, a.menu_status;


-- --------------------------------------------------------------------------------
-- LANGKAH 1 - nama menunya
-- --------------------------------------------------------------------------------
UPDATE tbl_user_role
   SET menu = 'Approval Proforma Invoice'
 WHERE menu_status = 'main_menu_3'
   AND menu LIKE 'Approval Invoice DP%CBD%';


-- --------------------------------------------------------------------------------
-- LANGKAH 2 - alamat yang dituju
-- --------------------------------------------------------------------------------
UPDATE tbl_user_access
   SET base_url = 'arnag/approval_proformainvoice'
 WHERE base_url LIKE '%approval_invoice_dpcbd%';


-- --------------------------------------------------------------------------------
-- LANGKAH 3 - periksa hasilnya
-- Seharusnya menunya bernama Approval Proforma Invoice dan alamatnya
-- arnag/approval_proformainvoice; tidak ada lagi yang menunjuk layar lama.
-- --------------------------------------------------------------------------------
SELECT a.menu, b.base_url, COUNT(*) AS jumlah_user
  FROM tbl_user_role a INNER JOIN tbl_user_access b ON b.menu_id = a.id
 WHERE a.menu_status = 'main_menu_3'
 GROUP BY a.menu, b.base_url
 ORDER BY a.menu;
