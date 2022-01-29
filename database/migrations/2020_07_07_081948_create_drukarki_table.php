<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrukarkiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drukarki', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id('id_dr');
            $table->string('nazwa_dr', 50);
            $table->string('typ_dr', 50);
            $table->unsignedInteger('ip_dr');
            $table->string('udzial_dr', 80);
            $table->integer('nr_inwent_dr');
            $table->unsignedInteger('id_dz')->nullable();
            $table->unsignedInteger('id_dza')->nullable();
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
        Schema::dropIfExists('drukarki');
    }
}
