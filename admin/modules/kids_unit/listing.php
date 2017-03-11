<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

$iCourses   = getValue("iCourses");
if($iCourses>0) {$sql_search = " AND kcou_id =".$iCourses; }else{ $sql_search = ""; }
$list->add("kcou_title","Danh mục","string",0,0);
$list->add($name_field,"Tên khóa học","string", 1, 1);
$list->add("kunit_title_vie","Tên TV khóa học","string", 1, 1);
$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");

$db_courses = new db_query("SELECT kcou_id,kcou_title FROM kids_courses");
while($row_courses = mysql_fetch_assoc($db_courses->result)){
  $arrayCourses[$row_courses["kcou_id"]] = $row_courses["kcou_title"];
}unset($db_course);

$list->addSearch("Khóa học","Courses_search","array",$arrayCourses,$iCourses);

//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count 
								FROM  kids_units 
								INNER JOIN kids_courses ON kids_units.kcou_id=kids_courses.kcou_id
								WHERE 1".$sql_search);
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM  kids_units 
								INNER JOIN kids_courses ON kids_units.kcou_id=kids_courses.kcou_id
								WHERE 1".$sql_search
									  ." ORDER BY  " . $list->sqlSort() . "kunit_id DESC "
                              .	$list->limit($total->total) );
                                 
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
   ?>    
      <?=$list->start_tr($i, $row[$id_field])?>
      <td class="bold" align="">
         <input type="text" style="width: 200px;color: red;" value="<?=$row[$name_field]?>" />
         <!--<a style="text-decoration: none;" class="thickbox noborder a_detail" title="Xem chi tiết" href="<?//=$fs_redirect?>?record_id=<?//=$row[$id_field]?>&TB_iframe=true&amp;height=450&amp;width=950">Details</a>-->
      </td>  
	  <td>
          <input style="color: #1C3E7F;" type="text" value="<?=$row['kcou_title']?>" />
      </td>	 
      <td>
          <input style="color: #1C3E7F;" type="text" value="<?=$row['kunit_title_vie']?>" />
      </td>	 
      <?=$list->showEdit($row['kunit_id'])?>
      <?=$list->showDelete($row['kunit_id'])?>
      <?=$list->end_tr()?>
   <?
     }
   ?>  
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>