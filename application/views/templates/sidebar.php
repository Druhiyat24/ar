<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="<?= base_url('/landingpage'); ?>"  class="nav-link" >
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" role="button" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-user"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<style>
/* ── Modern Sidebar ── */
.main-sidebar {
    background: linear-gradient(180deg, #1a1f3c 0%, #16213e 60%, #0f3460 100%) !important;
    box-shadow: 4px 0 15px rgba(0,0,0,0.35) !important;
}

.brand-link {
    background: linear-gradient(135deg, #0d1b4b 0%, #1a237e 60%, #283593 100%) !important;
    border-bottom: 2px solid rgba(100,130,255,0.35) !important;
    padding: 16px 14px 14px !important;
    transition: background .25s;
    position: relative;
    overflow: hidden;
}
.brand-link::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, #5c6bc0, #42a5f5, #5c6bc0, transparent);
}
.brand-link:hover { background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%) !important; }

/* Logo ring glow */
.brand-link .brand-image {
    border: 2px solid rgba(100,149,255,0.5) !important;
    box-shadow: 0 0 10px rgba(66,165,245,0.4), 0 0 0 3px rgba(66,165,245,0.1) !important;
    width: 38px !important;
    height: 38px !important;
    margin-top: 0 !important;
    transition: box-shadow .25s;
}
.brand-link:hover .brand-image {
    box-shadow: 0 0 16px rgba(66,165,245,0.65), 0 0 0 4px rgba(66,165,245,0.15) !important;
}

/* Brand text block */
.brand-text {
    display: inline-flex !important;
    flex-direction: column !important;
    line-height: 1.2 !important;
    vertical-align: middle !important;
}
.brand-name {
    color: #ffffff !important;
    font-size: 14px !important;
    font-weight: 700 !important;
    letter-spacing: 1.5px !important;
    text-transform: uppercase;
}
.brand-sub {
    color: #7986cb !important;
    font-size: 9.5px !important;
    font-weight: 400 !important;
    letter-spacing: .8px !important;
    text-transform: uppercase;
    margin-top: 1px;
}

/* Nav header */
.nav-header {
    color: #7986cb !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    letter-spacing: 1.5px !important;
    text-transform: uppercase !important;
    padding: 12px 16px 4px !important;
}

/* Nav link */
.nav-sidebar .nav-link {
    border-radius: 6px !important;
    margin: 1px 6px !important;
    padding: 7px 10px !important;
    color: #b0bec5 !important;
    transition: all .18s ease !important;
    font-size: 14px !important;
}
.nav-sidebar .nav-link:hover {
    background: rgba(255,255,255,0.09) !important;
    color: #fff !important;
}
.nav-sidebar .nav-link.active,
.nav-sidebar .nav-item > .nav-link.active {
    background: linear-gradient(90deg, #3949ab, #1e88e5) !important;
    color: #fff !important;
    box-shadow: 0 2px 8px rgba(57,73,171,0.4) !important;
}

/* Icon warna */
.nav-sidebar .nav-icon { color: #7986cb !important; }
.nav-sidebar .nav-link:hover .nav-icon,
.nav-sidebar .nav-link.active .nav-icon { color: #fff !important; }

/* Treeview arrow */
.nav-sidebar .nav-link > .right { color: #546e7a !important; transition: transform .2s; }

/* Search box */
.sidebar .form-inline .input-group {
    background: rgba(255,255,255,0.07) !important;
    border-radius: 20px !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
    overflow: hidden !important;
    margin: 10px 10px 6px !important;
    width: calc(100% - 20px) !important;
}
.form-control-sidebar {
    background: transparent !important;
    border: none !important;
    color: #e0e6ff !important;
    font-size: 12px !important;
}
.form-control-sidebar::placeholder { color: #78909c !important; }
.btn-sidebar { background: transparent !important; color: #7986cb !important; }

/* Scrollbar tipis */
.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-track { background: transparent; }
.sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }

/* ── Sidebar Search Results ── */
.sidebar-search-results {
    background: #0f1535 !important;
    border: 1px solid rgba(92,107,192,0.35) !important;
    box-shadow: 0 6px 20px rgba(0,0,0,0.6) !important;
}
.sidebar-search-results .list-group-item {
    background: #0f1535 !important;
    color: #cfd8e3 !important;
    border-color: rgba(92,107,192,0.15) !important;
}
.sidebar-search-results .list-group-item:hover {
    background: rgba(57,73,171,0.4) !important;
    color: #fff !important;
}
.sidebar-search-results .list-group-item .search-title {
    color: #e8eeff !important;
    font-weight: 600 !important;
    font-size: 13px !important;
}
.sidebar-search-results .list-group-item .search-path {
    color: #5c6bc0 !important;
    font-size: 11px !important;
}
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?= base_url('assets/') ?>dist/img/nag_logo.png" alt="Nag-Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text ml-2">
            <span class="brand-name">Nirwana Alabare</span>
            <span class="brand-sub">AR Management System</span>
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
                   <a href="http://10.10.5.62:8080/erp/" class="nav-link"><li class="nav-header">MAIN MENU</li></a>
                   
                   <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            Admin
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <!-- Submenu user_access_1 -->
                    <ul class="nav nav-treeview" style="margin-left: 8px;">
                        <?php foreach ($user_access_1 as $ua_1) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url($ua_1['base_url']); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                    <p><?= $ua_1['menu']; ?></p>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Folder Collapsible untuk Master -->
                    <ul class="nav nav-treeview" style="margin-left: 8px;">
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link folder-toggle" data-target="menu_master">
                                <i class="fas fa-folder nav-icon" id="icon_menu_master"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview collapse folder-content" id="menu_master" style="margin-left: 8px;">
                                <?php foreach ($user_access_7 as $ua_7) : ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url($ua_7['base_url']); ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                            <p><?= $ua_7['menu']; ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-file-invoice nav-icon"></i>
                        <p>
                            Invoice
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview" style="margin-left: 8px;">
                        <?php
                        $kategori = [
                            'invoice' => 'Invoice',
                            'proforma_invoice' => 'Proforma Invoice',
                            'return_invoice' => 'Return Invoice',
                            'dp_invoice' => 'DP-CBD Invoice',
                            'debitnote' => 'Debit Note',
                            'projection' => 'Projection'
                        ];

                        foreach ($kategori as $key => $label) :
                            $has_access = array_filter($user_access_2, function ($ua) use ($key) {
                                return $ua['ctg_menu'] == $key;
                            });
                            if (!empty($has_access)) :
                                $folderId = "menu_" . $key;
                                ?>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link folder-toggle" data-target="<?= $folderId ?>">
                                        <i class="fas fa-folder nav-icon" id="icon_<?= $folderId ?>"></i>
                                        <p><?= $label ?><i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview folder-content collapse" id="<?= $folderId ?>" style="margin-left: 8px;">
                                        <?php foreach ($has_access as $ua_2) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url($ua_2['base_url']); ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                                    <p><?= $ua_2['menu']; ?></p>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endif;
                        endforeach; ?>
                    </ul>
                </li>



                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-receipt nav-icon"></i>
                        <p>
                            Kwitansi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php foreach ($user_access_5 as $ua_5) : ?>
                        <ul class="nav nav-treeview" style="margin-left: 8px;">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_5['base_url']); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                    <p><?= $ua_5['menu']; ?></p>
                                </a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>
                            Alokasi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php foreach ($user_access_6 as $ua_6) : ?>
                        <ul class="nav nav-treeview" style="margin-left: 8px;">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_6['base_url']); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                    <p><?= $ua_6['menu']; ?></p>
                                </a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-thumbs-up"></i>
                        <p>
                            Approval
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="margin-left: 8px;">

                        <!-- First Approve -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>
                                    First Approval
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="margin-left: 0;">
                                <li class="nav-item">
                                    <a href="<?= base_url('arnag/first_approvalinvoice'); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                        <p>Approval Invoice</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('arnag/first_approvalinvoice_manual'); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                        <p>Approval Invoice Manual</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('arnag/first_approval_debitnote'); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                        <p>Approval Debit Note</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('arnag/first_approval_invoice_dpcbd'); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                        <p>Approval Invoice DP & CBD</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Secondary Approval -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-check-double nav-icon"></i>
                                <p>
                                    Second Approval
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="margin-left: 0;">
                                <?php foreach ($user_access_4 as $ua_4) : ?>
                                <li class="nav-item">
                                    <a href="<?= base_url($ua_4['base_url']); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                        <p><?= $ua_4['menu']; ?></p>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            Reverse Document
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php foreach ($user_access_reverse as $ua_rvs) : ?>
                        <ul class="nav nav-treeview" style="margin-left: 8px;">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_rvs['base_url']); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                    <p><?= $ua_rvs['menu']; ?></p>
                                </a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </li>



                <li class="nav-header">REPORT AR</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Report
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php foreach ($user_access_3 as $ua_3) : ?>
                        <?php if (strpos($ua_3['base_url'], 'projection_report') !== false && strpos($ua_3['base_url'], 'history') === false) : ?>

                        <!-- Projection → 2 sub-menu -->
                        <ul class="nav nav-treeview" style="margin-left: 8px;">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>
                                        Projection
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="margin-left: 0;">
                                    <li class="nav-item">
                                        <a href="<?= base_url($ua_3['base_url']); ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                            <p>Projection Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('report/history_projection_report'); ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                            <p>History Projection</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <?php elseif (strpos($ua_3['base_url'], 'history_projection') !== false) : ?>
                        <?php // sudah ditampilkan di bawah Projection, skip ?>

                        <?php else : ?>
                        <ul class="nav nav-treeview" style="margin-left: 8px;">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_3['base_url']); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                    <p><?= $ua_3['menu']; ?></p>
                                </a>
                            </li>
                        </ul>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Corporate Report
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                        <?php foreach ($user_access_corporate as $ua_c) : ?>
                        <ul class="nav nav-treeview" style="margin-left: 8px;">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_c['base_url']); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon" style="font-size:8px;"></i>
                                    <p><?= $ua_c['menu']; ?></p>
                                </a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->