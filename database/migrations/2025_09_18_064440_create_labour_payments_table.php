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
        Schema::create('labour_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('labour_id');
            $table->integer('total_bricks');
            $table->decimal('current_payment', 15, 2)->nullable();
            $table->decimal('total_payment', 15, 2);
            $table->decimal('paid_amount', 15, 2)->nullable();
            $table->decimal('due_amount', 15, 2)->nullable();
            $table->date('payment_date');
            $table->string('financial_year');
            $table->string('remarks', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('labour_id')
                ->references('id')->on('labours')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labour_payments');
    }
};
