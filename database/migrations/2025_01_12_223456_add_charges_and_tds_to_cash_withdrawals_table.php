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
        Schema::table('cash_withdrawals', function (Blueprint $table) {
            $table->decimal('commissions', 10, 2)->after('amount')->nullable()->comment('Transaction charges');
            $table->decimal('tds', 10, 2)->after('commissions')->nullable()->comment('Tax Deducted at Source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_withdrawals', function (Blueprint $table) {
            $table->dropColumn(['commissions','tds']);
        });
    }
};
