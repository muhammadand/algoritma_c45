@extends('app')

@section('content')
<div class="page-inner">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Card Container for Create Form -->
            <div class="card border-0 shadow-lg rounded">
                <div class="card-body p-5">
                    <h4 class="text-center mb-4">Buat Profil</h4>

             
{{-- SweetAlert Scripts --}}
<script>
    // Notifikasi flash success
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    // Notifikasi flash error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    // Konfirmasi hapus
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
</script>

                    <!-- Profile Creation Form -->
                    <form action="{{ route('profil.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Alamat</label>
                            <input class="form-control" type="text" name="alamat" required />
                        </div>

                        <div class="mb-3">
                            <label>Tanggal Lahir</label>
                            <input class="form-control" type="date" name="tanggal_lahir" required />
                        </div>

                        <div class="mb-3">
                            <label>Foto</label>
                            <input class="form-control" type="file" name="foto" />
                        </div>

                        <div class="mb-3 text-center">
                            <button class="btn btn-label-primary px-4 py-2" style="border-radius: 25px;">
                                {{-- class="btn btn-label-danger btn-round btn-sm d-flex align-items-center justify-content-center px-3 py-2" --}}
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
