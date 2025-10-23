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
        Schema::create('labours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('labour_type_id');
            $table->decimal('rate_per_thousand', 8, 2);
            $table->string('name');
            $table->string('mobile_number', 15)->nullable();
            $table->string('secondary_mobile_number', 15)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('aadhar_no', 20)->unique()->nullable();
            $table->string('pan_number', 15)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();

            $table->string('financial_year');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('labour_type_id')
                ->references('id')->on('labour_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laburs');
    }
};
