<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masterpart extends CI_Controller
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
        $data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "body/Unpackingpxp/view_masterpart";
        $this->load->view('template', $data);
    }


    //get edit data
    public function show($id)
    {
        //$sql = "SELECT * from machining_master_part where id='$id'";
        $sql = "SELECT mmp.id,  mmp.partno1, mmp.partno2, mmp.part_name, qty_box, qty_unit, qty_safety_stock, nw, supply, part_address_oln, hamidasi_address, part_address_hml, project, oln_line, is_special_part, line_code, qty_endstock, line_code, qty_endstock, last_updatedate, last_updatetime, last_stodate, last_sto_qty FROM machining_master_part mmp join machining_stock_data msd on mmp.partno1=msd.partno1 where mmp.id='$id'";
        $rs = $this->db->query($sql)->row_array();
        //print_r($row);
        //$data['id'] = $row["id"];
        $rs = $this->db->query($sql);
        if ($rs->num_rows() > 0) {
            $row = $this->db->query($sql)->row_array();
            echo json_encode($row);
            //echo json_encode(array('status' => 'record_found'));
        } else {
            echo json_encode(array('status' => 'no_record_found'));
        }
    }

    //update data
    public function update($id)
    {
        $data = $this->input->post(); //get semua data post        
        //$data = $this->input->post('umur'); //get data post tertentu saja
		
		$data1['partno1'] = $data["partno1"];
        $data1['partno2'] = $data["partno2"];
        $data1['part_name'] = $data["part_name"];
        $data1['qty_endstock'] = $data["qty_endstock"];
        $data1['line_code'] = $data["line_code"];
        $data1['last_updatedate'] = date("Y-m-d");
        $data1['last_updatetime'] = date("H:i:s");
        $this->db->where('partno1', $data["partno1"]); //kunci bisa pakai petik kalau key nya string
        $this->db->update('machining_stock_data', $data1);

        unset($data["qty_endstock"], $data["line_code"]); //di tabel master part tidak ada kolom qty_endstock dan line_code

        //tambah data saat update
        $add_data = array(
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata('username')
        );
        $data = array_merge($data, $add_data);

        $this->db->where('id', $id); //kunci bisa pakai petik kalau key nya string
        $this->db->update('machining_master_part', $data);
        
    }


    //hapus data
    public function destroy($id)
    {
        //$this->db->where('id', $id); //kunci bisa pakai petik kalau key nya string
        //$this->db->delete('machining_master_part'); //tabel

        //$data = array("isactive" => "no");
        //$this->db->where('id', $id);
        //$this->db->update('machining_master_part', $data);
    }

    public function store()
    {
        $data = $this->input->post(); //get semua data post

        //hapus key passwrd1 dari array associative $data
        //karena di tabel machining_master_part tidak ada kolom passwrd1
        //unset($data["passwrd1"]); //unset($data["passwrd1"],$array["key3"]);

        //insert ke tabel stock data
        $data1['partno1'] = $data["partno1"];
        $data1['partno2'] = $data["partno2"];
        $data1['part_name'] = $data["part_name"];
        $data1['qty_endstock'] = $data["qty_endstock"];
        $data1['line_code'] = $data["line_code"];
        $this->db->insert('machining_stock_data', $data1);


        unset($data["qty_endstock"], $data["line_code"]); //di tabel master part tidak ada kolom qty_endstock dan line_code

        $add_data = array(
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('username')
        );
        $data = array_merge($data, $add_data);

        //$this->db->trans_start();
        $this->db->insert('machining_master_part', $data);

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(array('sts' => 'gagal'));
        } else {
            echo json_encode(array('sts' => 'sukses'));
        }
        //$this->db->trans_complete();
    }


    public function data($param1 = "", $param2 = "", $param3 = "")
    {
        // param1 param2 urutan uri segmen

        $param1 = str_replace("_BLANK_", "", $param1);
        $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3);

        $dataFilter = array(
            'mmp.partno1' =>  strtoupper($param1),
            'mmp.part_name' =>  strtoupper($param2),
            'is_special_part' =>  $param3
        );

        $queryBuilder = $this->db->select('mmp.id,  mmp.partno1, mmp.partno2, mmp.part_name, qty_box, qty_unit, qty_safety_stock, nw, supply, part_address_oln, hamidasi_address, part_address_hml, project, oln_line, is_special_part, line_code, qty_endstock, line_code, qty_endstock, last_updatedate, last_updatetime, last_stodate, last_sto_qty')
            ->from('machining_master_part mmp')
            ->join('machining_stock_data msd', 'mmp.partno1=msd.partno1')
            ->like($dataFilter)
            ->order_by('created_at', 'DESC')
            ->order_by('updated_at', 'DESC');

        //print_r($this->db->last_query());
        //exit();

        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);
        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->addColumn('is_special_part', function ($row) {
                $str = $row->is_special_part;
                if ($str == "yes") {
                    $warna = "badge-info";
                } else {
                    $warna = "badge-warning";
                }
                //$warna = fwarna_badge($str); //kunaon function helper case na teu jalan
                return '<span class="badge ' . $warna . ' badge-pill">' . ucfirst($str) . '</span>';
            })
            ->addColumn('aksi', function ($row) {

                $str = '';

                $str = $str . '<button title="Edit" onclick="editForm(`' . base_url() . 'index.php/Masterpart/show/' . $row->id . '`,`' . base_url() . 'index.php/Masterpart/update/' . $row->id . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-search"></i></button>';

                return '<div class="btn-group">' . $str . '</div>';
            })
            ->generate();
    }
}
