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
        $super_admin = User::where('email', 'superadmin@local.com')->first();

        if (empty($super_admin)) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@local.com',
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}