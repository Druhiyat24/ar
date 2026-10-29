-- =====================================================================
-- URGENT - Edit Invoice: "Duplicate entry ... for key 'id'"
--
-- GEJALANYA
-- Sesudah Save gagal di langkah "Clearing the previous rows", menekan
-- Try Again berakhir dengan:
--   Error Number: 1062 - Duplicate entry '209787' for key 'id'
--   INSERT INTO tbl_invoice_detail_edit ...
--
-- SEBABNYA
-- Langkah pembersihan itu mengerjakan tiga hal berurutan:
--   1. arsipkan baris detail  -> tbl_invoice_detail_edit
--   2. arsipkan baris potongan -> tbl_invoice_pot_edit
--   3. hapus barisnya dari tbl_invoice_detail & tbl_invoice_pot
--
-- Percobaan pertama berhenti di langkah 2 (kolom dp_cbd belum ada di
-- tabel arsipnya - lihat migrasi 20261023b). Langkah 1 TERLANJUR jalan,
-- jadi barisnya sudah ada di arsip sementara aslinya belum terhapus.
-- Try Again mengulang dari langkah 1 -> id yang sama diarsipkan lagi ->
-- 1062.
--
-- Skrip ini membuang arsip yang terlanjur itu, supaya Edit bisa diulang.
-- Yang dibuang HANYA baris arsip yang id-nya MASIH ADA di tabel aslinya -
-- itu tandanya pembersihannya memang tidak pernah selesai. Arsip dari
-- edit yang sudah berhasil tidak tersentuh.
--
-- Jalankan 20261023b LEBIH DULU - tanpa itu Edit-nya akan gagal lagi di
-- langkah yang sama.
--
-- AMAN DIULANG. Tidak menyentuh data invoicenya sendiri.
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. Lihat dulu - belum menghapus apa pun
--    Ini daftar arsip yang terlanjur dibuat dari percobaan yang gagal.
-- ---------------------------------------------------------------------
SELECT  b.no_invoice,
        e.id_book_invoice,
        COUNT(*) AS baris_arsip_terlanjur
FROM    tbl_invoice_detail_edit AS e
JOIN    tbl_invoice_detail      AS d ON d.id = e.id
LEFT JOIN tbl_book_invoice      AS b ON b.id = e.id_book_invoice
GROUP BY b.no_invoice, e.id_book_invoice
ORDER BY e.id_book_invoice;

SELECT  b.no_invoice,
        p.id_book_invoice,
        COUNT(*) AS baris_potongan_terlanjur
FROM    tbl_invoice_pot_edit AS p
JOIN    tbl_invoice_pot      AS o ON o.id = p.id
LEFT JOIN tbl_book_invoice   AS b ON b.id = p.id_book_invoice
GROUP BY b.no_invoice, p.id_book_invoice
ORDER BY p.id_book_invoice;


-- ---------------------------------------------------------------------
-- 2. Buang arsip yang terlanjur itu
--    Syaratnya sama dengan bagian 1: id-nya masih ada di tabel aslinya.
-- ---------------------------------------------------------------------
DELETE  e
FROM    tbl_invoice_detail_edit AS e
JOIN    tbl_invoice_detail      AS d ON d.id = e.id;

DELETE  p
FROM    tbl_invoice_pot_edit AS p
JOIN    tbl_invoice_pot      AS o ON o.id = p.id;


-- ---------------------------------------------------------------------
-- 3. Periksa hasilnya - dua-duanya harus 0
-- ---------------------------------------------------------------------
SELECT (SELECT COUNT(*) FROM tbl_invoice_detail_edit e
          JOIN tbl_invoice_detail d ON d.id = e.id) AS sisa_arsip_detail,
       (SELECT COUNT(*) FROM tbl_invoice_pot_edit p
          JOIN tbl_invoice_pot o ON o.id = p.id)    AS sisa_arsip_potongan;
