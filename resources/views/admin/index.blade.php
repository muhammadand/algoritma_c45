@extends('app')

@section('content')
<div class="container mt-4">
    <div class="row">
        {{-- Statistik Utama --}}
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Obat</h5>
                    <p class="card-text display-6">{{ $totalObat }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total User</h5>
                    <p class="card-text display-6">{{ $totalUser }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Obat --}}
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Daftar Obat</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Satuan</th>
                        <th>Kuantitas</th>
                        <th>Jenis Penyakit</th>
                        <th>Klasifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataObat as $obat)
                        <tr>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->satuan }}</td>
                            <td>{{ $obat->kuantitas }}</td>
                            <td>{{ $obat->jenis_penyakit }}</td>
                            <td>{{ $obat->klasifikasi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Navigasi Halaman Obat --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $dataObat->appends(['user_page' => request('user_page')])->links() }}
            </div>
        </div>
    </div>

    {{-- Tabel Data User --}}
    <div class="card mt-4">
        <div class="card-header bg-success text-white">Daftar User</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataUser as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Navigasi Halaman User --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $dataUser->appends(['obat_page' => request('obat_page')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
