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

class Rapel extends CI_Controller
{

    public function index()
    {
        $data['header'] = "layout/header"; //view/layout/header.php
        //$data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "rapel_form_upload";
        $this->load->view('template', $data);
    }



    public function uplod()
    {

        $this->session->unset_userdata('msg');

        $config['upload_path'] = './uplod/rapel/';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx|csv';
        $config['max_size']    = '4048';
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
            echo "Upload file <b>" . $file . "</b> success..<br>";
            $str = "Upload file <b>" . $file . "</b> success..<br>";

            $this->uplod_proses($file, $str); //proses insert record excel ke database

            /* $data['header'] = "layout/header";
			$data['navbar'] = "layout/navbar";
			$data['sidebar'] = "layout/sidebar";
			$data['body'] = "body/Unpackingpxp/view_masterpart";
			$this->load->view('template', $data); */
        }
    }


    public function uplod_proses($namaFile = "", $str = "")
    {
        $dirs = "./uplod/rapel/";

        echo "function tesla namaFile = " . $namaFile . " nama file tsb ada";
        //exit();

        if (file_exists($dirs . $namaFile)) {

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

            $tahun_rapel = '2025';

            $data = array();
            //$username = $this->session->userdata('username');
            $afftectedRows = 0;

            for ($i = 7; $i < count($sheetData); $i++) //baca baris data excel dari baris ke 1, baris ke 0 adalah header di excel
            {
                if (strlen($sheetData[$i]['1']) > 6) {
                    $datas = array(
                        'tahun'  => $tahun_rapel,
                        'kolom01'  => $sheetData[$i]['1'],
                        'kolom02'  => $sheetData[$i]['2'],
                        'kolom03'  => $sheetData[$i]['3'],
                        'kolom04'  => $sheetData[$i]['4'],
                        'kolom05'  => $sheetData[$i]['5'],
                        'kolom06'  => $sheetData[$i]['6'],
                        'kolom07'  => $sheetData[$i]['7'],
                        'kolom08'  => $sheetData[$i]['8'],
                        'kolom09'  => $sheetData[$i]['9'],
                        'kolom10'  => $sheetData[$i]['10'],
                        'kolom11'  => $sheetData[$i]['11'],
                        'kolom12'  => $sheetData[$i]['12'],
                        'kolom13'  => $sheetData[$i]['13'],
                        'kolom14'  => $sheetData[$i]['14'],
                        'kolom15'  => $sheetData[$i]['15'],
                        'kolom16'  => $sheetData[$i]['16'],
                        'kolom17'  => $sheetData[$i]['17'],
                        'kolom18'  => $sheetData[$i]['18'],
                        'kolom19'  => $sheetData[$i]['19'],
                        'kolom20'  => $sheetData[$i]['20'],
                        'kolom21'  => $sheetData[$i]['21'],
                        'kolom22'  => $sheetData[$i]['22'],
                        'kolom23'  => $sheetData[$i]['23'],
                        'kolom24'  => $sheetData[$i]['24'],
                        'kolom25'  => $sheetData[$i]['25'],
                        'kolom26'  => $sheetData[$i]['26'],
                        'kolom27'  => $sheetData[$i]['27'],
                        'kolom28'  => $sheetData[$i]['28'],
                        'kolom29'  => $sheetData[$i]['29'],
                        'kolom30'  => $sheetData[$i]['30'],
                        'kolom31'  => $sheetData[$i]['31'],
                        'kolom32'  => $sheetData[$i]['32'],
                        'kolom33'  => $sheetData[$i]['33'],
                        'kolom34'  => $sheetData[$i]['34'],
                        'kolom35'  => $sheetData[$i]['35'],
                        'kolom36'  => $sheetData[$i]['36'],
                        'kolom37'  => $sheetData[$i]['37'],
                        'kolom38'  => $sheetData[$i]['38'],
                        'kolom39'  => $sheetData[$i]['39'],
                        'kolom40'  => $sheetData[$i]['40'],
                        'kolom41'  => $sheetData[$i]['41'],
                        'kolom42'  => $sheetData[$i]['42'],
                        'kolom43'  => $sheetData[$i]['43'],
                        'kolom44'  => $sheetData[$i]['44'],
                        'kolom45'  => $sheetData[$i]['45'],
                        'kolom46'  => $sheetData[$i]['46'],
                        'kolom47'  => $sheetData[$i]['47'],
                        'kolom48'  => $sheetData[$i]['48'],
                        'kolom49'  => $sheetData[$i]['49'],
                        'kolom50'  => $sheetData[$i]['50'],
                        'kolom51'  => $sheetData[$i]['51'],
                        'kolom52'  => $sheetData[$i]['52'],
                        'kolom53'  => $sheetData[$i]['53']
                    );
                }

                //$qty = $sheetData[$i]['4']; //str_replace(".", "", $sheetData[$i]['4']);

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

                array_push($data, $datas); //untuk insert batch ini sudah OKE

                /* $sql = "INSERT INTO machining_shipping_plan(caseno, partno, rubetsu, partname, qty, unitweight, netweight, containerno, fta_code, shippingcode, vanningcode, efa_mfn, created_by) VALUES('" . $sheetData[$i]['0'] . "','" . $sheetData[$i]['1'] . "','" . $sheetData[$i]['2'] . "','" . $sheetData[$i]['3'] . "','" . $qty . "','" . $sheetData[$i]['5'] . "','" . $sheetData[$i]['6'] . "','" . $sheetData[$i]['7'] . "','" . $sheetData[$i]['8'] . "','" . $sheetData[$i]['9'] . "','" . $sheetData[$i]['10'] . "','" . $sheetData[$i]['11'] . "','$username') ON CONFLICT (caseno, partno, shippingcode) DO NOTHING;";
                $this->db->query($sql); */

                ///$afftectedRows = $afftectedRows + $this->db->affected_rows();
            }
            /* echo "Total records excel file " . $i . " record<br>";
			echo "Total records excel file " . $n . " success import<br>";
			echo "Total records excel duplicate " . $dup . " record<br>"; */

            $this->db->insert_batch('rapel1', $data); //ini sudah OKE
            $afftectedRows = $afftectedRows + $this->db->affected_rows();

            //$id = $this->db->insert_id();

            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>" . $str . "<br>afftectedRows " . $afftectedRows . "</span>
			    </div>");

            /* $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>" . $str . "<br>afftectedRows " . $afftectedRows . "<br>id " . $id . "</span>
			    </div>"); */

            redirect('rapel/index');
        } else {

            $str = "file not found";
            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>" . $str . "</span>
			    </div>");
            redirect('rapel/index');
        }
    }


    public function slip($nik)
    {
        $data['nik'] = $nik;
        $this->load->view('rapel_slip_gaji', $data);
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

        $html = $this->load->view('body/_contoh/laporan_pdf', $this->data, true);

        // run dompdf
        //parameter terakhir TRUE=preview pdf di browser, FALSE=pdf terdownload otomatis
        $this->dompdfmy->generate($html, $file_pdf, $paper, $orientation, TRUE);
    }


    public function genpdf()
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('dompdfmy');

        // title dari pdf
        $this->data['title_pdf'] = 'Laporan Penjualan Toko Kita';

        //filename dari pdf ketika didownload
        //$file_pdf = 'laporan_penjualan_toko_kita';
        //setting paper
        $paper = 'A4';
        //$paper = array(0, 0, 612.00, 792.00); //custom paper size
        //orientasi paper potrait / landscape
        $orientation = "landscape";

        //$html = $this->load->view('rapel_slip_gaji', $this->data, true);

        $folder =  FCPATH . 'pdfs/';

        echo "Generating PDF please wait..<br>";
        $n = 2;

        $is_setpwd = 'yes';

        //for ($i = 0; $i <= $n; $i++) {
        $sql = "SELECT * FROM rapel1 /*where kolom01 in (select kolom01 from rapel1 where kolom07 not like '%HRD%')*/ ";
        //$sql = "SELECT * FROM rapel1 where kolom01 in ('IO-5974')";
        $rs = $this->db->query($sql);

        //if ($rs->num_rows() > 0) {
        foreach ($rs->result_array() as $row) {

            $data["nik"] = $row["kolom01"];

            $html = $this->load->view('rapel_slip_gaji', $data, true);

            $file_pdf = '' . $row['kolom01']; //. '.pdf'; //otomatis sudah ada extention .pdf nya sendiri
            $filename = $folder . $file_pdf;

            $pwd = substr($row['kolom01'], 3, 4);

            //generate ke file
            $this->dompdfmy->createPDF($html, $filename, $paper, $orientation, TRUE, $is_setpwd, $pwd);

            //kirim email
            $this->fun_kirim_email($data['nik']);
        }

        //foreach ($rs->result_array() as $row) {
        //kirim email
        //$this->fun_kirim_email($data['nik']);
        //}

        echo "Generate PDF to File is done.";
    }



    public function fun_kirim_email($nik)
    {

        ini_set('SMTP', 'smtp.okalog.co.id');
        ini_set('smtp_port', 465);

        // Konfigurasi email ini ga jalan, bisa jalan karena ada konfigurasi di mail.exe di folder xampp
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'mail',
            //'smtp_host' => 'smtp.gmail.com',
            //'smtp_host' => 'smtp-relay.gmail.com',
            //'smtp_host' => 'smtp.googlemail.com',
            'smtp_host' => 'smtp.okalog.co.id',
            //'smtp_host' => 'ssl://smtp.googlemail.com',
            //'smtp_user' => 'reminder.oln@gmail.com',  // Email gmail
            //'smtp_pass'   => 'gcrjrujvgzbbrhph',  // Password gmail

            'smtp_user' => 'it02@okalog.co.id',  // Email gmail
            'smtp_pass'   => 'Olcoln112233',  // Password gmail

            'smtp_crypto' => 'ssl',
            'smtp_port'   => 465,
            //'smtp_port'   => 25,
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];

        // Load library email dan konfigurasinya
        //$this->load->library('email');

        $config1['charset'] = 'iso-8859-1';
        $config1['mailtype'] = 'html';
        $config1['crlf'] = "\r\n";
        $config1['newline'] = "\r\n";

        $this->email->initialize($config1);
        $this->email->set_newline("\r\n");

        $sql = "SELECT kolom01 as nik, kolom53 as email, kolom02 as nama from rapel1 where kolom01='$nik'";
        //$rs = $this->db->query($sql);
        $row = $this->db->query($sql)->row_array();
        //$label_id = $row['id'];

        // Email dan nama pengirim
        //$this->email->from('reminder.oln@gmail.com', 'OLN, Document Reminder');
        $this->email->from('reminder@okalog.co.id', 'OLN, Payroll');

        // Email penerima
        $this->email->to($row['email']); // Ganti dengan email tujuan                    

        /* $hod_email = "";
        $sql1 = "SELECT email from users where iddept='" . $row['iddept'] . "' and ishod='yes'";
        $rs1 = $this->db->query($sql1);
        if ($rs1->num_rows() > 0) {
            $row1 = $this->db->query($sql1)->row_array();            
            $hod_email = $row1['email'];
        } */

        /* $lampiran = "";
        $sql2 = "SELECT name from document_attachment where docid='$iddoc'";
        $rs2 = $this->db->query($sql2);
        if ($rs2->num_rows() > 0) {
            $row2 = $this->db->query($sql2)->row_array();
            $lampiran = $row2['name'];

            $this->email->attach('http://192.168.1.57/dev/document_reminder/uplod/lampiran/' . $row2['name']);
        } else {
            $lampiran = "";
        } */

        //lampiran
        //$folder =  "C:\\\\xampp\\\htdocs\\\\dev\\\document_reminder\\\pdfs\\\\"; //FCPATH . "pdfs\\";
        $folder =  FCPATH . "pdfs\\";
        $this->email->attach($folder . $nik . ".pdf");
        //$this->email->attach('http://192.168.1.57/dev/document_reminder/pdfs/' . $nik . '.pdf');

        //$this->email->cc('someone@gmail.com');
        //$this->email->cc($hod_email);
        //$this->email->bcc('it02@okalog.co.id', 'it01@okalog.co.id', 'fey@okalog.co.id');

        //if ($lampiran !== "") {
        // Lampiran email, isi dengan url/path file
        //$this->email->attach('http://intranet.oln/dev/document_reminder/uplod/lampiran/' . $lampiran);
        //}

        // Subject email
        $this->email->subject('REVISI Slip Rapel Kenaikan Gaji Tahun 2025 PT. Okamoto Logistics Nusantara');

        // Isi email                    
        $str = "<span style='font-family:verdana'>Dear " . $row['nama'] . ",<br><br>

                        Terlampir REVISI PDF Slip Rapel Kenaikan Gaji Tahun 2025 anda<br>
                        kata sandi adalah nomor IO anda, contoh 1234<br><br>Mohon Abaikan Email Sebelumnya<br><br>";

        /* if ($lampiran !== "") {
            $str = $str . "Lampiran : $lampiran<br><br>";
        } */

        $str = $str . "Terima kasih.
                        <br>
                        <br>
                        Regards<br>
                        PT. Okamoto Logistics Nusantara";


        $this->email->message($str);

        if ($this->email->send()) {
            echo '<br>Sukses! email berhasil dikirim ke ' . $row['nama'] . ' ' . $row['nama'] . ' pada ' . date("Y-m-d H:i:s") . '<hr>';
            echo $this->email->print_debugger();
        } else {
            //echo 'Error! email tidak dapat dikirim.';
            show_error($this->email->print_debugger());
        }

        $this->email->clear(TRUE); //reset semua variabel email termasuk me remove attachments

        //echo "<hr>" . $folder . $nik . ".pdf<hr>";
        //exit();
    }
}
