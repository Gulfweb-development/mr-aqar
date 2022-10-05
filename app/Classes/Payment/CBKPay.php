<?php

namespace App\Classes\Payment;

class CBKPay
{
	private $ClientId;
	private $ClientSecret;
	private $ENCRP_KEY;
	private $URL;

	function __construct()
	{
		$this->ClientId = config('cbk.ClientId');
		$this->ClientSecret = config('cbk.ClientSecret');
		$this->ENCRP_KEY = config('cbk.ENCRP_KEY');
		$this->URL = true || config('app.env') === 'production' ? "https://pg.cbk.com" : "https://pgtest.cbk.com";
	}

	/* get token */
	public  function getAccessToken()
	{
		$postfield = array(
			"ClientId" => $this->ClientId,
			"ClientSecret" => $this->ClientSecret,
			"ENCRP_KEY" => $this->ENCRP_KEY
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL =>  $this->URL . "/ePay/api/cbk/online/pg/merchant/Authenticate",
			CURLOPT_ENCODING => "",
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FRESH_CONNECT => true,
			CURLOPT_POSTFIELDS => json_encode($postfield),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic ' . base64_encode($this->ClientId . ":" . $this->ClientSecret),
				"Content-Type: application/json",
				"cache-control: no-cache",
				"Content-Length: " . strlen(json_encode($postfield))
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$authenticateData = json_decode($response);
		if ($authenticateData->Status == "1") {
			return $authenticateData->AccessToken;
		} else {
			return false;
		}
	}

	/*request payment url*/
	public function initiatePayment($amount, $trackid, $reference, $udf1 = '', $udf2 = '', $udf3 = '', $udf4 = '', $udf5 = '',  $paymentType = '', $lang = 'en', $returnUrl = '')
	{

		//get access token 
		if ($AccessToken = $this->getAccessToken()) {
			//generate pg page 
			$formData = array(
				'tij_MerchantEncryptCode' => $this->ENCRP_KEY,
				'tij_MerchAuthKeyApi' => $AccessToken,
				'tij_MerchantPaymentLang' => $lang,
				'tij_MerchantPaymentAmount' => $amount,
				'tij_MerchantPaymentTrack' => $trackid,
				'tij_MerchantPaymentRef' => $reference,
				'tij_MerchantUdf1' => $udf1,
				'tij_MerchantUdf2' => $udf2,
				'tij_MerchantUdf3' => $udf3,
				'tij_MerchantUdf4' => $udf4,
				'tij_MerchantUdf5' => $udf5,
				'tij_MerchPayType' => $paymentType,
				'tij_MerchReturnUrl' => $returnUrl
			);
			$url = $this->URL . "/ePay/pg/epay?_v=" . $AccessToken;
			$form = "<form id='pgForm' method='post' action='$url' enctype='application/x-www-form-urlencoded'>";
			foreach ($formData as $k => $v) {
				$form .= "<input type='hidden' name='$k' value='$v'>";
			}
			$form .= "</form><div style='position: fixed;top: 15%;left: 50%;transform: translate(-50%, -50%);text-align:center'>Redirecting... <br> <b> DO NOT REFRESH</b><br><img src='/fancybox/source/fancybox_loading@2x.gif'></div><script type='text/javascript'>
                document.getElementById('pgForm').submit();
            </script>";

			return $form;
		} else {
			return "Authentication Failed";
		}
	}


	/*get response*/
	public function getPaymentStatusDetails($encrp)
	{
		//returns the unencrypted data
		//get access token 
		if ($AccessToken = $this->getAccessToken()) {
			$url = $this->URL . "/ePay/api/cbk/online/pg/GetTransactions/" . $encrp . "/" . $AccessToken;
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_ENCODING => "",
				CURLOPT_FOLLOWLOCATION => 1,
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HTTPHEADER => array(
					'Authorization: Basic ' . base64_encode($this->ClientId . ":" . $this->ClientSecret),
					"Content-Type: application/json",
					"cache-control: no-cache"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);


			$paymentDetails = json_decode($response);
			if ($paymentDetails->Status != "0" or $paymentDetails->Status != "-1") {
				return $paymentDetails;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	/*verify Payment*/
	public function getPaymentStatusDetailsAlt($trackid)
	{

		if ($AccessToken = $this->getAccessToken()) {

			$postfield = array(
				"authkey" => $AccessToken,
				"encrypmerch" => $this->ENCRP_KEY,
				"payid" => $trackid
			);
			
			$url = $this->URL . "/ePay/api/cbk/online/pg/Verify";
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_ENCODING => "",
				CURLOPT_FOLLOWLOCATION => 1,
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_FRESH_CONNECT => true,
				CURLOPT_POSTFIELDS => json_encode($postfield),
				CURLOPT_HTTPHEADER => array(
					'Authorization: Basic ' . base64_encode($this->ClientId . ":" . $this->ClientSecret),
					"Content-Type: application/json",
					"cache-control: no-cache",
					"Content-Length: " . strlen(json_encode($postfield))
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);


			$paymentDetails = json_decode($response);
			
			if (@$paymentDetails->Status != "0" || @$paymentDetails->Status != "-1") {
				return $paymentDetails;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function getPaymentStatus($paymentStatusData) {
		if(!@$paymentStatusData || (!@$paymentStatusData->Status && !@$paymentStatusData->ErrorCode)){
			return 'failed';
		}

		if(@$paymentStatus->Status){
			if(in_array($paymentStatus->Status, ['-1', '0'])){
				return 'invalid';
			}else if($paymentStatus->Status == '1'){
				return 'success';
			}else if($paymentStatus->Status == '2'){
				return 'failed';
			}else if($paymentStatus->Status == '3'){
				return 'canceled';
			}
		}else if(@$paymentStatus->ErrorCode){
			return 'invalid';
		}else{
			return 'failed';
		}
		
	}


	/*print predefined CBK PG error*/
	public function getCBKError($error_code)
	{

		switch ($error_code) {
			case "TIJ0001":
				$error = "Invalid Merchant Language";
				break;
			case "TIJ0002":
				$error = "Invalid Merchant Amount";
				break;
			case "TIJ0003":
				$error = "Invalid Merchant Amount KWD";
				break;
			case "TIJ0004":
				$error = "Invalid Merchant Track ID";
				break;
			case "TIJ0005":
				$error = "Invalid Merchant UDF1";
				break;
			case "TIJ0006":
				$error = "Invalid Merchant Currency";
				break;
			case "TIJ0007":
				$error = "Invalid Merchant Payment reference";
				break;
			case "TIJ0008":
				$error = "Invalid Merchant Pay Type";
				break;
			case "TIJ0009":
				$error = "Invalid Merchant API Authenticate Key";
				break;
			case "TIJ0015":
				$error = "Invalid Merchant UDF2";
				break;
			case "TIJ0016":
				$error = "Error in QR";
				break;
			case "TIJ0020":
				$error = "Error in KNET";
				break;
			case "TIJ0022":
				$error = "Invalid Merchant UDF3";
				break;
			case "TIJ0023":
				$error = "Invalid Merchant UDF4";
				break;
			case "TIJ0024":
				$error = "Invalid Merchant UDF5";
				break;
			default:
				$error = "Unknown error";
		}
		return $error;
	}

	public function getPaymentResultMsg($statusCode){
		switch ($statusCode) {
			case '-1':
				$message = ("Session Invalid! Please try again.");
				break;

			case '0':
				$message = ("Session Invalid! Please try again.");
				break;

			case '1':
				$message = ("Payment Successful!!");
				break;

			case '2':
				$message = ("Payment Failed!!");
				break;

			case '3':
				$message = ("Session Expired! Please try again.");
				break;

			default:
				$message = ("Sorry something went wrong!! Please try again");
				break;
		}
		return $message;
	}
}
