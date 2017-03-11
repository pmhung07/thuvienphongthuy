<?
include ("inc_security.php");
checkAddEdit("add");
$fs_action = getURL();
$record_id = getValue("record_id","int","GET","");
$media_type = getValue("media_type","int","GET",0);
$url = getValue("url_media","str","GET","");
?>
<?
if($media_type == 3){
?>
<div>
   <object width="500" height="282">
      <embed src="<?=$url?>" width="790" height="282" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed>
   </object>
</div>
<?}else{
   loadmedia($url,300,300);
}?>