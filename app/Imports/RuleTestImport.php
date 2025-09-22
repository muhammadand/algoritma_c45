<?php

namespace App\Imports;

use App\Models\RuleTest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RuleTestImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new RuleTest([
            'nik'                    => $row['nik'],
            'nama_lengkap'           => $row['nama_lengkap'],
            'alamat'                 => $row['alamat'],
            'tanggal_lahir'          => $row['tanggal_lahir'],
            'usia'                   => $row['usia'],
            'status_perkawinan'      => $row['status_perkawinan'], // Disimpan apa adanya
            'pekerjaan'              => $row['pekerjaan'],
            'gaji_perbulan'          => $row['gaji_perbulan'],
            'hasil_bi_checking'      => $row['hasil_bi_checking'],
            'status_kepemilikan_rumah' => $row['status_kepemilikan_rumah'],
            'hasil_kelayakan' => $row['hasil_kelayakan'],
        ]);
    }
}
