<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('user_id');
            $table->string('reference')->nullable();
            $table->string('requested_by')->nullable();
            $table->unsignedInteger('medicine_id')->nullable();
            $table->unsignedInteger('request_qty')->nullable();
            $table->string('lot_number')->nullable();
            $table->datetime('expiry_date')->nullable();
            $table->unsignedInteger('stock')->nullable();
            $table->float("unit_price", 8, 2)->nullable();
            $table->float("amount", 8, 2)->nullable();
            $table->unsignedInteger('approved_qty')->nullable();
            $table->datetime('transaction_date')->nullable();
            $table->datetime('date_approved')->nullable();
            $table->string('status')->default("For Approval");
            
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
        Schema::dropIfExists('requests');
    }
}
