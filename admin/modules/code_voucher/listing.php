<?
require_once("inc_security.php");
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

$sql_search = "1";
$iPayment = getValue("iPayment");
$list             = new fsDataGird($id_field,"code_vou_seri",translate_text("Countries Listing"));
$sqlWhere         = "";
$fil_search = "";
$search		= getValue("search","int","GET",0);
$code_vou_status = '0';
$code_vou_uni    = '';
if($search == 1){
   $code_vou_status = getValue("code_vou_status","int","GET",0);
   $code_vou_uni = getValue("code_vou_uni","str","GET","");
   if($code_vou_uni == "Enter keyword"){
      $code_vou_uni = "";
   }
   if($code_vou_uni != ''){
      $fil_search = " AND code_vou_status =".$code_vou_status." AND code_vou_uni LIKE '%".$code_vou_uni."%'";
   }else{
      $fil_search = " AND code_vou_status =".$code_vou_status." AND code_vou_uni LIKE '%".$code_vou_uni."%'";
   }
}
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$arr_use = array(0=>"Chưa sử dụng",1=>"Đã sử dụng");
$list->addSearch(translate_text("Status"),"code_vou_status","array",$arr_use,"code_vou_status");
$list->addSearch(translate_text("University Code"),"code_vou_uni","text",""," ");
$list->add("code_vou_seri","Seri","string",0,0);
$list->add("code_vou_time","Total Date","int", 0, 0);
$list->add("code_vou_uni","University Code","string",0,0);
$list->add("code_vou_creat","Creat Date","date", 0, 0);
$list->add("code_vou_uid","User Email","int", 0, 0);
$list->add("code_vou_status","Status","int", 0, 0);


//$list->add("",translate_text("Edit"),"edit");
//$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT count(*) AS count FROM code_voucher
                               WHERE 1 ".$fil_search." ORDER BY code_vou_creat DESC");
//câu lệnh select dữ liêu			
$db_listing 	= new db_query("SELECT * FROM code_voucher
                               WHERE 1 ".$fil_search." ORDER BY code_vou_creat DESC "
                              . $list->limit($total->total));
$total_row = mysql_num_rows($db_listing->result);

//$list->addSearch("---Payment----","Payment_search","array",$arrayPayment,$iPayment);
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
   $sum_money = 0;
   //thực hiện lênh select csdl
   while($row	=	mysql_fetch_assoc($db_listing->result)){
   $i++;
   ?>    
      <?=$list->start_tr($i, $row["code_vou_id"])?>
      <td align="center" width="300">
         <input style="width: 150px;color: red;" type="text" value="<?=$row["code_vou_seri"]?>" />
      </td>
      <td align="center" width="150">
         <input style="width: 30px;color: blue;" type="text" value="<?=$row["code_vou_time"]?>" /> ngày
      </td>
      <td align="center" width="280">
         <input style="width: 70px;color: blue;" type="text" value="<?=$row["code_vou_uni"]?>" />
      </td>
      <td align="center" width="280">
         <input style="width: 80px;color: blue;" type="text" value="<?=date("d-m-Y",$row["code_vou_creat"])?>" />
      </td>
      <td align="center" width="280">
         <?
         if($row["code_vou_uid"] != 0){
            $db_listing_mail 	= new db_query("SELECT use_email FROM users WHERE use_id = ".$row["code_vou_uid"]);
            if($row_mail = mysql_fetch_assoc($db_listing_mail->result)){ $email = $row_mail['use_email']; }
         }else { $email = "Chưa sử dụng";}
         ?>
         <input style="width: 100px;color: blue;" type="text" value="<?=$email?>" />
      </td>
      <td align="center" width="280">
         <input style="width: 100px;color: blue;" type="text" value="<?=($row["code_vou_status"] == 0)?"Chưa sử dụng":"Đã sử dụng"?>" />
      </td>
      <?=$list->end_tr()?>
   <?}?>  
   <?=$list->showFooter($total_row,'<a class="file_exel" style="font-weight: bold; float: right;" href="javascript:void(0);">Xuất file</a>')?>
</div>
<div>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<script>
   $(document).ready(function() {
      var hidden_sum = $('#hidden_sum').val()+' đồng';
      $('#sum_payment').append(hidden_sum);
      $('.file_exel').live('click',function(){
         var fil_search = "<?=$fil_search?>";
         var url = "export_exel.php?search="+"<?=$search?>"+"&code_vou_status="+"<?=$code_vou_status?>"+"&code_vou_uni="+"<?=$code_vou_uni?>";
         window.open(url);
      });
   });
</script>