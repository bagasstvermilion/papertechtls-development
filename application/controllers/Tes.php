<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        /* if (!$this->session->userdata('username')) {
			$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>Please login first.</span>
			    </div>");
			redirect('login');
		} */
    }

    public function index()
    {
        $source = "\\\\10.205.48.239\\k255\\jasexcel\\dailyTrans.xlsx";
        $destination = "C:\\xampp\\htdocs\\papertechtls\\uplod\\dailyTrans.xlsx";

        if (copy($source, $destination)) {
            echo "File berhasil dicopy";
        } else {
            echo "Gagal copy file";
        }


        $path = "\\\\10.205.48.239\\k255\\jasexcel";

        $files = scandir($path);

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                echo $file . "<br>";
            }
        }
    }
}
