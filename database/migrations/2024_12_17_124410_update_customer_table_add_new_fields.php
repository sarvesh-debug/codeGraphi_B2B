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
            // Adding address-related fields
            $table->string('address_aadhar')->nullable()->after('balance'); // Address (As per Aadhar)
            $table->string('full_address')->nullable()->after('address_aadhar'); // Full Address
            $table->string('city')->nullable()->after('full_address'); // City
            $table->string('state')->nullable()->after('city'); // State
            $table->string('pincode', 6)->nullable()->after('state'); // Pin
            
            // Adding Aadhar details
            $table->string('aadhar_no', 12)->nullable()->after('pincode'); // Aadhar Number
            $table->string('aadhar_front')->nullable()->after('aadhar_no'); // Aadhar Front Page Upload
            $table->string('aadhar_back')->nullable()->after('aadhar_front'); // Aadhar Back Page Upload

            // Adding PAN details
            $table->string('pan_no', 10)->nullable()->after('aadhar_back'); // PAN Number
            $table->string('pan_image')->nullable()->after('pan_no'); // PAN Image Upload

            // Adding bank details
            $table->string('account_no')->nullable()->after('pan_image'); // Account Number
            $table->string('ifsc_code')->nullable()->after('account_no'); // IFSC Code
            $table->string('bank_name')->nullable()->after('ifsc_code'); // Bank Name
            $table->string('bank_document')->nullable()->after('bank_name'); // Bank Document Upload (Passbook, Cheque, etc.)
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
            // Dropping added columns
            $table->dropColumn([
                'address_aadhar',
                'full_address',
                'city',
                'state',
                'pin',
                'aadhar_no',
                'aadhar_front',
                'aadhar_back',
                'pan_no',
                'pan_image',
                'account_no',
                'ifsc_code',
                'bank_name',
                'bank_document'
            ]);
        });
    }
};
