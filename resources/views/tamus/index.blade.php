<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Daftar Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .navbar-custom h4 {
            margin: 0;
            font-weight: 600;
            flex-grow: 1;
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
        .main-content {
            margin-left: 240px;
            padding: 80px 20px 20px;
            transition: margin-left 0.3s ease;
        }

        .main-content.full {
            margin-left: 0;
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

            .main-content {
                margin-left: 0;
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
        <h4 class="center flex-grow-1 fw-bold">📖 Daftar Tamu</h4>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('tamus.index') }}" class="active">📖 Daftar Tamu</a>
        <a href="{{ route('tamus.statistik') }}">📊 Statistik</a>
        <a href="{{ url('/logout') }}">🚪 Logout</a>
    </div>
    

    <!-- Main Content -->
    <div class="main-content" id="main">
        {{-- Tombol aksi --}}
        <div class="mb-3 d-flex flex-wrap gap-2">
            <a href="{{ route('tamus.create') }}" class="btn btn-primary">➕ Tambah Tamu Baru</a>
            <a href="{{ route('tamus.exportExcel') }}" class="btn btn-success">⬇️ Export Excel</a>
            <a href="{{ route('tamus.exportPDF') }}" class="btn btn-danger">⬇️ Export PDF</a>
        </div>

        {{-- Form pencarian --}}
        <form method="GET" action="{{ route('tamus.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama / instansi / tanggal"
                       value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tabel tamu --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>Tujuan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tamus as $index => $tamu)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tamu->nama }}</td>
                            <td>{{ $tamu->instansi }}</td>
                            <td>{{ $tamu->tujuan }}</td>
                            <td>{{ $tamu->created_at->format('d M Y H:i') }}</td>

                            
                            <td>
                               
                                <a href="{{ route('tamus.edit', $tamu->id) }}" class="btn btn-warning btn-sm">Update</a>

                                <form action="{{ route('tamus.destroy', $tamu->id) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('main');
        const overlay = document.getElementById('overlay');

        toggleBtn.addEventListener('click', () => {
            if (window.innerWidth > 992) {
                // Desktop mode
                sidebar.classList.toggle('hidden');
                main.classList.toggle('full');
            } else {
                // Mobile mode
                
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        // Tidak auto buka/tutup saat resize
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
