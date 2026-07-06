<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
        
        // Pengecekan Login
        if (!$this->session->userdata('username')) {
            $this->session->set_flashdata('msg', "<div class='alert bg-danger' role='alert'><span style='color:white;'>Please login first.</span></div>");
            redirect('login');
        }
        
        // Proteksi Role
        $role = strtolower(trim($this->session->userdata('role')));
        if (!in_array($role, ['warehouse', 'admin', 'whcs'])) {
            redirect('login/home');
        }
    }

    // ══════════════════════════════════════════════════════════
    // INDEX – render halaman (tanpa data tabel, data load via AJAX)
    // ══════════════════════════════════════════════════════════
    public function index() {
        $hari_ini  = date('Y-m-d');
        $view_date = $this->input->get('view_date') ? $this->input->get('view_date') : $hari_ini;

        // Dropdown history tanggal
        $this->db->select('tanggal');
        $this->db->distinct();
        $this->db->order_by('tanggal', 'DESC');
        $tgl_list     = $this->db->get('truck_logs')->result_array();
        $list_tanggal = array_column($tgl_list, 'tanggal');
        if (!in_array($hari_ini, $list_tanggal)) {
            array_unshift($list_tanggal, $hari_ini);
        }

        $data = [
            'hari_ini'     => $hari_ini,
            'view_date'    => $view_date,
            'list_tanggal' => $list_tanggal,

            // Layout
            'header'  => "layout/header",
            'sidebar' => "layout/sidebar",
            'body'    => "body/warehouse/index" 
        ];

        $this->load->view('template', $data);
    }

    // ══════════════════════════════════════════════════════════
    // GET_DATA – endpoint AJAX, return JSON untuk tabel
    // ══════════════════════════════════════════════════════════
    public function get_data($view_date = null) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $view_date = $view_date ?? date('Y-m-d');

        // Ambil data truk
        $this->db->where('tanggal', $view_date);
        $this->db->order_by('no_antrean', 'ASC');
        $trucks_raw = $this->db->get('truck_logs')->result_array();

        // Ambil data dari CS History untuk cross-check jumlah box & berat
        $this->db->select('kedatangan_truck, qty_box_pallet_total, berat_isi_truck');
        $this->db->where('tanggal_jadwal', $view_date);
        $cs_data = $this->db->get('cs_history')->result_array();

        $trucks_final = [];
        foreach ($trucks_raw as $truck) {
            $no_antrean_str = (string) $truck['no_antrean'];
            $berat_material_cs = 0.0;
            $qty_box_cs = 0.0;

            // 1. Cari data di baris Induk (Summary) di CS
            foreach ($cs_data as $cs_row) {
                $kedatangan = trim((string) $cs_row['kedatangan_truck']);
                if ($kedatangan === $no_antrean_str) {
                    $berat_material_cs = floatval($cs_row['berat_isi_truck'] ?? 0);
                    $qty_box_cs = floatval($cs_row['qty_box_pallet_total'] ?? 0);

                    if ($berat_material_cs > 0 && $berat_material_cs < 100) {
                        $berat_material_cs *= 1000;
                    }
                    break;
                }
            }

            // 2. Jika baris induk 0 (Kosong), jumlahkan dari anak-anaknya (misal 1.1, 1.2)
            if ($qty_box_cs == 0) {
                foreach ($cs_data as $cs_row) {
                    $kedatangan = trim((string) $cs_row['kedatangan_truck']);
                    if (strpos($kedatangan, $no_antrean_str . '.') === 0) {
                        $qty_box_cs += floatval($cs_row['qty_box_pallet_total'] ?? 0);
                    }
                }
            }

            $truck['jumlah_box'] = ($qty_box_cs > 0) ? intval($qty_box_cs) : "-";
            $truck['berat_material'] = ($berat_material_cs > 0) ? intval(round($berat_material_cs)) : "-";

            // Pastikan jika status di DB null atau string kosong, dikirim sebagai null ke JS
            if (empty($truck['status_loading'])) {
                $truck['status_loading'] = null;
            }

            $trucks_final[] = $truck;
        }

        // AMBIL SEMUA LOG REMARK (Security & Warehouse) per trans_no yang tampil
        $trans_no_list = array_filter(array_column($trucks_final, 'trans_no'));
        $remark_map = [];
        if (!empty($trans_no_list)) {
            $this->db->where_in('trans_no', $trans_no_list);
            $this->db->order_by('created_at', 'ASC');
            $logs = $this->db->get('remark_logs')->result_array();
            foreach ($logs as $log) {
                $remark_map[$log['trans_no']][] = $log;
            }
        }
        foreach ($trucks_final as &$tf) {
            $tf['remark_logs'] = $remark_map[$tf['trans_no']] ?? [];
        }

        header('Content-Type: application/json');
        echo json_encode($trucks_final);
        exit;
    }

    // ══════════════════════════════════════════════════════════
    // PROSES_TABEL_WAREHOUSE – batch update / delete / single update
    // ══════════════════════════════════════════════════════════
    public function proses_tabel_warehouse() {
        $action = $this->input->post('action');
        
        try {
            if ($action && strpos($action, 'single_update_') === 0) {
                $parts = explode('_', $action);
                $truck_id = intval(end($parts));
                $this->_update_truck_wh($truck_id);
                $this->session->set_flashdata('success', "Data Gudang berhasil diupdate & sinkron ke CS!");

            } elseif ($action === 'batch_update') {
                $all_ids = $this->input->post('row_ids');
                if (!empty($all_ids)) {
                    foreach ($all_ids as $truck_id) {
                        $this->_update_truck_wh(intval($truck_id));
                    }
                    $this->session->set_flashdata('success', "Berhasil mengupdate data massal & sinkron ke CS!");
                }

            } elseif ($action === 'batch_delete') {
                $selected_ids = $this->input->post('selected_rows');
                if (!empty($selected_ids)) {
                    foreach ($selected_ids as $truck_id) {
                        $cek = $this->db->get_where('truck_logs', ['id' => $truck_id])->row_array();
                        if ($cek && ($cek['is_completed'] ?? 'no') === 'yes') {
                            continue; 
                        }
                        $this->db->where('id', $truck_id);
                        $this->db->update('truck_logs', [
                            'loading_dock' => NULL,
                            'status_loading' => NULL, // Diubah ke NULL agar benar-benar kosong
                            'remarks_wh' => NULL
                        ]);
                        $this->_push_to_cs($truck_id, NULL, '');
                    }
                    $this->session->set_flashdata('success', "Berhasil mengosongkan antrean gudang yang dicentang!");
                } else {
                    $this->session->set_flashdata('warning', "Tidak ada baris yang dicentang!");
                }
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('danger', "Error Database: " . $e->getMessage());
        }

        redirect('warehouse');
    }

    // ══════════════════════════════════════════════════════════
    // PRIVATE – update satu baris gudang (Manual/Massal Form Submit)
    // ══════════════════════════════════════════════════════════
    private function _update_truck_wh($truck_id) {
        $cek = $this->db->get_where('truck_logs', ['id' => $truck_id])->row_array();
        if ($cek && ($cek['is_completed'] ?? 'no') === 'yes') {
            return;
        }

        $loading_dock = $this->input->post("loading_dock_$truck_id");
        $status_loading = $this->input->post("status_loading_$truck_id");
        $remarks_wh = trim($this->input->post("remarks_$truck_id"));

        $this->db->where('id', $truck_id);
        $this->db->update('truck_logs', [
            'loading_dock'   => $loading_dock ? $loading_dock : NULL,
            'status_loading' => (!empty($status_loading)) ? $status_loading : NULL, // Jika kosong set NULL
            'remarks_wh'     => $remarks_wh
        ]);

        if (!empty($remarks_wh)) {
            $truck = $this->db->get_where('truck_logs', ['id' => $truck_id])->row_array();
            if ($truck) {
                $this->db->insert('remark_logs', [
                    'trans_no'   => $truck['trans_no'],
                    'remarks'    => $remarks_wh,
                    'role'       => 'warehouse',
                    'created_by' => $this->session->userdata('username')
                ]);
            }
        }

        $this->_push_to_cs($truck_id, (!empty($status_loading) ? $status_loading : NULL), $remarks_wh);
    }

    // ══════════════════════════════════════════════════════════
    // PRIVATE – Sinkronisasi (Nembak) Status ke Tabel CS
    // ══════════════════════════════════════════════════════════
    private function _push_to_cs($truck_id, $status, $remarks) {
        $truck = $this->db->get_where('truck_logs', ['id' => $truck_id])->row_array();
        if ($truck) {
            $antrean = (string) $truck['no_antrean'];
            $tgl = $truck['tanggal'];

            $this->db->where('tanggal_jadwal', $tgl);
            $this->db->group_start();
            $this->db->where('kedatangan_truck', $antrean); 
            $this->db->or_like('kedatangan_truck', $antrean . '.', 'after'); 
            $this->db->group_end();
            
            $this->db->update('cs_history', [
                'status_tracking' => $status, // Menyimpan nilai asli (bisa berupa NULL jika kosong)
                'remark' => $remarks
            ]);
        }
    }

    // ══════════════════════════════════════════════════════════
    // AJAX_UPDATE_TRUCK_WH – Endpoint Baru untuk Auto-Save Real-time
    // ══════════════════════════════════════════════════════════
    public function ajax_update_truck_wh() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $truck_id = intval($this->input->post('truck_id'));
        if (!$truck_id) {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
            exit;
        }

        $cek = $this->db->get_where('truck_logs', ['id' => $truck_id])->row_array();
        if ($cek && ($cek['is_completed'] ?? 'no') === 'yes') {
            echo json_encode(['status' => 'error', 'message' => 'Data sudah completed']);
            exit;
        }

        $loading_dock   = $this->input->post('loading_dock');
        $status_loading = $this->input->post('status_loading');
        $remarks_wh     = trim($this->input->post('remarks') ?? '');

        // Persiapan Update - Jika status_loading kosong (""), simpan sebagai NULL di database
        $update_data = [
            'status_loading' => (!empty($status_loading)) ? $status_loading : NULL
        ];
        
        if ($this->input->post('loading_dock') !== null) {
            $update_data['loading_dock'] = $loading_dock ? $loading_dock : NULL;
        }
        if ($this->input->post('remarks') !== null) {
            $update_data['remarks_wh'] = $remarks_wh;
        }

        $this->db->where('id', $truck_id);
        $this->db->update('truck_logs', $update_data);

        // Jika ada remark baru, masukkan ke log
        if ($this->input->post('remarks') !== null && !empty($remarks_wh)) {
            $this->db->insert('remark_logs', [
                'trans_no'   => $cek['trans_no'],
                'remarks'    => $remarks_wh,
                'role'       => 'warehouse',
                'created_by' => $this->session->userdata('username')
            ]);
        }

        // Ambil data terbaru pasca update untuk disinkronkan ke CS
        $truck_updated = $this->db->get_where('truck_logs', ['id' => $truck_id])->row_array();
        
        // Tetap kirimkan nilai asli status_loading (NULL atau String) ke sistem CS tanpa mematikan nilai NULL-nya
        $this->_push_to_cs($truck_id, $truck_updated['status_loading'], $truck_updated['remarks_wh'] ?? '');

        // Ambil history remark warehouse terbaru untuk dikembalikan ke client
        $this->db->where('trans_no', $cek['trans_no']);
        $this->db->where('role', 'warehouse');
        $this->db->order_by('created_at', 'ASC');
        $new_logs = $this->db->get('remark_logs')->result_array();

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success', 
            'message' => 'Data berhasil disimpan!',
            'new_remarks_html' => $this->_render_ajax_remarks($new_logs)
        ]);
        exit;
    }

    // Helper render log via PHP untuk dikembalikan ke AJAX
    private function _render_ajax_remarks($logs) {
        if (empty($logs)) return '<div class="log-empty">Belum ada catatan.</div>';
        $html = '';
        foreach ($logs as $l) {
            $waktu = substr($l['created_at'] ?? '', 0, 16);
            $html .= '<div class="log-line"><span class="log-meta role-warehouse">['.htmlspecialchars($l['created_by'] ?? '').', '.$waktu.']</span> '.htmlspecialchars($l['remarks'] ?? '').'</div>';
        }
        return $html;
    }
}