<?php
/**
 * Peluncur baris perintah untuk Cek_lampiran.
 *
 *     php cek_lampiran.php
 *
 * Kenapa perlu peluncur: application/config/config.php menyusun base_url dari
 * $_SERVER['HTTP_HOST'], dan di baris perintah itu tidak ada - jadi
 * "php index.php cek_lampiran" berhenti sebelum controllernya jalan. Di sini
 * HTTP_HOST diisi seadanya (cuma dipakai menyusun base_url, dan controllernya
 * tidak mencetak URL apa pun), lalu rutenya dipasang lewat $argv seperti yang
 * dibaca CodeIgniter waktu dijalankan dari baris perintah.
 *
 * Hanya untuk baris perintah. Kalau dibuka dari web, Cek_lampiran sendiri yang
 * menolak (show_404) - isinya daftar letak berkas di server.
 */
if (PHP_SAPI !== 'cli') {
    header('HTTP/1.1 404 Not Found');
    exit;
}

if (!isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = 'localhost';
}

/**
 * CodeIgniter 3 di PHP 8 memuntahkan puluhan peringatan "deprecated" waktu
 * memuat intinya (CI_URI::$config dan kawan-kawan). Itu bukan kesalahan baru
 * dan bukan urusan alat ini, tapi laporannya jadi tenggelam. Jadi yang
 * dicetak hanya mulai dari baris pertama laporannya.
 *
 * Kalau laporannya tidak pernah muncul - misalnya databasenya tidak bisa
 * disambung - seluruh keluarannya dilewatkan apa adanya, supaya kesalahan
 * yang sebenarnya tetap terbaca.
 */
function cek_lampiran_saring($isi)
{
    $a = strpos($isi, 'Pemeriksa lampiran');   // baris pertama Cek_lampiran::index
    return $a === false ? $isi : substr($isi, $a);
}
ob_start('cek_lampiran_saring');

// Rutenya dibaca CodeIgniter dari $_SERVER['argv'] (lihat CI_URI::_parse_argv).
$_SERVER['argv'] = array('index.php', 'cek_lampiran');
$_SERVER['argc'] = 2;
$argv = $_SERVER['argv'];
$argc = $_SERVER['argc'];

require __DIR__ . '/index.php';
