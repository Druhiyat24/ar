-- ============================================================================
-- Debit Note: koma ribuan di kolom Header dibuang dari baris yang SUDAH
-- tersimpan.
-- Dijalankan MANUAL, sekali saja, di database yang sama dengan aplikasi AR.
--
-- Isi kolom Header (header1..header5) di tbl_debitnote_det dibaca sebagai
-- DAFTAR yang dipisah KOMA - Model_nag::report_debit_note_det() memecahnya
-- dengan SPLIT_STRING, lalu cetakan menumpuk tiap pecahannya ke bawah dengan
-- <br>. Satu baris Header boleh berisi beberapa nilai, itu memang dipakai.
--
-- Masalahnya: baris dari "Add Invoice Export" dulu mengisi Qty Inv & Price
-- lewat pemformat tampilan yang memisah ribuan, jadi qty 4656 masuk sebagai
-- "4,656.00". Waktu dicetak nilainya terpecah jadi "4" dan "656.00" - di PDF
-- terbaca dua baris, seperti ke-enter. Lihat DN/NAG/1026/0846.
--
-- Sumber masalahnya sudah ditutup di crud-nag.js (dn_inv_exim_angka_simpan),
-- jadi DN baru sudah bersih. Migrasi ini membereskan yang sudah tersimpan.
--
-- SENGAJA DIBATASI supaya daftar bernilai banyak tidak ikut digabung:
--   a. hanya baris yang id_invoice_exim-nya terisi - baris itu pasti berasal
--      dari Add Invoice Export, dan di situ satu kolom Header = satu nilai;
--   b. hanya isi yang bentuknya memang angka berpemisah ribuan yang benar
--      (1-3 angka, lalu kelompok 3 angka, boleh berdesimal).
-- Dengan dua batasan itu PO "123,456" milik baris manual tetap utuh.
-- ============================================================================

-- 1) Lihat dulu yang akan berubah - jalankan ini LEBIH DAHULU:
--      SELECT d.id, h.no_dn, d.no_invoice_exim, d.header4, d.header5
--        FROM tbl_debitnote_det AS d
--        LEFT JOIN tbl_debitnote_h AS h ON h.no_dn = d.no_dn
--       WHERE d.id_invoice_exim IS NOT NULL
--         AND (d.header4 REGEXP '^-?[0-9]{1,3}(,[0-9]{3})+([.][0-9]+)?$'
--           OR d.header5 REGEXP '^-?[0-9]{1,3}(,[0-9]{3})+([.][0-9]+)?$')
--       ORDER BY d.id;

UPDATE tbl_debitnote_det SET header1 = REPLACE(header1, ',', '') WHERE id_invoice_exim IS NOT NULL AND header1 REGEXP '^-?[0-9]{1,3}(,[0-9]{3})+([.][0-9]+)?$';
UPDATE tbl_debitnote_det SET header2 = REPLACE(header2, ',', '') WHERE id_invoice_exim IS NOT NULL AND header2 REGEXP '^-?[0-9]{1,3}(,[0-9]{3})+([.][0-9]+)?$';
UPDATE tbl_debitnote_det SET header3 = REPLACE(header3, ',', '') WHERE id_invoice_exim IS NOT NULL AND header3 REGEXP '^-?[0-9]{1,3}(,[0-9]{3})+([.][0-9]+)?$';
UPDATE tbl_debitnote_det SET header4 = REPLACE(header4, ',', '') WHERE id_invoice_exim IS NOT NULL AND header4 REGEXP '^-?[0-9]{1,3}(,[0-9]{3})+([.][0-9]+)?$';
UPDATE tbl_debitnote_det SET header5 = REPLACE(header5, ',', '') WHERE id_invoice_exim IS NOT NULL AND header5 REGEXP '^-?[0-9]{1,3}(,[0-9]{3})+([.][0-9]+)?$';

-- 2) Cek hasilnya - daftar di langkah 1 harus kosong sekarang, dan
--    cetakan DN-nya (arnag/report_debit_note/<id>) Qty Inv-nya satu baris.
--
--    Kalau kolom header4 / header5 belum ada di database ini, dua UPDATE
--    terakhir memang akan menolak - jalankan dulu
--    migrations/20260911_debitnote_header4_header5.sql, lalu ulangi.

-- ----------------------------------------------------------------------------
-- ROLLBACK: tidak ada - isinya angka yang pemisah ribuannya dibuang, nilainya
-- tidak berubah. Kalau ingin dipulihkan apa adanya, pakai backup.
-- ----------------------------------------------------------------------------
