<?
require_once("session.php");

// Bootstrap appliation
require_once '../bootstrap/setup.php';
require_once("../functions/app_functions.php");

//require_once("../functions/checkpostserver.php");
require_once("../functions/translate.php");
require_once("../functions/functions.php");
require_once("../classes/database.php");
//require_once("../classes/denyconnect.php");
//Chống bot truy cập
//$denyconnect = new denyconnect();
$loginpath="login.php";
if (!isset($_SESSION["logged"])){
	redirect($loginpath);
}
else{
	if ($_SESSION["logged"] != 1){
		redirect($loginpath);
	}
}
$framemainsrc = 'blank.htm';
$db_language			= new db_query("SELECT tra_text,tra_keyword FROM admin_translate");
$langAdmin 				= array();
while($row=mysqli_fetch_assoc($db_language->result)){
	$langAdmin[$row["tra_keyword"]] = $row["tra_text"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title><?=translate_text("Administrator")?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script type="text/javascript" src="resource/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="resource/js/jquery.layout.js"></script>
	<script type="text/javascript" src="resource/js/sortable/ui.core.js"></script>
	<script type="text/javascript" src="resource/js/sortable/ui.draggable.js"></script>
	<script type="text/javascript" src="resource/js/sortable/ui.sortable.js"></script>
	<link rel='stylesheet' href='resource/js/sortable/styles.css' type='text/css' media='all' />
	<script type="text/javascript">
	  // When the document is ready set up our sortable with it's inherant function(s)
	  $(document).ready(function() {
		 $("#test-list").sortable({
			handle : '.handle',
			update : function () {
			  var order = $('#test-list').sortable('serialize');
				$.ajax({
					url: "resource/process-sortable.php",
					type: "post",
					data: order,
					error: function(){
						alert("Lỗi load dữ liệu");
					},
					success: function(data) {
					 //alert(data);
				  }

				});
			}
		 });
		 $('body').layout({ applyDefaultStyles: true });
	});
	</script>
	<link rel="stylesheet" type="text/css" href="resource/css/layout.css">
</head>
<body>
  <iframe id="mainFrame" name="mainFrame" class="ui-layout-center"
	width="100%" height="600" frameborder="0" scrolling="auto"
	src="resource/intro.php"></iframe>
  <div class="ui-layout-north"><? include("resource/php/inc_header.php");?></div>
  <div class="ui-layout-west"><? include("resource/php/inc_left.php");?></div>
</body>
</html>