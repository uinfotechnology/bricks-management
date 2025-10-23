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
        Schema::create('bricks_stocks_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id'); // Reference to bricks_stocks
            $table->integer('bricks_type_category_id');
            $table->integer('bricks_type_sub_category_id')->nullable();
            $table->integer('bricks_quantity');
            $table->date('stock_date');
            $table->string('financial_year');
            $table->string('transaction_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stock_id')->references('id')->on('bricks_stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bricks_stocks_transactions');
    }
};
