<?
include("inc_security.php");
checkAddEdit("edit");


$fs_title			= $module_name . " | Chi tiết";
$record_id = getValue("record_id");
$db_record = new db_query("SELECT * FROM courses
                           INNER JOIN categories_multi ON courses.cou_cat_id=categories_multi.cat_id
                           INNER JOIN levels ON courses.cou_lev_id=levels.lev_id
                           WHERE ".$id_field." = ".$record_id);
$db_result = $db_record->result;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style type="text/css">
.label{
    font-family: Arial,Helvetica,sans-serif;
    font-size:14px;
    font-weight:bold;
}
h2{
    font-size:16px;
    text-transform: uppercase;
}
</style>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<?=template_top($fs_title) ?>
   <div style="padding-left: 30px;">
      <?php $row=mysqli_fetch_assoc($db_result);?>
      <h2>Thông tin chi tiết khóa học</h2>
      <p>
         <span class="label">Hình đại diện</span>
      </p>
      <img border="1" src="<?=$imgpath . "medium_" . $row['cou_avatar'] ?>" />
      <p><span class="label">Tên khóa học: </span><?php echo $row[$name_field];?></p>
      <p><span class="label">Danh mục: </span><?php echo $row['cat_name'];?></p>
      <p><span class="label">Level: </span><?php echo $row['lev_name'];?></p>
      <p><span class="label">Thời gian khởi tạo: </span><?=date("d/m/Y",$row['cou_time']);?></p>
      <p><span class="label">Hình thức: </span>
      <?php if($row['cou_charge']== 0)
                  echo "Miễn phí";
            else
                  echo "Trả tiền";
      ?>
      </p>
      <p><span class="label">Thông tin khóa học: </span> </p>
      <p><?php echo $row['cou_info']; ?></p>
   </div>
<?=template_bottom() ?>
</body>

