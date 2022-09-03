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
            'username' => 'superadmin',
            'name' => 'Super Admin',
            'role' => 'Super Admin',
            'email' => 'davidmendozaofficial@gmail.com',
            'address' => 'Mars',
            'contact' => '09154590172',
            'password' => '123456'
        ]);

        for($i = 1; $i <= 3; $i++){
            $this->createAdmin($i);
        }
    }

    private function createAdmin($i){
        User::create([
            'username' => "centrapharm$i",
            'name' => "CENTRAPHARM$i",
            'role' => 'Admin',
            'email' => "centrapharm$i@pharmacy.com",
            'address' => "CENTRAPHARM$i ADDRESS",
            'contact' => "09" . rand(100000000, 999999999),
            'password' => '123456'
        ]);
    }
}
