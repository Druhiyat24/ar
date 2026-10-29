-- =====================================================================
-- PERBAIKAN jurnal Alokasi yang sisi KREDITnya tidak tertulis.
--
-- Gejalanya: di buku besar, nomor alokasi (mis. 0013/ALK/NAG/1026) cuma
-- punya baris DEBIT di COA 1.90.02 POS SILANG PIUTANG USAHA. Kolom Cr
-- kosong, jadi Balance-nya sama dengan Db-nya - jurnalnya tidak seimbang.
--
-- Sebabnya: waktu Alokasi disimpan, jurnalnya dikirim dalam dua kiriman
-- terpisah (debit dulu, lalu kredit). Kiriman keduanya tidak ditunggu
-- sampai selesai, jadi kalau halamannya keburu pindah, baris kreditnya
-- tidak pernah sampai ke database. Sisi debitnya sudah terlanjur masuk.
--
-- Berkas ini membentuk ULANG baris kreditnya dari sumber yang sama dengan
-- yang dipakai layar Alokasi:
--
--   baris jurnal kredit  =  tbl_alokasi_detail (1 baris = 1 baris jurnal)
--   mata uang & kurs     =  baris DEBIT jurnalnya sendiri (1.90.02)
--   nama COA             =  mastercoa_v2
--
-- Kurs sengaja diambil dari baris debit yang SUDAH ADA, bukan dari kepala
-- alokasi: itulah kurs yang benar-benar dipakai waktu jurnalnya ditulis,
-- jadi hasilnya dijamin seimbang dengan debitnya.
--
-- Baris alokasi ke Proforma Invoice ikut DIPECAH seperti di layar: sebesar
-- DPP ke COA uang muka, sisanya ke PPN KELUARAN. Porsinya twot / total PI.
--
-- Baris detail yang nilainya MINUS (selisih kurs / pembulatan) ditulis ke
-- sisi debit dengan nilai positif - sama seperti layarnya.
--
-- CARA PAKAI: jalankan langkah 1 s/d 6 berurutan. Langkah 1-3 cuma
-- membaca & menyiapkan; yang benar-benar menulis ke buku besar hanya
-- langkah 4. Jangan lompat ke langkah 4 sebelum hasil langkah 3 bersih.
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. PERIKSA DULU - alokasi mana yang sisi kreditnya hilang
--
--    "baris_detail" = jumlah baris yang nanti akan dibuat. Kalau 0,
--    detail alokasinya ikut hilang - kasus itu TIDAK bisa diperbaiki
--    berkas ini, alokasinya harus diinput ulang oleh tim AR.
-- ---------------------------------------------------------------------
SELECT  j.no_journal,
        MAX(j.tgl_journal)                   AS tgl_journal,
        MAX(j.buyer)                         AS customer,
        MAX(j.curr)                          AS curr,
        MAX(j.rate)                          AS kurs,
        ROUND(SUM(j.debit), 2)               AS debit,
        ROUND(SUM(j.credit), 2)              AS kredit,
        ROUND(SUM(j.debit_idr), 2)           AS debit_idr,
        ROUND(SUM(j.credit_idr), 2)          AS kredit_idr,
        (SELECT COUNT(*) FROM tbl_alokasi_detail d
          WHERE d.no_alk = j.no_journal AND d.amount <> 0) AS baris_detail
FROM    tbl_list_journal AS j
WHERE   j.type_journal = 'Alokasi'
GROUP BY j.no_journal
HAVING  kredit = 0 AND debit > 0
ORDER BY tgl_journal DESC, j.no_journal;


-- ---------------------------------------------------------------------
-- 2a. View bantu - dua sumber yang dipakai langkah 2b
-- ---------------------------------------------------------------------
DROP VIEW IF EXISTS v_alk_sisi_debit;
CREATE VIEW v_alk_sisi_debit AS
SELECT  j.no_journal,
        MAX(j.tgl_journal)         AS tgl_journal,
        MAX(j.type_journal)        AS type_journal,
        MAX(j.buyer)               AS buyer,
        MAX(j.status)              AS status,
        MAX(j.keterangan)          AS keterangan,
        MAX(j.create_by)           AS create_by,
        MAX(j.create_date)         AS create_date,
        IFNULL(NULLIF(TRIM(MAX(j.curr)), ''), 'IDR') AS curr,
        IF(IFNULL(NULLIF(TRIM(MAX(j.curr)), ''), 'IDR') = 'IDR',
           1, IFNULL(NULLIF(MAX(j.rate), 0), 1))     AS rate,
        ROUND(SUM(j.debit), 4)     AS debit,
        ROUND(SUM(j.debit_idr), 2) AS debit_idr
FROM    tbl_list_journal AS j
WHERE   j.type_journal = 'Alokasi'
  AND   j.no_coa       = '1.90.02'
  AND   j.debit        > 0
  AND   j.tgl_journal >= '2026-10-01'        -- <<< ganti di sini >>>
  -- cuma jurnal yang sisi kreditnya benar-benar kosong
  AND   NOT EXISTS (SELECT 1 FROM tbl_list_journal AS z
                     WHERE z.no_journal = j.no_journal
                       AND (z.credit <> 0 OR z.credit_idr <> 0))
GROUP BY j.no_journal;

DROP VIEW IF EXISTS v_alk_baris_detail;
CREATE VIEW v_alk_baris_detail AS
SELECT  d.id,
        d.no_alk,
        d.coa,
        d.cost_center,
        d.no_ref,
        d.ref_date,
        d.amount,
        d.keterangan,
        d.profit_center,
        ABS(d.amount)                                            AS nilai,
        ROUND(ABS(d.amount) * b.rate, 2)                         AS nilai_idr,
        IFNULL((SELECT m.no_coa FROM mastercoa_v2 AS m
                 WHERE m.inv_type LIKE '%PPN INV%' LIMIT 1), '') AS coa_ppn,
        -- porsi DPP-nya; 1 artinya tidak ada PPN yang perlu dipisah
        IF(p.no_proforma_invoice IS NOT NULL
           AND IFNULL(p.total, 0) > 0 AND IFNULL(p.twot, 0) > 0,
           ROUND(p.twot / p.total, 6), 1)                        AS rasio,
        IF(p.no_proforma_invoice IS NOT NULL
           AND IFNULL(p.total, 0) > 0 AND IFNULL(p.twot, 0) > 0
           AND ROUND(p.twot / p.total, 6) > 0
           AND ROUND(p.twot / p.total, 6) < 1
           AND (SELECT COUNT(*) FROM mastercoa_v2 AS m2
                 WHERE m2.inv_type LIKE '%PPN INV%') > 0, 1, 0)  AS pecah
FROM    tbl_alokasi_detail AS d
JOIN    v_alk_sisi_debit   AS b ON b.no_journal = d.no_alk
-- PI hanya dipecah kalau barisnya memang jatuh ke COA uang muka penjualan
LEFT JOIN tbl_invoice_proforma AS p
       ON p.no_proforma_invoice = d.no_ref
      AND d.coa IN (SELECT m3.no_coa FROM mastercoa_v2 AS m3
                     WHERE m3.inv_type LIKE '%DP/CBD%')
WHERE   d.amount <> 0;


-- ---------------------------------------------------------------------
-- 2b. SIAPKAN baris yang akan dibuat (belum menyentuh buku besar)
--
--    Hasilnya ditampung di tabel bantu tbl_alk_kredit_hilang supaya bisa
--    diperiksa dulu, baru dipindahkan ke tbl_list_journal di langkah 4.
--
--    BATAS TANGGAL ada di langkah 2a, baris bertanda <<< ganti di sini >>>.
--    Bawaannya
--    1 Oktober 2026 ke atas - jurnal lama yang tidak seimbang karena sebab
--    lain sengaja tidak ikut diperbaiki di sini.
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS tbl_alk_kredit_hilang;

CREATE TABLE tbl_alk_kredit_hilang AS
SELECT  x.id_detail,
        x.no_journal,
        x.tgl_journal,
        x.type_journal,
        x.no_coa,
        IFNULL(NULLIF(TRIM(c.nama_coa), ''), '-') AS nama_coa,
        x.no_costcenter,
        '-'                                       AS nama_costcenter,
        x.reff_doc,
        x.reff_date,
        x.buyer,
        ''                                        AS no_ws,
        x.curr,
        x.rate,
        x.debit,
        x.credit,
        x.debit_idr,
        x.credit_idr,
        x.status,
        x.keterangan,
        x.create_by,
        x.create_date,
        x.profit_center,
        x.debit_idr_induk
FROM (
        -- (a) baris utamanya: sebesar DPP kalau dipecah, selain itu penuh
        SELECT  d.id                                        AS id_detail,
                d.no_alk                                    AS no_journal,
                b.tgl_journal,
                b.type_journal,
                IFNULL(NULLIF(TRIM(d.coa), ''), '-')        AS no_coa,
                IFNULL(NULLIF(TRIM(d.cost_center), ''), '-') AS no_costcenter,
                IF(d.amount < 0, '-', IFNULL(d.no_ref, '')) AS reff_doc,
                IF(d.amount < 0, NULL, NULLIF(d.ref_date, '0000-00-00')) AS reff_date,
                b.buyer,
                b.curr,
                b.rate,
                IF(d.amount < 0, IF(d.pecah, ROUND(d.nilai * d.rasio, 2), d.nilai), 0)         AS debit,
                IF(d.amount > 0, IF(d.pecah, ROUND(d.nilai * d.rasio, 2), d.nilai), 0)         AS credit,
                IF(d.amount < 0, IF(d.pecah, ROUND(d.nilai_idr * d.rasio, 2), d.nilai_idr), 0) AS debit_idr,
                IF(d.amount > 0, IF(d.pecah, ROUND(d.nilai_idr * d.rasio, 2), d.nilai_idr), 0) AS credit_idr,
                b.status,
                IF(TRIM(IFNULL(d.keterangan, '')) IN ('', '-'), b.keterangan, d.keterangan) AS keterangan,
                b.create_by,
                b.create_date,
                IFNULL(NULLIF(TRIM(d.profit_center), ''), 'NAG') AS profit_center,
                b.debit_idr                                 AS debit_idr_induk
          FROM  v_alk_baris_detail AS d
          JOIN  v_alk_sisi_debit   AS b ON b.no_journal = d.no_alk

        UNION ALL

        -- (b) baris PPN-nya: sisa dari yang dipecah
        SELECT  d.id                                        AS id_detail,
                d.no_alk                                    AS no_journal,
                b.tgl_journal,
                b.type_journal,
                d.coa_ppn                                   AS no_coa,
                IFNULL(NULLIF(TRIM(d.cost_center), ''), '-') AS no_costcenter,
                IF(d.amount < 0, '-', IFNULL(d.no_ref, '')) AS reff_doc,
                IF(d.amount < 0, NULL, NULLIF(d.ref_date, '0000-00-00')) AS reff_date,
                b.buyer,
                b.curr,
                b.rate,
                IF(d.amount < 0, d.nilai     - ROUND(d.nilai * d.rasio, 2), 0)     AS debit,
                IF(d.amount > 0, d.nilai     - ROUND(d.nilai * d.rasio, 2), 0)     AS credit,
                IF(d.amount < 0, d.nilai_idr - ROUND(d.nilai_idr * d.rasio, 2), 0) AS debit_idr,
                IF(d.amount > 0, d.nilai_idr - ROUND(d.nilai_idr * d.rasio, 2), 0) AS credit_idr,
                b.status,
                IF(TRIM(IFNULL(d.keterangan, '')) IN ('', '-'), b.keterangan, d.keterangan) AS keterangan,
                b.create_by,
                b.create_date,
                IFNULL(NULLIF(TRIM(d.profit_center), ''), 'NAG') AS profit_center,
                b.debit_idr                                 AS debit_idr_induk
          FROM  v_alk_baris_detail AS d
          JOIN  v_alk_sisi_debit   AS b ON b.no_journal = d.no_alk
         WHERE  d.pecah = 1
     ) AS x
LEFT JOIN mastercoa_v2 AS c ON c.no_coa = x.no_coa;

-- ---------------------------------------------------------------------
-- 3. PERIKSA hasil siapannya - WAJIB bersih sebelum langkah 4
--
--    3a. rekap per nomor: "selisih" HARUS 0. Artinya
--        debit yang sudah ada + debit baru = kredit baru.
--
--    Kolom "catatan" menandai alokasi yang perlu dilihat orang dulu:
--    alokasi yang detailnya memuat baris MINUS (selisih kurs / potongan).
--    Barisnya tetap dibuat dan tetap seimbang, tapi ditulis sebagai baris
--    debit tersendiri - cara layar Alokasi yang sekarang. Jurnal lama
--    (sebelum Agustus 2025) dulu menguranginya langsung dari baris
--    invoicenya, jadi bentuknya tidak akan sama persis dengan yang lama.
-- ---------------------------------------------------------------------
SELECT  s.no_journal,
        COUNT(*)                        AS baris_baru,
        MAX(s.debit_idr_induk)          AS debit_idr_sudah_ada,
        ROUND(SUM(s.debit_idr), 2)      AS debit_idr_baru,
        ROUND(SUM(s.credit_idr), 2)     AS kredit_idr_baru,
        ROUND(SUM(s.credit_idr) - SUM(s.debit_idr) - MAX(s.debit_idr_induk), 2) AS selisih,
        IF(ABS(SUM(s.credit_idr) - SUM(s.debit_idr) - MAX(s.debit_idr_induk)) < 1,
           'SIAP', 'JANGAN DIPAKAI - periksa manual') AS keterangan,
        IF(SUM(s.debit) > 0, 'ada baris minus - lihat dulu', '-') AS catatan
FROM    tbl_alk_kredit_hilang AS s
GROUP BY s.no_journal
ORDER BY s.no_journal;

--    3b. rincian barisnya, untuk dicocokkan dengan alokasinya
SELECT  s.no_journal, s.tgl_journal, s.no_coa, s.nama_coa, s.reff_doc,
        s.curr, s.rate, s.debit, s.credit, s.debit_idr, s.credit_idr,
        s.profit_center, s.keterangan
FROM    tbl_alk_kredit_hilang AS s
ORDER BY s.no_journal, s.id_detail, s.no_coa;

--    3c. alokasi yang TIDAK akan diperbaiki berkas ini, supaya tidak ada
--        yang terlewat diam-diam. Umumnya karena detail alokasinya ikut
--        hilang - itu harus diinput ulang lewat menu Alokasi.
SELECT  b.no_journal,
        b.tgl_journal,
        b.debit_idr AS debit_idr_sudah_ada,
        (SELECT COUNT(*) FROM tbl_alokasi_detail d
          WHERE d.no_alk = b.no_journal AND d.amount <> 0) AS baris_detail,
        IF((SELECT COUNT(*) FROM tbl_alokasi_detail d
             WHERE d.no_alk = b.no_journal AND d.amount <> 0) = 0,
           'detail alokasinya tidak ada - input ulang lewat menu Alokasi',
           'detail ada tapi nilainya tidak cocok dengan debitnya') AS sebab
FROM    v_alk_sisi_debit AS b
WHERE   b.no_journal NOT IN (
            SELECT t.no_journal
              FROM tbl_alk_kredit_hilang AS t
             GROUP BY t.no_journal
            HAVING ABS(SUM(t.credit_idr) - SUM(t.debit_idr) - MAX(t.debit_idr_induk)) < 1
        )
ORDER BY b.no_journal;


-- ---------------------------------------------------------------------
-- 4. TULIS ke buku besar
--
--    Hanya nomor yang lolos pemeriksaan 3a (selisihnya di bawah 1 rupiah)
--    yang ikut ditulis - yang tidak seimbang sengaja dilewati.
-- ---------------------------------------------------------------------
INSERT INTO tbl_list_journal
       (no_journal, tgl_journal, type_journal, no_coa, nama_coa,
        no_costcenter, nama_costcenter, reff_doc, reff_date, buyer, no_ws,
        curr, rate, debit, credit, debit_idr, credit_idr,
        status, keterangan, create_by, create_date, profit_center)
SELECT  s.no_journal, s.tgl_journal, s.type_journal, s.no_coa, s.nama_coa,
        s.no_costcenter, s.nama_costcenter, s.reff_doc, s.reff_date, s.buyer, s.no_ws,
        s.curr, s.rate, s.debit, s.credit, s.debit_idr, s.credit_idr,
        s.status, s.keterangan, s.create_by, s.create_date, s.profit_center
FROM    tbl_alk_kredit_hilang AS s
WHERE   s.no_journal IN (
            SELECT t.no_journal
              FROM tbl_alk_kredit_hilang AS t
             GROUP BY t.no_journal
            HAVING ABS(SUM(t.credit_idr) - SUM(t.debit_idr) - MAX(t.debit_idr_induk)) < 1
        )
ORDER BY s.no_journal, s.id_detail, s.no_coa;


-- ---------------------------------------------------------------------
-- 5. PERIKSA LAGI - jurnalnya harus sudah seimbang
--    Hasil yang benar: tidak ada baris sama sekali.
-- ---------------------------------------------------------------------
SELECT  j.no_journal,
        MAX(j.tgl_journal)          AS tgl_journal,
        ROUND(SUM(j.debit_idr), 2)  AS debit_idr,
        ROUND(SUM(j.credit_idr), 2) AS kredit_idr,
        ROUND(SUM(j.debit_idr) - SUM(j.credit_idr), 2) AS selisih
FROM    tbl_list_journal AS j
WHERE   j.type_journal = 'Alokasi'
  AND   j.tgl_journal >= '2026-10-01'        -- <<< samakan dengan langkah 2a >>>
GROUP BY j.no_journal
HAVING  ABS(selisih) > 1
ORDER BY tgl_journal DESC, j.no_journal;


-- ---------------------------------------------------------------------
-- 6. BERSIH-BERSIH - jalankan SESUDAH langkah 5 bersih
--
--    Tabel tbl_alk_kredit_hilang sengaja tidak langsung dihapus: selama
--    masih ada, barisnya bisa dipakai membatalkan langkah 4.
-- ---------------------------------------------------------------------
DROP VIEW  IF EXISTS v_alk_baris_detail;
DROP VIEW  IF EXISTS v_alk_sisi_debit;
-- DROP TABLE IF EXISTS tbl_alk_kredit_hilang;


-- ---------------------------------------------------------------------
-- KALAU HARUS DIBATALKAN (sebelum tabel bantunya dihapus)
--
--    Menghapus persis baris yang dibuat langkah 4, bukan yang lain.
-- ---------------------------------------------------------------------
-- DELETE j FROM tbl_list_journal AS j
--   JOIN tbl_alk_kredit_hilang AS s
--     ON  s.no_journal = j.no_journal
--     AND s.no_coa     = j.no_coa
--     AND s.reff_doc   = j.reff_doc
--     AND ROUND(s.debit, 4)  = ROUND(j.debit, 4)
--     AND ROUND(s.credit, 4) = ROUND(j.credit, 4);
