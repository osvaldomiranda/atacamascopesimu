<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('command');
            $table->string('type');
            $table->string('status'); 
            $table->double('ar', 12, 4)->nullable();  
            $table->double('dec', 12, 4)->nullable();
            $table->integer('exptime')->nullable(); 
            $table->integer('iso')->nullable();
            $table->integer('steps')->nullable();
            $table->integer('direction')->nullable(); 
            $table->integer('iso')->nullable();
            $table->integer('user_id')->references('id')->on('user');
            $table->integer('equipment_id')->references('id')->on('equipment'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commands');
    }
}
