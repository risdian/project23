<?php

namespace App\Services;

use App\Models\Order;
use Auth;
use App\Models\OrderItem;

class ToyyibPayService {

    protected $toyyibPay;

    public function __construct()
    {
        if (config('settings.toyyibpay_secret_id') == '' || config('settings.toyyibpay_client_id') == '') {
            return redirect()->back()->with('error', 'No ToyyibPay settings found.');
        }

    }

    public function processPayment($order){

        $orders = Order::findOrFail($order->id);

        $grand_total = $orders->grand_total * 100;
        $option = [
            'userSecretKey' => 'kvdo9x8y-799s-d5yn-3ugb-c860ubvakzx9',
            'categoryCode' => '1bynfwel',
            'billName' =>  'Al-ikhlas personal shopper',
            'billDescription' => 'Al-ikhlas personal shopper',
            'billPriceSetting'=> 1,
            'billPayorInfo'=> 1,
            'billAmount'=> $grand_total,
            'billReturnUrl'=> route('complete.payment'),
            'billCallbackUrl'=> route('payment.update'),
            'billExternalReferenceNo' => $orders->order_number,
            'billTo'=> $orders->name,
            'billEmail'=> $orders->email,
            'billPhone'=> $orders->phone_number,
            'billSplitPayment'=> 0,
            'billSplitPaymentArgs'=> '',
            'billPaymentChannel'=> 0,
            'billDisplayMerchant'=>1,
            'billContentEmail'=>'Email content'
            ];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $option);


            $result = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
            $obj = json_decode($result);
            $obk = $obj[0]->BillCode;

            $orders->payment_code = $obk;

            $orders->save();


          return $order;

    }

    public function completePayment($paymentId, $payerId, $status_id){

        // Checking Payment

        $option = [

            'billCode' => $payerId,
            // 'billpaymentStatus' => '1'
        ];

        // dd($status_id);
          $curl = curl_init();

          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/getBillTransactions');
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $option);

          $result = curl_exec($curl);
          $info = curl_getinfo($curl);
          curl_close($curl);
          $obj = json_decode($result);
          $transactions = $obj[0];
        //   dd($transactions);

          if ($transactions->billpaymentStatus === '1') {

            $paymentStatus = $transactions->billpaymentStatus;
            $invoiceId = $transactions->billName;
            $saleId = $transactions->billpaymentInvoiceNo;

            $transactionData = ['salesId' => $saleId, 'invoiceId' => $invoiceId, 'paymentStatus' =>  $paymentStatus];

            return $transactionData;
        } else {

            if($transactions->billpaymentStatus === '2'){
                $result_last = 'Pending transaction';
            }
            if($transactions->billpaymentStatus === '3'){
                $result_last = 'Unsuccessful transaction';
            }
            if($transactions->billpaymentStatus === '4'){
                $result_last = 'Pending';
            }

            $paymentStatus = $transactions->billpaymentStatus;
            $invoiceId = $transactions->billName;
            $saleId = $transactions->billpaymentInvoiceNo;

            $transactionData = ['salesId' => $saleId, 'invoiceId' => $invoiceId, 'paymentStatus' =>  $paymentStatus];

            return $transactionData;

        }
    }
}
