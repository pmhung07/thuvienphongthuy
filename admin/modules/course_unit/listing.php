<?
require_once("inc_security.php");

$list = new fsDataGird($id_field,$name_field,translate_text("Listing"));
$iParent    = getValue("iParent");
$iCate      = getValue("iCate");
$iCourses   = getValue("iCourses");
$cou_id     = getValue("cou_id");

$sql_search =	"1";
if($iParent>0) $sql_search =	"courses.cou_cat_id = ".$iParent." OR categories_multi.cat_parent_id = ".$iParent;
if($iCate>0) $sql_search = "categories_multi.cat_id = ".$iCate;
if($iCourses>0) $sql_search = "1 AND cou_id =".$iCourses;

//Lay ra danh muc cha
$arrayParent = array(0=>translate_text("Danh mục cha"));
$db_parent = new db_query("SELECT cat_type,cat_name,cat_id
                             FROM categories_multi
                             WHERE cat_parent_id = 0" );
while($row_parent = mysql_fetch_array($db_parent->result)){
	$arrayParent[$row_parent["cat_id"]]   = $row_parent["cat_name"];
}unset($db_parent);

//Lay ra danh muc con
$arrayCate = array(0=>translate_text("Danh mục con"));
if($iParent>0){
   $db_cateogry = new db_query("SELECT cat_type,cat_name,cat_id
                             FROM categories_multi
                             WHERE cat_parent_id = ".$iParent );
   while($row = mysql_fetch_array($db_cateogry->result)){
   	$arrayCate[$row["cat_id"]]   = $row["cat_name"];
   }unset($db_cateogry);
}
//Lay ra danh sach khoa hoc
$arrayCourses = array(0 => "Khóa học");
if($iParent>0){
   $db_courses = new db_query("SELECT cou_id,cou_name FROM categories_multi
                              INNER JOIN courses ON courses.cou_cat_id = categories_multi.cat_id
                              WHERE cou_cat_id = ".$iParent." OR categories_multi.cat_parent_id = ".$iParent);
   while($row_courses = mysql_fetch_assoc($db_courses->result)){
      $arrayCourses[$row_courses["cou_id"]] = $row_courses["cou_name"];
   }unset($db_course);
}

$list->addSearch(translate_text("Danh mục cha"),"Parent_search","array",$arrayParent,$iParent);
$list->addSearch(translate_text("Danh mục con"),"Cate_search","array",$arrayCate,$iCate);
$list->addSearch("Khóa học","Courses_search","array",$arrayCourses,$iCourses);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
   <body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   <?=template_top(translate_text("Category listing"))?>
   	<?php echo $list->urlsearch(); ?>
   	<table border="1" cellpadding="3" cellspacing="0" class="table" width="100%" bordercolor="<?=$fs_border?>">
   		<tr> 
   			<td class="bold bg" width="5"><input type="checkbox" id="check_all" onClick="check('1','<?=count($listAll)+1?>')"/></td>
   			<td class="bold bg" ><?=translate_text("name")?></td>
            <td class="bold bg" align="center" width="400"><?=translate_text("Chuyên mục - Level")?></td>				
            <td class="bold bg" align="center" width="5"><?=translate_text("Number")?></td>			
   			<td class="bold bg" align="center" width="5"><img src="<?=$fs_imagepath?>copy.gif" border="0"/></td>
   			<td class="bold bg" align="center" width="16"><img src="<?=$fs_imagepath?>edit.png" border="0" width="16"/></td>
   			<td class="bold bg" align="center" width="16"><img src="<?=$fs_imagepath?>delete.gif" border="0"/></td>
   		</tr>
   		<form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
   		<input type="hidden" name="iQuick" value="update" />	
   		<? 		
         $i=0;
         $j = 0;
         $m = 0;  
         $n = 0;
         $db_course = new db_query("SELECT cou_id,cou_cat_id,cou_name,cou_lev_id FROM categories_multi
                                    INNER JOIN courses ON courses.cou_cat_id = categories_multi.cat_id
                                    WHERE ".$sql_search." ORDER BY cou_cat_id ASC");

         while($rowCourse = mysql_fetch_array($db_course->result)){
         $m++;
         $n++;
         $dlUnut = '';
         $db_unit = new db_query("SELECT com_cou_id,com_name,com_id,com_num_unit,com_active,com_picture,com_content
                  				 	 FROM courses_multi
                  					 WHERE com_cou_id = ".$rowCourse["cou_id"]."
                                  ORDER BY com_num_unit ASC"); 
         ?>
         <tr <? if($m%2==0) echo ' bgcolor="#FAFAFA"';?>>
            <td></td>
            <td nowrap="nowrap" style="padding:0px 10px;height: 25px;line-height: 20px;">
               <div class="cou"><? echo '<b>COURSE : </b><span style="color:red">'.$rowCourse["cou_name"]."</span>";?></div>
               <a class="node" href="listing.php?url=<?=base64_encode(getURL())?>&cou_id=<?=$rowCourse['cou_id']?>&iParent=<?=$iParent?>&iCate=<?=$iCate?>&iCourses=<?=$iCourses?>"> + </a>
            </td>
            <td colspan="5" style="padding-left: 20px;">
               <?php echo nameCate($rowCourse['cou_cat_id']).'  --  '.nameLevel($rowCourse['cou_lev_id']); ?>
            </td>
            
         </tr>
         <?php
         if($cou_id == $rowCourse['cou_id']){
            while($rowUnit = mysql_fetch_array($db_unit->result)){
            $j++;
            $n++;
            $dlUnut .= '<tr class="unit"';
            if($j%2==0) $dlUnut .= ' bgcolor="#FAFAFA"';
            $dlUnut .= '><td';
            //if($row["admin_id"] == $admin_id) $dlUnut .=' bgcolor="#FFFF66"';
            $dlUnut .='><input type="checkbox" name="record_id[]" id="record_'.$rowUnit["com_id"].'_'.$n.'" value="'.$rowUnit["com_id"].'"/></td>';
            $dlUnut .= '<td nowrap="nowrap" style="padding-left: 20px;height: 20px;line-height: 20px;">|------ <b>Unit '.$rowUnit["com_num_unit"].' </b> : '.$rowUnit["com_name"].'</td>';
            $dlUnut .= '<td align="">
                           <textarea style="margin-left: 18px;width: 280px;height: 25px;">'.$rowUnit["com_content"].'</textarea>   
                           <img style="height:31px" src="'.$imgpath.'small_'.$rowUnit["com_picture"].'" />
                        </td>';
            $dlUnut .= '<td align="center">'.$rowUnit["com_num_unit"].'</td>';
            $dlUnut .= '<td align="center" width="16"><img src="'.$fs_imagepath.'copy.gif" title="'.translate_text("Are you want duplicate record").'" border="0" onClick="if (confirm(\''.translate_text("Are you want duplicate record").'\')){ window.location.href=\'copy.php?record_id='.$rowUnit["com_id"].'&returnurl='.base64_encode(getURL()).'\'}" style="cursor:pointer"></td>';
            $dlUnut .= '<td align="center" width="16"><a class="text" href="edit.php?record_id='.$rowUnit["com_id"].'&returnurl='.base64_encode(getURL()).'"><img src="'.$fs_imagepath.'edit.png" alt="EDIT" border="0"></a></td>';
            $dlUnut .= '<td align="center"><img src="'.$fs_imagepath.'delete.gif" alt="DELETE" border="0" onClick="if (confirm(\'Are you sure to delete?\')){ window.location.href=\'delete.php?record_id='.$rowUnit["com_id"].'&returnurl='.base64_encode(getURL()).'\'}" style="cursor:pointer"></td>';
            $dlUnut .= '</tr>';
            }
         echo $dlUnut;
         }   
         ?>
         <?php       
         }
         unset($dlUnut);
         unset($db_unit);
         unset($db_course);
         ?>
   	   </form>
      </table>
   <?=template_bottom() ?>
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
   $('#Courses_search').change(function (){
      var iParent		   =	$("#Parent_search").val();
      var iCate		   =	$("#Cate_search").val();
      var iCourses		   =	$("#Courses_search").val();
      window.location	=	"listing.php?iCate=" +iCate+"&iParent="+iParent+"&iCourses="+ iCourses;
   });
}); 
</script>

