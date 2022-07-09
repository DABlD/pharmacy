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
        $size = 10;
        for($i = 1; $i <= $size; $i++){
            $this->addBhc($i);
        }
    }

    public function addBhc($i){
        $bhc = new Bhc();
        $bhc->rhu_id = rand(1, 3);
        $bhc->code = rand(10000, 99999);
        $bhc->name = "BHC$i";
        $bhc->region = "BHC$i - Region";
        $bhc->municipality = "BHC$i - Municipality";
        $bhc->save();
    }
}
