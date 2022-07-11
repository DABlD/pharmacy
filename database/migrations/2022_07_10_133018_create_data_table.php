<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('medicine_id');
            $table->string('transaction_types_id');
            $table->string('reference');
            $table->string('particulars');
            $table->string('lot_number');
            $table->datetime('expiry_date');

            $table->unsignedInteger('qty');
            $table->float("unit_price", 8, 2);
            $table->float("amount", 8, 2);

            $table->datetime('transaction_date');
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
        Schema::dropIfExists('data');
    }
}
