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
        Schema::create('labour_work_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('labour_id');
            $table->integer('bricks_quantity')->default(0);
            $table->date('work_date');
            $table->boolean('is_paid')->default(0);
            $table->string('financial_year');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('labour_id')->references('id')->on('labours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labour_work_details');
    }
};
