<?php ini_set('memory_limit', '1024M');

defined('BASEPATH') or exit('No direct script access allowed');

class Unpackingpxpdata extends CI_Controller
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


    //default blank data table untuk inisialisasi tanpa tampil data dulu
    public function blank_data()
    {
        echo '{"draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}';
    }

    public function print_ulang_label($id)
    {
        $data["id"] = $id;
        $this->load->view('body/Unpackingpxp/print_label_print_ulang', $data);
    }

    public function uploadshipmentplan_data()
    {
        $queryBuilder = $this->db->select('id, caseno, partno, rubetsu, partname, qty, unitweight, netweight, containerno, fta_code, shippingcode, vanningcode, efa_mfn')
            ->from('machining_shipping_plan');
        //->where(array('tujuan like ' =>  '%' . $tujuan . '%'));
        //->join('product p', 'c.id=p.category_id');
        //->group_by(array('p.id'));

        //$datatables = new Ngekoding\CodeIgniterDataTables\DataTables($queryBuilder, '3'); // CodeIgniter 3		
        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);

        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->generate();
    }


    public function masterpart_data()
    {
        $queryBuilder = $this->db->select('*')
            ->from('machining_master_part');
        //->where(array('tujuan like ' =>  '%' . $tujuan . '%'));
        //->join('product p', 'c.id=p.category_id');
        //->group_by(array('p.id'));

        //$datatables = new Ngekoding\CodeIgniterDataTables\DataTables($queryBuilder, '3'); // CodeIgniter 3		
        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);

        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->generate();
    }


    public function get_machining_stock_data($partno1 = "", $partname = "")
    {
        $dataFilter = array(
            'partno1' =>  strtoupper($partno1),
            'part_name' =>  strtoupper($partname)
        );
        //$queryBuilder = $this->db->select('*')
        //->from('machining_stock_data')
        //->where(array('tujuan like ' =>  '%' . $tujuan . '%'));
        // ->where($dataFilter);

        $queryBuilder = $this->db->select('*')
            ->from('machining_stock_data')
            ->like($dataFilter);

        //$this->db->select('*');
        //$this->db->from('machining_stock_data');
        //$this->db->like($dataFilter);
        //$queryBuilder = $this->db->get();

        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);

        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->addColumn('aksi', function ($row) {

                $str = '';

                $str = $str . '<button title="Delete" onclick="deleteData(`' . base_url() . 'index.php/login/destroy/' . $row->id . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';

                $str = $str . '<button title="Edit" onclick="editForm(`' . base_url() . 'index.php/Unpackingpxpdata/machining_stock_data_show/' . $row->id . '`,`' . base_url() . 'index.php/login/machining_stock_data_update/' . $row->id . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-search"></i></button>';

                return '<div class="btn-group">' . $str . '</div>';
            })
            ->generate();
    }

    public function get_machining_finish_case($param1 = "", $param2 = "", $param3 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3);

        $dataFilter = array(
            'typecase' =>  strtoupper($param1),
            'caseno' =>  strtoupper($param2),
            'CAST(finishdate AS TEXT)' =>  $param3
        );

        $queryBuilder = $this->db->select('*')
            ->from('machining_finish_case')
            ->like($dataFilter);

        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);

        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->addColumn('aksi', function ($row) {

                $str = '';

                $str = $str . '<button title="Delete" onclick="deleteData(`' . base_url() . 'index.php/login/destroy/' . $row->id . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';

                $str = $str . '<button title="Edit" onclick="editForm(`' . base_url() . 'index.php/Unpackingpxpdata/machining_stock_data_show/' . $row->id . '`,`' . base_url() . 'index.php/login/machining_stock_data_update/' . $row->id . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-search"></i></button>';

                return '<div class="btn-group">' . $str . '</div>';
            })
            ->generate();
    }


    public function get_machining_unpacking_inprogress($param1 = "", $param2 = "", $param3 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        /* $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3); */

        $dataFilter = array(
            /* 'partno' =>  strtoupper($param1),
            'caseno' =>  strtoupper($param2), */
            'CAST(workdate AS TEXT)' =>  $param1,
            'status' =>  'FINISH SCAN'
        );

        $queryBuilder = $this->db->select('*')
            ->from('machining_unpacking')
            ->like($dataFilter);

        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);

        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->generate();
    }


    public function get_machining_unpacking_complete($param1 = "", $param2 = "", $param3 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        /* $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3); */

        $dataFilter = array(
            /* 'partno' =>  strtoupper($param1),
            'caseno' =>  strtoupper($param2), */
            'CAST(workdate AS TEXT)' =>  $param1,
            'status' =>  'COMPLETE CASE'
        );

        $queryBuilder = $this->db->select('*')
            ->from('machining_unpacking')
            ->like($dataFilter);

        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);

        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->generate();
    }


    // param1 param2 urutan uri segmen
    public function get_machining_master_part($param1 = "", $param2 = "", $param3 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3);

        $dataFilter = array(
            'partno1' =>  strtoupper($param1),
            'part_name' =>  strtoupper($param2),
            'is_special_part' =>  $param3
        );


        $queryBuilder = $this->db->select('*')
            ->from('machining_master_part')
            ->like($dataFilter);

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


    // param1 param2 urutan uri segmen
    public function get_machining_shipping_plan($param1 = "", $param2 = "", $param3 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3);

        /* print_r($this->uri->segment_array());
        echo "<br>" . $this->uri->segment(4);
        echo "<br>param1=" . $param1;
        echo "<br>param2=" . $param2; */

        $dataFilter = array(
            'caseno' =>  strtoupper($param1),
            'partno' =>  strtoupper($param2),
            'status' =>  $param3
        );

        /* $this->db->select('*');
        $this->db->from('machining_shipping_plan');
        $this->db->like($dataFilter);
        $this->db->get();
        print_r($this->db->last_query());
        exit(); */

        $queryBuilder = $this->db->select('*')
            ->from('machining_shipping_plan')
            ->like($dataFilter);

        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);
        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->addColumn('status', function ($row) {
                return '<span class="badge ' . fwarna_badge($row->status) . ' badge-pill">' . ucfirst($row->status) . '</span>';
            })
            ->addColumn('aksi', function ($row) {

                if ($row->status == 'waiting') {
                    $str = '';
                    $str = $str . '<button title="Delete" onclick="editForm(`' . base_url() . 'index.php/shipmentplanupload/show/' . $row->id . '`,`' . base_url() . 'index.php/shipmentplanupload/destroy/' . '' . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';

                    return '<div class="btn-group">' . $str . '</div>';
                }
            })
            ->generate();
    }


    // param1 param2 urutan uri segmen
    public function get_match_unmatch_actual_vs_plan($param1 = "", $param2 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        $param2 = str_replace("_BLANK_", "", $param2);

        $dataFilter = array(
            'caseno' =>  strtoupper($param1),
            'partno' =>  strtoupper($param2)
        );

        $queryBuilder = $this->db->select('*')
            ->from('view_match_unmatch_actual_vs_plan1')
            ->like($dataFilter)
            ->order_by('state', 'DESC');
        //->limit(100);

        $datatables = new Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter3($queryBuilder);
        $datatables->asObject()->addSequenceNumber('DT_RowIndex')
            ->addColumn('state', function ($row) {
                $str = $row->state;
                if ($str == "match") {
                    $warna = "badge-info";
                } else {
                    $warna = "badge-danger";
                }
                //$warna = fwarna_badge($str); //kunaon function helper case na teu jalan
                return '<span class="badge ' . $warna . ' badge-pill">' . ucfirst($str) . '</span>';
            })
            ->generate();

        /* CREATE VIEW view_match_unmatch_actual_vs_plan AS 
        SELECT caseno, partno, partname, qty_plan, qty_actual,
        case when qty_actual=qty_plan then 'match' else 'unmatch' end as state
        from (
        select msp.caseno, msp.partno, msp.partname, sum(msp.qty) as qty_plan,
        coalesce((select sum(mu.qty) from machining_unpacking mu where mu.status='FINISH SCAN' and mu.partno=msp.partno and mu.caseno=msp.caseno 
            group by mu.caseno, mu.partno),0) as qty_actual
        from machining_shipping_plan msp where msp.status='waiting' 
        group by msp.caseno, msp.partno, msp.partname
        ) as tabel_sql order by state desc */
    }
}
