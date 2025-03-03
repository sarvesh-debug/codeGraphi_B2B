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
        Schema::table('business', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->unique();
            $table->string('name');
            $table->string('owner');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('state');
            $table->string('city');
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->decimal('lockBalance', 15, 2)->default(0.00);
            $table->string('pin', 6);
            $table->text('full_address');
            $table->string('bank_name');
            $table->string('account_no');
            $table->string('ifsc_code');
            $table->string('pan_no');
            $table->string('profile_image')->nullable();
            $table->string('pan_image')->nullable();
            $table->string('bank_document')->nullable();
           
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
        Schema::table('business', function (Blueprint $table) {
            Schema::dropIfExists('business');
        });
    }
};
