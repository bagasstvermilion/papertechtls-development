<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" data-backdrop="static">
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
                        <div class="col-lg-4">
                            <label class="col-form-label">User Name</label>
                            <input type="text" name="username" id="username" placeholder="" class="form-control form-control-sm" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Name</label>
                            <div class="input-group">
                                <!-- <span class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-code"></i>
                                    </span>
                                </span> -->
                                <input id="name" name="name" placeholder="" type="text" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-lg-4" style="display: none;">
                            <label class="col-form-label">Is Active</label>
                            <select name="isactive" id="isactive" class="form-control form-control-sm">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Role</label>
                            <select name="role" id="role" class="form-control form-control-sm">
                                <option value="security">Security</option>
                                <option value="warehouse">Warehouse</option>
                                <option value="cs">CS</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" style="display: none;">
                        <div class="col-lg-4">
                            <label class="col-form-label">Is Admin</label>
                            <select name="isadmin" id="isadmin" class="form-control form-control-sm">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Is PIC</label>
                            <select name="ispic" id="ispic" class="form-control form-control-sm">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Department</label>
                            <select name="iddept" id="iddept" class="form-control form-control-sm">
                                <?php
                                $sql = "SELECT * from department d";
                                $rs = $this->db->query($sql);
                                if ($rs->num_rows() > 0) {
                                    foreach ($rs->result_array() as $row) {
                                ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-form-label">Password</label>
                            <input id="passwrd" name="passwrd" type="password" class="form-control form-control-sm datepicker" required>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Confirm Password</label>
                            <div class="input-group">
                                <input id="passwrd1" name="passwrd1" type="password" class="form-control form-control-sm datepicker" required>
                            </div>
                        </div>
                        <!-- <div class="col-lg-4">
                            <label class="col-form-label">Tgl STNK</label>
                            <div class="input-group">

                                <input id="tglstnk" required readonly type="text" autocomplete="off" data-target="#tglstnk" data-toggle="datetimepicker" class="form-control datetimepicker-input form-control-sm" />

                                <div class="input-group-append" data-target="#tglstnk" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div> -->

                    </div>
                    <!-- <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-form-label">No. Rangka</label>
                            <input autofocus type="text" name="norangka" id="norangka" class="form-control form-control-sm" required autofocus>
                        </div>

                        <div class="col-lg-4">
                            <label class="col-form-label">cekboxListValues</label>
                            <div class="input-group">
                                <input id="cekboxListValues" name="cekboxListValues" type="text" class="form-control form-control-sm form-control form-control-sm-sm" required>
                            </div>
                        </div> -->
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
                    <!-- <button class="btn btn-sm btn-flat btn-danger" id="btn"><i class="fa fa-save"></i> Get check box value</button> -->
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancel</button>
                </div>

        </form>
    </div>
</div>