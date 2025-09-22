@extends('app')

@section('content')
<div class="page-inner">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Manage Users</h1>
        <a href="{{ route('user.create') }}" class="btn btn-label-primary btn-round btn-sm">
            <i class="fas fa-plus me-2"></i> Tambah User
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('user.edit', $user->user_id) }}" class="btn btn-label-warning btn-round btn-sm d-flex align-items-center justify-content-center px-3 py-2 me-2">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>

                            <form action="{{ route('user.destroy', $user->user_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-label-danger btn-round btn-sm d-flex align-items-center justify-content-center px-3 py-2" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
