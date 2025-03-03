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
        Schema::table('get_commission', function (Blueprint $table) {
            $table->string('externalRef', 100)->nullable()->after('closing_bal')->comment('External Reference'); // Adding the externalRef column
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('get_commission', function (Blueprint $table) {
            //
        });
    }
};
