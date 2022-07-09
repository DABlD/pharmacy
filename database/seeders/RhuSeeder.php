<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Rhu, User};

class RhuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size = 3;
        for($i = 1; $i <= $size; $i++){
            $this->addRhu($i);
        }
    }

    public function addRhu($i){
        $user = new User();
        $user->username = "rhu$i";
        $user->name = "RHU $i";
        $user->role = "RHU";
        $user->email = "rhu$i@pharmacy.com";
        $user->address = "RHU$i ADDRESS";
        $user->contact = "09" . rand(100000000, 999999999);
        $user->password = "12345678";
        $user->save();

        $rhu = new Rhu();
        $rhu->user_id = $user->id;
        $rhu->company_name = "RHU$i - Company Name";
        $rhu->company_code = "RHU$i - Company Name";
        $rhu->contact_personnel = "RHU$i - Contact Personnel";
        $rhu->save();
    }
}
