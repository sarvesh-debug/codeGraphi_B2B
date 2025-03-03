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
        Schema::create('dis_commission', function (Blueprint $table) {
            $table->id();
            $table->string('dis_no')->unique();
            $table->string('services');
            $table->string('retailer_no');
            $table->decimal('commission', 8, 2); // Adjust precision if needed
            $table->decimal('opening_balance', 12, 2); // Adjust precision if needed
            $table->decimal('closing_balance', 12, 2); // Adjust precision if needed
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dis_commission');
    }
};
