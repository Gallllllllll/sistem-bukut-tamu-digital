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
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            background-color: #8b0000;
            color: white;
            padding-top: 20px;
            position: fixed;
            width: 230px;
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

        .content {
            margin-left: 240px;
            padding: 30px;
        }

        /* Tab style */
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #555;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            border-bottom: 3px solid #0d6efd;
            color: #0d6efd;
            font-weight: 600;
        }

        canvas {
        max-height: 300px !important;
        }

        .navbar-custom {
            background-color: white;
            border-bottom: 1px solid #ddd;
            padding: 10px 20px;
            position: sticky;
            z-index: 1050;
            top: 0;
        }
        .navbar-custom h4 {
            margin: 0;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: sticky;
                top: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #8b0000;
                flex-wrap: wrap;
                gap: 10px;
                padding: 10px;
                z-index: 1050;
                box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            }

            .sidebar h4 {
                display: none;
            }

            .sidebar a {
                display: inline-block;
                padding: 8px 15px;
                border-radius: 6px;
                background-color: #a52a2a;
                font-size: 0.9rem;
            }

            .navbar-custom {
                position: sticky; 
                top: 60px;
                z-index: 1010;
                flex-direction: column;
                align-items: flex-start !important;
                gap: 8px;
            }

            .content {
                margin: 0 auto;          
                padding: 20px;
                max-width: 600px;        
                text-align: center;       
            }

            .card {
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                border-radius: 12px;
            }

            canvas {
                max-width: 100% !important;
                height: auto !important;
            }
        }

    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="text-center mb-4">
            <h4 class="fw-bold">📚 E-Library</h4>
        </div>
        <a href="{{ route('tamus.index') }}">📖 Daftar Tamu</a>
        <a href="{{ route('tamus.statistik') }}" class="active">📊 Statistik</a>
        <a href="{{ url('/logout') }}">🚪 Logout</a>
    </div>

    {{-- Main Content --}}
    <div class="content">
        <div class="navbar-custom d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">⬅️ Kembali</a>
            <h4 class="m-0 text-center flex-grow-1 fw-bold">📊 Statistik Tamu</h4>
        </div>

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
        </ul>

        {{-- Isi Tab --}}
        <div class="tab-content" id="statistikTabsContent">
            {{-- Tab: Keseluruhan --}}
            <div class="tab-pane fade show active" id="keseluruhan" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Jumlah Tamu per Hari</div>
                    <div class="card-body">
                        <canvas id="tamuPerHariChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Tab: Aktivitas --}}
            <div class="tab-pane fade" id="aktivitas" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Jumlah Tamu per Aktivitas</div>
                    <div class="card-body">
                        <canvas id="tamuPerAktivitasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Script untuk grafik --}}
<script>
    const tamuPerHari = {!! json_encode($tamuPerHari) !!};
    const tamuPerAktivitas = {!! json_encode($tamuPerAktivitas) !!};

    // Grafik per hari
    new Chart(document.getElementById('tamuPerHariChart'), {
        type: 'bar',
        data: {
            labels: tamuPerHari.map(item => item.tanggal),
            datasets: [{
                label: 'Jumlah Tamu',
                data: tamuPerHari.map(item => item.jumlah),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
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
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
