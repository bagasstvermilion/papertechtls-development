<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">

        <form action="" method="post" class="form-horizontal">

            <!-- <input type="hidden" name="_token" value="Ir9whjd5Tm1IW5vBxyVYvHb2fE1zu5BHcNx6hPeM"><input type="hidden" name="_method" value="post"> -->

            <div class="modal-content">
                <div class="modal-header alert-light">
                    <h4 class="modal-title">Detail Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Tanggal Jadwal</label>
                            <input type="text" name="tanggal_jadwal" id="tanggal_jadwal" placeholder="" class="form-control form-control-sm" readonly required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">No Tiket</label>
                            <div class="input-group">
                                <!-- <span class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-code"></i>
                                    </span>
                                </span> -->
                                <input id="trans_no" name="trans_no" placeholder="" type="text" class="form-control form-control-sm" readonly required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">No Antrian</label>
                            <input id="no_antrean" name="no_antrean" placeholder="" type="text" class="form-control form-control-sm" readonly required>
                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">No Polisi</label>
                            <input id="no_polisi" name="no_polisi" placeholder="" type="text" class="form-control form-control-sm" readonly required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tabel2" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
                                <thead>
                                    <th class="text-center">No</th><!-- width="5%" -->
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Area</th>
                                    <th class="text-center">Urutan Bongkar</th>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Weight</th>
                                    <th class="text-center">Color</th>
                                    <th class="text-center">Pattern Nose</th>
                                    <th class="text-center">Qty Box</th>
                                    <th class="text-center">Qty Pcs</th>
                                    <th class="text-center">Qty Box Total</th>
                                    <th class="text-center">Status Produk</th>
                                    <th class="text-center">Berat Total</th>
                                    <th class="text-center">Berat Box</th>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>


                <div class="modal-footer alert-light" style="display: none;">
                    <!-- <button class="btn btn-sm btn-flat btn-danger" id="btn"><i class="fa fa-save"></i> Get check box value</button> -->
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancel</button>
                </div>

        </form>
    </div>
</div>