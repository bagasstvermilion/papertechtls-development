<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qrcodecontroller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function qrcode($txt)
    {
        //$this->load->library('ciqrcode'); //pemanggilan library QR CODE

        header("Content-Type: image/png");
        $params['data'] = $txt; //'This is a text to encode become QR Code';
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
}
