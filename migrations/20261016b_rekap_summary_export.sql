-- ================================================================================
-- PERBAIKAN DATA - Invoice Export: rekap uangnya diselaraskan dengan barisnya
-- Dibuat 2026-10-16.
--
-- MASALAHNYA
-- Di cetakan Invoice Export ada dua angka yang berdampingan:
--   Sub Total          -> dijumlah dari baris Invoice Summary
--   Net Invoice Total  -> diambil dari baris rekap (tbl_book_invoice_exim_pot)
-- Waktu baris Invoice Summary dirapikan dari AR, barisnya memang ditulis ulang
-- tapi baris rekapnya TIDAK ikut dihitung ulang. Jadi dua angka itu bicara soal
-- isi yang berbeda. Contoh nyatanya 0230/E/NAG/1026 (TFKC26100165):
--   Sub Total 4.044,62  vs  Net Invoice Total 3.211,99
-- Selisih 832,63 itu persis satu baris summary yang ditambahkan dari AR.
--
-- Programnya sudah dibetulkan: tiap Invoice Summary disimpan dari AR, rekapnya
-- ikut dihitung ulang. Berkas ini membereskan invoice yang SUDAH tersimpan
-- sebelum perbaikan itu.
--
-- YANG DISENTUH
-- Hanya invoice Export yang rekapnya memang tidak cocok dengan barisnya
-- (selisih lebih dari 0,01). Invoice yang angkanya sudah benar tidak diutak-atik.
-- DP, DP/CBD, retur & tarif VAT TIDAK diubah - itu isian orang, bukan hasil
-- hitungan baris.
--
-- RUMUSNYA - sama persis dengan yang dipakai menu Invoice EXIM:
--   total    = jumlah nilai KOTOR tiap baris (sebelum diskon)
--   discount = kotor - bersih
--   twot     = bersih - DP - DP/CBD - retur
--   vat      = twot x tarif
--   grand    = twot + vat
-- Nilai bersih tiap baris diambil dari total_cm yang TERSIMPAN, bukan dihitung
-- ulang dari unit cost - unit cost yang tersimpan sudah dibulatkan 4 angka,
-- menghitung ulang dari situ melesetkan totalnya.
--
-- AMAN DIULANG. Baris yang sudah cocok tidak lolos saringan, jadi menjalankan
-- berkas ini dua kali hasilnya sama.
--
-- CARA MEMUNDURKAN
-- Nilai lamanya disalin dulu ke tbl_book_invoice_exim_pot_bak_20261016.
--   UPDATE tbl_book_invoice_exim_pot p
--     JOIN tbl_book_invoice_exim_pot_bak_20261016 b ON b.id = p.id
--      SET p.total = b.total, p.discount = b.discount, p.twot = b.twot,
--          p.vat = b.vat, p.grand_total = b.grand_total;
-- ================================================================================


-- --------------------------------------------------------------------------------
-- LANGKAH 0 - lihat dulu invoice mana saja yang akan dibetulkan
-- Jalankan sendiri kalau mau memeriksa sebelum mengubah apa pun.
-- --------------------------------------------------------------------------------
-- SELECT i.no_invoice, p.grand_total AS net_sekarang,
--        ROUND(r.bersih, 2) AS net_seharusnya,
--        ROUND(r.bersih - p.grand_total, 2) AS selisih
--   FROM tbl_book_invoice_exim_pot p
--   JOIN tbl_book_invoice i ON i.id = p.id_book_invoice
--   JOIN (SELECT id_book_invoice,
--                SUM(total_cm) AS bersih,
--                SUM(total_cm / (1 - IFNULL(disc,0)/100)) AS kotor
--           FROM tbl_book_invoice_exim_export_det
--          WHERE IFNULL(disc,0) < 100
--          GROUP BY id_book_invoice) r ON r.id_book_invoice = p.id_book_invoice
--  WHERE i.shipp = 'Export'
--    AND ABS(p.total - r.kotor) > 0.01;


-- --------------------------------------------------------------------------------
-- LANGKAH 1 - salin dulu nilai lamanya
-- --------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_book_invoice_exim_pot_bak_20261016 (
    id INT NOT NULL,
    id_book_invoice INT NULL,
    total DOUBLE NULL,
    discount DOUBLE NULL,
    twot DOUBLE NULL,
    vat DOUBLE NULL,
    grand_total DOUBLE NULL,
    disalin_pada DATETIME NULL,
    PRIMARY KEY (id)
) COMMENT 'Cadangan sebelum migrations/20261016b - rekap Invoice Export diselaraskan';

INSERT INTO tbl_book_invoice_exim_pot_bak_20261016
    (id, id_book_invoice, total, discount, twot, vat, grand_total, disalin_pada)
SELECT p.id, p.id_book_invoice, p.total, p.discount, p.twot, p.vat, p.grand_total, NOW()
  FROM tbl_book_invoice_exim_pot p
  JOIN tbl_book_invoice i ON i.id = p.id_book_invoice
  JOIN (SELECT id_book_invoice,
               SUM(total_cm) AS bersih,
               SUM(total_cm / (1 - IFNULL(disc,0)/100)) AS kotor
          FROM tbl_book_invoice_exim_export_det
         WHERE IFNULL(disc,0) < 100
         GROUP BY id_book_invoice) r ON r.id_book_invoice = p.id_book_invoice
 WHERE i.shipp = 'Export'
   AND ABS(IFNULL(p.total,0) - r.kotor) > 0.01
   AND p.id NOT IN (SELECT id FROM tbl_book_invoice_exim_pot_bak_20261016);


-- --------------------------------------------------------------------------------
-- LANGKAH 2 - rekapnya dihitung ulang dari barisnya
-- --------------------------------------------------------------------------------
UPDATE tbl_book_invoice_exim_pot p
  JOIN tbl_book_invoice i ON i.id = p.id_book_invoice
  JOIN (SELECT id_book_invoice,
               SUM(total_cm) AS bersih,
               SUM(total_cm / (1 - IFNULL(disc,0)/100)) AS kotor
          FROM tbl_book_invoice_exim_export_det
         WHERE IFNULL(disc,0) < 100
         GROUP BY id_book_invoice) r ON r.id_book_invoice = p.id_book_invoice
   SET p.total       = ROUND(r.kotor, 4),
       p.discount    = ROUND(r.kotor - r.bersih, 4),
       p.twot        = ROUND(r.bersih - IFNULL(p.dp,0) - IFNULL(p.dp_cbd,0) - IFNULL(p.retur,0), 4),
       p.vat         = ROUND((r.bersih - IFNULL(p.dp,0) - IFNULL(p.dp_cbd,0) - IFNULL(p.retur,0))
                             * IFNULL(p.vat_persen,0) / 100, 4),
       p.grand_total = ROUND((r.bersih - IFNULL(p.dp,0) - IFNULL(p.dp_cbd,0) - IFNULL(p.retur,0))
                             * (1 + IFNULL(p.vat_persen,0) / 100), 4)
 WHERE i.shipp = 'Export'
   AND ABS(IFNULL(p.total,0) - r.kotor) > 0.01;


-- --------------------------------------------------------------------------------
-- LANGKAH 3 - periksa hasilnya: seharusnya tidak ada baris yang keluar lagi
-- --------------------------------------------------------------------------------
SELECT i.no_invoice, p.total, p.grand_total, ROUND(r.kotor, 4) AS kotor_baris
  FROM tbl_book_invoice_exim_pot p
  JOIN tbl_book_invoice i ON i.id = p.id_book_invoice
  JOIN (SELECT id_book_invoice,
               SUM(total_cm) AS bersih,
               SUM(total_cm / (1 - IFNULL(disc,0)/100)) AS kotor
          FROM tbl_book_invoice_exim_export_det
         WHERE IFNULL(disc,0) < 100
         GROUP BY id_book_invoice) r ON r.id_book_invoice = p.id_book_invoice
 WHERE i.shipp = 'Export'
   AND ABS(IFNULL(p.total,0) - r.kotor) > 0.01;
