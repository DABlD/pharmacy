<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 2; $i <= 4; $i++){
            $size = rand(1,5);
            for($j = 1; $j <= $size; $j++){
                $this->addCategory($i, $j);
            }
        }
    }

    public function addCategory($i, $j){
        $category = new Category();
        $category->admin_id = $i;
        $category->name = "Category $j";
        $category->save();
    }
}