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
        $size = 5;
        for($i = 1; $i <= $size; $i++){
            $this->addCategory($i);
        }
    }

    public function addCategory($i){
        $category = new Category();
        $category->name = "Category $i";
        $category->save();
    }
}