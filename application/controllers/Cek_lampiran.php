<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pemeriksa lampiran: baris yang ada di DATABASE tapi berkasnya tidak ada di
 * server INI.
 *
 * Databasenya dipakai bersama oleh beberapa server, tapi folder uploads-nya
 * milik masing-masing server. Lampiran yang diunggah di satu server karena itu
 * tidak otomatis ada di server lain - waktu dicetak, lampirannya dilewati dan
 * dicatat di halaman terakhir PDF ("file is missing on the server", lihat
 * Dn_pdf_gabung). Alat ini memberi tahu lebih dulu mana saja yang kurang,
 * tanpa harus mencetak satu per satu.
 *
 * Jalankan dari folder aplikasi, di TIAP server:
 *     php index.php cek_lampiran
 *
 * Yang keluar daftar lampiran yang hilang di server itu. Bandingkan hasilnya
 * antar server untuk tahu berkasnya ada di mana.
 *
 * Tidak mengubah apa pun - hanya membaca tabel dan mengecek isi folder.
 */
class Cek_lampiran extends CI_Controller
{
    /** Tabel lampiran yang diperiksa: nama tabel => judul & kolom nomornya. */
    private $tabel = array(
        'tbl_debitnote_doc' => array('judul' => 'Debit Note', 'nomor' => 'no_dn'),
        'tbl_invoice_doc'   => array('judul' => 'Invoice',    'nomor' => 'no_invoice'),
    );

    public function __construct()
    {
        parent::__construct();

        // Hanya lewat baris perintah. Isinya daftar letak berkas di server -
        // tidak perlu, dan sebaiknya tidak bisa, dibuka dari web.
        if (!is_cli()) {
            show_404();
        }
    }

    /**
     * Satu tabel lampiran: tiap barisnya dicek berkasnya ada atau tidak.
     *
     * Hasilnya dikembalikan, bukan langsung dicetak, supaya bisa diuji.
     * NULL kalau tabelnya belum dibuat di database ini.
     *
     * @param string $tabel        nama tabel lampiran
     * @param string $kolom_nomor  kolom nomor dokumennya (no_dn / no_invoice)
     * @param string $dasar        folder aplikasi, berakhir pemisah folder
     */
    public function periksa($tabel, $kolom_nomor, $dasar)
    {
        if (!$this->db->table_exists($tabel)) {
            return null;
        }

        $baris = $this->db->query(
            "SELECT id, " . $kolom_nomor . " AS nomor, original_name, file_path
               FROM " . $tabel . "
           ORDER BY id"
        )->result_array();

        $hilang = array();
        foreach ($baris as $b) {
            $path = trim((string) $b['file_path']);
            // Path-nya relatif dari folder aplikasi - lihat Arnag::lihat_dn_doc.
            if ($path === '' || !is_file($dasar . $path)) {
                $hilang[] = $b;
            }
        }

        return array('jumlah' => count($baris), 'hilang' => $hilang);
    }

    public function index()
    {
        $dasar = FCPATH;

        echo "Pemeriksa lampiran\n";
        echo "Folder aplikasi : " . $dasar . "\n\n";

        $total = 0;
        foreach ($this->tabel as $nama => $t) {
            $hasil = $this->periksa($nama, $t['nomor'], $dasar);

            if ($hasil === null) {
                echo str_pad($t['judul'], 11) . ' : tabel ' . $nama . " belum ada - dilewati\n\n";
                continue;
            }

            echo str_pad($t['judul'], 11) . ' : ' . $hasil['jumlah'] . ' lampiran, '
               . count($hasil['hilang']) . " tidak ada di server ini\n";

            foreach ($hasil['hilang'] as $h) {
                echo '   ' . str_pad((string) $h['nomor'], 20) . ' '
                   . str_pad((string) $h['original_name'], 32) . ' '
                   . $h['file_path'] . "\n";
            }
            echo "\n";
            $total += count($hasil['hilang']);
        }

        if ($total === 0) {
            echo "Semua lampiran lengkap di server ini.\n";
            exit(0);
        }

        echo $total . " lampiran tidak ada di server ini.\n";
        echo "Berkasnya ada di server tempat diunggah - salin folder uploads dari sana,\n";
        echo "atau commit berkasnya dari server itu lalu pull di sini.\n";
        exit(1);
    }
}
