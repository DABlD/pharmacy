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
        ];

        foreach($array as $type){
            $this->addTransactionType($type[0], $type[1], $type[2], $type[3]);
        }
    }

    public function addTransactionType($type, $operator, $inDashboard, $canDelete){
        $tType = new TransactionType();
        $tType->type = $type;
        $tType->operator = $operator;
        $tType->inDashboard = $inDashboard;
        $tType->canDelete = $canDelete;
        $tType->save();
    }
}