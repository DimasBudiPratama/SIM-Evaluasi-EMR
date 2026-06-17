<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KuesionerPiecesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();

        // 1. Ambil semua data pertanyaan PIECES yang aktif
        $pertanyaan = Pertanyaan::where('metode', 'PIECES')
            ->where('status', 1)
            ->orderBy('kode_pertanyaan', 'asc')
            ->get();

        // 2. Kelompokkan pertanyaan berdasarkan kategori
        $pertanyaanGrouped = $pertanyaan->groupBy('kategori');

        // 3. Cek apakah user ini SUDAH PERNAH mengisi kuesioner
        // Kita ambil jawaban user dan di-key berdasarkan 'pertanyaan_id' agar mudah dicocokkan di blade
        $jawabanUser = Jawaban::where('user_id', $userId)
            ->get()
            ->keyBy('pertanyaan_id');

        // 4. Tentukan status apakah user sudah mengisi atau belum
        $sudahMengisi = $jawabanUser->isNotEmpty();

        // Ambil durasi menit/detik dari salah satu jawaban jika sudah mengisi untuk ditampilkan di timer
        $durasiTersimpan = $sudahMengisi ? $jawabanUser->first()->durasi_detik : 0;

        return view('pages.kuesioner-pieces.index', compact(
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

        // Cek double submit untuk keamanan tambahan
        $exists = Jawaban::where('user_id', $userId)->exists();
        if ($exists) {
            return redirect()->route('kuesioner-pieces.index')->with('gagal', 'Anda sudah pernah mengisi kuesioner ini.');
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
            return redirect()->route('kuesioner-pieces.index')->with('success', 'Kuesioner berhasil dikirim. Terima kasih!');
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
