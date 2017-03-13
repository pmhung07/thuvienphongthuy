<?php
require_once("../home/config.php");


$json             = array();
$success          = 0;
$message          = '';
$list_cou         = '';
$list_page        = '';

$arrCategory        = array();
$arrSkill           = array();
$arrItemSkill       = array();

$iCategory          = getValue('iCategory','int','POST',0);

if($iCategory != 0){
    $menu               = new menu();
    $listAll            = $menu->getAllChild('categories_multi','cat_id','cat_parent_id',$iCategory,' cat_type = 0 AND cat_active = 1','cat_id','cat_order ASC,cat_order ASC, cat_name ASC','cat_has_child');
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
    $countSkill = 0;
    foreach($arrCategory as $value){
        $dbCourses     =   new db_query("SELECT skl_les_id,
                                                skl_les_name,
                                                skl_les_img,
                                                cat_id,
                                                cat_name
                                           FROM skill_lesson a,
                                                categories_multi b
                                          WHERE a.skl_les_cat_id = b.cat_id
                                            AND skl_les_cat_id = ".$value." ORDER BY skl_les_order");
        $arrCoursesChild    =   $dbCourses->resultArray();
        $countSkill         +=   count($arrCoursesChild);
        unset($dbCourses);
        array_push($arrSkill, $arrCoursesChild);
    }

    // LIST ITEM
    $countItemSkill = 1;
    for($i = 0;$i < count($arrSkill);$i++){
        for($j = 0;$j < count($arrSkill[$i]);$j++){

            // COUNT LESSON SKILL
            $dbLessonCount = new db_query('SELECT COUNT(skl_cont_id)
                                               AS count_lesson
                                             FROM skill_content
                                            WHERE skl_cont_les_id = '.$arrSkill[$i][$j]['skl_les_id']);
            $row_count = mysqli_fetch_assoc($dbLessonCount->result);

            $arrItemSkill[$countItemSkill] = array(
                'skl_les_id'        => $arrSkill[$i][$j]['skl_les_id'],
                'skl_les_name'      => $arrSkill[$i][$j]['skl_les_name'],
                'skl_les_img'       => $arrSkill[$i][$j]['skl_les_img'],
                'cat_id'            => $arrSkill[$i][$j]['cat_id'],
                'cat_name'          => $arrSkill[$i][$j]['cat_name'],
                'count_lesson'      => $row_count['count_lesson']
            );
            $countItemSkill++; }
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
    if(isset($arrItemSkill[$start]["skl_les_id"])){
        $list_cou .= '<div class="content-show-courses">';
            $list_cou .= '<div class="content-show-courses-img">';
                $list_cou .= '<a href="'.generate_skill_details_link($arrItemSkill[$start]["cat_id"],$arrItemSkill[$start]["cat_name"],$arrItemSkill[$start]["skl_les_id"],$arrItemSkill[$start]["skl_les_name"]).'">';
                    $list_cou .= '<img src="'.$var_path_skill_medium.$arrItemSkill[$start]["skl_les_img"].'" alt="'.$arrItemSkill[$start]["skl_les_img"].'">';
                $list_cou .= '</a>';
            $list_cou .= '</div>';
            $list_cou .= '<div class="content-show-courses-info">';
                //$list_cou .= '<div class="content-show-courses-info-price">';
                    //$list_cou .= '<span>200.000 VNĐ</span>';
                //$list_cou .= '</div>';
                $list_cou .= '<div class="content-show-courses-info-title">';
                    $list_cou .= '<a href="'.generate_skill_details_link($arrItemSkill[$start]["cat_id"],$arrItemSkill[$start]["cat_name"],$arrItemSkill[$start]["skl_les_id"],$arrItemSkill[$start]["skl_les_name"]).'">';
                        $list_cou .= '<span>'.truncateString_($arrItemSkill[$start]['skl_les_name'],20).'</span>';
                    $list_cou .= '</a>';
                $list_cou .= '</div>';
                $list_cou .= '<div class="content-show-courses-info-details">';
                    $list_cou .= '<span>'.$arrItemSkill[$start]["skl_les_name"] .' | <b>'.$arrItemSkill[$start]["count_lesson"].' Lessons</b></span>';
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
                             url:"/ajax/paging_skill.php",
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
