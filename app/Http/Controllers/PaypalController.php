<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Order;
use Session;

class PaypalController extends Controller
{

    private $gateway;

    public function __construct()
    {
       
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId('AQmvhyfqxnYiOZLjz0y6FXi2nJyCPo3-wqhcWoiqn2rnHPDRziQr39IbKBOYU6BTRnlZvLVDUElGf0ec');
        $this->gateway->setSecret('EJMyMd1CtrbLV4iOgcqEtks_Bl1-lGrEnr8eXCm2p9gsmIJXqii8aj1ylTbzToJmE_Q4gOVupuNWJ-1s');
        $this->gateway->setTestMode(true);
      
    }

    /**
     * Initiate a payment on PayPal.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function charge(Request $request)
    {
        if ($request->input('price')) {

            try {
                $response = $this->gateway->purchase(array(
                    'amount' => $request->input('price'),
                    'items'  => array(
                        array(
                            'name'        => 'Course Subscription',
                            'price'       => $request->input('price'),
                            'description' => 'Get access to premium courses.',
                            'quantity'    => 1
                        ),
                    ),
                    'currency'  => env('PAYPAL_CURRENCY'),
                    'returnUrl' => url('paymentsuccess/'.$request->input('id')),
                    'cancelUrl' => url('paymenterror/'.$request->input('id')),
                ))->send();

                if ($response->isRedirect()) {
                    $response->redirect();
                } else {

                    // not successful
                    return $response->getMessage();
                }
            } catch (Exception $e) {

                return $e->getMessage();
            }
        }
    }

    /**
     * Charge a payment and store the transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function success($id, Request $request)
    {
         $order = Order::find($id);
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
           
            if ($response->isSuccessful()) {
                $arr_body = $response->getData();
                $order->status = $arr_body['state'];
                $order->save();
                Session::flash('success', 'Payment successful!');
                return redirect('/owner');
            } else {
                return $response->getMessage();
            }
        } else {
            $order->status = 'declined';
            $order->save();
            Session::flash('success', 'Transaction is declined!');
            return redirect('/owner');
        }
    }

    /**
     * Error Handling.
     */
    public function error($id, Request $request)
    {
        $order = Order::find($id);
        $order->status = 'canceled';
        $order->save();
        Session::flash('success', 'Payment canceled!');
        return redirect('/owner');
    }
 
}
