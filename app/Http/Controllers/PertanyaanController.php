<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pertanyaan = Pertanyaan::orderBy('kode_pertanyaan', 'asc')->get();
        return view('pages.pertanyaan.index', compact('pertanyaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pertanyaan' => 'required|max:10|unique:pertanyaan,kode_pertanyaan',
            'metode' => 'required|in:PIECES,TAM',
            'kategori' => 'nullable|string|max:100',
            'isi_pertanyaan' => 'required|string',
        ]);

        Pertanyaan::create([
            'kode_pertanyaan' => $request->kode_pertanyaan,
            'metode' => $request->metode,
            'kategori' => $request->kategori,
            'isi_pertanyaan' => $request->isi_pertanyaan,
            'status' => $request->has('status') ? true : false,
        ]);

        return redirect()->route('pertanyaan.index')->with('success', 'Data pertanyaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $request->validate([
            'kode_pertanyaan' => 'required|max:10|unique:pertanyaan,kode_pertanyaan,' . $id,
            'metode' => 'required|in:PIECES,TAM',
            'kategori' => 'nullable|string|max:100',
            'isi_pertanyaan' => 'required|string',
        ]);

        $pertanyaan->update([
            'kode_pertanyaan' => $request->kode_pertanyaan,
            'metode' => $request->metode,
            'kategori' => $request->kategori,
            'isi_pertanyaan' => $request->isi_pertanyaan,
            'status' => $request->has('status') ? true : false,
        ]);

        return redirect()->route('pertanyaan.index')->with('success', 'Data pertanyaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->delete();

        return redirect()->route('pertanyaan.index')->with('success', 'Data pertanyaan berhasil dihapus!');
    }
}
