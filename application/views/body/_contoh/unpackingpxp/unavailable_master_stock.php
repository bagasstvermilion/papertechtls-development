<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span id="vJudulForm1"><b>STOCK</b></span><span style="color: red">Unavailable Part Number Data in <b>***_data_stock table</b></span></h3>
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


                    <!-- <div class="row">
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
                    </div> -->


                    <div class="row">&nbsp;</div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                                <thead>
                                    <th class="text-center">No</th><!-- width="5%" -->

                                    <th class="text-center">PartNo 1</th>

                                    <th class="text-center">Part Name</th>
                                    <!-- <th class="text-center">Qty End Stock</th> -->
                                    <!-- <th class="text-center">Action</th> -->
                                </thead>
                                <?php
                                /* $sql = "SELECT distinct msp.partno, mmp.partno2, msp.partname  from machining_shipping_plan msp, machining_master_part mmp where msp.partno=mmp.partno1 and msp.partno in (
                                    SELECT mmp.partno1 from machining_stock_data msd right join machining_master_part mmp on msd.partno1=mmp.partno1 where msd.Qty_EndStock is null
                                    )"; */
                                $sql = "SELECT distinct concat('',CAST(partno as varchar)) partno, partname from machining_shipping_plan  where partno not in (select distinct partno1 from (
                                    select partno1 from machining_stock_data
                                    union
                                    select partno1 from machining_master_part
                                    ) as tabel1)";
                                //$rs = $this->db->query($sql)->row_array();
                                //print_r($row);
                                //$data['id'] = $row["id"];
                                $rs = $this->db->query($sql);
                                if ($rs->num_rows() > 0) {
                                    //$row = $this->db->query($sql)->row_array();
                                    //echo json_encode($row);

                                    $i = 0;
                                    foreach ($rs->result_array() as $row) {
                                        $i++;
                                ?>
                                        <tbody>
                                            <tr>
                                                <td class="text-center"><?php echo $i; ?></td><!-- widtd="5%" -->
                                                <td class="text-center"><?php echo $row['partno']; ?></td>

                                                <td class=""><?php echo $row['partname']; ?></td>
                                                <!-- <td class="text-center">[null]</td> -->
                                                <!-- <td class="text-center">Action</td> -->
                                            </tr>
                                    <?php }
                                } ?>
                                        </tbody>

                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
</section>



<script>
    let dtTable;
    let vmessageTop = "MACHINING STOCK  ";
    let vJudulForm = "Unpacking PXP HML - ";
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
        //$('#tabel1').DataTable();

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
            autoWidth: false
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