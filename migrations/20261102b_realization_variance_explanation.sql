-- =====================================================================
-- AR Collection Realization & Variance Report: tempat menyimpan kolom
-- "Variance Explanation".
--
-- KENAPA PERLU TABEL BARU
--   Dua puluh kolom lain di laporan itu semuanya HASIL HITUNGAN - bisa
--   dihitung ulang kapan saja dari dokumen proyeksi dan dari alokasinya.
--   Satu kolom tidak: Variance Explanation. Di lembar kerja tim AR kolom itu
--   memang tidak berumus, isinya diketik tangan, dan di berkas contohnya
--   masih kosong seluruhnya.
--
--   Karena diketik, isinya harus punya tempat tinggal. Dikunci ke NOMOR
--   DOKUMEN + NOMOR INVOICE, bukan ke nomor invoice saja: satu invoice bisa
--   muncul di beberapa dokumen proyeksi, dan penjelasan selisih bulan
--   September bukan penjelasan selisih bulan Oktober.
--
-- AMAN DIULANG. Tidak ada data yang disentuh - cuma menambah satu tabel
-- kosong. Selama tabel ini belum ada, laporannya tetap jalan: kolom
-- penjelasannya saja yang selalu kosong dan tidak bisa disimpan
-- (Model_report::variance_explanation memeriksa tabelnya dulu).
-- =====================================================================


-- ---------------------------------------------------------------------
-- LANGKAH 1 - lihat dulu keadaannya. Sebelum dijalankan hasilnya 0 baris.
-- ---------------------------------------------------------------------
SELECT table_name, table_type
  FROM information_schema.tables
 WHERE table_schema = DATABASE()
   AND table_name = 'tbl_realization_variance';


-- ---------------------------------------------------------------------
-- LANGKAH 2 - tabelnya.
--
-- Kunci uniknya (doc_number, no_invoice) yang menjaga satu invoice cuma
-- punya satu penjelasan per dokumen - supaya menyimpan dua kali menimpa,
-- bukan menumpuk baris baru.
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tbl_realization_variance (
    id          INT(11)      NOT NULL AUTO_INCREMENT,
    doc_number  VARCHAR(15)  NOT NULL COMMENT 'nomor dokumen proyeksinya, PR/MMYY/NNNNN',
    no_invoice  VARCHAR(100) NOT NULL,
    explanation TEXT         DEFAULT NULL,
    updated_by  VARCHAR(100) DEFAULT NULL,
    updated_at  DATETIME     DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY doc_invoice (doc_number, no_invoice),
    KEY doc_number (doc_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ---------------------------------------------------------------------
-- LANGKAH 3 - pemeriksaan. Harus keluar satu baris BASE TABLE, dan
--             kunci uniknya harus terdiri dari dua kolom.
-- ---------------------------------------------------------------------
SELECT table_name, table_type
  FROM information_schema.tables
 WHERE table_schema = DATABASE()
   AND table_name = 'tbl_realization_variance';

SELECT index_name, GROUP_CONCAT(column_name ORDER BY seq_in_index) AS kolomnya, non_unique
  FROM information_schema.statistics
 WHERE table_schema = DATABASE()
   AND table_name = 'tbl_realization_variance'
 GROUP BY index_name, non_unique
 ORDER BY index_name;
