@extends('app')

@section('content')
<div class="container mt-4">
    <div class="card border border-success shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Uji Akurasi Algoritma C4.5</h5>
        </div>
        <div class="card-body">
            @if ($pesan)
                <div class="alert alert-warning">{{ $pesan }}</div>
            @else
                <p>Total Data: <strong>{{ $total }}</strong></p>
                <p>Prediksi Benar: <strong>{{ $benar }}</strong></p>
                <p>Prediksi Salah: <strong>{{ $salah }}</strong></p>
                <p>🎯 Threshold Terbaik: <strong>{{ $threshold }}</strong></p>
                <p>
                    - Label ≤ {{ $threshold }}: <strong>{{ $labelKiri }}</strong><br>
                    - Label > {{ $threshold }}: <strong>{{ $labelKanan }}</strong>
                </p>
                <h4 class="mt-4">🎯 Akurasi: <span class="text-success">{{ $akurasi }}%</span></h4>
            @endif
        </div>
    </div>
</div>
@endsection
