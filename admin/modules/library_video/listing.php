<?
require_once("inc_security.php");
$list                           = new fsDataGird($id_field,$name_field,translate_text("Listing"));
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add($name_field,"Tên Video","string", 1, 1);
$list->add("lib_video_info","Giới thiệu","string", 0, 0);
$list->add("lib_video_image","Image","string", 0, 0);
$list->add("lib_video_url","Video","string", 0, 0);
$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");

//$list->quickEdit = false;
$list->ajaxedit($fs_table);

//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count 
										 FROM 	".$fs_table);
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM " . $fs_table 
                                 . " WHERE 1".$list->sqlSearch()
										   . " ORDER BY " . $list->sqlSort() . "lib_video_id DESC "
                                 .	$list->limit($total->total));
                                 
$total_row = mysql_num_rows($db_listing->result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
   <body>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   <div id="listing">
      <?=$list->showHeader($total_row)?>
      <?
      $i = 0;
      //thực hiện lênh select csdl
      while($row	=	mysql_fetch_assoc($db_listing->result)){
      	$i++;
     	?> 
      	<?=$list->start_tr($i, $row[$id_field])?>
      	<td class="bold" align="center">
       <?=$row[$name_field]?>
      	</td>
       <td align="center" width="250">
       <textarea style="width: 400px;height: 30px;"><?=$row["lib_video_info"]?></textarea>
      	</td>
       <td class="bold" align="center" width="150">
       <?php if ($row["lib_video_image"] != ''){ ?>
       <img height="35px" src="<?=$imgpath.'small_'.$row["lib_video_image"]?>"  />
      	<?php } ?>
       </td>
       <td align="center" width="250">
           <?php
               $url =  $videopath.$row['lib_video_url'];
               checkmedia_les(2,$url);
           ?>
      	</td>
      	<?//$list->showEdit($row['lib_video_id'])?>
         <td width="10" align="center"><a class="edit"  rel="tooltip" title="<?=translate_text("Bạn muốn sửa bản ghi")?>" href="edit.php?record_id=<?=$row['lib_video_id']?>&cat_id=<?=$row['lib_video_catid']?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>"><img src="../../resource/images/grid/edit.png" border="0"/></a></td>
      	<td align="center" width="20">
          <img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Bạn có chắc là muốn xóa?')){ window.location.href='delete.php?record_id=<?=$row['lib_video_id']?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer">
       </td>
      	<?=$list->end_tr()?>
     	<?
      }
      ?>  
      <?=$list->showFooter($total_row)?>
   </div>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   </body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
#TB_window{
   top:400px;
}
</style>