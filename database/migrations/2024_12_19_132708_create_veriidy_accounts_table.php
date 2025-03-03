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
        Schema::create('veriidy_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('updated');
            $table->string('mobile');
            $table->string('benename');
            $table->string('beneMmobile');
            $table->string('accno');
            $table->unsignedBigInteger('bankId');
            $table->string('ifsc');
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
        Schema::dropIfExists('veriidy_accounts');
    }
};
