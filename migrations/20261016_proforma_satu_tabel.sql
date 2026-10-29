-- ============================================================================
-- Proforma Invoice: DP & CBD disatukan ke tbl_invoice_proforma.
-- Dijalankan MANUAL, sekali saja, di database aplikasi AR.
--
-- LATAR BELAKANG
-- Layar input DP & CBD sudah lebur ke layar Proforma Invoice (satu dropdown
-- Proforma Type), dan daftarnya pun sudah satu. Yang tersisa: datanya masih
-- di dua tabel.
--
--   tbl_invoice_proforma              PI & PI NON SO
--   tbl_invoice_proforma_dp_cbd       DP & CBD
--
-- Tabel kedua itu BUKAN cuma dibaca menu proformanya. Enam alur lain ikut
-- membacanya: approval DP/CBD (dua tingkat), alokasi, mutasi, cetakan DP, dan
-- faktur pajak. Kalau tabelnya sekadar ditinggalkan, keenam alur itu berhenti
-- melihat data baru.
--
-- CARANYA
-- Barisnya DIPINDAH ke tbl_invoice_proforma, lalu nama tabel lamanya dipakai
-- lagi sebagai VIEW ke tabel gabungan itu. Jadi:
--
--   * datanya benar-benar satu tabel;
--   * keenam alur lama tetap jalan apa adanya - querynya tidak diubah sama
--     sekali, yang berubah cuma apa yang ada di balik namanya;
--   * nomor PI dan nomor DP/CBD tetap dua deret terpisah, karena view-nya
--     hanya berisi baris DP & CBD.
--
-- Tabel aslinya TIDAK dibuang - diganti nama jadi *_arsip. Kalau ada yang
-- meleset, isinya masih utuh di situ (cara memundurkannya ada di bagian
-- ROLLBACK paling bawah).
--
-- SYARAT: migrations/20261015b_proforma_grouping.sql sudah dijalankan
-- (kolom type_pi & grouping). Bagian 1 di bawah memeriksanya.
-- ============================================================================


-- ============================================================================
-- BAGIAN 1 - PERIKSA DULU (cuma SELECT, tidak mengubah apa pun)
-- ============================================================================

-- 1a. Kolom type_pi harus sudah ada di KEDUA tabel. Kalau hasilnya bukan 2
--     baris, jalankan dulu migrations/20261015b_proforma_grouping.sql.
SELECT table_name, column_name
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND column_name = 'type_pi'
   AND table_name IN ('tbl_invoice_proforma', 'tbl_invoice_proforma_dp_cbd');

-- 1b. Berapa baris yang akan dipindah.
SELECT COUNT(*) AS baris_dp_cbd FROM tbl_invoice_proforma_dp_cbd;

-- 1c. Kolom yang ADA di tabel DP/CBD tapi BELUM ada di tabel gabungan.
--     Bagian 2 menambahkan tipe_dp & value_dp. Kalau di sini masih ada nama
--     lain yang muncul, BERHENTI dan tambahkan kolomnya dulu - kalau tidak,
--     isinya ikut hilang waktu dipindah.
SELECT c1.column_name, c1.column_type
  FROM information_schema.columns c1
 WHERE c1.table_schema = DATABASE()
   AND c1.table_name = 'tbl_invoice_proforma_dp_cbd'
   AND c1.column_name <> 'id'
   AND NOT EXISTS (SELECT 1 FROM information_schema.columns c2
                    WHERE c2.table_schema = DATABASE()
                      AND c2.table_name = 'tbl_invoice_proforma'
                      AND c2.column_name = c1.column_name);


-- ============================================================================
-- BAGIAN 2 - KOLOM KHUSUS DP/CBD DITAMBAHKAN KE TABEL GABUNGAN
-- ============================================================================

-- Patokan DP: '%' atau 'Amount'.
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'tipe_dp'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN tipe_dp VARCHAR(10) NULL DEFAULT NULL COMMENT ''patokan DP: % atau Amount''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Nilai DP dalam uang (hasil hitungan kalau patokannya persen).
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'value_dp'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN value_dp DOUBLE NULL DEFAULT NULL COMMENT ''nilai DP dalam uang''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ============================================================================
-- BAGIAN 3 - PINDAHKAN BARISNYA
--
-- Kolom yang dipindah disusun otomatis dari kolom yang ADA DI KEDUANYA, jadi
-- tidak ada yang tertinggal atau salah urutan. Kolom id sengaja TIDAK ikut:
-- id di kedua tabel bertabrakan, jadi baris pindahan dapat id baru. Kaitan
-- yang menyimpan id lama (tbl_duedate) dibereskan di Bagian 4.
-- ============================================================================

SET @kol := (SELECT GROUP_CONCAT(CONCAT('`', c1.column_name, '`') ORDER BY c1.ordinal_position)
               FROM information_schema.columns c1
              WHERE c1.table_schema = DATABASE()
                AND c1.table_name = 'tbl_invoice_proforma_dp_cbd'
                AND c1.column_name <> 'id'
                AND EXISTS (SELECT 1 FROM information_schema.columns c2
                             WHERE c2.table_schema = DATABASE()
                               AND c2.table_name = 'tbl_invoice_proforma'
                               AND c2.column_name = c1.column_name));

-- Hanya baris yang NOMORNYA belum ada di tabel gabungan - jadi aman kalau
-- bagian ini sempat dijalankan dua kali.
-- Sesudah migrasinya tuntas, nama lama itu sudah jadi VIEW ke tabel
-- gabungan - tidak ada lagi yang perlu dipindah, dan menjalankannya
-- lewat view bikin servernya menolak dengan "Prepared statement needs
-- to be re-prepared". Jadi dikerjakan hanya selama asalnya masih tabel.
SET @masih_tabel := EXISTS (SELECT 1 FROM information_schema.tables
                             WHERE table_schema = DATABASE()
                               AND table_name = 'tbl_invoice_proforma_dp_cbd'
                               AND table_type = 'BASE TABLE');

SET @s := IF(@masih_tabel = 0, 'DO 0',
             CONCAT('INSERT INTO tbl_invoice_proforma (', @kol, ') SELECT ', @kol,
                    ' FROM tbl_invoice_proforma_dp_cbd a',
                    ' WHERE NOT EXISTS (SELECT 1 FROM tbl_invoice_proforma b',
                    ' WHERE b.no_proforma_invoice = a.no_proforma_invoice)'));
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- Jenisnya dibaca dari NOMORNYA: 0001/C/E/NAG/1026 -> CBD, 0001/D/E/... -> DP.
-- Baris lama memang belum punya isi type_pi.
UPDATE tbl_invoice_proforma
   SET type_pi = CASE SUBSTRING_INDEX(SUBSTRING_INDEX(no_proforma_invoice, '/', 2), '/', -1)
                      WHEN 'C' THEN 'CBD' WHEN 'D' THEN 'DP' END
 WHERE IFNULL(type_pi, '') = ''
   AND SUBSTRING_INDEX(SUBSTRING_INDEX(no_proforma_invoice, '/', 2), '/', -1) IN ('C', 'D');

-- Sisanya (nomor tanpa /C/ atau /D/) berarti PI biasa.
UPDATE tbl_invoice_proforma SET type_pi = 'PI' WHERE IFNULL(type_pi, '') = '';

-- Barisnya: per SO dan per so_det. Keduanya dikaitkan lewat NOMOR proforma,
-- bukan id, jadi tidak ada yang perlu dipetakan ulang.
SET @kol := (SELECT GROUP_CONCAT(CONCAT('`', c1.column_name, '`') ORDER BY c1.ordinal_position)
               FROM information_schema.columns c1
              WHERE c1.table_schema = DATABASE()
                AND c1.table_name = 'tbl_invoice_proforma_detail_dp_cbd'
                AND c1.column_name <> 'id'
                AND EXISTS (SELECT 1 FROM information_schema.columns c2
                             WHERE c2.table_schema = DATABASE()
                               AND c2.table_name = 'tbl_invoice_proforma_detail'
                               AND c2.column_name = c1.column_name));
-- Sesudah migrasinya tuntas, nama lama itu sudah jadi VIEW ke tabel
-- gabungan - tidak ada lagi yang perlu dipindah, dan menjalankannya
-- lewat view bikin servernya menolak dengan "Prepared statement needs
-- to be re-prepared". Jadi dikerjakan hanya selama asalnya masih tabel.
SET @masih_tabel := EXISTS (SELECT 1 FROM information_schema.tables
                             WHERE table_schema = DATABASE()
                               AND table_name = 'tbl_invoice_proforma_detail_dp_cbd'
                               AND table_type = 'BASE TABLE');

SET @s := IF(@masih_tabel = 0, 'DO 0',
             CONCAT('INSERT INTO tbl_invoice_proforma_detail (', @kol, ') SELECT ', @kol,
                    ' FROM tbl_invoice_proforma_detail_dp_cbd a',
                    ' WHERE NOT EXISTS (SELECT 1 FROM tbl_invoice_proforma_detail b',
                    ' WHERE b.no_invoice_proforma = a.no_invoice_proforma)'));
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @kol := (SELECT GROUP_CONCAT(CONCAT('`', c1.column_name, '`') ORDER BY c1.ordinal_position)
               FROM information_schema.columns c1
              WHERE c1.table_schema = DATABASE()
                AND c1.table_name = 'tbl_invoice_proforma_detail_so_dp_cbd'
                AND c1.column_name <> 'id'
                AND EXISTS (SELECT 1 FROM information_schema.columns c2
                             WHERE c2.table_schema = DATABASE()
                               AND c2.table_name = 'tbl_invoice_proforma_detail_so'
                               AND c2.column_name = c1.column_name));
-- Sesudah migrasinya tuntas, nama lama itu sudah jadi VIEW ke tabel
-- gabungan - tidak ada lagi yang perlu dipindah, dan menjalankannya
-- lewat view bikin servernya menolak dengan "Prepared statement needs
-- to be re-prepared". Jadi dikerjakan hanya selama asalnya masih tabel.
SET @masih_tabel := EXISTS (SELECT 1 FROM information_schema.tables
                             WHERE table_schema = DATABASE()
                               AND table_name = 'tbl_invoice_proforma_detail_so_dp_cbd'
                               AND table_type = 'BASE TABLE');

SET @s := IF(@masih_tabel = 0, 'DO 0',
             CONCAT('INSERT INTO tbl_invoice_proforma_detail_so (', @kol, ') SELECT ', @kol,
                    ' FROM tbl_invoice_proforma_detail_so_dp_cbd a',
                    ' WHERE NOT EXISTS (SELECT 1 FROM tbl_invoice_proforma_detail_so b',
                    ' WHERE b.no_invoice_proforma = a.no_invoice_proforma)'));
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ============================================================================
-- BAGIAN 4 - KAITAN YANG MENYIMPAN ID LAMA
--
-- tbl_duedate.id_invoice menyimpan id baris proformanya. Baris pindahan dapat
-- id baru, jadi kaitannya dipasang ulang - dicocokkan lewat NOMOR invoice yang
-- memang ikut tersimpan di tabel itu, jadi tidak mungkin salah sasaran.
-- ============================================================================

UPDATE tbl_duedate d
  JOIN tbl_invoice_proforma p ON p.no_proforma_invoice = d.no_invoice
   SET d.id_invoice = p.id
 WHERE p.type_pi IN ('DP', 'CBD');


-- ============================================================================
-- BAGIAN 5 - NAMA TABEL LAMA JADI VIEW
--
-- Tabel aslinya disimpan sebagai *_arsip (tidak dibuang), lalu namanya dipakai
-- sebagai view ke tabel gabungan. Enam alur lama yang membacanya tidak perlu
-- diubah sama sekali.
--
-- View-nya sengaja sederhana (satu tabel, tanpa subquery) supaya tetap bisa
-- di-INSERT & di-UPDATE - alur simpan & approval DP/CBD memang menulis lewat
-- nama-nama ini.
-- ============================================================================

RENAME TABLE tbl_invoice_proforma_dp_cbd           TO tbl_invoice_proforma_dp_cbd_arsip;
RENAME TABLE tbl_invoice_proforma_detail_dp_cbd    TO tbl_invoice_proforma_detail_dp_cbd_arsip;
RENAME TABLE tbl_invoice_proforma_detail_so_dp_cbd TO tbl_invoice_proforma_detail_so_dp_cbd_arsip;

CREATE OR REPLACE VIEW tbl_invoice_proforma_dp_cbd AS
    SELECT * FROM tbl_invoice_proforma WHERE type_pi IN ('DP', 'CBD');

-- Baris detailnya tidak punya kolom jenis, jadi dikenali dari NOMOR-nya -
-- nomor DP & CBD memang selalu membawa /D/ atau /C/.
CREATE OR REPLACE VIEW tbl_invoice_proforma_detail_dp_cbd AS
    SELECT * FROM tbl_invoice_proforma_detail
     WHERE no_invoice_proforma LIKE '%/C/%' OR no_invoice_proforma LIKE '%/D/%';

CREATE OR REPLACE VIEW tbl_invoice_proforma_detail_so_dp_cbd AS
    SELECT * FROM tbl_invoice_proforma_detail_so
     WHERE no_invoice_proforma LIKE '%/C/%' OR no_invoice_proforma LIKE '%/D/%';


-- ============================================================================
-- BAGIAN 6 - PERIKSA HASILNYA
-- ============================================================================

-- 6a. Jumlahnya harus cocok: baris arsip = baris DP/CBD di tabel gabungan.
SELECT (SELECT COUNT(*) FROM tbl_invoice_proforma_dp_cbd_arsip) AS arsip,
       (SELECT COUNT(*) FROM tbl_invoice_proforma WHERE type_pi IN ('DP','CBD')) AS gabungan,
       (SELECT COUNT(*) FROM tbl_invoice_proforma_dp_cbd) AS lewat_view;

-- 6b. Tidak boleh ada yang jenisnya kosong.
SELECT COUNT(*) AS tanpa_jenis FROM tbl_invoice_proforma WHERE IFNULL(type_pi,'') = '';

-- 6c. Due date yang kehilangan kaitannya (harus 0).
SELECT COUNT(*) AS duedate_yatim
  FROM tbl_duedate d
  JOIN tbl_invoice_proforma p ON p.no_proforma_invoice = d.no_invoice
 WHERE p.type_pi IN ('DP','CBD') AND d.id_invoice <> p.id;

-- 6d. Lalu coba di layar:
--     - List Proforma Invoice: keempat jenis muncul, tidak ada yang dobel;
--     - Approval DP & CBD: daftarnya masih terisi seperti biasa;
--     - buat satu DP baru: nomornya tetap melanjutkan deret DP (0005/D/...),
--       bukan ikut deret PI.


-- ----------------------------------------------------------------------------
-- ROLLBACK (mengembalikan dua tabel seperti semula):
--   DROP VIEW tbl_invoice_proforma_dp_cbd;
--   DROP VIEW tbl_invoice_proforma_detail_dp_cbd;
--   DROP VIEW tbl_invoice_proforma_detail_so_dp_cbd;
--   RENAME TABLE tbl_invoice_proforma_dp_cbd_arsip           TO tbl_invoice_proforma_dp_cbd;
--   RENAME TABLE tbl_invoice_proforma_detail_dp_cbd_arsip    TO tbl_invoice_proforma_detail_dp_cbd;
--   RENAME TABLE tbl_invoice_proforma_detail_so_dp_cbd_arsip TO tbl_invoice_proforma_detail_so_dp_cbd;
--   DELETE FROM tbl_invoice_proforma WHERE type_pi IN ('DP','CBD');
--   DELETE FROM tbl_invoice_proforma_detail
--    WHERE no_invoice_proforma LIKE '%/C/%' OR no_invoice_proforma LIKE '%/D/%';
--   DELETE FROM tbl_invoice_proforma_detail_so
--    WHERE no_invoice_proforma LIKE '%/C/%' OR no_invoice_proforma LIKE '%/D/%';
--   Catatan: DP/CBD yang dibuat SESUDAH migrasi ini ikut terhapus oleh tiga
--   DELETE di atas - sebelum memundurkan, pindahkan dulu kalau masih dipakai.
--   Kaitan tbl_duedate-nya dipasang ulang dengan query di Bagian 4, tapi
--   diarahkan ke tbl_invoice_proforma_dp_cbd.
-- ----------------------------------------------------------------------------
