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
        Schema::create('add_moneys', function (Blueprint $table) {
            $table->id();
$table->string('request_by');
$table->string('phone');
$table->string('id_code');
$table->unsignedBigInteger('bank_id'); // Foreign key for bank details
$table->string('ifsc')->nullable(); // IFSC code
$table->string('account_no')->nullable(); // Account number
$table->decimal('amount', 10, 2); // Amount
$table->string('utr')->unique(); // Transaction ID / UTR
$table->date('date'); // Transaction date
$table->boolean('status')->default(false); // Status field (true/false)
$table->string('mode'); // Mode of transaction (IMPS, NEFT, etc.)
$table->json('slip_images')->nullable(); // Slip images (stored as JSON for multiple files)
$table->string('remark')->nullable(); // Remark
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
        Schema::dropIfExists('add_moneys');
    }
};
