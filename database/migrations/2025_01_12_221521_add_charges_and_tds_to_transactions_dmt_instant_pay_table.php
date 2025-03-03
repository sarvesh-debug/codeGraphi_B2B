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
            $table->decimal('charges', 10, 2)->nullable()->after('response_data');
            $table->decimal('tds', 10, 2)->nullable()->after('charges');
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
            $table->dropColumn(['charges', 'tds']);
        });
    }
};
