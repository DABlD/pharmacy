<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reorders', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger("user_id");
            $table->unsignedSmallInteger("medicine_id");
            $table->unsignedSmallInteger("point");
            
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
        Schema::dropIfExists('reorders');
    }
}
