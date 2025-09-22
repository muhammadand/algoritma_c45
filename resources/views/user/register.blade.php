<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Website Desa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-blue-50 min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white shadow-xl rounded-xl flex flex-col md:flex-row overflow-hidden max-w-4xl w-full">
        <!-- Logo / Info Section -->
        <div class="bg-blue-600 text-white flex flex-col justify-center items-center p-8 md:w-1/2">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Desa" class="w-28 h-28 rounded-full mb-4 border-4 border-white shadow-lg">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang!</h2>
            <p class="text-center text-blue-100">Silakan buat akun untuk dapat mengakses layanan dan informasi dari website desa.</p>
        </div>

        <!-- Form Section -->
        <div class="p-8 md:w-1/2">
            <h1 class="text-2xl font-semibold text-blue-800 text-center mb-6">Buat Akun Baru</h1>

            @if($errors->any())
                @foreach($errors->all() as $err)
                    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-2 text-sm">{{ $err }}</div>
                @endforeach
            @endif

            <form action="{{ route('register.action') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name -->
                <div class="flex items-center border rounded px-3 py-2 focus-within:ring-2 focus-within:ring-blue-300">
                    <i class="fas fa-user text-gray-500 mr-2"></i>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap"
                           class="w-full border-none outline-none text-gray-700" required>
                </div>

                <!-- Username -->
                <div class="flex items-center border rounded px-3 py-2 focus-within:ring-2 focus-within:ring-blue-300">
                    <i class="fas fa-envelope text-gray-500 mr-2"></i>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Username"
                           class="w-full border-none outline-none text-gray-700" required>
                </div>

                <!-- Password -->
                <div class="flex items-center border rounded px-3 py-2 focus-within:ring-2 focus-within:ring-blue-300">
                    <i class="fas fa-lock text-gray-500 mr-2"></i>
                    <input type="password" name="password" placeholder="Kata sandi"
                           class="w-full border-none outline-none text-gray-700" required>
                </div>

                <!-- Konfirmasi Password -->
                <div class="flex items-center border rounded px-3 py-2 focus-within:ring-2 focus-within:ring-blue-300">
                    <i class="fas fa-lock text-gray-500 mr-2"></i>
                    <input type="password" name="password_confirm" placeholder="Konfirmasi kata sandi"
                           class="w-full border-none outline-none text-gray-700" required>
                </div>

                <!-- Role -->
                <input type="hidden" name="role" value="admin">


                <!-- Buttons -->
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded shadow">
                    Daftar Akun
                </button>

                <div class="text-center mt-2">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Sudah punya akun? Masuk</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
