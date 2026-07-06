<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');

        if (!$this->session->userdata('username')) {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <span style='color:white;'>Please login first.</span>
                </div>");
            redirect('login');
        }
    }

    public function index()
    {
        // View ini tidak menggunakan template base (header/sidebar) 
        // karena murni untuk Fullscreen TV Display di Pabrik.
        $this->load->view('monitor');
    }

    public function data()
    {
        // Pastikan hanya diakses via AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $hari_ini = date('Y-m-d');

        // Tarik data truk hari ini yang punya loading dock dan belum dicancel
       $this->db->select('loading_dock, no_antrean, no_polisi, status_loading, nama_sopir');
        $this->db->where('tanggal', $hari_ini);
        $this->db->where('loading_dock IS NOT NULL');
        $this->db->where('status_loading !=', 'Cancel');
        $this->db->where('is_completed !=', 'yes'); // Truk yang sudah Completed tidak tampil di Monitor TV
        $this->db->order_by('loading_dock', 'ASC');
        $trucks = $this->db->get('truck_logs')->result_array();

        $antrean = [];
        foreach ($trucks as $row) {
            $antrean[] = [
                'dock'       => $row['loading_dock'],
                'kedatangan' => $row['no_antrean'],
                'plat'       => $row['no_polisi'],
                'status'     => $row['status_loading'],
                'sopir'      => $row['nama_sopir']
            ];
        }

        // Return JSON ke layar TV
        header('Content-Type: application/json');
        echo json_encode($antrean);
        exit;
    }
}