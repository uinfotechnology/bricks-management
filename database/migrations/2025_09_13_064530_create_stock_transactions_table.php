<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('party_id')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->decimal('rate', 10, 2);
            $table->decimal('gst', 10, 2)->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->enum('transaction_type', ['Purchase', 'Sale', 'Use', 'Adjustment']);
            $table->date('date');
            $table->string('financial_year');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('financial_year')->references('name')->on('financial_years')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
