<?php
require_once("../home/config.php");
$urlVid = getValue('urlVid','str','GET','');
get_media_library_v2($urlVid,'');
?>