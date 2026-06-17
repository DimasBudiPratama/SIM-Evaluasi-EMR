<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Responden;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Tambahkan validasi untuk field responden baru
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profesi' => ['required', 'string', 'max:100'],
            'unit_kerja' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
        ]);

        // 2. Gunakan DB Transaction untuk eksekusi multi-tabel aman
        $user = DB::transaction(function () use ($request) {

            // Simpan ke tabel users
            $userCreated = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Simpan ke tabel responden, hubungkan user_id ke primary id users baru
            Responden::create([
                'user_id' => $userCreated->id,
                'nama' => $request->name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'profesi' => $request->profesi,
                'unit_kerja' => $request->unit_kerja,
            ]);

            return $userCreated;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME)->with('success', 'Akun responden berhasil didaftarkan!');
    }
}
