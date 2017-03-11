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
$list->add("grammar","Ngữ pháp","string", 0, 0);
$list->add("vocabulary","Từ vựng","string", 0, 0);
$list->add("structure","Cấu trúc câu","string", 0, 0);
$list->add("writing","Viết","string", 0, 0);
$list->add("speaking","Nói","string", 0, 0);
$list->add("listening","Nghe","string", 0, 0);
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
   <?=$list->showHeader(1)?>
      <?=$list->start_tr(1, 1)?>
      <td width="150px" align="center">
         <? echo'<a title="Thêm câu hỏi phần ngữ pháp" class="thickbox noborder a_detail" href="add_question.php?url='. base64_encode(getURL()) . '&part=1&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Câu hỏi</b></a>';?>
      </td>
      <td width="150px" align="center">
         <? echo'<a title="Thêm câu hỏi phần từ vựng" class="thickbox noborder a_detail" href="add_question.php?url='. base64_encode(getURL()) . '&part=2&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Câu hỏi</b></a>';?>
      </td>
      <td width="150px" align="center">
         <? echo'<a title="Thêm câu hỏi phần cấu trúc câu" class="thickbox noborder a_detail" href="add_question.php?url='. base64_encode(getURL()) . '&part=3&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Câu hỏi</b></a>';?>
      </td>
      <td width="150px" align="center">
         <? echo'<a title="Thêm câu hỏi phần viết" class="thickbox noborder a_detail" href="add_question.php?url='. base64_encode(getURL()) . '&part=4&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Câu hỏi</b></a>';?>
      </td>
      <td width="150px" align="center">
         <? echo'<a title="Thêm câu hỏi phần nói" class="thickbox noborder a_detail" href="add_question.php?url='. base64_encode(getURL()) . '&part=5&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Câu hỏi</b></a>';?>
      </td>
      <td width="150px" align="center">
         <? echo'<a title="Thêm câu hỏi phần nghe" class="thickbox noborder a_detail" href="add_question.php?url='. base64_encode(getURL()) . '&part=6&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Câu hỏi</b></a>';?>
      </td>
      <?=$list->end_tr()?>
   <?=$list->showFooter(1)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
</style>