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
        Schema::create('transactions_dmt_instant_pay', function (Blueprint $table) {
            $table->id();
            $table->string('remitter_mobile_number');
            $table->string('reference_key');
            $table->unsignedBigInteger('customer_outlet_id'); // Add this line
            $table->json('response_data')->nullable();
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
        Schema::dropIfExists('transactions_dmt_instant_pay');
    }
};
