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
