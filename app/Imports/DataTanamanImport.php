<?php

namespace App\Imports;

use App\Models\DataTanaman;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataTanamanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataTanaman([
            'suhu'           => $row['suhu'],
            'ph_tanah'       => $row['ph_tanah'],
            'curah_hujan'    => $row['curah_hujan'],
            'ketinggian'     => $row['ketinggian'],
            'jenis_tanah'    => $row['jenis_tanah'],
            'cahaya'         => $row['cahaya'],
            'kelembapan'     => $row['kelembapan'],
            'tanaman_cocok'  => $row['tanaman_cocok'],
        ]);
    }
}
