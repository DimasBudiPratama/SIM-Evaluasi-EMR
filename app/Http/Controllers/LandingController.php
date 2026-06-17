<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Responden;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // 1. Ambil Total Sampel Responden Aktual
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        $totalPertanyaan = Pertanyaan::count();

        $pertanyaan = Pertanyaan::all();
        $jawabanAll = Jawaban::all();

        // 2. Inisialisasi variabel perhitungan
        $meanPiecesData = [
            'Control' => 0,
            'Economy' => 0,
            'Performance' => 0,
            'Information' => 0,
            'Efficiency' => 0,
            'Service' => 0
        ];
        $meanTamData = [
            'Perceived Usefulness' => 0,
            'Perceived Ease of Use' => 0,
            'Behavioral Intention to Use' => 0
        ];

        $sumGlobalPieces = 0;
        $sumGlobalTam = 0;

        // Menghitung berapa kategori yang terisi (untuk pembagi akurat)
        $countActivePieces = 0;
        $countActiveTam = 0;

        if ($totalResponden > 0) {
            $groupedPertanyaan = $pertanyaan->groupBy(['metode', 'kategori']);

            // Kalkulasi PIECES
            if (isset($groupedPertanyaan['PIECES'])) {
                foreach ($groupedPertanyaan['PIECES'] as $kategoriName => $items) {
                    $pertanyaanIds = $items->pluck('id')->toArray();
                    $skorButir = $jawabanAll->whereIn('pertanyaan_id', $pertanyaanIds)->pluck('skor_likert')->toArray();
                    $totalButirDiDimensi = count($pertanyaanIds);

                    if ($totalButirDiDimensi > 0) {
                        $totalSkorAktual = array_sum($skorButir);
                        $meanValue = round($totalSkorAktual / ($totalResponden * $totalButirDiDimensi), 2);

                        $meanPiecesData[$kategoriName] = $meanValue;
                        $sumGlobalPieces += $meanValue;
                        $countActivePieces++; // Tambah pembagi hanya jika ada data
                    }
                }
            }

            // Kalkulasi TAM
            if (isset($groupedPertanyaan['TAM'])) {
                foreach ($groupedPertanyaan['TAM'] as $kategoriName => $items) {
                    $pertanyaanIds = $items->pluck('id')->toArray();
                    $skorButir = $jawabanAll->whereIn('pertanyaan_id', $pertanyaanIds)->pluck('skor_likert')->toArray();
                    $totalButirDiDimensi = count($pertanyaanIds);

                    if ($totalButirDiDimensi > 0) {
                        $totalSkorAktual = array_sum($skorButir);
                        $meanValue = round($totalSkorAktual / ($totalResponden * $totalButirDiDimensi), 2);

                        $meanTamData[$kategoriName] = $meanValue;
                        $sumGlobalTam += $meanValue;
                        $countActiveTam++; // Tambah pembagi hanya jika ada data
                    }
                }
            }
        }

        // 3. Hitung Global Mean (Pastikan pembagi adalah jumlah kategori aktif)
        $globalMeanPieces = $countActivePieces > 0 ? number_format($sumGlobalPieces / $countActivePieces, 2) : 0;
        $globalMeanTam = $countActiveTam > 0 ? number_format($sumGlobalTam / $countActiveTam, 2) : 0;

        $data = [
            'totalResponden' => $totalResponden,
            'totalPertanyaan' => $totalPertanyaan,
            'globalMeanPieces' => $globalMeanPieces,
            'globalMeanTam' => $globalMeanTam,
        ];

        return view('welcome', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
