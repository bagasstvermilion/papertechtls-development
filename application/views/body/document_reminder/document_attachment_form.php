<div class="modal fade" id="modal-form-attachment" role="dialog" aria-labelledby="modal-form" tabindex="-1">
    <!-- tabindex="-1" -->
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
                            <label class="col-form-label">Department</label>
                            <select name="iddept" id="iddept" class="form-control form-control-sm">
                                <?php
                                if ($this->session->userdata('isadmin') == 'yes') {
                                    $sql = "SELECT * from department d";
                                } else {
                                    $sql = "SELECT * from department d where id = '" . $this->session->userdata('iddept') . "'";
                                }
                                echo "sql " . $sql;

                                $rs = $this->db->query($sql);
                                if ($rs->num_rows() > 0) {
                                    foreach ($rs->result_array() as $row) {
                                ?>
                                        <option value="<?php echo $row["id"]; ?>" <?php if ($this->session->userdata('iddept') == $row["id"]) { ?>selected<?php } ?>><?php echo $row["name"]; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Doc. Type</label>
                            <div class="input-group">
                                <select name="iddoctype" id="iddoctype" class="form-control form-control-sm">
                                    <?php
                                    $sql = "SELECT * from doctype where isactive='yes'";
                                    $rs = $this->db->query($sql);
                                    if ($rs->num_rows() > 0) {
                                        $i = 0;
                                        foreach ($rs->result_array() as $row) {
                                    ?>
                                            <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Document Number</label>
                            <input type="text" name="docno" id="docno" placeholder="" class="form-control form-control-sm" required>

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
                        <div class="col-lg-7">
                            <label class="col-form-label">Description</label>
                            <input type="text" name="description" id="description" placeholder="" class="form-control form-control-sm" required>

                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label">Company</label>
                            <div class="input-group">

                                <input id="company" name="company" placeholder="" type="text" class="form-control form-control-sm" required>
                            </div>
                        </div>


                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Start Date</label>
                            <div class="input-group">
                                <input id="startdate" name="startdate" required readonly type="text" autocomplete="off" data-target="#startdate" data-toggle="datetimepicker" class="form-control datetimepicker-input form-control-sm" />

                                <div class="input-group-append" data-target="#startdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Until</label>
                            <div class="input-group">

                                <input id="enddate" name="enddate" required readonly type="text" autocomplete="off" data-target="#enddate" data-toggle="datetimepicker" class="form-control datetimepicker-input form-control-sm" />

                                <div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Term</label>
                            <input type="text" name="term" id="term" placeholder="" class="form-control form-control-sm" required>

                        </div>

                        <div class="col-lg-3">
                            <label class="col-form-label">PIC</label>
                            <input type="text" name="pic" id="pic" placeholder="" class="form-control form-control-sm" required>

                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="col-form-label">Remark</label>
                            <input type="text" name="remark" id="remark" placeholder="" class="form-control form-control-sm" required>

                        </div>

                        <div class="col-lg-2">
                            <label class="col-form-label">Phone</label>
                            <input type="text" name="phone" id="phone" placeholder="" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Contact</label>
                            <input type="text" name="contact" id="contact" placeholder="" class="form-control form-control-sm" required>
                        </div>

                    </div>




                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-form-label">Attachment</label>

                            <input type="file" name="files[]" class="form-control" multiple />

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