<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('bill_no')->unique();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('party_id');
            $table->decimal('rate', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('gst', 10, 2)->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->enum('payment_status', ['paid', 'due', 'unpaid'])->default('unpaid');
            $table->string('financial_year');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('financial_year')->references('name')->on('financial_years')->onDelete('cascade');
            $table->foreign('party_id')->references('id')->on('account')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
