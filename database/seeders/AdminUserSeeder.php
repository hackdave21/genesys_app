<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'thierryamenyah1@gmail.com'],
            [
                'name' => 'Thierry Amenyah',
                'phone' => '+228 93 79 11 88',
                'password' => Hash::make('AdminGenesys2026!'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
    }
}
