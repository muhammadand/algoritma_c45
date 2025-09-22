<?php

namespace App\Imports;

use App\Models\Konsumen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KonsumenImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Konsumen([
            'nik'                     => $row['nik'],
            'nama_lengkap'            => $row['nama_lengkap'],
            'alamat'                  => $row['alamat'],
            'tanggal_lahir'           => $row['tanggal_lahir'],
            'usia'                    => $row['usia'],
            'status_perkawinan'       => $row['status_perkawinan'],
            'pekerjaan'               => $row['pekerjaan'],
            'gaji_perbulan'           => $row['gaji_perbulan'],
            'hasil_bi_checking'       => $row['hasil_bi_checking'],
            'status_kepemilikan_rumah' => $row['status_kepemilikan_rumah'],
            'hasil_kelayakan'         => $row['hasil_kelayakan'], // Tambahan kolom baru
        ]);
    }
}
