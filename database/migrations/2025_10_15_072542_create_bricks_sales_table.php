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
        Schema::create('bricks_sales', function (Blueprint $table) {
            $table->id();
            $table->string('bill_no', 100);
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('bricks_type_category_id');
            $table->unsignedBigInteger('bricks_type_sub_category_id')->nullable();
            $table->string('customer_name', 100);
            $table->string('customer_mobile', 15)->nullable();
            $table->text('customer_address')->nullable();
            $table->string('customer_city', 50)->nullable();
            $table->string('customer_state', 50)->nullable();
            $table->integer('quantity');
            $table->decimal('rate_per_thousand', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('amount_received', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);
            $table->string('payment_mode', 50)->nullable();
            $table->date('sale_date');
            $table->string('financial_year', 20);
            $table->string('upload_image')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('bricks_type_category_id')->references('id')->on('bricks_type_categorys')->onDelete('cascade');
            $table->foreign('bricks_type_sub_category_id')->references('id')->on('bricks_type_sub_categorys')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bricks_sales');
    }
};
