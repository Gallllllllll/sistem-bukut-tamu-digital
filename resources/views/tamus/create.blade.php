<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tamu Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("{{ asset('images/bg-pattern.png') }}"); 
            background-size: cover;        
            background-position: center;   
            background-repeat: no-repeat;
            backdrop-filter: blur(2px);
            min-height: 100vh;
        }
        .welcome-text {
            text-align: center;
            color: #333;
            margin-top: 60px;
            margin-bottom: 25px;
        }
        .welcome-text h2 {
            font-weight: 700;
            color: #223a59;
        }
        .welcome-text p {
            font-size: 1.1rem;
            color: #555;
        }
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 25px 8px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.95);
        }
        .card-header {
            background: linear-gradient(135deg, #223a59, #3a506b);
            color: white;
            text-align: center;
        }
        .btn-primary {
            background-color: #223a59;
            border: none;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: #a20a0a;
        }
        .top-right {
            position: absolute;
            top: 20px;
            right: 25px;
            color: white;
            border: 1pt;
            border-radius: 10px;
            border-color: white;
        }
        .top-right:hover {
            color: white;
        }
        .btn-danger{
            background-color: #a20a0a;
        }
        .btn-danger:hover{            
            background-color:#223a59;
            border-color: #223a59;
        }
        .btn-success:hover{            
            background-color:#223a59;
            border-color: #223a59;
        }     

        @media (max-width: 768px) {
            .welcome-text {
                margin-top: 90px;
            }
        }
    </style>
</head>
<body>

    <!-- 🔐 Tombol Login di pojok kiri atas -->
    <div class="top-right d-flex gap-2 p-2">
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                🔐 Login Administrator
            </a>
            <!-- Tombol untuk registrasi dan login -->
            <a href="{{ route('register') }}" class="btn btn-primary">Daftar Akun</a>
            <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>

        @else
            <a href="{{ route('tamus.index') }}" class="btn btn-success btn-sm">
                📋 Dashboard Admin
            </a>
            <a href="{{ route('logout') }}" class="btn btn-danger btn-sm">
                🚪 Logout
            </a>
        @endguest
    </div>


    <div class="container py-5">
        <!-- 🏷️ Tulisan Selamat Datang -->
        <div class="welcome-text">
            <h2>📚 Selamat Datang di E-Library Kami</h2>
            <p>Isi buku tamu digital untuk mencatat kunjunganmu hari ini! ✨</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">➕ Tambah Tamu Baru</h4>
                    </div>
                    <div class="card-body">

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            🎉 Terima kasih sudah berkunjung! Data kamu berhasil disimpan. 
                            Semoga harimu menyenangkan di perpustakaan kami 📚✨
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('tamus.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div class="mb-3">
                                <label for="instansi" class="form-label">Instansi</label>
                                <input type="text" name="instansi" id="instansi" class="form-control" placeholder="Masukkan asal instansi atau sekolah" required>
                            </div>

                            <div class="mb-3">
                                <label for="tujuan" class="form-label">Tujuan Kunjungan</label>
                                <select name="tujuan" id="tujuan" class="form-select" required>
                                    <option value="">-- Pilih Tujuan --</option>
                                    <option value="Membaca">Membaca</option>
                                    <option value="Meminjam Buku">Meminjam Buku</option>
                                    <option value="Mengembalikan Buku">Mengembalikan Buku</option>
                                    <option value="Mencari Referensi">Mencari Referensi</option>
                                    <option value="Diskusi/Belajar Kelompok">Diskusi / Belajar Kelompok</option>
                                    <option value="Menggunakan Fasilitas (Komputer/Internet)">Menggunakan Fasilitas (Komputer/Internet)</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">💾 Simpan Tamu</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert-success');
        if (alert) alert.remove();
    }, 3000);

    @if(session('success'))
        document.querySelector('form').reset();
    @endif

   




</script>

<!-- resources/views/home.blade.php -->




</body>
</html>
