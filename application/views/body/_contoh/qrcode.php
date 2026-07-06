<section class="content">
        <div class="row">
            <div class="col-md-12">
            <div class="col text-center">
                <h2><?php echo  $title ?></h2>
            </div>
            <table class="table table-bordered">
                <thead>
                    <th>NO</th>
                    <th>NOPOL</th>
                    <th>NAMA</th>
                    <th>MERK</th>
                    <th>QRCODE</th>
                </thead>
                <?php $no = 1; ?>
                <?php foreach ($row_kendaraan as $row) : ?>
                    <tbody>
                        <td><?php echo  $no++; ?></td>
                        <td><?php echo  $row->nopol; ?></td>
                        <td><?php echo  $row->nama; ?></td>
                        <td><?php echo  $row->idmerk; ?></td>
                        <td>
                            <?php
                            //require 'vendor/autoload.php'; // load folder vendor/autoload
                            //$qrCode = new Endroid\QrCode\QrCode($row->nopol); // mengambil data kode siswa sebagai data  QR code
                            //$qrCode->writeFile('./QRcode/' . $row->nopol . '.png'); // direktori untuk menyimpan gambar QR code
                            ?>
                            <!-- tampilkan gambar QR code -->
                            <!-- <img src="<?php echo  base_url('./QRcode/' . $row->nopol . '.png') ?>" alt="QRcode NoPol" width="100px"> -->

                            <img src="<?php echo base_url(); ?>index.php/welcome/qrcode/<?php echo $row->nopol; ?>" class="img-responsive">

                            <?php //getQrCodeImg("tes", $size = 200, $padding = 10, $errCorrection = 'middle'); ?>
                        </td>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
        </div>
    </section>

