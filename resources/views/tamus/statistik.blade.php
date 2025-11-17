<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Statistik Buku Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            font-family: "Poppins", sans-serif;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            height: 100vh;
            background-color: #8b0000;
            color: white;
            padding-top: 80px;
            position: fixed;
            top: 0;
            left: 0;
            width: 230px;
            z-index: 2000;
            transition: transform 0.3s ease;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #a52a2a;
            border-radius: 8px;
        }

        .sidebar.hidden {
            transform: translateX(-230px);
        }

        /* ===== OVERLAY ===== */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1500;
            display: none;
        }
        .overlay.show {
            display: block;
        }

        /* ===== TOPBAR ===== */
        .navbar-custom {
            background-color: white;
            border-bottom: 1px solid #ddd;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 2500;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-custom h4 {
            margin: 0;
            font-weight: 600;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #8b0000;
            cursor: pointer;
            margin-right: 15px;
        }

        /* ===== MAIN CONTENT ===== */
        .content {
            margin-left: 240px;
            padding: 100px 20px 40px;
            transition: margin-left 0.3s ease;
        }

        .content.full {
            margin-left: 0;
        }

        /* ===== CHART AREA ===== */
        .chart-keseluruhan canvas, #tamuPerAktivitasChart {
            width: 100% !important;
            height: 420px !important;
            display: block;
            margin: 0 auto;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-230px);
                position: fixed;
                width: 230px;
                top: 0;
                left: 0;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
                padding: 80px 20px;
            }

            .chart-keseluruhan {
                height: 350px;
            }
        }
    </style>
</head>
<body>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Navbar -->
    <div class="navbar-custom">
        <button class="toggle-btn" id="toggleBtn">☰</button>
        <h4 class="fw-bold text-danger">📚 E-Library</h4>
        <h4 class="m-0 text-center flex-grow-1 fw-bold">📊 Statistik Tamu</h4>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('tamus.index') }}">📖 Daftar Tamu</a>
        <a href="{{ route('tamus.statistik') }}" class="active">📊 Statistik</a>
        <a href="{{ url('/logout') }}">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content" id="main">
        {{-- Ringkasan total --}}
        <div class="row text-center mb-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3">
                    <h5>Total Keseluruhan</h5>
                    <h2 class="text-primary">{{ $totalTamu }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3">
                    <h5>Bulan Ini</h5>
                    <h2 class="text-success">{{ $totalBulanIni }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3">
                    <h5>Hari Ini</h5>
                    <h2 class="text-warning">{{ $totalHariIni }}</h2>
                </div>
            </div>
        </div>

        {{-- Tab Navigasi --}}
        <ul class="nav nav-tabs mb-4" id="statistikTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="keseluruhan-tab" data-bs-toggle="tab" data-bs-target="#keseluruhan" type="button" role="tab">
                    Statistik Keseluruhan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="aktivitas-tab" data-bs-toggle="tab" data-bs-target="#aktivitas" type="button" role="tab">
                    Statistik Aktivitas
                </button>
            </li>
                  <div class="mb-3">
                        <button class="btn btn-success" onclick="exportStats()">Export Statistik</button>
                    </div>
                    <button class="btn btn-success" onclick="exportToPDF()">Export PDF</button>

           
        </ul>
  

        {{-- Isi Tab --}}
        <div class="tab-content" id="statistikTabsContent">
            {{-- Tab: Keseluruhan --}}
            <div class="tab-pane fade show active" id="keseluruhan" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Jumlah Tamu per Hari</div>
                    <div class="card-body chart-keseluruhan" style="padding: 30px 20px;">
                        <canvas id="tamuPerHariChart" style="width: 100%; height: 400px !important;"></canvas>
                    </div>
                </div>
            </div>

            {{-- Tab: Aktivitas (versi awal - tetap seperti semula) --}}
            <div class="tab-pane fade" id="aktivitas" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Jumlah Tamu per Aktivitas</div>
                    <div class="card-body">
                        <canvas id="tamuPerAktivitasChart" style="max-height: 300px !important;"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Chart --}}
    <script>
        const tamuPerHari = {!! json_encode($tamuPerHari) !!};
        const tamuPerAktivitas = {!! json_encode($tamuPerAktivitas) !!};

        // Grafik per hari (dibesarkan)
        new Chart(document.getElementById('tamuPerHariChart'), {
            type: 'bar',
            data: {
                labels: tamuPerHari.map(item => item.tanggal),
                datasets: [{
                    label: 'Jumlah Tamu',
                    data: tamuPerHari.map(item => item.jumlah),
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // Grafik per aktivitas (asli, tidak diubah)
        new Chart(document.getElementById('tamuPerAktivitasChart'), {
            type: 'pie',
            data: {
                labels: tamuPerAktivitas.map(item => item.aktivitas),
                datasets: [{
                    label: 'Jumlah Tamu',
                    data: tamuPerAktivitas.map(item => item.jumlah),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.8)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'right' } }
            }
        });
    </script>

    {{-- Script Sidebar --}}
    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const main = document.getElementById('main');

        toggleBtn.addEventListener('click', () => {
            if (window.innerWidth > 992) {
                sidebar.classList.toggle('hidden');
                main.classList.toggle('full');
            } else {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Chart -->
    <script>
        const tamuPerHari = {!! json_encode($tamuPerHari) !!};
        const tamuPerAktivitas = {!! json_encode($tamuPerAktivitas) !!};

        // Grafik per hari (dibesarkan)
        new Chart(document.getElementById('tamuPerHariChart'), {
            type: 'bar',
            data: {
                labels: tamuPerHari.map(item => item.tanggal),
                datasets: [{
                    label: 'Jumlah Tamu',
                    data: tamuPerHari.map(item => item.jumlah),
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // Grafik per aktivitas
        new Chart(document.getElementById('tamuPerAktivitasChart'), {
            type: 'pie',
            data: {
                labels: tamuPerAktivitas.map(item => item.aktivitas),
                datasets: [{
                    label: 'Jumlah Tamu',
                    data: tamuPerAktivitas.map(item => item.jumlah),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.8)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'right' } }
            }
        });

        //
        const tamuPerAktivitas = {!! json_encode($tamuPerAktivitas) !!};

new Chart(document.getElementById('tamuPerAktivitasChart'), {
    type: 'pie',
    data: {
        labels: tamuPerAktivitas.map(item => item.aktivitas),
        datasets: [{
            label: 'Jumlah Tamu',
            data: tamuPerAktivitas.map(item => item.jumlah),
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
            ],
            borderColor: 'rgba(255, 255, 255, 0.8)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'right' } }
    }
});

    </script>

    <!-- Script untuk Export Statistik -->
    <script>
        function exportStats() {
            let data = getDataForExport();
            let csvContent = "data:text/csv;charset=utf-8," + data;
            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "statistik_tamu.csv");
            link.click();
        }

        function getDataForExport() {
            let data = "Nama Aktivitas, Jumlah Tamu\n";
            
            tamuPerAktivitas.forEach(item => {
                data += `${item.aktivitas}, ${item.jumlah}\n`;
            });
            
            return data;
        }

//
        function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Menambahkan margin
    doc.setMargins(10, 10, 10, 10);
    
    // Menambahkan judul
    doc.setFont("helvetica", "bold");
    doc.setFontSize(16);
    doc.text("Statistik Tamu E-Library", 10, 20);
    
    // Menangkap gambar dari canvas dan menambahkannya ke PDF
    const canvas = document.getElementById('tamuPerAktivitasChart');
    const imgData = canvas.toDataURL('image/png'); // Mengonversi canvas ke gambar PNG

    doc.addImage(imgData, 'PNG', 10, 30, 180, 100); // Menambahkan gambar ke PDF

    // Menambahkan CSV Data
    const dataCSV = getDataForExport(); // Mendapatkan data CSV
    doc.setFontSize(12);
    doc.text("Data CSV Aktivitas Tamu:", 10, 140);
    doc.text(dataCSV, 10, 150);

    // Menyimpan PDF
    doc.save('statistik_tamu.pdf');
}


    </script>

    

</body>
</html>