<?
include ("inc_security.php");
checkAddEdit("add");
$fs_action = getURL();
$record_id = getValue("record_id","int","GET","");
$media_type = getValue("media_type","int","GET",0);
$url_name = getValue("url","str","GET","");

?>
<div style="text-align: center;">
   <?if($media_type == 3){?>
      <object width="500" height="282">
         <embed src="<?=$imgpath.$url_name?>" width="790" height="282" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed>
      </object>
   <?}
   if($media_type == 2){
      $url = $imgpath.$url_name;   
      loadmedia($url,200,200);
   } 
   if($media_type == 1){
      echo '<img src="'.$imgpath.'medium_'.$url_name.'" />';
   }?>
   
   
   <?
   if($media_type == 1){
      echo '<img src="'.$imgpath.'medium_'.$url_name.'" />';
   {
      $url = $imgpath.$url_name;   
      loadmedia($url,200,200);
   }elseif($media_type == 3)
   {
      echo '<a class="a_detail" title="View Flash" class="thickbox noborder a_detail" href="view_flash.php?url='. base64_encode(getURL()) . '&media_type = '. $type_media .'&url=' . $url . '&TB_iframe=true&amp;height=200&amp;width=600" /><b>View Flash</b></a>';
   }
   ?>
</div>
