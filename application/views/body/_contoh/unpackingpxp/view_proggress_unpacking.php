<section class="content">

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><span id="vJudulForm1"><b>PROGRESS UNPACKING</b></span></h3>
          <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->

            <button style="display:none;" onclick="fCariData()" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Cari</button>

            <button style="display:none;" onclick="fDataReload()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>


            <div style="display:;" class="btn-group" role="group" aria-label="Basic example">

              <button style="display:none;" onclick="addForm('http://intranet.isfa/hrs/armada/kendaraan')" type="button" class="btn btn-warning btn-sm"><i class="fa fa-upload"></i> Upload</button>
            </div>

            <a href="<?php echo base_url(); ?>index.php/unpackingpxp" class="btn btn-primary btn-sm">Main Form</a>&nbsp;
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="background-color:;">

          <div class="row">
            <!-- <div class="col-lg-1">
              <label class="col-form-label">Type Case</label>
              <div class="input-group">
                <input id="txtCari1" name="txtCari1" type="text" class="form-control form-control-sm">
              </div>
            </div>
            <div class="col-lg-1">
              <label class="col-form-label">Case No</label>
              <div class="input-group">
                <input id="txtCari2" name="txtCari2" type="text" class="form-control form-control-sm">
              </div>
            </div> -->
            <div class="col-lg-2">
              <label class="col-form-label">Work Date</label>
              <div class="input-group">
                <!-- <input id="txtCari3" name="txtCari3" type="text" class="form-control form-control-sm"> -->
                <input id="txtCari3" name="txtCari3" required readonly type="text" autocomplete="off" data-target="#txtCari3" data-toggle="datetimepicker" class="form-control datetimepicker-input form-control-sm" />

                <div class="input-group-append" data-target="#txtCari3" data-toggle="datetimepicker">
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
            <div class="col-lg-12"></div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                <thead>
                  <th class="text-center">No</th><!-- width="5%" -->
                  <th class="text-center">KeyCode</th>
                  <th class="text-center">Case No</th>
                  <th class="text-center">Part No</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Work Date</th>
                  <th class="text-center">Work Time</th>
                  <th class="text-center">User</th>
                </thead>


              </table>
            </div>
          </div>

        </div>

      </div>
    </div>
</section>



<script>
  let dtTable;
  let vmessageTop = "PROGRESS UNPACKING  ";
  let vJudulForm = "Unpacking PXP HML - Progress Unpacking List";
  $('#vJudulForm1').text(vJudulForm);

  /* model lama jquery ui */
  /* $('#tglstnk').datepicker({
    autoclose: true,
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    changeYear: true
  }); */

  /* model bawaan template adminlte3 */
  var dateNow = new Date();
  $('#txtCari3').datetimepicker({
    defaultDate: dateNow,
    format: 'YYYY-MM-DD',
    date: moment()
  });

  var dataUrl = '<?php echo base_url(); ?>index.php/Unpackingpxpdata/blank_data';

  function getDtTable() {
    //akalin uri segment ci biar terima parameter kosong di sql
    $('#txtCari3').val().length > 0 ? param1 = $('#txtCari3').val() : param1 = "_BLANK_";
    //$('#txtCari2').val().length > 0 ? param2 = $('#txtCari2').val() : param2 = "_BLANK_";

    dataUrl1 = '<?php echo base_url(); ?>index.php/Unpackingpxpdata/get_machining_unpacking_inprogress';

    dataUrl = dataUrl1 + "/" + param1; // + "/" + param2; // + "/" + param3;
    //console.log(dataUrl);
    dtTable.ajax.url(dataUrl).load();
  }


  $(function() {
    dtTable = $('#tabel1').DataTable({
      "columnDefs": [
        // Hide second, third and fourth columns
        // {
        //   "visible": false,
        //   "targets": [7, 8]
        // }
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
          data: 'keycode'
        },
        {
          data: 'caseno'
        },
        {
          data: 'partno'
        },
        {
          data: 'qty',
          'className': 'text-right'
        },
        {
          data: 'status',
          'className': 'text-center'
        },
        {
          data: 'workdate',
          'className': 'text-center'
        },
        {
          data: 'worktime',
          'className': 'text-center'
        },
        {
          data: 'username'
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
    $('#modal-form .modal-title').text('Tambah Kendaraan ');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('post');
    $('#modal-form [name=nama]').focus();
  }

  function editForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Kendaraan ');

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
          dtTable.ajax.reload();
        })
        .fail((errors) => {
          alert('Tidak dapat menghapus data');
          return;
        });
    }
  }
</script>