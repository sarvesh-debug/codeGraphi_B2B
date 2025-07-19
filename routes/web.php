<?php

use App\Http\Controllers\accountStatementController;
use App\Http\Controllers\AccountVerificationController;
use App\Http\Controllers\AddBankController;
use App\Http\Controllers\addMoneyController;
use App\Http\Controllers\aepsPayoutController;
use App\Http\Controllers\AmountController;
use App\Http\Controllers\bbpsController;
use App\Http\Controllers\cgPayoutController;
use App\Http\Controllers\cmsController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\creditCradBBPSController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DigifintelUpiController;
use App\Http\Controllers\dmtinstantpayController;
use App\Http\Controllers\dmtpaysprintController;
use App\Http\Controllers\dthRechargeController;
use App\Http\Controllers\electricityBillController;
use App\Http\Controllers\fastTagRechargeController;
use App\Http\Controllers\gasBillController;
use App\Http\Controllers\infoController;
use App\Http\Controllers\insuranceBillController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\merchantController;
use App\Http\Controllers\nifiPayoutController;
use App\Http\Controllers\otherServiceController;
use App\Http\Controllers\otpsmsController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PanCardController;
use App\Http\Controllers\payoutInstantPaycontroller;
use App\Http\Controllers\postPaidRechargeController;
use App\Http\Controllers\LandlineController;
use App\Http\Controllers\WaterController;
use App\Http\Controllers\BroadbandController;
use App\Http\Controllers\prePaidRechargeController;
use App\Http\Controllers\digifintelRechargeController;
use App\Http\Controllers\digifintelController;
// use App\Http\Controllers\digifintelDthRechargeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\transtionStatusController;
use App\Http\Controllers\walletToWalletController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\paymentGatewayController;
use App\Http\Controllers\aepsController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\RemitterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\BinCheckerController;
use App\Http\Controllers\CMSGUIController;
use App\Http\Controllers\applyCreditCardController;


Route::get('/test-error', function () {
    abort(500);
});



Route::get('admin', function () {
    // return view('welcome');
    return redirect()->away('https://paybrill.com/');
})->name('admin');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('testing.pal',function(){
    return view('user.testing.recept');
});
Route::get('/download-excel', [CustomerController::class, 'downloadExcel'])->name('ddfile');

Route::get('/', function () {
    return redirect()->away('https://paybrill.com/');
});
// user Auth

Route::get('/info/testing',[infoController::class,'getTodayTransation']);

Route::get('/testing.pan',[AmountController::class,'getPandata'])->name('pantest');

Route::get('/testing.cpm',[dmtinstantpayController::class,'demotest'])->name('deo');

Route::get('/testing.pp',[bbpsController::class,'bbpstest'])->name('deo.r');
Route::get('/testing.aeps',[aepsController::class,'testDemo'])->name('deoa')
;
Route::get('/customer/login', [CustomerController::class, 'showForm'])->name('customer.login');
Route::post('/verify-pin', [CustomerController::class, 'verifyPin'])->name('verify.pin');


Route::get('forgot-password', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::post('forgot-password1', [PasswordResetController::class, 'sendResetLink1'])->name('password.email1');

Route::get('reset-password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::get('reset-password/reset1', [PasswordResetController::class, 'showResetForm1'])->name('password.reset1');
Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
Route::post('reset-password1', [PasswordResetController::class, 'resetPassword1'])->name('password.update1');
Route::post('reset-password/otp', [PasswordResetController::class, 'forgetPasswors'])->name('forgetPassworsAuth');
Route::post('reset-password/otp1', [PasswordResetController::class, 'forgetPasswors1'])->name('forgetPassworsAuth1');
    
// Route::post('/customer/loginF', [CustomerController::class, 'login'])->name('customer.loginF');
Route::post('/verify-otp', [otpsmsController::class, 'verifyOtp'])->name('verify.otp');

Route::match(['get', 'post'], '/customer/loginF', [CustomerController::class, 'login'])->name('customer.loginF');

Route::post('login/user/otp', [CustomerController::class, 'oneVerifyOtp'])->name('oneVerify.otp');

Route::middleware('auth.customer')->group(function () {

Route::post('reset-password/profile', [PasswordResetController::class, 'resetPasswordProfile'])->name('password.updateProfile');

Route::get('/change/password',[CustomerController::class,'changePassForm'])->name('change.ProfilePassword');
    
Route::get('/add-new', [CustomerController::class, 'addnewForm'])->name('add-new');
    Route::get('/list', [CustomerController::class, 'listData'])->name('list.new');
    
Route::put('/customers/{id}/update-package', [CustomerController::class, 'updatePackage'])->name('customer.updatePackage');




Route::get('customer/dashboard',[AmountController::class,'getSenderAmount'])->name('customer/dashboard');
Route::get('/get/profile', [CustomerController::class, 'getProfile'])->name('get.profile');

    
Route::get('remitter/certificate',function(){
return view('user.auth.certificate');
})->name('remitter.certificate');
    // Route::get('customer/dashboard', function () {
    //     return view('customer.dashboard');
    // })->name('customer.dashboard');

   
    
    // Route::get('customer/dashboard',function(){
    //     return view('user/home-page');
    // })->name('customer/dashboard');
    // Route::get('customer/dashboard',function(){
    //     return view('user/home-page');
    // })->name('customer/dashboard');

    
    // Route::get('/user',function(){
    //     return view('user.auth.index');


    // })->name('customer.login1');
    
    // Route::get('/customer/login', [CustomerController::class, 'showForm'])->name('customer.login');
    
    // Route::post('/customer/loginF', [CustomerController::class, 'login'])->name('customer.loginF');
    Route::get('/coustomer.logout', [CustomerController::class, 'logout'])->name('coustomer.logout');
    
    Route::get('/user/fund-transfer/bank-account',[AddBankController::class,'getBankDetails'])->name('/user/fund-transfer/bank-account');
    
    Route::get('/user/wallet/index',function(){
        return view('user/wallet.index');
    })->name('/user/wallet/index');
    // AEPS
    Route::get('/wallet/transfer', [aepsController::class, 'walletTxnForm'])->name('walletTxnForm');
    Route::post('wallet/tsfr',[aepsController::class,'transfer'])->name('wallet.tsfr');
Route::get('wallet/his',[aepsController::class,'aepsTxn'])->name('wallet.aepsTxn');
    
    Route::get('/cash-withdrawal', [aepsController::class, 'showForm'])->name('cash.withdrawal.form');
    // Route::post('/cash-withdrawal', [aepsController::class, 'makeWithdrawal'])->name('cash.withdrawal');
    Route::get('/aeps/balance-inquiry', [aepsController::class, 'balanceInquiry_show'])->name('balance.enquiry-form');
    Route::post('/aeps/balance-inquiry', [aepsController::class, 'balanceInquiry'])->name('balance.enquiry');
    Route::get('/aeps/balance-statement', [aepsController::class, 'miniStatement'])->name('balance.statement');
    Route::post('/aeps/cash-withdrawal', [aepsController::class, 'cashWithdrawal'])->name('cash.withdrawal');  
    Route::post('/aeps/balance-statemen', [aepsController::class, 'balanceStatement'])->name('balance.statementAPI');

    Route::post('/aeps/cashWithdrawal', [aepsController::class, 'cashWithdrawal'])->name('cashWithdrawal');

    Route::get('/aeps/history', [aepsController::class, 'history'])->name('aeps.history');
    Route::get('/aeps/sattlement', [aepsPayoutController::class, 'index'])->name('aeps.sattlementForm');
    Route::post('/aeps/sattlement', [aepsPayoutController::class, 'submit'])->name('aeps.sattlement');

    //cash deposite
    Route::get('/aeps.cash/deposit',[aepsController::class,'cashDepositForm'])->name('aepsCashDeposit.form');
    Route::post('/aeps.cash/deposit',[aepsController::class,'cashDeposit'])->name('aepsCashDeposit');
    Route::get('/admin/AEPS/balance-enquiry',function(){
        return view('user/AEPS.balance-enquiry');

    });
    Route::get('/user/AEPS/cash-withdrawal',function(){
        return view('user/AEPS.cash-withdrawal');
    })->name('/user/AEPS/cash-withdrawal');
   
    Route::get('/admin/AEPS/mini-statement',function(){
        return view('user/AEPS.mini-statement');
    });
    
    Route::get('/user/money-transfer/money-transfer',function(){
        return view('user/money-transfer.money-transfer');
    })->name('/user/money-transfer/money-transfer');
    // bbps
    Route::get('/user/bbps/bbps-services',function(){
        return view('user/bbps.index');
    })->name('/user/bbps/bbps-services');
    
    // mobile
    Route::get('/user/dth/dth-recharge',function(){
        return view('user/dth.index');
    })->name('/user/dth/dth-recharge');
    
    // DTH
    Route::get('/user/mobile/mobile-recharge',function(){
        return view('user/mobile.index');
    })->name('/user/mobile/mobile-recharge');
    
    
    // service
    Route::get('/user/services/services',function(){
        return view('user/services.services');
    })->name('/user/services/services');
    //commissiion pALne
    Route::get('/user/commission-plane',function(){
        return view('user.commission-plan');
    })->name('/user/commission-plane');
    
    Route::get('/user/AEPS/aeps-statement',function(){
        return view('user/AEPS.aeps-statement');
    })->name('/user/AEPS/aeps-statement');
    
    Route::get('/admin/account-opening',function(){
        return view('user/account-opening.index');
    });
    
    Route::get('/admin/services',function(){
        return view('admin/services.services');
    });
    
    // user-statement
    Route::get('/user/statement/account-stmt',function(){
        return view('user/statements.account-stmt');
    })->name('statement/account-stmt');
    
    Route::get('/user/statement/fund-report',function(){
        return view('user/statements.fund-report');
    })->name('statement/fund-report');
    
    Route::get('/user/statement/fund-transfer-report',function(){
        return view('user/statements.fund-transfer-report');
    })->name('statement/fund-transfer-report');
    
    Route::get('/user/statement/money-transfer-report',function(){
        return view('user/statements.money-transfer-report');
    })->name('statement/money-transfer-report');
    
    Route::get('/user/statement/wallet-transfer-report',function(){
        return view('user/statements.wallet-transfer-report');
    })->name('statement/wallet-transfer-report');
    
    
    //payment Getway 
    // Route::get('/user/fund-transfer/payment-getway',function(){
    //     return view('user/fund-transfer.payment-gateway');
    // })->name('/user/fund-transfer/payment-getway');
    
    Route::post('/process-payment', [paymentGatewayController::class, 'processPayment'])->name('process.payment');
    Route::get('/redirect-page', [paymentGatewayController::class, 'paymentRedirect'])->name('payment.redirect');
    Route::get('/process-payment-gateway', [paymentGatewayController::class, 'index'])->name('process-payment-gateway');
    
    Route::get('/payment-response', [paymentGatewayController::class, 'checkOrderStatus'])->name('payment.response');
    
    // kyc
    Route::get('user/kyc-form',[KycController::class,'userCreate'])->name('user/kyc-form');
    Route::post('user/kyc/store', [KycController::class, 'store'])->name('user/kyc.store');
   // Route::get('user/kyc/details/{id}', [KycController::class, 'showDetails'])->name('user.kyc.details');

   Route::get('/user/kyc/details', [KycController::class, 'showKycDetails'])->name('kyc.details');



//    DMT all information
Route::get('/register-beneficiary/{mobile}', [BeneficiaryController::class, 'registerForm'])->name('register.form');
Route::post('/register-beneficiary', [BeneficiaryController::class, 'registerBeneficiary'])->name('register.beneficiary');

Route::get('/delete-beneficiary/{mobile}/{bene_id}', [BeneficiaryController::class, 'deleteForm'])->name('delete.form');
Route::post('/delete-beneficiary', [BeneficiaryController::class, 'deleteBeneficiary'])->name('delete.beneficiary');

Route::get('/fetch-beneficiary', [BeneficiaryController::class, 'fetchForm'])->name('fetch.form');
Route::post('/fetch-beneficiary', [BeneficiaryController::class, 'fetchBeneficiary'])->name('fetch.beneficiary');

Route::get('/fetch-beneficiary-beneid', [BeneficiaryController::class, 'fetchByBeneIdForm'])->name('fetch.beneid.form');
Route::post('/fetch-beneficiary-beneid', [BeneficiaryController::class, 'fetchBeneficiaryByBeneId'])->name('fetch.beneid');


Route::get('/remitter/query', [RemitterController::class, 'showQueryForm'])->name('remitter.query.form');
Route::post('/remitter/query', [RemitterController::class, 'queryRemitter'])->name('remitter.query');


Route::get('/remitter/kyc', [RemitterController::class, 'showKycForm'])->name('remitter.kyc.form');
Route::post('/remitter/kyc', [RemitterController::class, 'kycRemitter'])->name('remitter.kyc');


Route::get('/remitter/register', [RemitterController::class, 'showRegisterForm'])->name('remitter.register.form');
Route::post('/remitter/register', [RemitterController::class, 'registerRemitter'])->name('remitter.register');

//money transfer
Route::get('/transact', [TransactionController::class, 'show'])->name('transact.form');
Route::post('/transact', [TransactionController::class, 'transact'])->name('transact.perform');

Route::get('/send-beneficiary/{mobile}/{bene_id}', [TransactionController::class, 'showOTP'])->name('send.otp');

Route::post('/transact/otp', [TransactionController::class, 'sent_otp'])->name('transact.otp');



Route::get('/transact-status', [TransactionController::class, 'showStatus'])->name('transact.formStatus');
Route::post('/transact-status', [TransactionController::class, 'queryTransaction'])->name('transact.performStaus');


Route::get('/transact/refund/form', [TransactionController::class, 'showRefund'])->name('refunddmt.form');

Route::post('/transact/refund', [TransactionController::class, 'refundOtp'])->name('refund.Otp');
Route::post('/transact/refund/claim', [TransactionController::class, 'refundOtpClaim'])->name('refund.OtpClaim');
Route::get('/transact/history', [TransactionController::class, 'history'])->name('dmtps.history');



// PAN Card Verification 
// Route::get('/pan-form',[PanCardController::class,'index'])->name('panCard');

// Route::post('/pan-store',[PanCardController::class,'submitForm'])->name('pan.store');
// routes/web.php
Route::get('/pan/new', [PanCardController::class, 'newPanForm'])->name('panCard');
Route::post('/pan/new', [PanCardController::class, 'submitNewPan'])->name('pan.new.submit');

Route::get('/pan/correction', [PanCardController::class, 'correctionForm'])->name('pan.correction');
Route::post('/pan/correction', [PanCardController::class, 'submitCorrection'])->name('pan.correction.submit');

Route::get('/pan/status', [PanCardController::class, 'statusForm'])->name('pan.status');
Route::post('/pan/status', [PanCardController::class, 'checkStatus'])->name('pan.status.submit');
Route::get('/pan/history', [PanCardController::class, 'panHistory'])->name('pan.history');

Route::get('/pan/callback', [PanCardController::class, 'handleCallback'])->name('pan.callback');
Route::get('/pan/test', [PanCardController::class, 'updateCustomerBalance']);

Route::post('/get-mpin', [CustomerController::class, 'getMpin'])->name('mpin');
Route::post('/change-mpin', [CustomerController::class, 'changeMpin'])->name('changeMpin');


// AEPS API
//Route::get('/outlet-login-status', [aepsController::class, 'outlet_show'])->name('outlet-log');

Route::get('/outlet-login-status', [aepsController::class, 'checkOutletLoginStatus'])->name('checkOutletLoginStatus');


Route::get('/outlet-login/aeps', [aepsController::class, 'outletLog'])->name('outlet-login/aeps.form');
Route::post('/outlet-login/store', [aepsController::class, 'outletLogin'])->name('outlet-login/aeps.store');

Route::get('/fetch-banks/aeps', [aepsController::class, 'fetchBanks'])->name('fetch.banksA');

//Route::get('/outlet-login', [aepsController::class, 'outletLog'])->name('outletlog-new');
//Route::post('/outlet-login', [aepsController::class, 'checkOutletLoginStatus'])->name('outletlog');

// Card Bin Cheacker
Route::get('/bin-checker', [BinCheckerController::class, 'index'])->name('binChecker.form');
Route::post('/bin-checker', [BinCheckerController::class, 'checkBin'])->name('binChecker.submit');

// bank account verifiaction
Route::get('/verify-bank-account', [AccountVerificationController::class, 'getBanks'])->name('verify.bank.account');


Route::get('/outlet-login', [AccountVerificationController::class, 'accountform'])->name('account-form');
Route::post('/verify-bank-account', [AccountVerificationController::class, 'verifyBankAccount'])->name(name: 'verify.bank');



Route::get('/upi-verify', [AccountVerificationController::class, 'upiform'])->name('upiform');
Route::post('/verify-bank-upi', [AccountVerificationController::class, 'verifyUPI'])->name(name: 'verify.upi');
// transtion status 
Route::get('/transation-status',[transtionStatusController::class,'showform'])->name('transation-statusd');
Route::post('/transation-status',[transtionStatusController::class,'txnStatus'])->name('transaction.status');

// account statement
Route::post('/bank-statement', [accountStatementController::class, 'fetchStatement'])->name('bank.statement');

Route::get('/transactions', [AccountStatementController::class, 'index'])->name('transactions.form');
Route::post('/transactions/fetch', [AccountStatementController::class, 'fetchStatementWallet'])->name('transactions.fetch');
Route::post('/ordered-transactions/fetch', [accountStatementController::class, 'fetchOrderedStatement'])->name('ordered-transactions.fetch');


//Payout

Route::get('/payout/form', [payoutInstantPaycontroller::class, 'showForm'])->name('payout.form');
Route::post('/payout/create', [payoutInstantPaycontroller::class, 'createPayout'])->name('payout.create');

Route::get('/payout/card/form', [payoutInstantPaycontroller::class, 'showFormCard'])->name('payout.card');
Route::post('/payout/card/create', [payoutInstantPaycontroller::class, 'createPayoutCard'])->name('create.card');

Route::get('/get/bank/list',[payoutInstantPaycontroller::class,'getBankList'])->name('payoutBank.list');


//DMT instantpay
Route::get('/dmt-bank-account', [dmtinstantpayController::class, 'getBanksdmt'])->name('dmt.bank.account');
Route::get('/dmt-bank-remitter-profile', [dmtinstantpayController::class, 'remitterProfileShow'])->name('dmt.remitter-profile');
Route::post('/dmt-bank-remitter-profile', [dmtinstantpayController::class, 'remitterProfile'])->name('dmt.remitter-profile_chk');
Route::post('/dmt-bank-remitter-registation', [dmtinstantpayController::class, 'remitterRegistration'])->name('remitterRegistration');

Route::post('/dmt-bank-remitter-registation-verify', [dmtinstantpayController::class, 'verifyRemitterRegistration'])->name('remitterRegistrationVerify');

Route::get('/dmt-remittre/kyc', [dmtinstantpayController::class, 'remitterKycForm'])->name('dmt.remitterkyc.form');
Route::post('/dmt-remittre/kyc', [dmtinstantpayController::class, 'remitterKyc'])->name('dmt.remitter.kyc');


Route::get('/dmt-beneficiaryRegistration/Add', [dmtinstantpayController::class, 'beneficiaryRegistrationForm'])->name('dmt-beneficiaryRegistration');
Route::match(['get', 'post'], '/dmt-beneficiaryRegistration/ok', [dmtinstantpayController::class, 'beneficiaryRegistration'])->name('beneficiaryRegistration');

Route::post('/dmt-beneficiaryRegistration/kyc', [dmtinstantpayController::class, 'beneficiaryRegistrationVerify'])->name('beneficiaryRegistrationkyc');

Route::match(['get', 'post'], '/send-money',[dmtinstantpayController::class, 'showSendMoneyForm'])->name('sendMoneyForm');

Route::post('generateTransactionOtp', [dmtinstantpayController::class, 'generateTransactionOtp'])->name('generateTransactionOtp');

Route::post('dmt/transaction', [dmtinstantpayController::class, 'transaction'])->name('dmt.transaction');
Route::post('dmt/den/delete', [dmtinstantpayController::class, 'beneficiaryDelete'])->name('dmt.delete');
Route::post('dmt/den/deleteotp', [dmtinstantpayController::class, 'DeleteVerify'])->name('dmt.deleteOtp');


Route::post('dmt/den/deleteotp', [dmtinstantpayController::class, 'DeleteVerify'])->name('dmt.deleteOtp');

Route::get('/transaction-history', [dmtinstantpayController::class, 'getAllTransactions'])->name('transaction.history');
Route::get('/dmt/pending/transa ction', [dmtinstantpayController::class, 'pendingTransaction'])->name('pending.dmt');
Route::get('/transaction-rcpt/{id}', [dmtinstantpayController::class, 'DuplicateRcpt'])->name('DuplicateRcpt');
Route::get('/transactions-rcpt/{id}', [dmtinstantpayController::class, 'DuplicateRcptAd'])->name('DuplicateRcptAd');


 //PaySprint DMT
 Route::get('/dmt-remitter-profile', [dmtpaysprintController::class, 'remitterProfileShow'])->name('dmt1.remitter-profile');
Route::post('/dmt-remitter-profile', [dmtpaysprintController::class, 'remitterProfile'])->name('dmt1.remitter-profile_chk');

Route::get('/remitter/kyc', [dmtpaysprintController::class, 'showKycForm'])->name('1remitter.kyc.form');
Route::post('/remitter/kyc', [dmtpaysprintController::class, 'kycRemitter'])->name('1remitter.kyc');


Route::get('/remitter/register', [dmtpaysprintController::class, 'showRegisterForm'])->name('1remitter.register.form');
Route::post('/remitter/register', [dmtpaysprintController::class, 'registerRemitter'])->name('1remitter.register');

Route::get('/fetch-beneficiary', [dmtpaysprintController::class, 'fetchForm'])->name('1fetch.form');
Route::post('/fetch-beneficiary', [dmtpaysprintController::class, 'fetchBeneficiary'])->name('1fetch.beneficiary');

Route::get('/register-beneficiary/{mobile}', [dmtpaysprintController::class, 'registerForm'])->name('1register.form');
Route::post('/register-beneficiary', [dmtpaysprintController::class, 'registerBeneficiary'])->name('1register.beneficiary');

Route::get('/delete-beneficiary/{mobile}/{bene_id}', [dmtpaysprintController::class, 'deleteForm'])->name('1delete.form');
Route::post('/delete-beneficiary', [dmtpaysprintController::class, 'deleteBeneficiary'])->name('1delete.beneficiary');


Route::get('/fetch-beneficiary-beneid', [dmtpaysprintController::class, 'fetchByBeneIdForm'])->name('1fetch.beneid.form');
Route::post('/fetch-beneficiary-beneid', [dmtpaysprintController::class, 'fetchBeneficiaryByBeneId'])->name('1fetch.beneid');

Route::get('/transact', [dmtpaysprintController::class, 'show'])->name('1transact.form');
Route::post('/transact', [dmtpaysprintController::class, 'transact'])->name('1transact.perform');

Route::get('/send-beneficiary/{mobile}/{bene_id}', [dmtpaysprintController::class, 'showOTP'])->name('1send.otp');

Route::post('/transact/otp', [dmtpaysprintController::class, 'sent_otp'])->name('1transact.otp');



Route::get('/transact-status', [dmtpaysprintController::class, 'showStatus'])->name('1transact.formStatus');
Route::post('/transact-status', [dmtpaysprintController::class, 'queryTransaction'])->name('1transact.performStaus');


Route::get('/transact/refund/form', [dmtpaysprintController::class, 'showRefund'])->name('1refunddmt.form');

Route::post('/transact/refund', [dmtpaysprintController::class, 'refundOtp'])->name('1refund.Otp');
Route::post('/transact/refund/claim', [dmtpaysprintController::class, 'refundOtpClaim'])->name('1refund.OtpClaim');
Route::get('/transact/history', [dmtpaysprintController::class, 'history'])->name('dmtps.history');


// credit Card
Route::get('/apply-credit-card', [CreditCardController::class, 'create'])->name('credit_card.create');
Route::post('/apply-credit-card', [CreditCardController::class, 'store'])->name('credit_card.store');
Route::get('/credit-card-applications', [CreditCardController::class, 'index'])->name('credit_card.index');

//bbps
Route::get('/bbps/telecom/circle', [bbpsController::class, 'getTelecomCircle'])->name('getTelecomCircle');
Route::get('/bbps/recharge/plane', [bbpsController::class, 'getRechargePlanForm'])->name('/bbps/recharge/plane');
Route::post('/bbps/recharge/plane', [bbpsController::class, 'getRechargePlan'])->name('bbps.recharge');
Route::get('/bbps/category', [bbpsController::class, 'getCategory'])->name('getcategory');
Route::get('/bbps/billers/{key}', [bbpsController::class, 'getBillers'])->name('getbillers');

Route::post('/bbps/billerDetails', [bbpsController::class, 'getBillerDetails'])->name('bbps.billerDetails');

Route::post('/bbps/getAllData', [bbpsController::class, 'getAllData'])->name('bbps.getAllData');
Route::post('/bbps/validate', [bbpsController::class, 'paybill'])->name('bbps.validate');

// Route::match(['get', 'post'],'/bbps/getAllData', [bbpsController::class, 'getAllData'])->name('bbps.getAllData');
// Route::match(['get', 'post'],'/bbps/validate', [bbpsController::class, 'paybill'])->name('bbps.validate');
//wallet to wallet

Route::post('/wallet/transfer', [walletToWalletController::class, 'index'])->name('wallet.transfer');
//Route::get('/wallet/transfer', [walletToWalletController::class, 'sendMoney']);
Route::post('/wallet/transfer/mpney', [walletToWalletController::class, 'sendMoney'])->name('wallet.send');

Route::post('wallet/transfer/dis',[walletToWalletController::class,'disTransRel'])->name('dis.trans');
Route::get('/wallet/transfer/history', [walletToWalletController::class, 'walletHistory'])->name('wallet.History');

// Route::get('/amount',[AmountController::class,'getAEPSamount'])->name('amount');
Route::get('/amount/aeps',[AmountController::class,'addPayableValueToBalance'])->name('amount.aeps');
Route::get('/user/signup', [merchantController::class, 'showSignupForm'])->name('merchant-form');
Route::post('/user/outlet/signup', [merchantController::class, 'initiateSignup'])->name('user.outlet.signup');
Route::get('/user/outlet/signup/verify', [merchantController::class, 'showOtpForm'])->name('showOtpForm');
Route::post('/user/outlet/signup/validate', [merchantController::class, 'validateOtp'])->name('otp-verify');

Route::get('/user/outlet/signup/change/mobile', [merchantController::class, 'showOtpMobile'])->name('show.mobilechng');
Route::post('/user/outlet/signup/mobile', [merchantController::class, 'mobileValidateOtp'])->name('otp-verify.mobile');

Route::post('/user/outlet/signup/mobile/verify', [merchantController::class, 'mobileValidateVerify'])->name('otp-mobile');





Route::get('/amount',[AmountController::class,'getCommission'])->name('amount');

// SMS_OTP
Route::post('/add/slop',[addMoneyController::class,'storeSlip'])->name('add.slip');
// cms Api



Route::get('/cms-form', [CMSGUIController::class, 'showForm'])->name('cms.form');
Route::post('/cms/start', [CMSGUIController::class, 'submitStart'])->name('cms.start.submit');
Route::post('/cms/status', [CMSGUIController::class, 'submitStatus'])->name('cms.status.submit');
Route::post('/cms/callback', [CMSGUIController::class, 'handleCallback']);

Route::get('/admin/cms-transactions', [CMSGUIController::class, 'adminTransactions'])->name('cms.admin.transactions');
Route::get('/cms/export/excel', [CMSGUIController::class, 'exportExcel'])->name('cms.export.excel');
Route::get('/cms/export/pdf', [CMSGUIController::class, 'exportPDF'])->name('cms.export.pdf');

//credit Card Apply

Route::post('/generate-lead', [applyCreditCardController::class, 'generateLead'])->name('apply.card');
Route::get('/leads', [applyCreditCardController::class, 'viewLeads'])->name('leads.index');
// Commission plan
Route::get('/commission-get', [CommissionController::class, 'getAllCommission'])->name('commission.get');

Route::get('distibuter/commission',[CustomerController::class,'disCommission'])->name('disCommission.list');


// 
Route::patch('/distibuterr/update-services/{id}', [CustomerController::class, 'updateServicesD'])->name('update.servicesD');

Route::get('/ladger/statement',[infoController::class,'index'])->name('laser.statement');

// Route::get('fund/Qr',[AddBankController::class,'dispalyQr'])->name('dispalyQr1');

// Broadband Recharge
Route::get('broadband/isp',[BroadbandController::class,'index'])->name('getBroadbandISP');
Route::post('broadband/broadbandRecharge',[BroadbandController::class,'broadbandRecharge'])->name('broadbandRecharge');
Route::post('broadband/recharge',[BroadbandController::class,'broadbandRechargePay'])->name('broadbandRechargePay');


//Mobile Rechage 
Route::get('mobile/test',[prePaidRechargeController::class,'mobiletest']);

Route::get('mobile/isp',[prePaidRechargeController::class,'getISP'])->name('getISP');
Route::get('mobile/mobileRecharge',[prePaidRechargeController::class,'mobileRecharge'])->name('mobileRecharge');
Route::post('mobile/recharge',[prePaidRechargeController::class,'mobileRechargePay'])->name('mobileRechargePay');

//Digifintel Recharge
Route::get('digifintel/mobileRecharge',[digifintelRechargeController::class, 'mobileRecharge'])->name('digifintelMobileRecharge');
Route::post('digifintel/mobile/recharge',[digifintelRechargeController::class,'mobileRechargePay'])->name('digifintelMobileRechargePay');


//Digifintel Services
Route::get('customer/digifintel/dashboard',[digifintelController::class,'index'])->name('customer/digifintel/dashboard');

Route::post('customer/digifintel/pay-bill',[digifintelController::class,'digifintelBillPay'])->name('customer/digifintel/billPay');

Route::get('digifintel/electricity/bill',[digifintelController::class,'electricityBill'])->name('digifintelElectricityBill');
Route::post('digifintel/electricity/bill/fetch-params',[digifintelController::class,'electricityBillFetchParams'])->name('digifintelElectricityBillFetchParams');
Route::post('digifintel/electricity/bill-fetch',[digifintelController::class,'electricityBillFetch'])->name('digifintelElectricityBillFetch');

Route::get('digifintel/insurance/bill',[digifintelController::class,'insuranceBill'])->name('digifintelInsuranceBill');
Route::post('digifintel/insurance/bill/fetch-params',[digifintelController::class,'insuranceBillFetchParams'])->name('digifintelInsuranceBillFetchParams');
Route::post('digifintel/insurance/bill-fetch',[digifintelController::class,'insuranceBillFetch'])->name('digifintelInsuranceBillFetch');

Route::get('digifintel/emi/bill',[digifintelController::class,'emiBill'])->name('digifintelEmiBill');
Route::post('digifintel/emi/bill/fetch-params',[digifintelController::class,'emiBillFetchParams'])->name('digifintelEmiBillFetchParams');
Route::post('digifintel/emi/bill-fetch',[digifintelController::class,'emiBillFetch'])->name('digifintelEmiBillFetch');

Route::get('digifintel/gas/bill',[digifintelController::class,'gasBill'])->name('digifintelGasBill');
Route::post('digifintel/gas/bill/fetch-params',[digifintelController::class,'gasBillFetchParams'])->name('digifintelGasBillFetchParams');
Route::post('digifintel/gas/bill-fetch',[digifintelController::class,'gasBillFetch'])->name('digifintelGasBillFetch');

Route::get('digifintel/lpg/bill',[digifintelController::class,'lpgBill'])->name('digifintelLpgBill');
Route::post('digifintel/lpg/bill/fetch-params',[digifintelController::class,'lpgBillFetchParams'])->name('digifintelLpgBillFetchParams');
Route::post('digifintel/lpg/bill-fetch',[digifintelController::class,'lpgBillFetch'])->name('digifintelLpgBillFetch');


Route::get('digifintel/dth/bill',[digifintelController::class,'dthBill'])->name('digifintelDthBill');
Route::post('digifintel/dth/bill/fetch-params',[digifintelController::class,'dthBillFetchParams'])->name('digifintelDthBillFetchParams');
Route::post('digifintel/dth/bill-fetch',[digifintelController::class,'dthBillFetch'])->name('digifintelDthBillFetch');


Route::get('digifintel/water/bill',[digifintelController::class,'waterBill'])->name('digifintelWaterBill');
Route::post('digifintel/water/bill/fetch-params',[digifintelController::class,'waterBillFetchParams'])->name('digifintelWaterBillFetchParams');
Route::post('digifintel/water/bill-fetch',[digifintelController::class,'waterBillFetch'])->name('digifintelWaterBillFetch');

Route::get('digifintel/landline/bill',[digifintelController::class,'landlineBill'])->name('digifintelLandlineBill');
Route::post('digifintel/landline/bill/fetch-params',[digifintelController::class,'landlineBillFetchParams'])->name('digifintelLandlineBillFetchParams');
Route::post('digifintel/landline/bill-fetch',[digifintelController::class,'landlineBillFetch'])->name('digifintelLandlineBillFetch');

Route::get('digifintel/cable/bill',[digifintelController::class,'cableBill'])->name('digifintelCableBill');
Route::post('digifintel/cable/bill/fetch-params',[digifintelController::class,'cableBillFetchParams'])->name('digifintelCableBillFetchParams');
Route::post('digifintel/cable/bill-fetch',[digifintelController::class,'cableBillFetch'])->name('digifintelCableBillFetch');

Route::get('digifintel/muncipality/bill',[digifintelController::class,'muncipalityBill'])->name('digifintelMuncipalityBill');
Route::post('digifintel/muncipality/bill/fetch-params',[digifintelController::class,'muncipalityBillFetchParams'])->name('digifintelMuncipalityBillFetchParams');
Route::post('digifintel/muncipality/bill-fetch',[digifintelController::class,'muncipalityBillFetch'])->name('digifintelMuncipalityBillFetch');

Route::get('digifintel/fastag/bill',[digifintelController::class,'fastagBill'])->name('digifintelFastagBill');
Route::post('digifintel/fastag/bill/fetch-params',[digifintelController::class,'fastagBillFetchParams'])->name('digifintelFastagBillFetchParams');
Route::post('digifintel/fastag/bill-fetch',[digifintelController::class,'fastagBillFetch'])->name('digifintelFastagBillFetch');

Route::get('digifintel/broadband/bill',[digifintelController::class,'broadbandBill'])->name('digifintelBroadbandBill');
Route::post('digifintel/broadband/bill/fetch-params',[digifintelController::class,'broadbandBillFetchParams'])->name('digifintelBroadbandBillFetchParams');
Route::post('digifintel/broadband/bill-fetch',[digifintelController::class,'broadbandBillFetch'])->name('digifintelBroadbandBillFetch');

Route::get('digifintel/datacardprepaid/bill',[digifintelController::class,'datacardprepaidBill'])->name('digifintelDatacardPrepaidBill');
Route::post('digifintel/datacardprepaid/bill/fetch-params',[digifintelController::class,'datacardprepaidBillFetchParams'])->name('digifintelDatacardPrepaidBillFetchParams');
Route::post('digifintel/datacardprepaid/bill-fetch',[digifintelController::class,'datacardprepaidBillFetch'])->name('digifintelDatacardPrepaidBillFetch');

Route::get('digifintel/datacardpostpaid/bill',[digifintelController::class,'datacardpostpaidBill'])->name('digifintelDatacardPostpaidBill');
Route::post('digifintel/datacardpostpaid/bill/fetch-params',[digifintelController::class,'datacardpostpaidBillFetchParams'])->name('digifintelDatacardPostpaidBillFetchParams');
Route::post('digifintel/datacardpostpaid/bill-fetch',[digifintelController::class,'datacardpostpaidBillFetch'])->name('digifintelDatacardPostpaidBillFetch');

Route::get('digifintel/postpaid/bill',[digifintelController::class,'postpaidBill'])->name('digifintelPostpaidBill');
Route::post('digifintel/postpaid/bill/fetch-params',[digifintelController::class,'postpaidBillFetchParams'])->name('digifintelPostpaidBillFetchParams');
Route::post('digifintel/postpaid/bill-fetch',[digifintelController::class,'postpaidBillFetch'])->name('digifintelPostpaidBillFetch');

//mobile Bill
Route::get('mobile/bill',[postPaidRechargeController::class,'index'])->name('mobileBill');
Route::post('mobile/bill/fetch',[postPaidRechargeController::class,'mobileBillFetch'])->name('mobileBillFetch');
Route::post('mobile/bill/pay',[postPaidRechargeController::class,'mobileBillPay'])->name('mobileBillPay');


// Landline
Route::get('landline/landlinebill',[LandlineController::class,'index'])->name('landlineBill');
Route::post('landline/landlinebill/fetch',[LandlineController::class,'landlineBillFetch'])->name('landlineBillFetch');
Route::post('landline/landlinebill/pay',[LandlineController::class,'landlineBillPay'])->name('landlineBillPay');


//Water
Route::get('water/bill',[WaterController::class,'index'])->name('waterBill');
Route::post('water/bill/fetch',[WaterController::class,'waterBillFetch'])->name('waterBillFetch');
Route::post('water/bill/pay',[WaterController::class,'waterBillPay'])->name('waterBillPay');


// credit Caillrd B
Route::get('creditCard/Recharge',[creditCradBBPSController::class,'index'])->name('creditCardRecharge');
Route::post('creditCard/bill/fetch',[creditCradBBPSController::class,'creditCardBillFetch'])->name('creditCardBillFetch');
Route::post('creditCard/recharge',[creditCradBBPSController::class,'creditCardRechargePay'])->name('creditCardRechargePay');

// Insurance Bill
Route::get('insurance/Recharge',[insuranceBillController::class,'index'])->name('insuranceRecharge');
Route::post('insurance/bill/fetch',[insuranceBillController::class,'insuranceBillFetch'])->name('insuranceBillFetch');
Route::post('insurance/recharge',[insuranceBillController::class,'insuranceRechargePay'])->name('insuranceRechargePay');


//Electricity Bill
Route::get('electricity/bill',[electricityBillController::class,'index'])->name('electricityBill');
Route::post('electricity/bill/fetch',[electricityBillController::class,'electricityBillFetch'])->name('electricityBillFetch');
Route::post('electricity/bill/pay',[electricityBillController::class,'electricityBillPay'])->name('electricityBillPay');

//Gas Bill
Route::get('gas/Recharge',[gasBillController::class,'index'])->name('gasRecharge');
Route::post('gas/bill/fetch',[gasBillController::class,'gasBillFetch'])->name('gasBillFetch');
Route::post('gas/recharge',[gasBillController::class,'gasRechargePay'])->name('gasRechargePay');

//DTH Rechage 
//Route::get('dth/test',[prePaidRechargeController::class,'mobiletest']);

//Route::get('dth/isp',[dthRechargeController::class,'getISP'])->name('getISP');
Route::get('dth/mobileRecharge',[dthRechargeController::class,'dthRecharge'])->name('dthRecharge');
Route::post('dth/recharge',[dthRechargeController::class,'dthRechargePay'])->name('dthRechargePay');

// //Digifintel DTH Recharge
// Route::get('digifintel/dth/mobileRecharge',[digifintelDthRechargeController::class,'dthRecharge'])->name('digifintelDthRecharge');
// Route::post('digifintel/dth/recharge',[digifintelDthRechargeController::class,'dthRechargePay'])->name('digifintelDthRechargePay');

// Fast Tag
//Route::get('',[fastTagRechargeController::class,'fastTagRecharge'])->name('fastTagRecharge');
Route::get('fastTag/Recharge',[fastTagRechargeController::class,'index'])->name('fastTagRecharge');
Route::post('fastTag/bill/fetch',[fastTagRechargeController::class,'fastTagBillFetch'])->name('fastTagBillFetch');
Route::post('fastTag/recharge',[fastTagRechargeController::class,'fastTagRechargePay'])->name('fastTagRechargePay');
Route::get('page/not/found',function(){
    return view('user/notFound');
})->name('pageNotFound');

//CGPayout
//Route::get('/user/verify/form',[cgPayoutController::class,'verifyUserForm'])->name('usercg.verifyForm');
Route::get('/user/verify/form',[cgPayoutController::class,'profile'])->name('usercg.verifyForm');
Route::post('/user/verify',[cgPayoutController::class,'verifyUser'])->name('usercg.verify');
Route::post('/user/payout',[cgPayoutController::class,'payout'])->name('usercg.payout');
Route::get('/user/payout/res',[cgPayoutController::class,'payoutMsg'])->name('payout.msg');
Route::get('/user/payout/history',[cgPayoutController::class,'payoutHistory'])->name('payout.history');

Route::post('payout/send/money',[cgPayoutController::class,'sendMoneyForm'])->name('sendMoney.Form');

Route::get('payout/add/beneficiary',[cgPayoutController::class,'addBeneficiaryForm'])->name('add.bene');
Route::post('payout/add/beneficiary',[cgPayoutController::class,'addBeneficiary'])->name('add.beneStore');
Route::post('payout/delete/beneficiary',[cgPayoutController::class,'deleteBeneficiary'])->name('delete.beneStore');
Route::get('bbps/all/history',[prePaidRechargeController::class,'bbpsHistory'])->name('bbpsAll.history');

//for rm dt sd

// Show all packages
Route::get('rt/packages', [PackageController::class, 'indexRT'])->name('packages.indexRT');

// Show form to create new package
Route::get('rt/packages/create', [PackageController::class, 'createRT'])->name('packages.createRT');

// Store newly created package
Route::post('rt/packages', [PackageController::class, 'storeRT'])->name('packages.storeRT');

// Show a single package
Route::get('rt/packages/{package}', [PackageController::class, 'showRT'])->name('packages.showRT');

// Show form to edit a package
Route::get('rt/packages/{package}/edit', [PackageController::class, 'editRT'])->name('packages.editRT');

// Update the package
Route::put('rt/packages/{package}', [PackageController::class, 'updateRT'])->name('packages.updateRT');

// Delete the package
Route::delete('rt/packages/{package}', [PackageController::class, 'destroyRT'])->name('packages.destroyRT');
Route::get('RT/commission-list/{packageId}', [CommissionController::class, 'indexRT'])->name('commission-listRT');
Route::get('fund/Qr',[DigifintelUpiController::class,'index'])->name('dispalyQr1');

    Route::get('/orderform', [DigifintelUpiController::class, 'index'])->name('diform');
    Route::post('/create-order', [DigifintelUpiController::class, 'createOrder'])->name('digifintel.create');
    Route::post('/pay-order', [DigifintelUpiController::class, 'payOrder'])->name('digifintel.payorder');
    Route::post('/check-order-status', [DigifintelUpiController::class, 'checkOrderStatus'])->name('digifintel.status');
    Route::post('/pay-intent', [DigifintelUpiController::class, 'payIntent'])->name('digifintel.payintent');
    Route::post('/check-intent-status', [DigifintelUpiController::class, 'checkIntentStatus'])->name('digifintel.intentstatus');
    Route::post('/verify-vpa', [DigifintelUpiController::class, 'verifyVpa'])->name('digifintel.verifyvpa');
    Route::get('/payment/history', [DigifintelUpiController::class, 'historyUPI'])->name('historyUPI');

    Route::post('indu/check-order-status', [DigifintelUpiController::class, 'checkOrderStatusIndu'])->name('digifintel.statusindu');

Route::get('/imps-form',[nifiPayoutController::class,'index'])->name('nifiimps');
Route::get('n/payout/report',[nifiPayoutController::class,'getReport'])->name('nifiReport');

Route::post('/imps-payout', [nifiPayoutController::class, 'sendImpsPayout'])->name('nifiimps.payout');
Route::get('n/wallet-balance', [nifiPayoutController::class, 'getWalletBalance'])->name('wallet.balance');

Route::get('/check-txn-status/{txn_id}', [nifiPayoutController::class, 'checkTxnStatus'])->name('nifi.txn.status');


//nifi
Route::get('get/cg/rem',[nifiPayoutController::class,'remProfile'])->name('remProfile');
Route::post('get/cg/rem/chk',[nifiPayoutController::class,'remProfilePost'])->name('remProfilePost');
Route::post('get/cg/rem/reg',[nifiPayoutController::class,'remitterRegistration'])->name('remitterRegistrationCG');
Route::post('get/cg/rem/vry',[nifiPayoutController::class,'remitterRegistrationVerify'])->name('remitterRegistrationVerifyCG');


Route::get('get/cg/bene/reg',[nifiPayoutController::class,'beneficiryReg'])->name('cg-beneficiaryRegistration');
Route::post('get/cg/bene/rstr',[nifiPayoutController::class,'beneficiryStore'])->name('cg-beneficiaryRegistrationStore');

Route::post('get/cg/bene/dlt',[nifiPayoutController::class,'beneDelete'])->name('beneDelete');

Route::match(['get', 'post'], 'cg/send-money',[nifiPayoutController::class, 'showSendMoneyForm'])->name('sendMoneyFormDmt1');

Route::match(['get', 'post'],'cg/generateTransactionOtp', [nifiPayoutController::class, 'generateTransactionOtp'])->name('generateTransactionOtpDmt1');

Route::match(['get', 'post'],'cg/dmt/transaction', [nifiPayoutController::class, 'transaction'])->name('transactionDmt1');

Route::get('/nifi/print/{id}', [nifiPayoutController::class, 'printReceipt'])->name('nifi.print');


});


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('customer/dashboard',function(){
//     return view('user/home-page');
// })->name('customer/dashboard');

// Route::get('/user',function(){
//     return view('user.auth.index');
// });


// Route::post('/customer/login', [CustomerController::class, 'login'])->name('customer.login');

// Route::get('/user/fund-transfer/bank-account',function(){
//     return view('user/fund-transfer/bank-account');
// })->name('/user/fund-transfer/bank-account');

// Route::get('/user/wallet/index',function(){
//     return view('user/wallet.index');
// })->name('/user/wallet/index');
// // AEPS

// Route::get('/cash-withdrawal', [aepsController::class, 'showForm'])->name('cash.withdrawal.form');
// // Route::post('/cash-withdrawal', [aepsController::class, 'makeWithdrawal'])->name('cash.withdrawal');
// Route::get('/aeps/balance-inquiry', [aepsController::class, 'balanceInquiry_show'])->name('balance.enquiry-form');
// Route::post('/aeps/balance-inquiry', [aepsController::class, 'balanceInquiry'])->name('balance.enquiry');
// Route::post('/aeps/cash-withdrawal', [aepsController::class, 'cashWithdrawal'])->name('cash.withdrawal');

// Route::get('/admin/AEPS/balance-enquiry',function(){
//     return view('user/AEPS.balance-enquiry');
// });
// Route::get('/user/AEPS/cash-withdrawal',function(){
//     return view('user/AEPS.cash-withdrawal');
// })->name('/user/AEPS/cash-withdrawal');

// Route::get('/admin/AEPS/mini-statement',function(){
//     return view('user/AEPS.mini-statement');
// });

// Route::get('/user/money-transfer/money-transfer',function(){
//     return view('user/money-transfer.money-transfer');
// })->name('/user/money-transfer/money-transfer');
// // bbps
// Route::get('/user/bbps/bbps-services',function(){
//     return view('user/bbps.index');
// })->name('/user/bbps/bbps-services');

// // mobile
// Route::get('/user/dth/dth-recharge',function(){
//     return view('user/dth.index');
// })->name('/user/dth/dth-recharge');

// // DTH
// Route::get('/user/mobile/mobile-recharge',function(){
//     return view('user/mobile.index');
// })->name('/user/mobile/mobile-recharge');


// // service
// Route::get('/user/services/services',function(){
//     return view('user/services.services');
// })->name('/user/services/services');
// //commissiion pALne
// Route::get('/user/commission-plane',function(){
//     return view('user.commission-plan');
// })->name('/user/commission-plane');

// Route::get('/user/AEPS/aeps-statement',function(){
//     return view('user/AEPS.aeps-statement');
// })->name('/user/AEPS/aeps-statement');

// Route::get('/admin/account-opening',function(){
//     return view('user/account-opening.index');
// });

// Route::get('/admin/services',function(){
//     return view('admin/services.services');
// });

// // user-statement
// Route::get('/user/statement/account-stmt',function(){
//     return view('user/statements.account-stmt');
// })->name('statement/account-stmt');

// Route::get('/user/statement/fund-report',function(){
//     return view('user/statements.fund-report');
// })->name('statement/fund-report');

// Route::get('/user/statement/fund-transfer-report',function(){
//     return view('user/statements.fund-transfer-report');
// })->name('statement/fund-transfer-report');

// Route::get('/user/statement/money-transfer-report',function(){
//     return view('user/statements.money-transfer-report');
// })->name('statement/money-transfer-report');

// Route::get('/user/statement/wallet-transfer-report',function(){
//     return view('user/statements.wallet-transfer-report');
// })->name('statement/wallet-transfer-report');


// //payment Getway 
// // Route::get('/user/fund-transfer/payment-getway',function(){
// //     return view('user/fund-transfer.payment-gateway');
// // })->name('/user/fund-transfer/payment-getway');

// Route::post('/process-payment', [paymentGatewayController::class, 'processPayment'])->name('process.payment');
// Route::get('/redirect-page', [paymentGatewayController::class, 'paymentRedirect'])->name('payment.redirect');
// Route::get('/process-payment-gateway', [paymentGatewayController::class, 'index'])->name('process-payment-gateway');

// Route::get('/payment-response', [paymentGatewayController::class, 'checkOrderStatus'])->name('payment.response');



//Admin

Route::get('forget/pass',[AuthController::class, 'forgetPage'])->name('admin.pass');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');


Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('login/admin/otp', [AuthController::class, 'adminVerifyOtp'])->name('adminVerify.otp');

Route::get('/user-signup', function () {
    return view('admin.client-sign');
})->name('client-sign');

Route::get('/verfy-retailerf', function () {
    return view('admin.client-sign');
})->name('/verfy-retailer.form');

Route::post('/verfy-retailer',[CustomerController::class,'veryfyRetailer'])->name('verfy-retailer');
Route::post('/admin/user', [CustomerController::class, 'store'])->name('admin.client.store');
Route::post('/admin/user/kyc', [CustomerController::class, 'storeKyc'])->name('admin.client.storekyc');

Route::get('admin.logout',[AuthController::class,'logout'])->name('admin.logout');


//Route::get('otp', [AuthController::class, 'showOtpForm'])->name('otp.form');

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('tds/report',[infoController::class,'tdsReport'])->name('admin.reports.tds');
    Route::get('/admin/tds-report-export', [infoController::class, 'exportTdsReport'])->name('admin.reports.tds.export');


Route::put('/ad/{id}/update-package', [CustomerController::class, 'updatePackageAd'])->name('customer.updatePackagead');

    
    Route::get('/admin/other services', [otherServiceController::class, 'showServices'])->name('admin.showServices');
    Route::post('/admin/other services', [otherServiceController::class, 'showServicesStore'])->name('store.showServices');
    Route::get('/admin/other/index', [otherServiceController::class, 'index'])->name('otherServices.index');
    Route::get('/admin/other/{id}/edit', [otherServiceController::class, 'Servicesedit'])->name('otherServices.edit');
    Route::get('/admin/other/destroy', [otherServiceController::class, 'oiii'])->name('otherServices.destroy');
    Route::put('/{id}', [OtherServiceController::class, 'Servicesupdate'])->name('otherServices.update'); // Update service
    Route::post('/other-services/{id}/toggle-status', [OtherServiceController::class, 'toggleStatus'])->name('otherServices.toggleStatus');
    Route::get('/admin/dashboard', [AuthController::class, 'index'])->name('admin.dashboard');

    Route::post('/admin/users', [CustomerController::class, 'store'])->name('admin.users.store');

    Route::get('/ladger/statement/admin',[infoController::class,'indexAdmin'])->name('ledger.statement');

    Route::post('wallet/transfer/admin',[walletToWalletController::class,'adminTransRel'])->name('admin.trans');

    Route::post('lock/relase/amount',[walletToWalletController::class,'lockRealese'])->name('lock.release');
    Route::post('wallet/mapping/admin',[CustomerController::class,'adminMapp'])->name('admin.disMapp');
    Route::get('wallet/transfer/history/admin',[walletToWalletController::class,'walletHistoryAdmin'])->name('admin.trans.his');

    Route::get('/admin/not/found',function(){
        return view('admin.notFound');
    })->name('admin.notFound');

    Route::get('/fund/request',[addMoneyController::class,'getFundRequests'])->name('getFundRequests');
    Route::get('/fund/request/history',[addMoneyController::class,'getFundRequestsHistory'])->name('getFundRequests.History');

    Route::post('/fund/request/approve',[CustomerController::class,'approveFund'])->name('approveFund');
    Route::post('/fund/request/reject',[CustomerController::class,'rejectFund'])->name('rejectFund');

    //mpin
    Route::get('/change-empin', [AuthController::class, 'showChangeEmpinForm'])->name('empin.form');
Route::post('/change-empin', [AuthController::class, 'updateEmpin'])->name('empin.update');


    // web.php
    Route::get('/admin/add/balance', [CustomerController::class, 'adminBalanceAddForm'])->name('adminBalanceAddForm');
    Route::post('/admin/add/balance', [CustomerController::class, 'adminBalanceAdd'])->name('adminBalanceAdd');

    Route::get('/admin/users/{id}/edit', [CustomerController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [CustomerController::class, 'update'])->name('admin.users.update');


        Route::get('/admin/user-list',[CustomerController::class,'showUser'])->name('admin/user-list');
        Route::get('/admin/user-list/lock',[CustomerController::class,'showUserLock'])->name('admin/user-lock');
    
        Route::patch('/admin/update-services/{id}', [CustomerController::class, 'updateServices'])->name('update.services');
     Route::get('/admin/user-list-request',function(){
        return view('admin/user-details.user-request');
    })->name('admin/user-list-request');
    
    Route::get('/admin/user-add-from',function(){
        return view('admin/user-details.user-add');
    })->name('admin/user-add');

    Route::get('admin/kyc-form',[KycController::class,'create'])->name('admin/kyc-form');
    Route::post('/kyc/store', [KycController::class, 'store'])->name('admin/kyc.store');
    Route::get('/admin/kyc-list', [KycController::class, 'getAllData'])->name('admin/kyc-list');

   Route::get('/admin/kyc/{id}/details', [KycController::class, 'show'])->name('admin/kyc.details');

   Route::put('/admin/kyc/update/{id}', [KycController::class, 'update'])->name('admin.kyc.update');

   // merchant onbording
    // Route::get('/user/signup', [merchantController::class, 'showSignupForm'])->name('merchant-form');
    // Route::post('/user/outlet/signup', [merchantController::class, 'initiateSignup'])->name('user.outlet.signup');
    // Route::get('/user/outlet/signup/verify', [merchantController::class, 'showOtpForm'])->name('showOtpForm');
    // Route::post('/user/outlet/signup/validate', [merchantController::class, 'validateOtp'])->name('otp-verify');
    Route::get('/user/outlet/merchant-list', [merchantController::class, 'merchantList'])->name('merchant-list');
        
    // Route::get('/admin/kyc-list',function(){
    //     return view('admin/kyc.kyc-all-list');
    // })->name('admin/kyc-list');
    
    Route::get('/admin/kyc-form',function(){
        return view('admin/kyc.kyc-form');
    })->name('admin/kyc-form');
    
    
    
    Route::get('/admin/wallet-credit',function(){
        return view('admin/wallet.creditDebit');
    })->name('admin/wallet/credit-debit');
    
    Route::get('/admin/wallet-credit-lock-release',function(){
        return view('admin/wallet.lock&release');
    })->name('admin/wallet/credit-lock');
    
    Route::get('/admin/wallet-credit-lock-fund',function(){
        return view('admin/wallet.fund-request');
    })->name('admin/wallet/fund-request');
    
    
    Route::get('/admin/reports/aeps',function(){
        return view('admin/reports.aeps');
    })->name('admin/reports/aeps');
    
    Route::get('/admin/reports/credit-card-bill',function(){
        return view('admin/reports.credit-card-bill-payment');
    })->name('admin/reports/credit-card-bill-payment');
    
    
    Route::get('/admin/reports/dmt',function(){
        return view('admin/reports.dmt1');
    })->name('admin/reports/dmt-payment');
    
    Route::get('/admin/reports/dth-recharge',function(){
        return view('admin/reports.dth-recharge');
    })->name('admin/reports/dth-recharge'); 
    
    Route::get('/admin/reports/ledger',function(){
        return view('admin/reports.ledger');
    })->name('admin/reports/ledger');   
    
    Route::get('/admin/reports/fund-transfer',function(){
        return view('admin/reports.fund-transfer');
    })->name('admin/reports/fund-transfer');  
    
    Route::get('/admin/reports/mobile-recharge',function(){
        return view('admin/reports.mobile-recharge');
    })->name('admin/reports/mobile-recharge');
    
    Route::get('/admin/reports/wallet-transfer',function(){
        return view('admin/reports.wallet-transfer');
    })->name('admin/reports/wallet-transfer');


    Route::post('/admin/login-as-customer/{id}', [AuthController::class, 'loginAsCustomer'])->name('admin.loginAsCustomer');

    // credit card apply

    Route::get('/credit-card-application-history', [CreditCardController::class, 'showAll'])->name('credit_card.history');

    // Commission Plane
    Route::get('/commission-form', [CommissionController::class, 'showForm'])->name('commission-form');


    Route::post('/commission-store', [CommissionController::class, 'store'])->name('commission-store');
    //Route::get('/commission-list', [CommissionController::class, 'index'])->name('commission-list');
Route::get('/commission-list/{packageId}', [CommissionController::class, 'index'])->name('commission-list');



    Route::get('/commissions/{id}/edit', [CommissionController::class, 'edit'])->name('commission.edit');
    // Route::put('/commissions/{id}', [CommissionController::class, 'update'])->name('commission.update');
    Route::put('/commission/commissionUpdate/{id}', [CommissionController::class, 'update'])->name('commission.update');

    // Add BAnk
    Route::get('/bankdetails/create', [AddBankController::class, 'showForm'])->name('bankdetails.form');
    Route::post('/bankdetails/store', [AddBankController::class, 'store']);

    Route::get('/bank-details/{id}/edit', [AddBankController::class, 'edit'])->name('bankdetails.edit');
    Route::post('/bank-details/{id}', [AddBankController::class, 'update'])->name('bankdetails.update');
    // Add QR
    Route::get('/bankdetails/qr', [AddBankController::class, 'showFormQr'])->name('bankdetails.Qr');
    Route::post('/bankdetails/store/qr', [AddBankController::class, 'storeQr'])->name('bankdetails.storeQr');


    // Add Other Serves
    Route::get('/other/services/create', [otherServiceController::class, 'showForm'])->name('otherServices.form');
    Route::post('/other/services/store', [otherServiceController::class, 'store'])->name('otherServices.store');

    Route::post('/other/services/update', [otherServiceController::class, 'update'])->name('otherServices.update');

    Route::get('/other/services/view', [otherServiceController::class, 'showIndex'])->name('otherServices.view');


    Route::delete('/commission/{id}', [CommissionController::class, 'destroy'])->name('commission.destroy');

    // --------------------- Map Commission Route --------------------
    Route::get('/map-commission', [CommissionController::class, 'displayMapCommission'])->name('map-commission');
    Route::post('/addMapCommissionData', [CommissionController::class, 'addMapCommissionData'])->name('addMapCommissionData');
    Route::delete('/commission/{id}/map', [CommissionController::class, 'mapCommissionDestroy'])->name('commission.mapCommissionDestroy');
    Route::put('/commission/update/{id}', [CommissionController::class, 'mapCommissionUpdate'])->name('commission.update');



    // Reports
    Route::get('/dmt1/report',[infoController::class,'dmt1Report'])->name('dmt1Report');
    Route::get('/aeps/report',[infoController::class,'aepsReport'])->name('aepsReport');
    Route::get('/bbps/report',[infoController::class,'bbpsReport'])->name('bbpsReport');
    Route::get('/payout/report',[infoController::class,'payoutReport'])->name('payoutReport');

    // Add BAnk
    Route::get('/bankdetails/create', [AddBankController::class, 'showForm'])->name('bankdetails.form');
    Route::post('/bankdetails/store', [AddBankController::class, 'store']);

    Route::get('/bank-details/{id}/edit', [AddBankController::class, 'edit'])->name('bankdetails.edit');
    Route::post('/bank-details/{id}', [AddBankController::class, 'update'])->name('bankdetails.update');
    // Add QR
    Route::get('/bankdetails/qr', [AddBankController::class, 'showFormQr'])->name('bankdetails.Qr');
    Route::post('/bankdetails/store/qr', [AddBankController::class, 'storeQr'])->name('bankdetails.storeQr');

    // Add Other Serves
    Route::get('/other/services/create', [otherServiceController::class, 'showForm'])->name('otherServices.form');
    Route::post('/other/services/store', [otherServiceController::class, 'store'])->name('otherServices.store');

    Route::get('/other/services/view', [otherServiceController::class, 'showIndex'])->name('otherServices.view');


    Route::get('/bank-details/{id}/edit', [otherServiceController::class, 'edit'])->name('bankdetails.edit');
    Route::post('/bank-details/{id}', [otherServiceController::class, 'update'])->name('bankdetails.update');

    Route::get('admin/pan/history',[PanCardController::class,'panHistoryAdmin'])->name('admin.panHistory');
    Route::get('admin/pan/balance',[PanCardController::class,'getEpanBalance'])->name('admin.balance');

    Route::get('/add/bank/details',[AddBankController::class,'showBank'])->name('showBank');
    Route::post('/addbank/{id}/toggle-status', [AddBankController::class, 'toggleStatus'])->name('otherServices.toggle');


//manual KYC 
Route::post('/user/kyc/verify/{id}', [CustomerController::class, 'verifyKyc'])->name('user.kyc.verify');
Route::post('/user/kyc/reject', [CustomerController::class, 'rejectKyc'])->name('user.kyc.reject');

//complete Full KYC Retailer
Route::post('/user/fullkyc/{id}', [CustomerController::class, 'completeFullKyc'])->name('user.fullkyc');
Route::post('/user/retailer/kyc/reject', [CustomerController::class, 'rejectRetailerKyc'])->name('user.rejectRetailedKyc');
Route::post('/user/rekyc/{id}', [CustomerController::class, 'reKYC'])->name('user.rekyc');


// Show all packages
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');

// Show form to create new package
Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');

// Store newly created package
Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');

// Show a single package
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

// Show form to edit a package
Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');

// Update the package
Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');

// Delete the package
Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');


  Route::get('/employees', [AuthController::class, 'indexEmp'])->name('employees.index');          // List + Search
    Route::get('/employees/create', [AuthController::class, 'create'])->name('employees.create'); // Show Create Form
    Route::post('/employees', [AuthController::class, 'store'])->name('employees.store');         // Store New Employee
    Route::get('/employees/{id}/edit', [AuthController::class, 'edit'])->name('employees.edit');  // Show Edit Form
    Route::put('/employees/{id}', [AuthController::class, 'update'])->name('employees.update');   // Update Employee
    Route::delete('/employees/{employee}', [AuthController::class, 'destroy'])->name('employees.destroy'); // Delete

    // Export to Excel
    Route::get('/employees/export', [AuthController::class, 'export'])->name('employees.export');

   


});

Route::post('/user/register',[CustomerController::class,'addUserbyAdmin'])->name('user.reg');
Route::post('/customer/{id}/status',[CustomerController::class,'active'])->name('user.active');


// Route::get('/dashboard',function(){
//     return view('admin/home-page');
// })->name('dashboard');


// Route::get('/admin1',function(){
//     return view('admin/auth.auth-log');
// })->name('admin1');




// Route::post('/admin/users', [CustomerController::class, 'store'])->name('admin.users.store');


// Route::get('/admin/user-list',function(){
//     return view('admin/user-details.user-list');
// })->name('admin/user-list');


// Route::get('/admin/user-list-request',function(){
//     return view('admin/user-details.user-request');
// })->name('admin/user-list-request');

// Route::get('/admin/user-add-from',function(){
//     return view('admin/user-details.user-add');
// })->name('admin/user-add');

// Route::get('/admin/kyc-list',function(){
//     return view('admin/kyc.kyc-all-list');
// })->name('admin/kyc-list');

// Route::get('/admin/kyc-form',function(){
//     return view('admin/kyc.kyc-form');
// })->name('admin/kyc-form');



// Route::get('/admin/wallet-credit',function(){
//     return view('admin/wallet.creditDebit');
// })->name('admin/wallet/credit-debit');

// Route::get('/admin/wallet-credit-lock-release',function(){
//     return view('admin/wallet.lock&release');
// })->name('admin/wallet/credit-lock');

// Route::get('/admin/wallet-credit-lock-fund',function(){
//     return view('admin/wallet.fund-request');
// })->name('admin/wallet/fund-request');


// Route::get('/admin/reports/aeps',function(){
//     return view('admin/reports.aeps');
// })->name('admin/reports/aeps');

// Route::get('/admin/reports/credit-card-bill',function(){
//     return view('admin/reports.credit-card-bill-payment');
// })->name('admin/reports/credit-card-bill-payment');


// Route::get('/admin/reports/dmt',function(){
//     return view('admin/reports.dmt');
// })->name('admin/reports/dmt-payment');

// Route::get('/admin/reports/dth-recharge',function(){
//     return view('admin/reports.dth-recharge');
// })->name('admin/reports/dth-recharge'); 

// Route::get('/admin/reports/ledger',function(){
//     return view('admin/reports.ledger');
// })->name('admin/reports/ledger');   

// Route::get('/admin/reports/fund-transfer',function(){
//     return view('admin/reports.fund-transfer');
// })->name('admin/reports/fund-transfer');  

// Route::get('/admin/reports/mobile-recharge',function(){
//     return view('admin/reports.mobile-recharge');
// })->name('admin/reports/mobile-recharge');

// Route::get('/admin/reports/wallet-transfer',function(){
//     return view('admin/reports.wallet-transfer');
// })->name('admin/reports/wallet-transfer');


// SuperDistibuter


Route::get('/distibuter/dashboard',function(){
    return view('superDistibuter.home-page');
})->name('distibuter-dashboard');


// testing
Route::get('/print/testing', function () {
    return view('user.testing.aepstest');
})->name('sss');

Route::get('/get-aepsWallet', function () {
    $aepsWallet = DB::table('customer')
        ->where('username', session('username'))
        ->value('aepsWallet');

    return response()->json(['aepsWallet' => $aepsWallet]);
});

Route::get('/get-Wallet', function () {
    $Wallet = DB::table('customer')
        ->where('username', session('username'))
        ->value('balance');

    return response()->json(['Wallet' => $Wallet]);
});