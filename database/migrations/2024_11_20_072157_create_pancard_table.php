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
        Schema::create('pancard', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('number'); // Add 'number' field
            $table->string('mode'); // Add 'mode' field
            $table->text('response_body');
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
        Schema::dropIfExists('pancard');
    }
};
