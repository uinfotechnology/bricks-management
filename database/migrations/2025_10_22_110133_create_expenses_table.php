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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('purpose_of_expense', 255);
            $table->string('recipient_name', 255)->nullable();
            $table->decimal('amount_spent', 12, 2)->default(0);
            $table->string('payment_mode', 100)->nullable();
            $table->date('expense_date')->nullable();
            $table->string('financial_year', 20)->nullable();
            $table->text('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
