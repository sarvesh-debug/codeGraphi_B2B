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
            $table->decimal('openingB', 15, 2)->nullable()->after('response_body');
            $table->decimal('closingB', 15, 2)->nullable()->after('openingB');
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
            $table->dropColumn(['openingB', 'closingB']);
        });
    }
};
