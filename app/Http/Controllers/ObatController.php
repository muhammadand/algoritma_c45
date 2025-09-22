<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use App\Imports\ObatImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(new ObatImport, $request->file('file'));

    return redirect()->route('obat.index')->with('success', 'Data berhasil diimport!');
}
public function klasifikasi()
{
    try {
        // Tambahkan kolom klasifikasi kalau belum ada
        DB::statement("ALTER TABLE obats ADD COLUMN klasifikasi VARCHAR(50) NULL");
    } catch (\Exception $e) {
        // Kolom sudah ada, abaikan error
    }

    // Jalankan klasifikasi sesuai hasil C4.5
    DB::update("
        UPDATE obats
        SET klasifikasi = CASE
            WHEN kuantitas <= 99 THEN 'Kritis'
            WHEN kuantitas <= 1000 THEN 'Perlu Restok'
            ELSE 'Aman'
        END
    ");

    return redirect()->route('obat.index')->with('success', 'Klasifikasi berhasil dilakukan.');
}

    // Tampilkan semua data obat
    public function index(Request $request)
    {
        $query = Obat::query();
    
        // Filter berdasarkan klasifikasi jika ada parameter 'filter'
        if ($request->has('filter') && $request->filter !== '') {
            $query->where('klasifikasi', $request->filter);
        }
    
        // Urutkan berdasarkan id terbaru dan paginasi 20 per halaman
        $obats = $query->orderBy('id', 'desc')->paginate(20);
    
        return view('obat.index', compact('obats'));
    }


    // Tampilkan form untuk menambahkan obat baru
    public function create()
    {
        return view('obat.create');
    }

    // Simpan data obat baru ke database
  
    
   

    // Tampilkan form edit
    public function edit(Obat $obat)
    {
        return view('obat.edit', compact('obat'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'kuantitas' => 'required|integer',
            'jenis_penyakit' => 'required|string|max:255',
        ]);
    
        // Tentukan klasifikasi berdasarkan kuantitas
        $klasifikasi = $this->klasifikasikanDenganThreshold($request->kuantitas);

    
        // Simpan data obat beserta klasifikasinya
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'satuan' => $request->satuan,
            'kuantitas' => $request->kuantitas,
            'jenis_penyakit' => $request->jenis_penyakit,
            'klasifikasi' => $klasifikasi
        ]);
    
        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan dengan klasifikasi: ' . $klasifikasi);
    }
    
    // Update data obat
    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'kuantitas' => 'required|integer',
            'jenis_penyakit' => 'required|string|max:255',
        ]);
    
        // Hitung klasifikasi berdasarkan kuantitas
        $klasifikasi = $this->klasifikasikanDenganThreshold($request->kuantitas);

    
        // Update data
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'satuan' => $request->satuan,
            'kuantitas' => $request->kuantitas,
            'jenis_penyakit' => $request->jenis_penyakit,
            'klasifikasi' => $klasifikasi
        ]);
    
        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui dengan klasifikasi: ' . $klasifikasi);
    }
    
    private function klasifikasikanDenganThreshold($kuantitas)
    {
        $data = Obat::select('kuantitas', 'klasifikasi')->get()->toArray();
    
        if (count($data) < 3) {
            return 'Tidak Diketahui';
        }
    
        // Hitung threshold terbaik
        $labels = array_unique(array_column($data, 'klasifikasi'));
        usort($data, fn($a, $b) => $a['kuantitas'] <=> $b['kuantitas']);
        $splitPoints = $this->generateSplitPoints($data);
    
        $maxGain = 0;
        $bestThreshold = null;
    
        foreach ($splitPoints as $point) {
            $gain = $this->informationGain($data, $point, $labels);
            if ($gain > $maxGain) {
                $maxGain = $gain;
                $bestThreshold = $point;
            }
        }
    
        // Ambil label terbanyak dari masing-masing sisi threshold
        $labelKiri = $this->mostCommonLabel($data, '<=', $bestThreshold);
        $labelKanan = $this->mostCommonLabel($data, '>', $bestThreshold);
    
        return $kuantitas <= $bestThreshold ? $labelKiri : $labelKanan;
    }

    public function ujiAkurasi()
{
    $data = Obat::select('kuantitas', 'klasifikasi')->get()->toArray();

    if (count($data) < 3) {
        return view('obat.akurasi', [
            'akurasi' => null,
            'total' => 0,
            'benar' => 0,
            'salah' => 0,
            'pesan' => 'Data belum cukup untuk menghitung akurasi.'
        ]);
    }

    // Langkah 1: Dapatkan threshold terbaik dari rules
    $labels = array_unique(array_column($data, 'klasifikasi'));
    usort($data, fn($a, $b) => $a['kuantitas'] <=> $b['kuantitas']);
    $splitPoints = $this->generateSplitPoints($data);

    $maxGain = 0;
    $bestThreshold = null;

    foreach ($splitPoints as $point) {
        $gain = $this->informationGain($data, $point, $labels);
        if ($gain > $maxGain) {
            $maxGain = $gain;
            $bestThreshold = $point;
        }
    }

    // Dapatkan label mayoritas masing-masing sisi threshold
    $labelKiri = $this->mostCommonLabel($data, '<=', $bestThreshold);
    $labelKanan = $this->mostCommonLabel($data, '>', $bestThreshold);

    // Langkah 2: Bandingkan label aktual dengan prediksi
    $benar = 0;
    foreach ($data as $row) {
        $prediksi = $row['kuantitas'] <= $bestThreshold ? $labelKiri : $labelKanan;
        if ($row['klasifikasi'] === $prediksi) {
            $benar++;
        }
    }

    $total = count($data);
    $akurasi = round(($benar / $total) * 100, 2);
    $salah = $total - $benar;

    return view('obat.akurasi', [
        'akurasi' => $akurasi,
        'total' => $total,
        'benar' => $benar,
        'salah' => $salah,
        'threshold' => $bestThreshold,
        'labelKiri' => $labelKiri,
        'labelKanan' => $labelKanan,
        'pesan' => null,
    ]);
}

    
    // public function rules()
    // {
    
    //     $rules = [
    //         'IF kuantitas <= 99 THEN Klasifikasi: Kritis',
    //         'IF kuantitas > 99 AND kuantitas <= 1000 THEN Klasifikasi: Perlu Restok',
    //         'IF kuantitas > 1000 THEN Klasifikasi: Aman'
    //     ];
    
    //     return view('obat.rules', compact('rules'));
    // }
    
    public function rules()
    {
        $data = Obat::select('kuantitas', 'klasifikasi')->get()->toArray();
    
        if (count($data) < 3) {
            return view('obat.rules', [
                'rules' => ['Data belum cukup untuk membentuk aturan.'],
                'entropy' => null,
                'gains' => [],
                'bestThresholds' => [],
            ]);
        }
    
        // Ambil semua label unik
        $labels = array_unique(array_column($data, 'klasifikasi'));
        sort($data); // Urut berdasarkan kuantitas
        $splitPoints = $this->generateSplitPoints($data);
    
        $entropy = round($this->entropy($data, $labels), 3);
        $gains = [];
        $thresholdRules = [];
    
        $maxGain = 0;
        $bestThresholds = [];
    
        foreach ($splitPoints as $point) {
            $gain = round($this->informationGain($data, $point, $labels), 3);
            $gains[$point] = $gain;
    
            if ($gain > $maxGain) {
                $maxGain = $gain;
                $bestThresholds = [$point];
            } elseif ($gain == $maxGain) {
                $bestThresholds[] = $point;
            }
    
            // Buat aturan untuk ditampilkan
            $thresholdRules[] = [
                "IF kuantitas <= $point THEN Klasifikasi = " . $this->mostCommonLabel($data, '<=', $point),
                "IF kuantitas > $point THEN Klasifikasi = " . $this->mostCommonLabel($data, '>', $point)
            ];
        }
    
        // Ambil aturan hanya dari threshold terbaik
        $rules = [];
        foreach ($bestThresholds as $point) {
            $rules[] = "IF kuantitas <= $point THEN Klasifikasi = " . $this->mostCommonLabel($data, '<=', $point);
            $rules[] = "IF kuantitas > $point THEN Klasifikasi = " . $this->mostCommonLabel($data, '>', $point);
        }
    
        return view('obat.rules', [
            'rules' => $rules,
            'entropy' => $entropy,
            'gains' => $gains,
            'bestThresholds' => $bestThresholds,
        ]);
    }
    
    
    private function entropy($data, $labels)
    {
        $total = count($data);
        $counts = array_fill_keys($labels, 0);
    
        foreach ($data as $row) {
            $counts[$row['klasifikasi']]++;
        }
    
        $entropy = 0;
        foreach ($counts as $count) {
            if ($count > 0) {
                $p = $count / $total;
                $entropy -= $p * log($p, 2);
            }
        }
    
        return $entropy;
    }
    
    private function generateSplitPoints($data)
    {
        $points = [];
        for ($i = 0; $i < count($data) - 1; $i++) {
            $curr = $data[$i]['kuantitas'];
            $next = $data[$i + 1]['kuantitas'];
            if ($curr !== $next) {
                $points[] = ($curr + $next) / 2;
            }
        }
        return $points;
    }
    
    private function informationGain($data, $point, $labels)
    {
        $totalEntropy = $this->entropy($data, $labels);
    
        $left = array_filter($data, fn($row) => $row['kuantitas'] <= $point);
        $right = array_filter($data, fn($row) => $row['kuantitas'] > $point);
    
        $leftEntropy = $this->entropy($left, $labels);
        $rightEntropy = $this->entropy($right, $labels);
    
        $total = count($data);
        $gain = $totalEntropy
            - (count($left) / $total) * $leftEntropy
            - (count($right) / $total) * $rightEntropy;
    
        return $gain;
    }
    
    private function mostCommonLabel($data, $operator, $point)
    {
        $subset = array_filter($data, function ($row) use ($operator, $point) {
            return $operator === '<=' ? $row['kuantitas'] <= $point : $row['kuantitas'] > $point;
        });
    
        $counts = [];
        foreach ($subset as $row) {
            $label = $row['klasifikasi'];
            $counts[$label] = ($counts[$label] ?? 0) + 1;
        }
    
        arsort($counts);
        return array_key_first($counts);
    }
    
    public function show(Obat $obat)
{
    return view('obat.show', compact('obat'));
}


    // Hapus obat
    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }
    public function destroyAll()
    {
        // dd('Fungsi destroyAll berhasil dipanggil.');
    
        Obat::truncate(); // tidak akan dijalankan karena terhenti di dd
        return redirect()->route('obat.index')->with('success', 'Semua data obat berhasil dihapus.');
    }
    

}
