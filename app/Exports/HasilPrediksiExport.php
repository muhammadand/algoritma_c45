<?php

namespace App\Exports;

use App\Models\HasilPrediksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HasilPrediksiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return HasilPrediksi::select(
            'suhu', 'ph_tanah', 'curah_hujan', 'ketinggian',
            'jenis_tanah', 'cahaya', 'kelembapan', 'tanaman_cocok'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Suhu',
            'pH Tanah',
            'Curah Hujan',
            'Ketinggian',
            'Jenis Tanah',
            'Cahaya',
            'Kelembapan',
            'Tanaman Cocok',
        ];
    }
}
