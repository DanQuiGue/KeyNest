<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = Role::create([
            'id' => 1,
            'name' => 'Super Administrador'
        ]);

        $permissions = Permission::all();
        $super_admin->permissions()->attach($permissions);

        $company = Role::create([
            'id' => 2,
            'name' => 'Compañia'
        ]);

        $permissions= Permission::whereIn('role', ['company', 'both'])->pluck('id');
        $company->permissions()->attach($permissions);

        $influencer = Role::create([
            'id' => 3,
            'name' => 'Influencer'
        ]);

        $permissions= Permission::whereIn('role', ['influencer', 'both'])->pluck('id');
        $influencer->permissions()->attach($permissions);
    }
}
