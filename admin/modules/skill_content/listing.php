<?
require_once("inc_security.php");

$list = new fsDataGird($id_field,$name_field,translate_text("Listing"));
$iParent    = getValue("iParent","int","GET","");
$iCate      = getValue("iCate","int","GET","");
$iLesson    = getValue("iLesson","int","GET","");
$les_id     = getValue("les_id");

$sql_search = "1";
if($iParent>0) $sql_search =	"skill_lesson.skl_les_cat_id = ".$iParent." OR categories_multi.cat_parent_id = ".$iParent;
if($iCate>0) $sql_search = "categories_multi.cat_id = ".$iCate;
if($iLesson>0) $sql_search = "1 AND skl_les_id =".$iLesson;

//Lay ra danh muc cha
$arrayParent = array(0=>translate_text("Danh mục cha"));

$db_Parent = new db_query("SELECT cat_type,cat_name,cat_id FROM categories_multi
                             WHERE cat_parent_id = 0 AND cat_type = 0" );
while($row_parent = mysql_fetch_array($db_Parent->result)){
	$arrayParent[$row_parent["cat_id"]] = $row_parent["cat_name"];
}unset($db_Parent);

//Lay ra danh muc con
$arrayCate = array(0=>translate_text("Danh mục con"));
if($iParent>0){
   $db_cateogry = new db_query("SELECT cat_type,cat_name,cat_id
                             FROM categories_multi
                             WHERE cat_parent_id = ".$iParent." AND cat_type = 0");
   while($row = mysql_fetch_array($db_cateogry->result)){
   	$arrayCate[$row["cat_id"]]   = $row["cat_name"];
   }unset($db_cateogry);
}

//Lay ra ds bai hoc
$arrayLesson = array(0 => "Chọn bài học");
if($iParent>0){
   $db_sLesson = new db_query("SELECT skl_les_id, skl_les_name FROM categories_multi
                              INNER JOIN skill_lesson ON skill_lesson.skl_les_cat_id = categories_multi.cat_id
                              WHERE skl_les_cat_id = ".$iParent." OR categories_multi.cat_parent_id = ".$iParent);
   while($row = mysql_fetch_array($db_sLesson->result)){
      $arrayLesson[$row["skl_les_id"]] = $row["skl_les_name"];
   }unset($db_sLesson);
}

$list->addSearch(translate_text("Danh mục cha"),"Parent_search","array",$arrayParent,$iParent);
$list->addSearch(translate_text("Danh mục con"),"Cate_search","array",$arrayCate,$iCate);
$list->addSearch(translate_text("Chọn bài học"),"Course_search","array",$arrayLesson,$iLesson);

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
            <td class="bold bg" align="center" width="200"><?=translate_text("Xem Chi tiết")?></td>
            <td class="bold bg" align="center" width="180"><?=translate_text("Chuyên mục")?></td>				
            <td class="bold bg" align="center" width="5"><?=translate_text("Dạng")?></td>		
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
         $db_Lesson = new db_query("SELECT skl_les_id,skl_les_cat_id,skl_les_name FROM categories_multi
                                    INNER JOIN skill_lesson ON skill_lesson.skl_les_cat_id = categories_multi.cat_id
                                    WHERE ".$sql_search." ORDER BY skl_les_cat_id ASC");
         while($rowLesson = mysql_fetch_array($db_Lesson->result)){
         $i++;
         $m++;
         $n++;
         $dlCont = '';
         $db_cont = new db_query("SELECT skl_les_id,skl_les_name,skl_cont_id,skl_cont_title,skl_cont_type,skl_cont_order
   					  	             FROM skill_lesson,skill_content
   						             WHERE skill_lesson.skl_les_id = skill_content.skl_cont_les_id 
                                  AND skill_content.skl_cont_les_id = ".$rowLesson["skl_les_id"]."
                                  ORDER BY skl_cont_order ASC"); 
         ?>
            <tr <? if($m%2==0) echo ' bgcolor="#FAFAFA"';?>>
               <td align="center"><?php echo $i ?></td>
               <td nowrap="nowrap" style="padding-left: 20px;height: 20px;line-height: 20px;">
                  <div class="cou"><? echo '<b>Bài học : </b>'.$rowLesson["skl_les_name"];?></div>
                  <a class="node" href="listing.php?url=<?=base64_encode(getURL())?>&les_id=<?=$rowLesson['skl_les_id']?>&iParent=<?=$iParent?>&iCate=<?=$iCate?>&iLesson=<?=$iLesson?>"> + </a>
               </td>
               <td></td>
               <td colspan="4"  style="padding-left: 40px;">
                  <b><?php echo nameCate($rowLesson['skl_les_cat_id']); ?>
                  
                  </b>
               </td>
            </tr>
            <?php
            if($les_id == $rowLesson['skl_les_id']){
               while($rowCont = mysql_fetch_assoc($db_cont->result)){
               switch($rowCont['skl_cont_type']){
                  case 1 : $select = "add_type_main.php"; break;
                  case 2 : $select = "add_type_gram.php"; break;
                  case 3 : $select = "add_type_voc.php";  break;
                  case 4 : $select = "add_type_writing.php"; break;
                  case 5 : $select = "add_type_ext.php";  break;  
                 default : $select = "add_type_main.php"; break;  
               }   
               $j++;
               $n++;
               $dlCont .= '<tr';
               if($j%2==0) $dlCont .= ' bgcolor="#FAFAFA"';
               $dlCont .= '><td';
               $dlCont .='></td>';
               if($rowCont['skl_cont_title'] != ""){
                  $dlCont .= '<td nowrap="nowrap" style="padding-left: 20px;height: 20px;line-height: 20px;">|------ <b style="color:red">'.$rowCont['skl_cont_title'].'</b></td>';
               }
               else{
                  $dlCont .= '<td nowrap="nowrap" style="padding-left: 20px;height: 20px;line-height: 20px;">|------ <b style="color:red">Content so '.$rowCont['skl_cont_order'].'</b></td>';
               }
               $dlCont .= '<td align="center"><a title="Xem chi tiết" class="thickbox noborder a_detail" href="'.$select.'?url='.base64_encode(getURL()).'&record_id='.$rowCont["skl_cont_id"].'&TB_iframe=true&amp;height=600&amp;width=950"">Xem chi tiết</a></td>';
               $dlCont .= '<td align=""></td>';
               $dlCont .= '<td align="center">'.$rowCont["skl_cont_type"].'</td>';
               $dlCont .= '<td align="center"><a class="text" href="edit.php?record_id='.$rowCont["skl_cont_id"].'&returnurl='.base64_encode(getURL()).'"><img src="'.$fs_imagepath.'edit.png" alt="EDIT" border="0"></a></td>';
               $dlCont .= '<td align="center"><img src="'.$fs_imagepath.'delete.gif" alt="DELETE" border="0" onClick="if (confirm(\'Are you sure to delete?\')){ window.location.href=\'delete.php?record_id='.$rowCont["skl_cont_id"].'&returnurl='.base64_encode(getURL()).'\'}" style="cursor:pointer"></td>';
               $dlCont .= '</tr>';
               }
               unset($db_cont);
               echo $dlCont;
            }   
            ?>
         <?php 
         }unset($db_Lesson);
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
   top:400px;
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
      window.location	=	"listing.php?iParent=" +iParent+"&iCate="+iCate;
   });
   $('#Course_search').change(function (){
      var iParent		   =	$("#Parent_search").val();
      var iCate		   =	$("#Cate_search").val();
      var iLesson		   =	$("#Course_search").val();
      window.location	=	"listing.php?iCate=" +iCate+"&iParent="+iParent+"&iLesson="+ iLesson;
   });
}); 
</script>
