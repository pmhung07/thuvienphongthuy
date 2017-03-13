<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add($name_field,"Phần thi","string", 0, 0);
$list->add("tec_audio","Add Audio","string", 0, 0);
$list->add("add_exe","Add Exercises","string", 0, 0);
$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT count(*) AS count FROM ielt_type
                               INNER JOIN ielts ON iety_ielt_id = ielt_id
                               WHERE iety_type = 2 ".$list->sqlSearch());
//câu lệnh select dữ liêu
$db_listing 	= new db_query("SELECT * FROM ielts
                               INNER JOIN ielt_type ON iety_ielt_id = ielt_id
                               WHERE iety_type = 2 ".$list->sqlSearch()
									   . " ORDER BY " . $list->sqlSort() . "ielt_id DESC "
                              . $list->limit($total->total));

$total_row = mysqli_num_rows($db_listing->result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
   while($row	=	mysqli_fetch_assoc($db_listing->result)){
   $i++;
   ?>
      <?=$list->start_tr($i, $row[$id_field])?>
      <td align="center" width="300px" style="color: red;">
          <table>
            <tr>
               <td width="">Tên phần thi :</td>
               <td><input style="color: blue;font-weight: bold;font-size: 11px;" readonly="" type="text" value="<?=$row['iety_name']?>" /></td>
            </tr>
            <tr>
               <td width="">Thuộc đề thi :</td>
               <td><input style="color: red;font-weight: bold;font-size: 11px;" readonly="" type="text" value="<?=$row['ielt_name']?>" /></td>
            </tr>
         </table>
      </td>
      <td width="150px" align="center">
         <? echo'<a title="Thêm Audio" class="thickbox noborder a_detail" href="add_paragraph.php?url='. base64_encode(getURL()) . '&record_id=' . $row["iety_id"] .'&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Add Audio</b></a>';?>
      </td>
      <td width="150px" align="center">
         <? echo'<a title="Thêm exercises" class="thickbox noborder a_detail" href="add_question.php?url='. base64_encode(getURL()) . '&record_id=' . $row["iety_id"] .'&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Add Question</b></a>';?>
      </td>
      <?=$list->showEdit($row['iety_id'])?>
      <?=$list->showDelete($row['iety_id'])?>
      <?=$list->end_tr()?>
   <?
     }
   ?>
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
</style>