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
        Schema::create('saless', function (Blueprint $table) {
            $table->id();
            $table->date("sale_date");
            $table->integer("total_price");
            $table->integer("total_pay");
            $table->integer("total_return")->nullable();
            $table->integer("customer_id")->nullable();
            $table->integer("user_id");
            $table->integer("point")->nullable();
            $table->integer("total_point")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saless');
    }
};
