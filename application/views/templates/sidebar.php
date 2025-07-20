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
                 <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            Admin
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <!-- <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/userrole'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>User Role</p>
                            </a>
                        </li>                      
                    </ul> -->
                    <?php foreach ($user_access_1 as $ua_1) : ?>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_1['base_url']); ?>" class="nav-link">
                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
                                    <p><?= $ua_1['menu']; ?></p>
                                </a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </li>
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Invoice
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('arnag'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Master TOP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/bookinvoice'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Book Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/createinvoice'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Create Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/listinvoice'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>List Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/duedateupdate'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Due Date Update</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/proformainvoice'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Proforma Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/listproformainvoice'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>List Proforma Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/returninvoice'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Return Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/listreturninvoice'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>List Return Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('arnag/debitnote'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Debit Note</p>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Invoice
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php foreach ($user_access_2 as $ua_2) : ?>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_2['base_url']); ?>" class="nav-link">
                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
                                    <p><?= $ua_2['menu']; ?></p>
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
                        <ul class="nav nav-treeview">
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
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>
                            Kwitansi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php foreach ($user_access_5 as $ua_5) : ?>
                        <ul class="nav nav-treeview">
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
                        <ul class="nav nav-treeview">
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
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            Reverse Document
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php foreach ($user_access_reverse as $ua_rvs) : ?>
                        <ul class="nav nav-treeview" style="padding-left: 5px;">
                            <li class="nav-item">
                                <a href="<?= base_url($ua_rvs['base_url']); ?>" class="nav-link">
                                    <i class="fas fa-chevron-circle-right nav-icon"></i>
                                    <p><?= $ua_rvs['menu']; ?></p>
                                </a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </li>


                <!-- <li class="nav-header">REPORT AR</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Report
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('report/frm_sales_report'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('report/frm_sales_report_material'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Sales Report / Material</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('report/frm_report_outstanding_pi'); ?>" class="nav-link">
                                <i class="fas fa-chevron-circle-right nav-icon"></i>
                                <p>Report Outstanding PI</p>
                            </a>
                        </li>
                    </ul>
                </li> -->
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
                        <ul class="nav nav-treeview">
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