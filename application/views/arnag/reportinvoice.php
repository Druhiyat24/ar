<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title; ?></title>
    <style>
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -7.5px;
            margin-left: -7.5px;
        }
    </style>
</head>

<!-- info row -->
<div class="row">
    <div class="col-sm-6">
        From
        <address>
            <strong>PT.Nirwana Alabare Garment</strong><br>
            Jl. Raya Majalaya - Rancaekek No.289<br>
            Telepon: (022) 85962076<br>
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-6" style="text-align:right">
        To
        <address>
            <strong><?= $data_invoice['customer']; ?></strong><br>
            <?= $data_invoice['alamat']; ?><br>
            <?= $data_invoice['phone']; ?><br>
            <?= $data_invoice['email']; ?><br>
        </address>
    </div>
</div>

<body>
    <div style="text-align:center">
        <h3> INVOICE : <?= $data_invoice['no_invoice']; ?> </h3>
    </div>

    <table id="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Produk</th>
                <th>Harga Jual</th>
                <th>Terjual</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">1</td>
                <td>Kacang Goreng</td>
                <td>Rp5.000,-</td>
                <td>1</td>
                <td>25 Oktober 2020, 17:01:03</td>
            </tr>
            <tr>
                <td scope="row">2</td>
                <td>Kopi Hitam</td>
                <td>Rp5.000,-</td>
                <td>1</td>
                <td>25 Oktober 2020, 16:01:03</td>
            </tr>
            <tr>
                <td scope="row">3</td>
                <td>Gorengan Bakwan</td>
                <td>Rp3.000,-</td>
                <td>3</td>
                <td>25 Oktober 2020, 15:01:02</td>
            </tr>
            <tr>
                <td scope="row">4</td>
                <td>Nasi uduk</td>
                <td>Rp14.000,-</td>
                <td>2</td>
                <td>25 Oktober 2020, 14:04:03</td>
            </tr>
        </tbody>
    </table>
</body>

</html>