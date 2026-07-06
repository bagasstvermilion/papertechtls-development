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

                        <a href="<?php echo base_url(); ?>index.php/unpackingpxp/frm_uploadshipmentplan" class="btn btn-warning btn-sm"><i class="fa fa-upload"></i> Upload</a>

                        <a href="<?php echo base_url(); ?>index.php/unpackingpxp" class="btn btn-primary btn-sm">Main Form</a>&nbsp;
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-1">
                            <label class="col-form-label">Case No</label>
                            <div class="input-group">
                                <input id="txtCari1" name="txtCari1" type="text" class="form-control form-control-sm" autocomplete="on">
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <label class="col-form-label">Part No</label>
                            <div class="input-group">
                                <input id="txtCari2" name="txtCari2" type="text" class="form-control form-control-sm" autocomplete="on">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">Status</label>
                            <div class="input-group">
                                <select name="txtCari3" id="txtCari3" class="form-control form-control-sm">
                                    <option value="waiting">Waiting</option>
                                    <option value="progress">Progress</option>
                                    <option value="done">Done</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-1">
                            <label class="col-form-label">&nbsp;</label>
                            <div class="input-group">
                                <button onclick="getDtTable();" type="button" class="btn btn-warning btn-sm"><i class="fa fa-search"></i> View</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                                <thead>
                                    <th class="text-center">No</th><!-- width="5%" -->
                                    <th class="text-center">CaseNo</th>
                                    <th class="text-center">PartNo</th>
                                    <th class="text-center">Rubetsu</th>
                                    <th class="text-center">PartName</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">UnitWeight</th>
                                    <th class="text-center">NetWeight</th>
                                    <th class="text-center">ContainerNo</th>
                                    <th class="text-center">FTA Code</th>
                                    <th class="text-center">ShippingCode</th>
                                    <th class="text-center">VanningCode</th>
                                    <th class="text-center">EFA MFN</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </thead>


                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
</section>


<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <!--  data-backdrop="static" paksa user harus close modal tekan tombol close x -->

    <div class="modal-dialog modal-xl" role="document">

        <form action="" method="post" class="form-horizontal">

            <!-- <input type="hidden" name="_token" value="Ir9whjd5Tm1IW5vBxyVYvHb2fE1zu5BHcNx6hPeM"><input type="hidden" name="_method" value="post"> -->

            <div class="modal-content">
                <div class="modal-header alert-light">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Case No</label>
                            <select name="caseno" id="caseno" class="form-control form-control-sm">
                                <?php
                                $sql = "SELECT DISTINCT caseno FROM machining_shipping_plan ORDER BY caseno";
                                $rs = $this->db->query($sql);
                                if ($rs->num_rows() > 0) {
                                    foreach ($rs->result_array() as $row) {
                                ?>
                                        <option value="<?php echo $row['caseno']; ?>"><?php echo $row['caseno']; ?></option>
                                <?php }
                                } ?>
                            </select>

                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Container No</label>
                            <div class="input-group">
                                <select name="containerno" id="containerno" class="form-control form-control-sm">
                                    <?php
                                    $sql = "SELECT DISTINCT containerno FROM machining_shipping_plan ORDER BY containerno";
                                    $rs = $this->db->query($sql);
                                    if ($rs->num_rows() > 0) {
                                        foreach ($rs->result_array() as $row) {
                                    ?>
                                            <option value="<?php echo $row['containerno']; ?>"><?php echo $row['containerno']; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Shipping Code</label>
                            <select name="shippingcode" id="shippingcode" class="form-control form-control-sm">
                                <?php
                                $sql = "SELECT DISTINCT shippingcode FROM machining_shipping_plan ORDER BY shippingcode";
                                $rs = $this->db->query($sql);
                                if ($rs->num_rows() > 0) {
                                    foreach ($rs->result_array() as $row) {
                                ?>
                                        <option value="<?php echo $row['shippingcode']; ?>"><?php echo $row['shippingcode']; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>

                    </div>

                </div>


                <div class="modal-footer alert-light">
                    <!-- <button class="btn btn-sm btn-flat btn-danger" id="btn"><i class="fa fa-save"></i> Get check box value</button> -->
                    <button class="btn btn-sm btn-flat btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancel</button>
                </div>

        </form>
    </div>
</div>



<script>
    let vJudulForm = "Machining Upload Shipping Plan";

    let table;
    let vmessageTop = "Kendaraan ";

    /* model lama jquery ui */
    /* $('#tglstnk').datepicker({
      autoclose: true,
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
    }); */

    /* model bawaan template adminlte3 */
    /* var dateNow = new Date();
    $('#txtCari3').datetimepicker({
        defaultDate: dateNow,
        format: 'YYYY-MM-DD',
        date: moment()
    }); */

    var dataUrl = '<?php echo base_url(); ?>index.php/Unpackingpxpdata/blank_data';
    //dataUrl = '<?php echo base_url(); ?>index.php/Unpackingpxpdata/get_machining_shipping_plan';

    function getDtTable() {

        //akalin uri segment ci biar terima parameter kosong di sql
        $('#txtCari1').val().length > 0 ? param1 = $('#txtCari1').val() : param1 = "_BLANK_";
        $('#txtCari2').val().length > 0 ? param2 = $('#txtCari2').val() : param2 = "_BLANK_";
        $('#txtCari3').find(":selected").val().length > 0 ? param3 = $('#txtCari3').find(":selected").val() : param3 = "_BLANK_";

        dataUrl1 = '<?php echo base_url(); ?>index.php/Unpackingpxpdata/get_machining_shipping_plan';
        dataUrl = dataUrl1 + "/" + param1 + "/" + param2 + "/" + param3;
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
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
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
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
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
                }, {
                    data: 'caseno'
                },
                {
                    data: 'partno'
                },
                {
                    data: 'rubetsu'
                },
                {
                    data: 'partname'
                },
                {
                    data: 'qty',
                    'className': 'text-right'
                },
                {
                    data: 'unitweight',
                    'className': 'text-right'
                },
                {
                    data: 'netweight',
                    'className': 'text-right'
                },
                {
                    data: 'containerno'
                },
                {
                    data: 'fta_code'
                },
                {
                    data: 'shippingcode'
                },
                {
                    data: 'vanningcode'
                },
                {
                    data: 'efa_mfn'
                },
                {
                    data: 'status'
                },
                {
                    data: 'aksi',
                    'className': 'text-center'
                },
            ]
        });

        $('#modal-form').validator().on('submit', function(e) {
            if (!e.preventDefault()) {
                if (confirm('Are you sure you want to delete this item?')) {

                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((datajson) => {

                            console.log(datajson);

                            response = JSON.parse(datajson);
                            if (datajson.length > 0) {
                                alert(response.sts);
                            }

                            $('#modal-form').modal('hide');
                            dtTable.ajax.reload();
                        })
                        .fail((errors) => {
                            alert('Tidak dapat menyimpan data ' + errors);
                            return;
                        });

                } else {
                    $('#modal-form').modal('hide');
                }
            }
        });
    });

    function fDataReload() {
        dtTable.ajax.reload();
        alert("reload sukses");
    }

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kendaraan ');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
    }

    function editForm(url, updateUrl) {

        console.log(updateUrl);

        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Shipping Plan Delete Confirmation ');

        $('#modal-form form')[0].reset();

        $('#modal-form form').attr('action', updateUrl);

        $('#modal-form [name=_method]').val('put');
        //$('#modal-form [name=_method]').val('post');

        $('#partno1').focus();

        $.get(url)
            .done((response) => {

                datajson = JSON.parse(response);

                //$('#modal-form [name=partno1]').val(datajson.partno1);

                $('#modal-form [name=caseno]').val(datajson.caseno).change();
                $('#modal-form [name=containerno]').val(datajson.containerno).change();
                $('#modal-form [name=shippingcode]').val(datajson.shippingcode).change();
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((datajson) => {
                    dtTable.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>