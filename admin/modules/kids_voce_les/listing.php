<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

$iCourses   = getValue("iCourses");
if($iCourses>0) {$sql_search = " AND kcou_id =".$iCourses; }else{ $sql_search = ""; }
$list->add("kvcb_title","Lessons","string",0,0);
$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");


//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count 
      								 FROM  kids_vcb_lessons 
      								 WHERE 1".$sql_search);
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM  kids_vcb_lessons 
								       WHERE 1".$sql_search
									    ." ORDER BY  " . $list->sqlSort() . "	kvcb_id	 DESC "
                               .	$list->limit($total->total) );
                                 
$total_row = mysql_num_rows($db_listing->result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<?=$list->headerScript()?>
</head>
<body>
<? /*---------Body------------*/ ?>
<div id="listing">
   <?=$list->showHeader($total_row)?>
   <?
   $i = 0;
   //thực hiện lênh select csdl
   while($row	=	mysql_fetch_assoc($db_listing->result)){
   $i++;
   ?>    
      <?=$list->start_tr($i, $row[$id_field])?>
      <td class="bold" align="">
         <input type="text" style="width: 200px;color: red;" value="<?=$row["kvcb_title"]?>" />
      </td>  
      <?=$list->showEdit($row['kvcb_id'])?>
      <?=$list->showDelete($row['kvcb_id'])?>
      <?=$list->end_tr()?>
   <?
     }
   ?>  
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>