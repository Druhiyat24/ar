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
    //   terpilih[id_sodet] = true   - yang dicentang, per rincian SO.
    //     Disimpan per id, bukan per baris tampil, supaya mengganti
    //     bentuk pengelompokan tidak menghilangkan centangannya.
    //   qtyKetik[kunci]    = angka   - qty yang diketik ulang user.
    //   dibuka[kunci]      = bool    - rinciannya sedang dibuka.
    var grup = [];
    var terpilih = {};
    var qtyKetik = {};
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
    /**
     * Harga satuan ditulis APA ADANYA - nol di belakang koma dibuang.
     * Harga rupiah di SO banyak yang berdesimal panjang (11711.7117117);
     * kalau dipaksa 2 angka seperti nilai uang lain, angkanya meleset.
     * 1.16 tetap "1.16", 11711.7117117 tampil utuh.
     */
    function harga(v) {
        var n = parseFloat(String(v === undefined || v === null ? '' : v).replace(/,/g, ''));
        if (isNaN(n)) { n = 0; }
        return n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 10 });
    }

    function ruas(v) {
        return encodeURIComponent(String(v === undefined || v === null ? '' : v).trim());
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
                terpilih = {};
                qtyKetik = {};
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

    /* ===================== bentuk baris (grouping) =====================
     * Baris yang ditagih tidak harus per warna & size. User memilih bentuknya
     * di modal Add SO:
     *   PRODUCT             satu baris per produk
     *   PRODUCT_COLOR       dipecah per warna
     *   PRODUCT_SIZE        dipecah per size
     *   PRODUCT_COLOR_SIZE  dipecah per warna & size (bentuk lama)
     *
     * HARGA selalu ikut jadi penentu - dua harga tidak pernah digabung, apa
     * pun pilihannya. Server sudah memisahkan grupnya per SO + produk + harga
     * (Model_nag::so_proforma_grup), jadi di sini tinggal memecahnya lagi.
     *
     * Yang dipilih disimpan sebagai KUMPULAN id so_det, bukan per baris
     * tampil - jadi mengganti bentuk pengelompokan tidak menghilangkan
     * centangan yang sudah ada.
     */
    function bentuk() {
        var v = $.trim(String($('#pi-grouping').val() || ''));
        return v === '' ? 'PRODUCT_COLOR_SIZE' : v;
    }
    function pakaiWarna(b) { return b === 'PRODUCT_COLOR' || b === 'PRODUCT_COLOR_SIZE'; }
    function pakaiSize(b) { return b === 'PRODUCT_SIZE' || b === 'PRODUCT_COLOR_SIZE'; }

    /** Tulisan produk satu baris tampil - ini yang tersimpan & tercetak. */
    function namaProduk(t) {
        var b = t.bentuk;
        var nama = $.trim(String(t.product_item || '') + ' ' + String(t.styleno || ''));
        var isi = [];
        if (pakaiWarna(b)) { isi.push(String(t.color || '')); }
        if (pakaiSize(b)) { isi.push(String(t.size || '')); }
        return isi.length ? nama + ' (' + isi.join(',') + ')' : nama;
    }

    /**
     * Baris tampil hasil pengelompokan - sumbernya rincian per so_det yang
     * dikirim server.
     */
    function barisTampil() {
        var b = bentuk();
        var peta = {};
        var urut = [];
        grup.forEach(function (g) {
            (g.baris || []).forEach(function (r) {
                var k = String(g.kunci)
                    + (pakaiWarna(b) ? '|' + String(r.color || '') : '')
                    + (pakaiSize(b) ? '|' + String(r.size || '') : '');
                if (!peta[k]) {
                    peta[k] = {
                        kunci: k, bentuk: b,
                        id_so: g.id_so, so_no: g.so_no, so_date: g.so_date,
                        buyerno: g.buyerno, curr: g.curr,
                        product_item: g.product_item, styleno: g.styleno,
                        price: g.price, uom: r.uom,
                        color: r.color, size: r.size,
                        baris: []
                    };
                    urut.push(peta[k]);
                }
                peta[k].baris.push(r);
            });
        });
        return urut;
    }

    /** Rincian satu baris tampil yang benar-benar dicentang. */
    function rinciTerpilih(t) {
        return (t.baris || []).filter(function (r) { return terpilih[String(r.id_sodet)]; });
    }

    function jumlahTerpilih() {
        var n = 0;
        for (var k in terpilih) { if (terpilih[k]) { n++; } }
        return n;
    }

    /** Qty & nilai satu baris tampil - qty boleh diketik ulang user. */
    function angkaBaris(t) {
        var sisa = rinciTerpilih(t);
        var qty = 0;
        (sisa.length ? sisa : t.baris).forEach(function (r) { qty += parseFloat(r.qty) || 0; });
        var ketik = qtyKetik[t.kunci];
        if (ketik !== undefined && ketik !== '') {
            var n = parseFloat(String(ketik).replace(/,/g, ''));
            if (!isNaN(n)) { qty = n; }
        }
        var harga_satuan = parseFloat(String(t.price).replace(/,/g, '')) || 0;
        return { qty: qty, nilai: qty * harga_satuan, dipilih: sisa.length > 0,
                 sebagian: sisa.length > 0 && sisa.length < (t.baris || []).length };
    }

    /* ===================== gambar tabelnya ===================== */

    /** Baris tampil yang lolos kotak pencarian. */
    function tersaring() {
        var semua = barisTampil();
        var cari = $.trim(String($('#pi-f-filter').val() || '')).toLowerCase();
        if (cari === '') { return semua; }
        return semua.filter(function (t) {
            return (String(t.so_no) + ' ' + String(t.product_item) + ' ' + String(t.styleno)
                  + ' ' + String(t.color) + ' ' + String(t.size)).toLowerCase().indexOf(cari) > -1;
        });
    }

    function gambar() {
        var $b = $('#pi-so-tbody').empty();
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
        tampil.forEach(function (t) {
            var a = angkaBaris(t);
            var buka = !!dibuka[t.kunci];
            var jml = (t.baris || []).length;
            var lepas = jml - rinciTerpilih(t).length;

            html += '<tr class="pi-grup' + (a.dipilih ? ' is-pilih' : '') + '" data-k="' + teks(t.kunci) + '">'
                + '<td class="dn-tengah">'
                + '  <input type="checkbox" class="pi-cek-grup" data-k="' + teks(t.kunci) + '"'
                + (a.dipilih ? ' checked' : '') + '>'
                + '</td>'
                // Kolom Lines sengaja dipertahankan: bentuk barisnya boleh
                // diringkas, tapi user tetap bisa melihat rincian terkecilnya.
                + '<td class="dn-tengah">'
                + '  <button type="button" class="btn btn-link btn-sm pi-buka" data-k="' + teks(t.kunci) + '"'
                + '          title="Show the SO detail lines">'
                + '    <i class="fas fa-caret-' + (buka ? 'down' : 'right') + '"></i> ' + jml
                + '  </button>'
                + '</td>'
                + '<td>' + teks(t.so_no) + '</td>'
                + '<td>' + teks(t.so_date) + '</td>'
                + '<td>' + teks(namaProduk(t))
                + (a.dipilih && lepas ? ' <span class="badge badge-warning">' + lepas + ' excluded</span>' : '')
                + '</td>'
                + '<td class="dn-tengah">' + teks(t.curr) + '</td>'
                // Qty boleh diketik ulang - yang ditagih tidak selalu sama
                // dengan qty SO-nya.
                + '<td class="text-right">'
                + '  <input type="text" class="form-control form-control-sm text-right pi-qty"'
                + '         data-k="' + teks(t.kunci) + '" value="' + angka(a.qty) + '"'
                + '         autocomplete="off" inputmode="decimal">'
                + '</td>'
                + '<td class="text-right">' + harga(t.price) + '</td>'
                + '<td class="text-right pi-nilai">' + angka(a.nilai) + '</td>'
                + '</tr>';

            if (buka) {
                (t.baris || []).forEach(function (r) {
                    var ikut = !!terpilih[String(r.id_sodet)];
                    html += '<tr class="pi-rinci" data-k="' + teks(t.kunci) + '">'
                        + '<td class="dn-tengah">'
                        + '  <input type="checkbox" class="pi-cek-rinci" data-k="' + teks(t.kunci) + '"'
                        + '         data-id="' + teks(r.id_sodet) + '"' + (ikut ? ' checked' : '') + '>'
                        + '</td>'
                        + '<td></td>'
                        + '<td class="text-muted">' + teks(r.no_so) + '</td>'
                        + '<td></td>'
                        + '<td class="pi-rinci-produk">' + teks(r.color) + ' / ' + teks(r.size) + '</td>'
                        + '<td class="dn-tengah">' + teks(r.curr) + '</td>'
                        + '<td class="text-right">' + angka(r.qty) + '</td>'
                        + '<td class="text-right">' + harga(r.price) + '</td>'
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
        var tampil = barisTampil();
        var dipakai = tampil.filter(function (t) { return rinciTerpilih(t).length > 0; });

        $('#pi-so-terpilih').text(dipakai.length + ' row' + (dipakai.length === 1 ? '' : 's')
            + ' · ' + n + ' SO detail line' + (n === 1 ? '' : 's'));

        var nilai = 0;
        dipakai.forEach(function (t) { nilai += angkaBaris(t).nilai; });
        $('#pi-so-total').text(angka(nilai));
        $('#pi-so-tambah').prop('disabled', n === 0);

        var saring = tersaring();
        var semua = saring.length > 0 && saring.every(function (t) {
            return (t.baris || []).every(function (r) { return terpilih[String(r.id_sodet)]; });
        });
        $('#pi-so-pilih-semua').prop('checked', semua);
    }

    /* ===================== kirim ke tabel temporary ===================== */

    function tambahKeLayar() {
        var detSo = [];    // per baris tampil
        var detPerSo = {}; // diringkas lagi per SO - itu bentuk tabel satunya

        barisTampil().forEach(function (t) {
            var sisa = rinciTerpilih(t);
            if (!sisa.length) { return; }
            var a = angkaBaris(t);

            // id so_det yang diwakili baris ini. Semuanya ikut ditandai
            // terpakai waktu simpan - satu baris bisa mewakili puluhan so_det.
            var ids = sisa.map(function (r) { return String(r.id_sodet); });

            detSo.push({
                id_so_det: ids[0],
                id_so_det_list: ids.join(','),
                no_so: t.so_no,
                produk_det: namaProduk(t),
                curr: t.curr,
                qty: a.qty,
                uom: t.uom,
                price: t.price,
                total: a.nilai
            });

            if (!detPerSo[t.id_so]) {
                detPerSo[t.id_so] = {
                    so_no: t.so_no, so_date: t.so_date, buyerno: t.buyerno,
                    curr: t.curr, qty: 0, unit_price: t.price, total_price: 0,
                    id_so: t.id_so
                };
            }
            detPerSo[t.id_so].qty += a.qty;
            detPerSo[t.id_so].total_price += a.nilai;
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
            // Isian ringkasan sempat dikosongkan waktu modalnya dibuka -
            // aturan per tipe (centang DP dan kawan-kawan) dipasang lagi.
            piAturTipe();
            $('#pi-modal-so').modal('hide');
        }).fail(function () {
            Swal.fire('Could not add the SO',
                'The selected rows were not saved. Please try again.', 'error');
        }).always(function () {
            $t.prop('disabled', false).html('<i class="fas fa-plus"></i> Add Data');
        });
    }

    /* ===================== qty di tabel Data SO =====================
     * Qty boleh diketik ulang di layar depan juga, bukan cuma di modal.
     * Nilai barisnya dihitung ulang di sini - termasuk data-total yang ikut
     * tersimpan - lalu seluruh ringkasan di bawahnya menyusul lewat
     * input_diskon_proforma() milik crud-nag.js, supaya diskon & PPN-nya
     * dihitung dengan rumus yang sama persis.
     */
    function piHitungSodet() {
        var total = 0;
        $('#table-proforma-sodet tbody tr').each(function () {
            var sel = this.cells;
            if (!sel || sel.length < 8) { return; }
            var $kotak = $(sel[4]).find('input');
            var qty = parseFloat(String($kotak.length ? $kotak.val() : sel[4].innerHTML)
                .replace(/,/g, '')) || 0;
            var $harga = $(sel[6]).find('input');
            var satuan = parseFloat(String($harga.length ? $harga.val() : sel[6].innerHTML)
                .replace(/,/g, '')) || 0;
            var nilai = qty * satuan;
            // data-total itu yang ikut tersimpan - lihat pi_nilai_utuh()
            // di crud-nag.js.
            sel[7].setAttribute('data-total', String(nilai));
            sel[7].innerHTML = angka(nilai);
            total += nilai;
        });

        // Ruas yang sama dengan yang diisi sum_grandtotal_proforma().
        var tulis = (typeof formatMoney === 'function') ? formatMoney : function (v) { return angka(v); };
        $('[name="prof_grandtotal"]').val(total);
        $('[name="prof_grandtotal_h"]').val(tulis(total));
        $('[name="prof_twot"]').val(total);
        $('[name="prof_twot2"]').val(total);
        $('[name="prof_total_so_h"]').val(tulis(total));
        $('[name="prof_twot_h"]').val(tulis(total));
        if (typeof input_diskon_proforma === 'function') { input_diskon_proforma(); }
    }

    $(function () {
        $('#table-proforma-sodet').on('input', '.pi-qty-sodet', piHitungSodet);
    });

    /* ===================== baris ketikan (PI NON SO) =====================
     * Barisnya tidak punya so_det di belakangnya, jadi tidak ada yang perlu
     * ditandai terpakai - data-ids-nya sengaja kosong. Isinya cuma ada di
     * layar sampai ditekan Save; totalnya dihitung di sini juga, karena
     * sum_grandtotal_proforma() membaca tabel sementara yang memang kosong
     * untuk tipe ini.
     */
    function piBarisKetikan() {
        var kotak = function (kelas, tengah) {
            return '<td' + (tengah ? ' align="center"' : '') + '>'
                + '<input type="text" class="form-control form-control-sm '
                + kelas + '" autocomplete="off"></td>';
        };
        return '<tr data-ids="" class="pi-baris-ketik">'
            // Kolom ID dibiarkan kosong: barisnya memang tidak mewakili so_det.
            + '<td class="text-muted">-</td>'
            + kotak('pi-isi')
            + kotak('pi-isi')
            + kotak('pi-isi text-center', true)
            + kotak('pi-isi pi-qty-sodet text-right')
            + kotak('pi-isi text-center', true)
            + kotak('pi-isi pi-harga-sodet text-right')
            + '<td align="right" data-total="0">0.00</td>'
            + '<td class="dn-tengah">'
            + '<button type="button" class="btn btn-danger btn-sm pi-baris-buang"'
            + ' title="Remove this row"><i class="fas fa-times"></i></button></td>'
            + '</tr>';
    }

    $(function () {
        $('#pi-baris-tambah').on('click', function () {
            $('#table-proforma-sodet tbody').append(piBarisKetikan());
            $('#table-proforma-sodet tbody tr').last().find('input').first().trigger('focus');
            piHitungSodet();
        });
        $('#table-proforma-sodet').on('click', '.pi-baris-buang', function () {
            $(this).closest('tr').remove();
            piHitungSodet();
        });
        // Harga baris ketikan ikut dihitung - qty-nya sudah lewat .pi-qty-sodet.
        $('#table-proforma-sodet').on('input', '.pi-harga-sodet', piHitungSodet);
    });

    /* ===================== sesudah tersimpan ===================== */

    /**
     * Dipanggil crud-nag.js begitu header + detail + penanda so_det-nya
     * benar-benar tersimpan. Layar lama langsung memuat ulang halaman tanpa
     * memberi tahu apa-apa - di sini nomor PI-nya ditunjukkan dulu.
     */
    /**
     * Daftar tempat proforma ini nanti muncul.
     *
     * Satu daftar untuk semua tipe: DP & CBD sudah ikut ke daftar Proforma
     * Invoice, jadi menu lama List Invoice DP & CBD tidak dituju lagi.
     */
    function piDaftar() {
        return URL_AR + 'listproformainvoice';
    }

    window.pi_setelah_simpan = function (noPi) {
        var tujuan = piDaftar();
        Swal.fire({
            icon: 'success',
            title: 'Proforma invoice saved',
            html: 'Number <b>' + String(noPi || '') + '</b> has been saved.',
            confirmButtonText: 'OK'
        }).then(function () {
            window.location.href = tujuan;
        });
    };

    /* ===================== tipe proforma =====================
     * Satu layar untuk empat jenis:
     *   PI, PI NON SO -> tbl_invoice_proforma, penanda SO-nya so_det.no_pi
     *   DP, CBD       -> tbl_invoice_proforma_dp_cbd, penanda so_det.no_pi_cbd
     * Yang membedakan cuma nomor PI-nya, kolom penanda SO, kotak DP, dan
     * jurnal yang ikut tertulis waktu simpan (DP/CBD saja).
     */

    function piTipe() {
        return $.trim(String($('#prof_type_pi').val() || 'PI')).toUpperCase();
    }

    /** DP & CBD memakai tabel dan penanda SO-nya sendiri. */
    function piCbd(t) {
        t = t === undefined ? piTipe() : t;
        return t === 'DP' || t === 'CBD';
    }

    /**
     * Nomor proforma - bentuknya ikut tipe & Local/Export.
     *   PI  -> 0001/E/NAG/1026
     *   DP  -> 0001/D/E/NAG/1026
     *   CBD -> 0001/C/E/NAG/1026
     * Endpointnya yang sudah ada; yang CBD membaca tipenya dari prof_type_pi.
     */
    function piNomor(kode) {
        if (!kode) { return; }
        if (piCbd()) {
            if (typeof get_kode_proforma_invoice_cbd === 'function') {
                get_kode_proforma_invoice_cbd(kode);
            }
        } else if (typeof get_kode_proforma_invoice === 'function') {
            get_kode_proforma_invoice(kode);
        }
    }

    /**
     * Tombol Local / Export.
     *
     * Nilai Shipp-nya diisi handler di templates/footer.php yang menempel di
     * tombol yang sama; di sini tinggal menyalinnya ke prof_shipp_cbd (dibaca
     * alur DP/CBD) lalu mengambil nomornya.
     */
    window.pi_shipp = function (kode) {
        setTimeout(function () {
            $('#prof_shipp_cbd').val($('#prof_shipp').val() || '');
            piNomor(kode);
        }, 0);
    };

    /** PI NON SO: barisnya diketik sendiri, tidak diturunkan dari SO. */
    function piNonSo(t) {
        t = t === undefined ? piTipe() : t;
        return t === 'PI NON SO';
    }

    /** Kotak DP & penanda tipe menyesuaikan tipe yang dipilih. */
    function piAturTipe() {
        var t = piTipe();

        // Penanda baris SO yang dicari: DP & CBD memakai kolom no_pi_cbd.
        $('#pi-tipe-pi').val(piCbd(t) ? 'CBD' : '');

        // PI NON SO tidak menarik SO sama sekali: tombol Add SO dikunci,
        // gantinya Add Row untuk mengetik barisnya sendiri.
        var nonso = piNonSo(t);
        $('#prof_so_number2').prop('disabled', nonso)
            .attr('title', nonso ? 'PI NON SO rows are typed in, not taken from an SO' : '');
        $('#pi-baris-tambah').prop('hidden', !nonso);

        // Patokan DP (persen / nominal) cuma untuk DP. PI memakai nominal.
        $('#pi-dp-patokan').prop('hidden', t !== 'DP');
        if (t !== 'DP') { $('#pilih_dp_prof').val('Amount').trigger('change.select2'); }

        // DP justru HARUS ada DP-nya; CBD justru tidak boleh ada.
        //   DP            -> centangnya dipasang & dikunci, kotak DP terbuka,
        //                    dan nilainya wajib diisi (lihat validasi Save).
        //   CBD           -> centangnya dilepas & dikunci, kotak DP dikosongkan.
        //   PI / PI NON SO -> bebas, seperti semula.
        var wajibDp = (t === 'DP');
        var tanpaDp = (t === 'CBD');
        $('#prof_check_dp').prop('disabled', wajibDp || tanpaDp)
            .attr('title', wajibDp ? 'A DP proforma invoice must have a down payment'
                : (tanpaDp ? 'CBD is paid in full up front - there is no down payment' : null));
        if (wajibDp) {
            $('#prof_check_dp').prop('checked', true);
            $('#prof_dp').prop('readonly', false);
        }
        if (tanpaDp) {
            $('#prof_check_dp').prop('checked', false);
            $('#prof_dp').prop('readonly', true).val('');
            $('#prof_dp_h').val('');
            $('#prof_dp_h2').val('');
        }
    }

    /**
     * Ganti tipe sesudah SO-nya dipilih = pilihan itu dilepas.
     *
     * Baris SO yang sudah masuk ditandai dengan kolom yang beda per tipe
     * (no_pi vs no_pi_cbd), jadi membawanya pindah tipe cuma bikin penandanya
     * salah. Lebih jujur dikosongkan, dan user diberi tahu.
     */
    function piGantiTipe() {
        piAturTipe();

        var adaBaris = $('#table-proforma-sodet tbody tr').length > 0;
        var lanjut = function () {
            // Nomornya ikut berubah bentuk - diambil ulang kalau Shipp-nya
            // memang sudah dipilih.
            var sh = $.trim(String($('#prof_shipp').val() || '')).toLowerCase();
            if (sh === 'local') { piNomor('L'); }
            else if (sh === 'export') { piNomor('E'); }
        };

        if (!adaBaris) { lanjut(); return; }

        Swal.fire({
            icon: 'warning',
            title: 'Start over with this type?',
            html: 'The SO rows you picked are tied to the previous type, '
                + 'so they will be cleared.',
            showCancelButton: true,
            confirmButtonText: 'Yes, clear them',
            cancelButtonText: 'Cancel'
        }).then(function (h) {
            if (!h.isConfirmed) {
                // Dikembalikan ke tipe semula - termasuk tampilan kotak DP-nya.
                $('#prof_type_pi').val(tipeTerakhir).trigger('change.select2');
                piAturTipe();
                return;
            }
            tipeTerakhir = piTipe();
            $.when(
                $.get(URL_AR + 'delete_invoice_detail_proforma_temporary/'),
                $.get(URL_AR + 'delete_so_detail_proforma_temporary/')
            ).always(function () {
                if (typeof load_invoice_detail_proforma_temporary === 'function') {
                    load_invoice_detail_proforma_temporary();
                }
                if (typeof load_so_detail_proforma_temporary === 'function') {
                    load_so_detail_proforma_temporary();
                }
                if (typeof sum_grandtotal_proforma === 'function') {
                    sum_grandtotal_proforma();
                }
                lanjut();
            });
        });
    }

    var tipeTerakhir = 'PI';

    /**
     * COA jurnal DP/CBD.
     *
     * getcoa4()/getcoa_ppn4() di crud-nag.js menembak endpoint yang sama tapi
     * tidak mengembalikan janjinya, padahal di sini simpannya harus menunggu -
     * jurnal DP/CBD membaca kotak ini. Jadi diambil sendiri.
     */
    window.pi_ambil_coa = function () {
        var shipp = $('#prof_shipp').val() || '';
        return $.when(
            $.getJSON(URL_AR + 'getcoa4/' + ruas(shipp) + '/').done(function (d) {
                $('#no_coa_deb4').val(d && d.no_coa ? d.no_coa : '');
                $('#nama_coa_deb4').val(d && d.nama_coa ? d.nama_coa : '');
            }),
            $.getJSON(URL_AR + 'getcoa_ppn4/' + ruas(shipp) + '/').done(function (d) {
                $('#no_coa_ppn4').val(d && d.no_coa ? d.no_coa : '');
                $('#nama_coa_ppn4').val(d && d.nama_coa ? d.nama_coa : '');
            })
        );
    };

    /** Dipakai crud-nag.js waktu Save - tipe mana yang sedang dipilih. */
    window.pi_tipe = piTipe;
    // Dipanggil crud-nag.js sesudah isian ringkasan dikosongkan (Add SO):
    // aturan per tipe harus dipasang lagi, kalau tidak centang DP yang
    // terkunci itu hilang dan tidak bisa dipasang lagi oleh user.
    window.pi_atur_tipe = piAturTipe;
    window.pi_tipe_cbd = function () { return piCbd(); };

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

        // Nomor dari server belum memuat bagian Local/Export - bentuknya
        // masih 0009//NAG/1026. Dikosongkan dulu; terisi penuh begitu Shipp
        // dipilih, lengkap dengan huruf tipenya.
        if (!$.trim(String($('#prof_shipp').val() || ''))) { $('#prof_inv_number').val(''); }

        tipeTerakhir = piTipe();
        piAturTipe();
        $('#prof_type_pi').on('change', piGantiTipe);
        // Tombol Back ikut tipe juga - kembali ke daftar tempat proforma
        // ini nanti muncul.
        $('#pi-kembali').attr('href', piDaftar());
        $('#prof_type_pi').on('change', function () {
            setTimeout(function () { $('#pi-kembali').attr('href', piDaftar()); }, 0);
        });

        $('#pi-f-cari').on('click', cariSo);
        $('#pi-f-from, #pi-f-to').on('keypress', function (e) {
            if (e.which === 13) { cariSo(); }
        });

        // Bentuk baris diganti: centangannya tetap - yang disimpan id so_det,
        // bukan baris tampil. Qty ketikan dilepas karena barisnya memang
        // bukan baris yang sama lagi.
        $('#pi-grouping').on('change', function () {
            qtyKetik = {};
            dibuka = {};
            gambar();
        });

        /** Centang / lepas seluruh rincian satu baris tampil. */
        function tandaiBaris(k, on) {
            barisTampil().forEach(function (t) {
                if (String(t.kunci) !== String(k)) { return; }
                (t.baris || []).forEach(function (r) {
                    if (on) { terpilih[String(r.id_sodet)] = true; }
                    else { delete terpilih[String(r.id_sodet)]; }
                });
            });
        }

        $('#pi-so-tbody').on('change', '.pi-cek-grup', function () {
            tandaiBaris($(this).data('k'), this.checked);
            gambar();
        });

        $('#pi-so-tbody').on('change', '.pi-cek-rinci', function () {
            var id = String($(this).data('id'));
            if (this.checked) { terpilih[id] = true; } else { delete terpilih[id]; }
            gambar();
        });

        // Qty diketik ulang: barisnya tidak digambar ulang supaya kursornya
        // tidak lompat - cukup nilai baris ini & ringkasan di kaki modal.
        $('#pi-so-tbody').on('input', '.pi-qty', function () {
            var k = String($(this).data('k'));
            qtyKetik[k] = $(this).val();
            var cocok = barisTampil().filter(function (t) { return String(t.kunci) === k; });
            if (cocok.length) {
                $(this).closest('tr').find('.pi-nilai').text(angka(angkaBaris(cocok[0]).nilai));
            }
            segar();
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
            tersaring().forEach(function (t) {
                (t.baris || []).forEach(function (r) {
                    if (on) { terpilih[String(r.id_sodet)] = true; }
                    else { delete terpilih[String(r.id_sodet)]; }
                });
            });
            gambar();
        });

        $('#pi-so-tambah').on('click', tambahKeLayar);

        // Modal dibuka: tanggalnya dibiarkan apa adanya, hasil lama dibersihkan
        // supaya tidak ada centangan nyasar dari pencarian sebelumnya.
        $('#pi-modal-so').on('show.bs.modal', function () {
            grup = [];
            terpilih = {};
            qtyKetik = {};
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
