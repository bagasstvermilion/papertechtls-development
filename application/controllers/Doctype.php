<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Doctype extends CI_Controller
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


    public function index()
    {
        $data['header'] = "layout/header"; //view/layout/header.php
        //$data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "body/document_reminder/doctype_index";
        $this->load->view('template', $data);
    }


    public function data($param1 = "", $param2 = "", $param3 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3);

        $iddoctype = $this->session->userdata('iddoc');
        if ($iddoctype == 1) {
            $iddoctype = ""; //user tsb dapat akses ke semua jenis doc type
        }

        //echo $iddoctype;

        $created_by = $this->session->userdata('username');
        if ($this->session->userdata('isadmin') == 'yes' || $this->session->userdata('ishod') == 'yes') {
            $created_by = "";
        }

        $iddept = $this->session->userdata('iddept');
        if ($this->session->userdata('isadmin') == 'yes') {
            $iddept = "";
        }

        /* $sql = "SELECT name from doctype where CAST(id as varchar)='" . $iddoctype . "'";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $this->db->query($sql)->row_array();
			$documenttype = $row['name'];
		} else {
			echo "<h1>Data Not Found</h1>";
		} */


        if ($param1 == 1) {
            $param1 = ""; //user tsb dapat akses ke semua jenis doc type
        }

        $dataFilter = array(
            'iddoctype1' =>  $param1,
            /*'documenttype' =>  $documenttype,*/
            'status' =>  $param2,
            'created_by' =>  $created_by,
            'cast(iddept as varchar)' =>  $iddept
        );
        //$queryBuilder = $this->db->select('*')
        //->from('machining_stock_data')
        //->where(array('tujuan like ' =>  '%' . $tujuan . '%'));
        // ->where($dataFilter);



        $queryBuilder = $this->db->select('*')
            ->from('doctype')
            ->where(array('id <> ' =>  '1'));
        //->like($dataFilter)
        //->order_by('documenttype', 'ASC')
        //->order_by('today_reminder_date', 'ASC NULLS LAST');
        //$this->db->get();
        //echo $this->db->last_query();

        //$this->db->select('*');
        //$this->db->from('machining_stock_data');
        //$this->db->like($dataFilter);
        //$queryBuilder = $this->db->get();

        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);

        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->addColumn('aksi', function ($row) {

                $str = '';

                $kontroler = 'doctype';

                $str = $str . '<button title="Delete" onclick="deleteData(`' . base_url() . 'index.php/' . $kontroler . '/destroy/' . $row->id . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';

                $str = $str . '<button title="Edit" onclick="editForm(`' . base_url() . 'index.php/' . $kontroler . '/show/' . $row->id . '`,`' . base_url() . 'index.php/' . $kontroler . '/update/' . $row->id . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-search"></i></button>';

                return '<div class="btn-group">' . $str . '</div>';
            })
            ->generate();
    }


    public function uploadshipmentplan()
    {
        $data['header'] = "layout/header"; //view/layout/header.php
        $data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "body/Unpackingpxp/uploadshipmentplan";
        $this->load->view('template', $data);
    }


    public function frm_uploadshipmentplan()
    {
        $data['header'] = "layout/header"; //view/layout/header.php
        $data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "body/Unpackingpxp/frm_uploadshipmentplan";
        $this->load->view('template', $data);
    }


    //update data
    public function update($id)
    {
        $data = $this->input->post(); //get semua data post
        //$data = $this->input->post('umur'); //get data post tertentu saja

        /* $add = array(
            'email_reminder_date' => $reminder_date,
            'today_reminder_date' => $reminder_date
        );

        $data = array_merge($data, $add); */

        $this->db->where('id', $id); //kunci bisa pakai petik kalau key nya string
        $this->db->update('doctype', $data);
    }


    //hapus data
    public function destroy($id)
    {
        //$this->db->where('id', $id); //kunci bisa pakai petik kalau key nya string
        //$this->db->delete('document'); //tabel

        $data = array("isactive" => "no");
        $this->db->where('id', $id);
        $this->db->update('doctype', $data);
    }


    public function store()
    {
        $data = $this->input->post(); //get semua data post

        //hapus key passwrd1 dari array associative $data
        //karena di tabel document tidak ada kolom passwrd1
        // unset($data["passwrd1"]); //unset($data["passwrd1"],$array["key3"]);

        //$data["passwrd"] = md5($this->input->post("passwrd"));

        //print_r($data);
        //exit();



        $add = array(
            'created_by' => $this->session->userdata('username'),
            'created_at' => date("Y-m-d H:i:s")
        );


        $data = array_merge($data, $add);

        //$this->db->trans_start();
        $this->db->insert('doctype', $data);
        //$lastid = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(array('sts' => 'gagal'));
        } else {
            echo json_encode(array('sts' => 'sukses'));
        }
        //$this->db->trans_complete();
    }


    //get edit data
    public function show($id)
    {
        $sql = "SELECT * from doctype where id=$id";
        $rs = $this->db->query($sql)->row_array();
        //print_r($row);
        //$data['id'] = $row["id"];
        $rs = $this->db->query($sql);
        if ($rs->num_rows() > 0) {
            $row = $this->db->query($sql)->row_array();
            echo json_encode($row);
            //echo json_encode(array('status' => 'record_found'));
        } else {
            echo json_encode(array('status' => 'no_record_foundz'));
        }
    }
}
