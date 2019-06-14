<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToAstronomicObject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('astronomic_objects', function (Blueprint $table) {
            $table->string('exp_time')->nullable();
            $table->string('iso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('astronomic_objects', function (Blueprint $table) {
            $table->dropColumn('exp_time');
            $table->dropColumn('iso');
        });
    }
}
