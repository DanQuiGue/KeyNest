<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);
        // User::factory(10)->create();
        $user=User::create([
            'name' => 'root',
            'email' => 'root@root.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->roles()->attach(1); // superadmin
    }
}
