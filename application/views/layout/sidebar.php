 <!-- tanpa side bar display:none -->
 <aside class="main-sidebar sidebar-light-white elevation-4">

   <!-- Brand Logo -->
   <a href="#" class="brand-link">
     <!-- <img src="<?php echo base_url(); ?>assets/images/sonoco_logo.png" alt="Sonoco" class="brand-image" style="opacity: .8">
     <span class="brand-text font-weight-light">
       <b>SONOCO</b>
     </span> -->

     <div align="center" class="image"><img id="logo_image" src="<?php echo base_url(); ?>assets/images/sonoco_logo.png" alt="Company Logo" class="" width="100" height="75"></div>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar user panel (optional) -->

     <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="image">
         <img src="<?php echo base_url(); ?>assets/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
       </div>
       <div class="info">
         <a href="#" class="d-block">M Andi Purnama Sabar</a>
       </div>
     </div> -->

     <!-- <div align="center" class="image"><img src="<?php echo base_url(); ?>assets/images/sonoco_logo.png" alt="Sonoco" class="" width="100" height="75"></div> -->


     <!-- SidebarSearch Form -->
     <div class="form-inline" style="display:none;">
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
       <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

         <!-- <li class="nav-item">
           <a href="http://intranet.isfa/hrs/dashboard" class="nav-link">
             <i class="fas fa-tachometer-alt nav-icon"></i>
             <p>Dashboard</p>
           </a>
         </li> -->

         <li class="nav-item" style="display: none;">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-address-card"></i>
             <p>
               Contoh Parent Menu
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="<?php echo base_url(); ?>index.php/document" class="nav-link">
                 <i class="nav-icon fas fa-copy"></i>
                 <p>Document</p>
               </a>
             </li>

             <li class="nav-item">
               <a href="http://intranet.isfa/hrs/cuti/sisacuti" class="nav-link">
                 <i class="nav-icon fas fa-copy"></i>
                 <p>Child Menu 2</p>
               </a>
             </li>

           </ul>
         </li>
         <li class="nav-item">
           <p>&nbsp;</p>
         </li>
         <li class="nav-item">
           <a href="<?php echo base_url(); ?>index.php/login/home" class="nav-link">
             <!-- <i class="fas fa-home nav-icon"></i> --><i data-lucide="home"></i>
             <p>Home</p>
           </a>
         </li>
         <?php if ($this->session->userdata('role') == "admin") { ?>
           <li class="nav-item">
             <a href="<?php echo base_url(); ?>index.php/login/users" class="nav-link">
               <!-- <i class="fas fa-home nav-icon"></i> --><i data-lucide="settings"></i>
               <p>Kelola Akun</p>
             </a>
           </li>
         <?php } ?>
         <?php if ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "cs" || $this->session->userdata('role') == "whcs") { ?>
           <li class="nav-item">
             <a href="<?php echo base_url(); ?>index.php/cs/cs_upload_frm" class="nav-link">
               <i data-lucide="file-up"></i>
               <p>CS Upload</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="<?php echo base_url(); ?>index.php/cs/cs_view" class="nav-link">
               <i data-lucide="file-search-corner"></i>
               <p>CS View</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="<?php echo base_url(); ?>index.php/cs/tracking" class="nav-link">
               <i data-lucide="users"></i>
               <p>CS Tracking</p>
             </a>
           </li>
         <?php } ?>
         <?php if ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "security") { ?>
           <li class="nav-item">
             <a href="<?php echo base_url(); ?>index.php/security" class="nav-link">
               <!-- <i class="fas fas fa-truck nav-icon"></i> --><i data-lucide="shield"></i>
               <p>Security Gate</p>
             </a>
           </li>
         <?php } ?>
         <?php if ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "warehouse" || $this->session->userdata('role') == "whcs") { ?>
           <li class="nav-item">
             <a href="<?php echo base_url(); ?>index.php/warehouse" class="nav-link">
               <!-- <i class="fas fa-warehouse nav-icon"></i> --><i data-lucide="warehouse"></i>
               <p>Warehouse</p>
             </a>
           </li>

         <?php } ?>

         <li class="nav-item">
           <a href="<?php echo base_url(); ?>index.php/monitor" target="_blank" class="nav-link">
             <!-- <i class="fas fa-tv nav-icon"></i> --><i data-lucide="monitor"></i>
             <p>Monitor TV</p>
           </a>
         </li>

         <!-- <li class="nav-item">
           <a href="http://intranet.isfa/hrs/carrequest" class="nav-link">
             <i class="fas fa-car-side nav-icon"></i>
             <p>Monitorting Kendaraan</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="http://intranet.isfa/hrs/carrequest" class="nav-link">
             <i class="fas fa-car nav-icon"></i>
             <p>Car Request</p>
           </a>
         </li>


         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-truck"></i>
             <p>
               Armada
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="http://intranet.isfa/hrs/armada/kendaraan" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Master Kendaraan</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="./index2.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Riwayat Service</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="./index3.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Riwayat Perjalanan</p>
               </a>
             </li>
           </ul>
         </li>

         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-user-friends"></i>
             <p>
               SubKon
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="http://intranet.isfa/hrs/subkon/daftarsubkon" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Kontraktor</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="http://intranet.isfa/hrs/subkonkaryawan" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Karyawan</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="http://intranet.isfa/hrs/subkonkaryawanabsensi" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Kehadiran</p>
               </a>
             </li>

           </ul>
         </li>
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-building"></i>
             <p>
               Aset
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Daftar Aset</p>
               </a>
             </li>
           </ul>
         </li> -->



         <li class="nav-item menu-open" style="display:none;">
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Dashboard
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="./index.html" class="nav-link active">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Dashboard v1</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="./index2.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Dashboard v2</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="./index3.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Dashboard v3</p>
               </a>
             </li>
           </ul>
         </li>
         <li class="nav-item" style="display:none;">
           <a href="pages/widgets.html" class="nav-link">
             <i class="nav-icon fas fa-th"></i>
             <p>
               Widgets
               <span class="right badge badge-danger">New</span>
             </p>
           </a>
         </li>
         <li class="nav-item" style="display:none;">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-copy"></i>
             <p>
               Layout Options
               <i class="fas fa-angle-left right"></i>
               <span class="badge badge-info right">6</span>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="pages/layout/top-nav.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Top Navigation</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Top Navigation + Sidebar</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/boxed.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Boxed</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Fixed Sidebar</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="pages/layout/fixed-sidebar-custom.html" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Fixed Sidebar <small>+ Custom Area</small></p>
               </a>
             </li>

           </ul>
         </li>

       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>