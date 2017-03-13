<?
error_reporting(0);
require_once("../../session.php");
//Kiem tra xem ip nay co duoc phep vao admin hay khong
$ip					= $_SERVER['REMOTE_ADDR'];
$check_ip_exists	= 1;
$check_ip 			= 0;
$mod_file			= 0;
//if(file_exists("../../ipstore/" . ip2long($ip) . ".cfn")){
//$check_ip_exists	= 1;
//}

$array_ip = array("58.",
						"61.28.",
						"65.110.",
						"69.13.",
						"113.",
						"115.",
						"116.",
						"117.",
						"118.",
						"119.",
						"120.",
						"122.",
						"123.",
						"124.",
						"125.",
						"126.",
						"127.",
						"134.159.",
						"169.211.",
						"172.",
						"183.",
						"192.",
						"195.",
						"196.",
						"197.",
						"198.",
						"199.",
						"200.",
						"201.",
						"202.",
						"203.77.",
						"203.99.",
						"203.113.",
						"203.119.",
						"203.128.",
						"203.160.",
						"203.161.",
						"203.162.",
						"203.170.",
						"203.171.",
						"203.176.",
						"203.189.",
						"203.190.",
						"203.191.",
						"203.201.",
						"203.210.",
						"204.",
						"205.",
						"206.",
						"210.",
						"218.100.",
						"218.186.",
						"219.",
						"220.",
						"221.",
						"222.",
						"223.",
                  "198."
						);

//Kiểm tra xem IP có nằm trong khỏang kiểm sóat hay ko?
$check_ip	= 1;
/*foreach ($array_ip as $m_key=>$m_value){
	//if (strpos($this->deny_ip,$m_value)!==false){
	if (strpos($ip,$m_value)===0){
		$check_ip = 1;
		break;
	}
}*/


if($check_ip_exists == 0 || $check_ip == 0){
	die("Ban chua co quyen vao day");
}
error_reporting(E_ALL);

// Bootstrap appliation
if(!defined('BASE_PATH')) {
	define('BASE_PATH', realpath(dirname(__DIR__ . '/../../../../')));
}

require_once BASE_PATH .'/bootstrap/setup.php';
require_once BASE_PATH .'/functions/app_functions.php';

require_once("../../../classes/database.php");
require_once("../../../classes/form.php");
require_once("../../../classes/htmlcleaner.php");
//require_once("../../../classes/generate_information_attribute.php");
//require_once("../../../classes/generate_information_group.php");
require_once("../../../functions/functions.php");
require_once("../../../functions/rewrite_functions.php");
require_once("../../../functions/file_functions.php");
//require_once("../../../functions/sql_function.php");
//require_once("../../../functions/date_functions.php");
//require_once("../../../functions/cucre_functions.php");
require_once("../../../functions/resize_image.php");
require_once("../../../functions/translate.php");
//require_once("../../../functions/functions_seo.php");
require_once("../../../functions/pagebreak.php");
require_once("../../../classes/generate_form.php");
require_once("../../../classes/form.php");
//require_once("../../../classes/Mobitek.php");
require_once("../../../classes/upload.php");
require_once("../../../classes/menu.php");
require_once("../../../classes/grid.php");
//require_once("../../../classes/memcached_store.php");
//require_once("../../../classes/PHPExcel.php");
//require_once("../../../classes/PHPExcel/IOFactory.php");

$version_transport	= "v0.1.6";
//require_once("../../../classes/transport/". $version_transport ."/Transport.php");


//require_once("../../../classes/money/users_money.php");
$wys_path				= "../../resource/wysiwyg_editor/";
require_once($wys_path . "fckeditor.php");

require_once("functions.php");
require_once("template.php");
$admin_id 				= getValue("user_id","int","SESSION");
$lang_id	 				= getValue("lang_id","int","SESSION");;

//phan khai bao bien dung trong admin
$fs_stype_css			= "../css/css.css";
$fs_template_css		= "../css/template.css";
$fs_border 				= "#f9f9f9";
$fs_bgtitle 			= "#DBE3F8";
$fs_imagepath 			= "../../resource/images/";
$fs_scriptpath 		= "../../resource/js/";
$fs_denypath			= "../../error.php";
$wys_cssadd				= array();
$wys_cssadd				= "/css/all.css";
$sqlcategory 			= "";
$fs_category			= checkAccessCategory();
//phan include file css

$load_header 			= '<link href="../../resource/css/css.css" rel="stylesheet" type="text/css">' . "\n";
$load_header 			.= '<link href="../../resource/css/template.css" rel="stylesheet" type="text/css">' . "\n";
$load_header 			.= '<link href="../../resource/css/grid.css" rel="stylesheet" type="text/css">' . "\n";
$load_header 			.= '<link href="../../resource/css/thickbox.css" rel="stylesheet" type="text/css">' . "\n";
$load_header 			.= '<link href="../../resource/css/calendar.css" rel="stylesheet" type="text/css">' . "\n";
$load_header 			.= '<link href="../../resource/css/backend.css" rel="stylesheet" type="text/css">' . "\n";
$load_header 			.= '<link href="../../resource/js/jwysiwyg/jquery.wysiwyg.css" rel="stylesheet" type="text/css">' . "\n";

//phan include file script
//$load_header 			.= '<script language="javascript" src="../../../js/jcopy/jquery.zclip.js"></script>' . "\n";
$load_header 			.= '<script language="javascript" src="../../resource/js/jquery-1.3.2.min.js"></script>' . "\n";
$load_header 			.= '<script language="javascript" src="../../resource/js/library.js"></script>' . "\n";
$load_header 			.= '<script language="javascript" src="../../resource/js/thickbox.js"></script>' . "\n";
$load_header 			.= '<script language="javascript" src="../../resource/js/calendar.js"></script>' . "\n";
$load_header 			.= '<script language="javascript" src="../../resource/js/tooltip.jquery.js"></script>' . "\n";
$load_header 			.= '<script language="javascript" src="../../resource/js/jquery.jeditable.mini.js"></script>' . "\n";
$load_header 			.= '<script language="javascript" src="../../resource/js/swfObject.js"></script>' . "\n";
$load_header 			.= '<script language="javascript" src="../../resource/js/jwysiwyg/jquery.wysiwyg.js"></script>' . "\n";

$fs_change_bg			= 'onMouseOver="this.style.background=\'#DDF8CC\'" onMouseOut="this.style.background=\'#FEFEFE\'"';

//phan ngon ngu admin
$db_language			= new db_query("SELECT tra_text,tra_keyword FROM admin_translate");
$langAdmin 				= array();
while($row=mysqli_fetch_assoc($db_language->result)){
	$langAdmin[$row["tra_keyword"]] = $row["tra_text"];
}
unset($db_language);

// Get config from database
$db_con	= new db_query("SELECT * from configuration");
if ($row=mysqli_fetch_array($db_con->result)){
	while (list($data_field, $data_value) = each($row)) {
		if (!is_int($data_field)){
			//tao ra cac bien config
			$$data_field = $data_value;
			//echo $data_field . "= $data_value <br>";
		}
	}
}
$db_con->close();
unset($db_con);

$lang_id			= getValue("lang_id", "int", "SESSION", 1);
$userlogin		= getValue("userlogin", "str", "SESSION", "", 1);
$password		= getValue("password", "str", "SESSION", "", 1);

$admin_id		= 0; // Lưu lại ID của user admin hiện tại
$is_admin		= 0; // Là Supper Admin hay không (=1 là super admin)
$admin_city_id = 0; // Lưu lại ID của city mà user hiện tại có quyền admin
$admin_job		= 0; // Lưu lại nghiệp vụ của nhân viên(cskh, kd, marketting)
// Check tài khoản Admin có hợp lệ ko
$db_admin_user = new db_query("SELECT *
							 			FROM admin_user
							 			WHERE adm_loginname='" . $userlogin . "' AND adm_password='" . $password . "' AND adm_active=1 AND adm_delete = 0");
if ($row = mysqli_fetch_assoc($db_admin_user->result)){
	$admin_id		= $row["adm_id"];
	$is_admin		= $row["adm_isadmin"];
	//$admin_city_id = $row['adm_city_id'];
	//$admin_job		= $row['adm_job'];
}
unset($db_admin_user);

// Hợp lệ thì mới cho xử lý tiếp
if($admin_id > 0){

	//$array_admin_city => Mảng chứa những city mà user hiện tại phụ trách
	// 1. Chứa id city và name
	//$arrayAdminCity	= get_admin_city($admin_id, $is_admin);
	//2. Chỉ chứa id của city
	//$array_admin_city	= array_keys($arrayAdminCity);


	//Nếu user hiện tại không phải phụ trách city nào thì deny luôn
	//if(count($array_admin_city) == 0) redirect($fs_denypath);

}else{ // Không hợp lệ thì ra trang thông báo lỗi
	redirect($fs_denypath);
}
?>
