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
        Schema::table('transactions_dmt_instant_pay', function (Blueprint $table) {
            $table->string('second_no')->nullable()->after('remitter_mobile_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions_dmt_instant_pay', function (Blueprint $table) {
            $table->dropColumn('second_no');
        });
    }
};
