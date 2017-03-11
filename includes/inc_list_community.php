<?php
$arrCategory        = array();
$arrCommunity       = array();
$arrItemNews        = array();
$arrNews            = array();

$iCategory          = getValue('iCategory','int','GET',0);

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
            $arrCategory[] = $value['cat_id'];
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
    $arrInfoCategory                           =   array();
    $arrInfoCategory[0]['cat_name']            =   'CỘNG ĐỒNG TIẾNG ANH';
    $arrInfoCategory[0]['cat_description']     =   'Thư viện cộng đồng tiếng anh, nơi chia sẻ những nội dung học và giải trí tiếng anh hay và hiệu quả nhất';

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


/* PAGING */
$num_new_list = 9;
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
    <div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-title">
                    <div class="wrap-search-google-module">
                        <div class="search-google-module">
                            <script>
                            (function() {
                            var cx = '014392461875755904911:x7kjjrisdw4';
                            var gcse = document.createElement('script');
                            gcse.type = 'text/javascript';
                            gcse.async = true;
                            gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                            '//www.google.com/cse/cse.js?cx=' + cx;
                            var s = document.getElementsByTagName('script')[0];
                            s.parentNode.insertBefore(gcse, s);
                            })();
                            </script>
                            <gcse:search></gcse:search>
                        </div>
                    </div>
                    <div class="list-courses-filter-title-main">
                        <span><?=$arrInfoCategory[0]['cat_name']?></span>
                    </div>
                    <span class="list-courses-filter-title-breadcrumb">
                        <?php
                        if($iCategory != 0){
                            breadcrumb_cate_page($iCategory);
                        }else{
                        ?>
                            <a>Trang chủ</a> 
                            <span></span>
                            <a>CỘNG ĐỒNG</a>
                        <?php } ?>
                    </span>
                </div>
                <div class="list-courses-filter-search">
                    <form method="get" id="courses-search" class="courses-search" action="http://<?=$base_url?>/home/search.php">
                        <input id="searchtext" class="searchtext-module" name="searchtext" type="text" value="" placeholder="Khóa học">
                        <input type="hidden" name="search-type" value="courses">
                        <input type="submit" class="search-searchtext-module" value="">
                    </form>
                </div>
                <div class="list-courses-filter-title-description">
                    <?=removeHTML($arrInfoCategory[0]['cat_description'])?>
                </div>
            </div>
        </div>
    </div>
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="list-courses-main-content-show community-content-show">
                        <?php 
                            $start  = 1;
                            $end    = 9;
                        ?>
                        <?php $countItemNews = 1; ?>
                        <?php for($start = 1;$start <= $end;$start++){ ?>
                            <?php if(isset($arrItemNews[$start]['postcom_id'])){ ?>
                                <!---->
                                <div class="content-show-community">
                                    <div class="content-show-courses-info community-show-info">
                                        <div class="content-show-courses-info-price community-show-price">
                                            <a href="http://<?=$base_url?>/cong-dong/<?=$arrItemNews[$start]['cat_id']?>/<?=removeTitle($arrItemNews[$start]['cat_name'])?>/<?=$arrItemNews[$start]['postcom_id']?>/<?=removeTitle($arrItemNews[$start]['postcom_title'])?>.html">
                                                <span class="community-title"><?=$countItemNews . ' . ' . truncateString_($arrItemNews[$start]['postcom_title'],80)?></span>
                                            </a>
                                        </div>
                                        <div class="content-show-courses-info-details community-info-details">
                                            <span class="comunity-info-admin"><?=$arrItemNews[$start]['cat_name']?></span>
                                            <span class="comunity-info-view"><?=$arrItemNews[$start]['postcom_view']?></span>
                                            <span class="comunity-info-date"><?=date("d/m/Y",$arrItemNews[$start]['postcom_time'])?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php $countItemNews++; } ?>

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
                                    url:'http://<?=$base_url?>/ajax/paging_community.php',
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
                </div>
                <div class="list-courses-main-sidebar">
                    <?php include_once('../includes/inc_sidebar_community.php');?>
                </div>
            </div>
        </div>
    </div>
</div>