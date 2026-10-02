-- ===========================================================================
--  PEMULIHAN PROFORMA INVOICE YANG TERSIMPAN TAPI TIDAK MUNCUL DI LIST
-- ===========================================================================
--  Sebelum perbaikan, layar Proforma Invoice menyimpan headernya lalu LANGSUNG
--  memuat ulang halaman, padahal penyimpanan detailnya masih berjalan. Yang
--  belum selesai ikut dibatalkan browser, jadi bisa tertinggal:
--
--    a. header di tbl_invoice_proforma TANPA barisnya di
--       tbl_invoice_proforma_detail_so - daftar Proforma Invoice INNER JOIN ke
--       tabel itu, jadi headernya tidak akan pernah muncul; dan
--    b. so_det.no_pi terlanjur tertandai nomor proforma itu - padahal
--       pemilihan SO menyaring "no_pi is null", jadi SO-nya TIDAK BISA dipakai
--       lagi untuk proforma baru.
--
--  Berkas ini mencari sisa (a), membersihkan tanda (b), lalu membuang header
--  yatimnya supaya nomornya bisa dipakai ulang.
--
--  AMAN DIJALANKAN BERULANG. Jalankan BAGIAN 1 dulu - kalau hasilnya kosong,
--  tidak ada yang perlu dibereskan dan sisanya tidak usah dijalankan.
--
--  BAGIAN 1-3 dijalankan di database AR (yang memuat tbl_invoice_proforma).
--  BAGIAN 4 dijalankan di database db_nag (yang memuat so_det). Kalau keduanya
--  memang satu database, semuanya bisa dijalankan sekaligus di sana.
-- ===========================================================================


-- ===========================================================================
--  BAGIAN 1 - CARI HEADER YANG TIDAK PUNYA DETAIL SO (cuma SELECT)
--
--  Inilah proforma yang "tersimpan tapi tidak muncul di List".
--  Kalau hasilnya kosong: tidak ada yang perlu dibereskan, berhenti di sini.
-- ===========================================================================
SELECT 'Proforma Invoice' AS menu, a.id, a.no_proforma_invoice, a.tgl_proforma_inv,
       a.id_customer, a.status,
       (SELECT COUNT(*) FROM tbl_invoice_proforma_detail x
         WHERE x.no_invoice_proforma = a.no_proforma_invoice) AS baris_detail
  FROM tbl_invoice_proforma a
 WHERE UPPER(IFNULL(a.status, '')) <> 'CANCEL'
   AND NOT EXISTS (SELECT 1 FROM tbl_invoice_proforma_detail_so d
                    WHERE d.no_invoice_proforma = a.no_proforma_invoice)

UNION ALL

SELECT 'Invoice DP & CBD', a.id, a.no_proforma_invoice, a.tgl_proforma_inv,
       a.id_customer, a.status,
       (SELECT COUNT(*) FROM tbl_invoice_proforma_detail_dp_cbd x
         WHERE x.no_invoice_proforma = a.no_proforma_invoice)
  FROM tbl_invoice_proforma_dp_cbd a
 WHERE UPPER(IFNULL(a.status, '')) <> 'CANCEL'
   AND NOT EXISTS (SELECT 1 FROM tbl_invoice_proforma_detail_dp_cbd d
                    WHERE d.no_invoice_proforma = a.no_proforma_invoice)

 ORDER BY 1, 4, 3;


-- ===========================================================================
--  BAGIAN 2 - PERINTAH PEMBERSIH TANDA DI so_det
--
--  so_det ada di koneksi db_nag. Query ini MENGHASILKAN perintahnya: jalankan,
--  salin seluruh hasilnya, lalu tempel & jalankan di database db_nag.
--  (Kalau tbl_invoice_proforma dan so_det memang satu database, langsung pakai
--   BAGIAN 4 saja - lebih singkat.)
-- ===========================================================================
SELECT CONCAT('UPDATE so_det SET no_pi = NULL WHERE no_pi = ''',
              REPLACE(a.no_proforma_invoice, '''', ''''''), ''';') AS perintah_untuk_db_nag
  FROM tbl_invoice_proforma a
 WHERE UPPER(IFNULL(a.status, '')) <> 'CANCEL'
   AND NOT EXISTS (SELECT 1 FROM tbl_invoice_proforma_detail_so d
                    WHERE d.no_invoice_proforma = a.no_proforma_invoice)
 GROUP BY a.no_proforma_invoice
 ORDER BY a.no_proforma_invoice;


-- ===========================================================================
--  BAGIAN 3 - BUANG HEADER YATIMNYA
--
--  Headernya tidak membawa data apa-apa (detailnya memang tidak pernah
--  tersimpan), jadi dibuang saja supaya nomornya bisa dipakai ulang waktu
--  user menginput ulang.
--
--  Kalau Bapak lebih suka jejaknya tetap tersimpan, ganti DELETE dengan:
--      UPDATE tbl_invoice_proforma SET status = 'CANCEL' WHERE ...
--  Catatan: penomoran mengabaikan status CANCEL, jadi nomor yang sama tetap
--  akan dipakai lagi oleh proforma berikutnya.
--
--  JALANKAN BAGIAN 2 DULU - sesudah ini daftarnya tidak bisa dicari lagi.
-- ===========================================================================
DELETE FROM tbl_invoice_proforma_detail
 WHERE no_invoice_proforma IN (
       SELECT no_proforma_invoice FROM (
           SELECT a.no_proforma_invoice
             FROM tbl_invoice_proforma a
            WHERE UPPER(IFNULL(a.status, '')) <> 'CANCEL'
              AND NOT EXISTS (SELECT 1 FROM tbl_invoice_proforma_detail_so d
                               WHERE d.no_invoice_proforma = a.no_proforma_invoice)
       ) yatim);

DELETE FROM tbl_invoice_proforma
 WHERE UPPER(IFNULL(status, '')) <> 'CANCEL'
   AND no_proforma_invoice NOT IN (
       SELECT no_invoice_proforma FROM (
           SELECT DISTINCT no_invoice_proforma FROM tbl_invoice_proforma_detail_so
       ) ada);


-- ===========================================================================
--  BAGIAN 4 - PEMBERSIH TANDA DI so_det (dijalankan di database db_nag)
--
--  Dipakai KALAU tbl_invoice_proforma dan so_det ada di database yang sama.
--  Kalau beda database, pakai hasil BAGIAN 2 - dan jalankan SEBELUM BAGIAN 3,
--  karena sesudah itu daftar nomornya sudah terhapus.
--
--  Yang dibersihkan hanya tanda yang nomornya TIDAK ada lagi sebagai proforma
--  terpakai, jadi proforma yang sah tidak ikut terlepas.
-- ===========================================================================
-- UPDATE so_det
--    SET no_pi = NULL
--  WHERE IFNULL(no_pi, '') <> ''
--    AND no_pi NOT IN (SELECT DISTINCT no_invoice_proforma
--                        FROM tbl_invoice_proforma_detail_so)
--    AND no_pi NOT IN (SELECT DISTINCT no_invoice_proforma
--                        FROM tbl_invoice_proforma_detail_dp_cbd);


-- ===========================================================================
--  BAGIAN 5 - PEMERIKSAAN HASIL (cuma SELECT)
--
--  "yatim" harus 0.
-- ===========================================================================
SELECT COUNT(*) AS yatim
  FROM tbl_invoice_proforma a
 WHERE UPPER(IFNULL(a.status, '')) <> 'CANCEL'
   AND NOT EXISTS (SELECT 1 FROM tbl_invoice_proforma_detail_so d
                    WHERE d.no_invoice_proforma = a.no_proforma_invoice);


-- ===========================================================================
--  BAGIAN 6 - NOMOR PROFORMA YANG DOBEL (cuma SELECT)
--
--  Kalau penyimpanan sempat dilaporkan gagal padahal datanya sudah masuk, lalu
--  tombol Save ditekan lagi di halaman yang sama, nomornya belum berganti -
--  jadi bisa tersimpan dua kali dengan nomor yang sama.
--
--  Hasilnya harus kosong. Kalau ada, buang yang id-nya lebih besar (yang
--  belakangan) beserta detailnya - periksa dulu isinya sebelum dibuang.
-- ===========================================================================
SELECT a.no_proforma_invoice, COUNT(*) AS jumlah,
       GROUP_CONCAT(a.id ORDER BY a.id) AS id_nya
  FROM tbl_invoice_proforma a
 WHERE UPPER(IFNULL(a.status, '')) <> 'CANCEL'
 GROUP BY a.no_proforma_invoice
HAVING COUNT(*) > 1;
