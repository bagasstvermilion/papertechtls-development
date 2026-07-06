<!-- <!DOCTYPE html> -->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Papertech TLS</title>

    <!-- <link rel="icon" href="img/logo_jbi.png" type="image/gif" sizes="16x16"> -->

    <!-- Custom fonts for this template-->
    <!-- <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <style>
        .main {
            width: 50%;
            margin: 50px auto;
        }

        /* Bootstrap 4 text input with search icon */

        .icon-inside-pwd .form-control {
            padding-left: 2.375rem;
        }

        .icon-inside-pwd .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: #aaa;
        }

        .icon-inside-uid .form-control {
            padding-left: 2.375rem;
        }

        .icon-inside-uid .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: #aaa;
        }
    </style>
</head>

<body class="">
    <table width="100%" height="100%" border="1">
        <tr>
            <td>
                <div class="container">

                    <!-- Outer Row -->
                    <div class="row justify-content-center">

                        <div class="col-xl-10 col-lg-12 col-md-9">

                            <div class="card o-hidden border-0 shadow-lg my-5">
                                <div class="card-body p-0">
                                    <!-- Nested Row within Card Body -->
                                    <div class="row">
                                        <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background: url('<?php echo base_url(); ?>/assets/images/sonoco_logo.png'); background-position: center; background-size: cover;"></div>
                                        <div class="col-lg-6">
                                            <div class="p-5">
                                                <div class="text-center">
                                                    <!-- <img class="img-fluid" src="<?php echo base_url(); ?>assets/images/logo-okamoto1.svg">
                                                    <span>&nbsp;<br><br></span> -->
                                                    <h1 style="display:;" class="h5 text-secondary"><b><span style="color:darkorange;">Papertech</span> <span style="color:crimson;">TLS</span></b></h1><br>
                                                </div>

                                                <?php echo $this->session->flashdata('msg'); ?>
                                                <?php //echo $this->session->flashdata('failed');
                                                ?>
                                                <?php //echo form_open('', array('class' => 'user')); 
                                                ?>

                                                <form action="<?php echo base_url(); ?>index.php/login/prslogin" method="post" class="user" accept-charset="utf-8">
                                                    <div class="form-group  icon-inside-uid has-feedback ">
                                                        <span class="fas fa-user form-control-feedback"></span>
                                                        <input required="" autofocus="autofocus" autocomplete="off" value="<?php echo set_value('username'); ?>" type="text" name="username" class="form-control" placeholder="Username"><!-- class="form-control form-control-user" -->
                                                        <?php echo form_error('username', '<small class="text-danger">', '</small>'); ?>
                                                    </div>
                                                    <div class="form-group icon-inside-pwd">
                                                        <span class="fa fa-key form-control-feedback"></span>
                                                        <input required="" type="password" name="passwrd" id="passwrd" class="form-control" placeholder="Password">
                                                        <?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
                                                    </div>
                                                    <!--
										<div class="form-group">
											<select class="form-control" id="flag" name="flag">
												<option value="4" selected>Karyawan</option>
												<option value="3">Rekanan</option>
												<option value="2">Mandor</option>
												<option value="1">Vendor</option>
											</select>
										</div>
										-->
                                                    <button type="submit" class="btn btn-info btn-user btn-block">Login</button>
                                                    <hr>
                                                    <div class="text-center">
                                                        Copyright &copy; 2026 - <a href="#">ICT Dept</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </td>
        </tr>
    </table>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Core plugin JavaScript-->
    <!-- <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script> -->

    <!-- Custom scripts for all pages-->
    <!-- <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script> -->

</body>

</html>