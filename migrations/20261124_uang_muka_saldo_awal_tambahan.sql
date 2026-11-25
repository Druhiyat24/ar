-- ================================================================================
-- Sub Ledger Uang Muka Penjualan - dua nomor yang dikeluhkan tim AR
-- Dibuat 2026-11-24.
--
-- LATARNYA
-- Laporan ini DIMULAI 1 Oktober 2026 (Model_nag::AWAL_UANG_MUKA). Mutasi
-- sebelum tanggal itu tidak dihitung ulang dari buku besar - satu-satunya
-- jalan masuknya lewat tbl_uang_muka_awal, yang isinya saldo per
-- 30 September 2026 hasil pemeriksaan tim AR
-- (migrations/20261027d_uang_muka_saldo_awal_isi.sql, 7 baris).
--
-- Karena itu dokumen bertanggal sebelum 1 Oktober 2026 yang TIDAK ada di
-- ketujuh baris itu memang tidak akan pernah muncul di laporan. Itulah yang
-- terjadi pada dua nomor berikut:
--
--   1. BM/BCA1979/NAG/1225/00002 - 5 Des 2025, PT DIZAMATRA POWERINDO,
--      IDR 2.000.000, COA 2.40.01. Jurnalnya ada (kredit 2.40.01), tapi
--      nomornya tidak ada di lembar kerja saldo awal, jadi tidak ikut
--      terbawa. Berkas ini menambahkannya.
--
--   2. GM/NAG/0826/00217 - 31 Agu 2026, PT SUMBER MEKAR TEKSTIL INDUSTRI,
--      PI-46265, IDR 4.803.104,90. Yang ini sebetulnya SUDAH ada di laporan
--      (nilainya ikut di TOTAL IDR 247.401.706,04), hanya saja nomor BM-nya
--      tersimpan sebagai GM/NAG/0926/00024. PI, tanggal, customer dan
--      nilainya sama persis - jadi yang perlu dibetulkan nomornya saja,
--      BUKAN ditambah baris baru. Kalau ditambah, nilainya jadi dobel.
--
-- YANG DISENTUH
-- Hanya tbl_uang_muka_awal: satu baris ditambah, satu nomor dibetulkan.
-- Tidak ada jurnal, invoice, atau alokasi yang diubah.
--
-- AMAN DIULANG - barisnya dihapus dulu berdasarkan COA + nomor dokumennya,
-- dan pembetulan nomor BM-nya cuma jalan kalau memang masih perlu.
--
-- SESUDAH DIJALANKAN
-- Total Beginning Balance 2.40.01 IDR berubah dari 247.401.706,04 (3 baris)
-- menjadi 249.401.706,04 (4 baris).
--
-- CARA MEMUNDURKAN
--   DELETE FROM tbl_uang_muka_awal
--    WHERE no_coa = '2.40.01' AND no_dokumen = 'BM/BCA1979/NAG/1225/00002';
--   UPDATE tbl_uang_muka_awal SET no_bm = 'GM/NAG/0926/00024'
--    WHERE no_coa = '2.40.01' AND no_dokumen = 'PI-46265';
-- ================================================================================


-- --------------------------------------------------------------------------------
-- LANGKAH 1 - PERIKSA DULU: apa betul sisanya 2.000.000?
--
-- Uang muka DIZAMATRA tidak dipasangkan lewat Proforma Invoice, jadi sisanya
-- tidak bisa dibaca per dokumen - yang bisa ditunjukkan mutasinya di COA
-- 2.40.01 untuk customer itu sampai 30 September 2026. Periksa dulu
-- hasilnya; kalau sisanya ternyata bukan 2.000.000, ganti angkanya di
-- LANGKAH 2 (dua tempat: amount dan amount_idr) sebelum dijalankan.
-- --------------------------------------------------------------------------------
SELECT j.no_journal,
       j.tgl_journal,
       j.curr,
       j.credit                                  AS uang_masuk,
       j.debit                                   AS terpakai,
       j.status,
       j.profit_center,
       IFNULL(NULLIF(TRIM(j.supplier), ''), j.buyer) AS customer
  FROM tbl_list_journal AS j
 WHERE j.no_coa = '2.40.01'
   AND j.tgl_journal <= '2026-09-30'
   AND IFNULL(j.status, '') NOT LIKE 'CANCEL%'
   AND (UPPER(IFNULL(j.supplier, '')) LIKE '%DIZAMATRA%'
     OR UPPER(IFNULL(j.buyer, ''))    LIKE '%DIZAMATRA%')
 ORDER BY j.tgl_journal, j.no_journal;

-- Ringkasannya: sisa uang muka DIZAMATRA di COA 2.40.01 per 30 Sep 2026.
SELECT ROUND(SUM(j.credit), 2)                AS total_masuk,
       ROUND(SUM(j.debit), 2)                 AS total_terpakai,
       ROUND(SUM(j.credit) - SUM(j.debit), 2) AS sisa_per_30sep2026
  FROM tbl_list_journal AS j
 WHERE j.no_coa = '2.40.01'
   AND j.tgl_journal <= '2026-09-30'
   AND IFNULL(j.status, '') NOT LIKE 'CANCEL%'
   AND (UPPER(IFNULL(j.supplier, '')) LIKE '%DIZAMATRA%'
     OR UPPER(IFNULL(j.buyer, ''))    LIKE '%DIZAMATRA%');


-- --------------------------------------------------------------------------------
-- LANGKAH 2 - MASUKKAN baris BM/BCA1979/NAG/1225/00002
--
-- Tidak ada nomor PI-nya, jadi no_dokumen diisi nomor BM-nya (sesuai aturan
-- kolom itu) dan no_pi dibiarkan kosong - kolom PI No di laporan jadi strip.
--
-- Customer dicari lewat namanya DI SERVER INI, dengan titik & spasi
-- diabaikan: masternya menulis "PT.DIZAMATRA POWERINDO" sementara lembar
-- kerja AR menulis "PT DIZAMATRA POWERINDO". Kalau tetap tidak ketemu, yang
-- tersimpan namanya dan laporannya tetap menampilkan nama itu.
--
-- Profit center DIBACA dari jurnalnya sendiri, bukan ditebak dari nomornya;
-- baris jurnal di COA uang muka yang sama didahulukan, lalu baris lain dari
-- jurnal yang sama, baru bawaan NAG.
-- --------------------------------------------------------------------------------
DELETE FROM tbl_uang_muka_awal
 WHERE no_coa = '2.40.01' AND no_dokumen = 'BM/BCA1979/NAG/1225/00002';

INSERT INTO tbl_uang_muka_awal
       (no_coa, no_dokumen, no_pi, id_customer, customer, payer, profit_center, curr,
        amount, amount_idr, tgl_masuk, no_bm, tgl_bm, no_alokasi, tgl_alokasi,
        keterangan)
SELECT '2.40.01'                            AS no_coa,
       'BM/BCA1979/NAG/1225/00002'          AS no_dokumen,
       NULL                                 AS no_pi,
       (SELECT s.Id_Supplier FROM mastersupplier AS s
         WHERE s.tipe_sup = 'C'
           AND REPLACE(REPLACE(UPPER(TRIM(s.Supplier)), '.', ''), ' ', '')
             = 'PTDIZAMATRAPOWERINDO'
         LIMIT 1)                           AS id_customer,
       'PT DIZAMATRA POWERINDO'             AS customer,
       IFNULL((SELECT s2.Id_Supplier FROM mastersupplier AS s2
                WHERE s2.tipe_sup = 'C'
                  AND REPLACE(REPLACE(UPPER(TRIM(s2.Supplier)), '.', ''), ' ', '')
                    = 'PTDIZAMATRAPOWERINDO'
                LIMIT 1),
              'PT DIZAMATRA POWERINDO')     AS payer,
       COALESCE((SELECT j.profit_center FROM tbl_list_journal AS j
                  WHERE j.no_journal = 'BM/BCA1979/NAG/1225/00002'
                    AND j.no_coa = '2.40.01'
                    AND IFNULL(j.profit_center, '') <> '' LIMIT 1),
                (SELECT j2.profit_center FROM tbl_list_journal AS j2
                  WHERE j2.no_journal = 'BM/BCA1979/NAG/1225/00002'
                    AND IFNULL(j2.profit_center, '') <> '' LIMIT 1),
                'NAG')                      AS profit_center,
       'IDR'                                AS curr,
       2000000.00                           AS amount,
       2000000.00                           AS amount_idr,
       DATE '2025-12-05'                    AS tgl_masuk,
       'BM/BCA1979/NAG/1225/00002'          AS no_bm,
       DATE '2025-12-05'                    AS tgl_bm,
       NULL                                 AS no_alokasi,
       NULL                                 AS tgl_alokasi,
       'saldo awal per 2026-10-01'          AS keterangan;


-- --------------------------------------------------------------------------------
-- LANGKAH 3 - BETULKAN nomor BM baris PI-46265
--
-- Nomor yang benar diputuskan oleh jurnalnya, bukan oleh berkas ini:
-- nomornya diganti HANYA kalau GM/NAG/0826/00217 ada di tbl_list_journal
-- sementara GM/NAG/0926/00024 tidak. Kalau dua-duanya ada, atau dua-duanya
-- tidak ada, tidak ada yang diubah - hasilnya kelihatan di LANGKAH 4b dan
-- tim AR tinggal menjalankan UPDATE manual di bawah ini.
-- --------------------------------------------------------------------------------
SET @ada_0826 := (SELECT COUNT(*) FROM tbl_list_journal
                   WHERE no_journal = 'GM/NAG/0826/00217');
SET @ada_0926 := (SELECT COUNT(*) FROM tbl_list_journal
                   WHERE no_journal = 'GM/NAG/0926/00024');

UPDATE tbl_uang_muka_awal
   SET no_bm = 'GM/NAG/0826/00217'
 WHERE no_coa = '2.40.01'
   AND no_dokumen = 'PI-46265'
   AND IFNULL(no_bm, '') <> 'GM/NAG/0826/00217'
   AND @ada_0826 > 0
   AND @ada_0926 = 0;

-- Kalau LANGKAH 4b bilang nomornya belum berubah padahal tim AR yakin
-- GM/NAG/0826/00217 yang benar, jalankan yang ini:
--
--   UPDATE tbl_uang_muka_awal SET no_bm = 'GM/NAG/0826/00217'
--    WHERE no_coa = '2.40.01' AND no_dokumen = 'PI-46265';


-- --------------------------------------------------------------------------------
-- LANGKAH 4 - PERIKSA hasilnya
-- --------------------------------------------------------------------------------
-- 4a. isi tabelnya sekarang - kolom customer_tampil & payer_tampil inilah
--     yang muncul di laporan; pastikan isinya nama, bukan angka.
SELECT w.no_coa, w.no_dokumen, w.no_pi, w.profit_center, w.curr, w.amount,
       w.tgl_masuk, w.no_bm,
       UPPER(IFNULL(NULLIF(TRIM(sc.Supplier), ''),
                    IFNULL(NULLIF(TRIM(w.customer), ''), w.id_customer))) AS customer_tampil,
       UPPER(IFNULL(NULLIF(TRIM(sp.Supplier), ''), IFNULL(TRIM(w.payer), ''))) AS payer_tampil
  FROM tbl_uang_muka_awal AS w
  LEFT JOIN mastersupplier AS sc ON sc.Id_Supplier = w.id_customer
  LEFT JOIN mastersupplier AS sp ON sp.Id_Supplier = w.payer
 ORDER BY w.no_coa, w.tgl_masuk, w.no_dokumen;

-- 4b. nomor BM baris PI-46265 - sudah berubah atau belum, dan kenapa.
SELECT w.no_bm                                   AS no_bm_sekarang,
       @ada_0826                                 AS jurnal_gm_0826_00217,
       @ada_0926                                 AS jurnal_gm_0926_00024,
       IF(w.no_bm = 'GM/NAG/0826/00217', 'sudah dibetulkan',
          IF(@ada_0826 > 0 AND @ada_0926 > 0,
             'DIPERIKSA MANUAL - dua-duanya ada di jurnal',
             IF(@ada_0826 = 0 AND @ada_0926 = 0,
                'DIPERIKSA MANUAL - dua-duanya tidak ada di jurnal',
                'dibiarkan - jurnalnya memilih nomor yang lama'))) AS catatan
  FROM tbl_uang_muka_awal AS w
 WHERE w.no_coa = '2.40.01' AND w.no_dokumen = 'PI-46265';

-- 4c. jumlahnya per COA & mata uang.
--     Harapannya: 2.40.01 IDR = 249.401.706,04 dari 4 baris
--                 2.40.02 USD =      19.312,94 dari 4 baris
SELECT no_coa, curr, COUNT(*) AS jumlah_baris,
       ROUND(SUM(amount), 2)     AS jumlah_amount,
       ROUND(SUM(amount_idr), 2) AS jumlah_idr
  FROM tbl_uang_muka_awal
 GROUP BY no_coa, curr
 ORDER BY no_coa, curr;
