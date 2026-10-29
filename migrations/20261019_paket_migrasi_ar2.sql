-- ================================================================================
-- PAKET MIGRASI AR - 19 Oktober 2026
--
-- Jalankan SELURUH berkas ini sekali, dari atas ke bawah, di database AR.
-- Urutannya penting: bagian belakang memakai kolom & tabel yang dibuat
-- bagian depan.
--
-- AMAN DIULANG. Semua bagian memeriksa dulu: kolom yang sudah ada tidak
-- ditambah lagi, baris yang sudah pindah tidak dipindah dua kali, tabel yang
-- sudah jadi view tidak diganti nama lagi, dan baris yang angkanya sudah
-- benar tidak diutak-atik. Jadi kalau sempat terhenti di tengah, jalankan
-- saja lagi dari atas.
--
-- Isinya lima migrasi yang masih menunggu:
--   BAGIAN A - Proforma Invoice & Invoice Export
--               (20261016_paket_migrasi_ar.sql)
--   BAGIAN B - Invoice Export: rekap uangnya diselaraskan dengan barisnya
--               (20261016b_rekap_summary_export.sql)
--   BAGIAN C - Menu Second Approval: Invoice DP & CBD jadi Proforma Invoice
--               (20261016c_menu_approval_proforma.sql)
--   BAGIAN D - Create Invoice: catatan pemakaian Proforma Invoice
--               (20261017_alokasi_proforma_invoice.sql)
--   BAGIAN E - Invoice: kolom Advance di tabel potongan
--               (20261017b_invoice_pot_dp_cbd.sql)
--   BAGIAN F - Proforma Invoice: kolom Billed To
--               (20261019b_proforma_billed_to.sql)
--
-- Berkas aslinya tetap disimpan untuk rujukan - keterangan panjang & cara
-- memundurkannya ada di sana. Yang DIJALANKAN cukup berkas ini.
-- ================================================================================


-- ================================================================================
-- BAGIAN A - Proforma Invoice & Invoice Export
-- Jenis proforma, bentuk baris, harga penuh, DP/CBD disatukan ke satu tabel, dan penanda summary Invoice Export.
-- Asalnya: migrations/20261016_paket_migrasi_ar.sql
-- ================================================================================

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


-- ================================================================================
-- BAGIAN B - Invoice Export: rekap uangnya diselaraskan dengan barisnya
-- Membereskan invoice yang Sub Total & Net Invoice Total-nya terlanjur beda.
-- Asalnya: migrations/20261016b_rekap_summary_export.sql
-- ================================================================================

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


-- ================================================================================
-- BAGIAN C - Menu Second Approval: Invoice DP & CBD jadi Proforma Invoice
-- Approval DP/CBD sudah jadi satu dengan Proforma Invoice.
-- Asalnya: migrations/20261016c_menu_approval_proforma.sql
-- ================================================================================

-- ================================================================================
-- MENU - Second Approval: "Invoice DP & CBD" jadi "Proforma Invoice"
-- Dibuat 2026-10-16.
--
-- LATARNYA
-- DP & CBD sudah jadi salah satu jenis Proforma Invoice (satu layar input, satu
-- daftar, satu tabel). Approval-nya pun jadi satu: layar Approval Proforma
-- Invoice sekarang memuat PI, PI NON SO, DP & CBD sekaligus, dengan nilai yang
-- mengikuti jenisnya - DP/CBD memakai nilai DP-nya.
--
-- Menu First Approval ditulis langsung di tampilannya, jadi sudah ikut berubah
-- begitu programnya diperbarui. Menu Second Approval datang dari database
-- (tbl_user_role + tbl_user_access), jadi berkas inilah yang mengubahnya.
--
-- YANG DISENTUH
-- Cuma baris menunya - hak akses tiap user tidak diubah, jadi siapa yang boleh
-- membuka menu itu tetap sama persis.
--
-- AMAN DIULANG. Baris yang sudah berubah tidak cocok lagi dengan saringannya.
--
-- CARA MEMUNDURKAN
--   UPDATE tbl_user_role SET menu = 'Approval Invoice DP & CBD'
--    WHERE menu = 'Approval Proforma Invoice' AND menu_status = 'main_menu_3';
--   UPDATE tbl_user_access SET base_url = 'arnag/approval_invoice_dpcbd'
--    WHERE base_url = 'arnag/approval_proformainvoice';
-- ================================================================================


-- --------------------------------------------------------------------------------
-- LANGKAH 0 - lihat dulu baris mana yang akan berubah
-- --------------------------------------------------------------------------------
-- SELECT a.id, a.menu, a.menu_status, COUNT(b.user) AS jumlah_user
--   FROM tbl_user_role a LEFT JOIN tbl_user_access b ON b.menu_id = a.id
--  WHERE a.menu_status = 'main_menu_3' AND a.menu LIKE '%DP%CBD%'
--  GROUP BY a.id, a.menu, a.menu_status;


-- --------------------------------------------------------------------------------
-- LANGKAH 1 - nama menunya
-- --------------------------------------------------------------------------------
UPDATE tbl_user_role
   SET menu = 'Approval Proforma Invoice'
 WHERE menu_status = 'main_menu_3'
   AND menu LIKE 'Approval Invoice DP%CBD%';


-- --------------------------------------------------------------------------------
-- LANGKAH 2 - alamat yang dituju
-- --------------------------------------------------------------------------------
UPDATE tbl_user_access
   SET base_url = 'arnag/approval_proformainvoice'
 WHERE base_url LIKE '%approval_invoice_dpcbd%';


-- --------------------------------------------------------------------------------
-- LANGKAH 3 - periksa hasilnya
-- Seharusnya menunya bernama Approval Proforma Invoice dan alamatnya
-- arnag/approval_proformainvoice; tidak ada lagi yang menunjuk layar lama.
-- --------------------------------------------------------------------------------
SELECT a.menu, b.base_url, COUNT(*) AS jumlah_user
  FROM tbl_user_role a INNER JOIN tbl_user_access b ON b.menu_id = a.id
 WHERE a.menu_status = 'main_menu_3'
 GROUP BY a.menu, b.base_url
 ORDER BY a.menu;


-- ================================================================================
-- BAGIAN D - Create Invoice: catatan pemakaian Proforma Invoice
-- Tabel baru - sumber laporan alokasi PI dan penentu sisa tiap PI.
-- Asalnya: migrations/20261017_alokasi_proforma_invoice.sql
-- ================================================================================

-- ================================================================================
-- Create Invoice: Proforma Invoice dipakai memotong tagihan
-- Dibuat 2026-10-17.
--
-- LATARNYA
-- Proforma Invoice bertipe DP, CBD & PI NON SO dipanggil di layar Create
-- Invoice untuk memotong total tagihannya. Satu nomor PI boleh dipakai
-- berulang di beberapa invoice - tiap kali dipakai sebagiannya saja - jadi
-- pemakaiannya harus dicatat per invoice, bukan sekadar penanda "sudah
-- terpakai" di PI-nya.
--
-- Catatan ini juga yang nanti jadi sumber laporan alokasi PI: dari satu nomor
-- PI kelihatan dipakai di invoice mana saja dan berapa, serta sisanya.
--
-- AMAN DIULANG - tabelnya dibuat kalau belum ada, kolomnya ditambah kalau
-- belum ada.
--
-- CARA MEMUNDURKAN
--   DROP TABLE tbl_invoice_proforma_alokasi;
-- ================================================================================


CREATE TABLE IF NOT EXISTS tbl_invoice_proforma_alokasi (
    id INT NOT NULL AUTO_INCREMENT,
    id_book_invoice INT NOT NULL COMMENT 'invoice yang memakai',
    no_invoice VARCHAR(60) NULL COMMENT 'nomor invoicenya - memudahkan laporan',
    id_proforma INT NOT NULL COMMENT 'baris tbl_invoice_proforma yang dipakai',
    no_proforma_invoice VARCHAR(60) NOT NULL,
    type_pi VARCHAR(20) NULL COMMENT 'DP / CBD / PI NON SO',
    curr VARCHAR(10) NULL,
    nilai_pi DECIMAL(18,4) NOT NULL DEFAULT 0 COMMENT 'nilai PI yang boleh dipakai - nilai DP kalau ber-DP, selain itu totalnya',
    amount DECIMAL(18,4) NOT NULL DEFAULT 0 COMMENT 'yang dipakai invoice ini',
    bagian VARCHAR(10) NOT NULL DEFAULT 'ADVANCE' COMMENT 'DP = masuk Down Payment, ADVANCE = masuk Advance',
    created_by VARCHAR(100) NULL,
    created_at DATETIME NULL,
    PRIMARY KEY (id),
    KEY idx_alokasi_invoice (id_book_invoice),
    KEY idx_alokasi_pi (no_proforma_invoice)
) COMMENT 'Pemakaian Proforma Invoice (DP/CBD/PI NON SO) di tiap invoice';


-- --------------------------------------------------------------------------------
-- Periksa hasilnya
-- --------------------------------------------------------------------------------
SELECT COUNT(*) AS kolom_terpasang
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND table_name = 'tbl_invoice_proforma_alokasi';


-- ================================================================================
-- BAGIAN E - Invoice: kolom Advance di tabel potongan
-- Tanpa kolom ini potongan Advance tidak tercatat dan jurnalnya tidak seimbang.
-- Asalnya: migrations/20261017b_invoice_pot_dp_cbd.sql
-- ================================================================================

-- ================================================================================
-- Invoice: kolom Advance (DP/CBD from Invoice) di tabel potongan
-- Dibuat 2026-10-17.
--
-- LATARNYA
-- Layar Create Invoice punya dua potongan uang muka: Down Payment dan Advance
-- (dulu bernama "DP/CBD from Invoice"). Yang pertama tersimpan di kolom dp,
-- yang kedua TIDAK PERNAH tersimpan - kolomnya memang belum ada di
-- tbl_invoice_pot. Akibatnya Grand Total yang tersimpan sudah dikurangi
-- Advance, tapi potongannya sendiri tidak tercatat di mana pun, dan jurnalnya
-- tidak mungkin seimbang.
--
-- Sekarang Advance datang dari Proforma Invoice (DP/CBD/PI NON SO) yang
-- dipanggil di layar itu, jadi kolomnya diperlukan.
--
-- AMAN DIULANG - kolomnya ditambah kalau belum ada.
--
-- CARA MEMUNDURKAN
--   ALTER TABLE tbl_invoice_pot DROP COLUMN dp_cbd;
--   ALTER TABLE tbl_invoice_pot_knitting DROP COLUMN dp_cbd;
-- ================================================================================


SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_pot' AND column_name = 'dp_cbd'), 'ALTER TABLE tbl_invoice_pot ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0 COMMENT ''Advance - uang muka dari Proforma Invoice CBD/PI NON SO'' AFTER dp', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_pot_knitting') AND NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_pot_knitting' AND column_name = 'dp_cbd'), 'ALTER TABLE tbl_invoice_pot_knitting ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0 COMMENT ''Advance - uang muka dari Proforma Invoice CBD/PI NON SO'' AFTER dp', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- --------------------------------------------------------------------------------
-- Periksa hasilnya - keduanya harus 1
-- --------------------------------------------------------------------------------
SELECT table_name, COUNT(*) AS kolom_dp_cbd
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND table_name IN ('tbl_invoice_pot', 'tbl_invoice_pot_knitting')
   AND column_name = 'dp_cbd'
 GROUP BY table_name;


-- ================================================================================
-- BAGIAN F - Proforma Invoice: kolom Billed To
-- Yang ditagih boleh beda dengan customer pemilik SO-nya.
-- Asalnya: migrations/20261019b_proforma_billed_to.sql
-- ================================================================================

-- ================================================================================
-- Proforma Invoice: kolom Billed To
-- Dibuat 2026-10-19.
--
-- LATARNYA
-- Yang ditagih tidak selalu sama dengan customer pemilik SO - cetakan invoice
-- sudah memisahkan "Purchaser / Invoice To" dari "Ship To". Proforma Invoice
-- ikut membawa keterangan itu supaya cetakannya bisa menyebut siapa yang
-- ditagih.
--
-- Kosong berarti sama dengan customernya.
--
-- AMAN DIULANG - kolomnya ditambah kalau belum ada.
--
-- CARA MEMUNDURKAN
--   ALTER TABLE tbl_invoice_proforma DROP COLUMN billed_to;
-- ================================================================================


SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_proforma' AND column_name = 'billed_to'), 'ALTER TABLE tbl_invoice_proforma ADD COLUMN billed_to VARCHAR(20) NULL DEFAULT NULL COMMENT ''id customer yang ditagih - kosong berarti sama dengan customernya'' AFTER id_customer', 'DO 0'); PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- --------------------------------------------------------------------------------
-- Periksa hasilnya - harus 1
-- --------------------------------------------------------------------------------
SELECT COUNT(*) AS kolom_billed_to
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND table_name = 'tbl_invoice_proforma'
   AND column_name = 'billed_to';


-- ================================================================================
-- SELESAI
--
-- Tiap bagian memajang hasil pemeriksaannya sendiri di atas. Yang paling
-- perlu dilihat:
--   BAGIAN B - daftar invoice yang masih tidak cocok harus KOSONG.
--   BAGIAN C - menunya bernama Approval Proforma Invoice.
--   BAGIAN D - tabel tbl_invoice_proforma_alokasi punya kolomnya.
--   BAGIAN E - kolom dp_cbd ada di tbl_invoice_pot.
-- ================================================================================
