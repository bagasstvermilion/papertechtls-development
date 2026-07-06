<?php
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



	public function uplod()
	{

		$config['upload_path'] = './uplod/excel/';
		$config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx|csv';
		$config['max_size']	= '48';
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
			echo "Upload file <b>" . $file . "</b> sukses..<br>";
			$this->tesla($file);
		}
	}


	public function tesla($namaFile = "")
	{

		$dirs = "./uplod/excel/";

		if (file_exists($dirs . $namaFile)) {

			echo "function tesla namaFile = " . $namaFile . " nama file tsb ada";

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

			print_r(count($sheetData));
			exit;

			for ($i = 1; $i < count($sheetData); $i++) //baca baris data excel
			{
				$datas = array(
					'F1' => $sheetData[$i]['0'],
					'F2' => $sheetData[$i]['1'],
					'F3' => $sheetData[$i]['2']
				);

				array_push($data, $datas);

				//$a = $this->Modelku->get('user', "username='$username'")->result_array();
				//if (count($a)==0) {				    	
				//$this->Modelku->insert('user', $ar);

				//$this->db->insert('importdata', $datas);
				//}
			}
			//$this->db->insert_batch('importdata', $data);
		} else {
			echo "file not found";
		}
	}
}
