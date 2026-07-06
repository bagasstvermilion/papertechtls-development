<?php
set_time_limit(0);
//ini_set('max_execution_time', 900); //set maximum execution time 900 = 15 menit (900/60)
ini_set('memory_limit', '1024M');
ini_set('post_max_size', '40M');
ini_set('upload_max_filesize', '40M');

defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

//$xlReader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();

class PhpspreadsheetController extends CI_Controller
{

	public function index()
	{
		exit();
		//echo getcwd()."\\application\\controller\\JO.xls";
		//$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		$spreadsheet = $reader->load(getcwd() . "\\application\\controllers\\JO.xls");
		$sheetData = $spreadsheet->getActiveSheet()->toArray();
	}



	public function uplod_shipping_plan()
	{

		$config['upload_path'] = './uplod/excel/';
		$config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx|csv';
		$config['max_size']	= '4048';
		$config['overwrite'] = TRUE;
		$config['remove_space'] = TRUE;
		$this->upload->initialize($config);
		$this->load->library('upload', $config); // Load konfigurasi uploadnya

		$data_metadata = array('image_metadata' => $this->upload->data());

		if (!$this->upload->do_upload('file')) { //jika tanpa ada file yg di upload maka..

			/*$datax = array(
				'id'=>$this->input->post('id'),
				'nik'=>$this->input->post('nik'),
				'nama'=>$this->input->post('nama'),
				'jabatan'=>$this->input->post('jabatan'),
				'dept'=>$this->input->post('dept'),
				'sdhdapat'=>$this->input->post('sdhdapat'),	  
				'aktif'=>$this->input->post('aktif')
			);*/

			$error = array('error' => $this->upload->display_errors());
			echo json_encode($error);
			//redirect(base_url('index.php/login'));

		} else {

			/*$datax = array(
				'id'=>$this->input->post('id'),
				'nik'=>$this->input->post('nik'),
				'nama'=>$this->input->post('nama'),
				'jabatan'=>$this->input->post('jabatan'),
				'dept'=>$this->input->post('dept'),
				'sdhdapat'=>$this->input->post('sdhdapat'),	  
				'aktif'=>$this->input->post('aktif'),
				'foto' => str_replace(" ","_",$_FILES['foto']['name'])
			);*/

			$file = str_replace(" ", "_", $_FILES['file']['name']);
			//echo "Upload file <b>" . $file . "</b> success..<br>";
			$str = "Upload file <b>" . $file . "</b> success..<br>";

			$this->fun_uplod_shipping_plan($file, $str); //proses insert record excel ke database

			/* $data['header'] = "layout/header";
			$data['navbar'] = "layout/navbar";
			$data['sidebar'] = "layout/sidebar";
			$data['body'] = "body/Unpackingpxp/view_masterpart";
			$this->load->view('template', $data); */
		}
	}


	public function fun_uplod_shipping_plan($namaFile = "", $str = "")
	{
		$dirs = "./uplod/excel/";

		if (file_exists($dirs . $namaFile)) {

			//echo "function tesla namaFile = " . $namaFile . " nama file tsb ada";

			$arr_file = explode('.', $dirs . $namaFile);
			$extension = strtolower(end($arr_file));

			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else if ('xls' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$spreadsheet = $reader->load($dirs . $namaFile);

			$sheetData = $spreadsheet->getActiveSheet()->toArray();

			//$this->db->insert_batch('importdata', $sheetData);

			//print_r(count($sheetData));
			//exit;
			$n = 0;
			$dup = 0;
			$data = array();
			$username = $this->session->userdata('username');
			$afftectedRows = 0;

			for ($i = 1; $i < count($sheetData); $i++) //baca baris data excel dari baris ke 1, baris ke 0 adalah header di excel
			{
				$datas = array(
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
				);

				$qty = $sheetData[$i]['4']; //str_replace(".", "", $sheetData[$i]['4']);

				//$a = $this->Modelku->get('user', "username='$username'")->result_array();
				//if (count($a)==0) {				    	
				//$this->Modelku->insert('user', $ar);

				/* $sql = "SELECT id from machining_shipping_plan where concat(caseno, partno, shippingcode)=concat('" . $datas['caseno'] . "', '" . $datas['partno'] . "','" . $datas['shippingcode'] . "')";				
				$rs = $this->db->query($sql);
				if ($rs->num_rows() > 0) {
					$row = $this->db->query($sql)->row_array();

					$dup = $dup + 1;
					echo "row $i caseno '" . $datas['caseno'] . "', partno '" . $datas['partno'] . "', shippingcode '" . $datas['shippingcode'] . "' skiped, already exist/ duplicate<br>";
				} else {
					$n = $n + 1;

					$this->db->insert('machining_shipping_plan', $datas);					
				} */

				//}

				//array_push($data, $datas); //untuk insert batch ini sudah OKE

				$sql = "INSERT INTO machining_shipping_plan(caseno, partno, rubetsu, partname, qty, unitweight, netweight, containerno, fta_code, shippingcode, vanningcode, efa_mfn, created_by) VALUES('" . $sheetData[$i]['0'] . "','" . $sheetData[$i]['1'] . "','" . $sheetData[$i]['2'] . "','" . $sheetData[$i]['3'] . "','" . $qty . "','" . $sheetData[$i]['5'] . "','" . $sheetData[$i]['6'] . "','" . $sheetData[$i]['7'] . "','" . $sheetData[$i]['8'] . "','" . $sheetData[$i]['9'] . "','" . $sheetData[$i]['10'] . "','" . $sheetData[$i]['11'] . "','$username') ON CONFLICT (caseno, partno, shippingcode) DO NOTHING;";
				$this->db->query($sql);

				$afftectedRows = $afftectedRows + $this->db->affected_rows();
			}
			/* echo "Total records excel file " . $i . " record<br>";
			echo "Total records excel file " . $n . " success import<br>";
			echo "Total records excel duplicate " . $dup . " record<br>"; */

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

			redirect('unpackingpxp/frm_uploadshipmentplan');
		} else {

			$str = "file not found";
			$this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>" . $str . "</span>
			    </div>");
			redirect('unpackingpxp/frm_uploadshipmentplan');
		}
	}
}
