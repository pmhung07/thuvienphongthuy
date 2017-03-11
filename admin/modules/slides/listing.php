<?
require_once("inc_security.php");
error_reporting(0);
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

$iCat	   = getValue("iCat");
$iParent = getValue("iParent");

//unlink("../../../pictures/courses/small_vnd1343381100.jpg");


//Tim kiem theo Danh muc va theo Level
//$list->addSearch(translate_text("Danh mục cha"),"iParent","array",$arrayParent,$iParent);
//$list->addSearch(translate_text("Danh mục con"),"iCat","array",$arrayCat,$iCat);
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add("slide_img","Ảnh đại diện","string",0,0);
$list->add("slide_name","Mô tả","string",0,0);
$list->add("slide_type","Quảng cáo","string",0,0);
$list->add("slide_order","Thứ tự","int",0,0);
$list->add("slide_active","Active","int", 0, 0);
$list->add("slide_content_invi","Active Content","int", 0, 0);

$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count 
										 FROM slides 
                               WHERE 1".$list->sqlSearch());
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM slides 
								 		 WHERE 1".$list->sqlSearch()
									   . " ORDER BY " . $list->sqlSort() . "slide_type ASC "
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
   <?=$list->showHeader($total_row)?>
   <?
   $i = 0;
   //thực hiện lênh select csdl
   while($row	=	mysql_fetch_assoc($db_listing->result)){
   $i++;
   ?>    
      <?=$list->start_tr($i, $row[$id_field])?>
      <td align="center">
		   <img style="height: 20px;width: 30px;" src="<?=$imgpath . "small_" . $row['slide_img'] ?>" />
		</td>
      <td class="bold" align="center">
         <input type="text" style="width: 300px;color: red;" value="<?=$row[$name_field]?>" />
      </td>      
      <td class="bold" align="center">
            <?
            switch($row['slide_type']){
               case '1':
               echo '<span style="color:red;font-weight:bold;">Banner Slider</span>';
               break;
               case '2':
               echo '<span style="color:blue;font-weight:bold;">Banner Sidebar Right</span>';
               break;
               case '3':
               echo '<span style="color:#675905;font-weight:bold;">Nhà tuyển dụng</span>';
               break;
               case '4':
               echo '<span style="color:#675905;font-weight:bold;">Banner trang giới thiệu</span>';
               break;
            }
            ?>
      </td>   
      <td class="bold" align="center">
         <input type="text" style="width: 50px;color: red;text-align: center;" value="<?=format_number($row['slide_order'])?>" />
      </td> 
      <?=$list->showCheckbox("slide_active", $row["slide_active"], $row[$id_field])?>
      <?=$list->showCheckbox("slide_content_invi", $row["slide_content_invi"], $row[$id_field])?>
      <?=$list->showEdit($row['slide_id'])?>
      <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='delete.php?record_id=<?=$row['slide_id']?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
      <?=$list->end_tr()?>
   <?
     }
   ?>  
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
</style>