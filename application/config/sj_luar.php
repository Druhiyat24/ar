<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Akun layanan untuk cetakan Surat Jalan dari program lain
|--------------------------------------------------------------------------
|
| Dipakai modal detail invoice (Arnag::lihat_sj_knitting & lihat_sj_material):
| halaman cetak SJ di kedua program ini dijaga login, sedangkan cookie sesinya
| samesite=lax - tidak pernah ikut terkirim dari iframe. Jadi AR yang
| mengambilkan PDF-nya dengan akun di bawah ini, lalu mengalirkannya ke layar.
| Akunnya cuma dipakai untuk membaca cetakan SJ.
|
|   sj_knitting  aplikasi knitting  - SJ OFC/OUT
|   sj_wip       nds_wip            - SJ GK/OUT (out material)
|
| Nilainya bisa ditimpa lewat environment (SJ_KNITTING_URL / _USER / _PASS,
| SJ_WIP_URL / _USER / _PASS) kalau di server tidak mau ditulis di berkas ini.
|
*/

$config['sj_knitting_url']  = 'http://nag.ddns.net:8888/knitting/public/index.php/';
$config['sj_knitting_user'] = 'guest';
$config['sj_knitting_pass'] = 'guest';

$config['sj_wip_url']  = 'http://nag.ddns.net:8003/nds_wip/public/index.php/';
$config['sj_wip_user'] = 'guest';
$config['sj_wip_pass'] = 'guest';
