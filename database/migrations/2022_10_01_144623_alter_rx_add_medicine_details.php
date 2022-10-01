<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRxAddMedicineDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rxes', function (Blueprint $table){
            $table->string('item_code')->after('date');
            $table->string('item_name')->after('item_code');
            $table->string('item_description')->after('item_name');
            $table->float("price", 8, 2)->after('item_description');
            $table->smallInteger("qty")->default(0)->after('price');
            $table->string('lot_number')->after('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rxes', function (Blueprint $table){
            $table->dropColumn('item_code');
            $table->dropColumn('item_name');
            $table->dropColumn('item_description');
            $table->dropColumn('price');
            $table->dropColumn('qty');
            $table->dropColumn('lot_number');
        });
    }
}
