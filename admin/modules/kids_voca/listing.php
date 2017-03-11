<?
require_once("inc_security.php");

$list = new fsDataGird($id_field,$name_field,translate_text("Listing"));
$iCourse    = getValue("iCourse","int","GET","");
$cou_id     = getValue("cou_id");
$sql_search = "1";
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
	<table border="1" cellpadding="3" cellspacing="0" class="table" width="100%" bordercolor="<?=$fs_border?>">
   	<tr> 
   		<td class="bold bg" width="5">STT</td>
   		<td class="bold bg" ><?=translate_text("Name")?></td>	
         <td colspan="5" align="center">Thông tin chi tiết</td>			
   	</tr>
		<form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
		<input type="hidden" name="iQuick" value="update" />	
		   <? 
         $i=0;
         $j = 0;
         $m = 0;
         $n = 0;   
         $db_course = new db_query("SELECT * FROM kids_vcb_lessons ORDER BY kvcb_id");
         while($rowCourse = mysql_fetch_array($db_course->result)){
         $i++;
         $m++;
         $n++;
         $dlUnut = '';
         $db_unit = new db_query("SELECT kvcb_ent_id,kvcb_ent_title,kvcb_ent_examples
   					  	             FROM kids_vcb_entries
                                  WHERE kids_vcb_entries.kvcb_id = ".$rowCourse["kvcb_id"]); 
         ?>
            <tr <? if($m%2==0) echo ' bgcolor="#FAFAFA"';?>>
               <td align="center"><?php echo $i ?></td>
               <td nowrap="nowrap" style="padding-left: 20px;height: 20px;line-height: 20px;">
                  <div class="cou"><? echo '<b>COURSE : </b>'.$rowCourse["kvcb_title"];?></div>
                  <a class="node" href="listing.php?url=<?=base64_encode(getURL())?>&cou_id=<?=$rowCourse['kvcb_id']?>&iParent=<?=$iParent?>&iCate=<?=$iCate?>&iCourse=<?=$iCourse?>"> + </a>
               </td>
               <td align="center">
               </td>
            </tr>
            <?php
            if($cou_id == $rowCourse['kvcb_id']){
               while($rowUnit = mysql_fetch_array($db_unit->result)){
               $j++;
               $n++;
               $dlUnut .= '<tr';
               if($j%2==0) $dlUnut .= ' bgcolor="#FAFAFA"';
               $dlUnut .= '><td';
               $dlUnut .='></td>';
               $dlUnut .= '<td nowrap="nowrap" style="padding-left: 20px;height: 20px;line-height: 20px;">|------ <b style="color:red">Vi dụ <span style="color:#2e6e9e">'.$rowUnit["kvcb_ent_title"].'</span> <span style="color:#4B9258;font-weight:bold;">--------------------</span> ID : <span style="color:#2e6e9e">'.$rowUnit["kvcb_ent_id"].'</span></b></td>';
               $dlUnut .= '<td align="center"><a title="Xem chi tiết" class="thickbox noborder a_detail" href="listdetail.php?url='.base64_encode(getURL()).'&record_id='.$rowUnit["kvcb_ent_id"].'&TB_iframe=true&amp;height=450&amp;width=950"">Xem chi tiết</a></td>';
               $dlUnut .= '<td align=""></td>';
               $dlUnut .= '<td align="center">'.$rowUnit["kvcb_ent_title"].'</td>';
               $dlUnut .= '<td align="center"><a class="text" href="edit.php?record_id='.$rowUnit["kvcb_ent_id"].'&returnurl='.base64_encode(getURL()).'"><img src="'.$fs_imagepath.'edit.png" alt="EDIT" border="0"></a></td>';
               $dlUnut .= '<td align="center"><img src="'.$fs_imagepath.'delete.gif" alt="DELETE" border="0" onClick="if (confirm(\'Are you sure to delete?\')){ window.location.href=\'delete.php?record_id='.$rowUnit["kvcb_ent_id"].'&returnurl='.base64_encode(getURL()).'\'}" style="cursor:pointer"></td>';
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
      var iCourse		   =	$("#Course_search").val();
      window.location	=	"listing.php?iCate=" +iCate+"&iParent="+iParent+"&iCourse="+ iCourse;
   });
}); 
</script>
