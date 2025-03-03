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
            $table->string('dis_phone')->nullable()->after('phone'); // Add dis_phone column
            $table->string('dis_name')->default('Self')->after('dis_phone'); // Add dis_name column with default value
        
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
            $table->dropColumn('dis_name'); // Remove dis_name column
            $table->dropColumn('dis_phone'); // Remove dis_phone column
        });
    }
};
