<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_conditions', function (Blueprint $table) {
            $table->increments('condition_id');
            $table->string('condition', '16');

            $table->engine = 'InnoDB';
        });

        Schema::create('item_categories', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('category', '16');

            $table->engine = 'InnoDB';
        });

        Schema::create('items', function (Blueprint $table) {
            $table->increments('item_id');
            $table->unsignedInteger('user_id');
            $table->string('name', '50');
            $table->string('description', '500');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('condition_id');
            $table->unsignedTinyInteger('ban_flag')->default(0);
            $table->dateTime('create_at');
            $table->string('image1', '255');
            $table->string('image2', '255')->nullable();
            $table->string('image3', '255')->nullable();
            $table->unsignedInteger('buyer_id', 1)->default(0);

            $table->engine = 'InnoDB';
            $table->foreign('category_id')->references('category_id')->on('item_categories');
            $table->foreign('condition_id')->references('condition_id')->on('item_conditions');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('buyer_id');
            $table->dateTime('create_at');
            $table->dateTime('completed_at');

            $table->engine = 'InnoDB';
            $table->primary('item_id');
            $table->foreign('item_id')->references('item_id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
        Schema::drop('item_conditions');
        Schema::drop('item_categories');
        Schema::drop('transactions');
    }
}
