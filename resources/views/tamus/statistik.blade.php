<!DOCTYPE html>
<html>
<head>
    <title>Statistik Buku Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Statistik Buku Tamu</h1>

    <!-- Ringkasan -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Tamu</h5>
                    <p class="card-text display-4">{{ $tamuPerHari->sum('jumlah') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Jumlah Tamu per Hari</h5>
            <canvas id="tamuChart" height="100"></canvas>
        </div>
    </div>
</div>

<script>
    const labels = {!! json_encode($tamuPerHari->pluck('tanggal')) !!};
    const dataJumlah = {!! json_encode($tamuPerHari->pluck('jumlah')) !!};

    const ctx = document.getElementById('tamuChart').getContext('2d');
    const tamuChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Tamu',
                data: dataJumlah,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>
