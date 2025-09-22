@extends('app')

@section('content')
<div class="container mt-4">
    <div class="card border border-primary shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Aturan Klasifikasi C4.5</h5>
        </div>
        <div class="card-body">
            <p class="mb-3">Berikut adalah hasil klasifikasi menggunakan algoritma <strong>C4.5</strong> berdasarkan atribut <strong>kuantitas</strong>:</p>

            @if($entropy !== null)
            <!-- Informasi Entropy dan Gain -->
            <div class="mb-4">
                <h6 class="fw-bold">📊 Informasi Perhitungan</h6>
                <ul class="list-unstyled">
                    <li>Entropy Dataset: <strong>{{ $entropy }}</strong></li>
                    @foreach ($gains as $threshold => $gain)
                        <li>Gain pada threshold {{ $threshold }}: <strong>{{ $gain }}</strong></li>
                    @endforeach
                    <li>🎯 <strong>Threshold terbaik</strong>: {{ implode(' dan ', $bestThresholds) }}</li>
                </ul>
            </div>
            @endif

            <!-- Aturan Rule -->
            <div>
                <h6 class="fw-bold">📌 Aturan Klasifikasi (Rules)</h6>
                <ol>
                    @foreach ($rules as $rule)
                        <li>{{ $rule }}</li>
                    @endforeach
                </ol>
            </div>

            <p class="text-muted mt-4 small">
                Aturan ini diturunkan secara otomatis berdasarkan algoritma <strong>C4.5</strong> dari data persediaan obat. Klasifikasi berguna untuk mengelompokkan stok menjadi kategori <em>Kritis</em>, <em>Perlu Restok</em>, dan <em>Aman</em>.
            </p>
        </div>
    </div>
</div>
@endsection
