<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Permission secara terpisah
        $permSemuaFitur = Permission::create(['name' => 'semua fitur']);
        $permPeneliti   = Permission::create(['name' => 'peneliti']);
        $permLaporan    = Permission::create(['name' => 'laporan']);
        $permKuesioner  = Permission::create(['name' => 'isi-kuesioner']);

        // 2. Buat Role
        $roleAdmin     = Role::create(['name' => 'admin']);
        $rolePeneliti  = Role::create(['name' => 'peneliti']);
        $roleResponden = Role::create(['name' => 'responden']);

        // 3. Berikan Permission ke masing-masing Role
        $roleAdmin->givePermissionTo($permSemuaFitur);

        // Peneliti bisa akses fitur peneliti dan lihat laporan
        $rolePeneliti->givePermissionTo([$permPeneliti, $permLaporan]);

        // Responden hanya bisa isi kuesioner
        $roleResponden->givePermissionTo($permKuesioner);

        // 4. Buat User Admin
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@rsmetro.test',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole($roleAdmin);

        // 5. Buat User Peneliti
        $userPeneliti = User::factory()->create([
            'name' => 'Peneliti',
            'email' => 'peneliti@rsmetro.test',
            'password' => bcrypt('12345678'),
        ]);
        $userPeneliti->assignRole($rolePeneliti);

        // 6. Buat User Responden
        $userResponden = User::factory()->create([
            'name' => 'Responden',
            'email' => 'responden@rsmetro.test',
            'password' => bcrypt('12345678'),
        ]);
        $userResponden->assignRole($roleResponden);
    }
}
