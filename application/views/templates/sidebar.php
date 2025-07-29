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

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?= base_url('assets/') ?>dist/img/nag_logo.png" alt="Nag-Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>NWN-ALABARE</b></span>
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
                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
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
                                            <i class="fas fa-chevron-circle-right nav-icon"></i>
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
                            'debitnote' => 'Debit Note'
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
                                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
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
                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
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
                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
                                    <p><?= $ua_6['menu']; ?></p>
                                </a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-stamp"></i>
                        <p>
                            Approval
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php foreach ($user_access_4 as $ua_4) : ?>
                        <ul class="nav nav-treeview" style="margin-left: 8px;">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_4['base_url']); ?>" class="nav-link">
                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
                                    <p><?= $ua_4['menu']; ?></p>
                                </a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
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
                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
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
                        <ul class="nav nav-treeview" style="margin-left: 8px;">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_3['base_url']); ?>" class="nav-link">
                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
                                    <p><?= $ua_3['menu']; ?></p>
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