<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$fs_redirect  = base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

$iCat    = getValue("iCat");
$iParent = getValue("iParent");
//$iLev    = getValue("iLev");

//unlink("../../../pictures/courses/small_vnd1343381100.jpg");

$sql_filter = "";
if($iParent !=""){
   if($iCat !="") $sql_filter .= " AND pcat_parent_id = '".$iParent."'";
   else $sql_filter .= " AND pcat_id = '".$iParent."'"; 
}
if($iCat !="") $sql_filter  .= " AND pcat_id = '" . $iCat . "'";
//if($iLev !="") $sql_filter  .= " AND lev_id = '" . $iLev . "'";

//Lay ra danh muc cha
$arrayParent = array();
$arrayParent[''] = "Chọn Danh mục cha";
$db_parent = new db_query("SELECT com_id,com_content
                             FROM ".$fs_table."
                             WHERE 1
                             ORDER BY com_id DESC");
while($row = mysql_fetch_array($db_parent->result)){
   $arrayParent[$row["com_id"]] = $row["com_content"];
}
unset($db_parent);

//Tim kiem theo Danh muc va theo Level
//$list->addSearch(translate_text("Danh mục cha"),"iParent","array",$arrayParent,$iParent);
//$list->addSearch(translate_text("Level"),"iLev","array",$arr_lev,$iLev);
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add($name_field,"Tên câu thảo luận","string", 1, 1);
$list->add("rep_content","Câu trả lời thảo luận","string",1,1);
$list->add("com_active","Active","int", 0, 0);

$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total      = new db_count("SELECT  count(*) AS count 
                            FROM comments 
                            LEFT JOIN comments_reply
                            ON com_id = rep_comment_id 
                            WHERE 1".$list->sqlSearch().$sql_filter);
//câu lệnh select dữ liêu                    
$db_listing   = new db_query("SELECT * FROM comments 
                              LEFT JOIN comments_reply
                              ON com_id = rep_comment_id 
                              WHERE 1".$list->sqlSearch().$sql_filter
                              . " ORDER BY " . $list->sqlSort() . "com_id DESC "
                              . $list->limit($total->total));
                                 
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
   $check_content = '';
   while($row = mysql_fetch_assoc($db_listing->result)){
   $i++;

   ?>    
      <?=$list->start_tr($i, $row[$id_field])?>
      <!-- <td align="center">
    </td> -->
      
      <td width="250" class="bold" align="center">
         <textarea style="width: 400px;height: 25px;"><?=truncateString_(removeHTML(($row['com_content'])),120)?></textarea>
      </td>
      <td width="300" align="center">
         <?if($row['rep_content']){
            $type = 'del_reply';
            $type_act = 'act_reply';
            $record_id = $row['rep_id'];
            $act_action = $row['rep_active'];
            $fs_edit    = 'edit_reply.php';
            ?>
            <textarea style="width: 400px;height: 25px;"><?=truncateString_(removeHTML(($row['rep_content'])),120)?></textarea>
         <?}else{
            $type ='del_comment';
            $type_act = 'act_comment';
            $record_id = $row['com_id'];
            $act_action = $row['com_active'];
            $fs_edit    = 'edit_comment.php';
            ?>
            <span style="color: red;">Chưa có câu trả lời</span>
         <?}?>
      </td>      
      <td align="center" width="16">
              <a onClick="loadactive(this); return false;" href="active.php?record_id=<?=$record_id?>&type=<?=$type_act?>&value=<?=abs($rowComment["com_active"]-1)?>&url=<?=base64_encode(getURL())?>">
              <img border="0" src="<?=$fs_imagepath?>check_<?=$act_action?>.gif" title="Active!"/>
            </a>
      <td align="center" width="16"><a class="text" href="<?=$fs_edit?>?record_id=<?=$record_id?>&returnurl='.base64_encode(getURL()).'"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"></a></td>
      <? $del_ques = '<td align="center"><img src="'.$fs_imagepath.'delete.gif" alt="DELETE" border="0" onClick="if (confirm(\'Bạn có muốn xóa bản ghi?\')){ window.location.href=\'delete.php?record_id='.$record_id.'&type='.$type.'&returnurl='.base64_encode(getURL()).'\'}" style="cursor:pointer"></td>'; ?>
            <?=$del_ques?>
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
         var iParent       =  $("#iParent").val();
         window.location  = "listing.php?iParent=" +iParent;
      });
      $('#iCat').change(function (){
         var iParent       =  $("#iParent").val();
         var iCat         = $("#iCat").val();
         window.location  = "listing.php?iParent="+ iParent +"&iCat="+ iCat;
      });
   });
</script>