<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attribute_option_skus', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('attribute_option_id');
            $table->unsignedMediumInteger('sku_id');

            $table->foreign('attribute_option_id')->references('id')->on('attribute_options')->onDelete('RESTRICT');
            $table->foreign('sku_id')->references('id')->on('skus')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_option_skus');
    }
};
