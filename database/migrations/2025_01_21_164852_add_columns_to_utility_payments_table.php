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
        Schema::table('utility_payments', function (Blueprint $table) {
            $table->decimal('opening_balance', 15, 2)->after('response_body')->nullable();
            $table->decimal('closing_balance', 15, 2)->after('opening_balance')->nullable();
            $table->decimal('charges', 10, 2)->after('closing_balance')->nullable();
            $table->decimal('tds', 10, 2)->after('charges')->nullable();
            $table->decimal('commission', 10, 2)->after('tds')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('utility_payments', function (Blueprint $table) {
            $table->dropColumn(['opening_balance', 'closing_balance', 'charges', 'tds', 'commission']);
        
        });
    }
};
