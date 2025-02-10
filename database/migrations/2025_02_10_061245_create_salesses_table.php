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
        Schema::create('salesses', function (Blueprint $table) {
            $table->id();
            $table->date("sale_date");
            $table->integer("total_price");
            $table->integer("total_pay");
            $table->integer("total_return");
            $table->integer("customer_id");
            $table->integer("user_id");
            $table->integer("point");
            $table->integer("total_point");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salesses');
    }
};
