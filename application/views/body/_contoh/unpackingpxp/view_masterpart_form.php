<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <!--  data-backdrop="static" paksa user harus close modal tekan tombol close x -->

    <div class="modal-dialog modal-xl" role="document">

        <form action="" method="post" class="form-horizontal">

            <!-- <input type="hidden" name="_token" value="Ir9whjd5Tm1IW5vBxyVYvHb2fE1zu5BHcNx6hPeM"><input type="hidden" name="_method" value="post"> -->

            <div class="modal-content">
                <div class="modal-header alert-light">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Partno 1</label>
                            <input type="text" name="partno1" id="partno1" placeholder="" class="form-control form-control-sm" required>

                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Partno 2</label>
                            <div class="input-group">
                                <!-- <span class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-code"></i>
                                    </span>
                                </span> -->
                                <input id="partno2" name="partno2" placeholder="" type="text" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Part Name</label>
                            <input type="text" name="part_name" id="part_name" placeholder="" class="form-control form-control-sm" required>

                        </div>
                        <!-- <div class="col-lg-4">
                            <label class="col-form-label">Is Active</label>
                            <select name="isactive" id="isactive" class="form-control form-control-sm">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div> -->
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Qty Box</label>
                            <input type="number" name="qty_box" id="qty_box" placeholder="" class="form-control form-control-sm" required>

                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Qty Unit</label>
                            <div class="input-group">

                                <input id="qty_unit" name="qty_unit" placeholder="" type="number" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Qty Safety Stock</label>
                            <input type="number" name="qty_safety_stock" id="qty_safety_stock" placeholder="" class="form-control form-control-sm" required>

                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">NW</label>
                            <input type="text" name="nw" id="nw" placeholder="" class="form-control form-control-sm" required>

                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Supply</label>
                            <div class="input-group">

                                <input id="supply" name="supply" placeholder="" type="text" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Part Address OLN</label>
                            <input type="text" name="part_address_oln" id="part_address_oln" placeholder="" class="form-control form-control-sm" required>

                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Hamidasi Address</label>
                            <input type="text" name="hamidasi_address" id="hamidasi_address" placeholder="" class="form-control form-control-sm" required>

                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Part Address HML</label>
                            <div class="input-group">

                                <input id="part_address_hml" name="part_address_hml" placeholder="" type="text" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Project</label>
                            <input type="text" name="project" id="project" placeholder="" class="form-control form-control-sm" required>

                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-form-label">OLN Line</label>
                            <input type="text" name="oln_line" id="oln_line" placeholder="" class="form-control form-control-sm" required>

                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Is Special Part ?</label>
                            <select name="is_special_part" id="is_special_part" class="form-control form-control-sm">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-form-label">Line Code</label>
                            <input type="text" name="line_code" id="line_code" placeholder="" class="form-control form-control-sm" required>

                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Qty End Stock</label>
                            <input type="number" name="qty_endstock" id="qty_endstock" placeholder="" class="form-control form-control-sm" required>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-form-label">Last STO Date</label>
                            <div class="input-group">
                                <!-- <input id="last_stodate" name="last_stodate" type="text" class="form-control form-control-sm"> -->
                                <input id="last_stodate" name="last_stodate" required readonly type="text" autocomplete="off" data-target="#last_stodate" data-toggle="datetimepicker" class="form-control datetimepicker-input form-control-sm" />

                                <div class="input-group-append" data-target="#last_stodate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Last STO Qty</label>
                            <input type="number" name="last_sto_qty" id="last_sto_qty" placeholder="" class="form-control form-control-sm" required>
                        </div>

                    </div>


                </div>


                <div class="modal-footer alert-light">
                    <!-- <button class="btn btn-sm btn-flat btn-danger" id="btn"><i class="fa fa-save"></i> Get check box value</button> -->
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancel</button>
                </div>

        </form>
    </div>
</div>