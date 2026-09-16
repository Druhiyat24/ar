File font Source Sans Pro - font bawaan tema AdminLTE, dilayani dari server sendiri.

Dulu font ini ditarik dari https://fonts.googleapis.com di SETIAP halaman, jadi
tampilan menunggu internet dulu - dan menggantung lama kalau server tidak bisa
keluar internet.

ISI FOLDER (sudah lengkap, tidak perlu unduh apa pun)
  source-sans-pro-300.ttf         Light 300
  source-sans-pro-400.ttf         Regular 400
  source-sans-pro-400italic.ttf   Italic 400
  source-sans-pro-700.ttf         Bold 700

Keempatnya Source Sans Pro versi 2.021 subset latin - build yang sama dengan yang
dilayani Google Fonts, jadi tampilannya sama persis dengan server. Diambil dari
cache dompdf di repo ini sendiri (vendor/dompdf/dompdf/lib/fonts), bukan diunduh.

Penting: Bold-nya harus file sendiri. Kalau hanya ada Regular, huruf tebal dibuat
"dipaksakan" oleh browser dan hasilnya terlihat kabur / berbayang.

CARA KERJANYA
Aturan @font-face dibuat otomatis di application/views/templates/header.php, HANYA
untuk file yang benar-benar ada di folder ini. Jadi:
  - menambah / mengganti file cukup taruh disini dengan nama seperti di atas,
    tidak perlu ubah kode;
  - file .woff2 (kalau ada) dipakai lebih dulu daripada .ttf karena lebih kecil;
  - kalau folder ini dikosongkan, teks otomatis pakai font sistem dan aplikasi
    tetap jalan normal.

OPSIONAL - unduh-font.ps1
Mengunduh versi .woff2 dari Google Fonts (sekitar 30 KB per file, lawan 40 KB .ttf).
Jalankan di komputer yang bisa internet kalau mau menghemat sedikit lagi. Tidak
wajib: dengan .ttf yang sekarang tampilannya sudah sama.
