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
