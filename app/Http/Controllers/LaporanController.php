<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // 1. Ambil Master Data Pertanyaan & Jawaban Aktual
        $pertanyaan = Pertanyaan::all();
        $jawabanAll = Jawaban::with('pertanyaan')->get();
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        // dd($totalResponden);

        $laporanPieces = [];
        $laporanTam = [];

        if ($totalResponden > 0) {
            // Kelompokkan data kuesioner berdasarkan metode dan dimensi (kategori)
            $groupedPertanyaan = $pertanyaan->groupBy(['metode', 'kategori']);

            foreach ($groupedPertanyaan as $metode => $kategories) {
                foreach ($kategories as $kategoriName => $items) {
                    $pertanyaanIds = $items->pluck('id')->toArray();
                    $skorButir = $jawabanAll->whereIn('pertanyaan_id', $pertanyaanIds)->pluck('skor_likert')->toArray();

                    $totalSkorAktual = array_sum($skorButir);
                    $totalButirDiDimensi = count($pertanyaanIds);

                    // Komputasi Skor Indikator
                    $mean = count($skorButir) > 0 ? round($totalSkorAktual / ($totalResponden * $totalButirDiDimensi), 2) : 0;
                    $persentase = count($skorButir) > 0 ? round(($totalSkorAktual / ($totalResponden * $totalButirDiDimensi * 5)) * 100, 1) : 0;

                    // Penentuan Kriteria Keberhasilan EMR
                    if ($mean >= 4.2) {
                        $interpretasi = 'Sangat Baik';
                    } elseif ($mean >= 3.4) {
                        $interpretasi = 'Baik';
                    } elseif ($mean >= 2.6) {
                        $interpretasi = 'Cukup';
                    } elseif ($mean >= 1.8) {
                        $interpretasi = 'Buruk';
                    } else {
                        $interpretasi = 'Sangat Buruk';
                    }

                    $dataDimensi = [
                        'kategori' => $kategoriName,
                        'total_butir' => $totalButirDiDimensi,
                        'mean' => $mean,
                        'persentase' => $persentase,
                        'interpretasi' => $interpretasi
                    ];

                    if ($metode == 'PIECES') {
                        $laporanPieces[] = $dataDimensi;
                    } else {
                        $laporanTam[] = $dataDimensi;
                    }
                }
            }
        }

        return view('pages.laporan.index', compact('laporanPieces', 'laporanTam', 'totalResponden'));
    }


    // Method Internal 1: Kalkulasi PIECES
    private function dataPieces()
    {
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        $pertanyaan = Pertanyaan::where('metode', 'PIECES')->get();
        $jawaban = Jawaban::whereIn('pertanyaan_id', $pertanyaan->pluck('id'))->get();
        $laporan = [];

        if ($totalResponden > 0) {
            foreach ($pertanyaan->groupBy('kategori') as $kategori => $items) {
                $ids = $items->pluck('id')->toArray();
                $skor = $jawaban->whereIn('pertanyaan_id', $ids)->pluck('skor_likert')->toArray();
                $mean = count($skor) > 0 ? round(array_sum($skor) / ($totalResponden * count($ids)), 2) : 0;
                $persen = count($skor) > 0 ? round((array_sum($skor) / ($totalResponden * count($ids) * 5)) * 100, 1) : 0;

                if ($mean >= 4.2) {
                    $interpretasi = 'Sangat Baik';
                } elseif ($mean >= 3.4) {
                    $interpretasi = 'Baik';
                } elseif ($mean >= 2.6) {
                    $interpretasi = 'Cukup';
                } else {
                    $interpretasi = 'Buruk';
                }

                $laporan[] = ['kategori' => $kategori, 'total_butir' => count($ids), 'mean' => $mean, 'persentase' => $persen, 'interpretasi' => $interpretasi];
            }
        }
        return $laporan;
    }

    // Method Internal 2: Kalkulasi TAM
    private function dataTam()
    {
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        $pertanyaan = Pertanyaan::where('metode', 'TAM')->get();
        $jawaban = Jawaban::whereIn('pertanyaan_id', $pertanyaan->pluck('id'))->get();
        $laporan = [];

        if ($totalResponden > 0) {
            foreach ($pertanyaan->groupBy('kategori') as $kategori => $items) {
                $ids = $items->pluck('id')->toArray();
                $skor = $jawaban->whereIn('pertanyaan_id', $ids)->pluck('skor_likert')->toArray();
                $mean = count($skor) > 0 ? round(array_sum($skor) / ($totalResponden * count($ids)), 2) : 0;
                $persen = count($skor) > 0 ? round((array_sum($skor) / ($totalResponden * count($ids) * 5)) * 100, 1) : 0;

                if ($mean >= 4.2) {
                    $interpretasi = 'Sangat Baik';
                } elseif ($mean >= 3.4) {
                    $interpretasi = 'Baik';
                } elseif ($mean >= 2.6) {
                    $interpretasi = 'Cukup';
                } else {
                    $interpretasi = 'Buruk';
                }

                $laporan[] = ['kategori' => $kategori, 'total_butir' => count($ids), 'mean' => $mean, 'persentase' => $persen, 'interpretasi' => $interpretasi];
            }
        }
        return $laporan;
    }

    // 1. Download PDF khusus PIECES
    public function pdfPieces()
    {
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        $laporanPieces = $this->dataPieces();
        $pdf = PDF::loadView('pages.laporan.LaporanPDF', compact('laporanPieces', 'totalResponden'))->setPaper('a4', 'portrait');
        return $pdf->download('Laporan_Evaluasi_EMR_PIECES.pdf');
    }

    // 2. Download PDF khusus TAM
    public function pdfTam()
    {
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        $laporanTam = $this->dataTam();
        $pdf = PDF::loadView('pages.laporan.LaporanPDF', compact('laporanTam', 'totalResponden'))->setPaper('a4', 'portrait');
        return $pdf->download('Laporan_Evaluasi_EMR_TAM.pdf');
    }

    // 3. Download PDF Gabungan Keduanaya
    public function pdfGabungan()
    {
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        $laporanPieces = $this->dataPieces();
        $laporanTam = $this->dataTam();
        $pdf = PDF::loadView('pages.laporan.LaporanPDF', compact('laporanPieces', 'laporanTam', 'totalResponden'))->setPaper('a4', 'portrait');
        return $pdf->download('Laporan_Evaluasi_EMR_Gabungan.pdf');
    }


    // ==========================================================
    // PERUBAHAN KHUSUS LOGIKA PERHITUNGAN EXCEL (SINKRON DENGAN PDF)
    // ==========================================================

    public function excelPieces()
    {
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        $rawPieces = $this->dataPieces();
        $laporanPieces = [];

        foreach ($rawPieces as $row) {
            $meanPieces = floatval($row['mean']);
            $persenAkurat = round(($meanPieces / 5) * 100, 1);

            $laporanPieces[] = [
                'kategori' => $row['kategori'],
                'total_butir' => intval($row['total_butir']),
                'mean' => str_replace('.', ',', (string)number_format($meanPieces, 2)),
                'persentase' => str_replace('.', ',', (string)number_format($persenAkurat, 1)) . '%',
                'interpretasi' => $row['interpretasi']
            ];
        }

        $filename = "Laporan_Evaluasi_EMR_PIECES_" . time() . "_" . date('dMY') . ".xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('pages.laporan.laporanExcelPieces', compact('laporanPieces', 'totalResponden'));
    }

    /**
     * 2. UNDUH EXCEL KHUSUS TAM SAJA
     */
    public function excelTam()
    {
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        $rawTam = $this->dataTam();
        $laporanTam = [];

        foreach ($rawTam as $row) {
            $meanTam = floatval($row['mean']);
            $persenAkuratTam = round(($meanTam / 5) * 100, 1);

            $laporanTam[] = [
                'kategori' => $row['kategori'],
                'total_butir' => intval($row['total_butir']),
                'mean' => str_replace('.', ',', (string)number_format($meanTam, 2)),
                'persentase' => str_replace('.', ',', (string)number_format($persenAkuratTam, 1)) . '%',
                'interpretasi' => $row['interpretasi']
            ];
        }

        $filename = "Laporan_Evaluasi_EMR_TAM_" . time() . "_" . date('dMY') . ".xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('pages.laporan.laporanExcelTam', compact('laporanTam', 'totalResponden'));
    }

    public function excelGabungan()
    {
        $totalResponden = Jawaban::groupBy('user_id')->pluck('user_id')->count();
        $rawPieces = $this->dataPieces();
        $rawTam = $this->dataTam();

        $laporanPieces = [];
        $laporanTam = [];

        // 1. Proses Sinkronisasi Nilai Persentase PIECES Per Kategori
        foreach ($rawPieces as $row) {
            $meanPieces = floatval($row['mean']);

            $persenAkurat = round(($meanPieces / 5) * 100, 1);

            $laporanPieces[] = [
                'kategori' => $row['kategori'],
                'total_butir' => intval($row['total_butir']),
                'mean' => str_replace('.', ',', (string)number_format($meanPieces, 2)),
                // UBAH DISINI: Ubah titik menjadi koma dan tambahkan simbol % langsung sebagai teks
                'persentase' => str_replace('.', ',', (string)number_format($persenAkurat, 1)) . '%',
                'interpretasi' => $row['interpretasi']
            ];
            // dd($laporanPieces);
        }

        // 2. Proses Sinkronisasi Nilai Persentase TAM Per Kategori
        foreach ($rawTam as $row) {
            $meanTam = floatval($row['mean']);

            $persenAkuratTam = round(($meanTam / 5) * 100, 1);

            $laporanTam[] = [
                'kategori' => $row['kategori'],
                'total_butir' => intval($row['total_butir']),
                'mean' => str_replace('.', ',', (string)number_format($meanTam, 2)),
                // UBAH DISINI: Lakukan hal yang sama untuk TAM
                'persentase' => str_replace('.', ',', (string)number_format($persenAkuratTam, 1)) . '%',
                'interpretasi' => $row['interpretasi']
            ];
            // dd($laporanTam);
        }

        $filename = "Laporan_Evaluasi_EMR_Gabungan_" . date('dMY') . ".xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('pages.laporan.LaporanExcel', compact('laporanPieces', 'laporanTam', 'totalResponden'));
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
