<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

$iCat	   = getValue("iCat");
$iParent = getValue("iParent");
//$iLev    = getValue("iLev");

//unlink("../../../pictures/courses/small_vnd1343381100.jpg");

$sql_filter = "";
if($iParent !=""){
   if($iCat !="") $sql_filter .= " AND cat_parent_id = '".$iParent."'";
   else $sql_filter .= " AND cat_id = '".$iParent."'";
}
if($iCat !="") $sql_filter  .= " AND cat_id = '" . $iCat . "'";
//if($iLev !="") $sql_filter  .= " AND lev_id = '" . $iLev . "'";

//Lay ra danh muc cha
$arrayParent = array();
$arrayParent[''] = "Chọn Danh mục cha";
$db_parent = new db_query("SELECT cat_name,cat_id
                             FROM categories_multi
                             WHERE cat_parent_id = 0");
while($row = mysqli_fetch_array($db_parent->result)){
   $arrayParent[$row["cat_id"]] = $row["cat_name"];
}unset($db_parent);

//Lay ra danh muc con
$arrayCat = array();
$arrayCat[''] = "Chọn Danh mục con";
if($iParent > 0){
   $db_cateogry = new db_query("SELECT cat_name,cat_id
                                FROM categories_multi
                                WHERE cat_parent_id =".$iParent);
   while($row = mysqli_fetch_array($db_cateogry->result)){
      $arrayCat[$row["cat_id"]] = $row["cat_name"];
   }unset($db_cateogry);
}


//Tim kiem theo Danh muc va theo Level
$list->addSearch(translate_text("Danh mục cha"),"iParent","array",$arrayParent,$iParent);
$list->addSearch(translate_text("Danh mục con"),"iCat","array",$arrayCat,$iCat);
//$list->addSearch(translate_text("Level"),"iLev","array",$arr_lev,$iLev);
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add("post_picture","Hình ảnh đại diện","string",0,0);
$list->add($name_field,"Tiêu đề","string", 1, 1);
$list->add("cat_name","Danh mục","string",0,0);
$list->add("post_time","Ngày tạo","string",0,0);
$list->add("post_active","Active","int", 0, 0);

$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count
										 FROM posts
                               INNER JOIN categories_multi ON posts.post_cat_id=categories_multi.cat_id
                               WHERE 1".$list->sqlSearch().$sql_filter);
//câu lệnh select dữ liêu
$db_listing 	= new db_query("SELECT * FROM posts
                               INNER JOIN categories_multi ON posts.post_cat_id=categories_multi.cat_id
								 		 WHERE 1".$list->sqlSearch().$sql_filter
									   . " ORDER BY " . $list->sqlSort() . "post_id DESC "
                              .	$list->limit($total->total));

$total_row = mysqli_num_rows($db_listing->result);
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
   while($row	=	mysqli_fetch_assoc($db_listing->result)){
   $i++;
   ?>
      <?=$list->start_tr($i, $row[$id_field])?>
      <td align="center">
		   <img style="height: 40px;" src="<?=$imgpath . "small_" . $row['post_picture'] ?>" />
		</td>
      <td width="250" class="bold" align="center">
         <input type="text" style="width: 240px;color: red;" value="<?=$row[$name_field]?>" />
      </td>
      <td width="200" align="center">
          <input style="width:190px; color: #1C3E7F;" type="text" value="<?=$row['cat_name']?>" />
      </td>
      <td align="center"><?=date("d/m/Y",$row['post_time'])?></td>
      <?=$list->showCheckbox("post_active", $row["post_active"], $row[$id_field])?>
      <?=$list->showEdit($row['post_id'])?>
      <?=$list->showDelete($row['post_id'])?>
      <?=$list->end_tr()?>
   <?
     }
   ?>
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<script>
   $(document).ready(function() {
      $('#iParent').change(function (){
         var iParent		   =	$("#iParent").val();
         window.location	=	"listing.php?iParent=" +iParent;
      });
      $('#iCat').change(function (){
         var iParent		   =	$("#iParent").val();
         var iCat		      =	$("#iCat").val();
         window.location	=	"listing.php?iParent="+ iParent +"&iCat="+ iCat;
      });
   });
</script>