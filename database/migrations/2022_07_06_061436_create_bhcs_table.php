<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBhcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bhcs', function (Blueprint $table) {
            $table->id();
            $table->integer('rhu_id')->unsigned();

            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('region')->nullable();
            $table->string('municipality')->nullable();

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
        Schema::dropIfExists('bhcs');
    }
}
