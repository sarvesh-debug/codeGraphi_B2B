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
        Schema::table('wallet_transfers', function (Blueprint $table) {
            $table->enum('type', ['cr', 'dr'])->after('transfer_id')->comment('cr for credit, dr for debit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_transfers', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
