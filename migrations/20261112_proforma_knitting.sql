-- =====================================================================
-- Proforma Invoice: SO knitting (NAK) bisa ditarik juga.
--
-- MASALAHNYA
--   Create Proforma Invoice cuma bisa menarik SO garment. Daftar SO-nya
--   dibaca dari MySQL signalbit (tabel so + so_det), sedangkan SO
--   knitting - nomor seperti SO/NAK/1126/00019 - ada di database
--   PostgreSQL aplikasi knitting (sales_orders + detail_so). Jadi SO
--   knitting tidak pernah muncul sama sekali.
--
-- YANG DIKERJAKAN BERKAS INI
--   Menyiapkan satu kolom: tbl_invoice_proforma.profit_center.
--
--   Kolom itu yang membedakan proforma garment dari knitting, dan dia
--   dipakai untuk TIGA hal sekaligus:
--
--     1. PENANDA "SO INI SUDAH DIPAKAI PI".
--        Garment menandainya di so_det.no_pi - AR memang menulis ke
--        database garment (lihat Model_nag::update_pi_sodet). detail_so
--        knitting TIDAK punya kolom itu, dan database aplikasi knitting
--        sengaja tidak disentuh dari sini. Jadi penandanya dibaca dari
--        sisi AR: baris tbl_invoice_proforma_detail_so milik proforma
--        NAK yang statusnya belum CANCEL. Akibat sampingnya enak -
--        Cancel PI otomatis membebaskan SO-nya, tanpa UPDATE lintas
--        database.
--
--     2. NOMOR PROFORMA. Nomornya ikut profit center-nya, dan nomor
--        urutnya dihitung PER profit center - sama seperti Debit Note
--        (lihat Model_nag::get_kode_debitnote):
--            garment  0007//E/NAG/1126
--            knitting 0001//E/NAK/1126
--
--     3. UANG MUKA LINTAS PROFIT CENTER DITOLAK. Model_nag::pi_untuk_invoice
--        sudah menolaknya, tapi profit center PI-nya sampai sekarang
--        ditebak dari alokasi bank masuknya dan jatuh ke 'NAG' kalau
--        alokasinya belum ada. Sesudah ini yang dipakai kolom ini dulu.
--
-- TIDAK ADA DATA YANG HILANG, dan AMAN DIULANG.
--
-- SELAMA BERKAS INI BELUM DIJALANKAN: layarnya MENOLAK menarik SO
-- knitting dengan pesan yang jelas - bukan menyimpannya sebagai garment.
-- Proforma garment sama sekali tidak terpengaruh.
-- =====================================================================


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu keadaannya.
--
--   kolom_profit_center harus 0 di tbl_invoice_proforma. Kalau sudah 1,
--   berkas ini pernah dijalankan dan sisanya cuma memastikan.
--
--   table_type-nya ikut dipajang: sesudah
--   20261016_proforma_satu_tabel.sql, tbl_invoice_proforma_dp_cbd itu
--   VIEW - dan view tidak bisa di-ALTER, jadi penanganannya beda.
-- ---------------------------------------------------------------------
SELECT t.table_name,
       t.table_type,
       SUM(c.column_name = 'profit_center') AS kolom_profit_center
  FROM information_schema.tables AS t
  LEFT JOIN information_schema.columns AS c
         ON c.table_schema = t.table_schema AND c.table_name = t.table_name
 WHERE t.table_schema = DATABASE()
   AND t.table_name IN ('tbl_invoice_proforma',
                        'tbl_invoice_proforma_dp_cbd',
                        'tbl_invoice_proforma_detail_so',
                        'tbl_invoice_proforma_detail_so_dp_cbd')
 GROUP BY t.table_name, t.table_type
 ORDER BY t.table_name;


-- ---------------------------------------------------------------------
-- LANGKAH 2 - kolomnya ditambahkan.
--
--   Dibiarkan NULL dulu; isinya diisi LANGKAH 3. Kodenya sendiri
--   membaca yang kosong sebagai 'NAG', jadi urutan ini tidak pernah
--   membuat proforma lama berpindah buku walau langkahnya terputus.
-- ---------------------------------------------------------------------

-- 2a. Tabel induknya.
SET @s := IF(
    (SELECT COUNT(*) FROM information_schema.tables
      WHERE table_schema = DATABASE()
        AND table_name = 'tbl_invoice_proforma'
        AND table_type = 'BASE TABLE') = 1
    AND NOT EXISTS (SELECT 1 FROM information_schema.columns
                     WHERE table_schema = DATABASE()
                       AND table_name = 'tbl_invoice_proforma'
                       AND column_name = 'profit_center'),
    'ALTER TABLE tbl_invoice_proforma ADD COLUMN profit_center VARCHAR(10) NULL DEFAULT NULL COMMENT ''NAG = garment, NAK = knitting. Kosong dibaca NAG.''',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2b. Pemasangan yang BELUM menjalankan 20261016: tabel DP/CBD-nya masih
--     tabel sendiri, jadi kolomnya perlu ditambahkan di sana juga.
--     Kalau sudah jadi VIEW, bagian ini dilewati - view-nya disegarkan
--     LANGKAH 4.
SET @s := IF(
    (SELECT COUNT(*) FROM information_schema.tables
      WHERE table_schema = DATABASE()
        AND table_name = 'tbl_invoice_proforma_dp_cbd'
        AND table_type = 'BASE TABLE') = 1
    AND NOT EXISTS (SELECT 1 FROM information_schema.columns
                     WHERE table_schema = DATABASE()
                       AND table_name = 'tbl_invoice_proforma_dp_cbd'
                       AND column_name = 'profit_center'),
    'ALTER TABLE tbl_invoice_proforma_dp_cbd ADD COLUMN profit_center VARCHAR(10) NULL DEFAULT NULL COMMENT ''NAG = garment, NAK = knitting. Kosong dibaca NAG.''',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2c. Penanda "SO sudah dipakai PI" untuk knitting dicari lewat NOMOR
--     SO-nya di tbl_invoice_proforma_detail_so. Tanpa index, pencariannya
--     memeriksa seluruh tabel tiap kali modal Add SO ditekan.
SET @s := IF(
    (SELECT COUNT(*) FROM information_schema.tables
      WHERE table_schema = DATABASE()
        AND table_name = 'tbl_invoice_proforma_detail_so'
        AND table_type = 'BASE TABLE') = 1
    AND NOT EXISTS (SELECT 1 FROM information_schema.statistics
                     WHERE table_schema = DATABASE()
                       AND table_name = 'tbl_invoice_proforma_detail_so'
                       AND index_name = 'ix_pi_det_so_no_so'),
    'ALTER TABLE tbl_invoice_proforma_detail_so ADD INDEX ix_pi_det_so_no_so (no_so)',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ---------------------------------------------------------------------
-- LANGKAH 3 - proforma yang SUDAH ADA semuanya garment.
--
--   Sampai berkas ini dijalankan, satu-satunya SO yang bisa ditarik
--   layar Proforma Invoice adalah SO garment - jadi tidak ada baris lama
--   yang perlu dipilah. Diisi tegas supaya datanya tidak bergantung pada
--   tafsiran "kosong berarti NAG".
-- ---------------------------------------------------------------------
SET @s := IF(
    EXISTS (SELECT 1 FROM information_schema.columns
             WHERE table_schema = DATABASE()
               AND table_name = 'tbl_invoice_proforma'
               AND column_name = 'profit_center'),
    'UPDATE tbl_invoice_proforma SET profit_center = ''NAG'' WHERE profit_center IS NULL OR TRIM(profit_center) = ''''',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ---------------------------------------------------------------------
-- LANGKAH 4 - view DP/CBD dibuat ulang supaya ikut membawa kolom baru.
--
--   MySQL MENGUNCI daftar kolom sebuah view saat view itu dibuat -
--   'SELECT *' dijabarkan sekali lalu dibekukan. Jadi kolom yang baru
--   ditambahkan tidak ikut kelihatan sampai view-nya dibuat ulang.
--   Definisinya disalin apa adanya dari 20261016_proforma_satu_tabel.sql;
--   yang berubah cuma daftar kolomnya. Persoalan & caranya sama dengan
--   20261102_proforma_dp_cbd_view_billed_to.sql.
-- ---------------------------------------------------------------------
SET @s := IF(
    (SELECT COUNT(*) FROM information_schema.tables
      WHERE table_schema = DATABASE()
        AND table_name = 'tbl_invoice_proforma_dp_cbd'
        AND table_type = 'VIEW') = 1,
    'CREATE OR REPLACE VIEW tbl_invoice_proforma_dp_cbd AS SELECT * FROM tbl_invoice_proforma WHERE type_pi IN (''DP'', ''CBD'')',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ---------------------------------------------------------------------
-- LANGKAH 5 - pemeriksaan.
--
--   kolom_profit_center harus 1 untuk tbl_invoice_proforma DAN untuk
--   tbl_invoice_proforma_dp_cbd.
-- ---------------------------------------------------------------------
SELECT t.table_name,
       t.table_type,
       SUM(c.column_name = 'profit_center') AS kolom_profit_center
  FROM information_schema.tables AS t
  LEFT JOIN information_schema.columns AS c
         ON c.table_schema = t.table_schema AND c.table_name = t.table_name
 WHERE t.table_schema = DATABASE()
   AND t.table_name IN ('tbl_invoice_proforma', 'tbl_invoice_proforma_dp_cbd')
 GROUP BY t.table_name, t.table_type
 ORDER BY t.table_name;


-- ---------------------------------------------------------------------
-- LANGKAH 6 - tidak boleh ada proforma yang profit center-nya kosong.
--             Kolom "kosong" harus 0.
-- ---------------------------------------------------------------------
SELECT COUNT(*)                                  AS total,
       SUM(profit_center = 'NAG')                AS garment,
       SUM(profit_center = 'NAK')                AS knitting,
       SUM(profit_center IS NULL
           OR TRIM(profit_center) = '')          AS kosong
  FROM tbl_invoice_proforma;


-- ---------------------------------------------------------------------
-- MEMBATALKAN (kalau benar-benar perlu)
--
--   ALTER TABLE tbl_invoice_proforma DROP COLUMN profit_center;
--   ALTER TABLE tbl_invoice_proforma_detail_so DROP INDEX ix_pi_det_so_no_so;
--   -- lalu view DP/CBD-nya dibuat ulang sekali lagi, supaya daftar
--   -- kolomnya ikut kembali:
--   CREATE OR REPLACE VIEW tbl_invoice_proforma_dp_cbd AS
--       SELECT * FROM tbl_invoice_proforma WHERE type_pi IN ('DP', 'CBD');
--
--   Sesudah dibatalkan, layarnya menolak menarik SO knitting lagi, dan
--   proforma knitting yang sudah tersimpan jadi terbaca sebagai garment.
--   Jadi jangan dibatalkan kalau sudah ada PI knitting.
-- ---------------------------------------------------------------------
