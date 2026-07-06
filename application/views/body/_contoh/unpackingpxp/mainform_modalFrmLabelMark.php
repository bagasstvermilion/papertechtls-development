<div class="modal" id="modalFrmLabelMark" tabindex="-1" role="dialog" aria-labelledby="modal-form" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">

        <form name="frmLabelMark" action="" method="post" class="form-horizontal">
            <!-- <input type="hidden" name="_token" value="Ir9whjd5Tm1IW5vBxyVYvHb2fE1zu5BHcNx6hPeM"><input type="hidden" name="_method" value="post"> -->

            <div class="modal-content">

                <div class="modal-header alert-light">
                    <h4 class="modal-title">Label Mark Manual Input</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <!-- <div class="col-lg-4">
                            <label class="col-form-label">User Name</label>
                            <input type="text" name="username" id="username" placeholder="" class="form-control form-control-sm" required>
                            <span class="help-block with-errors"></span>
                        </div> -->
                        <div class="col-lg-4">
                            <label class="col-form-label">Case No</label>
                            <div class="input-group">
                                <input id="slmmCaseNo" name="slmmCaseNo" type="placeholder="" type=" text" class="form-control form-control-sm" required autocomplete="off" autofocus>
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
                                <input id="slmmPartNo" name="slmmPartNo" value="placeholder="" type=" text" class="form-control form-control-sm" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Quantity</label>
                            <div class="input-group">
                                <input id="slmmQty" name="slmmQty" type="number" class="form-control form-control-sm" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                </div>


                <div class="modal-footer alert-light">
                    <!-- <button class="btn btn-sm btn-flat btn-danger" id="btn"><i class="fa fa-save"></i> Get check box value</button> -->
                    <button onclick="fun_modalFrmLabelMarkSubmit();" type="button" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Insert</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancel</button>
                </div>

        </form>
    </div>
</div>