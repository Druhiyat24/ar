-- =====================================================================
-- Projection Report: dua kolom baru - Type (Invoice / Debit Note) dan
-- Bank & Acc No.
--
-- DI LAYAR PROYEKSI keduanya TIDAK perlu disimpan: dihitung saat laporan
-- dibuka, dari tabel dokumennya langsung (lihat peta_bank_invoice() di
-- Model_report). Berkas ini hanya mengurus HISTORY-nya.
--
-- KENAPA HISTORY HARUS MENYIMPAN SENDIRI
--   tbl_history_projection_det itu POTRET. Seluruh isinya - nilai, kurs,
--   tanggal rencana - disalin saat dokumen proyeksi dibuat, supaya laporan
--   yang sama dibuka bulan depan tetap mengeluarkan angka yang sama
--   walaupun invoicenya diedit belakangan. Kalau Type & Bank dibaca ulang
--   dari tabel invoice tiap kali dokumen dibuka, dua kolom ini jadi
--   satu-satunya yang bisa berubah sendiri di dalam potret - mis. waktu tim
--   AR mengganti rekening tujuan sebuah invoice. Jadi keduanya ikut
--   disalin.
--
--   Konsekuensinya memang disadari: dokumen yang SUDAH TERLANJUR dibuat
--   sebelum migrasi ini punya dua kolom kosong. LANGKAH 4 mengisinya
--   sekali, dari keadaan tabel invoice HARI INI - itu tebakan terbaik yang
--   tersedia, dan sesudahnya tidak pernah berubah lagi.
--
-- AMAN DIULANG. Penambahan kolomnya dijaga information_schema, pengisian
-- awalnya hanya menyentuh baris yang masih kosong.
-- =====================================================================


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu keadaannya. Sebelum dijalankan hasilnya 0 baris.
-- ---------------------------------------------------------------------
SELECT table_name, column_name, column_type
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND table_name IN ('tbl_history_projection_det', 'tbl_history_projection_det_cancel')
   AND column_name IN ('doc_type', 'bank_acc')
 ORDER BY table_name, column_name;


-- ---------------------------------------------------------------------
-- LANGKAH 2 - kolomnya di tabel detail history.
--
-- doc_type cuma dua nilai ('Invoice' / 'Debit Note') tapi disimpan sebagai
-- teks, bukan ENUM: kalau nanti ada jenis dokumen ketiga, menambahnya tidak
-- perlu ALTER TABLE di basis data yang sudah besar.
--
-- bank_acc disimpan SUDAH DALAM BENTUK TAMPILAN ("BANK CENTRAL ASIA -
-- 008-751-5757"), bukan id ke masterbank. Alasannya sama dengan di atas:
-- ini potret. Nomor rekening yang dulu dicantumkan di invoice harus tetap
-- terbaca walau barisnya di masterbank sudah diubah atau dihapus.
-- ---------------------------------------------------------------------
SET @sql := (
    SELECT IF(COUNT(*) = 0,
        'ALTER TABLE tbl_history_projection_det
            ADD COLUMN doc_type VARCHAR(20)  NULL AFTER type_so,
            ADD COLUMN bank_acc VARCHAR(120) NULL AFTER doc_type',
        'SELECT ''tbl_history_projection_det: kolomnya sudah ada'' AS catatan')
      FROM information_schema.columns
     WHERE table_schema = DATABASE()
       AND table_name   = 'tbl_history_projection_det'
       AND column_name  = 'doc_type'
);
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;


-- ---------------------------------------------------------------------
-- LANGKAH 3 - kolom yang sama di tabel salinan dokumen yang dibatalkan.
--
-- Tabel itu dibuat lewat CREATE TABLE ... LIKE waktu pembatalan pertama,
-- jadi di basis data yang belum pernah membatalkan dokumen proyeksi, tabel
-- ini memang belum ada - dan nanti lahir sudah ikut berkolom baru. Yang
-- diurus di sini cuma yang SUDAH terlanjur ada: tanpa ini, INSERT ... SELECT
-- * waktu membatalkan dokumen akan gagal karena jumlah kolomnya beda.
-- ---------------------------------------------------------------------
-- COUNT(*), BUKAN SUM(...): atas tabel yang belum ada, hasil penyaringnya
-- nol baris - dan SUM() atas nol baris mengembalikan NULL, bukan 0.
-- Perbandingan apa pun terhadap NULL bernilai NULL, jadi semua cabang WHEN
-- terlewat dan yang jalan ELSE-nya: ALTER TABLE atas tabel yang belum ada.
SET @sql := (
    SELECT CASE
        WHEN COUNT(*) = 0
             THEN 'SELECT ''tabel cancel belum ada - akan lahir ikut kolom barunya'' AS catatan'
        WHEN SUM(column_name = 'doc_type') > 0
             THEN 'SELECT ''tabel cancel: kolomnya sudah ada'' AS catatan'
        ELSE 'ALTER TABLE tbl_history_projection_det_cancel
                 ADD COLUMN doc_type VARCHAR(20)  NULL AFTER type_so,
                 ADD COLUMN bank_acc VARCHAR(120) NULL AFTER doc_type'
    END
      FROM information_schema.columns
     WHERE table_schema = DATABASE()
       AND table_name   = 'tbl_history_projection_det_cancel'
);
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;


-- ---------------------------------------------------------------------
-- LANGKAH 4 - isi awal untuk dokumen yang sudah terlanjur dibuat.
--
-- Sumbernya sama persis dengan yang dipakai layar proyeksi:
--   tbl_book_invoice.id_bank  -> masterbank.id
--   tbl_invoice_nb.bank       -> masterbank.id  (disimpan sebagai teks)
--   tbl_debitnote_h.akun      -> masterbank.no_rek
--   saldoawal_ar              -> tidak punya bank sama sekali -> '-'
--
-- Type ditentukan dari TABEL ASALNYA, bukan dari pola nomornya - kecuali
-- untuk saldo awal, yang satu-satunya penandanya memang nomor dokumennya
-- ('%DN/%').
--
-- Hanya baris yang kolomnya masih NULL yang disentuh, jadi menjalankan
-- berkas ini dua kali tidak menimpa apa pun.
-- ---------------------------------------------------------------------
-- Nama banknya DIPENDEKKAN, sama seperti di layar: "BANK CENTRAL ASIA"
-- jadi "BCA" (diminta tim AR 5 Nov 2026). Daftarnya disamakan dengan
-- singkat_bank() di Model_report; yang tidak ada di daftar dibiarkan
-- bernama panjang - lebih baik panjang daripada salah singkat.
--
-- Ketiga sumber digabung dengan COALESCE SEBELUM dipendekkan, jadi CASE-nya
-- cukup ditulis sekali. Urutannya sama dengan di PHP: booking, lalu invoice
-- manual, lalu debit note.
UPDATE tbl_history_projection_det d
  LEFT JOIN tbl_book_invoice bi ON bi.no_invoice = d.no_invoice
  LEFT JOIN masterbank      mb1 ON mb1.id        = bi.id_bank
  LEFT JOIN tbl_invoice_nb   nb ON nb.no_inv     = d.no_invoice
  LEFT JOIN masterbank      mb2 ON mb2.id        = nb.bank
  LEFT JOIN tbl_debitnote_h  dn ON dn.no_dn      = d.no_invoice
  LEFT JOIN masterbank      mb3 ON mb3.no_rek    = dn.akun
   SET d.doc_type = CASE
                        WHEN dn.no_dn IS NOT NULL            THEN 'Debit Note'
                        WHEN bi.no_invoice IS NOT NULL
                          OR nb.no_inv  IS NOT NULL          THEN 'Invoice'
                        WHEN d.no_invoice LIKE '%DN/%'       THEN 'Debit Note'
                        ELSE 'Invoice'
                    END,
       d.bank_acc = IFNULL(
           CONCAT(
               CASE
                   WHEN UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank)) LIKE '%CENTRAL ASIA%'      THEN 'BCA'
                   WHEN UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank)) LIKE '%NEGARA INDONESIA%'  THEN 'BNI'
                   WHEN UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank)) LIKE '%RAKYAT INDONESIA%'  THEN 'BRI'
                   WHEN UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank)) LIKE '%TABUNGAN NEGARA%'   THEN 'BTN'
                   WHEN UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank)) LIKE '%SYARIAH INDONESIA%' THEN 'BSI'
                   WHEN UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank)) LIKE '%CIMB%'              THEN 'CIMB'
                   WHEN UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank)) LIKE '%MANDIRI%'           THEN 'MANDIRI'
                   WHEN UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank)) LIKE '%PERMATA%'           THEN 'PERMATA'
                   WHEN UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank)) LIKE '%DANAMON%'           THEN 'DANAMON'
                   ELSE UPPER(COALESCE(mb1.nama_bank, mb2.nama_bank, mb3.nama_bank))
               END,
               ' - ',
               COALESCE(mb1.no_rek, mb2.no_rek, mb3.no_rek)),
           '-')
 WHERE d.doc_type IS NULL OR d.bank_acc IS NULL;


-- ---------------------------------------------------------------------
-- LANGKAH 5 - periksa hasilnya.
--
-- Yang pertama: kolomnya sudah ada (harus 2 baris untuk tabel detail).
-- Yang kedua: sebaran isinya. Baris ber-bank '-' itu WAJAR - saldo awal dan
-- invoice yang memang belum ditentukan rekeningnya (di produksi ada ribuan
-- tbl_book_invoice dengan id_bank NULL).
-- ---------------------------------------------------------------------
SELECT table_name, column_name, column_type
  FROM information_schema.columns
 WHERE table_schema = DATABASE()
   AND table_name IN ('tbl_history_projection_det', 'tbl_history_projection_det_cancel')
   AND column_name IN ('doc_type', 'bank_acc')
 ORDER BY table_name, column_name;

SELECT doc_type,
       SUM(bank_acc = '-')  AS tanpa_bank,
       SUM(bank_acc <> '-') AS ada_bank,
       COUNT(*)             AS jml
  FROM tbl_history_projection_det
 GROUP BY doc_type;
