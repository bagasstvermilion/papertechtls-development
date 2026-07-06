<h1>Pakai Library PHPSpreadSheet</h1>
<div class="container pt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-2">
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                <?php if ($this->session->flashdata('message')) :
                    echo $this->session->flashdata('message');
                endif; ?>
            </div>

            <form action="<?php echo base_url(); ?>index.php/PhpspreadsheetController/uplod" id="frm1" method="post" enctype="multipart/form-data" accept-charset="utf-8">


                <div class="form-group row">
                    <label for="Nama" class="col-sm-2 col-form-label">File Upload</label>
                    <div class="col-sm-10">

                        <input type="file" class="form-control" id="file" name="file" accept=".csv,.xls,.xlsx" required="">

                        <small>File type: csv, xls, xlsx<br></small>
                        <small class="text-danger">
                            <?php echo form_error('FileUpload') ?>
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-md-2">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>