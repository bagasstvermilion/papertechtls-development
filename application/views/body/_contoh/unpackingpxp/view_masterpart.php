<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span id="vJudulForm1"><b>Master Part</b></span></h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->

                        <button style="display:none;" onclick="fCariData()" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Cari</button>

                        <button style="display:none;" onclick="fDataReload()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>


                        <div style="display:;" class="btn-group" role="group" aria-label="Basic example">

                            <button onclick="addForm('<?php echo base_url(); ?>index.php/masterpart/store')" type="button" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Create</button>
                        </div>

                        <!-- <a href="<?php echo base_url(); ?>index.php/unpackingpxp/frm_uploadshipmentplan" class="btn btn-warning btn-sm"><i class="fa fa-upload"></i> Upload</a> -->

                        <a href="<?php echo base_url(); ?>index.php/unpackingpxp" class="btn btn-primary btn-sm">Main Form</a>&nbsp;
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="background-color:;">

                    <div class="row">
                        <div class="col-lg-1">
                            <label class="col-form-label">PartNo 1</label>
                            <div class="input-group">
                                <input id="txtCari1" name="txtCari1" type="text" class="form-control form-control-sm" autocomplete="on">
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <label class="col-form-label">Part Name</label>
                            <div class="input-group">
                                <input id="txtCari2" name="txtCari2" type="text" class="form-control form-control-sm" autocomplete="on">
                            </div>
                        </div>
                        <div class="col-lg-2" style="display:;">
                            <label class="col-form-label">Special Part</label>
                            <div class="input-group">
                                <select name="txtCari3" id="txtCari3" class="form-control form-control-sm">
                                    <option value="">All Part</option>
                                    <option value="no">General Part</option>
                                    <option value="yes">Special Part</option>
                                </select>

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
                            <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                                <thead>
                                    <th class="text-center">No</th><!-- width="5%" -->
                                    <th class="text-center">PartNo 1</th>
                                    <th class="text-center">PartNo 2</th>
                                    <th class="text-center">PartName</th>
                                    <th class="text-center">Qty Box</th>
                                    <th class="text-center">Qty Unit</th>
                                    <th class="text-center">Qty Safety Stock</th>
                                    <th class="text-center">Qty End Stock</th>
                                    <th class="text-center">Qty Last STO</th>
                                    <th class="text-center">NW</th>
                                    <th class="text-center">Supply</th>
                                    <th class="text-center">Part Address OLN</th>
                                    <th class="text-center">Hamidasi Address</th>
                                    <th class="text-center">Part Address HML</th>
                                    <th class="text-center">Project</th>
                                    <th class="text-center">OLN Line</th>
                                    <th class="text-center">Special Part</th>
                                    <th class="text-center">Action</th>
                                </thead>


                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php require_once("view_masterpart_form.php"); ?>

</section>



<script>
    let dtTable;
    let vmessageTop = "Master Part ";

    /* model lama jquery ui */
    /* $('#tglstnk').datepicker({
      autoclose: true,
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
    }); */

    /* model bawaan template adminlte3 */
    var dateNow = new Date();
    $('#last_stodate').datetimepicker({
        defaultDate: dateNow,
        format: 'YYYY-MM-DD',
        date: moment()
    });

    var dataUrl = '<?php echo base_url(); ?>index.php/Unpackingpxpdata/blank_data';

    function getDtTable() {

        //akalin uri segment ci biar terima parameter kosong di sql
        $('#txtCari1').val().length > 0 ? param1 = $('#txtCari1').val() : param1 = "_BLANK_";
        $('#txtCari2').val().length > 0 ? param2 = $('#txtCari2').val() : param2 = "_BLANK_";
        $('#txtCari3').find(":selected").val().length > 0 ? param3 = $('#txtCari3').find(":selected").val() : param3 = "_BLANK_";

        dataUrl1 = '<?php echo base_url(); ?>index.php/masterpart/data';
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
                    data: 'partno1',
                    'className': 'text-center'
                },
                {
                    data: 'partno2',
                    'className': 'text-center'
                },
                {
                    data: 'part_name',
                    'className': ''
                },
                {
                    data: 'qty_box',
                    'className': 'text-right'
                },
                {
                    data: 'qty_unit',
                    'className': 'text-right'
                },
                {
                    data: 'qty_safety_stock',
                    'className': 'text-right'
                },
                {
                    data: 'qty_endstock',
                    'className': 'text-right'
                },
                {
                    data: 'last_sto_qty',
                    'className': 'text-right'
                },
                {
                    data: 'nw',
                    'className': 'text-right'
                },
                {
                    data: 'supply',
                    'className': ''
                },
                {
                    data: 'part_address_oln',
                    'className': 'text-center'
                },
                {
                    data: 'hamidasi_address',
                    'className': 'text-center'
                },
                {
                    data: 'part_address_hml',
                    'className': 'text-center'
                },
                {
                    data: 'project',
                    'className': 'text-center'
                },
                {
                    data: 'oln_line',
                    'className': 'text-center'
                },
                {
                    data: 'is_special_part',
                    'className': 'text-center'
                },
                {
                    data: 'aksi',
                    'className': 'text-center'
                },
            ]
        });

        $('#modal-form').validator().on('submit', function(e) {
            if (!e.preventDefault()) {

                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((datajson) => {
                        $('#modal-form').modal('hide');
                        dtTable.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data ' + errors);
                        return;
                    });
            }
        });
    });

    function fDataReload() {
        dtTable.ajax.reload();
        alert("reload sukses");
    }

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Add New Master Part ');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        //$('#modal-form [name=nama]').focus();
    }

    function editForm(url, updateUrl) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Master Part ');

        $('#modal-form form')[0].reset();

        $('#modal-form form').attr('action', updateUrl);

        $('#modal-form [name=_method]').val('put');
        //$('#modal-form [name=_method]').val('post');

        $('#partno1').focus();

        $.get(url)
            .done((response) => {

                datajson = JSON.parse(response);

                $('#modal-form [name=partno1]').val(datajson.partno1);
                $('#modal-form [name=partno2]').val(datajson.partno2);
                $('#modal-form [name=part_name]').val(datajson.part_name);
                $('#modal-form [name=qty_box]').val(datajson.qty_box);
                $('#modal-form [name=qty_unit]').val(datajson.qty_unit);
                $('#modal-form [name=qty_safety_stock]').val(datajson.qty_safety_stock);
                $('#modal-form [name=nw]').val(datajson.nw);
                $('#modal-form [name=supply]').val(datajson.supply);
                $('#modal-form [name=part_address_oln]').val(datajson.part_address_oln);
                $('#modal-form [name=hamidasi_address]').val(datajson.hamidasi_address);
                $('#modal-form [name=part_address_hml]').val(datajson.part_address_hml);
                $('#modal-form [name=project]').val(datajson.project);
                $('#modal-form [name=oln_line]').val(datajson.oln_line);
                $('#modal-form [name=qty_endstock]').val(datajson.qty_endstock);
                $('#modal-form [name=line_code]').val(datajson.line_code);

                $('#modal-form [name=is_special_part]').val(datajson.is_special_part).change();
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