# ParsianIPG
Internet Payment Gateway Library for Parsian bank **(Iran Banking System)**

Install Using Composer
------------

    composer require netramz/parsianipg
    
Usage
-----

    use Netramz\ParsianIPG\ParsianIPG;
    $IPG = new ParsianIPG('MERCHANTID');

Payment Request
-----

    $paymentRequest = $IPG->paymentRequest($Amount, $OrderId, $CallBackUrl);

    if ($paymentRequest->Status == 'success') {
        echo 'https://pec.shaparak.ir/NewIPG/?Token='.$paymentRequest->token;
    }else{
        //error
    }


Confirm Payment
-----
    $confirmPayment = $IPG->confirmPayment($token);
    if ($confirmPayment->Status == 'success') {

        $Data = [
            "status"           => $paymentRequest->Status,
            "message"          => $paymentRequest->message,
            "CardNumberMasked" => $paymentRequest->CardNumberMasked,
            "RRN"              => $paymentRequest->RRN,
        ];
    
    }else{
        //error
    }
