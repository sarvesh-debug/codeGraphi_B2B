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
        Schema::create('utility_payments', function (Blueprint $table) {
            $table->id();
            $table->string('mobile')->nullable(); 
            $table->string('biller_id'); // billerId
            $table->string('external_ref'); // externalRef
            $table->string('telecom_circle')->nullable(); // telecomCircle
            $table->string('payment_mode')->default('Cash'); // paymentMode
            $table->text('payment_remarks')->nullable(); // paymentInfo->Remarks
            $table->decimal('transaction_amount', 10, 2); // transactionAmount
            $table->json('response_body')->nullable(); // API response
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
        Schema::dropIfExists('utility_payments');
    }
};
