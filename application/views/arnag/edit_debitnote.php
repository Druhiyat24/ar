<?php
// Edit Debit Note memakai form yang sama dengan Create (tampilan & alurnya
// sama). Bedanya diatur lewat $is_edit di create_debitnote.php:
// - baris dari Memo / Request terkunci (tidak bisa diubah / dihapus), baris
//   manual bebas diubah & dihapus, baris baru bisa ditambah;
// - save lewat arnag/update_debitnote (header + detail 1 transaksi).
$is_edit = true;
include __DIR__ . '/create_debitnote.php';
