<?php
require_once("../home/config.php");


$json             = array();
$success          = 0;
$message          = '';
$list_cou         = '';
$list_page        = '';

$arrCategory        = array();
$arrNews            = array();
$arrItemNews        = array();

$iCategory          = getValue('iCategory','int','POST',0);

if($iCategory != 0){

    $menu               = new menu();
    $listAll            = $menu->getAllChild('post_category','pcat_id','pcat_parent_id',$iCategory,' pcat_type = 1 AND pcat_active = 1','pcat_id','pcat_order ASC,pcat_order ASC, pcat_name ASC','pcat_has_child');
    $countCateChild     = count($listAll);

    // GET INFO CATEGORY
    $dbCategory         =   new db_query("SELECT * FROM post_category WHERE pcat_id =".$iCategory);
    $arrInfoCategory    =   $dbCategory->resultArray();

    // SAVE ARR CATEGORY
    if($countCateChild != 0){
        foreach($listAll as $value){
            $arrCategory[] = $value['pcat_id'];
        }
    }else{
        $arrCategory[] = $iCategory;
    }

    // GET NEWS BY CAT_ID
    $count_news = 0;
    foreach($arrCategory as $value){
        $dbNews         =   new db_query("SELECT a.post_id,
                                                 a.post_title,
                                                 a.post_content,
                                                 a.post_time,
                                                 a.post_description,
                                                 a.post_picture,
                                                 b.pcat_id,
                                                 b.pcat_name
                                            FROM posts a,post_category b
                                           WHERE a.post_pcat_id = b.pcat_id 
                                             AND post_pcat_id = ".$value." 
                                             AND post_active = 1 ORDER BY post_time DESC");
        $arrNewsChild   =   $dbNews->resultArray();
        $count_news    +=   count($arrNewsChild);
        array_push($arrNews, $arrNewsChild);
    }

    // LIST ITEM
    $countItemNews = 1; 
    for($i = 0;$i < count($arrNews);$i++){
        for($j = 0;$j < count($arrNews[$i]);$j++){ 
        $arrItemNews[$countItemNews] = array(
            'post_id'           => $arrNews[$i][$j]['post_id'],
            'post_title'        => $arrNews[$i][$j]['post_title'],
            'post_description'  => $arrNews[$i][$j]['post_description'],
            'post_time'         => $arrNews[$i][$j]['post_time'],
            'post_picture'      => $arrNews[$i][$j]['post_picture'],
            'pcat_id'           => $arrNews[$i][$j]['pcat_id'],
            'pcat_name'         => $arrNews[$i][$j]['pcat_name']
        ); 
        $countItemNews++; } 
    }

}else{

    $arrInfoCategory                            =   array();
    $arrInfoCategory[0]['pcat_name']            =   'TIN TỨC SỰ KIỆN';
    $arrInfoCategory[0]['pcat_description']     =   'Tin tức, học bổng TiengAnh2020';

    $dbNews         =   new db_query("SELECT a.post_id,
                                             a.post_title,
                                             a.post_content,
                                             a.post_time,
                                             a.post_description,
                                             a.post_picture,
                                             b.pcat_id,
                                             b.pcat_name
                                        FROM posts a,post_category b
                                       WHERE a.post_pcat_id = b.pcat_id 
                                         AND post_active = 1 ORDER BY post_time DESC");
    $arrNews        =   $dbNews->resultArray();
    $count_news     =   count($arrNews);

    $countItemNews = 1; 
    for($i = 0;$i < count($arrNews);$i++){
        $arrItemNews[$countItemNews] = array(
            'post_id'           => $arrNews[$i]['post_id'],
            'post_title'        => $arrNews[$i]['post_title'],
            'post_description'  => $arrNews[$i]['post_description'],
            'post_time'         => $arrNews[$i]['post_time'],
            'post_picture'      => $arrNews[$i]['post_picture'],
            'pcat_id'           => $arrNews[$i]['pcat_id'],
            'pcat_name'         => $arrNews[$i]['pcat_name']
        ); 
        $countItemNews++; 
    }

}

$page          	  = getValue('page','int','POST',1);
$pageCount     	  = getValue('pageCount','int','POST',0);
$end			        = getValue('end','int','POST',0);

$num_new_list     = 10;
if($page != 1){
    $startPage        = (($page-1) * $num_new_list) + 1;
    $endPage          = (($page-1) * $num_new_list) + $num_new_list;   
}else{
    $startPage        = 1;
    $endPage          = 10;  
}

$countItemNews = 1;
for($start = $startPage;$start <= $endPage;$start++){ 
    if(isset($arrItemNews[$start]['post_id'])){ 
    if(($countItemNews) % 2 == 0){$class='community-color-even';}else{$class='community-color-retail';}
        $list_cou .= '<div class="content-show-news '.$class.'">';
            $list_cou .= '<div class="news_show_img">';
                $list_cou .= '<img src="'.$var_path_post_medium.$arrItemNews[$start]['post_picture'].'" alt="">';
            $list_cou .= '</div>';
            $list_cou .= '<div class="content-show-courses-info news-show-info">';
                $list_cou .= '<div class="content-show-courses-info-price news-show-price">';
                    $list_cou .= '<a href="http://'.$base_url.'/tin-tuc/'.removeTitle($arrItemNews[$start]["post_title"]).'/c'.$arrItemNews[$start]["pcat_id"].'p'.removeTitle($arrItemNews[$start]["post_id"]).'.html">';
                        $list_cou .= '<span>'.$arrItemNews[$start]["post_title"].'</span>';
                    $list_cou .= '</a>';
                $list_cou .= '</div>';
                $list_cou .= '<div class="content-show-courses-info-price news-show-des">';
                    $list_cou .= '<span>'.$arrItemNews[$start]["post_description"].'</span>';
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
                             url:"/ajax/paging_news.php",
                             data:{
                                iCategory:'.$iCategory.',
                                page:page,
                                pageCount:'.$pageCount.'
                             },
                             success:function(data){
                                  $(".community-content-show").fadeOut(0,function(){
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
