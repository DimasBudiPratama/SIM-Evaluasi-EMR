<?php

namespace App\Http\Controllers;

use App\Models\Responden;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RespondenController extends Controller
{

    public function index()
    {
        $responden = Responden::all();
        return view('pages.responden.index', compact('responden'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'jenis_kelamin' => 'required|string',
            'profesi'       => 'required|string|max:255',
            'unit_kerja'    => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name'     => $request->nama,
                'email'    => $request->email,
                'password' => Hash::make('12345678'),
            ]);

            Responden::create([
                'user_id'       => $user->id,
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'profesi'       => $request->profesi,
                'unit_kerja'    => $request->unit_kerja,
            ]);

            DB::commit();

            return redirect()->route('responden.index')->with('success', 'Data responden berhasil ditambahkan!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('responden.index')->with('gagal', 'Data tidak berhasil ditambahkan!');
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
    public function destroy($id)
    {
        $responden = Responden::findOrFail($id);

        DB::beginTransaction();

        try {
            $userId = $responden->user_id;

            $responden->delete();

            User::where('id', $userId)->delete();

            DB::commit();

            return redirect()->route('responden.index')->with('success', 'Data responden berhasil dihapus!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('responden.index')->with('gagal', 'Data gagal dihapus!');
        }
    }
}
