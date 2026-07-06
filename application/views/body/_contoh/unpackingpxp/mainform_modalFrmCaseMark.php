<div class="modal" id="modalFrmCaseMark" tabindex="-1" role="dialog" aria-labelledby="modal-form" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">

        <form name="frmCaseMark" action="" method="post" class="form-horizontal">
            <!-- <input type="hidden" name="_token" value="Ir9whjd5Tm1IW5vBxyVYvHb2fE1zu5BHcNx6hPeM"><input type="hidden" name="_method" value="post"> -->

            <div class="modal-content">

                <div class="modal-header alert-light">
                    <h4 class="modal-title">Case Mark Manual Input</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- inputan manual case mark -->
                    <div class="form-group row" id="row_modalFrmCaseMark">
                        <div class="col-lg-4">
                            <label class="col-form-label">Year Month</label>
                            <input type="text" name="scmmYearMonth" id="scmmYearMonth" class="form-control form-control-xl" readonly value="<?php echo date("Ym"); ?>" style="height:55px; font-size:45px;">
                            <!-- <span class="help-block with-errors"></span> -->
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Case No</label>
                            <div class="input-group">
                                <!-- <span class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-code"></i>
                                    </span>
                                </span> -->
                                <input id="scmmCaseNo" name="scmmCaseNo" type="placeholder="" type=" text" class="form-control form-control-xl" required="" autocomplete="off" style="height:55px; font-size:45px;" placeholder="Case No">
                            </div>
                        </div>
                    </div>

                    <!-- inputan manual label mark -->
                    <div class="form-group row" id="row_modalFrmLabelMark">
                        <div class="col-lg-4">
                            <label class="col-form-label">Case No</label>
                            <div class="input-group">
                                <input id="slmmCaseNo" name="slmmCaseNo" type="placeholder="" type=" text" class="form-control form-control-xl" required="" autocomplete="off" style="height:55px; font-size:45px;" placeholder="Case No">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Part No</label>
                            <div class="input-group">
                                <!-- <span class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-code"></i>
                                    </span>
                                </span> -->
                                <input id="slmmPartNo" name="slmmPartNo" value="" type=" text" class="form-control form-control-xl" required="" autocomplete="off" style="height:55px; font-size:45px;" placeholder="Part No">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Quantity</label>
                            <div class="input-group">
                                <input id="slmmQty" name="slmmQty" type="number" class="form-control form-control-xl" required="" style="height:55px; font-size:45px;" placeholder="Quantity">
                            </div>
                        </div>
                    </div>
                    <input type="text" id="modalFormRowActive" name="modalFormRowActive" value="" placeholder="modal form yang aktif adalah">
                </div>


                <div class="modal-footer alert-light">
                    <!-- <button class="btn btn-sm btn-flat btn-danger" id="btn"><i class="fa fa-save"></i> Get check box value</button> -->
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Insert</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancel</button>
                </div>

        </form>
    </div>
</div>