<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unpackingpxp extends CI_Controller
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

	public function print_label($keycode, $partno, $caseno)
	{
		$data['keycode'] = $keycode;
		$data['partno'] = $partno;
		$data['caseno'] = $caseno;
		//$data['body'] = "body/Unpackingpxp/print_label";
		$this->load->view('body/Unpackingpxp/print_label', $data);
	}

	public function print_label_spesial_part($partno, $caseno)
	{
		$data['partno'] = $partno;
		$data['caseno'] = $caseno;
		//$data['body'] = "body/Unpackingpxp/print_label";
		$this->load->view('body/Unpackingpxp/print_label_spesial_part', $data);
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
	}

	public function unavailable_master_stock()
	{
		$data['header'] = "layout/header"; //view/layout/header.php
		//$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/Unpackingpxp/unavailable_master_stock";
		$this->load->view('template', $data);
	}

	public function index()
	{
		$data['header'] = "layout/header"; //view/layout/header.php
		//$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/Unpackingpxp/mainform";
		$this->load->view('template', $data);
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





	public function get_qtysafetyendstock($id)
	{
		$sql = "SELECT msd.Qty_EndStock, mmp.Qty_Safety_Stock, mmp.part_name, mmp.hamidasi_address, mmp.part_address_oln/*, mmp.part_address_hml*/ from machining_stock_data msd, machining_master_part mmp where msd.partno1=mmp.partno1 and mmp.partno1='$id'";
		//$row = $this->db->query($sql)->row_array();
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $this->db->query($sql)->row_array();
			echo json_encode($row);
		} else {
			echo json_encode(array('qty_endstock' => '0', 'qty_safety_stock' => '0', 'part_name' => 'not found, check master part and stock data', 'hamidasi_address' => 'not found, check master part and stock data', 'part_address_oln' => 'not found, check master part and stock data'));
		}
		//print_r($row);
		//$data['id'] = $row["id"];
	}

	public function cek_caseno($id)
	{
		$sql = "SELECT distinct caseno from machining_shipping_plan where caseno='$id'";
		//echo $sql;
		//$row = $this->db->query($sql)->row_array();
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			//$row = $this->db->query($sql)->row_array();
			//echo json_encode($row);
			echo json_encode(array('sts' => 'true')); //record found
		} else {
			echo json_encode(array('sts' => 'true')); //record not found
		}
		//print_r($row);
		//$data['id'] = $row["id"];		
	}


	public function fun_is_caseno_complete($id)
	{
		$sql = "SELECT id as sts from machining_finish_case where caseno='$id' and status='COMPLETE CASE'";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			//$row = $this->db->query($sql)->row_array();
			//echo json_encode($row);
			echo json_encode(array('sts' => 1)); //case complete found

		} else {

			//$sql = "SELECT id as sts from machining_shipping_plan where caseno='$id' and status='waiting'";
			$sql = "SELECT id as sts from machining_shipping_plan where caseno='$id' and status<>'done'";
			$rs = $this->db->query($sql);
			if ($rs->num_rows() > 0) {
				//$row = $this->db->query($sql)->row_array();
				//echo json_encode($row);
				echo json_encode(array('sts' => 0)); //info user boleh scan HML label
			} else {
				echo json_encode(array('sts' => 2)); //case yg masih waiting not found
			}
		}
	}


	public function fun_savedata1()
	{
		$scanLabelMark = $this->input->get('scanLabelMark');
		$caseNo = $this->input->get('caseno');
		$partno = $this->input->get('partno');
		$qty = $this->input->get('qty');
		$data['partno'] = $partno;
		$data['caseno'] = $caseNo;
		$data['status'] = 'FINISH SCAN';

		$data['worktime'] = date("H:m:s");
		$data['workdate'] = date("Y-m-d");
		$data['username'] = $this->session->userdata('username');
		$username = $data['username'];
		$data['hmlqrcode'] = $scanLabelMark;

		$is_special_part = 'no';
		$qty_unit = 0;

		//apakah partno ini spesial part
		$sql = "SELECT is_special_part, qty_unit from machining_master_part mmp where mmp.partno1='$partno'";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $this->db->query($sql)->row_array();
			$is_special_part =  $row["is_special_part"];
			$qty_unit =  $row["qty_unit"];
		}

		//apakah qty actual per part yg di input melebihi plan ?
		$sql = "SELECT CASE when (select coalesce(sum(qty),0)+$qty actual from machining_unpacking WHERE caseno='$caseNo' AND partno='$partno') > (select qty plan from machining_shipping_plan WHERE caseno='$caseNo' AND partno='$partno') then 'aktual_melebihi_plan' else 'lanjut_proses' end as hasil";
		$row = $this->db->query($sql)->row_array();
		if ($row["hasil"] == "aktual_melebihi_plan") {
			echo json_encode(array('sts' => 9, 'keyCode' => '', 'state' => $row['hasil'], 'is_special_part' => $is_special_part));
			exit();
		}

		//cek jika qty actual yg di scan/ input apakah sudah sesuai dengan plan? apakah ada duplicate di tabel machining_unpacking
		//jika ya, set status shipping plan yg masih waiting untuk caseno dan partNo tsb menjadi done				
		$sql = "SELECT mu.id from machining_shipping_plan msp, machining_unpacking mu where mu.caseno=msp.caseno and mu.partno=msp.partno and mu.qty=msp.qty and mu.caseno='$caseNo' and mu.partno='$partno' and mu.qty=$qty and mu.status='FINISH SCAN' and hmlqrcode='$scanLabelMark'";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			echo json_encode(array('sts' => 0, 'keyCode' => '', 'state' => 'duplikat', 'is_special_part' => $is_special_part)); //data partno caseno qty identik duplikat
		} else {
			//get total scan untuk nomor urut keycode
			$sql = "SELECT count(caseno) as total_scan from machining_unpacking where concat(caseno)='$caseNo'";
			$rs = $this->db->query($sql);
			if ($rs->num_rows() > 0) {
				$row = $this->db->query($sql)->row_array();
				//echo json_encode($row);
				if ($row['total_scan'] < 1) {
					$total_scan = 1;
				} else {
					$total_scan = $row['total_scan'] + 1;
				}
			} else {
				//echo json_encode(array('status' => 'no_record_found'));
				$total_scan = 1;
			}
			//echo "<br> total scan" . $total_scan;
			//exit();

			$this->db->trans_start();

			//$("#slmKeyCode").val("???"); //generate keycode //barcodeLabelOLN = slmPartNo+slmQty+'L'+yymmddxxxxx+slmCaseNo

			if ($is_special_part == "no") {
				$data['qty'] = $qty;

				$data['keycode'] = "M01" . $data['partno'] . "" . sprintf("%05s", $data['qty']) . "L" . date("ymd") . sprintf("%05s", $total_scan) . $caseNo;
				$keyCode = $data['keycode'];

				$this->db->insert('machining_unpacking', $data);
			} else {

				$nloop = $qty / $qty_unit;
				$qty_per_loop = $qty / $nloop;
				$data['qty'] = $qty_per_loop;
				/* echo "<br>" . $qty_unit;
				echo "<br>" . $nloop; */

				for ($i = 1; $i < ($nloop + 1); $i++) {
					$data['keycode'] = "M01" . $data['partno'] . "" . sprintf("%05s", $data['qty']) . "L" . date("ymd") . sprintf("%05s", $total_scan) . $caseNo;
					$keyCode = ""; //$data['keycode'];

					/* echo "<hr>";
					print_r($data); */

					$this->db->insert('machining_unpacking', $data);

					$total_scan = $total_scan + 1;
				}
				/* echo "xxxxxxxx";
				exit(); */
			}

			//$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				echo json_encode(array('sts' => 0, 'keyCode' => $keyCode, 'state' => '', 'is_special_part' => $is_special_part));
			} else {

				//stock bertambah
				$cdate = date('Y-m-d');
				$ctime = date('H:i:s');
				$sql = "UPDATE machining_stock_data set qty_endstock=(qty_endstock+$qty), last_updatedate='$cdate', last_updatetime='$ctime', last_updateby='$username' where partno1='$partno'";
				$this->db->query($sql);

				echo json_encode(array('sts' => 1, 'keyCode' => $keyCode, 'state' => '', 'is_special_part' => $is_special_part)); //sts = true
			}
			$this->db->trans_complete();

			//20220906 set status shipping plan sedang dalam proses
			$sql = "UPDATE machining_shipping_plan SET status='progress' WHERE status='waiting' AND caseno='$caseNo' AND partno='$partno'";
			$this->db->query($sql);
		}
	}

	public function get_total_scan($id)
	{
		$sql = "SELECT count(caseno) as total_scan from machining_unpacking where concat(caseno)='$id' /*and status='FINISH SCAN'*/";
		//$row = $this->db->query($sql)->row_array();
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $this->db->query($sql)->row_array();
			echo json_encode($row);
		} else {
			echo json_encode(array('total_scan' => '0')); //record_not_found
		}
	}

	public function cek_partnocaseno($id)
	{
		$sql = "SELECT caseno, partno from machining_shipping_plan where concat(caseno, partno)='$id'";
		//$rs = $this->db->query($sql)->row_array();
		//print_r($row);
		//$data['id'] = $row["id"];
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $this->db->query($sql)->row_array();
			//echo json_encode($row);
			echo json_encode(array('status' => 'record_found'));
		} else {
			echo json_encode(array('status' => 'no_record_found'));
		}
	}

	public function get_qtyplanbox_actualbox_bycaseno($id)
	{
		$sql = "SELECT (SELECT COALESCE(sum(mu.qty),0) as qty_actual from machining_unpacking mu WHERE concat(mu.caseno)='$id'),(
			SELECT COALESCE(sum(msp.qty),0) as qty_plan from machining_shipping_plan msp where concat(msp.caseno)='$id')";
		//$rs = $this->db->query($sql)->row_array();
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $this->db->query($sql)->row_array();
			//$data['id'] = $row["id"];
			echo json_encode($row);
		} else {
			echo json_encode(array('qty_actual' => '0', 'qty_plan' => '0'));
		}
	}

	public function get_qtyplanbox_actualbox_bycasenopartno($id)
	{
		$sql = "SELECT (SELECT COALESCE(sum(mu.qty),0) as qty_actual_casenopartno from machining_unpacking mu WHERE concat(mu.caseno,mu.partno)='$id'),(
			SELECT COALESCE(sum(msp.qty),0) as qty_plan_casenopartno from machining_shipping_plan msp where concat(msp.caseno,msp.partno)='$id')";
		//echo $sql;
		//$rs = $this->db->query($sql)->row_array();
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $this->db->query($sql)->row_array();
			//$data['id'] = $row["id"];
			echo json_encode($row);
		} else {
			echo json_encode(array('qty_actual_casenopartno' => '0', 'qty_plan_casenopartno' => '0'));
		}
	}


	public function get_planboxbycaseno($id)
	{
		$sql = "SELECT COALESCE(sum(msp.qty),0) as qty_plan from machining_shipping_plan msp where concat(msp.caseno)='$id'";
		//$rs = $this->db->query($sql)->row_array();
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $this->db->query($sql)->row_array();
			//$data['id'] = $row["id"];
			//echo json_encode($row);
			echo $row["qty_plan"];
		} else {
			//echo json_encode(array('qty_plan' => '0'));
			echo 0;
		}
	}

	public function get_actualboxbycaseno($id)
	{
		$sql = "SELECT COALESCE(sum(mu.qty),0) as qty_actual from machining_unpacking mu WHERE concat(mu.caseno)='$id' /*and mu.status='FINISH SCAN'*/";
		//$rs = $this->db->query($sql)->row_array();
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $this->db->query($sql)->row_array();
			//$data['id'] = $row["id"];
			//echo json_encode($row);
			echo $row["qty_actual"];
		} else {
			//echo json_encode(array('qty_actual' => '0'));
			echo 0;
		}
	}


	public function fun_save_finishcase()
	{
		//$data = $this->input->post(); //get all post values
		$caseNo = $this->input->get('caseno');
		$data['typecase'] = $this->input->get('caseType');
		$partno = $this->input->get('partno');
		$data['caseno'] = $caseNo;
		$data['status'] = 'COMPLETE CASE';
		$data['finishtime'] = date("H:m:s");
		$data['finishdate'] = date("Y-m-d");
		$user = $this->session->userdata('username');

		$this->db->insert('machining_finish_case', $data); //insert ke tabel history finish case
		//$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			echo json_encode(array('sts' => 'false', 'keyCode' => ''));
			//echo json_encode(array('sts' => 'insert_gagal', 'keyCode' => '$keyCode'));
		} else {
			//set shipping plan DONE
			$sql = "UPDATE machining_shipping_plan set status='done', done_at=LOCALTIMESTAMP(0), done_by='$user' WHERE caseno='$caseNo' /*and partno='$partno'*/";
			$this->db->query($sql);

			//set table machining_unpacking by caseNo part no Complete Case
			$sql = "UPDATE machining_unpacking set status='COMPLETE CASE' where caseno='$caseNo' /*and partno='$partno'*/";
			$this->db->query($sql);
			echo json_encode(array('sts' => 'true', 'keyCode' => ''));
			//echo json_encode(array('sts' => 'insert_sukes', 'keyCode' => $keyCode));
		}

		/* $add = array(
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('id_user'),
            'total' => $this->input->post('biaya') * $this->input->post('qty')
        );
        $data = array_merge($data, $add); */
		//print_r($data);
		//print_r($row);
		//$data['id'] = $row["id"];
		//echo json_encode($row);
	}


	public function view_finishcase()
	{
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/Unpackingpxp/view_finishcase";
		$this->load->view('template', $data);
	}

	public function view_stockmch($cari_partno1 = "", $cari_partname = "")
	{
		$data['cari_partno1'] = $cari_partno1;
		$data['cari_partname'] = $cari_partname;
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/Unpackingpxp/view_stockmch";
		$this->load->view('template', $data);
	}

	public function view_proggress_unpacking()
	{
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/Unpackingpxp/view_proggress_unpacking";
		$this->load->view('template', $data);
	}

	public function view_finish_unpacking()
	{
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/Unpackingpxp/view_finish_unpacking";
		$this->load->view('template', $data);
	}

	public function view_masterpart()
	{
		$data['header'] = "layout/header"; //view/layout/header.php
		$data['navbar'] = "layout/navbar";
		$data['sidebar'] = "layout/sidebar";
		$data['body'] = "body/Unpackingpxp/view_masterpart";
		$this->load->view('template', $data);
	}
}
