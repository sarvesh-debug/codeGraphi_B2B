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
            $table->string('status')->default('pending')->after('column_name'); // Replace 'column_name' with the column after which you want to add this
            $table->string('txnid')->nullable()->after('status');
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
            $table->dropColumn('status');
            $table->dropColumn('txnid');
        });
    }
};
