<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Medicine, Reorder};

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size = 10;
        $ctr = 1;

        for($i = 2; $i <= 4; $i++){
            for($j = 1; $j <= $size; $j++){
                $this->addMedicine($ctr, $i);
                $ctr++;
            }
        }
    }

    public function addMedicine($i, $uid){
        $medicine = new Medicine();
        $medicine->user_id = $uid;
        $medicine->category_id = rand(1, 5);
        $medicine->code = rand(10000, 99999);
        $medicine->brand = "Brand" . rand(1,5);
        $medicine->name = "Medicine$i";
        $medicine->packaging = rand(1, 20) . "/PC";
        $medicine->unit_price = rand(1, 5) * 50;
        $medicine->cost_price = $medicine->unit_price - 25;
        $medicine->save();

        $reorder = new Reorder();
        $reorder->user_id = $uid;
        $reorder->medicine_id = $medicine->id;
        $reorder->point = rand(1, 5) * 30;
        $reorder->save();
    }
}
