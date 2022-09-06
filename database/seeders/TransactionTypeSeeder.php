<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionType;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            ["Physical Count", "+", 0, 0],
            ["Sales", "-", 0, 0],
            ["Sales Return", "+", 0, 0],
            ["Ending Inventory", null, 0, 0],
            ["Purchase Order", "+", 0, 0],
            ["Issued To", "-", 0, 0],
            ["Receive", "+", 0, 0],
            ["Adj. Entry Plus", "+", 0, 0],
            ["Adj. Entry Minus", "-", 0, 0]
        ];

        for($i = 2; $i <= 4; $i++){
            foreach($array as $type){
                $this->addTransactionType($type[0], $type[1], $type[2], $type[3], $i);
            }
        }
    }

    public function addTransactionType($type, $operator, $inDashboard, $canDelete, $admin_id){
        $tType = new TransactionType();
        $tType->admin_id = $admin_id;
        $tType->type = $type;
        $tType->operator = $operator;
        $tType->inDashboard = $inDashboard;
        $tType->canDelete = $canDelete;
        $tType->save();
    }
}