<?php

namespace App\Imports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ObatImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Obat([
            'nama_obat'      => $row['nama_obat'],       // Ambil dari kolom 'Nama Obat'
            'satuan'         => $row['satuan'],
            'kuantitas'      => $row['kuantitas'],
            'jenis_penyakit' => $row['jenis_penyakit'],
        ]);
    }
}
