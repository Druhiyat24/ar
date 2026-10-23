-- =====================================================================
-- PEMERIKSAAN jurnal Alokasi yang terbentuk SEBELUM perbaikan 21-10-2026.
--
-- Berkas ini HANYA MEMBACA. Tidak ada UPDATE, DELETE, atau pembuatan
-- tabel di sini - koreksinya dikerjakan manual oleh tim AR berdasarkan
-- hasil pemeriksaan ini.
--
-- Dua hal yang dulu salah di layar Alokasi, dan sudah diperbaiki di
-- sistem, tapi barisnya yang sudah terbentuk masih memakai cara lama:
--
--   1. MATA UANG & KURS.
--      Jurnalnya dulu mengikuti dropdown "Payment With", yang bawaannya
--      IDR dan sering tidak diubah. Akibatnya alokasi dari bank USD
--      tercatat IDR dengan kurs 1, dan nilai rupiahnya (debit_idr /
--      credit_idr) tidak ikut dikonversi - jadi jauh lebih kecil dari
--      semestinya. Yang benar: ikut mata uang banknya, seperti yang
--      tersimpan di kepala alokasinya (tbl_alokasi.curr).
--
--   2. NILAI MINUS DI DEBIT.
--      Pemisah positif/negatifnya dulu memakai ambang 1, bukan 0, jadi
--      nilai pecahan di bawah 1 (mis. selisih kurs 0.36) ikut dianggap
--      negatif lalu dibalik: tercatat debit -0.36, padahal mestinya
--      kredit 0.36.
--
-- Alokasi yang dibuat SESUDAH perbaikan tidak akan muncul di sini.
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. Alokasi yang jurnalnya beda mata uang / kurs dengan banknya
--    Kolom "nilai_idr_semestinya" = nilai rupiah kalau dihitung dengan
--    kurs alokasinya; bandingkan dengan "nilai_idr_tercatat".
-- ---------------------------------------------------------------------
SELECT  a.no_alk,
        a.tgl_alk,
        a.curr                        AS curr_alokasi,
        a.rate                        AS kurs_alokasi,
        j.curr                        AS curr_jurnal,
        j.rate                        AS kurs_jurnal,
        COUNT(*)                      AS jml_baris,
        ROUND(SUM(j.debit_idr + j.credit_idr), 2) AS nilai_idr_tercatat,
        ROUND(SUM((j.debit + j.credit) * IF(a.curr = 'IDR', 1, a.rate)), 2) AS nilai_idr_semestinya
FROM    tbl_list_journal AS j
JOIN    tbl_alokasi      AS a ON a.no_alk = j.no_journal
WHERE   j.type_journal = 'Alokasi'
  AND  (j.curr <> a.curr
        OR ROUND(IFNULL(j.rate, 0), 4) <> ROUND(IF(a.curr = 'IDR', 1, a.rate), 4))
GROUP BY a.no_alk, a.tgl_alk, a.curr, a.rate, j.curr, j.rate
ORDER BY a.tgl_alk DESC, a.no_alk;


-- ---------------------------------------------------------------------
-- 2. Baris jurnal alokasi yang nilainya minus
--    Kolom "semestinya" menyebutkan ke sisi mana nilainya seharusnya.
-- ---------------------------------------------------------------------
SELECT  j.no_journal,
        a.tgl_alk,
        j.no_coa,
        j.nama_coa,
        j.debit,
        j.credit,
        j.debit_idr,
        j.credit_idr,
        CASE WHEN j.debit  < 0 THEN CONCAT('kredit ', ABS(j.debit))
             WHEN j.credit < 0 THEN CONCAT('debit ',  ABS(j.credit))
             ELSE '-' END AS semestinya
FROM    tbl_list_journal AS j
JOIN    tbl_alokasi      AS a ON a.no_alk = j.no_journal
WHERE   j.type_journal = 'Alokasi'
  AND  (j.debit < 0 OR j.credit < 0 OR j.debit_idr < 0 OR j.credit_idr < 0)
ORDER BY a.tgl_alk DESC, j.no_journal, j.id;


-- ---------------------------------------------------------------------
-- 3. Alokasi yang jurnalnya tidak seimbang
--    Berguna dipakai lagi SESUDAH koreksi manual, untuk memastikan
--    tidak ada yang tertinggal.
-- ---------------------------------------------------------------------
SELECT  j.no_journal,
        a.tgl_alk,
        ROUND(SUM(j.debit), 2)      AS debit,
        ROUND(SUM(j.credit), 2)     AS kredit,
        ROUND(SUM(j.debit_idr), 2)  AS debit_idr,
        ROUND(SUM(j.credit_idr), 2) AS kredit_idr
FROM    tbl_list_journal AS j
JOIN    tbl_alokasi      AS a ON a.no_alk = j.no_journal
WHERE   j.type_journal = 'Alokasi'
GROUP BY j.no_journal, a.tgl_alk
HAVING  ABS(debit - kredit) > 0.01 OR ABS(debit_idr - kredit_idr) > 0.01
ORDER BY a.tgl_alk DESC, j.no_journal;


-- ---------------------------------------------------------------------
-- 4. Rincian satu alokasi, untuk dipakai waktu mengoreksi
--    Ganti nomornya sesuai yang sedang diperiksa.
-- ---------------------------------------------------------------------
SELECT  j.id,
        j.no_journal,
        j.no_coa,
        j.nama_coa,
        j.reff_doc,
        j.curr,
        j.rate,
        j.debit,
        j.credit,
        j.debit_idr,
        j.credit_idr,
        ROUND(j.debit  * IF(a.curr = 'IDR', 1, a.rate), 2) AS debit_idr_semestinya,
        ROUND(j.credit * IF(a.curr = 'IDR', 1, a.rate), 2) AS credit_idr_semestinya
FROM    tbl_list_journal AS j
JOIN    tbl_alokasi      AS a ON a.no_alk = j.no_journal
WHERE   j.type_journal = 'Alokasi'
  AND   j.no_journal = '0002/ALK/NAG/1026'
ORDER BY j.id;
