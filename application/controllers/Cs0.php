<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cs extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('username')) {
			$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>Please login first.</span>
			    </div>");
			redirect('login');
		}
	}


	public function cs_upload_history()
	{
		$data['header'] = "layout/header"; //view/layout/header.php
		//$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/cs/cs_upload_history";
		$this->load->view('template', $data);
	}

	public function cs_upload_history_data($param1 = "", $param2 = "", $param3 = "")
	{
		$param1 = str_replace("_BLANK_", "", $param1);
		$param2 = str_replace("_BLANK_", "", $param2);
		$param3 = str_replace("_BLANK_", "", $param3);

		$data = [];
		$i = 0;

		$created_by = $this->session->userdata('username');
		if ($this->session->userdata('isadmin') == 'yes' || $this->session->userdata('ishod') == 'yes') {
			$created_by = "";
		}

		$sql = "SELECT * from cs_upload_log where date(upload_at) between '$param1' and '$param2' order by upload_at";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row) {

				$i = $i + 1;

				$row["DT_RowIndex"] = $i;

				$row["filename"] = '<a title="Download" href="' . base_url() . 'uplod/excel/' . $row["filename"] . '">' . $row["filename"] . '</a>';


				//$row["clp"] = $clp; //tambah key dan value ke variabel array asosiatif -> $row / tambah kolom baru di data tabel

				$data[] = $row; //row kolom2 tabel di masukan ke variabel array asosiatif $data
			}

			$draw = 0;
			$result = array(
				"draw" => $draw,
				"recordsTotal" => $rs->num_rows(),
				"recordsFiltered" => $rs->num_rows(),
				"data" => $data
			);

			echo json_encode($result);
		} else {
			echo '{"note":"data not found","draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}';
		}
	}


	public function cs_upload_frm()
	{
		$data['header'] = "layout/header"; //view/layout/header.php
		//$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/cs/cs_upload_frm";
		$this->load->view('template', $data);
	}


	public function cs_upload()
	{
		$config['upload_path'] = './uplod/excel/';
		$config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx|csv';
		$config['max_size']	= '4048';
		$config['overwrite'] = TRUE;
		$config['remove_space'] = TRUE;
		$this->upload->initialize($config);
		$this->load->library('upload', $config); // Load konfigurasi uploadnya

		//$data_metadata = array('image_metadata' => $this->upload->data()); //20241107 di komen by andi

		if (!$this->upload->do_upload('file')) { //jika tanpa ada file yg di upload maka..

			$error = array('error' => $this->upload->display_errors());
			echo json_encode($error);
		} else {

			$impcode 	= $this->input->post('impcode');
			$jobtype 	= $this->input->post('jobtype');
			$pib 		= null;
			$invoiceno_rack = $this->input->post('invoiceno_rack');

			// $file = str_replace(" ", "_", $_FILES['file']['name']);
			$file = $this->upload->data()['file_name']; // Anur 25/11/24.. File name dengan library CI after upload

			//echo "Upload file <b>".$file."</b> success..<br>";
			$str = "Upload file <b>" . $file . "</b> success..<br>";

			$this->fun_upload_prs($file, $str, $impcode, $jobtype, $invoiceno_rack); //proses insert record excel ke database
		}
	}


	public function fun_upload_prs($namaFile = "", $str = "", $impcode = "", $jobtype = "", $invoiceno_rack)
	{

		$pib 	= null;
		$dirs 	= "./uplod/excel/";

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

			$tanggal_jadwal = $sheetData[2]['0']; //'2026-06-09';//$sheetData[$i]['0']; //baris ke i kolom ke 0

			//$date = DateTime::createFromFormat('l, F d, Y', $tanggal_jadwal);
			//$tanggal_jadwal = $date ? $date->format('Y-m-d') : null;

			// Beritahu PHP format asalnya adalah Bulan/Hari/Tahun
			$date = DateTime::createFromFormat('m/d/Y', $tanggal_jadwal);

			// Ubah menjadi format Baru: Tahun-Bulan-Hari
			$tanggal_jadwal = $date->format('Y-m-d');

			//echo $tanggal_jadwal;
			//exit();


			for ($i = 5; $i < count($sheetData); $i++) //baca baris data excel dari baris ke 1, baris ke 0 adalah header di excel
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

				$item_desc = addslashes($sheetData[$i]['4']);
				$weight = $sheetData[$i]['5'];
				$color = $sheetData[$i]['6'];
				$pattern_nose = $sheetData[$i]['7'];

				$qty_box_pallet = (strlen($sheetData[$i]['8'])) ? str_replace(',', '.', $sheetData[$i]['8']) : 0; 
				$qty_pcs = (strlen($sheetData[$i]['9'])) ? str_replace(',', '.', $sheetData[$i]['9']) : 0;
				$qty_box_pallet_total = (strlen($sheetData[$i]['10'])) ? str_replace(',', '.', $sheetData[$i]['10']) : 0;
				
				$status_produk = $sheetData[$i]['11'];
				$waktu_muat = $sheetData[$i]['12'];
				$status_tracking = $sheetData[$i]['13'];
				
				$berat_total = (strlen($sheetData[$i]['14'])) ? str_replace(',', '.', $sheetData[$i]['14']) : 0;
				$berat_box = (strlen($sheetData[$i]['15'])) ? str_replace(',', '.', $sheetData[$i]['15']) : 0;
				$berat_isi_truck = (strlen($sheetData[$i]['16'])) ? str_replace(',', '.', $sheetData[$i]['16']) : 0;

				$normal_min = (strlen($sheetData[$i]['17'])) ? str_replace(',', '.', $sheetData[$i]['17']) : 0;
				$normal_max = (strlen($sheetData[$i]['18'])) ? str_replace(',', '.', $sheetData[$i]['18']) : 0;
				$toleransi_min = (strlen($sheetData[$i]['19'])) ? str_replace(',', '.', $sheetData[$i]['19']) : 0;
				$toleransi_max = (strlen($sheetData[$i]['20'])) ? str_replace(',', '.', $sheetData[$i]['20']) : 0;
				$warning = (strlen($sheetData[$i]['21'])) ? str_replace(',', '.', $sheetData[$i]['21']) : 0;

				// Lanjut ke query INSERT INTO cs_history...
				$sql = "INSERT INTO cs_history(tanggal_jadwal, kode_unik, kedatangan_truck, nama_customer, area, urutan_bongkar, item_desc, weight, color, pattern_nose, qty_box_pallet, qty_pcs, qty_box_pallet_total, status_produk, waktu_muat, status_tracking, berat_total, berat_box, berat_isi_truck, normal_min, normal_max, toleransi_min, toleransi_max, warning) values('$tanggal_jadwal', '$kode_unik', '$kedatangan_truck', '$nama_customer', '$area', '$urutan_bongkar', '$item_desc', '$weight', '$color', '$pattern_nose', $qty_box_pallet, $qty_pcs, $qty_box_pallet_total, '$status_produk', '$waktu_muat', '$status_tracking', $berat_total, $berat_box, $berat_isi_truck, $normal_min, $normal_max, $toleransi_min, $toleransi_max, $warning)";
				/* $nama_supir = $sheetData[$i]['24'];
                $no_telp = $sheetData[$i]['25'];
                $remark = $sheetData[$i]['26']; */

				//array_push($data, $datas); //untuk insert batch ini sudah OKE

				/* $sql = "INSERT INTO cs_history1(tanggal_jadwal, kode_unik, kedatangan_truck, nama_customer, area, urutan_bongkar, no_so, mid, item_desc, weight, color, pattern_nose, qty_box_pallet, qty_pcs, qty_box_pallet_total, status_produk, waktu_muat, status_tracking, berat_total, berat_box, berat_isi_truck, normal_min, normal_max, toleransi_min, toleransi_max, warning) values('$tanggal_jadwal', '$kode_unik', '$kedatangan_truck', '$nama_customer', '$area', '$urutan_bongkar', '$no_so', '$mid', '$item_desc', '$weight', '$color', '$pattern_nose', $qty_box_pallet, $qty_pcs, $qty_box_pallet_total, '$status_produk', '$waktu_muat', '$status_tracking', $berat_total, $berat_box, $berat_isi_truck, $normal_min, $normal_max, $toleransi_min, $toleransi_max, $warning)"; */

				$sql = "INSERT INTO cs_history(tanggal_jadwal, kode_unik, kedatangan_truck, nama_customer, area, urutan_bongkar, item_desc, weight, color, pattern_nose, qty_box_pallet, qty_pcs, qty_box_pallet_total, status_produk, waktu_muat, status_tracking, berat_total, berat_box, berat_isi_truck, normal_min, normal_max, toleransi_min, toleransi_max, warning) values('$tanggal_jadwal', '$kode_unik', '$kedatangan_truck', '$nama_customer', '$area', '$urutan_bongkar', '$item_desc', '$weight', '$color', '$pattern_nose', $qty_box_pallet, $qty_pcs, $qty_box_pallet_total, '$status_produk', '$waktu_muat', '$status_tracking', $berat_total, $berat_box, $berat_isi_truck, $normal_min, $normal_max, $toleransi_min, $toleransi_max, $warning)";
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

	public function tracking()
	{
		$hari_ini = date('Y-m-d');
		
		$this->db->select('tanggal_jadwal');
		$this->db->distinct();
		$this->db->order_by('tanggal_jadwal', 'DESC');
		$tgl_list = $this->db->get('cs_history')->result_array();
		$list_tanggal = array_column($tgl_list, 'tanggal_jadwal');
		
		if (!in_array($hari_ini, $list_tanggal)) {
			array_unshift($list_tanggal, $hari_ini);
		}

		$data = [
			'list_tanggal' => $list_tanggal,
			'header'  => "layout/header",
			'sidebar' => "layout/sidebar",
			'body'    => "body/cs/tracking"
		];
		$this->load->view('template', $data);
	}

	public function api_cs_data()
	{
		$tanggal = $this->input->get('tanggal');
		if ($tanggal) {
			$this->db->where('tanggal_jadwal', $tanggal);
			$this->db->order_by('id', 'ASC');
			$data = $this->db->get('cs_history')->result_array();
		} else {
			$data = [];
		}
		
		// Konversi angka desimal supaya aman dibaca JS
		foreach ($data as &$row) {
			$row['weight'] = (float)$row['weight'];
			$row['qty_box_pallet'] = (float)$row['qty_box_pallet'];
			$row['qty_pcs'] = (float)$row['qty_pcs'];
			$row['qty_box_pallet_total'] = (float)$row['qty_box_pallet_total'];
			$row['berat_total'] = (float)$row['berat_total'];
			$row['berat_box'] = (float)$row['berat_box'];
			$row['berat_isi_truck'] = (float)$row['berat_isi_truck'];
			$row['normal_min'] = (float)$row['normal_min'];
			$row['normal_max'] = (float)$row['normal_max'];
			$row['toleransi_min'] = (float)$row['toleransi_min'];
			$row['toleransi_max'] = (float)$row['toleransi_max'];
		}

		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function api_cs_color_load()
	{
		$tanggal = $this->input->get('tanggal');
		$this->db->where('tanggal_jadwal', $tanggal);
		$row = $this->db->get('cs_color_map')->row_array();
		
		$color_map = [];
		if ($row && $row['color_map']) {
			$color_map = json_decode($row['color_map'], true);
		}
		
		header('Content-Type: application/json');
		echo json_encode(["color_map" => $color_map]);
	}

	public function api_cs_save()
	{
		$req_data = json_decode(file_get_contents('php://input'), true);
		$baris_data = $req_data['data'];

		foreach ($baris_data as $row) {
			$id = $row[0]; // ID dari kolom pertama (index 0)
			if ($id) {
				$update_data = [
					'kedatangan_truck' => $row[2],
					'nama_customer'    => $row[3],
					'area'             => $row[4],
					'urutan_bongkar'   => $row[5],
					'item_desc'        => $row[6],
					'weight'           => (float)str_replace(',', '.', $row[7] ?: 0),
					'color'            => $row[8],
					'pattern_nose'     => $row[9],
					'qty_box_pallet'   => (float)str_replace(',', '.', $row[10] ?: 0),
					'qty_pcs'          => (float)str_replace(',', '.', $row[11] ?: 0),
					'qty_box_pallet_total' => (float)str_replace(',', '.', $row[12] ?: 0),
					'status_produk'    => $row[13],
					'waktu_muat'       => $row[14],
					'status_tracking'  => $row[15],
					'berat_total'      => (float)str_replace(',', '.', $row[16] ?: 0),
					'berat_box'        => (float)str_replace(',', '.', $row[17] ?: 0),
					'berat_isi_truck'  => (float)str_replace(',', '.', $row[18] ?: 0),
					'normal_min'       => (float)str_replace(',', '.', $row[19] ?: 0),
					'normal_max'       => (float)str_replace(',', '.', $row[20] ?: 0),
					'toleransi_min'    => (float)str_replace(',', '.', $row[21] ?: 0),
					'toleransi_max'    => (float)str_replace(',', '.', $row[22] ?: 0),
					'warning'          => $row[23],
					'nama_supir'       => $row[24],
					'no_telp'          => $row[25],
					'remark'           => $row[26]
				];
				$this->db->where('id', $id);
				$this->db->update('cs_history', $update_data);
			}
		}
		echo json_encode(["status" => "success"]);
	}

	public function api_cs_color_save()
	{
		$req_data = json_decode(file_get_contents('php://input'), true);
		$tanggal = $req_data['tanggal'];
		$color_map = $req_data['color_map'];

		$this->db->where('tanggal_jadwal', $tanggal);
		$cek = $this->db->get('cs_color_map')->row_array();

		if ($cek) {
			$this->db->where('tanggal_jadwal', $tanggal);
			$this->db->update('cs_color_map', ['color_map' => $color_map, 'updated_at' => date('Y-m-d H:i:s')]);
		} else {
			$this->db->insert('cs_color_map', [
				'tanggal_jadwal' => $tanggal, 
				'color_map' => $color_map, 
				'updated_at' => date('Y-m-d H:i:s')
			]);
		}
		echo json_encode(["status" => "success"]);
	}
}
