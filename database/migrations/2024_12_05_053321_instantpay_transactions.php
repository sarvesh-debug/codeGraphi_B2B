<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('instantpay_transactions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->bigInteger('outlet_id'); // Outlet ID from the session
            $table->string('mobile', 15); // Mobile number from the request
            $table->string('account_number', 20)->nullable(); // Account number
            $table->string('ifsc', 15)->nullable(); // IFSC code
            $table->string('transfer_mode', 50)->nullable(); // Transfer mode
            $table->decimal('transfer_amount', 10, 2)->nullable(); // Transfer amount
            $table->decimal('latitude', 10, 8)->nullable(); // Latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Longitude
            $table->string('reference_key')->nullable(); // Reference key
            $table->string('otp', 6)->nullable(); // OTP
            $table->json('response_data'); // API response stored as JSON
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instantpay_transactions');
    }
};
