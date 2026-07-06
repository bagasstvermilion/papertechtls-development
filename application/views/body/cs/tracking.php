<link href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
.cs-page, .cs-page * { color-scheme: light !important; }
#spreadsheet-container, #spreadsheet-container * { color-scheme: light !important; }
.handsontable td[data-column="remark_sec"], .handsontable td[data-column="remark_wh"] { white-space: pre-wrap !important; text-align: left !important; vertical-align: top !important; }
@media (prefers-color-scheme: dark) {
    .cs-page { background: var(--surface) !important; color: var(--text-primary) !important; }
    .handsontable td { background-color: #ffffff !important; color: #0f172a !important; }
    .handsontable th { background-color: #003366 !important; color: #ffffff !important; }
    .handsontable tr:nth-child(even) td { background-color: #fafbfd !important; }
    .handsontable tbody tr td.bg-yellow { background-color: #fef08a !important; color: #854d0e !important; }
    .handsontable tbody tr td.bg-green  { background-color: #bbf7d0 !important; color: #166534 !important; }
    .handsontable tbody tr td.bg-red    { background-color: #fecaca !important; color: #991b1b !important; }
    .handsontable tbody tr td.bg-blue   { background-color: #bfdbfe !important; color: #1e3a8a !important; }
    .handsontable tbody tr td.bg-purple { background-color: #e9d5ff !important; color: #581c87 !important; }
    .handsontable tbody tr td.bg-orange { background-color: #fed7aa !important; color: #7c2d12 !important; }
    .handsontable tbody tr td.bg-pink   { background-color: #fbcfe8 !important; color: #831843 !important; }
    .handsontable tbody tr td.bg-gray   { background-color: #e2e8f0 !important; color: #1e293b !important; }
}

* { box-sizing: border-box; }
:root {
    --navy: #003366; --navy-mid: #0a4080; --accent: #0ea5e9; --accent-soft: #e0f2fe;
    --success: #10b981; --success-soft: #d1fae5; --warning: #f59e0b; --warning-soft: #fef3c7;
    --danger: #ef4444; --surface: #ffffff; --surface-2: #f8fafc; --surface-3: #f1f5f9;
    --border: #e2e8f0; --border-mid: #cbd5e1; --text-primary: #0f172a; --text-secondary: #475569;
    --text-muted: #94a3b8; --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04);
    --shadow-lg: 0 10px 40px rgba(0,0,0,0.1); --radius: 10px; --radius-sm: 6px; --radius-lg: 16px;
}

body { font-family: 'DM Sans', sans-serif; }

.cs-page { display: flex; flex-direction: column; gap: 16px; height: calc(100vh - 60px); }

/* ── HEADER ── */
.cs-header { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px 24px; box-shadow: var(--shadow-sm); flex-shrink: 0; }
.cs-header-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 12px; }
.cs-title-text h2 { margin: 0; font-size: 20px; font-weight: 700; color: var(--navy); letter-spacing: -0.3px; }
.cs-title-text p { margin: 2px 0 0; font-size: 13px; color: var(--text-muted); }
.cs-status-bar { display: flex; gap: 8px; flex-wrap: wrap; }
.status-pill { display: flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.status-pill .dot { width: 7px; height: 7px; border-radius: 50%; }
.pill-blue { background: var(--accent-soft); color: #0369a1; }
.pill-blue .dot { background: var(--accent); }
.pill-green { background: var(--success-soft); color: #065f46; }
.pill-green .dot { background: var(--success); }

/* ── CONTROLS ── */
.cs-controls { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.ctrl-group { display: flex; align-items: center; gap: 8px; background: var(--surface-2); border: 1px solid var(--border); border-radius: var(--radius); padding: 8px 14px; transition: border-color 0.2s; }
.ctrl-group:focus-within { border-color: var(--accent); background: white; box-shadow: 0 0 0 3px rgba(14,165,233,0.08); }
.ctrl-label { font-size: 12px; font-weight: 600; color: var(--text-secondary); white-space: nowrap; }
.ctrl-group select { border: none; background: transparent; font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500; color: var(--text-primary); padding: 0; outline: none; cursor: pointer; min-width: 130px; }
.ctrl-divider { width: 1px; height: 32px; background: var(--border); }

/* ── BUTTONS ── */
.btn-cs { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; border: none; border-radius: var(--radius); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.18s ease; white-space: nowrap; }
.btn-success-cs { background: linear-gradient(135deg, #059669, #10b981); color: white; box-shadow: 0 2px 8px rgba(5,150,105,0.3); }
.btn-success-cs:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(5,150,105,0.35); }
.btn-primary-cs { background: linear-gradient(135deg, #003366, #0a4080); color: white; box-shadow: 0 2px 8px rgba(0,51,102,0.3); }
.btn-primary-cs:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(0,51,102,0.35); }
.btn-accent-cs { background: linear-gradient(135deg, #0ea5e9, #0284c7); color: white; box-shadow: 0 2px 8px rgba(14,165,233,0.3); }
.btn-accent-cs:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(14,165,233,0.35); }
.btn-warning-cs { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; box-shadow: 0 2px 8px rgba(245,158,11,0.3); }
.btn-warning-cs:hover { transform: translateY(-1px); }
.btn-undo { background: #f1f5f9; color: var(--text-secondary); border: 1px solid var(--border); }
.btn-undo:hover { background: #eef2f7; border-color: var(--border-mid); }
.btn-add { background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
.btn-add:hover { background: #e0f2fe; border-color: #7dd3fc; }

/* ── SPREADSHEET ── */
.spreadsheet-wrapper { flex: 1; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); display: flex; flex-direction: column; min-height: 0; height: 100%; }
.spreadsheet-toolbar { display: flex; align-items: center; justify-content: space-between; padding: 10px 16px; background: var(--surface-2); border-bottom: 1px solid var(--border); flex-shrink: 0; flex-wrap: wrap; gap: 10px; }
.toolbar-left { display: flex; align-items: center; gap: 15px; flex-wrap: wrap; }
.toolbar-tag { display: flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 600; color: var(--text-secondary); background: var(--surface-3); border: 1px solid var(--border); padding: 4px 10px; border-radius: 20px; }
.toolbar-tag span.live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--success); animation: pulse-dot 2s infinite; }
@keyframes pulse-dot { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
.row-count { font-size: 12px; color: var(--text-muted); font-family: 'DM Mono', monospace; }
#spreadsheet-container { flex: 1; overflow: auto; min-height: 0; height: 100%; }

/* ── HANDSONTABLE OVERRIDES ── */
.handsontable th { background: var(--navy) !important; color: white !important; font-family: 'DM Sans', sans-serif !important; font-weight: 600 !important; font-size: 12px !important; border-color: rgba(255,255,255,0.12) !important; }
.handsontable td { font-family: 'DM Sans', sans-serif !important; font-size: 12.5px !important; color: var(--text-primary) !important; }
.handsontable tr:nth-child(even) td { background: #fafbfd; }
.handsontable tbody tr:hover td:not([class*="bg-"]) { background-color: inherit !important; }
.spreadsheet-wrapper, .spreadsheet-toolbar, .cs-header { background: #ffffff !important; }
.spreadsheet-toolbar { background: #f8fafc !important; }
.cs-page { background: #f1f5f9 !important; }
.handsontable th:hover { background-color: #003366 !important; cursor: default; }
.htDimmed { background: #f1f5f9; color: #64748b !important; font-weight: 600 !important; font-family: 'DM Mono', monospace !important; font-size: 11.5px !important; }

.handsontable tbody tr td.bg-yellow, .handsontable tbody tr td.bg-yellow.htDimmed { background-color: #fef08a !important; color: #854d0e !important; font-weight: bold !important; }
.handsontable tbody tr td.bg-green,  .handsontable tbody tr td.bg-green.htDimmed  { background-color: #bbf7d0 !important; color: #166534 !important; font-weight: bold !important; }
.handsontable tbody tr td.bg-red,    .handsontable tbody tr td.bg-red.htDimmed    { background-color: #fecaca !important; color: #991b1b !important; font-weight: bold !important; }
.handsontable tbody tr td.bg-blue,   .handsontable tbody tr td.bg-blue.htDimmed   { background-color: #bfdbfe !important; color: #1e3a8a !important; font-weight: bold !important; }
.handsontable tbody tr td.bg-purple, .handsontable tbody tr td.bg-purple.htDimmed { background-color: #e9d5ff !important; color: #581c87 !important; font-weight: bold !important; }
.handsontable tbody tr td.bg-orange, .handsontable tbody tr td.bg-orange.htDimmed { background-color: #fed7aa !important; color: #7c2d12 !important; font-weight: bold !important; }
.handsontable tbody tr td.bg-pink,   .handsontable tbody tr td.bg-pink.htDimmed   { background-color: #fbcfe8 !important; color: #831843 !important; font-weight: bold !important; }
.handsontable tbody tr td.bg-gray,   .handsontable tbody tr td.bg-gray.htDimmed   { background-color: #e2e8f0 !important; color: #1e293b !important; font-weight: bold !important; }

.handsontable td.text-bold { font-weight: 800 !important; color: #000 !important; }
.handsontable td.text-italic { font-style: italic !important; }
.handsontable td.text-left { text-align: left !important; }
.handsontable td.text-center { text-align: center !important; }
.handsontable td.text-right { text-align: right !important; }

/* ── COLOR PALETTE ── */
.color-palette-bar { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.palette-label { font-size: 11px; font-weight: 700; color: var(--text-secondary); white-space: nowrap; margin-right: 2px; }
.palette-btn { width: 26px; height: 26px; border-radius: 4px; border: 1px solid #cbd5e1; background: white; cursor: pointer; transition: all 0.15s; flex-shrink: 0; display:flex; align-items:center; justify-content:center; font-size: 14px; }
.palette-btn:hover { transform: scale(1.1); border-color: var(--navy); }
.palette-btn[data-color="clear"] { background: white; border: 2px dashed #cbd5e1; font-size: 13px; }

/* ── FULLSCREEN ── */
.spreadsheet-wrapper.fullscreen-mode { position: fixed !important; top: 0 !important; left: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 99999 !important; border-radius: 0 !important; }
.btn-maximize { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 5px; }
.btn-maximize:hover { background: #e2e8f0; color: var(--navy); }
.floating-minimize { position: fixed; bottom: 30px; right: 30px; background: var(--danger); color: white; padding: 12px 24px; border-radius: 30px; font-size: 14px; font-weight: 700; box-shadow: 0 10px 25px rgba(239,68,68,0.4); cursor: pointer; z-index: 100000; border: 2px solid white; display: none; align-items: center; gap: 8px; }
.spreadsheet-wrapper.fullscreen-mode .floating-minimize { display: flex; }

/* ── LOADING OVERLAY ── */
.loading-overlay { position: absolute; inset: 0; background: rgba(255,255,255,0.88); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 100; border-radius: var(--radius-lg); opacity: 0; pointer-events: none; transition: opacity 0.2s; }
.loading-overlay.active { opacity: 1; pointer-events: all; }
.spinner { width: 36px; height: 36px; border: 3px solid var(--border); border-top-color: var(--navy); border-radius: 50%; animation: spin 0.7s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ── TOAST ── */
.cs-toast { position: fixed; bottom: 24px; right: 24px; background: var(--navy); color: white; padding: 13px 20px; border-radius: var(--radius); font-size: 13.5px; font-weight: 500; box-shadow: var(--shadow-lg); z-index: 9999; transform: translateY(80px); opacity: 0; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); display: flex; align-items: center; gap: 8px; max-width: 360px; }
.cs-toast.show { transform: translateY(0); opacity: 1; }
.cs-toast.toast-success { background: linear-gradient(135deg, #059669, #10b981); }
.cs-toast.toast-error { background: linear-gradient(135deg, #dc2626, #ef4444); }
.cs-toast.toast-info { background: linear-gradient(135deg, #003366, #0a4080); }
.cs-toast.toast-warning { background: linear-gradient(135deg, #d97706, #f59e0b); }
/* ══════════════════════════════════
   MODAL EXPORT
══════════════════════════════════ */
.modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.55); backdrop-filter: blur(6px); z-index: 10000; display: flex; align-items: center; justify-content: center; padding: 20px; opacity: 0; pointer-events: none; transition: opacity 0.25s; }
.modal-backdrop.active { opacity: 1; pointer-events: all; }
.modal-box { background: white; border-radius: 20px; box-shadow: 0 25px 60px rgba(0,0,0,0.25); width: 100%; max-width: 1100px; max-height: 88vh; display: flex; flex-direction: column; transform: translateY(20px) scale(0.97); transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1); overflow: hidden; }
.modal-backdrop.active .modal-box { transform: translateY(0) scale(1); }
.modal-header { padding: 20px 24px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-shrink: 0; }
.modal-title { font-size: 17px; font-weight: 700; color: var(--navy); margin: 0 0 4px; }
.modal-subtitle { font-size: 12px; color: var(--text-muted); margin: 0; }
.modal-close { background: var(--surface-3); border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: background 0.15s; }
.modal-close:hover { background: #fecaca; }

.export-modal-box { max-width: 460px; }
.export-form { padding: 20px 24px; display: flex; flex-direction: column; gap: 16px; }
.export-field label { display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px; }
.export-field select { width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: var(--radius); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500; color: var(--text-primary); background: var(--surface-2); outline: none; transition: border-color 0.2s; }
.export-field select:focus { border-color: var(--accent); background: white; box-shadow: 0 0 0 3px rgba(14,165,233,0.08); }
.export-preview-info { background: var(--accent-soft); border: 1px solid #bae6fd; border-radius: var(--radius); padding: 10px 14px; font-size: 12.5px; color: #0369a1; display: flex; align-items: center; gap: 8px; }
.btn-export-confirm { background: linear-gradient(135deg, #7c3aed, #6d28d9); color: white; border: none; padding: 11px 24px; border-radius: var(--radius); font-size: 14px; font-weight: 700; cursor: pointer; width: 100%; box-shadow: 0 2px 8px rgba(124,58,237,0.3); transition: all 0.18s; }
.btn-export-confirm:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(124,58,237,0.35); }
.btn-export-confirm:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

/* Baris kedua nested header sedikit lebih terang */
.handsontable thead tr:nth-child(2) th { background: var(--navy-mid) !important; font-size: 11px !important; }
</style>

<div class="cs-page">

    <div class="cs-header">
        <div class="cs-header-top">
            <div class="cs-title-text">
                <h2>📋 CS Master Order</h2>
                <p>Edit Data Excel CS di sini. Klik kanan atau gunakan toolbar untuk mewarnai baris.</p>
            </div>
            <div class="cs-status-bar">
                <div class="status-pill pill-blue"><span class="dot"></span> Web Spreadsheet Active</div>
                <div class="status-pill pill-green" id="rowBadge"><span class="dot"></span><span id="rowBadgeText">Belum ada data</span></div>
            </div>
        </div>

        <div class="cs-controls">
            <div class="ctrl-group">
                <span class="ctrl-label">📅 Lihat Tanggal</span>
                <select id="filterTanggal" onchange="loadData()">
                    <option value="">— Pilih Tanggal —</option>
                    <?php foreach ($list_tanggal as $tgl): ?>
                        <option value="<?= $tgl ?>"><?= $tgl ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn-cs btn-success-cs" onclick="simpanKeDatabase()">💾 Simpan Perubahan</button>
            <div class="ctrl-divider"></div>
            <button class="btn-cs btn-primary-cs" onclick="bukaModalExport()">📤 Export History</button>
            <div class="ctrl-divider"></div>

            <button class="btn-cs btn-add" onclick="addRowBottom()">＋ Baris</button>
            <button class="btn-cs btn-add" onclick="addColRight()">＋ Kolom</button>
        </div>
    </div>

    <div class="spreadsheet-wrapper" id="masterSpreadsheet" style="position:relative;">

        <div class="spreadsheet-toolbar">
            <div class="toolbar-left">
                <div style="display:flex;gap:6px;">
                    <div class="toolbar-tag"><span class="live-dot"></span> Live</div>
                    <div class="toolbar-tag" id="activeDateTag">—</div>
                </div>

                <div class="color-palette-bar">
                    <span class="palette-label">🔤:</span>
                    <button class="palette-btn" style="font-weight:900;font-family:serif;" title="Bold" onclick="applyFormat('text-bold','toggle')">B</button>
                    <button class="palette-btn" style="font-style:italic;font-family:serif;" title="Italic" onclick="applyFormat('text-italic','toggle')">I</button>
                    <span style="border-left:1px solid #ccc;margin:0 5px;height:20px;"></span>
                    <button class="palette-btn" title="Rata Kiri"   onclick="applyFormat('text-left','align')">⇤</button>
                    <button class="palette-btn" title="Rata Tengah" onclick="applyFormat('text-center','align')">↔</button>
                    <button class="palette-btn" title="Rata Kanan"  onclick="applyFormat('text-right','align')">⇥</button>
                    <span style="border-left:1px solid #ccc;margin:0 5px;height:20px;"></span>
                    <span class="palette-label">🎨:</span>
                    <button class="palette-btn" data-color="clear" title="Hapus Format" onclick="applyFormat('clear','color')">✕</button>
                    <button class="palette-btn" style="background:#fef08a;" title="Kuning"  onclick="applyFormat('bg-yellow','color')"></button>
                    <button class="palette-btn" style="background:#bbf7d0;" title="Hijau"   onclick="applyFormat('bg-green','color')"></button>
                    <button class="palette-btn" style="background:#fecaca;" title="Merah"   onclick="applyFormat('bg-red','color')"></button>
                    <button class="palette-btn" style="background:#bfdbfe;" title="Biru"    onclick="applyFormat('bg-blue','color')"></button>
                    <button class="palette-btn" style="background:#e9d5ff;" title="Ungu"    onclick="applyFormat('bg-purple','color')"></button>
                    <button class="palette-btn" style="background:#fed7aa;" title="Oranye"  onclick="applyFormat('bg-orange','color')"></button>
                    <button class="palette-btn" style="background:#fbcfe8;" title="Pink"    onclick="applyFormat('bg-pink','color')"></button>
                    <button class="palette-btn" style="background:#e2e8f0;" title="Abu"     onclick="applyFormat('bg-gray','color')"></button>
                </div>
            </div>

            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <button class="btn-cs btn-undo" style="padding:5px 10px;font-size:12px;" onclick="doUndo()" title="Undo (Ctrl+Z)">↩ Undo</button>
                <button class="btn-cs btn-undo" style="padding:5px 10px;font-size:12px;" onclick="doRedo()" title="Redo (Ctrl+Y)">↪ Redo</button>
                <span style="border-left:1px solid #ccc;height:20px;margin:0 4px;"></span>
                <div class="row-count" id="rowCountLabel">—</div>
                <button class="btn-maximize" onclick="toggleFullscreen()">⛶ Maximize</button>
            </div>
        </div>

        <div id="spreadsheet-container" style="flex:1;overflow:auto;min-height:0;height:100%;"></div>

        <button class="floating-minimize" onclick="toggleFullscreen()">🗕 Minimize</button>

        <div class="loading-overlay" id="loadingOverlay">
            <div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
                <div class="spinner"></div>
                <div style="font-size:13px;font-weight:600;color:var(--text-secondary);" id="loadingLabel">Memuat data…</div>
            </div>
        </div>
    </div>
</div>

<div class="cs-toast" id="csToast"></div>
<div class="modal-backdrop" id="exportModal">
    <div class="modal-box export-modal-box">
        <div class="modal-header">
            <div>
                <p class="modal-title">📤 Export History CS ke Excel</p>
                <p class="modal-subtitle">Pilih rentang bulan yang ingin di-export. Setiap tanggal akan menjadi sheet terpisah.</p>
            </div>
            <button class="modal-close" onclick="tutupModalExport()">✕</button>
        </div>

        <div class="export-form">
            <div class="export-field">
                <label>📅 Dari Bulan</label>
                <select id="exportDari"></select>
            </div>
            <div class="export-field">
                <label>📅 Sampai Bulan</label>
                <select id="exportSampai"></select>
            </div>
            <div class="export-preview-info" id="exportPreviewInfo">
                ℹ️ Pilih rentang bulan untuk melihat estimasi data.
            </div>
            <button class="btn-export-confirm" id="btnExportConfirm" onclick="prosesExport()">
                ⬇️ Download Excel History
            </button>
        </div>
    </div>
</div>
<script>
// Token CSRF untuk CodeIgniter
const csrfToken = "<?= $this->security->get_csrf_hash() ?>";

// ─── STATE ───────────────────────────────────────────────────────
let hot;
let colorMap   = {};
let undoStack  = [];
let redoStack  = [];
let extraColHeaders = [];
let extraColCount   = 0;

function rendererBulat(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    const num = parseFloat(String(value).replace(/,/g, ''));
    td.innerText = (!isNaN(num) && value !== '' && value !== null) ? Math.round(num).toString() : (value || '');
    td.style.textAlign = 'right';
}   

// ─── INIT ────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    initSpreadsheet();

    const filterEl = document.getElementById('filterTanggal');
    if (filterEl.options.length > 1) {
        filterEl.selectedIndex = 1;
        loadData();
    }

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'z') { e.preventDefault(); doUndo(); }
        if (e.ctrlKey && e.key === 'y') { e.preventDefault(); doRedo(); }
        if (e.key === 'Escape') {
            const w = document.getElementById('masterSpreadsheet');
            if (w.classList.contains('fullscreen-mode')) {
                w.classList.remove('fullscreen-mode');
                requestAnimationFrame(() => requestAnimationFrame(() => { if(hot){ hot.render(); setTimeout(() => hot.render(), 100); } }));
            }
        }
    });

});

// ─── COLUMN DEFINITIONS (TETAP 27 KOLOM PYTHON) ───────────────────
function buildNestedHeaders() {
    // Baris header atas (grup)
    const row1 = [
        'ID','Kode Unik','Kedatangan Truck','Nama Customer','Area / Region','Urutan Bongkar',
        { label: 'Item Desc', colspan: 2 },          // ← membawahi type & weight
        'Color','Pattern Nose',
        'Qty/(Box/pallet)','Qty/Pcs','Qty Box / pallet','Status Produk','Waktu Muat',
        'Status Tracking','BERAT TOTAL (Kg)','BERAT Box (Kg)','BERAT ISI TRUCK',
        { label: 'NORMAL', colspan: 2 },             // ← membawahi Min & Max
        { label: 'TOLERANSI', colspan: 2 },          // ← membawahi Min & Max
        'WARNING','Nama Supir','No Telp',
        'Remark CS','Remark Security','Remark Warehouse'
    ];
    // Baris header bawah (sub-kolom)
    const row2 = [
        '','','','','','',
        'Type','Weight',
        '','',
        '','','','','',
        '','','','',
        'Min','Max','Min','Max',
        '','','',
        '','',''
    ];
    // Kolom extra yang ditambah user
    extraColHeaders.forEach(name => { row1.push(name); row2.push(''); });
    return [row1, row2];
}

function buildColumns() {
    const base = [
        { data:'id', readOnly:true }, { data:'kode_unik', readOnly:true }, { data:'kedatangan_truck' },
        { data:'nama_customer' }, { data:'area' }, { data:'urutan_bongkar' },
        { data:'item_desc' }, { data:'weight', type:'numeric' }, { data:'color' }, { data:'pattern_nose' },
        { data:'qty_box_pallet', type:'numeric' }, { data:'qty_pcs', type:'numeric' },
        { data:'qty_box_pallet_total', type:'numeric', readOnly:true }, { data:'status_produk' },
        { data:'waktu_muat' }, { data:'status_tracking', readOnly:true },
       { data:'berat_total', type:'numeric', readOnly:true, renderer: rendererBulat },
        { data:'berat_box', type:'numeric', readOnly:true, renderer: rendererBulat },
        { data:'berat_isi_truck', type:'numeric', readOnly:true, renderer: rendererBulat },
        { data:'normal_min', type:'numeric', readOnly:true, renderer: rendererBulat }, 
        { data:'normal_max', type:'numeric', readOnly:true, renderer: rendererBulat },
        { data:'toleransi_min', type:'numeric', readOnly:true, renderer: rendererBulat }, 
        { data:'toleransi_max', type:'numeric', readOnly:true, renderer: rendererBulat },
        { data:'warning', type:'numeric', readOnly:true, renderer: rendererBulat },
        { data:'nama_supir', readOnly:true }, { data:'no_telp', readOnly:true },

        // Mapping Data Remark
        { data:'remark' }, 
        { data:'remark_sec', readOnly:true, renderer: 'text', wordWrap: true }, 
        { data:'remark_wh', readOnly:true, renderer: 'text', wordWrap: true }
    ];
    for (let i = 0; i < extraColCount; i++) base.push({ data: 'extra_col_${i}' });
    return base;
}

// ─── INIT SPREADSHEET ────────────────────────────────────────────
function initSpreadsheet() {
    if (hot) { hot.destroy(); hot = null; }
    const container = document.getElementById('spreadsheet-container');

    hot = new Handsontable(container, {
        data: [],
        rowHeaders: true,
        outsideClickDeselects: false,
        nestedHeaders: buildNestedHeaders(),  // ← JADI INI
        columns: buildColumns(),
        hiddenColumns: { columns: [0,1], indicators: false },
        mergeCells: true,
        
        cells: function(row, col) {
            let cellProperties = {};
            const kedatangan = this.instance.getDataAtRowProp(row, 'kedatangan_truck');
            const k_str = String(kedatangan || '').trim();
            let classes = [];
            
            if (/^\d+$/.test(k_str)) {
                classes.push('bg-yellow', 'text-bold');
            } else if (colorMap && colorMap[`${row},${col}`]) {
                classes.push(...colorMap[`${row},${col}`].split(' '));
            }

            if (classes.length > 0) {
                cellProperties.className = classes.join(' ');
            }
            return cellProperties;
        },

        contextMenu: {
            items: {
                row_above:  { name:'➕ Sisipkan Baris Atas' },
                row_below:  { name:'➕ Sisipkan Baris Bawah' },
                remove_row: { name:'🗑 Hapus Baris' },
                hsep1: '---------',
                bold:   { name:'<b>B</b> Tebal',   callback: () => applyFormat('text-bold','toggle') },
                italic: { name:'<i>I</i> Miring', callback: () => applyFormat('text-italic','toggle') },
                hsep2: '---------',
                align_l: { name:'⇤ Rata Kiri',   callback: () => applyFormat('text-left','align') },
                align_c: { name:'↔ Rata Tengah', callback: () => applyFormat('text-center','align') },
                align_r: { name:'⇥ Rata Kanan',  callback: () => applyFormat('text-right','align') },
                hsep3: '---------',
                color_yellow: { name:'🟡 Kuning', callback: () => applyFormat('bg-yellow','color') },
                color_green:  { name:'🟢 Hijau',  callback: () => applyFormat('bg-green','color') },
                color_red:    { name:'🔴 Merah',  callback: () => applyFormat('bg-red','color') },
                clear: { name:'✕ Hapus Format', callback: () => applyFormat('clear','color') }
            }
        },
        beforeChange: function(changes, source) {
            if (source === 'loadData' || source === 'internal_calc') return;
            if (changes) { undoStack.push({ type:'data', snapshot: hot.getData().map(r=>[...r]) }); redoStack=[]; }
        },
        afterChange: function(changes, source) {
            if (source === 'loadData' || source === 'internal_calc' || !changes) return;
            let summaryRows = new Set();
            this.suspendExecution();
            
            changes.forEach(([row, prop]) => {
                const k = String(this.getDataAtRowProp(row,'kedatangan_truck') || '').trim();
                
                if (k.includes('.')) {
                    summaryRows.add(k.split('.')[0]); 
                    
                    if (['weight','qty_pcs'].includes(prop)) {
                        const w  = parseFloat(String(this.getDataAtRowProp(row,'weight')).replace(/,/g,'')) || 0;
                        const qp = parseFloat(String(this.getDataAtRowProp(row,'qty_pcs')).replace(/,/g,'')) || 0;
                        if (w > 0 && qp > 0) {
                            this.setDataAtRowProp(row, 'berat_total', Math.round((w*qp)/1000), 'internal_calc');
                        }
                    }
                } else if (/^\d+$/.test(k)) {
                    summaryRows.add(k);
                }
            });

            const allData = this.getData();
            summaryRows.forEach(pid => {
                let sumQty=0, sumBT_raw=0, sumBB=0, sIdx=-1;
                allData.forEach((r,i) => {
                    const k = String(r[2]||'').trim();
                    if (k === pid) {
                        sIdx = i;
                    } 
                    else if (k.startsWith(pid + '.')) { 
                        sumQty += parseFloat(String(r[12]).replace(/,/g,'')) || 0; 
                        sumBT_raw += parseFloat(String(r[16]).replace(/,/g,'')) || 0; // 🔥 nilai asli (sudah dibulatkan per baris di tahap sebelumnya, tapi minim selisih)
                        sumBB  += parseFloat(String(r[17]).replace(/,/g,'')) || 0; 
                    }
                });
                
                if (sIdx !== -1) {
                    this.setDataAtRowProp(sIdx,'qty_box_pallet_total', sumQty, 'internal_calc');
                    this.setDataAtRowProp(sIdx,'berat_total', Math.round(sumBT_raw), 'internal_calc'); // 🔥 bulatkan setelah jumlah
                    this.setDataAtRowProp(sIdx,'berat_box', sumBB, 'internal_calc');
                }
            });
            this.resumeExecution();
        },
        width:'100%', height:'100%', colWidths:120, manualColumnResize:true, minSpareRows:5,
        stretchH: 'none',
        licenseKey:'non-commercial-and-evaluation'
    });
}

// ─── FUNGSI KALKULASI ULANG SEMUA DATA ───────────────────────────
function hitungUlangSemuaRumus() {
    if (!hot) return;
    const allData = hot.getData();
    let summaryRows = new Set();
    
    allData.forEach(r => {
        const k = String(r[2] || '').trim();
        if (/^\d+$/.test(k)) summaryRows.add(k);
    });

    hot.suspendExecution();
    summaryRows.forEach(pid => {
        let sumQty = 0, sumBT_raw = 0, sumBB = 0, sIdx = -1;
        allData.forEach((r, i) => {
            const k = String(r[2] || '').trim();
            if (k === pid) {
                sIdx = i;
            } else if (k.startsWith(pid + '.')) {
                const w = parseFloat(String(r[7]).replace(/,/g, '')) || 0;
                const qp = parseFloat(String(r[11]).replace(/,/g, '')) || 0;
                
                
                let rowBT_raw = parseFloat(String(r[16]).replace(/,/g, '')) || 0;
                if (w > 0 && qp > 0) {
                    rowBT_raw = (w * qp) / 1000;
                }

                // Tampilan per baris anak tetap dibulatkan (tidak mengubah cara hitung total)
                hot.setDataAtRowProp(i, 'berat_total', Math.round(rowBT_raw), 'internal_calc');

                sumQty += parseFloat(String(r[12]).replace(/,/g, '')) || 0;
                sumBT_raw += rowBT_raw; // 🔥 jumlahkan nilai asli, BUKAN yang sudah dibulatkan
                sumBB  += parseFloat(String(r[17]).replace(/,/g, '')) || 0;
            }
        });
        
        if (sIdx !== -1) {
            hot.setDataAtRowProp(sIdx, 'qty_box_pallet_total', sumQty, 'internal_calc');
            hot.setDataAtRowProp(sIdx, 'berat_total', Math.round(sumBT_raw), 'internal_calc'); // 🔥 bulatkan SETELAH dijumlah
            hot.setDataAtRowProp(sIdx, 'berat_box', sumBB, 'internal_calc');
        }
    });
    hot.resumeExecution();
}

// ─── LOAD DATA DARI CI3 ─────────────────────────────────────────
function loadData() {
    const tanggal = document.getElementById('filterTanggal').value;
    if (!tanggal) {
        if (hot) { colorMap = {}; hot.loadData([]); }
        document.getElementById('rowBadgeText').textContent = 'Grid kosong';
        document.getElementById('rowCountLabel').textContent = '—';
        document.getElementById('activeDateTag').textContent = '—';
        return;
    }

    setLoading(true, 'Memuat data…');

    Promise.all([
        fetch(`<?= base_url('index.php/cs/api_cs_data') ?>?tanggal=${tanggal}`).then(r=>r.json()),
        fetch(`<?= base_url('index.php/cs/api_cs_color_load') ?>?tanggal=${tanggal}`).then(r=>r.json())
    ])
    .then(([data, colorData]) => {
        colorMap = colorData.color_map || {};
        undoStack=[]; redoStack=[];
        if (!hot) initSpreadsheet();
        hot.loadData(data.length ? data : []);
        
        applySummaryFormatting();
        hitungUlangSemuaRumus(); 
        
        const count = data.length;
        document.getElementById('rowBadgeText').textContent = count ? `${count} baris dimuat` : 'Tidak ada data';
        document.getElementById('rowCountLabel').textContent = count ? `${count} rows` : '—';
        document.getElementById('activeDateTag').textContent = `📅 ${tanggal}`;
        setLoading(false);
        if (count) showToast(`✅ Data dimuat · ${count} baris`, 'toast-success');
        else showToast('ℹ️ Tidak ada data untuk tanggal ini', 'toast-info');
    })
    .catch(() => { setLoading(false); showToast('❌ Gagal memuat data','toast-error'); });
}

// ─── ALGORITMA MERGE DINAMIS SPREADSHEET ──────────────────────────
// ─── ALGORITMA MERGE DINAMIS SPREADSHEET (KHUSUS TEKS) ────────
function applySummaryFormatting() {
    if (!hot) return;
    const data = hot.getData();
    const merges = [];
    
    let childGroups = [];
    let currentGroup = null;

    data.forEach((r, i) => {
        const k = String(r[2] || '').trim().toUpperCase();
        if (/^\d+$/.test(k) || k === 'TOTAL') {
            if (currentGroup) { childGroups.push(currentGroup); currentGroup = null; }
        } else if (k.includes('.') || k.includes(',')) {
            if (!currentGroup) currentGroup = { start: i, rows: [] };
            currentGroup.rows.push(i);
        }
    });
    if (currentGroup) childGroups.push(currentGroup);

    // 🔥 HANYA MERGE KOLOM TEKS/PENAMAAN
    // Indeks: Customer(3), Area(4), Urutan(5), Item(6), Color(8), Pattern(9), 
    // Status(13), Waktu(14), Tracking(15), Supir(24), Telp(25), Remarks(26,27,28)
    // (Abaikan angka/qty: 7, 10, 11, 12, 16, 17, 18, 19, 20, 21, 22, 23)
    const colsToMergeVertically = [3, 4, 5, 6, 8, 9, 13, 14, 15, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28]; 
    
    const normalizeStr = s => String(s || '').replace(/\s+/g, ' ').trim();
    const isEmptyEq = val => val === "" || val === "0" || val === 0;
    
    childGroups.forEach(group => {
        if (group.rows.length <= 1) return; 

        colsToMergeVertically.forEach(colIdx => {
            let startRow = group.rows[0];
            let count = 1;
            let currentVal = normalizeStr(data[startRow][colIdx]);

            for (let i = 1; i < group.rows.length; i++) {
                let rowIdx = group.rows[i];
                let cellVal = normalizeStr(data[rowIdx][colIdx]);
                
                if (cellVal === currentVal || isEmptyEq(cellVal)) {
                    count++;
                } else {
                    if (count > 1) merges.push({ row: startRow, col: colIdx, rowspan: count, colspan: 1 });
                    startRow = rowIdx;
                    count = 1;
                    currentVal = cellVal;
                }
            }
            if (count > 1) merges.push({ row: startRow, col: colIdx, rowspan: count, colspan: 1 });
        });
    });

    hot.updateSettings({ mergeCells: merges.length ? merges : false });
}

// ─── SIMPAN PERUBAHAN KE CI3 ──────────────────────────────────────
function simpanKeDatabase() {
    const tanggal = document.getElementById('filterTanggal').value;
    if (!tanggal) { showToast('⚠️ Pilih tanggal terlebih dahulu!','toast-error'); return; }
    if (!hot) { showToast('⚠️ Tidak ada data untuk disimpan','toast-error'); return; }

    const semuaData = hot.getData();
    setLoading(true, 'Menyimpan…');

    Promise.all([
        fetch('<?= base_url('index.php/cs/api_cs_save') ?>', {
            method:'POST',
            headers: { 'Content-Type':'application/json' },
            body: JSON.stringify({ tanggal: tanggal, data: semuaData })
        }).then(r=>r.json()),
        fetch('<?= base_url('index.php/cs/api_cs_color_save') ?>', {
            method:'POST',
            headers: { 'Content-Type':'application/json' },
            body: JSON.stringify({ tanggal: tanggal, color_map: JSON.stringify(colorMap) })
        }).then(r=>r.json())
    ])
    .then(([saveRes, colorRes]) => {
        setLoading(false);
        if (saveRes.status==='success' && colorRes.status==='success') {
            showToast('✅ Data & warna tersimpan!','toast-success');
        } else {
            showToast('❌ Gagal menyimpan', 'toast-error');
        }
    })
    .catch(() => { setLoading(false); showToast('❌ Terjadi kesalahan jaringan','toast-error'); });
}

// ─── TOOLBAR & BUTTON ACTION ──────────────────────────────────────
function applyFormat(formatClass, type) {
    const selected = hot && hot.getSelected();
    if (!selected || !selected.length) { showToast('⚠️ Pilih sel di tabel dulu','toast-warning'); return; }

    const sel = selected.map(([r1,c1,r2,c2]) => ({
        start: { row: Math.min(r1,r2), col: Math.min(c1,c2) },
        end:   { row: Math.max(r1,r2), col: Math.max(c1,c2) }
    }));

    undoStack.push({ type:'color', snapshot: JSON.stringify(colorMap) });
    redoStack = [];

    sel.forEach(s => {
        for (let r=s.start.row; r<=s.end.row; r++) {
            for (let c=s.start.col; c<=s.end.col; c++) {
                const key = `${r},${c}`;
                let classes = colorMap[key] ? colorMap[key].split(' ').filter(Boolean) : [];
                if (type==='color') {
                    classes = classes.filter(cls => !cls.startsWith('bg-'));
                    if (formatClass!=='clear') classes.push(formatClass);
                } else if (type==='align') {
                    classes = classes.filter(cls => !['text-left','text-center','text-right'].includes(cls));
                    classes.push(formatClass);
                } else if (type==='toggle') {
                    classes = classes.includes(formatClass) ? classes.filter(cls=>cls!==formatClass) : [...classes, formatClass];
                }
                if (classes.length) colorMap[key] = classes.join(' ');
                else delete colorMap[key];
            }
        }
    });
    hot.render();
}

function doUndo() {
    if (!undoStack.length) { showToast('⚠️ Tidak ada yang bisa di-undo','toast-info'); return; }
    const last = undoStack.pop();
    if (last.type==='data') { redoStack.push({ type:'data', snapshot: hot.getData().map(r=>[...r]) }); hot.loadData(last.snapshot); }
    else { redoStack.push({ type:'color', snapshot: JSON.stringify(colorMap) }); colorMap=JSON.parse(last.snapshot); hot.render(); }
    showToast('↩ Undo','toast-info');
}
function doRedo() {
    if (!redoStack.length) { showToast('⚠️ Tidak ada yang bisa di-redo','toast-info'); return; }
    const next = redoStack.pop();
    if (next.type==='data') { undoStack.push({ type:'data', snapshot: hot.getData().map(r=>[...r]) }); hot.loadData(next.snapshot); }
    else { undoStack.push({ type:'color', snapshot: JSON.stringify(colorMap) }); colorMap=JSON.parse(next.snapshot); hot.render(); }
    showToast('↪ Redo','toast-info');
}

function addRowBottom() {
    if (!hot) { showToast('⚠️ Muat data dulu','toast-warning'); return; }
    undoStack.push({ type:'data', snapshot: hot.getData().map(r=>[...r]) }); redoStack=[];
    hot.alter('insert_row_below', hot.countRows()-1);
    showToast('➕ Baris baru ditambahkan','toast-success');
}
function addColRight() {
    const name = prompt('Nama kolom baru:', `Kolom ${extraColCount+1}`);
    if (!name) return;
    extraColHeaders.push(name); extraColCount++;
    hot.updateSettings({ nestedHeaders: buildNestedHeaders(), columns: buildColumns() });  // ← JADI INI
    showToast(`➕ Kolom "${name}" ditambahkan`,'toast-success');
}

function toggleFullscreen() {
    const w = document.getElementById('masterSpreadsheet');
    const going = !w.classList.contains('fullscreen-mode');
    w.classList.toggle('fullscreen-mode');
    if (going) { setTimeout(() => { if(hot) hot.render(); }, 150); }
    else { requestAnimationFrame(() => requestAnimationFrame(() => { if(hot){ hot.render(); setTimeout(()=>hot.render(),100); } })); }
}

function setLoading(state, label='Memuat data…') {
    document.getElementById('loadingOverlay').classList.toggle('active', state);
    document.getElementById('loadingLabel').textContent = label;
}

function showToast(msg, type='toast-info') {
    const t = document.getElementById('csToast');
    t.textContent = msg; t.className = `cs-toast ${type} show`;
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.classList.remove('show'), 3200);
}
// ─── FUNGSI MODAL EXPORT EXCEL ───────────────────────────────────
function bukaModalExport() {
    const tanggalList = [<?php foreach($list_tanggal as $tgl) echo '"'.$tgl.'",'; ?>];
    const bulanSet = new Set();
    tanggalList.forEach(t => { if(t) bulanSet.add(t.substring(0,7)); });
    const bulanArr = [...bulanSet].sort().reverse(); 

    const bulanNama = {'01':'Januari','02':'Februari','03':'Maret','04':'April','05':'Mei','06':'Juni','07':'Juli','08':'Agustus','09':'September','10':'Oktober','11':'November','12':'Desember'};
    function labelBulan(ym) {
        const [y,m] = ym.split('-');
        return `${bulanNama[m]||m} ${y}`;
    }

    ['exportDari','exportSampai'].forEach(id => {
        const sel = document.getElementById(id);
        sel.innerHTML = '';
        bulanArr.forEach(bln => {
            const opt = document.createElement('option');
            opt.value = bln;
            opt.textContent = labelBulan(bln);
            sel.appendChild(opt);
        });
    });
    if (bulanArr.length >= 3) document.getElementById('exportDari').value = bulanArr[Math.min(2, bulanArr.length-1)];
    updateExportPreview();

    document.getElementById('exportDari').addEventListener('change', updateExportPreview);
    document.getElementById('exportSampai').addEventListener('change', updateExportPreview);
    document.getElementById('exportModal').classList.add('active');
}

function updateExportPreview() {
    const dari   = document.getElementById('exportDari').value;
    const sampai = document.getElementById('exportSampai').value;
    const tanggalList = [<?php foreach($list_tanggal as $tgl) echo '"'.$tgl.'",'; ?>];

    if (!dari || !sampai) return;
    const d = dari < sampai ? dari : sampai;
    const s = dari < sampai ? sampai : dari;

    const cocok = tanggalList.filter(t => t >= d+'-01' && t <= s+'-31');
    document.getElementById('exportPreviewInfo').textContent =
        cocok.length
            ? `📋 Ditemukan ${cocok.length} tanggal data dalam rentang ${d} s/d ${s}. Setiap tanggal = 1 sheet di Excel.`
            : `⚠️ Tidak ada data dalam rentang ${d} s/d ${s}.`;
}

function tutupModalExport() {
    document.getElementById('exportModal').classList.remove('active');
}

function prosesExport() {
    let dari   = document.getElementById('exportDari').value;
    let sampai = document.getElementById('exportSampai').value;
    if (!dari || !sampai) { showToast('⚠️ Pilih rentang bulan','toast-warning'); return; }

    if (dari > sampai) { [dari, sampai] = [sampai, dari]; }

    const btn = document.getElementById('btnExportConfirm');
    btn.disabled = true;
    btn.textContent = '⏳ Menyiapkan file…';

    window.location.href = `<?= base_url('index.php/cs/api_cs_export') ?>?dari=${dari}&sampai=${sampai}`;

    setTimeout(() => {
        btn.disabled = false;
        btn.textContent = '⬇️ Download Excel History';
        tutupModalExport();
        showToast('✅ File export sedang diunduh','toast-success');
    }, 2500);
}
</script>