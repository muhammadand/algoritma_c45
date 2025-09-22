<?php

namespace App\Exports;

use App\Models\DataPrediksi;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataPrediksiExport implements FromCollection
{
    public function collection()
    {
        return DataPrediksi::all();
    }
}

