<?
function base64_url_encode($input){
	return strtr(base64_encode($input), '+/=', '_,-');
}
function base64_url_decode($input) {
	return base64_decode(strtr($input, '_,-', '+/='));
}

function get_day(){
   $array_value = array( 1 => "01", 2  => "02", 3  => "03", 4  => "04", 5  => "05", 6  => "06", 7  => "07", 8  => "08", 9  => "09", 10 => "10",
                        11 => "11", 12 => "12", 13 => "13", 14 => "14", 15 => "15", 16 => "16", 17 => "17", 18 => "18", 19 => "19", 20 => "20",
                        21 => "21", 22 => "22", 23 => "23", 24 => "24", 25 => "25", 26 => "26", 27 => "27", 28 => "28", 29 => "29", 30 => "30", 31 => "31" );
   return $array_value;
}

function get_month(){
   $array_value = array( 1 => "01",  2 => "02",  3 => "03",  4 => "04",  5 => "05",  6 => "06",
                         7 => "07",  8 => "08",  9 => "09",  10 => "10",11 => "11", 12 => "12");
   return $array_value;
}

function get_year(){
   $array_value =  array(1950 => "1950",  1951 => "1951",  1952 => "1952",  1953 => "1953",  1954 => "1954",  1955 => "1955",  1956 => "1956",  1957 => "1957",  1958 => "1958",   1959 => "1959",
                         1960 => "1960",  1961 => "1961",  1962 => "1962",  1963 => "1963",  1964 => "1964",  1965 => "1965",  1966 => "1966",  1967 => "1967",  1968 => "1968",   1969 => "1969",
                         1970 => "1970",  1971 => "1971",  1972 => "1972",  1973 => "1973",  1974 => "1974",  1975 => "1975",  1976 => "1976",  1977 => "1977",  1978 => "1978",   1979 => "1979",
                         1980 => "1980",  1981 => "1981",  1982 => "1982",  1983 => "1983",  1984 => "1984",  1985 => "1985",  1986 => "1986",  1987 => "1987",  1988 => "1988",   1989 => "1989",
                         1990 => "1990",  1991 => "1991",  1992 => "1992",  1993 => "1993",  1994 => "1994",  1995 => "1995",  1996 => "1996",  1997 => "1997",  1998 => "1998",   1999 => "1999",
                         2000 => "2000",  2001 => "2001",  2002 => "2002",  2003 => "2003",  2004 => "2004",  2005 => "2005",  2006 => "2006",  2007 => "2007",  2008 => "2008",   2009 => "2009",
                         2010 => "2010",  2011 => "2011",  2012 => "2012",  2014 => "2014",  2015 => "2015");
   return $array_value;
}

function array_language(){
	$db_language	= new db_query("SELECT * FROM languages ORDER BY lang_id ASC");
	$arrReturn		= array();
	while($row = mysqli_fetch_array($db_language->result)){
		$arrReturn[$row["lang_id"]] = array($row["lang_code"], $row["lang_name"]);
	}
	return $arrReturn;
}

function check_email_address($email) {
	//First, we check that there's one @ symbol, and that the lengths are right
	if(!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)){
		//Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	//Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for($i = 0; $i < sizeof($local_array); $i++){
		if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])){
			return false;
		}
	}
	if(!ereg("^\[?[0-9\.]+\]?$", $email_array[1])){
	//Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if(sizeof($domain_array) < 2){
			return false; // Not enough parts to domain
		}
		for($i = 0; $i < sizeof($domain_array); $i++){
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])){
				return false;
			}
		}
	}
	return true;
}

function cut_string($str, $length, $char=" ..."){
	//Nếu chuỗi cần cắt nhỏ hơn $length thì return luôn
	$strlen	= mb_strlen($str, "UTF-8");
	if($strlen <= $length) return $str;

	//Cắt chiều dài chuỗi $str tới đoạn cần lấy
	$substr	= mb_substr($str, 0, $length, "UTF-8");
	if(mb_substr($str, $length, 1, "UTF-8") == " ") return $substr . $char;

	//Xác định dấu " " cuối cùng trong chuỗi $substr vừa cắt
	$strPoint= mb_strrpos($substr, " ", "UTF-8");

	//Return string
	if($strPoint < $length - 20) return $substr . $char;
	else return mb_substr($substr, 0, $strPoint, "UTF-8") . $char;
}

function format_number($number, $edit=0){
	if($edit == 0){
		$return	= number_format($number, 2, ".", ",");
		if(intval(substr($return, -2, 2)) == 0) $return = number_format($number, 0, ".", ",");
		elseif(intval(substr($return, -1, 1)) == 0) $return = number_format($number, 1, ".", ",");
		return $return;
	}
	else{
		$return	= number_format($number, 2, ".", "");
		if(intval(substr($return, -2, 2)) == 0) $return = number_format($number, 0, ".", "");
		return $return;
	}
}

function format_currency($value = ""){
	$str		=	$value;
	if($value != ""){
		$str		=	number_format(round($value/1000)*1000,0,"",",");
	}
	return $str;
}

function generate_array_variable($variable){
	$list			= tdt($variable);
	$arrTemp		= explode("{-break-}", $list);
	$arrReturn	= array();
	for($i=0; $i<count($arrTemp); $i++) $arrReturn[$i] = trim($arrTemp[$i]);
	return $arrReturn;
}

function generate_security_code(){
	$code	= rand(1000, 9999);
	return $code;
}

function getURL($serverName=0, $scriptName=0, $fileName=1, $queryString=1, $varDenied=''){
	$url	 = '';
	$slash = '/';
	if($scriptName != 0)$slash	= "";
	if($serverName != 0){
		if(isset($_SERVER['SERVER_NAME'])){
			$url .= 'http://' . $_SERVER['SERVER_NAME'];
			if(isset($_SERVER['SERVER_PORT'])) $url .= ":" . $_SERVER['SERVER_PORT'];
			$url .= $slash;
		}
	}
	if($scriptName != 0){
		if(isset($_SERVER['SCRIPT_NAME']))	$url .= substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
	}
	if($fileName	!= 0){
		if(isset($_SERVER['SCRIPT_NAME']))	$url .= substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
	}
	if($queryString!= 0){
		$url .= '?';
		reset($_GET);
		$i = 0;
		if($varDenied != ''){
			$arrVarDenied = explode('|', $varDenied);
			while(list($k, $v) = each($_GET)){
				if(array_search($k, $arrVarDenied) === false){
					$i++;
					if($i > 1) $url .= '&' . $k . '=' . @urlencode($v);
					else $url .= $k . '=' . @urlencode($v);
				}
			}
		}
		else{
			while(list($k, $v) = each($_GET)){
				$i++;
				if($i > 1) $url .= '&' . $k . '=' . @urlencode($v);
				else $url .= $k . '=' . @urlencode($v);
			}
		}
	}
	$url = str_replace('"', '&quot;', strval($url));
	return $url;
}

function getValue($value_name, $data_type = "int", $method = "GET", $default_value = 0, $advance = 0){
	$value = $default_value;
	switch($method){
		case "GET": if(isset($_GET[$value_name])) $value = $_GET[$value_name]; break;
		case "POST": if(isset($_POST[$value_name])) $value = $_POST[$value_name]; break;
		case "COOKIE": if(isset($_COOKIE[$value_name])) $value = $_COOKIE[$value_name]; break;
		case "SESSION": if(isset($_SESSION[$value_name])) $value = $_SESSION[$value_name]; break;
		default: if(isset($_GET[$value_name])) $value = $_GET[$value_name]; break;
	}
	$valueArray	= array("int" => intval($value), "str" => trim(strval($value)), "flo" => floatval($value), "dbl" => doubleval($value), "arr" => $value);
	foreach($valueArray as $key => $returnValue){
		if($data_type == $key){
			if($advance != 0){
				switch($advance){
					case 1:
						$returnValue = replaceMQ($returnValue);
						break;
					case 2:
						$returnValue = htmlspecialbo($returnValue);
						break;
				}
			}
			//Do số quá lớn nên phải kiểm tra trước khi trả về giá trị
			if((strval($returnValue) == "INF") && ($data_type != "str")) return 0;
			return $returnValue;
			break;
		}
	}
	return (intval($value));
}

function get_server_name(){
	$server = $_SERVER['SERVER_NAME'];
	if(strpos($server, "asiaqueentour.com") !== false) return "http://www.asiaqueentour.com";
	else return "http://" . $server . ":" . $_SERVER['SERVER_PORT'];
}

function htmlspecialbo($str){
	$arrDenied	= array('<', '>', '\"', '"');
	$arrReplace	= array('&lt;', '&gt;', '&quot;', '&quot;');
	$str = str_replace($arrDenied, $arrReplace, $str);
	return $str;
}

function lang_path(){
	global $lang_id;
	global $array_lang;
	global $con_root_path;
	$default_lang = 1;
	$path	= ($lang_id == $default_lang) ? $con_root_path : $con_root_path . $array_lang[$lang_id][0] . "/";
	return $path;
}

function random(){
	$rand_value = "";
	$rand_value.= rand(1000,9999);
	$rand_value.= chr(rand(65,90));
	$rand_value.= rand(1000,9999);
	$rand_value.= chr(rand(97,122));
	$rand_value.= rand(1000,9999);
	$rand_value.= chr(rand(97,122));
	$rand_value.= rand(1000,9999);
	return $rand_value;
}

function redirect($url){
	$url	= htmlspecialbo($url);
	echo '<script type="text/javascript">window.location.href = "' . $url . '";</script>';
	exit();
}

function removeAccent($mystring){
	$marTViet=array(
		// Chữ thường
		"à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
		"è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
		"ì","í","ị","ỉ","ĩ",
		"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
		"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
		"ỳ","ý","ỵ","ỷ","ỹ",
		"đ","Đ","'",
		// Chữ hoa
		"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
		"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
		"Ì","Í","Ị","Ỉ","Ĩ",
		"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
		"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
		"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
		"Đ","Đ","'"
		);
	$marKoDau=array(
		/// Chữ thường
		"a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a",
		"e","e","e","e","e","e","e","e","e","e","e",
		"i","i","i","i","i",
		"o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
		"u","u","u","u","u","u","u","u","u","u","u",
		"y","y","y","y","y",
		"d","D","",
		//Chữ hoa
		"A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A",
		"E","E","E","E","E","E","E","E","E","E","E",
		"I","I","I","I","I",
		"O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
		"U","U","U","U","U","U","U","U","U","U","U",
		"Y","Y","Y","Y","Y",
		"D","D","",
		);
	return str_replace($marTViet, $marKoDau, $mystring);
}

function removeHTML($string){
	$string = preg_replace ('/<script.*?\>.*?<\/script>/si', ' ', $string);
	$string = preg_replace ('/<style.*?\>.*?<\/style>/si', ' ', $string);
	$string = preg_replace ('/<.*?\>/si', ' ', $string);
	$string = str_replace ('&nbsp;', ' ', $string);
    $string = str_replace ('&amp;', '&', $string);
	$string = mb_convert_encoding($string, "UTF-8", "UTF-8");
	$string = str_replace (array(chr(9),chr(10),chr(13)), ' ', $string);
	for($i = 0; $i <= 5; $i++) $string = str_replace ('  ', ' ', $string);
	return $string;
}
function removeScript($string){
	$string = preg_replace ('/<script.*?\>.*?<\/script>/si', '<br />', $string);
	$string = preg_replace ('/on([a-zA-Z]*)=".*?"/si', ' ', $string);
	$string = preg_replace ('/On([a-zA-Z]*)=".*?"/si', ' ', $string);
	$string = preg_replace ("/on([a-zA-Z]*)='.*?'/si", " ", $string);
	$string = preg_replace ("/On([a-zA-Z]*)='.*?'/si", " ", $string);
	return $string;
}
function removeLink($string){
	$string = preg_replace ('/<a.*?\>/si', '', $string);
	$string = preg_replace ('/<\/a>/si', '', $string);
	return $string;
}

function replaceFCK($string, $type=0){
	$array_fck	= array ("&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Igrave;", "&Iacute;", "&Icirc;",
								"&Iuml;", "&ETH;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ugrave;", "&Uacute;", "&Yacute;", "&agrave;",
								"&aacute;", "&acirc;", "&atilde;", "&egrave;", "&eacute;", "&ecirc;", "&igrave;", "&iacute;", "&ograve;", "&oacute;",
								"&ocirc;", "&otilde;", "&ugrave;", "&uacute;", "&ucirc;", "&yacute;",
								);
	$array_text	= array ("À", "Á", "Â", "Ã", "È", "É", "Ê", "Ì", "Í", "Î",
								"Ï", "Ð", "Ò", "Ó", "Ô", "Õ", "Ù", "Ú", "Ý", "à",
								"á", "â", "ã", "è", "é", "ê", "ì", "í", "ò", "ó",
								"ô", "õ", "ù", "ú", "û", "ý",
								);
	if($type == 1) $string = str_replace($array_fck, $array_text, $string);
	else $string = str_replace($array_text, $array_fck, $string);
	return $string;
}

function replaceJS($text){
	$arr_str = array("\'", "'", '"', "&#39", "&#39;", chr(10), chr(13), "\n");
	$arr_rep = array(" ", " ", '&quot;', " ", " ", " ", " ");
	$text		= str_replace($arr_str, $arr_rep, $text);
	$text		= str_replace("    ", " ", $text);
	$text		= str_replace("   ", " ", $text);
	$text		= str_replace("  ", " ", $text);
	return $text;
}

function replace_keyword_search($keyword, $lower=1){
	if($lower == 1) $keyword	= mb_strtolower($keyword, "UTF-8");
	$keyword	= replaceMQ($keyword);
	$arrRep	= array("'", '"', "-", "+", "=", "*", "?", "/", "!", "~", "#", "@", "%", "$", "^", "&", "(", ")", ";", ":", "\\", ".", ",", "[", "]", "{", "}", "‘", "’", '“', '”');
	$keyword	= str_replace($arrRep, " ", $keyword);
	$keyword	= str_replace("  ", " ", $keyword);
	$keyword	= str_replace("  ", " ", $keyword);
	return $keyword;
}

function replaceMQ($text){
	$text	= str_replace("\'", "'", $text);
	$text	= str_replace("'", "''", $text);
	return $text;
}

function remove_magic_quote($str){
	$str = str_replace("\'", "'", $str);
	$str = str_replace("\&quot;", "&quot;", $str);
	$str = str_replace("\\\\", "\\", $str);
	return $str;
}

function generate_star($value = 1, $width = 19){
	$value	=	intval($value);
	$width	=	intval($width);
	$str	=	'';
	$str	.=	'<span class="rateStar" style="background: url(\'/themes/v1/images/rating-star-'	.	$width	.	'.png\') no-repeat scroll 0 0 transparent; display: inline-block; height: '	.	$width	.	'px; width: '	.	($value*$width)	.	'px; background-position: 0px '	.	($value - 1)*(-$width)	.	'px;"></span>';
	return $str;
}

//Hàm cắt chuỗi , hiển thị số từ
function truncateString_($str, $len, $charset="UTF-8"){
    $str = html_entity_decode($str, ENT_QUOTES, $charset);
    if(mb_strlen($str, $charset)> $len){
        $arr = explode(' ', $str);
        $str = mb_substr($str, 0, $len, $charset);
        $arrRes = explode(' ', $str);
        $last = $arr[count($arrRes)-1];
        unset($arr);
        if(strcasecmp($arrRes[count($arrRes)-1], $last))   unset($arrRes[count($arrRes)-1]);
      return implode(' ', $arrRes)."...";
   }
    return $str;
}
// Hàm remover HTML đối với phần nội dung khóa học
function removeHTMLMain($string){
	$string = preg_replace ('/<script.*?\>.*?<\/script>/si', ' ', $string);
	$string = preg_replace ('/<style.*?\>.*?<\/style>/si', ' ', $string);
	$string = preg_replace ('/<b.*?\>/si', '^b^', $string);
	$string = preg_replace ('/<\/b>/si', '*b*', $string);
	$string = preg_replace ('/<.*?\>/si', ' ', $string);
    $string = str_replace ('^b^', '<b>', $string);
	$string = str_replace ('*b*', '</b>', $string);
	$string = str_replace ('&nbsp;', ' ', $string);
    $string = str_replace ('&amp;', '&', $string);
	$string = mb_convert_encoding($string, "UTF-8", "UTF-8");
	$string = str_replace (array(chr(9),chr(10),chr(13)), ' ', $string);
	for($i = 0; $i <= 5; $i++) $string = str_replace ('  ', ' ', $string);
	return $string;
}
//Hàm cắt chuỗi , đếm số câu ,chưa dịch
function getMainC($str1){
    $str2   = removeLink($str1);
    $str3   = removeHTML($str2);
    $str3   = str_replace ('&&', '<br /><br />', $str3);
    $str    = explode("|", $str3);
    return $str;
}
//Hàm cắt chuỗi , đếm số câu ,chưa dịch
function getMainCNoTr($str1){
    $str2   = removeLink($str1);
    $str3   = removeHTMLMain($str2);
    $str    = explode("&&", $str3);
    $count  = count($str);
    $content = '';
    for($i=0;$i < $count ;$i++){
        $strSub    = explode("|", $str[$i]);
        $countSub  = count($strSub);
        for($j=0;$j < $countSub ;$j++){
           $content .= '<span >'.$strSub[$j].'</span>';
        }
        $content  .= '<div style=" height: 8px;"></div>';
     }
    return $content;
}
//Hàm lấy nội dung và dịch
function getMainCTran($str1,$strTr1){
    $strTr2   = removeLink($strTr1);
    $strTr3   = removeHTML($strTr2);
    $strTr    = explode("&&", $strTr3);

    $str2   = removeLink($str1);
    $str3   = removeHTMLMain($str2);
    $str    = explode("&&", $str3);
    $count  = count($str);
    $contentTr = '';
    for($i=0;$i < $count ;$i++){
        $strSub    = explode("|", $str[$i]);
        $strTrSub  = explode("|", $strTr[$i]);
        $countSub  = count($strSub);
        for($j=0;$j < $countSub ;$j++){
           if(isset($strTrSub[$j])) { $translate = $strTrSub[$j]; }else{$translate = "";};
           $contentTr .= '<span class="masterTooltip" title="'.$strSub[$j].'" >'.$strSub[$j].'</span>';
           $contentTr  .= '<div style=" height: 4px;"></div>';
           $contentTr .= '<span class="masterTooltipTranslate" title="'.$translate.'" >'.$translate.'</span>';
        }
        $contentTr  .= '<div style=" height: 8px;"></div>';
     }
    return $contentTr;
}
//Hàm cắt chuỗi, lấy ra câu trả lời
function getStringAns($str){
    $arrayString =  getMainC($str);
    $count1      =  count($arrayString);
    $j           =  0;
    $arrayAns    =  array();
    for($i=0;$i<$count1;$i++){
       if($i%2 != 0) {
           $arrayAns[$j] = strtolower($arrayString[$i]);
           $j ++;
       }
    }
    return $arrayAns;
}
//Hàm cắt chuỗi , tách câu trả lời ra khỏi đoạn văn
function checklike($uid,$cid,$type){
    $check = 0;
    if ($type   = 'courses'){
        $typeid = 1;
    }
    $sqlCheck   =  new db_query("SELECT * FROM user_like WHERE usel_use_id = ".$uid." AND usel_cou_id = ".$cid." AND usel_type =".$typeid);
    while($rowCheck  = mysqli_fetch_assoc($sqlCheck->result)){
        $check ++;
    }unset($sqlCheck);
    if($check == 0){
        echo '<button id="button_lk"></button>';
    }
}
function loadmedia($url,$width,$heigh)
{
   echo "<embed width='". $width ."' height='". $heigh ."' type='application/x-shockwave-flash' src='../../../mediaplayer/player.swf' flashvars='file=". $url ."'</embed>";
}

function checkmedia_exe_para($type_media,$url,$media_id){
	if($type_media == 1){
		echo'<a style="text-decoration:none" title="Video" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=300&amp;width=300" /><b> View Video</b></a>';
	}elseif($type_media == 2){
	  	echo'<a style="text-decoration:none" title="Audio" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=300&amp;width=300" /><b> View Audio</b></a>';
	}elseif($type_media == 3){
	  	echo'<a style="text-decoration:none" title="Flash" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=400&amp;width=700" /><b> View Flash</b></a>';
	}elseif($type_media == 4){
	  	echo'<a style="text-decoration:none" title="Paragraph" class="thickbox noborder a_detail" href="edit_media_para.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&media_id=' . $media_id . '&TB_iframe=true&amp;height=400&amp;width=900" /><b> View Paragraph</b></a>';
	}elseif($type_media == 5){
	  	echo'<a style="text-decoration:none" title="Images" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=400&amp;width=700" /><b> View Images</b></a>';
	}
}

function checkmedia_exe($type_media,$url){
	if($type_media == 1){
		echo'<a style="text-decoration:none" title="Video" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=300&amp;width=300" /><b> View Video</b></a>';
	}elseif($type_media == 2){
		echo'<a style="text-decoration:none" title="Audio" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=300&amp;width=300" /><b> View Audio</b></a>';
	}elseif($type_media == 3){
		echo'<a style="text-decoration:none" title="Flash" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=400&amp;width=700" /><b> View Flash</b></a>';
	}
}

function checkmedia_les($type_media,$url){
	if($type_media == 1){
	  	echo'<a style="text-decoration:none" title="Image" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=300&amp;width=300" /><b> View Image</b></a>';
	}elseif($type_media == 2){
		echo'<a style="text-decoration:none" title="Video" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=300&amp;width=300" /><b> View Video</b></a>';
	}elseif($type_media == 3){
	  	echo'<a style="text-decoration:none" title="Flash" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&media_type='. $type_media .'&url_media=' . $url . '&TB_iframe=true&amp;height=400&amp;width=700" /><b> View Flash</b></a>';
	}
}

function get_count_test($cat_id){
	if($cat_id == 9){
		$db_test = new db_query("SELECT * FROM test WHERE test_active = 1");
		$num_test = mysqli_num_rows($db_test->result);
		unset($db_test);
		return $num_test;
	}elseif($cat_id == 76){
		$db_test = new db_query("SELECT * FROM toeic WHERE toeic_active = 1");
		$num_test = mysqli_num_rows($db_test->result);
		unset($db_test);
		return $num_test;
	}elseif($cat_id == 35){
		$db_test = new db_query("SELECT * FROM ielts WHERE ielt_active = 1");
		$num_test = mysqli_num_rows($db_test->result);
		unset($db_test);
		return $num_test;
	}
}

// Hàm check user xem đã thi xong bài test chưa
function check_test($u_id){
    $check  = 0;
    $sqlCheck   =  new db_query("SELECT * FROM users WHERE use_id = ".$u_id);
    while($rowCheck  = mysqli_fetch_assoc($sqlCheck->result)){
        if ( $rowCheck['use_test_complete'] == 1 && $rowCheck['use_test_status'] == 0){
            $check = 1;
        }
        if ( $rowCheck['use_test_complete'] == 0){
            $check = 2;
        }
        if ( $rowCheck['use_test_complete'] == 1 && $rowCheck['use_test_status'] == 1){
            $check = 4;
        }
    }unset($sqlCheck);
    return $check;
}

function check_ielts($u_id){
    $check  = 0;
    $sqlCheck   =  new db_query("SELECT * FROM users WHERE use_id = ".$u_id);
    while($rowCheck  = mysqli_fetch_assoc($sqlCheck->result)){
        if ( $rowCheck['use_ielts_complete'] == 1 && $rowCheck['use_ielts_status'] == 0){
            $check = 1;
        }
        if ( $rowCheck['use_ielts_complete'] == 0){
            $check = 2;
        }
        if ( $rowCheck['use_ielts_complete'] == 1 && $rowCheck['use_ielts_complete'] == 1){
            $check = 3;
        }
    }unset($sqlCheck);
    return $check;
}

//1.Kiem tra xem co ton tai bai thi khong
function check_isset_test($test_id){
	$db_check_test = new db_query("SELECT COUNT(test_name) FROM test WHERE test_id = ".$test_id);
	$row_check = mysqli_fetch_assoc($db_check_test->result);
	if($row_check['COUNT(test_name)'] == 0){
		redirect("http://tienganh2020.com");
	}
}
function check_isset_ielts($test_id){
	$db_check_test = new db_query("SELECT COUNT(ielt_name) FROM ielts WHERE ielt_id = ".$test_id);
	$row_check = mysqli_fetch_assoc($db_check_test->result);
	if($row_check['COUNT(ielt_name)'] == 0){
		redirect("http://tienganh2020.com");
	}
}
//2.Truong hop lay bai thi khac
function check_access_test_other($test_id){
   $myuser = new user();
   $u_id = $myuser->u_id;
   if($myuser->logged == 1){
		if(isset($_SESSION["exam_test_try"])){
		 //Neu la thi thu,check xem co phai bai thi co id = 40 khong,khong thi khong cho thi
		 if($test_id != 40){ redirect("http://hochay.vn"); }
		}else{
			//Truong hop khong phai thi thu
			$db_check_tesr = new db_query("SELECT COUNT(tesr_id) FROM test_result WHERE tesr_test_id = ".$test_id." AND tesr_user_id = ".$u_id." AND tesr_user_success = 0");
			$row_check = mysqli_fetch_assoc($db_check_tesr->result);
			if($row_check['COUNT(tesr_id)'] == 0){
				redirect("http://tienganh2020.com");
			}
      	}
   }else{
      redirect("http://tienganh2020.com");
   }
}

function check_access_ielts_other($test_id){
   $myuser = new user();
   $u_id = $myuser->u_id;
   if($myuser->logged == 1){
		//Truong hop khong phai thi thu
		$db_check_tesr = new db_query("SELECT COUNT(ielr_id) FROM ielts_result WHERE ielr_ielt_id = ".$test_id." AND ielr_user_id = ".$u_id." AND ielr_user_success = 0");
		$row_check = mysqli_fetch_assoc($db_check_tesr->result);
		if($row_check['COUNT(ielr_id)'] == 0){
		 redirect("http://hochay.vn");
		}
   }else{
      redirect("http://hochay.vn");
   }
}
//3.Kiem tra xem user dang lam den phan nao
function check_access_part($u_id){
	$tesr_part_success = 0;
	if(!isset($_SESSION['exam_test_try'])){
		//get tesr_id để check xem user này đang làm phần nào
		$tesr_id = getValue("tesr_id","int","GET",0);
		//get tesr_id if not exists
		if($tesr_id == 0){
			$sqlcheck = new db_query("SELECT tesr_id FROM test_result WHERE tesr_user_id = ".$u_id." AND tesr_user_success = 0");
			while($rowcheck = mysqli_fetch_assoc($sqlcheck->result)){
				$tesr_id = $rowcheck['tesr_id'];
			}unset($rowcheck);
		}
		//creat sesson tesr save
		$_SESSION['tesr_id'] = $tesr_id;
		//check success part
		$db_part_success = new db_query("SELECT tesr_part_success FROM test_result WHERE tesr_id =".$tesr_id);
		if($row_part = mysqli_fetch_assoc($db_part_success->result)){
			$tesr_part_success = $row_part['tesr_part_success'];
		}
	}return $tesr_part_success;
}

function check_access_part_ielts($u_id){
	$tesr_part_success = 0;
	if(!isset($_SESSION['exam_test_try'])){
		//get tesr_id để check xem user này đang làm phần nào
		$ielr_id = getValue("ielr_id","int","GET",0);
		//get tesr_id if not exists
		if($ielr_id == 0){
			$sqlcheck = new db_query("SELECT ielr_id FROM ielts_result WHERE ielr_user_id = ".$u_id." AND 	ielr_user_success = 0");
			while($rowcheck = mysqli_fetch_assoc($sqlcheck->result)){
				$ielr_id = $rowcheck['ielr_id'];
			}unset($rowcheck);
		}
		//creat sesson tesr save
		$_SESSION['ielr_id'] = $ielr_id;
		//check success part
		$db_part_success = new db_query("SELECT ielr_part_success FROM ielts_result WHERE ielr_id =".$ielr_id);
		if($row_part = mysqli_fetch_assoc($db_part_success->result)){
			$tesr_part_success = $row_part['ielr_part_success'];
		}
	}return $tesr_part_success;
}

function redirect_access_part_ielts($user_part,$num_part,$test_id){
	if($user_part != $num_part){
		if($user_part == 0 || $user_part == 1){
			redirect("direct_listening.php?test_id=".$test_id);
		}elseif($user_part == 2){
			redirect("direct_reading.php?test_id=".$test_id);
		}elseif($user_part == 3){
			redirect("direct_writing.php?test_id=".$test_id);
		}elseif($user_part == 3){
			redirect("http://tienganh2020.com");
		}
	}
}

//4. Hàm tính thời gian thi
function creat_time_test($time_test_real){
	$time_test = $time_test_real * 60;
	if(isset($_SESSION['targetDate'])) {
		$time_target = $_SESSION['targetDate'];
	}else{
		$time_target = time() + ($time_test);
		$_SESSION['targetDate'] = $time_target;
	}
	$dateFormat = "d F Y -- g:i a";
	$time_actual = time();
	$time_diff = $time_target - $time_actual;
	return $time_diff;
}

function creat_time_ielts($time_test_real){
	$time_test = $time_test_real * 60;
	if(isset($_SESSION['targetDate_ielts'])) {
		$time_target = $_SESSION['targetDate_ielts'];
	}else{
		$time_target = time() + ($time_test);
		$_SESSION['targetDate_ielts'] = $time_target;
	}
	$dateFormat = "d F Y -- g:i a";
	$time_actual = time();
	$time_diff = $time_target - $time_actual;
	return $time_diff;
}
//------------------------------------------------------------------------------------------------------------------------

//Ham check va tao khoa hoc free cho user
function check_give_course_test($uid_inviter){
	$sqlUser = new db_query("SELECT use_date_act_end,use_test_status,use_status_act FROM users WHERE use_id = ".$uid_inviter);

	if($row_user = mysqli_fetch_assoc($sqlUser->result)){
		$invite_date = $row_user['use_date_act_end'];
		$invite_test = $row_user['use_test_status'];
		$invite_status = $row_user['use_status_act'];
	}unset($sqlUser);

	$invite_date_total = $invite_date + (48 * 60 * 60);
	$invite_test_total = $invite_test + 1;

	$sqlCheck = new db_query("SELECT user_invite_count FROM user_invite WHERE user_invite_uid = ".$uid_inviter);
	while($row_check  = mysqli_fetch_assoc($sqlCheck->result)){
		if($row_check['user_invite_count'] == 2){
			// cộng time học
			if($invite_status == 1){
				$db_ex = new db_execute("UPDATE users SET use_date_act_end = ". $invite_date_total ." WHERE use_id = " . $uid_inviter);
				$db_ex_1 = new db_execute("UPDATE users SET use_status_act = 1 WHERE use_id = " . $uid_inviter);
			}else{
				$use_date   =  time();
				$use_date_end  =  $use_date + (48* 60 * 60);
				$db_ex = new db_execute("UPDATE users SET use_date_act_start = ". $use_date ." WHERE use_id = " . $uid_inviter);
				$db_ex = new db_execute("UPDATE users SET use_date_act_end = ". $use_date_end ." WHERE use_id = " . $uid_inviter);
				$db_ex_1 = new db_execute("UPDATE users SET use_status_act = 1 WHERE use_id = " . $uid_inviter);
			}
		}

		if($row_check['user_invite_count'] == 5){
			// cộng lượt thi
		  $db_ex = new db_execute("UPDATE users SET use_test_status = ". $invite_test_total ." WHERE use_id = " . $uid_inviter);
		}
	}
}

// hàm check speaking và writing
function checkLearn($uid,$learn){
    $check  = 0;
    if($learn == 'writing')  { $dblearn = 'learn_writing';  }
    if($learn == 'speaking') { $dblearn = 'learn_speaking'; }
    $sqlCheck   =  new db_query("SELECT * FROM ".$dblearn." WHERE learn_unit_id = ".$uid);
    while($rowCheck  = mysqli_fetch_assoc($sqlCheck->result)){
        $check = 1;
    }
    unset($sqlCheck);
    return $check;
}
// hàm check speaking và writing
function checkLesson($uid,$learn){
	$check  = 0;
	if($learn == 'main' || $learn == 'strategy')  { $dblearn = 'main_lesson';$les_det_type = 1;$det_id = "main_det_id";  }
	if($learn == 'grammar') { $dblearn = 'grammar_lesson';$les_det_type = 2;$det_id = "gram_det_id"; }
	if($learn == 'vocabulary') { $dblearn = 'vocabulary_lesson';$les_det_type = 3;$det_id = "voc_det_id"; }
	$sqlUnitMail = new db_query("SELECT * FROM lesson_details WHERE les_det_type = ".$les_det_type." AND les_com_id =".$uid);
	$rowUnitMail = mysqli_fetch_assoc($sqlUnitMail->result);
	$iUnit       = $rowUnitMail['les_det_id'];
	unset($sqlUnitMail);
	//Lấy nội dung bài học và bài tập
	$sqlCont    = new db_query("SELECT * FROM ".$dblearn." WHERE ".$det_id." = ".$iUnit);
	while($rowCheck  = mysqli_fetch_assoc($sqlCont->result)){
	    $check = 1;
	}
	return $check;
}

function checkUnit($uid){
    $check  = 0;
    $db1 = new db_query('SELECT exe_id FROM exercises WHERE exe_type = 0 AND exe_com_id = '.$uid);
    while($row1 = mysqli_fetch_assoc($db1->result)){
      $db2 = new db_query('SELECT que_id FROM questions WHERE que_exe_id = '.$row1['exe_id']);
      while($row2 = mysqli_fetch_assoc($db2->result)){
         $check++;
      }unset($db2);
    }unset($db1);
    if($check > 0) $check = 1;
    return $check;
}

function checkUnit_main($uid){
    $check  = 0;
    $sqlCheck   =  new db_query("SELECT * FROM main_lesson WHERE main_det_id = (SELECT les_det_id FROM lesson_details WHERE les_com_id = ". $uid ." AND les_det_type = 1)");
    if($rowCheck  = mysqli_fetch_assoc($sqlCheck->result)){
        $check = 1;
    }
    unset($sqlCheck);
    return $check;
}

//Ham insert ban ghi de lam bai tap va tinh diem
function add_test_result($u_id,$test_id){
   // insert bang ket qua
   $sql  =  "INSERT INTO `test_result` (`tesr_id`, `tesr_user_id`, `tesr_test_id`) VALUES (NULL, $u_id, $test_id);";
   $db_insert  =  new db_execute($sql);
   // update bang user
   $db_ex = new db_execute("UPDATE users SET use_test_complete = 0 WHERE use_id = " . $u_id);
}

//Ham check xem user da tham gia khoa hoc hay chua, neu chua tham gia thi insert vao bang user_course
function check_user_course($idUser,$idCou){
	$sqlCheck   =  new db_query("SELECT * FROM user_course WHERE usec_use_id = ".$idUser." AND usec_cou_id = ".$idCou);
	$row_check  = mysqli_fetch_assoc($sqlCheck->result);
	unset($sqlCheck);
	if($row_check == Null){
		$sql  =  "INSERT INTO `user_course` (`usec_use_id`, `usec_cou_id`, `usec_start_time`, `usec_status`) VALUES ('".$idUser."', '".$idCou."', '".time()."', '0');";
		$db_insert = new db_execute($sql);
		unset($db_insert);
	}
	$sql = "UPDATE user_course SET usec_last_time = ".time()." WHERE usec_use_id = ".$idUser." AND usec_cou_id = ".$idCou;
	$db_update = new db_execute($sql);
	unset($db_update);
}
//Ham check share facebook badges
function check_fb_badge($idUser,$idbadge){
	$time = time();
	$db_useb = new db_query("SELECT * FROM user_badges WHERE useb_use_id = ".$idUser." AND useb_badge_id = ".$idbadge);
	$row_useb = mysqli_fetch_assoc($db_useb->result);
	unset($db_useb);
	if($row_useb == NUll){
		//Neu chua co badge nay thi them vao bang user_badges
		$db_insert = new db_execute("INSERT user_badges ( useb_id, useb_use_id, useb_badge_id, useb_get_time ) VALUES ('NULL','".$idUser."','".$idbadge."','".$time."')");
		unset($db_insert);
		switch($idbadge){
			case 7 : $day = 10; break;
			case 6 : $day = 5; break;
			case 5 : $day = 2;  break;
			case 4 : $day = 1;  break;
			default: $day = 0;  break;
		}
		//Tang ngay su dung
		$db_award = new db_query("SELECT * FROM users WHERE use_id = ".$idUser);
		$row_award = mysqli_fetch_assoc($db_award->result);
		if($row_award['use_status_act'] == 0){
			$use_date_end  =  $time + ($day*24*60*60);
			$sql = "UPDATE users SET use_date_act_start = '".$time."',use_date_act_end = '".$use_date_end."',use_status_act = '1' WHERE use_id = ".$idUser;
			$db_update = new db_execute($sql);
			unset($db_update);
		}
		else{
			$use_date_act_end  = $row_award['use_date_act_end'] + ($day*24*60*60);
			$sql = "UPDATE users SET use_date_act_end = '".$use_date_act_end."' WHERE use_id = ".$idUser;
			$db_update = new db_execute($sql);
			unset($db_update);
		}unset($db_award);
		return 1;
	}
	return 0;
}

// Hàm hiển thị ramdon phần tử trong mảng
function array_random($arr, $num = 1) {
    shuffle($arr);
    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
}
// Hàm check ip không proxy
function getRealIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      	$ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      	$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      	$ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
// Hàm check IP
function checkUserIP($ip,$course){
	$check = 1; // = 1  nếu là lần đầu đăng nhập
	$sqlIP = new db_query("SELECT * FROM user_ip WHERE use_ip = '".$ip."'");
	while($rowIP = mysqli_fetch_assoc($sqlIP->result)){
		if($rowIP['use_course'] == $course){
			$check = 2;
		}else{
			$check = 0;
		}
	}
	return $check;
}
// Hàm lưu IP
function saveIp($ip,$course){
	$check = checkUserIP($ip,$course);
	if ($check == 1){
		$db_insert = new db_execute("INSERT user_ip ( use_ip, use_date , use_course  ) VALUES ('".$ip."','".time()."' , '".$course."')");
	}
}
// Hàm get audio cho luyen noi
function get_media_sp($straudio){
	$media     = "";
	$audio     = explode("|",$straudio);
	$count     = count($audio);
	for($i=0;$i < $count ;$i++){
		 $media .= '<a class="media" href="'.getURL(1,0,0,0).'js/data_record/'.trim($audio[$i]).'"></a><br />';
	}
	return $media;
}

// hàm lấy tên lever trong course
function nameLevel($idLvC){
     $db_level = new db_query("SELECT *
					           FROM levels
					           WHERE lev_id	= ".$idLvC);
    while($row = mysqli_fetch_assoc($db_level->result)){
        $nLevel = $row['lev_name'];
	}
    unset($db_level);
    return $nLevel;
    // it.Hoanlv
}

// Hàm lấy tên category trong course
function nameCate($idCoureC){
    $db_cate = new db_query("SELECT cat_name
                             FROM categories_multi
                             WHERE cat_id	= ".$idCoureC);
    while($row = mysqli_fetch_assoc($db_cate->result)){
        $nCate = $row['cat_name'];
	}unset($db_cate);
    return $nCate;
    // it.Hoanlv
}

// Hàm get media cho quiz
function get_media_quiz($id){
	 $media  = "";
	 if (($id != '0') && ($id != '')){
	 $id     = explode("|", $id);
     $count  = count($id);
     for($i=0;$i < $count ;$i++){

		 $sqlMedia    = new db_query("SELECT * FROM media_exercies WHERE media_id = ".$id[$i]);
		 while($rowMedia = mysqli_fetch_assoc($sqlMedia->result)){
			 if($rowMedia['media_type'] == 2){
				 $media .= "<div style='margin-top:10px;padding:10px;border-top:1px dashed #999'><b>Audio cho phần bài tập</b></div>";
				 $media .= '<a class="media" href="'.getURL(1,0,0,0).'/data/exercises_unit/'.$rowMedia['media_name'].'"></a>';
			 }elseif($rowMedia['media_type'] == 1){
				 $media .= "<div style='margin-top:10px;padding:10px;border-top:1px dashed #999'><b>Video cho phần bài tập</b></div>";
				 $media .= "<center><embed width='400' height='250' type='application/x-shockwave-flash' src='".getURL(1,0,0,0)."/mediaplayer/player.swf' flashvars='file=".getURL(1,0,0,0)."/data/exercises_unit/".$rowMedia['media_name']."'</embed></center>";
			 }elseif($rowMedia['media_type'] == 4){
				 $media .= "<div style='margin-top:10px;padding:10px;border-top:1px dashed #999'><b>đọc đoạn văn sau và trả lời câu hỏi</b></div>";
				 $media .= $rowMedia["media_paragraph"];
			 }elseif($rowMedia['media_type'] == 5){
				 $media .= "<div style='margin-top:10px;padding:10px;border-top:1px dashed #999'></div>";
				 $media .= "<img src='".getURL(1,0,0,0)."/data/exercises_unit/".$rowMedia['media_name']."' style='max-height:800px;max-width:800px'/>";
			 }
		 }
		 unset($sqlMedia);
	 }
	 }
	 return $media;
}
// Hàm get media cho quiz
function get_media_quiz_skill($id){
	$media  = "";
	 if (($id != '0') && ($id != '')){
	 $id     = explode("|", $id);
     $count  = count($id);
     for($i=0;$i < $count ;$i++){

		 $sqlMedia    = new db_query("SELECT * FROM media_exercies WHERE media_id = ".$id[$i]);
		 while($rowMedia = mysqli_fetch_assoc($sqlMedia->result)){
			 if($rowMedia['media_type'] == 2){
				 $media .= "<div><b>Audio cho phần bài tập</b></div>";
				 $media .= '<a class="media" href="'.getURL(1,0,0,0).'/data/skill_exercises/'.$rowMedia['media_name'].'"></a>';
			 }elseif($rowMedia['media_type'] == 1){
				 $media .= "<div><b>Video cho phần bài tập</b></div>";
				 $media .= "<center><embed width='400' height='250' type='application/x-shockwave-flash' src='".getURL(1,0,0,0)."/mediaplayer/player.swf' flashvars='file=".getURL(1,0,0,0)."/data/skill_exercises/".$rowMedia['media_name']."'</embed></center>";
			 }elseif($rowMedia['media_type'] == 4){
				 $media .= "<div><b></b></div>";
				 $media .= $rowMedia["media_paragraph"];
			 }elseif($rowMedia['media_type'] == 5){
				 $media .= "<div></div>";
				 $media .= "<img src='".getURL(1,0,0,0)."/data/skill_exercises/".$rowMedia['media_name']."'/>";
			 }
		 }
		 unset($sqlMedia);
	 }
	 }
	 return $media;
}
// Hàm get media cho thư viện
function get_media_library($file,$image){
	global $base_url;

	$media  = "<script type='text/javascript' src='"."http://".$base_url."/"."mediaplayer/jwplayer.js'></script>";
	$media .= "<center><div id='mediaplayer'></div></center>";
	$media .= "<script type='text/javascript'>
              jwplayer('mediaplayer').setup({
                'flashplayer': 'http://".$base_url."/"."mediaplayer/player.swf',
                'id': 'playerID',
                'width': '500',
                'height': '280',
                'file': '".$file."',
                'image': '".$image."',
                'skin': '".getURL(1,0,0,0)."mediaplayer/skins/blueratio/blueratio.xml',
                'viral.allowmenu':false,
                'viral.functions' : false,
				'autostart'  : true,
              });
             </script>";
	echo $media;
}

function get_media_library_v2($file,$image){
	global $base_url;
	$media   =  "<center><div id='mediaplayer_".$file."' class='jwplayer'></div></center>";
	$media  .=  "<script type='text/javascript'>
                jwplayer('mediaplayer_".$file."').setup({
                    'volume': '100',
                    'allowscriptaccess': 'always',
                    'wmode': 'opaque',
                    'file': '".$file."',
                    'width': '100%',
                    'height': '',
                    'skin': 'http://".$base_url."/mediaplayer/skins/five.xml',
                    'logo':{
                   		file: '',
        				link: '".$base_url."'
                    }
               });
             </script>";
	echo $media;
}

function get_media_skill_v2($file,$count){
	global $base_url;
	$media   =  "<center><div id='mediaplayer_".$count."' class='jwplayer'></div></center>";
	$media  .=  "<script type='text/javascript'>
                jwplayer('mediaplayer_".$count."').setup({
                    'volume': '100',
                    'allowscriptaccess': 'always',
                    'wmode': 'opaque',
                    'file': '".$file."',
                    'width': '100%',
                    'height': '',
                    'skin': 'http://".$base_url."/mediaplayer/skins/five.xml',
                    'logo':{
                   		file: '',
        				link: '".$base_url."'
                    }
               });
             </script>";
	echo $media;
}

//Hàm tạo chuỗi ngẫu nhiên
function rand_string( $length ) {
$str = "";
$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
$size = strlen( $chars );
for( $i = 0; $i < $length; $i++ ) {
$str .= $chars[ rand( 0, $size - 1 ) ];
 }
return $str;
}
//Hàm Share Facebook Badge
function share_fb_badge($iUser){
   $db_usea = new db_query("SELECT usea_share_sum FROM user_action WHERE usea_use_id = ".$iUser);
   $row_usea = mysqli_fetch_assoc($db_usea->result);
   unset($db_usea->result);

   if($row_usea['usea_share_sum'] >= 30){
      $add_this_badge = check_fb_badge($iUser,7);
      if($add_this_badge == 1) return 7;
      else return 0;
   }
   else if($row_usea['usea_share_sum'] >= 10){
      $add_this_badge = check_fb_badge($iUser,6);
      if($add_this_badge == 1) return 6;
      else return 0;
   }
   else if($row_usea['usea_share_sum'] >= 5){
      $add_this_badge = check_fb_badge($iUser,5);
      if($add_this_badge == 1) return 5;
      else return 0;
   }
   else if($row_usea['usea_share_sum'] >= 1){
      $add_this_badge = check_fb_badge($iUser,4);
      if($add_this_badge == 1) return 4;
      else return 0;
   }
   else return 0;
}

function get_id_module($module){
	switch($module) {

		// Categories_multi Table
        case "listCourses"     			:
        case "listCommunity"			:
        case "listSkills"      			:
        // Libraries Categories Table
        case "listLibraries"			:
        // News Categories Table
        case "listNews"					: 	$id = getValue("iCategory");		break;

        case "listCoursesMain"  		:  	$id = getValue("iCourse");			break;
        case "listSkillsDetails"  		:  	$id = getValue("iSkill");       	break;
        case "listCommunityDetails"  	:  	$id = getValue("iCommunity");   	break;

        case "listLibrariesDetails"  	:  	$id = getValue("iLibrary");   		break;
        case "listNewsDetails"  		:  	$id = getValue("iNew");   			break;

        default                			:  	$id = 0;

    } 	return $id;
}

//Hàm get id cho skill
function get_id_skill($skill){
	switch($skill)
        {
        case "cate"     :  $id = getValue("cate","int","GET",""); break;
        case "les"      :  $id = getValue("iles","int","GET",""); break;
        case "edit_les" :  $id = getValue("iles","int","GET",""); break;
        default         :  $id = 0;
        }
	return $id;
}
// Hàm mã hóa url
function encrypt($string, $key) {
	$result = '';
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
	}
	return base64_encode($result);
}
// Hàm giải mã url
function decrypt($string, $key) {
	$result = '';
	$string = base64_decode($string);

	for($i=0; $i<strlen($string); $i++) {
	$char = substr($string, $i, 1);
	$keychar = substr($key, ($i % strlen($key))-1, 1);
	$char = chr(ord($char)-ord($keychar));
	$result.=$char;
	}

	return $result;
}
// Hàm kiểm tra  thanh toán
function checkpayment($methods,$price,$time,$type){
		$check = 0;
		if ($type == 'course'){
			if(($methods == 'atm') || ($methods == 'baokim') || ($methods == 'visa') || ($methods == 'tranfers')){
				if(($time == '35' && $price == '50000')
					|| ($time == '75' && $price == '100000')
					|| ($time == '360' && $price == '140000')
					|| ($time == '540' && $price == '300000'))
				{ $check = 2; }
			}
			if($methods == 'home'){
				if(($time == '360' && $price == '140000')
					|| ($time == '540' && $price == '300000')
               || ($time == '35' && $price == '50000')
               || ($time == '75' && $price == '100000'))
				{ $check = 2; }
			}
			if($methods == 'card'){
				if(($time == '30' && $price == '50000')
					|| ($time == '60' && $price == '100000')
					|| ($time == '300' && $price == '300000')
					|| ($time == '450' && $price == '400000'))
				{ $check = 2; }
			}
		}elseif ($type == 'pm_test'){
			if($methods == 'atm'){
				if($time == '1' && $price == '120000') { $check = 2; }
			}
			if($methods == 'card'){
				if($time == '1' && $price == '150000') { $check = 2; }
			}
		}
	// check = 1 ; tài khoản đã kích hoạt
	return $check;
}
// Hàm get cate course
function get_cateCourse($icou){
	$nCate = array();
    $db_cate = new db_query("SELECT cat_name,cat_id
									FROM   categories_multi,courses
									WHERE  courses.cou_id = ".$icou." AND categories_multi.cat_id = courses.cou_cat_id");
    while($row_cate = mysqli_fetch_assoc($db_cate->result)){
      $nCate['name']    = $row_cate['cat_name'];
	  $nCate['id']      = $row_cate['cat_id'];
    }; unset($db_cate);
	return $nCate;
}
// Hàm get menu icon
function get_li_link($id,$name,$method,$lesson,$type = ""){
	global $base_url;
	if ($lesson == $method) { $classLi = "active"; }else{ $classLi = ""; }
	switch($method){
		case "main" 			:
			$title   = "Main Lesson";
			$classA  = "icon-main";
			break;
		case "grammar"          :
			$title   = "Grammar";
			$classA  = "icon-gram";
			break;
		case "vocabulary"       :
			$title   = "Vocabulary";
			$classA  = "icon-voca";
			break;
		case "quiz"             :
			$title   = "Quiz";
			$classA  = "icon-quiz";
			break;
		case "speak"            :
			$title   = "Speaking";
			$classA  = "icon-speak";
			break;
		case "write"			:
			$title   = "Writing";
			$classA  = "icon-write";
			break;
		case "strategy"			:
			$title   = "Strategy";
			$classA  = "icon-main";
			break;
		case "practice"			:
			$title   = "Practice";
			$classA  = "icon-quiz";
			break;
	}
	$li  = '<li class="lessonTooltip '.$classLi.'" title="'.$title.'">';
	$url123doc = '';
	if ($type != ""){ $url123doc = '/123doc'; }
	$li .= '<a href="http://'.$base_url.$url123doc.'/lesson/'.$method.'/'.$id.'/'.removeTitle($name).'.html" class="'.$classA .'">&nbsp;</a></li>';
	return $li;
}
function get_menu_icon($iCou,$id,$name,$lesson){
	$sqlForm    = new db_query("SELECT * FROM courses WHERE cou_id = ".$iCou);
	if($row_form = mysqli_fetch_assoc($sqlForm->result)){
		$type = $row_form['cou_form'];
	}unset($sqlForm);
	$menu = '<ul>';
	if($type == 1 || $type == 2){
		$menu .=   get_li_link($id,$name,"main",$lesson);
		$menu .=   get_li_link($id,$name,"grammar",$lesson);
		$menu .=   get_li_link($id,$name,"vocabulary",$lesson);
		if($type != 2){
			$menu .=   get_li_link($id,$name,"quiz",$lesson);
		}
	    if (checkLearn($id,'writing') == 1) {
			$menu .=   get_li_link($id,$name,"write",$lesson);
	    }if (checkLearn($id,'speaking') == 1) {
			$menu .=   get_li_link($id,$name,"speak",$lesson);
	    }
	}elseif($type == 3){
		$menu .=   get_li_link($id,$name,"strategy",$lesson);
		$menu .=   get_li_link($id,$name,"practice",$lesson);
	}
    $menu .= '</ul>';
    return $menu;
}

function check_learn_user($iles,$iuser,$type){
	if ($type == 'write'){
		$sqlRe   = new db_query("SELECT * FROM learn_writing_result WHERE lwr_wri_id = ".$iles." AND lwr_use_id = ".$iuser);
	}elseif($type == 'speak'){
		$sqlRe   = new db_query("SELECT * FROM learn_speak_result WHERE lsr_spe_id = ".$iles." AND lsr_use_id = ".$iuser);
	}elseif($type == 'skl_speak'){
	   $sqlRe   = new db_query("SELECT * FROM learn_speak_result WHERE lsr_skl_les_id = ".$iles." AND lsr_use_id = ".$iuser);
	}elseif($type == 'skl_write'){
	   $sqlRe   = new db_query("SELECT * FROM learn_writing_result WHERE lwr_skl_les_id = ".$iles." AND lwr_use_id = ".$iuser);
	}
	$row_check  = mysqli_fetch_assoc($sqlRe->result);
	if ($row_check == NULL) { $check = 0; }else{ $check = 1; }
	unset($sqlRe);
	return $check;
}
//Ham lay so nguoi gui bai luyen noi,luyen nghe trong 1 skill lesson
function get_person_sk($ilesson,$lesson_type){
   $num_person = 0;
   if($lesson_type == 2 || $lesson_type == 5){
      $db = new db_query("SELECT lsr_id FROM learn_speak_result WHERE lsr_skl_les_id = ".$ilesson);
      $num_person = mysqli_num_rows($db->result);
   }elseif($lesson_type == 3 || $lesson_type == 4){
      $db = new db_query("SELECT lwr_id FROM learn_writing_result WHERE lwr_skl_les_id = ".$ilesson);
      $num_person = mysqli_num_rows($db->result);
   }
   return $num_person;
}

//Ham check user onl
function check_user_online($u_id){
   //$myuser = new user();
   //------------------
   $base_url            =  $_SERVER['HTTP_HOST'];
   $db_count_uonline    = new db_query("SELECT count(*) AS count FROM user_online WHERE uonl_user_id = ".$u_id);
	$row_count_uonline	= mysqli_fetch_array($db_count_uonline->result);
	$count_uonline       = $row_count_uonline["count"];
   $time_waiting        = 5 * 60;
   //------------------
   if($count_uonline <= 0){
      $current_time = time();
      $sql_insert_uonline = "INSERT INTO user_online  VALUES (NULL ,'". $u_id ."', '', 1, '".$current_time."')";
      $db_ins_uonline = new db_execute($sql_insert_uonline);unset($db_ins_uonline);
      //$myuser->savecookie(5*24*3600);
      redirect("http://".$base_url."/courses.html");
   }else{
      $current_time = time();
      $db_onl_off = new db_query("SELECT uonl_onl_off,uonl_last_act FROM user_online WHERE uonl_user_id = ".$u_id);
      while($row_onl_off = mysqli_fetch_assoc($db_onl_off->result)){
         $get_onl_off = $row_onl_off['uonl_onl_off'];
         $last_time_act = $row_onl_off['uonl_last_act'];
      }unset($db_onl_off);
      //if($get_onl_off == 0){
         //$sql_update_lastact = "UPDATE user_online SET uonl_last_act = ".$current_time." WHERE uonl_user_id = ".$u_id;
         //$db_upt_lastact = new db_execute($sql_update_lastact);
         //unset($db_upt_lastact);
         //redirect("http://".$base_url."/courses.html");
      //}else
      if($current_time < ($last_time_act + $time_waiting)){
         echo "<script>alert('Tài khoản của bạn đang được sử dụng!');</script>";
         redirect("http://".$base_url."/logout_onl.html");
      }elseif($current_time > ($last_time_act + $time_waiting)){
         $sql_update_lastact = "UPDATE user_online SET uonl_last_act = ".$current_time." WHERE uonl_user_id = ".$u_id;
         $db_upt_lastact = new db_execute($sql_update_lastact);
         unset($db_upt_lastact);
         //redirect("http://".$base_url."/courses.html");
      }
   }
}
//Ham update last act
function update_last_act($u_id){
   $current_time = time();
   $sql_update_lastact = "UPDATE user_online SET uonl_last_act = ".$current_time." WHERE uonl_user_id = ".$u_id;
   $db_upt_lastact = new db_execute($sql_update_lastact);
   unset($db_upt_lastact);
}

//
function update_logout($u_id){
   $db_exec	= new db_execute("DELETE FROM user_online WHERE uonl_user_id = " . $u_id);
	unset($db_exec);
}
//
function ins_cookie($u_id){
   $base_url            =  $_SERVER['HTTP_HOST'];
   $db_count_uonline    = new db_query("SELECT count(*) AS count FROM user_online WHERE uonl_user_id = ".$u_id);
	$row_count_uonline	= mysqli_fetch_array($db_count_uonline->result);
	$count_uonline       = $row_count_uonline["count"];
   $time_waiting        = 5 * 60;
   //------------------
   if($count_uonline <= 0){
      $current_time = time();
      $sql_insert_uonline = "INSERT INTO user_online  VALUES (NULL ,'". $u_id ."', '', 1, '".$current_time."')";
      $db_ins_uonline = new db_execute($sql_insert_uonline);unset($db_ins_uonline);
      //$myuser->savecookie(5*24*3600);
      redirect("http://".$base_url."/courses.html");
   }
}

function ins_code($num,$str_length,$time,$type){
   for($i=0;$i<$num;$i++){
      $random_str = md5(uniqid(mt_rand(), true));
      $str_code = strtoupper(substr($random_str,0,$str_length));
      //echo $i."------".$str_code."</br>";
      $sql_insert = "INSERT INTO code_payment_home  VALUES (NULL, 0, '". $str_code ."', ".$time.", 0, ".$type.")";
      $db_ins = new db_execute($sql_insert);
   }
}

// -----------------------------FUNCTION HOCHAY V2---------------------------------

//Ham check user onl
function check_user_online_v2($u_id){
   //$myuser = new user();
   //------------------
   $base_url            =  $_SERVER['HTTP_HOST'];
   $db_count_uonline    = new db_query("SELECT count(*) AS count FROM user_online WHERE uonl_user_id = ".$u_id);
	$row_count_uonline	= mysqli_fetch_array($db_count_uonline->result);
	$count_uonline       = $row_count_uonline["count"];
   $time_waiting        = 5 * 60;
   //------------------
   if($count_uonline <= 0){
      $current_time = time();
      $sql_insert_uonline = "INSERT INTO user_online  VALUES (NULL ,'". $u_id ."', '', 1, '".$current_time."')";
      $db_ins_uonline = new db_execute($sql_insert_uonline);unset($db_ins_uonline);
      //$myuser->savecookie(5*24*3600);
      redirect("http://".$base_url."/courses_v2.html");
   }else{
      $current_time = time();
      $db_onl_off = new db_query("SELECT uonl_onl_off,uonl_last_act FROM user_online WHERE uonl_user_id = ".$u_id);
      while($row_onl_off = mysqli_fetch_assoc($db_onl_off->result)){
         $get_onl_off = $row_onl_off['uonl_onl_off'];
         $last_time_act = $row_onl_off['uonl_last_act'];
      }unset($db_onl_off);
      //if($get_onl_off == 0){
         //$sql_update_lastact = "UPDATE user_online SET uonl_last_act = ".$current_time." WHERE uonl_user_id = ".$u_id;
         //$db_upt_lastact = new db_execute($sql_update_lastact);
         //unset($db_upt_lastact);
         //redirect("http://".$base_url."/courses.html");
      //}else
      if($current_time < ($last_time_act + $time_waiting)){
         echo "<script>alert('Tài khoản của bạn đang được sử dụng!');</script>";
         redirect("http://".$base_url."/logout_onl.html");
      }elseif($current_time > ($last_time_act + $time_waiting)){
         $sql_update_lastact = "UPDATE user_online SET uonl_last_act = ".$current_time." WHERE uonl_user_id = ".$u_id;
         $db_upt_lastact = new db_execute($sql_update_lastact);
         unset($db_upt_lastact);
         //redirect("http://".$base_url."/courses.html");
      }
   }
}
//
function ins_cookie_v2($u_id){
   $base_url            =  $_SERVER['HTTP_HOST'];
   $db_count_uonline    = new db_query("SELECT count(*) AS count FROM user_online WHERE uonl_user_id = ".$u_id);
	$row_count_uonline	= mysqli_fetch_array($db_count_uonline->result);
	$count_uonline       = $row_count_uonline["count"];
   $time_waiting        = 5 * 60;
   //------------------
   if($count_uonline <= 0){
      $current_time = time();
      $sql_insert_uonline = "INSERT INTO user_online  VALUES (NULL ,'". $u_id ."', '', 1, '".$current_time."')";
      $db_ins_uonline = new db_execute($sql_insert_uonline);unset($db_ins_uonline);
      //$myuser->savecookie(5*24*3600);
      redirect("http://".$base_url."/courses.html");
   }
}

function generate_lesson_detail_v2($str_cate,$type,$iCou,$iUnit,$name){
	global $base_url;
   $link	= 'http://'.$base_url."/khoa-hoc/".removeTitle($str_cate)."/" . removeTitle($name)	.	"/" . $iCou . "-" . $iUnit . "-" . $type . ".html";
   return $link;
}

function get_cate_parent_htt_v2($arr_cate_id){
   global	$base_url;
   $var_path_img =  '/pictures/categories/';
   $i = 1;
   foreach ($arr_cate_id as $value) {
      $db_cate = new db_query('SELECT * FROM categories_multi WHERE 	cat_id = '.$value.' AND cat_active = 1');
      if($row_cate = mysqli_fetch_assoc($db_cate->result)){
         $cat_name = $row_cate["cat_name"];
      }unset($db_cate);
      echo '<div class="course_right_block">';
      echo    '<div class="course_right_block_content show_first">';
      echo       '<img src="/themes_v2/images/course_thumb.jpg"/>';
      echo       '<span class="title">'.$cat_name.'</span>';
      echo    '</div>';
      echo    '<div class="course_right_block_list show_hover">';
      echo       '<div class="course_right_block_content">';
      echo          '<span class="course_right_block_title">'.$cat_name.'</span>';
      echo          '<ul class="scroll-pane">';
                    $db_cou = new db_query('SELECT cou_id,cou_name,cou_form FROM courses WHERE cou_cat_id = '.$value.' AND cou_active = 1 ORDER BY cou_name ASC');
                    while($row_cou = mysqli_fetch_assoc($db_cou->result)){
                       $cou_form = $row_cou['cou_form'];
                       $cou_df = "";
                       if($cou_form == 3){ $cou_df = "strategy"; }else{ $cou_df = "main"; }
                       $sqlFirstUnit = new db_query("SELECT com_id,com_name FROM courses_multi WHERE com_num_unit = 1 AND com_cou_id = ".$row_cou['cou_id']);
                       if($row_uFirst = mysqli_fetch_assoc($sqlFirstUnit->result)){ $first_unit = $row_uFirst['com_id'];$u_name = $row_uFirst['com_name']; }unset($sqlFirstUnit);
                       echo '<li><a href="'.generate_lesson_detail_v2($cou_df,$row_cou['cou_id'],$first_unit,$u_name).'">'.$row_cou['cou_name'].'</a></li>';
                    }unset($db_cou);
      echo          '</ul>';
      echo       '</div>';
      echo    '</div>';
      echo '</div>';
      $i++;
   }
}
//Ham in ra list khoa hoc hoac danh muc con
//type = 1: In ra khoa hoc, type = 2: In ra cate con
function print_cate_cou($iParent = 0,$type = 0){
   global	$base_url;
   if($type == 1){
      $var_path_img =  '/pictures/categories/';
      $db_skcate = new db_query('SELECT cat_id,cat_name,cat_picture FROM categories_multi WHERE cat_parent_id = '.$iParent.' AND cat_active = 1 ORDER BY cat_order ASC');
      $num = mysqli_num_rows($db_skcate->result);
      $c = 0;
      while($row_skcate = mysqli_fetch_assoc($db_skcate->result)){
         $c++;
         if($c == 1 || ($c - 1)%3 == 0){
            if($c == 1) echo '<div class="item active">';
            else echo '<div class="item">';
         }
         echo '<div class="course_right_block">';
         echo    '<div class="course_right_block_content show_first">';
         //echo       '<img src="'.$var_path_img.$row_skcate["cat_picture"].'"/>';
         echo        '<img src="/themes_v2/images/course_thumb.jpg"/>';
         echo        '<span class="title">'.$row_skcate["cat_name"].'</span>';
         echo    '</div>';
         echo    '<div class="course_right_block_list show_hover">';
         echo       '<div class="course_right_block_content">';
         echo          '<span class="course_right_block_title">'.$row_skcate['cat_name'].'</span>';
         echo          '<ul class="scroll-pane">';
                        $db_cou = new db_query('SELECT cou_id,cou_name,cou_form FROM courses WHERE cou_cat_id = '.$row_skcate['cat_id'].' AND cou_active = 1 ORDER BY cou_name ASC');
                        while($row_cou = mysqli_fetch_assoc($db_cou->result)){
                           $cou_form = $row_cou['cou_form'];
                           $cou_df = "";
                           if($cou_form == 3){ $cou_df = "strategy"; }  else{ $cou_df = "main";}
                           $sqlFirstUnit = new db_query("SELECT com_id,com_name FROM courses_multi WHERE com_num_unit = 1 AND com_cou_id = ".$row_cou['cou_id']);
                           if($row_uFirst = mysqli_fetch_assoc($sqlFirstUnit->result)){ $first_unit = $row_uFirst['com_id'];$u_name = $row_uFirst['com_name']; }unset($sqlFirstUnit);
                           echo '<li><a href="'.generate_lesson_detail_v2($cou_df,$row_cou['cou_id'],$first_unit,$u_name).'">'.$row_cou['cou_name'].'</a></li>';
                        }unset($db_cou); unset($row_cou);
         echo           '</ul>';
         echo       '</div>';
         echo     '</div>';
         echo  '</div>';
         if(($c%3 == 0) && ($c < $num)) echo '</div>';
         elseif($c == $num) echo '</div>';
      }unset($db_skcate);
   }elseif($type == 2){
      $var_path_img = '/themes_v2/images/';
      $db_skcate = new db_query('SELECT cat_id,cat_name,cat_picture FROM categories_multi WHERE cat_parent_id = 0 AND cat_active = 1 AND cat_type = 0 ORDER BY cat_order ASC');
      $num = mysqli_num_rows($db_skcate->result);
      $c = 0;
      while($row_skcate = mysqli_fetch_assoc($db_skcate->result)){
         $c++;
         if($c == 1 || ($c - 1)%3 == 0){
            if($c == 1) echo '<div class="item active">';
            else echo '<div class="item">';
         }
         echo '<div class="course_right_block">';
         echo    '<div class="course_right_block_content show_first">';
         //echo       '<img src="'.$var_path_img.'course_thumb.jpg"/>';
         echo        '<img src="/themes_v2/images/course_thumb.jpg"/>';
         echo        '<span class="title">'.$row_skcate["cat_name"].'</span>';
         echo    '</div>';
         echo    '<div class="course_right_block_list show_hover">';
         echo       '<div class="course_right_block_content">';
         echo          '<span class="course_right_block_title">'.$row_skcate['cat_name'].'</span>';
         echo          '<ul class="scroll-pane">';
                        $db_cate = new db_query('SELECT cat_id,cat_name FROM categories_multi WHERE cat_parent_id = '.$row_skcate['cat_id']);
                        while($row_cate = mysqli_fetch_assoc($db_cate->result)){
                           echo '<li><a class="skill_cate" id="'.$row_cate['cat_id'].'">'.$row_cate['cat_name'].'</a></li>';
                        }unset($db_cate); unset($row_cate);
         echo           '</ul>';
         echo       '</div>';
         echo     '</div>';
         echo  '</div>';
         if(($c%3 == 0) && ($c < $num)) echo '</div>';
         elseif($c == $num) echo '</div>';
      }unset($db_skcate);
   }
}

/*
 * 2013 05 31 - Duong - function tạo course list & lib list
 */
/*
function gen_home_block1_course_v2($iCourse){
	global $var_path_img,$base_url;

	$db_query = new db_query("SELECT * FROM categories_multi WHERE cat_id = ".$iCourse." AND cat_active = 1");
	$result = mysqli_fetch_assoc($db_query->result);

	if($iCourse == 0){
		$title = "Tiếng Anh trẻ em";
		$description = "";
		$url = 'http://'.$base_url."/kids";
	} else {
		$title = $result['cat_name'];
		$description = $result['cat_description'];
		$url = gen_course_cate_v2($iCourse, $title);
	}

	$return = '';
	$return .= '<div class="course_block">';
	$return .= '<div class="course_block_left" style="background:url(\''.$var_path_img.'home/course_'.$iCourse.'.jpg\') no-repeat">';
	$return .= '<a href="'.$url.'"></a>';
	$return .= '</div>';
	$return .= '<div class="course_block_right">';
	$return .= '<div class="course_block_title"><a href="'.$url.'">'.$title.'</a></div>';
	$return .= $description;
	$return .= '</div>';
	$return .= '<div class="clearfix"></div>';
	$return .= '</div><!--end a course block-->';

	return $return;
}
*/
/*2013 06 08 - Duong - New Block Generator for homepage*/
function gen_home_course_block_1_v2($iCourse){
	global $var_path_img,$base_url;
   $myuser = new user();
   $u_id = $myuser->u_id;

	$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_id = '.$iCourse.' AND cat_active = 1');
	$result = mysqli_fetch_assoc($db_query->result);
	unset($db_query);

	if($iCourse == 0){
		$title = "Tiếng Anh trẻ em";
		$description = "";
		$url = 'http://'.$base_url."/kids";
	} else {
		$title = $result['cat_name'];
		$description = $result['cat_description'];
		$url = gen_course_cate_v3($iCourse);
	}

	//query child courses

	/*
	$courses_array = array();
	$db_query = new db_query('SELECT DISTINCT(cou_lev_id) FROM courses ORDER BY cou_lev_id ASC');
	while($result = mysqli_fetch_assoc($db_query->result)){
		$db_query2 = new db_query('SELECT * FROM levels WHERE lev_id = '.$result['cou_lev_id']);
		$result2 = mysqli_fetch_assoc($db_query2->result);
		array_push($courses_array,$result2);
		unset($db_query2);
	}
	unset($db_query);
	*/
	$courses_array = array();
	$db_query = new db_query("SELECT * FROM categories_multi WHERE cat_parent_id = ".$iCourse." AND cat_active = 1");
	while($db_result = mysqli_fetch_assoc($db_query->result)){
      if(check_userdemo($u_id) == 1){
         if($db_result['cat_id'] != 135 && $db_result['cat_id'] != 143 && $db_result['cat_id'] != 139){
		      array_push($courses_array,$db_result);
         }
      }else{
         array_push($courses_array,$db_result);
      }
	}
	unset($db_result);
	unset($db_query);

	$return ='';
	$return.='<div class="home-block-item">';
		$return.='<a href="'.$url.'" title="'.$title.'">';
			$return.='<div class="home-block-item-img" style="background-image:url(\''.$var_path_img.'home/course_'.$iCourse.'.jpg\')"></div>';
			$return.='<h2 class="home-block-item-title">'.$title.'</h2>';
		$return.='</a>';
		//$return.='<p>'.$description.'</p>';
		$return.='<ul class="unstyled">';
      /*
			foreach($courses_array as $course){
				$return.='<li><span class="icon icon-list-play"></span><h3><a href="'.gen_course_cate_v3($course['cat_id']).'" title="'.$course['cat_name'].'">Trình độ '.$course['cat_name'].'</a></h3></li>';
			}
      */
      $db_cou = new db_query("SELECT cou_id,cou_name,cou_info FROM courses INNER JOIN categories_multi ON cou_cat_id = cat_id WHERE cat_parent_id = ".$iCourse." ORDER BY cou_time DESC LIMIT 4");
      $i = 0;
      while($row_cou = mysqli_fetch_assoc($db_cou->result)){
         $i++;
         $db_com = new db_query("SELECT com_id FROM courses_multi WHERE com_cou_id = ".$row_cou['cou_id']." AND com_num_unit = 1");
         $row_com = mysqli_fetch_assoc($db_com->result);
         unset($db_com);
         if($i == 1){
            $return.='<li><span class="icon icon-list-play"></span><h3><a href="'.gen_course_les_v3($row_com['com_id']).'" title="'.removeHTML($row_cou['cou_info']).'">'.$row_cou['cou_name'].'</a> <sup style="color: #ff0000; font-weight: bold; font-size: 10px;">NEW</sup></h3></li>';
         }else{
            $return.='<li><span class="icon icon-list-play"></span><h3><a href="'.gen_course_les_v3($row_com['com_id']).'" title="'.removeHTML($row_cou['cou_info']).'">'.$row_cou['cou_name'].'</a></h3></li>';
         }

      }unset($db_cou);
		$return.='</ul>';

	$return.='</div>';

	return $return;
}

function gen_home_course_block_2_v2($iCourse,$logged,$act){
	global $var_path_img,$base_url;

	$return ='';
	$return.='<div class="home-block-item">';
	$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_id = '.$iCourse.' AND cat_active = 1');
	$result = mysqli_fetch_assoc($db_query->result);
		$return.='<a href="'.gen_course_cate_v3($iCourse).'" title="'.$result['cat_name'].'"><h2 class="home-block-item-img" style="background-image:url(\''.$var_path_img.'home/test_'.$iCourse.'.jpg\')"></h2></a>';
	unset($db_query);
	unset($result);
		$return.='<ul class="unstyled home-block-item-list">';

			$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$iCourse.' AND cat_active = 1 ORDER BY cat_view DESC');
			while($result = mysqli_fetch_assoc($db_query->result)){
				if($result['cat_view']==2){	//link phần thi thử
					$return.='<li style="position:relative">';
					$return.='<div class="pull-right">';
					switch($iCourse){
						case 27:
							$test_table = 'toeic';
							$prefix = 'toeic';
							$url_prefix = '/toeic/toeic_listening.php?test_id=';
							break;
						case 28:
							$test_table = 'ielts';
							$prefix = 'ielt';
							$url_prefix = '/ielts/direction_first.php?test_id=';
							break;
						case 4:
							$test_table = 'test';
							$prefix = 'test';
							$url_prefix = '/toefl/direction_first.php?test_id=';
							break;
					}
					//manipulate
					$db_query2 = new db_query("SELECT * FROM ".$test_table." LIMIT 0,4");
					$i=0;
					while($result2 = mysqli_fetch_assoc($db_query2->result)){
						$i++;
                  if(($logged == 1) && ($act == 1)){
                     $return.='<a target="_blank" class="bg_cyan white" href="'.$url_prefix.$result2[$prefix.'_id'].'">'.$i.'</a>';
                  }else{
                     if($i > 1) $return.='<a class="bg_cyan white disable_exam">'.$i.'</a>';
                     else $return.='<a target="_blank" class="bg_cyan white" href="'.$url_prefix.$result2[$prefix.'_id'].'">'.$i.'</a>';
                  }
					}
					unset($result2);
					unset($db_query2);


						$return.='<a class="bg_cyan white" href="'.gen_course_cate_v3($result['cat_id']).'" title="'.$result['cat_name'].'">...</a>';
					/* 4-TOEFL
						27-TOEIC
						28-IELTS */
					//$db_query2 = new db_query("SELECT * FROM ");
					//$result2 =
					$return.='</div>';
					$return.='<h3>';
					$return.='<a href="'.gen_course_cate_v3($result['cat_id']).'" title="'.$result['cat_name'].'">'.$result['cat_name'];
					$return.='</a>';
					$return.='</h3>';
					$return.='</li>';
				} else {		//link phần luyện thi
					$return.='<li>';
						$return.='<h3><a href="'.gen_course_cate_v3($result['cat_id']).'" title="'.$result['cat_name'].'">'.$result['cat_name'].'</a></h3>';
						$return.='<ul class="unstyled">';
						$db_query2 = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$result['cat_id'].' AND cat_active = 1');
						while($result2 = mysqli_fetch_assoc($db_query2->result)){
							$return.='<li><h3><a href="'.gen_course_cate_v3($result2['cat_id']).'" title="'.$result2['cat_name'].'">'.$result2['cat_name'].'</a></h3></li>';
						}
						unset($db_query2);
						$return.='</ul>';
					$return.='</li>';
				}
			}
			unset($db_query);
         if($iCourse == 4){
            $return .= '<li>';
            $return .= '<h3></h3>';
            $return .= '</li>';

            $return .= '<li>';
            $return .= '<h3></h3>';
            $return .= '</li>';
         }

		$return.='</ul>';
	$return.='</div>';

	return $return;
}

function gen_home_course_block_3_v2($iCourse){
	global $var_path_img,$base_url;

	$return ='';
	$name_parent =
	Cate($iCourse);
	//giới thiệu section - temporarily fixed
	$return.='<div class="home-block-item">';
		$return.='<div class="home-block-item-img" style="background:url(\''.$var_path_img.'home/course_37_1.jpg\')"></div>';
		$return.='<h2 class="home-block-item-title">Giới thiệu</h2>';
		$return.='<p>Tiếng Anh phổ thông là phần dành cho các học sinh cấp II & cấp III</p>';
	$return.='</div>';

	$cat_array = array();
	$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$iCourse.' AND cat_active = 1');
	while($result = mysqli_fetch_assoc($db_query->result)){
		array_push($cat_array,$result);
	}
	unset($result);
	unset($db_query);

	$i=2;
	foreach($cat_array as $cat){
		$return.='<div class="home-block-item">';
			$return.='<a href="'.gen_course_cate_v3($cat['cat_id']).'" title="'.$cat['cat_name'].'">';
				$return.='<div class="home-block-item-img" style="background:url(\''.$var_path_img.'home/course_37_'.$i.'.jpg\')"></div>';
				$return.='<h2 class="home-block-item-title">'.$cat['cat_name'].'</h2>';
			$return.='</a>';
			$return.='<ul class="home-block-item-list unstyled">';

			$db_query = new db_query('SELECT * FROM courses WHERE cou_cat_id = '.$cat['cat_id'].' AND cou_active = 1 ORDER BY cou_name ASC');
         $name_cate = $name_parent.'-'.$cat['cat_name'];
			while($result = mysqli_fetch_assoc($db_query->result)){
				$db_query2 = new db_query('SELECT * FROM courses_multi WHERE com_cou_id = '.$result['cou_id'].' AND com_active = 1');
				$result2 = mysqli_fetch_assoc($db_query2->result);
				unset($db_query2);
				$return.='<li><h3><a href="'.gen_course_les_v3($result2['com_id']).'" title="'.$result['cou_name'].'">'.$result['cou_name'].'</a></h3></li>';
			}
			$return.='</ul>';
		$return.='</div>';
		$i++;
	}

	return $return;
}

function gen_home_course_block_4_v2($iCourse){
	//tiếng Anh trẻ em
	/*
	 *
	 * <div class="course_block">
				<h2 class="bold"><a href="http://<?=$base_url?>/kids/#screenType=1&id=1" title="Superstar Kids 1">Superstar Kids 1</a></h2>
				<ul class="unstyled">
					<li><span class="icon icon-three-lines"></span><h3><a href="http://<?=$base_url?>/kids/#screenType=2&id=1&planetId=1&order=1&titleText=Unit+1%3A+ABC+alphabet" title="Unit 1: ABC Alphabet">Unit 1: ABC Alphabet</a></h3></li>
					<li><span class="icon icon-three-lines"></span><h3><a href="http://<?=$base_url?>/kids/#screenType=2&id=2&planetId=1&order=2&titleText=Unit+2%3A+Number" title="Unit 2: Number">Unit 2: Number</a></h3></li>
					<li><span class="icon icon-three-lines"></span><h3><a href="http://<?=$base_url?>/kids/#screenType=2&id=3&planetId=1&order=3&titleText=Unit+3%3A+Greeting" title="Tiếng Anh trẻ em">Unit 3: Greeting</a></h3></li>
					<li><span class="icon icon-three-lines"></span><h3><a href="http://<?=$base_url?>/kids/#screenType=2&id=4&planetId=1&order=4&titleText=Unit+4%3A+Days+of+the+week" title="Tiếng Anh trẻ em">Unit 4: Days of the week</a></h3></li>
				</ul>
				<a class="pull-left" style="margin-left:12px" href="http://<?=$base_url?>/kids/#screenType=1&id=1" title="Superstar Kids 1">Xem thêm...</a>
			</div>
			<div class="course_block">
				<h2 class="bold"><a href="http://<?=$base_url?>/kids/#screenType=1&id=2" title="Superstar Kids 2">Superstar Kids 2</a></h2>
				<ul class="unstyled">
					<li><span class="icon icon-three-lines"></span><h3><a href="http://<?=$base_url?>/kids/#screenType=2&id=23&planetId=2&order=1&titleText=Unit+1%3A+Parts+of+body" title="Tiếng Anh trẻ em">Unit 1: Parts of Body</a></h3></li>
					<li><span class="icon icon-three-lines"></span><h3><a href="http://<?=$base_url?>/kids/#screenType=2&id=24&planetId=2&order=2&titleText=Unit+2%3A+Clothes" title="Tiếng Anh trẻ em">Unit 2: Clothes</a></h3></li>
					<li><span class="icon icon-three-lines"></span><h3><a href="http://<?=$base_url?>/kids/#screenType=2&id=29&planetId=2&order=3&titleText=Unit+3%3A+Food" title="Tiếng Anh trẻ em">Unit 3: Foot</a></h3></li>
					<li><span class="icon icon-three-lines"></span><h3><a href="http://<?=$base_url?>/kids/#screenType=2&id=37&planetId=2&order=4&titleText=Unit+4%3A+Drinks" title="Tiếng Anh trẻ em">Unit 4: Drink</a></h3></li>
				</ul>
				<a class="pull-left" style="margin-left:12px" href="http://<?=$base_url?>/kids/#screenType=1&id=2" title="Superstar Kids 2">Xem thêm...</a>
			</div>
	 */
	 global $base_url;

	 $return ='';
	 $db_query = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$iCourse.' AND cat_active = 1');
	 while($db_result = mysqli_fetch_assoc($db_query->result)){
		$return.='<div class="course_block">';
			$return.='<h2 class="bold"><a href="'.gen_course_cate_v3($db_result['cat_id']).'" title="'.$db_result['cat_name'].'">'.$db_result['cat_name'].'</a></h2>';
			$return.='<ul class="unstyled">';
				$db_query2 = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$db_result['cat_id'].' AND cat_active = 1');
				while($db_result2 = mysqli_fetch_assoc($db_query2->result)){
					$return.='<li><span class="icon icon-three-lines"></span><h3><a href="'.gen_course_cate_v3($db_result2['cat_id']).'" title="'.$db_result2['cat_name'].'">'.$db_result2['cat_name'].'</a></h3></li>';
				}
				unset($db_result2);
				unset($db_query2);
			$return.='</ul>';
			$return.='<a class="pull-left" style="margin-left:12px" href="'.gen_course_cate_v3($db_result['cat_id']).'" title="'.$db_result['cat_name'].'">Xem thêm...</a>';
		$return.='</div>';
	 }
	 unset($db_result);
	 unset($db_query);

	 return $return;
}

function gen_home_course_block_5_v2($iCourse){
	global $var_path_img,$base_url;

	$return ='';
	$nparent = nameCate($iCourse);
	$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$iCourse.' AND cat_active = 1');
	while($result = mysqli_fetch_assoc($db_query->result)){
		$return.='<div class="home-block-item bg_gray2">';

		$return.='<a href="'.gen_sk_cate_v2($result['cat_id'],$result['cat_name']).'" title="'.$result['cat_name'].'">';
		$return.='<h2 class="home-block-item-img pull-left" style="background-image:url(\''.$var_path_img.'home/course_'.$result['cat_id'].'.jpg\')"></h2>';
		$return.='<h2 class="home-block-item-title">'.$result['cat_name'].'</h2>';
		$return.='</a>';

		$return.='<ul class="unstyled">';
		$db_query2 = new db_query('SELECT * FROM skill_lesson WHERE skl_les_cat_id = '.$result['cat_id'].' AND skl_les_active = 1 ORDER BY skl_les_time DESC LIMIT 0,3');
		while($result2 = mysqli_fetch_assoc($db_query2->result)){
			$return.='<li><h3><a href="'.gen_sk_les_v2($result['cat_name'],$result2['skl_les_id'],$result2['skl_les_name']).'" title="'.$result2['skl_les_name'].'">'.$result2['skl_les_name'].'</a></h3></li>';
		}
		$return.='</ul>';
		$return.='<a href="'.gen_sk_cate_v2($result['cat_id'],$result['cat_name']).'" title="'.$result['cat_name'].'">Xem thêm...</a>';
		$return.='<div class="clearfix"></div>';

		$return.='</div>';
	}

	return $return;
}

function gen_home_course_block_6_v2($iCourse){
	//từ vựng
	global $var_path_img,$base_url;

	$return ='';

	$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_id = '.$iCourse.' AND cat_active = 1');
	$result = mysqli_fetch_assoc($db_query->result);

	$return.='<div class="home-block-item">';
		$return.='<a href="'.gen_course_cate_v3($result['cat_id']).'" title="'.$result['cat_name'].'">';
		$return.='<h2 class="home-block-item-img" style="background-image:url(\''.$var_path_img.'home/course_'.$iCourse.'.jpg\')"></h2>';
		$return.='</a>';
		$return.='<ul class="unstyled">';
		$db_query2 = new db_query('SELECT cou_id,cou_name,cou_info,cou_time FROM courses INNER JOIN categories_multi ON cat_id = cou_cat_id WHERE cat_parent_id = '.$iCourse.' AND cou_active = 1 ORDER BY cou_time DESC LIMIT 0,4');
		while($db_result2 = mysqli_fetch_assoc($db_query2->result)){
         $db_com = new db_query("SELECT com_id FROM courses_multi WHERE com_cou_id = ".$db_result2['cou_id']." AND com_num_unit = 1");
         $row_com = mysqli_fetch_assoc($db_com->result);
         unset($db_com);
			$return.='<li><span class="icon icon-list-play"></span><a style="margin-left:20px" href="'.gen_course_les_v3($row_com['com_id']).'" title="'.removeHTML($db_result2['cou_info']).'">'.$db_result2['cou_name'].'</a></li>';
		}
		unset($db_result2);
		unset($db_query2);

		$return.='</ul>';
		$return.='<a style="margin-left:20px" href="'.gen_course_cate_v3($result['cat_id']).'" title="'.$result['cat_name'].'">Xem thêm</a>';
	$return.='</div>';

	return $return;
}

function gen_home_course_block_7_v2($iCourse){
	global $var_path_img,$base_url,$var_path_skill;

	$return ='';
	$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$iCourse.' AND cat_active = 1');
	while($result = mysqli_fetch_assoc($db_query->result)){
		$return.='<div class="home-block-item">';
		$return.='<a href="'.gen_sk_cate_v2($result['cat_id'], $result['cat_name']).'" title="'.$result['cat_name'].'">';
			$return.='<div class="home-block-item-left bg_green">';
				$return.='<h2 class="home-block-item-left-text">'.str_replace("Luyện Nói ","",$result['cat_name']).'</h2>';
				$return.='<div class="home-block-item-left-icon" style="background:url(\''.$var_path_img.'/home/course_'.$result['cat_id'].'.png\') no-repeat top center"></div>';
			$return.='</div>';
		$return.='</a>';
		$return.='<div class="home-block-item-right">';
		$db_query2 = new db_query('SELECT * FROM skill_lesson WHERE skl_les_cat_id = '.$result['cat_id'].' AND skl_les_active = 1 ORDER BY skl_les_id ASC LIMIT 0,4');
		while($result2 = mysqli_fetch_assoc($db_query2->result)){
			$return.='<a href="'.gen_sk_les_v2($result['cat_name'],$result2['skl_les_id'], $result2['skl_les_name']).'" title="'.$result2['skl_les_name'].'">';
				$return.='<div class="item">';
				$return.='<div class="item-background" style="background-image:url(\'http://'.$base_url.$var_path_skill.'small_'.$result2['skl_les_img'].'\')"></div>';
				$return.='<div class="item-caption">'.$result2['skl_les_name'].'</div>';
				$return.='</div>';
			$return.='</a>';
		}
		unset($result2);
		unset($db_query2);

		$return.='<a href="'.gen_sk_cate_v2($result['cat_id'], $result['cat_name']).'" title="'.$result['cat_name'].'">';
			$return.='<div class="item-more">';
				$db_count = new db_count('SELECT count(*) AS count FROM skill_lesson WHERE skl_les_cat_id = '.$result['cat_id'].' AND skl_les_active = 1');
				$count = $db_count->total;
				$return.='<div class="item-more-symbol">&middot;&middot;&middot;</div>';
				$return.='<div class="item-more-text">'.$count.' bài</div>';
			$return.='</div>';
		$return.='</a>';
		$return.='</div>';
		$return.='<div class="clearfix"></div>';

		$return.='</div>';
	}

	return $return;
}

function gen_home_course_block_11_v2($iCourse){
	global $var_path_img,$base_url,$var_path_skill;

	$return = '';
	//get children
	$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$iCourse.' AND cat_active = 1');
	while($result = mysqli_fetch_assoc($db_query->result)){
		$return.='<div class="home-block-item">';
			$return.='<a href="'.gen_sk_cate_v2($result['cat_id'], $result['cat_name']).'"><div class="home-block-item-title bg_cyan white" style="background-image:url(\'/themes_v2/images/home/course_'.$result['cat_id'].'_small.png\')">'.str_replace("Luyện Nghe ","",str_replace("Luyện Nói ","",$result['cat_name'])).'</div></a>';

			//get posts
			$db_query2 = new db_query('SELECT * FROM skill_lesson WHERE skl_les_cat_id = '.$result['cat_id'].' AND skl_les_active = 1 ORDER BY skl_les_time DESC LIMIT 0,4');
			$i = 0;
			while($result2 = mysqli_fetch_assoc($db_query2->result)){
				$i++;
				if($i==1){
					$return.='<a href="'.gen_sk_les_v2($result['cat_name'],$result2['skl_les_id'], $result2['skl_les_name']).'" title="'.$result2['skl_les_name'].'"><div class="home-block-item-first">';
						$return.='<div class="home-block-item-first-background" style="background-image:url(\'http://'.$base_url.$var_path_skill.'small_'.$result2['skl_les_img'].'\')"></div>';
						$return.='<div class="home-block-item-first-caption">';
							$return.='<span class="cyan">'.date("d/m/Y",$result2['skl_les_time']).'</span>';
							$return.=' - <span class="white">'.truncateString_($result2['skl_les_name'],45).'</span>';
						$return.='</div>';
					$return.='</div></a>';
				} else {
					if($i==2){$return.='<ul class="home-block-item-list unstyled">';}

					$return.='<li><a class="black" href="'.gen_sk_les_v2($result['cat_name'],$result2['skl_les_id'], $result2['skl_les_name']).'" title="'.$result2['skl_les_name'].'"><span class="cyan">'.date("d/m/Y",$result2['skl_les_time']).'</span> - '.truncateString_($result2['skl_les_name'],30).'</a></li>';

					if($i==4){$return.='</ul>';}
				}
			}

			$return.='<a class="home-block-item-more cyan" href="'.gen_sk_cate_v2($result['cat_id'], $result['cat_name']).'">Xem thêm »</a>';


		$return.='</div>';
	}

	return $return;
}

function gen_home_course_block_8_v2($iCourse){
	global $var_path_img,$base_url,$var_path_skill;
	$return ='';

	$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_id = '.$iCourse.' AND cat_active = 1');
	$result = mysqli_fetch_assoc($db_query->result);

	$return.='<div class="home-block-left">';
		$return.='<a href="'.gen_sk_cate_v2($result['cat_id'], $result['cat_name']).'" title="'.$result['cat_name'].'">';
			$return.='<img src="'.$var_path_img.'/home/course_'.$iCourse.'.jpg" alt="'.$result['cat_name'].'" />';
		$return.='</a>';
	$return.='</div>';
	$return.='<div class="home-block-right">';
		$return.='<ul class="unstyled">';
		$db_query2 = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$iCourse.' AND cat_active = 1');
		while($result2 = mysqli_fetch_assoc($db_query2->result)){
			$return.='<li>';
				//count
				$db_count = new db_count('SELECT count(*) AS count FROM skill_lesson WHERE skl_les_cat_id = '.$result2['cat_id'].' AND skl_les_active = 1');
				$count = $db_count->total;
				$return.='<a href="'.gen_sk_cate_v2($result2['cat_id'],$result2['cat_name']).'" title="'.$result2['cat_name'].'">';
					$return.='<div class="pull-right">'.$count.' bài <span class="icon icon-greater"></span></div>';
				$return.='</a>';

				$return.='<a href="'.gen_sk_cate_v2($result2['cat_id'],$result2['cat_name']).'" title="'.$result2['cat_name'].'">';
					$return.='<h2 class="item-title">'.$result2['cat_name'].'</h2>';
				$return.='</a>';
				//query last 2 posts
				$return.='<div class="item-child-posts">';
				$db_query3 = new db_query('SELECT * FROM skill_lesson WHERE skl_les_cat_id = '.$result2['cat_id'].' AND skl_les_active = 1 ORDER BY skl_les_time DESC LIMIT 0,2');
				while($result3 = mysqli_fetch_assoc($db_query3->result)){
					$return2 =' | <a href="'.gen_sk_les_v2($result2['cat_name'],$result3['skl_les_id'], $result3['skl_les_name']).'"><span class="cyan">'.date("d/m/Y",$result3['skl_les_time']).'</span> - '.$result3['skl_les_name'].'</a>';
				}
				$return.=truncateString_(substr($return2,2),320);
				$return2 = '';
				$return.='</div>';
			$return.='</li>';
		}

		$return.='</ul>';
	$return.='</div>';
	$return.='<div class="clearfix"></div>';

	return $return;
}

function gen_home_course_block_9_v2($iCourse){
	global $var_path_img;
	$return ='';
	$nparent = nameCate($iCourse);
	$db_query = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$iCourse.' AND cat_active = 1');
		while($result = mysqli_fetch_assoc($db_query->result)){
			$return.='<div class="home-block-item">';
			$return.='<a href="'.gen_sk_cate_v2($result['cat_id'],$result['cat_name']).'" title="'.$result['cat_name'].'">';
				$return.='<h2 class="home-block-item-title bold">'.$result['cat_name'].'</h2>';
				$return.='<div class="home-block-item-left">';
				$return.='<img src="'.$var_path_img.'home/course_'.$result['cat_id'].'.jpg" alt="'.$result['cat_name'].'" />';
				$return.='</div>';
			$return.='</a>';
			$return.='<div class="home-block-item-right">';
				$return.='<ul class="unstyled">';
				$db_query2 = new db_query('SELECT * FROM skill_lesson WHERE skl_les_cat_id = '.$result['cat_id'].' AND skl_les_active = 1 LIMIT 0,3');
				while($result2 = mysqli_fetch_assoc($db_query2->result)){
					$return.='<li><div class="icon icon-list-play"></div><h3><a href="'.gen_sk_les_v2($result['cat_name'],$result2['skl_les_id'],$result2['skl_les_name']).'" title="'.$result2['skl_les_name'].'">'.substr($result2['skl_les_name'],0,35).((strlen($result2['skl_les_name'])>35)?'...':'').'</a></h3></li>';
				}
				$return.='</ul>';

				$db_count = new db_count('SELECT count(*) AS count FROM skill_lesson WHERE skl_les_cat_id = '.$result['cat_id'].' AND skl_les_active = 1');
				$count = $db_count->total;
				$return.='<span style="margin-left:16px">Xem thêm <a href="'.gen_sk_cate_v2($result['cat_id'],$result['cat_name']).'" title="'.$result['cat_name'].'">'.$count.' bài khác</a></span>';
			$return.='</div>';
		$return.='</div>';
		}
		$return.='<div class="clearfix"></div>';

	return $return;
}

function gen_home_course_block_10_v2($lib_cat_type,$color){
	global $var_path_img;

	$title = '';
	$slug = '';
	$url = '';

	$return ='';

	switch($lib_cat_type){
		case 1:
			$title = 'Trò chơi tiếng Anh';
			$slug = 'game';
			break;
		case 2: $title = 'Truyện tiếng Anh';
			$slug = 'story';
			break;
		case 3: $title = 'Bài hát tiếng Anh';
			$slug = 'song';
			break;
		case 4: $title = 'Video tiếng Anh';
			$slug = 'video';
			break;
	}

	$return.='<div class="home-block-item">';
		$return.='<div class="home-block-item-img" style="background-image:url(\''.$var_path_img.'home/thu_vien_'.$lib_cat_type.'.jpg\')">';
			$return.='<a href="'.gen_lib_cat_v2(-$lib_cat_type, $slug).'" title="'.$title.'">';
				$return.='<div class="home-block-item-icon bg_'.$color.'" style="background-image:url(\''.$var_path_img.'home/thu_vien_icon_'.$lib_cat_type.'.png\')"></div>';
			$return.='</a>';
			$return.='<ul class="home-block-item-list unstyled">';
			$db_query = new db_query("SELECT * FROM library_".$slug." ORDER BY lib_".$slug."_count_view DESC LIMIT 0,5");
			while($result = mysqli_fetch_assoc($db_query->result)){
				$return.='<li><a href="'.gen_lib_post_v2($lib_cat_type, $result['lib_'.$slug.'_id'], $result['lib_'.$slug.'_title']).'">'.truncateString_($result['lib_'.$slug.'_title'],20).' - '.$result['lib_'.$slug.'_count_view'].' <i class="icon-white icon-eye-open"></i></a></li>';
			}
			$return.='<a href="'.gen_lib_cat_v2(-$lib_cat_type, $slug).'" title="'.$title.'">Xem thêm »</a>';

			$return.='</ul>';
		$return.='</div>';
		$return.='<h2 class="home-block-item-title"><a href="'.gen_lib_cat_v2(-$lib_cat_type, $slug).'" title="'.$title.'">'.$title.'</a></h2>';
	$return.='</div>';


	$return.='';
	$return.='';

	return $return;
}


function gen_lib_cat_list_v2($lib_cat_type){
	$return = array();

	$db_query = new db_query("SELECT lib_cat_id,lib_cat_name,lib_cat_description,lib_cat_picture FROM library_cate WHERE lib_cat_type = ".$lib_cat_type." AND lib_cat_parent_id = 0 AND lib_cat_active = 1");
	while($result = mysqli_fetch_assoc($db_query->result)):
		array_push(	$return,array(	'id'	=> $result['lib_cat_id'],
											'name'=> $result['lib_cat_name'],
											'desc'=> $result['lib_cat_description'],
											'img'	=> $result['lib_cat_picture'])
					 );
	endwhile;
	unset($db_query);

	return $return;

}

function gen_lib_cat_block_v2($lib_cat_type,$color){
	global $var_path_library,$var_path_img ;

	$return = '';

	$title = '';
	$slug = '';
	$url = '';

	switch($lib_cat_type){
		case 1:
			$title = 'Game';
			$slug = 'game';
			break;
		case 2: $title = 'Truyện';
			$slug = 'story';
			break;
		case 3: $title = 'Bài hát';
			$slug = 'song';
			break;
		case 4: $title = 'Video';
			$slug = 'video';
			break;
	}

	$return .='<div class="list-line" id="list-line'.$lib_cat_type.'">';
		$return .='<div class="list-line-left" style="background:url(\''.$var_path_img.'library/lib_icon_'.$lib_cat_type.'.jpg\') no-repeat">';
			$return .='<div class="list-line-left-text">'.$title.'</div>';
		$return .='</div>';
		$return .='<div class="list-line-right">';
			$return .='<div class="list-line-right-carousel">';

			$single_titles = gen_lib_cat_list_v2($lib_cat_type);

			foreach($single_titles as $single_title){
				$return .='<div class="item">';
					$return .='<div class="item-info">';
						$return .='<div class="item-image" style="background:url(\'http://hochay.vn/'.$var_path_library.'/medium_'.$single_title['img'].'\') no-repeat center center;background-size:cover"></div>';
						$return .='<div class="item-title">'.$single_title['name'].'</div>';
						$reutrn .='<div class="item-description">'.$single_title['desc'].'</div>';
					$return .='</div>';
					$return .='<div class="item-hover bg_'.$color.'">';
						$return .= '<div class="item-hover-title">'.$single_title['name'].'</div>';
						$return .='<div class="item-hover-button"><a href="'.gen_lib_cat_v2($single_title['id'],$single_title['name']).'">Xem chi tiết</a></div>';
					$return .='</div>';
				$return .='</div>';
			}

			$return .='</div>';
			if(sizeof($single_titles)>3){
				$return .='<a href="#" id="ui-carousel-next" class="next"></a>';
				$return .='<a href="#" id="ui-carousel-prev" class="prev"></a>';
			}
		$return .='</div>';
	$return .='</div>';

	return $return;
}

/*
 * i=0
 * return[0]
 *

/*
 * 2013 06 04 - Duong
 */

//generate library post
function gen_game_post_v2($id){
	global $var_path_library_game,$var_path_library_game_file;

	$return = array(	'type_name'		=> 'Game',
							'slug'		=> 'game',
							'img_path'	=> $var_path_library_game,
							'file_path'	=>	$var_path_library_game_file,
							'files_url' 		=> array());

	//Query
	$sql = 'SELECT library_cate.lib_cat_name,library_game.* FROM library_game INNER JOIN library_cate ON library_game.lib_game_catid = library_cate.lib_cat_id WHERE lib_game_id = '.$id;
	$db_query = new db_query($sql);
	$db_row = mysqli_fetch_assoc($db_query->result);
	unset($db_query);

	//Update the view count
	$sql = 'UPDATE library_game SET lib_game_count_view = lib_game_count_view + 1 WHERE lib_game_id = '.$id;
	$db_update = new db_execute($sql);
	unset($db_update);

	//Others
	$sql = 'SELECT * FROM library_game WHERE lib_game_id <> '.$id.' AND lib_game_catid = '.$db_row['lib_game_catid'].' ORDER BY RAND() LIMIT 10';
	$db_query = new db_query($sql);
	$result_array = $db_query->resultArray();
	unset($db_query);

	$return['result'] = $db_row;
	$return['others'] = $result_array;

	return $return;
}

function gen_story_post_v2($id){
	global $var_path_library_story,$var_path_library_story_file;

	$return = array(	'type_name'		=> 'Truyện',
							'slug'		=> 'story',
							'img_path'	=> $var_path_library_story,
							'file_path'	=> $var_path_library_story_file,
							'files_url' 		=> array());

	//Query
	//Update the view count
	//Others

	//Query
	$sql = 'SELECT library_cate.lib_cat_name,library_story.* FROM library_story INNER JOIN library_cate ON library_story.lib_story_catid = library_cate.lib_cat_id WHERE lib_story_id = '.$id;
	$db_query = new db_query($sql);
	$db_row = mysqli_fetch_assoc($db_query->result);
	unset($db_query);

	//Update the view count
	$sql = 'UPDATE library_story SET lib_story_count_view = lib_story_count_view + 1 WHERE lib_story_id = '.$id;
	$db_update = new db_execute($sql);
	unset($db_update);

	//get the images
	$sql = 'SELECT * FROM images_story WHERE img_story_id = '.$id;
	$db_query = new db_query($sql);
	while($images = mysqli_fetch_assoc($db_query->result)){
		array_push($return['files_url'],$images['img_url']);
	}
	unset($db_query);

	//Others
	$sql = 'SELECT * FROM library_story WHERE lib_story_id <> '.$id.' AND lib_story_catid = '.$db_row['lib_story_catid'].' ORDER BY lib_story_id DESC LIMIT 10';
	$db_query = new db_query($sql);
	$result_array = $db_query->resultArray();
	unset($db_query);

	$return['result'] = $db_row;
	$return['others'] = $result_array;

	return $return;
}

function gen_song_post_v2($id){
	global $var_path_library_song,$var_path_library_song_file;

	$return = array(	'type_name'	=> 'Bài hát',
							'slug'		=> 'song',
							'img_path'	=> $var_path_library_song,
							'file_path'	=> $var_path_library_song_file,
							'files_url' 		=> array());

	//Query
	$sql = 'SELECT library_cate.lib_cat_name,library_'.$return['slug'].'.* FROM library_'.$return['slug'].' INNER JOIN library_cate ON library_'.$return['slug'].'.lib_'.$return['slug'].'_catid = library_cate.lib_cat_id WHERE lib_'.$return['slug'].'_id = '.$id;
	$db_query = new db_query($sql);
	$db_row = mysqli_fetch_assoc($db_query->result);
	unset($db_query);

	//Update the view count
	$sql = 'UPDATE library_'.$return['slug'].' SET lib_'.$return['slug'].'_count_view = lib_'.$return['slug'].'_count_view + 1 WHERE lib_'.$return['slug'].'_id = '.$id;
	$db_update = new db_execute($sql);
	unset($db_update);

	//Others
	$sql = 'SELECT * FROM library_'.$return['slug'].' WHERE lib_'.$return['slug'].'_id <> '.$id.' AND lib_'.$return['slug'].'_catid = '.$db_row['lib_'.$return['slug'].'_catid'].' ORDER BY lib_'.$return['slug'].'_id DESC LIMIT 10';
	$db_query = new db_query($sql);
	$result_array = $db_query->resultArray();
	unset($db_query);

	$return['result'] = $db_row;
	$return['others'] = $result_array;

	return $return;
}

function gen_video_post_v2($id){
	global $var_path_library_video,$var_path_library_video_file;

	$return = array(	'type_name'		=> 'Video',
							'slug'		=> 'video',
							'img_path'	=> $var_path_library_video,
							'file_path'	=> $var_path_library_video_file,
							'files_url' 		=> array());

	//Query
	$sql = 'SELECT library_cate.lib_cat_name,library_'.$return['slug'].'.* FROM library_'.$return['slug'].' INNER JOIN library_cate ON library_'.$return['slug'].'.lib_'.$return['slug'].'_catid = library_cate.lib_cat_id WHERE lib_'.$return['slug'].'_id = '.$id;
	$db_query = new db_query($sql);
	$db_row = mysqli_fetch_assoc($db_query->result);
	unset($db_query);

	//Update the view count
	$sql = 'UPDATE library_'.$return['slug'].' SET lib_'.$return['slug'].'_count_view = lib_'.$return['slug'].'_count_view + 1 WHERE lib_'.$return['slug'].'_id = '.$id;
	$db_update = new db_execute($sql);
	unset($db_update);

	//Others
	$sql = 'SELECT * FROM library_'.$return['slug'].' WHERE lib_'.$return['slug'].'_id <> '.$id.' AND lib_'.$return['slug'].'_catid = '.$db_row['lib_'.$return['slug'].'_catid'].' ORDER BY lib_'.$return['slug'].'_id DESC LIMIT 10';
	$db_query = new db_query($sql);
	$result_array = $db_query->resultArray();
	unset($db_query);

	$return['result'] = $db_row;
	$return['others'] = $result_array;

	return $return;

	return $return;
}
//Ham tra ve mang id cua cac khoa hoc user dang hoc
function get_user_courses($user_id){
   $arr_ucou = array();
   $db = new db_query('SELECT usec_cou_id FROM user_course INNER JOIN courses ON user_course.usec_cou_id = courses.cou_id WHERE usec_use_id = '.$user_id.' AND cou_active = 1 ORDER BY usec_get_time DESC');
   while($row = mysqli_fetch_assoc($db->result)){
      $arr_ucou[] = $row['usec_cou_id'];
   }unset($db);
   return $arr_ucou;
}
function get_user_courses_v2($user_id){
   $arr_ucou = array();
   $db = new db_query('SELECT ucp_cou_id FROM user_courses_pack INNER JOIN courses ON user_courses_pack.ucp_cou_id = courses.cou_id WHERE ucp_use_id = '.$user_id.' AND ucp_status = 1');
   while($row = mysqli_fetch_assoc($db->result)){
      $arr_ucou[] = $row['ucp_cou_id'];
   }unset($db);
   return $arr_ucou;
}
function get_user_courses_view($user_id){
   $arr_ucou = array();
   $db = new db_query('SELECT usec_cou_id FROM user_course INNER JOIN courses ON user_course.usec_cou_id = courses.cou_id WHERE usec_use_id = '.$user_id.' LIMIT 0,8');
   while($row = mysqli_fetch_assoc($db->result)){
      $arr_ucou[] = $row['usec_cou_id'];
   }unset($db);
   return $arr_ucou;
}
function get_user_courses_wish($user_id){
   $arr_ucou = array();
   $db = new db_query('SELECT wishes_object_id FROM wishes INNER JOIN courses ON wishes.wishes_object_id = courses.cou_id WHERE wishes_user_id = '.$user_id.' LIMIT 0,8');
   while($row = mysqli_fetch_assoc($db->result)){
      $arr_ucou[] = $row['wishes_object_id'];
   }unset($db);
   return $arr_ucou;
}
//Ham tra ve mang id cua cac khoa hoc user da hoan thanh
function get_user_fnc($user_id){
   $course_fn = array();
   $db_uc = new db_query('SELECT usec_cou_id,usec_cou_point FROM user_course INNER JOIN courses ON user_course.usec_cou_id = courses.cou_id WHERE usec_use_id = '.$user_id.' AND cou_active = 1 ORDER BY usec_get_time DESC');
   while($row_uc = mysqli_fetch_assoc($db_uc->result)){
      $db_fn = new db_query('SELECT COUNT(com_id) AS num_unit FROM courses_multi WHERE com_cou_id = '.$row_uc['usec_cou_id']);
      $row_fn = mysqli_fetch_assoc($db_fn->result);
      unset($db_fn);
      $sum_point = $row_fn['num_unit']*20;
      if(($row_uc['usec_cou_point'] != 0) && ($sum_point <= $row_uc['usec_cou_point'])){
         $course_fn[] = $row_uc['usec_cou_id'];
      }
   }unset($db_uc);
   return $course_fn;
}
//Ham check tai khoan con su dung khong
function check_act_user($user_id){
   $db_user = new db_query('SELECT use_status_act FROM users WHERE use_id = '.$user_id);
   while($row_user = mysqli_fetch_assoc($db_user->result)){
      $user_status = $row_user['use_status_act'];
   }unset($db_user);
   return $user_status;
}
//Check xem đã làm bài viêt chưa
function check_user_write($u_id,$write_id){
   $count_user_write = 0;
   $base_url            =  $_SERVER['HTTP_HOST'];
   $db_user_write       = new db_query("SELECT count(*) AS count FROM learn_writing_result WHERE lwr_use_id = ".$u_id." AND lwr_wri_id = ".$write_id);
	$row_user_write	   = mysqli_fetch_array($db_user_write->result);
	$count_user_write    = $row_user_write["count"];
   //------------------
   if($count_user_write > 0){
      $count_user_write = 1;
   }
   return $count_user_write;
}
function check_user_speak($u_id,$write_id){
   $count_user_speak    = 0;
   $base_url            =  $_SERVER['HTTP_HOST'];
   $db_user_speak       = new db_query("SELECT count(*) AS count FROM learn_speak_result WHERE lsr_use_id = ".$u_id." AND lsr_spe_id = ".$write_id);
	$row_user_speak	   = mysqli_fetch_array($db_user_speak->result);
	$count_user_speak    = $row_user_speak["count"];
   //------------------
   if($count_user_speak > 0){
      $count_user_speak = 1;
   }
   return $count_user_speak;
}
//Lay ra xau id cua forum con tuong ung trong forum cha
function get_strforum($parent_id){
   $str_id_forum = "";
   switch($parent_id){
      //Thao luan chung
      case 8:
         $str_id_forum = "9,37,40";
         break;
      //Chung chi quoc te
      case 10:
         $str_id_forum = "11,19,20";
         break;
      //Ky nang tieng anh
      case 12:
         $str_id_forum = "21,22,23,24,25";
         break;
      //Kien thuc tieng anh
      case 13:
         $str_id_forum = "26,27,38,39";
         break;
      //Tieng anh tre em
      case 14:
         $str_id_forum = "43";
         break;
      //Tieng anh pho thong
      case 15:
         $str_id_forum = "34,35,36";
         break;
      //Tieng anh chuyen nganh
      case 16:
         $str_id_forum = "28,29,45,46,47,48,49";
         break;
      //Hoc tieng anh qua video
      case 50:
         $str_id_forum = "51";
         break;
   }
   return $str_id_forum;
}
//Lay thong tin SEO cho danh muc phan khoa hoc
function get_meta_courses($id){
   $base_url     = $_SERVER['HTTP_HOST'];
   $iunit = getValue("iunit","int","GET",0);
   $type  = getValue("type","str","GET","");

   $db_unit = new db_query("SELECT * FROM courses_multi WHERE com_id = ".$iunit);
   $row_unit = mysqli_fetch_assoc($db_unit->result);
   unset($db_unit);
   switch($type){
      case 'main':         $name_type = "Bài học chính";    break;
      case 'speak':        $name_type = "Bài nói";          break;
      case 'write':        $name_type = "Bài viết";         break;
      case 'grammar':      $name_type = "Ngữ pháp";         break;
      case 'vocabulary':   $name_type = "Từ vựng";          break;
      case 'quiz':         $name_type = "Luyện tập";        break;
      case 'strategy':     $name_type = "Strategy";         break;
      case 'practice':     $name_type = "Luyện tập";        break;
      default:             $name_type = "";
   }
   $sql          = new db_query("SELECT * FROM courses WHERE cou_id = ".$id);
   $row          = mysqli_fetch_assoc($sql->result);
   unset($sql);
   /*
   $row_unit['title']       == '' ? $title          = $row_unit['com_name'].' - '.$name_type          : $title          = $row_unit['title'].' - '.$name_type;
   $row_unit['description'] == '' ? $description    = $row_unit['com_content'].','.$name_type         : $description    = $row_unit['description'].','.$name_type;
   $row_unit['keywords']    == '' ? $keywords       = $row_unit['com_name'].','.$name_type            : $keywords       = $row_unit['keywords'].','.$name_type;
   */
   $title         =  $row_unit['com_name'].' - '.$name_type;
   $description   =  $row_unit['com_content'];
   $keywords      =  $row['cou_name'].','.$row_unit['com_name'].','.$name_type;

   $arr_meta['image']        = "http://".$base_url."/pictures/courses/small_".$row['cou_image'];
   $arr_meta['title']        = removeHTML(str_replace ('"', ' ', $title));
   $arr_meta['description']  = removeHTML(str_replace ('"', ' ', $description));
   $arr_meta['keywords']     = removeHTML(str_replace ('"', ' ', $keywords));

   return $arr_meta;
}
//Lay thong tin SEO cho danh muc phan thu vien
function get_meta_lib_cat($id){
   $base_url = $_SERVER['HTTP_HOST'];
   $arr_meta = array();
   $arr = array(0,-1,-2,-3,-4); //0:library, -1:game, -2:story, -3:song, -4:video
   if(!in_array($id,$arr)){
      $sql          = new db_query("SELECT * FROM library_cate WHERE lib_cat_id = ".$id);
      $row          = mysqli_fetch_assoc($sql->result);
      unset($sql);

      $row['title']        == ''? $title        = $row['lib_cat_name']        : $title       = $row['title'];
      $row['description']  == ''? $description  = $row['lib_cat_description'] : $description = $row['description'];
      $row['keywords']     == ''? $keywords     = $row['lib_cat_name']        : $keywords    = $row['keywords'];

      $arr_meta['image']        = "http://".$base_url."/pictures/library_cat/".$row['lib_cat_picture'];
      $arr_meta['title']        = removeHTML(str_replace ('"', ' ', $title));
      $arr_meta['description']  = removeHTML(str_replace ('"', ' ', $description));
      $arr_meta['keywords']     = removeHTML(str_replace ('"', ' ', $keywords));
   }else{
      switch($id){
         case "0":
           $arr_meta['title']        = "TÀI LIỆU,NGHE NHẠC,XEM PHIM,ĐỌC TRUYỆN,CHƠI GAME,TIN TỨC,GIẢI TRÍ";
           $arr_meta['description']  = "Học tiếng anh online,thư giãn qua các video giải trí,đọc các bộ truyện tranh nổi tiếng,nghe nhạc,xem phim,chơi game và download tài liệu miễn phí";
           $arr_meta['keywords']     = "Tài liệu, nghe nhạc, xem phim, đọc truyện tranh, game, tin tức, thư giãn, tiếng anh online, miễn phí";
           break;
         case "-1":
           $arr_meta['title']        = "Game học tiếng Anh, English Game, Học tiếng Anh qua trò chơi";
           $arr_meta['description']  = "Chơi game online không giới hạn với các loại game vui, game hot nhất hiện nay hoàn toàn miễn phí, Ở đây các bạn sẽ được giải lao qua các trò chơi tiếng Anh vừa vui nhộn, vừa kiểm tra kiến thức tiếng Anh của bạn.";
           $arr_meta['keywords']     = "game học tiếng Anh, English Game, kho game miễn phí, Trò chơi tiếng Anh, Học Tiếng Anh Miễn Phí, học tiếng Anh qua trò chơi, tiếng Anh, học tiếng Anh qua game";
           $arr_meta['image']        = "http://".$base_url."/themes_v2/images/home/thu_vien_1.jpg";
           break;
         case "-2":
           $arr_meta['title']        = "ĐỌC TRUYỆN TRANH ONLINE,TRUYỆN CƯỜI TIẾNG ANH,MANGA,TRUYỆN NGẮN HAY";
           $arr_meta['description']  = "Thưởng thức thế giới truyện tranh, manga online, các câu chuyện cười tiếng anh và các truyện ngắn hay nhất hoàn toàn miễn phí";
           $arr_meta['keywords']     = "Đọc truyện tranh, online, truyện cười tiếng anh, truyện ngắn hay, miễn phí, manga";
           $arr_meta['image']        = "http://".$base_url."/themes_v2/images/home/thu_vien_2.jpg";
           break;
         case "-3":
           $arr_meta['title']        = "Bài hát tiếng Anh, nghe nhạc tiếng anh, Học tiếng Anh qua bài hát";
           $arr_meta['description']  = "Thưởng thức các ca khúc nhạc hot âu mỹ, nhạc dance, nhạc phim, các bài hát tiếng anh hay trực tuyến được cập nhật liên tục";
           $arr_meta['keywords']     = "Bài hát tiếng Anh, nhac tieng anh, bai hat tieng anh,nghe nhạc tiếng anh online, nhạc hot âu mỹ, nhạc phim tiếng anh, Học tiếng Anh qua bài hát";
           $arr_meta['image']        = "http://".$base_url."/themes_v2/images/home/thu_vien_3.jpg";
           break;
         case "-4":
           $arr_meta['title']        = "Học tiếng anh qua video, video học tiếng anh, Phim tiếng anh";
           $arr_meta['description']  = "Học tiếng anh qua các bản tin tức 24h của đài VOA news, BBC news, CNN news, xem phim và thư giãn với video hài, hot nhất.";
           $arr_meta['keywords']     = "Học tiếng anh qua video, Clip học tiếng anh, video học tiếng anh, Học tiếng anh qua phim, Học tiếng Anh qua CNN, Học tiếng Anh qua BBC, Học tiếng Anh qua VOA";
           $arr_meta['image']        = "http://".$base_url."/themes_v2/images/home/thu_vien_4.jpg";
           break;
      }
   }
   return $arr_meta;
}
//Lay thong tin SEO cho trang chi tiet phan thu vien
function get_meta_lib_post($id){
   $base_url = $_SERVER['HTTP_HOST'];
   $arr_meta = array();
   $lib_type = getValue('libType','int','GET',1);
   switch($lib_type){
      case 1:
         $table = "library_game"; break;
      case 2:
         $table = "library_story"; break;
      case 3:
         $table = "library_song"; break;
      case 4:
         $table = "library_video"; break;
   }
   if($table == "library_game"){
      $sql          = new db_query("SELECT * FROM library_game WHERE lib_game_id = ".$id);
      $row          = mysqli_fetch_assoc($sql->result);
      unset($sql);

      $row['meta_title']       == '' ? $title          = $row['lib_game_title'] : $title          = $row['meta_title'];
      $row['meta_description'] == '' ? $description    = $row['lib_game_info']  : $description    = $row['meta_description'];
      $row['meta_keywords']    == '' ? $keywords       = $row['lib_game_title'] : $keywords       = $row['meta_keywords'];

      $arr_meta['image']        = "http://".$base_url."/pictures/library_game/".$row['lib_game_image'];
      $arr_meta['title']        = removeHTML(str_replace ('"', ' ', $title));
      $arr_meta['description']  = removeHTML(str_replace ('"', ' ', $description));
      $arr_meta['keywords']     = removeHTML(str_replace ('"', ' ', $keywords));

   }else if($table == "library_story"){
      $sql          = new db_query("SELECT * FROM library_story WHERE lib_story_id = ".$id);
      $row          = mysqli_fetch_assoc($sql->result);
      unset($sql);

      $row['meta_title']       == '' ? $title          = $row['lib_story_title']  : $title          = $row['meta_title'];
      $row['meta_description'] == '' ? $description    = $row['lib_story_intro']  : $description    = $row['meta_description'];
      $row['meta_keywords']    == '' ? $keywords       = $row['lib_story_title']  : $keywords       = $row['meta_keywords'];

      $arr_meta['image']        = "http://".$base_url."/pictures/library_story/".$row['lib_story_image'];
      $arr_meta['title']        = removeHTML(str_replace ('"', ' ', $title));
      $arr_meta['description']  = removeHTML(str_replace ('"', ' ', $description));
      $arr_meta['keywords']     = removeHTML(str_replace ('"', ' ', $keywords));

   }else if($table == "library_song"){
      $sql          = new db_query("SELECT * FROM library_song WHERE lib_song_id = ".$id);
      $row          = mysqli_fetch_assoc($sql->result);
      unset($sql);

      $row['meta_title']       == '' ? $title          = $row['lib_song_title']  : $title          = $row['meta_title'];
      $row['meta_description'] == '' ? $description    = $row['lib_song_info']   : $description    = $row['meta_description'];
      $row['meta_keywords']    == '' ? $keywords       = $row['lib_song_title']  : $keywords       = $row['meta_keywords'];

      $arr_meta['image']        = "http://".$base_url."/pictures/song/".$row['lib_song_image'];
      $arr_meta['title']        = removeHTML(str_replace ('"', ' ', $title));
      $arr_meta['description']  = removeHTML(str_replace ('"', ' ', $description));
      $arr_meta['keywords']     = removeHTML(str_replace ('"', ' ', $keywords));

   }else if($table == "library_video"){
      $sql          = new db_query("SELECT * FROM library_video WHERE lib_video_id = ".$id);
      $row          = mysqli_fetch_assoc($sql->result);
      unset($sql);

      $row['meta_title']       == '' ? $title          = $row['lib_video_title'] : $title          = $row['meta_title'];
      $row['meta_description'] == '' ? $description    = $row['lib_video_info']  : $description    = $row['meta_description'];
      $row['meta_keywords']    == '' ? $keywords       = $row['lib_video_title'] : $keywords       = $row['meta_keywords'];

      $arr_meta['image']        = "http://".$base_url."/pictures/video/".$row['lib_video_image'];
      $arr_meta['title']        = removeHTML(str_replace ('"', ' ', $title));
      $arr_meta['description']  = removeHTML(str_replace ('"', ' ', $description));
      $arr_meta['keywords']     = removeHTML(str_replace ('"', ' ', $keywords));

   }
   return $arr_meta;
}
//Ham check xem user xem bai post nay chua (pmhung)
function check_user_view_post($u_id,$p_id){
   $db_user_view       = new db_query("SELECT count(*) AS count FROM post_user_view WHERE puv_user_id = ".$u_id);
	$row_user	        = mysqli_fetch_array($db_user_view->result);
	$count_user         = $row_user["count"];
   //------------------
   if($count_user <= 0){
      $array_post = array($p_id);
      $arr_encode = json_encode($array_post);
      $sql_insert = "INSERT INTO post_user_view  VALUES (NULL,". $u_id .", '". $arr_encode ."')";
      $db_ins = new db_execute($sql_insert);
      unset($db_ins);
   }else{
      $sql          = new db_query("SELECT puv_post_id  FROM post_user_view WHERE puv_user_id = ".$u_id);
      $row          = mysqli_fetch_assoc($sql->result);
      unset($sql);
      $arr_de = json_decode($row['puv_post_id']);
      if (!in_array($p_id, $arr_de)) {
         array_push($arr_de,$p_id);
         $sql = "UPDATE post_user_view SET puv_post_id = '".json_encode($arr_de)."' WHERE puv_user_id=".$u_id;
         $db_inc = new db_execute($sql);
         unset($db_inc);
      }
   }
}
// Hàm check xem có  cat con trong cat cha không(pttuan)
function check_child($cat_id){
   $db_check_child = new db_query('SELECT *
                                   FROM categories_multi
                                   WHERE cat_parent_id ='.$cat_id);
   $list_check    = $db_check_child->resultArray();
   unset($db_check_child);
   $total = count($list_check);
   if($total != 0){
      return true;
   }else{
      return false;
   }
}
//Ham check xem user xem bai post nay chua (pmhung)
function check_count_new($u_id,$c_id,$type = 0){
   $count_new          = 0;
   if($type == 0){
   $db_count           = new db_query("SELECT count(*) AS count
                                       FROM post_community
                                       JOIN categories_multi ON(postcom_cat_id = cat_id)
                                       WHERE cat_parent_id =".$c_id);
   }
   if($type == 1){
    $db_count = new db_query("SELECT count(*) AS count
                              FROM post_community
                              WHERE postcom_cat_id = ".$c_id);
   }
	$row_count	        = mysqli_fetch_array($db_count->result);
	$count_post         = $row_count["count"];
   //------------------
   $sql          = new db_query("SELECT puv_post_id  FROM post_user_view WHERE puv_user_id = ".$u_id);
   $row          = mysqli_fetch_assoc($sql->result);
   unset($sql);
   $arr_de = json_decode($row['puv_post_id']);
   $count_view = 0;
   if($type == 0){
   $db_commu = new db_query("SELECT postcom_id
                             FROM post_community
                             JOIN categories_multi ON(postcom_cat_id = cat_id)
                             WHERE cat_parent_id=".$c_id);
   }
   if($type == 1){
      $db_commu = new db_query("SELECT postcom_id
                                FROM post_community
                                WHERE postcom_cat_id=".$c_id);
   }
   while($row_commu = mysqli_fetch_assoc($db_commu->result)){
      if(is_array($arr_de)){
         if (in_array($row_commu['postcom_id'], $arr_de)) {
            $count_view++;
         }
      }else{
         $count_view = 0;
      }
   }unset($db_commu);
   $count_new = $count_post - $count_view;
   if($count_new <=0){
      echo "0";
   }else{
      echo $count_new;
   }
}
// Kiểm tra xem có danh mục này trong tin tức hay ko
// Nếu có redirect
// Không tồn tại redirect về phần tin tức của cộng đồng
function check_cat_news($id){
   $db_check = new db_count('SELECT count(*) AS count
                              FROM post_category
                              WHERE pcat_id ='.$id);
   $total = $db_check->total;
   if($total){
      return true;
   }else{
      return false;
   }
}
// Đếm số lượng bài viết trong phần cộng đồng
function count_topic(){
	$db_cate = new db_query("SELECT cat_id
                           FROM categories_multi
                           WHERE cat_type = 2 AND cat_parent_id  = 0 AND cat_active = 1 AND cat_id != 227 AND cat_id != 228 AND cat_id != 229 AND cat_id != 230 AND cat_id != 212 ");
   $i = 0;
   $total_topics = 0;
   while($row_cate = mysqli_fetch_assoc($db_cate->result)){
      if(check_child($row_cate['cat_id'])){
        $db_count= new db_count("SELECT count(*) AS count
                                 FROM post_community
                                 JOIN categories_multi
                                 ON(postcom_cat_id = cat_id)
                                 WHERE postcom_active = 1 AND cat_parent_id =".$row_cate['cat_id']);
      }else{
        $db_count  =  new db_count('SELECT count(*) AS count
                                  FROM post_community
                                  JOIN categories_multi
                                  ON(cat_id = postcom_cat_id)
                                  WHERE postcom_active = 1 AND postcom_cat_id = '.$row_cate['cat_id']);
      }

      $row_count   = $db_count->total;
      $total_topics += $row_count;
      unset($db_count);
   }
   return $total_topics;
}
function total_user(){
   $db_user = new db_query('SELECT count(*) as count_user
                            FROM users');
   $count_user = mysqli_fetch_assoc($db_user->result);
   unset($db_user);
   return $count_user['count_user'];
}
function last_user(){
     $db_user = new db_query('SELECT use_name
                             FROM users
                             WHERE 1
                             ORDER BY use_id DESC
                             LIMIT 1');
     $last_use = mysqli_fetch_assoc($db_user->result);
     unset($db_user);
     return $last_use['use_name'];
}
//Ham check xem user xem bai post nay chua (pmhung)
function check_view_new_post($u_id,$p_id){
   $new          = 0;
   $sql          = new db_query("SELECT puv_post_id  FROM post_user_view WHERE puv_user_id = ".$u_id);
   $row          = mysqli_fetch_assoc($sql->result);
   unset($sql);
   $arr_de = json_decode($row['puv_post_id']);
   if(is_array($arr_de)){
      if (in_array($p_id, $arr_de)) {
         $new = 1;
      }else{
         $new = 0;
      }
   }
   return $new;
}
//
function get_str_cate_from_cou($iCou){
   $str_cate = "";
   $ncate    = "";
   $nlev     = "";
   $db_info = new db_query("SELECT cou_cat_id,cou_lev_id FROM courses WHERE cou_id = ".$iCou);
   $row_info = mysqli_fetch_assoc($db_info->result);
   unset($db_info);
   if(in_array($row_info['cou_cat_id'],array(1,2,3,26))){
      switch($row_info['cou_lev_id']){
   		case 1: $nlev = 'Beginner';
   			break;
   		case 2: $nlev = 'Intermediate';
   			break;
   		case 3: $nlev = 'Upper Intermediate';
   			break;
   		case 4: $nlev = 'Advanced';
   	}
      $ncate = nameCate($row_info['cou_cat_id']);
      $str_cate = $ncate.'-'.$nlev;
   }else{
      $db_cate = new db_query("SELECT cat_id,cat_name,cat_parent_id FROM categories_multi WHERE cat_id = ".$row_info['cou_cat_id']);
      $row_cate = mysqli_fetch_assoc($db_cate->result);
      $ncate = $row_cate['cat_name'];
      unset($db_cate);
      //parent cate
      $db_parent = new db_query("SELECT cat_id,cat_name FROM categories_multi WHERE cat_id = ".$row_cate['cat_parent_id']);
      $row_parent = mysqli_fetch_assoc($db_parent->result);
      $nparent = $row_parent['cat_name'];
      unset($db_parent);
      $str_cate = $nparent.'-'.$ncate;
   }
   return $str_cate;
}
//
function get_cate_from_reason($reason){
   $arr_cate = array();
   for($i = 0; $i < count($reason); $i++){
      switch($reason[$i]){
         case 1:
            //Tiếng Anh phổ thông
            array_unshift($arr_cate,42,43); break;
         case 2:
            //Tiếng Anh công việc: T.a văn phòng + T.a kinh doanh
            array_unshift($arr_cate,1,26); break;
         case 3:
            //Tiếng Anh giao tiếp
            array_unshift($arr_cate,2); break;
         case 4:
            //TOEIC
            array_unshift($arr_cate,33,34); break;
         case 5:
            //IELTS
            array_unshift($arr_cate,29,30,31,32); break;
         case 6:
            //TOEFL
            array_unshift($arr_cate,14,15,16,17); break;
         case 7:
            //Từ mới
            array_unshift($arr_cate,3); break;
         case 8:
            //Rèn luyện tổng thể
            array_unshift($arr_cate,2,1,26); break;
         default:
            array_unshift($arr_cate,2,1,26); break;
      }
   }
   return $arr_cate;
}
//
function build_test_from_reason($reason){
   $str_part = "";
   if(count($reason) > 1) $str_part = "1,2,3,4,5,6";
   else{
      for($i = 0; $i < count($reason); $i++){
         switch($reason[$i]){
            case 1:
               //Tiếng Anh phổ thông
               $str_part = "1,2,3,4"; break;
            case 2:
               //Tiếng Anh công việc: T.a văn phòng + T.a kinh doanh
               $str_part = "1,2,3,5"; break;
            case 3:
               //Tiếng Anh giao tiếp
               $str_part = "1,2,3,5"; break;
            case 4:
               //TOEIC
               $str_part = "1,2,3,6"; break;
            case 5:
               //IELTS
               $str_part = "2,4,5,6"; break;
            case 6:
               //TOEFL
               $str_part = "2,4,5,6"; break;
            case 7:
               //Từ mới
               $str_part = "1,2,3,4"; break;
            case 8:
               //Rèn luyện tổng thể
               $str_part = "1,2,3,4,5,6"; break;
            default:
               $str_part = "1,2,3,4,5,6"; break;
         }
      }
   }
   return $str_part;
}
//
function get_cate_onlink($iCate,$iLev){
   $name1 = "";
   $name2 = "";
   $name_on_link = "";
   $db_cate = new db_query("SELECT cat_id,cat_name,cat_parent_id FROM categories_multi WHERE cat_id = ".$iCate);
   $row_cate = mysqli_fetch_assoc($db_cate->result);
   unset($db_cate);

   $db_parent = new db_query("SELECT cat_id,cat_name FROM categories_multi WHERE cat_id = ".$row_cate['cat_parent_id']);
   $row_parent = mysqli_fetch_assoc($db_parent->result);
   unset($db_parent);

   if(in_array($iCate,array(2,1,26,3))){
      $name1 = $row_cate['cat_name'];
      switch($iLev){
         case 1: $name2 = "beginner";              break;
         case 2: $name2 = "intermediate";          break;
         case 3: $name2 = "upper-intermediate";    break;
         case 4: $name2 = "advanced";              break;
         default: $name2 = "";                     break;
      }
   }else{
      $name1 = $row_parent['cat_name'];
      $name2 = $row_cate['cat_name'];
   }
   $name_on_link = $name1.'-'.$name2;
   return $name_on_link;
}
//
function creat_time_sg_test($time_test_real){
   $time_target = time() + ($time_test_real * 60);
   $dateFormat = "d F Y -- g:i a";
   $time_actual = time();
   $time_diff = $time_target - $time_actual;
   return $time_diff;
}
//
function curPageURL() {
 $pageURL = 'http://';
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
//
function get_array_cate_sg($arr_reason,$lev_id){
   $arr_cate = array();
   foreach($arr_reason as $rs){
         if($rs == 1){
            //Tieng anh pho thong
            if($lev_id == 1 || $lev_id == 2) array_unshift($arr_cate,42);
            if($lev_id == 3 || $lev_id == 4) array_unshift($arr_cate,43);
         }
         if($rs == 2){
            //Tieng anh cong viec (T.a van phong + T.a kinh doanh)
            if($lev_id == 1) array_unshift($arr_cate,139,143);
            if($lev_id == 2) array_unshift($arr_cate,140,144);
            if($lev_id == 3) array_unshift($arr_cate,141,145);
            if($lev_id == 4) array_unshift($arr_cate,142,146);
         }
         if($rs == 3){
            //Tieng anh giao tiep
            if($lev_id == 1) array_unshift($arr_cate,135);
            if($lev_id == 2) array_unshift($arr_cate,136);
            if($lev_id == 3) array_unshift($arr_cate,137);
            if($lev_id == 4) array_unshift($arr_cate,138);
         }
         if($rs == 4){
            //TOEIC
            if($lev_id == 1) array_unshift($arr_cate,158,195);
            if($lev_id == 2 || $lev_id == 3) array_unshift($arr_cate,163,164);
            if($lev_id == 4) array_unshift($arr_cate,168,169);
         }
         if($rs == 5){
            //IELTS
            if($lev_id == 1) array_unshift($arr_cate,172,173,174,176,177);
            if($lev_id == 2 || $lev_id == 3) array_unshift($arr_cate,178,179,180,181,182);
            if($lev_id == 4) array_unshift($arr_cate,185,186,187,188,189);
         }
         if($rs == 6){
            //TOEFL
            array_unshift($arr_cate,14,15,16,17);
         }
         if($rs == 7){
            //Tu vung
            if($lev_id == 1) array_unshift($arr_cate,147);
            if($lev_id == 2) array_unshift($arr_cate,148);
            if($lev_id == 3) array_unshift($arr_cate,149);
            if($lev_id == 4) array_unshift($arr_cate,150);
         }
         if($rs == 7){
            //Ren luyen tong the
            if($lev_id == 1) array_unshift($arr_cate,135,139,143);
            if($lev_id == 2) array_unshift($arr_cate,136,140,144);
            if($lev_id == 3) array_unshift($arr_cate,137,141,145);
            if($lev_id == 4) array_unshift($arr_cate,138,142,146);
         }
   }
   return $arr_cate;
}
//======== check log
function creat_log_user($user_id,$courses_name,$unit_names){
   //nếu chưa tồn tại tài khoản thì không update
   //bắt đầu insert vào db
   $array_u = array();
   for($i = 15768;$i<=15827;$i++){
      $array_u[] = $i;
   }
   if(in_array($user_id,$array_u)){
      $db_execute	= new db_execute_return();
    	$umoney_return  = $db_execute->db_execute("INSERT IGNORE INTO temp_log(temp_log_user_id,temp_log_time,temp_log_description	)
   	 									                VALUES(" . $user_id . " , '" . time() . "' , '". "Courses : " . $courses_name."----- Unit : ".$unit_names . "')"
                                                 , __FILE__ . " Line: " . __LINE__);
      unset($db_execute);
   }
}
function check_userdemo($user_id){
   $check = 0;
   $array_u = array();
   for($i = 15768;$i<=15827;$i++){
      $array_u[] = $i;
   }
   if(in_array($user_id,$array_u)){
      $check = 1;
   }
   return $check;
}
/*280813 - pmh*/
// Mời ban
function invite_friend($user,$friend){
   //Kiem tra xem myuser da moi ket ban friend nay chua
   $arr_invite = get_friend_invite($friend);
   if(!in_array($user,$arr_invite)){
      $date = time();
      $sql_insert = "INSERT INTO friendship  VALUES (NULL,". $user .", ". $friend .", ". $date .", 0)";
      $db_ins = new db_execute($sql_insert);
      unset($db_ins);
      //notify
      $db_user_send = new db_query("SELECT use_id,use_name FROM users WHERE use_id = ".$user);
      $row_user_send = mysqli_fetch_assoc($db_user_send->result);
      $user_send_name = $row_user_send['use_name'];
      unset($db_user_send);
      user_notification($friend,'<a href="/user/u-'.$user.'">'.$user_send_name.'</a> muốn kết bạn với bạn. <span>Click <a class="accept_fri">vào đây</a> để xác nhận.<span>');
      //log
      $db_user = new db_query("SELECT use_id,use_name FROM users WHERE use_id = ".$friend);
      $row_user = mysqli_fetch_assoc($db_user->result);
      $user_name = $row_user['use_name'];
      unset($db_user);
      user_activity_log($user,'Bạn đã gửi lời mời kết bạn đến <a href="/user/u-'.$friend.'">'.$user_name.'</a>');
   }
}
// Chấp nhận
function accept_friend($user,$friend){
   $date = time();
   $sql_insert = "INSERT INTO friendship  VALUES (NULL,". $user .", ". $friend .", ". $date .", 1)";
   $db_ins = new db_execute($sql_insert);
   unset($db_ins);
   $sql = "UPDATE friendship SET frs_stt = 1 WHERE frs_user=".$friend." AND frs_friend=".$user;
   $db_inc = new db_execute($sql);
   unset($db_inc);
   //notification
   $db_user_send = new db_query("SELECT use_id,use_name FROM users WHERE use_id = ".$user);
   $row_user_send = mysqli_fetch_assoc($db_user_send->result);
   $user_send_name = $row_user_send['use_name'];
   unset($db_user_send);
   user_notification($friend,'<a href="/user/u-'.$user.'">'.$user_send_name.'</a> đã đồng ý kết bạn với bạn. <span>Gửi <a class="send_mes">tin nhắn</a></span>');
   //log
   $db_user = new db_query("SELECT use_id,use_name FROM users WHERE use_id = ".$friend);
   $row_user = mysqli_fetch_assoc($db_user->result);
   $user_name = $row_user['use_name'];
   unset($db_user);
   user_activity_log($user,'Bạn đã đồng ý kết bạn với <a href="/user/u-'.$friend.'">'.$user_name.'</a>');
}
// Từ chối
function denied_friend($user,$friends){
   $sql = "UPDATE friendship SET frs_stt = -1 WHERE frs_user=".$friends." AND frs_friend=".$user;
   $db_inc = new db_execute($sql);
   unset($db_inc);
   //log
   $db_user = new db_query("SELECT use_id,use_name FROM users WHERE use_id = ".$friends);
   $row_user = mysqli_fetch_assoc($db_user->result);
   $user_name = $row_user['use_name'];
   unset($db_user);
   user_activity_log($user,'Bạn đã từ chối kết bạn với <a href="/user/u-'.$friend.'">'.$user_name.'</a>');
}
// Xóa bạn
function remove_friend($user,$friend){
   $db_exec	= new db_execute("DELETE FROM friendship WHERE frs_user =".$user." AND frs_friend=".$friend);
	unset($db_exec);
   $db_exec_1	= new db_execute("DELETE FROM friendship WHERE frs_user =".$friend." AND frs_friend=".$user);
	unset($db_exec_1);
   //log
   $db_user = new db_query("SELECT use_id,use_name FROM users WHERE use_id = ".$friend);
   $row_user = mysqli_fetch_assoc($db_user->result);
   $user_name = $row_user['use_name'];
   unset($db_user);
   user_activity_log($user,'Bạn đã xóa <a href="/user/u-'.$friend.'">'.$user_name.'</a> khỏi danh sách bạn bè');
}
//funtion check_friend
function check_frienship($user,$friend){
   $check_fr = 0;
   $db_count= new db_query("SELECT count(*) AS count FROM friendship a ,friendship b WHERE a.frs_user = b.frs_friend AND a.frs_friend = b.frs_user AND a.frs_user =".$user." AND a.frs_friend=".$friend);
   $row		= mysqli_fetch_array($db_count->result);
	unset($db_count);
   $count_fr = $row["count"];
   $db_count_2= new db_query("SELECT count(*) AS count FROM friendship a ,friendship b WHERE a.frs_user = b.frs_friend AND a.frs_friend = b.frs_user AND a.frs_user =".$friend." AND a.frs_friend=".$user);
   $row_2		= mysqli_fetch_array($db_count_2->result);
	unset($db_count_2);
   $count_fr_2 = $row_2["count"];
   if($count_fr > 0 && $count_fr_2 > 0){
      $check_fr = 1;
   }elseif($count_fr > 0 && $count_fr_2 == 0 || $count_fr == 0 && $count_fr_2 > 0 ){
      $check_fr = 0;
   }
   return $check_fr;
}
// Get friend
function get_friend($user){
   $arr_friend = array();
   $db_list_friend = new db_query("SELECT frs_friend FROM friendship WHERE frs_user = ".$user." AND frs_stt=1 ");
   $i = 0;
   while($arr_friend_list = mysqli_fetch_assoc($db_list_friend->result)){
      $arr_friend[$i] = $arr_friend_list['frs_friend'];
      $i++;
   }unset($db_list_friend);
   return $arr_friend;
}
//Get friend invite
function get_friend_invite($user){
   $arr_friend = array();
   $db_list_friend = new db_query("SELECT frs_user FROM friendship WHERE frs_friend = ".$user." AND frs_stt=0 ");
   $i = 0;
   while($arr_friend_list = mysqli_fetch_assoc($db_list_friend->result)){
      $arr_friend[$i] = $arr_friend_list['frs_user'];
      $i++;
   }unset($db_list_friend);
   return $arr_friend;
}
// Activity log
function user_activity_log($user_id,$description){
   $date = time();
   $sql_insert = "INSERT INTO user_activity_log  VALUES (NULL,". $user_id .",'". $description ."', ". $date ." , 0)";
   $db_ins = new db_execute($sql_insert);
   unset($db_ins);
}
// Add Notification log
function user_notification($user_id,$description){
   $date = time();
   $sql_insert = "INSERT INTO user_notification  VALUES (NULL,". $user_id .",'". $description ."', ". $date ." , 0, 0, 1)";
   $db_ins = new db_execute_return();
   $id_noti = $db_ins->db_execute($sql_insert);
   unset($db_ins);
   return $id_noti;
}
// Update Notification log
function user_notification_update($user_id){
   $sql = "UPDATE user_notification SET user_noti_status = 1 WHERE user_noti_uid=".$user_id."";
   $db_inc = new db_execute($sql);
   unset($db_inc);
}
// Count Notification
function count_user_notification($user_id){
   // Select Count
   $count_notification = 0;
	$db_count= new db_query("SELECT count(*) AS count FROM user_notification WHERE user_noti_uid=".$user_id." AND user_noti_status = 0");
	$row		= mysqli_fetch_array($db_count->result);
	unset($db_count);
   $count_notification = $row["count"];
	return $count_notification;
}

function count_user_activitylog($user_id){
   // Select Count
   $count_activity = 0;
	$db_count= new db_query("SELECT count(*) AS count FROM user_activity_log WHERE user_act_uid=".$user_id." AND user_act_stt = 0");
	$row		= mysqli_fetch_array($db_count->result);
	unset($db_count);
   $count_activity = $row["count"];
	return $count_activity;
}

// Update Notification log
function user_activitylog_update($user_id){
   $sql = "UPDATE user_activity_log SET user_act_stt = 1 WHERE user_act_uid=".$user_id."";
   $db_inc = new db_execute($sql);
   unset($db_inc);
}

function count_user_message($user_id){
   // Select Count
   $count_notification = 0;
	$db_count= new db_query("SELECT count(*) AS count FROM user_message WHERE user_mes_receid=".$user_id." AND user_mes_type = 0");
	$row		= mysqli_fetch_array($db_count->result);
	unset($db_count);
   $count_notification = $row["count"];
	return $count_notification;
}
// Count Notification
function send_message($user_id,$friend_id,$description){
   $date = time();
   $sql_insert = "INSERT INTO user_message  VALUES (NULL,". $user_id .", ". $friend_id .",'". $description ."', 0 , ". $date .")";
   $db_ins = new db_execute($sql_insert);
   unset($db_ins);
   //Noti
   $db_user = new db_query("SELECT use_id,use_name FROM users WHERE use_id = ".$user_id);
   $row_user = mysqli_fetch_assoc($db_user->result);
   $user_name = $row_user['use_name'];
   unset($db_user);
   user_notification($friend_id,'<a href="/user/u-'.$user_id.'">'.$user_name.'</a> đã gửi <a href="/user/message/'.$user_id.'">tin nhắn</a> cho bạn');
   //log
   $db_user = new db_query("SELECT use_id,use_name FROM users WHERE use_id = ".$friend_id);
   $row_user = mysqli_fetch_assoc($db_user->result);
   $user_name = $row_user['use_name'];
   unset($db_user);
   user_activity_log($user_id,'Bạn đã gửi tin nhắn đến <a href="/user/u-'.$friend_id.'">'.$user_name.'</a>');
}

//-----------------------------

//
/*20130822 - Dương*/
function find_course_packages($iCourse,$string=0,$type){
	//return packages' id that included in the given course
	/*
	 * $string
	 * 0-[default]-return array
	 * 1-return string
	 */
	$data_array = array();
	$db_query = new db_query("SELECT * FROM package_data WHERE padt_data_id = ".$iCourse." AND padt_type= ".$type);
	while($db_result = mysqli_fetch_assoc($db_query->result)){
		array_push($data_array,$db_result['padt_pack_id']);
	}
	unset($db_result);
	unset($db_query);

	//produce the output
	switch($string){
		case 0:
			$return = array();
			$return = $data_array;
			break;
		case 1:
			$return = '';
			$return.=implode(',',$data_array);
			break;
	}

	return $return;
}

function find_package_courses($iPackage,$string=0){
	//return courses' id that included in the given package
	/*
	 * $string
	 * 0-[default]-return array
	 * 1-return string
	 */
	$data_array = array();
	$db_query = new db_query("SELECT * FROM package_data WHERE padt_pack_id = ".$iPackage);
	while($db_result = mysqli_fetch_assoc($db_query->result)){
		array_push($data_array,$db_result['padt_data_id']);
	}
	unset($db_result);
	unset($db_query);

		//produce the output
	switch($string){
		case 0:
			$return = array();
			$return = $data_array;
			break;
		case 1:
			$return = '';
			$return.=implode(',',$data_array);
			break;
	}

	return $return;
}

function purchase_package($user_id,$pid_array,$type){
	//kiểm tra số tiền của tài khoản hiện tại
	$user_main_account = get_money($user_id);
	//lấy thông tin về gói

	$packages = array();
	$packages['total'] = 0;
	$packages['children'] = array();

	foreach($pid_array as $pid){
		$db_query = new db_query("SELECT * FROM package WHERE pack_id = ".$pid);
		$db_result = mysqli_fetch_assoc($db_query->result);
			$data_array = array(	'id'			=> $db_result['pack_id'],
										'name'		=> $db_result['pack_name'],
										'price'		=> $db_result['pack_price'],
										'total_day'	=> $db_result['pack_totalday'],
										'children'	=> array());
			$db_query2 = new db_query("SELECT * FROM package_data WHERE padt_pack_id = ".$pid);
			while($db_result2 = mysqli_fetch_assoc($db_query2->result)){
				array_push($data_array['children'],$db_result2['padt_data_id']);
			}
			unset($db_result2);
			unset($db_query2);
			$packages['total']+=$data_array['price'];
			array_push($packages['children'],$data_array);

			unset($data_array);
		unset($db_result);
		unset($db_query);
	}

	if($packages['total']>$user_main_account){
		$response = "Số tiền trong tài khoản của bạn không đủ để thực hiện. Xin vui lòng nạp tiền";
	} else {
		//trừ tiền trong tài khoản
		$total_money = (sizeof($packages['children'])<3)?($packages['total']):(($packages['total'])*0.83);
		substract_money($user_id,$total_money);

		foreach($packages['children'] as $package){
			//lưu log vào package_user
			$db_execute = new db_execute_return();
			$package_user_log  = $db_execute->db_execute("INSERT IGNORE INTO package_user(pau_pack_id,pau_user_id,pau_get_date)
   	 									                			VALUES(".$package['id'].",".$user_id.",UNIX_TIMESTAMP(NOW()))"
                                                 			, __FILE__ . " Line: " . __LINE__);
			unset($db_execute);
			//cập nhật vào user_course
			foreach($package['children'] as $course_id){
			   if($course_id == 0) { $type = 0; }
				$db_query = new db_query("SELECT * FROM user_courses_pack WHERE ucp_use_id = ".$user_id." AND ucp_cou_id = ".$course_id." AND ucp_status = ".$type);
				//check xem có tồn tại chưa
				if(!$db_result = mysqli_fetch_assoc($db_query->result)){
				   $current_time = time();
				   $end_time = $current_time + ($package['total_day'])*(24*3600);
					$db_execute = new db_execute_return();
					$db_execute_result = $db_execute->db_execute("INSERT IGNORE INTO user_courses_pack(ucp_id,ucp_use_id,ucp_cou_id,ucp_end_time,ucp_status,ucp_type)
					 																VALUES(NULL,".$user_id.",".$course_id.",".$end_time.",1,".$type.")"
																					, __FILE__ . " Line: " . __LINE__);
					unset($db_execute_result);
					unset($db_execute);
				} else {
					//Nếu đã tồn tại
					//Check xem thời gian hết hạn có lớn hơn hiện tại ko
					$current_time = time();

					$end_time = $db_result['ucp_end_time'];
					if($end_time > $current_time){
						$start_time = $end_time;
					} else {
						$start_time = $current_time;
					}
					$end_time = $start_time + ($package['total_day'])*(24*3600);
					//thực hiện cộng ngày
					$db_execute = new db_execute(	"UPDATE user_courses_pack
															 SET ucp_end_time = ".$end_time.",ucp_status = 1 AND ucp_type=".$type."
															 WHERE ucp_use_id = ".$db_result['ucp_use_id']."
															 AND ucp_cou_id =".$course_id
															, __FILE__ . " Line: " . __LINE__);
					unset($db_execute);
				}
			}
		}


		$response = 'CHÚC MỪNG, BẠN ĐÃ MUA KHÓA HỌC THÀNH CÔNG!<br/>';
		$response.= 'Khóa học vừa mua sẽ tự động cập nhật vào<br/>';
		$response.= '"Khóa đang học" tại trang cá nhân';
	}


	return $response;

}

function is_mobile(){
   $useragent = $_SERVER['HTTP_USER_AGENT'];
   if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
      return true;
   }else{
      return false;
   }
}
// Get name comment save user_activity
function nameCourses($id){
      $db_comment = new db_query('SELECT cou_name
                                 FROm courses
                                 JOIN comments
                                 ON(com_post_id = cou_id)
                                 WHERE com_id ='.$id);
      $comment = mysqli_fetch_assoc($db_comment->result);
      unset($db_comment);
      return $comment['cou_name'];

}
function idFaq_rerult($id){
    $db_user_ques = new db_query('SELECT que_user_id
                                 FROM faq_questions
                                 WHERE que_id ='.$id);
    $usercheck = mysqli_fetch_assoc($db_user_ques->result);
    unset($db_user_ques);
    return $usercheck['que_user_id'];
}
function count_mem_in_cou($iCou){
   $mem = 0;
   $db_query = new db_query('SELECT DISTINCT usec_use_id FROM user_course WHERE usec_cou_id = '.$iCou);
   $mem = mysqli_num_rows($db_query->result);
   return $mem;
}

/*
 * 2013.09.11 - Dương: manual debug
 */
function dump($var){
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}
/*Tuấn - Support*/
// Show kiểu support
function show_type_support($id){
    $db_name = new db_query('SELECT scat_type
                             FROM support_category
                             WHERE scat_active = 1 AND scat_parent_id = 0 AND scat_id ='.$id);
    $row = mysqli_fetch_assoc($db_name->result);
    unset($db_name);
    return $row['scat_type'];
}

/*
 * 2013.09.12 - Duong: Tạo link nhanh đến các module
 */
function gen_module_link($module,$params = array()){
	global $base_url;

	$link ='';
	$link.='http://'.$base_url.'/home_v2/module.php?module='.$module;
	if(sizeof($params)>0){
		$link.='&'.http_build_query($params);
	}
	return $link;
}
function gen_include_link($path){
	global $base_url;

	$link ='';
	$link.='http://'.$base_url.'/includes_v2/'.$path;

	return $link;
}

function gen_home_link($path){
	global $base_url;

	$link ='';
	$link.='http://'.$base_url.'/home_v2/'.$path;

	return $link;
}
function gen_edit_course_category_link($params = array()){
	$link = '';
	$link.= gen_module_link('cat_edit');
	if(sizeof($params)>0){
		$link.='&'.http_build_query($params);
	}
	return $link;
}

function gen_edit_course_link($params = array()){
	$link = '';
	$link.= gen_module_link('course_edit');
	if(sizeof($params)>0){
		$link.='&'.http_build_query($params);
	}
	return $link;
}
function check_user_course_v2($user_id,$cou_id,$type){
   // 0 - khong duoc hoc ; 1 - duoc hoc;
   $check_user_course = 0;
   $arr_cou_get = array();
   $db_query_full = new db_query('SELECT ucp_end_time,ucp_id
                                  FROM user_courses_pack
                                  WHERE ucp_use_id = '.$user_id.' AND ucp_cou_id = 0');
   if($row_full = mysqli_fetch_assoc($db_query_full->result)){
      $time_end_full = $row_full['ucp_end_time'];
      if($time_end_full > time()){
         $check_user_course = 1;
      }else{
         $db_query = new db_query('SELECT ucp_cou_id
                             FROM user_courses_pack
                             WHERE ucp_use_id = '.$user_id.' AND ucp_status = 1 AND ucp_type ='.$type);
         $i = 0;
         while($row = mysqli_fetch_assoc($db_query->result)){
            $arr_cou_get[$i] = $row['ucp_cou_id'];
            $i++;
         }unset($db_query);
         if(in_array($cou_id,$arr_cou_get) || in_array(0,$arr_cou_get)){
            $check_user_course = 1;
         }
      }
   }else{
      $db_query = new db_query('SELECT ucp_cou_id
                          FROM user_courses_pack
                          WHERE ucp_use_id = '.$user_id.' AND ucp_status = 1 AND ucp_type ='.$type);
      $i = 0;
      while($row = mysqli_fetch_assoc($db_query->result)){
         $arr_cou_get[$i] = $row['ucp_cou_id'];
         $i++;
      }unset($db_query);
      if(in_array($cou_id,$arr_cou_get) || in_array(0,$arr_cou_get)){
         $check_user_course = 1;
      }
   }
   return $check_user_course;
}
function check_date_course($user_id,$cou_id,$type){
   //check tron goi
   $db_query_full = new db_query('SELECT ucp_end_time,ucp_id
                                  FROM user_courses_pack
                                  WHERE ucp_use_id = '.$user_id.' AND ucp_cou_id = 0');

   if($row_full = mysqli_fetch_assoc($db_query_full->result)){
      $time_end_full = $row_full['ucp_end_time'];
      $ucp_id_full = $row_full['ucp_id'];
      if($time_end_full < time()){
         $db_execute = new db_execute(	"UPDATE user_courses_pack
         										 SET ucp_status = 0
         										 WHERE ucp_id = ".$ucp_id_full );
         unset($db_execute);
      }
   }

   // check khoa le
   $db_query = new db_query('SELECT ucp_end_time,ucp_id
                             FROM user_courses_pack
                             WHERE ucp_use_id = '.$user_id.' AND ucp_cou_id = '.$cou_id.' AND ucp_type='.$type);
   if($row = mysqli_fetch_assoc($db_query->result)){
      $time_end = $row['ucp_end_time'];
      $ucp_id = $row['ucp_id'];
      if($time_end < time()){
         $db_execute = new db_execute(	"UPDATE user_courses_pack
         										 SET ucp_status = 0
         										 WHERE ucp_id = ".$ucp_id );
         unset($db_execute);
      }
   }
}
function check_crc_user($cou_id,$user_id){
   $check = 0;
   $db_query = new db_query('SELECT * FROM hoc123_courses
                             WHERE id = '.$cou_id.' AND user_created ='.$user_id);
   if(!$row = mysqli_fetch_assoc($db_query->result)){
      $check = 0;
   }else{
      $check = 1;
   }
   return $check;
}
//Hàm kiểm tra xem thành viên đã chấp nhận tham gia khoa hoc hay chua return 0: Chưa được mời, -1: Đã đc mời,chưa chấp nhận, 1: Đã tham gia
function chk_user_course($user_id,$cou_id){
   $db_chk = new db_query("SELECT id,status FROM hoc123_user_course WHERE user_id = ".$user_id." AND cou_id = ".$cou_id);
   if($db_chk){
      $row_chk = mysqli_fetch_assoc($db_chk->result);
      return $row_chk['status'];
   }else{
      return 0;
   }
   unset($db_chk);
}


//Ham phan trang block content trang chu moi
function get_list_num_page($pageCount,$page){
   $str = '';
   // Điều kiện Previouss
   if($pageCount > 1){
      if($page > 1){
         $str .= '<a title="'.($page - 1).'" class="prev_node">&lt;&lt;</a>';
      }
      if($pageCount > 12){
         // Nếu trang hiện tại đang ở các số 1->8
         if($page < 9){
            // Nếu trang bé hơn 6 thì in ra từ 1->9
            if($page < 6){
               for ($i=1; $i<=9; $i++) {
                  if($i == $page){
                     $str .= '<a class="current" title="'.$page.'">'.$page.'</a>';
                  }else{
                      $str .= '<a title="'.$i.'">'.$i.'</a>';
                  }
               }
            }else{
               // Ngược lại thì in từ 1-> trang hiện tại + 4
               for ($i=1; $i<$page+4; $i++) {
                  if($i == $page){
                     $str .= '<a class="current" title="'.$page.'">'.$page.'</a>';
                  }else{
                     $str .= '<a title="'.$i.'">'.$i.'</a>';
                  }
               }
            }
            // In ra dấu ...
            $str .= '<span>…</span>';
            for ($j = ($pageCount - 1); $j <= $pageCount; $j++) {
               $str .= '<a title="'.$j.'">'.$j.'</a>';
            }
         }else{
            $go_page = $page + 4;
            if($pageCount - $page > 8 && $go_page < $pageCount - 3){
               for ($i=1; $i<=2; $i++) {
                  $str .= '<a title="'.$i.'">'.$i.'</a>';
               }
               $str .= '<span>…</span>';
               $go_page = ($page + 3 > $pageCount)?$pageCount - 2: $page + 3;
               for($i = ($page - 3); $i <= $go_page; $i++){
                  if($i == $page){
                     $str .= '<a class="current" title="'.$page.'">'.$page.'</a>';
                  }else{
                        $str .= '<a title="'.$i.'">'.$i.'</a>';
                  }
               }
               $str .= '<span>…</span>';
               for ($j = ($pageCount - 1); $j <= $pageCount; $j++) {
                  $str .= '<a title="'.$j.'">'.$j.'</a>';
               }
            }else{
               if($pageCount-$page < 6){
                  for ($i=1; $i<=2; $i++) {
                     $str .= '<a title="'.$i.'">'.$i.'</a>';
                  }
                  $str .= '<span>…</span>';
                  for ($i= $pageCount - 8; $i<=$pageCount; $i++) {
                     if($i == $page){
                        $str .= '<a class="current" title="'.$page.'">'.$page.'</a>';
                     }else{
                           $str .= '<a title="'.$i.'">'.$i.'</a>';
                     }
                  }
               }
               else{
                  for ($i=1; $i<=2; $i++) {
                     $str .= '<a title="'.$i.'">'.$i.'</a>';
                  }
                  $str .= '<span>…</span>';
                  for ($i= $page - 3;$i<=$pageCount; $i++) {
                     if($i == $page){
                        $str .= '<a class="current" title="'.$page.'">'.$page.'</a>';
                     }else{
                           $str .= '<a title="'.$i.'">'.$i.'</a>';
                     }
                  }
               }

            }
         }
      }else{
         for ($i= 1;$i<=$pageCount; $i++) {
            if($i == $page){
               $str .= '<a class="current" title="'.$page.'">'.$page.'</a>';
            }else{
                  $str .= '<a title="'.$i.'">'.$i.'</a>';
            }
         }
      }
      // Điều kiện next
      if($page < $pageCount){
         $str .= '<a title="'.($page+1).'" class="next_node">&gt;&gt;</a>';
      }
   }
   return $str;
}
//Hàm lấy mảng các loại đề thi : Thi ĐH, TOEIC, TOEFL, IELTS
function get_exam_arr(){
   $exam_array = array();
   //Select de thi dai hoc
   $db_exam = new db_query('SELECT * FROM uni_test WHERE uni_test_active = 1 ORDER BY uni_test_date,uni_test_name DESC');
   while($row_exam = mysqli_fetch_assoc($db_exam->result)){
      $data_array = array();
      $data_array = array('id'            => $row_exam['uni_test_id'],
                          'name'          => $row_exam['uni_test_name'],
                          'url'           => '/testuni/toeic_reading.php?test_id='.$row_exam['uni_test_id'],
                          'name_cate'     => 'Đề thi Đại học',
                          'link_cate'     => 'http://'.$_SERVER['HTTP_HOST'].'/khoa-hoc/232-luyen-thi-dai-hoc-de-thi-dai-hoc.html');
      array_push($exam_array,$data_array);
      unset($data_array);
   }unset($db_exam);
   //Select de thi toeic
   $db_exam = new db_query('SELECT * FROM toeic WHERE toeic_active = 1 ORDER BY toeic_date,toeic_name DESC');
   while($row_exam = mysqli_fetch_assoc($db_exam->result)){
      $data_array = array();
      $data_array = array('id'            => $row_exam['toeic_id'],
                          'name'          => $row_exam['toeic_name'],
                          'url'           => '/toeic/toeic_listening.php?test_id='.$row_exam['toeic_id'],
                          'name_cate'     => 'Thi thử TOEIC',
                          'link_cate'     => 'http://'.$_SERVER['HTTP_HOST'].'/khoa-hoc/76-chung-chi-toeic-thi-thu-toeic.html');
      array_push($exam_array,$data_array);
      unset($data_array);
   }unset($db_exam);
   //Select de thi toefl
   $db_exam = new db_query('SELECT * FROM test WHERE test_active = 1 ORDER BY test_date,test_name DESC');
   while($row_exam = mysqli_fetch_assoc($db_exam->result)){
      $data_array = array();
      $data_array = array('id'            => $row_exam['test_id'],
                          'name'          => $row_exam['test_name'],
                          'url'           => '/toefl/direction_first.php?test_id='.$row_exam['test_id'],
                          'name_cate'     => 'Thi thử TOEFL',
                          'link_cate'     => 'http://'.$_SERVER['HTTP_HOST'].'/khoa-hoc/9-chung-chi-toefl-thi-thu-toefl-ibt.html');
      array_push($exam_array,$data_array);
      unset($data_array);
   }unset($db_exam);
   //Select de thi ielts
   $db_exam = new db_query('SELECT * FROM ielts WHERE ielt_active = 1 ORDER BY ielt_date,ielt_name DESC');
   while($row_exam = mysqli_fetch_assoc($db_exam->result)){
      $data_array = array();
      $data_array = array('id'            => $row_exam['ielt_id'],
                          'name'          => $row_exam['ielt_name'],
                          'url'           => '/ielts/direction_first.php?test_id='.$row_exam['ielt_id'],
                          'name_cate'     => 'Thi thử IELTS',
                          'link_cate'     => 'http://'.$_SERVER['HTTP_HOST'].'/khoa-hoc/35-chung-chi-ielts-thi-thu-ielts.html');
      array_push($exam_array,$data_array);
      unset($data_array);
   }unset($db_exam);

   return $exam_array;
}

//Lưu điểm
function save_score_user($true_ques,$ques,$course,$unit,$type,$uid){
   $total_score = round((10 * $true_ques)/$ques,1);
   $db_query = new db_query('SELECT user_score_id
                             FROM user_score
                             WHERE user_score_uid = '.$uid.' AND user_score_course_id = '.$course.' AND user_score_unit_id='.$unit.' AND user_score_type='.$type);
   if($row = mysqli_fetch_assoc($db_query->result)){
      $user_score_id = $row['user_score_id'];
      $db_execute = new db_execute(	"UPDATE user_score
      										 SET user_score_total = ".$total_score." , user_score_time = ".time()."
      										 WHERE user_score_id = ".$user_score_id );
      unset($db_execute);
   }else{
      $sql_insert = "INSERT INTO user_score  VALUES (NULL,". $uid .",". $course .", ". $unit ." , ". $total_score ." , ". $type ." , ". time() .")";
      $db_ins = new db_execute_return();
      $id_noti = $db_ins->db_execute($sql_insert);
      unset($db_ins);
   }
}

// GET điểm
function get_score_user($user_score_uid,$user_score_course_id,$user_score_unit_id,$user_score_type){
   $total_score = "";
   $db_query = new db_query('SELECT user_score_total
                             FROM user_score
                             WHERE user_score_uid = '.$user_score_uid.' AND user_score_course_id = '.$user_score_course_id.' AND user_score_unit_id='.$user_score_unit_id.' AND user_score_unit_id='.$user_score_unit_id.' AND user_score_type='.$user_score_type);
   if($row = mysqli_fetch_assoc($db_query->result)){
      $total_score = $row['user_score_total'];
   }else{
      $total_score = "Chưa có ";
   }
   return $total_score;
}

function score_average_unit($user_id,$unit_id,$course_id,$type){
   $total = 0;
   $record = 0;
   $result = 0;
   if($type == 2){
   $db_query = new db_query('SELECT user_score_total
                             FROM user_score
                             WHERE user_score_uid = '.$user_id.' AND user_score_unit_id='.$unit_id);
   }else{
   $db_query = new db_query('SELECT user_score_total
                             FROM user_score
                             WHERE user_score_uid = '.$user_id.' AND user_score_course_id='.$course_id);
   }
   while($row = mysqli_fetch_assoc($db_query->result)){
     $result = $result +$row['user_score_total'];
     $record++;
   }
   if($record != 0){
      $total = round(($result/$record),1);
   }else{
      $total = 0;
   }
   return $total;
}

/*
 * @param: Bảng, tên cột parent id, tên cột id
 * @return: Mảng các id cat con
 */
function db_get_children_array($parent_id,$table,$id_col,$parent_id_col){
	$return = array();
	$db_query = new db_query('SELECT '.$id_col.' FROM '.$table.' WHERE '.$parent_id_col.' = '.$parent_id);
	while($db_row = mysqli_fetch_assoc($db_query->result)){
		array_push($return,$db_row[$id_col]);
	}
	return $return;
}

//Tìm chuỗi các cha, phục vụ breadcrumb
function db_find_parents_trail($id,$root_value,$table,$id_col,$parent_id_col){
	$return = array();

	//get the current node info
	$db_query = new db_query('SELECT * FROM '.$table.' WHERE '.$id_col.' = '.$id);
		$return[] = mysqli_fetch_assoc($db_query->result);
		unset($db_query);

	$i=0;

	while($return[$i][$parent_id_col]!=$root_value){
		$db_query = new db_query('SELECT * FROM '.$table.' WHERE '.$id_col.' = '.$return[$i][$parent_id_col]);
		$return[] = mysqli_fetch_assoc($db_query->result);
		unset($db_query);
		$i++;
	}

	return $return;
}

function breadcrumb_cate_page($iCate,$type = 1){
   $nodes = array();
   $cat_trails = db_find_parents_trail($iCate,'0','categories_multi','cat_id','cat_parent_id');
   foreach($cat_trails as $trail){
   array_unshift($nodes,array('text' => $trail['cat_name'],
			                  'link' => ''.gen_url_category($trail['cat_id'])));
   }
   $breadcrumb = '';
   if($type == 1){
      //Trang chủ
      array_unshift($nodes,array('text' => 'Trang chủ',
   		                     'link' => ''.'http://'.$_SERVER['HTTP_HOST']));
      $i = 0;
      foreach($nodes as $node){
         if($i != 0){
         	$breadcrumb.=' <span></span> ';
         }
         if($i == sizeof($nodes)-1){$breadcrumb.='<a class="current">';}
         if($node['link'] != '' && $i != sizeof($nodes)-1){
         	$breadcrumb.= '<a href="'.$node['link'].'">'.$node['text'].'</a>';
         }else{
         	$breadcrumb.= '<a href="'.$node['link'].'">'.$node['text'].'</a>';
         }
         if($i == sizeof($nodes)-1){$breadcrumb.='</a>';}
         $i++;
      }
   }else{
      $i = 0;
      foreach($nodes as $node){
         if($i != 0){
         	$breadcrumb.=' <span></span> ';
         }
        	$breadcrumb.= '<a href="'.$node['link'].'"<span></span>'.$node['text'].'</a>';
         $i++;
      }
   }
   return $breadcrumb;
}

function breadcrumb_cate_lib_page($iCate,$type = 1){
   $nodes = array();
   $cat_trails = db_find_parents_trail($iCate,'0','library_cate','lib_cat_id','lib_cat_parent_id');
   foreach($cat_trails as $trail){
   array_unshift($nodes,array('text' => $trail['lib_cat_name'],
			                  'link' => ''.gen_url_lib_category($trail['lib_cat_id'])));
   }
   $breadcrumb = '';
   if($type == 1){
      //Trang chủ
      array_unshift($nodes,array('text' => 'Trang chủ',
   		                     'link' => ''.'http://'.$_SERVER['HTTP_HOST']));
      $i = 0;
      foreach($nodes as $node){
         if($i != 0){
         	$breadcrumb.=' <span></span> ';
         }
         if($i == sizeof($nodes)-1){$breadcrumb.='<a class="current">';}
         if($node['link'] != '' && $i != sizeof($nodes)-1){
         	$breadcrumb.= '<a href="'.$node['link'].'">'.$node['text'].'</a>';
         }else{
         	$breadcrumb.= $node['text'];
         }
         if($i == sizeof($nodes)-1){$breadcrumb.='</a>';}
         $i++;
      }
   }else{
      $i = 0;
      foreach($nodes as $node){
         if($i != 0){
         	$breadcrumb.=' <span></span> ';
         }
        	$breadcrumb.= '<a href="'.$node['link'].'"<span></span>'.$node['text'].'</a>';
         $i++;
      }
   }
   return $breadcrumb;
}

function breadcrumb_cate_news_page($iCate,$type = 1){
   $nodes = array();
   $cat_trails = db_find_parents_trail($iCate,'0','post_category','pcat_id','pcat_parent_id');
   foreach($cat_trails as $trail){
   array_unshift($nodes,array('text' => $trail['pcat_name'],
			                  'link' => ''.gen_url_news_category($trail['pcat_id'])));
   }
   $breadcrumb = '';
   if($type == 1){
      //Trang chủ
      array_unshift($nodes,array('text' => 'Trang chủ',
   		                     'link' => ''.'http://'.$_SERVER['HTTP_HOST']));
      $i = 0;
      foreach($nodes as $node){
         if($i != 0){
         	$breadcrumb.=' <span></span> ';
         }
         if($i == sizeof($nodes)-1){$breadcrumb.='<a class="current">';}
         if($node['link'] != '' && $i != sizeof($nodes)-1){
         	$breadcrumb.= '<a href="'.$node['link'].'">'.$node['text'].'</a>';
         }else{
         	$breadcrumb.= $node['text'];
         }
         if($i == sizeof($nodes)-1){$breadcrumb.='</a>';}
         $i++;
      }
   }else{
      $i = 0;
      foreach($nodes as $node){
         if($i != 0){
         	$breadcrumb.=' <span></span> ';
         }
        	$breadcrumb.= '<a href="'.$node['link'].'"<span></span>'.$node['text'].'</a>';
         $i++;
      }
   }
   return $breadcrumb;
}

function get_cou_les_in_cate($str_cat_id = '',$cat_type = '',$page = 1){
	$list_block             = array();
	$list_block['id']       = $str_cat_id;
	$list_block['title']    = '';
	$list_block['desc']     = '';
	$list_block['package_type'] = 0;
	$list_block['item']     = array();
	$list_block['cid']      = array();
	$list_block['type']     = '';

   switch($cat_type){
   case 1:
   	$categories_table = 'categories_multi';
   	$posts_table = 'courses';
   	$posts_prefix = 'cou';
   	$content_table = 'courses_multi';
   	$content_table_order_col = 'com_num_unit';
   	$content_prefix = 'com';
      $list_block['package_type'] = 1;
   	break;
   case 0:
   	$categories_table = 'categories_multi';
   	$posts_table = 'skill_lesson';
   	$posts_prefix = 'skl_les';
   	$content_table = 'skill_content';
   	$content_table_order_col = 'skl_cont_order';
   	$content_prefix = 'skl_cont';
      $list_block['package_type'] = 2;
   	break;
   }
   $db_count = new db_count("SELECT COUNT(*) as count FROM ".$posts_table." WHERE ".$posts_prefix."_cat_id IN (".$list_block['id'].") AND ".$posts_prefix."_active = 1 ORDER BY ".$posts_prefix."_order ASC");
   $list_block['total'] = $db_count->total;
   $per_page = 10;
   $start = ($page - 1)*$per_page;
   $db_query = new db_query("SELECT * FROM ".$posts_table." WHERE ".$posts_prefix."_cat_id IN (".$list_block['id'].") AND ".$posts_prefix."_active = 1 ORDER BY ".$posts_prefix."_order ASC LIMIT ".$start.",".$per_page."");

   unset($db_count);
   while($db_result = mysqli_fetch_assoc($db_query->result)){
   	$data_array = array(	'id'			   =>	$db_result[$posts_prefix.'_id'],
                           'cat_id'       => $db_result[$posts_prefix.'_cat_id'],
   								'title'		   =>	$db_result[$posts_prefix.'_name'],
   								'desc'		   =>	$db_result[$posts_prefix.(($cat_type==0)?"_desc":'_info')],
   								'img'			   => 'http://'.$_SERVER['HTTP_HOST'].(($cat_type==1)?'/pictures/courses/':'/pictures/skill_lesson/').$db_result[$posts_prefix.(($cat_type==1)?'_avatar':'_img')],
   								'url'			   => (($cat_type==1)? gen_intro_course($db_result[$posts_prefix.'_id'],$db_result[$posts_prefix.'_name']):gen_sk_les_v3($db_result[$posts_prefix.'_id'])),
   								'children'	   => array());


   	if($cat_type==1){
   		$db_query2 = new db_query("SELECT * FROM ".$content_table." WHERE ".$content_prefix."_".(($cat_type==0)?"les":$posts_prefix)."_id = ".$data_array['id']." AND ".$content_prefix."_active = 1 ORDER BY ".$content_table_order_col." ASC");
   		while($db_result2 = mysqli_fetch_assoc($db_query2->result)){
   			array_push($data_array['children'],array(	'id'		=> $db_result2[$content_prefix.'_id'],
   																	'title'	=> $db_result2[$content_prefix.(($cat_type==1)?'_name':'_title')],
   																	'desc'	=> $db_result2[$content_prefix.'_content'],
   																	'img'		=> 'http://'.$_SERVER['HTTP_HOST'].'/pictures/unit/'.$db_result2[$content_prefix.'_picture'],
   																	'url'		=> gen_course_les_v3($db_result2[$content_prefix.'_id'])));
   		}
   		unset($db_result2);
   		unset($db_query2);
   	}
      /*
		$data_array['count'] = sizeof($data_array['children']);
		if(sizeof($data_array['children'])>0){
			$data_array['url'] = $data_array['children'][0]['url'];
		}
      */
		array_push($list_block['item'],$data_array);
		array_push($list_block['cid'],$data_array['id']);
		unset($data_array);
   }
   unset($db_result);
   unset($db_query);
   return $list_block;
}

function get_tests_in_cate($iCate = 0,$str_cate_id = '',$page = 1){
	$list_block             = array();
	$list_block['id']       = $iCate;
	$list_block['title']    = '';
	$list_block['desc']     = '';
	$list_block['item']     = array();
	$list_block['cid']      = array();
	$list_block['type']     = 'tests';
   switch($iCate){
      	case 0:
		case 76:
		case 161:
		case 165:
		case 170:
			$test_table 			= 'toeic';
			$prefix 				= 'toeic';
			$url_prefix 			= '/toeic/toeic_listening.php?test_id=';
         	$path_img_test 			= '/pictures/toeic/';
       	 	$list_block['title']    = 'Đề thi thử TOEIC';
			break;
		case 9:
			$test_table 			= 'test';
			$prefix 				= 'test';
			$url_prefix 			= '/toefl/direction_first.php?test_id=';
         	$path_img_test 			= '/pictures/test/';
         	$list_block['title']    = 'Đề thi thử TOEFL';
			break;
		case 35:
			$test_table 			= 'ielts';
			$prefix 				= 'ielt';
			$url_prefix 			= '/ielts/direction_first.php?test_id=';
			$path_img_test 			= '/pictures/ielts/';
			$list_block['title']    = 'Đề thi thử IELTS';
			break;
      case 232:
			$test_table 			= 'uni_test';
			$prefix 				= 'uni_test';
			$url_prefix 			= '/testuni/toeic_reading.php?test_id=';
         	$path_img_test 			= '/pictures/test/';
         	$list_block['title']    = 'Đề thi thử Đại học';
			break;
 	}
   if($iCate != 0 && $str_cate_id == ''){
      $db_count = new db_count('SELECT COUNT(*) as count FROM '.$test_table.' WHERE '.$prefix.'_active = 1 AND '.$prefix.'_cat_id = '.$iCate);
      $list_block['total'] = $db_count->total;
      $per_page = 10;
      $start = ($page - 1)*$per_page;
      $db_query = new db_query("SELECT * FROM ".$test_table." WHERE ".$prefix."_active = 1 AND ".$prefix."_cat_id = ".$iCate." LIMIT ".$start.",".$per_page);
   }elseif($iCate == 0 && $str_cate_id != ''){
      $db_count = new db_count('SELECT COUNT(*) as count FROM '.$test_table.' WHERE '.$prefix.'_active = 1 AND '.$prefix.'_cat_id  IN ('.$str_cate_id.')');
      $list_block['total'] = $db_count->total;
      $per_page = 10;
      $start = ($page - 1)*$per_page;
      $db_query = new db_query("SELECT * FROM ".$test_table." WHERE ".$prefix."_active = 1 AND ".$prefix."_cat_id IN (".$str_cate_id.") LIMIT ".$start.",".$per_page);
   }

	while($db_result = mysqli_fetch_assoc($db_query->result)){
		$data_array = array(	'id'		=> $db_result[$prefix.'_id'],
                        		'cat_id'    => $db_result[$prefix.'_cat_id'],
								'title'		=> $db_result[$prefix.'_name'],
								'desc'		=> '',
								'img'		=> 'http://'.$_SERVER['HTTP_HOST'].$path_img_test.$db_result[$prefix.'_image'],
								'url'		=> $url_prefix.$db_result[$prefix.'_id'],
								'children'	=> array());
		array_push($list_block['item'],$data_array);
		array_push($list_block['cid'],$data_array['id']);
	}
   unset($db_result);
   unset($db_query);
   return $list_block;
}

//Xóa tag
function delete_tags($post_id,$group_type,$type){
   $db_exe = new db_execute('DELETE FROM tags_posts WHERE tp_post_id = '.$post_id.' AND tp_group_type = '.$group_type.' AND tp_type = '.$type);
   unset($db_exe);
}

//Lưu tag
function save_tags($post_id,$str_tags,$group_type,$type){
   //Xóa các tag cũ
   delete_tags($post_id,$group_type,$type);
   //Cập nhật tag mới
   $str_tags = trim($str_tags);
   $str_tags = mb_strtolower($str_tags,"UTF-8");
   $arr_tag = explode(",",$str_tags);
   foreach($arr_tag as $tag){
      $tag = trim($tag);
      $db_chk = new db_query("SELECT * FROM tags WHERE tag_name = '".$tag."'");
      $row_chk = mysqli_fetch_assoc($db_chk->result);
      unset($db_chk);
      if($row_chk){
         $last_tag_id = $row_chk['tag_id'];
      }else{
         $db_insert = new db_execute_return();
         $last_tag_id = $db_insert->db_execute('INSERT INTO tags (tag_name) VALUES ("'.$tag.'")');
         unset($db_insert);
      }
      $db = new db_query('SELECT tp_id FROM tags_posts WHERE tp_tag_id = '.$last_tag_id.' AND tp_post_id = '.$post_id.' AND tp_type = '.$type);
      if(mysqli_num_rows($db->result) == 0){
         $db_insert = new db_execute('INSERT INTO tags_posts(tp_tag_id,tp_post_id,tp_group_type,tp_type) VALUES('.$last_tag_id.','.$post_id.','.$group_type.','.$type.')');
         unset($db_insert);
      }
      unset($db);
   }
}
//Lấy mảng tag
function get_tags($post_id,$group_type,$type){
   $arr_tag = array();
   $db = new db_query('SELECT * FROM tags_posts JOIN tags ON tp_tag_id = tag_id
                       WHERE tp_post_id = '.$post_id.' AND tp_group_type = '.$group_type.' AND tp_type = '.$type);
   while($row = mysqli_fetch_assoc($db->result)){
      $data = array('tag_name'   => $row['tag_name'],
                    'tag_url'    => gen_tags_url($row['tag_id'],$row['tag_name']));
      array_push($arr_tag,$data);
   }unset($db);

   return $arr_tag;
}
//Lấy string category
function gen_str_cate($cat_id,$table,$id_col,$parent_id_col,$name_col){
   $str_tag    = '';
   $cat_trails = db_find_parents_trail($cat_id,'0',$table,$id_col,$parent_id_col);
   $count      = sizeof($cat_trails);
   $i = 0;
   foreach($cat_trails as $trail){
      $i++;
      if($i == $count) $str_tag .= $trail[$name_col];
      else $str_tag .= $trail[$name_col].',';
   }
   return $str_tag;
}
//update exp
function update_exp($user_id){
   $sqlActCout = new db_query("SELECT * FROM users WHERE use_id = ".$user_id );
   $rowActCout = mysqli_fetch_assoc($sqlActCout->result);
   $iCattemp = $rowActCout['use_cattemp_id'];
   $iLevtemp = $rowActCout['use_levtemp_id'];
   $time_off = $rowActCout['use_temp_time']+(24*3600);
   $time = time();
   if($time > $time_off){
     $sql = "UPDATE user_action SET usea_login = 0,usea_edit = 0,usea_ava = 0,usea_main = 0,usea_gram = 0,usea_voc = 0,usea_quiz = 0,usea_speaking = 0,usea_writing = 0,usea_hay = 0,usea_share = 0 WHERE usea_use_id = ".$rowActCout['use_id'];
     $db_reset = new db_execute($sql);
     unset($db_reset);
     $db_update_time = new db_execute("UPDATE users SET use_temp_time = ".$time." WHERE use_id = ".$rowActCout['use_id']);
     unset($db_update_time);
   }
}
//no avatar
function noavatar($user_id){
   $img_path = "";
   $db_stu = new db_query("SELECT * FROM users WHERE use_id=".$user_id);
   if($row_stu = mysqli_fetch_assoc($db_stu->result)){
      if($row_stu['use_gender'] == 1){
         $img_path = 'http://hoc123.vn/themes_v2/images/nam.png';
      }else{
         $img_path = 'http://hoc123.vn/themes_v2/images/nu.png';
      }
   }
   return $img_path;
}
//Gen message for sharing courses
function get_mes_sharing_cou($iCate = 0){
   //Find id root cate
   $nodes = array();
   $cat_trails = db_find_parents_trail($iCate,'0','categories_multi','cat_id','cat_parent_id');
   foreach($cat_trails as $trail){
   array_unshift($nodes,array('id'   => $trail['cat_id'],
                              'text' => $trail['cat_name'],
			                     'link' => ''.gen_course_cate_v3($trail['cat_id'])));
   }
   $arr_mes = array();
   $root_cate_id = $nodes[0]['id'];
   switch($root_cate_id){
      case 2:
         $arr_mes[] = 'Học dốt Tiếng Anh mà học cái này xong thấy lên trình vãi :))) ';
         /*$arr_mes[] = 'Số được gặp Tây :)) đêm qua vừa cày bài Advanced về giao thông, sáng nay được Anh Tây đẹp zai hỏi đường,
                       anh cứ khen mình xinh với nói Tiếng Anh giỏi, sướng cả ngày =)))) hihi';*/
         $arr_mes[] = 'Bị thích học ở trang này ý :x giọng Tiếng Anh nghe chuẩn và hay thế :x';
         $arr_mes[] = 'Ai đang muốn học Tiếng Anh giao tiếp thì học khóa này đi này, từ cơ bản đến nâng cao luôn, đỡ phải đi tìm thầy :D';
         $arr_mes[] = 'Ngồi luyện chưởng nói bắt chước theo mà cũng được phết =))) Tây ơi chờ em :x :))';
         break;
     case 37:
         //$arr_mes[] = 'Cô ... đang tìm người dạy tiếng anh lớp 6 cho em đúng không? Cháu thấy trang này được này, cô đỡ mất thời gian đưa em đi học hehe';
         $arr_mes[] = 'Anh em ơi, t tìm được trang web này, đủ bộ kiến thức luôn, ấm bụng đi ngủ rồi nhé :)) tha hồ mà lên cày kiểm tra với thi mà đỡ phải nhờ vả ai hahaa sướng quá ';
         $arr_mes[] = 'Ai bảo cứ phải ra lò mà luyện nào :)) ở nhà ngồi mát học online sướng hơn ý :D';
         $arr_mes[] = 'Chả biết các bạn thế nào, chứ mình thấy học Tiếng Anh online vừa tiện lại hiệu quả, người ta cập nhật đủ kiến thức, xong có bài tập ở dưới luôn, chả cần phải đi học thêm nhiều mà kiến thức vẫn đủ';
         $arr_mes[] = 'Ai thiếu sót kiến thức lớp nào thì vào web này mà học này, vừa rẻ lại vừa hấp dẫn :x';
         break;
     case 197:
         $arr_mes[] = 'Các mẹ muốn cho con học Tiếng Anh thì vào đây này, mình thấy hay phết :D bọn trẻ con vừa xem hoạt hình vừa học luôn';
         $arr_mes[] = 'Cứ thắc mắc sao con cháu có 5 tuổi mà hát Tiếng Anh siêu thế :)) hóa ra là ngày nào nó cũng vào đây để hát :))';
         //$arr_mes[] = 'Phải công nhận cái Super Star Kids trong hoc123 hay thật, sắp xếp khoa học bọn trẻ con dễ học theo, nó biết còn nhiều từ hơn mình :(( GATO vãi :(';
         $arr_mes[] = 'Đọc đoạn con em mô tả bố bằng Tiếng anh cười đau ruột :))) cơ mà được cái đứa chị như mình cũng đã tìm được cho nó cái web tin cậy để học :x';
         $arr_mes[] = 'Nghe bọn trẻ con đọc Tiếng Anh đáng yêu thế :x bây giờ chúng nó còn quay ra bảo mình phát âm sai, không giống như video dạy =)))';
         break;
     case 27:
         $arr_mes[] = 'Toeic ở trường dạy chán vãi, may có mấy đứa giới thiệu cho web này, không chắc tử trận mất ';
         $arr_mes[] = 'T tìm được web này dạy Toeic này, đủ kĩ năng với bài tập kèm theo luôn, tiện phết, bọn m thử vào xem nhé :D';
         //$arr_mes[] = 'Vào thấy có dạy Toeic trên 750 :)) thử cày để đua đòi với chúng bạn =))';
         $arr_mes[] = 'Có đề thi thử Toeic hay phết này, vào làm thử  xem đứa nào cao điểm nhất đê ;;)';
         $arr_mes[] = 'Học trên web này đủ hết, đỡ phải mua sách nhiều hê hê';
         $arr_mes[] = '';
         break;
     case 4:
         $arr_mes[] = 'Share là được học miễn phí, sao không biết trang web này sớm hơn :))';
         $arr_mes[] = 'Nhiều gói học hay quá :x quyết tâm học hết mới được :x';
         $arr_mes[] = 'Thấy nhiều người bảo học TOEFL khó lắm, em vào học trong này thấy ổn phết, làm được bài tập kha khá đấy :D';
         break;
     case 28:
         $arr_mes[] = 'Ielts  :( Niềm sợ hãi của em, nhưng giờ đây đỡ sợ hơn rồi hahaaaaaa';
         $arr_mes[] = 'Chưa bao giờ học Ielts nên cũng không biết thế nào, học ở đây rồi thấy thích quá :x tự tin chém gió với anh em rồi hehe';
         $arr_mes[] = 'Thích mấy bài nghe của khóa này quá đi, ôi admin nhớ cho thêm nhé :x';
         break;
     case 1:
         $arr_mes[] = 'Học khóa này mới thấy nhiều cái mình chưa biết hix hix thôi muộn còn hơn không ;;)';
         //$arr_mes[] = 'Hê hê, học xong gói Upper Intermediate 2 này :)) tha hồ mà sướt mướt với sếp =))))';
         $arr_mes[] = 'Học Tiếng anh văn phòng thích quá :x nói được nhiều hơn hẳn so với hồi xưa :x';
         $arr_mes[] = 'Bô lô ba la 1 hồi trên này cũng xong bài tập :)) ai chưa biết làm thế nào thì vào đây cày 1 lúc là ra đấy hehe';
         $arr_mes[] = 'Đừng làm anh cáu, anh đang học đấy :)))';
         break;
     case 26:
         $arr_mes[] = 'Đang cần là có :)) mai đi phỏng vấn chắc cũng chém được 1 ít :x';
         $arr_mes[] = 'Chả biết gì tiếng anh kinh doanh, các anh chị ở công ty cứ nói ầm ầm ý :(( không muốn thua bạn thua bè nên phải học ';
         $arr_mes[] = 'Em thấy khóa này được lắm này, vừa tiện lại vừa nhanh lên trình độ :x';
         break;
     case 3:
         $arr_mes[] = 'Quần áo, giày dép :)) bây h tự tin đi shopping nước ngoài rồi hahaa';
         $arr_mes[] = 'Sau nhiều tiếng chăm chỉ học hành, mai tự tin đi kiểm tra rồi :x';
         $arr_mes[] = 'Ai học khóa này cũng được ý, biết thêm nhiều từ cực luôn';
         $arr_mes[] = 'Thấy con bạn đọc lưu loát nhiều từ cũng phải mò ra học :)) hay quá đi ý ';
         break;
   }
   $arr_mes[] = 'Học là thích - Thích là nhích';
   $arr_mes[] = 'Chưa bao giờ học Tiếng Anh dễ đến thế';
   $arr_mes[] = 'Chinh phục ngôn ngữ - Bạn có thể?';
   $arr_mes[] = 'Cùng hoc123 biến điều không thể thành có thể';
   $arr_mes[] = 'Dễ dàng đăng kí, thanh toán nhanh gọn, học Tiếng Anh hiệu quả';
   $arr_mes[] = 'Tiếng Anh - Bạn vẫn đang sợ nó?';
   $arr_mes[] = 'Quyết định tương lai của bạn chỉ bằng 1 click';
   $arr_mes[] = 'Khóa học Tiếng Anh vừa rẻ vừa chất lượng ';
   $arr_mes[] = 'Your life  - your chance but my way. You want to try it?';
   $rand_key = array_rand($arr_mes,1);

   return $arr_mes[$rand_key];
}

function update_time_log($user_act_id,$time_date){
   $date = strtotime(date("d-m-Y",$time_date));
   $sql = "UPDATE user_activity_log SET user_act_time_date=".$date."  WHERE user_act_id=".$user_act_id;
   $db_inc = new db_execute($sql);
   unset($db_inc);
}

function update_time_noti($user_noti_id,$time_date){
   $date = strtotime(date("d-m-Y",$time_date));
   $sql = "UPDATE user_notification SET user_noti_time_date=".$date."  WHERE user_noti_id=".$user_noti_id;
   $db_inc = new db_execute($sql);
   unset($db_inc);
}

function redirect_301($url_new) {
   $url_old =  urldecode($_SERVER['REQUEST_URI']);
   $domain  = 'http://hoc123.vn';
   $url_new = $domain.$url_new;
   if ($url_old != $url_new) {
      header( "HTTP/1.1 301 Moved Permanently" );
      header( "Location: " . $url_new);
   }
}

function convertname($str){
	if($str != "" || $str != NULL){
		$str = explode(" ",$str);
		$count = count($str);
		return $str[$count-1];
	}else{
		return 'Tân Binh';
	}
}

// Hàm check nếu không đủ thông tin thì bắt nhập
function checkuserinfo($logged,$name,$phone){
	$base_url = $_SERVER['HTTP_HOST'];
	if($logged == 1){
		if($name == '' || $name == NULL || $phone == '' || $phone = NULL){
			redirect("http://".$base_url."/user/info.html");
		}
	}
}

// Hàm trả về trạng thái active 1: Được học , 0 : Không được học
function check_course_active($user_id){
	$active = 0;
	$dbCheckUser 	= 	new db_query('SELECT * FROM user_active WHERE uactive_user_id = "'.$user_id.'"');
	$numUserActive  =	mysqli_num_rows($dbCheckUser->result);
	if($numUserActive <= 0){
		$active = 0;
	}else{
		$curTime 		=	time();
		$arrUser		= 	$dbCheckUser->resultArray();
		if($arrUser[0]['uactive_end_date'] > $curTime){
			$active = 1;
		}else{
			$active = 0;
		}
	}
	return $active;
}

// Hàm đếm số ngày học còn lại
function check_course_active_date($user_id){
	$count = 0;
	$dbCheckUser 	= 	new db_query('SELECT * FROM user_active WHERE uactive_user_id = "'.$user_id.'"');
	$numUserActive  =	mysqli_num_rows($dbCheckUser->result);
	if($numUserActive <= 0){
		$count = 0;
	}else{
		$curTime 		=	time();
		$arrUser		= 	$dbCheckUser->resultArray();
		if($arrUser[0]['uactive_end_date'] > $curTime){
			$count = intval(($arrUser[0]['uactive_end_date'] - $curTime)/(24*3600));
		}else{
			$count = 0;
		}
	}
	return $count;
}

// Hàm hiển thị Audio mới
function showaudio($urlfile,$ref){
	$media 	= 	"";
	$media .=	"<script type='text/javascript'>
                	$(document).ready(function(){
					$('#play_".$ref."').jPlayer({
						ready: function (event) {
							$(this).jPlayer('setMedia', {
								wav:'".$urlfile."',
							});
						},
						cssSelectorAncestor: '#playcon_".$ref."',
						swfPath: 'js',
						supplied: 'wav',
						wmode: 'window'
					});
				});
                </script>";
    $media .=	'<div id="play_'.$ref.'" class="jp-jplayer"></div>
				<div id="playcon_'.$ref.'" class="jp-audio">
					<div class="jp-type-single">
						<div class="jp-gui jp-interface">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
							</ul>
							<div class="jp-progress">
								<div class="jp-seek-bar">
									<div class="jp-play-bar"></div>
								</div>
							</div>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
							<div class="jp-time-holder">
								<div class="jp-current-time"></div>
								<div class="jp-duration"></div>

								<ul class="jp-toggles">
									<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
									<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
								</ul>
							</div>
						</div>
						<div class="jp-no-solution">
							<span>Update Required</span>
							To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
						</div>
					</div>
				</div>';
		return $media;
}

function get_banner($type){
	$arr_img = '';
	$db_select = new db_query('SELECT * FROM slides WHERE slide_type='.$type.' ORDER BY slide_order');
	$arr_img = $db_select->resultArray();
	return $arr_img;
}
function get_intro($type){
	$arr_intro = '';
	$db_select = new db_query('SELECT * FROM introductions WHERE intro_positions='.$type);
	$arr_intro = $db_select->resultArray();
	return $arr_intro;
}

?>