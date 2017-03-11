<?
require_once("inc_security.php");
$list          = new fsDataGird("lwr_id","",translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));
$array_teach_success = array( 0 => "Chưa chấm" , 1 => "Đã chấm" );
$iSuccess   = getValue("tesr_teach_success","int","GET",0);
$sql_filter = " AND lwr_status = ".$iSuccess;
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->addSearch(translate_text("Chọn bài thi chưa chấm"),"tesr_teach_success","array",$array_teach_success,$iSuccess);
$list->add("lwr_use_id","User ID","string",0,1);
$list->add("cat_name","Category","string",0,1);
$list->add("cou_name","Course","string",0,1);
$list->add("com_name","Unit","string",0,1);
$list->add("lwr_point","Point","int",0,0);
$list->add("send_mail","Send Mail","int", 0, 1);
$list->add("",translate_text("Chấm "),"edit");
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT count(*) AS count FROM learn_writing_result 
                               INNER JOIN learn_writing ON learn_writing_result.lwr_wri_id=learn_writing.learn_wr_id 
                               INNER JOIN courses_multi ON learn_writing.learn_unit_id=courses_multi.com_id
                               INNER JOIN courses ON courses_multi.com_cou_id = courses.cou_id
                               WHERE 1".$list->sqlSearch().$sql_filter);
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM learn_writing_result 
                               INNER JOIN learn_writing ON learn_writing_result.lwr_wri_id=learn_writing.learn_wr_id 
                               INNER JOIN courses_multi ON learn_writing.learn_unit_id=courses_multi.com_id
                               INNER JOIN courses ON courses_multi.com_cou_id = courses.cou_id
                               WHERE 1".$list->sqlSearch()
									   . $list->sqlSort() . $sql_filter . " ORDER BY lwr_id DESC "
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
      $str_cate = "";
      //select category
      $db_cate = new db_query('SELECT cat_name,cat_parent_id FROM categories_multi WHERE cat_id = '.$row['cou_cat_id']);
      $row_cate = mysql_fetch_assoc($db_cate->result);
      unset($db_cate);
      if($row_cate['cat_parent_id'] == 0){
         $str_cate = $row_cate['cat_name'];
      }else{
         $db_parent = new db_query('SELECT cat_name FROM categories_multi WHERE cat_id = '.$row_cate['cat_parent_id']);
         $row_parent = mysql_fetch_assoc($db_parent->result);
         unset($db_parent);
         $str_cate = $row_parent['cat_name'].'-'.$row_cate['cat_name'];
      }
      //
      $url = 'http://'.$_SERVER['HTTP_HOST'].'/khoa-hoc/'.removeTitle($str_cate).'/' . removeTitle($row['cou_name'])	.	'/' . $row['cou_id'] . '-' . $row['com_id'] . '-write.html'; 
      
   ?>    
      <?=$list->start_tr($i, $row[$id_field])?>
      <td align="center" width="100">
         <input style="text-align: center;color: red;font-weight: bold;font-size: 11px;width: 60px;" value="<?=$row['lwr_use_id']?>" type="text" />
      </td>
      <td align="center" width="100">
         <input style="text-align: center;color: red;font-weight: bold;font-size: 11px;width: 150px;" value="<?=$row_cate['cat_name']?>" type="text" />
      </td>
      <td align="center" width="200">
         <input style="text-align: center;color: red;font-weight: bold;font-size: 11px;width: 250px;" value="<?=$row['cou_name']?>" type="text" />
      </td>
      <td align="center" width="200">
         <input style="text-align: center;color: red;font-weight: bold;font-size: 11px;width: 150px;" value="<?=$row['com_name']?>" type="text" />
      </td>
      <td align="center" width="50">
         <input style="text-align: center;color: red;font-weight: bold;font-size: 11px;width: 20px;" value="<?=$row['lwr_point']?>" type="text" />
      </td>
      <td width="50" align="center">
      	 <?php if ($row['lwr_smail'] == 0) { ?>
         <button id="bt_send_mail" type="button" style="width: 76px;background: #EEE;text-align: center;font-weight: bold;color: red;cursor: pointer;" name="<?=$row['lwr_id']?>">Send Mail</button>
         <?php } ?>
      </td>
      <td align="center" width="15">
   		<a href="edit.php?record_id=<?=$row['lwr_id']?>&user_id=<?=$row['lwr_use_id']?>&les_name=<?=$row['com_name']?>&les_url=<?=$url?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>" title="Bạn muốn sửa đổi bản ghi" rel="tooltip" class="edit">
   			<img border="0" src="../../resource/images/grid/edit.png" />
   		</a>
      </td>
      <?//=$list->showEdit($row['lwr_id'])?>
      <?=$list->showDelete($row['lwr_id'])?>
      <?=$list->end_tr()?>
   <?}?>  
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<?
function removeTitle($string,$keyReplace = "/"){
	 $string = removeAccent($string);
	 $string  =  trim(preg_replace("/[^A-Za-z0-9]/i"," ",$string)); // khong dau
	 $string  =  str_replace(" ","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace($keyReplace,"-",$string);
	 return strtolower($string);
}
?>
<script>
   $("#bt_send_mail").click(function(){
		  var id = $(this).attr("name");
		  $(this).hide();
		  $.ajax({
			type:'POST',
			dataType:'json',
			data:{
				record_id:id,
			 },
			url:'ajax_send_mail_score.php',
			success:function(data){
				if(data.err == "1"){
				   alert(data.msg);	
				   window.location.reload();
				}else{
					alert(data.err);
				}
			 }
		  });
	  })
   
   
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