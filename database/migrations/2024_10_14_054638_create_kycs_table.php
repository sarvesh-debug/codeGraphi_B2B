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
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('aadhaar')->unique();
            $table->string('pan')->unique();
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('outlet_name');
            $table->string('aadhaar_front')->nullable();  // For storing Aadhaar front image path
            $table->string('aadhaar_back')->nullable();   // For storing Aadhaar back image path
            $table->string('pan_card')->nullable();       // For storing PAN card image path
            $table->string('done')->nullable();
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
        Schema::dropIfExists('kycs');
    }
};
