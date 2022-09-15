<?php
namespace App\Lib;
use Illuminate\Http\Request;

class KnetPayment
{
    const TRANSPORTAL_ID=149501; // Tranportal ID provided by the bank to merchant.TEST : 149501 , LIVE : 204201
    const TRANSPORTAL_PASS="149501pg";// Tranportal password provided by the bank to merchant. TEST : 149501pg ,  LIVE : 8mMd6UyY
    const CURRENCY_CODE="414";// Currency code provided by the bank to merchant.
    const LANGID="USA"; // Transaction language, THIS MUST BE ALWAYS USA OR AR.
    const ACTION="1"; //1=Pur chase , 4 = Authorization
    const TERM_RESOURCE_KEY="9195601413699195";// TESET: 9195601413699195 ,  LIVE : 9211498116699211
    const PAYMENT_REQUEST_URL="https://www.kpaytest.com.kw/kpg/PaymentHTTP.htm?param=paymentInit&trandata=";
    //LIVE URL : https://www.kpay.com.kw/kpg/PaymentHTTP.htm?param=paymentInit&trandata=
    //TEST URL : https://www.kpaytest.com.kw/kpg/PaymentHTTP.htm?param=paymentInit&trandata=

    const RETURN_URL="https://www.basickw.net/payapi/returnUrl.php";
    const RETURN_URL_ERROR="https://www.basickw.net/payapi/returnErrorUrl.php";
    const RESPONSE_URL="https://www.basickw.net/payapi/response.php";
    const BASICTOKEN="66a08c59-3ef4-44bb-9fbf-c6206d785f04";




    public function requestPayment(Request $request)
    {

        $response_array = array();
        //check inputs
        $amount = $request->get('price', '');
        $returnUrl = $request->get('returnUrl', '');


        $refid = $request->get('ref_id', '');
        $udfs1 = $request->get('udf1', '');
        $udfs2 = $request->get('udf2', '');
        $udfs3 = $request->get('udf3', '');
        $token = $request->get('token', '');

        $trackid = date('ymdsi');

        if (empty($token)) {
            $response_array = array("status" => 400, "message" => "Token is missing");
        } else if (!empty($token) && $token != self::BASICTOKEN) {
            $response_array = array("status" => 400, "message" => "Your token is invalid");
        } else if (empty($amount)) {
            $response_array = array("status" => 400, "message" => "Amount value is missing");
        } else if (empty($refid)) {
            $response_array = array("status" => 400, "message" => "Ref. ID  is missing");
        } else if (empty($returnUrl)) {
            $response_array = array("status" => 400, "message" => "Return Url is missing");
        } else {

            //prepare payment
            $ReqTranportalId = "id=" . self::TRANSPORTAL_ID;
            $ReqTranportalPassword = "password=" . self::TRANSPORTAL_PASS;
            $ReqCurrency = "currencycode=" . self::CURRENCY_CODE;
            $ReqLangid = "langid=" . self::LANGID;
            $ReqAction = "action=" . self::ACTION;
            $ReqAmount = "amt=" . $amount;
            $ReqTrackId = "trackid=" . $trackid;
            $ReqResponseUrl = "responseURL=" . self::RETURN_URL;
            $ReqErrorUrl = "errorURL=" . self::RETURN_URL_ERROR;
            $ReqUdf1 = "udf1=" . $trackid;
            $ReqUdf2 = "udf2=" . $refid;
            $ReqUdf3 = "udf3=" . $udfs1;
            $ReqUdf4 = "udf4=" . $udfs2;
            $ReqUdf5 = "udf5=" . $udfs3;

            $ResponseUrl = self::RETURN_URL;
            $ErrorUrl = self::RETURN_URL_ERROR;


            /* Now merchant sets all the inputs in one string for encrypt and then passing to the Payment Gateway URL */
            $param = $ReqTranportalId . "&" . $ReqTranportalPassword . "&" . $ReqAction . "&" . $ReqLangid . "&" . $ReqCurrency . "&" . $ReqAmount . "&" . $ReqResponseUrl . "&" . $ReqErrorUrl . "&" . $ReqTrackId . "&" . $ReqUdf1 . "&" . $ReqUdf2 . "&" . $ReqUdf3 . "&" . $ReqUdf4 . "&" . $ReqUdf5;

            //echo $param; echo "<hr>";
            $param = $this->encryptAES($param, self::TERM_RESOURCE_KEY) . "&tranportalId=" . self::TRANSPORTAL_ID . "&responseURL=" . $ResponseUrl . "&errorURL=" . $ErrorUrl;
            //echo $param;


            $arrayTime = array(
                "presult" => "INITIALIZED",
                "payment_id" => "",
                "postdate" => date("md"),
            );

            //end adding trans rec

            $payUrl = self::PAYMENT_REQUEST_URL . $param; /* Redirect browser */
            return ['url_redirect'=>$payUrl,'track_id'=>$trackid];

           // $response_array = array("status" => 200, "message" => "Payment url is created", "payUrl" => $payUrl);
        }
    }

    public function encryptAES($str,$key) {
        $str = $this->pkcs5_pad($str);
        $iv = $key;
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
        mcrypt_generic_init($td, $key, $iv);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);

        mcrypt_module_close($td);

        $encrypted=unpack('C*', ($encrypted));

        $encrypted=$this->byteArray2Hex($encrypted);

        $encrypted = urlencode($encrypted);

        return $encrypted;

    }
    public function pkcs5_pad ($text) {
        $blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);

    }
    public function byteArray2Hex($byteArray) {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }
    public function decrypt($code,$key) {

        $code =  $this->hex2ByteArray(trim($code));

        $code=$this->byteArray2String($code);

        $iv = $key;

        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);

        mcrypt_generic_init($td, $key, $iv);

        $decrypted = mdecrypt_generic($td, $code);

        mcrypt_generic_deinit($td);

        mcrypt_module_close($td);

        return $this->pkcs5_unpad($decrypted);

    }
    public function hex2ByteArray($hexString) {
        $string = hex2bin($hexString);
        return unpack('C*', $string);

    }
    public function byteArray2String($byteArray) {

        $chars = array_map("chr", $byteArray);

        return join($chars);

    }
    public  function pkcs5_unpad($text) {

        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);

    }


}