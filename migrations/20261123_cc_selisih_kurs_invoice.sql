-- =====================================================================
-- Baris SELISIH KURS di jurnal invoice: cost centernya diisi.
--
-- APA YANG TERJADI
--   Jurnal invoice yang memakai uang muka valas membawa satu baris
--   tambahan di COA 8.52.01 LABA / (RUGI) SELISIH KURS SUDAH TEREALISASI.
--   Barisnya ditulis dengan no_costcenter '-', padahal 8.52.01 akun laba
--   rugi: tanpa cost center, bebannya tidak terbagi ke departemen mana pun.
--
--   Penyebabnya sudah dibereskan di Model_nag::_jurnal_tambah_advance()
--   (lihat _sql_cc_selisih_kurs) - invoice yang di-approve SESUDAH
--   perbaikan itu langsung membawa cost centernya. Berkas ini mengurus
--   baris yang SUDAH TERLANJUR tertulis tanpa cost center.
--
-- CARA KERJANYA
--   Cost centernya ikut profit center barisnya, sesuai permintaan tim AR:
--
--     NAG -> DEP06SUB001    FINANCE, ACCOUNTING & TAX
--     NAK -> DEPNK09SUB001  FINANCE, ACCOUNTING & TAX
--
--   Tidak ada angka yang disentuh - debit, kredit, kurs & keterangannya
--   tetap apa adanya. Yang diisi hanya dua kolom cost center.
--
-- YANG SENGAJA TIDAK DISENTUH
--   COA 8.52.01 dipakai BANYAK modul lain (Bank Keluar, Payment, Payment
--   Voucher, Alokasi, OTHERS, FOREX GAIN OR LOSS, ...) dan sebagian juga
--   kosong cost centernya. Aturan departemennya belum tentu sama, jadi
--   berkas ini HANYA menyentuh baris ber-type_journal = 'Invoice'.
--
--   Baris yang profit centernya bukan NAG / NAK juga dilewati - tidak ada
--   cost center yang bisa dipastikan untuk itu. Query pemeriksaan di
--   bagian akhir akan memperlihatkannya kalau memang ada.
--
-- AMAN DIULANG. Yang diisi cuma baris yang cost centernya masih kosong
-- atau '-', jadi menjalankannya dua kali tidak mengubah apa-apa lagi.
--
-- Jalankan di: signalbit (database AR)
-- =====================================================================

-- ---------------------------------------------------------------------
-- 1. Sebelum: berapa baris yang akan terisi
-- ---------------------------------------------------------------------
SELECT 'SEBELUM' AS tahap,
       profit_center,
       COUNT(*) AS baris_tanpa_cost_center
  FROM tbl_list_journal
 WHERE no_coa = '8.52.01'
   AND type_journal = 'Invoice'
   AND IFNULL(no_costcenter, '') IN ('', '-')
 GROUP BY profit_center;

-- ---------------------------------------------------------------------
-- 2. Isi cost centernya - tbl_list_journal
-- ---------------------------------------------------------------------
UPDATE tbl_list_journal
   SET no_costcenter   = IF(UPPER(TRIM(profit_center)) = 'NAK',
                            'DEPNK09SUB001', 'DEP06SUB001'),
       nama_costcenter = 'FINANCE, ACCOUNTING & TAX'
 WHERE no_coa = '8.52.01'
   AND type_journal = 'Invoice'
   AND IFNULL(no_costcenter, '') IN ('', '-')
   AND UPPER(TRIM(IFNULL(profit_center, ''))) IN ('NAG', 'NAK');

-- ---------------------------------------------------------------------
-- 3. Isi cost centernya - sb_list_journal (jurnal invoice knitting lama)
-- ---------------------------------------------------------------------
UPDATE sb_list_journal
   SET no_costcenter   = IF(UPPER(TRIM(profit_center)) = 'NAK',
                            'DEPNK09SUB001', 'DEP06SUB001'),
       nama_costcenter = 'FINANCE, ACCOUNTING & TAX'
 WHERE no_coa = '8.52.01'
   AND type_journal = 'Invoice'
   AND IFNULL(no_costcenter, '') IN ('', '-')
   AND UPPER(TRIM(IFNULL(profit_center, ''))) IN ('NAG', 'NAK');

-- ---------------------------------------------------------------------
-- 4. Sesudah: semua baris invoice 8.52.01 harus sudah bercost center
--
--    baris_tanpa_cost_center HARUS 0. Kalau masih ada isinya, baris itu
--    profit centernya bukan NAG / NAK - tanyakan dulu ke tim AR mau
--    dimasukkan ke departemen mana, jangan ditebak.
-- ---------------------------------------------------------------------
SELECT 'SESUDAH' AS tahap,
       SUM(IFNULL(no_costcenter, '') IN ('', '-'))        AS baris_tanpa_cost_center,
       SUM(no_costcenter = 'DEP06SUB001')                 AS nag,
       SUM(no_costcenter = 'DEPNK09SUB001')               AS nak,
       COUNT(*)                                           AS seluruhnya
  FROM tbl_list_journal
 WHERE no_coa = '8.52.01'
   AND type_journal = 'Invoice';

-- Rinciannya, untuk dicocokkan tim AR.
SELECT no_journal, tgl_journal, profit_center,
       no_costcenter, nama_costcenter, debit_idr, credit_idr, keterangan
  FROM tbl_list_journal
 WHERE no_coa = '8.52.01'
   AND type_journal = 'Invoice'
 ORDER BY tgl_journal, no_journal;
