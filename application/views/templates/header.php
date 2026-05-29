<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title><?= $title; ?></title>
  <?php
    // Naikkan versi ini setiap kali ada perubahan CSS/JS agar semua browser paksa reload
    define('ASSET_VER', '20260522');
    $vjs = filemtime(FCPATH . 'assets/build/js/crud/crud-nag.js');
    $av  = ASSET_VER;
    $au  = base_url('assets/');
  ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= $au ?>plugins/fontawesome-free/css/all.min.css?v=<?= $av ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $au ?>dist/css/adminlte.min.css?v=<?= $av ?>">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?= $au ?>plugins/daterangepicker/daterangepicker.css?v=<?= $av ?>">
  <link rel="stylesheet" href="<?= $au ?>plugins/datepicker/datepicker3.css?v=<?= $av ?>">
  <link rel="stylesheet" href="<?= $au ?>plugins/bootstrap/bootstrap-datetimepicker.min.css?v=<?= $av ?>">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= $au ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css?v=<?= $av ?>">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= $au ?>plugins/toastr/toastr.min.css?v=<?= $av ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= $au ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css?v=<?= $av ?>">
  <link rel="stylesheet" href="<?= $au ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css?v=<?= $av ?>">
  <link rel="stylesheet" href="<?= $au ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css?v=<?= $av ?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= $au ?>plugins/select2/css/select2.min.css?v=<?= $av ?>">
  <link rel="stylesheet" href="<?= $au ?>plugins/selectpicker/bootstrap-select.min.css?v=<?= $av ?>">
  <link rel="stylesheet" href="<?= $au ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css?v=<?= $av ?>">
  <link rel="stylesheet" href="<?= $au ?>plugins/apexchart/apexcharts.css?v=<?= $av ?>">
  <link rel="stylesheet" href="<?= $au ?>plugins/animate/animate.min.css?v=<?= $av ?>">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css" /> -->

  <style type="text/css">

    /* ════════════════════════════════
       MODERN UI — Global
    ════════════════════════════════ */

    /* Body & wrapper */
    body { background: #f0f2f8 !important; font-family: 'Source Sans Pro', sans-serif; }
    .wrapper { background: #f0f2f8; }

    /* ── Navbar ── */
    .main-header.navbar {
        background: #fff !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
        border-bottom: none !important;
        padding: 0 16px !important;
    }
    .main-header .nav-link { color: #4a5568 !important; transition: color .18s; }
    .main-header .nav-link:hover { color: #3949ab !important; }

    /* ── Content wrapper ── */
    .content-wrapper { background: #f0f2f8 !important; }
    .content-header h1 { font-size: 1.4rem; font-weight: 700; color: #2d3748; }

    /* ── Cards ── */
    .card {
        border: none !important;
        border-radius: 12px !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07) !important;
        margin-bottom: 20px !important;
        transition: box-shadow .2s;
    }
    .card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.11) !important; }

    .card-header {
        border-radius: 12px 12px 0 0 !important;
        border-bottom: 1px solid rgba(0,0,0,0.06) !important;
        padding: 14px 20px !important;
        font-weight: 600 !important;
    }
    .card-title { font-size: 15px !important; font-weight: 600 !important; }
    .card-body { padding: 18px 20px !important; }

    /* Card color headers */
    .card-info > .card-header    { background: linear-gradient(90deg,#1e88e5,#42a5f5) !important; color:#fff !important; }
    .card-success > .card-header { background: linear-gradient(90deg,#2e7d32,#43a047) !important; color:#fff !important; }
    .card-warning > .card-header { background: linear-gradient(90deg,#e65100,#fb8c00) !important; color:#fff !important; }
    .card-danger  > .card-header { background: linear-gradient(90deg,#b71c1c,#e53935) !important; color:#fff !important; }
    .card-secondary > .card-header { background: linear-gradient(90deg,#37474f,#546e7a) !important; color:#fff !important; }
    .card-primary > .card-header { background: linear-gradient(90deg,#283593,#3949ab) !important; color:#fff !important; }

    /* ── Buttons ── */
    .btn {
        border-radius: 8px !important;
        font-weight: 500 !important;
        padding: 6px 16px !important;
        transition: all .18s ease !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1) !important;
    }
    .btn:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.18) !important; }
    .btn:active { box-shadow: 0 1px 4px rgba(0,0,0,0.12) !important; }
    /* Setiap tipe button warna berbeda & mudah dibedakan */
    .btn-primary   { background: linear-gradient(135deg,#283593,#3949ab) !important; border:none !important; color:#fff !important; }
    .btn-success   { background: linear-gradient(135deg,#1b5e20,#388e3c) !important; border:none !important; color:#fff !important; }
    .btn-warning   { background: linear-gradient(135deg,#e65100,#f57c00) !important; border:none !important; color:#fff !important; }
    .btn-danger    { background: linear-gradient(135deg,#b71c1c,#d32f2f) !important; border:none !important; color:#fff !important; }
    .btn-info      { background: linear-gradient(135deg,#006064,#00838f) !important; border:none !important; color:#fff !important; }
    .btn-secondary { background: linear-gradient(135deg,#37474f,#607d8b) !important; border:none !important; color:#fff !important; }
    .btn-default   { background: linear-gradient(135deg,#e8eaf6,#c5cae9) !important; border:none !important; color:#3949ab !important; }

    /* ── Form controls ── */
    .form-control {
        border-radius: 8px !important;
        border: 1.5px solid #e2e8f0 !important;
        padding: 7px 12px !important;
        font-size: 13.5px !important;
        transition: border-color .18s, box-shadow .18s !important;
        background: #fff !important;
    }
    .form-control:focus {
        border-color: #3949ab !important;
        box-shadow: 0 0 0 3px rgba(57,73,171,0.12) !important;
        outline: none !important;
    }

    /* ── Tables (non-sticky) ── */
    .table thead th {
        background: #f7f9fc !important;
        border-bottom: 2px solid #e2e8f0 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        color: #4a5568 !important;
        padding: 10px 12px !important;
        white-space: nowrap;
    }
    .table tbody td {
        font-size: 13px !important;
        padding: 9px 12px !important;
        border-bottom: 1px solid #f0f4f8 !important;
        color: #2d3748 !important;
        vertical-align: middle !important;
    }
    .table tbody tr:hover { background: #eef2ff !important; }

    /* ── table-head-fixed (AdminLTE sticky header) ── */
    /* Beri background solid agar header tidak tembus ke baris bawahnya */
    .table-head-fixed thead tr th {
        position: sticky !important;
        top: 0 !important;
        z-index: 10 !important;
        background: #eef1f7 !important;
        border-bottom: 2px solid #c8d0e7 !important;
    }
    /* Beri padding-top pada body agar baris pertama tidak tertutup header */
    .table-head-fixed tbody tr:first-child td {
        border-top: none !important;
    }

    /* ── Modal ── */
    .modal-content {
        border: none !important;
        border-radius: 14px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.18) !important;
        overflow: hidden !important;
    }
    .modal-header {
        padding: 16px 22px !important;
        border-bottom: 1px solid rgba(0,0,0,0.06) !important;
    }
    .modal-footer { border-top: 1px solid rgba(0,0,0,0.06) !important; }

    /* ── Select2 ── */
    .select2-selection {
      height: 38px !important;
      border-color: #e2e8f0 !important;
      border-radius: 8px !important;
    }
    .select2-container--bootstrap4 .select2-selection--single {
        border-radius: 8px !important;
    }

    /* ── Input group ── */
    .input-group-text {
        border-radius: 0 8px 8px 0 !important;
        border: 1.5px solid #e2e8f0 !important;
        background: #f7f9fc !important;
        color: #7986cb !important;
    }

    /* ── Badge ── */
    .badge { border-radius: 6px !important; padding: 4px 8px !important; }

    /* ── Section header ── */
    section.content-header {
        padding: 16px 20px 8px !important;
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

    #modal-add-duedate .modal-dialog {
    max-width: 75%;
}


    #modal-add-duedate .modal-body {
    max-height: 100vh;
    overflow-y: auto;
}

#modal-duedate-detail .modal-dialog {
    max-width: 75%;
}


    #modal-duedate-detail .modal-body {
    max-height: 100vh;
    overflow-y: auto;
}

/* ===== Filter row alignment ===== */
/* Remove bottom margin from form-groups inside filter rows so align-items-end works correctly */
.row.align-items-end .form-group {
    margin-bottom: 0 !important;
}
/* Buttons in filter rows match input height (38px) and don't wrap */
.row.align-items-end .d-flex .btn {
    height: 38px !important;
    white-space: nowrap !important;
    display: inline-flex !important;
    align-items: center !important;
}
/* The button group column itself aligns to bottom */
.row.align-items-end .d-flex {
    align-items: flex-end;
}

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