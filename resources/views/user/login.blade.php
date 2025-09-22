<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Website Early</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-200 via-blue-100 to-white min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8 relative">
        {{-- Logo Desa --}}
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Desa" class="h-24 w-24 rounded-full shadow-md border-4 border-blue-300">
        </div>

        <h2 class="text-2xl font-bold text-center text-blue-800 mb-6">Selamat Datang di Website Early</h2>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-2">{{ $error }}</div>
            @endforeach
        @endif

        <form method="POST" action="{{ route('login.action') }}" class="space-y-4">
            @csrf

            <div class="flex items-center border rounded px-3 py-2 focus-within:ring-2 focus-within:ring-blue-400">
                <i class="fas fa-user text-gray-500 mr-2"></i>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Username"
                       class="w-full border-none outline-none text-gray-700" required>
            </div>

            <div class="flex items-center border rounded px-3 py-2 focus-within:ring-2 focus-within:ring-blue-400">
                <i class="fas fa-lock text-gray-500 mr-2"></i>
                <input type="password" name="password" placeholder="Password"
                       class="w-full border-none outline-none text-gray-700" required>
            </div>

            <div class="flex justify-between items-center text-sm">
                <a href="{{ route('password') }}" class="text-blue-600 hover:underline">Lupa password?</a>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded shadow">
                Masuk
            </button>

            <a href="{{ route('register') }}"
               class="w-full block text-center border border-blue-500 text-blue-600 font-semibold py-2 rounded hover:bg-blue-50 mt-2">
                Daftar Akun
            </a>
        </form>
    </div>

</body>
</html>
