<section class="content">

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><span id="vJudulForm1"><b>STOCK</b></span></h3>
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
            <div class="col-lg-1">
              <label class="col-form-label">PartNo 1</label>
              <div class="input-group">
                <input id="txtCari1" name="txtCari1" type="text" class="form-control form-control-sm">
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
                  <th class="text-center">Line Code</th>
                  <th class="text-center">PartNo 1</th>
                  <th class="text-center">PartNo 2</th>
                  <th class="text-center">Part Name</th>
                  <th class="text-center">Qty End Stock</th>
                  <th class="text-center">Last Update Date</th>
                  <th class="text-center">Last Update Time</th>
                  <th class="text-center">Last STO Date</th>
                  <th class="text-center">Last STO Qty</th>
                  <!-- <th class="text-center">Action</th> -->
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
  let vmessageTop = "STOCK  ";
  let vJudulForm = "Unpacking PXP HML - Stock List";
  $('#vJudulForm1').text(vJudulForm);

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


  var dataUrl = '<?php echo base_url(); ?>index.php/Unpackingpxpdata/blank_data';

  function getDtTable() {
    dataUrl1 = '<?php echo base_url(); ?>index.php/Unpackingpxpdata/get_machining_stock_data';
    dataUrl = dataUrl1 + "/" + $('#txtCari1').val();
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
          data: 'line_code',
          'className': 'text-center'
        },
        {
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
          data: 'qty_endstock',
          'className': 'text-right'
        },
        {
          data: 'last_updatedate',
          'className': 'text-center'
        },
        {
          data: 'last_updatetime',
          'className': 'text-center'
        },
        {
          data: 'last_stodate',
          'className': 'text-center'
        },
        {
          data: 'last_sto_qty',
          'className': 'text-center'
        },
        /* {
          data: 'aksi',
          'className': 'text-center'
        }, */
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