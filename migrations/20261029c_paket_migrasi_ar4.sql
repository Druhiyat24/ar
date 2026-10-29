-- =====================================================================
-- PAKET MIGRASI AR ke-4 - 29 Oktober 2026
--
-- Gabungan migrasi yang masih menunggu dijalankan, disusun berurutan.
-- Isinya sama persis dengan berkas aslinya - paket ini cuma menyatukan,
-- jadi menjalankan salah satu berkasnya sendiri tetap boleh.
--
-- JALANKAN SELURUH BERKAS INI SEKALI, dari atas ke bawah. Urutannya
-- penting: bagian 3 mengisi tabel yang dibuat bagian 2, dan bagian 7
-- memakai tabel cadangan yang dibuat bagian 6.
--
-- AMAN DIULANG. Tiap bagian memeriksa dulu sebelum mengubah, jadi bagian
-- yang sudah pernah dijalankan dilewati atau menghasilkan angka yang sama.
--
-- BACA SEBENTAR SEBELUM MENJALANKAN
--   * BAGIAN 6 SUDAH DIJALANKAN 29 Oktober 2026. Ikut disertakan supaya
--     paketnya utuh; menjalankannya lagi tidak merusak apa-apa - cadangan
--     aslinya dibuat dengan CREATE TABLE IF NOT EXISTS + INSERT IGNORE,
--     jadi isi cadangannya tidak tertimpa. Bagian 7 yang BELUM dijalankan,
--     dan bagian 7 inilah yang mengembalikan dokumen selain PR/0926/00001
--     ke nilai aslinya.
--   * Beberapa bagian punya SELECT "lihat dulu" dan SELECT pemeriksaan.
--     Perhatikan hasilnya - di situ ketahuan kalau ada yang perlu
--     ditindaklanjuti manual.
--   * Bagian 3 mengisi saldo awal uang muka dari lembar kerja tim AR.
--     Kalau angkanya berubah, perbaiki di sana dulu sebelum dijalankan.
--
-- ISINYA
--   1. Menu Report "Sub Ledger - Uang Muka Penjualan"
--      (20261023e_menu_subledger_uang_muka.sql)
--   2. Sub Ledger Uang Muka: tabel saldo awal per 1 Oktober 2026
--      (20261027_uang_muka_saldo_awal.sql)
--   3. Sub Ledger Uang Muka: ISI saldo awalnya - 7 baris dari tim AR
--      (20261027d_uang_muka_saldo_awal_isi.sql)
--   4. Jurnal Alokasi yang sisi KREDITnya tidak tertulis
--      (20261027b_jurnal_alokasi_kredit_hilang.sql)
--   5. Buang catatan pemakaian uang muka milik invoice yang sudah batal
--      (20261028_lepas_alokasi_invoice_batal.sql)
--   6. Receivable Amount history Projection dikunci ke Invoice Amount
--      (20261029_receivable_projection_ikut_invoice_amount.sql)
--   7. Kembalikan Receivable history SELAIN PR/0926/00001
--      (20261029b_receivable_kembalikan_selain_pr0926.sql)
-- =====================================================================


-- =====================================================================
-- BAGIAN 1 - Menu Report "Sub Ledger - Uang Muka Penjualan"
-- Dari: 20261023e_menu_subledger_uang_muka.sql
-- =====================================================================

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


-- =====================================================================
-- BAGIAN 2 - Sub Ledger Uang Muka: tabel saldo awal per 1 Oktober 2026
-- Dari: 20261027_uang_muka_saldo_awal.sql
-- =====================================================================

-- ================================================================================
-- Sub Ledger Uang Muka Penjualan: saldo awal per 1 Oktober 2026
-- Dibuat 2026-10-27.
--
-- LATARNYA
-- Laporan Sub Ledger - Uang Muka Penjualan membaca COA uang muka (2.40.xx).
-- COA itu sudah dipakai sejak 2023, jauh sebelum alur Proforma Invoice &
-- Alokasi ada, jadi mutasi lamanya tidak punya dokumen pasangan: ada baris
-- potongan tanpa penambahan, dan ada uang masuk yang tidak pernah dialokasikan.
-- Kalau semuanya ikut dihitung, laporannya penuh baris yang tidak bisa
-- ditelusuri.
--
-- Karena itu laporannya DIMULAI 1 OKTOBER 2026. Mutasi sebelum tanggal itu
-- tidak dihitung ulang - saldonya dimasukkan sekali lewat tabel ini, dan
-- itulah yang muncul di kolom Beginning Balance.
--
-- YANG DISENTUH
-- Satu tabel baru. Tidak ada data lama yang diubah atau dihapus.
--
-- AMAN DIULANG - tabelnya dibuat kalau belum ada.
--
-- CARA MEMUNDURKAN
--   DROP TABLE tbl_uang_muka_awal;
-- ================================================================================


-- --------------------------------------------------------------------------------
-- LANGKAH 1 - tabelnya
-- Satu baris = satu uang muka yang masih bersaldo per 30 September 2026.
-- --------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_uang_muka_awal (
    id INT NOT NULL AUTO_INCREMENT,
    no_coa VARCHAR(20) NOT NULL COMMENT 'COA uang mukanya, mis. 2.40.01',
    no_dokumen VARCHAR(100) NOT NULL COMMENT 'kunci barisnya: nomor PI kalau ada, kalau tidak nomor BM / alokasinya',
    no_pi VARCHAR(60) NULL COMMENT 'isi kalau uang mukanya memang dari Proforma Invoice - ini yang dipajang di kolom PI No',
    id_customer VARCHAR(20) NULL COMMENT 'id di mastersupplier - namanya diambil dari sana',
    customer VARCHAR(255) NULL COMMENT 'dipakai kalau id_customer tidak diisi',
    payer VARCHAR(255) NULL COMMENT 'yang ditagih, kalau berbeda dari customernya',
    profit_center VARCHAR(20) NULL COMMENT 'NAG / NAK - dipajang di kolom Profit Center',
    curr VARCHAR(10) NOT NULL DEFAULT 'IDR',
    amount DECIMAL(18,4) NOT NULL DEFAULT 0 COMMENT 'sisa uang muka per 30 Sep 2026, mata uang aslinya',
    amount_idr DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'nilai rupiahnya - untuk baris IDR isi sama dengan amount',
    tgl_masuk DATE NULL COMMENT 'tanggal uang mukanya diterima - dipakai menghitung umur & kelompok aging',
    no_bm VARCHAR(100) NULL,
    tgl_bm DATE NULL,
    no_alokasi VARCHAR(100) NULL,
    tgl_alokasi DATE NULL,
    keterangan VARCHAR(255) NULL,
    PRIMARY KEY (id),
    KEY idx_um_awal (no_coa, no_dokumen)
) COMMENT 'Saldo awal Sub Ledger Uang Muka Penjualan per 1 Oktober 2026';

-- Kalau tabelnya sudah terlanjur dibuat SEBELUM kolom profit_center ada,
-- kolomnya ditambahkan di sini. Kalau sudah ada, blok ini tidak melakukan
-- apa-apa - jadi aman dijalankan berulang.
SET @ada := (SELECT COUNT(*) FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = 'tbl_uang_muka_awal'
                AND COLUMN_NAME = 'profit_center');
SET @sql := IF(@ada = 0,
    'ALTER TABLE tbl_uang_muka_awal ADD COLUMN profit_center VARCHAR(20) NULL AFTER payer',
    'DO 0');
PREPARE tambah_kolom FROM @sql;
EXECUTE tambah_kolom;
DEALLOCATE PREPARE tambah_kolom;


-- --------------------------------------------------------------------------------
-- LANGKAH 2 - USULAN ANGKANYA (cuma SELECT, tidak mengubah apa pun)
--
-- Query ini menghitung sisa tiap uang muka di COA uang muka sampai
-- 30 September 2026, dari buku besarnya. Hasilnya DIPERIKSA DULU tim AR -
-- baris lama banyak yang tidak punya dokumen pasangan, jadi jangan langsung
-- dimasukkan mentah-mentah.
--
-- Kolomnya sudah disusun sama dengan tabel di atas, supaya tinggal disalin.
-- --------------------------------------------------------------------------------
SELECT j.no_coa,
       IFNULL(NULLIF(TRIM(NULLIF(TRIM(j.reff_doc), '-')), ''), j.no_journal) AS no_dokumen,
       NULL                                   AS no_pi,
       NULL                                   AS id_customer,
       UPPER(TRIM(IFNULL(j.buyer, '')))       AS customer,
       NULL                                   AS payer,
       IFNULL(NULLIF(TRIM(j.curr), ''), 'IDR') AS curr,
       ROUND(SUM(j.credit - j.debit), 4)      AS amount,
       ROUND(SUM(j.credit_idr - j.debit_idr), 2) AS amount_idr,
       MIN(CASE WHEN j.credit > 0 THEN j.tgl_journal END) AS tgl_masuk,
       NULL AS no_bm, NULL AS tgl_bm, NULL AS no_alokasi, NULL AS tgl_alokasi,
       CONCAT('saldo awal per 2026-10-01, dari ', COUNT(*), ' baris jurnal') AS keterangan
  FROM tbl_list_journal AS j
 INNER JOIN (SELECT no_coa FROM mastercoa_v2
              WHERE IFNULL(inv_type, '') LIKE '%DP/CBD%'
           GROUP BY no_coa) AS c ON c.no_coa = j.no_coa
 WHERE j.tgl_journal < '2026-10-01'
   AND IFNULL(j.status, '') NOT LIKE 'CANCEL%'
GROUP BY j.no_coa,
         IFNULL(NULLIF(TRIM(NULLIF(TRIM(j.reff_doc), '-')), ''), j.no_journal),
         IFNULL(NULLIF(TRIM(j.curr), ''), 'IDR'),
         UPPER(TRIM(IFNULL(j.buyer, '')))
HAVING ROUND(SUM(j.credit - j.debit), 4) <> 0
ORDER BY j.no_coa, no_dokumen;


-- --------------------------------------------------------------------------------
-- LANGKAH 3 - memasukkan saldo awalnya (CONTOH - isi sendiri sesudah diperiksa)
--
-- INSERT INTO tbl_uang_muka_awal
--     (no_coa, no_dokumen, no_pi, id_customer, curr, amount, amount_idr, tgl_masuk,
--      no_bm, tgl_bm, no_alokasi, tgl_alokasi, keterangan)
-- VALUES
--     ('2.40.01', 'PI-44672', 'PI-44672', '1191', 'IDR',
--      115700000, 115700000, '2022-04-21',
--      'BBM/1979/0422/019', '2022-04-21', NULL, NULL, 'saldo awal per 2026-10-01');
--
-- Catatan pengisian:
--   * no_dokumen = kunci barisnya. Kalau uang mukanya dari PI, isi nomor PI-nya
--     dan isi juga no_pi supaya kolom PI No-nya terisi.
--   * Baris IDR: amount_idr diisi sama dengan amount.
--   * tgl_masuk menentukan umur & kelompok aging-nya.
-- --------------------------------------------------------------------------------


-- --------------------------------------------------------------------------------
-- LANGKAH 4 - periksa hasilnya
-- --------------------------------------------------------------------------------
SELECT no_coa, curr, COUNT(*) AS jumlah_baris,
       ROUND(SUM(amount), 2) AS jumlah_amount,
       ROUND(SUM(amount_idr), 2) AS jumlah_idr
  FROM tbl_uang_muka_awal
 GROUP BY no_coa, curr
 ORDER BY no_coa, curr;


-- =====================================================================
-- BAGIAN 3 - Sub Ledger Uang Muka: ISI saldo awalnya - 7 baris dari tim AR
-- Dari: 20261027d_uang_muka_saldo_awal_isi.sql
-- =====================================================================

-- ================================================================================
-- ISI saldo awal Sub Ledger Uang Muka Penjualan - 7 baris dari tim AR.
--
-- Jalankan SESUDAH migrations/20261027_uang_muka_saldo_awal.sql (yang membuat
-- tabelnya). Berkas ini cuma mengisi datanya.
--
-- Angkanya saldo per 30 September 2026, sesuai lembar kerja tim AR:
--
--   COA      PI No                BM/GM No                     Tanggal      Curr  Saldo
--   2.40.02  PI-45930A            GM/NAG/0925/00047            30-Sep-2025  USD          308.49
--   2.40.02  PI-45930B            GM/NAG/0925/00047            30-Sep-2025  USD        1,681.00
--   2.40.02  PI/NAG/2026/04/006   BM/BCA1982/NAG/0626/00009    29-Jun-2026  USD       16,573.45
--   2.40.02  PI/NAG/2026/04/009   BM/BCA1982/NAG/0726/00004    30-Jul-2026  USD          750.00
--   2.40.01  PI-44672             BBM/1979/0422/019            21-Apr-2022  IDR  140,472,554.00
--   2.40.01  PI-45869             GM/NAG/0725/00067            31-Jul-2025  IDR  102,126,047.14
--   2.40.01  PI-46265             GM/NAG/0926/00024            31-Aug-2026  IDR    4,803,104.90
--
-- CUSTOMER & PAYER disimpan sebagai ID mastersupplier (tipe_sup = 'C'),
-- dicari lewat namanya DI SERVER INI - bukan ditulis mati di sini, supaya
-- ID-nya pasti ID yang benar-benar ada. Kalau sebuah nama tidak ketemu,
-- yang tersimpan namanya; laporannya tetap menampilkan nama itu.
--
-- Nilai rupiahnya dihitung di query (amount x kurs), tidak diketik ulang:
-- kurs 16.655 / 17.781 / 18.078 untuk yang USD, 1 untuk yang IDR.
--
-- PROFIT CENTER tidak ditebak dari nomor dokumennya, tapi DIBACA dari
-- jurnalnya sendiri (tbl_list_journal) di server ini. Nomor dokumen ternyata
-- tidak bisa dipercaya untuk ini: GM/NAG/0925/00047 nomornya bertuliskan NAG,
-- padahal baris jurnalnya tercatat NAK. Yang diambil profit center baris
-- jurnal di COA uang muka yang sama; kalau tidak ketemu, baris mana pun dari
-- jurnal itu; kalau jurnalnya memang tidak ada, dipakai NAG. Bawaan NAG itu
-- permintaan tim AR supaya kolomnya tidak bolong - bukan hasil pembacaan.
-- Yang KETEMU di jurnal tetap menang: GM/NAG/0925/00047 misalnya tercatat
-- NAK, dan tetap tersimpan NAK meskipun nomornya bertuliskan NAG.
--
-- Berkas ini AMAN dijalankan berulang: ketujuh barisnya dihapus dulu
-- berdasarkan COA + nomor dokumennya, baru dimasukkan lagi.
-- ================================================================================


-- --------------------------------------------------------------------------------
-- LANGKAH 1 - PERIKSA DULU: semua namanya ketemu di mastersupplier?
--
-- Kolom "id" yang KOSONG berarti namanya belum ada / beda tulisannya.
-- Benahi dulu masternya, atau biarkan - yang tersimpan nanti namanya.
-- --------------------------------------------------------------------------------
SELECT d.nama                                        AS nama_di_lembar_kerja,
       (SELECT s.Id_Supplier FROM mastersupplier AS s
         WHERE s.tipe_sup = 'C'
           AND UPPER(TRIM(s.Supplier)) = d.nama LIMIT 1) AS id,
       IF((SELECT COUNT(*) FROM mastersupplier AS s2
            WHERE s2.tipe_sup = 'C'
              AND UPPER(TRIM(s2.Supplier)) = d.nama) = 1,
          'ok', 'PERIKSA - tidak ketemu / lebih dari satu') AS catatan
  FROM (
        SELECT 'TEEJAY MAURITIUS PRIVATE LIMITED' AS nama
  UNION SELECT 'AMAZON'
  UNION SELECT 'GREAT GIANT FIBRE GARMENT CO.,LTD.'
  UNION SELECT 'MOHAMMAD ESWANDY JUNAIDI'
  UNION SELECT 'PT. SIPATEX'
  UNION SELECT 'PT SUMBER MEKAR TEKSTIL INDUSTRI'
       ) AS d
 ORDER BY d.nama;


-- --------------------------------------------------------------------------------
-- LANGKAH 1b - PERIKSA profit center tiap dokumen, dibaca dari jurnalnya
--
-- Kolom "pc" yang KOSONG berarti jurnalnya tidak ketemu / tidak mencatat
-- profit center - barisnya tetap masuk, kolom Profit Center-nya saja kosong
-- dan bisa dibenahi belakangan dengan UPDATE biasa.
-- --------------------------------------------------------------------------------
SELECT d.no_bm, d.no_coa,
       IFNULL((SELECT j.profit_center FROM tbl_list_journal AS j
                WHERE j.no_journal = d.no_bm
                  AND j.no_coa = d.no_coa
                  AND IFNULL(j.profit_center, '') <> '' LIMIT 1),
              (SELECT j2.profit_center FROM tbl_list_journal AS j2
                WHERE j2.no_journal = d.no_bm
                  AND IFNULL(j2.profit_center, '') <> '' LIMIT 1)) AS pc
  FROM (
        SELECT 'GM/NAG/0925/00047' AS no_bm, '2.40.02' AS no_coa
  UNION SELECT 'BM/BCA1982/NAG/0626/00009', '2.40.02'
  UNION SELECT 'BM/BCA1982/NAG/0726/00004', '2.40.02'
  UNION SELECT 'BBM/1979/0422/019', '2.40.01'
  UNION SELECT 'GM/NAG/0725/00067', '2.40.01'
  UNION SELECT 'GM/NAG/0926/00024', '2.40.01'
       ) AS d
 ORDER BY d.no_coa, d.no_bm;


-- --------------------------------------------------------------------------------
-- LANGKAH 2 - MASUKKAN barisnya
-- --------------------------------------------------------------------------------
DELETE FROM tbl_uang_muka_awal
 WHERE (no_coa = '2.40.02' AND no_dokumen IN
           ('PI-45930A', 'PI-45930B', 'PI/NAG/2026/04/006', 'PI/NAG/2026/04/009'))
    OR (no_coa = '2.40.01' AND no_dokumen IN
           ('PI-44672', 'PI-45869', 'PI-46265'));

INSERT INTO tbl_uang_muka_awal
       (no_coa, no_dokumen, no_pi, id_customer, customer, payer, profit_center, curr,
        amount, amount_idr, tgl_masuk, no_bm, tgl_bm, no_alokasi, tgl_alokasi,
        keterangan)
SELECT d.no_coa,
       d.no_pi                                  AS no_dokumen,
       d.no_pi,
       -- ID customernya; kalau namanya tidak ketemu, kolomnya dikosongkan dan
       -- nama di kolom sebelahnya yang dipakai laporan.
       (SELECT s.Id_Supplier FROM mastersupplier AS s
         WHERE s.tipe_sup = 'C'
           AND UPPER(TRIM(s.Supplier)) = d.nama_customer LIMIT 1) AS id_customer,
       d.nama_customer                          AS customer,
       -- Yang ditagih: ID-nya kalau ketemu, kalau tidak namanya.
       IFNULL((SELECT s2.Id_Supplier FROM mastersupplier AS s2
                WHERE s2.tipe_sup = 'C'
                  AND UPPER(TRIM(s2.Supplier)) = d.nama_payer LIMIT 1),
              d.nama_payer)                     AS payer,
       -- lihat catatan PROFIT CENTER di atas
       -- COALESCE, bukan IFNULL: pilihannya tiga - baris jurnal di COA uang
       -- mukanya, baris lain dari jurnal yang sama, lalu bawaan per baris.
       COALESCE((SELECT j.profit_center FROM tbl_list_journal AS j
                  WHERE j.no_journal = d.no_bm
                    AND j.no_coa = d.no_coa
                    AND IFNULL(j.profit_center, '') <> '' LIMIT 1),
                (SELECT j2.profit_center FROM tbl_list_journal AS j2
                  WHERE j2.no_journal = d.no_bm
                    AND IFNULL(j2.profit_center, '') <> '' LIMIT 1),
                'NAG')                            AS profit_center,
       d.curr,
       d.amount,
       ROUND(d.amount * d.kurs, 2)              AS amount_idr,
       d.tgl                                    AS tgl_masuk,
       d.no_bm,
       d.tgl                                    AS tgl_bm,
       NULL                                     AS no_alokasi,
       NULL                                     AS tgl_alokasi,
       'saldo awal per 2026-10-01'              AS keterangan
  FROM (
        SELECT '2.40.02' AS no_coa, 'PI-45930A' AS no_pi,
               'GM/NAG/0925/00047' AS no_bm, DATE '2025-09-30' AS tgl,
               'USD' AS curr, 308.49 AS amount, 16655 AS kurs,
               'TEEJAY MAURITIUS PRIVATE LIMITED' AS nama_customer,
               'TEEJAY MAURITIUS PRIVATE LIMITED' AS nama_payer
  UNION ALL SELECT '2.40.02', 'PI-45930B',
               'GM/NAG/0925/00047', DATE '2025-09-30',
               'USD', 1681.00, 16655,
               'TEEJAY MAURITIUS PRIVATE LIMITED',
               'TEEJAY MAURITIUS PRIVATE LIMITED'
  UNION ALL SELECT '2.40.02', 'PI/NAG/2026/04/006',
               'BM/BCA1982/NAG/0626/00009', DATE '2026-06-29',
               'USD', 16573.45, 17781,
               'AMAZON',
               'GREAT GIANT FIBRE GARMENT CO.,LTD.'
  UNION ALL SELECT '2.40.02', 'PI/NAG/2026/04/009',
               'BM/BCA1982/NAG/0726/00004', DATE '2026-07-30',
               'USD', 750.00, 18078,
               'MOHAMMAD ESWANDY JUNAIDI',
               'MOHAMMAD ESWANDY JUNAIDI'
  UNION ALL SELECT '2.40.01', 'PI-44672',
               'BBM/1979/0422/019', DATE '2022-04-21',
               'IDR', 140472554.00, 1,
               'PT. SIPATEX',
               'PT. SIPATEX'
  UNION ALL SELECT '2.40.01', 'PI-45869',
               'GM/NAG/0725/00067', DATE '2025-07-31',
               'IDR', 102126047.14, 1,
               'PT SUMBER MEKAR TEKSTIL INDUSTRI',
               'PT SUMBER MEKAR TEKSTIL INDUSTRI'
  UNION ALL SELECT '2.40.01', 'PI-46265',
               'GM/NAG/0926/00024', DATE '2026-08-31',
               'IDR', 4803104.90, 1,
               'PT SUMBER MEKAR TEKSTIL INDUSTRI',
               'PT SUMBER MEKAR TEKSTIL INDUSTRI'
       ) AS d;


-- --------------------------------------------------------------------------------
-- LANGKAH 3 - PERIKSA hasilnya
--
-- 3a. ketujuh barisnya, lengkap dengan nama hasil terjemahan ID-nya.
--     Kolom "customer_tampil" & "payer_tampil" inilah yang nanti muncul di
--     laporan - pastikan isinya nama, bukan angka.
-- --------------------------------------------------------------------------------
SELECT w.no_coa, w.no_dokumen, w.curr, w.amount, w.amount_idr, w.tgl_masuk, w.no_bm,
       w.id_customer,
       UPPER(IFNULL(NULLIF(TRIM(sc.Supplier), ''),
                    IFNULL(NULLIF(TRIM(w.customer), ''), w.id_customer))) AS customer_tampil,
       w.payer,
       UPPER(IFNULL(NULLIF(TRIM(sp.Supplier), ''), IFNULL(TRIM(w.payer), ''))) AS payer_tampil
  FROM tbl_uang_muka_awal AS w
  LEFT JOIN mastersupplier AS sc ON sc.Id_Supplier = w.id_customer
  LEFT JOIN mastersupplier AS sp ON sp.Id_Supplier = w.payer
 ORDER BY w.no_coa, w.no_dokumen;

-- 3b. jumlahnya per COA & mata uang - cocokkan dengan lembar kerja AR.
--     Harapannya: 2.40.01 IDR = 247.401.706,04 dari 3 baris
--                 2.40.02 USD =      19.312,94 dari 4 baris
SELECT no_coa, curr, COUNT(*) AS jumlah_baris,
       ROUND(SUM(amount), 2)     AS jumlah_amount,
       ROUND(SUM(amount_idr), 2) AS jumlah_idr
  FROM tbl_uang_muka_awal
 GROUP BY no_coa, curr
 ORDER BY no_coa, curr;


-- =====================================================================
-- BAGIAN 4 - Jurnal Alokasi yang sisi KREDITnya tidak tertulis
-- Dari: 20261027b_jurnal_alokasi_kredit_hilang.sql
-- =====================================================================

-- =====================================================================
-- PERBAIKAN jurnal Alokasi yang sisi KREDITnya tidak tertulis.
--
-- Gejalanya: di buku besar, nomor alokasi (mis. 0013/ALK/NAG/1026) cuma
-- punya baris DEBIT di COA 1.90.02 POS SILANG PIUTANG USAHA. Kolom Cr
-- kosong, jadi Balance-nya sama dengan Db-nya - jurnalnya tidak seimbang.
--
-- Sebabnya: waktu Alokasi disimpan, jurnalnya dikirim dalam dua kiriman
-- terpisah (debit dulu, lalu kredit). Kiriman keduanya tidak ditunggu
-- sampai selesai, jadi kalau halamannya keburu pindah, baris kreditnya
-- tidak pernah sampai ke database. Sisi debitnya sudah terlanjur masuk.
--
-- Berkas ini membentuk ULANG baris kreditnya dari sumber yang sama dengan
-- yang dipakai layar Alokasi:
--
--   baris jurnal kredit  =  tbl_alokasi_detail (1 baris = 1 baris jurnal)
--   mata uang & kurs     =  baris DEBIT jurnalnya sendiri (1.90.02)
--   nama COA             =  mastercoa_v2
--
-- Kurs sengaja diambil dari baris debit yang SUDAH ADA, bukan dari kepala
-- alokasi: itulah kurs yang benar-benar dipakai waktu jurnalnya ditulis,
-- jadi hasilnya dijamin seimbang dengan debitnya.
--
-- Baris alokasi ke Proforma Invoice ikut DIPECAH seperti di layar: sebesar
-- DPP ke COA uang muka, sisanya ke PPN KELUARAN. Porsinya twot / total PI.
--
-- Baris detail yang nilainya MINUS (selisih kurs / pembulatan) ditulis ke
-- sisi debit dengan nilai positif - sama seperti layarnya.
--
-- CARA PAKAI: jalankan langkah 1 s/d 6 berurutan. Langkah 1-3 cuma
-- membaca & menyiapkan; yang benar-benar menulis ke buku besar hanya
-- langkah 4. Jangan lompat ke langkah 4 sebelum hasil langkah 3 bersih.
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. PERIKSA DULU - alokasi mana yang sisi kreditnya hilang
--
--    "baris_detail" = jumlah baris yang nanti akan dibuat. Kalau 0,
--    detail alokasinya ikut hilang - kasus itu TIDAK bisa diperbaiki
--    berkas ini, alokasinya harus diinput ulang oleh tim AR.
-- ---------------------------------------------------------------------
SELECT  j.no_journal,
        MAX(j.tgl_journal)                   AS tgl_journal,
        MAX(j.buyer)                         AS customer,
        MAX(j.curr)                          AS curr,
        MAX(j.rate)                          AS kurs,
        ROUND(SUM(j.debit), 2)               AS debit,
        ROUND(SUM(j.credit), 2)              AS kredit,
        ROUND(SUM(j.debit_idr), 2)           AS debit_idr,
        ROUND(SUM(j.credit_idr), 2)          AS kredit_idr,
        (SELECT COUNT(*) FROM tbl_alokasi_detail d
          WHERE d.no_alk = j.no_journal AND d.amount <> 0) AS baris_detail
FROM    tbl_list_journal AS j
WHERE   j.type_journal = 'Alokasi'
GROUP BY j.no_journal
HAVING  kredit = 0 AND debit > 0
ORDER BY tgl_journal DESC, j.no_journal;


-- ---------------------------------------------------------------------
-- 2a. View bantu - dua sumber yang dipakai langkah 2b
-- ---------------------------------------------------------------------
DROP VIEW IF EXISTS v_alk_sisi_debit;
CREATE VIEW v_alk_sisi_debit AS
SELECT  j.no_journal,
        MAX(j.tgl_journal)         AS tgl_journal,
        MAX(j.type_journal)        AS type_journal,
        MAX(j.buyer)               AS buyer,
        MAX(j.status)              AS status,
        MAX(j.keterangan)          AS keterangan,
        MAX(j.create_by)           AS create_by,
        MAX(j.create_date)         AS create_date,
        IFNULL(NULLIF(TRIM(MAX(j.curr)), ''), 'IDR') AS curr,
        IF(IFNULL(NULLIF(TRIM(MAX(j.curr)), ''), 'IDR') = 'IDR',
           1, IFNULL(NULLIF(MAX(j.rate), 0), 1))     AS rate,
        ROUND(SUM(j.debit), 4)     AS debit,
        ROUND(SUM(j.debit_idr), 2) AS debit_idr
FROM    tbl_list_journal AS j
WHERE   j.type_journal = 'Alokasi'
  AND   j.no_coa       = '1.90.02'
  AND   j.debit        > 0
  AND   j.tgl_journal >= '2026-10-01'        -- <<< ganti di sini >>>
  -- cuma jurnal yang sisi kreditnya benar-benar kosong
  AND   NOT EXISTS (SELECT 1 FROM tbl_list_journal AS z
                     WHERE z.no_journal = j.no_journal
                       AND (z.credit <> 0 OR z.credit_idr <> 0))
GROUP BY j.no_journal;

DROP VIEW IF EXISTS v_alk_baris_detail;
CREATE VIEW v_alk_baris_detail AS
SELECT  d.id,
        d.no_alk,
        d.coa,
        d.cost_center,
        d.no_ref,
        d.ref_date,
        d.amount,
        d.keterangan,
        d.profit_center,
        ABS(d.amount)                                            AS nilai,
        ROUND(ABS(d.amount) * b.rate, 2)                         AS nilai_idr,
        IFNULL((SELECT m.no_coa FROM mastercoa_v2 AS m
                 WHERE m.inv_type LIKE '%PPN INV%' LIMIT 1), '') AS coa_ppn,
        -- porsi DPP-nya; 1 artinya tidak ada PPN yang perlu dipisah
        IF(p.no_proforma_invoice IS NOT NULL
           AND IFNULL(p.total, 0) > 0 AND IFNULL(p.twot, 0) > 0,
           ROUND(p.twot / p.total, 6), 1)                        AS rasio,
        IF(p.no_proforma_invoice IS NOT NULL
           AND IFNULL(p.total, 0) > 0 AND IFNULL(p.twot, 0) > 0
           AND ROUND(p.twot / p.total, 6) > 0
           AND ROUND(p.twot / p.total, 6) < 1
           AND (SELECT COUNT(*) FROM mastercoa_v2 AS m2
                 WHERE m2.inv_type LIKE '%PPN INV%') > 0, 1, 0)  AS pecah
FROM    tbl_alokasi_detail AS d
JOIN    v_alk_sisi_debit   AS b ON b.no_journal = d.no_alk
-- PI hanya dipecah kalau barisnya memang jatuh ke COA uang muka penjualan
LEFT JOIN tbl_invoice_proforma AS p
       ON p.no_proforma_invoice = d.no_ref
      AND d.coa IN (SELECT m3.no_coa FROM mastercoa_v2 AS m3
                     WHERE m3.inv_type LIKE '%DP/CBD%')
WHERE   d.amount <> 0;


-- ---------------------------------------------------------------------
-- 2b. SIAPKAN baris yang akan dibuat (belum menyentuh buku besar)
--
--    Hasilnya ditampung di tabel bantu tbl_alk_kredit_hilang supaya bisa
--    diperiksa dulu, baru dipindahkan ke tbl_list_journal di langkah 4.
--
--    BATAS TANGGAL ada di langkah 2a, baris bertanda <<< ganti di sini >>>.
--    Bawaannya
--    1 Oktober 2026 ke atas - jurnal lama yang tidak seimbang karena sebab
--    lain sengaja tidak ikut diperbaiki di sini.
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS tbl_alk_kredit_hilang;

CREATE TABLE tbl_alk_kredit_hilang AS
SELECT  x.id_detail,
        x.no_journal,
        x.tgl_journal,
        x.type_journal,
        x.no_coa,
        IFNULL(NULLIF(TRIM(c.nama_coa), ''), '-') AS nama_coa,
        x.no_costcenter,
        '-'                                       AS nama_costcenter,
        x.reff_doc,
        x.reff_date,
        x.buyer,
        ''                                        AS no_ws,
        x.curr,
        x.rate,
        x.debit,
        x.credit,
        x.debit_idr,
        x.credit_idr,
        x.status,
        x.keterangan,
        x.create_by,
        x.create_date,
        x.profit_center,
        x.debit_idr_induk
FROM (
        -- (a) baris utamanya: sebesar DPP kalau dipecah, selain itu penuh
        SELECT  d.id                                        AS id_detail,
                d.no_alk                                    AS no_journal,
                b.tgl_journal,
                b.type_journal,
                IFNULL(NULLIF(TRIM(d.coa), ''), '-')        AS no_coa,
                IFNULL(NULLIF(TRIM(d.cost_center), ''), '-') AS no_costcenter,
                IF(d.amount < 0, '-', IFNULL(d.no_ref, '')) AS reff_doc,
                IF(d.amount < 0, NULL, NULLIF(d.ref_date, '0000-00-00')) AS reff_date,
                b.buyer,
                b.curr,
                b.rate,
                IF(d.amount < 0, IF(d.pecah, ROUND(d.nilai * d.rasio, 2), d.nilai), 0)         AS debit,
                IF(d.amount > 0, IF(d.pecah, ROUND(d.nilai * d.rasio, 2), d.nilai), 0)         AS credit,
                IF(d.amount < 0, IF(d.pecah, ROUND(d.nilai_idr * d.rasio, 2), d.nilai_idr), 0) AS debit_idr,
                IF(d.amount > 0, IF(d.pecah, ROUND(d.nilai_idr * d.rasio, 2), d.nilai_idr), 0) AS credit_idr,
                b.status,
                IF(TRIM(IFNULL(d.keterangan, '')) IN ('', '-'), b.keterangan, d.keterangan) AS keterangan,
                b.create_by,
                b.create_date,
                IFNULL(NULLIF(TRIM(d.profit_center), ''), 'NAG') AS profit_center,
                b.debit_idr                                 AS debit_idr_induk
          FROM  v_alk_baris_detail AS d
          JOIN  v_alk_sisi_debit   AS b ON b.no_journal = d.no_alk

        UNION ALL

        -- (b) baris PPN-nya: sisa dari yang dipecah
        SELECT  d.id                                        AS id_detail,
                d.no_alk                                    AS no_journal,
                b.tgl_journal,
                b.type_journal,
                d.coa_ppn                                   AS no_coa,
                IFNULL(NULLIF(TRIM(d.cost_center), ''), '-') AS no_costcenter,
                IF(d.amount < 0, '-', IFNULL(d.no_ref, '')) AS reff_doc,
                IF(d.amount < 0, NULL, NULLIF(d.ref_date, '0000-00-00')) AS reff_date,
                b.buyer,
                b.curr,
                b.rate,
                IF(d.amount < 0, d.nilai     - ROUND(d.nilai * d.rasio, 2), 0)     AS debit,
                IF(d.amount > 0, d.nilai     - ROUND(d.nilai * d.rasio, 2), 0)     AS credit,
                IF(d.amount < 0, d.nilai_idr - ROUND(d.nilai_idr * d.rasio, 2), 0) AS debit_idr,
                IF(d.amount > 0, d.nilai_idr - ROUND(d.nilai_idr * d.rasio, 2), 0) AS credit_idr,
                b.status,
                IF(TRIM(IFNULL(d.keterangan, '')) IN ('', '-'), b.keterangan, d.keterangan) AS keterangan,
                b.create_by,
                b.create_date,
                IFNULL(NULLIF(TRIM(d.profit_center), ''), 'NAG') AS profit_center,
                b.debit_idr                                 AS debit_idr_induk
          FROM  v_alk_baris_detail AS d
          JOIN  v_alk_sisi_debit   AS b ON b.no_journal = d.no_alk
         WHERE  d.pecah = 1
     ) AS x
LEFT JOIN mastercoa_v2 AS c ON c.no_coa = x.no_coa;

-- ---------------------------------------------------------------------
-- 3. PERIKSA hasil siapannya - WAJIB bersih sebelum langkah 4
--
--    3a. rekap per nomor: "selisih" HARUS 0. Artinya
--        debit yang sudah ada + debit baru = kredit baru.
--
--    Kolom "catatan" menandai alokasi yang perlu dilihat orang dulu:
--    alokasi yang detailnya memuat baris MINUS (selisih kurs / potongan).
--    Barisnya tetap dibuat dan tetap seimbang, tapi ditulis sebagai baris
--    debit tersendiri - cara layar Alokasi yang sekarang. Jurnal lama
--    (sebelum Agustus 2025) dulu menguranginya langsung dari baris
--    invoicenya, jadi bentuknya tidak akan sama persis dengan yang lama.
-- ---------------------------------------------------------------------
SELECT  s.no_journal,
        COUNT(*)                        AS baris_baru,
        MAX(s.debit_idr_induk)          AS debit_idr_sudah_ada,
        ROUND(SUM(s.debit_idr), 2)      AS debit_idr_baru,
        ROUND(SUM(s.credit_idr), 2)     AS kredit_idr_baru,
        ROUND(SUM(s.credit_idr) - SUM(s.debit_idr) - MAX(s.debit_idr_induk), 2) AS selisih,
        IF(ABS(SUM(s.credit_idr) - SUM(s.debit_idr) - MAX(s.debit_idr_induk)) < 1,
           'SIAP', 'JANGAN DIPAKAI - periksa manual') AS keterangan,
        IF(SUM(s.debit) > 0, 'ada baris minus - lihat dulu', '-') AS catatan
FROM    tbl_alk_kredit_hilang AS s
GROUP BY s.no_journal
ORDER BY s.no_journal;

--    3b. rincian barisnya, untuk dicocokkan dengan alokasinya
SELECT  s.no_journal, s.tgl_journal, s.no_coa, s.nama_coa, s.reff_doc,
        s.curr, s.rate, s.debit, s.credit, s.debit_idr, s.credit_idr,
        s.profit_center, s.keterangan
FROM    tbl_alk_kredit_hilang AS s
ORDER BY s.no_journal, s.id_detail, s.no_coa;

--    3c. alokasi yang TIDAK akan diperbaiki berkas ini, supaya tidak ada
--        yang terlewat diam-diam. Umumnya karena detail alokasinya ikut
--        hilang - itu harus diinput ulang lewat menu Alokasi.
SELECT  b.no_journal,
        b.tgl_journal,
        b.debit_idr AS debit_idr_sudah_ada,
        (SELECT COUNT(*) FROM tbl_alokasi_detail d
          WHERE d.no_alk = b.no_journal AND d.amount <> 0) AS baris_detail,
        IF((SELECT COUNT(*) FROM tbl_alokasi_detail d
             WHERE d.no_alk = b.no_journal AND d.amount <> 0) = 0,
           'detail alokasinya tidak ada - input ulang lewat menu Alokasi',
           'detail ada tapi nilainya tidak cocok dengan debitnya') AS sebab
FROM    v_alk_sisi_debit AS b
WHERE   b.no_journal NOT IN (
            SELECT t.no_journal
              FROM tbl_alk_kredit_hilang AS t
             GROUP BY t.no_journal
            HAVING ABS(SUM(t.credit_idr) - SUM(t.debit_idr) - MAX(t.debit_idr_induk)) < 1
        )
ORDER BY b.no_journal;


-- ---------------------------------------------------------------------
-- 4. TULIS ke buku besar
--
--    Hanya nomor yang lolos pemeriksaan 3a (selisihnya di bawah 1 rupiah)
--    yang ikut ditulis - yang tidak seimbang sengaja dilewati.
-- ---------------------------------------------------------------------
INSERT INTO tbl_list_journal
       (no_journal, tgl_journal, type_journal, no_coa, nama_coa,
        no_costcenter, nama_costcenter, reff_doc, reff_date, buyer, no_ws,
        curr, rate, debit, credit, debit_idr, credit_idr,
        status, keterangan, create_by, create_date, profit_center)
SELECT  s.no_journal, s.tgl_journal, s.type_journal, s.no_coa, s.nama_coa,
        s.no_costcenter, s.nama_costcenter, s.reff_doc, s.reff_date, s.buyer, s.no_ws,
        s.curr, s.rate, s.debit, s.credit, s.debit_idr, s.credit_idr,
        s.status, s.keterangan, s.create_by, s.create_date, s.profit_center
FROM    tbl_alk_kredit_hilang AS s
WHERE   s.no_journal IN (
            SELECT t.no_journal
              FROM tbl_alk_kredit_hilang AS t
             GROUP BY t.no_journal
            HAVING ABS(SUM(t.credit_idr) - SUM(t.debit_idr) - MAX(t.debit_idr_induk)) < 1
        )
ORDER BY s.no_journal, s.id_detail, s.no_coa;


-- ---------------------------------------------------------------------
-- 5. PERIKSA LAGI - jurnalnya harus sudah seimbang
--    Hasil yang benar: tidak ada baris sama sekali.
-- ---------------------------------------------------------------------
SELECT  j.no_journal,
        MAX(j.tgl_journal)          AS tgl_journal,
        ROUND(SUM(j.debit_idr), 2)  AS debit_idr,
        ROUND(SUM(j.credit_idr), 2) AS kredit_idr,
        ROUND(SUM(j.debit_idr) - SUM(j.credit_idr), 2) AS selisih
FROM    tbl_list_journal AS j
WHERE   j.type_journal = 'Alokasi'
  AND   j.tgl_journal >= '2026-10-01'        -- <<< samakan dengan langkah 2a >>>
GROUP BY j.no_journal
HAVING  ABS(selisih) > 1
ORDER BY tgl_journal DESC, j.no_journal;


-- ---------------------------------------------------------------------
-- 6. BERSIH-BERSIH - jalankan SESUDAH langkah 5 bersih
--
--    Tabel tbl_alk_kredit_hilang sengaja tidak langsung dihapus: selama
--    masih ada, barisnya bisa dipakai membatalkan langkah 4.
-- ---------------------------------------------------------------------
DROP VIEW  IF EXISTS v_alk_baris_detail;
DROP VIEW  IF EXISTS v_alk_sisi_debit;
-- DROP TABLE IF EXISTS tbl_alk_kredit_hilang;


-- ---------------------------------------------------------------------
-- KALAU HARUS DIBATALKAN (sebelum tabel bantunya dihapus)
--
--    Menghapus persis baris yang dibuat langkah 4, bukan yang lain.
-- ---------------------------------------------------------------------
-- DELETE j FROM tbl_list_journal AS j
--   JOIN tbl_alk_kredit_hilang AS s
--     ON  s.no_journal = j.no_journal
--     AND s.no_coa     = j.no_coa
--     AND s.reff_doc   = j.reff_doc
--     AND ROUND(s.debit, 4)  = ROUND(j.debit, 4)
--     AND ROUND(s.credit, 4) = ROUND(j.credit, 4);


-- =====================================================================
-- BAGIAN 5 - Buang catatan pemakaian uang muka milik invoice yang sudah batal
-- Dari: 20261028_lepas_alokasi_invoice_batal.sql
-- =====================================================================

-- =====================================================================
-- BERSIHKAN catatan pemakaian uang muka milik invoice yang sudah batal.
--
-- Gejalanya: di Create Invoice, kartu Others memajang Used Elsewhere yang
-- masih terisi padahal invoice yang memakainya sudah di-Cancel. Contoh
-- yang dilaporkan tim AR:
--
--   BM/BCA1979/NAG/1026/00001   value 100.000.000
--                               used elsewhere 16.015.135,14
--                               remaining       83.984.864,86
--
-- Sebabnya: Cancel Invoice mengembalikan bookingnya ke DRAFT dan menghapus
-- seluruh isi invoicenya (tbl_invoice_pot, tbl_invoice_detail), TAPI baris
-- di tbl_invoice_proforma_alokasi ikut tertinggal. Uang mukanya jadi
-- tertahan di invoice yang sudah tidak ada isinya dan tidak akan pernah
-- bisa dipakai lagi.
--
-- Programnya sudah diperbaiki: mulai sekarang Cancel Invoice dan Reverse
-- Invoice ikut menghapus barisnya (Arnag::_jalankan_cancel_invoice() dan
-- Arnag::rvs_invoice() memanggil Model_nag::lepas_alokasi_pi()), dan
-- penghitungan sisanya juga tidak lagi menghitung invoice berstatus
-- CANCEL. Berkas ini untuk baris yang TERLANJUR tertinggal sebelum
-- perbaikan itu dipasang.
--
-- Yang dianggap tertinggal ada dua macam:
--
--   (a) bookingnya berstatus CANCEL  - invoicenya dibatalkan dari layar
--       Booking Invoice;
--   (b) bookingnya DRAFT dan sama sekali tidak punya baris isi lagi
--       (tbl_invoice_detail maupun tbl_invoice_detail_knitting kosong)
--       - inilah bekas Cancel Invoice dari List Invoice.
--
-- Booking DRAFT yang MASIH punya baris isi TIDAK ikut dihapus: itu invoice
-- yang sedang dikerjakan, uang mukanya memang sedang dipakai.
--
-- CARA PAKAI: jalankan langkah 1, periksa hasilnya bersama tim AR, baru
-- jalankan langkah 2. Langkah 3 untuk memastikan hasilnya.
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. PERIKSA DULU - baris mana yang akan dihapus
--
--    Periksa kolom "alasan" dan "no_invoice": yang muncul di sini harus
--    benar-benar invoice yang sudah dibatalkan. Kalau ada satu saja yang
--    ternyata masih dipakai, JANGAN lanjut ke langkah 2 - laporkan dulu.
-- ---------------------------------------------------------------------
SELECT pa.id,
       pa.id_book_invoice,
       bi.no_invoice,
       IFNULL(bi.status, '(booking tidak ada)') AS status_booking,
       bi.tgl_inv,
       pa.no_proforma_invoice,
       pa.curr,
       pa.amount,
       CASE
           WHEN bi.id IS NULL THEN 'booking invoicenya sudah tidak ada'
           WHEN IFNULL(bi.status, '') LIKE 'CANCEL%' THEN 'booking dibatalkan'
           ELSE 'bekas Cancel Invoice - bookingnya kosong'
       END AS alasan
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE bi.id IS NULL
    OR IFNULL(bi.status, '') LIKE 'CANCEL%'
    OR (UPPER(IFNULL(bi.status, '')) = 'DRAFT'
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail AS d
                         WHERE d.id_book_invoice = bi.id)
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail_knitting AS dk
                         WHERE dk.id_book_invoice = bi.id))
 ORDER BY pa.no_proforma_invoice, pa.id;


-- ---------------------------------------------------------------------
--    Ringkasannya per uang muka - inilah angka yang akan berubah di
--    kolom Used Elsewhere / Remaining layar Create Invoice.
-- ---------------------------------------------------------------------
SELECT pa.no_proforma_invoice,
       pa.curr,
       COUNT(*)         AS baris,
       SUM(pa.amount)   AS akan_dilepas
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE bi.id IS NULL
    OR IFNULL(bi.status, '') LIKE 'CANCEL%'
    OR (UPPER(IFNULL(bi.status, '')) = 'DRAFT'
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail AS d
                         WHERE d.id_book_invoice = bi.id)
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail_knitting AS dk
                         WHERE dk.id_book_invoice = bi.id))
 GROUP BY pa.no_proforma_invoice, pa.curr
 ORDER BY pa.no_proforma_invoice;


-- ---------------------------------------------------------------------
-- 2. HAPUS barisnya
--
--    Baru jalankan kalau hasil langkah 1 sudah diperiksa.
--
--    Tidak perlu diarsipkan: riwayat pembatalan invoicenya sudah tercatat
--    di tbl_log, dan baris ini memang ditulis ulang tiap kali invoicenya
--    disimpan. Laporan Sub Ledger pun sudah tidak menghitungnya.
-- ---------------------------------------------------------------------
DELETE pa
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE bi.id IS NULL
    OR IFNULL(bi.status, '') LIKE 'CANCEL%'
    OR (UPPER(IFNULL(bi.status, '')) = 'DRAFT'
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail AS d
                         WHERE d.id_book_invoice = bi.id)
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail_knitting AS dk
                         WHERE dk.id_book_invoice = bi.id));


-- ---------------------------------------------------------------------
-- 3. PERIKSA HASILNYA - harus 0 baris
-- ---------------------------------------------------------------------
SELECT COUNT(*) AS sisa_yang_masih_nyangkut
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE bi.id IS NULL
    OR IFNULL(bi.status, '') LIKE 'CANCEL%'
    OR (UPPER(IFNULL(bi.status, '')) = 'DRAFT'
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail AS d
                         WHERE d.id_book_invoice = bi.id)
        AND NOT EXISTS (SELECT 1 FROM tbl_invoice_detail_knitting AS dk
                         WHERE dk.id_book_invoice = bi.id));


-- ---------------------------------------------------------------------
--    Dan inilah sisa uang muka BM yang dilaporkan tim AR. Sesudah
--    langkah 2, "terpakai" harus tinggal pemakaian invoice yang memang
--    masih hidup.
-- ---------------------------------------------------------------------
SELECT pa.no_proforma_invoice,
       pa.curr,
       SUM(pa.amount) AS terpakai,
       GROUP_CONCAT(DISTINCT bi.no_invoice ORDER BY bi.no_invoice
                    SEPARATOR ', ') AS dipakai_invoice
  FROM tbl_invoice_proforma_alokasi AS pa
  LEFT JOIN tbl_book_invoice AS bi ON bi.id = pa.id_book_invoice
 WHERE pa.no_proforma_invoice = 'BM/BCA1979/NAG/1026/00001'
 GROUP BY pa.no_proforma_invoice, pa.curr;


-- =====================================================================
-- BAGIAN 6 - Receivable Amount history Projection dikunci ke Invoice Amount
-- Dari: 20261029_receivable_projection_ikut_invoice_amount.sql
-- =====================================================================

-- =====================================================================
-- Receivable Amount di History Projection Report - disamakan dengan
-- rumus baru, yaitu dikunci ke kolom Invoice Amount.
--
-- MASALAHNYA
--   Dokumen history yang disimpan dengan rumus lama memajang Receivable
--   Amount yang tidak nyambung ke Invoice Amount-nya:
--
--     a. Invoice NAG   -> yang tersimpan nilai PENUH invoice, padahal
--                         Invoice Amount-nya sudah berkurang kena alokasi.
--     b. Invoice NAK   -> yang terbaca baris potongan yang nyangkut di
--        (knitting)      tbl_invoice_pot, bukan tbl_invoice_pot_knitting.
--                         Nilainya bisa jauh berbeda; contoh invoice
--                         0074/L/NAK/0726: 30,91 USD vs 9,53 USD yang benar.
--
-- RUMUS BARUNYA (sama persis dengan Model_report::_attach_receivable_breakdown)
--     Total Invoice = amount x rate
--     VAT           = Total Invoice x (vat / grand_total)
--     Tax Base      = Total Invoice - VAT
--     PPh 23        = Tax Base x mtax.percentage / 100
--     Collection    = Total Invoice - PPh 23
--
-- YANG TIDAK BERUBAH
--   Kolom tanggal (Projected Cash Inflow) dan Total Collection Amount di
--   daftar History dihitung dari RASIO collection/total_invoice, bukan dari
--   nilainya. Rasionya tidak bergeser - sudah diuji ke seluruh 3.074 baris
--   history, selisih terbesarnya 0,0000004. Jadi angka proyeksi kasnya tetap
--   sama persis; yang berubah hanya lima kolom tampilan.
--
-- CARA MENJALANKAN - BERURUTAN, JANGAN DILOMPAT
--   Langkah 1 & 2 cuma melihat, aman dijalankan kapan saja.
--   Langkah 3 baru mengubah data, dan ada cadangannya.
-- =====================================================================


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu berapa baris yang akan berubah
-- ---------------------------------------------------------------------
SELECT h.doc_number,
       DATE(h.created_at)                                  AS disimpan,
       h.periode_dari, h.periode_sampai, h.type,
       COUNT(*)                                            AS baris,
       SUM(ABS(d.total_invoice - d.amount * d.rate) > 1)   AS akan_berubah
FROM   tbl_history_projection_h   h
JOIN   tbl_history_projection_det d ON d.doc_number = h.doc_number
GROUP  BY h.doc_number
HAVING akan_berubah > 0
ORDER  BY h.created_at;


-- ---------------------------------------------------------------------
-- LANGKAH 2 - lihat angka sebelum & sesudahnya, sebelum diubah
--             (ganti nomor dokumennya sesuai hasil langkah 1)
-- ---------------------------------------------------------------------
SELECT d.no_invoice, d.curr, d.amount, d.rate,
       d.total_invoice                      AS total_sekarang,
       ROUND(d.amount * d.rate, 2)          AS total_seharusnya,
       d.tax_base                           AS tax_base_sekarang,
       ROUND(d.amount * d.rate
             - ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2), 2)
                                            AS tax_base_seharusnya
FROM   tbl_history_projection_det d
LEFT   JOIN (
        SELECT bi.no_invoice, pk.vat, pk.grand_total AS gt, bi.id_pph
        FROM   tbl_book_invoice bi
        JOIN   tbl_invoice_pot_knitting pk ON pk.id_book_invoice = bi.id
        WHERE  bi.profit_center = 'NAK'
        UNION ALL
        SELECT bi.no_invoice, p.vat, p.grand_total, bi.id_pph
        FROM   tbl_book_invoice bi
        JOIN   tbl_invoice_pot p ON p.id_book_invoice = bi.id
        WHERE  bi.profit_center <> 'NAK'
        UNION ALL
        SELECT nb.no_inv, np.vat, np.grand_total, nb.id_pph
        FROM   tbl_invoice_nb nb
        JOIN   tbl_invoice_nb_pot np ON np.no_inv = nb.no_inv
       ) c ON c.no_invoice = d.no_invoice
WHERE  d.doc_number = 'PR/0926/00001'
AND    ABS(d.total_invoice - d.amount * d.rate) > 1
ORDER  BY d.no_invoice;


-- ---------------------------------------------------------------------
-- LANGKAH 3 - cadangkan, lalu perbaiki
-- ---------------------------------------------------------------------

-- 3a. Cadangan. Kalau hasilnya tidak sesuai, datanya bisa dikembalikan dari
--     tabel ini. Dibuat sekali; kalau sudah ada, baris ini dilewati sendiri.
CREATE TABLE IF NOT EXISTS tbl_history_projection_det_sebelum_20261029
    LIKE tbl_history_projection_det;

INSERT IGNORE INTO tbl_history_projection_det_sebelum_20261029
SELECT * FROM tbl_history_projection_det;

-- 3b. Perbaikannya.
UPDATE tbl_history_projection_det d
LEFT   JOIN (
        SELECT bi.no_invoice, pk.vat, pk.grand_total AS gt, bi.id_pph
        FROM   tbl_book_invoice bi
        JOIN   tbl_invoice_pot_knitting pk ON pk.id_book_invoice = bi.id
        WHERE  bi.profit_center = 'NAK'
        UNION ALL
        SELECT bi.no_invoice, p.vat, p.grand_total, bi.id_pph
        FROM   tbl_book_invoice bi
        JOIN   tbl_invoice_pot p ON p.id_book_invoice = bi.id
        WHERE  bi.profit_center <> 'NAK'
        UNION ALL
        SELECT nb.no_inv, np.vat, np.grand_total, nb.id_pph
        FROM   tbl_invoice_nb nb
        JOIN   tbl_invoice_nb_pot np ON np.no_inv = nb.no_inv
       ) c ON c.no_invoice = d.no_invoice
LEFT   JOIN mtax m ON m.idtax = c.id_pph
SET    d.total_invoice     = ROUND(d.amount * d.rate, 2),
       d.tax_vat           = ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2),
       d.tax_base          = ROUND(d.amount * d.rate, 2)
                             - ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2),
       d.income_tax_23     = ROUND(
                               (ROUND(d.amount * d.rate, 2)
                                - ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2))
                               * COALESCE(m.percentage, 0) / 100, 2),
       d.collection_amount = ROUND(d.amount * d.rate, 2)
                             - ROUND(
                                 (ROUND(d.amount * d.rate, 2)
                                  - ROUND(d.amount * d.rate * COALESCE(c.vat / NULLIF(c.gt, 0), 0), 2))
                                 * COALESCE(m.percentage, 0) / 100, 2);


-- ---------------------------------------------------------------------
-- LANGKAH 4 - pemeriksaan sesudahnya. Ketiganya HARUS 0.
-- ---------------------------------------------------------------------
SELECT SUM(ABS(total_invoice - amount * rate) > 0.02)              AS total_tidak_pas,
       SUM(ABS((tax_base + tax_vat) - total_invoice) > 0.02)       AS dpp_ppn_tidak_pas,
       SUM(ABS(collection_amount - (total_invoice - income_tax_23)) > 0.02)
                                                                   AS collection_tidak_pas
FROM   tbl_history_projection_det;


-- Kalau hasilnya salah dan mau dikembalikan:
--   DELETE FROM tbl_history_projection_det;
--   INSERT INTO tbl_history_projection_det
--       SELECT * FROM tbl_history_projection_det_sebelum_20261029;
--
-- Kalau sudah yakin benar, cadangannya boleh dibuang:
--   DROP TABLE tbl_history_projection_det_sebelum_20261029;


-- =====================================================================
-- BAGIAN 7 - Kembalikan Receivable history SELAIN PR/0926/00001
-- Dari: 20261029b_receivable_kembalikan_selain_pr0926.sql
-- =====================================================================

-- =====================================================================
-- Kembalikan Receivable Amount history SELAIN PR/0926/00001.
--
-- 20261029_receivable_projection_ikut_invoice_amount.sql menulis ulang
-- SELURUH isi tbl_history_projection_det (UPDATE-nya tanpa WHERE). Yang
-- diminta cuma satu dokumen: PR/0926/00001. Berkas ini mengembalikan
-- dokumen yang lain ke nilai aslinya dari tabel cadangan.
--
-- SYARAT: tbl_history_projection_det_sebelum_20261029 masih ada. Itu
-- cadangan yang dibuat langkah 3a berkas sebelumnya - JANGAN di-DROP
-- sebelum berkas ini dijalankan dan diperiksa.
--
-- AKIBATNYA, supaya tidak kaget: dokumen selain PR/0926/00001 kembali
-- memajang Receivable Amount yang tidak nyambung ke Invoice Amount-nya -
-- nilai penuh invoice untuk baris NAG, dan baris potongan yang ketuker
-- untuk baris knitting. Itu memang isi aslinya waktu dokumen disimpan.
-- Dokumen BARU yang disimpan mulai sekarang tetap memakai rumus baru,
-- karena yang diperbaiki di kodenya tidak ikut dikembalikan.
-- =====================================================================


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu: berapa baris per dokumen yang akan dikembalikan
-- ---------------------------------------------------------------------
SELECT d.doc_number,
       COUNT(*)                                            AS baris,
       SUM(ABS(d.total_invoice - s.total_invoice) > 0.02)  AS akan_dikembalikan
FROM   tbl_history_projection_det d
JOIN   tbl_history_projection_det_sebelum_20261029 s ON s.id = d.id
WHERE  d.doc_number <> 'PR/0926/00001'
GROUP  BY d.doc_number
HAVING akan_dikembalikan > 0
ORDER  BY d.doc_number;


-- ---------------------------------------------------------------------
-- LANGKAH 2 - kembalikan. PR/0926/00001 sengaja dilewati.
-- ---------------------------------------------------------------------
UPDATE tbl_history_projection_det d
JOIN   tbl_history_projection_det_sebelum_20261029 s ON s.id = d.id
SET    d.tax_base          = s.tax_base,
       d.tax_vat           = s.tax_vat,
       d.total_invoice     = s.total_invoice,
       d.income_tax_23     = s.income_tax_23,
       d.collection_amount = s.collection_amount
WHERE  d.doc_number <> 'PR/0926/00001';


-- ---------------------------------------------------------------------
-- LANGKAH 3 - pemeriksaan. Yang boleh beda dari cadangan HANYA
--             PR/0926/00001; dokumen lain harus 0.
-- ---------------------------------------------------------------------
SELECT d.doc_number,
       SUM(ABS(d.total_invoice     - s.total_invoice)     > 0.02
         OR ABS(d.tax_base         - s.tax_base)          > 0.02
         OR ABS(d.tax_vat          - s.tax_vat)           > 0.02
         OR ABS(d.income_tax_23    - s.income_tax_23)     > 0.02
         OR ABS(d.collection_amount- s.collection_amount) > 0.02) AS beda_dari_cadangan
FROM   tbl_history_projection_det d
JOIN   tbl_history_projection_det_sebelum_20261029 s ON s.id = d.id
GROUP  BY d.doc_number
HAVING beda_dari_cadangan > 0
ORDER  BY d.doc_number;
-- Hasil yang benar: cuma satu baris, PR/0926/00001.


-- LANGKAH 4 - PR/0926/00001 sendiri harus tetap pas.
--             Ketiganya harus 0.
SELECT SUM(ABS(total_invoice - amount * rate) > 0.02)                      AS total_tidak_pas,
       SUM(ABS((tax_base + tax_vat) - total_invoice) > 0.02)               AS dpp_ppn_tidak_pas,
       SUM(ABS(collection_amount - (total_invoice - income_tax_23)) > 0.02) AS collection_tidak_pas
FROM   tbl_history_projection_det
WHERE  doc_number = 'PR/0926/00001';


-- Sesudah langkah 3 & 4 benar, cadangannya boleh dibuang:
--   DROP TABLE tbl_history_projection_det_sebelum_20261029;

