<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Traits\MedicineAttribute;

class CreateMedicinesTable extends Migration
{
    use MedicineAttribute;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedmEDIUMInteger("user_id");
            $table->unsignedSmallInteger("category_id");

            $table->string("image")->default('images/default_medicine_avatar.png');
            $table->string("code");
            $table->string("brand");
            $table->string("name");
            $table->string("packaging");
            $table->float("unit_price", 10, 2);
            $table->float("cost_price", 10, 2);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines');
    }
}
