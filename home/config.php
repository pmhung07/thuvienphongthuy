<?
ob_start();
@session_start();
require_once("initsession.php");

// Bootstrap appliation
require_once '../bootstrap/setup.php';
require_once("../functions/app_functions.php");

require_once("../includes/inc_config_variable.php");
require_once("../classes/database.php");
require_once("../classes/generate_form.php");
require_once("../classes/form.php");
require_once("../classes/upload.php");
require_once("../classes/menu.php");
require_once("../classes/user.php");
require_once("../classes/openid.php");
require_once("../classes/class.seo.php");
require_once("../classes/html_cleanup.php");
require_once("../classes/comments.php");
require_once("../classes/category.php");
require_once("../classes/tag.php");
require_once("../functions/resize_image.php");
require_once("../functions/functions.php");
require_once("../functions/functions.propel.php");
require_once("../functions/money.php");
require_once("../functions/lesson/lesson_main.php");
require_once("../functions/lesson/lesson_main_edit.php");
require_once("../functions/lesson/lesson_gram.php");
require_once("../functions/lesson/lesson_gram_edit.php");
require_once("../functions/lesson/lesson_voca.php");
require_once("../functions/lesson/lesson_voca_edit.php");
require_once("../functions/lesson/lesson_quiz.php");
require_once("../functions/lesson/lesson_quiz_edit.php");
require_once("../functions/lesson/lesson_write.php");
require_once("../functions/lesson/lesson_speak.php");
require_once("../functions/lesson/lesson_main_toeic.php");
require_once("../functions/file_functions.php");
require_once("../functions/rewrite_functions.php");
require_once("../functions/pagebreak.php");
//require_once("../includes/inc_config_website.php");

/*if($_SERVER["SERVER_NAME"] != "tienganh2020.com"){
   	header("HTTP/1.1 301 Moved Permanently");
   	header("Location: http://tienganh2020.com".$_SERVER["REQUEST_URI"]);
   	redirect("http://tienganh2020.com" . $_SERVER["REQUEST_URI"]);
}*/

$myuser     = new user();
ob_clean();
?>