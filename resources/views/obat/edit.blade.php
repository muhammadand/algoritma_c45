@extends('app')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-primary mb-4">Edit Obat</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_obat" class="form-label">Nama Obat</label>
                    <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                    @error('nama_obat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ old('satuan', $obat->satuan) }}" required>
                    @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kuantitas" class="form-label">Kuantitas</label>
                    <input type="number" class="form-control @error('kuantitas') is-invalid @enderror" name="kuantitas" value="{{ old('kuantitas', $obat->kuantitas) }}" required>
                    @error('kuantitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_penyakit" class="form-label">Jenis Penyakit</label>
                    <input type="text" class="form-control @error('jenis_penyakit') is-invalid @enderror" name="jenis_penyakit" value="{{ old('jenis_penyakit', $obat->jenis_penyakit) }}" required>
                    @error('jenis_penyakit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
