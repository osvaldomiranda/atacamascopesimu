<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAstronomicObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('astronomic_objects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('catalog')->nullable();
            $table->string('type_object')->nullable();
            $table->string('ra')->nullable();
            $table->string('dec')->nullable();
            $table->string('constellation')->nullable();
            $table->double('bmag',20,12)->nullable();
            $table->string('hubble')->nullable();
            $table->double('coord_ar',20,12)->nullable();
            $table->double('coord_dec',20,12)->nullable();
            $table->string('sign_dec')->nullable();
            $table->string('colloquial_name')->nullable();
            $table->string('equivalence')->nullable();
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
        Schema::dropIfExists('astronomic_objects');
    }
}
