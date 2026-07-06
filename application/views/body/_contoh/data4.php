<section class="content">
                
                <div class="row">
    <div class="col-md-12">                
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Kendaraan </h3>
              <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <button style="display:;" onclick="fDataReload()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>
                
                    
                <div class="btn-group" role="group" aria-label="Basic example">
                    
                    <button onclick="addForm('http://intranet.isfa/hrs/armada/kendaraan')" type="button" class="btn btn-warning btn-xs"><i class="fa fa-plus-circle"></i> Tambah</button>
                  </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                    <thead>                        
                        <th class="text-center">No</th><!-- width="5%" -->
                        <th class="text-center">Nama</th>
                        
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Merk</th>
                        <th class="text-center">Transmisi</th>
                        <th class="text-center">Tgl Pajak</th>
                        <th class="text-center">Tgl Stnk</th>
                        <th class="text-center">No. Rangka</th>
                        <th class="text-center">No. Mesin</th>
                        <th class="text-center">No. STNK</th>
                        <th class="text-center">No. BPKB</th>
                        <th class="text-center">Atas Nama</th>
                        <th class="hideme">Aksi <i class="fa fa-cog"></i></th><!-- width="15%" -->
                    </thead>

                    <tfoot>                        
                        <th class="text-center">No</th><!-- width="5%" -->
                        <th class="text-center">Nama</th>
                        
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Merk</th>
                        <th class="text-center">Transmisi</th>
                        <th class="text-center">Tgl Pajak</th>
                        <th class="text-center">Tgl Stnk</th>
                        <th class="text-center">No. Rangka</th>
                        <th class="text-center">No. Mesin</th>
                        <th class="text-center">No. STNK</th>
                        <th class="text-center">No. BPKB</th>
                        <th class="text-center">Atas Nama</th>
                        <th class="hideme">Aksi <i class="fa fa-cog"></i></th><!-- width="15%" -->
                    </tfoot>
                </table>
            </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
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
                                <input id="tglstnk" name="tglstnk" type="text" class="form-control form-control-sm datepicker" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">                                                
                        <div class="col-lg-4">
                            <label class="col-form-label">No. Rangka</label>
                            <input autofocus type="text" name="norangka" id="norangka" class="form-control form-control-sm" required autofocus>
                        </div>
                        <!--
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
                    -->
                    </div>

                </div>
                <div class="modal-footer alert-light">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
            </section>
            <!-- /.content -->
        </div>

<script>
    let table;
    let vmessageTop="Kendaraan ";

    $('#tglpajak').datepicker({autoclose: true, dateFormat: 'yy-mm-dd', changeMonth:true, changeYear : true});
    $('#tglstnk').datepicker({autoclose: true, dateFormat: 'yy-mm-dd', changeMonth:true, changeYear : true});

   
    $(function () {
        table = $('.table').DataTable({
            "columnDefs": [
                // Hide second, third and fourth columns
                { "visible": false, "targets": [7, 8] }
            ],
            "processing": true, "autoWidth": false, "responsive": false, "bLengthChange": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom:"<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
            /*dom:"<'row'<'col-sm-9 text-left'B><'col-sm-3'f>>" +*/
            "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            /*"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis","pageLength"],*/
            "buttons": ["copy", "csv", "excel", "pdf", "print"
            ,{
                extend: 'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> ',
		        titleAttr: 'Export to PDF',
                className: 'btn',
                messageTop: vmessageTop,
                exportOptions: {
                    columns: ':visible:not(:last-child)' /* print kolom tertentu saja */
                }
            }, 
            { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'}
            /*,{ extend: 'csv', className: 'btn purple btn-outline ' }*/
            /*, "colvis"*/]
            ,"scrollCollapse": true,
            "scrollY": "300px",
            "paging": true,
            processing: true,
            serverSide: false,
            autoWidth: false,
            ajax: {
                url: '<?php echo base_url(); ?>index.php/welcome/get_data4',
            },
            columns: [
                {data: 'DT_RowIndex', 'className': 'text-center', searchable: false, sortable: false},
                {data: 'nama'},
                
                {data: 'tahun', 'className': 'text-center' },
                {data: 'warna'},
                {data: 'idmerk'},
                {data: 'transmisi'},
                {data: 'norangka'},
                {data: 'nomesin'},
                {data: 'nostnk'},
                {data: 'nobpkb'},
                {data: 'atasnama'},
                {data: 'tglpajak', 'className': 'text-center' },
                {data: 'tglstnk', 'className': 'text-center' },
                {data: 'aksi', 'className': 'text-center' , searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((datajson) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data '+errors);
                        return;
                    });
            }
        });
    });

    function fDataReload(){
        table.ajax.reload();
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
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>        