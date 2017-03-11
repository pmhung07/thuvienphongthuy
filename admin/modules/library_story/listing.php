<?
require_once("inc_security.php");

	//gọi class DataGird
	$list = new fsDataGird($id_field,$name_field,translate_text("Game Library listing"));
	$sta_category_id	= array();
	$class_menu			= new menu();
	//$listAll			= $class_menu->getAllChild("categories_multi", "cat_id", "cat_parent_id", 0, "cat_type='news' AND cat_id IN (" . $fs_category . ") AND lang_id = " . $lang_id, "cat_id,cat_name,cat_type", "cat_order ASC,cat_name ASC", "cat_has_child", 0);
	//unset($class_menu);
	/*
	1: Ten truong trong bang
	2: Tieu de header
	3: kieu du lieu ( vnd : kiểu tiền VNĐ, usd : kiểu USD, date : kiểu ngày tháng, picture : kiểu hình ảnh, 
							array : kiểu combobox có thể edit, arraytext : kiểu combobox ko edit,
							copy : kieu copy, checkbox : kieu check box, edit : kiểu edit, delete : kiểu delete, string : kiểu text có thể edit, 
							number : kiểu số, text : kiểu text không edit
	4: co sap xep hay khong, co thi de la 1, khong thi de la 0
	5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
	*/
   
  	$list->add($name_field,"Ảnh đại diện","string",0,0);
	$list->add($name_field,"Tiêu đề","string",0,1);
	//$list->add("lib_story_en","Nội dung tiếng Anh","text",0,0);
	//$list->add("lib_story_vi","Nội dung tiếng Việt","text",0,0);
   $list->add("","Slice Image","Slice Image");
	$list->add("","Edit","edit");
	$list->add("","Delete","delete");
	$list->ajaxedit($fs_table);
	$total		= new db_count("SELECT count(*) AS count 
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch());	
   
	$db_listing	= new db_query("SELECT * 
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch() . "
      								 ORDER BY " . $list->sqlSort() . $id_field ." ASC
      								 " . $list->limit($total->total));
   $total_row = mysql_num_rows($db_listing->result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?=$list->headerScript()?>
</head>
<style type="text/css">
table td{
   text-align:center;
}
</style>
<body>
   <div id="listing">
      <?=$list->showHeader($total_row)?>
      <?
      //thực hiện lênh select csdl
      $i = 0;
   	while($row	=	mysql_fetch_assoc($db_listing->result)){
 	   $i++;
   	?> 
      	<?=$list->start_tr($i,$row[$id_field])?>
         <td width="100px" align="center"><img height="40" width="60" src="<?=$imgpath. "small_" .$row["lib_story_image"]?>"/></td>
         <td width="200px"><span style="color: red;"><?=$row["lib_story_title"]?></span></td>
         <?/*<td><textarea style="width: 99%;height: 50px;"><?=removeHTML($row["lib_story_en"])?></textarea></td>
         <td><textarea style="width: 99%;height: 50px;"><?=removeHTML($row["lib_story_vi"])?></textarea></td>*/?>
        	<td width="80px" align="center">
           <? 
           if($row["lib_story_type"] == 2){
              echo "Truyện tranh"; 
              echo '<p><a title="Add Slice Images" class="thickbox noborder" href="more_picture.php?record_id=' . $row["lib_story_id"] . '&TB_iframe=true&amp;height=450&amp;width=500" style="color:#0000FF; font-family:Tahoma; font-size:11px">(Add Slice Images)</a></p>';
           }else{
              echo "Truyện chữ";
              echo '<p><a title="Xem chi tiết" class="thickbox noborder" href="text_story.php?record_id='.$row["lib_story_id"].'&TB_iframe=true&amp;height=380&amp;width=950" style="color:#0000FF; font-family:Tahoma; font-size:11px">Xem Chi tiết</a></p>'; 
           }
           ?>
         </td>
         <?//=$list->showEdit($row['lib_story_id'])?>
         <?echo '<td width="10" align="center"><a class="edit"  rel="tooltip" title="' . translate_text("Bạn muốn sửa bản ghi") . '" href="edit.php?record_id=' .  $row['lib_story_id'] . '&url=' . base64_encode($_SERVER['REQUEST_URI']) . '&type='.$row['lib_story_type'].'&cat_id='.$row['lib_story_catid'].'"><img src="../../resource/images/grid/edit.png" border="0"></a></td>'?>
      	<?=$list->showDelete($row['lib_story_id'])?>
      	<?=$list->end_tr()?>
   	<?}?>  
     <?=$list->showFooter($total_row)?>
   </div>
</body>
</html>
<style>
#TB_window{
   top:400px;
}
</style>