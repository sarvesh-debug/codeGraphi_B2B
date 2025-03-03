<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditCardApplication;
use App\Exports\CreditCardApplicationsExport;
use Maatwebsite\Excel\Facades\Excel;
class CreditCardController extends Controller
{
    public function create()
    {
        return view('user.credit_card.index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'pan_no' => 'required|string|max:10',
            'bank' => 'required|string',
            'retailer_name' => 'required|string|max:255',
            'retailer_username' => 'required|string|max:255',
        ]);
    
        CreditCardApplication::create($request->all());
    
        // Redirect based on the bank value
        $bank = $request->bank;

        if ($bank === 'HDFC') {
            return redirect('https://applyonline.hdfcbank.com/cards/credit-cards.html?utm_content=DGPI&Channel=DSA&DSACode=XRKD&SMCode=H5399&LGCode=DGPI&LCCode=951548&LC2=EARNTRA#nbb');
        } elseif ($bank === 'IDFC') {
            return redirect('https://www.idfcfirstbank.com/credit-card/ntb-diy/apply?utm_source=Partner&utm_medium=MMM3&utm_campaign=EARNTRA_951548');
        } elseif ($bank === 'YES') {
            return redirect('https://rkpl.getpopcard.co/?utm_source=EARNTRA&utm_campaign=KC&utm_medium=951548');
        } elseif ($bank === 'RBL') {
            return redirect('https://cutt.ly/9eLeF14q');
        } elseif ($bank === 'Axis') {
            return redirect('https://web.axisbank.co.in/DigitalChannel/WebForm/?ipa68&axisreferralcode=951548');
        } elseif ($bank === 'HSBC_Visa') {
            return redirect('https://www.accountopening.hsbc.co.in/credit-cards/#!/app/apply-for-credit-card?form.campaign_id=MMM6_CCCampaign_EARNTRA_951548&form.source=MMM6&WT.ac=NA&gclid=NA&card=vpc&cid=INM:MP:D0:CC:05:2211:039:MMM6MyMoneyMantra_VPC');
        } elseif ($bank === 'HSBC_Cashback') {
            return redirect('https://www.accountopening.hsbc.co.in/credit-cards/#!/app/apply-for-credit-card?form.campaign_id=MMM6_CCCampaign_EARNTRA_951548&form.source=MMM6&WT.ac=NA&gclid=NA&card=cbc&cid=INM:MP:D0:CC:05:2211:039:MMM6MyMoneyMantra_CBC');
        } elseif ($bank === 'AU_Bank') {
            return redirect('https://cconboarding.aubank.in/auccself/?utm_source=dsa&utm_medium=display-agg&utm_campaign=credit-card-dsa-campaign-982237-347803-DIGA1_951548');
        } elseif ($bank === 'AU_Swipeup') {
            return redirect('https://cconboarding.aubank.in/auccself/#/landing?utm_card=swipeup&utm_source=dsa&utm_medium=display_agg&utm_campaign=swipeup_982237_347803-EARNTRA1_951548');
        } elseif ($bank === 'ICICI') {
            return redirect('https://buy.icicibank.com/ucj/cc/mobile?ius=RAJKH100105R&iup=UCC00476&userId=951548');
        } elseif ($bank === 'Jupiter') {
            return redirect('https://web.jupiter.money/rupay-csb/web-ob/landing?utm_source=MyMoneyMantra&utm_medium=Offline&utm_campaign=EARNTRA&utm_agent-id=951548&utm_lead-id=MMMParkP');
        } elseif ($bank === 'HDFC_Tata_Neu') {
            return redirect('https://www.tatadigital.com/v2/finance/creditcard/product-detail?utm_source=Partnerships_external&utm_medium=MyMoneyMantra&utm_campaign=951548');
        } elseif ($bank === 'IndusInd') {
            return redirect('https://induseasycredit.indusind.com/customer/credit-card/new-lead?utm_source=assisted&utm_medium=IBLV899&utm_campaign=Credit-Card&utm_content=951548');
        } else {
            return redirect()->back()->with('success', 'Credit Card Application Submitted Successfully!');
        }
        
    }
    

    public function index()
    {
        // Get username from session
        $username = session('username');

        // Fetch applications where retailer_username matches the session username
        $applications = CreditCardApplication::where('retailer_username', $username)->get();

        return view('user.credit_card.showcredit', compact('applications', 'username'));
       //return $applications;

    }
    public function showAll()
    {
        // Fetch all credit card applications
        $applications = CreditCardApplication::all();

        return view('admin.reports.credit_card_apply', compact('applications'));
    }

//     public function export()
// {
//     return Excel::download(new CreditCardApplicationsExport, 'credit_card_applications.xlsx');
// }

}
