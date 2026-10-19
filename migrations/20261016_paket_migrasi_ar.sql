-- ================================================================================
-- PAKET MIGRASI AR - Proforma Invoice & Invoice Export
-- Dibuat 2026-10-16.
--
-- Jalankan SELURUH berkas ini sekali, dari atas ke bawah, di database AR.
-- Urutannya penting: Bagian 4 memakai kolom yang dibuat Bagian 3.
--
-- AMAN DIULANG. Semua bagian memeriksa dulu: kolom yang sudah ada tidak
-- ditambah lagi, baris yang sudah pindah tidak dipindah dua kali, dan tabel
-- yang sudah jadi view tidak diganti nama lagi. Jadi kalau sempat terhenti
-- di tengah, jalankan saja lagi dari atas.
--
-- Berkas ini menggabungkan lima migrasi yang masih tertunda:
--   20261013_invoice_export_summary_ar.sql
--   20261015_proforma_harga_penuh.sql
--   20261015b_proforma_grouping.sql
--   20261016_proforma_satu_tabel.sql
--   20261013_isi_coa_invoice_lama.sql
-- Berkas aslinya disimpan untuk rujukan - keterangan panjang & cara
-- memundurkannya ada di sana. Yang DIJALANKAN cukup berkas ini.
-- ================================================================================


-- ================================================================================
-- BAGIAN 1 - Invoice Export: penanda summary dirapikan tangan
--
-- Cetakan Invoice Export biasanya mengambil nilai CM dari jumlah baris SJ-nya.
-- Begitu baris Invoice Summary-nya dirapikan tangan - digabung, dipecah, qty
-- atau harganya diketik ulang - kaitan itu tidak mewakili yang ditagih lagi,
-- jadi nilainya harus diambil dari baris summary-nya sendiri. Kolom ini
-- penandanya.
-- ================================================================================

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'tbl_book_invoice_exim_export_h') AND NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_book_invoice_exim_export_h' AND column_name = 'summary_ar'), 'ALTER TABLE tbl_book_invoice_exim_export_h ADD COLUMN summary_ar TINYINT(1) NOT NULL DEFAULT 0 COMMENT ''1 = baris Invoice Summary sudah dirapikan dari AR''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ================================================================================
-- BAGIAN 2 - Proforma Invoice: harga & total disimpan apa adanya
--
-- Harga di SO banyak yang berdesimal panjang (11711.7117117). Kolomnya masih
-- DOUBLE(16,2), jadi MySQL membulatkan sendiri waktu barisnya disimpan -
-- sebagus apa pun querynya. Dilebarkan jadi DOUBLE biasa.
--
-- Yang MUNCUL di layar & cetakan tetap 2 angka; yang DISIMPAN yang penuh,
-- supaya kalau nanti diminta total apa adanya, datanya sudah ada.
-- ================================================================================

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_so_det_proforma_temp' AND column_name = 'price' AND column_type <> 'double'), 'ALTER TABLE tbl_so_det_proforma_temp MODIFY price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_so_det_proforma_temp' AND column_name = 'total' AND column_type <> 'double'), 'ALTER TABLE tbl_so_det_proforma_temp MODIFY total DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_temp' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_temp MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_temp' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_temp MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_so MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_so MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so_dp_cbd' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_so_dp_cbd MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so_dp_cbd' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_so_dp_cbd MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_dp_cbd' AND column_name = 'unit_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_dp_cbd MODIFY unit_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_dp_cbd' AND column_name = 'total_price' AND column_type <> 'double'), 'ALTER TABLE tbl_invoice_proforma_detail_dp_cbd MODIFY total_price DOUBLE NULL DEFAULT NULL', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ================================================================================
-- BAGIAN 3 - Proforma Invoice: jenis, bentuk baris & kaitan so_det
--
-- Tiga kolom baru:
--   type_pi        jenis proformanya - PI, PI NON SO, DP, CBD. Satu layar
--                  sekarang melayani keempatnya, dan menu Create Invoice
--                  nanti membacanya.
--   grouping       bentuk baris SO yang dipilih user (per produk / warna /
--                  size). Cetakan tinggal mencetak apa adanya - cukup satu PDF.
--   id_so_det_list daftar so_det yang diwakili satu baris. Satu baris bisa
--                  mewakili puluhan so_det, dan SEMUANYA harus ikut ditandai
--                  terpakai - kalau cuma id pertamanya, sisanya masih bisa
--                  ditarik proforma lain.
-- ================================================================================

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'grouping'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN grouping VARCHAR(20) NULL DEFAULT NULL COMMENT ''bentuk baris SO: PRODUCT, PRODUCT_COLOR, PRODUCT_SIZE, PRODUCT_COLOR_SIZE''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_dp_cbd' AND column_name = 'grouping'), 'ALTER TABLE tbl_invoice_proforma_dp_cbd ADD COLUMN grouping VARCHAR(20) NULL DEFAULT NULL COMMENT ''bentuk baris SO: PRODUCT, PRODUCT_COLOR, PRODUCT_SIZE, PRODUCT_COLOR_SIZE''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_so_det_proforma_temp' AND column_name = 'id_so_det_list'), 'ALTER TABLE tbl_so_det_proforma_temp ADD COLUMN id_so_det_list TEXT NULL DEFAULT NULL COMMENT ''id so_det yang diwakili baris ini, dipisah koma''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so' AND column_name = 'id_so_det_list'), 'ALTER TABLE tbl_invoice_proforma_detail_so ADD COLUMN id_so_det_list TEXT NULL DEFAULT NULL COMMENT ''id so_det yang diwakili baris ini, dipisah koma''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so_dp_cbd' AND column_name = 'id_so_det_list'), 'ALTER TABLE tbl_invoice_proforma_detail_so_dp_cbd ADD COLUMN id_so_det_list TEXT NULL DEFAULT NULL COMMENT ''id so_det yang diwakili baris ini, dipisah koma''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'type_pi'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN type_pi VARCHAR(20) NULL DEFAULT NULL COMMENT ''jenis proforma: PI, PI NON SO, DP, CBD''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_dp_cbd' AND column_name = 'type_pi'), 'ALTER TABLE tbl_invoice_proforma_dp_cbd ADD COLUMN type_pi VARCHAR(20) NULL DEFAULT NULL COMMENT ''jenis proforma: PI, PI NON SO, DP, CBD''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ================================================================================
-- BAGIAN 4 - Proforma Invoice: DP & CBD disatukan ke satu tabel
--
-- Layar input & daftar DP/CBD sudah lebur ke Proforma Invoice. Datanya menyusul:
-- barisnya DIPINDAH ke tbl_invoice_proforma, lalu nama tabel lamanya dipakai
-- lagi sebagai VIEW ke tabel gabungan itu.
--
-- Kenapa view, bukan sekadar pindah: tabel DP/CBD bukan cuma dibaca menu
-- proformanya. Approval DP/CBD (dua tingkat), alokasi, mutasi, cetakan DP &
-- faktur pajak ikut membacanya. Dengan view, keenam alur itu tetap jalan apa
-- adanya - tidak satu query pun yang diubah - dan nomor DP/CBD tetap deret
-- sendiri karena view-nya cuma berisi DP & CBD.
--
-- Tabel aslinya TIDAK dibuang, disimpan sebagai *_arsip.
--
-- Pernyataan pertama di bawah adalah PENJAGA: kalau tabel DP/CBD ternyata punya
-- kolom yang belum ada di tabel gabungan, prosesnya BERHENTI dengan pesan yang
-- menyebutkan nama kolomnya - isinya tidak boleh hilang diam-diam.
-- ================================================================================

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'tipe_dp'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN tipe_dp VARCHAR(10) NULL DEFAULT NULL COMMENT ''patokan DP: % atau Amount''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'value_dp'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN value_dp DOUBLE NULL DEFAULT NULL COMMENT ''nilai DP dalam uang''', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @kurang := (SELECT GROUP_CONCAT(c1.column_name)
                  FROM information_schema.columns c1
                 WHERE c1.table_schema = DATABASE()
                   AND c1.table_name = 'tbl_invoice_proforma_dp_cbd'
                   AND c1.column_name <> 'id'
                   AND NOT EXISTS (SELECT 1 FROM information_schema.columns c2
                                    WHERE c2.table_schema = DATABASE()
                                      AND c2.table_name = 'tbl_invoice_proforma'
                                      AND c2.column_name = c1.column_name));
SET @s := IF(@kurang IS NULL, 'DO 0',
             CONCAT('SELECT * FROM `BERHENTI_kolom_DP_CBD_belum_ada_di_tabel_gabungan__',
                    @kurang, '`'));
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @kol := (SELECT GROUP_CONCAT(CONCAT('`', c1.column_name, '`') ORDER BY c1.ordinal_position)
               FROM information_schema.columns c1
              WHERE c1.table_schema = DATABASE()
                AND c1.table_name = 'tbl_invoice_proforma_dp_cbd'
                AND c1.column_name <> 'id'
                AND EXISTS (SELECT 1 FROM information_schema.columns c2
                             WHERE c2.table_schema = DATABASE()
                               AND c2.table_name = 'tbl_invoice_proforma'
                               AND c2.column_name = c1.column_name));

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

UPDATE tbl_invoice_proforma
   SET type_pi = CASE SUBSTRING_INDEX(SUBSTRING_INDEX(no_proforma_invoice, '/', 2), '/', -1)
                      WHEN 'C' THEN 'CBD' WHEN 'D' THEN 'DP' END
 WHERE IFNULL(type_pi, '') = ''
   AND SUBSTRING_INDEX(SUBSTRING_INDEX(no_proforma_invoice, '/', 2), '/', -1) IN ('C', 'D');

UPDATE tbl_invoice_proforma SET type_pi = 'PI' WHERE IFNULL(type_pi, '') = '';

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

UPDATE tbl_duedate d
  JOIN tbl_invoice_proforma p ON p.no_proforma_invoice = d.no_invoice
   SET d.id_invoice = p.id
 WHERE p.type_pi IN ('DP', 'CBD');

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_dp_cbd' AND table_type = 'BASE TABLE'), 'RENAME TABLE tbl_invoice_proforma_dp_cbd TO tbl_invoice_proforma_dp_cbd_arsip', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_dp_cbd' AND table_type = 'BASE TABLE'), 'RENAME TABLE tbl_invoice_proforma_detail_dp_cbd TO tbl_invoice_proforma_detail_dp_cbd_arsip', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma_detail_so_dp_cbd' AND table_type = 'BASE TABLE'), 'RENAME TABLE tbl_invoice_proforma_detail_so_dp_cbd TO tbl_invoice_proforma_detail_so_dp_cbd_arsip', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

CREATE OR REPLACE VIEW tbl_invoice_proforma_dp_cbd AS
    SELECT * FROM tbl_invoice_proforma WHERE type_pi IN ('DP', 'CBD');

CREATE OR REPLACE VIEW tbl_invoice_proforma_detail_dp_cbd AS
    SELECT * FROM tbl_invoice_proforma_detail
     WHERE no_invoice_proforma LIKE '%/C/%' OR no_invoice_proforma LIKE '%/D/%';

CREATE OR REPLACE VIEW tbl_invoice_proforma_detail_so_dp_cbd AS
    SELECT * FROM tbl_invoice_proforma_detail_so
     WHERE no_invoice_proforma LIKE '%/C/%' OR no_invoice_proforma LIKE '%/D/%';


-- ================================================================================
-- BAGIAN 5 - Isi COA invoice lama yang masih kosong
--
-- Hanya mengisi yang KOSONG (no_coa belum terisi); yang sudah ada tidak
-- disentuh. Aman diulang.
-- ================================================================================

UPDATE tbl_book_invoice a LEFT JOIN (SELECT id_supplier, supplier_ctg FROM tbl_ctg_supplier WHERE status = 'Y' GROUP BY id_supplier) sc ON sc.id_supplier = a.id_customer INNER JOIN mastercoa_v2 coa ON coa.inv_type LIKE '%INV_debit%' AND coa.shipp_tipe = a.shipp AND coa.cus_ctg LIKE CONCAT('%', IFNULL(sc.supplier_ctg, 'Third'), '%') SET a.no_coa = coa.no_coa, a.nama_coa = coa.nama_coa WHERE IFNULL(a.no_coa, '') = '';


-- ================================================================================
-- BAGIAN 6 - PERIKSA HASILNYA (cuma SELECT)
--
-- Keenamnya harus sesuai keterangan di sebelah kanannya.
-- ================================================================================

-- 1. Kolom barunya ada semua. Harapannya 7 baris:
--    grouping & type_pi di dua tabel header, id_so_det_list di tiga tabel.
SELECT table_name, column_name FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND column_name IN ('grouping', 'type_pi', 'id_so_det_list')
 ORDER BY column_name, table_name;

-- 2. Harga & totalnya tidak lagi dipatok 2 angka - semuanya 'double'.
SELECT table_name, column_name, column_type FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND column_name IN ('price', 'unit_price', 'total', 'total_price')
   AND (table_name = 'tbl_so_det_proforma_temp'
     OR table_name LIKE 'tbl_invoice_proforma_detail%')
 ORDER BY table_name, column_name;

-- 3. Jumlah DP/CBD: arsip = yang di tabel gabungan = yang lewat view.
SELECT (SELECT COUNT(*) FROM tbl_invoice_proforma_dp_cbd_arsip) AS arsip,
       (SELECT COUNT(*) FROM tbl_invoice_proforma WHERE type_pi IN ('DP','CBD')) AS gabungan,
       (SELECT COUNT(*) FROM tbl_invoice_proforma_dp_cbd) AS lewat_view;

-- 4. Tidak boleh ada proforma yang jenisnya kosong (harus 0).
SELECT COUNT(*) AS tanpa_jenis FROM tbl_invoice_proforma WHERE IFNULL(type_pi,'') = '';

-- 5. Due date yang kaitannya meleset (harus 0).
SELECT COUNT(*) AS duedate_meleset FROM tbl_duedate d
  JOIN tbl_invoice_proforma p ON p.no_proforma_invoice = d.no_invoice
 WHERE p.type_pi IN ('DP','CBD') AND d.id_invoice <> p.id;

-- 6. Ketiga nama lama sekarang VIEW, dan arsipnya masih ada.
SELECT table_name, table_type FROM information_schema.tables
 WHERE table_schema = DATABASE()
   AND table_name LIKE 'tbl_invoice_proforma%dp_cbd%'
 ORDER BY table_name;

-- Lalu coba di layar:
--   * List Proforma Invoice: keempat jenis muncul, tidak ada yang dobel;
--   * Approval DP & CBD: daftarnya masih terisi seperti biasa;
--   * buat satu DP baru: nomornya melanjutkan deret DP (mis. 0005/D/...),
--     dan nomor PI berikutnya tidak ikut melompat.
