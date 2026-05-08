<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>dist/css/adminlte.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/bootstrap/bootstrap-datetimepicker.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/toastr/toastr.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/selectpicker/bootstrap-select.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/apexchart/apexcharts.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/animate/animate.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css" /> -->

  <style type="text/css">
    .select2-selection {
      height: 38px !important;
      border-color: #ced4da !important;
    }

    .swal2-red .swal2-icon.swal2-warning {
      border-color: #e3342f !important;
      color: #e3342f !important;
    }
    .swal2-red .swal2-title {
      color: #e3342f !important;
    }

/*    input.form-control,
    .select2-container--bootstrap4 .select2-selection {
      border: 2px solid #808080 !important; 
      box-shadow: none;
    }

    input.form-control:focus,
    .select2-container--bootstrap4 .select2-container--focus .select2-selection {
      border-color: #8B008B !important;
      outline: none;
    }*/



  </style>

</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
  <?php log_message('info', 'Berhasil mengakses menu di AR'); ?>
  <div class="wrapper">