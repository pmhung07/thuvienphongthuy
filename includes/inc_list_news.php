<?php
$arrCategory        = array();
$arrNews            = array();
$arrItemNews        = array();

$iCategory          = getValue('iCategory','int','GET',9);

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

/* PAGING */
$num_new_list = 10;
$total = $count_news;
$page = getValue('page','int','GET',0);
$start = $page;
if(intval($start) == 0){
   $page = 1;
}
$pageCount = (int)($total/$num_new_list);
$div = $total % $num_new_list;          
if($div!= 0){
   $pageCount = $pageCount + 1;
}
$pageCount;
if($page > $pageCount){
   $page = 1;
}
$start = ($page-1)*$num_new_list;
$str = '';

//FREE RAM
unset($dbCategory);
unset($dbNews);
?>
<div class="list-courses">
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="list-courses-main-content-show community-content-show-news">

                        <div class="main_category_breadcrumb">
                            <div class="main_category_parent"><?=$arrInfoCategory[0]['pcat_name']?></div>
                            <?php
                            $dbCategoryChild = new db_query('SELECT * FROM post_category WHERE pcat_parent_id = '.$arrInfoCategory[0]['pcat_id'].' AND pcat_active = 1 AND pcat_type = 1');
                            $arrCategoryChild = $dbCategoryChild->resultArray();
                            if(count($arrCategoryChild) > 0){
                            ?>
                            <div class="main_category_child">
                                <ul>
                                    <?php 
                                    unset($dbCategoryChild);
                                    foreach($arrCategoryChild as $keyArrCateCh => $valueArrCateCh){
                                    ?>
                                        <li>
                                            <a class="<?=($valueArrCateCh['pcat_id'] == $iCat)?'a_active_cate':'';?>" href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($valueArrCateCh['pcat_name'])?>-c<?=$valueArrCateCh['pcat_id']?>.html"><?=$valueArrCateCh['pcat_name']?></a>
                                        </li>   
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } ?>
                        </div>  
                        <div class="main_category_left">
                            <div class="main_category_left_content_top">
                                <div class="main_category_left_content_top_images">
                                    <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[1]['post_title'])?>/c<?=$arrItemNews[1]['pcat_id']?>p<?=$arrItemNews[1]['post_id']?>.html">
                                        <img src="<?=$var_path_post_medium?><?=$arrItemNews[1]['post_picture']?>">
                                    </a>
                                </div>
                                <div class="main_category_left_content_top_details">
                                    <div class="main_category_left_content_top_title">
                                        <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[1]['post_title'])?>/c<?=$arrItemNews[1]['pcat_id']?>p<?=$arrItemNews[1]['post_id']?>.html">
                                            <?=$arrItemNews[1]['post_title']?>
                                        </a>
                                    </div>
                                    <div class="main_category_left_content_top_sapo">
                                        <?=$arrItemNews[1]['post_description']?>
                                    </div>
                                </div>
                            </div>
                            <div class="main_category_left_content_bot">
                                <ul>
                                    <li>
                                        <div class="main_category_left_content_bot_img">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[2]['post_title'])?>/c<?=$arrItemNews[2]['pcat_id']?>p<?=$arrItemNews[2]['post_id']?>.html">
                                                <img src="<?=$var_path_post_medium?><?=$arrItemNews[2]['post_picture']?>">
                                            </a>
                                        </div>
                                         <div class="main_category_left_content_bot_title">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[2]['post_title'])?>/c<?=$arrItemNews[2]['pcat_id']?>p<?=$arrItemNews[2]['post_id']?>.html">
                                                <?=$arrItemNews[2]['post_title']?>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="main_category_left_content_bot_img">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[3]['post_title'])?>/c<?=$arrItemNews[3]['pcat_id']?>p<?=$arrItemNews[3]['post_id']?>.html">
                                                <img src="<?=$var_path_post_medium?><?=$arrItemNews[3]['post_picture']?>">
                                            </a>
                                        </div>
                                         <div class="main_category_left_content_bot_title">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[3]['post_title'])?>/c<?=$arrItemNews[3]['pcat_id']?>p<?=$arrItemNews[3]['post_id']?>.html">
                                                <?=$arrItemNews[3]['post_title']?>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="main_category_left_content_bot_img">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[4]['post_title'])?>/c<?=$arrItemNews[4]['pcat_id']?>p<?=$arrItemNews[4]['post_id']?>.html">
                                                <img src="<?=$var_path_post_medium?><?=$arrItemNews[4]['post_picture']?>">
                                            </a>
                                        </div>
                                         <div class="main_category_left_content_bot_title">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[4]['post_title'])?>/c<?=$arrItemNews[4]['pcat_id']?>p<?=$arrItemNews[4]['post_id']?>.html">
                                                <?=$arrItemNews[4]['post_title']?>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>     

                            <div class="main_category_newest_title">
                                Mới nhất
                            </div>
                            <div class="community-content-show">
                                <?php 
                                    $start  = 1;
                                    $end    = 10;
                                ?>
                                <?php $countItemNews = 1; ?>
                                <?php for($start = 1;$start <= $end;$start++){ ?>
                                    <?php if(isset($arrItemNews[$start]['post_id'])){ ?>
                                        <!---->
                                        <div class="content-show-news <?=(($countItemNews) % 2 == 0)?'community-color-even':'community-color-retail';?>">
                                            <div class="news_show_img">
                                                <img src="<?=$var_path_post_medium?><?=$arrItemNews[$start]['post_picture']?>" alt="">
                                            </div>
                                            <div class="content-show-courses-info news-show-info">
                                                <div class="content-show-courses-info-price news-show-price">
                                                    <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[$start]['post_title'])?>/c<?=$arrItemNews[$start]['pcat_id']?>p<?=$arrItemNews[$start]['post_id']?>.html">
                                                        <span><?=$arrItemNews[$start]['post_title']?></span>
                                                    </a>
                                                </div>
                                                <div class="content-show-courses-info-price news-show-des">
                                                    <span><?=$arrItemNews[$start]['post_description']?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php $countItemNews++; } ?>
                            </div>
                            <?php /*PAGING*/ ?>
                            <div class="paging">
                                <div class="paging_listing">
                                    <ul>
                                    <?if($pageCount > 1){?>
                                        <?php if($page > 1){
                                            $str .= '<a title="'.($page-1).'" class="a_paging listing_page_pre"> < </a>';
                                        }?>
                                        <?php
                                        if($pageCount > 10){
                                            if($page < 9){
                                                if($page < 6){
                                                    for ($i=1; $i<=9; $i++) {
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }else{
                                                    for ($i=1; $i<$page+4; $i++) {
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }
                                                $str .= '<a>…</a>';
                                                for ($j = ($pageCount - 1); $j <= $pageCount; $j++) { 
                                                    $str .= '<a class="a_paging" title="'.$j.'">'.$j.'</a>';
                                                }
                                            }else{
                                                $go_page = $page + 4;
                                                if($pageCount - $page > 8 && $go_page < $pageCount - 3){
                                                    for ($i=1; $i<=2; $i++) { 
                                                        $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                    }
                                                    $str .= '<a>…</a>';
                                                    $go_page = ($page + 3 > $pageCount)?$pageCount - 2: $page + 3;
                                                    for($i = ($page - 3); $i <= $go_page; $i++){
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                    $str .= '<span>…</span>';
                                                    for ($j = ($pageCount - 1); $j <= $pageCount; $j++) { 
                                                        $str .= '<a class="a_paging" title="'.$j.'">'.$j.'</a>';
                                                    }
                                                }else{
                                                    if($pageCount-$page < 6) {
                                                        for ($i=1; $i<=2; $i++) { 
                                                           $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                        $str .= '<span>…</span>';
                                                        for ($i= $pageCount - 8; $i<=$pageCount; $i++) {
                                                            if($i == $page){
                                                                $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                            }else{
                                                                $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                            }
                                                        }
                                                    }else{
                                                        for ($i=1; $i<=2; $i++) { 
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                        $str .= '<span>…</span>';
                                                        for ($i= $page - 3;$i<=$pageCount; $i++) {
                                                            if($i == $page){
                                                                $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                            }else{
                                                                $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                            }
                                                        }
                                                    }
                                                }}}else{
                                                    for ($i= 1;$i<=$pageCount; $i++) {
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }
                                                ?>
                                                <?if($page < $pageCount){
                                                    $str .= '<a title="'.($page+1).'" class="a_paging listing_page_next"> > </a>';
                                                }?>
                                            <?}?>
                                        <?echo $str;?>
                                    </ul>
                                </div>
                            </div>
                            <script type="text/javascript">
                            $(document).ready(function(){
                              $('.a_paging').click(function(){
                                 var page = $(this).attr('title');
                                 $.ajax({
                                    type:'POST',
                                    dataType:'json',
                                    url:'http://<?=$base_url?>/ajax/paging_news.php',
                                    data:{
                                        iCategory:<?=$iCategory?>,
                                        page:page,
                                        pageCount:<?=$pageCount?>,
                                    },
                                    success:function(data){
                                        $(".community-content-show").fadeOut(0,function(){
                                            $(this).html(data.list_cou).fadeIn(500);
                                        })
                                    }
                                 });
                              });
                            });
                            </script>
                        </div>  

                        <div class="main_category_right">
                            <div class="main_category_right_viewest">
                                <div class="main_category_right_viewest_title">
                                    Xem nhiều 
                                </div>
                                <div class="main_category_right_viewest_content">
                                    <?php for($start = 1;$start <= 5;$start++){ ?>
                                    <?php if(isset($arrItemNews[$start]['post_id'])){ ?>
                                    <div class="main_category_right_viewest_content_post">
                                        <div class="main_category_right_viewest_content_images">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[$start]['post_title'])?>/c<?=$arrItemNews[$start]['pcat_id']?>p<?=$arrItemNews[$start]['post_id']?>.html">
                                                <img src="<?=$var_path_post_medium?><?=$arrItemNews[$start]['post_picture']?>">
                                            </a>
                                        </div>
                                        <div class="main_category_right_viewest_content_title">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[$start]['post_title'])?>/c<?=$arrItemNews[$start]['pcat_id']?>p<?=$arrItemNews[$start]['post_id']?>.html">
                                                <?=$arrItemNews[$start]['post_title']?>
                                            </a>
                                        </div>
                                        <!--<div class="main_category_right_viewest_content_sapo">
                                            <?//=removeHTML($arrItemNews[$start]['post_description'])?>
                                        </div>-->
                                    </div>
                                    <?php } } ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="list-courses-main-sidebar">
                    <?php include_once('../includes/inc_sidebar_news.php');?>
                    <?php include_once('../includes/inc_sidebar_faq.php');?>
                </div>
            </div>
        </div>
    </div>
</div>