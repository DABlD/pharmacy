<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rxes', function (Blueprint $table) {
            $table->id();
            
            $table->string('ticket_number');
            $table->string('patient_id');
            $table->string('patient_name');
            $table->string('contact');
            $table->string('address');
            $table->float("amount", 8, 2);
            $table->string('date');

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
        Schema::dropIfExists('rxes');
    }
}
