<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Menyusun berkas .eml (RFC 822) berisi pesan siap kirim + lampiran.
 *
 * Kenapa .eml: dari browser tidak ada cara melampirkan berkas langsung ke
 * Outlook - "mailto:" hanya bisa mengisi tujuan/subjek/isi, lampirannya
 * diabaikan semua klien email. Jadi berkasnya diunduh sebagai .eml; di Windows
 * berkas itu dibuka Outlook, dan karena ada header "X-Unsent: 1" Outlook
 * membukanya sebagai jendela tulis pesan (bukan pesan masuk) - lampirannya
 * sudah menempel dan tinggal ditekan Send.
 */
class Dn_email
{
    /**
     * @param array $opsi
     *   to          string  alamat tujuan (boleh kosong - diisi di Outlook)
     *   cc          string  alamat tembusan (boleh kosong)
     *   subjek      string
     *   isi         string  badan pesan, teks biasa
     *   lampiran    array   daftar array('nama' => ..., 'isi' => ..., 'tipe' => ...)
     * @return string isi berkas .eml
     */
    public function buat_eml(array $opsi)
    {
        $to      = $this->_bersihkan_header(isset($opsi['to']) ? $opsi['to'] : '');
        $cc      = $this->_bersihkan_header(isset($opsi['cc']) ? $opsi['cc'] : '');
        $subjek  = $this->_bersihkan_header(isset($opsi['subjek']) ? $opsi['subjek'] : '');
        $isi     = isset($opsi['isi']) ? (string) $opsi['isi'] : '';
        $lampiran = isset($opsi['lampiran']) && is_array($opsi['lampiran']) ? $opsi['lampiran'] : array();

        $batas = '----=_NAG_' . md5(uniqid('dn', true));
        $baris = array();

        // Header pesan. "From" sengaja tidak diisi supaya Outlook memakai akun
        // yang sedang aktif di komputer pengirim.
        // Tujuan boleh kosong - biar diisi langsung di Outlook.
        if ($to !== '') {
            $baris[] = 'To: ' . $to;
        }
        if ($cc !== '') {
            $baris[] = 'Cc: ' . $cc;
        }
        $baris[] = 'Subject: ' . $this->_encode_subjek($subjek);
        $baris[] = 'Date: ' . date('r');
        $baris[] = 'MIME-Version: 1.0';
        // Inilah yang membuat Outlook membukanya sebagai pesan baru siap kirim.
        $baris[] = 'X-Unsent: 1';
        $baris[] = 'Content-Type: multipart/mixed; boundary="' . $batas . '"';
        $baris[] = '';
        $baris[] = 'Berkas ini dibuka dengan klien email yang mendukung format MIME.';
        $baris[] = '';

        // Badan pesan.
        $baris[] = '--' . $batas;
        $baris[] = 'Content-Type: text/plain; charset=UTF-8';
        $baris[] = 'Content-Transfer-Encoding: base64';
        $baris[] = '';
        $baris[] = rtrim(chunk_split(base64_encode($this->_normalkan_baris($isi)), 76, "\r\n"), "\r\n");

        // Lampiran.
        foreach ($lampiran as $file) {
            $nama = $this->_nama_aman(isset($file['nama']) ? $file['nama'] : 'lampiran.bin');
            $tipe = isset($file['tipe']) && $file['tipe'] !== '' ? $file['tipe'] : 'application/octet-stream';
            $tipe = $this->_bersihkan_header($tipe);

            $baris[] = '--' . $batas;
            $baris[] = 'Content-Type: ' . $tipe . '; name="' . $nama . '"';
            $baris[] = 'Content-Transfer-Encoding: base64';
            $baris[] = 'Content-Disposition: attachment; filename="' . $nama . '"';
            $baris[] = '';
            $baris[] = rtrim(chunk_split(base64_encode((string) (isset($file['isi']) ? $file['isi'] : '')), 76, "\r\n"), "\r\n");
        }

        $baris[] = '--' . $batas . '--';
        $baris[] = '';

        return implode("\r\n", $baris);
    }

    /**
     * Nilai yang masuk ke header tidak boleh membawa ganti baris - kalau dibiarkan,
     * alamat kiriman pengguna bisa dipakai menyisipkan header lain.
     */
    private function _bersihkan_header($nilai)
    {
        return trim(str_replace(array("\r", "\n", "\0"), '', (string) $nilai));
    }

    /**
     * Subjek yang memuat karakter non-ASCII harus dikodekan (RFC 2047), kalau
     * tidak tampilannya berantakan di sebagian klien email.
     */
    private function _encode_subjek($subjek)
    {
        if ($subjek === '' || preg_match('/^[\x20-\x7E]*$/', $subjek)) {
            return $subjek;
        }
        return '=?UTF-8?B?' . base64_encode($subjek) . '?=';
    }

    // Nama berkas lampiran: tanpa tanda kutip/garis miring supaya headernya utuh.
    private function _nama_aman($nama)
    {
        $nama = $this->_bersihkan_header($nama);
        $nama = str_replace(array('"', '\\', '/'), '_', $nama);
        return $nama === '' ? 'lampiran.bin' : $nama;
    }

    // Badan pesan dikirim dengan akhir baris CRLF.
    private function _normalkan_baris($teks)
    {
        return str_replace(array("\r\n", "\r", "\n"), array("\n", "\n", "\r\n"), (string) $teks);
    }
}
