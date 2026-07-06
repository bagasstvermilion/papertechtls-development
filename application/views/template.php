<?php
/* $hasilBagi = 5;
for ($i = 1; $i < ($hasilBagi + 1); $i++) {
    echo "<h1>$i</h1>";
} */
?>
<?php $this->load->view($header); ?>

<!-- pakai side bar menu cek sidebar.php juga untuk enable side bar -->
<!-- <body class="hold-transition sidebar-mini layout-fixed text-sm sidebar-collapse layout-navbar-fixed"> -->

<!-- tanpa side bar menu cek sidebar.php juga untuk enable disable side bar -->

<!-- <body class="hold-transition layout-top-nav"> --> <!-- jika tanpa side bar -->
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

    <div class="wrapper">

        <?php $this->load->view('layout/navbar'); ?>

        <form action="url/logout" method="post" id="logout-form" style="display: none;">
            <input type="hidden" name="_token" value="Ir9whjd5Tm1IW5vBxyVYvHb2fE1zu5BHcNx6hPeM">
        </form>


        <!-- Left side column. contains the logo and sidebar -->
        <!-- Main Sidebar Container -->
        <?php $this->load->view($sidebar); ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Small boxes (Stat box) -->
                <?php $this->load->view($body); ?>

                <!-- ./wrapper -->

                <!-- js footer -->

                <!-- ChartJS -->


</body>

</html>