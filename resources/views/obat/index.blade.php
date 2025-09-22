@extends('app')

@section('content')
<div class="container mt-4">
<!-- Header -->
<div class="bg-light p-4 rounded shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h2 class="fw-bold text-primary mb-0">Manajemen Data Obat</h2>

        <!-- Statistik Jumlah Klasifikasi -->
        @php
            $totalKritis = \App\Models\Obat::where('klasifikasi', 'Kritis')->count();
            $totalRestok = \App\Models\Obat::where('klasifikasi', 'Perlu Restok')->count();
            $totalAman = \App\Models\Obat::where('klasifikasi', 'Aman')->count();
        @endphp
        <div class="d-flex gap-3 flex-wrap">
            <span class="badge bg-danger">Kritis: {{ $totalKritis }}</span>
            <span class="badge bg-warning text-dark">Perlu Restok: {{ $totalRestok }}</span>
            <span class="badge bg-success">Aman: {{ $totalAman }}</span>
        </div>
    </div>
</div>
<section class="border rounded p-3 mb-4 shadow-sm">
    <div class="d-flex flex-wrap gap-2 justify-content-start align-items-center">
        <!-- Tambah -->
        <a href="{{ route('obat.create') }}" class="btn btn-outline-primary btn-sm">
            Tambah Obat
        </a>

        <!-- Import -->
        <form action="{{ route('obat.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="file" class="form-control form-control-sm" required>
            <button type="submit" class="btn btn-outline-success btn-sm">Import</button>
        </form>

        <!-- Klasifikasi -->
        <form action="{{ route('obat.klasifikasi') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-warning btn-sm">Klasifikasikan C4.5</button>
        </form>

        <!-- Filter -->
        <form method="GET" action="{{ route('obat.index') }}" class="d-flex align-items-center gap-2">
            <select name="filter" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- Semua Klasifikasi --</option>
                <option value="Kritis" {{ request('filter') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                <option value="Perlu Restok" {{ request('filter') == 'Perlu Restok' ? 'selected' : '' }}>Perlu Restok</option>
                <option value="Aman" {{ request('filter') == 'Aman' ? 'selected' : '' }}>Aman</option>
            </select>
            <button type="submit" class="btn btn-outline-secondary btn-sm">Tampilkan</button>
        </form>

        <!-- Hapus Semua -->
        @if ($obats->count())
        <form id="delete-all-form" action="{{ route('obat.destroyAll') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDeleteAll()" class="btn btn-outline-danger btn-sm">
                Hapus Semua
            </button>
        </form>
        @endif
    </div>
</section>

    <!-- Tabel Obat -->
    <div class="table-responsive shadow-sm border rounded bg-white p-3">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Satuan</th>
                    <th>Kuantitas</th>
                    <th>Jenis Penyakit</th>
                    <th>klasifikasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($obats as $obat)
                <tr>
                    <td>{{ ($obats->currentPage() - 1) * $obats->perPage() + $loop->iteration }}</td>
                    <td>{{ $obat->nama_obat }}</td>
                    <td>{{ $obat->satuan }}</td>
                    <td>{{ $obat->kuantitas }}</td>
                    <td>{{ $obat->jenis_penyakit }}</td>
                    <td>
                        @if ($obat->klasifikasi == 'Kritis')
                            <span class="badge bg-danger">{{ $obat->klasifikasi }}</span>
                        @elseif ($obat->klasifikasi == 'Perlu Restok')
                            <span class="badge bg-warning text-dark">{{ $obat->klasifikasi }}</span>
                        @elseif ($obat->klasifikasi == 'Aman')
                            <span class="badge bg-success">{{ $obat->klasifikasi }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Aksi
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('obat.edit', $obat->id) }}">Edit</a></li>
                                <li><button class="dropdown-item text-danger" onclick="confirmDelete({{ $obat->id }})">Hapus</button></li>
                            </ul>
                        </div>
                        <form id="delete-form-{{ $obat->id }}" action="{{ route('obat.destroy', $obat->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">Tidak ada data obat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <div class="pagination-wrapper" style="display: inline-flex; gap: 4px;">
            {{ $obats->links() }}

        </div>
    </div>
</div>

<!-- SweetAlert -->
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function confirmDeleteAll() {
        Swal.fire({
            title: 'Yakin ingin menghapus semua?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, hapus semua'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-all-form').submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection
