<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Antrean Supir</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0b1c2c;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #f1c40f;
            font-size: 3em;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
            font-size: 1.5em;
            background-color: #1a2a3a;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        th,
        td {
            border: 1px solid #2c3e50;
            padding: 20px;
            text-align: center;
        }

        th {
            background-color: #176B87;
            color: #ecf0f1;
            font-size: 1.2em;
        }

        tr:nth-child(even) {
            background-color: #223141;
        }

        .text-bold {
            font-weight: bold;
            font-size: 1.2em;
            letter-spacing: 2px;
        }

        .status-loading {
            color: #f39c12;
            font-weight: bold;
        }

        .status-finish {
            color: #2ecc71;
            font-weight: bold;
        }

        .status-cancel {
            color: #e74c3c;
            font-weight: bold;
        }

/* Efek Transisi Fade pada Tabel */
#tableBody {
    transition: opacity 0.25s ease-in-out;
    opacity: 1;
}

/* Class saat transisi menghilang */
.fade-out {
    opacity: 0 !important;
}
    </style>
</head>

<body>

    <h1>🖥️ WAREHOUSE DISPLAY - LOADING DOCK</h1>

    <table>
        <thead>
            <tr>
                <th>No Loading Dock</th>
                <th style="display: none;">Kedatangan</th>
                <th>Nama Sopir</th>
                <th>No. Pol. Truck</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>

    <p style="margin-top: 30px; color: #7f8c8d;">🔴 Live Sync: Data diperbarui otomatis.</p>

    <script>
        // State global
let allTruckData = [];
let currentPage = 0;
const rowsPerPage = 3; 
const pageSwitchInterval = 5000; // Ganti halaman tiap 5 detik

// 1. Ambil data dari backend di latar belakang (Setiap 3 detik)
function fetchLiveMonitor() {
    fetch('<?= base_url('index.php/monitor/data') ?>', {
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(response => response.json())
    .then(data => {
        // Cek apakah data benar-benar berubah? Jika sama, jangan render ulang agar tidak ngeblink
        if (JSON.stringify(allTruckData) !== JSON.stringify(data)) {
            allTruckData = data;
            
            // Validasi jika jumlah data berkurang agar page tidak overheat
            const maxPage = Math.ceil(allTruckData.length / rowsPerPage) - 1;
            if (currentPage > maxPage) {
                currentPage = 0;
            }
            
            // Render pertama kali atau saat ada perubahan data nyata dari database
            renderTable(false); 
        }
    })
    .catch(error => console.error("Gagal menarik data:", error));
}

// 2. Fungsi Render Tabel dengan parameter Kendali Animasi (withAnimation)
function renderTable(withAnimation = true) {
    const tbody = document.getElementById('tableBody');

    // Jika butuh animasi (saat pindah halaman), jalankan efek fade
    if (withAnimation) {
        tbody.classList.add('fade-out');
        
        // Tunggu fade out selesai (250ms), baru ganti datanya
        setTimeout(() => {
            executeRender(tbody);
            tbody.classList.remove('fade-out'); // Fade In kembali
        }, 250);
    } else {
        // Jika hanya sinkronisasi data background biasa, langsung ganti tanpa kedipan animasi
        executeRender(tbody);
    }
}

// Manipulasi DOM murni dipisahkan agar bisa dikontrol oleh fungsi render di atas
function executeRender(tbody) {
    tbody.innerHTML = ''; 

    if (allTruckData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" style="color: #7f8c8d; padding: 40px;">Tidak ada antrean saat ini</td></tr>`;
        return;
    }

    const startIndex = currentPage * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const pageData = allTruckData.slice(startIndex, endIndex);

    pageData.forEach(row => {
        let statusClass = '';
        const displayStatus = row.status ? row.status.trim() : 'WAITING'; 

        if (displayStatus === 'Loading') statusClass = 'status-loading';
        else if (displayStatus === 'Finish') statusClass = 'status-finish';
        else if (displayStatus === 'Cancel') statusClass = 'status-cancel';
        else statusClass = 'status-loading'; 

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="font-size: 1.5em; font-weight: bold; color: #3498db;">${row.dock || '-'}</td>
            <td style="display: none;" data-kedatangan="${row.kedatangan}">${row.kedatangan}</td>
            <td class="text-bold">${row.sopir || '-'}</td>
            <td class="text-bold">${row.plat}</td>
            <td class="${statusClass}">${displayStatus.toUpperCase()}</td>
        `;
        tbody.appendChild(tr);
    });
}

// 3. Loop Interval Khusus Pindah Halaman Otomatis (Hanya ini yang memicu Animasi)
setInterval(() => {
    if (allTruckData.length > 0) {
        const totalPages = Math.ceil(allTruckData.length / rowsPerPage);
        
        // Hanya pindah halaman jika total halaman lebih dari 1
        if (totalPages > 1) {
            currentPage = (currentPage + 1) % totalPages; 
            renderTable(true); // <--- TRUE: Picu transisi fade yang smooth saat ganti page
        }
    }
}, pageSwitchInterval);

// Eksekusi Awal saat TV menyala
fetchLiveMonitor();
setInterval(fetchLiveMonitor, 3000); // Cek update data ke DB tiap 3 detik secara silent
    </script>
</body>

</html>