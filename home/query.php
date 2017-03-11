<?php
require_once('config.php');
//   MHN00000
//$codeClass = 'MHN';
//$num4 = '0000';
//$num3 = '000';
//$num2 = '00';
//$num1 = '0';

//$code = '';
/*for($i = 1;$i<=5000;$i++){
	if($i < 10){
		$code = $codeClass.$num4.$i;
	}elseif($i >= 10 && $i < 100){
		$code = $codeClass.$num3.$i;
	}elseif($i >= 100 && $i < 999){
		$code = $codeClass.$num2.$i;
	}elseif($i >= 1000 && $i <= 5000){
		$code = $codeClass.$num1.$i;
	}
	
	//echo $code;

	//$dbSelect = new db_query('SELECT * FROM user_university WHERE user_uni_code_student LIKE "'.$code.'"');
	//$arrCode    =   $dbSelect->resultArray();
	//$countArrCode = count($arrCode);
	//if($countArrCode <= 0){
		//$sql = "INSERT INTO `user_university` (`user_uni_id`, `user_uni_code_student`, `user_uni_code_school`) VALUES (NULL, '$code', 'MHN');";
	    //$db_insert = new db_execute($sql);
	    //unset($db_insert);
	//}else{
		//echo 'Đã tồn tại';
	//}
}*/

	/*$strCode ="";
	$strSeri ="";
	$chars = "123456789";
	$size = strlen($chars);
	for($j = 1;$j <= 3334;$j++){
		for($i = 1;$i <=16;$i++){
			$strCode .= $chars[ rand( 0, $size - 1 ) ];
 		}
 		for($i = 1;$i <=10;$i++){
			$strSeri .= $chars[ rand( 0, $size - 1 ) ];
 		}
 		$code = $strCode;
 		$seri = $strSeri;
 		$strCode = "";
 		$strSeri = "";
 		//echo "stt: ".$j."----code:".$code." ---- seri:".$seri."</br>";

 		$dbSelect = new db_query('SELECT * FROm scratch_cards WHERE sc_code LIKE "'.$code.'" OR sc_seri LIKE "'.$seri.'"');
 		$arrCountData = $dbSelect->resultArray();
 		if(count($arrCountData) < 1){
 			$sql = "INSERT INTO `scratch_cards` (`sc_id`, `sc_code`, `sc_seri`, `sc_value`) VALUES (NULL, '$code', '$seri', '100000');";
		    $db_insert = new db_execute($sql);
		    unset($db_insert);
		    echo "stt: ".$j."----code:".$code." ---- seri:".$seri."</br>";
 		}else{
 			echo 'ERROR !! BỊ TRÙNG </br>';
 		}

 		
 	}*/

?>