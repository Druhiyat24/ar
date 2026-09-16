-- ============================================================================
-- Debit Note: lepaskan Req DN yang tersangkut di Debit Note yang SUDAH Cancel.
-- Dijalankan MANUAL, sekali saja. Tidak mengubah struktur tabel (data saja).
--
-- Latar belakang:
--   Sebelum perbaikan 14-09-2026, cancel Debit Note hanya mengubah status DN
--   dan melepas memo_det. Req DN (req_dn_h) yang dipakai DN itu tetap
--   status = 'Processed' dengan no_dn berisi nomor DN yang sudah Cancel,
--   sehingga tidak pernah muncul lagi di dropdown No Req (Create Debit Note
--   hanya menampilkan status = 'Post' AND no_dn IS NULL).
--   Cancel yang dilakukan SESUDAH perbaikan sudah otomatis melepas Req DN;
--   file ini hanya untuk membereskan data lama.
--
-- Memo tidak perlu dibereskan: cancel versi lama sudah melepas memo_det.
-- ============================================================================

-- 1) PREVIEW DULU - daftar Req DN yang akan dilepas. Periksa hasilnya.
--    Dijaga: kalau nomor DN yang sama masih dipakai DN lain yang TIDAK Cancel
--    (nomor kembar), Req-nya tidak disentuh.
SELECT r.id, r.no_req, r.no_dn, r.status AS status_req, h.status AS status_dn
  FROM req_dn_h r
  JOIN tbl_debitnote_h h ON h.no_dn = r.no_dn AND h.status = 'Cancel'
 WHERE r.status = 'Processed'
   AND NOT EXISTS (
         SELECT 1 FROM tbl_debitnote_h h2
          WHERE h2.no_dn = r.no_dn AND h2.status <> 'Cancel'
       );

-- 2) LEPASKAN - jalankan setelah preview di atas dicek.
--    Jumlah baris yang berubah harus sama dengan jumlah baris preview.
UPDATE req_dn_h r
  JOIN tbl_debitnote_h h ON h.no_dn = r.no_dn AND h.status = 'Cancel'
   SET r.no_dn = NULL,
       r.status = 'Post'
 WHERE r.status = 'Processed'
   AND NOT EXISTS (
         SELECT 1 FROM (SELECT no_dn FROM tbl_debitnote_h WHERE status <> 'Cancel') aktif
          WHERE aktif.no_dn = r.no_dn
       );
-- Catatan: subquery "aktif" dibungkus tabel turunan karena MySQL tidak
-- mengizinkan UPDATE yang membaca tabel yang sama secara langsung di
-- subquery-nya bila tabel itu ikut di-JOIN.

-- 3) CEK - harus kosong.
SELECT r.id, r.no_req, r.no_dn
  FROM req_dn_h r
  JOIN tbl_debitnote_h h ON h.no_dn = r.no_dn AND h.status = 'Cancel'
 WHERE r.status = 'Processed'
   AND NOT EXISTS (
         SELECT 1 FROM tbl_debitnote_h h2
          WHERE h2.no_dn = r.no_dn AND h2.status <> 'Cancel'
       );

-- ----------------------------------------------------------------------------
-- ROLLBACK: tidak bisa otomatis (nomor DN lama tidak disimpan). Kalau perlu
-- bisa dibatalkan, SIMPAN dulu hasil preview langkah 1 (id + no_dn) sebelum
-- menjalankan langkah 2, lalu kembalikan per baris:
--   UPDATE req_dn_h SET no_dn = '<no_dn dari preview>', status = 'Processed' WHERE id = <id>;
-- ----------------------------------------------------------------------------
