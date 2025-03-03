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
        Schema::table('pancard', function (Blueprint $table) {
            $table->string('apply_for')->nullable()->after('mode'); // Add 'apply_for' column
            $table->decimal('balance', 10, 2)->default(0)->after('apply_for'); // Add 'balance' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pancard', function (Blueprint $table) {
            $table->dropColumn(['apply_for', 'balance']);
        });
    }
};
