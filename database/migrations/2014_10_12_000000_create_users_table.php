<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            
            $table->string('name')->nullable();
            $table->string('avatar')->default('images/default_avatar.png');
            $table->enum('role', ['Admin', 'RHU', 'BHC', 'Approver'])->nullable();
            
            $table->string('email')->unique()->nullable();
            $table->text('address')->nullable();
            $table->string('contact')->nullable();

            $table->string('password');

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
        Schema::dropIfExists('users');
    }
}
