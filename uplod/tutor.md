<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cs extends CI_Controller
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

        // ═══ TAMBAHAN: Proteksi berdasarkan role ═══
        $role = strtolower(trim($this->session->userdata('role')));
        if (!in_array($role, ['admin', 'cs', 'warehouse', 'whcs'])) {
            redirect('login/home');
        }
        // ═══════════════════════════════════════════
    }

    public function cs_view()
    {
        $data['header'] = "layout/header"; ////view/layout/header.php
        ////$data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "body/cs/cs_view";
        $this->load->view('template', $data);
    }

    /* public function cs_upload_history()
    {
        $data['header'] = "layout/header"; ////view/layout/header.php
        ////$data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "body/cs/cs_upload_history";
        $this->load->view('template', $data);
    } */

    public function cs_view_data_detail($param1 = "", $param2 = "", $param3 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3);

        $data = [];
        $i = 0;

        $sql = "SELECT * from cs_history where tanggal_jadwal=? and SUBSTRING_INDEX(kedatangan_truck, '.', 1)=? and length(item_desc)>0";
        $rs = $this->db->query($sql, [$param1, $param2]);
        if ($rs->num_rows() > 0) {
            foreach ($rs->result_array() as $row) {

                $i = $i + 1;

                $row["DT_RowIndex"] = $i;

                //$row["trans_no"] = '<a title="Detail No Pol ' . $row["no_polisi"] . '" href="javascript:addForm(\'' . $row["trans_no"] . '_' . $row["no_polisi"] . '_' . $row["tanggal_jadwal"] . '_' . $row["no_antrean"] . '\');">' . $row["trans_no"] . '</a>';

                $data[] = $row; //row kolom2 tabel di masukan ke variabel array asosiatif $data
            }

            $draw = 0;
            $result = array(
                "draw" => $draw,
                "recordsTotal" => $rs->num_rows(),
                "recordsFiltered" => $rs->num_rows(),
                "data" => $data
            );

            echo json_encode($result);
        } else {
            echo '{"note":"data not found","draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}';
        }
    }


    public function cs_view_data($param1 = "", $param2 = "", $param3 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3);

        $data = [];
        $i = 0;

        $created_by = $this->session->userdata('username');
        if ($this->session->userdata('isadmin') == 'yes' || $this->session->userdata('ishod') == 'yes') {
            $created_by = "";
        }

        $sql = "WITH cs_historys AS (
        SELECT csh.tanggal_jadwal, csh.kode_unik, csh.kedatangan_truck, csh.normal_min as normal_min_netto, csh.warning as netto_lebih_dari_berat_ini from cs_history csh where csh.kedatangan_truck not like '%.%' and csh.kedatangan_truck not like '%,%' and length(csh.kedatangan_truck)>0 and csh.kedatangan_truck<>'TOTAL' and length(csh.item_desc)<1
        and csh.tanggal_jadwal between ? and ?
        )
        SELECT cshs.*, tl.* from truck_logs tl, cs_historys cshs where tl.tanggal=cshs.tanggal_jadwal and tl.no_antrean=cshs.kedatangan_truck order by cshs.kedatangan_truck";
        $rs = $this->db->query($sql, [$param1, $param2]);
        if ($rs->num_rows() > 0) {
            foreach ($rs->result_array() as $row) {

                $row["remarks_wh"] = "";
                $row["keterangan_sec"] = "";

                $i = $i + 1;

                $row["DT_RowIndex"] = $i;

                $row["trans_no1"] = $row["trans_no"];

                //number_format(angka, jumlah_desimal, pemisah_desimal, pemisah_ribuan)
                $row["timbang_kosong"] = number_format($row["timbang_kosong"], 0, ".", "");
                $row["timbang_isi"] = number_format($row["timbang_isi"], 0, ".", "");
                $row["netto"] = number_format($row["netto"], 0, ".", "");

                $row["normal_min_netto"] = number_format((float)$row["normal_min_netto"], 0, '', '');
                $row["netto_lebih_dari_berat_ini"] = number_format((float)$row["netto_lebih_dari_berat_ini"], 0, '', '');

                //$row["normal_min_netto"] = number_format($row["normal_min_netto"], 0, ".", "");
                //$row["netto_lebih_dari_berat_ini"] = number_format($row["netto_lebih_dari_berat_ini"], 0, ".", "");


                if ($row["netto"] < $row["normal_min_netto"] && $row["netto"] > 0 && $row["netto"] <= $row["netto_lebih_dari_berat_ini"]) {
                    //jika kurang
                    $row["status_muatan"] = '<span class="badge badge-warning" title="Range Toleransi ' . $row['normal_min_netto'] . '~' . $row['netto_lebih_dari_berat_ini'] . '">Kurang</span>';
                    //
                } elseif ($row["netto"] >= $row["normal_min_netto"] && $row["netto"] <= $row["netto_lebih_dari_berat_ini"]) {
                    //jika in range
                    $row["status_muatan"] = '<span class="badge badge-success" title="Range Toleransi ' . $row['normal_min_netto'] . '~' . $row['netto_lebih_dari_berat_ini'] . '">Pass</span>';
                    //
                } elseif ($row["netto"] > $row["netto_lebih_dari_berat_ini"]) {
                    //jika lebih
                    $row["status_muatan"] = '<span class="badge badge-danger" title="Range Toleransi ' . $row['normal_min_netto'] . '~' . $row['netto_lebih_dari_berat_ini'] . '">Lebih</span>';
                    //
                } elseif ($row["netto"] < 1) {
                    //jika 0 atau belu timbang isi
                    $row["status_muatan"] = '<span class="badge badge-info">Belum Timbang Isi</span>';
                }

                $row["trans_no"] = '<a title="Detail No Pol ' . $row["no_polisi"] . '" href="javascript:addForm(\'' . $row["trans_no"] . '_' . $row["no_polisi"] . '_' . $row["tanggal_jadwal"] . '_' . $row["no_antrean"] . '\');">' . $row["trans_no"] . '</a>';

                //loop komen wh
                $sql1 = "SELECT *, left(right(created_at,8),5) as jamkomen from remark_logs where trans_no=? and role='warehouse' order by created_at asc";
                $rs1 = $this->db->query($sql1, [$row["trans_no1"]]);
                if ($rs1->num_rows() > 0) {
                    foreach ($rs1->result_array() as $row1) {
                        $row["remarks_wh"] = $row["remarks_wh"] . "<div style=\"border-bottom: 1px solid #ccc;\" class=\"row\" title=\"" . htmlspecialchars($row1["created_by"], ENT_QUOTES, 'UTF-8') . "\">" .  $row1["jamkomen"] . ": " . htmlspecialchars($row1["remarks"], ENT_QUOTES, 'UTF-8') . "</div>";
                    }
                }

                //loop komen security
                $sql2 = "SELECT *, left(right(created_at,8),5) as jamkomen from remark_logs where trans_no=? and role='security' order by created_at asc";
                $rs2 = $this->db->query($sql2, [$row["trans_no1"]]);
                if ($rs2->num_rows() > 0) {
                    foreach ($rs2->result_array() as $row2) {
                        $row["keterangan_sec"] = $row["keterangan_sec"] . "<div style=\"border-bottom: 1px solid #ccc;\"class=\"row\" title=\"" . htmlspecialchars($row2["created_by"], ENT_QUOTES, 'UTF-8') . "\">" .  $row2["jamkomen"] . ": " . htmlspecialchars($row2["remarks"], ENT_QUOTES, 'UTF-8') . "</div>";
                    }
                }


                //$row["clp"] = $clp; //tambah key dan value ke variabel array asosiatif -> $row / tambah kolom baru di data tabel

                $data[] = $row; //row kolom2 tabel di masukan ke variabel array asosiatif $data
            }

            $draw = 0;
            $result = array(
                "draw" => $draw,
                "recordsTotal" => $rs->num_rows(),
                "recordsFiltered" => $rs->num_rows(),
                "data" => $data
            );

            echo json_encode($result);
        } else {
            echo '{"note":"data not found","draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}';
        }
    }


    public function cs_upload_history_data($param1 = "", $param2 = "", $param3 = "")
    {
        $param1 = str_replace("_BLANK_", "", $param1);
        $param2 = str_replace("_BLANK_", "", $param2);
        $param3 = str_replace("_BLANK_", "", $param3);

        $data = [];
        $i = 0;

        $created_by = $this->session->userdata('username');
        if ($this->session->userdata('isadmin') == 'yes' || $this->session->userdata('ishod') == 'yes') {
            $created_by = "";
        }

        $sql = "SELECT * from cs_upload_log where date(upload_at) between ? and ? order by upload_at";
        $rs = $this->db->query($sql, [$param1, $param2]);
        if ($rs->num_rows() > 0) {
            foreach ($rs->result_array() as $row) {

                $i = $i + 1;

                $row["DT_RowIndex"] = $i;

                $row["filename"] = '<a title="Download" href="' . base_url() . 'uplod/excel/' . $row["filename"] . '">' . $row["filename"] . '</a>';


                //$row["clp"] = $clp; //tambah key dan value ke variabel array asosiatif -> $row / tambah kolom baru di data tabel

                $data[] = $row; //row kolom2 tabel di masukan ke variabel array asosiatif $data
            }

            $draw = 0;
            $result = array(
                "draw" => $draw,
                "recordsTotal" => $rs->num_rows(),
                "recordsFiltered" => $rs->num_rows(),
                "data" => $data
            );

            echo json_encode($result);
        } else {
            echo '{"note":"data not found","draw":0,"recordsTotal":0,"recordsFiltered":0,"data":[]}';
        }
    }


    public function cs_upload_frm()
    {
        $data['header'] = "layout/header"; //view/layout/header.php
        //$data['navbar'] = "layout/navbar";
        $data['sidebar'] = "layout/sidebar";
        $data['body'] = "body/cs/cs_upload_frm";
        $this->load->view('template', $data);
    }


    public function cs_upload()
    {
        $config['upload_path'] = './uplod/excel/';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx|csv';
        $config['max_size'] = '4048';
        $config['overwrite'] = TRUE;
        $config['remove_space'] = TRUE;
        $this->upload->initialize($config);
        $this->load->library('upload', $config); // Load konfigurasi uploadnya

        //$data_metadata = array('image_metadata' => $this->upload->data()); //20241107 di komen by andi

        if (!$this->upload->do_upload('file')) { //jika tanpa ada file yg di upload maka..

            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {

            $impcode    = $this->input->post('impcode');
            $jobtype    = $this->input->post('jobtype');
            $pib        = null;
            $invoiceno_rack = $this->input->post('invoiceno_rack');

            // $file = str_replace(" ", "_", $_FILES['file']['name']);
            $file = $this->upload->data()['file_name']; // Anur 25/11/24.. File name dengan library CI after upload

            //echo "Upload file <b>".$file."</b> success..<br>";
            $str = "Upload file <b>" . $file . "</b> success..<br>";

            $this->fun_upload_prs($file, $str, $impcode, $jobtype, $invoiceno_rack); //proses insert record excel ke database
        }
    }


    public function fun_upload_prs($namaFile = "", $str = "", $impcode = "", $jobtype = "", $invoiceno_rack)
    {

        $pib    = null;
        $dirs   = "./uplod/excel/";

        if (file_exists($dirs . $namaFile)) {

            $arr_file = explode('.', $dirs . $namaFile);
            //$extension = strtolower(end($arr_file));
            $extension = end($arr_file);

            //20240813
            $namaFile_array = explode('.', $namaFile);
            $namaFile1 = $namaFile_array[0];
            $namaFileBak = $namaFile1 . "_" . date("YmdHis") . "." . $extension;

            $filename = $namaFile1 . "." . $extension;

            $username = $this->session->userdata('username');

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($dirs . $namaFile);
            $activeSheet = $spreadsheet->getActiveSheet();
            $this->_unmerge_fill_values($activeSheet);
            $sheetData = $activeSheet->toArray();

            $afftectedRows = 0;

            $nama_customer1 = "";
            $area1 = "";
            $urutan_bongkar1 = "";

            $tanggal_jadwal = $sheetData[2]['0']; //'2026-06-09';//$sheetData[$i]['0']; //baris ke i kolom ke 0

            //$date = DateTime::createFromFormat('l, F d, Y', $tanggal_jadwal);
            //$tanggal_jadwal = $date ? $date->format('Y-m-d') : null;

            // Beritahu PHP format asalnya adalah Bulan/Hari/Tahun
            //$date = DateTime::createFromFormat('m/d/Y', $tanggal_jadwal);
            $date = DateTime::createFromFormat('d-m-Y', $tanggal_jadwal);

            // Ubah menjadi format Baru: Tahun-Bulan-Hari
            $tanggal_jadwal = $date->format('Y-m-d');

            //echo $tanggal_jadwal;
            //exit();

            //kalau ada data hapus dulu replace dengan yang baru
            $this->db->query("DELETE from cs_upload_log where plandate=?", [$tanggal_jadwal]);
            $this->db->query("DELETE from cs_history where tanggal_jadwal=?", [$tanggal_jadwal]);

            $this->db->query("INSERT into cs_upload_log(filename, upload_by, plandate) values(?, ?, ?)", [$filename, $username, $tanggal_jadwal]);

            //$this->db->insert_batch('machining_shipping_plan', $data); //ini sudah OKE

            $iduploadlog = $this->db->insert_id();


            for ($i = 5; $i < count($sheetData); $i++) //baca baris data excel dari baris ke 1, baris ke 0 adalah header di excel
            {
                //hanya row yg ada data yg di proses
                if (strlen($sheetData[$i]['0']) > 0) {

                    /* $datas = array(
                    'caseno'  => $sheetData[$i]['0'],
                    'partno'  => $sheetData[$i]['1'],
                    'rubetsu'  => $sheetData[$i]['2'],
                    'partname'  => $sheetData[$i]['3'],
                    'qty'  => $sheetData[$i]['4'],
                    ); */

                    //$tanggal_jadwal = $sheetData[1]['0']; //'2026-06-09';//$sheetData[$i]['0'];
                    $kode_unik = $tanggal_jadwal . "-" . $sheetData[$i]['0'];
                    $kedatangan_truck = $sheetData[$i]['0'];

                    if (strlen($sheetData[$i]['1']) > 0) {
                        $nama_customer = $sheetData[$i]['1'];
                        $nama_customer1 = $sheetData[$i]['1'];
                    } else {
                        if (strlen($sheetData[$i]['1']) == 0) {
                            $nama_customer = "";
                        } else {
                            $nama_customer = $nama_customer1;
                        }
                    }

                    if (strlen($sheetData[$i]['2']) > 0) {
                        $area = $sheetData[$i]['2'];
                        $area1 = $sheetData[$i]['2'];
                    } else {
                        if (strlen($sheetData[$i]['2']) == 0) {
                            $area = "";
                        } else {
                            $area = $area1;
                        }
                    }

                    if (strlen($sheetData[$i]['1']) > 0) {
                        $urutan_bongkar = $sheetData[$i]['3'];
                        $urutan_bongkar1 = $sheetData[$i]['3'];
                    } else {
                        if (strlen($sheetData[$i]['2']) == 0) {
                            $urutan_bongkar = "";
                        } else {
                            $urutan_bongkar = $urutan_bongkar1;
                        }
                    }

                    //$area = $sheetData[$i]['2'];
                    //$urutan_bongkar = $sheetData[$i]['3'];
                    //$no_so = $sheetData[$i]['4'];
                    //$mid = $sheetData[$i]['5'];

                    $item_desc = addslashes($sheetData[$i]['4']);
                    $weight = $sheetData[$i]['5'];
                    $color = $sheetData[$i]['6'];
                    $pattern_nose = $sheetData[$i]['7'];

                    $qty_box_pallet = (strlen($sheetData[$i]['8'])) ? str_replace(',', '.', $sheetData[$i]['8']) : 0; //jika tidak ada data isi 0
                    $qty_pcs = (strlen($sheetData[$i]['9'])) ? str_replace(',', '.', $sheetData[$i]['9']) : 0;;
                    $qty_box_pallet_total = (strlen($sheetData[$i]['10'])) ? str_replace(',', '.', $sheetData[$i]['10']) : 0;
                    $status_produk = $sheetData[$i]['11'];
                    $waktu_muat = $sheetData[$i]['12'];
                    $status_tracking = $sheetData[$i]['13'];
                    $berat_total = (strlen($sheetData[$i]['14'])) ? str_replace(',', '.', $sheetData[$i]['14']) : 0;
                    $berat_box = (strlen($sheetData[$i]['15'])) ? str_replace(',', '.', $sheetData[$i]['15']) : 0;

                    $berat_isi_truck = (strlen($sheetData[$i]['16'])) ? str_replace(',', '.', $sheetData[$i]['16']) : 0;

                    $normal_min = (strlen($sheetData[$i]['17'])) ? str_replace(',', '.', $sheetData[$i]['17']) : 0;
                    $normal_max = (strlen($sheetData[$i]['18'])) ? str_replace(',', '.', $sheetData[$i]['18']) : 0;
                    $toleransi_min = (strlen($sheetData[$i]['19'])) ? str_replace(',', '.', $sheetData[$i]['19']) : 0;
                    $toleransi_max = (strlen($sheetData[$i]['20'])) ? str_replace(',', '.', $sheetData[$i]['20']) : 0;
                    $warning = (strlen($sheetData[$i]['21'])) ? str_replace(',', '.', $sheetData[$i]['21']) : 0;

                    /* $nama_supir = $sheetData[$i]['24'];
                    $no_telp = $sheetData[$i]['25'];
                    $remark = $sheetData[$i]['26']; */

                    //array_push($data, $datas); //untuk insert batch ini sudah OKE

                    $sql = "INSERT INTO cs_history(iduploadlog, tanggal_jadwal, kode_unik, kedatangan_truck, nama_customer, area, urutan_bongkar, item_desc, weight, color, pattern_nose, qty_box_pallet, qty_pcs, qty_box_pallet_total, status_produk, waktu_muat, status_tracking, berat_total, berat_box, berat_isi_truck, normal_min, normal_max, toleransi_min, toleransi_max, warning) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $this->db->query($sql, [
                        $iduploadlog, $tanggal_jadwal, $kode_unik, $kedatangan_truck, $nama_customer, $area, $urutan_bongkar, $item_desc, $weight, $color, $pattern_nose, $qty_box_pallet, $qty_pcs, $qty_box_pallet_total, $status_produk, $waktu_muat, $status_tracking, $berat_total, $berat_box, $berat_isi_truck, $normal_min, $normal_max, $toleransi_min, $toleransi_max, $warning
                    ]);


                    $afftectedRows = $afftectedRows + $this->db->affected_rows();
                }
            }

            //$this->db->insert_batch('machining_shipping_plan', $data); //ini sudah OKE

            //$id = $this->db->insert_id();

            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <span style='color:white;'>" . $str . "<br>afftectedRows " . $afftectedRows . "</span>
                </div>");

            /* $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <span style='color:white;'>" . $str . "<br>afftectedRows " . $afftectedRows . "<br>id " . $id . "</span>
                </div>"); */

            redirect('cs/cs_upload_frm');
        } else {

            $str = "file not found";
            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <span style='color:white;'>" . $str . "</span>
                </div>");
            redirect('cs/cs_upload_frm');
        }
    }


    public function tracking()
    {
        $hari_ini = date('Y-m-d');

        $this->db->select('tanggal_jadwal');
        $this->db->distinct();
        $this->db->order_by('tanggal_jadwal', 'DESC');
        $tgl_list = $this->db->get('cs_history')->result_array();
        $list_tanggal = array_column($tgl_list, 'tanggal_jadwal');

        if (!in_array($hari_ini, $list_tanggal)) {
            array_unshift($list_tanggal, $hari_ini);
        }

        $data = [
            'list_tanggal' => $list_tanggal,
            'header'  => "layout/header",
            'sidebar' => "layout/sidebar",
            'body'    => "body/cs/tracking"
        ];
        $this->load->view('template', $data);
    }

    public function api_cs_data()
    {
        $tanggal = $this->input->get('tanggal');
        if ($tanggal) {
            $this->db->where('tanggal_jadwal', $tanggal);
            $this->db->order_by('id', 'ASC');
            $data = $this->db->get('cs_history')->result_array();

            // 🔥 AMBIL DATA REMARK SECURITY & WAREHOUSE DARI truck_logs (via no_antrean)
            $this->db->where('tanggal', $tanggal);
            $trucks = $this->db->get('truck_logs')->result_array();
            $truck_map = [];
            foreach ($trucks as $t) {
                $truck_map[(string)$t['no_antrean']] = $t;
            }

ini ada yang beda gak menurutmu? ini aku coba debugging sendiri hasilnya lancar, yang bikin error itu karena kamu ngehapus addslashes di line 396, ketika aku kembalikan dia langsung bisa lagi
