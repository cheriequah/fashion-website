<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('image');
            $table->text('description');
            $table->bigInteger('color_id')->unsigned()->nullable();
            $table->float('price');
            $table->float('discount');
            $table->enum('is_featured',['Yes','No']);
            $table->tinyInteger('status');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('pattern_id')->unsigned()->nullable();
            $table->bigInteger('occasion_id')->unsigned()->nullable();
            $table->bigInteger('sleeve_id')->unsigned()->nullable();
            $table->bigInteger('material_id')->unsigned()->nullable();
            $table->timestamps();

            // when parent table row is deleted then child table will be set to null
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('set null');
            $table->foreign('occasion_id')->references('id')->on('occasions')->onDelete('set null');
            $table->foreign('sleeve_id')->references('id')->on('sleeves')->onDelete('set null');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
