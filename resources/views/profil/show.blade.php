@extends('app')

@section('content')
<div class="container-fluid" style="margin-top: 40px;">
    <div class="row justify-content-center">
        <!-- Ubah ukuran kolom menjadi col-lg-6 atau sesuai kebutuhan -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg rounded" style="background-color: #fff; padding: 20px;">
                <div class="card-body p-4">
                    <!-- Profile Image Section -->
                    <div class="text-center mb-4">
                        @if($profil->foto)
                            <img src="{{ asset('storage/' . $profil->foto) }}" alt="Foto Profil" 
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: 4px solid #f0f0f0;">
                        @else
                            <div style="width: 100px; height: 100px; background-color: #ddd; font-size: 24px; color: #555; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Username and User Status -->
                    <h2 class="text-center" style="font-size: 24px; font-weight: 700; margin-top: 20px; color: #333;">{{ Auth::user()->username }}</h2>
                    <p class="text-center" style="font-size: 14px; color: #777;">Pengguna Terdaftar</p>

                    <hr style="border-top: 1px solid #eaeaea; margin-top: 20px; margin-bottom: 20px;">

                    <!-- Address and Birthdate Information -->
                    <div class="mb-4" style="font-size: 16px; color: #555;">
                        <div class="mb-3">
                            <strong>Alamat:</strong>
                            <p>{{ $profil->alamat }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Tanggal Lahir:</strong>
                            <p>{{ \Carbon\Carbon::parse($profil->tanggal_lahir)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Edit Profile Button -->
                    <div class="text-center mt-4">
                        <a href="{{ route('profil.edit', Auth::id()) }}" class="btn btn-label-warning px-3 py-2" style="padding: 12px 25px; font-size: 16px; border-radius: 25px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-decoration: none;">
                            <i class="bi bi-pencil" style="margin-right: 5px;"></i> 
                            Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
