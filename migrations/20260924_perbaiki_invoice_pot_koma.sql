-- ===========================================================================
-- Perbaikan angka rekap invoice yang terpotong karena pemisah ribuan.
--
-- SEBAB
--   Layar Create Invoice baru sempat mengirim angka rekap apa adanya dari
--   kotak isian - lengkap dengan pemisah ribuan ("221,033,314.04"). Kolomnya
--   DECIMAL, jadi MySQL memotongnya di koma PERTAMA dan menyimpan "221" tanpa
--   memberi error (server ini tidak memakai strict mode), sehingga Save tetap
--   terlihat berhasil. Baris SJ-nya (tbl_invoice_detail / _knitting) TIDAK
--   terpengaruh - angkanya dikirim polos dan tersimpan benar.
--
--   Penyebabnya sudah diperbaiki di aplikasi (payloadPot di
--   crud-create-invoice.js mengirim angka polos), jadi invoice baru sudah
--   aman. Berkas ini hanya untuk invoice yang terlanjur tersimpan.
--
-- YANG DIPERBAIKI
--   tbl_invoice_pot dan tbl_invoice_pot_knitting - hanya baris yang memang
--   rusak, yaitu yang total-nya jauh lebih kecil dari jumlah baris SJ-nya.
--   Angka penggantinya diambil dari booking Invoice EXIM
--   (tbl_book_invoice_exim_pot) yang menyimpan nilai aslinya dengan benar.
--
-- CARA PAKAI
--   Jalankan langkah 1 dulu dan cocokkan angkanya. Baru jalankan langkah 2
--   dan 3. Langkah 4 memperlihatkan invoice yang tidak bisa diperbaiki
--   otomatis (booking-nya bukan dari Invoice EXIM), dan langkah 5 memeriksa
--   hasil akhirnya - harus kosong.
--
--   Kalau DP / DP CBD / Return sempat DIUBAH di layar Create Invoice (berbeda
--   dengan yang diisi waktu booking di Invoice EXIM), angka penggantinya ikut
--   yang dari booking - periksa kolom pembanding di langkah 1.
-- ===========================================================================

-- ---------------------------------------------------------------------------
-- 1. LIHAT DULU: yang tersimpan vs yang seharusnya
-- ---------------------------------------------------------------------------
SELECT a.id, a.no_invoice, a.profit_center, a.status,
       p.total        AS total_tersimpan,
       ROUND(e.total, 2)       AS total_seharusnya,
       ROUND(d.total_detail,2) AS total_dari_baris_sj,
       p.discount     AS disc_tersimpan,  ROUND(e.discount, 2)    AS disc_seharusnya,
       p.dp           AS dp_tersimpan,    ROUND(e.dp, 2)          AS dp_booking,
       p.retur        AS retur_tersimpan, ROUND(e.retur, 2)       AS retur_booking,
       p.twot         AS twot_tersimpan,  ROUND(e.twot, 2)        AS twot_seharusnya,
       e.vat_persen,
       p.vat          AS vat_tersimpan,   ROUND(e.vat, 2)         AS vat_seharusnya,
       p.grand_total  AS grand_tersimpan, ROUND(e.grand_total, 2) AS grand_seharusnya
  FROM tbl_book_invoice a
  INNER JOIN tbl_invoice_pot p ON p.id_book_invoice = a.id
  INNER JOIN (SELECT id_book_invoice, SUM(total_price) AS total_detail
                FROM tbl_invoice_detail
               GROUP BY id_book_invoice) d ON d.id_book_invoice = a.id
  LEFT JOIN tbl_book_invoice_exim_pot e ON e.id_book_invoice = a.id
 WHERE p.total < ROUND(d.total_detail, 2) - 1
 ORDER BY a.id;

-- ---------------------------------------------------------------------------
-- 2. PERBAIKI tbl_invoice_pot (semua invoice: garment & knitting)
-- ---------------------------------------------------------------------------
UPDATE tbl_invoice_pot p
 INNER JOIN tbl_book_invoice_exim_pot e ON e.id_book_invoice = p.id_book_invoice
 INNER JOIN (SELECT id_book_invoice, SUM(total_price) AS total_detail
               FROM tbl_invoice_detail
              GROUP BY id_book_invoice) d ON d.id_book_invoice = p.id_book_invoice
   SET p.total       = ROUND(e.total, 2),
       p.discount    = ROUND(e.discount, 2),
       p.dp          = ROUND(e.dp, 2),
       p.retur       = ROUND(e.retur, 2),
       p.twot        = ROUND(e.twot, 2),
       p.vat         = ROUND(e.vat, 2),
       p.grand_total = ROUND(e.grand_total, 2)
 WHERE p.total < ROUND(d.total_detail, 2) - 1;

-- ---------------------------------------------------------------------------
-- 3. PERBAIKI tbl_invoice_pot_knitting (khusus invoice NAK)
--    total_other tidak diubah - Other Charge memang tidak dipakai lagi.
-- ---------------------------------------------------------------------------
UPDATE tbl_invoice_pot_knitting p
 INNER JOIN tbl_book_invoice_exim_pot e ON e.id_book_invoice = p.id_book_invoice
 INNER JOIN (SELECT id_book_invoice, SUM(total_price) AS total_detail
               FROM tbl_invoice_detail_knitting
              GROUP BY id_book_invoice) d ON d.id_book_invoice = p.id_book_invoice
   SET p.total       = ROUND(e.total, 2),
       p.discount    = ROUND(e.discount, 2),
       p.dp          = ROUND(e.dp, 2),
       p.retur       = ROUND(e.retur, 2),
       p.twot        = ROUND(e.twot, 2),
       p.vat         = ROUND(e.vat, 2),
       p.grand_total = ROUND(e.grand_total, 2)
 WHERE p.total < ROUND(d.total_detail, 2) - 1;

-- ---------------------------------------------------------------------------
-- 4. SISANYA: invoice rusak yang booking-nya BUKAN dari Invoice EXIM.
--    Tidak ada sumber angka aslinya, jadi harus diisi tangan. Kolom
--    total_seharusnya & disc_seharusnya di bawah dihitung ulang dari baris
--    SJ-nya; DP / Return / VAT isi sesuai yang dulu diketik.
-- ---------------------------------------------------------------------------
SELECT a.id, a.no_invoice, a.profit_center,
       p.total AS total_tersimpan,
       ROUND(d.total_detail, 2) AS total_seharusnya,
       ROUND(d.disc_detail, 2)  AS disc_seharusnya,
       p.dp, p.retur, p.vat, p.grand_total
  FROM tbl_book_invoice a
  INNER JOIN tbl_invoice_pot p ON p.id_book_invoice = a.id
  INNER JOIN (SELECT id_book_invoice,
                     SUM(total_price) AS total_detail,
                     SUM(total_price * disc / 100) AS disc_detail
                FROM tbl_invoice_detail
               GROUP BY id_book_invoice) d ON d.id_book_invoice = a.id
  LEFT JOIN tbl_book_invoice_exim_pot e ON e.id_book_invoice = a.id
 WHERE p.total < ROUND(d.total_detail, 2) - 1
   AND e.id_book_invoice IS NULL
 ORDER BY a.id;

-- ---------------------------------------------------------------------------
-- 5. PERIKSA HASILNYA - harus kosong, kecuali invoice yang muncul di
--    langkah 4 (itu memang menunggu diisi tangan)
-- ---------------------------------------------------------------------------
SELECT 'tbl_invoice_pot' AS tabel, a.id, a.no_invoice,
       p.total, ROUND(d.total_detail, 2) AS total_dari_baris_sj
  FROM tbl_book_invoice a
  INNER JOIN tbl_invoice_pot p ON p.id_book_invoice = a.id
  INNER JOIN (SELECT id_book_invoice, SUM(total_price) AS total_detail
                FROM tbl_invoice_detail
               GROUP BY id_book_invoice) d ON d.id_book_invoice = a.id
 WHERE ABS(p.total - ROUND(d.total_detail, 2)) > 1
UNION ALL
SELECT 'tbl_invoice_pot_knitting', a.id, a.no_invoice,
       p.total, ROUND(d.total_detail, 2)
  FROM tbl_book_invoice a
  INNER JOIN tbl_invoice_pot_knitting p ON p.id_book_invoice = a.id
  INNER JOIN (SELECT id_book_invoice, SUM(total_price) AS total_detail
                FROM tbl_invoice_detail_knitting
               GROUP BY id_book_invoice) d ON d.id_book_invoice = a.id
 WHERE ABS(p.total - ROUND(d.total_detail, 2)) > 1;
