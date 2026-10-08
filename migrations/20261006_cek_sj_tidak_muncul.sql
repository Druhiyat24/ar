-- ===========================================================================
--  KENAPA SJ TIDAK MUNCUL DI CREATE INVOICE EXIM
-- ===========================================================================
--  CUMA SELECT - tidak mengubah apa pun, aman dijalankan di live.
--
--  Dijalankan di database signalbit_erp (yang memuat bppb).
--
--  Daftar SJ di layar Create Invoice EXIM disaring tujuh syarat di query-nya
--  (InvoiceEximController::sjGarment) ditambah satu saringan "sudah dipakai
--  invoice lain" (saringTerpakai). Query di bawah memeriksa satu per satu dan
--  menyebutkan syarat mana yang menolaknya.
--
--  GANTI daftar nomor di BAGIAN 1 sesuai yang mau diperiksa.
-- ===========================================================================


-- ===========================================================================
--  BAGIAN 1 - PERIKSA SJ-NYA
--
--  Baca kolom "kesimpulan" lebih dulu. Kalau isinya "MUNCUL", berarti SJ-nya
--  lolos semua syarat dan yang salah ada di pilihan di layar - lihat BAGIAN 2.
--
--  Kalau nomornya TIDAK muncul sama sekali di hasil ini, berarti nomor itu
--  memang tidak ada di tabel bppb (salah ketik, atau SJ-nya dari knitting -
--  knitting ada di database lain, lihat BAGIAN 3).
-- ===========================================================================
SELECT c.bppbno_int                                   AS sj,
       c.bppbdate,
       c.jenis_trans,
       c.id_supplier,
       f.Supplier                                     AS nama_supplier,
       f.tipe_sup,
       c.stat_inv,
       c.confirm,
       c.cancel,

       CASE
         WHEN f.Id_Supplier IS NULL
           THEN 'TIDAK MUNCUL - id_supplier tidak ada di mastersupplier'
         WHEN c.bppbno_int NOT REGEXP '^(FG|GK|GEN|WIP|GACC|SCR|SPCK)/OUT/'
           THEN 'TIDAK MUNCUL - tipe pengeluarannya belum diizinkan ditagih'
         WHEN NOT ((c.bppbno_int LIKE 'FG/OUT/%' AND c.bppbdate < '2026-08-01')
                   OR c.jenis_trans LIKE 'Penjualan%'
                   OR c.jenis_trans LIKE 'Pengiriman ke Subkontraktor CMT%'
                   OR c.jenis_trans LIKE 'Pengiriman Sample%')
           THEN CONCAT('TIDAK MUNCUL - jenis_trans "', IFNULL(c.jenis_trans, ''),
                       '" tidak termasuk yang ditagihkan')
         WHEN c.id_supplier = '1038'
           THEN 'TIDAK MUNCUL - supplier 1038 memang dikecualikan'
         WHEN NOT (c.stat_inv IS NULL OR c.stat_inv = '' OR c.stat_inv = '0')
           THEN CONCAT('TIDAK MUNCUL - sudah ditandai di-invoice (stat_inv = ',
                       c.stat_inv, ')')
         WHEN c.confirm <> 'Y' OR c.confirm IS NULL
           THEN 'TIDAK MUNCUL - belum di-confirm (confirm <> Y)'
         WHEN c.cancel = 'Y'
           THEN 'TIDAK MUNCUL - SJ-nya cancel'
         WHEN c.bppbno_int LIKE 'FG/OUT/%' AND IFNULL(f.tipe_sup, '') <> 'C'
           THEN 'TIDAK MUNCUL - penerimanya bukan customer (tipe_sup <> C)'
         WHEN dipakai.no_invoice IS NOT NULL
           THEN CONCAT('TIDAK MUNCUL - sudah dipakai invoice ', dipakai.no_invoice)
         ELSE 'MUNCUL - lolos semua syarat, lihat BAGIAN 2'
       END                                            AS kesimpulan,

       dipakai.no_invoice                             AS dipakai_invoice

  FROM bppb AS c
  LEFT JOIN mastersupplier AS f ON f.Id_Supplier = c.id_supplier
  LEFT JOIN (
        SELECT x.id_baris, MIN(bi.no_invoice) AS no_invoice
          FROM tbl_book_invoice_exim_det x
          INNER JOIN tbl_book_invoice bi ON bi.id = x.id_book_invoice
         WHERE x.asal = 'NAG' AND UPPER(IFNULL(bi.status, '')) <> 'CANCEL'
         GROUP BY x.id_baris
       ) AS dipakai ON dipakai.id_baris = c.id

 WHERE c.bppbno_int IN ('GACC/OUT/1026/12756',
                        'GACC/OUT/1026/12757',
                        'GACC/OUT/1026/12758')
 ORDER BY c.bppbno_int;


-- ===========================================================================
--  BAGIAN 2 - KALAU KESIMPULANNYA "MUNCUL"
--
--  Berarti SJ-nya memang layak, dan yang menyaring adalah pilihan di layar:
--
--    a. RENTANG TANGGAL. Daftar SJ disaring bppbdate BETWEEN awal AND akhir.
--       Bandingkan kolom bppbdate di BAGIAN 1 dengan tanggal yang dipilih di
--       modal "Add SJ". Nomor 1026 = Oktober 2026, tapi bppbdate-nya belum
--       tentu bulan itu - yang dipakai tanggal SJ, bukan nomornya.
--
--    b. CUSTOMER / BUYER. Kalau Buyer dipilih di modal, cuma SJ milik
--       Id_Supplier itu yang muncul. Bandingkan dengan kolom id_supplier &
--       nama_supplier di BAGIAN 1.
--
--    c. PROFIT CENTER. Layar NAG cuma menampilkan SJ garment (bppb). Kalau
--       bookingnya NAK, daftarnya diambil dari knitting - lihat BAGIAN 3.
-- ===========================================================================
-- Rentang tanggal & supplier yang benar untuk ketiga SJ ini:
SELECT MIN(c.bppbdate) AS tanggal_paling_awal,
       MAX(c.bppbdate) AS tanggal_paling_akhir,
       GROUP_CONCAT(DISTINCT c.id_supplier) AS id_supplier_yang_harus_dipilih
  FROM bppb AS c
 WHERE c.bppbno_int IN ('GACC/OUT/1026/12756',
                        'GACC/OUT/1026/12757',
                        'GACC/OUT/1026/12758');


-- ===========================================================================
--  BAGIAN 3 - KALAU NOMORNYA TIDAK ADA SAMA SEKALI DI bppb
--
--  Cari nomor yang mirip - mungkin beda ejaan atau tersimpan di kolom lain.
-- ===========================================================================
SELECT id, bppbno, bppbno_int, bppbdate, jenis_trans, id_supplier,
       stat_inv, confirm, cancel
  FROM bppb
 WHERE bppbno_int LIKE 'GACC/OUT/1026/1275%'
    OR bppbno    LIKE '%1275%' AND bppbno LIKE 'GACC%'
 ORDER BY bppbno_int;


-- Semua jenis_trans yang ADA untuk tipe GACC - dipakai memastikan apakah
-- jenis_trans-nya memang belum masuk daftar yang ditagihkan.
SELECT c.jenis_trans, COUNT(*) AS jumlah_sj,
       MIN(c.bppbdate) AS dari, MAX(c.bppbdate) AS sampai
  FROM bppb AS c
 WHERE c.bppbno_int LIKE 'GACC/OUT/%'
 GROUP BY c.jenis_trans
 ORDER BY jumlah_sj DESC;
