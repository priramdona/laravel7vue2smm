<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Munggi',
            'email' => 'munggi@gmail.com',
            'password' => Hash::make('password'), // Ganti dengan password yang sudah di-hash
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
