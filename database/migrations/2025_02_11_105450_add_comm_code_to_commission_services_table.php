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
        Schema::table('CommissionServices', function (Blueprint $table) {
            $table->string('CommCode')->nullable()->after('serviceName'); // Adding CommCode column after serviceName
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('CommissionServices', function (Blueprint $table) {
            $table->dropColumn('CommCode'); // Remove the CommCode column on rollback
        });
    }
};
