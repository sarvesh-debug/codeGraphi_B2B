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
        Schema::table('customer', function (Blueprint $table) {
            $table->string('device_id')->nullable()->after('status');
            $table->boolean('verified')->default(false)->after('device_id');
            $table->string('otp', 6)->nullable()->after('verified');
            $table->timestamp('sent_date')->nullable()->after('otp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn(['device_id', 'verified', 'otp', 'sent_date']);
        });
    }
};
