<?php

namespace Netramz\ParsianIPG;

class ParsianIPG{
	
	public function __construct(string $LoginAccount)
	{
		$this->LoginAccount = $LoginAccount;
	}
    
    public function paymentRequest($Amount, $OrderId, $CallBackUrl)
    {
		$requestData = [
			'LoginAccount'	=> $this->LoginAccount,
			'OrderId'		=> $OrderId,
			'Amount'		=> $Amount,
			'CallBackUrl'	=> $CallBackUrl
		];
		$client	= new \SoapClient( 'https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL', array(
            'encoding' => 'UTF-8'
        ));
		$result = $client->SalePaymentRequest( [ 'requestData' => $requestData ] );

		$response   = new \stdClass();
		$Status     = $result->SalePaymentRequestResult->Status;
		$token      = $result->SalePaymentRequestResult->Token;
		$Message    = $result->SalePaymentRequestResult->Message ?? NULL;
		
        if( $Status == 0 && $token > 0 ){
            $response->Status   = 'success';
            $response->token    = $token;
        }else{
            $response->Status   = 'error';
            $response->Message  = $Message;
        }
        
        return $response;
	}
    
    public function confirmPayment($token)
    {
		$requestData = [
			'LoginAccount'	=> $this->LoginAccount,
			'Token'			=> $token,
		];
		$client = new \SoapClient( 'https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?WSDL', array(
            'encoding' => 'UTF-8'
        ));
		$result = $client->ConfirmPayment( [ 'requestData' => $requestData ] );
		
		$response           = new \stdClass();
		$Status             = $result->ConfirmPaymentResult->Status;
		$Message            = $result->ConfirmPaymentResult->Message ?? NULL;
		$CardNumberMasked   = $result->ConfirmPaymentResult->CardNumberMasked ?? NULL;
		$RRN                = $result->ConfirmPaymentResult->RRN;
		
		if( $Status == 0 ){
		    $response->Status           = 'success';
	            $response->Message          = $Message;
		    $response->CardNumberMasked = $CardNumberMasked;
		    $response->RRN              = $RRN;
		}else{
		    $response->Status           = 'error';
		    $response->Message          = $Message;
		    $response->CardNumberMasked = $CardNumberMasked;
		    $response->RRN              = $RRN;
		}
        
        return $response;
	}
	
	public function reversalRequest($token)
	{
		$requestData = [
			'LoginAccount'	=> $this->LoginAccount,
			'Token'			=> $token,
		];
		$client = new \SoapClient( 'https://pec.shaparak.ir/NewIPGServices/Reverse/ReversalService.asmx?WSDL', array(
            'encoding' => 'UTF-8'
        ));
		$result = $client->ReversalRequest( [ 'requestData' => $requestData ] );
		
		$response   = new \stdClass();
		$Status     = $result->ReversalRequestResult->Status;
		$Message    = $result->ReversalRequestResult->Message ?? NULL;
		
		if( $Status == 0 ){
            $response->Status  = 'success';
        }else{
            $response->Status  = 'error';
            $response->Message = $Message;
        }
        
        return $response;
	}
	
}
