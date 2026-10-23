-- =====================================================================
-- PAKET MIGRASI AR ke-3 - 23 Oktober 2026
--
-- Gabungan migrasi yang masih menunggu dijalankan, disusun berurutan.
-- Isinya sama persis dengan berkas aslinya - paket ini cuma menyatukan,
-- jadi menjalankan salah satu berkasnya sendiri tetap boleh.
--
-- AMAN DIULANG. Tiap bagian memeriksa dulu sebelum mengubah, jadi bagian
-- yang sudah pernah dijalankan dilewati dengan sendirinya.
--
-- BACA SEBENTAR SEBELUM MENJALANKAN
--   * Bagian 7 & 8 yang memulihkan Cancel & Edit Invoice (HTTP 500).
--   * Beberapa bagian punya SELECT "lihat dulu" dan SELECT pemeriksaan.
--     Perhatikan hasilnya - di situ ketahuan kalau ada yang perlu
--     ditindaklanjuti manual (mis. PI yang banknya tidak ketemu
--     padanannya, atau kolom arsip yang masih kurang).
--   * Bagian 8 MENGHAPUS baris arsip yang terlanjur dibuat percobaan
--     Edit yang gagal. Yang dibuang hanya yang id-nya masih ada di tabel
--     aslinya; riwayat edit yang sudah berhasil tidak tersentuh.
--
-- ISINYA
--   1. Paket AR ke-2 - kumpulan migrasi 13-19 Oktober (termasuk kolom dp_cbd)
--      (20261019_paket_migrasi_ar2.sql)
--   2. Proforma Invoice: kolom Billed To
--      (20261019b_proforma_billed_to.sql)
--   3. Proforma Invoice: bank pindah ke b_masterbank
--      (20261020_proforma_bank_b_masterbank.sql)
--   4. Alokasi Proforma Invoice: dari kotak mana PI-nya dipanggil
--      (20261020b_alokasi_pi_sumber.sql)
--   5. Kwitansi: Debit Note ikut bisa ditarik
--      (20261020_kwitansi_debitnote.sql)
--   6. Invoice EXIM Export knitting: nilai billing di baris Invoice Summary
--      (20261023_exim_export_summary_billing.sql)
--   7. URGENT - arsip invoice ketinggalan kolom dp_cbd (Cancel & Edit HTTP 500)
--      (20261023b_arsip_invoice_kolom_dp_cbd.sql)
--   8. URGENT - buang arsip Edit yang terlanjur dari percobaan yang gagal
--      (20261023c_bersihkan_arsip_edit_gagal.sql)
-- =====================================================================


-- =====================================================================
-- BAGIAN 1 - Paket AR ke-2 - kumpulan migrasi 13-19 Oktober (termasuk kolom dp_cbd)
-- Dari: 20261019_paket_migrasi_ar2.sql
-- =====================================================================

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


-- =====================================================================
-- BAGIAN 2 - Proforma Invoice: kolom Billed To
-- Dari: 20261019b_proforma_billed_to.sql
-- =====================================================================

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


-- =====================================================================
-- BAGIAN 3 - Proforma Invoice: bank pindah ke b_masterbank
-- Dari: 20261020_proforma_bank_b_masterbank.sql
-- =====================================================================

-- ================================================================================
-- Proforma Invoice: bank pindah ke b_masterbank
-- 20 Oktober 2026
--
-- Pilihan Bank Account di layar Proforma Invoice (buat baru & edit) sekarang
-- diambil dari b_masterbank - tabel bank yang dipakai sekarang - dan cetakan
-- PI ikut membacanya dari sana. PI yang SUDAH tersimpan masih menyimpan id
-- bank dari masterbank yang lama; berkas ini memindahkan id itu ke id yang
-- sepadan di b_masterbank, dicocokkan lewat NOMOR REKENING.
--
-- Jalankan sekali di database AR, sesudah layarnya diperbarui.
-- Tidak ada PI lama? Berkas ini tidak mengubah apa pun - tetap aman dijalankan.
--
-- AMAN DIULANG. Pemetaan tiap PI dicatat dulu di tbl_migrasi_bank_proforma,
-- dan yang sudah tercatat tidak dipetakan lagi. Catatan itu juga yang dipakai
-- kalau perubahannya mau dimundurkan (lihat bagian paling bawah).
-- ================================================================================


-- --------------------------------------------------------------------------------
-- 1. Catatan pemetaan
--    Dibuat sekali. Isinya: id PI, bank lamanya, bank barunya, dan nomor
--    rekening yang dipakai mencocokkan - cukup untuk memundurkan.
-- --------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_migrasi_bank_proforma (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  id_proforma   INT         NOT NULL,
  sumber        VARCHAR(40) NOT NULL,
  id_bank_lama  INT         NULL,
  id_bank_baru  INT         NULL,
  no_rek        VARCHAR(100) NULL,
  waktu         TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_pi (sumber, id_proforma)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------------------------------
-- 2. Pemetaannya dicatat
--    Nomor rekening dibandingkan tanpa tanda hubung & spasi: masterbank menulis
--    "008-997-1979", b_masterbank kadang "0089971979".
--    PI yang sudah tercatat dilewati - itu yang membuat berkas ini aman diulang.
-- --------------------------------------------------------------------------------
INSERT IGNORE INTO tbl_migrasi_bank_proforma (id_proforma, sumber, id_bank_lama, id_bank_baru, no_rek)
SELECT p.id, 'tbl_invoice_proforma', p.id_bank, b.id, m.no_rek
  FROM tbl_invoice_proforma p
  JOIN masterbank   m ON m.id = p.id_bank
  JOIN b_masterbank b
    ON REPLACE(REPLACE(TRIM(b.bank_account), '-', ''), ' ', '')
     = REPLACE(REPLACE(TRIM(m.no_rek),       '-', ''), ' ', '')
 WHERE NOT EXISTS (
         SELECT 1 FROM tbl_migrasi_bank_proforma t
          WHERE t.sumber = 'tbl_invoice_proforma' AND t.id_proforma = p.id
       );


-- --------------------------------------------------------------------------------
-- 3. Baru id banknya dipindahkan
--    Hanya PI yang id banknya masih sama dengan yang tercatat sebagai "lama".
--    Dijalankan dua kali, syarat ini sudah tidak terpenuhi - jadi tidak ada
--    yang berubah dua kali.
-- --------------------------------------------------------------------------------
UPDATE tbl_invoice_proforma p
  JOIN tbl_migrasi_bank_proforma t
    ON t.sumber = 'tbl_invoice_proforma' AND t.id_proforma = p.id
   SET p.id_bank = t.id_bank_baru
 WHERE t.id_bank_baru IS NOT NULL
   AND p.id_bank = t.id_bank_lama;


-- --------------------------------------------------------------------------------
-- 4. PI DP/CBD yang belum ikut pindah tabel
--    Kalau paket migrasi sebelumnya sudah dijalankan, tbl_invoice_proforma_dp_cbd
--    sudah jadi VIEW dan barisnya ada di tbl_invoice_proforma - bagian ini
--    dilewati sendiri. Kalau masih tabel asli, barisnya ikut dipetakan.
-- --------------------------------------------------------------------------------
SET @masih_tabel := (SELECT COUNT(*) FROM information_schema.TABLES
                      WHERE TABLE_SCHEMA = DATABASE()
                        AND TABLE_NAME = 'tbl_invoice_proforma_dp_cbd'
                        AND TABLE_TYPE = 'BASE TABLE');

SET @s := IF(@masih_tabel = 1,
  'INSERT IGNORE INTO tbl_migrasi_bank_proforma (id_proforma, sumber, id_bank_lama, id_bank_baru, no_rek) SELECT p.id, ''tbl_invoice_proforma_dp_cbd'', p.id_bank, b.id, m.no_rek FROM tbl_invoice_proforma_dp_cbd p JOIN masterbank m ON m.id = p.id_bank JOIN b_masterbank b ON REPLACE(REPLACE(TRIM(b.bank_account), ''-'', ''''), '' '', '''') = REPLACE(REPLACE(TRIM(m.no_rek), ''-'', ''''), '' '', '''') WHERE NOT EXISTS (SELECT 1 FROM tbl_migrasi_bank_proforma t WHERE t.sumber = ''tbl_invoice_proforma_dp_cbd'' AND t.id_proforma = p.id)',
  'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(@masih_tabel = 1,
  'UPDATE tbl_invoice_proforma_dp_cbd p JOIN tbl_migrasi_bank_proforma t ON t.sumber = ''tbl_invoice_proforma_dp_cbd'' AND t.id_proforma = p.id SET p.id_bank = t.id_bank_baru WHERE t.id_bank_baru IS NOT NULL AND p.id_bank = t.id_bank_lama',
  'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- --------------------------------------------------------------------------------
-- 5. Yang tidak bisa dipetakan - PERIKSA HASIL INI
--    Nomor rekening banknya tidak ketemu di b_masterbank (banknya belum
--    didaftarkan di sana, atau nomornya beda). PI-nya tetap bisa dibuka &
--    dicetak - cuma kolom banknya kosong sampai banknya dipilih ulang di
--    layar Edit Proforma Invoice.
-- --------------------------------------------------------------------------------
SELECT p.id                AS id_pi,
       p.no_proforma_invoice AS no_pi,
       p.id_bank           AS id_bank_sekarang,
       IFNULL(m.nama_bank, '(tidak ada di masterbank)') AS bank_lama,
       IFNULL(m.no_rek, '-')                            AS no_rek_lama
  FROM tbl_invoice_proforma p
  LEFT JOIN masterbank m ON m.id = p.id_bank
 WHERE NOT EXISTS (SELECT 1 FROM b_masterbank b WHERE b.id = p.id_bank)
 ORDER BY p.id;


-- ================================================================================
-- CARA MEMUNDURKAN (kalau perlu)
--
--   UPDATE tbl_invoice_proforma p
--     JOIN tbl_migrasi_bank_proforma t
--       ON t.sumber = 'tbl_invoice_proforma' AND t.id_proforma = p.id
--      SET p.id_bank = t.id_bank_lama
--    WHERE p.id_bank = t.id_bank_baru;
--
--   DELETE FROM tbl_migrasi_bank_proforma WHERE sumber = 'tbl_invoice_proforma';
--
-- Layarnya juga harus dikembalikan ke masterbank (Model_nag::load_bank_pi dan
-- report_proforma_invoice), kalau tidak banknya tidak akan ketemu lagi.
-- ================================================================================


-- =====================================================================
-- BAGIAN 4 - Alokasi Proforma Invoice: dari kotak mana PI-nya dipanggil
-- Dari: 20261020b_alokasi_pi_sumber.sql
-- =====================================================================

-- ================================================================================
-- Alokasi Proforma Invoice: dari kotak mana PI-nya dipanggil
-- 20 Oktober 2026
--
-- Di layar Create Invoice, PI sekarang dipanggil lewat DUA kotak:
--   Proforma Invoice        - PI yang SO-nya ikut ditagih invoice itu,
--   Other Proforma Invoice  - seluruh PI yang masih outstanding, tanpa filter
--                             SO maupun customer.
--
-- Kotak kedua sengaja longgar supaya PI lama tetap bisa dipakai, jadi di
-- catatan alokasinya harus kelihatan yang mana dipanggil dari kotak mana.
-- Kolom `sumber` itu penandanya: 'PI' atau 'OTHER'.
--
-- Jalankan sekali di database AR. AMAN DIULANG - kolomnya cuma ditambah kalau
-- memang belum ada, dan baris lama diisi 'PI' sekali saja (waktu dibuat,
-- semuanya memang lewat kotak yang sekarang jadi kotak atas).
-- ================================================================================


-- --------------------------------------------------------------------------------
-- 1. Kolom penandanya
-- --------------------------------------------------------------------------------
SET @ada := (SELECT COUNT(*) FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = 'tbl_invoice_proforma_alokasi'
                AND COLUMN_NAME = 'sumber');

SET @s := IF(@ada = 0,
  'ALTER TABLE tbl_invoice_proforma_alokasi ADD COLUMN sumber VARCHAR(10) NOT NULL DEFAULT ''PI'' COMMENT ''PI = kotak Proforma Invoice (SO-nya ikut ditagih), OTHER = kotak Other Proforma Invoice'' AFTER bagian',
  'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- --------------------------------------------------------------------------------
-- 2. Baris lama
--    Sebelum ada kotak kedua, semua alokasi datang dari kotak yang sekarang
--    jadi kotak atas - jadi diisi 'PI'. Yang sudah terisi tidak disentuh.
-- --------------------------------------------------------------------------------
UPDATE tbl_invoice_proforma_alokasi
   SET sumber = 'PI'
 WHERE sumber IS NULL OR TRIM(sumber) = '';


-- --------------------------------------------------------------------------------
-- 3. Periksa hasilnya
-- --------------------------------------------------------------------------------
SELECT sumber, COUNT(*) AS jumlah, IFNULL(SUM(amount), 0) AS total_dipakai
  FROM tbl_invoice_proforma_alokasi
 GROUP BY sumber;


-- ================================================================================
-- CARA MEMUNDURKAN
--   ALTER TABLE tbl_invoice_proforma_alokasi DROP COLUMN sumber;
-- ================================================================================


-- =====================================================================
-- BAGIAN 5 - Kwitansi: Debit Note ikut bisa ditarik
-- Dari: 20261020_kwitansi_debitnote.sql
-- =====================================================================

-- ================================================================================
-- Kwitansi: Debit Note ikut bisa ditarik
-- 20 Oktober 2026
--
-- Sebelumnya Create Kwitansi hanya bisa menarik invoice (tbl_book_invoice dan
-- tbl_invoice_nb). Sekarang Debit Note juga bisa, dan satu kwitansi boleh
-- berisi campuran beberapa invoice + beberapa DN.
--
-- Yang ditambahkan:
--   1. tbl_debitnote_h.no_kwt   - penanda DN sudah masuk kwitansi, supaya
--                                 tidak bisa ditarik dua kali. Caranya sama
--                                 persis dengan tbl_book_invoice.no_kwt dan
--                                 tbl_invoice_nb.no_kwt yang sudah ada.
--   2. tbl_kwitansi_detail.sumber - 'INV' atau 'DN', dipakai layar & cetakan
--                                 untuk tahu baris itu invoice atau DN.
--   3. tbl_kwt_temp.sumber      - sama, untuk tabel sementara waktu memilih.
--
-- Jalankan sekali di database AR, sesudah kodenya diperbarui.
--
-- AMAN DIULANG: tiap ALTER diperiksa dulu, kolom yang sudah ada dilewati.
-- Selama berkas ini BELUM dijalankan, aplikasi tetap jalan seperti biasa -
-- kwitansi tetap bisa dibuat dari invoice, hanya bagian Debit Note-nya yang
-- belum muncul (lihat Model_nag::kwt_dn_siap).
-- ================================================================================

-- --------------------------------------------------------------------------------
-- 1. Penanda DN sudah dipakai di kwitansi
-- --------------------------------------------------------------------------------
SET @ada := (SELECT COUNT(*) FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME   = 'tbl_debitnote_h'
                AND COLUMN_NAME  = 'no_kwt');
SET @sql := IF(@ada = 0,
  'ALTER TABLE tbl_debitnote_h
     ADD COLUMN no_kwt VARCHAR(100) NULL DEFAULT NULL
         COMMENT ''nomor kwitansi yang memakai DN ini - kosong berarti belum ditarik'',
     ADD KEY idx_dn_h_no_kwt (no_kwt)',
  'SELECT ''tbl_debitnote_h.no_kwt sudah ada - dilewati''');
PREPARE jalan FROM @sql; EXECUTE jalan; DEALLOCATE PREPARE jalan;

-- --------------------------------------------------------------------------------
-- 2. Asal baris kwitansi: invoice atau debit note
--    Baris lama dibiarkan NULL dan dibaca sebagai 'INV' oleh aplikasinya -
--    semua kwitansi lama memang isinya invoice.
-- --------------------------------------------------------------------------------
SET @ada := (SELECT COUNT(*) FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME   = 'tbl_kwitansi_detail'
                AND COLUMN_NAME  = 'sumber');
SET @sql := IF(@ada = 0,
  'ALTER TABLE tbl_kwitansi_detail
     ADD COLUMN sumber VARCHAR(10) NULL DEFAULT NULL
         COMMENT ''INV = invoice, DN = debit note. NULL (baris lama) dibaca INV''',
  'SELECT ''tbl_kwitansi_detail.sumber sudah ada - dilewati''');
PREPARE jalan FROM @sql; EXECUTE jalan; DEALLOCATE PREPARE jalan;

-- --------------------------------------------------------------------------------
-- 3. Tabel sementara waktu memilih di layar Create Kwitansi
-- --------------------------------------------------------------------------------
SET @ada := (SELECT COUNT(*) FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME   = 'tbl_kwt_temp'
                AND COLUMN_NAME  = 'sumber');
SET @sql := IF(@ada = 0,
  'ALTER TABLE tbl_kwt_temp
     ADD COLUMN sumber VARCHAR(10) NULL DEFAULT NULL
         COMMENT ''INV = invoice, DN = debit note''',
  'SELECT ''tbl_kwt_temp.sumber sudah ada - dilewati''');
PREPARE jalan FROM @sql; EXECUTE jalan; DEALLOCATE PREPARE jalan;

-- --------------------------------------------------------------------------------
-- 4. Cek hasilnya - ketiganya harus muncul:
--      SHOW COLUMNS FROM tbl_debitnote_h      LIKE 'no_kwt';
--      SHOW COLUMNS FROM tbl_kwitansi_detail  LIKE 'sumber';
--      SHOW COLUMNS FROM tbl_kwt_temp         LIKE 'sumber';
-- --------------------------------------------------------------------------------

-- ================================================================================
-- ROLLBACK (kwitansi yang sudah berisi DN akan kehilangan penandanya):
--   ALTER TABLE tbl_debitnote_h     DROP KEY idx_dn_h_no_kwt, DROP COLUMN no_kwt;
--   ALTER TABLE tbl_kwitansi_detail DROP COLUMN sumber;
--   ALTER TABLE tbl_kwt_temp        DROP COLUMN sumber;
-- ================================================================================


-- =====================================================================
-- BAGIAN 6 - Invoice EXIM Export knitting: nilai billing di baris Invoice Summary
-- Dari: 20261023_exim_export_summary_billing.sql
-- =====================================================================

-- =====================================================================
-- Invoice EXIM Export knitting: nilai BILLING di baris Invoice Summary
--
-- LATARNYA
-- Knitting punya dua angka untuk SJ yang sama:
--   * KIRIM (shipment) - satuan & qty yang benar-benar dikirim. Ini yang
--     dipakai menu Invoice EXIM di layar maupun cetakannya.
--   * TAGIH (billing)  - satuan & qty yang ditagihkan ke customer. Ini
--     yang harus dipakai AR.
--
-- Baris SJ-nya sudah membawa keduanya (tbl_book_invoice_exim_det:
-- qty_tagih, unit_price_tagih, total_price_tagih sejak migrasi 20261008).
-- Baris Invoice Summary belum - isinya baru angka kirim, padahal baris
-- itulah yang ditarik AR waktu invoicenya dibuat.
--
-- Kolom di bawah menampung angka billing baris summary. Yang lama tidak
-- diubah sama sekali, jadi tampilan & cetakan EXIM tetap memakai angka
-- kirim seperti sekarang.
--
-- Kosong / nol berarti baris itu memang tidak punya angka billing
-- tersendiri (garment) - pemakainya jatuh ke angka kirim.
--
-- AMAN DIULANG - kolomnya ditambah kalau belum ada, dan pengisiannya
-- hanya menyentuh baris yang masih kosong.
--
-- CARA MEMUNDURKAN
--   ALTER TABLE tbl_book_invoice_exim_export_det
--     DROP COLUMN qty_invoiced_tagih, DROP COLUMN unit_tagih,
--     DROP COLUMN total_cm_tagih,     DROP COLUMN total_fob_tagih;
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. Kolomnya
-- ---------------------------------------------------------------------
SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns
                          WHERE table_schema = DATABASE()
                            AND table_name = 'tbl_book_invoice_exim_export_det'
                            AND column_name = 'qty_invoiced_tagih'),
    'ALTER TABLE tbl_book_invoice_exim_export_det
       ADD COLUMN qty_invoiced_tagih DECIMAL(18,4) NOT NULL DEFAULT 0
       COMMENT ''qty billing baris ini - 0 berarti ikut qty kirim''
       AFTER qty_invoiced',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns
                          WHERE table_schema = DATABASE()
                            AND table_name = 'tbl_book_invoice_exim_export_det'
                            AND column_name = 'unit_tagih'),
    'ALTER TABLE tbl_book_invoice_exim_export_det
       ADD COLUMN unit_tagih VARCHAR(20) NULL DEFAULT NULL
       COMMENT ''satuan billing - kosong berarti ikut satuan kirim''
       AFTER qty_invoiced_tagih',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns
                          WHERE table_schema = DATABASE()
                            AND table_name = 'tbl_book_invoice_exim_export_det'
                            AND column_name = 'total_cm_tagih'),
    'ALTER TABLE tbl_book_invoice_exim_export_det
       ADD COLUMN total_cm_tagih DECIMAL(18,4) NOT NULL DEFAULT 0
       COMMENT ''total CM billing - 0 berarti ikut total CM kirim''
       AFTER total_cm',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

SET @s := IF(NOT EXISTS (SELECT 1 FROM information_schema.columns
                          WHERE table_schema = DATABASE()
                            AND table_name = 'tbl_book_invoice_exim_export_det'
                            AND column_name = 'total_fob_tagih'),
    'ALTER TABLE tbl_book_invoice_exim_export_det
       ADD COLUMN total_fob_tagih DECIMAL(18,4) NOT NULL DEFAULT 0
       COMMENT ''total FOB billing - 0 berarti ikut total FOB kirim''
       AFTER total_fob',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ---------------------------------------------------------------------
-- 2. Lihat dulu invoice mana yang akan terisi - belum mengubah apa pun
--    Hanya baris summary yang punya baris SJ knitting (qty_tagih > 0).
-- ---------------------------------------------------------------------
SELECT  b.no_invoice,
        s.urutan,
        s.color_name,
        s.qty_invoiced                      AS qty_kirim,
        ROUND(SUM(d.qty_tagih), 4)          AS qty_billing,
        s.total_cm                          AS total_cm_kirim,
        ROUND(SUM(d.total_price_tagih), 4)  AS total_cm_billing
FROM    tbl_book_invoice_exim_export_det AS s
JOIN    tbl_book_invoice                 AS b ON b.id = s.id_book_invoice
JOIN    tbl_book_invoice_exim_det        AS d
          ON d.id_book_invoice = s.id_book_invoice
         AND d.urutan_summary  = s.urutan
WHERE   IFNULL(d.qty_tagih, 0) > 0
GROUP BY b.no_invoice, s.id, s.urutan, s.color_name, s.qty_invoiced, s.total_cm
ORDER BY b.no_invoice, s.urutan;


-- ---------------------------------------------------------------------
-- 3. Isi nilai billing invoice yang sudah terbuat
--    Diambil dari baris SJ-nya sendiri, dikaitkan lewat urutan summary -
--    cara yang sama dengan yang dipakai waktu invoicenya disimpan.
--
--    Baris yang nilai billingnya sudah terisi tidak disentuh, jadi skrip
--    ini aman dijalankan ulang dan tidak menimpa koreksi manual.
-- ---------------------------------------------------------------------
UPDATE  tbl_book_invoice_exim_export_det AS s
JOIN    (SELECT d.id_book_invoice,
                d.urutan_summary,
                ROUND(SUM(d.qty_tagih), 4)         AS qty_tagih,
                ROUND(SUM(d.total_price_tagih), 4) AS total_tagih,
                MIN(NULLIF(TRIM(d.uom_tagih), ''))  AS uom_tagih
           FROM tbl_book_invoice_exim_det AS d
          WHERE IFNULL(d.qty_tagih, 0) > 0
            AND d.urutan_summary IS NOT NULL
          GROUP BY d.id_book_invoice, d.urutan_summary) AS t
          ON t.id_book_invoice = s.id_book_invoice
         AND t.urutan_summary  = s.urutan
SET     s.qty_invoiced_tagih = t.qty_tagih,
        s.unit_tagih         = t.uom_tagih,
        s.total_cm_tagih     = t.total_tagih,
        -- FOB billing mengikuti perbandingan FOB : CM yang sudah ada di
        -- baris itu. Kalau CM kirimnya nol, perbandingannya tidak bisa
        -- dihitung - FOB billing disamakan dengan CM billing.
        s.total_fob_tagih    = CASE
                                   WHEN IFNULL(s.total_cm, 0) <> 0
                                       THEN ROUND(t.total_tagih * (IFNULL(s.total_fob, 0) / s.total_cm), 4)
                                   ELSE t.total_tagih
                               END
WHERE   IFNULL(s.qty_invoiced_tagih, 0) = 0;


-- ---------------------------------------------------------------------
-- 4. Periksa hasilnya
-- ---------------------------------------------------------------------

-- 4a. Berapa baris summary yang sekarang punya nilai billing.
SELECT COUNT(*) AS baris_summary_dengan_billing
  FROM tbl_book_invoice_exim_export_det
 WHERE IFNULL(qty_invoiced_tagih, 0) > 0;

-- 4b. Masih ada baris SJ knitting yang baris summary-nya belum terisi?
--     Hasilnya harus kosong.
SELECT  b.no_invoice, d.urutan_summary, ROUND(SUM(d.qty_tagih), 4) AS qty_billing
FROM    tbl_book_invoice_exim_det AS d
JOIN    tbl_book_invoice          AS b ON b.id = d.id_book_invoice
JOIN    tbl_book_invoice_exim_export_det AS s
          ON s.id_book_invoice = d.id_book_invoice
         AND s.urutan          = d.urutan_summary
WHERE   IFNULL(d.qty_tagih, 0) > 0
  AND   IFNULL(s.qty_invoiced_tagih, 0) = 0
GROUP BY b.no_invoice, d.urutan_summary
ORDER BY b.no_invoice, d.urutan_summary;


-- =====================================================================
-- BAGIAN 7 - URGENT - arsip invoice ketinggalan kolom dp_cbd (Cancel & Edit HTTP 500)
-- Dari: 20261023b_arsip_invoice_kolom_dp_cbd.sql
-- =====================================================================

-- =====================================================================
-- URGENT - Cancel Invoice & Edit Invoice gagal (HTTP 500)
--
-- GEJALANYA
--   * Cancel Invoice: "Invoice ... was not cancelled. The server answered
--     with HTTP 500."
--   * Edit Invoice: Save berhenti di langkah "Clearing the previous rows
--     (HTTP 500)".
--
-- SEBABNYA
-- Kolom dp_cbd (Advance) ditambahkan ke tbl_invoice_pot dan
-- tbl_invoice_pot_knitting lewat migrasi 20261017b / paket 20261019.
-- Tabel ARSIP-nya tidak ikut ditambah, padahal:
--
--   * Cancel menyalin dengan  INSERT INTO tplog_batalinvoice_pot
--                             SELECT * FROM tbl_invoice_pot ...
--     Jumlah kolomnya beda -> MySQL menolak (error 1136).
--
--   * Edit menyalin per kolom ke tbl_invoice_pot_edit. Kolom dp_cbd tidak
--     ada di sana -> MySQL menolak (error 1054).
--
-- Dua-duanya berakhir sebagai HTTP 500, dan karena gagal di tengah,
-- tidak ada yang berubah - invoicenya aman.
--
-- Skrip ini menambahkan kolom yang kurang di tabel arsipnya. Tidak ada
-- data yang diubah.
--
-- AMAN DIULANG - kolomnya ditambah hanya kalau tabelnya ada dan kolomnya
-- memang belum ada.
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. Lihat dulu bedanya - belum mengubah apa pun
--    Hasilnya: kolom yang ada di tabel sumber tapi tidak ada di arsipnya.
--    Sesudah skrip ini dijalankan, hasilnya harus kosong.
-- ---------------------------------------------------------------------
SELECT  'tbl_invoice_pot -> tplog_batalinvoice_pot' AS pasangan, s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice_pot'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_pot_knitting -> tplog_batalinvoice_pot_knitting', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot_knitting'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice_pot_knitting'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_pot -> tbl_invoice_pot_edit', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tbl_invoice_pot_edit'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_detail -> tbl_invoice_detail_edit', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_detail'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tbl_invoice_detail_edit'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_detail -> tplog_batalinvoice_detail', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_detail'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice_detail'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_invoice_detail_knitting -> tplog_batalinvoice_detail_knitting', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_detail_knitting'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice_detail_knitting'
                       AND a.column_name = s.column_name)
UNION ALL
SELECT  'tbl_book_invoice -> tplog_batalinvoice', s.column_name
  FROM  information_schema.columns s
 WHERE  s.table_schema = DATABASE() AND s.table_name = 'tbl_book_invoice'
   AND  NOT EXISTS (SELECT 1 FROM information_schema.columns a
                     WHERE a.table_schema = DATABASE()
                       AND a.table_name = 'tplog_batalinvoice'
                       AND a.column_name = s.column_name);


-- ---------------------------------------------------------------------
-- 2. Tambahkan kolom dp_cbd di tabel arsipnya
-- ---------------------------------------------------------------------

-- 2a. Arsip pembatalan - potongan garment
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables
                      WHERE table_schema = DATABASE() AND table_name = 'tplog_batalinvoice_pot')
             AND NOT EXISTS (SELECT 1 FROM information_schema.columns
                              WHERE table_schema = DATABASE()
                                AND table_name = 'tplog_batalinvoice_pot'
                                AND column_name = 'dp_cbd'),
    'ALTER TABLE tplog_batalinvoice_pot
       ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0
       COMMENT ''Advance - mengikuti tbl_invoice_pot'' AFTER dp',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2b. Arsip pembatalan - potongan knitting
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables
                      WHERE table_schema = DATABASE() AND table_name = 'tplog_batalinvoice_pot_knitting')
             AND NOT EXISTS (SELECT 1 FROM information_schema.columns
                              WHERE table_schema = DATABASE()
                                AND table_name = 'tplog_batalinvoice_pot_knitting'
                                AND column_name = 'dp_cbd'),
    'ALTER TABLE tplog_batalinvoice_pot_knitting
       ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0
       COMMENT ''Advance - mengikuti tbl_invoice_pot_knitting'' AFTER dp',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;

-- 2c. Arsip saat Edit Invoice
SET @s := IF(EXISTS (SELECT 1 FROM information_schema.tables
                      WHERE table_schema = DATABASE() AND table_name = 'tbl_invoice_pot_edit')
             AND NOT EXISTS (SELECT 1 FROM information_schema.columns
                              WHERE table_schema = DATABASE()
                                AND table_name = 'tbl_invoice_pot_edit'
                                AND column_name = 'dp_cbd'),
    'ALTER TABLE tbl_invoice_pot_edit
       ADD COLUMN dp_cbd DOUBLE NOT NULL DEFAULT 0
       COMMENT ''Advance - mengikuti tbl_invoice_pot'' AFTER dp',
    'DO 0');
PREPARE p FROM @s; EXECUTE p; DEALLOCATE PREPARE p;


-- ---------------------------------------------------------------------
-- 3. Periksa hasilnya
--    Jalankan lagi query bagian 1 - hasilnya harus KOSONG.
--    Kalau masih ada baris yang keluar, kolom itu juga perlu ditambahkan
--    ke tabel arsipnya dengan cara yang sama seperti di bagian 2.
-- ---------------------------------------------------------------------
SELECT COUNT(*) AS kolom_arsip_yang_masih_kurang
  FROM (
    SELECT s.column_name
      FROM information_schema.columns s
     WHERE s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot'
       AND NOT EXISTS (SELECT 1 FROM information_schema.columns a
                        WHERE a.table_schema = DATABASE()
                          AND a.table_name IN ('tplog_batalinvoice_pot', 'tbl_invoice_pot_edit')
                          AND a.column_name = s.column_name
                          AND a.table_name = 'tplog_batalinvoice_pot')
    UNION ALL
    SELECT s.column_name
      FROM information_schema.columns s
     WHERE s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot'
       AND NOT EXISTS (SELECT 1 FROM information_schema.columns a
                        WHERE a.table_schema = DATABASE()
                          AND a.table_name = 'tbl_invoice_pot_edit'
                          AND a.column_name = s.column_name)
    UNION ALL
    SELECT s.column_name
      FROM information_schema.columns s
     WHERE s.table_schema = DATABASE() AND s.table_name = 'tbl_invoice_pot_knitting'
       AND NOT EXISTS (SELECT 1 FROM information_schema.columns a
                        WHERE a.table_schema = DATABASE()
                          AND a.table_name = 'tplog_batalinvoice_pot_knitting'
                          AND a.column_name = s.column_name)
  ) x;


-- =====================================================================
-- BAGIAN 8 - URGENT - buang arsip Edit yang terlanjur dari percobaan yang gagal
-- Dari: 20261023c_bersihkan_arsip_edit_gagal.sql
-- =====================================================================

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


-- =====================================================================
-- SELESAI
--
-- Sesudah ini, dua hal yang paling cepat dicek di layar:
--   * Cancel & Edit satu invoice - tidak boleh ada HTTP 500 lagi.
--   * Create Invoice AR dari booking EXIM knitting - qty & totalnya
--     harus memakai angka BILLING, bukan angka kirim.
-- =====================================================================
