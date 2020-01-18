<?php

namespace App\Http\Controllers;

use App\front_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $front_user = front_user::where("pay_vai","=","begateway")
            ->where("subscription_status","=",1)
            ->get();
        foreach ($front_user as $row=> $single){
            $exp = date("Y-m-d", strtotime(date("Y-m-d",strtotime($single->pay_time))."30 day"));
            $today_time = strtotime(date("Y-m-d"));
            $time_ex = strtotime($exp);
            if ($today_time > $time_ex){
                $front_user = front_user::find($single->id);
                $front_user->subscription_status = 0;
                $front_user->save();
            }
        }
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('back-end.dashboard.dashboard');
    }
    public function manageuser(){
        $front_user = front_user::all();
        return view('back-end.manage-user.manage-user',[
            'front_users'  =>  $front_user
        ]);
    }

    private function apiContext(){
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),       // ClientID
                env('PAYPAL_CLIENT_SECRET')    // ClientSecret
            )
        );
        return $apiContext;
    }
    public function paypaldate($agreementId){
        $agreement = new Agreement();
        $agreement->setId($agreementId);
        $agreementStateDescriptor = new AgreementStateDescriptor();
        $agreementStateDescriptor->setNote("Cancel the agreement");
        try {
            $AgreementDetails = Agreement::get($agreement->getId(), $this->apiContext());
        } catch (Exception $ex) {
        }
        return $AgreementDetails;
    }
    public function viewuserprofile($id){
        $front_user = front_user::find($id);
        $AgreementDetails = $this->paypaldate($front_user->payer_id);
        return view('back-end.single-view.single-view',[
            'front_user' => $front_user,
            'AgreementDetails' => $AgreementDetails
        ]);
    }
    public function manageuseractive(){
        $front_user = front_user::where('subscription_status','=','1')->get();

        return view('back-end.active-user.active-user',[
            'front_users'  =>  $front_user
        ]);
    }
    public function manageuserinactive(){
        $front_user = front_user::where('subscription_status','!=','1')->get();

        return view('back-end.active-user.active-user',[
            'front_users'  =>  $front_user
        ]);
    }

}
