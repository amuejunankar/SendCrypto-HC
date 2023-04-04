<?php

// This file is used to send SMS OTP only.
// By passing number and otp.

function sendSMS($mobileNumber, $otpsms) {
    $fields = array(
        "variables_values" => "$otpsms",
        "route" => "otp",
        "numbers" => "$mobileNumber",
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($fields),
      CURLOPT_HTTPHEADER => array(
        "authorization: LWcJCMB90vheEI7og6iPGFaXwNprTVlzORsH5jUqDt3dmZA8xb5gunr7WHK16PyTJGNMlmpB4obihtsE",
        "accept: */*",
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      throw new Exception("cURL Error #:" . $err);
    }
}


?>