<?php
require_once("../home/config.php");


$json             = array();
$success          = 0;
$message          = '';
$list_cou         = '';

$arrCategory        = array();
$arrNews            = array();
$arrItemNews        = array();

$iCategory          = getValue('iCategory','int','POST',0);
$arrayLibraryType   = array(1 => "Game"
                           ,2 => "Truyện"
                           ,3 => "Bài hát"
                           ,4 => "Video");
//GET INFO CATEGORY BY ID
$dbCategory         =   new db_query("SELECT * FROM library_cate WHERE lib_cat_id =".$iCategory);
$arrInfoCategory    =   $dbCategory->resultArray();
$catType            =   $arrInfoCategory[0]['lib_cat_type'];

switch ($catType) {
    case 1:
        $tableLibrary   = 'library_game';
        $idLibrary      = 'lib_game_id';
        $idLibraryCat   = 'lib_game_catid';
        $nameItem       = 'lib_game_title';
        $desItem        = 'lib_game_info';
        $imgItem        = 'lib_game_image';
        $urlImgItem     = $var_path_library_game_medium;
        break;
    case 2:
        $tableLibrary   = 'library_story';
        $idLibrary      = 'lib_story_id';
        $idLibraryCat   = 'lib_story_catid';
        $nameItem       = 'lib_story_title';
        $desItem        = 'meta_description';
        $imgItem        = 'lib_story_image';
        $urlImgItem     = $var_path_library_story_medium;
        break;
    case 3:
        $tableLibrary   = 'library_song';
        $idLibrary      = 'lib_song_id';
        $idLibraryCat   = 'lib_song_catid';
        $nameItem       = 'lib_song_title';
        $desItem        = 'lib_song_info';
        $imgItem        = 'lib_song_image';
        $urlImgItem     = $var_path_library_song_medium;
        break;
    case 4:
        $tableLibrary   = 'library_video';
        $idLibrary      = 'lib_video_id';
        $idLibraryCat   = 'lib_video_catid';
        $nameItem       = 'lib_video_title';
        $desItem        = 'lib_video_info';
        $imgItem        = 'lib_video_image';
        $urlImgItem     = $var_path_library_video_medium;
        break;
    default:
        # code...
        break;
}

// COUNT ITEM LIB BY CATID
$dbItemLibCount = new db_query('SELECT COUNT('.$idLibrary.') 
                                    AS count_lib_item 
                                  FROM '.$tableLibrary.' 
                                 WHERE '.$idLibraryCat.' = '.$iCategory);
$rowCount       = mysql_fetch_assoc($dbItemLibCount->result);
$countItemLib   = $rowCount['count_lib_item'];

// GET CATE OR ITEM LIB
if($countItemLib == 0){
    $dbCategoryChild         =   new db_query('SELECT * FROM library_cate WHERE lib_cat_parent_id ='.$iCategory);
    $arrInfoCategoryChild    =   $dbCategoryChild->resultArray();
}else{

    $dbLibItem               =   new db_query('SELECT a.'.$idLibrary.',
                                                      a.'.$idLibraryCat.',
                                                      a.'.$nameItem.',
                                                      a.'.$desItem.',
                                                      b.lib_cat_id,
                                                      b.lib_cat_name
                                            FROM '.$tableLibrary.' a,library_cate b
                                           WHERE a.'.$idLibraryCat.' = b.lib_cat_id 
                                             AND '.$idLibraryCat.' = '.$iCategory);

    $arrLibItem              =   $dbLibItem->resultArray();
}

// FREE RAM
unset($dbCategory);
unset($dbCategoryChild);
unset($dbLibItem);

$page             = getValue('page','int','POST',1);
$pageCount        = getValue('pageCount','int','POST',0);
$end              = getValue('end','int','POST',0);

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
    if(isset($arrLibItem[($start-1)][$idLibrary])){ 
        $list_cou .= '<div class="content-show-courses">';
            $list_cou .= '<div class="content-show-courses-img">';
                $list_cou .= '<a href="http://'.$base_url.'/thu-vien/'.$arrLibItem[($start-1)]["lib_cat_id"].'/'.removeTitle($arrLibItem[($start-1)]["lib_cat_name"]).'/'.$arrLibItem[($start-1)][$idLibrary].'/'.removeTitle($arrLibItem[($start-1)][$nameItem]).'.html">';
                    $list_cou .= '<img src="'.$urlImgItem.$arrLibItem[$start-1]["imgItem"].'/course15.jpg" alt="full-screen-slider">';
                $list_cou .= '</a>';
            $list_cou .= '</div>';
            $list_cou .= '<div class="content-show-courses-info">';
                $list_cou .= '<div class="content-show-courses-info-price">';
                    $list_cou .= '<a href="http://'.$base_url.'/thu-vien/'.$arrLibItem[($start-1)]["lib_cat_id"].'/'.removeTitle($arrLibItem[($start-1)]["lib_cat_name"]).'/'.$arrLibItem[($start-1)][$idLibrary].'/'.removeTitle($arrLibItem[($start-1)][$nameItem]).'.html">';
                        $list_cou .= '<span class="library-info-title">'.truncateString_($arrLibItem[($start-1)][$nameItem],20).'</span>';
                    $list_cou .= '</a>';
                $list_cou .= '</div>';
                $list_cou .= '<div class="content-show-courses-info-details">';
                    $list_cou .= '<span class="font-bold">'.$arrLibItem[($start-1)][$nameItem].'</span></br>';
                    $list_cou .= '<span>'.$arrLibItem[($start-1)]['lib_cat_name'].'</span>';
                $list_cou .= '</div>';
            $list_cou .= '</div>';
        $list_cou .= '</div>';
    }
$countItemNews++;}

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
                             url:"/ajax/paging_library.php",
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
