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

        // for($i = 1; $i <= 3; $i++){
            // $this->createAdmin($i);
        // }
    }

    private function createAdmin($i){
        $user = new User();
        $user->username = "centrapharm$i";
        $user->name = "CENTRAPHARM$i";
        $user->role = 'Admin';
        $user->email = "centrapharm$i@pharmacy.com";
        $user->address = "CENTRAPHARM$i ADDRESS";
        $user->contact = "09" . rand(100000000, 999999999);
        $user->password = '123456';
        $user->save();

        $user->login_link = "?u=$user->id";
        $user->save();
    }
}
