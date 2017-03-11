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
    $listAll            = $menu->getAllChild('categories_multi','cat_id','cat_parent_id',$iCategory,' cat_type = 2 AND cat_active = 1','cat_id','cat_order ASC,cat_order ASC, cat_name ASC','cat_has_child');
    $countCateChild     = count($listAll);

    // GET INFO CATEGORY
    $dbCategory         =   new db_query('SELECT * FROM categories_multi WHERE cat_id ='.$iCategory.' AND cat_type = 2');
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
        $dbNews         =   new db_query("SELECT a.postcom_id,
                                                 a.postcom_title,
                                                 a.postcom_time,
                                                 a.postcom_view,   
                                                 b.cat_id,
                                                 b.cat_name
                                            FROM post_community a,categories_multi b
                                           WHERE a.postcom_cat_id = b.cat_id 
                                             AND postcom_cat_id = ".$value." 
                                             AND postcom_active = 1 ORDER BY postcom_time DESC");
        $arrNewsChild   =   $dbNews->resultArray();
        $count_news    +=   count($arrNewsChild);
        array_push($arrNews, $arrNewsChild);
    }

    // LIST ITEM
    $countItemNews = 1; 
    for($i = 0;$i < count($arrNews);$i++){
        for($j = 0;$j < count($arrNews[$i]);$j++){ 
        $arrItemNews[$countItemNews] = array(
            'postcom_id'           => $arrNews[$i][$j]['postcom_id'],
            'postcom_title'        => $arrNews[$i][$j]['postcom_title'],
            'postcom_time'         => $arrNews[$i][$j]['postcom_time'],
            'postcom_view'         => $arrNews[$i][$j]['postcom_view'],
            'cat_id'               => $arrNews[$i][$j]['cat_id'],
            'cat_name'             => $arrNews[$i][$j]['cat_name']
        ); 
        $countItemNews++; } 
    }

}else{

    $arrInfoCategory                            =   array();
    $arrInfoCategory[0]['cat_name']            =   'CỘNG ĐỒNG';
    $arrInfoCategory[0]['cat_description']     =   'Cộng đồng TiengAnh2020';

    $dbNews         =   new db_query("SELECT a.postcom_id,
                                             a.postcom_title,
                                             a.postcom_time,
                                             a.postcom_view,   
                                             b.cat_id,
                                             b.cat_name
                                        FROM post_community a,categories_multi b
                                       WHERE a.postcom_cat_id = b.cat_id 
                                         AND b.cat_active = 1
                                         AND postcom_active = 1 ORDER BY postcom_time DESC");
    $arrNews        =   $dbNews->resultArray();
    $count_news     =   count($arrNews);

    $countItemNews = 1; 
    for($i = 0;$i < count($arrNews);$i++){
        $arrItemNews[$countItemNews] = array(
            'postcom_id'           => $arrNews[$i]['postcom_id'],
            'postcom_title'        => $arrNews[$i]['postcom_title'],
            'postcom_time'         => $arrNews[$i]['postcom_time'],
            'postcom_view'         => $arrNews[$i]['postcom_view'],
            'cat_id'               => $arrNews[$i]['cat_id'],
            'cat_name'             => $arrNews[$i]['cat_name']
        ); 
        $countItemNews++; 
    }

}

$page          	  = getValue('page','int','POST',1);
$pageCount     	  = getValue('pageCount','int','POST',0);
$end			        = getValue('end','int','POST',0);

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
    if(isset($arrItemNews[$start]['postcom_id'])){ 
    if(($countItemNews) % 2 == 0){$class='community-color-even';}else{$class='community-color-retail';}
        $list_cou .= '<div class="content-show-community">';
            $list_cou .= '<div class="content-show-courses-info community-show-info">';
                $list_cou .= '<div class="content-show-courses-info-price community-show-price">';
                        $list_cou .= '<a href="http://'.$base_url.'/cong-dong/'.$arrItemNews[$start]["cat_id"].'/'.removeTitle($arrItemNews[$start]["cat_name"]).'/'.$arrItemNews[$start]["postcom_id"].'/'.removeTitle($arrItemNews[$start]["postcom_title"]).'.html">';
                            $list_cou .= '<span class="community-title">'.$countItemNews.' . '.truncateString_($arrItemNews[$start]["postcom_title"],80).'</span>';
                        $list_cou .= '</a>';
                $list_cou .= '</div>';
            $list_cou .= '<div class="content-show-courses-info-details community-info-details">';
                $list_cou .= '<span class="comunity-info-admin">'.$arrItemNews[$start]["cat_name"].'</span>';
                $list_cou .= '<span class="comunity-info-view">'.$arrItemNews[$start]["postcom_view"].'</span>';
                $list_cou .= '<span class="comunity-info-date">'.date("d/m/Y",$arrItemNews[$start]["postcom_time"]).'</span>';
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
                             url:"/ajax/paging_community.php",
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
