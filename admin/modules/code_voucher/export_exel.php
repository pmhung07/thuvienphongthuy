<?
include_once('inc_security.php');
$search = getValue('search','int','GET',0);
$fil_search = "";
if($search == 1){
   $code_vou_status     = getValue('code_vou_status','int','GET',0);
   $code_vou_uni        = getValue('code_vou_uni','str','GET','');
   if($code_vou_uni != ''){
      $fil_search = " AND code_vou_status =".$code_vou_status." AND code_vou_uni ='".$code_vou_uni."'";
   }else{
      $fil_search = " AND code_vou_status =".$code_vou_status;
   }
}
$db_listing          = new db_query("SELECT code_vou_seri,code_vou_time,code_vou_uni,code_vou_creat,code_vou_uid,code_vou_status
                                    FROM code_voucher
                                    WHERE 1 ".$fil_search." ORDER BY code_vou_creat DESC");
$arr_voucher         = $db_listing->resultArray();
if($arr_voucher){
   $excel               = new ExportDataExcel('browser');
   $time = date('d_m_Y',time());
   $excel->filename     = "$time"."_voucher.xls";
   $data                = array("Mã seri","Tổng số ngày","Mã trường","Ngày tạo","Email","Trạng thái");
   $excel->initialize();
   $excel->addRow($data);
   foreach($arr_voucher as $row) {
      $row['code_vou_creat']  = date('d/m/Y',$row['code_vou_creat']);
      $row['code_vou_status'] = ($row['code_vou_status'] ==='0')?'Chưa sử dụng':'Đã sử dụng';
      $row['code_vou_uid']    = ($row['code_vou_uid'] != 0)?'Đã sử dụng':'Chưa sử dụng';
      $excel->addRow($row);
   }
   $excel->finalize();
}else{
   ?>
   <script>
      window.close();
   </script>
   <?
}
?>