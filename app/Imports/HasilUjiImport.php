<?php

namespace App\Imports;

use App\Models\HasilUji;
use Maatwebsite\Excel\Concerns\ToModel;

class HasilUjiImport implements ToModel
{
    public function model(array $row)
    {
        // Lewati baris header
        if (strtolower(trim($row[0])) === 'suhu') return null;

        return new HasilUji([
            'suhu'             => $row[0],
            'ph_tanah'         => $row[1],
            'curah_hujan'      => $row[2],
            'ketinggian'       => $row[3],
            'jenis_tanah'      => $row[4], // Biarkan dalam bentuk teks dulu
            'cahaya'           => $row[5],
            'kelembapan'       => $row[6],
            'tanaman_asli'     => $row[7],
            'tanaman_prediksi' => null, // Atau bisa diisi '-' kalau kamu mau
        ]);
    }
}
