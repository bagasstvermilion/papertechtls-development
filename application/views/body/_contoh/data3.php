<section class="content">
                
                <div class="row">
    <div class="col-md-12">                
        <div class="card">
            <div class="card-header">
              <h3 class="card-title"><span id="vJudulForm1">vJudulForm1</span></h3>
              <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                
                <input id="txtCari" name="txtCari" value="ATM" placeholder="Tujuan" type="text" class="form-control form-control-sm">

                <button style="display:;" onclick="fCariData()" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Cari</button>

                <button style="display:;" onclick="fDataReload()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>
                
                    
                <div class="btn-group" role="group" aria-label="Basic example">
                    
                    <button onclick="addForm('http://intranet.isfa/hrs/armada/kendaraan')" type="button" class="btn btn-warning btn-xs"><i class="fa fa-plus-circle"></i> Tambah</button>
                  </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                
            </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <form action="" method="post" class="form-horizontal">

            <input type="hidden" name="_token" value="Ir9whjd5Tm1IW5vBxyVYvHb2fE1zu5BHcNx6hPeM">            <input type="hidden" name="_method" value="post">
            <div class="modal-content">
                <div class="modal-header alert-light">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                    <thead>                        
                        <th><input type="checkbox" name="select_all" value="1" id="dataTable-select-all">All</th>
                        <th class="text-center">No</th><!-- width="5%" -->
                        <th class="text-center">ID</th>
                        <th class="text-center">Nama</th>                        
                        <th class="text-center">Tahun</th>                        
                        <th class="text-center">State</th>
                        <th class="text-center">QRCode</th>
                    </thead>            
                </table>
                 

                    <div class="form-group row">                                                
                        <div class="col-lg-6">
                            <label class="col-form-label">Nama</label>
                            <input autofocus type="text" name="nama" id="nama" placeholder="Contoh: AVANZA 1.3 E STD MT" class="form-control form-control-sm" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label" >No. POL</label>
                            <div class="input-group">
                                <!-- <span class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-code"></i>
                                    </span>
                                </span> -->
                                <input id="nopol" name="nopol" placeholder="T-1234-BC" type="text" class="form-control form-control-sm" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">                                                
                        <div class="col-lg-4">
                            <label class="col-form-label">Tahun</label>
                            <input autofocus type="number" name="tahun" id="tahun" class="form-control form-control-sm" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label" >Warna</label>
                            <div class="input-group">          
                                <input id="warna" name="warna" type="text" class="form-control form-control-sm form-control form-control-sm-sm" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label" >Merk</label>
                            <div class="input-group">          
                                <input id="idmerk" name="idmerk" placeholder="HINO" type="text" class="form-control form-control-sm" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">                                                
                        <div class="col-lg-4">
                            <label class="col-form-label">Transmisi</label>
                            <select name="transmisi" id="transmisi" class="form-control form-control-sm">
                                <option value="MANUAL">MANUAL</option>
                                <option value="AUTOMATIC">AUTOMATIC</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label" >Tgl Pajak</label>
                            <div class="input-group">          
                                <input id="tglpajak" name="tglpajak" type="text" class="form-control form-control-sm datepicker" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label" >Tgl STNK</label>
                            <div class="input-group">
                                        
                                        <input id="tglstnk" required readonly type="text"  autocomplete="off" data-target="#tglstnk" data-toggle="datetimepicker" class="form-control datetimepicker-input form-control-sm"/>

                                        <div class="input-group-append" data-target="#tglstnk" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                        </div>
                        
                    </div>
                    <div class="form-group row">                                                
                        <div class="col-lg-4">
                            <label class="col-form-label">No. Rangka</label>
                            <input autofocus type="text" name="norangka" id="norangka" class="form-control form-control-sm" required autofocus>
                        </div>
                        
                        <div class="col-lg-4">
                            <label class="col-form-label" >cekboxListValues</label>
                            <div class="input-group">          
                                <input id="cekboxListValues" name="cekboxListValues" type="text" class="form-control form-control-sm form-control form-control-sm-sm" required>
                            </div>
                        </div>
                        <!--
                        <div class="col-lg-4">
                            <label class="col-form-label" >Merk</label>
                            <div class="input-group">          
                                <input id="idmerk" name="idmerk" placeholder="HINO" type="text" class="form-control form-control-sm" required>
                            </div>
                        </div>
                    -->
                    </div>
                   
                    
                <div class="modal-footer alert-light">
                    <button class="btn btn-sm btn-flat btn-danger" id="btn"><i class="fa fa-save"></i> Get check box value</button>
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
                
        </form>
    </div>
</div>
            </section>
            <!-- /.content -->
        </div>

<script>    
    

    let table;
    let vmessageTop="Kehadiran Karyawan Subkon ";

    var today = moment().format('YYYY-MM-DD'); //YYYY-MM-DD HH:mm
    //$('#tglmasuk').val(today);
    

   var dateNow = new Date();
    $('#tglstnk').datetimepicker({        
        defaultDate:dateNow,
        format: 'YYYY-MM-DD',
        date: moment()
    });


    let dataTable;
    let vJudulForm = "Kendaraan";
    $('#vJudulForm1').text(vJudulForm);

    let defaultDataUrl = '<?php echo base_url(); ?>index.php/welcome/get_data3';
    let blankDataUrl = '<?php echo base_url(); ?>index.php/blankdatatable';
    let dataUrl = defaultDataUrl;

    $('#tglpajak').datepicker({autoclose: true, dateFormat: 'yy-mm-dd', changeMonth:true, changeYear : true});
    $('#tglstnk').datepicker({autoclose: true, dateFormat: 'yy-mm-dd', changeMonth:true, changeYear : true});

   
    $(function getData() {
        dataTable = $('#tabel1').DataTable({
            "columnDefs": [
                /*
                {
                    // Hide second, third and fourth columns
                    "visible": false, "targets": [7, 8] 
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                    "className": 'dt-body-center',
                    "render": function (data, type, full, meta) {
                        return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                    }
                }
                */
            ],
            "processing": true, "autoWidth": false, "responsive": false, "bLengthChange": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom:"<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
            /*dom:"<'row'<'col-sm-9 text-left'B><'col-sm-3'f>>" +*/
            "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            /*"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis","pageLength"],*/
            "buttons": 
            [/*"copy", "csv", "excel", "pdf", "print"*/
                ,{
                    extend: 'pdfHtml5',
                    text:      '<i class="fas fa-file-pdf"></i> ',
                    titleAttr: 'Export to PDF',
                    className: 'btn',
                    download: 'open', /* otomatis terbuka di browser tanpa download dulu */
                    orientation: 'landscape', /* landscape atau portrait */
                    pageSize: 'A4',
                    header: true,
                    messageBottom: "messageBottom",
                    messageTop: "messageTop",
                    footer: true,
                    title: "Judul",
                    exportOptions: {
                        //columns: ':visible:not(:first-child)' /* print kolom tertentu saja */
                        stripHtml : true,
                        columns: [1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'excel',
                    autoFilter: true,
                    text:      '<i class="fas fa-file-excel"></i> ',
                    titleAttr: 'Export to Excel',
                    className: 'btn',
                    messageTop: vJudulForm,
                    title: null,
                    exportOptions: {
                        columns: ':visible:not(:last-child)', /* print kolom tertentu saja */
                        /*modifier: { page: 'current' }*/ //to save only the data shown on the current DataTable page
                    }
                }, 
                {
                    extend: 'print',
                    text:      '<i class="fas fa-print"></i> ',
                    titleAttr: 'Print',
                    className: 'btn',
                    messageTop: vJudulForm,
                    title: '&nbsp;',
                    exportOptions: {                        
                        stripHtml : false,
                        columns: [1, 2, 3, 4, 5, 6] 
                    }
                }, 
                {
                    extend: 'csv',
                    text:      '<i class="fas fa-file-csv"></i> ',
                    titleAttr: 'Export to CSV',
                    className: 'btn',
                    messageTop: vJudulForm,
                    title: '',
                    exportOptions: {
                        columns: ':visible:not(:last-child)' /* print kolom tertentu saja */
                    }
                },
                {
                    extend: 'copy',
                    text:      '<i class="fas fa-copy"></i> ',
                    titleAttr: 'Copy to ClipBoard',
                    className: 'btn',
                    messageTop: vJudulForm,
                    title: '',
                    exportOptions: {
                        columns: ':visible:not(:last-child)' /* print kolom tertentu saja */
                    }
                },
                {
                    text: '<i class="fa fa-search"></i>',
                    titleAttr: 'Load Data',
                    attr: {
                        id: 'myBtnLoadData'
                    }
                },
                { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'}
                /*,{ extend: 'csv', className: 'btn purple btn-outline ' }*/
                /*, "colvis"*/
            ]
            ,"scrollCollapse": true,
            "scrollY": "300px",
            "paging": true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: dataUrl,
            },
            /*prerender:true,*/
                "language": {
                "search": "_INPUT_",            // Removes the 'Search' field label
                "searchPlaceholder": "Nomor PO" // Placeholder for the search box
            },
            columns: [
                {
                    data: 'id', 'className': 'text-center', searchable: false, sortable: false,
                        "render": function (data, type, full, meta) 
                        {
                            return '<input onclick="myfunk(' + data + ')" class="cekboxDTabel" type="checkbox" name="id[]" value="' + data + '">';
                            //"render": function ( data, type, row, meta ) {
                            //return '<input type="text" value="'+data+'">';
                        }
                },
                {data: 'DT_RowIndex', 'className': 'text-center', searchable: false, sortable: true},
                {data: 'id', 'className': 'text-center' },
                {data: 'tujuan'},                
                {data: 'keperluan', 'className': 'text-center' },
                {data: 'state', 'className': 'text-center' },
                {data: 'qrcode', 'className': 'text-center' },

            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((datajson) => {
                        $('#modal-form').modal('hide');
                        dataTable.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data '+errors);
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

    function fDataReload(){
        dataUrl = defaultDataUrl;
        alert(dataUrl);
        dataTable.ajax.url(dataUrl).load();
        dataTable.ajax.reload();
    }

    function addForm(url) {
        $('#modal-form').modal('show');

        $("#dataTable-select-all").removeAttr('checked');
        dataTable.ajax.url(defaultDataUrl + "/SET_NO_DATA").load(); //test load no data
        dataTable.ajax.reload();
        //dataTable.clear().draw();


        $('#modal-form .modal-title').text('Tambah ' + vJudulForm);

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit ' + vJudulForm);

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#nama').focus();

        $.get(url)
            .done((datajson) => {
                $('#modal-form [name=nama]').val(datajson.nama);
                $('#modal-form [name=nopol]').val(datajson.nopol);
                $('#modal-form [name=tahun]').val(datajson.tahun);
                $('#modal-form [name=warna]').val(datajson.warna);
                $('#modal-form [name=idmerk]').val(datajson.idmerk);
                $('#modal-form [name=transmisi]').val(datajson.transmisi);
                $('#modal-form [name=tglpajak]').val(datajson.tglpajak);
                $('#modal-form [name=tglstnk]').val(datajson.tglstnk);
                $('#modal-form [name=nama]').focus();
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
    $(document).ready(function()
    {
        
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
            }else{
                alert("reload default data");
                dataTable.ajax.url(defaultDataUrl).load();
            }
            //dataTable.ajax.reload();
        });


        // Handle click on "Select all" control
        $('#dataTable-select-all').on('click', function(){
            // Get all rows with search applied
            var rows = dataTable.rows({ 'search': 'applied' }).nodes();
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
        $(document).on('click', '#btn', function () {
            var matches = [];
            var checkedcollection = dataTable.$(".cekboxDTabel:checked", { "page": "all" });
            checkedcollection.each(function (index, elem) {
                matches.push($(elem).val());
            });

            var AccountsJsonString = matches;//JSON.stringify(matches);
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
        console.log('checked id='+value);
        deblo.push(value); //
        
    }else{
        console.log('not checked id='+value);
        var indexDeblo = deblo.indexOf(value);
            if (indexDeblo > -1) {
                deblo.splice(indexDeblo, 1);
            }
    }
    $('#cekboxListValues').val(deblo);
});


//var today = moment().format('YYYY-MM-DD'); //YYYY-MM-DD HH:mm

var date  = moment("20170101", "YYYYMMDD");
var date7 = moment("20170108", "YYYYMMDD");

var date1 = moment("2019-12-24 23:00", "YYYY-MM-DD HH:mm"); //H atau HH 24 hour format
var date2 = moment("2019-12-25 01:00", "YYYY-MM-DD HH:mm");
//var secs1 = moment("20170101 00:00:01", "YYYYMMDD HH:mm:ss");

//console.log(date7.diff(date, "days")    + "d"); // "7d"
//console.log(mins7.diff(date, "minutes") + "m"); // "7m"
//console.log(secs1.diff(date, "seconds") + "s"); // "1s"
var selisih = date2.diff(date1, 'hours');
console.log(selisih); // "1s"

// Requiring the module
//const moment = require('moment');
  
var dateOne = moment(Array('2022', '06', '23', '23', '00')); //YYYY mm dd HH mm
var dateTwo = moment(Array('2022', '06', '24', '01', '00'));
  
// Function call
var result = dateTwo.diff(dateOne, 'hours');
var result1 = dateTwo.diff(dateOne, 'minutes');
  
console.log("No of hours:", result, "Minutes:", result1);




var det1 = moment('2019-12-24 22:00:00', "YYYY-MM-DD HH:mm:ss", true);
var det2 = moment('2019-12-24 23:10:00', "YYYY-MM-DD HH:mm:ss", true);
var resultx = det2.diff(det1, 'hours');
var resulty = det2.diff(det1, 'minutes');

console.log(resulty % 60);


let currentDateTm = moment().utcOffset('+0700').format('YYYY-MM-DD HH:mm')
console.log(currentDateTm)
</script>        