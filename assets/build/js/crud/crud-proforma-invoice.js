/* ===========================================================================
 * Proforma Invoice - pemilihan SO.
 *
 * Layar lamanya dua tabel bertingkat di modal Add SO: pilih SO dulu, lalu
 * centang satu per satu baris rincinya. Satu SO bisa puluhan centangan karena
 * dipecah per warna DAN per size - SO/0926/01370 saja 27 baris untuk satu
 * produk.
 *
 * Di sini jadi SATU tabel, barisnya diringkas per SO + produk + HARGA
 * (lihat Model_nag::so_proforma_grup). Harga ikut jadi kunci karena satu
 * produk bisa beda harga antar warna - yang begitu tidak boleh disatukan.
 * Grupnya masih bisa dibuka kalau ada warna/size yang perlu dilepas.
 *
 * YANG DISIMPAN TIDAK BERUBAH. Tombol Add Data tetap mengirim ke dua endpoint
 * lama - simpan_invoice_detail_proforma_temporary (per SO) dan
 * simpan_so_detail_proforma_temporary (per so_det) - dengan nama field yang
 * sama persis. Jadi hitungan total, alur Save, dan cetakan PDF-nya (yang
 * memang per warna & size) sama sekali tidak tersentuh.
 * ======================================================================== */
(function () {
    'use strict';

    // base_url() itu fungsi PHP, bukan variabel JS - view yang menitipkan
    // alamatnya lewat CI_URL. Kalau tidak ada, jatuh ke alamat relatif, sama
    // seperti pemanggilan AJAX lain di layar ini.
    var URL_AR = typeof CI_URL !== 'undefined' ? CI_URL : '';

    // Grup hasil pencarian terakhir + pilihan user.
    // dipilih[kunci] = { semua: bool, lepas: { id_sodet: true } }
    var grup = [];
    var dipilih = {};
    var dibuka = {};

    function teks(v) {
        if (v === null || v === undefined || v === '') { return '-'; }
        return $('<div>').text(v).html();
    }
    function angka(v, d) {
        var n = parseFloat(String(v === undefined || v === null ? '' : v).replace(/,/g, ''));
        if (isNaN(n)) { n = 0; }
        return n.toLocaleString('en-US', {
            minimumFractionDigits: d === undefined ? 2 : d,
            maximumFractionDigits: d === undefined ? 2 : d
        });
    }
    function ruas(v) {
        return encodeURIComponent(String(v === undefined || v === null ? '' : v).trim());
    }

    /** Baris rinci sebuah grup yang BENAR-BENAR terpilih. */
    function rinciTerpilih(g) {
        var p = dipilih[g.kunci];
        if (!p || !p.semua) { return []; }
        return (g.baris || []).filter(function (r) {
            return !p.lepas[String(r.id_sodet)];
        });
    }

    function jumlahTerpilih() {
        var n = 0;
        grup.forEach(function (g) { n += rinciTerpilih(g).length; });
        return n;
    }

    /* ===================== pencarian ===================== */

    function cariSo() {
        var dari = $('#pi-f-from').val();
        var sampai = $('#pi-f-to').val();
        var cust = $('#prof_customer').val();
        var tipe = $('#pi-tipe-pi').val() || '';

        if (!dari || !sampai) {
            Swal.fire('Date range needed', 'Please pick both dates first.', 'info');
            return;
        }

        $('#pi-so-tbody').html('<tr><td colspan="9" class="text-center text-muted py-4">'
            + '<i class="fas fa-spinner fa-spin"></i> Loading…</td></tr>');

        $.getJSON(URL_AR + 'so_proforma_grup_json/' + ruas(dari) + '/' + ruas(sampai)
                  + '/' + ruas(cust) + '/' + ruas(tipe))
            .done(function (d) {
                if (!d || !d.status) {
                    $('#pi-so-tbody').html('<tr><td colspan="9" class="text-center text-danger py-4">'
                        + teks(d && d.message ? d.message : 'Could not load the SO list.') + '</td></tr>');
                    return;
                }
                grup = d.grup || [];
                dipilih = {};
                dibuka = {};
                gambar();
                // Sekalian ditunjukkan berapa centangan yang dihemat.
                $('#pi-so-info').text(d.jml_grup + ' row' + (d.jml_grup === 1 ? '' : 's')
                    + ' from ' + d.jml_baris + ' SO detail line' + (d.jml_baris === 1 ? '' : 's'));
            })
            .fail(function () {
                $('#pi-so-tbody').html('<tr><td colspan="9" class="text-center text-danger py-4">'
                    + 'Could not load the SO list.</td></tr>');
            });
    }

    /* ===================== gambar tabelnya ===================== */

    /** Grup yang lolos kotak pencarian - dicocokkan ke nomor SO & produknya. */
    function tersaring() {
        var cari = $.trim(String($('#pi-f-filter').val() || '')).toLowerCase();
        if (cari === '') { return grup; }
        return grup.filter(function (g) {
            return (String(g.so_no) + ' ' + String(g.product_item) + ' '
                  + String(g.styleno)).toLowerCase().indexOf(cari) > -1;
        });
    }

    function gambar() {
        var $b = $('#pi-so-tbody').empty();
        // Yang digambar hasil saringan, tapi pilihannya tetap disimpan per
        // grup - mengetik di kotak cari tidak membatalkan centangan yang sudah
        // ada, cuma menyembunyikan barisnya sementara.
        var tampil = tersaring();

        if (!tampil.length) {
            $b.html('<tr><td colspan="9" class="text-center text-muted py-4">'
                + '<i class="fas fa-inbox"></i> '
                + (grup.length ? 'No SO matches that search.'
                              : 'No SO found for this customer and date range.')
                + '</td></tr>');
            $('#pi-so-pilih-semua').prop('checked', false);
            segar();
            return;
        }

        var html = '';
        tampil.forEach(function (g) {
            var p = dipilih[g.kunci];
            var pilih = !!(p && p.semua);
            var lepas = p ? Object.keys(p.lepas).length : 0;
            var buka = !!dibuka[g.kunci];
            var jml = (g.baris || []).length;

            // Qty & total grup ikut rincian yang masih terpilih - kalau ada
            // warna/size yang dilepas, angkanya harus ikut turun.
            var sisa = rinciTerpilih(g);
            var qty = 0, total = 0;
            (pilih ? sisa : g.baris || []).forEach(function (r) {
                qty += parseFloat(r.qty) || 0;
                total += parseFloat(r.total_price) || 0;
            });

            html += '<tr class="pi-grup' + (pilih ? ' is-pilih' : '') + '" data-k="' + teks(g.kunci) + '">'
                + '<td class="dn-tengah">'
                + '  <input type="checkbox" class="pi-cek-grup" data-k="' + teks(g.kunci) + '"'
                + (pilih ? ' checked' : '') + '>'
                + '</td>'
                + '<td class="dn-tengah">'
                + '  <button type="button" class="btn btn-link btn-sm pi-buka" data-k="' + teks(g.kunci) + '"'
                + '          title="Show color &amp; size">'
                + '    <i class="fas fa-caret-' + (buka ? 'down' : 'right') + '"></i> ' + jml
                + '  </button>'
                + '</td>'
                + '<td>' + teks(g.so_no) + '</td>'
                + '<td>' + teks(g.so_date) + '</td>'
                + '<td>' + teks(g.product_item) + ' ' + teks(g.styleno)
                + (lepas ? ' <span class="badge badge-warning">' + lepas + ' excluded</span>' : '')
                + '</td>'
                + '<td class="dn-tengah">' + teks(g.curr) + '</td>'
                + '<td class="text-right">' + angka(qty) + '</td>'
                + '<td class="text-right">' + angka(g.price, 2) + '</td>'
                + '<td class="text-right">' + angka(total) + '</td>'
                + '</tr>';

            if (buka) {
                (g.baris || []).forEach(function (r) {
                    var ikut = pilih && !(p && p.lepas[String(r.id_sodet)]);
                    html += '<tr class="pi-rinci" data-k="' + teks(g.kunci) + '">'
                        + '<td class="dn-tengah">'
                        + '  <input type="checkbox" class="pi-cek-rinci" data-k="' + teks(g.kunci) + '"'
                        + '         data-id="' + teks(r.id_sodet) + '"' + (ikut ? ' checked' : '')
                        + (pilih ? '' : ' disabled') + '>'
                        + '</td>'
                        + '<td></td>'
                        + '<td class="text-muted">' + teks(r.no_so) + '</td>'
                        + '<td></td>'
                        + '<td class="pi-rinci-produk">' + teks(r.color) + ' / ' + teks(r.size) + '</td>'
                        + '<td class="dn-tengah">' + teks(r.curr) + '</td>'
                        + '<td class="text-right">' + angka(r.qty) + '</td>'
                        + '<td class="text-right">' + angka(r.price, 2) + '</td>'
                        + '<td class="text-right">' + angka(r.total_price) + '</td>'
                        + '</tr>';
                });
            }
        });

        $b.html(html);
        segar();
    }

    /** Ringkasan di kaki modal + tombolnya. */
    function segar() {
        var n = jumlahTerpilih();
        var g = grup.filter(function (x) { return rinciTerpilih(x).length > 0; }).length;
        $('#pi-so-terpilih').text(g + ' row' + (g === 1 ? '' : 's') + ' · '
            + n + ' SO detail line' + (n === 1 ? '' : 's'));

        // Nilai yang dicentang - dijumlah dari baris RINCI-nya, bukan dari
        // baris grup, supaya warna/size yang dilepas ikut berkurang.
        var nilai = 0;
        grup.forEach(function (x) {
            rinciTerpilih(x).forEach(function (r) {
                nilai += parseFloat(r.total_price) || 0;
            });
        });
        $('#pi-so-total').text(angka(nilai));
        $('#pi-so-tambah').prop('disabled', n === 0);

        // Centang pilih-semua ikut baris yang SEDANG tampil saja.
        var tampil = tersaring();
        var semua = tampil.length > 0 && tampil.every(function (x) {
            var p = dipilih[x.kunci];
            return p && p.semua;
        });
        $('#pi-so-pilih-semua').prop('checked', semua);
    }

    /* ===================== kirim ke tabel temporary ===================== */

    function tambahKeLayar() {
        var detSo = [];   // per so_det
        var detPerSo = {}; // diringkas lagi per SO - itu bentuk tabel satunya

        grup.forEach(function (g) {
            var sisa = rinciTerpilih(g);
            if (!sisa.length) { return; }

            sisa.forEach(function (r) {
                detSo.push({
                    id_so_det: r.id_sodet,
                    no_so: r.no_so,
                    produk_det: r.produk_detail,
                    curr: r.curr,
                    qty: r.qty,
                    uom: r.uom,
                    price: r.price,
                    total: r.total_price
                });
            });

            // Baris per SO: qty & nilainya dijumlah dari rincian yang terpilih,
            // supaya cocok dengan baris so_det yang ikut tersimpan.
            if (!detPerSo[g.id_so]) {
                detPerSo[g.id_so] = {
                    so_no: g.so_no, so_date: g.so_date, buyerno: g.buyerno,
                    curr: g.curr, qty: 0, unit_price: g.price, total_price: 0,
                    id_so: g.id_so
                };
            }
            sisa.forEach(function (r) {
                detPerSo[g.id_so].qty += parseFloat(r.qty) || 0;
                detPerSo[g.id_so].total_price += parseFloat(r.total_price) || 0;
            });
        });

        var detInv = Object.keys(detPerSo).map(function (k) { return detPerSo[k]; });
        if (!detSo.length) { return; }

        var $t = $('#pi-so-tambah').prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin"></i> Adding…');

        // Isi tabel sementaranya DIKOSONGKAN dulu. Tabel ini dipakai
        // bersama - bukan per user, bukan per booking - dan total di layar
        // dijumlah dari isinya (Model_nag::sum_grandtotal_proforma). Kalau
        // tidak dikosongkan, baris dari sesi Add SO sebelumnya ikut
        // terhitung dan totalnya membengkak. Alur lamanya pun begitu,
        // lihat duplicate_data_so_proforma() di crud-nag.js.
        //
        // Harus berurutan: hapus dulu sampai selesai, baru simpan.
        $.when(
            $.get(URL_AR + 'delete_invoice_detail_proforma_temporary/'),
            $.get(URL_AR + 'delete_so_detail_proforma_temporary/')
        ).then(function () {
            // Dua endpoint LAMA, nama field sama persis - lihat catatan di atas.
            return $.when(
                $.post(URL_AR + 'simpan_invoice_detail_proforma_temporary/', { data_table: detInv }),
                $.post(URL_AR + 'simpan_so_detail_proforma_temporary/', { data_table: detSo })
            );
        }).done(function () {
            // Tiga fungsi ini milik crud-nag.js - sengaja dipakai ulang supaya
            // isi tabel & hitungan totalnya persis seperti layar lama.
            if (typeof load_invoice_detail_proforma_temporary === 'function') {
                load_invoice_detail_proforma_temporary();
            }
            if (typeof load_so_detail_proforma_temporary === 'function') {
                load_so_detail_proforma_temporary();
            }
            if (typeof sum_grandtotal_proforma === 'function') {
                sum_grandtotal_proforma();
            }
            $('#pi-modal-so').modal('hide');
        }).fail(function () {
            Swal.fire('Could not add the SO',
                'The selected rows were not saved. Please try again.', 'error');
        }).always(function () {
            $t.prop('disabled', false).html('<i class="fas fa-plus"></i> Add Data');
        });
    }

    /* ===================== sesudah tersimpan ===================== */

    /**
     * Dipanggil crud-nag.js begitu header + detail + penanda so_det-nya
     * benar-benar tersimpan. Layar lama langsung memuat ulang halaman tanpa
     * memberi tahu apa-apa - di sini nomor PI-nya ditunjukkan dulu.
     */
    window.pi_setelah_simpan = function (noPi) {
        Swal.fire({
            icon: 'success',
            title: 'Proforma invoice saved',
            html: 'Number <b>' + String(noPi || '') + '</b> has been saved.',
            confirmButtonText: 'OK'
        }).then(function () {
            window.location.href = URL_AR + 'listproformainvoice';
        });
    };

    /* ===================== kejadian di layar ===================== */

    /** Tandai tombol Local / Export yang sedang dipilih. */
    function tandaiShipp() {
        var v = $.trim(String($('#prof_shipp').val() || '')).toLowerCase();
        $('#prof_L').toggleClass('is-aktif', v === 'local');
        $('#prof_E').toggleClass('is-aktif', v === 'export');
    }

    $(function () {
        // Nilainya diisi handler di templates/footer.php yang terpasang di
        // tombol yang sama - penandanya dijalankan sesudah itu.
        $('#prof_L, #prof_E').on('click', function () { setTimeout(tandaiShipp, 0); });
        tandaiShipp();

        $('#pi-f-cari').on('click', cariSo);
        $('#pi-f-from, #pi-f-to').on('keypress', function (e) {
            if (e.which === 13) { cariSo(); }
        });

        $('#pi-so-tbody').on('change', '.pi-cek-grup', function () {
            var k = $(this).data('k');
            if (this.checked) {
                dipilih[k] = { semua: true, lepas: {} };
            } else {
                delete dipilih[k];
            }
            gambar();
        });

        $('#pi-so-tbody').on('change', '.pi-cek-rinci', function () {
            var k = $(this).data('k');
            var id = String($(this).data('id'));
            if (!dipilih[k]) { return; }
            if (this.checked) {
                delete dipilih[k].lepas[id];
            } else {
                dipilih[k].lepas[id] = true;
            }
            gambar();
        });

        $('#pi-so-tbody').on('click', '.pi-buka', function () {
            var k = $(this).data('k');
            dibuka[k] = !dibuka[k];
            gambar();
        });

        $('#pi-f-filter').on('input', gambar);

        $('#pi-so-pilih-semua').on('change', function () {
            var on = this.checked;
            // Yang kena cuma baris yang sedang tampil - pilihan di baris
            // yang sedang tersaring tidak ikut dihapus.
            tersaring().forEach(function (g) {
                if (on) { dipilih[g.kunci] = { semua: true, lepas: {} }; }
                else { delete dipilih[g.kunci]; }
            });
            gambar();
        });

        $('#pi-so-tambah').on('click', tambahKeLayar);

        // Modal dibuka: tanggalnya dibiarkan apa adanya, hasil lama dibersihkan
        // supaya tidak ada centangan nyasar dari pencarian sebelumnya.
        $('#pi-modal-so').on('show.bs.modal', function () {
            grup = [];
            dipilih = {};
            dibuka = {};
            $('#pi-so-info').text('');
            $('#pi-f-filter').val('');
            // Customer-nya ikut yang dipilih di layar - SO yang boleh ditarik
            // memang cuma milik customer itu.
            $('#pi-f-cust').val($('#prof_customer option:selected').text());
            gambar();
        });
    });
}());
