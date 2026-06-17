<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {

        $riwayatPieces = Jawaban::with(['pertanyaan', 'user'])
            ->select('jawaban.*') // Mengunci agar ID yang diambil tetap ID milik tabel jawaban
            ->join('pertanyaan', 'jawaban.pertanyaan_id', '=', 'pertanyaan.id')
            ->where('pertanyaan.metode', 'PIECES')
            ->orderByDesc('jawaban.created_at') // Responden terakhir berada di paling atas
            ->orderBy('pertanyaan.kode_pertanyaan', 'asc') // Kode di dalam responden tersebut urut E1, E2, C1...
            ->get();

        $riwayatTam = Jawaban::with(['pertanyaan', 'user'])
            ->select('jawaban.*')
            ->join('pertanyaan', 'jawaban.pertanyaan_id', '=', 'pertanyaan.id')
            ->where('pertanyaan.metode', 'TAM')
            ->orderByDesc('jawaban.created_at')
            ->orderBy('pertanyaan.kode_pertanyaan', 'asc')
            ->get();

        return view('pages.riwayat.index', compact('riwayatPieces', 'riwayatTam'));
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
