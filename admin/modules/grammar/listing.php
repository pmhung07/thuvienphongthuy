<?
require_once("inc_security.php");

$name_field = getValue("name_field","str","GET","");
$list = new fsDataGird($id_field,$name_field,translate_text("Listing"));
$iParent = getValue("iParent","int","GET","");
$iCate   = getValue("iCate","int","GET","");
$iCourse = getValue("iCourse","int","GET","");
$cou_id  = getValue("cou_id");

$sql_search = "1";
if($iParent>0) $sql_search =	"courses.cou_cat_id = ".$iParent." OR categories_multi.cat_parent_id = ".$iParent;
if($iCate>0) $sql_search = "categories_multi.cat_id = ".$iCate;
if($iCourse>0) $sql_search = "1 AND cou_id =".$iCourse;

//Lay ra danh muc cha
$arrayParent = array(0=>translate_text("Danh mục cha"));

$db_Parent = new db_query("SELECT cat_type,cat_name,cat_id FROM categories_multi
                             WHERE cat_parent_id = 0" );
while($row_parent = mysqli_fetch_array($db_Parent->result)){
	$arrayParent[$row_parent["cat_id"]] = $row_parent["cat_name"];
}unset($db_Parent);

//Lay ra danh muc con
$arrayCate = array(0=>translate_text("Danh mục con"));
if($iParent>0){
   $db_cateogry = new db_query("SELECT cat_type,cat_name,cat_id
                             FROM categories_multi
                             WHERE cat_parent_id = ".$iParent );
   while($row = mysqli_fetch_array($db_cateogry->result)){
   	$arrayCate[$row["cat_id"]]   = $row["cat_name"];
   }unset($db_cateogry);
}


//Lay ra danh sach khoa hoc
$arrayCourse = array(0 => "Chọn Course");
if($iParent>0){
   $db_Course = new db_query("SELECT cou_id,cou_name FROM categories_multi
                              INNER JOIN courses ON courses.cou_cat_id = categories_multi.cat_id
                              WHERE cou_cat_id = ".$iParent." OR categories_multi.cat_parent_id = ".$iParent);
   while($row = mysqli_fetch_array($db_Course->result)){
      $arrayCourse[$row["cou_id"]] = $row["cou_name"];
   }unset($db_Course);
}

$list->addSearch(translate_text("Danh mục cha"),"Parent_search","array",$arrayParent,$iParent);
$list->addSearch(translate_text("Danh mục con"),"Cate_search","array",$arrayCate,$iCate);
$list->addSearch(translate_text("Chọn Course"),"Course_search","array",$arrayCourse,$iCourse);

//$list->addSearch("","cou_select","array",$array_course,$iCourse);
//$list->addSearch("","unit_select","array",$array_unit,$iUnit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*---------Body------------*/ ?>
<div id="listing">
   <?php echo $list->urlsearch(); ?>
	<table border="1" cellpadding="3" cellspacing="0" class="table" width="100%" bordercolor="<?=$fs_border?>">
   	<tr>
   		<td class="bold bg" width="5">STT</td>
   		<td class="bold bg" ><?=translate_text("name")?></td>
            <td class="bold bg" align="center" width="100"><?=translate_text("Xem Chi tiết")?></td>
            <td class="bold bg" align="center" width="180"><?=translate_text("Chuyên mục")?></td>
            <td class="bold bg" align="center" width="5"><?=translate_text("Number")?></td>
            <td class="bold bg" align="center" width="30" >Sửa</td>
            <td class="bold bg" align="center" width="30" >Xóa</td>
   	</tr>
		<form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
		<input type="hidden" name="iQuick" value="update" />
		   <?
         $i=0;
         $j = 0;
         $m = 0;
         $n = 0;
         $db_course = new db_query("SELECT cou_id,cou_cat_id,cou_name FROM categories_multi
                                    INNER JOIN courses ON courses.cou_cat_id = categories_multi.cat_id
                                    WHERE ".$sql_search." ORDER BY cou_cat_id ASC");
         while($rowCourse = mysqli_fetch_array($db_course->result)){
         $i++;
         $m++;
         $n++;
         $dlUnut = '';
         $db_unit = new db_query("SELECT com_cou_id,com_name,com_id,com_num_unit,com_active,les_det_id,les_det_content
   					  	             FROM courses_multi,lesson_details
   						             WHERE courses_multi.com_id = lesson_details.les_com_id
                                  AND courses_multi.com_cou_id = ".$rowCourse["cou_id"]."
                                  AND lesson_details.les_det_type = 2
                                  ORDER BY com_num_unit ASC");
         ?>
            <tr <? if($m%2==0) echo ' bgcolor="#FAFAFA"';?>>
               <td align="center"><?php echo $i ?></td>
               <td nowrap="nowrap" style="padding-left: 20px;height: 20px;line-height: 20px;">
                  <div class="cou"><? echo '<b>COURSE : </b>'.$rowCourse["cou_name"];?></div>
                  <a class="node" href="listing.php?url=<?=base64_encode(getURL())?>&cou_id=<?=$rowCourse['cou_id']?>&iParent=<?=$iParent?>&iCate=<?=$iCate?>&iCourse=<?=$iCourse?>"> + </a>
               </td>
               <td></td>
               <td colspan="4"  style="padding-left: 40px;">
                  <b><?php echo nameCate($rowCourse['cou_cat_id']); ?></b>
               </td>
            </tr>
            <?php
            if($cou_id == $rowCourse['cou_id']){
                while($rowUnit = mysqli_fetch_array($db_unit->result)){
               $j++;
               $n++;
               $dlUnut .= '<tr';
               if($j%2==0) $dlUnut .= ' bgcolor="#FAFAFA"';
               $dlUnut .= '><td';

               $dlUnut .='></td>';
               $dlUnut .= '<td nowrap="nowrap" style="padding-left: 20px;height: 20px;line-height: 20px;">|------ <b style="color:red">Grammar của Unit '.$rowUnit["com_num_unit"].' </b></td>';
               $dlUnut .= '<td align="center"><a title="Xem chi tiết" class="thickbox noborder a_detail" href="listdetail.php?url='.base64_encode(getURL()).'&record_id='.$rowUnit["les_det_id"].'&TB_iframe=true&amp;height=1200&amp;width=950"">Xem chi tiết</a></td>';
               $dlUnut .= '<td align=""></td>';
               $dlUnut .= '<td align="center">'.$rowUnit["com_num_unit"].'</td>';
               $dlUnut .= '<td align="center"><a class="text" href="editgram.php?record_id='.$rowUnit["les_det_id"].'&returnurl='.base64_encode(getURL()).'"><img src="'.$fs_imagepath.'edit.png" alt="EDIT" border="0"></a></td>';
               $dlUnut .= '<td align="center"><img src="'.$fs_imagepath.'delete.gif" alt="DELETE" border="0" onClick="if (confirm(\'Are you sure to delete?\')){ window.location.href=\'deletegram.php?record_id='.$rowUnit["les_det_id"].'&returnurl='.base64_encode(getURL()).'\'}" style="cursor:pointer"></td>';
               $dlUnut .= '</tr>';
               }
               echo $dlUnut;
            }
            ?>

         <?php
         }
         unset($db_unit);
         unset($dlUnut);
         unset($db_course);
         ?>
		</form>
	</table>
</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
<style>
.cou{
   width:420px;
   float:left;
}
.node{
   border: 1px solid #CCCCCC;
   border-radius: 3px 3px 3px 3px;
   display: block;
   float: right;
   padding:0px 10px;
   text-align: center;
   text-decoration: none;
   cursor:pointer;
}
#TB_window{
   top:800px;
}
</style>
<script>
$(document).ready(function() {
   $('#Parent_search').change(function (){
      var iParent		    =	$("#Parent_search").val();
      window.location	=	"listing.php?iParent=" +iParent;
   });
    $('#Cate_search').change(function (){
      var iParent		    =	$("#Parent_search").val();
      var iCate	    =	$("#Cate_search").val();
      window.location	=	"listing.php?iParent="+iParent+"&iCate="+iCate;
   });
   $('#Course_search').change(function (){
      var iParent		   =	$("#Parent_search").val();
      var iCate		   =	$("#Cate_search").val();
      var iCourse		   =	$("#Course_search").val();
      window.location	=	"listing.php?iCate=" +iCate+"&iParent="+iParent+"&iCourse="+ iCourse;
   });
});
</script>
