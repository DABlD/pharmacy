<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bhc;

class BhcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size = 3;
        $ctr = 1;

        for($i = 1; $i <= 9; $i++){
            for($j = 1; $j <= $size; $j++){
                $this->addBhc($ctr, $i);
                $ctr++;
            }
        }
    }

    public function addBhc($i, $rid){
        $bhc = new Bhc();
        $bhc->rhu_id = $rid;
        $bhc->code = rand(10000, 99999);
        $bhc->name = "BHC$i";
        $bhc->region = "BHC$i - Region";
        $bhc->municipality = "BHC$i - Municipality";
        $bhc->save();
    }
}
