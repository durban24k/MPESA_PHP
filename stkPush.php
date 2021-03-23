<?php
      function stkPush($phone,$amnt){
            require_once './accessToken.php';

            $accessToken=accessToken();
            date_default_timezone_set("Africa/Nairobi");
            $timestamp=date('YmdHis');
            $shortCode='#';
            $passKey='#';
            $password=base64_encode($shortCode.$passKey.$timestamp);
            $callBack='https://d7a3c7b04a3b.ngrok.io/TeleHealth/callback.php';
            $stk_url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

            $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$accessToken];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $stk_url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

            $curl_post_data = array(
                  //Fill in the request parameters with valid values
                  'BusinessShortCode' => intval($shortCode),
                  'Password' => $password,
                  'Timestamp' => $timestamp,
                  'TransactionType' => 'CustomerPayBillOnline',
                  'Amount' => $amnt,
                  'PartyA' => $phone,
                  'PartyB' => intval($shortCode),
                  'PhoneNumber' => $phone,
                  'CallBackURL' => $callBack,
                  'AccountReference' => 'Medical',
                  'TransactionDesc' => 'AFIAPLUS SERVICE'
            );

            $data_string = json_encode($curl_post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $curl_response = curl_exec($curl);
            print_r($curl_response);
            $transaction_data=json_decode($curl_response);
            echo $transaction_data->CheckoutRequestID;
      }
      stkPush($phone,$amnt);
?>