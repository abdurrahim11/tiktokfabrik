<?php

namespace App\Http\Controllers;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use Illuminate\Http\Request;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use Mail;
class paymentController extends Controller
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

    public function createPlan(){
        $plan = new Plan();
        $plan->setName('Pro Plan')
            ->setDescription('i wil provide tik tok followers')
            ->setType('fixed');

        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')  // or TRIAL
            ->setFrequency('Month')
            ->setFrequencyInterval("1")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 25, 'currency' => 'EUR')));
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(route('/agreement',['success' => 'true']))
            ->setCancelUrl(route('/agreement',['success'=>'false']))
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 25, 'currency' => 'EUR')));

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        try {
            $cratePlan = $plan->create($this->apiContext());
        } catch (Exception $ex) {
            print_r($ex->getMessage());
            die();
        }

        $this->activatePlan($cratePlan);
    }
    private function activatePlan($createdPlan){
        try{
            $patch = new Patch();

            $value = new PayPalModel('{
	       "state":"ACTIVE"
	     }');

            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);

            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $createdPlan->update($patchRequest, $this->apiContext());

            $plan = Plan::get($createdPlan->getId(), $this->apiContext());


        }catch (Exception $ex){
            print_r($ex->getMessage());
            die();
        }
    }
    public function showPlans(){
        $params = array('page_size' => '20','status' => 'ALL');
        $planList = Plan::all($params, $this->apiContext());
        dd($planList->toArray());
    }
    public function deletePlan(){
        $plan_id = 'P-8TD18201W0928383JQII7MGY';
        $plan = Plan::get($plan_id,$this->apiContext());
        $plan->delete($this->apiContext());
    }
}
