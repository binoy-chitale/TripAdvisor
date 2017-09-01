<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttractionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attractions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('start_time')->default(null);
            $table->string('end_time')->default(null);
            $table->string('duration')->default(null);
            $table->string('rating');
            $table->longText('description');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('phone');
            $table->string('address');
            $table->string('rank');
            $table->longText('images');
            $table->string('split_ratings');
            $table->string('stars');
            $table->integer('dest_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attractions');
    }
}
