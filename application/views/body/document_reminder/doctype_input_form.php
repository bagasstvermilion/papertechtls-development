<!-- <div class="modal fade" id="modal-form" role="dialog" aria-labelledby="modal-form" tabindex="-1"> -->
<div class="modal" id="modal-form" role="dialog" aria-labelledby="modal-form" tabindex="-1">
    <!-- tabindex="-1" -->
    <!--  data-backdrop="static" paksa user harus close modal tekan tombol close x -->

    <div class="modal-dialog modal-xl" role="document">

        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

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
                        <div class="col-lg-4">
                            <label class="col-form-label">Document Type</label>
                            <input type="text" name="name" id="name" placeholder="" class="form-control form-control-sm" required>

                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Is Active</label>
                            <select name="isactive" id="isactive" class="form-control form-control-sm">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>


                        <!-- <div class="col-lg-4">
                            <label class="col-form-label">Is Active</label>
                            <select name="isactive" id="isactive" class="form-control form-control-sm">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div> -->
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