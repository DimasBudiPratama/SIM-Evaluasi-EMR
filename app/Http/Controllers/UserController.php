<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data yang diperlukan untuk setiap tab
        $users = User::with('roles')->get();
        $roles = Role::all();
        $permissions = Permission::all();

        // Kirim data ke view settings.index
        return view('pages.settings.index', compact('users', 'roles', 'permissions'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Sync role (hapus role lama, ganti dengan yang baru)
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function storeRoles(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Role berhasil dibuat!');
    }

    public function updateRoles(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        return redirect()->back()->with('success', 'Role berhasil diupdate!');
    }

    public function destroyRoles($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Role berhasil dihapus!');
    }

    public function storePermissions(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Permission berhasil dibuat!');
    }

    public function updatePermissions(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $id]);
        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name]);
        return redirect()->back()->with('success', 'Permission berhasil diupdate!');
    }

    public function destroyPermissions($id)
    {
        Permission::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Permission berhasil dihapus!');
    }

    public function updateAssign(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        // syncPermissions akan otomatis menghapus yang tidak dicentang dan menambah yang baru
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->back()->with('success', 'Permissions berhasil diupdate untuk role ' . $role->name);
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
