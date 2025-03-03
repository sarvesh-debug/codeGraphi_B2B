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
            $table->string('name')->after('order_id')->nullable(); // Add 'name' field
            $table->string('username')->after('name')->nullable(); // Add 'username' field
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
            $table->dropColumn(['name', 'username']);
        });
    }
};
