-- ============================================================================
-- PEMERIKSA jurnal alokasi 0004/ALK/NAG/1026 - SELECT SEMUA, tidak mengubah
-- apa pun. Aman dijalankan di database live.
--
-- Dipakai untuk melihat di mana jurnalnya meleset sebelum dibuatkan query
-- perbaikannya. Jalankan berurutan, lalu kirimkan hasilnya.
--
-- Catatan: jurnal alokasi TIDAK dibuat oleh aplikasi AR ini - di sini barisnya
-- hanya dihapus & diarsipkan waktu reverse (Model_nag::copy_jurnal_alokasi /
-- delete_jurnal_alokasi). Yang menulisnya aplikasi sebelah, jadi perbaikannya
-- nanti ikut tergantung jawaban nomor 5 di bawah.
--
-- Ganti nomornya di satu tempat saja:
SET @alk := '0004/ALK/NAG/1026';
-- ============================================================================


-- ======================= 1. kepala alokasinya =======================
-- Satu baris per dokumen yang dialokasikan (invoice / debit note / dsb).
SELECT a.id, a.no_alk, a.tgl_alk, a.customer, a.doc_number, a.bank, a.account,
       a.curr, a.rate, a.amount, a.eqp_idr, a.sisa, a.status
  FROM tbl_alokasi a
 WHERE a.no_alk = @alk
 ORDER BY a.id;


-- ======================= 2. baris alokasinya =======================
-- Inilah yang diketik di layar Alokasi - COA, cost center & nilainya.
SELECT d.id, d.no_alk, d.coa, d.cost_center, d.no_ref, d.ref_date, d.due_date,
       d.total, d.eqp_idr, d.amount, d.profit_center, d.status, d.keterangan
  FROM tbl_alokasi_detail d
 WHERE d.no_alk = @alk
 ORDER BY d.id;


-- ======================= 3. jurnal yang sekarang terposting =======================
SELECT j.id, j.no_journal, j.tgl_journal, j.type_journal, j.no_coa, j.nama_coa,
       j.no_costcenter, j.reff_doc, j.buyer, j.supplier, j.curr, j.rate,
       j.debit, j.credit, j.debit_idr, j.credit_idr, j.status, j.profit_center,
       j.keterangan, j.create_by, j.create_date
  FROM tbl_list_journal j
 WHERE j.no_journal = @alk
 ORDER BY j.id;


-- ======================= 4. seimbang atau tidak =======================
-- Debit harus sama dengan kredit. Kalau selisihnya bukan 0, di situ salahnya.
SELECT COUNT(*)                            AS jml_baris,
       SUM(j.debit)                        AS total_debit,
       SUM(j.credit)                       AS total_credit,
       SUM(j.debit) - SUM(j.credit)        AS selisih,
       SUM(j.debit_idr)                    AS total_debit_idr,
       SUM(j.credit_idr)                   AS total_credit_idr,
       SUM(j.debit_idr) - SUM(j.credit_idr) AS selisih_idr
  FROM tbl_list_journal j
 WHERE j.no_journal = @alk;


-- ======================= 5. jurnal vs baris alokasinya =======================
-- Per COA: nilai yang diketik di Alokasi dibanding yang masuk jurnal.
-- Baris yang 'hanya di jurnal' atau 'hanya di alokasi' itu petunjuk utamanya.
SELECT COALESCE(d.coa, j.no_coa)                AS no_coa,
       COALESCE(d.nilai_alokasi, 0)             AS nilai_di_alokasi,
       COALESCE(j.nilai_jurnal, 0)              AS nilai_di_jurnal,
       COALESCE(j.nilai_jurnal, 0) - COALESCE(d.nilai_alokasi, 0) AS selisih,
       CASE WHEN d.coa IS NULL    THEN 'hanya di jurnal'
            WHEN j.no_coa IS NULL THEN 'hanya di alokasi'
            ELSE 'ada di dua-duanya' END        AS keterangan
  FROM (SELECT coa, SUM(amount) AS nilai_alokasi
          FROM tbl_alokasi_detail WHERE no_alk = @alk GROUP BY coa) d
  LEFT JOIN (SELECT no_coa, SUM(debit) - SUM(credit) AS nilai_jurnal
               FROM tbl_list_journal WHERE no_journal = @alk GROUP BY no_coa) j
         ON j.no_coa = d.coa
 UNION
SELECT COALESCE(d.coa, j.no_coa),
       COALESCE(d.nilai_alokasi, 0),
       COALESCE(j.nilai_jurnal, 0),
       COALESCE(j.nilai_jurnal, 0) - COALESCE(d.nilai_alokasi, 0),
       CASE WHEN d.coa IS NULL    THEN 'hanya di jurnal'
            WHEN j.no_coa IS NULL THEN 'hanya di alokasi'
            ELSE 'ada di dua-duanya' END
  FROM (SELECT no_coa, SUM(debit) - SUM(credit) AS nilai_jurnal
          FROM tbl_list_journal WHERE no_journal = @alk GROUP BY no_coa) j
  LEFT JOIN (SELECT coa, SUM(amount) AS nilai_alokasi
               FROM tbl_alokasi_detail WHERE no_alk = @alk GROUP BY coa) d
         ON d.coa = j.no_coa;


-- ======================= 6. pernah di-reverse? =======================
-- Kalau alokasinya pernah dibalik, jurnal lamanya ada di arsip ini. Berguna
-- untuk tahu apakah yang sekarang hasil posting ulang.
SELECT c.id, c.no_journal, c.tgl_journal, c.no_coa, c.nama_coa,
       c.debit, c.credit, c.debit_idr, c.credit_idr, c.status,
       c.create_by, c.create_date, c.cancel_by, c.cancel_date
  FROM tbl_list_journal_cancel c
 WHERE c.no_journal = @alk
 ORDER BY c.id;


-- ======================= 7. dokumen yang dialokasikan =======================
-- Jurnal dokumen asalnya - untuk membandingkan COA piutang yang dipakai.
SELECT j.no_journal, j.type_journal, j.no_coa, j.nama_coa,
       j.debit, j.credit, j.debit_idr, j.credit_idr, j.curr, j.rate
  FROM tbl_list_journal j
 WHERE j.no_journal IN (SELECT doc_number FROM tbl_alokasi WHERE no_alk = @alk)
 ORDER BY j.no_journal, j.id;
