<?php
$iCategory = getValue("iCategory","int","GET",0);    
$iNews = getValue("iNews","int","GET",0);

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

$dbSelectNews = new db_query('SELECT * FROM posts WHERE post_id = '.$iNews);
$arrNewsDetails = $dbSelectNews->resultArray();



?>
<div class="list-courses" style="margin-top: 20px;">

    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="content-main-news">
                        <h1><?=$arrNewsDetails[0]['post_title']?></h1>
                        <h2><?=removeHTML($arrNewsDetails[0]['post_description'])?></h2>
                        <span class="spdatenews"><?=date("d/m/Y",$arrNewsDetails[0]['post_time'])?></span>
                        <div class="content_main_details_news_str">
                            <?=$arrNewsDetails[0]['post_content']?>
                        </div>
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
                                                <img src="<?=$var_path_news.$arrNewsRandom[$i]['post_picture']?>">
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
                <div class="list-courses-main-sidebar" style="margin-top:0px!Important;">

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
                                <img src="http://<?=$base_url?>/pictures/slides/<?=$value['slide_img']?>"/>
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