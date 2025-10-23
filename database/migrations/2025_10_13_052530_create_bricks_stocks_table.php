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
        Schema::create('bricks_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('bricks_type_category_name');
            $table->unsignedBigInteger('bricks_type_category_id');
            $table->string('bricks_type_sub_category_name')->nullable();
            $table->unsignedBigInteger('bricks_type_sub_category_id')->nullable();
            $table->integer('bricks_quantity')->default(0);
            $table->timestamps();

            $table->foreign('bricks_type_category_id')
                ->references('id')
                ->on('bricks_type_categorys')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bricks_stocks');
    }
};
