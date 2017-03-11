<?
   require_once("config.php");
   $test_id = getValue("test_id","int","GET",0); 
   redirect("direction.php?test_id=".$test_id);
?>