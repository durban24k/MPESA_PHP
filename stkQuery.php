<?php
     function stkQuery(){
          require_once './accessToken.php';

          $accessToken=accessToken();
          date_default_timezone_set("Africa/Nairobi");
          $timestamp=date('YmdHis');
          $shortCode='#';
          $passKey='#';
          $password=base64_encode($shortCode.$passKey.$timestamp);
          $query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
          
          $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$accessToken];

          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $query_url);
          curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

          $curl_post_data = array(
          //Fill in the request parameters with valid values
          'BusinessShortCode' => intval($shortCode),
          'Password' => $password,
          'Timestamp' => $timestamp,
          'CheckoutRequestID' => 'ws_CO_130220210232478668'
          );
          
          $data_string = json_encode($curl_post_data);
          
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
          
          $curl_response = curl_exec($curl);
          // print_r($curl_response);
          
          echo $curl_response;
     }
     stkQuery();

     
?>