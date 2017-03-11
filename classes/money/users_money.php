<?
//kiểu tài khoản chính
define('TYPE_MONEY_MAIN', 1);
define('TYPE_MONEY_PROMOTION', 2);
define('TYPE_UPDATE_MONEY_ADD', 1);
define('TYPE_UPDATE_MONEY_SPENT', 2);
define('TYPE_SPENT_ONE_MOVIE', 1);
//nạp tiền qua tin nhắn
define('TYPE_ADD_FROM_VATGIA', 1);
define('TYPE_ADD_FROM_SMS', 2);
define('TYPE_ADD_FROM_FACEBOOK', 3);
define('TYPE_ADD_FROM_MOBILE_CARD', 4);
define('TYPE_ADD_TANG_TIEN', 5);
define('TYPE_ADD_BAOKIM', 6);

//định nghĩa các kiểu mã hóa
define('HASH_TYPE_MONEY', 1);

//phần tài khoản bảo kim
$class_money_dir	=	dirname(__FILE__);

require_once($class_money_dir . "/BKPaymentProService2.php");
require_once($class_money_dir . "/BKTransactionAPI.php");
//require_once($class_money_dir . "/BaoKimPayment.php");
/*
Class lưu trử thông tin tài khoản của user
*/
class UserMoney{
	
	//khai báo số lượng bảng lưu lịch sử tiêu tiền
	protected $num_table_spent = 10;
	//khai báo số lượng bảng lưu lịch sử nạp tiền
	protected $num_table_add	=	10;
	//khai báo mật khẩu mã hóa
	protected $password_sercurity	=	"flsjfsld01lf0s;fs0";
	
	//khai bao thư mục chứa log
	protected $path_log;
	
	//khai báo biến chứa tiền
	protected $money				=	0;
	protected $money_promotion	=	0;
	protected $user_id;
	public	 $errorMsg;
	public	 $baokim_transaction_api_url;
	public	 $baokim_request_url;
	public	 $baokim_api_password;
	public	 $baokim_user_email;
	public	 $baokim_api_username;
	public	 $baokim_merchant_id;
	public	 $baokim_secure_pass;
	//phần trăm tiền được nhận từ thẻ khi nạp tiền
	protected $percent_card = 0.83;
	
	protected $mmca_money	=	0;
   public    $numm_pay     =   0;
	
	
	/**
	 * Hàm khởi tạo
	 */
	function UserMoney($user_id = 0){
      $user_id								=	intval($user_id);
      if($user_id < 0) $user_id 		= 	0;
      $this->user_id						=	$user_id;
      $this->path_log				   =	$_SERVER["DOCUMENT_ROOT"] . "/logs/";
		
		
		/*$this->baokim_transaction_api_url		=	"http://sandbox.baokim.vn/services/transaction_api/init?wsdl";
		$this->baokim_api_password 				=   "hochay";
		$this->baokim_api_username				=	"hochay"; 
		$this->baokim_secure_pass				=	"a63f5c5d7d21cd80";
		//$this->baokim_secure_secret  			=   "hochayvnlml3w34";
		$this->baokim_merchant_id				=	"759";
		$this->baokim_user_email				=	"it.hoanlv@gmail.com";
		$this->baokim_payment_url 				=	"http://sandbox.baokim.vn/payment/customize_payment/order";
		//link otp nạp qua bảo kim
		$this->baokim_request_url				=	"http://sandbox.baokim.vn/services/payment_pro_2/init?wsdl";*/
      
      /*$this->baokim_transaction_api_url		=	"http://sandbox.baokim.vn/services/transaction_api/init?wsdl";
		$this->baokim_api_password 				=  "nhajben";
		$this->baokim_api_username				   =	"nhajben"; 
		$this->baokim_secure_pass			 	   =	"ebc9f951ea3020e8";
		$this->baokim_secure_secret  			   =  "nhajben";
		$this->baokim_merchant_id				   =	"577";
		$this->baokim_user_email				   =	"nhaj_ben@yahoo.com.vn";
		$this->baokim_payment_url 				   =	"http://sandbox.baokim.vn/payment/customize_payment/order";
		//link otp nạp qua bảo kim
		$this->baokim_request_url				   =	"http://sandbox.baokim.vn/services/payment_pro_2/init?wsdl";*/
		
		
	 	$this->baokim_transaction_api_url	=	"https://www.baokim.vn/services/transaction_api/init?wsdl";
		$this->baokim_api_password 			=  "wwwhochayvn9Hfdhfkfkd";
		$this->baokim_api_username				=	"wwwhochayvn"; 
		$this->baokim_secure_pass				=	"6d7ad20e66d056fc";
		$this->baokim_secure_secret  			=  "hochayvnlml3w34";
		$this->baokim_merchant_id				=	"9688";
		$this->baokim_user_email				=	"hochayhochay@gmail.com";
		$this->baokim_payment_url 				=	"https://www.baokim.vn/payment/customize_payment/order";
		//link otp nạp qua bảo kim
		$this->baokim_request_url				=	"https://www.baokim.vn/services/payment_pro_2/init?wsdl";
		
		/** 
		$this->baokim_transaction_api_url	=	"https://www.baokim.vn/services/transaction_api/init?wsdl";
		$this->baokim_api_password 			=  "893bsdj278sd9n78sdn27sdn";
		$this->baokim_api_username				=	"diep2810"; 
		$this->baokim_secure_pass				=	"6c11c4496df586cf";
		$this->baokim_user_email				=	"diep2810@gmail.com";
		$this->baokim_merchant_id				=	"3290";
		$this->baokim_payment_url 				=	"https://www.baokim.vn/payment/customize_payment/order";
		$this->baokim_request_url				=	"https://www.baokim.vn/services/payment_pro_2/init?wsdl";
		*/
	}
	

	
	
	/**
	 * Hàm lấy số tiền còn lại
	 */
 	function getMoney(){
      if($this->money != 0){
      	return $this->money;
      }else{
      	$db_select = new db_query("SELECT mou_money,mou_money_promotion
      										FROM money_users
      										WHERE mou_user_id = " . $this->user_id
      										, __FILE__ . " Line: " . __LINE__);
      	if($row = mysql_fetch_assoc($db_select->result)){
      		$this->money				=	$row["mou_money"];
      		$this->money_promotion	=	$row["mou_money_promotion"];
      	}else{
      		return $this->money;
      	}
      }
      return $this->money;
 	}
 	
	/**
	 * Hàm lấy số tiền còn lại
	 */
 	function getMoneyPromotion(){
 		if($this->money_promotion != 0){
 			return $this->money_promotion;
 		}else{
 			$db_select = new db_query("SELECT mou_money,mou_money_promotion
												FROM money_users
												WHERE mou_user_id = " . $this->user_id
												, __FILE__ . " Line: " . __LINE__);
			if($row = mysql_fetch_assoc($db_select->result)){
				$this->money				=	$row["mou_money"];
				$this->money_promotion	=	$row["mou_money_promotion"];
			}else{
				return $this->money_promotion;
			}
 		}
 	}
   /**
   * 
   * Hàm nạp tiền qua ATM
   * 
   */ 	
	function add_money_atm($user_id,$bank_id,$uname,$total_amount,$url_return,$timeact,$payment_type,$comment = "",$type_pay){
	   $user_id	 =	intval($user_id);
	   $uname    = replaceMQ($uname);
	   $db_user  = new db_query("SELECT * FROM users WHERE use_id = ".$user_id);
	   $row_user = mysql_fetch_assoc($db_user->result);
	   unset($db_user);
	   $payer_name = $row_user['use_name'];
	   $payer_email = $row_user['use_email'];
	   if ($uname == '') $uname = $payer_name;
	   //echo $payer_name.'-'.$payer_email;
	   //die();
	   $tax_fee            =   "0";
	   $shipping_fee       =   "0";
	   $order_description  =   "Note order";
      $bank_id	           =	intval($bank_id);
      $total_amount	     =	intval($total_amount);
      $maa_ip	           =	ip2long($_SERVER['REMOTE_ADDR']);
      $comment	           =	replaceMQ($comment);
      $payment_type       =   replaceMQ($payment_type);
	   $url_return         =   replaceMQ($url_return);
	   //echo $total_amount;
	   //die();
      $db_execute			  = new db_execute_return();
	   $vg_transaction_id  = $db_execute->db_execute("INSERT INTO money_atm_add(maa_user_id,maa_money,maa_ip,maa_comment,maa_date,maa_status,maa_bank)
																	  VALUES(
			                                             " . $user_id . "
                                                     ," . $total_amount . "
				                                         ," . $maa_ip . "
																 	  ,'" . $comment . "'
                                                     ," . time() . "
																 	  ,0
				                                         ,". $bank_id . "
																  	  )", __FILE__ . " Line: " . __LINE__);
	   unset($db_execute);
      if($vg_transaction_id <= 0){
			$this->errorMsg .= "&bull; Có lỗi xảy ra khi thực hiện. Bạn hãy liên hệ ban quản trị để nhờ trợ giúp.<br />";	
      //ngược lại thì bắt đầu bắn sang bảo kim	
		}else{		    
         $request_info = new PaymentInfoRequest(); 	    			
			$request_info->api_username            = $this->baokim_api_username;
        	$request_info->api_password            = $this->baokim_api_password;
        	$request_info->merchant_id             = $this->baokim_merchant_id;			
			$request_info->bk_seller_email         = $this->baokim_user_email;
        	$request_info->order_id                = $type_pay."_".$vg_transaction_id;
        	$request_info->total_amount            = $total_amount;
        	$request_info->tax_fee                 = $tax_fee;
        	$request_info->shipping_fee            = $shipping_fee;
        	$request_info->order_description       = "Nạp tiền kích hoạt tài khoản hochay.vn";
        	$request_info->currency_code           = "VND";					
			$request_info->bank_payment_method_id  = $bank_id;
			$request_info->payment_mode            = 1;
			$request_info->payer_name              = $uname;
			$request_info->payer_email             = $payer_email;			
			
			if($row_user['use_phone'] == "" ) { 
				$request_info->payer_phone_no  = "0986278627"; 
			}else{ 
				$request_info->payer_phone_no = str_replace("+84","0",$row_user['use_phone']); 
			}; 
			
			$request_info->shipping_address        = "";
        	$request_info->payer_message           = "";
        	$request_info->escrow_timeout          = "";
        	$request_info->extra_fields_value      = "";
			
			//$location                              = 'http://sandbox.baokim.vn';
			$location                              = 'https://www.baokim.vn';
			$bk                                    = new BKPaymentProService2($location."/services/payment_pro_2/init?wsdl");
			$request_info->url_return              = $url_return;//Khi thanh toán thành công sẽ trở về url này
			$response_info                         = $bk->DoPaymentPro($request_info);
			//var_dump($response_info);
			//die();
			if($response_info->error_code == 0){
				$url    =   $response_info->url_redirect;
				redirect($url);
			}else{
				var_dump($response_info);
			}
      }
	}
   
   /**
   * 
   * Hàm nạp tiền qua ATM - v2
   * 
   */ 	
	function add_money_atm_v2($user_id,$bank_id,$uname,$total_amount,$url_return,$timeact,$payment_type,$comment = "",$type_pay){
	   
      $user_id	           =	intval($user_id);
      $uname              =   replaceMQ($uname);
      $bank_id	           =	intval($bank_id);
      $total_amount	     =	intval($total_amount);
      $maa_ip	           =	ip2long($_SERVER['REMOTE_ADDR']);
      $comment	           =	replaceMQ($comment);
      $payment_type       =   replaceMQ($payment_type);
	   $url_return         =   replaceMQ($url_return);
      $tax_fee            =   "0";
	   $shipping_fee       =   "0";
	   $order_description  =   "Note order";
      
	   $db_user  = new db_query("SELECT * FROM users WHERE use_id = ".$user_id);
	   $row_user = mysql_fetch_assoc($db_user->result);
	   unset($db_user);
      
	   $payer_name         = $row_user['use_name'];
	   $payer_email        = $row_user['use_email'];
	   if ($uname == '') $uname = $payer_name;
      
      $db_execute			  = new db_execute_return();
	   $vg_transaction_id  = $db_execute->db_execute("INSERT INTO money_atm_add(maa_user_id,maa_money,maa_ip,maa_comment,maa_date,maa_status,maa_bank)
																	  VALUES(
                    			                                             " . $user_id . "
                                                                         ," . $total_amount . "
                    				                                         ," . $maa_ip . "
                    																 	  ,'" . $comment . "'
                                                                         ," . time() . "
                    																 	  ,0
                    				                                         ,". $bank_id . "
                    																  	  )", __FILE__ . " Line: " . __LINE__);
	   unset($db_execute);
      if($vg_transaction_id <= 0){
			$this->errorMsg .= "&bull; Có lỗi xảy ra khi thực hiện. Bạn hãy liên hệ ban quản trị để nhờ trợ giúp.<br />";	
      //ngược lại thì bắt đầu bắn sang bảo kim	
		}else{		    
         $request_info = new PaymentInfoRequest(); 	    			
			$request_info->api_username            = $this->baokim_api_username;
        	$request_info->api_password            = $this->baokim_api_password;
        	$request_info->merchant_id             = $this->baokim_merchant_id;			
			$request_info->bk_seller_email         = $this->baokim_user_email;
        	$request_info->total_amount            = $total_amount;
        	$request_info->tax_fee                 = $tax_fee;
        	$request_info->shipping_fee            = $shipping_fee;
        	$request_info->order_description       = "Nạp tiền kích hoạt tài khoản hoc123.vn";
        	$request_info->currency_code           = "VND";					
			$request_info->bank_payment_method_id  = $bank_id;
			$request_info->payment_mode            = 1;
			$request_info->payer_name              = $uname;
			$request_info->payer_email             = $payer_email;
         $request_info->shipping_address        = "";
        	$request_info->payer_message           = "";
        	$request_info->escrow_timeout          = "";
        	$request_info->extra_fields_value      = "";
         $request_info->url_return              = $url_return;
         
         if($row_user['use_phone'] == "" ) { 
				$request_info->payer_phone_no       = "0986278627"; 
			}else{ 
            //$request_info->payer_phone_no = str_replace("+84","0",$row_user['use_phone']);
            $request_info->payer_phone_no = "0000000000";
			}; 
         
         // Bắn các kiểu của thanh toán để phân biệt khi trả về update CSDL
         if($payment_type == 1){
     	      $request_info->order_id             = "entire".$type_pay."_".$vg_transaction_id; //atm_... or visa_...
            $giamgia = giamgia_40_3ngay($user_id);
            if($giamgia == 1){
               $request_info->total_amount = 150000;
            }
         }else{
            $request_info->order_id             = "retail".$type_pay."_".$vg_transaction_id; // retaiatm_... or retailvisa_...
         }			
			
			// Bắn sang Bảo Kim
			$location                              = 'https://www.baokim.vn';
			$bk                                    = new BKPaymentProService2($location."/services/payment_pro_2/init?wsdl");
			$response_info                         = $bk->DoPaymentPro($request_info);
         
			if($response_info->error_code == 0){
				$url    =   $response_info->url_redirect;
				redirect($url);
			}else{
				var_dump($response_info);
			}
      }
	}
   
	/**
	 * Hàm nạp tiền qua mobile card
	 * 1111111111 : 20 nghìn
	 * 2222222222 : 100 nghìn
	 * $iMethod = 92 hoac 93 hoac 107 
	 */
 	function add_money_mobile_card($user_id, $pin, $serial,$imoney ,$timeact,$type ,$num_pay, $iMethod, $comment = ""){
 		$user_id	=	intval($user_id);
 		$pin		=	replaceMQ($pin);
 		$serial	    =	replaceMQ($serial);
 		$mmca_ip	=	ip2long($_SERVER['REMOTE_ADDR']);
 		$comment	=	replaceMQ($comment);
 		
		
 		if($user_id <= 0){
 			$this->log("add_money_mobile_card.cfn", "UserID<=0");
			return 0;
 		}
 		
 		$db_execute				= new db_execute_return();
		$vg_transaction_id	= $db_execute->db_execute("INSERT INTO money_mobile_card_add(mmca_user_id,mmca_pin,mmca_serial,mmca_ip,mmca_comment,mmca_date,mmca_status,mmca_card)
																	   VALUES(
																		 " . $user_id . "
																		,'" . $pin . "'
																		,'" . $serial . "'
																		," . $mmca_ip . "
																		,'" . $comment . "'
																		," . time() . "
																		,0
																		,". $iMethod . "
																		)", __FILE__ . " Line: " . __LINE__);
		unset($db_execute);
		if($vg_transaction_id <= 0){
			$this->errorMsg .= "&bull; Có lỗi xảy ra khi thực hiện. Bạn hãy liên hệ ban quản trị để nhờ trợ giúp.<br />";
			
		//ngược lại thì bắt đầu bắn sang bảo kim	
		}else{
			$BKTransactionAPI 			= new BKTransactionAPI("https://www.baokim.vn/the-cao/saleCard/wsdl");
			// Call class nạp thẻ qua Bảo Kim
			$info_topup						= new TopupToMerchantRequest();			
			$info_topup->api_password		= $this->baokim_api_password;
			$info_topup->api_username 		= $this->baokim_api_username;
			$info_topup->merchant_id 		= $this->baokim_merchant_id;
			//$info_topup->secure_secret      = $this->baokim_secure_secret;
			$info_topup->pin_field 			= $pin;
			$info_topup->seri_field 		= $serial;
			$info_topup->card_id 			= $iMethod;
			$info_topup->transaction_id 	= $vg_transaction_id . "_mobile_card";			
			// Chuyển $info_topup về dạng array để sort
			$data_sign_array 					= (array)$info_topup;
			//print_r($data_sign_array);
			// Sort lại $data_sign_array theo key
			ksort($data_sign_array);
			// Mã hóa lại $data_sign_array
			$data_sign 							= md5($this->baokim_secure_pass . implode('', $data_sign_array));
			// Gán lại data_sign để gửi sang Bảo Kim
			$info_topup->data_sign 			= $data_sign;
			// Thực hiện kết nối với Bảo Kim
            
			try{
				$response	= $BKTransactionAPI->DoTopupToMerchant($info_topup);
				$this->log("add_money_mobile_card", "User_id: " . $user_id . " Provider card: " . $iMethod . " " . json_encode($response));
				$this->errorMsg .= $response->error_message;
				//print_r($response);
				//var_dump($response);
			}catch(SoapFault $exception){
				$this->errorMsg	.= "&bull; Lỗi kết nối. Bạn hãy thử lại sau.<br />";
				//echo $this->errorMsg;
			}
			
			// Nếu kết nối thành công thì thực hiện ($response->error_code == 0 - Nạp tiền thành công, $response->error_code == 5 - Trường hợp user nhập lại những thẻ chưa được update trong db của vg)
			
			if(isset($response->error_code)){
				if($response->error_code == 0 || $response->error_code == 5){
				    
					$money							= doubleval($response->info_card);
					$mmca_bk_transaction_id		= trim($response->transaction_id);
					$this->mmca_money						= $this->percent_card * $money;
					$mmca_status					= 1;
					$comment							=  'Mã PIN: ' . $pin .
															' - Số Serial: ' . $serial .
															' - Mệnh giá: ' . format_number($money) . ' VNĐ' .
															' - BK transaction: ' . $mmca_bk_transaction_id .
															' - BK Response Code: ' . $response->error_code .
															' - Provider_card: ' . $iMethod;
					// Kiếm tra tiền nạp vào có > 0 hay ko
					if($money <= 0){
						$this->errorMsg	.= "&bull; Mệnh giá thẻ cào bằng 0, giao dịch bị từ chối.<br />";
					}
				    if($money != $imoney){
				        $this->errorMsg	= "&bull; Mệnh giá thẻ cào không đúng " . format_number($imoney) . " VNĐ , giao dịch bị từ chối.<br />";
				    }
					// Kiểm tra xem transaction_id có rỗng không
					if($mmca_bk_transaction_id == "" || $mmca_bk_transaction_id == NULL){
						$this->errorMsg	.= "&bull; Không nhận được mã giao dịch, giao dịch bị từ chối.<br />";
					}
				    if ($this->errorMsg == 'Giao dịch thành công') { $this->errorMsg = ""; }
					// Kiểm tra lần cuối nếu $fs_errorMsg khác rỗng mới thực thi giao dịch
					if($this->errorMsg == ""){
						
						// Check BK transaction_id trả về nếu không có trong db mới cập nhật
						$db_transaction	= new db_query("SELECT mmca_id
																	 FROM money_mobile_card_add
																	 WHERE mmca_bk_transaction_id = '" . replaceMQ($mmca_bk_transaction_id) . "'");
						
                        // Nếu chưa tồn tại transaction thì mới thực hiện
						if(mysql_num_rows($db_transaction->result) == 0){
							
							$db_update	= new db_execute("UPDATE money_mobile_card_add
																	SET mmca_bk_transaction_id = '" . replaceMQ($mmca_bk_transaction_id) . "',
																		 mmca_money = " . $this->mmca_money . ",
																		 mmca_comment = '" . replaceMQ($comment) . "',
																		 mmca_last_update = " . time() . ",
																		 mmca_status = " . $mmca_status . "
																	WHERE mmca_user_id = " . $user_id . " AND mmca_id = " . $vg_transaction_id);
					
							unset($db_update);
							
							//update money vao bảng payment_money
							$insert_money = new db_execute("INSERT INTO payment_user (pau_uid,pau_money,pau_time) VALUES ('$user_id','$money',".time().")", __FILE__ . " Line: " . __LINE__);
                            
                            //kick hoạt tài khoản theo thời gian
							$timesafe = 0;
							$sql_uinvite  =  new db_query("SELECT * FROM user_invite_tree WHERE uit_uid = ".$user_id );
							while($row_uinvite   = mysql_fetch_assoc($sql_uinvite->result)){
								$timesafe = 20;
							}
							unset($sql_uinvite);
                            $sqlActCout   =  new db_query("SELECT * FROM users WHERE use_id = ".$user_id ); 
                            while($rowActCout   = mysql_fetch_assoc($sqlActCout->result)){
                                if($type == "course"){
                                    if($rowActCout['use_status_act'] == 0){
                                        $datestart = time();
                                        $dateend   = time() + ($timeact * 60 *60 *24) + (($timesafe * $timeact / 100) * 60 * 60 * 24);
                                    }else{
                                        $datestart = $rowActCout['use_date_act_start'];
                                        $dateend   = $rowActCout['use_date_act_end'] + ($timeact * 60 *60 *24) + (($timesafe * $timeact / 100) * 60 * 60 * 24);
                                    }
                                        $db_user_update	= new db_execute("UPDATE users
                        												SET use_status_act = 1,
                                                                        use_date_act_start = ". $datestart ." ,
                                                                        use_date_act_end   = ". $dateend ." 
                        												WHERE use_id = " . $user_id );
                                        unset($db_user_update);
                                }elseif($type == "test"){
                                    if ($num_pay == 1){
                                        $this->numm_pay = 1;
                                        	$db_execute				= new db_execute_return();
                                    		$id_money_test          = $db_execute->db_execute("INSERT INTO user_payment_test(use_pt_user_id,use_pt_money)
                                    																	   VALUES(
                                    																		 " . $user_id . "
                                    																		,'100000'
                                    																		)", __FILE__ . " Line: " . __LINE__);
                                    		unset($db_execute);
                                    }elseif($num_pay == 2){
                                        $this->numm_pay = 2;
                                        $db_update	= new db_execute("UPDATE users
                												SET use_test_status = 1
                												WHERE use_id = " . $user_id );
                                        unset($db_update);
                                        $db_del = new db_execute("DELETE FROM user_payment_test WHERE use_pt_user_id =" . $user_id);
                                        unset($db_del);
                                    }
                                    
                                }
                                        
                            }
                            unset($rowActCout);
							
							//bắt đầu cộng tiền vào db tài khoản chính
							return $this->add($user_id, $this->mmca_money, $comment, TYPE_ADD_FROM_MOBILE_CARD, TYPE_MONEY_MAIN);
						
						}// End if(mysql_num_rows($db_transaction->result) == 0)
						else{
							$this->errorMsg	.= "&bull; Mã PIN và số Serial này đã được sử dụng hoặc không hợp lệ. Mã giao dịch bị trùng<br />";
						}
						unset($db_transaction);
						
					}//if($this->errorMsg == "")
					
				} // if($response->error_code == 0 || $response->error_code == 5)
			
			} //if(isset($response->error_code) && $fs_errorMsg == "")
			
		} //if($vg_transaction_id <= 0)
		
 		
 	}
	
   
   function add_money_mobile_card_v2($user_id, $pin, $serial,$imoney ,$timeact,$type ,$num_pay, $iMethod, $comment = "",$pay_type){
 		$user_id	=	intval($user_id);
 		$pin		=	replaceMQ($pin);
 		$serial	    =	replaceMQ($serial);
 		$mmca_ip	=	ip2long($_SERVER['REMOTE_ADDR']);
 		$comment	=	replaceMQ($comment);
 		
		
 		if($user_id <= 0){
 			$this->log("add_money_mobile_card.cfn", "UserID<=0");
			return 0;
 		}
 		
 		$db_execute				= new db_execute_return();
		$vg_transaction_id	= $db_execute->db_execute("INSERT INTO money_mobile_card_add(mmca_user_id,mmca_pin,mmca_serial,mmca_ip,mmca_comment,mmca_date,mmca_status,mmca_card)
																	   VALUES(
																		 " . $user_id . "
																		,'" . $pin . "'
																		,'" . $serial . "'
																		," . $mmca_ip . "
																		,'" . $comment . "'
																		," . time() . "
																		,0
																		,". $iMethod . "
																		)", __FILE__ . " Line: " . __LINE__);
		unset($db_execute);
		if($vg_transaction_id <= 0){
			$this->errorMsg .= "&bull; Có lỗi xảy ra khi thực hiện. Bạn hãy liên hệ ban quản trị để nhờ trợ giúp.<br />";
			
		//ngược lại thì bắt đầu bắn sang bảo kim	
		}else{
			$BKTransactionAPI 			= new BKTransactionAPI("https://www.baokim.vn/the-cao/saleCard/wsdl");
			// Call class nạp thẻ qua Bảo Kim
			$info_topup						= new TopupToMerchantRequest();			
			$info_topup->api_password		= $this->baokim_api_password;
			$info_topup->api_username 		= $this->baokim_api_username;
			$info_topup->merchant_id 		= $this->baokim_merchant_id;
			//$info_topup->secure_secret      = $this->baokim_secure_secret;
			$info_topup->pin_field 			= $pin;
			$info_topup->seri_field 		= $serial;
			$info_topup->card_id 			= $iMethod;
			$info_topup->transaction_id 	= $vg_transaction_id . "_mobile_card";			
			// Chuyển $info_topup về dạng array để sort
			$data_sign_array 					= (array)$info_topup;
			//print_r($data_sign_array);
			// Sort lại $data_sign_array theo key
			ksort($data_sign_array);
			// Mã hóa lại $data_sign_array
			$data_sign 							= md5($this->baokim_secure_pass . implode('', $data_sign_array));
			// Gán lại data_sign để gửi sang Bảo Kim
			$info_topup->data_sign 			= $data_sign;
			// Thực hiện kết nối với Bảo Kim
            
			try{
				$response	= $BKTransactionAPI->DoTopupToMerchant($info_topup);
				$this->log("add_money_mobile_card", "User_id: " . $user_id . " Provider card: " . $iMethod . " " . json_encode($response));
				$this->errorMsg .= $response->error_message;
				//print_r($response);
				//var_dump($response);
			}catch(SoapFault $exception){
				$this->errorMsg	.= "&bull; Lỗi kết nối. Bạn hãy thử lại sau.<br />";
				//echo $this->errorMsg;
			}
			
			// Nếu kết nối thành công thì thực hiện ($response->error_code == 0 - Nạp tiền thành công, $response->error_code == 5 - Trường hợp user nhập lại những thẻ chưa được update trong db của vg)
			
			if(isset($response->error_code)){
				if($response->error_code == 0 || $response->error_code == 5){
				    
					$money							= doubleval($response->info_card);
					$mmca_bk_transaction_id		= trim($response->transaction_id);
					$this->mmca_money						= $this->percent_card * $money;
					$mmca_status					= 1;
					$comment							=  'Mã PIN: ' . $pin .
															' - Số Serial: ' . $serial .
															' - Mệnh giá: ' . format_number($money) . ' VNĐ' .
															' - BK transaction: ' . $mmca_bk_transaction_id .
															' - BK Response Code: ' . $response->error_code .
															' - Provider_card: ' . $iMethod;
					// Kiếm tra tiền nạp vào có > 0 hay ko
					if($money <= 0){
						$this->errorMsg	.= "&bull; Mệnh giá thẻ cào bằng 0, giao dịch bị từ chối.<br />";
					}
				    if($money != $imoney){
				        $this->errorMsg	= "&bull; Mệnh giá thẻ cào không đúng " . format_number($imoney) . " VNĐ , giao dịch bị từ chối.<br />";
				    }
					// Kiểm tra xem transaction_id có rỗng không
					if($mmca_bk_transaction_id == "" || $mmca_bk_transaction_id == NULL){
						$this->errorMsg	.= "&bull; Không nhận được mã giao dịch, giao dịch bị từ chối.<br />";
					}
				    if ($this->errorMsg == 'Giao dịch thành công') { $this->errorMsg = ""; }
					// Kiểm tra lần cuối nếu $fs_errorMsg khác rỗng mới thực thi giao dịch
					if($this->errorMsg == ""){
						
						// Check BK transaction_id trả về nếu không có trong db mới cập nhật
						$db_transaction	= new db_query("SELECT mmca_id
																	 FROM money_mobile_card_add
																	 WHERE mmca_bk_transaction_id = '" . replaceMQ($mmca_bk_transaction_id) . "'");
						
                        // Nếu chưa tồn tại transaction thì mới thực hiện
						if(mysql_num_rows($db_transaction->result) == 0){
							
							$db_update	= new db_execute("UPDATE money_mobile_card_add
																	SET mmca_bk_transaction_id = '" . replaceMQ($mmca_bk_transaction_id) . "',
																		 mmca_money = " . $this->mmca_money . ",
																		 mmca_comment = '" . replaceMQ($comment) . "',
																		 mmca_last_update = " . time() . ",
																		 mmca_status = " . $mmca_status . "
																	WHERE mmca_user_id = " . $user_id . " AND mmca_id = " . $vg_transaction_id);
					
							unset($db_update);
							
							//update money vao bảng payment_money
							$insert_money = new db_execute("INSERT INTO payment_user (pau_uid,pau_money,pau_time) VALUES ('$user_id','$money',".time().")", __FILE__ . " Line: " . __LINE__);
                            
                            //kick hoạt tài khoản theo thời gian
							$timesafe = 0;
							$sql_uinvite  =  new db_query("SELECT * FROM user_invite_tree WHERE uit_uid = ".$user_id );
							while($row_uinvite   = mysql_fetch_assoc($sql_uinvite->result)){
								$timesafe = 20;
							}
							unset($sql_uinvite);
                            $sqlActCout   =  new db_query("SELECT * FROM users WHERE use_id = ".$user_id ); 
                            while($rowActCout   = mysql_fetch_assoc($sqlActCout->result)){
                                if($type == "course"){
                                    //action here
                                    if($pay_type == 1){
                                       add_package_full($user_id);
                                    }else{
                                       add_user_money($user_id,1,$imoney);
                                    }
                                }       
                            }
                            unset($rowActCout);
							//bắt đầu cộng tiền vào db tài khoản chính
							return $this->add($user_id, $this->mmca_money, $comment, TYPE_ADD_FROM_MOBILE_CARD, TYPE_MONEY_MAIN);
						
						}// End if(mysql_num_rows($db_transaction->result) == 0)
						else{
							$this->errorMsg	.= "&bull; Mã PIN và số Serial này đã được sử dụng hoặc không hợp lệ. Mã giao dịch bị trùng<br />";
						}
						unset($db_transaction);
						
					}//if($this->errorMsg == "")
					
				} // if($response->error_code == 0 || $response->error_code == 5)
			
			} //if(isset($response->error_code) && $fs_errorMsg == "")
			
		} //if($vg_transaction_id <= 0)
		
 		
 	}
   
   
	
	/**
	 * Ham nạp tiền qua tài khoản bảo kim
	 * User đăng nhập
	 * Nhập mail
	 * Chuyển thông tin sang baokim
	 * Baokim check trả về OTP
	 */
 	function add_money_baokim_request($user_id, $use_money, $use_mail, $phone, $type){
 		$use_id		=	intval($user_id);
 		$use_money 	=	intval($use_money);
 		$use_mail	=	$use_mail;
 		$use_time	=	time(); 		
 		$bk                  = new BKPaymentProService2($this->baokim_request_url);
 		//check user đăng nhập chưa
 		if($user_id <= 0 || $use_money < 0){
 			$this->log("add_money_baokim.cfn", "UserID<=0");
			return 1;
 		}
 		
 		//lưu thông tin trước khi truyền tham số đi
 		$db_bk	=	new db_execute_return();
 		$bk_id	=	$db_bk->db_execute("INSERT INTO money_baokim(mbk_time,mbk_user_id,mbk_money,mbk_otp,mbk_mail,mbk_description,mbk_error,mbk_phone)
		 											VALUES(". $use_time .",".
													 $use_id . ",".
													 $use_money .",'',".
													 "'". $use_mail . "','".
													 "Nạp tiền vào hochay.vn" . "','',". $phone .")");
		 unset($db_bk);
		 if($bk_id < 0){
		 	$this->errorMsg .= "&bull; Có lỗi xảy ra khi thực hiện. Bạn hãy liên hệ ban quản trị để nhờ trợ giúp.<br />";
		 	return 1;
		 }else{
		 	//gọi class bao kim
		 	$motphim_request = new PayWithBaokimAccountRequest();
	    	$motphim_request->merchant_id = $this->baokim_merchant_id;
			$motphim_request->api_username = $this->baokim_api_username;
			$motphim_request->api_password = $this->baokim_api_password;
			//$motphim_request->secure_secret  = $this->baokim_secure_secret;
			$motphim_request->baokim_seller_account_email = $this->baokim_user_email;
			$motphim_request->baokim_buyer_account_email = $use_mail;
			$motphim_request->total_amount = $use_money;
			$motphim_request->currency_code = 'VND';
			$motphim_request->payment_mode = 1;
			$motphim_request->escrow_timeout = 3;
			$motphim_request->tax_fee 		= '';
			$motphim_request->shipping_fee 	= '';
			
			$motphim_request->affiliate_id = '';
			$motphim_request->affiliate_site_id = '';
			$motphim_request->business_line_id = '';
		 	
		 	//gọi hàm order
		 	$order_info = new OrderInfo();
			$order_info->order_id = $bk_id . "_hh_";
			$order_info->order_description = 'Nạp tài khoản hochay';
			$order_info->order_amount = $use_money;
			$order_info->order_url_detail = '';
			$motphim_request->order_info = $order_info;
			
			
			$payer_info = new PayerInfo();
			$payer_info->payer_name = "Tai khoan hochay";
			$payer_info->payer_email = $use_mail;
			$payer_info->payer_phone_no = $phone;
			$payer_info->payer_message = "Nạp gỗ vào tài khoản trên trang hochay.vn";
			$motphim_request->payer_info = $payer_info;
			
			$response = $bk->DoPayWithBaokimAccount($motphim_request);
			$this->errorMsg .= $response->response_message;
			$this->log("add_money_baokim.cfn", "REQUEST: User_id: " . $user_id . " User Phone: ". $phone ." Use_mail: " . $use_mail . " Money: " . $use_money . " " . json_encode($response));
			
			//cuối cùng kiểm tra reposne_code=0 thì update transaction_id
			if($response->response_code == 0){
				$db_ex	=	new db_execute("UPDATE money_baokim SET mbk_transaction_id='". $response->transaction_id . "' WHERE mbk_id=". $bk_id);
				unset($db_ex);
			}
			return $response;
		 }
 	}
 	
 	/** 
	 * User nhập OTP gửi tiếp về bảo kim
	 * Baokim trả về thành công hoăc không thành công
	 */
 	function add_money_baokim_otp($use_id, $bk_otp,$timeact,$type, $bk_transaction){
 		$bk                  = new BKPaymentProService2($this->baokim_request_url);
 		$user_id	=	intval($use_id);
 		if($user_id < 0){
 			return 1;
 		}
 		$transaction_id = $bk_transaction;
		$sms_otp		= $bk_otp;
		//lấy mail
		$db_buymail	=	new db_query("SELECT mbk_mail FROM money_baokim WHERE mbk_transaction_id='". $transaction_id ."'");
		//nếu có thì gửi đi
		if($row = mysql_fetch_assoc($db_buymail->result)){
			$baokim_buyer_account_email = $row['mbk_mail'];
			$verifyOTP = new VerifyTransactionOTPRequest();
	    	$verifyOTP->api_password   = $this->baokim_api_password;
	    	$verifyOTP->api_username   = $this->baokim_api_username;
			//$verifyOTP->secure_secret  = $this->baokim_secure_secret;
	    	$verifyOTP->baokim_buyer_account_email = $baokim_buyer_account_email;
	    	$verifyOTP->merchant_id = $this->baokim_merchant_id;
	    	$verifyOTP->transaction_id = $transaction_id;
	    	$verifyOTP->sms_otp = $sms_otp;
	    	//var_dump($verifyOTP);
	    	//echo '<br />';
	    	$responseOTP = new VerifyTransactionOTPResponse();
	    	$responseOTP = $bk->DoVerifyTransactionOTP($verifyOTP);
	    	//ghi log
	    	$this->log("add_money_baokim.cfn", "REQUEST OTP: Transaction_id: " . $bk_transaction . " " . json_encode($responseOTP));
	    	//check nếu không có lõi thì update thông tin nap tiền
	    	if($responseOTP->response_code == 0){
	    		/**
	    		 * Check nếu tồn tại user và transaction_id
	  			 * update trạng thái bảng money_naokim
	    		 * 
	    		 */
	    		$db_check	=	new db_query("SELECT * FROM money_baokim 
				 										WHERE mbk_user_id =". $user_id . " AND mbk_transaction_id='" . $transaction_id . "'");
				if($row_check = mysql_fetch_assoc($db_check->result)){
					//update trạng thái thành công
					$db_ex	=	new db_execute("UPDATE money_baokim SET mbk_status=1 WHERE mbk_transaction_id='". replaceMQ($bk_transaction) . "'");
	    			
                    //kick hoạt tài khoản theo thời gian
                    $sqlActCout  =  new db_query("SELECT * FROM users WHERE use_id = ".$user_id ); 
                    while($rowActCout   = mysql_fetch_assoc($sqlActCout->result)){
                        if($type == "course"){
                            if($rowActCout['use_status_act'] == 0){
                                $datestart = time();
                                $dateend   = time() + ($timeact * 60 *60 *24);
                            }else{
                                $datestart = $rowActCout['use_date_act_start'];
                                $dateend   = $rowActCout['use_date_act_end'] + ($timeact * 60 *60 *24);
                            }
                                $db_update	= new db_execute("UPDATE users
                												SET use_status_act = 1,
                                                                use_date_act_start = ". $datestart ." ,
                                                                use_date_act_end   = ". $dateend ." 
                												WHERE use_id = " . $user_id );
                                unset($db_update);
                                
                        }elseif($type == "test"){
                            $db_update	= new db_execute("UPDATE users
                												SET use_test_status = 1
                												WHERE use_id = " . $user_id );
                            unset($db_update);
                        }
                    }
                    unset($rowActCout);
                    
                    //check nếu chưa nạp tiền thì insert ngược lại thì update
	    			$db_checkuser	=	new db_query("SELECT * 
					 											FROM money_users 
																WHERE mou_user_id=". $user_id);
					if($row_use	=	mysql_fetch_assoc($db_checkuser->result)){
						$db_money	=	new db_execute("UPDATE money_users SET mou_money = mou_money  + ". $row_check['mbk_money'] . " 
						 											WHERE mou_user_id=". $user_id);
					}else{
						//inssert vao bang
						//bắt đầu cộng tiền vào db tài khoản chính
						return $this->add($user_id, $row_check['mbk_money'] , "Nạp tiền qua tài khoản bảo kim", TYPE_ADD_BAOKIM, TYPE_MONEY_MAIN);						
					}
					unset($db_checkuser,$db_ex, $db_money);
				}
	    		unset($db_check);
	    	}else{
	    		$this->errorMsg .= $responseOTP->response_message;
	    	}
	    	return $responseOTP;
		}else{
			return 1;
		}
 	}
	/**
	 * Hàm tiêu tiền
	 */
 	function spent($user_id, $money = 0, $comment = '', $type_spent = TYPE_SPENT_ONE_MOVIE,$type_money = TYPE_MONEY_MAIN){
 		$status	=	0;
 		$money_promotion	=	0;

 		$last_id	=	$this->insert_money_spent(array(
 														  "user_id"			=> $user_id
 														  ,"money"			=>	$money
 														  ,"comment"		=> $comment
 														  ,"type_spent"	=>	$type_spent
 														  ,"type_money"	=>	$type_money
		 												  ));
		//nếu là tài khoản khuyến mại thì
 		if($type_money ==  TYPE_MONEY_PROMOTION){
 			$money_promotion	=	$money;
 			$money				=	0;
 		}		 												  
	  //nếu khác 0 thì tiếp tục cập nhật trừ tiền
		if($last_id > 0){
			//bắt đầu trừ tiền
			$status	=	$this->update_money_users($user_id
																, array(
																			"user_id"				=>	$user_id
																			,"money"					=>	$money
																			,"money_promotion"	=>	$money_promotion
																			)
																, TYPE_UPDATE_MONEY_SPENT
																);
			//nếu trường hợp update không thành công thì xóa spent đi
			if($status == 0){
				$db_ex =	new db_execute("DELETE FROM money_spent_all WHERE mos_id = " . $last_id, __FILE__ . " Line: " . __LINE__);
				unset($db_ex);
			}
		}
		
		if($status != 0){
			return 1;
		}else{
			return 0;
		}
			 												  
 	}
 	
 	
 	/**
	 * Hàm nạp tiền
	 */
 	function add($user_id, $money = 0, $comment = '', $type_add = TYPE_ADD_FROM_VATGIA,$type_money = TYPE_MONEY_MAIN){
 		$status	=	0;
 		$money_promotion	=	0;
 		//nếu là tài khoản khuyến mại thì
 		$last_id	=	$this->insert_money_add(array(
 														  "user_id"			=> $user_id
 														  ,"money"			=>	$money
 														  ,"comment"		=> $comment
 														  ,"type_add"		=>	$type_add
 														  ,"type_money"	=>	$type_money
		 												  ));
		if($type_money ==  TYPE_MONEY_PROMOTION){
 			$money_promotion	=	$money;
 			$money				=	0;
 		}		 												  
	  //nếu khác 0 thì tiếp tục cập nhật trừ tiền
		if($last_id > 0){
			//bắt đầu trừ tiền
			$status	=	$this->update_money_users($user_id
																, array(
																			"user_id"				=>	$user_id
																			,"money"					=>	$money
																			,"money_promotion"	=>	$money_promotion
																			)
																, TYPE_UPDATE_MONEY_ADD
																);
			//nếu trường hợp update không thành công thì xóa spent đi
			if($status == 0){
				$db_ex =	new db_execute("DELETE FROM money_add_all WHERE moa_id = " . $last_id, __FILE__ . " Line: " . __LINE__);
				unset($db_ex);
			}
		}
		
		if($status != 0){
			return 1;
		}else{
			return 0;
		}
			 												  
 	}
	
	/**
	 * Hàm cộng vào bảng tiền tổng
	 * default : tien chinh và cộng tiền
	 */
 	protected function update_money_users($user_id = 0, $array_value = array(), $type_update = TYPE_UPDATE_MONEY_ADD){
 		$user_id	=	intval($user_id);
 		if($user_id < 0) $user_id = 0;
 		$mou_user_id				=	isset($array_value["user_id"]) ? intval($array_value["user_id"]) : 0;
		$mou_money					=	isset($array_value["money"]) ? doubleval($array_value["money"]) : 0;
		$mou_money_promotion		=	isset($array_value["money_promotion"]) ? doubleval($array_value["money_promotion"]) : 0;
		$mou_hash					=	"";
		
		//nếu user _id = 0 thì ghi log và return luôn
		if($user_id == 0){
			$this->log("add_money_users.cfn", json_encode($array_value));
			return 0;
		}
		
		//nếu trường hợp tiền âm
		if($mou_money <= 0 && $mou_money_promotion <= 0){
			$this->log("add_money_users.cfn", json_encode($array_value));
			return 0;
		}
		
		//nếu tiền khuyến mại là số âm thì gán bằng 0
		if($mou_money_promotion < 0) $mou_money_promotion = 0;
		
		if($type_update == TYPE_UPDATE_MONEY_ADD){
	 		$mou_quantity_add			=	1;
	 		$mou_quantity_spent		=	0;
	 		
 		}else{
	 		$mou_quantity_add			=	0;
	 		$mou_quantity_spent		=	1;
	 		$mou_money_promotion		=	0 - $mou_money_promotion;
	 		$mou_money					=	0 - $mou_money;
	 	}
		
		//select từ bảng lưu tiền ra xem đã tồn tại record id chưa
 		$db_select	=	new db_query("SELECT *
											  FROM money_users
											  WHERE mou_user_id = " . $user_id
		 									 , __FILE__ . " Line: " . __LINE__);
		 //nếu đã tồn tại tài khoản thì update
		 if($row = mysql_fetch_assoc($db_select->result)){
		 	//nếu là cộng tiền thì
		 	if($type_update == TYPE_UPDATE_MONEY_ADD){
		 		$mou_quantity_add			=	intval($row["mou_quantity_add"]) + 1;
		 		$mou_quantity_spent		=	intval($row["mou_quantity_spent"]);

	 		}else{
		 		$mou_quantity_add			=	intval($row["mou_quantity_add"]);
		 		$mou_quantity_spent		=	intval($row["mou_quantity_spent"]) + 1;

		 	}
		 	$mou_money					=	doubleval($row["mou_money"]) + $mou_money;
		 	$mou_money_promotion		=	doubleval($row["mou_money_promotion"]) + $mou_money_promotion;
		 	//bắt đầu update vào db
		 	$db_ex	=	new db_execute("UPDATE money_users
												SET 
												mou_money = " . $mou_money . "
												,mou_money_promotion = " . $mou_money_promotion . "
												,mou_quantity_add = " . $mou_quantity_add . "
												,mou_quantity_spent = " . $mou_quantity_spent . "
												,mou_hash = '" . $this->hash_money(array($user_id,$mou_money,$mou_money_promotion,$mou_quantity_add,$mou_quantity_spent)) . "'
												WHERE
												mou_user_id = " . $user_id
			 									, __FILE__ . " Line: " . __LINE__);
			if($db_ex->total > 0){
				return 1;
			}else{
				$this->log("add_money_users.cfn", "Update Error: " . json_encode($array_value));
				return 0;
			}
		 
		 //ngược lại thì thêm mới vào	
		 }else{
		 	
		 	//nếu là tiêu tiền thì return không thành công
		 	if($type_update == TYPE_UPDATE_MONEY_SPENT){
		 		$this->log("add_money_users.cfn", "Update Error: " . json_encode($array_value));
				return 0;
		 	}//end if
		 	
		 	//bắt đầu insert vào db
		 	$db_ex	=	new db_execute("INSERT IGNORE INTO money_users(mou_user_id,mou_money,mou_money_promotion,mou_quantity_add,mou_quantity_spent,mou_hash)
			 									 VALUES
			 									 (
			 									 " . $user_id . "
			 									 ," . $mou_money . "
			 									 ," . $mou_money_promotion . "
			 									 ," . $mou_quantity_add . "
			 									 ," . $mou_quantity_spent . "
			 									 ,'" . $this->hash_money(array($user_id,$mou_money,$mou_money_promotion,1,1)) . "'
			 									 )
		  										 "
												 , __FILE__ . " Line: " . __LINE__);
		 	if($db_ex->total > 0){
				return 1;
			}else{
				$this->log("add_money_users.cfn", "Insert Error: " . json_encode($array_value));
				return 0;
			}
		 	
		 }//if($row = mysql_fetch_assoc($db_select->result))
 	}
 	
 	/**
 	 * Hàm insert nạp tiền
 	 */
 	protected function insert_money_add($array){
 		$user_id						=	isset($array["user_id"]) ? intval($array["user_id"]) : 0;
 		$moa_money					=	isset($array["money"]) ? doubleval($array["money"]) : 0;
 		$moa_ip						=	ip2long($_SERVER["REMOTE_ADDR"]);
 		$moa_comment				=	isset($array["comment"]) ? strval($array["comment"]) : "";
 		$moa_comment				=	replaceMQ($moa_comment);
 		$moa_type_add				=	isset($array["type_add"]) ? intval($array["type_add"]) : 0;
 		$moa_type_money			=	isset($array["type_money"]) ? intval($array["type_money"]) : 0;
 		$moa_hash					=	$this->hash_money($array);

 		$db_ex	=	new db_execute_return();
 		$last_id	=	$db_ex->db_execute("INSERT IGNORE INTO money_add_all(moa_user_id,moa_money,moa_ip,moa_comment,moa_time,moa_hash,moa_type_add,moa_type_money)
				 									 VALUES
				 									 (
				 									 " . $user_id . "
				 									 ," . $moa_money . "
				 									 ," . $moa_ip . "
				 									 ,'" . $moa_comment . "'
				 									 ," . time() . "
				 									 ,'" . $this->hash_money(array($user_id,$moa_money,$moa_ip,$moa_comment,$moa_type_add,$moa_type_money)) . "'
				 									 ," . $moa_type_add . "
				 									 ," . $moa_type_money . "
				 									 )
			  										 "
													 , __FILE__ . " Line: " . __LINE__);
		 	if($last_id > 0){
				return $last_id;
			}else{
				$this->log("insert_money_add.cfn", "Insert Error: " . json_encode($array));
				return 0;
			}
 	}
 	/**
 	 * Hàm insert tieu tiền
 	 */
 	protected function insert_money_spent($array){
 		$user_id						=	isset($array["user_id"]) ? intval($array["user_id"]) : 0;
 		$mos_money					=	isset($array["money"]) ? doubleval($array["money"]) : 0;
 		$mos_ip						=	ip2long($_SERVER["REMOTE_ADDR"]);
 		$mos_comment				=	isset($array["comment"]) ? strval($array["comment"]) : "";
 		$mos_comment				=	replaceMQ($mos_comment);
 		$mos_type_spent			=	isset($array["type_spent"]) ? intval($array["type_spent"]) : 0;
 		$mos_type_money			=	isset($array["type_money"]) ? intval($array["type_money"]) : 0;
 		$mos_hash					=	$this->hash_money($array);
 		$db_ex	=	new db_execute_return();
 		$last_id	=	$db_ex->db_execute("INSERT IGNORE INTO money_spent_all(mos_user_id,mos_money,mos_ip,mos_comment,mos_time,mos_hash,mos_type_spent,mos_type_money)
				 									 VALUES
				 									 (
				 									 " . $user_id . "
				 									 ," . $mos_money . "
				 									 ," . $mos_ip . "
				 									 ,'" . $mos_comment . "'
				 									 ," . time() . "
				 									 ,'" . $this->hash_money(array($user_id,$mos_money,$mos_ip,$mos_comment,$mos_type_spent,$mos_type_money)) . "'
				 									 ," . $mos_type_spent . "
				 									 ," . $mos_type_money . "
				 									 )
			  										 "
													 , __FILE__ . " Line: " . __LINE__);
		 	if($last_id > 0){
				return $last_id;
			}else{
				$this->log("insert_money_spent.cfn", "Insert Error: " . json_encode($array));
				return 0;
			}
 	}	
 	
 	 	
 	/**
 	 * Hàm mã hóa dữ liệu mỗi lần update hoặc insert
 	 */
 	protected function hash_money($array){
 		return md5($this->password_sercurity . "|" . json_encode($array));
 	}
	
	function get_real_money_added(){
 		return $this->mmca_money;
 	}
	
	function log($filename, $content){
		
		$handle       =   @fopen($this->path_log . $filename, "a");
		//Neu handle chua co mo thêm ../
		if (!$handle) $handle = @fopen($filename, "a");
		//Neu ko mo dc lan 2 thi exit luon
		if (!$handle) exit();		
		@fwrite($handle, date("d/m/Y h:i:s A") . " " . $content . " " . @$_SERVER["REQUEST_URI"] . "\n");	
		@fclose($handle); 	
			
	}
}

?>