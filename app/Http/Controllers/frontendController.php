<?php

namespace App\Http\Controllers;

use App\front_user;
use App\invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PDF;
class frontendController extends Controller
{
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
    }

    public function index(){
        if (!Session::get('email')){
            return view('front-end.register-package.register-package');
        }else{
            return redirect('/');
        }
    }
    private function form_validate($request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:front_users',
            'whatsapp_no' => 'required',
            'password' => 'required',
            'address' => 'required',
            'tiktok_username' => 'required',
            'tiktok_password' => 'required',
            'tiktok_county' => 'required',
            'tiktok_target_interest' => 'required',
            'tiktok_follower_no' => 'required'
        ]);
    }
    public function registerpackage(Request $request){
        $this->form_validate($request);
        $reg_form_data = $request->all();
        Session::put('reg_form_data',$reg_form_data);
        if ($request->payment_method == "PayPal"){
            return redirect()->route('/subscribe');
        }else{
            return redirect()->route('/begateway');
        }
    }
    public function userlogin(){

        if (!Session::get('email')){
            return view('front-end.user-login.user-login');
        }else{
            return redirect('/');
        }
    }
    public function formuserlogin(Request $request){
        $front_user = front_user::where('email',$request->email)->first();
        if($front_user){
            if (md5($request->password)== $front_user->password){
                Session::put('email',$front_user->email);
                return redirect('/');
            }else{
                return redirect('/user-login')->with('massage','Password incorrect ');
            }
        }else{
            return redirect('/user-login');
        }
    }
    public function dashboard(){
        if (Session::get('email')){
            $front_user = front_user::where('email',Session::get('email'))->first();
            return view('front-end.dashboard.dashboard',[
                'front_user'  => $front_user
            ]);
        }else{
            return redirect('/register-package');
        }
    }
    public function userprofile(){
        if (Session::get('email')){
            $front_user = front_user::where('email',Session::get('email'))->first();

            return view('front-end.user-profile.user-profile',[
                'front_user'  => $front_user
            ]);
        }else{
            return redirect('/register-package');
        }
    }
    public function userlogout(){
        if (Session::get('email')){
            Session::forget('email');
            return redirect('/');
        }else{
            return redirect('/register-package');
        }
    }
    public function userprofileupdate(Request $request){
        if (Session::get('email')){
            $front_user = front_user::where('email',Session::get('email'))->first();
            $all_data_form = $request;
            $front_user->name = $all_data_form['name'];
            $front_user->whatsapp_no = $all_data_form['whatsapp_no'];
            $front_user->password = md5($all_data_form['password']);
            $front_user->address = $all_data_form['address'];
            $front_user->tiktok_username = $all_data_form['tiktok_username'];
            $front_user->tiktok_password = $all_data_form['tiktok_password'];
            $front_user->tiktok_county = $all_data_form['tiktok_county'];
            $front_user->tiktok_target_interest = $all_data_form['tiktok_target_interest'];
            $front_user->tiktok_follower_no = $all_data_form['tiktok_follower_no'];
            $front_user->save();
            return redirect('/user-profile');
        }else{
            return redirect('/register-package');
        }
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
    public function accountstatus(){
        $front_user = front_user::where('email',Session::get('email'))->first();
        $AgreementDetails = "";
        if (!empty($front_user->payer_id)){
            $AgreementDetails = $this->paypaldate($front_user->payer_id);
        }
        return view('front-end.account-status.account-status',[
            'front_user'  => $front_user,
            'AgreementDetails' => $AgreementDetails
        ]);
    }
    public function generatePDF()

    {
        $front_user = front_user::where('email',Session::get('email'))->first();
        $data = ['title' => 'Welcome to HDTuto.com'];

        $pdf = PDF::loadView('front-end.pdf.Invoice', $data);



        return $pdf->download('hdtuto.pdf');
    }



}
