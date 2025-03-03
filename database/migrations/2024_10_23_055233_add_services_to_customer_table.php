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
            $table->boolean('aeps')->default(false); // AEPS service flag (e.g., enabled/disabled)
            $table->boolean('dmt')->default(false); // DMT service flag
            $table->boolean('payout')->default(false); // Payout service flag
            $table->boolean('cc_bill_payment')->default(false); // Credit card bill payment service flag
            $table->boolean('pan')->default(false); // PAN card service flag
            $table->boolean('cc_links')->default(false); // Credit card links service flag
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
            $table->dropColumn(['aeps', 'dmt', 'payout', 'cc_bill_payment', 'pan', 'cc_links']);
        });
    }
};
