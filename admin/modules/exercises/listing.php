<?
require_once("inc_security.php");
$list = new fsDataGird($id_field,$name_field,translate_text("Exercises Listing"));

//Get courses
$array_course[""] = "Choose Courses";
$course_select = new db_query("SELECT cou_id,cou_name FROM courses");
while($row_cou = mysql_fetch_assoc($course_select->result)){
   $array_course[$row_cou["cou_id"]] = $row_cou["cou_name"];
}unset($course_select);

//Filter
$sql_filter = "";
$id_course = getValue("cou_id","int","GET","");
if($id_course > 0){
   $sql_filter = " AND com_cou_id =" . $id_course;
} 
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/

//$list->add($id_field,"Mã [ID]","int", 0, 0);
$list->add($name_field,"Quiz Information","string", 0, 1);
$list->add("cou_name","Courses Information","string", 0, 1);
$list->add("exe_date","Date","string",0,0);
$list->add("exe_active","Active","title", 0, 0);
$list->add("","Details","detail");
$list->add("","Edit","edit");
$list->add("","Delete","delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count(" SELECT count(*) AS count FROM 	" .$fs_table. " 
                                INNER JOIN courses_multi ON exe_com_id = com_id
                                INNER JOIN courses ON com_cou_id = cou_id WHERE 1". $list->sqlSearch() . $sql_filter);
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM " . $fs_table . 
							 			" INNER JOIN courses_multi ON exe_com_id = com_id
                                INNER JOIN courses ON com_cou_id = cou_id WHERE 1". $list->sqlSearch() . $sql_filter                                                  
								    . " ORDER BY " . $list->sqlSort() . "exe_id DESC "
                            .	$list->limit($total->total));                     
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
   <?=$list->addSearch("","cou_id","array",$array_course,"")?>
   <?=$list->showHeader($total_row)?>
   <?
   //thực hiện lênh select csdl
   $i = 0;
	while($row	=	mysql_fetch_assoc($db_listing->result)){
   $i++; 
	?> 
   	<?=$list->start_tr($i, $row[$id_field])?>
   	<td width="300" align="center">
         <table width="280px">
    			<tr>
   				<td align="right"> Quiz Name : </td>
   				<td><input type="text" size="30" readonly="" class="form_control" value="<?=$row['exe_name']?>" /></td>
            </tr>
   	      <tr>
   				<td align="right"> Unit Name : </td>
   				<td><input type="text" size="30" readonly="" class="form_control" value="<?=$row['com_name']?>" /></td>
            </tr>
   	 	</table>
      </td>
      <td width="200" align="center"><span style="color: red;"><?=$row['cou_name']?></span></td>
   	<td width="100" align="center"><?=date("d/m/Y",$row['exe_date'])?></td>
   	<?=$list->showCheckbox("exe_active", $row["exe_active"], $row[$id_field])?>
      <td width="70" align="center">
         <? echo'<a title="Thông tin chi tiết" class="thickbox noborder a_detail" href="confirmation.php?url='. base64_encode(getURL()) . '&record_id=' . $row["exe_id"] .'&TB_iframe=true&amp;height=450&amp;width=950" /><b>Chi tiết</b></a>';?>
      </td>
   	<td align="center" width="15">
   		<a href="edit.php?record_id=<?=$row['exe_id']?>&iCourse=<?=$row['cou_id']?>&iCom=<?=$row['com_id']?> &url=<?=base64_encode($_SERVER['REQUEST_URI'])?>" title="Bạn muốn sửa đổi bản ghi" rel="tooltip" class="edit">
   			<img border="0" src="../../resource/images/grid/edit.png" />
   		</a>
      </td>
   	<?=$list->showDelete($row['exe_id'])?>
   	<?=$list->end_tr()?>
	<?}?>  
  <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
</style>