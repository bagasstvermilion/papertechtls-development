<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Papertech TLS</title>
    <meta name="csrf-token" content="Ir9whjd5Tm1IW5vBxyVYvHb2fE1zu5BHcNx6hPeM">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- <link rel="icon" href="http://intranet.isfa/hrs/img/logo.png" type="image/png"> -->

    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/dist/css/adminlte.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/jqvmap/jqvmap.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/summernote/summernote-bs4.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/jquery-ui/jquery-ui.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/ekko-lightbox/ekko-lightbox.css">



    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"> -->


    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/dist/css/adminlte.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min"></script>
  <![endif]-->

    <!--link rel="stylesheet" href="https://www.jquerypost.com/demo/bootstrap-4-for-step-wizard-style-interface-smart-wizard-180/dist/css/smart_wizard_theme_arrows.css"-->


    <style>
        .header {
            position: sticky;
            top: 0;
        }

        .container {
            /*width: 600px;*/
            height: 400px;
            overflow: auto;
        }

        h1 {
            color: green;
        }
    </style>
    <style>
        .datepicker {
            z-index: 9999 !important
        }

        /* remove X from locked tag */
        .locked-tag .select2-selection__choice__remove {
            display: none !important;
        }

        /* I suggest to hide  all selected tags from drop down list */
        .select2-results__option[aria-selected="true"] {
            display: none;
        }


        .dataTable tbody tr {
            /*height: 35px;*/
            /* or whatever height you need to make them all consistent */
        }

        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 4px 10px;
            /* e.g. change 8x to 4px here */
        }
    </style>
    <style>
        .connecting-line {
            height: 2px;
            background: #e0e0e0;
            position: absolute;
            width: 75%;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: 15px;

        }

        .progressbar {
            counter-reset: step;
        }

        .progressbar li {
            list-style-type: none;
            width: 15%;
            float: left;
            font-size: 12px;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            color: #7d7d7d;
        }

        .progressbar li:before {
            width: 30px;
            height: 30px;
            content: counter(step);
            counter-increment: step;
            line-height: 30px;
            border: 2px solid #7d7d7d;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
        }

        .progressbar li:after {
            width: 100%;
            height: 2px;
            content: '';
            position: absolute;
            background-color: #7d7d7d;
            top: 15px;
            left: -50%;
            z-index: -1;
        }

        .progressbar li:first-child:after {
            content: none;
        }

        .progressbar li.active {
            color: green;
        }

        .progressbar li.active:before {
            border-color: #55b776;
        }

        .progressbar li.active+li:after {
            background-color: #55b776;
        }
    </style>

    <style>
        @media print {
            .hideme {
                display: none;
            }
        }
    </style>


    <style type="text/css">
        /* #resultswebcam { padding:20px; border:1px solid; background:#ccc; } */
        /* @media (max-width: 320px) {
    #my_camera video {
        max-width: 80%;
        max-height: 80%;
    }

    #resultswebcam img {
        max-width: 80%;
        max-height: 80%;

    }
} */
    </style>


    <!-- jQuery 3 -->
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Moment -->
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/moment/moment.min.js"></script>

    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/AdminLTE/dist/js/adminlte.min.js"></script>
    <!-- Validator -->
    <script src="<?php echo base_url(); ?>assets/js/validator.min.js"></script>

    <!-- <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/select2/js/select2.full.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/inputmask/jquery.inputmask.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/webcamjs/v1.0.25/webcam.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

    <script src="<?php echo base_url(); ?>/assets/AdminLTE/plugins/popper/umd/popper.min.js"></script>

    <script src="https://unpkg.com/lucide@latest"></script>


    <script>
        function preview(selector, temporaryFile, width = 200) {
            $(selector).empty();
            $(selector).append(`<img src="${window.URL.createObjectURL(temporaryFile)}" width="${width}">`);
        }

        $(document).ready(function() {
            //$('.sidebar-toggle').click(); //lipat side bar menu
            //$('#btnNavLink').click(); //auto lipat side bar menu OK
            lucide.createIcons();

            $('#btnNavLink').on('click', function(e) {
                e.preventDefault(); // Mencegah halaman reload jika elemen berupa tag <a> atau <button> submit
                // Tulis kode aksi Anda di bawah ini
                //console.log('Tombol Nav Link berhasil diklik!');
                // Otomatis tambah jika tidak ada, dan hapus jika ada
                $('#logo_image').toggleClass('brand-image');
            });
        });
    </script>

</head>