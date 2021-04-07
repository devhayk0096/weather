<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_results', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('country_code')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->tinyInteger('temperature');
            $table->tinyInteger('temp_max')->nullable();
            $table->tinyInteger('temp_min')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('condition_name')->nullable();
            $table->date('formatted_date')->nullable();
            $table->string('formatted_day')->nullable();
            $table->bigInteger('timestamp')->nullable();
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
        Schema::dropIfExists('search_results');
    }
}
