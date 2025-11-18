<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
    </div>
    <div>
        <label for="name">Nama</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
    </div>
    <div>
        <label for="email">Email</label>
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
