<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alert;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size = 10;
        for($i = 1; $i <= $size; $i++){
            $this->addAlert($i, rand(0, 3));
        }
    }

    public function addAlert($i, $j){
        $alert = new Alert();
        $alert->message = "Test Alert #$i";
        $alert->created_at = now()->sub($j, 'days')->toDateTimeString();
        $alert->save();
    }
}
