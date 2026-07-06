<style type="text/css">
    table#tabel1.dataTable tbody tr:hover {
        background-color: #e1f5fe;
    }

    table#tabel1.dataTable tbody tr:hover>.sorting_1 {
        background-color: #e1f5fe;
    }
</style>


<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span id="vJudulForm1" style="display:none;">vJudulForm1</span><i data-lucide="shield-check"></i> <b style="color: #003366;">Keamanan & Akses Pengguna</b></h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->

                        <input style="display: none;" id="txtCari" name="txtCari" value="ATM" placeholder="Tujuan" type="text" class="form-control form-control-sm">

                        <button style="display:none;" onclick="fCariData()" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Cari</button>

                        <button style="display:none;" onclick="fDataReload()" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>

                        <div class="btn-group" role="group" aria-label="Basic example">

                            <button onclick="addForm('<?php echo base_url(); ?>index.php/login/store')" type="button" class="btn btn-warning btn-sm"><i class="fa fa-plus-circle"></i> Create</button>

                        </div>

                        <!-- <a href="<?php echo base_url(); ?>index.php/document" class="btn btn-primary btn-sm">Main Form</a> -->&nbsp;
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                        <thead>

                            <th class="text-center">No</th><!-- width="5%" -->
                            <th class="text-center">UserName</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Role</th>
                            <!-- <th class="text-center">Doc Type Access</th>
                            <th class="text-center">Dept</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Is Admin</th>
                            <th class="text-center">Is PIC</th>
                            <th class="text-center">Active</th> -->
                            <th class="text-center">Action</th>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <?php require_once("form.php"); ?>

</section>
<!-- /.content -->
</div>

<script>
    let table;
    let vmessageTop = "Kehadiran Karyawan Subkon ";

    var today = moment().format('YYYY-MM-DD'); //YYYY-MM-DD HH:mm
    //$('#tglmasuk').val(today);


    var dateNow = new Date();
    $('#tglstnk').datetimepicker({
        defaultDate: dateNow,
        format: 'YYYY-MM-DD',
        date: moment()
    });


    let dataTable;
    let vJudulForm = "Users";
    $('#vJudulForm1').text(vJudulForm);

    let defaultDataUrl = '<?php echo base_url(); ?>index.php/welcome/get_data3';
    let blankDataUrl = '<?php echo base_url(); ?>index.php/blankdatatable';
    let dataUrl = defaultDataUrl;

    $('#tglpajak').datepicker({
        autoclose: true,
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });
    $('#tglstnk').datepicker({
        autoclose: true,
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });


    $(function() {
        dataTable = $('#tabel1').DataTable({
            "columnDefs": [
                // Hide second, third and fourth columns
                /*{ "visible": false, "targets": [7, 8] }*/
            ],
            "processing": true,
            "autoWidth": false,
            "responsive": false,
            "bLengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                /*dom:"<'row'<'col-sm-9 text-left'B><'col-sm-3'f>>" +*/
                "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            /*"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis","pageLength"],*/
            "buttons": ["copy", "csv", "excel", "pdf", "print", {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> ',
                    titleAttr: 'Export to PDF',
                    className: 'btn',
                    messageTop: vmessageTop,
                    exportOptions: {
                        columns: ':visible:not(:last-child)' /* print kolom tertentu saja */
                    }
                },
                {
                    extend: 'colvis',
                    className: 'btn dark btn-outline',
                    text: 'Columns'
                }
                /*,{ extend: 'csv', className: 'btn purple btn-outline ' }*/
                /*, "colvis"*/
            ],
            "scrollCollapse": true,
            "scrollY": "300px",
            "paging": true,
            processing: true,
            serverSide: false,
            autoWidth: false,
            ajax: {
                url: '<?php echo base_url(); ?>index.php/login/data',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    'className': 'text-center',
                    searchable: false,
                    sortable: true
                },

                {
                    data: 'username'
                },
                {
                    data: 'name',
                    'className': ''
                },
                {
                    data: 'role',
                    'className': ''
                },
                /* {
                    data: 'doctype',
                    'className': ''
                },
                {
                    data: 'dept',
                    'className': 'text-left'
                },
                {
                    data: 'email',
                    'className': 'text-left'
                },
                {
                    data: 'isadmin',
                    'className': 'text-center'
                },
                {
                    data: 'ispic',
                    'className': 'text-center'
                },

                {
                    data: 'isactive',
                    'className': 'text-center'
                }, */
                {
                    data: 'aksi',
                    'className': 'text-center',
                    searchable: false,
                    sortable: false
                },
            ]
        });

        $(".dt-buttons").css({
            "display": "none"
        }); //hide tombol data table buttons

        $('#modal-form').validator().on('submit', function(e) {

            if ($("#passwrd").val() !== $("#passwrd1").val()) {
                alert('Konfirmasi password tidak sama');
                return false;
            }

            if (!e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((datajson) => {
                        $('#modal-form').modal('hide');
                        dataTable.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data ' + errors);
                        return;
                    });
            }
        });
    });

    function fCariData() {
        dataUrl = defaultDataUrl + "/" + $('#txtCari').val();
        alert(dataUrl);
        dataTable.ajax.url(dataUrl).load();
    }

    function fDataReload() {
        dataUrl = defaultDataUrl;
        alert(dataUrl);
        dataTable.ajax.url(dataUrl).load();
        dataTable.ajax.reload();
    }

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Add ' + vJudulForm);

        //$("#dataTable-select-all").removeAttr('checked');
        //dataTable.ajax.url(defaultDataUrl + "/SET_NO_DATA").load(); //test load no data
        //dataTable.ajax.reload();
        //dataTable.clear().draw();        

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');

        $('#modal-form [name=isactive]').val('yes').change();
        $('#modal-form [name=username]').removeAttr("readonly");
        //$('#modal-form [name=passwrd]').removeAttr("readonly");
        //$('#modal-form [name=passwrd1]').removeAttr("readonly");
        $('#modal-form [name=passwrd]').removeAttr("disabled");
        $('#modal-form [name=passwrd1]').removeAttr("disabled");
        $('#modal-form [name=username]').focus();
        document.getElementById('username').focus();
    }

    function editForm(url, urlUpdate) {

        //console.log(urlUpdate);

        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit ' + vJudulForm);

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', urlUpdate);
        $('#modal-form [name=_method]').val('put');

        $('#modal-form [name=passwrd]').attr('disabled', 'disabled');
        $('#modal-form [name=passwrd1]').attr('disabled', 'disabled');

        $('#name').focus();

        $.get(url)
            .done((response) => {
                datajson = JSON.parse(response);
                //console.log(datajson);                
                $('#modal-form [name=username]').val(datajson.username);
                $('#modal-form [name=username]').attr('readonly', 'readonly');

                $('#modal-form [name=name]').val(datajson.name).focus();
                //$('#modal-form [name=passwrd]').val(datajson.passwrd);

                $('#modal-form [name=isadmin]').val(datajson.isadmin).change(); //selected option
                $('#modal-form [name=ispic]').val(datajson.ispic).change();
                $('#modal-form [name=isgemba]').val(datajson.isgemba).change();
                $('#modal-form [name=isactive]').val(datajson.isactive).change();
                $('#modal-form [name=iddept]').val(datajson.iddept).change();

                //$('#modal-form [name=name]').focus();
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data ' + errors);
                return;
            });
    }

    function deleteData(url) {
        //alert(url);
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((datajson) => {
                    dataTable.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }

    /*$("#myBtnLoadData").on("click", function() {
        dataTable.ajax.url(defaultDataUrl).load();
        dataTable.ajax.reload();
        alert("reload default data");
    });*/

    //on window browser resize
    $(window).on("resize", function() {
        //alert("window on resize");
        //dataTable.ajax.reload();
    });

    //executes when HTML-Document is loaded and DOM is ready
    $(document).ready(function() {

        var txtCariDataTable = "";

        $('#tabel1').on('search.dt', function() {
            txtCariDataTable = $('.dataTables_filter input').val();
        });

        //set id to search input box of dataTable
        $('input[type=search]').attr('id', 'dTable-txtSearch');

        //alert("document is ready");
        $("#myBtnLoadData").on("click", function() {

            //alert($('input[type=search]').val());
            //alert(txtCariDataTable);

            if (txtCariDataTable.length > 0) {
                //dataTable.search(txtCariDataTable).draw();
                alert("pencarian data di kolom nama di tabel db");
                dataUrl = defaultDataUrl + "/" + txtCariDataTable;
                dataTable.ajax.url(dataUrl).load();
            } else {
                alert("reload default data");
                dataTable.ajax.url(defaultDataUrl).load();
            }
            //dataTable.ajax.reload();
        });


        // Handle click on "Select all" control
        $('#dataTable-select-all').on('click', function() {
            // Get all rows with search applied
            var rows = dataTable.rows({
                'search': 'applied'
            }).nodes();
            // Check/uncheck checkboxes for all rows in the table
            //$('input[type="checkbox"]', rows).prop('checked', this.checked);
            $('input[name="id[]"]', rows).prop('checked', this.checked);

            /*$('input[name="id[]"]:checked').each(function () {
                listvalues = this.toArray().map(x => x.value).join(', ');
            });*/
        });

        /*$("#btn").on('click', function(event){
            event.preventDefault();
            var searchIDs = $("input:checkbox:checked").map(function() {
                return this.value;
            }).toArray();
    
            console.log(searchIDs);
             $("#cekboxListValues").val(searchIDs);
        });
*/
        //oke kena semua
        $(document).on('click', '#btn', function() {
            var matches = [];
            var checkedcollection = dataTable.$(".cekboxDTabel:checked", {
                "page": "all"
            });
            checkedcollection.each(function(index, elem) {
                matches.push($(elem).val());
            });

            var AccountsJsonString = matches; //JSON.stringify(matches);
            console.log(AccountsJsonString);
            //alert(AccountsJsonString);
        });
    });


    //executes when complete page is fully loaded, including all frames, objects and images
    $(window).on("load", function() {
        var listvalues = [];
        $('.cekboxDTabel').on('change', function(event) {
            event.preventDefault();
            //$('#tabel1 input[type=checkbox]:checked').click(function(){
            //$('input[name="id[]"]').click(function(){
            listvalues = $('.cekboxDTabel:checked').toArray().map(x => x.value).join(', ');
            //$('#show').html(listvalues);
            alert(listvalues);
            $('#cekboxListValues').val(listvalues);
        });
        //alert("window is loaded");
        //dataTable.clear().draw(); //not work        
    });

    function myfunk(x) {
        //alert(x);
    }


    //checkbox di dataTable
    var deblo = new Array();

    $(document).on('change', '[name="id[]"]', function() {
        var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox

        if (checkbox.is(':checked')) {
            console.log('checked id=' + value);
            deblo.push(value); //

        } else {
            console.log('not checked id=' + value);
            var indexDeblo = deblo.indexOf(value);
            if (indexDeblo > -1) {
                deblo.splice(indexDeblo, 1);
            }
        }
        $('#cekboxListValues').val(deblo);
    });


    //var today = moment().format('YYYY-MM-DD'); //YYYY-MM-DD HH:mm

    var date = moment("20170101", "YYYYMMDD");
    var date7 = moment("20170108", "YYYYMMDD");

    var date1 = moment("2019-12-24 23:00", "YYYY-MM-DD HH:mm"); //H atau HH 24 hour format
    var date2 = moment("2019-12-25 01:00", "YYYY-MM-DD HH:mm");
    //var secs1 = moment("20170101 00:00:01", "YYYYMMDD HH:mm:ss");

    //console.log(date7.diff(date, "days")    + "d"); // "7d"
    //console.log(mins7.diff(date, "minutes") + "m"); // "7m"
    //console.log(secs1.diff(date, "seconds") + "s"); // "1s"
    var selisih = date2.diff(date1, 'hours');
    //console.log(selisih); // "1s"

    // Requiring the module
    //const moment = require('moment');

    var dateOne = moment(Array('2022', '06', '23', '23', '00')); //YYYY mm dd HH mm
    var dateTwo = moment(Array('2022', '06', '24', '01', '00'));

    // Function call
    var result = dateTwo.diff(dateOne, 'hours');
    var result1 = dateTwo.diff(dateOne, 'minutes');

    //console.log("No of hours:", result, "Minutes:", result1);


    var det1 = moment('2019-12-24 22:00:00', "YYYY-MM-DD HH:mm:ss", true);
    var det2 = moment('2019-12-24 23:10:00', "YYYY-MM-DD HH:mm:ss", true);
    var resultx = det2.diff(det1, 'hours');
    var resulty = det2.diff(det1, 'minutes');

    //console.log(resulty % 60);

    let currentDateTm = moment().utcOffset('+0700').format('YYYY-MM-DD HH:mm')
    //console.log(currentDateTm)
</script>