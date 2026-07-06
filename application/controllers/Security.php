<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends CI_Controller {

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
		$role = $this->session->userdata('role');
		if (!in_array($role, ['security', 'admin'])) {
			redirect('login/home');
		}

		// DEKLARASI PATH EXCEL DAILYTRANS (Sesuaikan dengan path di komputer magangmu)
		if (!defined('PATH_DAILY_TRANS')) {
			define('PATH_DAILY_TRANS', FCPATH . 'uplod/excel/dailyTrans.xlsx');
		}
	}

	// ══════════════════════════════════════════════════════════
	// INDEX – render halaman (tanpa data tabel, data load via AJAX)
	// ══════════════════════════════════════════════════════════
	public function index() {
		$this->_sync_daily_trans();
		$hari_ini  = date('Y-m-d');
		$view_date = $this->input->get('view_date') ? $this->input->get('view_date') : $hari_ini;

		// Dropdown history tanggal
		$this->db->select('tanggal');
		$this->db->distinct();
		$this->db->order_by('tanggal', 'DESC');
		$tgl_list      = $this->db->get('truck_logs')->result_array();
		$list_tanggal = array_column($tgl_list, 'tanggal');
		if (!in_array($hari_ini, $list_tanggal)) {
			array_unshift($list_tanggal, $hari_ini);
		}

		// List tiket untuk autocomplete scan
		$this->db->select('no_ticket');
		$query_tiket = $this->db->get('tickets')->result_array();
		$semua_tiket = array_column($query_tiket, 'no_ticket');

		$used_tickets = array_column(
			$this->db->select('trans_no')->get('truck_logs')->result_array(),
			'trans_no'
		);

		$list_tiket = array_values(array_diff($semua_tiket, $used_tickets));

		$data = [
			'hari_ini'     => $hari_ini,
			'view_date'    => $view_date,
			'list_tanggal' => $list_tanggal,
			'list_tiket'   => $list_tiket,

			// Layout
			'header'  => "layout/header",
			'sidebar' => "layout/sidebar",
			'body'    => "body/security/security"
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

		$this->_sync_daily_trans();

		$view_date = $view_date ?? date('Y-m-d');

		// Ambil data truk
		$this->db->where('tanggal', $view_date);
		$this->db->order_by('no_antrean', 'ASC');
		$trucks_raw = $this->db->get('truck_logs')->result_array();

		// Ambil data CS
		$this->db->select('kedatangan_truck, berat_isi_truck, normal_min, toleransi_max, warning');
		$this->db->where('tanggal_jadwal', $view_date);
		$cs_data = $this->db->get('cs_history')->result_array();

		$trucks_final = [];
		foreach ($trucks_raw as $truck) {
			$no_antrean_str = (string) $truck['no_antrean'];

			foreach (['timbang_kosong', 'timbang_isi', 'netto'] as $col) {
				$val         = floatval($truck[$col] ?? 0);
				$truck[$col] = ($val == 0) ? "" : $val;
			}

			$berat_material_cs  = 0.0;
			$truck['normal_min']     = 0;
			$truck['toleransi_max']  = 0;
			$truck['warning_limit']  = 0;
			$truck['warning_cs']     = "-";

			// Ambil murni B. Material dari berat_isi_truck di tabel CS
			foreach ($cs_data as $cs_row) {
				if (trim($cs_row['kedatangan_truck']) === $no_antrean_str) {
					$berat_material_cs       = floatval($cs_row['berat_isi_truck'] ?? 0);
					$truck['normal_min']     = floatval($cs_row['normal_min']     ?? 0);
					$truck['toleransi_max']  = floatval($cs_row['toleransi_max']  ?? 0);
					
					// 🔥 SMART FILTER: Mengakali bug format desimal dari database CS
					// Jika angka tercatat sangat kecil (misal 2.6 kg), kita balikan jadi 2600 kg
					if ($berat_material_cs > 0 && $berat_material_cs < 100) {
						$berat_material_cs *= 1000;
					}
					if ($truck['normal_min'] > 0 && $truck['normal_min'] < 100) {
						$truck['normal_min'] *= 1000;
					}
					if ($truck['toleransi_max'] > 0 && $truck['toleransi_max'] < 100) {
						$truck['toleransi_max'] *= 1000;
					}

					try {
						$truck['warning_limit'] = floatval(str_replace(',', '', trim($cs_row['warning'])));
					} catch (Exception $e) {
						$truck['warning_limit'] = 0;
					}
					$truck['warning_cs'] = $cs_row['warning'];
					break;
				}
			}

			$timbang_kosong = floatval($truck['timbang_kosong'] ?: 0);
			
			// B. Total = Timbang Kosong + B. Material (Kalkulasi hanya jika keduanya terisi)
			$berat_total_calc = 0;
			if ($timbang_kosong > 0 && $berat_material_cs > 0) {
				$berat_total_calc = $timbang_kosong + $berat_material_cs;
			}

			// Format dengan pembulatan integer
			$truck['berat_material']     = ($berat_material_cs  > 0) ? intval(round($berat_material_cs))  : "-";
			$truck['berat_total']        = ($berat_total_calc   > 0) ? intval(round($berat_total_calc))   : "-";
			$truck['raw_berat_material'] = $berat_material_cs;

			$trucks_final[] = $truck;
		}

		// 🔥 AMBIL SEMUA LOG REMARK (Security & Warehouse)
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
	// SIMPAN SECURITY – Saat Truk Masuk Pertama Kali
	// ══════════════════════════════════════════════════════════
	public function simpan_security() {
		$trans_no   = trim($this->input->post('trans_no'));
		$nama_sopir = $this->input->post('nama_sopir');
		$no_telp    = $this->input->post('no_telp');
		$hari_ini   = date('Y-m-d');

		if (empty($trans_no)) {
			$this->session->set_flashdata('danger', 'Gagal! No Ticket tidak boleh kosong.');
			redirect('security');
		}

		// Cek duplikat hari ini
		$this->db->where('trans_no', $trans_no);
		$this->db->where('tanggal', $hari_ini);
		$cek_tiket = $this->db->get('truck_logs')->row_array();
		if ($cek_tiket) {
			$this->session->set_flashdata('danger', "⚠️ Gagal! No Ticket '$trans_no' sudah pernah digunakan sebelumnya.");
			redirect('security');
		}

		// TARIK DETAIL DARI TABEL TICKETS (SMART CACHE)
		$this->db->where('no_ticket', $trans_no);
		$data_tiket_excel = $this->db->get('tickets')->row_array();

		if (!$data_tiket_excel) {
			$this->session->set_flashdata('danger', "Gagal! No Ticket tidak valid / tidak terdaftar di sistem Timbangan.");
			redirect('security');
		}

		// Jika nama sopir dikosongkan petugas di web, tarik otomatis dari Excel
		if (empty($nama_sopir)) {
			$nama_sopir = $data_tiket_excel['nama_sopir'];
		}

		// Nomor antrean otomatis
		$this->db->select_max('no_antrean');
		$this->db->where('tanggal', $hari_ini);
		$max_antrean    = $this->db->get('truck_logs')->row_array();
		$no_antrean_baru = ($max_antrean['no_antrean'] == null) ? 1 : intval($max_antrean['no_antrean']) + 1;

		// MASUKKAN DATA
		$insert_data = [
			'tanggal'        => $hari_ini,
			'no_antrean'     => $no_antrean_baru,
			'trans_no'       => $trans_no,
			'no_polisi'      => $data_tiket_excel['no_polisi'] ?: '-',
			'nama_sopir'     => $nama_sopir,
			'no_telp'        => $no_telp,
			'timbang_kosong' => $data_tiket_excel['timbang_kosong'],
			'timbang_isi'    => $data_tiket_excel['timbang_isi'],
			'netto'          => $data_tiket_excel['netto'],
			'status_loading' => 'Waiting'
		];

		if ($this->db->insert('truck_logs', $insert_data)) {
			
			
			$update_cs = [
				'nama_supir' => $nama_sopir, // Ingat: Di CS pakai 'u' (supir)
				'no_telp'    => $no_telp
			];
			$antrean_str = (string) $no_antrean_baru;
			
			// Update baris induk (1) maupun baris anak (1.1, 1.2) di CS
			$this->db->where('tanggal_jadwal', $hari_ini);
			$this->db->group_start();
			$this->db->where('kedatangan_truck', $antrean_str);
			$this->db->or_like('kedatangan_truck', $antrean_str . '.', 'after');
			$this->db->group_end();
			$this->db->update('cs_history', $update_cs);

			$this->session->set_flashdata('success', "Berhasil! Tiket $trans_no didaftarkan. Antrean Truk #$no_antrean_baru");
		} else {
			$this->session->set_flashdata('danger', "Terjadi Kesalahan Sistem Database.");
		}

		redirect('security');
	}

	// ══════════════════════════════════════════════════════════
	// PROSES_TABEL_SECURITY – batch update / delete / single update
	// ══════════════════════════════════════════════════════════
	public function proses_tabel_security() {
		$action = $this->input->post('action');

		try {
			if ($action && strpos($action, 'single_update_') === 0) {
				$parts    = explode('_', $action);
				$truck_id = intval(end($parts));
				$this->_update_truck_only($truck_id);
				$this->session->set_flashdata('success', "Data Kepulangan Truk berhasil dicatat!");

			} elseif ($action === 'batch_update') {
				$all_rows = $this->input->post('row_ids');
				if (!empty($all_rows)) {
					foreach ($all_rows as $row_id) {
						$this->_update_truck_only(intval($row_id));
					}
					$this->session->set_flashdata('success', "Semua perubahan data berhasil disimpan!");
				}

			} elseif ($action === 'batch_delete') {
				$selected_rows = $this->input->post('selected_rows');
				if (!empty($selected_rows)) {
					$this->db->where_in('id', $selected_rows);
					$this->db->where('is_completed !=', 'yes');
					$this->db->delete('truck_logs');
					$count = count($selected_rows);
					$this->session->set_flashdata('success', "Berhasil MENGHAPUS $count data truk (data Completed otomatis dilindungi)!");
				} else {
					$this->session->set_flashdata('warning', "Tidak ada data yang dicentang untuk dihapus!");
				}
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('danger', "Error: " . $e->getMessage());
		}

		redirect('security');
	}

	private function _update_truck_only($truck_id) {

    $cek = $this->db->get_where('truck_logs', ['id' => $truck_id])->row_array();
    if ($cek && ($cek['is_completed'] ?? 'no') === 'yes') {
        return;
    }

    $timbang_kosong = $this->input->post("timbang_kosong_$truck_id");
    $timbang_isi    = $this->input->post("timbang_isi_$truck_id");
    $keterangan_sec = trim($this->input->post("keterangan_sec_$truck_id"));
    $nama_sopir     = $this->input->post("nama_sopir_$truck_id");
    $no_telp        = $this->input->post("no_telp_$truck_id");
    $raw_netto      = $this->input->post("netto_$truck_id");

    $update_data = [
        'nama_sopir' => $nama_sopir,
        'no_telp'    => $no_telp
    ];

    // 🔥 FIX: hanya sentuh timbang_kosong/timbang_isi/netto KALAU field-nya memang dikirim.
    // Kalau request cuma buat simpan catatan (quick-save Enter), field ini absen dari POST,
    // jadi JANGAN ditimpa jadi NULL.
    if ($timbang_kosong !== null) {
        $tk = !empty($timbang_kosong) ? floatval($timbang_kosong) : 0.0;
        $update_data['timbang_kosong'] = ($tk > 0) ? $tk : NULL;
    }
    if ($timbang_isi !== null) {
        $ti = !empty($timbang_isi) ? floatval($timbang_isi) : 0.0;
        $update_data['timbang_isi'] = ($ti > 0) ? $ti : NULL;
    }
    if ($raw_netto !== null) {
        $netto = !empty($raw_netto) ? floatval($raw_netto) : 0.0;

        // Hitung ulang netto otomatis kalau kosong dan tk/ti sama-sama dikirim
        if ($netto == 0.0 && isset($tk) && isset($ti) && $tk > 0 && $ti > 0) {
            $netto = $ti - $tk;
        }
        $update_data['netto'] = ($netto > 0) ? $netto : NULL;
    }

    $this->db->where('id', $truck_id);
    $this->db->update('truck_logs', $update_data);
    $truck = $this->db->get_where('truck_logs', ['id' => $truck_id])->row_array();

    if ($truck) {

        if (!empty($keterangan_sec)) {
            $this->db->insert('remark_logs', [
                'trans_no'   => $truck['trans_no'],
                'remarks'    => $keterangan_sec,
                'role'       => 'security',
                'created_by' => $this->session->userdata('username')
            ]);
        }

        $this->db->where('id', $truck_id);
        $this->db->update('truck_logs', ['keterangan_sec' => $keterangan_sec]);

        $update_cs = [
            'nama_supir' => $nama_sopir,
            'no_telp'    => $no_telp,
            'remark'     => $keterangan_sec
        ];
        $antrean_str = (string) $truck['no_antrean'];

        $this->db->where('tanggal_jadwal', $truck['tanggal']);
        $this->db->group_start();
        $this->db->where('kedatangan_truck', $antrean_str);
        $this->db->or_like('kedatangan_truck', $antrean_str . '.', 'after');
        $this->db->group_end();
        $this->db->update('cs_history', $update_cs);
    }
}
	// ══════════════════════════════════════════════════════════
	// MARK_COMPLETED
	// ══════════════════════════════════════════════════════════
	public function mark_completed($truck_id) {
		$truck = $this->db->get_where('truck_logs', ['id' => $truck_id])->row_array();
		if (!$truck) {
			$this->session->set_flashdata('danger', "Data truk tidak ditemukan.");
			redirect('security');
		}
		if (($truck['status_loading'] ?? '') !== 'Finish') {
			$this->session->set_flashdata('warning', "Truk belum bisa di-Complete-kan, Status Warehouse belum Finish!");
			redirect('security');
		}

		$this->db->where('id', $truck_id);
		$this->db->update('truck_logs', ['is_completed' => 'yes']);

		$this->session->set_flashdata('success', "Truk Antrean #{$truck['no_antrean']} telah ditandai SELESAI (Completed).");
		redirect('security');
	}

	public function sync_now() {
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		$result = $this->_sync_daily_trans();
		header('Content-Type: application/json');
		echo json_encode($result);
		exit;
	}

	private function _sync_daily_trans() {
		$debug_path = FCPATH . 'uplod/excel/debug_sync.txt';

		if (!file_exists(PATH_DAILY_TRANS)) {
			file_put_contents($debug_path, date('Y-m-d H:i:s') . " - FILE TIDAK DITEMUKAN: " . PATH_DAILY_TRANS . "\n", FILE_APPEND);
			return ['status' => 'no_file'];
		}

		$local_copy_path = FCPATH . 'uplod/excel/_local_cache_dailyTrans.xlsx';

		

		// Load Excel sumber
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$reader->setReadDataOnly(true);
		$spreadsheet = $reader->load(PATH_DAILY_TRANS);
		$sheetData   = $spreadsheet->getActiveSheet()->toArray();

		// Susun data terbaru dari Excel sumber
		$excel_tickets = []; // no_ticket => data_baris
		for ($i = 1; $i < count($sheetData); $i++) {
    $no_ticket = trim($sheetData[$i][0] ?? '');
    if (empty($no_ticket)) continue;

    $timbang_kosong = (float) str_replace(',', '.', $sheetData[$i][11] ?? 0);
    $timbang_isi    = (float) str_replace(',', '.', $sheetData[$i][14] ?? 0);
    $netto          = (float) str_replace(',', '.', $sheetData[$i][16] ?? 0);

    // 🔥 Ambil waktu timbang asli dari kolom "1st Weigh DT" (index 10)
    $raw_weigh_dt = trim($sheetData[$i][10] ?? '');
    $waktu_scan   = $this->_parse_excel_datetime($raw_weigh_dt);

    $excel_tickets[$no_ticket] = [
        'no_ticket'      => $no_ticket,
        'no_polisi'      => trim($sheetData[$i][1] ?? '-'),
        'nama_sopir'     => trim($sheetData[$i][8] ?? ''),
        'timbang_kosong' => $timbang_kosong,
        'timbang_isi'    => $timbang_isi,
        'netto'          => $netto,
        'waktu_scan'     => $waktu_scan
    ];
}



		// Ambil data tickets yang sudah ada di database
		$existing_rows = $this->db->select('no_ticket')->get('tickets')->result_array();
		$existing_tickets = array_column($existing_rows, 'no_ticket');

		$hari_ini = date('Y-m-d');
		$inserted = 0; $updated = 0; $deleted = 0;

		// 1. INSERT/UPDATE baris yang ADA di Excel
		foreach ($excel_tickets as $no_ticket => $data_baris) {
			if (!in_array($no_ticket, $existing_tickets)) {
				$this->db->insert('tickets', $data_baris);
				$inserted++;
			} else {
				$this->db->where('no_ticket', $no_ticket);
				$this->db->update('tickets', $data_baris);
				$updated++;
			}

			// AUTO UPDATE TRUCK LOGS (Fase Keluar Truk) — hanya jika belum completed
			if ($data_baris['timbang_isi'] > 0) {
				$this->db->where('trans_no', $no_ticket);
				$this->db->where('tanggal', $hari_ini);
				$this->db->where('is_completed !=', 'yes');
				$this->db->update('truck_logs', [
					'timbang_isi' => $data_baris['timbang_isi'],
					'netto'       => $data_baris['netto']
				]);
			}
		}

		// 2. HAPUS baris di tabel tickets yang TIDAK ADA LAGI di Excel
		$used_today = array_column(
			$this->db->select('trans_no')->where('tanggal', $hari_ini)->get('truck_logs')->result_array(),
			'trans_no'
		);
		foreach ($existing_tickets as $no_ticket) {
			if (!isset($excel_tickets[$no_ticket]) && !in_array($no_ticket, $used_today)) {
				$this->db->where('no_ticket', $no_ticket);
				$this->db->delete('tickets');
				$deleted++;
			}
		}

		// 3. SIMPAN SALINAN LOKAL file Excel sumber (sebagai cadangan/jejak terakhir)
		copy(PATH_DAILY_TRANS, $local_copy_path);

		
		file_put_contents($debug_path, date('Y-m-d H:i:s') . " - SYNC SELESAI: inserted=$inserted, updated=$updated, deleted=$deleted, total_baris_excel=" . count($excel_tickets) . "\n", FILE_APPEND);

		return [
			'status'   => 'synced',
			'inserted' => $inserted,
			'updated'  => $updated,
			'deleted'  => $deleted
		];
	}

	private function _parse_excel_datetime($raw)
{
    $debug_path = FCPATH . 'uplod/excel/debug_datetime.txt';

    if (empty($raw) && $raw !== 0 && $raw !== '0') {
        file_put_contents($debug_path, date('Y-m-d H:i:s') . " - RAW KOSONG\n", FILE_APPEND);
        return date('Y-m-d H:i:s');
    }

    // Log raw value untuk diagnosa
    file_put_contents($debug_path, date('Y-m-d H:i:s') . " - RAW VALUE: [" . $raw . "] TYPE: " . gettype($raw) . "\n", FILE_APPEND);

    // Kasus 1: Excel serial number (angka desimal seperti 46215.447...)
    if (is_numeric($raw)) {
        try {
            $dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $raw);
            return $dateObj->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            file_put_contents($debug_path, date('Y-m-d H:i:s') . " - GAGAL KONVERSI SERIAL: " . $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    // Kasus 2: String format d/m/Y H:i atau d/m/Y H:i:s
    $formats = ['d/m/Y H:i', 'd/m/Y H:i:s', 'd-m-Y H:i', 'd-m-Y H:i:s', 'm/d/Y H:i', 'm/d/Y H:i:s'];
    foreach ($formats as $fmt) {
        $date = DateTime::createFromFormat($fmt, trim($raw));
        if ($date !== false) {
            return $date->format('Y-m-d H:i:s');
        }
    }

    file_put_contents($debug_path, date('Y-m-d H:i:s') . " - SEMUA FORMAT GAGAL, FALLBACK KE NOW\n", FILE_APPEND);
    return date('Y-m-d H:i:s');
}
}