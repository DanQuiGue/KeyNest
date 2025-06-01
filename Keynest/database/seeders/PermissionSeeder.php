<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Games
        Permission::create([
            'name' => 'Puede crear juegos',
            'code' => 'can.create.games',
            'role' => 'company',
        ]);
        Permission::create([
            'name' => 'Puede ver juegos',
            'code' => 'can.read.games',
            'role' => 'both',
        ]);
        Permission::create([
            'name' => 'Puede editar juegos',
            'code' => 'can.update.games',
            'role' => 'company',
        ]);
        Permission::create([
            'name' => 'Puede borrar juegos',
            'code' => 'can.delete.games',
            'role' => 'company',
        ]);

        // Gender
        Permission::create([
            'name' => 'Puede crear genero',
            'code' => 'can.create.gender'
        ]);
        Permission::create([
            'name' => 'Puede ver genero',
            'code' => 'can.read.gender'
        ]);
        Permission::create([
            'name' => 'Puede editar genero',
            'code' => 'can.update.gender'
        ]);
        Permission::create([
            'name' => 'Puede borrar genero',
            'code' => 'can.delete.gender'
        ]);

        // Ratings
        Permission::create([
            'name' => 'Puede crear valoraciones',
            'code' => 'can.create.ratings',
            'role' => 'company',
        ]);
        Permission::create([
            'name' => 'Puede ver valoraciones',
            'code' => 'can.read.ratings',
            'role' => 'company',
        ]);
        Permission::create([
            'name' => 'Puede editar valoraciones',
            'code' => 'can.update.ratings',
            'role' => 'company',
        ]);
        Permission::create([
            'name' => 'Puede borrar valoraciones',
            'code' => 'can.delete.ratings',
            'role' => 'company',
        ]);

        // Request
        Permission::create([
            'name' => 'Puede crear solicitudes',
            'code' => 'can.create.request',
            'role' => 'influencer',
        ]);
        Permission::create([
            'name' => 'Puede ver juegos',
            'code' => 'can.read.request',
            'role' => 'influencer',
        ]);
        Permission::create([
            'name' => 'Puede editar juegos',
            'code' => 'can.update.request',
            'role' => 'influencer',
        ]);
        Permission::create([
            'name' => 'Puede borrar juegos',
            'code' => 'can.delete.request',
            'role' => 'influencer',
        ]);

    }
}
