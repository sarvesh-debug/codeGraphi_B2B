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
        Schema::create('get_commission', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('retailermobile', 15)->comment('Retailer Mobile Number');
            $table->string('service')->comment('Service Name');
            $table->string('sub_services')->comment('Sub-services Name');
            $table->decimal('opening_bal', 10, 2)->comment('Opening Balance');
            $table->decimal('commission', 10, 2)->comment('Commission Earned');
            $table->decimal('tds', 10, 2)->comment('Tax Deducted at Source');
            $table->decimal('amount', 10, 2)->comment('Transaction Amount');
            $table->decimal('closing_bal', 10, 2)->comment('Closing Balance');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('get_commission');
    }
};
