<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
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
$list->add($name_field,"Tên gói","string", 1, 1);
$list->add("pack_cat_id","Danh mục","int", 1, 0);
$list->add("pack_description","Mô tả","string", 0, 0);
$list->add("pack_price","Số tiền","int", 0, 0);
$list->add("pack_totalday","Số ngày","int", 0, 0);
$list->add("",translate_text("Gói học"),"Gói học");
$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT count(*) AS count FROM package
                            WHERE 1 ".$list->sqlSearch());
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM package
                              -- INNER JOIN categories_multi 
                              -- ON(cat_id  = pack_cat_id)
                              WHERE 1 ".$list->sqlSearch()
									            . " ORDER BY " . $list->sqlSort() . " pack_id DESC "
                              . $list->limit($total->total));
                                 
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
      <td width="150" class="bold" align="center">
         <input type="text" style="width: 150px;color: red;" value="<?=$row[$name_field]?>" />
      </td>
      <?
      $cat_trails = db_find_parents_trail($row["pack_cat_id"],'0','categories_multi','cat_id','cat_parent_id');
      $cat_parent = ($cat_trails[(count($cat_trails)) - 1]['cat_id']);
      ?>
      <td width="200" align="center">
          <select name="cat_type" id="cat_type"  class="form_control">
            <option value="0">---Danh mục---</option>
            <? foreach($listAll as $value){ ?>
            <option value="<?=$row['pack_cat_id']?>" <? if($value['cat_id'] == $cat_parent) echo "selected='selected'";?>><?=$value['cat_name']?></option>
            <? } ?>
          </select>
      </td>  
      <td width="200" align="center">
          <input style="width: 120px;" value="<?=truncateString_(removeHTML(($row['pack_description'])),120)?>"/>
      </td>
      <td width="50" align="center">
          <input style="width:50px; color: red;text-align: center;" type="text" value="<?=$row['pack_price']?>" /> vnđ
      </td>
      <td width="50" align="center">
          <input style="width:50px; color: red;text-align: center;" type="text" value="<?=$row['pack_totalday']?>"/> ngày
      </td>
      <td width="150px" align="center">
         <? echo'<a title="Thêm các bài" class="thickbox noborder a_detail" href="add_package_data.php?url='. base64_encode(getURL()) . '&record_id=' . $row["pack_id"] .'.&pack_cat_id=' . $row["pack_cat_id"] .'&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Chi tiết</b></a>';?>
      </td>
      <?=$list->showEdit($row['pack_id'])?>
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