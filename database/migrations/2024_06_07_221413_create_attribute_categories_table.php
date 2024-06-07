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
        Schema::create('attribute_categories', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('category_id');
            $table->unsignedMediumInteger('attribute_id');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('RESTRICT');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_categories');
    }
};
