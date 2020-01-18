<?php

namespace App\Http\Controllers;

use App\front_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mail;
class begatewayController extends Controller
{
    public function begateway(){
        \BeGateway\Settings::$shopId  = 361;
        \BeGateway\Settings::$shopKey = 'b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d';

        \BeGateway\Logger::getInstance()->setLogLevel(\BeGateway\Logger::INFO);

        $transaction = new \BeGateway\GetPaymentToken;

        $transaction->money->setAmount(99.00);
        $transaction->money->setCurrency('EUR');
        $transaction->setTestMode(false);
        $transaction->setDescription('test');
        $transaction->setTrackingId('my_custom_variable');
        $transaction->setLanguage('en');
        $transaction->setNotificationUrl('http://www.example.com/notify');
        $transaction->setSuccessUrl(route("/success-bepaid"));
        $transaction->setDeclineUrl('http://www.example.com/decline');
        $transaction->setFailUrl('http://www.example.com/fail');
        $transaction->setCancelUrl('http://www.example.com/cancel');

        $all_data_form = Session::get('reg_form_data');
        $transaction->customer->setFirstName($all_data_form['name']);
        $transaction->customer->setAddress($all_data_form['address']);
        $transaction->customer->setEmail($all_data_form['email']);

        $response = $transaction->submit();
        if ($response->isSuccess() ) {
            return redirect($response->getRedirectUrl());
        }
    }
    public function successbepaid(Request $request){
        if ($request->status == "successful"){
            if (Session::get('email')){
                $front_user = front_user::where('email',Session::get('email'))->first();
                $front_user->subscription_status = 1;
                $front_user->pay_vai = "begateway";
                $front_user->pay_time = date("Y/m/d");
                $front_user->save();
                return redirect('/account-status');
            }else{
                $front_user = new front_user();
                $all_data_form = Session::get('reg_form_data');
                $front_user->name = $all_data_form['name'];
                $front_user->email = $all_data_form['email'];
                $front_user->whatsapp_no = $all_data_form['whatsapp_no'];
                $front_user->password = md5($all_data_form['password']);
                $front_user->address = $all_data_form['address'];
                $front_user->tiktok_username = $all_data_form['tiktok_username'];
                $front_user->tiktok_password = $all_data_form['tiktok_password'];
                $front_user->tiktok_county = $all_data_form['tiktok_county'];
                $front_user->tiktok_target_interest = $all_data_form['tiktok_target_interest'];
                $front_user->tiktok_follower_no = $all_data_form['tiktok_follower_no'];
                $front_user->subscription_status = 1;
                $front_user->pay_vai = "begateway";
                $front_user->pay_time = date("Y/m/d");
                $front_user->save();
                $data = [
                    "name"  => $all_data_form['name'],
                    "email"  => $all_data_form['email'],
                    "address"  => $all_data_form['address'],
                ];
                Mail::send("front-end.mails.confirmation",$data,function ($massage) use($data){
                    $massage->from('support@yourdomain.com', 'tiktokfabrik');
                    $massage->to($data["email"])->cc('support@yourdomain.com');
                    $massage->subject("Tiktokfabrik confirmation ");
                });
                Session::put('email',$all_data_form['email']);
                return redirect('/');
            }
        }
    }
    public function activebegateway(){

    }
}
