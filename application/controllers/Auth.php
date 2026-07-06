<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $this->load->view('login');
    }

    public function uploadshipmentplan()
    {
        /* $data['header'] = "layout/header"; //view/layout/header.php
        $data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "body/Unpackingpxp/frm_uploadshipmentplan";
        $this->load->view('template', $data); */
    }
}
