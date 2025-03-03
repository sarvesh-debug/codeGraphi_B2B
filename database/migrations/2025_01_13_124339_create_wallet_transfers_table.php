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
        Schema::create('wallet_transfers', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('sender_id'); // ID of the sender
            $table->string('receiver_id'); // ID of the receiver
            $table->decimal('amount', 15, 2); // Transfer amount
            $table->decimal('opening_balance', 15, 2); // Sender's opening balance
            $table->decimal('closing_balance', 15, 2); // Sender's closing balance
            $table->decimal('charges', 15, 2)->default(0); // Charges for the transfer
            $table->decimal('tds', 15, 2)->default(0); // Tax Deducted at Source
            $table->string('remark', 255)->nullable(); // Optional remark
            $table->string('transfer_id', 100)->unique(); // Unique transfer ID
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraints
            $table->foreign('sender_id')->references('username')->on('customer')->onDelete('cascade');
            $table->foreign('receiver_id')->references('username')->on('customer')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transfers');
    }
};
