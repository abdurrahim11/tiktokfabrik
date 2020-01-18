<?php

namespace App\Http\Controllers;
use App\front_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;
use PayPal\Auth\OAuthTokenCredential;
use Mail;
class paypalUserController extends Controller
{
    private function apiContext(){
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),       // ClientID
                env('PAYPAL_CLIENT_SECRET')    // ClientSecret
            )
        );
        return $apiContext;
    }
    public function subscribe()
    {
        $id = 'P-7LK141844A476813NWBCHPJY';
        $agreement = new \PayPal\Api\Agreement();
        $agreement->setName('Some subscription name')
            ->setDescription('Initial payment of $15 followed by a recurring payment of $15 on the ' . date('jS') . ' of every month.') // we can start date to 1 month from now if we take our first payment via the setup fee
            ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 month", time())));

        $plan = new Plan();
        $plan->setId($id);
        $agreement->setPlan($plan);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);
        try {
            $agreement = $agreement->create($this->apiContext());
            $approvalUrl = $agreement->getApprovalLink();
        } catch(\Exception $ex) {
            print_r($ex->getMessage());
            die();
        }

        return redirect($approvalUrl);

    }

    public function agreement(Request $request)
    {

        if (!empty($request->input('success')))
        {
            $success = $request->input('success');

            if ($success && !empty($request->input('token')))
            {
                $token = $request->input('token');
                $agreement = new \PayPal\Api\Agreement();
                try {
                    $agreement->execute($token, $this->apiContext());
                } catch(\Exception $ex) {
                    exit(1);
                }
                $agreement = $agreement->toArray();
                if (Session::get('email')){
                    $front_user = front_user::where('email',Session::get('email'))->first();
                    $front_user->subscription_status = 1;
                    $front_user->agreement_id = $agreement['payer']['payer_info']['payer_id'];
                    $front_user->payer_id = $agreement['id'];
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
                    $front_user->agreement_id = $agreement['payer']['payer_info']['payer_id'];
                    $front_user->payer_id = $agreement['id'];
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
            else
            {
                // payment failed, perhaps send the user elsewhere and log the error
            }
        }
    }

    public function webhook()
    {
        /**
         * Receive the entire body that you received from PayPal webhook.
         */
        $bodyReceived = file_get_contents('php://input');

        // Receive HTTP headers that you received from PayPal webhook.
        $headers = getallheaders();

        /**
         * Uppercase all the headers for consistency
         */
        $headers = array_change_key_case($headers, CASE_UPPER);

        $signatureVerification = new \PayPal\Api\VerifyWebhookSignature();
        $signatureVerification->setWebhookId(env('PAYPAL_WEBHOOK_ID'));
        $signatureVerification->setAuthAlgo($headers['PAYPAL-AUTH-ALGO']);
        $signatureVerification->setTransmissionId($headers['PAYPAL-TRANSMISSION-ID']);
        $signatureVerification->setCertUrl($headers['PAYPAL-CERT-URL']);
        $signatureVerification->setTransmissionSig($headers['PAYPAL-TRANSMISSION-SIG']);
        $signatureVerification->setTransmissionTime($headers['PAYPAL-TRANSMISSION-TIME']);

        $webhookEvent = new \PayPal\Api\WebhookEvent();
        $webhookEvent->fromJson($bodyReceived);
        $signatureVerification->setWebhookEvent($webhookEvent);
        $request = clone $signatureVerification;

        try {
            $output = $signatureVerification->post($this->apiContext);
        } catch(\Exception $ex) {
            print_r($ex->getMessage());
            exit(1);
        }

        $verificationStatus = $output->getVerificationStatus();
        $responseArray = json_decode($request->toJSON(), true);

        $event = $responseArray['webhook_event']['event_type'];

        if ($verificationStatus == 'SUCCESS')
        {
            switch($event)
            {
                case 'BILLING.SUBSCRIPTION.CANCELLED':
                case 'BILLING.SUBSCRIPTION.SUSPENDED':
                case 'BILLING.SUBSCRIPTION.EXPIRED':
                case 'BILLING_AGREEMENTS.AGREEMENT.CANCELLED':

                    // $user = User::where('payer_id',$responseArray['webhook_event']['resource']['payer']['payer_info']['payer_id'])->first();
                    $this->updateStatus($responseArray['webhook_event']['resource']['payer']['payer_info']['payer_id'], 0);
                    break;
            }
        }
        echo $verificationStatus;
        exit(0);
    }
    public function paypalcancelsub($agreementId){
        $agreement = new Agreement();
        $agreement->setId($agreementId);
        $agreementStateDescriptor = new AgreementStateDescriptor();
        $agreementStateDescriptor->setNote("Cancel the agreement");
        try {
            $agreement->cancel($agreementStateDescriptor, $this->apiContext());
            $cancelAgreementDetails = Agreement::get($agreement->getId(), $this->apiContext());
        } catch (Exception $ex) {
        }
        if ($cancelAgreementDetails->state==='Cancelled'){
            $front_user = front_user::where('email',Session::get('email'))->first();
            $front_user->subscription_status = 2;
            $front_user->save();
            return redirect('/account-status');
        }
    }
}
