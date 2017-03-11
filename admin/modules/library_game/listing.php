<?
require_once("inc_security.php");

	//gọi class DataGird
	$list = new fsDataGird($id_field,$name_field,translate_text("Game Library listing"));
	$sta_category_id	= array();
	//$class_menu			= new menu();
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
   
  	$list->add($name_field,"Ảnh trò chơi","string",0,1);
	$list->add($name_field,"Tên trò chơi","string",0,1);
	$list->add("lib_game_info","Thông tin trò chơi","text",0,1);
   $list->add("","View Flash","View Flash");
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
         <td width="100px"><img height="50px" src="<?=$imgpath. "small_" .$row["lib_game_image"]?>"/></td>
         <td width="200px"><span style="color: red;"><?=$row["lib_game_title"]?></span></td>
         <td><textarea style="width: 99%;height: 50px;"><?=$row["lib_game_info"]?></textarea></td>
        	<td width="100px" align="center">
            <?
               $url = $mediapath.$row["lib_game_url"];
               checkmedia_les(3,$url);
            ?>  
         </td>
         <td width="10" align="center"><a class="edit"  rel="tooltip" title="<?=translate_text("Bạn muốn sửa bản ghi")?>" href="edit.php?record_id=<?=$row['lib_game_id']?>&cat_id=<?=$row['lib_game_catid']?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>"><img src="../../resource/images/grid/edit.png" border="0"/></a></td>
         <?//$list->showEdit($row['lib_game_id'])?>
      	<?=$list->showDelete($row['lib_game_id'])?>
      	<?=$list->end_tr()?>
   	<?}?>  
     <?=$list->showFooter($total_row)?>
   </div>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
#TB_window{
   top:400px;
}
</style>