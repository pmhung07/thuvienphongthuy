<?
include ("inc_security.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
	<div style="padding:12px;float:left;">
   	<?
   	$keyword = getValue("keyword","str","POST","",1,1);
      $check = getValue("check","str","POST","",1,1);
      $record_id = getValue("record_id","str","POST","",1,1);
   	$db_search = new db_query("SELECT * FROM skill_lesson
   										WHERE skl_les_active = 1 AND skl_les_name LIKE '%" . str_replace(" ","%",$keyword) . "%' 
                                                      OR skl_les_id LIKE '" . str_replace(" ","%",$keyword) . "' LIMIT 15");
   	
   	?>
   	<table cellpadding="5" cellspacing="0" style="border-collapse:collapse" border="1" bordercolor="#f2f2f2" bgcolor="#FFFFCC">
   		<tr>
   			<th width="100px">Tên khóa học</th>
   			<th>Thông tin khóa học</th>
   			<th>Chọn</th>
   		</tr>
      	<?while($row = mysql_fetch_assoc($db_search->result)){
      	  $info = removeHTML($row["skl_les_desc"]);  
         ?>
   		<tr>
   			<td><?=$row["skl_les_name"]?></td>
   			<td><?=substr($info,1,200).".."?></td>
   			<td>
            <?if($check == "check_add"){?>
               <a href="add.php?iskill_les=<?=$row["skl_les_id"]?>">Chọn</a>
            <?}else{?>
               <a href="edit.php?iskill_les=<?=$row["skl_les_id"]?>&record_id=<?=$record_id?>">Chọn</a>
            <?}?>   
            </td>
   		</tr>
      	<?}?>
   	</table>
	</div>
</body>
</html>
