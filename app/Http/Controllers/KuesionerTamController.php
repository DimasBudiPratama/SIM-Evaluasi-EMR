<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KuesionerTamController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 1. Ambil semua data pertanyaan TAM yang aktif
        $pertanyaan = Pertanyaan::where('metode', 'TAM')
            ->where('status', 1)
            ->orderBy('kode_pertanyaan', 'asc')
            ->get();

        // 2. Kelompokkan pertanyaan berdasarkan kategori
        $pertanyaanGrouped = $pertanyaan->groupBy('kategori');

        // 3. Cek apakah user ini sudah pernah mengisi kuesioner TAM
        // Gunakan whereHas jika ingin membatasi pengecekan hanya pada jawaban bertipe TAM
        $jawabanUser = Jawaban::where('user_id', $userId)
            ->whereIn('pertanyaan_id', $pertanyaan->pluck('id'))
            ->get()
            ->keyBy('pertanyaan_id');

        // 4. Tentukan status apakah user sudah mengisi atau belum
        $sudahMengisi = $jawabanUser->isNotEmpty();

        // Ambil durasi menit/detik dari salah satu jawaban jika sudah mengisi
        $durasiTersimpan = $sudahMengisi ? $jawabanUser->first()->durasi_detik : 0;

        return view('pages.kuesioner-tam.index', compact(
            'pertanyaanGrouped',
            'sudahMengisi',
            'jawabanUser',
            'durasiTersimpan'
        ));
    }

    public function store(Request $request)
    {
        $jawabanInput = $request->input('jawaban');
        $durasiDetik = $request->input('durasi_detik', 0);

        if (!$jawabanInput) {
            return redirect()->back()->with('gagal', 'Anda belum mengisi kuesioner.');
        }

        $userId = auth()->id();

        // Validasi double submit spesifik untuk pertanyaan yang dikirim
        $pertanyaanIds = array_keys($jawabanInput);
        $exists = Jawaban::where('user_id', $userId)
            ->whereIn('pertanyaan_id', $pertanyaanIds)
            ->exists();

        if ($exists) {
            return redirect()->route('kuesioner-tam.index')->with('gagal', 'Anda sudah pernah mengisi kuesioner ini.');
        }

        DB::beginTransaction();
        try {
            foreach ($jawabanInput as $pertanyaanId => $skor) {
                Jawaban::create([
                    'user_id'       => $userId,
                    'pertanyaan_id' => $pertanyaanId,
                    'skor_likert'   => $skor,
                    'durasi_detik'  => $durasiDetik,
                ]);
            }
            DB::commit();
            return redirect()->route('kuesioner-tam.index')->with('success', 'Kuesioner TAM berhasil dikirim. Terima kasih!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('gagal', 'Gagal mengirim kuesioner.');
        }
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
