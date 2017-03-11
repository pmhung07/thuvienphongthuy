<?php
require_once("../home/config.php");


$json             = array();
$success          = 0;
$message          = '';
$list_cou         = '';
$list_page        = '';

$arrCategory        = array();
$arrCourses         = array();
$arrItemCourses     = array();

$iCategory          = getValue('iCategory','int','POST',0);

if($iCategory != 0){
    $menu               = new menu();
    $listAll            = $menu->getAllChild('categories_multi','cat_id','cat_parent_id',$iCategory,' cat_type = 1 AND cat_active = 1','cat_id','cat_order ASC,cat_order ASC, cat_name ASC','cat_has_child');
    $countCateChild     = count($listAll);
    //GET INFO CATEGORY
    $dbCategory         =   new db_query('SELECT * FROM categories_multi WHERE cat_id ='.$iCategory);
    $arrInfoCategory    =   $dbCategory->resultArray();


    // SAVE ARR CATEGORY
    if($countCateChild != 0){
        foreach($listAll as $value){
            $arrCategory[] = $value['cat_id'];
        }
    }else{
        $arrCategory[] = $iCategory;
    }

    // GET Skill BY CAT_ID
     $countCourses = 0;
    foreach($arrCategory as $value){
        $dbCourses     =   new db_query('SELECT cou_id,
                                                cou_name,
                                                cou_avatar,
                                                cat_id,
                                                cat_name
                                           FROM courses a,
                                                categories_multi b 
                                          WHERE a.cou_cat_id = b.cat_id 
                                            AND cou_cat_id = '.$value.' 
                                            AND cou_active = 1 ORDER BY cou_order');
        $arrCoursesChild    =   $dbCourses->resultArray();
        $countCourses       +=  count($arrCoursesChild);
        unset($dbCourses);
        array_push($arrCourses, $arrCoursesChild);
    }

    // LIST ITEM
    $countItemCount = 1; 
    for($i = 0;$i < count($arrCourses);$i++){
        for($j = 0;$j < count($arrCourses[$i]);$j++){ 

            // COUNT LESSON SKILL
            $dbLessonCount = new db_query('SELECT COUNT(com_id) 
                                               AS count_lesson 
                                             FROM courses_multi 
                                            WHERE com_cou_id = '.$arrCourses[$i][$j]['cou_id']);
            $row_count = mysql_fetch_assoc($dbLessonCount->result);

            $arrItemCourses[$countItemCount] = array(
                'cou_id'        => $arrCourses[$i][$j]['cou_id'],
                'cou_name'      => $arrCourses[$i][$j]['cou_name'],
                'cou_image'     => $arrCourses[$i][$j]['cou_avatar'],
                'cat_id'        => $arrCourses[$i][$j]['cat_id'],
                'cat_name'      => $arrCourses[$i][$j]['cat_name'],
                'count_lesson'  => $row_count['count_lesson'] 
            ); 
            $countItemCount++; } 
            unset($dbLessonCount);
    }
}

$page          	  = getValue('page','int','POST',1);
$pageCount     	  = getValue('pageCount','int','POST',0);

$num_new_list     = 9;
if($page != 1){
    $startPage        = (($page-1) * $num_new_list) + 1;
    $endPage          = (($page-1) * $num_new_list) + $num_new_list;   
}else{
    $startPage        = 1;
    $endPage          = 9;  
}

$countItemNews = 1;
for($start = $startPage;$start <= $endPage;$start++){ 
    if(isset($arrItemCourses[$start]["cou_id"])){ 
        $list_cou .= '<div class="content-show-courses">';
            $list_cou .= '<div class="content-show-courses-img">';
                $list_cou .= '<a href="'.gen_course($arrItemCourses[$start]['cou_id'],$arrItemCourses[$start]['cou_name']).'">';
                    $list_cou .= '<img src="'.$var_path_course_medium.$arrItemCourses[$start]["cou_image"].'" alt="<?=$name?>">';
                $list_cou .= '</a>';
            $list_cou .= '</div>';
            $list_cou .= '<div class="content-show-courses-info">';
                $list_cou .= '<a href="'.gen_course($arrItemCourses[$start]['cou_id'],$arrItemCourses[$start]['cou_name']).'">';
                    $list_cou .= '<div class="content-show-courses-info-title">';
                        $list_cou .= '<span>'.truncateString_($arrItemCourses[$start]['cou_name'],20).'</span>';
                    $list_cou .= '</div>';
                $list_cou .= '</a>';
                $list_cou .= '<div class="content-show-courses-info-details">';
                    $list_cou .= '<span>'.$arrItemCourses[$start]["cou_name"] .' | <b>'.$arrItemCourses[$start]["count_lesson"].' Lessons</b></span>';
                $list_cou .= '</div>';
            $list_cou .= '</div>';
        $list_cou .= '</div>';
    }$countItemNews++;
}

//Phan trang
 $list_cou .= '<div class="paging">';
 $list_cou .= '<div class="paging_listing"><ul>';

if($pageCount > 1){
  if($page > 1){
     $list_cou .= '<a title="'.($page - 1).'" class="a_paging listing_page_pre"> < </a>';
  }
  
  if($pageCount > 10){
        if($page < 9){
           if($page < 6){
              for ($i=1; $i<=9; $i++) {
                 if($i == $page){
                    $list_cou .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                 }else{
                    $list_cou .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                 }
              }
           }else{
              for ($i=1; $i<$page+4; $i++) {
                 if($i == $page){
                    $list_cou .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                 }else{
                    $list_cou .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                 }
              }
           }
           $list_cou .= '<a>…</a>';
           for ($j = ($pageCount - 1); $j <= $pageCount; $j++) { 
              $list_cou .= '<a class="a_paging" title="'.$j.'">'.$j.'</a>';
           }
        }else{
           $go_page = $page + 4;
           if($pageCount - $page > 8 && $go_page < $pageCount - 3){
              for ($i=1; $i<=2; $i++) { 
                 $list_cou .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
              }
              $list_cou .= '<a>…</a>';
              $go_page = ($page + 3 > $pageCount)?$pageCount - 2: $page + 3;
              for($i = ($page - 3); $i <= $go_page; $i++){
                 if($i == $page){
                    $list_cou .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                 }else{
                    $list_cou .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                 }
              }
              $list_cou .= '<a>…</a>';
              for ($j = ($pageCount - 1); $j <= $pageCount; $j++) { 
                 $list_cou .= '<a class="a_paging" title="'.$j.'">'.$j.'</a>';
              }
           }else{
              if($pageCount-$page < 6){
                 for ($i=1; $i<=2; $i++) { 
                    $list_cou .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                 }
                 $list_cou .= '<a>…</a>';
                 for ($i= $pageCount - 8; $i<=$pageCount; $i++) {
                    if($i == $page){
                       $list_cou .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                    }else{
                       $list_cou .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                    }
                 }
              }
              else{
                 for ($i=1; $i<=2; $i++) { 
                    $list_cou .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                 }
                 $list_cou .= '<a>…</a>';
                 for ($i= $page - 3;$i<=$pageCount; $i++) {
                    if($i == $page){
                       $list_cou .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                    }else{
                       $list_cou .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                    }
                 }
              }
  
           }
        }}else{
           for ($i= 1;$i<=$pageCount; $i++) {
              if($i == $page){
                 $list_cou .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
              }else{
                 $list_cou .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
              }
           }
        }
  
  if($page < $pageCount){
     $list_cou .= '<a title="'.($page + 1).'" class="a_paging listing_page_next"> > </a>';
  }
}

$list_cou .= '</ul></div>';
$list_cou .= '</div>';

$list_cou .= '<script type="text/javascript">
                    $(document).ready(function(){
                       $(".a_paging").click(function(){
                          var page = $(this).attr("title");
                          $.ajax({
                             type:"POST",
                             dataType:"json",
                             url:"/ajax/paging_courses.php",
                             data:{
                                iCategory:'.$iCategory.',
                                page:page,
                                pageCount:'.$pageCount.'
                             },
                             success:function(data){
                                  $(".list-courses-main-content-show").fadeOut(0,function(){
                                      $(this).html(data.list_cou).fadeIn(500);
                                  })
                             }
                          });
                       });
                    });
                 </script>';

$json['list_cou'] = $list_cou;
echo json_encode($json);

?>
