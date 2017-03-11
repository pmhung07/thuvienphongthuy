<?php
/* PAGING */
$count_news = 0;
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

$iCategory = getValue("iCategory","int","GET",0);    

if($iCategory == 0){
    $dbSelect = new db_query('SELECT * FROM posts LIMIT 4');
    $arrNews = $dbSelect->resultArray();

    $dbSelectList = new db_query('SELECT * FROM posts LIMIT 4,3');
    $arrNewsList = $dbSelectList->resultArray();

    $dbSelectRandom = new db_query('SELECT * FROM posts ORDER BY RAND() LIMIT 5');
    $arrNewsRandom = $dbSelectRandom->resultArray();
}else{
    $dbSelect = new db_query('SELECT * FROM posts WHERE post_cat_id = '.$iCategory.' LIMIT 4');
    $arrNews = $dbSelect->resultArray();

    $dbSelectList = new db_query('SELECT * FROM posts WHERE post_cat_id = '.$iCategory.' LIMIT 4,4');
    $arrNewsList = $dbSelectList->resultArray();

    $dbSelectRandom = new db_query('SELECT * FROM posts WHERE post_cat_id = '.$iCategory.' ORDER BY RAND() LIMIT 5');
    $arrNewsRandom = $dbSelectRandom->resultArray();
}
?>
<div class="list-courses" style="margin-top:20px;">
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="list-courses-main-content-show-news community-content-show-news">  
                        <div class="main_category_left">
                            <div class="main_category_left_content_top">
                                <?php if(isset($arrNews[0]['post_id'])){ ?>
                                <div class="main_category_left_content_top_images">
                                    <a href="<?=gen_news_list_details($arrNews[0]['post_title'],$iCategory,$arrNews[0]['post_id'])?>">
                                        <?php if($arrNews[0]['post_picture'] != ""){ ?>
                                            <img src="<?=$var_path_news.$arrNews[0]['post_picture']?>">
                                        <?php }else{ ?>
                                            <img src="http://thuvienphongthuy.vn/themes/img/no-image.png">
                                        <?php } ?>
                                    </a>
                                </div>
                                <div class="main_category_left_content_top_details">
                                    <div class="main_category_left_content_top_title">
                                        <a href="<?=gen_news_list_details($arrNews[0]['post_title'],$iCategory,$arrNews[0]['post_id'])?>">
                                            <?=$arrNews[0]['post_title']?>
                                        </a>
                                    </div>
                                    <div class="main_category_left_content_top_sapo">
                                        <?=removeHTML($arrNews[0]['post_description'])?>
                                    </div>
                                </div>
                                <?}?>
                            </div>
                            <div class="main_category_left_content_bot">
                                <ul>
                                    <?php for($i=1;$i<=3;$i++){ ?>
                                    <?php if(isset($arrNews[$i]['post_id'])){ ?>
                                    <li>
                                        <div class="main_category_left_content_bot_img">
                                            <a href="<?=gen_news_list_details($arrNews[$i]['post_title'],$iCategory,$arrNews[$i]['post_id'])?>">
                                                <?php if($arrNews[$i]['post_picture'] != ""){ ?>
                                                    <img src="<?=$var_path_news.$arrNews[$i]['post_picture']?>">
                                                <?php }else{ ?>
                                                    <img src="http://thuvienphongthuy.vn/themes/img/no-image.png">
                                                <?php } ?>
                                            </a>
                                        </div>
                                         <div class="main_category_left_content_bot_title">
                                            <a href="<?=gen_news_list_details($arrNews[$i]['post_title'],$iCategory,$arrNews[$i]['post_id'])?>">
                                                <?=$arrNews[$i]['post_title']?>
                                            </a>
                                        </div>
                                    </li>
                                    <?php }} ?>
                                </ul>
                            </div>     

                            <div class="main_category_newest_title">
                                Mới nhất
                            </div>
                            <div class="community-content-show">
                                <?php 
                                    $start  = 1;
                                    $end    = 2;
                                ?>
                                <?php $countItemNews = 1; ?>

                                    <?php 
                                    for($i = 0; $i < 3;$i++){ 
                                        if(isset($arrNewsList[$i]['post_id'])){
                                        ?>
                                        <div class="content-show-news">
                                            <div class="news_show_img">
                                                <?php if($arrNewsList[$i]['post_picture'] != ""){ ?>
                                                    <img src="<?=$var_path_news.$arrNewsList[$i]['post_picture']?>">
                                                <?php }else{ ?>
                                                    <img src="http://thuvienphongthuy.vn/themes/img/no-image.png">
                                                <?php } ?>
                                            </div>
                                            <div class="content-show-courses-info news-show-info">
                                                <div class="content-show-courses-info-price news-show-price">
                                                    <a href="<?=gen_news_list_details($arrNewsList[$i]['post_title'],$iCategory,$arrNewsList[$i]['post_id'])?>">
                                                        <span><?=$arrNewsList[$i]['post_title']?></span>
                                                    </a>
                                                </div>
                                                <div class="content-show-courses-info-price news-show-des">
                                                    <span><?=removeHTML($arrNewsList[$i]['post_description'])?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }} ?>

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
                                    <?php
                                    for($i = 0; $i < 4;$i++){ 
                                        if(isset($arrNewsRandom[$i]['post_id'])){
                                        ?>
                                    <div class="main_category_right_viewest_content_post">
                                        <div class="main_category_right_viewest_content_images">
                                            <a href="<?=gen_news_list_details($arrNewsRandom[$i]['post_title'],$iCategory,$arrNewsRandom[$i]['post_id'])?>">
                                                <?php if($arrNewsRandom[$i]['post_picture'] != ""){ ?>
                                                    <img src="<?=$var_path_course.$value['cou_avatar']?>">
                                                <?php }else{ ?>
                                                    <img src="http://thuvienphongthuy.vn/themes/img/no-image.png">
                                                <?php } ?>
                                            </a>
                                        </div>
                                        <div class="main_category_right_viewest_content_title">
                                            <a href="<?=gen_news_list_details($arrNewsRandom[$i]['post_title'],$iCategory,$arrNewsRandom[$i]['post_id'])?>">
                                                <span><?=$arrNewsRandom[$i]['post_title']?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <?php }} ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="list-courses-main-sidebar">

                    <?php
                    $iCategory = getValue('iCategory','int','GET',0);
                    $db_select = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = 0 AND cat_active = 1 AND cat_type = 3');
                    $arr_cat_parent = $db_select->resultArray();
                    $sb_sql = "";
                    ?>
                    <div class="menu-category">
                        <div class="menu-category-titlte">
                            <span>DANH MỤC TIN TỨC</span>
                        </div>
                        <div class="menu-category-content">
                            <ul>
                                <?php foreach($arr_cat_parent as $key => $value){ ?>
                                <li>
                                    <a href="<?=gen_news_list($value['cat_id'],$value['cat_name'])?>">
                                        <?=$value['cat_name']?>
                                    </a>
                                    <?php
                                    $db_select_child = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$value['cat_id'].' AND cat_active = 1 AND cat_type = 3');
                                    $arr_cat_child = $db_select_child->resultArray();
                                    $countarrchild = count($arr_cat_child);
                                    if($countarrchild != 0){
                                    ?>
                                        <ul>
                                        <?php foreach($arr_cat_child as $keychild => $valuechild){ ?>
                                            <li>
                                                <a href="<?=gen_news_list($valuechild['cat_id'],$valuechild['cat_name'])?>"><?=$valuechild['cat_name']?></a>
                                            </li>
                                        <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <?//php include_once('../includes/inc_sidebar_news.php');?>
                    <?//php include_once('../includes/inc_sidebar_faq.php');?>
                    <?php
                    $bg_slide = get_banner(2);
                    foreach($bg_slide as $key=>$value){
                    ?>
                    <div class="ad-sidebar">
                        <a href="<?=$value['slide_url']?>">
                            <?php if($value['slide_img'] != ""){ ?>
                                <img src="<?=$var_path_course.$value['cou_avatar']?>">
                            <?php }else{ ?>
                                <img src="http://thuvienphongthuy.vn/themes/img/no-image.png">
                            <?php } ?>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>