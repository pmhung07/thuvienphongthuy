<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,"",translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));
$menu = new menu();
$sql = '1';
$listAll                 = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND cat_type =  1 AND cat_parent_id = 0 AND cat_active  = 1 AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add("pau_id","ID","int", 1, 0);
$list->add("pau_user_id","Email","string", 0, 0);
$list->add("pau_pack_id","Package","int", 0, 0);
$list->add("pau_start_date","Ngày bắt đầu","int", 0, 0);
$list->add("pau_end_date","Ngày kết thúc","int", 0, 0);
$list->add("pau_end_date","Ngày còn lại","int", 0, 0);
$list->add("pau_status","Trạng thái","int", 0, 0);
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT count(*) AS count FROM package a, package_user b ,users c
                               WHERE a.pack_id = b.pau_pack_id AND b.pau_user_id = c.use_id ".$list->sqlSearch());
//câu lệnh select dữ liêu
$db_listing 	= new db_query("SELECT * FROM package a, package_user b ,users c
                               WHERE a.pack_id = b.pau_pack_id AND b.pau_user_id = c.use_id ".$list->sqlSearch()
                               . " ORDER BY " . $list->sqlSort() . "pau_id ASC "
                              . $list->limit($total->total));

$total_row = mysqli_num_rows($db_listing->result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
   while($row	=	mysqli_fetch_assoc($db_listing->result)){
   $i++;
   ?>
      <?=$list->start_tr($i, $row[$id_field])?>
      <td width="30" class="bold" align="center">
         <input type="text" style="width: 30px;color: red;" value="<?=$row['pau_id']?>" />
      </td>
      <td width="200" align="center">
          <input style="width: 200px;" value="<?=$row['use_email']?>"/>
      </td>
      <td width="200" align="center">
          <input style="width:200px; color: red;text-align: center;" type="text" value="<?=$row['pack_name']?>" />
      </td>
          <td width="100" align="center">
          <input style="width:100px; color: #1C3E7F;text-align: center;" type="text" value="<?=date("d-m-Y",$row['pau_start_date'])?>" />
      </td>
      <td width="100" align="center">
          <input style="width:100px; color: #1C3E7F;text-align: center;" type="text" value="<?=date("d-m-Y",$row['pau_end_date'])?>" />
      </td>
      <?php
         $cur_time = time();
         $remaining = 0;
         //if($row['pau_end_date']>$cur_time) $remaining = intval(($row['pau_end_date'] - $cur_time)/(24*3600));
         //else $remaining = 0;
      ?>
      <td width="100" align="center">
          <input style="width:30px; color: #1C3E7F;text-align: center;color: red;" type="text" value="<?=$remaining?>"/>
      </td>
      <td width="100" align="center">
          <input style="width:50px; color: red;text-align: center;" type="text" value="<?echo ($row['pau_status']== 1) ? "Active" : "InActive";?>" />
      </td>
      <?=$list->showDelete($row['pack_id'])?>
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