<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label for="name">Nama</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
    </div>
    <div>
        <label fo@extends('tamus.app')

@section('content')
    <div class="container">
        <h2>Daftar Pengguna Baru</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control">
                @error('name') 
                    <div class="alert alert-danger">{{ $message }}</div> 
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control">
                @error('email') 
                    <div class="alert alert-danger">{{ $message }}</div> 
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required class="form-control">
                @error('password') 
                    <div class="alert alert-danger">{{ $message }}</div> 
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control">
                @error('password_confirmation') 
                    <div class="alert alert-danger">{{ $message }}</div> 
                @enderror
            </div>

            <!-- Button Daftar -->
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>
@endsection
r="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>
    <button type="submit">Daftar</button>
</form>
