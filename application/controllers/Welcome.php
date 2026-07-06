<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
        parent::__construct();

        
    }

	
    public function qrcode($txt)
    {	
    	//$this->load->library('ciqrcode'); //pemanggilan library QR CODE

    	header("Content-Type: image/png");
		$params['data'] = $txt;//'This is a text to encode become QR Code';
		$this->ciqrcode->generate($params);


		/*$params['data'] = 'This is a text to encode become QR Code';
		$params['level'] = 'H';
		$params['size'] = 10;
		$params['savename'] = FCPATH.'tes.png';
		$this->ciqrcode->generate($params);
		echo '<img src="'.base_url().'tes.png" />';
		echo "savename = ".$params['savename'];
		unlink($params['savename']);*/


    	 //require 'vendor/autoload.php';
    	//use Endroid\QrCode\QrCode;
/*$qrCode = new QrCode('http://letzcricket.com');
header('Content-Type: '.$qrCode->getContentType());
echo $qrCode->writeString();*/



    	/*$qrCode = new Endroid\QrCode\QrCode();
     	$qrCode->setText($qrCodeText)->setSize($size)->setPadding($padding)->setErrorCorrection($errCorrection)->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0));
     	$imageUri = $qrCode->getDataUri();
     	return '<img src="' . $imageUri . '" />';*/

    	//echo FCPATH;
    	exit();

        $data['title'] = "Generate QRCODE";
        $data['row_kendaraan'] = $this->db->get('kendaraan')->result(); // ambil data
        
        $data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/_contoh/qrcode";
		$this->load->view('template', $data);
    }


    public function qrcode1() 
    {
		$data['title'] = "Generate QRCODE";
        $data['row_kendaraan'] = $this->db->get('kendaraan')->result(); // ambil data
        
        $data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/_contoh/qrcode";
		$this->load->view('template', $data);
    }

	public function index($id='', $paramex='')
	{
		$data['kunci'] = $id;
		$data['paramex'] = $paramex;
		$this->load->view('welcome_message', $data);
	}

	public function wercome($parameter_1 ='', $parameter_2 ='')
	{
		//$data['kunci'] = $id;
		echo "parameter_1 = ".$parameter_1;
		echo "<br>parameter_2 = ".$parameter_2;
	}


	function import_excel() {
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/_contoh/import_excel";

		$this->load->view('template', $data); //view/template.php
	}


	function tes_template() {
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/blank";

		/* $id = trim($this->session->userdata('id_user'));

        $data['link'] = "informasi/hapus";

        $datainformasi = $this->model_app->datainformasi();
        $data['datainformasi'] = $datainformasi; */

		$this->load->view('template', $data); //view/template.php
	}


	function template_data1() {
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/_contoh/data1";

		$this->load->view('template', $data); //view/template.php
	}

	function template_data2() {
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/_contoh/data2";

		$this->load->view('template', $data); //view/template.php
	}

	function template_data3() {
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/_contoh/data3";

		$this->load->view('template', $data); //view/template.php
	}

	function template_data4() {
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/_contoh/data4";

		$this->load->view('template', $data); //view/template.php
	}

	function get_data2() {
		$sql = "SELECT * from customer";
		$row = $this->db->query($sql)->row_array();
		//print_r($row);
		//$data['id'] = $row["id"];

		echo "[".json_encode($row)."]";
	}


	public function tes_pdf()
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('dompdfmy');
        
        // title dari pdf
        $this->data['title_pdf'] = 'Laporan Penjualan Toko Kita';
        
        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_penjualan_toko_kita';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
		$html = $this->load->view('body/_contoh/laporan_pdf',$this->data, true);	    
        
        // run dompdf
		//parameter terakhir TRUE=preview pdf di browser, FALSE=pdf terdownload otomatis
        $this->dompdfmy->generate($html, $file_pdf, $paper, $orientation, TRUE); 
    }

    public function tes_pdf1()
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('dompdfmy');
        
        // title dari pdf
        $this->data['title_pdf'] = 'Laporan Penjualan Toko Kita';
        
        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_penjualan_toko_kita';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
		$html = $this->load->view('body/_contoh/laporan_pdf1',$this->data, true);	    
        
        // run dompdf
		//parameter terakhir TRUE=preview pdf di browser, FALSE=pdf terdownload otomatis
		$paper = array(0,0,612.00,792.00);
        $this->dompdfmy->generate($html, $file_pdf, $paper, $orientation, TRUE); 
    }
	
	public function get_data3($tujuan='') {

		$queryBuilder = $this->db->select('id, tujuan, keperluan, state')
                    ->from('carrequest')
                    ->where(array('tujuan like ' =>  '%'.$tujuan.'%'));
                    //->join('product p', 'c.id=p.category_id');
                    //->group_by(array('p.id'));

		//$datatables = new Ngekoding\CodeIgniterDataTables\DataTables($queryBuilder, '3');
		// CodeIgniter 3
		$datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);
		
		// Return the output as objects instead of arrays
		//$datatables->asObject();

		$datatables->
					/*->addColumn('aksi', function($row) {
						$edit = 'n<a href="#" onclick="alert(\'Edit button clicked!\')" class="btn btn-success btn-sm">Edit</a>';
					   	$delete = '<a href="#" onclick="alert(\'Delete button clicked!\')" class="btn btn-danger btn-sm">Delete</a>';
						return $edit.' '.$delete;
				   })*/
				   asObject()->addSequenceNumber('DT_RowIndex')
				    // Add extra column
					->addColumn('state', function($row) {
  						return '<span class="badge ' .fwarna_badge($row->state). ' badge-pill">' . $row->state . '</span>';
					})
					->addColumn('qrcode', function($row) {
  						return '<img src="'. base_url() .'index.php/welcome/qrcode/'.$row->state.$row->id.'" class="img-responsive img-thumbnail">';
					})
				   ->generate();
    }


    public function get_data4() {

		$queryBuilder = $this->db->select('id, nama, tahun, warna, idmerk, transmisi, norangka, nomesin, nostnk, nobpkb, atasnama, tglpajak, tglstnk')
                    ->from('kendaraan')
                    ->where('nama<>""');
                    //->join('product p', 'c.id=p.category_id');
                    //->group_by(array('p.id'));

		//$datatables = new Ngekoding\CodeIgniterDataTables\DataTables($queryBuilder, '3');
		// CodeIgniter 3
		$datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);

		$datatables->
					/*->addColumn('aksi', function($row) {
						$edit = 'n<a href="#" onclick="alert(\'Edit button clicked!\')" class="btn btn-success btn-sm">Edit</a>';
					   	$delete = '<a href="#" onclick="alert(\'Delete button clicked!\')" class="btn btn-danger btn-sm">Delete</a>';
						return $edit.' '.$delete;
				   })*/
				   asObject()->addSequenceNumber('DT_RowIndex')
				    // Add extra column
					->addColumn('aksi', function($row) {
  						//return 'id samde '.$row->id.' tes ';
				    	//return '<a href="url/to/delete/post/'.$row->id.'">Delete</a>';

						$str = '';

                		$str = $str . '<button title="Delete" onclick="deleteData(`' . base_url().'kelas/fungsidel/'.$row->id . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';

                		$str = $str . '<button title="Edit" onclick="editForm(`' . base_url().'kelas/fungsiedit/'.$row->id . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-search"></i></button>';

                		return '<div class="btn-group">' . $str . '</div>';
					})
				   ->generate();
    }
}
