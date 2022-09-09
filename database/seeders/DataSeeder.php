<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Data;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                      //UID, MID, BID, TID, SIZE
        $this->addData(2, [1,5], [1,9], [2, 2], 5);
        $this->addData(5, [1,5], [1,3], [2, 2], 5);

        $this->addData(3, [1,5], [10, 12], [2, 2], 5);
    }

    private function addData($uid, $mid, $bid, $tid, $size){
        for($i = 0; $i < $size; $i++){
            $data = new Data();
            $data->user_id = $uid;
            $data->medicine_id = rand($mid[0], $mid[1]);
            $data->bhc_id = rand($bid[0], $bid[1]);
            $data->transaction_types_id = rand($tid[0], $tid[1]);
            $data->reference = "Test " . now()->format("H:m A");
            $data->particulars = "Test";
            $data->lot_number = rand(100000, 999999);
            $data->expiry_date = now()->add(rand(6, 12), 'months')->toDateString();
            $data->qty = rand(10,20);
            $data->unit_price = $data->qty + 5;
            $data->amount = $data->qty * $data->unit_price;
            $data->transaction_date = now()->sub(6, 'days')->add(rand(1, 6), 'days')->toDateTimeString();
            $data->save();
        }
    }
}
