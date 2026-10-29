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
