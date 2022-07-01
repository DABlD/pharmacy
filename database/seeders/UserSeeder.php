<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'centrapharm',
            'name' => 'CENTRAPHARM',
            'role' => 'Admin',
            'email' => 'davidmendozaofficial@gmail.com',
            'address' => 'MALOLOS, BULACAN',
            'contact' => '8231895',
            'password' => '123456'
        ]);
    }
}
