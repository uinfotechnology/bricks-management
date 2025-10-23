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
        Schema::create('bricks_type_sub_categorys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bricks_type_category_id');
            $table->string('bricks_type_sub_category_name');
            $table->string('financial_year');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bricks_type_category_id')
                ->references('id')->on('bricks_type_categorys')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bricks_type_sub_categorys');
    }
};
