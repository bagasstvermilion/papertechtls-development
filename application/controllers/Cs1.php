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

	public function cs_view()
	{
		$data['header'] = "layout/header"; ////view/layout/header.php
		////$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/cs/cs_view";
		$this->load->view('template', $data);
	}

	/* public function cs_upload_history()
	{
		$data['header'] = "layout/header"; ////view/layout/header.php
		////$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/cs/cs_upload_history";
		$this->load->view('template', $data);
	} */

	public function cs_view_data_detail($param1 = "", $param2 = "", $param3 = "")
	{
		$param1 = str_replace("_BLANK_", "", $param1);
		$param2 = str_replace("_BLANK_", "", $param2);
		$param3 = str_replace("_BLANK_", "", $param3);

		$data = [];
		$i = 0;

		$sql = "SELECT * from cs_history where tanggal_jadwal='$param1' and SUBSTRING_INDEX(kedatangan_truck, '.', 1)='$param2' and length(item_desc)>0";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row) {

				$i = $i + 1;

				$row["DT_RowIndex"] = $i;

				//$row["trans_no"] = '<a title="Detail No Pol ' . $row["no_polisi"] . '" href="javascript:addForm(\'' . $row["trans_no"] . '_' . $row["no_polisi"] . '_' . $row["tanggal_jadwal"] . '_' . $row["no_antrean"] . '\');">' . $row["trans_no"] . '</a>';

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


	public function cs_view_data($param1 = "", $param2 = "", $param3 = "")
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

		$sql = "WITH cs_historys AS (
		SELECT csh.tanggal_jadwal, csh.kode_unik, csh.kedatangan_truck, csh.normal_min as normal_min_netto, csh.warning as netto_lebih_dari_berat_ini from cs_history csh where csh.kedatangan_truck not like '%.%' and csh.kedatangan_truck not like '%,%' and length(csh.kedatangan_truck)>0 and csh.kedatangan_truck<>'TOTAL' and length(csh.item_desc)<1 
		and csh.tanggal_jadwal between '$param1' and '$param2'
		)
		SELECT cshs.*, tl.* from truck_logs tl, cs_historys cshs where tl.tanggal=cshs.tanggal_jadwal and tl.no_antrean=cshs.kedatangan_truck order by cshs.kedatangan_truck";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row) {

				$row["remarks_wh"] = "";
				$row["keterangan_sec"] = "";

				$i = $i + 1;

				$row["DT_RowIndex"] = $i;

				$row["trans_no1"] = $row["trans_no"];

				//number_format(angka, jumlah_desimal, pemisah_desimal, pemisah_ribuan)
				$row["timbang_kosong"] = number_format($row["timbang_kosong"], 0, ".", "");
				$row["timbang_isi"] = number_format($row["timbang_isi"], 0, ".", "");
				$row["netto"] = number_format($row["netto"], 0, ".", "");

				$row["normal_min_netto"] = str_replace('.', '', $row["normal_min_netto"]);
				$row["netto_lebih_dari_berat_ini"] = str_replace('.', '', $row["netto_lebih_dari_berat_ini"]);

				//$row["normal_min_netto"] = number_format($row["normal_min_netto"], 0, ".", "");
				//$row["netto_lebih_dari_berat_ini"] = number_format($row["netto_lebih_dari_berat_ini"], 0, ".", "");


				if ($row["netto"] < $row["normal_min_netto"] && $row["netto"] > 0) {
					//jika kurang
					$row["status_muatan"] = '<span class="badge badge-warning" title="Range Toleransi ' . $row['normal_min_netto'] . '~' . $row['netto_lebih_dari_berat_ini'] . '">Kurang</span>';
					//
				} elseif ($row["netto"] >= $row["normal_min_netto"] && $row["netto"] <= $row["netto_lebih_dari_berat_ini"]) {
					//jika in range
					$row["status_muatan"] = '<span class="badge badge-success" title="Range Toleransi ' . $row['normal_min_netto'] . '~' . $row['netto_lebih_dari_berat_ini'] . '">Pass</span>';
					//
				} elseif ($row["netto"] > $row["netto_lebih_dari_berat_ini"]) {
					//jika lebih
					$row["status_muatan"] = '<span class="badge badge-danger" title="Range Toleransi ' . $row['normal_min_netto'] . '~' . $row['netto_lebih_dari_berat_ini'] . '">Lebih</span>';
					//
				} elseif ($row["netto"] < 1) {
					//jika 0 atau belu timbang isi
					$row["status_muatan"] = '<span class="badge badge-info">Belum Timbang Isi</span>';
				}

				$row["trans_no"] = '<a title="Detail No Pol ' . $row["no_polisi"] . '" href="javascript:addForm(\'' . $row["trans_no"] . '_' . $row["no_polisi"] . '_' . $row["tanggal_jadwal"] . '_' . $row["no_antrean"] . '\');">' . $row["trans_no"] . '</a>';

				//loop komen wh
				$sql1 = "SELECT *, left(right(created_at,8),5) as jamkomen from remark_logs where trans_no='" . $row["trans_no1"] . "' and role='warehouse' order by created_at asc";
				$rs1 = $this->db->query($sql1);
				if ($rs1->num_rows() > 0) {
					foreach ($rs1->result_array() as $row1) {
						$row["remarks_wh"] = $row["remarks_wh"] . "<div style=\"border-bottom: 1px solid #ccc;\" class=\"row\" title=\"" . $row1["created_by"] . "\">" .  $row1["jamkomen"] . ": " . $row1["remarks"] . "</div>";
					}
				}

				//loop komen security
				$sql2 = "SELECT *, left(right(created_at,8),5) as jamkomen from remark_logs where trans_no='" . $row["trans_no1"] . "' and role='security' order by created_at asc";
				$rs2 = $this->db->query($sql2);
				if ($rs2->num_rows() > 0) {
					foreach ($rs2->result_array() as $row2) {
						$row["keterangan_sec"] = $row["keterangan_sec"] . "<div style=\"border-bottom: 1px solid #ccc;\"class=\"row\" title=\"" . $row2["created_by"] . "\">" .  $row2["jamkomen"] . ": " . $row2["remarks"] . "</div>";
					}
				}


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

			$reader->setReadDataOnly(true);
			$spreadsheet = $reader->load($dirs . $namaFile);

			$activeSheet = $spreadsheet->getActiveSheet();
			$this->_unmerge_fill_values($activeSheet); 

			$sheetData = $activeSheet->toArray();

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

			//kalau ada data hapus dulu replace dengan yang baru
			$this->db->query("DELETE from cs_upload_log where plandate='$tanggal_jadwal'");
			$this->db->query("DELETE from cs_history where tanggal_jadwal='$tanggal_jadwal'");

			$this->db->query("INSERT into cs_upload_log(filename, upload_by, plandate) values('$filename', '$username', '$tanggal_jadwal')");

			//$this->db->insert_batch('machining_shipping_plan', $data); //ini sudah OKE

			$iduploadlog = $this->db->insert_id();


			for ($i = 5; $i < count($sheetData); $i++) //baca baris data excel dari baris ke 1, baris ke 0 adalah header di excel
			{
				/* $datas = array(
					'caseno'  => $sheetData[$i]['0'],
					'partno'  => $sheetData[$i]['1'],
					'rubetsu'  => $sheetData[$i]['2'],
					'partname'  => $sheetData[$i]['3'],
					'qty'  => $sheetData[$i]['4'],
				); */

				//$tanggal_jadwal = $sheetData[1]['0']; //'2026-06-09';//$sheetData[$i]['0'];
				$kode_unik = $tanggal_jadwal . "-" . $sheetData[$i]['0'];
				$kedatangan_truck = $sheetData[$i]['0'];

				if (strlen($sheetData[$i]['1']) > 0) {
					$nama_customer = $sheetData[$i]['1'];
					$nama_customer1 = $sheetData[$i]['1'];
				} else {
					if (strlen($sheetData[$i]['1']) == 0) {
						$nama_customer = "";
					} else {
						$nama_customer = $nama_customer1;
					}
				}

				if (strlen($sheetData[$i]['2']) > 0) {
					$area = $sheetData[$i]['2'];
					$area1 = $sheetData[$i]['2'];
				} else {
					if (strlen($sheetData[$i]['2']) == 0) {
						$area = "";
					} else {
						$area = $area1;
					}
				}

				if (strlen($sheetData[$i]['1']) > 0) {
					$urutan_bongkar = $sheetData[$i]['3'];
					$urutan_bongkar1 = $sheetData[$i]['3'];
				} else {
					if (strlen($sheetData[$i]['2']) == 0) {
						$urutan_bongkar = "";
					} else {
						$urutan_bongkar = $urutan_bongkar1;
					}
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

				/* $sql = "INSERT INTO cs_history(tanggal_jadwal, kode_unik, kedatangan_truck, nama_customer, area, urutan_bongkar, no_so, mid, item_desc, weight, color, pattern_nose, qty_box_pallet, qty_pcs, qty_box_pallet_total, status_produk, waktu_muat, status_tracking, berat_total, berat_box, berat_isi_truck, normal_min, normal_max, toleransi_min, toleransi_max, warning) values('$tanggal_jadwal', '$kode_unik', '$kedatangan_truck', '$nama_customer', '$area', '$urutan_bongkar', '$no_so', '$mid', '$item_desc', '$weight', '$color', '$pattern_nose', $qty_box_pallet, $qty_pcs, $qty_box_pallet_total, '$status_produk', '$waktu_muat', '$status_tracking', $berat_total, $berat_box, $berat_isi_truck, $normal_min, $normal_max, $toleransi_min, $toleransi_max, $warning)"; */

				$sql = "INSERT INTO cs_history(iduploadlog, tanggal_jadwal, kode_unik, kedatangan_truck, nama_customer, area, urutan_bongkar, item_desc, weight, color, pattern_nose, qty_box_pallet, qty_pcs, qty_box_pallet_total, status_produk, waktu_muat, status_tracking, berat_total, berat_box, berat_isi_truck, normal_min, normal_max, toleransi_min, toleransi_max, warning) values($iduploadlog, '$tanggal_jadwal', '$kode_unik', '$kedatangan_truck', '$nama_customer', '$area', '$urutan_bongkar', '$item_desc', '$weight', '$color', '$pattern_nose', $qty_box_pallet, $qty_pcs, $qty_box_pallet_total, '$status_produk', '$waktu_muat', '$status_tracking', $berat_total, $berat_box, $berat_isi_truck, $normal_min, $normal_max, $toleransi_min, $toleransi_max, $warning)";
				$this->db->query($sql);

				$afftectedRows = $afftectedRows + $this->db->affected_rows();
			}

			//$this->db->query("INSERT into cs_upload_log(filename, jmlrowdata, upload_by, plandate) values('$filename', '$afftectedRows', '$username', '$tanggal_jadwal')");

			//$this->db->insert_batch('machining_shipping_plan', $data); //ini sudah OKE

			//$id = $this->db->insert_id();

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

			// 🔥 AMBIL DATA REMARK SECURITY & WAREHOUSE DARI truck_logs (via no_antrean)
			$this->db->where('tanggal', $tanggal);
			$trucks = $this->db->get('truck_logs')->result_array();
			$truck_map = [];
			foreach ($trucks as $t) {
				$truck_map[(string)$t['no_antrean']] = $t;
			}

			// 🔥 AMBIL SEMUA LOG REMARK (Security & Warehouse) per trans_no
			$trans_no_list = array_filter(array_column($trucks, 'trans_no'));
			$remark_logs_map = [];
			if (!empty($trans_no_list)) {
				$this->db->where_in('trans_no', $trans_no_list);
				$this->db->order_by('created_at', 'ASC');
				$logs = $this->db->get('remark_logs')->result_array();
				foreach ($logs as $log) {
					$remark_logs_map[$log['trans_no']][] = $log;
				}
			}

			foreach ($data as &$row) {
				$kedatangan = trim((string)$row['kedatangan_truck']);
				$is_induk = ctype_digit($kedatangan); // Hanya angka murni (1, 2, 3) = baris kuning/induk

				$row['remark_sec'] = '';
				$row['remark_wh']  = '';

				if ($is_induk && isset($truck_map[$kedatangan])) {
					$truck = $truck_map[$kedatangan];

					// 🔥 Nama Supir & No Telp ikut sinkron dari Security HANYA di baris induk
					$row['nama_supir'] = $truck['nama_sopir'] ?: $row['nama_supir'];
					$row['no_telp']    = $truck['no_telp']    ?: $row['no_telp'];

					// 🔥 Susun log remark Security & Warehouse jadi teks bertumpuk (rapi, bukan numpuk per baris anak)
					$logs_for_truck = $remark_logs_map[$truck['trans_no']] ?? [];
					$sec_lines = []; $wh_lines = [];
					foreach ($logs_for_truck as $log) {
						$jam  = substr($log['created_at'], 11, 5); // HH:MM
						$line = $jam . ' - ' . $log['remarks'];
						if ($log['role'] === 'security')  $sec_lines[] = $line;
						if ($log['role'] === 'warehouse') $wh_lines[]  = $line;
					}
					$row['remark_sec'] = implode("\n", $sec_lines);
					$row['remark_wh']  = implode("\n", $wh_lines);
				} else {
					// Baris anak (1.1, 1.2, dst): KOSONGKAN supaya tidak numpuk/duplikat
					$row['nama_supir'] = '';
					$row['no_telp']    = '';
				}

				// Konversi angka desimal supaya aman dibaca JS
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
		} else {
			$data = [];
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

	public function api_cs_export()
	{
		$dari   = $this->input->get('dari');
		$sampai = $this->input->get('sampai');

		if (!$dari || !$sampai) { echo "Parameter dari & sampai wajib"; return; }
		if ($dari > $sampai) { $temp = $dari; $dari = $sampai; $sampai = $temp; }

		$this->db->select('tanggal_jadwal');
		$this->db->distinct();
		$this->db->where('tanggal_jadwal >=', $dari . '-01');
		$this->db->where('tanggal_jadwal <=', $sampai . '-31');
		$this->db->order_by('tanggal_jadwal', 'ASC');
		$tanggal_list = $this->db->get('cs_history')->result_array();

		if (empty($tanggal_list)) { echo "Tidak ada data di rentang ini"; return; }

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$spreadsheet->removeSheetByIndex(0);

		// Warna asli mengikuti file Excel CS sumber
		$COLOR_HEADER_BLUE   = '9CC2E5';
		$COLOR_TOLERANSI_YEL = 'FFFF00';
		$COLOR_WARNING_RED   = 'FF0000';
		$COLOR_JUDUL_YELLOW  = 'FFFF00';
		$COLOR_INDUK_YELLOW  = 'FEF08A';

		// Lebar kolom asli + 3 kolom tambahan remark
		$col_widths = [
			'A'=>11.82, 'B'=>24.45, 'C'=>10.45, 'D'=>12.18, 'E'=>23.82, 'F'=>5.45,
			'G'=>12.18, 'H'=>14.54, 'I'=>9.18, 'J'=>11.54, 'K'=>8.18, 'L'=>9.82,
			'M'=>9.82, 'N'=>9.18, 'O'=>9.18, 'P'=>9.18, 'Q'=>9.18, 'R'=>10.37,
			'S'=>10.09, 'T'=>15, 'U'=>15, 'V'=>20, 'W'=>20, 'X'=>20
		];

		foreach ($tanggal_list as $tgl_row) {
			$tgl = $tgl_row['tanggal_jadwal'];
			$sheet = $spreadsheet->createSheet();
			$sheet->setTitle(substr(date('d M Y', strtotime($tgl)), 0, 31));

			foreach ($col_widths as $col => $w) $sheet->getColumnDimension($col)->setWidth($w);

			// ── ROW 1-2: Judul tanggal (mirip A1:O2 merge di Excel asli) ──
			$sheet->mergeCells('A1:S2');
			$sheet->setCellValue('A1', 'CS MASTER ORDER');
			$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->getColor()->setARGB('003366');
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			// ── ROW 3: Tanggal (kuning, mirip A3:O3) ──
			$sheet->mergeCells('A3:S3');
			$sheet->setCellValue('A3', date('d F Y', strtotime($tgl)));
			$sheet->getStyle('A3')->getFont()->setBold(true)->setSize(12);
			$sheet->getStyle('A3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($COLOR_JUDUL_YELLOW);
			$sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			// ── ROW 4-5: Header 2 baris (sesuai layout asli) ──
			$headers_row4 = [
				'A'=>'Kedatangan Truck','B'=>'Nama Customer','C'=>'Area','D'=>'Urutan Bongkar',
				'E'=>'Item Desc', // (G di asli) gabung type+weight di sini
				'G'=>'Color','H'=>'Pattern Nose','I'=>'Qty/(Box/pallet)','J'=>'Qty/Pcs',
				'K'=>'Qty Box / pallet','L'=>'Status Produk','M'=>'Waktu Muat','N'=>'Status Tracking',
				'O'=>'BERAT TOTAL (Kg)','P'=>'BERAT Box (Kg)','Q'=>'BERAT ISI TRUCK',
				'R'=>'NORMAL','T'=>'TOLERANSI','V'=>'WARNING',
				'W'=>'Nama Supir / No Telp','X'=>'Remark (CS / Security / Warehouse)'
			];
			foreach ($headers_row4 as $col => $label) {
				$sheet->setCellValue($col . '4', $label);
			}
			$sheet->mergeCells('A4:A5'); $sheet->mergeCells('B4:B5'); $sheet->mergeCells('C4:C5'); $sheet->mergeCells('D4:D5');
			$sheet->mergeCells('E4:F4'); $sheet->setCellValue('E5','type'); $sheet->setCellValue('F5','weight');
			$sheet->mergeCells('G4:G5'); $sheet->mergeCells('H4:H5'); $sheet->mergeCells('I4:I5'); $sheet->mergeCells('J4:J5');
			$sheet->mergeCells('K4:K5'); $sheet->mergeCells('L4:L5'); $sheet->mergeCells('M4:M5'); $sheet->mergeCells('N4:N5');
			$sheet->mergeCells('O4:O5'); $sheet->mergeCells('P4:P5'); $sheet->mergeCells('Q4:Q5');
			$sheet->mergeCells('R4:S4'); $sheet->setCellValue('R5','Min'); $sheet->setCellValue('S5','Max');
			$sheet->mergeCells('T4:U4'); $sheet->setCellValue('T5','Min'); $sheet->setCellValue('U5','Max');
			$sheet->mergeCells('V4:V5');
			$sheet->mergeCells('W4:W5'); $sheet->mergeCells('X4:X5');

			$sheet->getStyle('A4:Q5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($COLOR_HEADER_BLUE);
			$sheet->getStyle('R4:U5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($COLOR_TOLERANSI_YEL);
			$sheet->getStyle('V4:V5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($COLOR_WARNING_RED);
			$sheet->getStyle('W4:X5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
			$sheet->getStyle('A4:X5')->getFont()->setBold(true);
			$sheet->getStyle('A4:X5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setWrapText(true);

			// ── DATA ──
			$this->db->where('tanggal_jadwal', $tgl);
			$this->db->order_by('id', 'ASC');
			$rows_db = $this->db->get('cs_history')->result_array();

			$this->db->where('tanggal', $tgl);
			$trucks = $this->db->get('truck_logs')->result_array();
			$truck_map = [];
			foreach ($trucks as $t) $truck_map[(string)$t['no_antrean']] = $t;

			$trans_no_list = array_filter(array_column($trucks, 'trans_no'));
			$remark_logs_map = [];
			if (!empty($trans_no_list)) {
				$this->db->where_in('trans_no', $trans_no_list);
				$this->db->order_by('created_at', 'ASC');
				$logs = $this->db->get('remark_logs')->result_array();
				foreach ($logs as $log) $remark_logs_map[$log['trans_no']][] = $log;
			}

			$row_idx = 6;
			foreach ($rows_db as $db_row) {
				$kedatangan = trim((string)$db_row['kedatangan_truck']);
				$is_induk   = ctype_digit($kedatangan);

				$nama_telp = ''; $remark_gabung = $db_row['remark'] ?: '';
				if ($is_induk && isset($truck_map[$kedatangan])) {
					$truck = $truck_map[$kedatangan];
					$nama_telp = ($truck['nama_sopir'] ?: '-') . "\n" . ($truck['no_telp'] ?: '-');

					$logs_for_truck = $remark_logs_map[$truck['trans_no']] ?? [];
					$sec_lines = []; $wh_lines = [];
					foreach ($logs_for_truck as $log) {
						$jam = substr($log['created_at'], 11, 5);
						if ($log['role'] === 'security')  $sec_lines[] = "[SEC $jam] " . $log['remarks'];
						if ($log['role'] === 'warehouse')  $wh_lines[]  = "[WH $jam] " . $log['remarks'];
					}
					$parts = array_filter([$remark_gabung, implode("\n", $sec_lines), implode("\n", $wh_lines)]);
					$remark_gabung = implode("\n", $parts);
				}

				$rowdata = [
					'A'=>$db_row['kedatangan_truck'], 'B'=>$db_row['nama_customer'], 'C'=>$db_row['area'],
					'D'=>$db_row['urutan_bongkar'], 'E'=>$db_row['item_desc'], 'F'=>$db_row['weight'],
					'G'=>$db_row['color'], 'H'=>$db_row['pattern_nose'], 'I'=>$db_row['qty_box_pallet'],
					'J'=>$db_row['qty_pcs'], 'K'=>$db_row['qty_box_pallet_total'], 'L'=>$db_row['status_produk'],
					'M'=>$db_row['waktu_muat'], 'N'=>$db_row['status_tracking'], 'O'=>$db_row['berat_total'],
					'P'=>$db_row['berat_box'], 'Q'=>$db_row['berat_isi_truck'], 'R'=>$db_row['normal_min'],
					'S'=>$db_row['normal_max'], 'T'=>$db_row['toleransi_min'], 'U'=>$db_row['toleransi_max'],
					'V'=>$db_row['warning'], 'W'=>$nama_telp, 'X'=>$remark_gabung
				];

				foreach ($rowdata as $col => $val) {
					$sheet->setCellValue($col . $row_idx, $val);
					$cell = $sheet->getStyle($col . $row_idx);
					$cell->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
					$cell->getAlignment()->setWrapText(true)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
					if ($is_induk) {
						$cell->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($COLOR_INDUK_YELLOW);
						$cell->getFont()->setBold(true);
					}
				}
				$row_idx++;
			}
		}

		$filename = "CS_History_" . $dari . "_sd_" . $sampai . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
	private function _unmerge_fill_values($sheet)
	{
		foreach ($sheet->getMergeCells() as $mergeRange) {
			$range = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::rangeToArray($mergeRange);
			$firstCellValue = null;
			$isFirst = true;
			foreach ($range as $rowCells) {
				foreach ($rowCells as $coord) {
					// rangeToArray sebenarnya return value langsung di versi tertentu,
					// jadi kita ambil ulang via getCell agar konsisten
				}
			}

			// Ambil koordinat awal & akhir range secara eksplisit
			[$startCell, $endCell] = explode(':', $mergeRange);
			$startCoord = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($startCell);
			$endCoord   = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($endCell);

			$startColIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($startCoord[0]);
			$endColIndex   = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($endCoord[0]);
			$startRow = (int) $startCoord[1];
			$endRow   = (int) $endCoord[1];

			$firstCellValue = $sheet->getCellByColumnAndRow($startColIndex, $startRow)->getValue();

			for ($r = $startRow; $r <= $endRow; $r++) {
				for ($c = $startColIndex; $c <= $endColIndex; $c++) {
					if ($r === $startRow && $c === $startColIndex) continue; // sel pertama, skip
					$sheet->setCellValueByColumnAndRow($c, $r, $firstCellValue);
				}
			}
		}
	}	
}
