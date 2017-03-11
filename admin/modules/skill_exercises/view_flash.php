<?
include ("inc_security.php");
checkAddEdit("add");
$fs_action = getURL();
$record_id = getValue("record_id","int","GET","");
$game_url = getValue("game_url","str","GET","");
?>

<div>
   <object width="500" height="282">
      <embed src="<?=$fs_filepath_data.$game_url?>" width="790" height="282" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed>
   </object>
</div>