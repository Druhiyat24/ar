-- =====================================================================
-- Projection Report: tombol Cancel jadi hak akses per user.
--
-- MASALAHNYA
--   Di layar History Projection Report, tombol Cancel muncul untuk SIAPA
--   SAJA yang bisa membuka menunya, dan endpoint-nya
--   (Report::cancel_history_projection_report) tidak memeriksa apa pun -
--   bahkan tidak memeriksa sesi. Sekali klik, satu dokumen proyeksi
--   beserta seluruh detailnya hilang dari layar.
--
--   Datanya sendiri tidak hilang permanen: Model_report menyalinnya dulu
--   ke tbl_history_projection_h_cancel & _det_cancel sebelum menghapus.
--   Tapi dari sisi pemakai dokumennya tetap lenyap, dan tidak ada yang
--   bisa mengembalikannya lewat layar.
--
-- YANG DIKERJAKAN BERKAS INI
--   Menambah SATU baris hak akses di tbl_user_role:
--
--       menu        : Cancel History Projection
--       menu_status : cancel_projection
--
--   menu_status-nya BUKAN salah satu kelompok menu sidebar, jadi baris ini
--   tidak pernah muncul sebagai menu - dia murni penanda hak akses. Pola
--   yang sama sudah dipakai tombol Refresh Dashboard (menu_status
--   'dsb_refresh', lihat Landingpage.php).
--
--   Barisnya langsung muncul sebagai pilihan yang bisa dicentang di menu
--   Master > User Role, jadi siapa yang boleh membatalkan diatur dari
--   layar - tidak perlu mengubah kode lagi.
--
-- PENTING - FAIL CLOSED
--   Sesudah berkas ini dijalankan, tombol Cancel HILANG untuk semua
--   orang sampai hak aksesnya diberikan. Itu memang disengaja: lebih baik
--   seorang pemakai bertanya "kok tombolnya tidak ada" daripada satu
--   dokumen proyeksi terhapus tanpa sengaja. Lihat LANGKAH 3 untuk
--   memberikannya, atau lakukan dari menu Master > User Role.
--
-- TIDAK ADA DATA YANG HILANG, dan AMAN DIULANG.
-- =====================================================================


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu keadaannya. Baris cancel_projection harus
--             belum ada (0 baris). Kalau sudah ada, berkas ini pernah
--             dijalankan dan sisanya cuma memastikan.
-- ---------------------------------------------------------------------
SELECT id, menu, base_url, menu_status, status
  FROM tbl_user_role
 WHERE menu_status = 'cancel_projection';


-- ---------------------------------------------------------------------
-- LANGKAH 2 - hak aksesnya didaftarkan.
--
--   base_url-nya diisi alamat endpoint yang dijaga, supaya di layar
--   Master > User Role kelihatan hak ini mengunci apa.
-- ---------------------------------------------------------------------
INSERT INTO tbl_user_role (menu, base_url, menu_status, status)
SELECT 'Cancel History Projection',
       'report/cancel_history_projection_report',
       'cancel_projection',
       'Y'
  FROM DUAL
 WHERE NOT EXISTS (SELECT 1 FROM tbl_user_role
                    WHERE menu_status = 'cancel_projection');


-- ---------------------------------------------------------------------
-- LANGKAH 3 - siapa yang boleh membatalkan.
--
--   CARA MUDAHNYA: buka menu Master > User Role, pilih usernya, centang
--   baris "Cancel History Projection", simpan. Tidak perlu SQL.
--
--   Kalau mau sekalian dari sini: isi daftar usernya di @daftar_user,
--   dipisah koma TANPA spasi, lalu jalankan blok ini. Dibiarkan kosong
--   berarti tidak ada yang diberi hak - dan tombolnya belum muncul untuk
--   siapa pun.
--
--   Contoh: SET @daftar_user := 'willy,frisca';
-- ---------------------------------------------------------------------
SET @daftar_user := '';

INSERT INTO tbl_user_access (user, menu_id, base_url)
SELECT u.username, r.id, r.base_url
  FROM userpassword AS u
 CROSS JOIN tbl_user_role AS r
 WHERE r.menu_status = 'cancel_projection'
   AND @daftar_user <> ''
   AND FIND_IN_SET(u.username, @daftar_user) > 0
   AND NOT EXISTS (SELECT 1 FROM tbl_user_access AS a
                    WHERE a.user = u.username AND a.menu_id = r.id);


-- ---------------------------------------------------------------------
-- LANGKAH 4 - pemeriksaan. Barisnya harus ada tepat satu.
-- ---------------------------------------------------------------------
SELECT id, menu, base_url, menu_status, status
  FROM tbl_user_role
 WHERE menu_status = 'cancel_projection';


-- ---------------------------------------------------------------------
-- LANGKAH 5 - siapa saja yang sekarang boleh membatalkan.
--             Kosong berarti tombolnya belum muncul untuk siapa pun.
-- ---------------------------------------------------------------------
SELECT b.user
  FROM tbl_user_role AS a
 INNER JOIN tbl_user_access AS b ON b.menu_id = a.id
 WHERE a.menu_status = 'cancel_projection'
   AND a.status = 'Y'
 ORDER BY b.user;


-- ---------------------------------------------------------------------
-- MEMBATALKAN (kalau benar-benar perlu)
--
--   DELETE b FROM tbl_user_access AS b
--     INNER JOIN tbl_user_role AS a ON a.id = b.menu_id
--    WHERE a.menu_status = 'cancel_projection';
--   DELETE FROM tbl_user_role WHERE menu_status = 'cancel_projection';
--
--   Sesudah dibatalkan, tombol Cancel tetap TIDAK muncul untuk siapa pun -
--   kodenya memang menutup tombol itu kalau hak aksesnya tidak ada.
--   Untuk mengembalikannya seperti semula, kodenya yang harus diubah.
-- ---------------------------------------------------------------------
