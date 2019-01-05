<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('shorturl.drivers.local.table_name'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('long_url', config('shorturl.drivers.local.index_key_prefix_size'))->unique();
            $table->string('short_url', 10)->unique();
            $table->bigInteger('clicks')->nullable();
            $table->text('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('shorturl.drivers.local.table_name'));
    }
}

