<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Responden;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Total Sampel Responden Aktual (Dihitung murni dari tabel responden)
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();

        // 2. Hitung Total Butir Pertanyaan per Metode
        $totalPertanyaanPieces = Pertanyaan::where('metode', 'PIECES')->count();
        $totalPertanyaanTam = Pertanyaan::where('metode', 'TAM')->count();

        // 3. Tarik Semua Data Master untuk Kalkulasi Grafik
        $pertanyaan = Pertanyaan::all();
        $jawabanAll = Jawaban::all();

        // Array penampung nilai mean
        $meanPiecesData = [
            'Control'     => 0,
            'Economy'     => 0,
            'Performance' => 0,
            'Information' => 0,
            'Efficiency'  => 0,
            'Service'     => 0,
        ];

        // BARU: Array penampung nilai PERSENTASE KELAYAKAN PIECES
        $persenPiecesData = [
            'Control'     => 0,
            'Economy'     => 0,
            'Performance' => 0,
            'Information' => 0,
            'Efficiency'  => 0,
            'Service'     => 0,
        ];



        $meanTamData = [
            'Perceived Usefulness'      => 0,
            'Perceived Ease of Use'     => 0,
            'Behavioral Intention to Use' => 0,
        ];

        // BARU: Array penampung nilai PERSENTASE KELAYAKAN TAM
        $persenTamData = [
            'Perceived Usefulness'      => 0,
            'Perceived Ease of Use'     => 0,
            'Behavioral Intention to Use' => 0,
        ];

        $sumGlobalPieces = 0;
        $sumGlobalTam = 0;

        if ($totalResponden > 0) {
            $groupedPertanyaan = $pertanyaan->groupBy(['metode', 'kategori']);

            if (isset($groupedPertanyaan['PIECES'])) {
                foreach ($groupedPertanyaan['PIECES'] as $kategoriName => $items) {
                    $pertanyaanIds = $items->pluck('id')->toArray();
                    $skorButir = $jawabanAll->whereIn('pertanyaan_id', $pertanyaanIds)->pluck('skor_likert')->toArray();
                    $totalButirDiDimensi = count($pertanyaanIds); // Nilai 2


                    // RUMUS YANG SAMA DENGAN PDF/LAPORAN:
                    // Persentase = (Total Skor Aktual / (Total Responden * Total Butir * Skor Maks 5)) * 100
                    $totalSkorAktual = array_sum($skorButir); //Nilai 10
                    $totalIdeal = $totalResponden * $totalButirDiDimensi * 5;


                    $meanValue = count($skorButir) > 0 ? round($totalSkorAktual / ($totalResponden * $totalButirDiDimensi), 2) : 0;
                    $persenValue = $totalIdeal > 0 ? round(($totalSkorAktual / $totalIdeal) * 100, 1) : 0;

                    if (array_key_exists($kategoriName, $meanPiecesData)) {
                        $meanPiecesData[$kategoriName] = $meanValue;
                        $persenPiecesData[$kategoriName] = $persenValue; // Ini sekarang akan menghasilkan 63.3%
                        $sumGlobalPieces += $meanValue;
                    }
                }
            }

            // --- KALKULASI DATA TAM ---
            if (isset($groupedPertanyaan['TAM'])) {
                foreach ($groupedPertanyaan['TAM'] as $kategoriName => $items) {
                    $pertanyaanIds = $items->pluck('id')->toArray();
                    $skorButir = $jawabanAll->whereIn('pertanyaan_id', $pertanyaanIds)->pluck('skor_likert')->toArray();
                    $totalButirDiDimensi = count($pertanyaanIds);

                    // RUMUS YANG SAMA DENGAN PDF/LAPORAN:
                    $totalSkorAktual = array_sum($skorButir);
                    $totalIdeal = $totalResponden * $totalButirDiDimensi * 5;

                    $meanValue = count($skorButir) > 0 ? round($totalSkorAktual / ($totalResponden * $totalButirDiDimensi), 2) : 0;
                    $persenValue = $totalIdeal > 0 ? round(($totalSkorAktual / $totalIdeal) * 100, 1) : 0;

                    if (array_key_exists($kategoriName, $meanTamData)) {
                        $meanTamData[$kategoriName] = $meanValue;
                        $persenTamData[$kategoriName] = $persenValue;
                        $sumGlobalTam += $meanValue;
                    }
                }
            }
        }

        // 4. Nilai Rata-rata Global (Untuk Summary Atas)
        $globalMeanPieces = number_format($sumGlobalPieces / 6, 2);
        $globalMeanTam = number_format($sumGlobalTam / 3, 2);

        return view('dashboard', compact(
            'totalResponden',
            'totalPertanyaanPieces',
            'totalPertanyaanTam',
            'globalMeanPieces',
            'globalMeanTam',
            'meanPiecesData',
            'persenPiecesData',
            'meanTamData',
            'persenTamData',
        ));
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
