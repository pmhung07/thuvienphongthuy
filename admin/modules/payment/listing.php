<?
require_once("inc_security.php");
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

$sql_search = "1";
$transaction_bk = "";
$iPayment = getValue("iPayment");
switch($iPayment){
   case "1":
      $pay = "money_atm_add";
      $transaction_bk = "maa_bk_transaction_id";
      $user_id = "maa_user_id";
      $money = "maa_money";
      $last_date = "maa_last_update";
      $id_field = "maa_id";
      $and = "AND maa_type = 1";
      break;
   case "2":
      $pay = "money_baokim";
      $transaction_bk = "mbk_status = 1 AND mbk_status";
      $user_id = "mbk_user_id";
      $money = "mbk_money";
      $last_date = "mbk_time";
      $id_field = "mbk_id";
      $and = "";
      break;
   case "3":
      $pay = "money_mobile_card_add";
      $transaction_bk = "mmca_bk_transaction_id";
      $user_id = "mmca_user_id";
      $money = "mmca_money";
      $last_date = "mmca_last_update";
      $id_field = "mmca_id";
      $and = "";
      break;
   case "4":
      $pay = "money_home";
      $transaction_bk = "mh_mail";
      $user_id = "mh_user_id";
      $money = "mh_money";
      $last_date = "mh_time";
      $id_field = "mh_id";
      $and = "";
      break;
   case "5":
      $pay = "money_atm_add";
      $transaction_bk = "maa_bk_transaction_id";
      $user_id = "maa_user_id";
      $money = "maa_money";
      $last_date = "maa_last_update";
      $id_field = "maa_id";
      $and = "AND maa_type = 2";
      break;
   default :
      $pay = "money_atm_add";
      $transaction_bk = "maa_bk_transaction_id";
      $user_id = "maa_user_id";
      $money = "maa_money";
      $last_date = "maa_last_update";
      $id_field = "maa_id";
      $and = "AND maa_type = 1";
}
$str_create_date	= getValue("date_pha", "str", "GET", "dd/mm/yyyy", 1);
$create_date   	= convertDateTime($str_create_date, "00:00:00");
$list             = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$sqlWhere         = "";
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add("use_email","Email","string",0,0);
$list->add("maa_money","Money","string", 0, 0);
$list->add("remaining_days","Ngày còn lại","string",0,0);
$list->add("maa_last_update","Date Active","date", 0, 0);

$str_date_start	= getValue("date_start", "str", "GET", "dd/mm/yyyy", 1);
$create_date_start= convertDateTime($str_date_start, "00:00:00");

if($create_date_start > 0 && $str_date_start != "" && $str_date_start != "dd/mm/yyyy"){
	$sqlWhere   .=  " AND ". $last_date ." >= ".    $create_date_start;
}

$str_date_end		= getValue("date_end", "str", "GET", "dd/mm/yyyy", 1);
$create_date_end	= convertDateTime($str_date_end, "00:00:00");

if($create_date_end > 0 && $str_date_end != "" && $str_date_end != "dd/mm/yyyy"){
	$sqlWhere   .=  " AND ". $last_date ." <= ".    $create_date_end;
}
//$list->add("",translate_text("Edit"),"edit");
//$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT count(*) AS count FROM ".$pay."
                               INNER JOIN users ON ".$pay.".".$user_id." = users.use_id
                               WHERE ".$transaction_bk." IS NOT NULL " . $and . $sqlWhere . " ORDER BY ".$last_date." DESC");
//câu lệnh select dữ liêu
$db_listing 	= new db_query("SELECT * FROM ".$pay."
                               INNER JOIN users ON ".$pay.".".$user_id." = users.use_id
                               WHERE ".$transaction_bk." IS NOT NULL " . $and . $sqlWhere . " ORDER BY ".$last_date." DESC "
                              . $list->limit($total->total));
$total_row = mysqli_num_rows($db_listing->result);
$arrayPayment = array(1 => "ATM" , 2 => "Bảo Kim" , 3 => "Card" , 4 => "Home" , 5 => "VISA");
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
<div style="margin-top: 10px;margin-bottom: 10px;border: dashed 1px #CECECE;width: 590px;height: 110px;padding: 10px;margin-left: 5px;">
   <form action="/admin/modules/payment/listing.php" method="GET">
      <div class="t1">
      Hình thức:
      <select id="iPayment" class="textbox" name="iPayment">
			<?foreach($arrayPayment as $key => $value){?>
				<option value="<?=$key?>" <?=($key == $iPayment) ? "selected='selected'": ""?> ><?=$value?></option>
			<?}?>
		</select>
      </div>
      <div class="t1" style="margin-top: 5px;">
   	   Ngày bắt đầu:<input type="text" value="<?=$str_create_date?>" onblur="if(this.value=='') this.value='dd/mm/yyyy'" onfocus="if(this.value=='dd/mm/yyyy') this.value=''" onclick="displayDatePicker('date_start', this);" onkeypress="displayDatePicker('date_start', this);" style="width:90px;" id="date_start" name="date_start" class="textbox" />
   	   Ngày kết thúc:<input type="text" value="<?=$str_create_date?>" onblur="if(this.value=='') this.value='dd/mm/yyyy'" onfocus="if(this.value=='dd/mm/yyyy') this.value=''" onclick="displayDatePicker('date_end', this);" onkeypress="displayDatePicker('date_end', this);" style="width:90px;" id="date_end" name="date_end" class="textbox" />
         <input class="bottom" type="submit" value="Tìm kiếm" />
      </div>
   </form>
   <p style="margin: 5px 2px 2px 0px;"><b>Tổng số đơn hàng :</b> <b style="color: red;"><?=$total_row;?> đơn</b></p>
   <p style="margin: 5px 2px 2px 0px;"><b>Tổng số tiền :</b> <b id="sum_payment" style="color: red;"></b></p>
</div>
<div id="listing">
   <?=$list->showHeader($total_row)?>
   <?
   $i = 0;
   $sum_money = 0;
   //thực hiện lênh select csdl
   while($row	=	mysqli_fetch_assoc($db_listing->result)){
   	//Tinh so ngay con lai
		$cur_time = time();
		if($row['use_date_act_end']>$cur_time) $remaining = intval(($row['use_date_act_end'] - $cur_time)/(24*3600));
		else $remaining = 0;
   $i++;
   $sum_money = $sum_money + $row[$money];
   ?>
      <?=$list->start_tr($i, $row[$id_field])?>
      <td align="center" width="300">
         <input style="width: 300px;" type="text" value="<?=$row['use_email']?>" />
         <?if($pay=="money_home"){?>
            <input style="width: 300px;color: #1C3A70;" type="text" value="<?=$row['mh_address']?>" />
            <input style="width: 300px;color: #1C3A70;" type="text" value="<?=$row['mh_phone']?>" />
            <input style="width: 300px;color: #1C3A70;" type="text" value="<?=$row['mh_comment']?>" />
         <?}?>
		</td>
      <td align="center" width="300">
         <input style="width: 80px;color: red;" type="text" value="<?=format_number($row[$money])?>" /> vnđ
      </td>
      <td align="center" width="100">
         <input style="width: 30px;color: blue;" type="text" value="<?=$remaining?>" /> ngày
      </td>
      <td align="center" width="280">
         <?
            $time = date("d-m-Y : H-i-s", $row[$last_date]);
         ?>
         <input style="color: #e17009;width: 250px;" type="text" value="<?=$time?>" />
      </td>
      <?=$list->end_tr()?>
   <?}?>
   <input id="hidden_sum" type="hidden" value="<?=number_format($sum_money)?>" />
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<script>
   $(document).ready(function() {
      var hidden_sum = $('#hidden_sum').val()+' đồng';
      $('#sum_payment').append(hidden_sum);
   });
</script>