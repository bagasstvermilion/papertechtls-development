<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Getjasfile extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo '<html lang="en">
            <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Tambahkan tag di bawah ini untuk reload otomatis setiap 5 detik -->
            <meta http-equiv="refresh" content="10">
            <title>PapertechTLS JAS Software Excel Reader</title>
            </head>
            <body><!-- <pre> --><h2 style="color: #003366;">SONOCO - Papertech TLS</h2>';

        echo date("l, F d, Y H:i:s") . "<br><br>";

        // Tentukan path file Excel Anda
        //$file_path = './path/ke/file_anda.xlsx';

        $file_path = getcwd() . '/uplod/excel/dailyTrans.xlsx';
        //$file_path = 'C:/xampp/htdocs/papertechtls/uplod/excel/dailyTrans.xlsx';
        //$file_path = __DIR__ . '/uplod/excel/dailyTrans.xlsx';
        //echo getcwd() . '/uplod/excel/dailyTrans.xlsx';
        ///echo $file_path;


        $file_info = new SplFileInfo($file_path);
        $extension = $file_info->getExtension();

        if ('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ('xls' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        if (!file_exists($file_path)) {
            show_error('File Excel tidak ditemukan pada path yang ditentukan.');
            exit();
        }

        try {
            // Fungsi lokal untuk mengonversi format tanggal bawaan Excel menjadi format MySQL
            $format_date = function ($cell_value) {
                if (empty($cell_value)) return NULL;
                if (is_numeric($cell_value)) {
                    $date_obj = Date::excelToDateTimeObject($cell_value);
                    return $date_obj->format('Y-m-d H:i:s');
                }
                return date('Y-m-d H:i:s', strtotime($cell_value));
            };

            // Membaca file excel
            //$spreadsheet = IOFactory::load($file_path);
            $spreadsheet = $reader->load($file_path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Hapus baris pertama jika berupa judul kolom (Header)
            $header = array_shift($rows);

            // Siapkan query mentah MySQL untuk teknik UPSERT
            $sql = "INSERT INTO jas_timbangan (
                        trans_no, vehicle_no, transporter_code, transporter_name, product_code, 
                        product_name, customer_code, customer_name, supplier_code, supplier_name, 
                        no_lapak, driver, remark, weigh_1st_dt, weight_1st, operator_1st, 
                        weigh_2nd_dt, weight_2nd, operator_2nd, netto
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                    )
                    ON DUPLICATE KEY UPDATE
                        vehicle_no = VALUES(vehicle_no),
                        transporter_code = VALUES(transporter_code),
                        transporter_name = VALUES(transporter_name),
                        product_code = VALUES(product_code),
                        product_name = VALUES(product_name),
                        customer_code = VALUES(customer_code),
                        customer_name = VALUES(customer_name),
                        supplier_code = VALUES(supplier_code),
                        supplier_name = VALUES(supplier_name),
                        no_lapak = VALUES(no_lapak),
                        driver = VALUES(driver),
                        remark = VALUES(remark),
                        weigh_1st_dt = VALUES(weigh_1st_dt),
                        weight_1st = VALUES(weight_1st),
                        operator_1st = VALUES(operator_1st),
                        weigh_2nd_dt = VALUES(weigh_2nd_dt),
                        weight_2nd = VALUES(weight_2nd),
                        operator_2nd = VALUES(operator_2nd),
                        netto = VALUES(netto)";

            // Mulai database transaction CI3 agar proses eksekusi ribuan data sangat cepat
            $this->db->trans_start();

            $row_count = 0;

            //print_r($rows);

            foreach ($rows as $row) {

                //if ($row_count > 1) { //baca data excel dimualai dari baris 1 karena 0 adalah judul/ header column
                //echo $format_date($row[13]) . "<hr>";
                //if ($format_date($row[13]) == "2026-05-22" /*date("Y-m-d")*/) { //ambil data yang hanya tanggal hari ini saja

                // Abaikan jika baris kosong atau trans_no tidak diisi
                if (empty($row[0])) {
                    continue;
                }

                // Susun data array pengikat (binding) sesuai urutan tanda tanya (?) pada query SQL
                $bind_data = [
                    $row[0], // trans_no
                    $row[1], // vehicle_no
                    $row[2], // transporter_code
                    $row[3], // transporter_name
                    $row[4], // product_code
                    $row[5], // product_name
                    $row[6], // customer_code
                    $row[7], // customer_name
                    !empty($row[8]) ? $row[8] : NULL,  // supplier_code
                    !empty($row[9]) ? $row[9] : NULL,  // supplier_name
                    !empty($row[10]) ? $row[10] : NULL, // no_lapak
                    !empty($row[11]) ? $row[11] : NULL, // driver
                    !empty($row[12]) ? $row[12] : NULL, // remark
                    $format_date($row[13]), // weigh_1st_dt
                    (int)$row[14],          // weight_1st
                    !empty($row[15]) ? $row[15] : NULL,               // operator_1st
                    $format_date($row[16]), // weigh_2nd_dt
                    (int)$row[17],          // weight_2nd
                    !empty($row[18]) ? $row[18] : NULL,            // operator_2nd
                    !empty($row[19]) ? (int)$row[19] : 0 // netto
                ];

                // Eksekusi query dengan teknik Query Binding (Aman dari SQL Injection)
                $this->db->query($sql, $bind_data);
                //}
                //}
                $row_count++;
            }

            // Selesaikan transaksi database
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                echo "Gagal memproses transaksi data database.";
            } else {
                echo "Sukses! Berhasil memproses " . $row_count . " baris data dari file Excel <b>JAS Software \"dailyTrans.xlsx\"</b> ke dataBase.";
            }
        } catch (\Exception $e) {
            echo "Terjadi kesalahan sistem: " . $e->getMessage();
        }
    }


    public function fun_upload_prs($namaFile = "", $str = "", $impcode = "", $jobtype = "", $invoiceno_rack)
    {

        $pib     = null;
        $dirs     = "./uplod/excel/";

        if (file_exists($dirs . $namaFile)) {

            $arr_file = explode('.', $dirs . $namaFile);
            //$extension = strtolower(end($arr_file));
            $extension = end($arr_file);

            //20240813
            $namaFile_array = explode('.', $namaFile);
            $namaFile1 = $namaFile_array[0];
            $namaFileBak = $namaFile1 . "_" . date("YmdHis") . "." . $extension;

            $filename = $namaFile1 . "." . $extension;

            $username = $this->session->userdata('username');

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($dirs . $namaFile);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $afftectedRows = 0;

            $nama_customer1 = "";
            $area1 = "";
            $urutan_bongkar1 = "";

            $tanggal_jadwal = $sheetData[1]['0']; //'2026-06-09';//$sheetData[$i]['0'];
            $date = DateTime::createFromFormat('l, F d, Y', $tanggal_jadwal);
            $tanggal_jadwal = $date ? $date->format('Y-m-d') : null;


            for ($i = 4; $i < count($sheetData); $i++) //baca baris data excel dari baris ke 1, baris ke 0 adalah header di excel
            {
                /* $datas = array(
					'caseno'  => $sheetData[$i]['0'],
					'partno'  => $sheetData[$i]['1'],
					'rubetsu'  => $sheetData[$i]['2'],
					'partname'  => $sheetData[$i]['3'],
					'qty'  => $sheetData[$i]['4'],
					'unitweight'  => $sheetData[$i]['5'],
					'netweight'  => $sheetData[$i]['6'],
					'containerno'  => $sheetData[$i]['7'],
					'fta_code'  => $sheetData[$i]['8'],
					'shippingcode'  => $sheetData[$i]['9'],
					'vanningcode'  => $sheetData[$i]['10'],
					'efa_mfn'  => $sheetData[$i]['11']
				); */

                //$tanggal_jadwal = $sheetData[1]['0']; //'2026-06-09';//$sheetData[$i]['0'];
                $kode_unik = $tanggal_jadwal . "-" . $sheetData[$i]['0'];
                $kedatangan_truck = $sheetData[$i]['0'];

                if (strlen($sheetData[$i]['1']) > 0) {
                    $nama_customer = $sheetData[$i]['1'];
                    $nama_customer1 = $sheetData[$i]['1'];
                } else {
                    $nama_customer = $nama_customer1;
                }

                if (strlen($sheetData[$i]['2']) > 0) {
                    $area = $sheetData[$i]['2'];
                    $area1 = $sheetData[$i]['2'];
                } else {
                    $area = $area1;
                }

                if (strlen($sheetData[$i]['1']) > 0) {
                    $urutan_bongkar = $sheetData[$i]['3'];
                    $urutan_bongkar1 = $sheetData[$i]['3'];
                } else {
                    $urutan_bongkar = $urutan_bongkar1;
                }

                //$area = $sheetData[$i]['2'];
                //$urutan_bongkar = $sheetData[$i]['3'];
                $no_so = $sheetData[$i]['4'];
                $mid = $sheetData[$i]['5'];

                $item_desc = addslashes($sheetData[$i]['6']);
                $weight = $sheetData[$i]['7'];
                $color = $sheetData[$i]['8'];
                $pattern_nose = $sheetData[$i]['9'];

                $qty_box_pallet = (strlen($sheetData[$i]['10'])) ? str_replace(',', '.', $sheetData[$i]['10']) : 0; //jika tidak ada data isi 0
                $qty_pcs = (strlen($sheetData[$i]['11'])) ? str_replace(',', '.', $sheetData[$i]['11']) : 0;;
                $qty_box_pallet_total = (strlen($sheetData[$i]['12'])) ? str_replace(',', '.', $sheetData[$i]['12']) : 0;
                $status_produk = $sheetData[$i]['13'];
                $waktu_muat = $sheetData[$i]['14'];
                $status_tracking = $sheetData[$i]['15'];
                $berat_total = (strlen($sheetData[$i]['16'])) ? str_replace(',', '.', $sheetData[$i]['16']) : 0;
                $berat_box = (strlen($sheetData[$i]['17'])) ? str_replace(',', '.', $sheetData[$i]['17']) : 0;

                $berat_isi_truck = (strlen($sheetData[$i]['18'])) ? str_replace(',', '.', $sheetData[$i]['18']) : 0;

                $normal_min = (strlen($sheetData[$i]['19'])) ? str_replace(',', '.', $sheetData[$i]['19']) : 0;
                $normal_max = (strlen($sheetData[$i]['20'])) ? str_replace(',', '.', $sheetData[$i]['20']) : 0;
                $toleransi_min = (strlen($sheetData[$i]['21'])) ? str_replace(',', '.', $sheetData[$i]['21']) : 0;
                $toleransi_max = (strlen($sheetData[$i]['22'])) ? str_replace(',', '.', $sheetData[$i]['22']) : 0;
                $warning = (strlen($sheetData[$i]['23'])) ? str_replace(',', '.', $sheetData[$i]['23']) : 0;

                /* $nama_supir = $sheetData[$i]['24'];
                $no_telp = $sheetData[$i]['25'];
                $remark = $sheetData[$i]['26']; */

                //array_push($data, $datas); //untuk insert batch ini sudah OKE

                $sql = "INSERT INTO cs_history(tanggal_jadwal, kode_unik, kedatangan_truck, nama_customer, area, urutan_bongkar, no_so, mid, item_desc, weight, color, pattern_nose, qty_box_pallet, qty_pcs, qty_box_pallet_total, status_produk, waktu_muat, status_tracking, berat_total, berat_box, berat_isi_truck, normal_min, normal_max, toleransi_min, toleransi_max, warning) values('$tanggal_jadwal', '$kode_unik', '$kedatangan_truck', '$nama_customer', '$area', '$urutan_bongkar', '$no_so', '$mid', '$item_desc', '$weight', '$color', '$pattern_nose', $qty_box_pallet, $qty_pcs, $qty_box_pallet_total, '$status_produk', '$waktu_muat', '$status_tracking', $berat_total, $berat_box, $berat_isi_truck, $normal_min, $normal_max, $toleransi_min, $toleransi_max, $warning)";
                $this->db->query($sql);

                $afftectedRows = $afftectedRows + $this->db->affected_rows();
            }

            $this->db->query("INSERT into cs_upload_log(filename, jmlrowdata, upload_by) values('$filename', '$afftectedRows', '$username')");

            //$this->db->insert_batch('machining_shipping_plan', $data); //ini sudah OKE

            $id = $this->db->insert_id();

            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>" . $str . "<br>afftectedRows " . $afftectedRows . "</span>
			    </div>");

            /* $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>" . $str . "<br>afftectedRows " . $afftectedRows . "<br>id " . $id . "</span>
			    </div>"); */

            redirect('cs/cs_upload_frm');
        } else {

            $str = "file not found";
            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>" . $str . "</span>
			    </div>");
            redirect('cs/cs_upload_frm');
        }
    }
}
