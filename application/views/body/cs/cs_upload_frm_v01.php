<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span id="vJudulForm1"><b>CS Upload</b></span></h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->

                        <button style="display:none;" onclick="fCariData()" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Cari</button>

                        <button style="display:none;" onclick="fDataReload()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>


                        <div style="display:none;" class="btn-group" role="group" aria-label="Basic example">

                            <button onclick="addForm('http://intranet.isfa/hrs/armada/kendaraan')" type="button" class="btn btn-warning btn-sm"><i class="fa fa-upload"></i> Upload</button>
                        </div>

                        <!-- <a href="<?php echo base_url(); ?>index.php/unpackingpxp/uploadshipmentplan" class="btn btn-warning btn-sm">Back to List</a> -->

                        <!-- <a href="<?php echo base_url(); ?>index.php/import/shippingplan" class="btn btn-primary btn-sm">Back to Shipping Plan</a>&nbsp; -->
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="background-color:;">

                    <div class="row">
                        <div class="col-md-12 d-none" style="display: none;">
                            <span style="font-weight: bold; color:red;">Excel File Column Format</span>
                            <table width="100%" border="1">
                                <thead>
                                    <tr>
                                        <td align="center">PageNo</td>
                                        <td align="center">RecordNo</td>
                                        <td align="center">ShipmentNo</td>
                                        <td align="center">PoNo</td>
                                        <td align="center">Model2</td>
                                        <td align="center">Model</td>
                                        <td align="center">LotNo</td>
                                        <td align="center">CaseNo</td>
                                        <td align="center">CaseNo2</td>
                                        <td align="center">Destination</td>
                                        <td align="center">No</td>
                                        <td align="center">PartNo2</td>
                                        <td align="center">PartNo</td>
                                        <td align="center">SFX</td>
                                        <td align="center">Qty</td>
                                        <td align="center">Qty Box/Case</td>
                                        <td align="center">idConsigned</td>
                                        <td align="center">Dock</td>
                                        <td align="center">PartName</td>
                                        <td align="center">Weight</td>
                                        <td align="center">Price</td>
                                        <td align="center">CaseWeight</td>
                                        <td align="center">LWH</td>
                                        <td align="center">M3</td>
                                        <td align="center">TimePack</td>
                                        <td align="center">SN Box No</td>
                                        <td align="center">OLN Tana No</td>
                                        <td align="center">Barcode 1</td>
                                        <td align="center">AP No</td>
                                        <td align="center">VanningDate</td>
                                        <td align="center">ContNo</td>
                                        <td align="center">Bumber S/A</td>
                                        <td align="center">Barcode 2</td>
                                        <td align="center">Packing Date 2</td>
                                        <td align="center">Project Code</td>
                                        <td align="center">SN Box</td>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-2">
                                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                                <?php if ($this->session->flashdata('msg')) :
                                    echo $this->session->flashdata('msg');
                                endif; ?>
                            </div>

                            <form action="<?php echo base_url(); ?>index.php/cs/cs_upload" id="frm1" method="post" enctype="multipart/form-data" accept-charset="utf-8">

                                <!-- <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Code</label>
                                    <div class="col-sm-10">

                                        <select name="impcode" id="impcode" class="form-control" required>
                                            <option value="" selected disabled > - SELECT IMPCODE - </option>
                                            
                                        </select>

                                    </div>
                                </div> -->

                               <!--  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Job Type</label>
                                    <div class="col-sm-10">

                                        <select name="jobtype" id="jobtype" class="form-control">
                                            <option value="OKA">OKA</option>
                                            <option value="OT">OT</option>
                                        </select>

                                    </div>
                                </div> -->

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

                                <!-- <div class="form-group row" id="row_file_upload">
                                    <label for="Nama" class="col-sm-2 col-form-label">Invoice Rack</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="invoiceno_rack" name="invoiceno_rack" required>
                                    </div>
                                </div> -->

                                <div class="form-group row">
                                    <div class="col-sm-10 offset-md-2">
                                        <button id="btn1" type="submit" class="btn btn-warning">Upload</button>
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

        /* var fileName = document.getElementById('file').files[0].name;
        var fileName1 = fileName;
        fileName = fileName.toLowerCase();

        var impcode1 = $('#impcode').val();
        var impcode2 = $('#impcode').val();
        impcode1 = impcode1.toLowerCase(); */

        //alert(impcode1 + ' ' + fileName);

        /* if (fileName.indexOf(impcode1) < 1) {

            Swal.fire({
                title: "Check the file",
                text: "The uploaded file " + fileName1 + " file name must contain the selected job code " + impcode2,
                icon: "warning"
            });

            return false;
        } */

        /* let str = document.getElementById('file').files[0].name;
        str = str.toLocaleLowerCase();
        let substr = $('#impcode').val();
        substr = substr.toLocaleLowerCase(); */

        //console.log(str.includes(substr));
        
        /* if (!str.includes(substr)) {

            Swal.fire({
                title: "Check the file",
                text: "The uploaded file " + fileName1 + " file name must contain the selected job code " + impcode2,
                icon: "warning"
            });

            return false;
        } */

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

<script>
    <?php if($this->session->flashdata('error')){ ?>
    Swal.fire('Warning','<?= $this->session->flashdata('error') ?>','warning');
    <?php } ?>
</script>