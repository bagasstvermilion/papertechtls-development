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
                                    <!-- Label memakan 2 dari 12 kolom -->
                                    <label for="file" class="col-sm-2 col-form-label">CS File Upload</label>

                                    <!-- Sisa 10 kolom untuk input dan tombol -->
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <!-- Input File -->
                                            <input type="file" class="form-control" id="file" name="file" accept=".csv,.xls,.xlsx" required="">

                                            <!-- Tombol di sebelah kanan (Khas Bootstrap 4) -->
                                            <div class="input-group-append">
                                                <button id="btn1" type="submit" class="btn btn-info">Upload</button>
                                            </div>
                                        </div>

                                        <!-- Pesan teks tetap rapi di bawah input group -->
                                        <small class="form-text text-muted">File type: csv, xls, xlsx</small>
                                        <small class="text-danger d-block">
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

                                <!-- <div class="form-group row">
                                    <div class="col-sm-10 offset-md-2">
                                        <button id="btn1" type="submit" class="btn btn-warning">Upload</button>
                                    </div>
                                </div> -->

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


                    <div class="row">
                        <div class="col-lg-2" style="display:;">
                            <label class="col-form-label">Upload History From</label>
                            <div class="input-group">
                                <input id="txtCari1" name="txtCari1" required readonly type="text" autocomplete="off" data-target="#txtCari1" data-toggle="datetimepicker" class="form-control datetimepicker-input form-control-sm" />

                                <div class="input-group-append" data-target="#txtCari1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2" style="display:;">
                            <label class="col-form-label">To</label>
                            <div class="input-group">
                                <input id="txtCari2" name="txtCari2" required readonly type="text" autocomplete="off" data-target="#txtCari2" data-toggle="datetimepicker" class="form-control datetimepicker-input form-control-sm" />

                                <div class="input-group-append" data-target="#txtCari2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <label class="col-form-label">&nbsp;</label>
                            <div class="input-group">
                                <button style="display:;" onclick="getDtTable();" type="button" class="btn btn-warning btn-sm"><i class="fa fa-search"></i> View</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px;">
                                <thead>
                                    <th class="text-center">No</th><!-- width="5%" -->
                                    <th class="text-center" title="CS Loading Plan Date">Plan Date</th>
                                    <th class="text-center">File Name</th>
                                    <!-- <th class="text-center">Row Data</th> -->
                                    <th class="text-center">Upload By</th>
                                    <th class="text-center">Upload At</th>
                                </thead>

                            </table>
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
    let dtTable;
    let vmessageTop = "Master Part ";

    let vJudulForm = vmessageTop;
    //$('#vJudulForm1').text(vJudulForm);

    /* model lama jquery ui */
    /* $('#tglstnk').datepicker({
      autoclose: true,
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
    }); */

    /* model bawaan template adminlte3 */
    var dateNow = new Date();
    $('#txtCari1').datetimepicker({
        defaultDate: dateNow,
        format: 'YYYY-MM-DD',
        date: moment()
    });

    $('#txtCari2').datetimepicker({
        defaultDate: dateNow,
        format: 'YYYY-MM-DD',
        date: moment()
    });

    var dataUrl = '<?php echo base_url(); ?>index.php/blankdatatable'; //'<?php echo base_url(); ?>index.php/Unpackingpxpdata/blank_data';

    function getDtTable() {

        //akalin uri segment ci biar terima parameter kosong di sql
        $('#txtCari1').val().length > 0 ? param1 = $('#txtCari1').val() : param1 = "_BLANK_";
        $('#txtCari2').val().length > 0 ? param2 = $('#txtCari2').val() : param2 = "_BLANK_";
        //$('#txtCari1').find(":selected").val().length > 0 ? param1 = $('#txtCari1').find(":selected").val() : param1 = "_BLANK_";
        //$('#txtCari2').find(":selected").val().length > 0 ? param2 = $('#txtCari2').find(":selected").val() : param2 = "_BLANK_";

        dataUrl1 = '<?php echo base_url(); ?>index.php/cs/cs_upload_history_data';
        dataUrl = dataUrl1 + "/" + param1 + "/" + param2; // + "/" + param3;
        //console.log(dataUrl);
        dtTable.ajax.url(dataUrl).load();
    }


    $(function() {
        dtTable = $('#tabel1').DataTable({
            "columnDefs": [
                // Hide second, third and fourth columns
                /* {
                    "visible": false,
                    "targets": [7, 8]
                } */
            ],
            "processing": true,
            "autoWidth": false,
            "responsive": false,
            "bLengthChange": true,
            "lengthMenu": [
                [25, 50, -1],
                [25, 50, "All"]
            ],
            dom: "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                /*dom:"<'row'<'col-sm-9 text-left'B><'col-sm-3'f>>" +*/
                "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            /*"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis","pageLength"],*/
            "buttons": [ /*"copy", "csv", "excel", "pdf", "print"*/ , {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> ',
                    titleAttr: 'Export to PDF',
                    className: 'btn',
                    download: 'open',
                    /* otomatis terbuka di browser tanpa download dulu */
                    orientation: 'landscape',
                    /* landscape atau portrait */
                    pageSize: 'A4',
                    header: true,
                    /* messageBottom: "messageBottom", */
                    /* messageTop: "messageTop", */
                    footer: true,
                    title: vJudulForm,
                    exportOptions: {
                        //columns: ':visible:not(:first-child)' /* print kolom tertentu saja */
                        stripHtml: true,
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: 'excel',
                    autoFilter: true,
                    text: '<i class="fas fa-file-excel"></i> ',
                    titleAttr: 'Export to Excel',
                    className: 'btn',
                    messageTop: vJudulForm,
                    title: null,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        //columns: ':visible:not(:last-child)',
                        /* print kolom tertentu saja */
                        /*modifier: { page: 'current' }*/ //to save only the data shown on the current DataTable page
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> ',
                    titleAttr: 'Print',
                    className: 'btn',
                    messageTop: vJudulForm,
                    title: '&nbsp;',
                    exportOptions: {
                        stripHtml: false,
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> ',
                    titleAttr: 'Export to CSV',
                    className: 'btn',
                    messageTop: vJudulForm,
                    title: '',
                    exportOptions: {
                        //columns: ':visible:not(:last-child)' /* print kolom tertentu saja */
                    }
                },
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> ',
                    titleAttr: 'Copy to ClipBoard',
                    className: 'btn',
                    messageTop: vJudulForm,
                    title: '',
                    exportOptions: {
                        //columns: ':visible:not(:last-child)' /* print kolom tertentu saja */
                    }
                },
                /* {
                    text: '<i class="fa fa-search"></i>',
                    titleAttr: 'Load Data',
                    attr: {
                        id: 'myBtnLoadData'
                    }
                }, */
                /* {
                    extend: 'colvis',
                    className: 'btn dark btn-outline',
                    text: 'Columns'
                } */
                /*,{ extend: 'csv', className: 'btn purple btn-outline ' }*/
                /*, "colvis"*/
            ],
            "scrollCollapse": true,
            /* "scrollY": "300px", */
            scrollY: '70vh',
            "scrollX": true, // <-- TAMBAHKAN INI agar header ikut bergeser saat horizontal scroll
            "paging": true,
            processing: true,
            serverSide: false,
            autoWidth: false,
            ajax: {
                url: dataUrl,
            },
            columns: [{
                    data: 'DT_RowIndex',
                    'className': 'text-center',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'plandate',
                    'className': 'text-center'
                },
                {
                    data: 'filename',
                    'className': 'text-left'
                },
                /* {
                    data: 'jmlrowdata',
                    'className': 'text-center'
                }, */
                {
                    data: 'upload_by',
                    'className': 'text-left'
                },
                {
                    data: 'upload_at',
                    'className': 'text-center'
                },
                <?php if ($this->session->userdata('isadmin') == 'yes' || $this->session->userdata('ishod') == 'yes') { ?>
                    /*{
                                         data: 'created_by',
                                        'className': 'text-left'
                                      }, */
                <?php } ?>
            ]
        });
    });
</script>
<script>
    <?php if ($this->session->flashdata('error')) { ?>
        Swal.fire('Warning', '<?= $this->session->flashdata('error') ?>', 'warning');
    <?php } ?>
</script>