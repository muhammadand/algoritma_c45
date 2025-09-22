<?php

namespace App\Http\Controllers;



use App\Models\Obat;
use App\Models\User;



class AdminController extends Controller
{
    public function index()
    {
        // ----------------------------------------
        // 1. Hitung Total Data
        // ----------------------------------------
        $totalObat = Obat::count();
        $totalUser = User::count();
    
        // ----------------------------------------
        // 2. Ambil Data Obat (Paginate 5)
        // ----------------------------------------
        $dataObat = Obat::paginate(5);
    
        // ----------------------------------------
        // 3. Ambil Data User (Paginate 5)
        // ----------------------------------------
        $dataUser = User::paginate(5);
    
        // ----------------------------------------
        // 4. Kirim Data ke View
        // ----------------------------------------
        return view('admin.index', compact(
            'totalObat',
            'totalUser',
            'dataObat',
            'dataUser'
        ));
    }
    
    
}

    
    
    

    
