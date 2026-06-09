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
        Schema::create('related_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_product_id');
            $table->unsignedBigInteger('related_product_id');
            $table->enum('relation_type', ['alternative', 'related']);
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('main_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('related_product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related_products');
    }
};
