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
        Schema::table('commission_plan', function (Blueprint $table) {
            $table->string('sub_service')->nullable(); // Add the sub_service column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commission_plan', function (Blueprint $table) {
            $table->dropColumn('sub_service');
        });
    }
};
