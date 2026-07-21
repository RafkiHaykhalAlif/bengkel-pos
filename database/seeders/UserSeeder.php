<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder {
    public function run(): void {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name'     => 'Owner',
            'email'    => 'owner@bengkel.com',
            'password' => Hash::make('1234'),
            'role'     => 'owner',
        ]);

        User::create([
            'name'     => 'Kasir',
            'email'    => 'kasir1@bengkel.com',
            'password' => Hash::make('kasir1'),
            'role'     => 'kasir',
        ]);
    }
}