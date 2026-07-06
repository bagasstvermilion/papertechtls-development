<style type="text/css">
    table#tabel1.dataTable tbody tr:hover {
        background-color: #ffa;
    }

    table#tabel1.dataTable tbody tr:hover>.sorting_1 {
        background-color: #ffa;
    }
</style>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span id="vJudulForm1"><b>Document Type</b></span></h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->

                        <button style="display:none;" onclick="fCariData()" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Cari</button>

                        <button style="display:none;" onclick="fDataReload()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>


                        <div style="display:;" class="btn-group" role="group" aria-label="Basic example">

                            <a href="<?php echo base_url(); ?>index.php/document" class="btn btn-primary btn-sm">Document List</a>&nbsp;

                            <button onclick="addForm('<?php echo base_url(); ?>index.php/doctype/store')" type="button" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Create</button>
                        </div>

                        <!-- <a href="<?php echo base_url(); ?>index.php/unpackingpxp/frm_uploadshipmentplan" class="btn btn-warning btn-sm"><i class="fa fa-upload"></i> Upload</a> -->

                        <!-- <a href="<?php echo base_url(); ?>index.php/unpackingpxp" class="btn btn-primary btn-sm">Main Form</a>&nbsp; -->
                        <!-- <button onclick="addFormAttachment('<?php echo base_url(); ?>index.php/document/store')" type="button" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Att</button>

            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-sm">
              Launch Small Modal
            </button> -->

                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="background-color:;">



                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                                <thead>
                                    <th class="text-center">No</th><!-- width="5%" -->
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Is Active</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Created By</th>
                                    <?php if ($this->session->userdata('isadmin') == 'yes' || $this->session->userdata('ishod') == 'yes') { ?>
                                        <!-- <th class="text-center">Created By</th> -->
                                    <?php } ?>
                                    <th class="text-center">Action</th>
                                </thead>


                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php require_once("doctype_input_form.php");
    ?>

</section>



<div class="modal fade" id="modal-sm">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Small Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>

    </div>

</div>



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
    $('#startdate').datetimepicker({
        defaultDate: dateNow,
        format: 'YYYY-MM-DD',
        date: moment()
    });

    $('#enddate').datetimepicker({
        defaultDate: dateNow,
        format: 'YYYY-MM-DD',
        date: moment()
    });

    var dataUrl = '<?php echo base_url(); ?>index.php/doctype/data'; //'<?php echo base_url(); ?>index.php/Unpackingpxpdata/blank_data';

    function getDtTable() {

        //akalin uri segment ci biar terima parameter kosong di sql
        //$('#txtCari1').val().length > 0 ? param1 = $('#txtCari1').val() : param1 = "_BLANK_";    
        //$('#txtCari1').find(":selected").val().length > 0 ? param1 = $('#txtCari1').find(":selected").val() : param1 = "_BLANK_";
        //$('#txtCari2').find(":selected").val().length > 0 ? param2 = $('#txtCari2').find(":selected").val() : param2 = "_BLANK_";
        var param1;
        var param2;

        dataUrl1 = '<?php echo base_url(); ?>index.php/doctype/data';
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
                    data: 'name',
                    'className': 'text-left'
                },
                {
                    data: 'isactive',
                    'className': 'text-center'
                },
                {
                    data: 'created_at',
                    'className': 'text-center'
                },
                {
                    data: 'created_by',
                    'className': 'text-left'
                },
                <?php if ($this->session->userdata('isadmin') == 'yes' || $this->session->userdata('ishod') == 'yes') { ?>
                    /*{
                                         data: 'created_by',
                                        'className': 'text-left'
                                      }, */
                <?php } ?> {
                    data: 'aksi',
                    'className': 'text-center'
                },
            ]
        });

        $('#modal-form').validator().on('submit', function(e) {
            if (!e.preventDefault()) {

                //$.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                /* $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                  .done((datajson) => {
                    $('#modal-form').modal('hide');
                    dtTable.ajax.reload();
                  })
                  .fail((errors) => {
                    alert('Tidak dapat menyimpan data ' + errors);
                    return;
                  }); */

                //Get form
                var myform = $('#modal-form form')[0];

                //FormData object 
                var data = new FormData(myform);

                //If you want to add an extra field for the FormData
                //data.append("CustomField", "This is some extra data, testing");

                $.ajax({
                        url: $('#modal-form form').attr('action'),
                        type: 'POST',
                        data: data, //penggunaan FormData
                        async: false,
                        processData: false,
                        contentType: false,
                        cache: false,
                        /*datatype: 'json'*/
                    })
                    .done(function(data) {
                        console.log(data);
                        $('#modal-form').modal('hide');

                        //dtTable.ajax.reload();
                        getDtTable();

                    })
                    .fail(function(jqXHR, textStatus, errorThrown, errors) {
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


    function addFormAttachment(url) {
        $('#modal-form-attachment').appendTo("body").modal('show');
        //$('#modal-form-attachment').modal('show');
        $('#modal-form-attachment .modal-title').text('Add Attachment ');
    }


    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Add New Document Type ');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [id=name]').focus();
    }

    $('#modal-form').on('shown.bs.modal', function() {
        $('#name').focus();
    })

    function editForm(url, updateUrl) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Data ');

        $('#modal-form form')[0].reset();

        $('#modal-form form').attr('action', updateUrl);

        $('#modal-form [name=_method]').val('put');
        //$('#modal-form [name=_method]').val('post');

        $('#partno1').focus();

        $.get(url)
            .done((response) => {
                //console.log(response);

                datajson = JSON.parse(response);

                $('#modal-form [name=isactive]').val(datajson.isactive).change();
                $('#modal-form [name=name]').val(datajson.name);
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


    //modal jadi center screen  
    function alignModal() {
        var modalDialog = $(this).find(".modal-dialog");
        modalDialog.css("margin-top", Math.max(0,
            ($(window).height() - modalDialog.height()) / 2));
    }
    $(".modal").on("shown.bs.modal", alignModal);
</script>