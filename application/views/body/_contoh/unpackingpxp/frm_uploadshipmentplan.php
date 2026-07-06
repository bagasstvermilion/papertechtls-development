<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span id="vJudulForm1"><b>SHIPPING PLAN (UPLOAD)</b></span></h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->

                        <button style="display:none;" onclick="fCariData()" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Cari</button>

                        <button style="display:none;" onclick="fDataReload()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>


                        <div style="display:none;" class="btn-group" role="group" aria-label="Basic example">

                            <button onclick="addForm('http://intranet.isfa/hrs/armada/kendaraan')" type="button" class="btn btn-warning btn-sm"><i class="fa fa-upload"></i> Upload</button>
                        </div>

                        <a href="<?php echo base_url(); ?>index.php/unpackingpxp/uploadshipmentplan" class="btn btn-warning btn-sm">Back to List</a>

                        <a href="<?php echo base_url(); ?>index.php/unpackingpxp" class="btn btn-primary btn-sm">Main Form</a>&nbsp;
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="background-color:;">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-2">
                                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                                <?php if ($this->session->flashdata('msg')) :
                                    echo $this->session->flashdata('msg');
                                endif; ?>
                            </div>

                            <form action="<?php echo base_url(); ?>index.php/PhpspreadsheetController/uplod_shipping_plan" id="frm1" method="post" enctype="multipart/form-data" accept-charset="utf-8">


                                <div class="form-group row" id="row_file_upload">
                                    <label for="Nama" class="col-sm-2 col-form-label">File Upload</label>
                                    <div class="col-sm-10">

                                        <input type="file" class="form-control" id="file" name="file" accept=".csv,.xls,.xlsx" required="">

                                        <small>File type: csv, xls, xlsx<br></small>
                                        <small class="text-danger">
                                            <?php echo form_error('FileUpload') ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10 offset-md-2">
                                        <button id="btn1" type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </div>

                                <div class="row" id="row_spinner" style="display:none;">
                                    <div class="col-md-12">
                                        <div align="center">
                                            <img class="img-responsive" width="100" height="100" src="<?php echo base_url(); ?>assets/images/loading-45.gif" alt="Spinner .gif">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
</section>

<script>
    $('#frm1').on('submit', function(e) {
        //alert("Submit..");
        $("#row_file_upload").css({
            "display": "none"
        });
        $("#row_spinner").css({
            "display": ""
        });
        $('#btn1').text('Uploading data please wait..');
        $('#btn1').attr('disabled', 'disabled');
        //return false;
    });
</script>