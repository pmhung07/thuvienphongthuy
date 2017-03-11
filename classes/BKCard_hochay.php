<?
/**
* nạp thẻ cào hochay
*/

define('CORE_API_HTTP_USR', 'h0ch4yvn');
define('CORE_API_HTTP_PWD', 'DLt2P3yl9gHmmqSxm557');


//key chuan
define('PRIVATE_KEY_BAOKIM','-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQC+j75g1cdZTPVT
sS3xToi+ADGeEXDst+uh2Z+qvrEOHjxqKQIc4vHizszsKfRPwIiXO7pXcSz2qNIC
HTkt3MnGov8Mynvacs3/CLR+pZ5C3cLCwxWO+wRB16b/KXMfuAbMM4Lqe70f9gI2
XVpa3hWUkFJmr7gC82Yf6IXhNfaGxti2YNB6Bj2pt/9N5v9AXOMqwF4ZN7ZLBhzF
qKpuqA280LPqkCa7XyTY3Y9/tPfJ95LCj15Q1jl8VOvuO34U2o/y7VRCryN7DJWb
z4apUbQdvmU5YO9sz1SSkLa2SAz4a2unChT30joF48QTV+DkFn6PQ0PuqIVyYgtR
Qsg9NHpbAgMBAAECggEAHQlGFvc8Eu1ZDFGZEIXI7DqXVOCPdmJn8xd37spzrBUL
W5m4CrLB7K9aJjoWUfiiV3jwYdaK5WK/7TaKueREkpHPjyFjUdvga5Xl+s49mS61
OHwFUu4IrgewGH02X4To9EB9GEGWhcI0gBglZmcknqiHBcKMpVZ1HzONAs34LHzo
sZ1QiFd8TODAKvK+fxwDxKkGLtjrx+UZ3V1ybCLe9IMLj28J3MoWRGh6DJBAmtI0
wMU5d31mYM9w5mx39jZ9E8uO1vAWd6hpfxlbrMla8egheuRDOIcwhXUSkADO6Tc/
F4dIiYeOQDNKnIXE8Rzt6yeHWE/F+gkP3Sb8Ao7s4QKBgQDnqXxM7Ab7QKCn1IcA
DoIRk6iikPPWRIU5NaeMmeZCizEgCv1rnbq0xhM/JpGXk8fsSViEp1Zr9RILvzQi
r2OkYYT9uGWY3J0Z2b7JxbBha8WEoRiA2ggLM+lHrLUyIgDJ/MhQoATuxQI44hWC
paLJdjZ8Z7Mds+xrJVDyDvFY8wKBgQDSlN18YqwHYysA1SDLAPrKMJSBplVXuV48
QDEcw9r90J38gbr/T8mVLnU+BHsSZ6SCdKbSXPrBhn8twumpKH2nrUh7ZFKHf3Hd
FZ3RZOlDo+Vo5nqfxiRrp2tKm1r/FgpwEL1UjLZHT9AXK01NgblO3BoY5kujEgF/
Z0uvr/Sy+QKBgQCbrzgczcYHVjBheZ9cN2PMAiqjTbzAs33Aq8E06TxoXfieqyQS
DYcq8659kyLm9ea2cbguNfMLTEBbapzT7oCNOQhSJnkImMJvW/kuyk81uWKdNlIs
Tdp4BOPySivfTCCxndLU9CU8fWN37OA906ipsWr+ggZKoN7yRrq2YbpqZwKBgQCm
YL/uOve4jn23lqzmN8vuXBu5o/Xh7a+q4vzqwUQRLfblPorElgGrQJ2ZdmjWzdSI
zinQI25r4Rwyx8FdyYQeKycNduJN9D++cgnTG2vB6YikLRXNjvvPouN+euiWio+M
o20zlEmgZkr/Q1M8XbZPvE9SRQKVwPA1/SMrmFY54QKBgQCGQ4T9nI4+9lVrPYwR
zAvMmmUdD8Qzja9JTWeXEHajPiA1mw/hwPQGQ03Iz3XK9pbrzJ1xc4rJaupR2kFz
gMn6dVaCGWCMCTvrj0LpTa4UalUYp/mceXdwUr3p8FdMLRywsrSoz+SHLzdARqFJ
gkaLwVbNyVOfVFcfQCMZuml0iA==
-----END PRIVATE KEY-----
');

class BKCardHochay{
            
    public $uri = '/s-card/api/agent';
    public $domain = 'https://www.baokim.vn';
    
    public function AddMoneyCardHochay($seri,$pin,$email){
        $arr_return = array();
        $seri  = htmlspecialchars($seri);
        $pin   = htmlspecialchars($pin);
        $email = htmlspecialchars($email);
        
        $arrayPost = array(
        	'seri'=>$seri,
        	'pin'=>$pin,
        	'email_from'=>$email
        );
        
        //	Khi có Signature thì thêm vào $url
        $signature = $this->makeSignature('POST',$this->uri, array(), $arrayPost, PRIVATE_KEY_BAOKIM);
        
        $url_signature = $this->domain.$this->uri.'?signature='.$signature;
        // Sandbox no signature     
        $curl = curl_init($url_signature);
        //echo $url_signature; die;
        
        curl_setopt_array($curl, array(
        	CURLOPT_POST=>true,
        	CURLOPT_HEADER=>false,
        	CURLINFO_HEADER_OUT=>true,
        	CURLOPT_TIMEOUT=>30,
        	CURLOPT_RETURNTRANSFER=>true,
        	CURLOPT_SSL_VERIFYPEER => 1,
        	CURLOPT_CAINFO=>dirname(__FILE__).'/ca.certs',
        	CURLOPT_HTTPAUTH=>CURLAUTH_DIGEST|CURLAUTH_BASIC,
        	CURLOPT_USERPWD=>CORE_API_HTTP_USR.':'.CORE_API_HTTP_PWD,
        	CURLOPT_POSTFIELDS=>http_build_query($arrayPost)
        ));
        
    
        $data = curl_exec($curl);
        //var_dump($data);die();
        //$txt_log = '';
        //$card_hochay_logs = $_SERVER['DOCUMENT_ROOT'] . '/logs/card_hochay.log'; 
        //$card_hochay_handle = fopen($card_hochay_logs , 'a') or die("can't open file");
        //fwrite($card_hochay_handle, date('d:m:Y-H:i:s').'\t'.$data.'\n');
            
        if ($data == false) {
        	$errCode = curl_errno($curl);
        	$message = curl_error($curl);
        
            $arr_return['code']     =  $errCode;
            $arr_return['message']   =  $message;
        	
        }else{
        	$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
            $arr_return['code']     =  $code;
            //var_dump($arr_return['code']);
            //$arr_return['data']     = json_decode($data,true);
            $arr_return['data']     = json_decode($data,true);
            //var_dump($arr_return['data']);die();       
        }
        return $arr_return;
    }
    public function makeSignature($method, $url, $getArgs=array(), $postArgs=array(), $priKeyFile){
    	if(strpos($url,'?') !== false)
    	{
    		list($url,$get) = explode('?', $url);
    		parse_str($get, $get);
    		$getArgs=array_merge($get, $getArgs);
    	}
    
    	ksort($getArgs);
    	ksort($postArgs);
    	$method=strtoupper($method);
    
    	$data = $method.'&'.urlencode($url).'&'.urlencode($this->httpBuildQuery($getArgs)).'&'.urlencode($this->httpBuildQuery($postArgs));
    
    	$priKey = openssl_get_privatekey($priKeyFile);
    
    	openssl_sign($data, $signature, $priKey, OPENSSL_ALGO_SHA1);
    
    	return urlencode(base64_encode($signature));
    }
    
   public function httpBuildQuery($formData, $numericPrefix='', $argSeparator='&', $arrName=''){
    	$query = array();
    	foreach ($formData as $k=>$v) {
    		if (is_int($k)) $k = $numericPrefix.$k;
    		if (is_array($v)) $query[] = httpBuildQuery($v, $numericPrefix, $argSeparator, $k);
    		else $query[] = rawurlencode(empty($arrName)?$k:($arrName.'['.$k.']')).'='.rawurlencode($v);
    	}
    
    	return implode($argSeparator, $query);
    }
}
?>