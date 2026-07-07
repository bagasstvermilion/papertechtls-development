<p>Debug main</p>
<style>
    /* ── Compact Table Style (konsisten dengan CS) ── */
    .custom-dropdown { display: none; position: absolute; top: 65px; left: 0; right: 0; background-color: #ffffff; border: 1px solid #ccc; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000; padding: 0; margin: 0; list-style: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .custom-dropdown li { padding: 6px 10px; cursor: pointer; color: #000000; font-size: 12px; border-bottom: 1px solid #f0f0f0; }
    .custom-dropdown li:hover { background-color: #ffb6c1; color: #000000; }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }

    .input-edit-mode {
        font-size: 11.5px;
        text-align: center;
        padding: 3px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }
    .remark-log-box { max-height:140px; max-width: 220px; overflow-y:auto; background:#f8f9fa; border:1px solid #ddd; border-radius:3px; padding:4px 6px; margin-bottom:4px; text-align:left; font-size:11px; line-height:1.4; }
    .remark-log-box .log-line { border-bottom:1px dashed #ddd; padding:6px 0; }
    .remark-log-box .log-line:last-child { border-bottom:none; }
    .remark-log-box .log-meta { font-weight:bold; color:#176B87; }
    .remark-log-box .log-meta.role-warehouse { color:#dc3545; }
    .remark-log-box .log-empty { color:#999; font-style:italic; }
    /* ── Main Table Container ── */
    #tabel-security-wrap { overflow-x: auto; margin-top: 10px; }

    #tabel-security { border-collapse: collapse; width: 100%; min-width: max-content; white-space: nowrap; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    #tabel-security th,
    #tabel-security td { border: 1px solid #ddd; padding: 5px 4px; text-align: center; font-size: 11.5px; }
    #tabel-security thead th { background-color: #176B87; color: white; }
    #tabel-security thead th.col-dark { color: black; background-color: #d9d9d9; }
    #tabel-security tbody tr:nth-child(even) { background-color: #f8f9fa; }
    #tabel-security tbody tr:hover { background-color: #e1f5fe; }

    /* ── Buttons ── */
    .btn-submit { background-color: #28a745; color: white; padding: 6px 12px; border: none; cursor: pointer; font-weight: bold; border-radius: 4px; font-size: 12px; }
    .btn-edit   { background-color: #ffc107; color: black; padding: 3px 6px; border: none; cursor: pointer; font-weight: bold; font-size: 11px; border-radius: 3px; }

    /* ── Alert ── */
    .alert         { background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border: 1px solid #c3e6cb; border-radius: 5px; transition: opacity 0.5s ease; font-size: 13px; }
    .alert-warning { background-color: #fff3cd; color: #856404; border-color: #ffeeba; }
    .alert-danger  { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }

    /* ── DataTables override – hapus export buttons ── */
    .dt-buttons { display: none !important; }

    /* ── Search bar ── */
    #sec-search-wrap { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
    #sec-search-wrap label { font-size: 12px; font-weight: bold; margin: 0; white-space: nowrap; }
    #sec-search-input { padding: 4px 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px; width: 220px; }
    #sec-search-input:focus { outline: none; border-color: #176B87; }

    /* ── Loading overlay ── */
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

<!-- ══════════ SCAN TIKET ══════════ -->
<div style="background-color: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 15px;">
    <h4 style="margin-top: 0; margin-bottom: 10px; color: #176B87; font-weight: bold;">🛡️ Scan Tiket Kedatangan</h4>

    <form action="<?= base_url('index.php/security/simpan_security') ?>" method="POST"
          style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

        <div style="position: relative; width: 180px;">
            <label style="display: block; font-weight: bold; margin-bottom: 3px; font-size: 12px;">No Ticket:</label>
            <input type="text" name="trans_no" id="input_trans_no" required
                   placeholder="— Ketik Tiket —"
                   style="padding: 6px; width: 100%; border: 1px solid #ccc; border-radius: 4px; font-size: 12px;"
                   autocomplete="off">
            <ul id="custom_ticket_list" class="custom-dropdown">
                <?php foreach($list_tiket as $tiket): ?>
                    <li class="ticket-item"><?= $tiket ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div>
            <label style="display: block; font-weight: bold; margin-bottom: 3px; font-size: 12px;">Nama Sopir:</label>
            <input type="text" name="nama_sopir" placeholder="Ketik Nama"
                   style="padding: 6px; width: 130px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px;">
        </div>
        <div>
            <label style="display: block; font-weight: bold; margin-bottom: 3px; font-size: 12px;">No Telp:</label>
            <input type="text" name="no_telp" placeholder="0812..."
                   style="padding: 6px; width: 110px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px;">
        </div>
        <div>
            <button type="submit" class="btn-submit">Submit</button>
        </div>
    </form>
</div>

<!-- ══════════ HEADER ANTREAN + DROPDOWN TANGGAL ══════════ -->
<div style="display: flex; justify-content: space-between; align-items: center;
            border-bottom: 2px solid #176B87; padding-bottom: 5px; margin-bottom: 10px;">
    <h3 style="color: #176B87; margin: 0; font-size: 16px;">🚜 Antrean Truk</h3>

    <div style="display: flex; align-items: center; gap: 8px;">
        <label style="font-weight: bold; font-size: 12px;">📅 Tanggal:</label>
        <select id="view_date_select"
                style="padding: 4px 8px; border-radius: 4px; border: 1px solid #ccc; font-weight: bold; font-size: 12px;">
            <option value="<?= $hari_ini ?>" <?= ($view_date == $hari_ini) ? 'selected' : '' ?>>
                Hari Ini (<?= $hari_ini ?>)
            </option>
            <?php foreach($list_tanggal as $tgl): ?>
                <?php if($tgl != $hari_ini): ?>
                <option value="<?= $tgl ?>" <?= ($view_date == $tgl) ? 'selected' : '' ?>><?= $tgl ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- ══════════ TABEL ══════════ -->
<div style="background:#fff; padding: 10px; border-radius: 6px; border: 1px solid #ddd;">

    <!-- Action Buttons -->
    <div style="margin-bottom: 8px; display: flex; gap: 6px; flex-wrap: wrap;" id="btn-action-wrap">
        <button type="button" id="btnModeEdit"   class="btn-submit" style="background-color:#007bff;" onclick="aktifkanModeEdit()">✏️ Edit</button>
        <button type="button" id="btnModeDelete" class="btn-submit" style="background-color:#dc3545;" onclick="aktifkanModeHapus()">🗑️ Hapus</button>
        <button type="submit" form="tabelSecurityForm" name="action" value="batch_update"
                id="btnSimpanEdit" class="btn-submit" style="background-color:#28a745; display:none;"
                onclick="return confirm('Yakin simpan semua perubahan?');">💾 Simpan</button>
        <button type="submit" form="tabelSecurityForm" name="action" value="batch_delete"
                id="btnKonfirmDelete" class="btn-submit" style="background-color:#c0392b; display:none;"
                onclick="return confirm('Yakin HAPUS truk yang dicentang?');">🚨 Konfirm Hapus</button>
        <button type="button" id="btnBatal" class="btn-submit" style="background-color:#6c757d; display:none;"
                onclick="window.location.reload();">❌ Batal</button>
    </div>

    <!-- Search -->
    <div id="sec-search-wrap">
        <label>🔍 Cari:</label>
        <input type="text" id="sec-search-input" placeholder="Cari no tiket, plat, sopir...">
        <span id="sec-search-count" style="font-size:11px; color:#666;"></span>
    </div>

    <div id="tabel-loading">⏳ Memuat data...</div>

    <div id="tabel-security-wrap">
        <form action="<?= base_url('index.php/security/proses_tabel_security') ?>" method="POST"
              id="tabelSecurityForm">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                   value="<?= $this->security->get_csrf_hash(); ?>">
            <!-- row_ids hidden inputs disuntikkan JS -->

            <table id="tabel-security">
                <thead>
                    <tr>
                        <th id="th-checkbox" style="display:none; background-color:#dc3545;">Del</th>
                        <th>Antrean</th>
                        <th>No. Tiket</th>
                        <th>Plat No</th>
                        <th>Nama Supir</th>
                        <th>No. Telp</th>
                        <th>Timbang Kosong</th>
                        <th class="col-dark">B. Material</th>
                        <th class="col-dark">B. Total</th>
                        <th>Timbang Isi</th>
                        <th>Netto</th>
                        <th class="col-dark">Status Muatan</th>
                        <th class="col-dark">Status WH</th>
                        <th class="col-dark">Ket. Warehouse</th>
                        <th>Catatan Security</th>
                        <th class="col-dark">Completed</th>
                        <th id="th-aksi">Konfirmasi</th>
                    </tr>
                </thead>
                <tbody id="tabel-security-body">
                    <tr><td colspan="17" style="text-align:center; padding:20px; color:#999;">Memuat data...</td></tr>
                </tbody>
            </table>
        </form>
    </div>

    <!-- Pagination info -->
    <div style="margin-top:6px; font-size:11px; color:#555;" id="sec-page-info"></div>
</div>

<script>
/* ════════════════════════════════════════════════
   STATE
════════════════════════════════════════════════ */
let secAllRows   = [];   // semua data dari AJAX
let secFiltered  = [];   // setelah search filter
let secEditMode  = false;
let secDeleteMode = false;

/* ════════════════════════════════════════════════
   LOAD DATA VIA AJAX
════════════════════════════════════════════════ */
function loadSecurityData(view_date) {
    document.getElementById('tabel-loading').style.display = 'block';
    document.getElementById('tabel-security-wrap').style.opacity = '0.4';

fetch('<?= base_url('index.php/security/get_data/') ?>' + view_date, {
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(r => r.json())
        .then(data => {
            secAllRows = data;
            applySearch();
            document.getElementById('tabel-loading').style.display = 'none';
            document.getElementById('tabel-security-wrap').style.opacity = '1';
        })
        .catch(() => {
            document.getElementById('tabel-loading').style.display = 'none';
            document.getElementById('tabel-security-wrap').style.opacity = '1';
            document.getElementById('tabel-security-body').innerHTML =
                '<tr><td colspan="17" style="color:red;text-align:center;padding:20px;">Gagal memuat data.</td></tr>';
        });
}

/* ════════════════════════════════════════════════
   CLIENT-SIDE SEARCH
════════════════════════════════════════════════ */
document.getElementById('sec-search-input').addEventListener('input', applySearch);

function applySearch() {
    const q = document.getElementById('sec-search-input').value.toLowerCase().trim();
    secFiltered = q
        ? secAllRows.filter(r =>
            (r.no_antrean   + '').toLowerCase().includes(q) ||
            (r.trans_no     + '').toLowerCase().includes(q) ||
            (r.no_polisi    + '').toLowerCase().includes(q) ||
            (r.nama_sopir   + '').toLowerCase().includes(q) ||
            (r.no_telp      + '').toLowerCase().includes(q) ||
            (r.status_loading+'').toLowerCase().includes(q) ||
            (r.keterangan_sec+'').toLowerCase().includes(q)
          )
        : [...secAllRows];

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
/* ════════════════════════════════════════════════
   RENDER TABEL
════════════════════════════════════════════════ */
function renderTable() {
    const tbody = document.getElementById('tabel-security-body');
    const hiddenWrap = document.getElementById('tabelSecurityForm');

    // Bersihkan hidden row_ids lama
    hiddenWrap.querySelectorAll('input[name="row_ids[]"]').forEach(el => el.remove());

    if (secFiltered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="17" style="text-align:center;padding:20px;color:#999;">Tidak ada data.</td></tr>';
        document.getElementById('sec-page-info').textContent = 'Menampilkan 0 baris';
        return;
    }

    let html = '';
    secFiltered.forEach(t => {
        const id = t.id;

        // Suntikkan hidden row_ids ke form
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'row_ids[]'; inp.value = id;
        hiddenWrap.appendChild(inp);

        // Status muatan badge
        let statusBadge = '-';

        const netto        = parseFloat(t.netto || 0);

        const normalMin    = parseFloat(t.normal_min || 0);

        const warningLimit = parseFloat(t.warning_limit || 0);

        if (netto > 0 && (normalMin > 0 || warningLimit > 0)) {

            if      (netto < normalMin)    statusBadge = '<span style="background-color:#fef3c7;color:#92400e;padding:2px 5px;border-radius:3px;font-weight:bold;">Kurang</span>';

            else if (netto > warningLimit) statusBadge = '<span style="background-color:#fee2e2;color:#991b1b;padding:2px 5px;border-radius:3px;font-weight:bold;">Lebih</span>';

            else                            statusBadge = '<span style="background-color:#d1fae5;color:#065f46;padding:2px 5px;border-radius:3px;font-weight:bold;">Pass</span>';

        }

        const beratMaterial = t.berat_material !== undefined ? t.berat_material : '-';
        const beratTotal    = t.berat_total    !== undefined ? t.berat_total    : '-';

        const cbDisplay = secDeleteMode ? 'table-cell' : 'none';
        const aksiDisplay = (secEditMode || secDeleteMode) ? 'none' : 'table-cell';

        const isCompleted = (t.is_completed === 'yes');
        const lockAttr = isCompleted ? 'disabled' : '';
        const rowStyleLock = isCompleted ? 'opacity:0.65;' : '';

        html += `
        <tr style="${rowStyleLock}">
           <input type="hidden" id="normal_min_${id}"     value="${t.normal_min || 0}">

            <input type="hidden" id="tol_max_${id}"        value="${t.toleransi_max || 0}">

            <input type="hidden" id="warning_limit_${id}"  value="${t.warning_limit || 0}">

            <input type="hidden" id="raw_bm_${id}"         value="${t.raw_berat_material || 0}">

            <td class="td-checkbox" style="display:${cbDisplay};">
                <input type="checkbox" name="selected_rows[]" value="${id}" style="width:15px;height:15px;" ${lockAttr}>
            </td>
            <td><b>${t.no_antrean}</b></td>
            <td>${t.trans_no || '-'}</td>
            <td>${t.no_polisi || '-'}</td>
            <td><input type="text" name="nama_sopir_${id}" value="${t.nama_sopir || ''}" class="input-edit-mode" style="width:80px;" ${lockAttr}></td>
            <td><input type="text" name="no_telp_${id}" value="${t.no_telp || ''}" class="input-edit-mode" style="width:80px;" ${lockAttr}></td>
            <td><input type="number" step="any" name="timbang_kosong_${id}" value="${t.timbang_kosong || ''}"
                       class="input-edit-mode" style="width:60px;background-color:#e9ecef;font-weight:bold;" readonly></td>
            <td class="col-dark" style="font-weight:bold;">${beratMaterial}</td>
            <td class="col-dark" style="font-weight:bold;color:#003366;" id="text_berat_total_${id}">${beratTotal}</td>
            <td><input type="number" step="any" name="timbang_isi_${id}" value="${t.timbang_isi || ''}"
                       class="input-edit-mode" style="width:60px;background-color:#e9ecef;font-weight:bold;" readonly></td>
            <td><input type="number" step="any" name="netto_${id}" value="${t.netto || ''}"
                       placeholder="Netto" class="input-edit-mode" style="width:60px;background-color:#e9ecef;font-weight:bold;" readonly></td>
            <td class="col-dark" id="status_muatan_${id}">${statusBadge}</td>
            <td class="col-dark">${t.status_loading || '-'}</td>
            <td class="col-dark text-wrap" style="min-width:180px; max-width:220px">
                <div class="remark-log-box">${renderRemarkLogs(t.remark_logs ? t.remark_logs.filter(l => l.role === 'warehouse') : [])}</div>
            </td>
            <td style="min-width:180px; max-width:220px" class="text-wrap">
                <div class="remark-log-box" id="remark_log_${id}">${renderRemarkLogs(t.remark_logs ? t.remark_logs.filter(l => l.role === 'security') : [])}</div>
                <textarea name="keterangan_sec_${id}" placeholder="Tambah catatan baru..."
                          class="input-edit-mode remark-textarea" style="width:100%;min-height:50px;resize:vertical;" ${lockAttr}></textarea>
            </td>
            <td class="col-dark">
                ${isCompleted
                    ? '<span style="background-color:#d1fae5;color:#065f46;padding:3px 8px;border-radius:4px;font-weight:bold;">✔ Selesai</span>'
                    : `<button type="button" class="btn-edit" style="background-color:#b3cf99;" onclick="if(confirm('Tandai truk #${t.no_antrean} selesai? Setelah ini data tidak bisa diubah lagi.')) window.location.href='<?= base_url('index.php/security/mark_completed/') ?>${id}'">Tandai Selesai</button>`
                }
            </td>
            <td class="td-aksi" style="display:${aksiDisplay};">
                ${isCompleted ? '-' : `<button type="submit" form="tabelSecurityForm" name="action" value="single_update_${id}" class="btn-edit">Update</button>`}
            </td>
        </tr>`;
    });

    tbody.innerHTML = html;
    document.getElementById('sec-page-info').textContent =
        `Menampilkan ${secFiltered.length} dari ${secAllRows.length} baris`;

    // Re-hitung netto untuk semua baris
    secFiltered.forEach(t => hitungNetto(t.id));
}

/* ════════════════════════════════════════════════
   HITUNG NETTO (sama persis seperti sebelumnya)
════════════════════════════════════════════════ */
function hitungNetto(id) {

    const kosongEl = document.querySelector(`input[name="timbang_kosong_${id}"]`);

    const isiEl    = document.querySelector(`input[name="timbang_isi_${id}"]`);

    const nettoEl  = document.querySelector(`input[name="netto_${id}"]`);

    const statusEl = document.getElementById(`status_muatan_${id}`);

    const totalEl  = document.getElementById(`text_berat_total_${id}`);

    if (!kosongEl || !isiEl || !nettoEl) return;

    const kosong         = parseFloat(kosongEl.value) || 0;

    const isi            = parseFloat(isiEl.value)    || 0;

    const beratMaterial  = parseFloat(document.getElementById(`raw_bm_${id}`)?.value)     || 0;

    const normalMin      = parseFloat(document.getElementById(`normal_min_${id}`)?.value) || 0;

    const warningLimit   = parseFloat(document.getElementById(`warning_limit_${id}`)?.value) || 0;

    const nettoDB        = parseFloat(nettoEl.getAttribute('value')) || 0;

    if (totalEl) {

        totalEl.innerText = (kosong > 0 && beratMaterial > 0)

            ? Math.round(kosong + beratMaterial)

            : (beratMaterial > 0 ? '-' : totalEl.innerText);

    }

    if (isi > 0 && kosong > 0) {

        const netto = nettoDB !== 0 ? nettoDB : (isi - kosong);

        nettoEl.value = parseFloat(netto.toFixed(2));

        if (statusEl && (normalMin > 0 || warningLimit > 0)) {

            if      (netto < normalMin)    statusEl.innerHTML = '<span style="background-color:#fef3c7;color:#92400e;padding:2px 5px;border-radius:3px;font-weight:bold;">Kurang</span>';

            else if (netto > warningLimit) statusEl.innerHTML = '<span style="background-color:#fee2e2;color:#991b1b;padding:2px 5px;border-radius:3px;font-weight:bold;">Lebih</span>';

            else                            statusEl.innerHTML = '<span style="background-color:#d1fae5;color:#065f46;padding:2px 5px;border-radius:3px;font-weight:bold;">Pass</span>';

        }

    } else {

        if (nettoDB === 0) nettoEl.value = '';

    }

}



/* ════════════════════════════════════════════════
   MODE EDIT / HAPUS
════════════════════════════════════════════════ */
function aktifkanModeEdit() {
    secEditMode = true; secDeleteMode = false;
    document.getElementById('btnModeEdit').style.display   = 'none';
    document.getElementById('btnModeDelete').style.display = 'none';
    document.getElementById('btnSimpanEdit').style.display = 'inline-block';
    document.getElementById('btnBatal').style.display      = 'inline-block';
    document.getElementById('th-aksi').style.display       = 'none';
    document.querySelectorAll('.td-aksi').forEach(el => el.style.display = 'none');
}

function aktifkanModeHapus() {
    secDeleteMode = true; secEditMode = false;
    document.getElementById('btnModeEdit').style.display      = 'none';
    document.getElementById('btnModeDelete').style.display    = 'none';
    document.getElementById('btnKonfirmDelete').style.display = 'inline-block';
    document.getElementById('btnBatal').style.display         = 'inline-block';
    document.getElementById('th-checkbox').style.display      = 'table-cell';
    document.querySelectorAll('.td-checkbox').forEach(el => el.style.display = 'table-cell');
    document.getElementById('th-aksi').style.display          = 'none';
    document.querySelectorAll('.td-aksi').forEach(el => el.style.display = 'none');
}

/* ════════════════════════════════════════════════
   DROPDOWN TANGGAL → RELOAD DATA
════════════════════════════════════════════════ */
document.getElementById('view_date_select').addEventListener('change', function() {
    loadSecurityData(this.value);
});

/* ════════════════════════════════════════════════
   AUTOCOMPLETE TIKET
════════════════════════════════════════════════ */
document.addEventListener("DOMContentLoaded", function() {
    // Auto-hide alert
    document.querySelectorAll('.alert, .alert-danger, .alert-warning').forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity    = "0";
            setTimeout(function() { alert.remove(); }, 500);
        }, 3500);
    });

    // Autocomplete
    const input         = document.getElementById("input_trans_no");
    const listContainer = document.getElementById("custom_ticket_list");
    const items         = listContainer.getElementsByTagName("li");

    input.addEventListener("input", function() {
        const filter = this.value.toUpperCase();
        let hasVisible = false;
        for (let i = 0; i < items.length; i++) {
            const txt = items[i].textContent || items[i].innerText;
            if (txt.toUpperCase().indexOf(filter) > -1) { items[i].style.display = ""; hasVisible = true; }
            else items[i].style.display = "none";
        }
        listContainer.style.display = (this.value.length > 0 && hasVisible) ? "block" : "none";
    });
    input.addEventListener("focus", function() {
        if (items.length > 0) {
            for (let i = 0; i < items.length; i++) items[i].style.display = "";
            listContainer.style.display = "block";
        }
    });
    for (let i = 0; i < items.length; i++) {
        items[i].addEventListener("click", function() {
            input.value = this.innerText;
            listContainer.style.display = "none";
        });
    }
    document.addEventListener("click", function(e) {
        if (e.target !== input && e.target !== listContainer) listContainer.style.display = "none";
    });

    // ─── PENANGAN ENTER TEXTAREA TANPA REFRESH HALAMAN (AJAX 100% SAVE) ───
    const mainForm = document.getElementById('tabelSecurityForm');
    if (mainForm) {
        mainForm.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.classList.contains('remark-textarea')) {
                if (!e.shiftKey) {
                    e.preventDefault(); 
                    e.stopPropagation();
                    
                    const textarea = e.target;
                    const catatanBaru = textarea.value.trim();
                    if (catatanBaru === '') return; // Jangan kirim kalau kosong

                    const textareaName = textarea.getAttribute('name');
                    const truckId = textareaName.split('_').pop();
                    
                    if (truckId) {
                        // 1. Buat data form manual untuk baris ini agar terbaca penuh oleh $_POST di Controller CI
                        const formData = new FormData();
                        
                        // Cari CSRF token yang ada di form kamu
                        const csrfToken = mainForm.querySelector('input[name*="csrf_test_name"]') || mainForm.querySelector('input[type="hidden"]');
                        if (csrfToken) {
                            formData.append(csrfToken.getAttribute('name'), csrfToken.value);
                        }

                        // Kirim row id yang mau di-update
                        formData.append('row_ids[]', truckId);
                        // Trigger action yang dicari oleh Controller backend kamu
                        formData.append('action', `single_update_${truckId}`);
                        // Masukkan isi catatan security
                        formData.append(`keterangan_sec_${truckId}`, catatanBaru);
                        
                        // Masukkan juga nama sopir & no telp baris tersebut agar data di db tidak hilang/tertimpa kosong
                        const namaSopirInput = mainForm.querySelector(`input[name="nama_sopir_${truckId}"]`);
                        const noTelpInput = mainForm.querySelector(`input[name="no_telp_${truckId}"]`);
                        if (namaSopirInput) formData.append(`nama_sopir_${truckId}`, namaSopirInput.value);
                        if (noTelpInput) formData.append(`no_telp_${truckId}`, noTelpInput.value);

                        // 2. Efek loading indikator lokal pada textarea agar user tahu proses berjalan
                        textarea.style.backgroundColor = '#fff3cd'; 
                        textarea.disabled = true;

                        // 3. Kirim data ke Controller CI menggunakan Fetch API
                        fetch(mainForm.getAttribute('action'), {
                            method: 'POST',
                            body: formData,
                            headers: { "X-Requested-With": "XMLHttpRequest" }
                        })
                        .then(() => {
                            // Kembalikan status textarea ke normal setelah sukses terkirim
                            textarea.style.backgroundColor = '#ffffff';
                            textarea.disabled = false;
                            textarea.value = ''; // Kosongkan inputan textarea kembali

                            // 4. Update Tampilan Log Box di layar secara instan (real-time manipulasi DOM)
                            const logBox = document.getElementById(`remark_log_${truckId}`);
                            if (logBox) {
                                const emptyLog = logBox.querySelector('.log-empty');
                                if (emptyLog) emptyLog.remove(); // Hapus teks "Belum ada catatan" jika ada
                                
                                const waktuSekarang = new Date().toISOString().substring(0, 16).replace('T', ' ');
                                const logBaru = document.createElement('div');
                                logBaru.className = 'log-line';
                                logBaru.innerHTML = `<span class="log-meta role-security">[Anda, ${waktuSekarang}]</span> ${escapeHtml(catatanBaru)}`;
                                logBox.appendChild(logBaru);
                                logBox.scrollTop = logBox.scrollHeight; // Scroll otomatis ke log terbawah
                            }
                        })
                        .catch(err => {
                            textarea.style.backgroundColor = '#f8d7da';
                            textarea.disabled = false;
                            alert('⚠️ Gagal menyimpan catatan, silakan coba lagi.');
                        });
                    }
                }
            }
        });

        // Cegah form utama ke-submit tidak sengaja jika iseng tekan enter di input text biasa
        mainForm.addEventListener('submit', function(e) {
            if (e.submitter && e.submitter.nodeName !== 'BUTTON' && !e.submitter.type) {
                e.preventDefault();
                return false;
            }
        });
    }
    // ───────────────────────────────────────────────────────────────────────

    // Validasi tiket sebelum submit
    const scanForm = document.querySelector('form[action="<?= base_url('index.php/security/simpan_security') ?>"]');
    if (scanForm) {
        scanForm.addEventListener('submit', function(e) {
            const inputTiket = input.value.trim();
            let valid = false;
            for (let i = 0; i < items.length; i++) {
                if (items[i].innerText.trim() === inputTiket) { valid = true; break; }
            }
            if (!valid) {
                e.preventDefault();
                alert("⚠️ Nomor Tiket tidak valid atau tidak terdaftar di Excel! Silakan pilih dari saran yang muncul.");
                input.value = ''; input.focus();
            }
        });
    }

    
    loadSecurityData('<?= $view_date ?>');

    // 🔥 AUTO-REFRESH DIUBAH MENJADI TIAP 30 DETIK (Silent Sync Background)
    setInterval(function() {
        const active = document.activeElement;
        // Cek apakah user sedang fokus mengetik sesuatu di layar agar tidak terganggu
        const isTyping = active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA' || active.tagName === 'SELECT');
        
        if (!isTyping && !secEditMode && !secDeleteMode) {
            const currentFormDate = document.getElementById('view_date_select').value;
            
            // Ambil data terbaru secara diam-diam di background
            fetch('<?= base_url('index.php/security/get_data/') ?>' + currentFormDate, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(r => r.json())
            .then(data => { 
                secAllRows = data; 
                applySearch(); // Perbarui tabel secara halus tanpa memicu animasi loading yang bikin freeze
            })
            .catch(() => {});
        }
    }, 30000); // 30000 milidetik = 30 detik
});
</script>