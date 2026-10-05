/* ===========================================================================
 * Create Invoice - satu layar untuk garment (NAG) & knitting (NAK).
 *
 * Berkas ini BARU dan berdiri sendiri: crud-nag.js beserta dua layar lama
 * (createinvoice / createinvoice_knitting) tidak disentuh sama sekali.
 *
 * Yang dipakai tetap endpoint lama dengan nama field yang sama persis, jadi
 * isi database hasil Save tidak berubah:
 *   update_invoice_header/         tbl_book_invoice (status POST) + tbl_log
 *   update_status_bppb/            bppb (MySQL) + official_out_h (PostgreSQL)
 *   simpan_invoice_detail/         tbl_invoice_detail
 *   simpan_invoice_detail_knitting/tbl_invoice_detail_knitting   (NAK saja)
 *   simpan_invoice_pot/            tbl_invoice_pot
 *   simpan_invoice_pot_knitting/   tbl_invoice_pot_knitting      (NAK saja)
 *
 * Bedanya dengan layar lama hanya di layar: satu set angka (bukan dua),
 * tanpa Other Charge, dan permintaan simpannya dikirim berurutan - bukan
 * ditembak bersamaan tanpa menunggu.
 * ======================================================================== */
(function () {
    'use strict';

    var URL_AR   = typeof CI_URL      !== 'undefined' ? CI_URL      : 'arnag/';
    var URL_LIST = typeof CI_URL_LIST !== 'undefined' ? CI_URL_LIST : 'listinvoice';

    /* Layar ini dipakai dua kali: membuat invoice baru dan mengubah invoice
     * yang sudah ada. Alurnya sengaja sama persis - yang berbeda cuma isian
     * awalnya (diambil dari invoice-nya) dan endpoint waktu disimpan. */
    var UBAH = (typeof CI_MODE !== 'undefined' && CI_MODE === 'edit');
    var ID_UBAH = UBAH && typeof CI_ID_EDIT !== 'undefined' ? parseInt(CI_ID_EDIT, 10) || 0 : 0;
    // Invoice yang sudah FIRST APPROVED: isinya tidak boleh diubah lagi, yang
    // masih boleh cuma melengkapi supporting document - sesudah approval kedua
    // lampirannya memang tidak bisa ditambah lagi.
    var DOK_SAJA = UBAH && (typeof CI_DOK_SAJA !== 'undefined' && CI_DOK_SAJA);

    /* ------------------------------------------------------------------ *
     * Keadaan layar. Baris SJ disimpan sebagai data (bukan dibaca ulang
     * dari sel tabel), jadi isi payload tidak pernah ikut berubah kalau
     * tampilan tabelnya diubah.
     * ------------------------------------------------------------------ */
    var inv = {
        pc: '',            // NAG (garment) atau NAK (knitting)
        baris: [],         // baris SJ yang masuk invoice
        vat: 0,            // 0 / 0.11 / 0.12
        dp: 0,
        dpcbd: 0,
        retur: 0,
        // Booking dari Invoice EXIM yang SJ-nya belum terbit: barisnya masih
        // berupa SO/WS, jadi SJ-nya dipilih manual di sini - terbatas pada SO
        // yang dipesan booking itu.
        sjBelum: false,
        // Shipment Details - cuma dipakai invoice Export. Isinya milik
        // Invoice EXIM Export; di sini boleh dilengkapi tim AR.
        kirim: [],
        kirimMerek: [],
        kirimExport: false,
        // Langkah simpan berikutnya yang harus dijalankan. Selain 0 berarti
        // Save sebelumnya berhenti di tengah - Save berikutnya menyambung dari
        // langkah itu, tidak mengulang yang sudah tersimpan.
        lanjut: 0
    };
    var sjCari = [];       // baris SJ dari SEMUA SO yang dicentang di modal
    var soCari = [];
    var soDimuat = {};     // id_so yang SJ-nya sudah ditarik (biar tidak dobel)
    var soDisaring = {};   // id_so -> berapa baris SJ-nya dibuang (milik booking EXIM)

    /* ============================ alat bantu ============================ */
    function teks(v) {
        if (v === null || v === undefined || v === '') { return '-'; }
        return $('<div>').text(v).html();
    }
    function angka(v) {
        // Koma ribuan dibuang dulu: beberapa endpoint lama (mis. cari_book_inv
        // yang memakai FORMAT(value, 2)) mengirim angka yang SUDAH diformat -
        // parseFloat("33,948,900.00") berhenti di koma pertama dan jadi 33.
        var n = parseFloat(String(v === undefined || v === null ? '' : v).replace(/,/g, ''));
        if (isNaN(n)) { return '0.00'; }
        return n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    function nilai(v) {
        var n = parseFloat(String(v === undefined || v === null ? '' : v).replace(/,/g, ''));
        return isNaN(n) ? 0 : n;
    }
    function kosongkanTabel($tbody, kolom, ikon, pesan) {
        $tbody.html('<tr><td colspan="' + kolom + '"><div class="ci-kosong">'
            + '<i class="fas ' + ikon + '"></i><span>' + pesan + '</span></div></td></tr>');
    }
    function pesan(ikon, judul, isi) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: ikon, title: judul, html: isi, customClass: { popup: 'ci-swal' } });
        } else {
            alert(judul + '\n\n' + String(isi).replace(/<[^>]+>/g, ''));
        }
    }
    // Batas waktu satu permintaan. Tanpa ini, satu permintaan yang macet
    // membuat layar menunggu selamanya.
    var BATAS_WAKTU = 120000;

    /** Ambil JSON dari server - selalu lewat sini supaya batas waktunya ikut. */
    function ambilJson(rute) {
        return $.ajax({ url: URL_AR + rute, type: 'GET', dataType: 'json', timeout: BATAS_WAKTU });
    }

    /** Satu ruas URL CodeIgniter. Ruas kosong bikin method-nya kekurangan
     *  argumen (error 500), dan spasi (mis. "GRADE A") harus di-encode. */
    function ruasUrl(v) {
        return encodeURIComponent($.trim(String(v === undefined || v === null ? '' : v)));
    }

    /** Pesan pendek untuk permintaan yang gagal - dipakai di beberapa tempat. */
    function sebabGagal(xhr) {
        if (!xhr) { return 'Connection error.'; }
        if (xhr.statusText === 'timeout') { return 'The server took too long to answer.'; }
        // Kalau servernya menyebutkan alasannya, itu yang dipakai - "HTTP 409"
        // tidak memberi tahu apa pun ke user.
        var j = xhr.responseJSON;
        if (j && (j.message || j.pesan)) { return String(j.message || j.pesan); }
        if (xhr.status) { return 'Server error (HTTP ' + xhr.status + ').'; }
        return 'Connection error.';
    }

    /** Buka/tutup rincian angka di kartu Summary. Yang tampil pertama cuma
     *  Grand Total - rinciannya dibuka kalau user memang mau melihat. */
    function bukaRincian(buka) {
        $('#ci-sum-detail').prop('hidden', !buka);
        $('#ci-sum-toggle').toggleClass('is-buka', !!buka)
            .find('span').text(buka ? 'Hide details' : 'Show details');
    }

    /** Isi kotak angka, tapi jangan ganggu kalau sedang dipakai mengetik. */
    function isiAngka($el, nilaiBaru) {
        if ($el.is(':focus')) { return; }
        $el.val(angka(nilaiBaru));
    }

    /** Satu baris SJ dikenali dari sumber + id-nya. */
    function kunci(r) {
        return String(r.id_bppb) + '|' + String(r.sj);
    }

    /* ===================== 1. Pilih booking invoice ===================== */
    function cariBooking() {
        var dari = $('#ci-book-from').val();
        var sampai = $('#ci-book-to').val();
        var $b = $('#ci-book-body');
        kosongkanTabel($b, 10, 'fa-spinner fa-spin', 'Loading...');

        // cari_book_inv_ar = cari_book_inv yang filternya membandingkan tanggal
        // saja; tgl_book_inv menyimpan jam, jadi yang lama melewatkan booking
        // hari itu kalau tanggal awal & akhir filternya sama.
        ambilJson('cari_book_inv_ar/' + ruasUrl(dari) + '/' + ruasUrl(sampai) + '/').fail(function (xhr) {
            kosongkanTabel($b, 10, 'fa-triangle-exclamation', 'Could not load booking invoices. ' + sebabGagal(xhr));
        }).done(function (data) {
            $b.data('isi', data || []);
            gambarBooking();
        }).fail(function () {
            kosongkanTabel($b, 10, 'fa-exclamation-triangle', 'Could not load the booking invoice list.');
        });
    }

    /** Gambar daftar booking sesuai filter profit center yang dipilih. */
    function gambarBooking() {
        var $b = $('#ci-book-body');
        var semua = $b.data('isi') || [];
        var pc = String($('#ci-book-pc').val() || '').toUpperCase();

        if (!semua.length) {
            kosongkanTabel($b, 10, 'fa-inbox', 'No draft booking invoice in this date range.');
            return;
        }
        // Index-nya tetap index di data asli - tombol Select membacanya dari situ.
        var tampil = semua.map(function (r, i) { return { r: r, i: i }; }).filter(function (x) {
            return !pc || String(x.r.profit_center || '').toUpperCase() === pc;
        });
        if (!tampil.length) {
            kosongkanTabel($b, 10, 'fa-filter', 'No draft booking invoice for this profit center.');
            return;
        }

        $b.html(tampil.map(function (x) {
            var r = x.r, i = x.i;
            // Booking dari Invoice EXIM yang SJ-nya belum terbit tetap bisa
            // ditagih, tapi SJ-nya dipilih di sini dan terbatas pada SO yang
            // dipesan booking itu - ditandai supaya diketahui sebelum dipilih.
            var sjBelum = !!r.dari_exim && !r.jml_sj;
            return '<tr data-i="' + i + '"' + (sjBelum ? ' class="ci-book-nosj"' : '') + '>'
                    + '<td class="dn-tengah"><button type="button" class="btn btn-ci-pilih ci-book-pilih" data-i="' + i + '"'
                    + (sjBelum ? ' title="SJ not issued yet - pick it here, limited to the SO booked in Invoice EXIM"' : '')
                    + '><i class="fas fa-plus"></i> Select</button></td>'
                    + '<td><b>' + teks(r.no_invoice) + '</b>'
                    + (sjBelum ? ' <span class="ci-lencana-nosj">SJ not issued</span>' : '') + '</td>'
                    + '<td>' + teks(r.profit_center) + '</td>'
                    + '<td>' + teks(r.customer) + '</td>'
                    + '<td>' + teks(r.shipp) + '</td>'
                    + '<td>' + teks(r.doc_type) + '</td>'
                    + '<td>' + teks(r.doc_number) + '</td>'
                    + '<td>' + teks(r.tanggal) + '</td>'
                    + '<td>' + teks(r.type) + '</td>'
                    + '<td class="ci-angka">' + angka(r.amount) + '</td>'
                    + '</tr>';
        }).join(''));
    }

    function pakaiBooking(r) {
        isiKepalaBooking(r);
        $('#ci-modal-book').modal('hide');
        cariTop();       // TOP-nya langsung dicari, biasanya cuma satu
        muatSjExim(r.id); // cek: booking ini dari Invoice EXIM atau dari AR?
    }

    /**
     * Isi kartu kiri dari sebuah booking. Dipisah dari pakaiBooking() supaya
     * mode edit bisa memakainya juga - bedanya di mode edit TOP & baris SJ-nya
     * datang dari invoice yang sedang diubah, bukan dicari ulang.
     */
    function isiKepalaBooking(r) {
        // Booking lain -> rantai simpan mulai dari awal lagi, dan pilihan
        // buyer di modal Add SO ikut disetel ulang ke customer yang baru.
        inv.lanjut = 0;
        $('#ci-so-buyer').removeData('ci-terisi');
        // Ganti booking = mulai dari nol; baris SJ lama tidak boleh ikut
        // terbawa ke invoice lain.
        inv.pc = String(r.profit_center || '').toUpperCase();
        inv.baris = [];
        inv.vat = 0; inv.dp = 0; inv.dpcbd = 0; inv.retur = 0;

        $('#ci-inv-number').val(r.no_invoice);
        $('#ci-pc-h').val(inv.pc);
        $('#ci-customer').val(r.customer);
        $('#ci-type').val(r.type);
        $('#ci-doc-type').val(r.doc_type);
        $('#ci-doc-number').val(r.doc_number);
        $('#ci-amount').val(angka(r.amount));
        $('#ci-id-inv').val(r.id);
        $('#ci-id-cust').val(r.id_customer);
        $('#ci-id-top').val('');
        $('#ci-top').val('');
        $('#ci-top-time').val('');
        $('#ci-so-list').val('');

        // Knitting boleh mengubah Local/Export (ikut layar knitting lama),
        // garment mengikuti booking-nya.
        var $shipp = $('#ci-shipp');
        $shipp.val(r.shipp || '');
        if ($shipp.find('option[value="' + (r.shipp || '') + '"]').length === 0 && r.shipp) {
            $shipp.append('<option value="' + teks(r.shipp) + '">' + teks(r.shipp) + '</option>').val(r.shipp);
        }
        $shipp.prop('disabled', inv.pc !== 'NAK');
        // change.select2 - bukan change biasa - supaya tampilan select2-nya
        // ikut nilai baru TANPA memicu update_shipp_invoice ke server.
        $shipp.trigger('change.select2');

        var $pc = $('#ci-pc-badge');
        $('#ci-pc-teks').text(inv.pc === 'NAK' ? 'NAK - Knitting' : 'NAG - Garment');
        $pc.toggleClass('is-nak', inv.pc === 'NAK').prop('hidden', !inv.pc);
        $('#ci-so-bantu').text(inv.pc === 'NAK'
            ? 'SJ is taken from knitting (OFC/OUT).'
            : 'SJ is taken from garment (BPPB).');

        gambarBaris();
        // Shipment Details ikut booking-nya - cuma terisi kalau Export.
        muatShipment();
    }

    /* ================== 1c. Mode edit: muat invoice-nya =================
     * Layar diisi dari invoice yang sedang diubah - kepala, baris SJ, rekap
     * angka, dan lampirannya - lalu bekerja persis seperti mode create.
     * ===================================================================== */
    function muatInvoiceUbah() {
        $('#ci-btn-simpan').prop('disabled', true);
        ambilJson('edit_invoice_json/' + ruasUrl(ID_UBAH) + '/')
            .done(function (d) {
                if (!d || !d.status) {
                    pesan('error', 'Could not load the invoice',
                        (d && d.message) || 'Please go back to the list and open it again.');
                    return;
                }
                pakaiInvoiceUbah(d);
                $('#ci-btn-simpan').prop('disabled', false);
            })
            .fail(function (xhr) {
                pesan('error', 'Could not load the invoice', sebabGagal(xhr)
                    + '<br>Nothing has been changed - please open it again from the list.');
            });
    }

    function pakaiInvoiceUbah(d) {
        var h = d.header || {};
        var p = d.pot || {};

        isiKepalaBooking({
            id: h.id, no_invoice: h.no_invoice, customer: h.customer, id_customer: h.id_customer,
            shipp: h.shipp, doc_type: h.doc_type, doc_number: h.doc_number, type: h.type,
            profit_center: h.profit_center, amount: p.grand_total || 0
        });

        // ---- Terms & account ----
        $('#ci-id-top').val(h.id_top || '');
        $('#ci-top').val(h.top ? h.top + ' days' : '');
        $('#ci-top-time').val(h.type_top || '');
        if (h.id_bank) { $('#ci-bank').val(String(h.id_bank)).trigger('change.select2'); }
        if (h.type_so) { $('#ci-type-so').val(h.type_so).trigger('change.select2'); }
        if (h.pph) {
            $('#ci-pph').val(h.pph).trigger('change.select2');
            $('#ci-id-pph').val(h.id_pph === null || h.id_pph === undefined ? '0' : h.id_pph);
        }
        $('#ci-coa-no').val(h.no_coa || '');
        $('#ci-coa-nama').val(h.nama_coa || '');

        // ---- baris SJ & rekap ----
        inv.baris = (d.baris || []).map(function (r) { r.disc = nilai(r.disc); return r; });
        inv.dp = nilai(p.dp);
        inv.dpcbd = 0;                       // kolomnya memang tidak tersimpan
        inv.retur = nilai(p.retur);
        inv.vat = nilai(d.vat_persen) / 100;
        $('#ci-m-vat11').prop('checked', nilai(d.vat_persen) === 11);
        $('#ci-m-vat12').prop('checked', nilai(d.vat_persen) === 12);
        // Isian uang di modal Add SO ikut diisi: hitungModal() membacanya balik
        // ke inv.dp/dpcbd/retur, jadi kalau dibiarkan kosong angka yang baru
        // saja dimuat malah tertimpa nol.
        $('#ci-m-dp').val(angka(inv.dp));
        $('#ci-m-dpcbd').val(angka(inv.dpcbd));
        $('#ci-m-retur').val(angka(inv.retur));

        // Baris yang sudah ada ikut muncul (dan tercentang) di modal Add SO,
        // jadi bisa dilepas atau ditambah persis seperti waktu membuat baru.
        // Asal booking ditetapkan lebih dulu: gambarBaris() ikut membacanya
        // untuk memilih ikon kunci atau tombol hapus di kolom Action.
        inv.dariExim = !!d.dari_exim;

        sjCari = inv.baris.map(function (r) {
            var s = $.extend({}, r);
            s._pilih = true;
            s._disc = nilai(r.disc);
            return s;
        });
        inv.baris.forEach(function (r) { if (r.id_so) { soDimuat[r.id_so] = true; } });
        gambarSj(sjCari);
        gambarBaris();

        // Booking yang datang dari Invoice EXIM tetap terkunci waktu diubah:
        // baris SJ-nya dipilih di nds_wip, bukan di sini.
        aturAsalBooking();

        // Invoice yang sudah FIRST APPROVED: kuncinya dipasang lagi sesudah
        // isinya dimuat - aturAsalBooking() & gambarBaris() sempat menyalakan
        // ulang tombol-tombolnya.
        if (DOK_SAJA) { kunciDokSaja(); }

        // ---- lampiran yang sudah tersimpan ----
        dok = (d.lampiran || []).map(function (l) {
            return {
                file: { name: l.nama, size: parseInt(l.ukuran, 10) || 0 },
                url: l.url,
                id_doc: l.id,
                tersimpan: true
            };
        });
        docRender();
    }

    /* ================= 1b. Booking yang datang dari Invoice EXIM ==========
     * Booking yang dibuat di menu Invoice EXIM sudah membawa baris SJ-nya
     * sendiri. Barisnya dimuat apa adanya dan DIKUNCI - user tidak memilih
     * ulang, tidak menghapus baris, dan tidak mengubah diskonnya. Booking yang
     * dibuat di menu Book Invoice AR tidak punya baris ini, jadi layarnya
     * bekerja seperti biasa (wajib Add SO).
     * ===================================================================== */
    function muatSjExim(idBook) {
        inv.dariExim = false;
        inv.sjBelum = false;
        aturAsalBooking();
        if (!idBook) { return; }

        ambilJson('cari_sj_exim/' + ruasUrl(idBook) + '/').fail(function (xhr) {
            pesan('error', 'Could not load the SJ rows', sebabGagal(xhr)
                + '<br>The booking invoice was selected, but its SJ rows are not loaded yet.');
        }).done(function (d) {
            var baris = (d && d.baris) || [];

            // Asal booking dibaca dari penandanya, BUKAN dari ada tidaknya
            // baris SJ. Invoice EXIM boleh dibuat sebelum SJ-nya terbit -
            // barisnya masih berupa SO/WS - jadi booking EXIM tanpa baris SJ
            // tetap booking EXIM, bukan booking Book Invoice AR.
            if (!d || !d.dari_exim) { aturAsalBooking(); return; }

            inv.dariExim = true;

            // SJ-nya belum terbit: yang tersimpan di EXIM baru baris SO/WS.
            // SJ-nya dipilih manual di sini, tapi TERBATAS pada SO itu -
            // pembatasannya di server (cari_so_ar & cari_sj_ar), jadi daftar
            // di modal Add SO memang sudah berisi SO booking ini saja.
            if (!baris.length) {
                inv.sjBelum = true;
                inv.baris = [];
                inv.soExim = d.so_baris || [];
                terapkanPotExim(d.pot);
                aturAsalBooking();
                gambarBaris();
                pesan('info', 'Pick the SJ for this booking',
                    'The SJ is not issued yet in <b>Invoice EXIM</b>'
                    + (d.jml_so ? ' - it booked ' + d.jml_so + ' WS/SO row' + (d.jml_so > 1 ? 's' : '') : '')
                    + '.<br>Press <b>Add SO</b> to pick the SJ. Only the SO booked there is listed, '
                    + 'so the invoice stays on the same SO.');
                return;
            }

            inv.sjBelum = false;
            inv.baris = baris.map(function (r) {
                r.disc = nilai(r.disc);
                return r;
            });

            terapkanPotExim(d && d.pot);
            aturAsalBooking();
            gambarBaris();
        }).fail(function () {
            // Endpoint/tabelnya belum ada - anggap booking biasa dari AR.
            inv.dariExim = false;
            aturAsalBooking();
        });
    }

    /**
     * DP, DP/CBD, Return & persen VAT ikut yang sudah diisi di Invoice EXIM.
     *
     * Total & diskonnya tetap dihitung ulang dari baris SJ-nya - rumusnya sama,
     * jadi angkanya pasti cocok. Dipakai juga waktu SJ-nya belum terbit:
     * barisnya memang belum ada, tapi DP & Return-nya sudah diisi di sana dan
     * tidak boleh hilang cuma karena SJ-nya dipilih di sini.
     */
    function terapkanPotExim(p) {
        if (!p) { return; }
        inv.dp    = nilai(p.dp);
        inv.dpcbd = nilai(p.dp_cbd);
        inv.retur = nilai(p.retur);
        inv.vat   = nilai(p.vat_persen) / 100;
    }

    /** Tampilan menyesuaikan asal booking: dari EXIM (terkunci) atau AR. */
    function aturAsalBooking() {
        // Booking EXIM: DP, DP/CBD & Return diketik di kartu Summary, jadi
        // rinciannya langsung dibuka - kalau tertutup, isiannya tidak kelihatan.
        if (inv.dariExim) { bukaRincian(true); }
        var exim = !!inv.dariExim;
        var sjBelum = exim && !!inv.sjBelum;
        // SJ-nya belum terbit: justru harus dipilih di sini, jadi Add SO &
        // Clear tetap hidup. Yang dibatasi SO-nya, dan itu urusan server.
        $('#ci-btn-so').prop('disabled', exim && !sjBelum);
        $('#ci-btn-kosongkan').prop('hidden', exim && !sjBelum);
        // Dua keterangan yang berbeda: SJ-nya terkunci, atau SJ-nya belum ada.
        $('#ci-catatan-exim').prop('hidden', !exim || sjBelum);
        $('#ci-catatan-nosj').prop('hidden', !sjBelum);
        $('#ci-so-bantu').prop('hidden', exim);
        $('#ci-so-list').attr('placeholder', sjBelum
            ? 'Pick the SJ from the SO booked in Invoice EXIM'
            : exim ? 'SJ rows come from Invoice EXIM' : 'Pick the SJ rows to invoice');

        // Booking AR mengisi DP / DP-CBD / Return di modal Add SO. Booking dari
        // EXIM tidak lewat modal itu, jadi ketiganya diketik langsung disini.
        $('#ci-dp, #ci-dpcbd, #ci-retur')
            .prop('readonly', !exim)
            .toggleClass('ci-bisa-isi', exim)
            .attr('title', exim ? '' : 'Filled in the Add SO window');
    }

    /* ========================= 2. Term of payment ======================= */
    function cariTop() {
        var idCust = $('#ci-id-cust').val();
        if (!idCust) { return; }
        var $b = $('#ci-top-body');
        kosongkanTabel($b, 5, 'fa-spinner fa-spin', 'Loading...');

        $.ajax({
            url: URL_AR + 'cari_top/',
            type: 'POST',
            data: { id_cust: idCust },
            dataType: 'JSON'
        }).done(function (data) {
            if (!data || !data.length) {
                kosongkanTabel($b, 5, 'fa-hand-holding-usd', 'No term of payment found for this customer.');
                return;
            }
            $b.html(data.map(function (r, i) {
                return '<tr>'
                    + '<td class="dn-tengah"><button type="button" class="btn btn-ci-pilih ci-top-pilih" data-i="' + i + '">'
                    + '<i class="fas fa-plus"></i> Select</button></td>'
                    + '<td>' + teks(r.customer) + '</td>'
                    + '<td>' + teks(r.type) + '</td>'
                    + '<td>' + teks(r.top) + '</td>'
                    + '<td>' + teks(r.status) + '</td>'
                    + '</tr>';
            }).join(''));
            $b.data('isi', data);
            // Cuma satu pilihan: langsung dipakai, tidak perlu buka modal.
            if (data.length === 1) { pakaiTop(data[0]); }
        }).fail(function () {
            kosongkanTabel($b, 5, 'fa-exclamation-triangle', 'Could not load the term of payment.');
        });
    }

    function pakaiTop(r) {
        $('#ci-top').val(r.type);
        $('#ci-top-time').val(r.top);
        $('#ci-id-top').val(r.id);
        $('#ci-modal-top').modal('hide');
    }

    /**
     * Kotak uang di modal Add SO diselaraskan dengan angka yang sedang dipakai.
     *
     * Booking dari Invoice EXIM mengisi DP / DP-CBD / Return & VAT di kartu
     * Summary, bukan di modal ini. Begitu modalnya ikut dibuka - SJ-nya belum
     * terbit, jadi SJ-nya dipilih di sini - kotak di modal masih nol, dan
     * sekali disentuh angka dari Invoice EXIM tertimpa nol.
     */
    function selaraskanModalUang() {
        $('#ci-m-dp').val(angka(inv.dp));
        $('#ci-m-dpcbd').val(angka(inv.dpcbd));
        $('#ci-m-retur').val(angka(inv.retur));
        var persen = Math.round(nilai(inv.vat) * 100);
        $('#ci-m-vat11').prop('checked', persen === 11);
        $('#ci-m-vat12').prop('checked', persen === 12);
    }

    /* ========================= 3. Pilih SO & SJ ========================= */
    function bukaModalSo() {
        // Booking EXIM yang SJ-nya SUDAH ada: barisnya terkunci. Yang SJ-nya
        // belum terbit justru harus dipilih di sini, jadi tidak ikut ditolak.
        if (inv.dariExim && !inv.sjBelum) {
            pesan('info', 'SJ rows are already set',
                'This booking invoice comes from Invoice EXIM - its SJ rows were picked there and cannot be changed here.');
            return;
        }
        if (!$('#ci-id-inv').val()) {
            pesan('warning', 'Pick a booking invoice first',
                'The profit center of the booking decides where the SJ comes from.');
            return;
        }
        $('#ci-so-cust').val($('#ci-customer').val());
        isiBuyerBawaan();
        if (inv.dariExim) { selaraskanModalUang(); }
        $('#ci-modal-so').modal('show');

        // Layar Edit: daftar SO-nya langsung diambil sekali, jadi SO milik
        // invoice ini sudah kelihatan (dan tercentang) tanpa user menekan
        // Search dulu - tanggal SO invoice lama biasanya jauh di luar rentang
        // bawaan, dan cari_so_ar() memang selalu menyertakan SO invoice ini.
        // Layar Edit maupun booking EXIM tanpa SJ: daftarnya diambil langsung.
        // Di keduanya tidak ada yang perlu difilter user - SO-nya sudah
        // ditentukan invoice/booking-nya, jadi kotak filternya dimatikan.
        $('#ci-so-from, #ci-so-to, #ci-so-buyer').prop('disabled', !!inv.sjBelum);
        if ((UBAH || inv.sjBelum) && !soCari.length) { cariSo(); }
    }

    /**
     * Buyer diisi dulu dengan customer booking-nya - itu yang paling sering
     * dipakai - tapi tetap boleh diganti user. Kalau customer-nya tidak ada
     * di daftar buyer, pilihannya ditambahkan sendiri supaya namanya tetap
     * kelihatan (bukan "ALL").
     */
    function isiBuyerBawaan() {
        var id = String($('#ci-id-cust').val() || '');
        var nama = $('#ci-customer').val();
        var $b = $('#ci-so-buyer');
        if (!id || $b.data('ci-terisi') === id) { return; }
        if (!$b.find('option[value="' + id + '"]').length) {
            $b.append($('<option>', { value: id, text: nama || id }));
        }
        $b.val(id).data('ci-terisi', id).trigger('change');
    }

    function cariSo() {
        var idCust = $('#ci-id-cust').val();
        var buyer = $('#ci-so-buyer').val() || idCust;
        var dari = $('#ci-so-from').val();
        var sampai = $('#ci-so-to').val();
        var $b = $('#ci-so-body');
        kosongkanTabel($b, 7, 'fa-spinner fa-spin', 'Loading...');

        // Daftar SO-nya diganti, jadi centang & SJ hasil pencarian sebelumnya
        // ikut dibersihkan - kalau tidak, ada baris tanpa SO di daftar.
        //
        // Kecuali yang memang sudah jadi isi invoice: SO-nya tetap dianggap
        // tercentang dan baris SJ-nya tetap di daftar. Tanpa ini, di layar
        // Edit SJ-nya tercentang tapi SO-nya tidak - padahal dua-duanya
        // datang dari invoice yang sama.
        soDimuat = {};
        soDisaring = {};
        inv.baris.forEach(function (r) { if (r.id_so) { soDimuat[r.id_so] = true; } });
        sjCari = sjCari.filter(function (r) { return !!cariDiInvoice(r); });
        catatanSjExim();
        $('#ci-so-cek-semua').prop('checked', false);
        gambarSj(sjCari);

        // cari_so_ar = cari_so / cari_so_knitting yang sudah membuang SO yang
        // SJ-nya habis (sudah di-invoice atau dipesan booking Invoice EXIM).
        ambilJson('cari_so_ar/' + ruasUrl(dari) + '/' + ruasUrl(sampai) + '/' + ruasUrl(idCust) + '/'
            + ruasUrl(buyer) + '/' + ruasUrl(inv.pc) + '/'
            + ruasUrl($('#ci-id-inv').val() || '0') + '/').fail(function (xhr) {
            kosongkanTabel($b, 7, 'fa-triangle-exclamation', 'Could not load the sales orders. ' + sebabGagal(xhr));
        }).done(function (hasil) {
            soCari = (hasil && hasil.baris) || [];
            // Daftarnya dibatasi ke SO booking-nya: dikatakan, supaya filter
            // yang tidak berpengaruh tidak terlihat seperti rusak.
            var terbatas = !!(hasil && hasil.terbatas);
            $('#ci-so-terbatas').prop('hidden', !terbatas);
            if (!soCari.length) {
                kosongkanTabel($b, 7, 'fa-inbox', terbatas
                    ? 'This booking has no SO recorded in Invoice EXIM.'
                    : 'No SO found for this filter.');
                return;
            }
            $b.html(soCari.map(function (r, i) {
                return '<tr>'
                    + '<td class="dn-tengah"><input type="checkbox" class="ci-so-cek" data-i="' + i + '"'
                    + (soDimuat[r.id_so] ? ' checked' : '') + '></td>'
                    + '<td><b>' + teks(r.so_no) + '</b></td>'
                    + '<td>' + teks(r.so_date) + '</td>'
                    + '<td>' + teks(r.supplier) + '</td>'
                    + '<td>' + teks(r.buyerno) + '</td>'
                    + '<td>' + teks(r.so_type) + '</td>'
                    + '<td>' + teks(r.id_so) + '</td>'
                    + '</tr>';
            }).join(''));
            sesuaikanRentangSo();
        }).fail(function () {
            kosongkanTabel($b, 7, 'fa-exclamation-triangle', 'Could not load the SO list.');
        });
    }

    /**
     * Layar Edit: rentang tanggal SO dimundurkan sampai mencakup SO invoice ini.
     *
     * SO invoice lama tanggalnya jauh sebelum hari ini, sedangkan kotak filter
     * bawaannya hari ini - jadi yang tertulis di filter tidak memuat SO yang
     * sedang tampil. Tanggalnya baru ketahuan sesudah SO-nya terambil, jadi
     * penyesuaiannya di sini. Yang dimundurkan cuma "SO Date From": rentang
     * yang sudah diperlebar user sendiri tidak dipersempit.
     */
    function sesuaikanRentangSo() {
        if (!UBAH) { return; }

        var awal = '';
        soCari.forEach(function (r) {
            if (!soDimuat[r.id_so]) { return; }
            var t = String(r.so_date || '').slice(0, 10);
            if (!/^\d{4}-\d{2}-\d{2}$/.test(t)) { return; }
            if (!awal || t < awal) { awal = t; }
        });
        if (!awal) { return; }

        var sekarang = String($('#ci-so-from').val() || '').slice(0, 10);
        if (!sekarang || awal < sekarang) {
            $('#ci-so-from').val(awal);
            // Datepicker-nya ikut diberi tahu supaya kalender & nilainya sejalan.
            try { $('#ci-so-from').datepicker('update', awal); } catch (e) { /* tanpa datepicker */ }
        }
    }

    /** Buang baris SJ milik satu SO (SO-nya dilepas centangnya). */
    function buangSjSo(idSo) {
        delete soDimuat[idSo];
        delete soDisaring[idSo];
        catatanSjExim();
        sjCari = sjCari.filter(function (r) { return String(r.id_so) !== String(idSo); });
        gambarSj(sjCari);
    }

    /**
     * Tarik SJ milik satu SO lalu GABUNGKAN dengan yang sudah ada - sama
     * seperti layar lama: beberapa SO boleh dicentang sekaligus dan SJ-nya
     * berkumpul di satu tabel.
     */
    function cariSj(idSo) {
        var $b = $('#ci-sj-body');
        if (!sjCari.length) { kosongkanTabel($b, 17, 'fa-spinner fa-spin', 'Loading...'); }

        // cari_sj_ar = cari_sj / cari_sj_knitting yang sudah membuang SJ milik
        // booking Invoice EXIM. Booking EXIM belum menandai bppb sebagai "sudah
        // di-invoice", jadi tanpa saringan ini satu SJ bisa dipesan dua kali.
        ambilJson('cari_sj_ar/' + ruasUrl(idSo) + '/' + ruasUrl(inv.pc) + '/'
            + ruasUrl($('#ci-id-inv').val() || '0') + '/').fail(function (xhr) {
            $('#ci-so-body').find('.ci-so-cek[data-i]').each(function () {
                var r = soCari[parseInt($(this).data('i'), 10)];
                if (r && String(r.id_so) === String(idSo)) { $(this).prop('checked', false); }
            });
            if (!sjCari.length) {
                kosongkanTabel($b, 17, 'fa-triangle-exclamation', 'Could not load the SJ rows. ' + sebabGagal(xhr));
            } else {
                pesan('error', 'Could not load the SJ rows', sebabGagal(xhr));
            }
        }).done(function (hasil) {
            var data = (hasil && hasil.baris) || [];
            soDimuat[idSo] = true;
            soDisaring[idSo] = (hasil && hasil.disaring) || 0;
            catatanSjExim();

            var baru = data.map(function (r) {
                // Baris yang sudah masuk invoice tetap tercentang & diskonnya
                // ikut, jadi modal ini bisa dipakai untuk mengoreksi pilihan.
                var lama = cariDiInvoice(r);
                r._pilih = !!lama;
                r._disc = lama ? lama.disc : 0;
                return r;
            }).filter(function (r) {
                // Satu SJ bisa muncul di dua SO (jarang, tapi mungkin) - yang
                // sudah ada di tabel tidak ditambahkan lagi.
                return !sjCari.some(function (x) { return kunci(x) === kunci(r); });
            });

            sjCari = sjCari.concat(baru);
            gambarSj(sjCari);
        });
    }

    /** Beri tahu kalau ada baris SJ yang disembunyikan karena sudah dipesan
     *  booking Invoice EXIM - biar user tidak mencarinya terus. */
    function catatanSjExim() {
        var jumlah = 0;
        Object.keys(soDisaring).forEach(function (k) { jumlah += soDisaring[k]; });
        var $c = $('#ci-sj-dipakai');
        if (!jumlah) { $c.attr('hidden', true).html(''); return; }
        $c.removeAttr('hidden').html('<i class="fas fa-eye-slash"></i> ' + jumlah + ' SJ row'
            + (jumlah > 1 ? 's are' : ' is') + ' hidden - already booked in <b>Invoice EXIM</b>.');
    }

    function cariDiInvoice(r) {
        for (var i = 0; i < inv.baris.length; i++) {
            if (kunci(inv.baris[i]) === kunci(r)) { return inv.baris[i]; }
        }
        return null;
    }

    function gambarSj(daftar) {
        var $b = $('#ci-sj-body');
        if (!daftar.length) {
            kosongkanTabel($b, 17, 'fa-truck', Object.keys(soDimuat).length
                ? 'No SJ left for the ticked SO - they may already be invoiced.'
                : 'Tick one or more SO above to see their SJ.');
            hitungModal();
            return;
        }
        $b.html(daftar.map(function (r) {
            var i = sjCari.indexOf(r);
            return '<tr' + (r._pilih ? ' class="is-pilih"' : '') + '>'
                + '<td>' + teks(r.no_so) + '</td>'
                + '<td>' + teks(r.sj) + '</td>'
                + '<td>' + teks(r.bppbdate) + '</td>'
                + '<td>' + teks(r.shipping_number) + '</td>'
                + '<td>' + teks(r.ws) + '</td>'
                + '<td>' + teks(r.styleno) + '</td>'
                + '<td>' + teks(r.product_group) + '</td>'
                + '<td>' + teks(r.product_item) + '</td>'
                + '<td>' + teks(r.color) + '</td>'
                + '<td>' + teks(r.size) + '</td>'
                + '<td>' + teks(r.curr) + '</td>'
                + '<td>' + teks(r.uom) + '</td>'
                + '<td class="ci-angka">' + angka(r.qty) + '</td>'
                + '<td class="ci-angka">' + angka(r.unit_price) + '</td>'
                + '<td class="ci-angka"><input type="text" class="form-control ci-kecil ci-sj-disc" data-i="' + i + '"'
                + ' value="' + (r._disc || 0) + '" inputmode="decimal" autocomplete="off"></td>'
                + '<td class="ci-angka">' + angka(r.total_price) + '</td>'
                + '<td class="dn-tengah"><input type="checkbox" class="ci-sj-cek" data-i="' + i + '"'
                + (r._pilih ? ' checked' : '') + '></td>'
                + '</tr>';
        }).join(''));
        aturKunciTanggal();
        hitungModal();
    }

    /* ---- Satu invoice = satu tanggal SJ ----
     * Begitu satu baris dicentang, baris bertanggal lain dikunci: boleh
     * beberapa SJ, tapi tanggalnya harus sama. Kalau semuanya dilepas,
     * kuncinya hilang lagi. */
    function tanggalSj(r) {
        return String((r && r.bppbdate) || '').slice(0, 10);
    }

    /** Tanggal yang sedang dipakai invoice ini - '' kalau belum ada. */
    /**
     * Baris yang akan jadi isi invoice kalau Apply ditekan sekarang:
     * baris invoice yang TIDAK ada di hasil pencarian (tidak bisa dilepas dari
     * sini) ditambah baris yang sedang tercentang. Dipakai bareng oleh
     * hitungModal() dan aturan satu tanggal.
     */
    function barisProspek() {
        return inv.baris.filter(function (x) {
            return !sjCari.some(function (y) { return kunci(y) === kunci(x); });
        }).concat(sjCari.filter(function (r) { return r._pilih; }));
    }

    /**
     * Tanggal yang sedang dipakai invoice ini - '' kalau belum ada.
     *
     * Dihitung dari baris PROSPEK, bukan dari inv.baris apa adanya: waktu user
     * melepas semua centang untuk mengganti tanggal, isi invoice yang lama
     * memang masih tersimpan sampai Apply ditekan - kalau itu ikut dihitung,
     * kuncinya tidak pernah lepas dan SJ tanggal lain tidak bisa dicentang.
     */
    function tanggalTerpakai() {
        var tgl = '';
        barisProspek().forEach(function (r) { if (!tgl) { tgl = tanggalSj(r); } });
        return tgl;
    }

    function aturKunciTanggal() {
        var tgl = tanggalTerpakai();
        var terkunci = 0;
        $('#ci-sj-body .ci-sj-cek').each(function () {
            var r = sjCari[parseInt($(this).data('i'), 10)];
            if (!r) { return; }
            var beda = !!tgl && tanggalSj(r) !== tgl;
            $(this).prop('disabled', beda);
            $(this).closest('tr').toggleClass('is-kunci-tgl', beda);
            if (beda) { terkunci++; }
        });

        var $ket = $('#ci-sj-tgl-info');
        if (!$ket.length) { return; }
        if (tgl && terkunci) {
            $ket.html('<i class="fas fa-calendar-day"></i> One invoice = one SJ date. '
                + 'Locked to <b>' + teks(tgl) + '</b> - <b>' + terkunci + '</b> row'
                + (terkunci > 1 ? 's' : '') + ' of another date have no tick box. '
                + 'Untick everything to pick another date.').prop('hidden', false);
        } else if (tgl) {
            $ket.html('<i class="fas fa-calendar-day"></i> One invoice = one SJ date. '
                + 'This invoice uses <b>' + teks(tgl) + '</b>.').prop('hidden', false);
        } else {
            $ket.prop('hidden', true);
        }
    }

    /** Tanggal SJ yang berbeda-beda di sekumpulan baris - kosong/1 isi = aman. */
    function tanggalBeda(daftar) {
        var ada = [];
        (daftar || []).forEach(function (r) {
            var t = tanggalSj(r);
            if (t && ada.indexOf(t) === -1) { ada.push(t); }
        });
        return ada;
    }

    /* Angka di modal - rumusnya satu, dipakai ulang tiap ada perubahan. */
    function hitungModal() {
        var total = 0, discount = 0, qty = 0, n = 0;

        // Yang dihitung: baris tercentang di modal + baris yang sudah masuk
        // invoice tapi SO-nya tidak sedang ditampilkan.
        var dipakai = barisProspek();

        dipakai.forEach(function (r) {
            var tp = nilai(r.total_price);
            total += tp;
            discount += nilai(r._disc !== undefined ? r._disc : r.disc) / 100 * tp;
            qty += nilai(r.qty);
            n++;
        });

        inv.dp = nilai($('#ci-m-dp').val());
        inv.dpcbd = nilai($('#ci-m-dpcbd').val());
        inv.retur = nilai($('#ci-m-retur').val());

        var twot = total - discount - inv.dp - inv.dpcbd - inv.retur;
        var vat = twot * inv.vat;

        $('#ci-m-total').val(angka(total));
        $('#ci-m-discount').val(angka(discount));
        $('#ci-m-twot').val(angka(twot));
        $('#ci-m-vat').val(angka(vat));
        $('#ci-m-grand').val(angka(twot + vat));

        $('#ci-sj-info').html(n
            ? '<b>' + n + '</b> SJ row' + (n > 1 ? 's' : '') + ' ticked'
              + '<span class="ci-pilih-qty">Total Qty <b>' + angka(qty) + '</b></span>'
            : 'No SJ ticked yet.');
        return dipakai;
    }

    /* ============ SJ jadi acuan: Invoice EXIM ikut diperbarui ============
     * Booking yang dibuat di Invoice EXIM sebelum SJ-nya terbit isinya baru
     * baris SO/WS. SJ yang dipilih di sini yang benar-benar dikirim, jadi qty
     * & warna di Invoice EXIM ikut menyesuaikan. Perubahannya tidak boleh
     * terjadi diam-diam - angka itu dipakai cetakan & daftar di menu EXIM.
     * ================================================================== */

    /** Kunci pencocokan baris: WS + warna, sama dengan yang dipakai server. */
    function kunciWsWarna(r) {
        return $.trim(String(r.ws == null ? '' : r.ws)).toUpperCase()
            + '|' + $.trim(String(r.color == null ? '' : r.color)).toUpperCase();
    }

    /**
     * Rencana perubahan Invoice EXIM kalau baris SJ yang sekarang dipakai.
     *
     * Dihitung dari data yang sudah ada di layar, jadi alert-nya muncul tanpa
     * menunggu server. Yang MENULIS tetap server, dan ia menghitung ulang
     * dengan rumus yang sama - jadi yang dilaporkan sama dengan yang dikerjakan.
     */
    function rencanaUbahExim(baris) {
        var sj = {};
        (baris || []).forEach(function (r) {
            var k = kunciWsWarna(r);
            if (!sj[k]) { sj[k] = { ws: r.ws, color: r.color, qty: 0 }; }
            sj[k].qty += nilai(r.qty);
        });

        var ubah = [], buang = [], adaSo = {};
        (inv.soExim || []).forEach(function (so) {
            var k = kunciWsWarna(so);
            if (!sj[k]) { buang.push(so); return; }
            adaSo[k] = true;
            if (Math.abs(nilai(so.qty) - sj[k].qty) > 0.00001) {
                ubah.push({ baris: so, dari: nilai(so.qty), ke: sj[k].qty });
            }
        });

        var baru = Object.keys(sj).filter(function (k) { return !adaSo[k]; })
            .map(function (k) { return sj[k]; });

        return { ubah: ubah, baru: baru, buang: buang };
    }

    /** "2 qty updated · 1 colour added · 1 row removed" */
    function ringkasUbahExim(r) {
        var bagian = [];
        if (r.ubah.length)  { bagian.push('<b>' + r.ubah.length + '</b> qty updated'); }
        if (r.baru.length)  { bagian.push('<b>' + r.baru.length + '</b> colour'
            + (r.baru.length > 1 ? 's' : '') + ' added'); }
        if (r.buang.length) { bagian.push('<b>' + r.buang.length + '</b> row'
            + (r.buang.length > 1 ? 's' : '') + ' removed'); }
        return bagian.join(' <span class="ci-titik">&middot;</span> ');
    }

    function labelWsWarna(r) {
        var ws = $.trim(String(r.ws == null ? '' : r.ws));
        var warna = $.trim(String(r.color == null ? '' : r.color));
        return teks(ws && ws !== '-' ? ws + ' \u00b7 ' + warna : warna);
    }

    function bagianUbahExim(judul, alasan, daftar, isiBaris) {
        return '<div class="ci-swal-judul-kecil">' + judul + '</div>'
            + '<div class="ci-swal-alasan">' + alasan + '</div>'
            + '<ul class="ci-swal-daftar">' + daftar.map(isiBaris).join('') + '</ul>';
    }

    /** Apa yang akan berubah di Invoice EXIM - ditanyakan dulu, sekali. */
    function konfirmasiUbahExim(baris, lanjut) {
        var r = rencanaUbahExim(baris);
        if (!r.ubah.length && !r.baru.length && !r.buang.length) { lanjut(); return; }

        var isi = ['<div class="ci-swal-ringkas-ubah">' + ringkasUbahExim(r) + '</div>'];
        if (r.ubah.length) {
            var naik = r.ubah.filter(function (x) { return x.ke > x.dari; }).length;
            var turun = r.ubah.length - naik;
            var judul = 'Qty follows the SJ';
            if (naik && turun) { judul += ' (' + naik + ' up, ' + turun + ' down)'; }
            else if (naik)     { judul += ' (' + naik + ' up)'; }
            else if (turun)    { judul += ' (' + turun + ' down)'; }
            isi.push(bagianUbahExim(judul,
                'What is invoiced is what was actually shipped, so the SJ qty replaces the ordered qty.',
                r.ubah, function (x) {
                    return '<li>' + labelWsWarna(x.baris) + ': <b>' + angka(x.dari)
                        + '</b> &rarr; <b>' + angka(x.ke) + '</b></li>';
                }));
        }
        if (r.baru.length) {
            isi.push(bagianUbahExim(
                'Added from the SJ &ndash; ' + r.baru.length + ' colour' + (r.baru.length > 1 ? 's' : ''),
                'These colours are on the SJ but were not booked in Invoice EXIM yet.',
                r.baru, function (x) {
                    return '<li>' + labelWsWarna(x) + ': <b>' + angka(x.qty) + '</b></li>';
                }));
        }
        if (r.buang.length) {
            isi.push(bagianUbahExim(
                'Removed &ndash; ' + r.buang.length + ' row' + (r.buang.length > 1 ? 's' : '') + ' without SJ',
                'No SJ covers these colours, so they are not shipped on this invoice.',
                r.buang, function (x) {
                    return '<li>' + labelWsWarna(x) + ': <b>' + angka(x.qty) + '</b></li>';
                }));
        }

        Swal.fire({
            icon: 'question',
            title: 'Update Invoice EXIM to match the SJ?',
            html: isi.join('')
                + '<p class="ci-swal-catatan">Invoice EXIM still holds the ordered WS/SO figures. '
                + 'Its prints and list follow these numbers, so they are brought in line with the SJ '
                + 'when this invoice is saved.</p>',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Yes, update',
            cancelButtonText: 'No, go back',
            reverseButtons: true,
            width: 620,
            customClass: { popup: 'ci-swal' }
        }).then(function (pilih) {
            if (pilih.isConfirmed) { lanjut(); }
        });
    }
    /* Tombol Apply: pilihan di modal jadi isi invoice. */
    function terapkanSo() {
        var dipakai = hitungModal();
        if (!dipakai.length) {
            pesan('warning', 'No SJ ticked', 'Tick at least one SJ row before continuing.');
            return;
        }
        // Pengaman terakhir: satu invoice = satu tanggal SJ.
        var beda = tanggalBeda(dipakai);
        if (beda.length > 1) {
            pesan('warning', 'One invoice = one SJ date',
                'The ticked rows carry ' + beda.length + ' different dates ('
                + teks(beda.join(', ')) + '). Keep only the rows of one date.');
            return;
        }
        var bersih = dipakai.map(function (r) {
            var s = $.extend({}, r);
            s.disc = nilai(s._disc !== undefined ? s._disc : s.disc);
            delete s._pilih;
            delete s._disc;
            return s;
        });

        var pakai = function () {
            inv.baris = bersih;
            gambarBaris();
            $('#ci-modal-so').modal('hide');
        };

        // Booking EXIM yang SJ-nya belum terbit: SJ ini yang jadi acuan, jadi
        // qty & warna di Invoice EXIM akan ikut berubah waktu disimpan nanti.
        // Ditanyakan di sini - di sinilah SJ-nya dipilih.
        if (inv.sjBelum) { konfirmasiUbahExim(bersih, pakai); return; }
        pakai();
    }

    /* ===================== 4. Tabel detail di layar ===================== */
    function gambarBaris() {
        var $b = $('#ci-tbody');
        if (!inv.baris.length) {
            kosongkanTabel($b, 17, 'fa-truck', 'No SJ selected yet. Use &ldquo;Add SO&rdquo; to pick one.');
            $('#ci-tfoot').prop('hidden', true);
        } else {
            $b.html(inv.baris.map(function (r, i) {
                return '<tr>'
                    + '<td>' + teks(r.no_so) + '</td>'
                    + '<td>' + teks(r.sj) + '</td>'
                    + '<td>' + teks(r.bppbdate) + '</td>'
                    + '<td>' + teks(r.shipping_number) + '</td>'
                    + '<td>' + teks(r.ws) + '</td>'
                    + '<td>' + teks(r.styleno) + '</td>'
                    + '<td>' + teks(r.product_group) + '</td>'
                    + '<td>' + teks(r.product_item) + '</td>'
                    + '<td>' + teks(r.color) + '</td>'
                    + '<td>' + teks(r.size) + '</td>'
                    + '<td>' + teks(r.curr) + '</td>'
                    + '<td>' + teks(r.uom) + '</td>'
                    + '<td class="ci-angka">' + angka(r.qty) + '</td>'
                    + '<td class="ci-angka">' + angka(r.unit_price) + '</td>'
                    + '<td class="ci-angka">' + angka(r.disc) + '</td>'
                    + '<td class="ci-angka">' + angka(r.total_price) + '</td>'
                    + '<td class="dn-tengah">'
                    + (inv.dariExim
                        ? '<i class="fas fa-lock ci-kunci" title="Comes from Invoice EXIM"></i>'
                        : '<button type="button" class="btn btn-dn-buang ci-buang" data-i="' + i + '"'
                          + ' title="Remove this row"><i class="fas fa-times"></i></button>')
                    + '</td>'
                    + '</tr>';
            }).join(''));

            var qty = 0, total = 0;
            inv.baris.forEach(function (r) { qty += nilai(r.qty); total += nilai(r.total_price); });
            $('#ci-foot-kiri').html('<b>' + inv.baris.length + '</b> SJ row' + (inv.baris.length > 1 ? 's' : ''));
            $('#ci-foot-qty').text(angka(qty));
            $('#ci-foot-total').text(angka(total));
            $('#ci-tfoot').prop('hidden', false);
        }

        // Nomor SO yang terpakai, grade/tanggal/mata uang ikut baris pertama -
        // sama seperti layar lama (satu invoice = satu tanggal SJ).
        var so = [];
        inv.baris.forEach(function (r) {
            if (r.no_so && so.indexOf(r.no_so) === -1) { so.push(r.no_so); }
        });
        $('#ci-so-list').val(so.join(', '));
        if (inv.baris.length) {
            $('#ci-grade').val(inv.baris[0].grade || 'GRADE A');
            $('#ci-inv-date').val(inv.baris[0].bppbdate || '');
            $('#ci-inv-curr').val(inv.baris[0].curr || '');
        } else {
            $('#ci-grade').val(''); $('#ci-inv-date').val(''); $('#ci-inv-curr').val('');
        }
        hitungRingkasan();
    }

    function hitungRingkasan() {
        var total = 0, discount = 0;
        inv.baris.forEach(function (r) {
            var tp = nilai(r.total_price);
            total += tp;
            discount += nilai(r.disc) / 100 * tp;
        });
        var twot = total - discount - inv.dp - inv.dpcbd - inv.retur;
        var vat = twot * inv.vat;

        $('#ci-total').val(angka(total));
        $('#ci-discount').val(angka(discount));
        // Tiga isian ini bisa diketik sendiri untuk booking dari EXIM, jadi
        // isinya tidak ditimpa selama kotaknya sedang dipakai mengetik.
        isiAngka($('#ci-dp'), inv.dp);
        isiAngka($('#ci-dpcbd'), inv.dpcbd);
        isiAngka($('#ci-retur'), inv.retur);
        $('#ci-twot').val(angka(twot));
        $('#ci-vat').val(angka(vat));
        $('#ci-grand').val(angka(twot + vat));
        $('#ci-vat-label').text(inv.vat ? '(' + Math.round(inv.vat * 100) + '%)' : '');
    }

    /* ============================ 5. Simpan ============================= */
    function kategoriCustomer() {
        var id = String($('#ci-id-cust').val());
        return (id === '524' || id === '804' || id === '366') ? 'Related' : 'Third';
    }

    /** COA & kurs dipakai header invoice - diambil seperti layar lama. */
    function ambilCoaDanRate() {
        // Ruasnya: Type SO / Shipp / kategori customer / grade / profit center.
        // Kalau ada yang masih kosong, URL-nya tidak bisa dibentuk - jangan
        // dipaksa, nanti malah error 500 di server.
        var ruas = [$('#ci-type-so').val(), $('#ci-shipp').val(), kategoriCustomer(),
            $('#ci-grade').val(), inv.pc].map(ruasUrl);
        var lengkap = ruas.every(function (v) { return v !== ''; });

        var coa = lengkap
            ? ambilJson('getcoa/' + ruas.join('/') + '/').then(function (d) {
                // Balasannya bisa null: kombinasi ini belum ada di mastercoa_v2.
                // Itu bukan alasan untuk berhenti - layar lama pun tetap
                // menyimpan - tapi harus kelihatan, jadi kotaknya dikosongkan
                // dan dilaporkan di dialog konfirmasi.
                $('#ci-coa-no').val(d && d.no_coa ? d.no_coa : '');
                $('#ci-coa-nama').val(d && d.nama_coa ? d.nama_coa : '');
                return d;
            })
            : kosongkanCoa();

        var tgl = ruasUrl($('#ci-inv-date').val());
        var rate = tgl
            ? ambilJson('getrate/' + tgl + '/').then(function (d) {
                // Kurs tanggal itu juga bisa belum diisi (null).
                $('#ci-rate').val(d && d.rate ? d.rate : '');
                return d;
            })
            : $.Deferred().resolve(null).promise();

        return $.when(coa, rate);

        function kosongkanCoa() {
            $('#ci-coa-no').val('');
            $('#ci-coa-nama').val('');
            return $.Deferred().resolve(null).promise();
        }
    }

    /**
     * Isian yang belum lengkap. Tiap baris ikut membawa keterangan singkat
     * (harus melakukan apa, di bagian mana) dan penunjuk elemennya, supaya
     * pesannya bisa langsung menuntun - bukan cuma menyebut nama isiannya.
     */
    function kurang() {
        var k = [];
        if (!$('#ci-id-inv').val()) {
            k.push({ nama: 'Booking invoice', ikon: 'fa-file-invoice', sel: '#ci-btn-book',
                ket: 'Press <b>Add Book Inv</b> and pick a DRAFT booking - it decides the customer and the profit center.' });
        }
        if (!$('#ci-id-top').val()) {
            k.push({ nama: 'Term of payment', ikon: 'fa-handshake', sel: '#ci-btn-top',
                ket: 'Pick it with the search button next to <b>TOP Type</b>; the due date follows from it.' });
        }
        if (!$('#ci-bank').val()) {
            k.push({ nama: 'Bank', ikon: 'fa-university', sel: '#ci-bank',
                ket: 'Choose the account that receives the payment - it is printed on the invoice.' });
        }
        if (!$('#ci-type-so').val()) {
            k.push({ nama: 'Type SO', ikon: 'fa-tags', sel: '#ci-type-so',
                ket: 'Choose <b>FOB</b> or <b>CMT</b>.' });
        }
        if (!inv.baris.length) {
            k.push({ nama: 'SJ rows', ikon: 'fa-truck', sel: inv.dariExim ? '#ci-inv-number' : '#ci-btn-so',
                ket: inv.sjBelum
                    ? 'The SJ of this booking is not issued yet in Invoice EXIM. Press <b>Add SO</b> '
                      + 'and pick the SJ - only the SO booked there is listed.'
                    : inv.dariExim
                    ? 'This booking comes from Invoice EXIM but has no SJ row - please check it there.'
                    : 'Press <b>Add SO</b>, tick the SJ you want to invoice, then press Apply.' });
        }
        // Satu invoice = satu tanggal SJ. Data lama bisa saja tercampur, jadi
        // tetap diperiksa di sini sebelum disimpan.
        var beda = tanggalBeda(inv.baris);
        if (beda.length > 1) {
            k.push({ nama: 'SJ date', ikon: 'fa-calendar-day', sel: '#ci-btn-so',
                ket: 'One invoice can only cover <b>one SJ date</b>, but these rows carry '
                    + beda.length + ' (' + teks(beda.join(', ')) + '). '
                    + 'Remove the rows that belong to another date.' });
        }
        return k;
    }

    /** Gulirkan ke isian yang kurang lalu sorot sebentar supaya kelihatan. */
    function sorotIsian(sel) {
        var $el = $(sel);
        if (!$el.length) { return; }
        var el = $el[0];
        if (el.scrollIntoView) { el.scrollIntoView({ block: 'center', behavior: 'smooth' }); }

        // Select2 menyembunyikan <select> aslinya - yang disorot kotak buatannya.
        var $sorot = $el.is('select') && $el.next('.select2-container').length
            ? $el.next('.select2-container') : $el;
        $sorot.addClass('ci-sorot');
        setTimeout(function () { $sorot.removeClass('ci-sorot'); }, 2200);
        if ($el.is('input, select, button')) {
            try { $el.trigger('focus'); } catch (e) { /* tidak apa-apa */ }
        }
    }

    /** Satu baris ringkasan (label kiri, nilai kanan). */
    function barisRingkas(label, isi, kelas) {
        return '<div' + (kelas ? ' class="' + kelas + '"' : '') + '><span>' + label + '</span><b>'
            + teks(isi) + '</b></div>';
    }
    /** Baris angka yang cuma ditampilkan kalau isinya tidak nol - dialognya
     *  jadi tidak kepanjangan oleh potongan yang memang tidak dipakai. */
    function barisAngka(label, $el, selalu) {
        var v = $el.val();
        if (!selalu && !nilai(v)) { return ''; }
        return barisRingkas(label, v);
    }

    /** Ditunjukkan dulu apa yang akan disimpan: sekali disimpan, booking-nya
     *  jadi POST dan SJ-nya tidak bisa dipakai invoice lain. */
    function bukaKonfirmasi() {
        // Invoice yang sudah FIRST APPROVED: isinya tidak ikut disimpan, jadi
        // yang ditanyakan cuma dokumennya.
        if (DOK_SAJA) {
            konfirmasiDokSaja();
            return;
        }

        var k = kurang();
        if (k.length) {
            var daftar = k.map(function (x) {
                return '<li><i class="fas ' + x.ikon + '"></i><span><b>' + teks(x.nama) + '</b>'
                    + '<small>' + x.ket + '</small></span></li>';
            }).join('');
            var judul = k.length > 1
                ? k.length + ' things still need to be filled in'
                : 'One more thing to fill in';

            if (typeof Swal === 'undefined') {
                pesan('warning', 'Please complete the form', '<ul>' + daftar + '</ul>');
                return;
            }
            Swal.fire({
                icon: 'warning',
                title: 'Please complete the form',
                html: '<div class="ci-swal-sub">' + judul + ' before this invoice can be saved.</div>'
                    + '<ul class="ci-swal-kurang">' + daftar + '</ul>',
                width: 520,
                confirmButtonText: 'OK, take me there',
                customClass: { popup: 'ci-swal' }
            }).then(function () { sorotIsian(k[0].sel); });
            return;
        }
        ambilCoaDanRate();

        if (typeof Swal === 'undefined') {
            if (window.confirm('Save invoice ' + $('#ci-inv-number').val() + '?')) { simpan(); }
            return;
        }

        var curr = String((inv.baris[0] || {}).curr || '').toUpperCase();
        var qty = 0, sj = {};
        inv.baris.forEach(function (r) { qty += nilai(r.qty); sj[r.sj] = true; });
        var jmlSj = Object.keys(sj).length;
        var vatLabel = $.trim($('#ci-vat-label').text());

        var ringkas = '<div class="ci-swal-ringkas">'
            + barisRingkas('Invoice Number', $('#ci-inv-number').val())
            + barisRingkas('Customer', $('#ci-customer').val())
            + barisRingkas('Bank', $('#ci-bank').find(':selected').text())
            + barisRingkas('Detail SJ', inv.baris.length + ' row' + (inv.baris.length > 1 ? 's' : '')
                + ' \u00b7 ' + jmlSj + ' SJ \u00b7 ' + angka(qty) + ' qty')
            // Lampiran & potongan cuma ditulis kalau memang ada isinya -
            // dialognya jadi pendek dan yang penting langsung kelihatan.
            + (dok.length ? barisRingkas('Supporting Docs',
                dok.length + ' file' + (dok.length > 1 ? 's' : '')) : '')
            + barisAngka('Discount', $('#ci-discount'))
            + barisAngka('Down Payment', $('#ci-dp'))
            + barisAngka('DP/CBD from Invoice', $('#ci-dpcbd'))
            + barisAngka('Return', $('#ci-retur'))
            + barisAngka('VAT' + (vatLabel ? ' ' + vatLabel : ''), $('#ci-vat'))
            + barisRingkas('Grand Total', $('#ci-grand').val() + (curr ? ' ' + curr : ''), 'ci-swal-grand')
            + '</div>'
            // Menyimpan tanpa lampiran itu boleh, tapi jangan sampai kelewat:
            // sesudah invoice tersimpan, dokumennya tidak bisa ditambahkan dari
            // layar ini lagi.
            + (dok.length ? '' : '<div class="ci-swal-ingat"><i class="fas fa-exclamation-triangle"></i>'
                + ' This invoice will be saved <b>without any supporting document</b>.</div>')
            + '<p class="ci-swal-catatan">'
            + (inv.lanjut
                ? 'The previous attempt stopped halfway, so saving continues from step '
                    + (inv.lanjut + 1) + ' - the steps that already went through are not repeated.'
                : 'Once saved, this booking invoice becomes <b>POST</b> and its SJ'
                    + ' can no longer be used by another invoice.')
            + (dok.length ? ' The supporting documents are uploaded right after the invoice is saved.' : '')
            + '</p>';

        tampilkanKonfirmasi(ringkas);
    }

    /** Kirim isi layar ke arnag/preview_invoice_v2 lewat form POST (tab baru).
     *  Tidak ada yang ditulis ke database - PDF-nya dibentuk dari data layar,
     *  jadi user bisa melihat dulu cetakan yang akan terjadi. */
    /**
     * Lampiran yang ikut disambung ke pratinjau. Dikirim lewat form biasa,
     * jadi ukurannya dibatasi post_max_size server - file yang tidak muat
     * dilewati (isinya tetap ikut waktu invoice disimpan nanti, ini cuma
     * soal pratinjau).
     */
    function lampiranPratinjau() {
        var muat = [], lewat = [], total = 0;
        dok.forEach(function (d) {
            if (total + d.file.size > DOC_CHUNK) { lewat.push(d.file.name); return; }
            total += d.file.size;
            muat.push(d.file);
        });
        return { muat: muat, lewat: lewat };
    }

    /**
     * Kirim isi layar ke arnag/preview_invoice_v2. $jenis kosong = cetakan
     * invoice, 'knitting' = cetakan kedua milik NAK. Keduanya berkas sendiri -
     * itu yang nanti dikirim ke customer - dan lampirannya ikut ke dua-duanya.
     */
    function kirimPratinjau(jenis, tujuan) {
        var $f = $('<form>', {
            method: 'POST',
            enctype: 'multipart/form-data',
            action: URL_AR + 'preview_invoice_v2',
            // Hasil POST-nya dirender di iframe dalam modal (nama iframe), atau
            // di tab baru kalau user memilih "Open in New Tab".
            target: tujuan || 'ci-pdf-frame'
        });
        var isi = {
            id_inv: $('#ci-id-inv').val(),
            id_top: $('#ci-id-top').val(),
            id_bank: $('#ci-bank').val(),
            // Knitting: barisnya ikut membawa id_konsumen, yang dipakai
            // cetakan untuk menulis konsumen sebagai penerima tagihan.
            data_table: inv.pc === 'NAK' ? payloadDetailKnitting() : payloadDetail(),
            pot: payloadPot(false),
            jenis: jenis || ''
        };
        // Shipment Details ikut dikirim supaya pratinjaunya memperlihatkan yang
        // baru diketik - bagian itu boleh diubah di sini dan belum tentu sudah
        // tersimpan waktu Preview ditekan.
        // kirim_ada dikirim terpisah: $.param membuang array kosong, jadi tanpa
        // penanda ini "semua barisnya dibuang" tidak bisa dibedakan dari "layar
        // memang tidak mengirim apa-apa".
        if (inv.kirimExport) {
            isi.kirim_ada = '1';
            isi.kirim = payloadKirim();
        }
        // Array & object dikirim sebagai data_table[0][qty] dst, sama seperti
        // yang dilakukan jQuery waktu mengirim lewat $.ajax.
        $f.append($.param(isi).split('&').map(function (pasangan) {
            // Pisahnya di '=' PERTAMA saja - nilainya sendiri boleh mengandung '='.
            var batas = pasangan.indexOf('=');
            var nama = batas < 0 ? pasangan : pasangan.slice(0, batas);
            var nilai = batas < 0 ? '' : pasangan.slice(batas + 1);
            return $('<input>', {
                type: 'hidden',
                name: decodeURIComponent(nama.replace(/\+/g, ' ')),
                value: decodeURIComponent(nilai.replace(/\+/g, ' '))
            });
        }));
        // Lampiran ikut dikirim supaya pratinjaunya = berkas utuh: invoice
        // di depan, supporting document menyusul di belakang.
        var lampiran = lampiranPratinjau();
        if (lampiran.muat.length) {
            var dt = new DataTransfer();
            lampiran.muat.forEach(function (file) { dt.items.add(file); });
            var input = document.createElement('input');
            input.type = 'file';
            input.name = 'lampiran[]';
            input.multiple = true;
            input.files = dt.files;
            $f.append(input);
        }
        if (lampiran.lewat.length) {
            pesan('warning', 'Some attachments are not in the preview',
                'These files are too large to include in the preview, but they will still be'
                + ' uploaded when the invoice is saved:<ul class="ci-swal-list"><li>'
                + lampiran.lewat.map(function (n) { return teks(n); }).join('</li><li>')
                + '</li></ul>');
        }

        $f.appendTo('body').trigger('submit').remove();
    }

    /** Buka modal pratinjau - mulai dari cetakan invoice. */
    function pratinjauPdf(selesai) {
        var knitting = inv.pc === 'NAK';
        $('#ci-pdf-pilih').prop('hidden', !knitting)
            .find('.btn').removeClass('is-aktif').first().addClass('is-aktif');

        // Modal dibuka dulu supaya iframe-nya sudah ada waktu form dikirim.
        $('#ci-modal-pdf').modal('show');
        if (selesai) { $('#ci-modal-pdf').one('hidden.bs.modal', selesai); }
        kirimPratinjau('');
    }

    /** Jenis cetakan yang sedang ditampilkan di modal pratinjau. */
    function jenisPratinjau() {
        return String($('#ci-pdf-pilih .btn.is-aktif').data('jenis') || '');
    }

    function tampilkanKonfirmasi(ringkas) {
        Swal.fire({
            icon: 'question',
            title: inv.lanjut
                ? (UBAH ? 'Resume saving the changes?' : 'Resume saving this invoice?')
                : (UBAH ? 'Save the changes?' : 'Save this invoice?'),
            html: ringkas,
            width: 560,
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: inv.lanjut
                ? '<i class="fa fa-redo"></i> Yes, continue'
                : (UBAH ? '<i class="fa fa-save"></i> Yes, save changes'
                        : '<i class="fa fa-save"></i> Yes, save it'),
            denyButtonText: '<i class="fa fa-file-pdf"></i> Preview PDF',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            focusCancel: true,
            customClass: { popup: 'ci-swal', actions: 'ci-swal-aksi', denyButton: 'ci-swal-deny' }
        }).then(function (pilih) {
            if (!pilih) { return; }
            if (pilih.isConfirmed) { simpan(); return; }
            // Pratinjau dibuka di tab baru, dialognya ditampilkan lagi supaya
            // user tinggal menekan Save kalau cetakannya sudah cocok.
            if (pilih.isDenied) {
                pratinjauPdf(function () { tampilkanKonfirmasi(ringkas); });
            }
        });
    }

    /** Baris detail versi tbl_invoice_detail - sama untuk NAG & NAK. */
    function payloadDetail() {
        var idInv = $('#ci-id-inv').val();
        return inv.baris.map(function (r) {
            return {
                id_book_invoice: idInv,
                id_bppb: r.id_bppb,
                so_number: r.no_so,
                bppb_number: r.sj,
                sj_date: r.bppbdate,
                shipp_number: r.shipping_number,
                ws: r.ws,
                styleno: r.styleno,
                product_group: r.product_group,
                product_item: r.product_item,
                color: r.color,
                size: r.size,
                curr: r.curr,
                uom: r.uom,
                qty: r.qty,
                unit_price: r.unit_price,
                disc: r.disc,
                total_price: r.total_price
            };
        });
    }

    /**
     * Baris SJ untuk dituliskan ke Invoice EXIM.
     *
     * Bentuknya sendiri, bukan payloadDetail(): tabel Invoice EXIM butuh id_so
     * & id baris SJ-nya, sedangkan bentuk payloadDetail() sudah dipakai apa
     * adanya untuk tbl_invoice_detail - menambah kolom di sana berisiko.
     */
    function payloadExim() {
        return inv.baris.map(function (r) {
            return {
                id_bppb: r.id_bppb,
                id_so: r.id_so,
                no_so: r.no_so,
                sj: r.sj,
                bppbdate: r.bppbdate,
                shipping_number: r.shipping_number,
                ws: r.ws,
                styleno: r.styleno,
                product_group: r.product_group,
                product_item: r.product_item,
                color: r.color,
                size: r.size,
                curr: r.curr,
                uom: r.uom,
                qty: r.qty,
                unit_price: r.unit_price,
                disc: r.disc,
                total_price: r.total_price
            };
        });
    }

    /** Tambahan khusus knitting: tbl_invoice_detail_knitting.
     *  Kolom shipment diisi angka yang sama - memang sudah satu nilai. */
    function payloadDetailKnitting() {
        return payloadDetail().map(function (d, i) {
            var r = inv.baris[i];
            return $.extend({}, d, {
                uom_ship: r.uom,
                qty_ship: r.qty,
                unit_price_ship: r.unit_price,
                total_price_ship: r.total_price,
                po_konsumen: r.po_konsumen || '',
                id_konsumen: r.kode_konsumen || ''
            });
        });
    }

    function payloadPot(pakaiOther) {
        // Kotak rekap di layar memakai pemisah ribuan ("1,040,066.25") supaya
        // enak dibaca, tapi kolomnya DECIMAL: koma membuat MySQL memotong
        // nilainya jadi 1. Yang dikirim harus angka polos - sama seperti layar
        // lama, yang mengisi kotaknya dengan toFixed(2) tanpa pemisah.
        var polos = function (sel) { return nilai($(sel).val()).toFixed(2); };
        var d = {
            id_book_invoice: $('#ci-id-inv').val(),
            total: polos('#ci-total'),
            discount: polos('#ci-discount'),
            dp: polos('#ci-dp'),
            retur: polos('#ci-retur'),
            twot: polos('#ci-twot'),
            vat: polos('#ci-vat'),
            grand_total: polos('#ci-grand')
        };
        // Kolomnya masih ada di tbl_invoice_pot_knitting, tapi Other Charge
        // sudah tidak dipakai - diisi 0 supaya tidak jadi teks kosong.
        if (pakaiOther) { d.total_other = '0.00'; }
        return d;
    }

    function kirim(rute, data, tipeData) {
        return $.ajax({
            url: URL_AR + rute,
            type: 'POST',
            data: data,
            dataType: tipeData || 'JSON',
            timeout: BATAS_WAKTU
        });
    }

    /** Jalankan pekerjaan berkelompok - paling banyak "sekaligus" berjalan
     *  bersamaan. Dipakai menandai SJ: kalau barisnya banyak, menembak semua
     *  permintaan sekaligus malah bikin server antre dan Save terasa lama. */
    function beriurutan(daftar, sekaligus) {
        var hasil = $.Deferred(), jalan = 0, i = 0, gagal = null;
        if (!daftar.length) { return hasil.resolve().promise(); }
        (function isi() {
            while (!gagal && jalan < sekaligus && i < daftar.length) {
                jalan++;
                daftar[i++]().done(function () {
                    jalan--;
                    if (gagal) { return; }
                    if (i >= daftar.length && jalan === 0) { hasil.resolve(); } else { isi(); }
                }).fail(function (x) {
                    jalan--;
                    if (!gagal) { gagal = x; hasil.reject(x); }
                });
            }
        })();
        return hasil.promise();
    }

    /** Ganti keterangan di dialog "Saving..." - user tahu sedang di langkah
     *  mana, dan langkah yang agak lama tidak terlihat seperti macet. */
    function tahapSimpan(nomor, total, teksnya) {
        var el = document.getElementById('ci-simpan-tahap');
        if (el) { el.textContent = 'Step ' + nomor + ' of ' + total + ' \u00b7 ' + teksnya; }
    }

    /* ============== 5b. Shipment Details (khusus Invoice Export) ==========
     * Isinya milik Invoice EXIM Export - tabel yang dibaca & ditulis sama
     * persis (tbl_book_invoice_exim_export_ship). Tim AR boleh melengkapinya
     * dari sini supaya tidak perlu bolak-balik ke menu EXIM, dan apa pun yang
     * diubah di sini langsung terbaca di sana (termasuk cetakannya).
     *
     * Bagiannya disembunyikan kalau invoicenya bukan Export.
     * ===================================================================== */

    // Kotak isian di modal <-> kunci datanya. Satu daftar saja, dipakai dua
    // arah, jadi tidak mungkin ada kolom yang terisi waktu dibuka tapi hilang
    // waktu disimpan. Urutannya sama dengan menu Invoice EXIM.
    var PETA_KIRIM = {
        '#ci-k-dest': 'dest_purchase', '#ci-k-style': 'style_no', '#ci-k-brand': 'brand',
        '#ci-k-chanel': 'chanel_description', '#ci-k-curr': 'currency',
        '#ci-k-payterm': 'payment_term', '#ci-k-findest': 'final_destination',
        '#ci-k-origin': 'country_origin', '#ci-k-mode': 'ship_mode',
        '#ci-k-sale': 'term_of_sale', '#ci-k-transfer': 'transfer_point',
        '#ci-k-port': 'port_of_loading', '#ci-k-gross': 'total_gross_weight',
        '#ci-k-net': 'total_net_weight', '#ci-k-netnet': 'total_net_net_weight',
        '#ci-k-carton': 'total_carton', '#ci-k-desc': 'product_description'
    };

    var kirimSedang = -1;   // baris yang sedang dibuka di modal, -1 = baris baru

    /** Isian bawaan baris baru - sama dengan yang dipakai menu Invoice EXIM. */
    function kirimKosong() {
        return {
            dest_purchase: '', style_no: '', brand: '', chanel_description: '',
            currency: 'USD', payment_term: '',
            final_destination: '', country_origin: 'ID', ship_mode: 'OCEAN',
            term_of_sale: '', transfer_point: 'JAKARTA,ID', port_of_loading: 'JAKARTA,ID',
            total_gross_weight: '', total_net_weight: '', total_net_net_weight: '',
            total_carton: '', product_description: ''
        };
    }

    /** Susun ulang pilihan Brand, nilainya dipertahankan. */
    function isiPilihanMerek(nilai) {
        var $s = $('#ci-k-brand');
        var isi = $.trim(String(nilai === null || nilai === undefined ? '' : nilai));
        var daftar = (inv.kirimMerek || []).slice();
        // Brand tersimpan yang tidak ada di daftar tetap dipakai, supaya
        // membuka invoice lama tidak diam-diam mengosongkannya.
        if (isi !== '' && daftar.indexOf(isi) < 0) { daftar.unshift(isi); }
        $s.empty().append($('<option>').val('').text(''));
        daftar.forEach(function (m) { $s.append($('<option>').val(m).text(m)); });
        $s.val(isi).trigger('change.select2');
    }

    /** Ambil Shipment Details booking ini. Dipanggil tiap booking berganti. */
    function muatShipment() {
        var id = parseInt($('#ci-id-inv').val(), 10) || 0;
        inv.kirim = [];
        inv.kirimMerek = [];
        inv.kirimExport = false;
        if (!id) { gambarKirim(); return; }

        ambilJson('shipment_export_json/' + ruasUrl(id) + '/?id_customer='
                  + ruasUrl($('#ci-id-cust').val()))
            .done(function (d) {
                if (!d || !d.status || !d.export) { gambarKirim(); return; }
                inv.kirimExport = true;
                inv.kirimMerek = d.brand || [];
                inv.kirim = (d.baris || []).map(function (r) {
                    return $.extend(kirimKosong(), r);
                });
                gambarKirim();
            })
            .fail(function () {
                // Gagal memuat tidak boleh mengunci layar - invoice AR-nya
                // tetap bisa disimpan, Shipment Details-nya saja yang absen.
                gambarKirim();
            });
    }

    function gambarKirim() {
        $('#ci-kirim-card').prop('hidden', !inv.kirimExport);
        if (!inv.kirimExport) { return; }

        var $b = $('#ci-kirim-tbody').empty();
        $('#ci-kirim-kosongkan').prop('disabled', DOK_SAJA || !inv.kirim.length);
        $('#ci-kirim-tambah').prop('disabled', DOK_SAJA);

        if (!inv.kirim.length) {
            kosongkanTabel($b, 13, 'fa-ship',
                'No shipment row yet. Use “Add Data” to add one.');
            return;
        }

        $b.html(inv.kirim.map(function (r, i) {
            return '<tr>'
                + '<td class="dn-tengah"><b>' + (i + 1) + '</b></td>'
                + '<td>' + teks(r.dest_purchase) + '</td>'
                + '<td>' + teks(r.style_no) + '</td>'
                + '<td>' + teks(r.brand) + '</td>'
                + '<td>' + teks(r.currency) + '</td>'
                + '<td>' + teks(r.final_destination) + '</td>'
                + '<td>' + teks(r.ship_mode) + '</td>'
                + '<td class="ci-angka">' + angka(r.total_gross_weight) + '</td>'
                + '<td class="ci-angka">' + angka(r.total_net_weight) + '</td>'
                + '<td class="ci-angka">' + angka(r.total_net_net_weight) + '</td>'
                + '<td class="ci-angka">' + angka(r.total_carton) + '</td>'
                + '<td class="ci-kirim-desc">' + teks(r.product_description) + '</td>'
                + '<td class="dn-tengah">'
                + '  <button type="button" class="btn btn-primary btn-sm ci-kirim-ubah"'
                + '          data-i="' + i + '"' + (DOK_SAJA ? ' disabled' : '')
                + '          title="Edit"><i class="fas fa-pen"></i></button>'
                + '  <button type="button" class="btn btn-danger btn-sm ci-kirim-buang"'
                + '          data-i="' + i + '"' + (DOK_SAJA ? ' disabled' : '')
                + '          title="Remove"><i class="fas fa-times"></i></button>'
                + '</td></tr>';
        }).join(''));
    }

    function bukaKirim(i) {
        kirimSedang = i;
        var r = (i >= 0 && inv.kirim[i]) ? inv.kirim[i] : kirimKosong();
        // Pilihan brandnya disusun lebih dulu - kalau optionnya belum ada,
        // .val() di bawah ini tidak akan kena.
        isiPilihanMerek(r.brand);
        Object.keys(PETA_KIRIM).forEach(function (sel) {
            $(sel).val(r[PETA_KIRIM[sel]]);
        });
        $('#ci-k-brand').trigger('change.select2');
        $('#ci-kirim-judul').text(i >= 0 ? 'Edit Shipment ' + (i + 1) : 'Add Shipment');
        $('#ci-modal-kirim').modal('show');
    }

    $(function () {
        // Brand: pilihan dari act_costing milik customer booking ini, tapi
        // masih boleh diketik sendiri kalau brandnya belum terdaftar -
        // invoice tidak boleh tertahan cuma karena master datanya kurang.
        $('#ci-k-brand').select2({
            theme: 'bootstrap4', width: '100%', tags: true,
            placeholder: 'Select or type a brand',
            dropdownParent: $('#ci-modal-kirim')
        });

        $('#ci-kirim-tambah').on('click', function () { bukaKirim(-1); });
        $('#ci-kirim-tbody').on('click', '.ci-kirim-ubah', function () {
            bukaKirim(parseInt($(this).data('i'), 10));
        });
        $('#ci-kirim-tbody').on('click', '.ci-kirim-buang', function () {
            inv.kirim.splice(parseInt($(this).data('i'), 10), 1);
            gambarKirim();
        });

        $('#ci-kirim-kosongkan').on('click', function () {
            if (!inv.kirim.length) { return; }
            Swal.fire({
                icon: 'warning',
                title: 'Clear all shipment rows?',
                html: 'All <b>' + inv.kirim.length + '</b> shipment row'
                    + (inv.kirim.length > 1 ? 's' : '') + ' will be removed. '
                    + 'Nothing is saved until you press Save.',
                showCancelButton: true,
                confirmButtonText: 'Clear All',
                cancelButtonText: 'Cancel',
                customClass: { popup: 'ci-swal' }
            }).then(function (h) {
                if (!h.isConfirmed) { return; }
                inv.kirim = [];
                gambarKirim();
            });
        });

        $('#ci-k-simpan').on('click', function () {
            var r = (kirimSedang >= 0 && inv.kirim[kirimSedang]) ? inv.kirim[kirimSedang] : kirimKosong();
            Object.keys(PETA_KIRIM).forEach(function (sel) {
                r[PETA_KIRIM[sel]] = $(sel).val();
            });
            if (kirimSedang < 0) { inv.kirim.push(r); }
            gambarKirim();
            $('#ci-modal-kirim').modal('hide');
        });
    });

    /** Baris yang dikirim ke server - kuncinya sama dengan kolom tabelnya. */
    function payloadKirim() {
        return inv.kirim.map(function (r) {
            var out = {};
            Object.keys(PETA_KIRIM).forEach(function (sel) {
                out[PETA_KIRIM[sel]] = r[PETA_KIRIM[sel]] === undefined
                    ? '' : r[PETA_KIRIM[sel]];
            });
            return out;
        });
    }

    /**
     * Rantai simpan dipecah jadi langkah bernama. Namanya ikut tampil di
     * dialog - waktu berjalan ("Step 3 of 5") maupun waktu gagal, jadi jelas
     * bagian mana yang bermasalah dan bagian mana yang sudah tersimpan.
     */
    function langkahSimpan(idInv, knitting) {
        var jml = inv.baris.length;
        var L = [
            { nama: 'Preparing account & rate', jalan: ambilCoaDanRate },
            { nama: 'Saving invoice header', jalan: function () {
                // Endpoint JSON khusus layar ini. Yang ditulis ke database sama
                // persis dengan update_invoice_header/ yang dipakai layar lama -
                // bedanya yang lama membalas redirect ke halaman createinvoice,
                // jadi Save ikut menunggu halaman itu selesai dirender.
                // Mode edit memakai endpoint sendiri: status & tanggal invoice
                // tidak disentuh, dan log-nya dicatat sebagai "Edit invoice".
                return kirim(UBAH ? 'update_invoice_header_edit_json/' : 'update_invoice_header_json/', {
                    id_inv: idInv,
                    inv_number1: $('#ci-inv-number').val(),
                    pph: $('#ci-pph').val(),
                    id_pph: $('#ci-id-pph').val(),
                    id_top: $('#ci-id-top').val(),
                    id_bank: $('#ci-bank').val(),
                    type_so: $('#ci-type-so').val(),
                    no_coa_deb: $('#ci-coa-no').val(),
                    nama_coa_deb: $('#ci-coa-nama').val()
                });
            } },
            { nama: 'Saving ' + jml + ' detail row' + (jml > 1 ? 's' : ''), jalan: function () {
                return kirim(UBAH ? 'edit_simpan_detail_json/' : 'simpan_invoice_detail/',
                    { data_table: payloadDetail() });
            } }
        ];

        // Mode edit: isi lamanya diarsipkan, SJ-nya dibebaskan, lalu barisnya
        // dihapus - baru ditulis ulang. Harus sebelum baris barunya masuk.
        if (UBAH) {
            L.splice(2, 0, { nama: 'Clearing the previous rows', jalan: function () {
                return kirim('edit_hapus_detail_json/', { id_book_invoice: idInv });
            } });
        }

        if (knitting) {
            L.push({ nama: 'Saving knitting detail rows', jalan: function () {
                return kirim('simpan_invoice_detail_knitting/', { data_table: payloadDetailKnitting() });
            } });
        }

        L.push({ nama: 'Saving invoice summary', jalan: function () {
            return kirim('simpan_invoice_pot/', { data_table: [payloadPot(false)] });
        } });

        if (knitting) {
            L.push({ nama: 'Saving knitting summary', jalan: function () {
                return kirim('simpan_invoice_pot_knitting/', { data_table: [payloadPot(true)] });
            } });
        }

        L.push({ nama: 'Marking ' + jml + ' SJ row' + (jml > 1 ? 's' : ''), jalan: function () {
            // Penanda "sudah di-invoice" di sumber SJ-nya. Dikirim paling
            // banyak 4 sekaligus supaya server tidak kebanjiran waktu
            // barisnya banyak.
            return beriurutan(inv.baris.map(function (r) {
                return function () {
                    return kirim('update_status_bppb/', {
                        id_bppb: r.id_bppb,
                        curr: r.curr,
                        no_invoice: idInv
                    }, 'text');
                };
            }), 4);
        } });

        // Booking EXIM yang SJ-nya belum terbit: SJ yang baru dipilih di sini
        // dituliskan ke Invoice EXIM-nya - qty & warna di sana ikut menyesuaikan.
        // Ditaruh paling akhir: kalau langkah ini gagal, invoice AR-nya sudah
        // tersimpan dan yang perlu diulang cuma langkah ini.
        if (inv.sjBelum) {
            L.push({ nama: 'Updating Invoice EXIM', jalan: function () {
                return kirim('perbarui_exim_dari_sj/', {
                    id_book_invoice: idInv,
                    data_table: payloadExim(),
                    pot: payloadPot(false)
                });
            } });
        }

        // Shipment Details ikut tersimpan - tabelnya milik Invoice EXIM
        // Export, jadi perubahan dari sini langsung terbaca di menu EXIM
        // maupun cetakannya. Dilewati kalau invoicenya bukan Export.
        if (inv.kirimExport) {
            L.push({ nama: 'Saving shipment details', jalan: function () {
                return kirim('simpan_shipment_export_json/', {
                    id_book_invoice: idInv,
                    data_table: payloadKirim()
                });
            } });
        }

        L.push({ nama: 'Clearing temporary rows', jalan: function () {
            return $.get(URL_AR + 'delete_invoice_detail_temporary/');
        } });

        return L;
    }

    /** Jalankan langkah ke-"mulai" sampai habis, satu per satu. */
    function jalankanLangkah(L, mulai) {
        var hasil = $.Deferred();
        (function lanjut(i) {
            if (i >= L.length) { hasil.resolve(); return; }
            inv.lanjut = i;                       // dipakai kalau nanti diulang
            tahapSimpan(i + 1, L.length, L[i].nama);
            $.when(L[i].jalan())
                .done(function () { lanjut(i + 1); })
                .fail(function (xhr) { hasil.reject({ indeks: i, nama: L[i].nama, xhr: xhr }); });
        })(mulai);
        return hasil.promise();
    }

    /**
     * Konfirmasi untuk invoice yang sudah FIRST APPROVED: yang disimpan cuma
     * supporting document-nya. Kalau tidak ada berkas baru, tidak ada yang
     * perlu dikirim.
     */
    function konfirmasiDokSaja() {
        var baru = dok.filter(function (d) { return !d.tersimpan; }).length;
        if (!baru) {
            pesan('info', 'Nothing to upload',
                'Choose the supporting document you want to add first.');
            return;
        }

        var lanjut = function () { simpanDokSaja(); };
        if (typeof Swal === 'undefined') {
            lanjut();
            return;
        }
        Swal.fire({
            icon: 'question',
            title: 'Save supporting document?',
            html: '<b>' + baru + '</b> file' + (baru > 1 ? 's' : '') + ' will be attached to invoice <b>'
                + teks($('#ci-inv-number').val()) + '</b>.'
                + '<div class="ci-swal-catatan">The invoice itself is not changed - it is already'
                + ' first approved.</div>',
            width: 520,
            showCancelButton: true,
            confirmButtonText: 'Yes, upload',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: { popup: 'ci-swal' }
        }).then(function (r) {
            if (r && r.isConfirmed) { lanjut(); }
        });
    }

    /** Unggah lampiran saja - isi invoice-nya tidak disentuh. */
    function simpanDokSaja() {
        var $tb = $('#ci-btn-simpan').prop('disabled', true);
        var idInv = $('#ci-id-inv').val() || ID_UBAH;

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Uploading...',
                html: 'The supporting document is being attached to invoice <b>'
                    + teks($('#ci-inv-number').val()) + '</b>.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                customClass: { popup: 'ci-swal' },
                didOpen: function () { Swal.showLoading(); }
            });
        }

        docUpload(idInv, function (info) {
            $tb.prop('disabled', false);
            selesaiSimpan(idInv, false, info);
        });
    }

    function simpan() {
        var $tb = $('#ci-btn-simpan').prop('disabled', true);
        var idInv = $('#ci-id-inv').val();
        var knitting = inv.pc === 'NAK';
        var L = langkahSimpan(idInv, knitting);
        var mulai = Math.min(Math.max(inv.lanjut || 0, 0), L.length - 1);

        // Layarnya dikunci selama rantai simpan berjalan supaya tidak ada yang
        // diubah (atau Save ditekan lagi) di tengah jalan.
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: mulai ? 'Resuming...' : (UBAH ? 'Saving changes...' : 'Saving...'),
                html: 'Invoice <b>' + teks($('#ci-inv-number').val()) + '</b> is being saved.'
                    + '<div id="ci-simpan-tahap" class="ci-swal-tahap"></div>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                customClass: { popup: 'ci-swal' },
                didOpen: function () { Swal.showLoading(); }
            });
        }

        jalankanLangkah(L, mulai)
            .done(function () {
                inv.lanjut = 0;
                // Lampiran dikirim setelah invoice-nya tersimpan - butuh id
                // invoice final & statusnya sudah POST. Gagalnya lampiran
                // tidak membatalkan invoice, cuma diberitahukan di pesan.
                docUpload(idInv, function (info) { selesaiSimpan(idInv, knitting, info); });
            })
            .fail(function (g) {
                $tb.prop('disabled', false);
                gagalSimpan(g, L.length);
            });
    }

    /**
     * Dialog gagal - langsung menawarkan mengulang. Yang diulang cuma langkah
     * yang gagal dan sesudahnya; langkah yang sudah lewat tidak dijalankan
     * lagi supaya barisnya tidak tersimpan dua kali.
     */
    function gagalSimpan(g, total) {
        var nomor = g.indeks + 1;
        var http = (g.xhr && g.xhr.statusText === 'timeout')
            ? ' (timed out)'
            : ((g.xhr && g.xhr.status) ? ' (HTTP ' + g.xhr.status + ')' : '');
        var isi = 'The invoice was not saved completely.'
            + '<div class="ci-swal-ringkas">'
            + '<div><span>Stopped at</span><b>Step ' + nomor + ' of ' + total + '</b></div>'
            + '<div><span>Failed step</span><b>' + teks(g.nama) + http + '</b></div>'
            + '</div>'
            + '<p class="ci-swal-catatan">Try Again continues from this step - the steps that already'
            + ' went through are not repeated, so nothing is saved twice. If you close this, pressing'
            + ' Save again also continues from the same step.</p>';

        if (typeof Swal === 'undefined') {
            alert('Save failed at step ' + nomor + ' of ' + total + ': ' + g.nama
                + '. Press Save again to continue from this step.');
            return;
        }
        Swal.fire({
            icon: 'error',
            title: 'Save failed',
            html: isi,
            width: 520,
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-redo"></i> Try Again',
            cancelButtonText: 'Close',
            reverseButtons: true,
            allowOutsideClick: false,
            customClass: { popup: 'ci-swal' }
        }).then(function (pilih) {
            if (pilih && pilih.isConfirmed) { simpan(); }
        });
    }

    /** Buka cetakan PDF invoice (desain baru). Knitting punya cetakan
     *  tambahan dengan format sendiri, jadi dua-duanya dibuka. */
    function cetakInvoice(idInv, knitting) {
        window.open(URL_AR + 'report_invoice_v2/' + idInv + '/');
        if (knitting) { window.open(URL_AR + 'print_invoice_knitting_v2/' + idInv + '/'); }
    }

    /**
     * Invoice sudah tersimpan. Dulu cetakannya langsung dibuka sendiri;
     * sekarang user yang memilih langkah berikutnya - cetak, buat invoice
     * lagi, atau kembali ke daftar. Sesudah mencetak dialognya muncul lagi,
     * jadi masih bisa memilih yang lain.
     * info.html (kalau ada) berisi hasil upload lampiran.
     */
    function selesaiSimpan(idInv, knitting, info) {
        var nomor = teks($('#ci-inv-number').val());

        if (typeof Swal === 'undefined') {
            window.location.href = URL_LIST;
            return;
        }

        Swal.fire({
            icon: 'success',
            title: DOK_SAJA ? 'Document saved' : (UBAH ? 'Changes saved' : 'Invoice saved'),
            html: 'Invoice <b>' + nomor + '</b> '
                + (DOK_SAJA
                    ? 'now has the supporting document attached.'
                    : (UBAH ? 'has been updated.' : 'is now POST.'))
                + (info && info.html ? '<div class="ci-swal-kabar">' + info.html + '</div>' : ''),
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: '<i class="fa fa-print"></i> Print Invoice',
            denyButtonText: (DOK_SAJA || UBAH)
                ? '<i class="fa fa-pen"></i> ' + (DOK_SAJA ? 'Add More' : 'Keep Editing')
                : '<i class="fa fa-plus"></i> Create Another',
            cancelButtonText: '<i class="fa fa-list"></i> Back to List',
            reverseButtons: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            width: 560,
            customClass: { popup: 'ci-swal', actions: 'ci-swal-aksi', denyButton: 'ci-swal-deny' }
        }).then(function (pilih) {
            if (!pilih) { return; }
            if (pilih.isConfirmed) {
                cetakInvoice(idInv, knitting);
                // Kabar lampiran cukup sekali - dialog berikutnya tanpa itu.
                selesaiSimpan(idInv, knitting, null);
                return;
            }
            if (pilih.isDenied) {
                // Mode edit: tetap di layar ini, invoice-nya dimuat ulang supaya
                // yang terlihat = yang tersimpan.
                window.location.href = UBAH
                    ? (URL_AR + 'edit_invoice_v2/' + idInv)
                    : (URL_AR + 'create_invoice');
                return;
            }
            window.location.href = URL_LIST;
        });
    }

    /* ==================== 6. Supporting document ========================
     * Bentuknya sama dengan Debit Note: tidak wajib, bisa lebih dari 1 file,
     * hanya PDF & gambar (semuanya bisa dibuka browser). File ditahan dulu di
     * browser - bisa dibuka lewat penampil - lalu dikirim per potongan
     * DOC_CHUNK byte ke upload_inv_doc/ SETELAH invoice tersimpan (butuh id
     * invoice final). Gagalnya lampiran tidak membatalkan invoice.
     * ------------------------------------------------------------------ */
    var DOC_EXT   = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
    var DOC_IKON  = { pdf: 'fa-file-pdf', img: 'fa-file-image' };
    var DOC_CHUNK = typeof CI_DOC_CHUNK !== 'undefined' ? CI_DOC_CHUNK : 1048576;
    var dok = [];          // { file: File, url: blob URL untuk preview }
    var dokAktif = -1;     // yang sedang dilihat di penampil (index di dok)

    function docExt(nama) {
        var i = String(nama).lastIndexOf('.');
        return i > -1 ? String(nama).slice(i + 1).toLowerCase() : '';
    }
    function docJenis(nama) {
        return docExt(nama) === 'pdf' ? 'pdf' : 'img';
    }
    function docUkuran(byte) {
        if (byte < 1024) { return byte + ' B'; }
        if (byte < 1024 * 1024) { return Math.round(byte / 1024) + ' KB'; }
        return (byte / 1024 / 1024).toFixed(1) + ' MB';
    }

    function docTambah(files) {
        var ditolak = [];
        Array.prototype.forEach.call(files || [], function (f) {
            if (DOC_EXT.indexOf(docExt(f.name)) === -1) { ditolak.push(f.name + ' - file type not allowed'); return; }
            if (!f.size) { ditolak.push(f.name + ' - file is empty'); return; }
            var sudahAda = dok.some(function (d) {
                return d.file.name === f.name && d.file.size === f.size && d.file.lastModified === f.lastModified;
            });
            if (!sudahAda) { dok.push({ file: f, url: URL.createObjectURL(f) }); }
        });
        docRender();

        if (ditolak.length) {
            pesan('warning', 'Some files were skipped',
                '<ul class="ci-swal-list"><li>' + ditolak.map(function (t) { return teks(t); }).join('</li><li>') + '</li></ul>'
                + '<div class="mt-2" style="font-size:12.5px;color:#64748b;">Only PDF and image files (JPG, PNG, GIF, WEBP) are allowed.</div>');
        }
    }

    function docHapus(i) {
        if (!dok[i]) { return; }
        var d = dok[i];
        // Lampiran yang sudah tersimpan (mode edit) ikut dihapus di server -
        // kalau gagal, barisnya dikembalikan supaya layar tidak berbohong.
        if (d.tersimpan && d.id_doc) {
            dok.splice(i, 1);
            docRender();
            $.ajax({ url: URL_AR + 'hapus_inv_doc/', type: 'POST',
                data: { id: d.id_doc }, dataType: 'JSON' })
                .done(function (res) {
                    if (res && res.status) { return; }
                    dok.splice(i, 0, d);
                    docRender();
                    pesan('error', 'Document was not removed',
                        (res && res.message) || 'The server refused the request.');
                })
                .fail(function (xhr) {
                    dok.splice(i, 0, d);
                    docRender();
                    pesan('error', 'Document was not removed', sebabGagal(xhr));
                });
            return;
        }
        URL.revokeObjectURL(d.url);
        dok.splice(i, 1);
        docRender();
    }

    function docRender() {
        var list = document.getElementById('ci-doc-list');
        if (!list) { return; }
        list.innerHTML = '';
        dok.forEach(function (d, i) {
            var jenis = docJenis(d.file.name);
            var li = document.createElement('li');
            li.className = 'ci-doc-item';
            li.innerHTML = '<i class="fas ' + DOC_IKON[jenis] + ' ci-doc-ikon is-' + jenis + '"></i>'
                + '<span class="ci-doc-nama"></span><span class="ci-doc-ukuran"></span>'
                + '<span class="ci-doc-aksi">'
                +   '<button type="button" class="btn ci-doc-lihat" title="View"><i class="fas fa-eye"></i></button>'
                +   '<button type="button" class="btn ci-doc-hapus" title="Remove"><i class="fas fa-times"></i></button>'
                + '</span>';
            // Nama file dari user - lewat textContent, bukan innerHTML.
            var nama = li.querySelector('.ci-doc-nama');
            nama.textContent = d.file.name;
            nama.title = d.file.name + ' - click to view';
            nama.addEventListener('click', function () { docLihat(i); });
            li.querySelector('.ci-doc-ukuran').textContent = docUkuran(d.file.size);
            li.querySelector('.ci-doc-lihat').addEventListener('click', function () { docLihat(i); });
            li.querySelector('.ci-doc-hapus').addEventListener('click', function () { docHapus(i); });
            list.appendChild(li);
        });
        $('#ci-doc-jumlah').text(dok.length ? dok.length + ' file' + (dok.length > 1 ? 's' : '') : '');
    }

    /* ---- penampil dokumen ---- */
    function docLihat(i) {
        if (!dok[i]) { return; }
        dokAktif = i;
        docViewer();
        if (!$('#ci-modal-doc').hasClass('show')) { $('#ci-modal-doc').modal('show'); }
    }

    function docViewer() {
        var i = dokAktif, n = dok.length, d = dok[i];
        if (!d) { return; }
        var jenis = docJenis(d.file.name);

        document.getElementById('ci-doc-judul').textContent = d.file.name;
        document.getElementById('ci-doc-judul-ikon').className = 'fas ' + DOC_IKON[jenis];
        document.getElementById('ci-doc-meta').textContent =
            (jenis === 'pdf' ? 'PDF document' : 'Image') + ' · ' + docUkuran(d.file.size);
        document.getElementById('ci-doc-posisi').textContent = (i + 1) + ' / ' + n;
        document.getElementById('ci-doc-buka').href = d.url;
        document.getElementById('ci-doc-prev').disabled = (i === 0);
        document.getElementById('ci-doc-next').disabled = (i === n - 1);

        // Preview - gambar bisa diklik untuk ukuran asli.
        var isi = document.getElementById('ci-doc-isi');
        var el = document.createElement(jenis === 'pdf' ? 'iframe' : 'img');
        el.src = d.url;
        el.title = el.alt = d.file.name;
        if (jenis === 'img') { el.addEventListener('click', function () { isi.classList.toggle('is-zoom'); }); }
        isi.classList.remove('is-zoom');
        isi.innerHTML = '';
        isi.appendChild(el);

        // Daftar dokumen di kiri
        var side = document.getElementById('ci-doc-side-list');
        side.innerHTML = '';
        dok.forEach(function (x, j) {
            var jx = docJenis(x.file.name);
            var li = document.createElement('li');
            if (j === i) { li.className = 'is-aktif'; }
            li.innerHTML = '<span class="ci-doc-thumb is-' + jx + '"></span>'
                + '<span class="ci-doc-side-info"><span class="ci-doc-side-nama"></span><span class="ci-doc-side-ukuran"></span></span>';
            var thumb = li.querySelector('.ci-doc-thumb');
            if (jx === 'img') {
                var im = document.createElement('img');
                im.src = x.url;
                im.alt = '';
                thumb.appendChild(im);
            } else {
                thumb.innerHTML = '<i class="fas ' + DOC_IKON[jx] + '"></i>';
            }
            li.querySelector('.ci-doc-side-nama').textContent = x.file.name;
            li.querySelector('.ci-doc-side-nama').title = x.file.name;
            li.querySelector('.ci-doc-side-ukuran').textContent = docUkuran(x.file.size);
            li.addEventListener('click', function () { docLihat(j); });
            side.appendChild(li);
        });
        document.getElementById('ci-doc-side-jumlah').textContent = '(' + n + ')';
        var aktif = side.querySelector('.is-aktif');
        if (aktif && aktif.scrollIntoView) { aktif.scrollIntoView({ block: 'nearest' }); }
    }

    function docGeser(arah) {
        var j = dokAktif + arah;
        if (j >= 0 && j < dok.length) { docLihat(j); }
    }

    /** Buang dokumen yang sedang dilihat, lanjut ke dokumen berikutnya. */
    function docHapusAktif() {
        var i = dokAktif;
        if (!dok[i]) { return; }
        docHapus(i);
        if (!dok.length) { $('#ci-modal-doc').modal('hide'); return; }
        dokAktif = Math.min(i, dok.length - 1);
        docViewer();
    }

    /* ---- upload ---- */
    function docUploadId() {
        var acak = new Uint8Array(16);
        (window.crypto || window.msCrypto).getRandomValues(acak);
        return Array.prototype.map.call(acak, function (b) { return ('0' + b.toString(16)).slice(-2); }).join('');
    }

    /** Kirim 1 file per potongan DOC_CHUNK byte (server menyambungnya).
     *  Potongan yang gagal karena koneksi dicoba ulang sampai 3x dulu. */
    function docKirimFile(idInv, file, progres, beres) {
        var uploadId = docUploadId(), offset = 0, coba = 0;
        (function potongan() {
            var ujung = Math.min(offset + DOC_CHUNK, file.size);
            var fd = new FormData();
            fd.append('id_inv', idInv);
            fd.append('upload_id', uploadId);
            fd.append('nama', file.name);
            fd.append('ukuran', file.size);
            fd.append('offset', offset);
            fd.append('potongan', file.slice(offset, ujung), file.name);
            $.ajax({
                url: URL_AR + 'upload_inv_doc/',
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                dataType: 'JSON'
            }).done(function (res) {
                if (!res || !res.status) { beres(res || { message: 'Upload failed.' }); return; }
                coba = 0;
                offset = res.received || ujung;
                progres(Math.min(offset, file.size) / file.size);
                if (res.done) { beres(null); } else { potongan(); }
            }).fail(function () {
                if (++coba <= 3) { setTimeout(potongan, 1000 * coba); } else { beres({ message: 'Connection error.' }); }
            });
        })();
    }

    /** Upload berurutan per file (gagalnya bisa per file, bisa di-retry).
     *  Invoice-nya sendiri SUDAH tersimpan waktu fungsi ini dipanggil. */
    function docUpload(idInv, selesai, antrian, sudah) {
        // Lampiran yang memang sudah tersimpan (mode edit) tidak diunggah lagi.
        antrian = antrian || dok.filter(function (d) { return !d.tersimpan; });
        sudah = sudah || 0;
        if (!antrian.length) { selesai(); return; }

        var total = antrian.length, i = 0, berhasil = 0, gagal = [], tabelBelumAda = false;

        // Tanpa SweetAlert (mis. di pengujian) uploadnya tetap jalan, cuma
        // tidak ada tampilan progresnya.
        if (typeof Swal === 'undefined') { kirim(); return; }
        Swal.fire({
            title: 'Uploading Documents',
            html: '<span id="ci-upload-progres"></span><div class="ci-upload-bar"><span id="ci-upload-bar"></span></div>',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            customClass: { popup: 'ci-swal' },
            didOpen: function () { Swal.showLoading(); kirim(); }
        });

        function kirim() {
            if (i >= total || tabelBelumAda) { return akhir(); }
            var d = antrian[i];
            var label = 'Uploading ' + (i + 1) + ' of ' + total + ': ' + d.file.name;
            var tampil = function (p) {
                $('#ci-upload-progres').text(label + ' (' + Math.floor(p * 100) + '%)');
                $('#ci-upload-bar').css('width', (p * 100) + '%');
            };
            tampil(0);

            docKirimFile(idInv, d.file, tampil, function (err) {
                if (!err) {
                    berhasil++;
                } else {
                    if (err.code === 'table_missing') { tabelBelumAda = true; }
                    gagal.push({ doc: d, pesan: err.message || 'Upload failed.' });
                }
                i++;
                kirim();
            });
        }

        function akhir() {
            var semua = sudah + berhasil;
            if (tabelBelumAda) {
                selesai({ html: 'Supporting documents were <b>not saved</b> - the document table is not ready yet. Please contact IT.' });
                return;
            }
            if (!gagal.length) {
                selesai({ html: semua + ' supporting document' + (semua > 1 ? 's' : '') + ' uploaded.' });
                return;
            }
            if (typeof Swal === 'undefined') {
                selesai({ html: semua + ' uploaded, ' + gagal.length + ' failed.' });
                return;
            }
            Swal.fire({
                icon: 'warning',
                title: 'Some Documents Failed',
                html: 'The invoice is saved, but ' + gagal.length + ' document' + (gagal.length > 1 ? 's' : '') + ' failed to upload:'
                    + '<ul class="ci-swal-list"><li>'
                    + gagal.map(function (g) { return teks(g.doc.file.name) + ' - ' + teks(g.pesan); }).join('</li><li>')
                    + '</li></ul>',
                showCancelButton: true,
                confirmButtonText: 'Retry Upload',
                cancelButtonText: 'Skip',
                allowOutsideClick: false,
                customClass: { popup: 'ci-swal' }
            }).then(function (r) {
                if (r.isConfirmed) {
                    docUpload(idInv, selesai, gagal.map(function (g) { return g.doc; }), semua);
                } else {
                    selesai({ html: semua + ' supporting document' + (semua === 1 ? '' : 's') + ' uploaded, ' + gagal.length + ' skipped.' });
                }
            });
        }
    }

    /* ============================ pemasangan ============================ */
    $(function () {
        $('.select2bs4').each(function () {
            $(this).select2({ theme: 'bootstrap4', width: '100%' });
        });
        $('#ci-so-buyer').select2({ theme: 'bootstrap4', width: '100%', dropdownParent: $('#ci-modal-so') });
        $('#ci-book-pc').select2({ theme: 'bootstrap4', width: '100%', dropdownParent: $('#ci-modal-book') });

        // ---- booking invoice ----
        $('#ci-btn-book').on('click', function () { $('#ci-modal-book').modal('show'); });
        $('#ci-book-cari').on('click', cariBooking);
        $('#ci-book-body').on('click', '.ci-book-pilih', function () {
            var data = $('#ci-book-body').data('isi') || [];
            var r = data[parseInt($(this).data('i'), 10)];
            if (r) { pakaiBooking(r); }
        });
        // Ganti profit center: daftarnya digambar ulang dari hasil yang sama.
        $('#ci-book-pc').on('change', function () {
            gambarBooking();
            $('#ci-book-filter').trigger('input');
        });
        $('#ci-book-filter').on('input', function () {
            var q = $.trim($(this).val()).toLowerCase();
            $('#ci-book-body tr').each(function () {
                $(this).toggle(!q || $(this).text().toLowerCase().indexOf(q) > -1);
            });
        });

        // ---- term of payment ----
        $('#ci-btn-top').on('click', function () {
            if (!$('#ci-id-cust').val()) {
                pesan('warning', 'Pick a booking invoice first', 'The customer comes from the booking invoice.');
                return;
            }
            cariTop();
            $('#ci-modal-top').modal('show');
        });
        $('#ci-top-body').on('click', '.ci-top-pilih', function () {
            var data = $('#ci-top-body').data('isi') || [];
            var r = data[parseInt($(this).data('i'), 10)];
            if (r) { pakaiTop(r); }
        });

        // ---- shipp (knitting saja) ----
        $('#ci-shipp').on('change', function () {
            var idInv = $('#ci-id-inv').val();
            if (!idInv || inv.pc !== 'NAK') { return; }
            // Nama field-nya sama persis dengan layar knitting lama.
            $.ajax({
                url: URL_AR + 'update_shipp_invoice/',
                type: 'POST',
                data: { id_inv: idInv, shipp: $(this).val() },
                dataType: 'JSON'
            });
        });

        // ---- PPh: id pajaknya ikut pilihan ----
        $('#ci-pph').on('change', function () {
            var v = $(this).find(':selected').data('idtax');
            $('#ci-id-pph').val(v === undefined ? '0' : v);
        });

        // ---- SO & SJ ----
        $('#ci-btn-so').on('click', bukaModalSo);
        $('#ci-so-cari').on('click', cariSo);
        // SO dicentang -> SJ-nya ditambahkan; dilepas -> barisnya dibuang.
        $('#ci-so-body').on('change', '.ci-so-cek', function () {
            var r = soCari[parseInt($(this).data('i'), 10)];
            if (!r) { return; }
            if (this.checked) { cariSj(r.id_so); } else { buangSjSo(r.id_so); }
            $('#ci-so-cek-semua').prop('checked',
                $('#ci-so-body .ci-so-cek').length > 0
                && $('#ci-so-body .ci-so-cek:not(:checked)').length === 0);
        });
        $('#ci-so-cek-semua').on('change', function () {
            var cek = this.checked;
            $('#ci-so-body .ci-so-cek').each(function () {
                if (this.checked !== cek) { $(this).prop('checked', cek).trigger('change'); }
            });
        });
        $('#ci-sj-body').on('change', '.ci-sj-cek', function () {
            var r = sjCari[parseInt($(this).data('i'), 10)];
            if (!r) { return; }
            r._pilih = this.checked;
            $(this).closest('tr').toggleClass('is-pilih', this.checked);
            aturKunciTanggal();
            hitungModal();
        });
        $('#ci-sj-cek-semua').on('change', function () {
            var cek = this.checked;
            // Satu invoice cuma boleh satu tanggal SJ, jadi "centang semua" pun
            // hanya mengambil baris bertanggal yang sedang dipakai. Kalau belum
            // ada yang dipilih, tanggal baris pertama yang tampil yang dipakai.
            var tgl = cek ? tanggalTerpakai() : '';
            if (cek && !tgl) {
                var $awal = $('#ci-sj-body .ci-sj-cek').first();
                var r0 = $awal.length ? sjCari[parseInt($awal.data('i'), 10)] : null;
                tgl = r0 ? tanggalSj(r0) : '';
            }
            $('#ci-sj-body .ci-sj-cek').each(function () {
                var r = sjCari[parseInt($(this).data('i'), 10)];
                var pilih = cek && (!tgl || !r || tanggalSj(r) === tgl);
                if (r) { r._pilih = pilih; }
                $(this).prop('checked', pilih).closest('tr').toggleClass('is-pilih', pilih);
            });
            aturKunciTanggal();
            hitungModal();
        });
        $('#ci-sj-body').on('input', '.ci-sj-disc', function () {
            var r = sjCari[parseInt($(this).data('i'), 10)];
            if (!r) { return; }
            var d = nilai($(this).val());
            r._disc = Math.max(0, Math.min(100, d));
            hitungModal();
        });
        $('#ci-sj-filter').on('input', function () {
            var q = $.trim($(this).val()).toLowerCase();
            if (!q) { gambarSj(sjCari); return; }
            gambarSj(sjCari.filter(function (r) {
                return String(r.sj || '').toLowerCase().indexOf(q) > -1
                    || String(r.shipping_number || '').toLowerCase().indexOf(q) > -1;
            }));
        });
        $('#ci-m-dp, #ci-m-dpcbd, #ci-m-retur').on('input', hitungModal);
        $('#ci-m-vat11').on('change', function () {
            if (this.checked) { $('#ci-m-vat12').prop('checked', false); }
            inv.vat = this.checked ? 0.11 : 0;
            hitungModal();
        });
        $('#ci-m-vat12').on('change', function () {
            if (this.checked) { $('#ci-m-vat11').prop('checked', false); }
            inv.vat = this.checked ? 0.12 : 0;
            hitungModal();
        });
        $('#ci-so-apply').on('click', terapkanSo);

        // ---- tabel detail ----
        $('#ci-tbody').on('click', '.ci-buang', function () {
            inv.baris.splice(parseInt($(this).data('i'), 10), 1);
            gambarBaris();
        });
        $('#ci-btn-kosongkan').on('click', function () {
            if (!inv.baris.length) { return; }
            inv.baris = [];
            gambarBaris();
        });

        // ---- DP / DP-CBD / Return (khusus booking dari EXIM) ----
        $('#ci-dp, #ci-dpcbd, #ci-retur').on('input', function () {
            if (!inv.dariExim) { return; }
            var id = this.id;
            var v = Math.max(0, nilai($(this).val()));
            if (id === 'ci-dp')         { inv.dp = v; }
            else if (id === 'ci-dpcbd') { inv.dpcbd = v; }
            else                          { inv.retur = v; }
            hitungRingkasan();
        }).on('blur', function () {
            // Selesai mengetik: angkanya dirapikan kembali (2 desimal).
            if (inv.dariExim) { hitungRingkasan(); }
        });

        // ---- pratinjau PDF ----
        $('#ci-pdf-tab').on('click', function () { kirimPratinjau(jenisPratinjau(), '_blank'); });
        // Ganti cetakan yang dilihat (invoice / invoice knitting).
        $('#ci-pdf-pilih').on('click', '.btn', function () {
            if ($(this).hasClass('is-aktif')) { return; }
            $('#ci-pdf-pilih .btn').removeClass('is-aktif');
            $(this).addClass('is-aktif');
            kirimPratinjau(jenisPratinjau());
        });
        $('#ci-modal-pdf').on('hidden.bs.modal', function () {
            // PDF-nya dilepas supaya tidak terus dimuat di latar belakang.
            $('#ci-pdf-frame').attr('src', 'about:blank');
        });

        // ---- rincian angka di kartu Summary ----
        $('#ci-sum-toggle').on('click', function () {
            bukaRincian($('#ci-sum-detail').prop('hidden'));
        });

        // ---- simpan ----
        $('#ci-btn-simpan').on('click', bukaKonfirmasi);
        $('#ci-btn-kembali').on('click', function () { window.location.href = URL_LIST; });

        // Isian angka: cuma digit & titik.
        $(document).on('keypress', '.ci-num, .ci-sj-disc', function (e) {
            var c = e.which;
            if (c === 8 || c === 0 || c === 13) { return true; }
            return (c >= 48 && c <= 57) || c === 46;
        });

        // ---- supporting document ----
        $('#ci-doc-pilih').on('click', function () { $('#ci-doc-input').trigger('click'); });
        $('#ci-doc-input').on('change', function () {
            docTambah(this.files);
            this.value = '';
        });
        $('#ci-doc-prev').on('click', function () { docGeser(-1); });
        $('#ci-doc-next').on('click', function () { docGeser(1); });
        $('#ci-doc-buang').on('click', docHapusAktif);
        $('#ci-modal-doc').on('hidden.bs.modal', function () {
            document.getElementById('ci-doc-isi').innerHTML = '';
        });
        // Panah kiri/kanan pindah dokumen selama penampil terbuka (kalau fokus
        // sedang di dalam PDF, panah dipakai PDF-nya untuk scroll).
        $(document).on('keydown', function (e) {
            if (!$('#ci-modal-doc').hasClass('show')) { return; }
            if (e.key === 'ArrowLeft')  { docGeser(-1); }
            if (e.key === 'ArrowRight') { docGeser(1); }
        });
        // Drag & drop ke kotak upload. File yang terlanjur di-drop di luar
        // kotak jangan sampai dibuka browser (halaman pindah, isian hilang).
        (function () {
            var zona = document.getElementById('ci-doc-drop');
            if (!zona) { return; }
            ['dragenter', 'dragover'].forEach(function (ev) {
                zona.addEventListener(ev, function (e) { e.preventDefault(); zona.classList.add('is-drag'); });
            });
            ['dragleave', 'drop'].forEach(function (ev) {
                zona.addEventListener(ev, function (e) { e.preventDefault(); zona.classList.remove('is-drag'); });
            });
            zona.addEventListener('drop', function (e) { docTambah(e.dataTransfer.files); });
            window.addEventListener('dragover', function (e) { e.preventDefault(); });
            window.addEventListener('drop', function (e) { e.preventDefault(); });
        })();
        docRender();

        gambarBaris();

        // Mode edit: isian layarnya diambil dari invoice yang sedang diubah.
        // Sesudah ini layarnya bekerja persis seperti waktu membuat baru.
        if (UBAH && ID_UBAH) { muatInvoiceUbah(); }

        // Invoice yang sudah FIRST APPROVED: layarnya dikunci, cuma kotak
        // supporting document yang masih bisa dipakai.
        if (DOK_SAJA) { kunciDokSaja(); }
    });

    /**
     * Kunci layar untuk invoice yang sudah FIRST APPROVED.
     *
     * Isinya tidak boleh diubah lagi - yang dibuka cuma supporting document,
     * karena sesudah approval kedua lampirannya tidak bisa ditambah lagi.
     * Yang dikunci isian & tombolnya, bukan tampilannya: pemeriksa tetap bisa
     * melihat seluruh isi invoice-nya.
     */
    function kunciDokSaja() {
        $('#ci-btn-book, #ci-btn-so, #ci-btn-top, #ci-btn-kosongkan').prop('disabled', true);
        $('#ci-bank, #ci-type-so, #ci-pph').prop('disabled', true).trigger('change.select2');
        $('#ci-dp, #ci-dpcbd, #ci-retur').prop('readonly', true).removeClass('ci-bisa-isi');
        $('#ci-tbody .ci-buang').prop('disabled', true).attr('title', 'The invoice is already first approved');
        $('#ci-kirim-tambah, #ci-kirim-kosongkan').prop('disabled', true);
        $('#ci-kirim-tbody .ci-kirim-ubah, #ci-kirim-tbody .ci-kirim-buang').prop('disabled', true);

        $('#ci-btn-simpan').html('<i class="fa fa-paperclip"></i> Save Documents');

        // Keterangan di atas kotak dokumen - supaya jelas kenapa yang lain mati.
        if (!$('#ci-dok-saja').length) {
            $('<div class="ci-catatan-exim" id="ci-dok-saja">'
                + '<i class="fas fa-lock"></i> This invoice is already <b>FIRST APPROVED</b>, so its'
                + ' content can no longer be changed. Supporting documents can still be added -'
                + ' after the second approval they can not.'
                + '</div>').insertBefore('#ci-doc-drop');
        }
    }
})();
