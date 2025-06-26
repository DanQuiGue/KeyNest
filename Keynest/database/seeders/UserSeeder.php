<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $root=User::create([
            'name' => 'root',
            'email' => 'root@root.com',
            'nickname'=>'root',
            'password' => Hash::make('12345678'),
        ]);
        $root->roles()->attach(1); // superadmin

        $company=User::create([
            'name' => 'company',
            'email' => 'company@company.com',
            'type' => 'company',
            'password' => Hash::make('12345678'),
        ]);
        $company->roles()->attach(2); // company

        $influencer=User::create([
            'name' => 'influencer',
            'surname'=>'influ',
            'nickname'=>'InCerFlu',
            'email' => 'influencer@influencer.com',
            'type' => 'company',
            'password' => Hash::make('12345678'),
        ]);
        $influencer->roles()->attach(3); // company
    }
}
