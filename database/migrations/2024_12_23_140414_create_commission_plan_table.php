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
        Schema::create('commission_plan', function (Blueprint $table) {
            $table->id(); // Serial Number (Primary Key)
            $table->string('service');
            $table->decimal('from_amount', 10, 2);
            $table->decimal('to_amount', 10, 2);
            $table->decimal('charge', 10, 2);
            $table->decimal('commission', 10, 2);
            $table->decimal('tds', 10, 2);
            $table->string('charge_in'); // e.g., Percentage or Flat
            $table->string('commission_in'); // e.g., Percentage or Flat
            $table->string('tds_in'); // e.g., Percentage or Flat
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
        Schema::dropIfExists('commission_plan');
    }
};
