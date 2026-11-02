-- =====================================================================
-- Proforma DP/CBD: view-nya disegarkan supaya ikut membawa kolom baru
-- (yang dibutuhkan sekarang: billed_to).
--
-- MASALAHNYA
--   Cetakan Proforma Invoice DP/CBD memajang nama CUSTOMER, bukan nama
--   yang DITAGIH (Billed To) - padahal di layarnya Billed To sudah diisi.
--   Yang ditagih itu juga tidak pernah ikut tersimpan.
--
-- SEBABNYA
--   20261016_proforma_satu_tabel.sql menyatukan datanya ke
--   tbl_invoice_proforma, lalu memakai nama tabel lama sebagai VIEW:
--
--       CREATE OR REPLACE VIEW tbl_invoice_proforma_dp_cbd AS
--           SELECT * FROM tbl_invoice_proforma WHERE type_pi IN ('DP','CBD');
--
--   MySQL MENGUNCI daftar kolom sebuah view pada saat view itu dibuat -
--   "SELECT *" dijabarkan sekali, lalu dibekukan. Kolom billed_to baru
--   ditambahkan tiga hari sesudahnya (20261019b_proforma_billed_to.sql),
--   jadi view-nya tidak ikut punya kolom itu.
--
--   Akibatnya dua-duanya pincang:
--     * menyimpan - alur simpan DP/CBD menulis lewat nama view ini, dan
--       kolom yang tidak ada di view ikut terbuang diam-diam;
--     * membaca  - cetakannya tidak bisa menemukan billed_to, jadi yang
--       dipajang nama customernya.
--
-- YANG DIKERJAKAN
--   Ketiga view-nya dibuat ulang dengan definisi yang SAMA PERSIS. Yang
--   berubah cuma daftar kolomnya - sekarang dijabarkan ulang dari tabel
--   yang isinya sudah lengkap. Tidak ada data yang disentuh.
--
-- AMAN DIULANG, dan aman dijalankan kapan saja: kalau namanya ternyata
-- masih TABEL (20261016 belum dijalankan), bagiannya dilewati sendiri -
-- bukan ditimpa.
--
-- SESUDAH INI: proforma DP/CBD yang SUDAH TERLANJUR tersimpan tetap
-- kosong Billed To-nya - nilainya memang tidak pernah sampai ke database.
-- Yang perlu diperbaiki tinggal dibuka lewat Edit, Billed To-nya dipilih
-- lagi, lalu disimpan.
-- =====================================================================


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu keadaannya. kolom_billed_to harus 0 di baris
--             view, dan 1 di tbl_invoice_proforma. Itulah selisih yang
--             diperbaiki berkas ini.
-- ---------------------------------------------------------------------
SELECT t.table_name,
       t.table_type,
       SUM(c.column_name = 'billed_to') AS kolom_billed_to
  FROM information_schema.tables  AS t
  LEFT JOIN information_schema.columns AS c
         ON c.table_schema = t.table_schema AND c.table_name = t.table_name
 WHERE t.table_schema = DATABASE()
   AND t.table_name IN ('tbl_invoice_proforma',
                        'tbl_invoice_proforma_dp_cbd',
                        'tbl_invoice_proforma_detail_dp_cbd',
                        'tbl_invoice_proforma_detail_so_dp_cbd')
 GROUP BY t.table_name, t.table_type
 ORDER BY t.table_name;


-- ---------------------------------------------------------------------
-- LANGKAH 2 - buat ulang view-nya. Definisinya disalin apa adanya dari
--             20261016_proforma_satu_tabel.sql; yang disegarkan cuma
--             daftar kolomnya.
-- ---------------------------------------------------------------------

-- 2a. Kepala proforma DP & CBD.
SET @s := IF(
    (SELECT COUNT(*) FROM information_schema.tables
      WHERE table_schema = DATABASE()
        AND table_name = 'tbl_invoice_proforma_dp_cbd'
        AND table_type = 'VIEW') = 1,
    'CREATE OR REPLACE VIEW tbl_invoice_proforma_dp_cbd AS
         SELECT * FROM tbl_invoice_proforma WHERE type_pi IN (''DP'', ''CBD'')',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2b. Baris detail per produk. Barisnya tidak punya kolom jenis, jadi
--     dikenali dari NOMORnya - nomor DP & CBD selalu membawa /D/ atau /C/.
SET @s := IF(
    (SELECT COUNT(*) FROM information_schema.tables
      WHERE table_schema = DATABASE()
        AND table_name = 'tbl_invoice_proforma_detail_dp_cbd'
        AND table_type = 'VIEW') = 1,
    'CREATE OR REPLACE VIEW tbl_invoice_proforma_detail_dp_cbd AS
         SELECT * FROM tbl_invoice_proforma_detail
          WHERE no_invoice_proforma LIKE ''%/C/%'' OR no_invoice_proforma LIKE ''%/D/%''',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2c. Baris detail per SO.
SET @s := IF(
    (SELECT COUNT(*) FROM information_schema.tables
      WHERE table_schema = DATABASE()
        AND table_name = 'tbl_invoice_proforma_detail_so_dp_cbd'
        AND table_type = 'VIEW') = 1,
    'CREATE OR REPLACE VIEW tbl_invoice_proforma_detail_so_dp_cbd AS
         SELECT * FROM tbl_invoice_proforma_detail_so
          WHERE no_invoice_proforma LIKE ''%/C/%'' OR no_invoice_proforma LIKE ''%/D/%''',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ---------------------------------------------------------------------
-- LANGKAH 3 - pemeriksaan. kolom_billed_to sekarang harus 1 untuk
--             tbl_invoice_proforma DAN tbl_invoice_proforma_dp_cbd.
-- ---------------------------------------------------------------------
SELECT t.table_name,
       t.table_type,
       SUM(c.column_name = 'billed_to') AS kolom_billed_to
  FROM information_schema.tables  AS t
  LEFT JOIN information_schema.columns AS c
         ON c.table_schema = t.table_schema AND c.table_name = t.table_name
 WHERE t.table_schema = DATABASE()
   AND t.table_name IN ('tbl_invoice_proforma', 'tbl_invoice_proforma_dp_cbd')
 GROUP BY t.table_name, t.table_type
 ORDER BY t.table_name;


-- ---------------------------------------------------------------------
-- LANGKAH 4 - jumlah barisnya tidak boleh berubah. Keduanya harus sama.
-- ---------------------------------------------------------------------
SELECT (SELECT COUNT(*) FROM tbl_invoice_proforma WHERE type_pi IN ('DP','CBD')) AS di_tabel,
       (SELECT COUNT(*) FROM tbl_invoice_proforma_dp_cbd)                        AS lewat_view;
