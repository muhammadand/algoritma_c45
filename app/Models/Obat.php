<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    // Nama tabel (optional jika sesuai konvensi)
    protected $table = 'obats';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'nama_obat',
        'satuan',
        'kuantitas',
        'jenis_penyakit',
        'klasifikasi'
    ];
}
