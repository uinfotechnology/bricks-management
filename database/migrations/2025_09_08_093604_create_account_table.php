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
        // company details 

        Schema::create('company_details', function(Blueprint $table){
            $table->id();
            $table->string('company_name');
            $table->string('registration_number')->nullable(); // Optional, GST / CIN
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('tan_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->timestamps();
        });
        // company financial Year
        Schema::create('financial_years', function(Blueprint $table){
            $table->id();
            $table->string('name'); // Example: '2025-2026'
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(false); // Currently running year
            $table->timestamps();
        });

        Schema::create('account', function (Blueprint $table) {
            $table->id();
            // Basic Information
            $table->string('account_type');
            $table->string('party_name');
            $table->string('contact_person')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('secondary_mobile_number')->nullable(); 
            $table->string('gst_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->decimal('opening_balance', 15, 2)->default(0); // For money amounts
            $table->text('address')->nullable();

            // Bank Details
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->date('date')->nullable();

            // Other
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};
