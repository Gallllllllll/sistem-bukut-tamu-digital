<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Statistik Buku Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container py-5">

    <!-- Judul -->
    <h1 class="mb-4 text-center fw-bold">📊 Statistik Buku Tamu</h1>

    <!-- Ringkasan -->
    <div class="row mb-4 justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Tamu</h6>
                    <h2 class="text-primary fw-bold">
                        {{ $tamuPerHari->sum('jumlah') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-semibold">
            Jumlah Tamu per Hari
        </div>
        <div class="card-body">
            <canvas id="tamuChart" height="120"></canvas>
        </div>
    </div>

    <!-- Tombol kembali -->
    <div class="text-center mt-4">
        <a href="{{ route('tamus.index') }}" class="btn btn-secondary">
            ⬅️ Kembali ke Daftar Tamu
        </a>
    </div>
</div>

<script>
    const labels = {!! json_encode($tamuPerHari->pluck('tanggal')) !!};
    const dataJumlah = {!! json_encode($tamuPerHari->pluck('jumlah')) !!};

    new Chart(document.getElementById('tamuChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Tamu',
                data: dataJumlah,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
