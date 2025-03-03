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
        Schema::create('cash_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('aadhaar_encrypted')->nullable(); // Encrypted Aadhaar
            $table->string('mobile');
            $table->string('external_ref')->unique(); // Unique external reference
            $table->decimal('amount', 10, 2); // Transaction amount
            $table->json('biometric_data'); // Biometric data
            $table->json('response_data'); // API response
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_withdrawals');
    }
};
