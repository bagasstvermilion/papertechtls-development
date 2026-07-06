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
                    <h3 class="card-title"><span id="vJudulForm1"><b>CS Upload History</b></span></h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->

                        <button style="display:none;" onclick="fCariData()" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Cari</button>

                        <button style="display:none;" onclick="fDataReload()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>


                        <div style="display:none;" class="btn-group" role="group" aria-label="Basic example">

                            <a href="<?php echo base_url(); ?>index.php/doctype" class="btn btn-primary btn-sm">Document Type</a>&nbsp;

                            <button onclick="addForm('<?php echo base_url(); ?>index.php/document/store')" type="button" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Create</button>
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
                        <div class="col-lg-2" style="display:;">
                            <label class="col-form-label">From Date</label>
                            <div class="input-group">
                                <input id="txtCari1" name="txtCari1" required readonly type="text" autocomplete="off" data-target="#txtCari1" data-toggle="datetimepicker" class="form-control datetimepicker-input form-control-sm" />

                                <div class="input-group-append" data-target="#txtCari1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2" style="display:;">
                            <label class="col-form-label">To Date</label>
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
                            <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                                <thead>
                                    <th class="text-center">No</th><!-- width="5%" -->
                                    <th class="text-center">File Name</th>
                                    <th class="text-center">Row Data</th>
                                    <th class="text-center">Upload By</th>
                                    <th class="text-center">Upload At</th>
                                </thead>

                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php //require_once("document_input_form.php");
    ?>
    <?php //require_once("document_attachment_form.php");
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
                }, {
                    data: 'filename',
                    'className': 'text-left'
                },
                {
                    data: 'jmlrowdata',
                    'className': 'text-center'
                },
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
        $('#modal-form .modal-title').text('Add New Document Reminder ');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        //$('#modal-form [name=nama]').focus();
        $('#modal-form [name=pic]').val('<?php echo $this->session->userdata('username'); ?>');
        $('#modal-form [id=pic_name]').text('<?php echo $this->session->userdata('nmuser'); ?>');
        $('#modal-form [id=div_status]').css('display', 'none');
    }

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

                datajson = JSON.parse(response);

                $('#modal-form [name=iddept]').val(datajson.iddept).change();
                $('#modal-form [name=iddoctype]').val(datajson.iddoctype).change();
                $('#modal-form [name=company]').val(datajson.company).change();

                $('#modal-form [name=company]').val(datajson.company);
                $('#modal-form [name=docno]').val(datajson.docno);
                $('#modal-form [name=description]').val(datajson.description);
                $('#modal-form [name=term]').val(datajson.term);
                $('#modal-form [name=startdate]').val(datajson.startdate);
                $('#modal-form [name=enddate]').val(datajson.enddate);
                $('#modal-form [name=remark]').val(datajson.remark);
                $('#modal-form [name=phone]').val(datajson.phone);
                $('#modal-form [name=pic]').val(datajson.pic);

                $('#modal-form [name=status]').val(datajson.status).change();

                $('#modal-form [name=contact]').val(datajson.contact);
                $('#modal-form [id=pic_name]').text(datajson.pic_name);

                $('#modal-form [id=div_status]').css('display', '');

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