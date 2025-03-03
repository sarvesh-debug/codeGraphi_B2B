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
        Schema::table('add_moneys', function (Blueprint $table) {
            $table->decimal('openingBalance', 10, 2)->after('amount')->nullable();
            $table->decimal('closingBalance', 10, 2)->after('openingBalance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('add_moneys', function (Blueprint $table) {
            $table->dropColumn(['openingBalance', 'closingBalance']);
        });
    }
};
