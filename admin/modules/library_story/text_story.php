<?
require_once("inc_security.php");
   $record_id = getValue("record_id","int","GET");

   $sql = "SELECT *
           FROM library_story
           WHERE lib_story_type = 1 AND lib_story_id = ".$record_id;
   $db_story = new db_query($sql);
   $row = mysqli_fetch_assoc($db_story->result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
#wrap{
   width: 900px;
   margin:0px auto;
}
table{
   width:100%;
   border:solid 1px #EEEFF1;
}

table tr th{
   background-color:#EEEFF1;
   color:#4D648E;
   font-weight:bold;
}
table td{
   text-align:center;
}
input.close{
   width: 80px;
   margin-top:10px;
   float:right;
   cursor:pointer;
}

</style>
</head>
<body>
   <div id="wrap">
      <table>
         <tr>
            <th width="120">Tiêu đề</th>
            <th>Nội dung tiếng Anh</th>
            <th>Nội dung tiếng Việt</th>
         </tr>
         <tr>
            <td style="color:red; width:120px"><?=$row['lib_story_title']?></td>
            <td><textarea style="width:99%; height:300px;"><?=removeHTML($row["lib_story_en"])?></textarea></td>
            <td><textarea style="width: 99%; height:300px;"><?=removeHTML($row["lib_story_vi"])?></textarea></td>
         </tr>
      </table>
      <input class="close" type="button" value="Đóng" style="background: url('<?=$fs_imagepath?>button_2.gif') no-repeat; " onclick="window.parent.tb_remove();"/>
   </div>
</body>
</html>