@extends('app')

@section('content')
<div class="page-inner">
    <h1 class="text-2xl font-bold mb-4">Tambah User</h1>

    @if ($errors->any())
        <div class="alert alert-danger p-3 mb-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="form-group mb-4">
            <label for="name" class="block font-bold">Nama</label>
            <input type="text" name="name" class="form-control w-full p-2 border rounded"
                   value="{{ old('name') }}" required>
        </div>

        <div class="form-group mb-4">
            <label for="username" class="block font-bold">Username</label>
            <input type="text" name="username" class="form-control w-full p-2 border rounded"
                   value="{{ old('username') }}" required>
        </div>

        <div class="form-group mb-4">
            <label for="role" class="block font-bold">Role <span class="text-red-500">*</span></label>
            <select name="role" class="form-control w-full p-2 border rounded" required>
                <option value="marketing" {{ old('role') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
            </select>
        </div>

        <div class="form-group mb-4">
            <label for="password" class="block font-bold">Password</label>
            <input type="password" name="password" class="form-control w-full p-2 border rounded" required>
        </div>

        <div class="form-group mb-4">
            <label for="password_confirmation" class="block font-bold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control w-full p-2 border rounded" required>
        </div>

        <div class="form-group flex space-x-2">
            <button type="submit" class="btn btn-label-primary btn-round btn-sm">
                Simpan
            </button>
            <a href="{{ route('user.index') }}" class="btn btn-label-secondary btn-round btn-sm">
                Kembali
            </a>
       
        </div>
    </form>
  
</div>
@endsection
