<style>
    /* ── Compact Table Style ── */
    .input-edit-mode { font-size: 11.5px; text-align: center; padding: 4px; border: 1px solid #ccc; border-radius: 3px; }
    .select-edit { font-size: 11.5px; padding: 3px; border: 1px solid #ccc; border-radius: 3px; background: white; font-weight: bold; }
    .remark-log-box { max-height:150px; overflow-y:auto; background:#f8f9fa; border:1px solid #ddd; border-radius:3px; padding:4px 6px; margin-bottom:4px; text-align:left; font-size:11px; line-height:1.4; white-space: normal; }
    .remark-log-box .log-line { border-bottom:1px dashed #ddd; padding:6px 0; white-space: normal; word-break: break-word; }
    .remark-log-box .log-line:last-child { border-bottom:none; }
    .remark-log-box .log-meta { font-weight:bold; color:#176B87; }
    .remark-log-box .log-meta.role-warehouse { color:#dc3545; }
    .remark-log-box .log-empty { color:#999; font-style:italic; }
    #tabel-wh-wrap { overflow-x: auto; margin-top: 10px; }
    #tabel-wh { border-collapse: collapse; width: 100%; min-width: max-content; white-space: nowrap; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    #tabel-wh td.remark-cell { white-space: normal; }
    #tabel-wh th, #tabel-wh td { border: 1px solid #ddd; padding: 5px 4px; text-align: center; font-size: 11.5px; }
    #tabel-wh thead th { background-color: #176B87; color: white; }
    #tabel-wh thead th.col-dark { color: black; background-color: #d9d9d9; }
    #tabel-wh tbody tr:nth-child(even) { background-color: #f8f9fa; }
    #tabel-wh tbody tr:hover { background-color: #e1f5fe; }

    /* ── Buttons ── */
    .btn-submit { background-color: #28a745; color: white; padding: 6px 12px; border: none; cursor: pointer; font-weight: bold; border-radius: 4px; font-size: 12px; }
    .btn-edit   { background-color: #007bff; color: white; padding: 3px 6px; border: none; cursor: pointer; font-weight: bold; font-size: 11px; border-radius: 3px; }

    /* ── Alert ── */
    .alert         { background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border: 1px solid #c3e6cb; border-radius: 5px; transition: opacity 0.5s ease; font-size: 13px; }
    .alert-warning { background-color: #fff3cd; color: #856404; border-color: #ffeeba; }
    .alert-danger  { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }

    /* ── Search bar ── */
    #wh-search-wrap { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
    #wh-search-wrap label { font-size: 12px; font-weight: bold; margin: 0; white-space: nowrap; }
    #wh-search-input { padding: 4px 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px; width: 220px; }
    #wh-search-input:focus { outline: none; border-color: #176B87; }

    #tabel-loading { display: none; text-align: center; padding: 20px; font-size: 13px; color: #555; }
</style>

<?php if($this->session->flashdata('success')): ?>
    <div class="alert"><strong>Info:</strong> <?= $this->session->flashdata('success') ?></div>
<?php endif; ?>
<?php if($this->session->flashdata('danger')): ?>
    <div class="alert alert-danger"><strong>Info:</strong> <?= $this->session->flashdata('danger') ?></div>
<?php endif; ?>
<?php if($this->session->flashdata('warning')): ?>
    <div class="alert alert-warning"><strong>Info:</strong> <?= $this->session->flashdata('warning') ?></div>
<?php endif; ?>

<div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #176B87; padding-bottom: 5px; margin-bottom: 10px;">
    <h3 style="color: #176B87; margin: 0; font-size: 16px;">🏢 Control Panel Warehouse</h3>

    <div style="display: flex; align-items: center; gap: 8px;">
        <label style="font-weight: bold; font-size: 12px;">📅 Tanggal:</label>
        <select id="view_date_select" style="padding: 4px 8px; border-radius: 4px; border: 1px solid #ccc; font-weight: bold; font-size: 12px;">
            <option value="<?= $hari_ini ?>" <?= ($view_date == $hari_ini) ? 'selected' : '' ?>>Hari Ini (<?= $hari_ini ?>)</option>
            <?php foreach($list_tanggal as $tgl): ?>
                <?php if($tgl != $hari_ini): ?>
                <option value="<?= $tgl ?>" <?= ($view_date == $tgl) ? 'selected' : '' ?>><?= $tgl ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div style="background:#fff; padding: 10px; border-radius: 6px; border: 1px solid #ddd;">

    <div style="margin-bottom: 8px; display: flex; gap: 6px; flex-wrap: wrap;">
        <button type="button" id="btnModeEdit"   class="btn-submit" style="background-color:#007bff;" onclick="aktifkanModeEdit()">✏️ Edit Massal</button>
        <button type="button" id="btnModeDelete" class="btn-submit" style="background-color:#dc3545;" onclick="aktifkanModeHapusWH()">🗑️ Kosongkan Dock</button>
        
        <button type="submit" form="tabelWarehouseForm" name="action" value="batch_update" id="btnSimpanEdit" class="btn-submit" style="background-color:#28a745; display:none;" onclick="return confirm('Yakin simpan semua perubahan ke CS?');">💾 Simpan Perubahan</button>
        <button type="submit" form="tabelWarehouseForm" name="action" value="batch_delete" id="btnKonfirmDelete" class="btn-submit" style="background-color:#c0392b; display:none;" onclick="return confirm('Kosongkan antrean dock yang dicentang?');">🚨 Konfirm Kosongkan</button>
        
        <button type="button" id="btnBatal" class="btn-submit" style="background-color:#6c757d; display:none;" onclick="window.location.reload();">❌ Batal</button>
    </div>

    <div id="wh-search-wrap">
        <label>🔍 Cari:</label>
        <input type="text" id="wh-search-input" placeholder="Cari antrean, plat, status...">
        <span id="wh-search-count" style="font-size:11px; color:#666;"></span>
    </div>

    <div id="tabel-loading">⏳ Memuat data...</div>

    <div id="tabel-wh-wrap">
        <form action="<?= base_url('index.php/warehouse/proses_tabel_warehouse') ?>" method="POST" id="tabelWarehouseForm">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

            <table id="tabel-wh">
                <thead>
                    <tr>
                        <th id="th-checkbox" style="display:none; background-color:#dc3545;">Pilih</th>
                        <th>Antrean</th>
                        <th>No. Tiket</th>
                        <th>Plat No</th>
                        <th class="col-dark">Jml Box </th>
                        <th class="col-dark">B. Material</th>
                        <th>Loading Dock</th>
                        <th>Status Loading</th>
                        <th class="col-dark">Remark security</th>
                        <th>Remark WH</th>
                        <th id="th-aksi">Aksi Edit</th>
                    </tr>
                </thead>
                <tbody id="tabel-wh-body">
                    <tr><td colspan="11" style="text-align:center; padding:20px; color:#999;">Memuat data...</td></tr>
                </tbody>
            </table>
        </form>
    </div>
    <div style="margin-top:6px; font-size:11px; color:#555;" id="wh-page-info"></div>
</div>

<script>
/* ════════════════════════════════════════════════
   STATE & DATA LOAD
════════════════════════════════════════════════ */
let whAllRows   = [];
let whFiltered  = [];
let whEditMode  = false;
let whDeleteMode = false;

function loadWarehouseData(view_date) {
    document.getElementById('tabel-loading').style.display = 'block';
    document.getElementById('tabel-wh-wrap').style.opacity = '0.4';

    fetch('<?= base_url('index.php/warehouse/get_data/') ?>' + view_date, {
        headers: { "X-Requested-With": "XMLHttpRequest" }
    })
    .then(r => r.json())
    .then(data => {
        whAllRows = data;
        applySearch();
        document.getElementById('tabel-loading').style.display = 'none';
        document.getElementById('tabel-wh-wrap').style.opacity = '1';
    })
    .catch(() => {
        document.getElementById('tabel-loading').style.display = 'none';
        document.getElementById('tabel-wh-wrap').style.opacity = '1';
        document.getElementById('tabel-wh-body').innerHTML = '<tr><td colspan="11" style="color:red;text-align:center;padding:20px;">Gagal memuat data.</td></tr>';
    });
}

/* ════════════════════════════════════════════════
   CLIENT-SIDE SEARCH & RENDER
════════════════════════════════════════════════ */
document.getElementById('wh-search-input').addEventListener('input', applySearch);

function applySearch() {
    const q = document.getElementById('wh-search-input').value.toLowerCase().trim();
    whFiltered = q ? whAllRows.filter(r => 
        (r.no_antrean + '').toLowerCase().includes(q) ||
        (r.trans_no + '').toLowerCase().includes(q) ||
        (r.no_polisi + '').toLowerCase().includes(q) ||
        (r.status_loading + '').toLowerCase().includes(q) ||
        (r.remarks_wh + '').toLowerCase().includes(q)
    ) : [...whAllRows];

    renderTable();
}
function renderRemarkLogs(logs) {
    if (!logs || logs.length === 0) return '<div class="log-empty">Belum ada catatan.</div>';
    return logs.map(l => {
        const waktu = (l.created_at || '').substring(0, 16).replace('T', ' ');
        const roleClass = l.role === 'warehouse' ? 'role-warehouse' : 'role-security';
        return `<div class="log-line"><span class="log-meta ${roleClass}">[${l.created_by ? ''+escapeHtml(l.created_by) : ''}, ${waktu}]</span> ${escapeHtml(l.remarks)}</div>`;
    }).join('');
}
function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str || '';
    return div.innerHTML;
}
function renderTable() {
    const tbody = document.getElementById('tabel-wh-body');
    const hiddenWrap = document.getElementById('tabelWarehouseForm');

    hiddenWrap.querySelectorAll('input[name="row_ids[]"]').forEach(el => el.remove());

    if (whFiltered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="11" style="text-align:center;padding:20px;color:#999;">Tidak ada data.</td></tr>';
        document.getElementById('wh-page-info').textContent = 'Menampilkan 0 baris';
        return;
    }

    let html = '';
    whFiltered.forEach(t => {
        const id = t.id;

        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'row_ids[]'; inp.value = id;
        hiddenWrap.appendChild(inp);

        const cbDisplay = whDeleteMode ? 'table-cell' : 'none';
        const aksiDisplay = (whEditMode || whDeleteMode) ? 'none' : 'table-cell';

        // Select Box Color
        let bgStatus = '';
        if (t.status_loading === 'Loading') bgStatus = '#fff3cd';
        else if (t.status_loading === 'Finish') bgStatus = '#d1fae5';
        else if (t.status_loading === 'Cancel') bgStatus = '#f8d7da';
        const isCompleted = (t.is_completed === 'yes');
        const lockAttr = isCompleted ? 'disabled' : '';
        const rowStyleLock = isCompleted ? 'opacity:0.65;' : '';
        
        html += `
        <tr style="${rowStyleLock}" data-truck-id="${id}">
            <td class="td-checkbox" style="display:${cbDisplay};">
                <input type="checkbox" name="selected_rows[]" value="${id}" style="width:15px;height:15px;"${lockAttr}>
            </td>
            <td style="font-weight:bold;color:#d93025;font-size:1.1em;">${t.no_antrean}</td>
            <td>${t.trans_no || '-'}</td>
            <td style="color:#003366;font-weight:bold;">${t.no_polisi || '-'}</td>
            
            <td class="col-dark" style="font-weight:bold;">${t.jumlah_box !== undefined ? t.jumlah_box : '-'}</td>
            <td class="col-dark" style="font-weight:bold;">${t.berat_material !== undefined ? t.berat_material : '-'}</td>
            
            <td>
                <input type="number" name="loading_dock_${id}" value="${t.loading_dock || ''}" class="input-edit-mode" style="width:50px; background-color:white;" min="1" max="20" placeholder="-" ${lockAttr} onchange="saveDockOrStatusInstantly(${id})">
            </td>
            <td>
                <select name="status_loading_${id}" class="select-edit" style="width:90px; background-color:${bgStatus};" ${lockAttr} onchange="saveDockOrStatusInstantly(${id})">
                    <option value="" ${(!t.status_loading || t.status_loading === '' || t.status_loading === null) ? 'selected' : ''}>—</option>
                    <option value="Waiting" ${t.status_loading === 'Waiting' ? 'selected' : ''}>Waiting</option>
                    <option value="Loading" ${t.status_loading === 'Loading' ? 'selected' : ''}>Loading</option>
                    <option value="Finish"  ${t.status_loading === 'Finish' ? 'selected' : ''}>Finish</option>
                    <option value="Cancel"  ${t.status_loading === 'Cancel' ? 'selected' : ''}>Cancel</option>
                </select>
            </td>
           <td class="col-dark remark-cell text-wrap" style="min-width:220px; max-width:220px;">
                <div class="remark-log-box">${renderRemarkLogs(t.remark_logs ? t.remark_logs.filter(l => l.role === 'security') : [])}</div>
            </td>
            <td class="remark-cell text-wrap" style="min-width:220px; max-width: 220px;">
                <div class="remark-log-box" id="remark_log_${id}">${renderRemarkLogs(t.remark_logs ? t.remark_logs.filter(l => l.role === 'warehouse') : [])}</div>
                <textarea name="remarks_${id}" placeholder="Tambah catatan baru..."
                          class="input-edit-mode remark-textarea" style="width:100%;min-height:50px;resize:vertical;" ${lockAttr} 
                          onkeydown="handleRemarkKey(event, ${id})" oninput="resetRemarkIdleTimer(${id})"></textarea>
            </td>
          <td class="td-aksi" style="display:${aksiDisplay};">
                ${isCompleted ? '<span style="color:#6c757d;font-weight:bold;">✔️ Selesai</span>' : `<button type="button" class="btn-edit btn-single-update" data-id="${id}">Update</button>`}
            </td>
        </tr>`;
    });

    tbody.innerHTML = html;
    document.getElementById('wh-page-info').textContent = `Menampilkan ${whFiltered.length} dari ${whAllRows.length} baris`;
}
/* ════════════════════════════════════════════════
   AJAX AUTO SAVE & MANUAL UPDATE LOGIC
════════════════════════════════════════════════ */
let remarkTypingTimers = {}; 

// --- [A] TOMBOL UPDATE MANUAL (Klik Tetap Ada & Berfungsi via AJAX) ---
document.getElementById('tabelWarehouseForm').addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('btn-single-update')) {
        e.preventDefault();
        
        const truckId = e.target.getAttribute('data-id');
        const currentDock = document.querySelector(`input[name="loading_dock_${truckId}"]`).value;
        const currentStatus = document.querySelector(`select[name="status_loading_${truckId}"]`).value;
        const currentRemark = document.querySelector(`textarea[name="remarks_${truckId}"]`).value.trim();
        
        if (checkDoubleDock(truckId, currentDock, currentStatus)) {
            if (!confirm(`⚠️ PERINGATAN: Loading Dock "${currentDock}" sedang digunakan oleh truk lain!\n\nTetap gunakan dock ini?`)) {
                return;
            }
        }
        
        const textareaEl = document.querySelector(`textarea[name="remarks_${truckId}"]`);
        
        // Simpan semua data baris tersebut secara manual
        executeAjaxUpdate(truckId, currentDock, currentStatus, currentRemark !== '' ? currentRemark : null, textareaEl);
        
        // Feedback visual tombol loading sebentar
        const originalText = e.target.textContent;
        e.target.textContent = '⏳...';
        e.target.disabled = true;
        setTimeout(() => {
            e.target.textContent = originalText;
            e.target.disabled = false;
        }, 800);
    }
});

// --- [B] OTOMATISASI OTOMATIS (BACKUP JIKA USER LUPA KLIK) ---

// 1. Auto-save On Change untuk Dock & Status Loading
function saveDockOrStatusInstantly(truckId) {
    const dockInput = document.querySelector(`input[name="loading_dock_${truckId}"]`);
    const statusSelect = document.querySelector(`select[name="status_loading_${truckId}"]`);
    
    const currentDock = dockInput ? dockInput.value : '';
    const currentStatus = statusSelect ? statusSelect.value : '';

    if (checkDoubleDock(truckId, currentDock, currentStatus)) {
        if (!confirm(`⚠️ PERINGATAN: Loading Dock "${currentDock}" sedang digunakan oleh truk lain!\n\nTetap gunakan dock ini?`)) {
            loadWarehouseData(document.getElementById('view_date_select').value);
            return;
        }
    }

    // Ganti warna background select secara real-time
    if (statusSelect) {
        if (currentStatus === 'Loading') statusSelect.style.backgroundColor = '#fff3cd';
        else if (currentStatus === 'Finish') statusSelect.style.backgroundColor = '#d1fae5';
        else if (currentStatus === 'Cancel') statusSelect.style.backgroundColor = '#f8d7da';
        else statusSelect.style.backgroundColor = '#ffffff';
    }

    executeAjaxUpdate(truckId, currentDock, currentStatus, null);
}

// 2. Handle key Enter (Simpan) & Shift+Enter (Baris baru) di Textarea Remark
function handleRemarkKey(event, truckId) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault(); 
        saveRemarkInstantly(truckId);
    }
}

// 3. Reset Timer 30 Detik Saat User Diam Pas Ketik Remark
function resetRemarkIdleTimer(truckId) {
    clearTimeout(remarkTypingTimers[truckId]);
    remarkTypingTimers[truckId] = setTimeout(function() {
        saveRemarkInstantly(truckId);
    }, 30000); 
}

// 4. Eksekusi Simpan Khusus Bagian Remark
function saveRemarkInstantly(truckId) {
    clearTimeout(remarkTypingTimers[truckId]); 
    const textarea = document.querySelector(`textarea[name="remarks_${truckId}"]`);
    if (!textarea) return;

    const remarkValue = textarea.value.trim();
    if (remarkValue === '') return; 

    executeAjaxUpdate(truckId, null, document.querySelector(`select[name="status_loading_${truckId}"]`).value, remarkValue, textarea);
}

// --- [C] FUNGSI UTAMA AJAX SEND ---
function executeAjaxUpdate(truckId, dock, status, remark, textareaEl = null) {
    const csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

    const formData = new FormData();
    formData.append(csrfName, csrfHash);
    formData.append('truck_id', truckId);
    formData.append('status_loading', status);
    if (dock !== null) formData.append('loading_dock', dock);
    if (remark !== null) formData.append('remarks', remark);

    fetch('<?= base_url('index.php/warehouse/ajax_update_truck_wh') ?>', {
        method: 'POST',
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" }
    })
    .then(r => r.json())
    .then(res => {
        if (res.status === 'success') {
            console.log(`Data armada ID ${truckId} berhasil tersimpan (Auto/Manual).`);
            if (remark !== null && res.new_remarks_html) {
                const logBox = document.getElementById(`remark_log_${truckId}`);
                if (logBox) logBox.innerHTML = res.new_remarks_html;
                if (textareaEl) textareaEl.value = ''; 
            }
        } else {
            console.error('Gagal menyimpan: ' + res.message);
        }
    })
    .catch(err => {
        console.error('Terjadi error jaringan / CSRF expired:', err);
    });
}

/* ════════════════════════════════════════════════
   MODE MASSAL & CHECK DOUBLE DOCK
════════════════════════════════════════════════ */
function aktifkanModeEdit() {
    whEditMode = true; whDeleteMode = false;
    document.getElementById('btnModeEdit').style.display   = 'none';
    document.getElementById('btnModeDelete').style.display = 'none';
    document.getElementById('btnSimpanEdit').style.display = 'inline-block';
    document.getElementById('btnBatal').style.display      = 'inline-block';
    document.getElementById('th-aksi').style.display       = 'none';
    renderTable();
}

function aktifkanModeHapusWH() {
    whDeleteMode = true; whEditMode = false;
    document.getElementById('btnModeEdit').style.display      = 'none';
    document.getElementById('btnModeDelete').style.display    = 'none';
    document.getElementById('btnKonfirmDelete').style.display = 'inline-block';
    document.getElementById('btnBatal').style.display         = 'inline-block';
    document.getElementById('th-checkbox').style.display      = 'table-cell';
    document.getElementById('th-aksi').style.display          = 'none';
    renderTable();
}

function checkDoubleDock(currentTruckId = null, currentDockValue = null, currentStatusValue = null) {
    const rows = document.querySelectorAll('#tabel-wh-body tr');
    let hasDuplicate = false;
    const activeDocks = {};

    rows.forEach(row => {
        const rowId = row.getAttribute('data-truck-id');
        if (!rowId) return;
        
        let dockValue = "";
        let statusValue = "";

        if (currentTruckId && String(rowId) === String(currentTruckId)) {
            dockValue = String(currentDockValue).trim();
            statusValue = currentStatusValue;
        } else {
            const dockInput = row.querySelector(`input[name="loading_dock_${rowId}"]`);
            const statusSelect = row.querySelector(`select[name="status_loading_${rowId}"]`);
            dockValue = dockInput ? dockInput.value.trim() : "";
            statusValue = statusSelect ? statusSelect.value : "";
        }

        if (dockValue !== "" && statusValue !== "Finish" && statusValue !== "Cancel") {
            if (activeDocks[dockValue]) hasDuplicate = true;
            activeDocks[dockValue] = true;
        }
    });
    return hasDuplicate;
}

document.getElementById('view_date_select').addEventListener('change', function() {
    loadWarehouseData(this.value);
});

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.alert').forEach(a => {
        setTimeout(() => { a.style.transition="opacity 0.5s ease"; a.style.opacity="0"; setTimeout(()=>a.remove(), 500); }, 3500);
    });
    loadWarehouseData('<?= $view_date ?>');

    // 🔥 AUTO-REFRESH DIUBAH MENJADI TIAP 30 DETIK (Silent Sync Background)
    setInterval(function() {
        const active = document.activeElement;
        const isTyping = active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA' || active.tagName === 'SELECT');
        
        if (!isTyping && !whEditMode && !whDeleteMode) {
            const currentFormDate = document.getElementById('view_date_select').value;
            
            // Ambil data terbaru secara diam-diam di background
            fetch('<?= base_url('index.php/warehouse/get_data/') ?>' + currentFormDate, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(r => r.json())
            .then(data => {
                whAllRows = data;
                applySearch(); // Perbarui tabel secara halus tanpa memicu animasi loading freeze
            })
            .catch(() => {});
        }
    }, 30000); // 30000 milidetik = 30 detik
});
</script>