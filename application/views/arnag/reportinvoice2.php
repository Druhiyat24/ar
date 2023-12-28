<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('vendors/Invoice_Template/style_inv.css'); ?>" media="all" />
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="<?= base_url('vendors/Invoice_Template/nag_logo.png'); ?>">
        </div>
        <div id="company">
            <h2 class="name">PT.Nirwana Alabare Garment</h2>
            <div>Jl. Raya Majalaya - Rancaekek No.289</div>
            <div>Telepon: (022) 85962076</div>
            <div><a href="mailto:company@example.com">company@example.com</a></div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">INVOICE TO:</div>
                <h2 class="name"><?= $data_invoice['customer']; ?></h2>
                <div class="address"><?= $data_invoice['alamat']; ?></div>
                <div class="phone"><?= $data_invoice['phone']; ?></div>
                <div class="email"><a href="mailto:john@example.com"><?= $data_invoice['email']; ?></a></div>
            </div>
            <div id="invoice">
                <h1><?= $data_invoice['no_invoice']; ?></h1>
                <div class="date">Date of Invoice : <?= $data_invoice['tgl_inv']; ?></div>
                <div class="date"><?= $data_invoice['type_top']; ?> : <?= $data_invoice['top']; ?> </div>
                <div class="date">Type : <?= $data_invoice['type']; ?></div>
                <div class="date">Shipping : <?= $data_invoice['shipp']; ?></div>
            </div>
        </div>

        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="desc">STYLE NAME</th>
                    <th class="unit">QTY</th>
                    <th class="qty">UNIT PRICE</th>
                    <th class="disc">DISC(%)</th>
                    <th class="total">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($data_invoice_detail as $inv_det) : ?>
                    <tr>
                        <td class="no"><?= $i; ?></td>
                        <td class="desc"><?= $inv_det['style_name']; ?></td>
                        <td class="unit"><?= $inv_det['qty']; ?></td>
                        <td class="qty"><?= $inv_det['unit_price']; ?></td>
                        <td class="disc"><?= $inv_det['disc']; ?></td>
                        <td class="total"><?= $inv_det['total_price']; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">TOTAL</td>
                    <td><?= $data_invoice_pot['total']; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">DISCOUNT</td>
                    <td><?= $data_invoice_pot['discount']; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">DOWN PAYMENT</td>
                    <td><?= $data_invoice_pot['dp']; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">RETUR</td>
                    <td><?= $data_invoice_pot['retur']; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">TOTAL WITH OUT TAX</td>
                    <td><?= $data_invoice_pot['twot']; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">VAT</td>
                    <td><?= $data_invoice_pot['vat']; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">GRAND TOTAL</td>
                    <td><?= $data_invoice_pot['grand_total']; ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- <div id="thanks">Thank you!</div> -->
        <div id="notices">
            <div>NOTICE:</div>
            <!-- <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div> -->
        </div>
    </main>
    <!-- <footer> -->
    <!-- Invoice was created on a computer and is valid without the signature and seal. -->
    <!-- </footer> -->
</body>

</html>