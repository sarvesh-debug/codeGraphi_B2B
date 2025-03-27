<?php

use App\Http\Controllers\accountStatementController;
use App\Http\Controllers\AccountVerificationController;
use App\Http\Controllers\AddBankController;
use App\Http\Controllers\addMoneyController;
use App\Http\Controllers\AmountController;
use App\Http\Controllers\bbpsController;
use App\Http\Controllers\cmsController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\dmtinstantpayController;
use App\Http\Controllers\infoController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\merchantController;
use App\Http\Controllers\otherServiceController;
use App\Http\Controllers\otpsmsController;
use App\Http\Controllers\PanCardController;
use App\Http\Controllers\payoutInstantPaycontroller;
use App\Http\Controllers\prePaidRechargeController;
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


Route::get('/test-error', function () {
    abort(500);
});



Route::get('admin', function () {
    // return view('welcome');
    return redirect()->away('https://zpaypvtltd.com/');
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

Route::get('/', function () {
    return redirect()->away('https://zpaypvtltd.com/');
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
    
    Route::get('/cash-withdrawal', [aepsController::class, 'showForm'])->name('cash.withdrawal.form');
    // Route::post('/cash-withdrawal', [aepsController::class, 'makeWithdrawal'])->name('cash.withdrawal');
    Route::get('/aeps/balance-inquiry', [aepsController::class, 'balanceInquiry_show'])->name('balance.enquiry-form');
    Route::post('/aeps/balance-inquiry', [aepsController::class, 'balanceInquiry'])->name('balance.enquiry');
    Route::get('/aeps/balance-statement', [aepsController::class, 'miniStatement'])->name('balance.statement');
    Route::post('/aeps/cash-withdrawal', [aepsController::class, 'cashWithdrawal'])->name('cash.withdrawal');  
    Route::post('/aeps/balance-statemen', [aepsController::class, 'balanceStatement'])->name('balance.statementAPI');

    Route::post('/aeps/cashWithdrawal', [aepsController::class, 'cashWithdrawal'])->name('cashWithdrawal');

    Route::get('/aeps/history', [aepsController::class, 'history'])->name('aeps.history');

    
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
Route::get('/outlet-login-status', [aepsController::class, 'outlet_show'])->name('outlet-log');

Route::post('/outlet-login-status', [aepsController::class, 'checkOutletLoginStatus']);


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


Route::get('cms/generate-url',[cmsController::class,'generateUrl'])->name('generate-url');
Route::get('cms/checkCmsStatus',[cmsController::class,'checkCmsStatus'])->name('checkCmsStatus-url');


// Commission plan
Route::get('/commission-get', [CommissionController::class, 'getAllCommission'])->name('commission.get');

Route::get('distibuter/commission',[CustomerController::class,'disCommission'])->name('disCommission.list');


// 
Route::patch('/distibuterr/update-services/{id}', [CustomerController::class, 'updateServicesD'])->name('update.servicesD');

Route::get('/ladger/statement',[infoController::class,'index'])->name('laser.statement');

Route::get('fund/Qr',[AddBankController::class,'dispalyQr'])->name('dispalyQr1');


//Mobile Rechage 
Route::get('mobile/test',[prePaidRechargeController::class,'mobiletest']);

Route::get('mobile/isp',[prePaidRechargeController::class,'getISP'])->name('getISP');
Route::get('mobile/mobileRecharge',[prePaidRechargeController::class,'mobileRecharge'])->name('mobileRecharge');
Route::post('mobile/recharge',[prePaidRechargeController::class,'mobileRechargePay'])->name('mobileRechargePay');


Route::get('page/not/found',function(){
    return view('user/notFound');
})->name('pageNotFound');

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
    Route::get('/commission-list', [CommissionController::class, 'index'])->name('commission-list');

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