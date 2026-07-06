<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->load->model('model_app');

    }


    public function index()
    {
        $data = "";
        $this->load->view('login', $data);
    }

    public function home()
    {
        $data['header'] = "layout/header"; //view/layout/header.php
        //$data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "home";
        $this->load->view('template', $data);
    }


    public  function prslogin()
    {

        $username = trim($this->input->post('username'));
        $password = md5(trim($this->input->post('passwrd')));

        $sql = "select * from users where username = '$username' AND passwrd = '$password' and isactive='yes'";
        //echo  $sql; exit();
        $akses = $this->db->query($sql);

        if ($akses->num_rows() == 1) {

            foreach ($akses->result_array() as $data) {

                //$this->session->set_userdata('some_name', 'some_value');
                $this->session->set_userdata('userid', $data['id']);
                $this->session->set_userdata('username', $data['username']);
                $this->session->set_userdata('nmuser', $data['name']);
                $this->session->set_userdata('role', $data['role']);
                $this->session->set_userdata('isadmin', $data['isadmin']);
                $this->session->set_userdata('ispic', $data['ispic']);
                $this->session->set_userdata('iddept', $data['iddept']);
                $this->session->set_userdata('iddoc', $data['iddoc']);
                $this->session->set_userdata('ishod', $data['ishod']);

                //$session['nama'] = $data['nama_pegawai'];
                //$session['level'] = $data['level'];
                //$session['id_jabatan'] = $data['id_jabatan'];

                $sql = "INSERT into apps_users_log.user_logs(login_dates, userid, appsid, subapps, login_date, username, subappsid) values(current_date, '" . $data['username'] . "', 41, '-',now(), '" . $data['name'] . "', '601')";
                //$this->db->query($sql);

                //$this->session->set_userdata($session);
                redirect('login/home');
            }
        } else {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>Wrong username / password.</span>
			    </div>");
            redirect('login');
        }
    }


    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }


    public function users()
    {
        if (!$this->session->userdata('username')) {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>Please login first.</span>
			    </div>");
            redirect('login');
        }

        $data['header'] = "layout/header"; //view/layout/header.php
        $data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "body/users/index";
        $this->load->view('template', $data);
    }

    //get edit data
    public function show($id)
    {
        $sql = "SELECT * from users where id='$id'";
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

        $this->db->where('id', $id); //kunci bisa pakai petik kalau key nya string
        $this->db->update('users', $data);
    }


    //hapus data
    public function destroy($id)
    {
        //$this->db->where('id', $id); //kunci bisa pakai petik kalau key nya string
        //$this->db->delete('users'); //tabel

        $data = array("isactive" => "no");
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    public function store()
    {
        $data = $this->input->post(); //get semua data post

        //hapus key passwrd1 dari array associative $data
        //karena di tabel users tidak ada kolom passwrd1
        unset($data["passwrd1"]); //unset($data["passwrd1"],$array["key3"]);

        $data["passwrd"] = md5($this->input->post("passwrd"));

        if ($data["role"] == "admin") {
            $data["isadmin"] = "yes";
        }

        //print_r($data);
        //exit();

        /* $add = array(
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('id_user'),
            'total' => $this->input->post('biaya') * $this->input->post('qty')
        );
        $data = array_merge($data, $add); */

        //$this->db->trans_start();
        $this->db->insert('users', $data);

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(array('sts' => 'gagal'));
        } else {
            echo json_encode(array('sts' => 'sukses'));
        }
        //$this->db->trans_complete();
    }


    public function data()
    {

        if (!$this->session->userdata('username')) {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <span style='color:white;'>Please login first.</span>
			    </div>");
            redirect('login');
        }

        $queryBuilder = $this->db->select('*, (SELECT name as dept from department d where d.id=cast(users.iddept as integer)), (SELECT name as doctype from doctype d2 where d2.id=users.iddoc)')
            ->from('users');
        //->where('nama<>""');
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
				   })*/asObject()->addSequenceNumber('DT_RowIndex')
            // Add extra column
            ->addColumn('isadmin', function ($row) {
                return '<span class="badge ' . fwarna_badge($row->isadmin) . ' badge-pill">' . ucfirst($row->isadmin) . '</span>';
            })
            ->addColumn('ispic', function ($row) {
                return '<span class="badge ' . fwarna_badge($row->ispic) . ' badge-pill">' . ucfirst($row->ispic) . '</span>';
            })

            ->addColumn('isactive', function ($row) {
                return '<span class="badge ' . fwarna_badge($row->isactive) . ' badge-pill">' . ucfirst($row->isactive) . '</span>';
            })
            ->addColumn('aksi', function ($row) {
                //return 'id samde '.$row->id.' tes ';
                //return '<a href="url/to/delete/post/'.$row->id.'">Delete</a>';

                $str = '';

                $str = $str . '<button title="Delete" onclick="deleteData(`' . base_url() . 'index.php/login/destroy/' . $row->id . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';

                $str = $str . '<button title="Edit" onclick="editForm(`' . base_url() . 'index.php/login/show/' . $row->id . '`,`' . base_url() . 'index.php/login/update/' . $row->id . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-search"></i></button>';

                return '<div class="btn-group">' . $str . '</div>';
            })
            ->generate();
    }
}
