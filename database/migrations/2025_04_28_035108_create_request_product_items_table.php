<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_product_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('request_product_id')->references('id')->on('request_products');
            $table->foreignUuid('product_id')->references('id')->on('products');
            $table->integer('qty');
            $table->string('remarks')->nullable();
            $table->enum('status', ['fulfilled', 'partial', 'out_of_stock'])->default('fulfilled');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_product_items');
    }
}
