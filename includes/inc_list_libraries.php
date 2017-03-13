<?php
$arrCategory            = array();
$arrInfoCategoryChild   = array();

$iCategory          = getValue('iCategory','int','GET',0);
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
$rowCount       = mysqli_fetch_assoc($dbItemLibCount->result);
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
                                                      a.'.$imgItem.',
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
                        <span><?=$arrInfoCategory[0]['lib_cat_name']?></span>
                    </div>
                    <span class="list-courses-filter-title-breadcrumb">
                        <?=breadcrumb_cate_lib_page($iCategory);?>
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
                    <?=removeHTML($arrInfoCategory[0]['lib_cat_description'])?>
                </div>
            </div>
        </div>
    </div>
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="list-courses-main-content-show">
                        <?php
                            // $countItemLib == 0 : Get Cate
                        ?>
                        <?php if($countItemLib == 0){ ?>
                            <?php foreach($arrInfoCategoryChild as $key => $value){ ?>
                                <div class="content-show-courses">
                                    <div class="content-show-courses-img">
                                        <a href="http://<?=$base_url?>/thu-vien/<?=$value['lib_cat_id']?>/<?=removeTitle($value['lib_cat_name'])?>.html">
                                            <img src="<?=$var_path_library_cate_medium.$value['lib_cat_picture']?>" alt="<?=$value['lib_cat_name']?>">
                                        </a>
                                    </div>
                                    <div class="content-show-courses-info">
                                        <div class="content-show-courses-info-price">
                                            <a href="http://<?=$base_url?>/thu-vien/<?=$value['lib_cat_id']?>/<?=removeTitle($value['lib_cat_name'])?>.html">
                                                <span></span>
                                            </a>
                                        </div>
                                        <div class="content-show-courses-info-details library-info-details">
                                            <span class="font-bold"><?=$value['lib_cat_name']?></span></br>
                                            <span><?=$value['lib_cat_description']?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php }else{ ?>

                            <?php
                            /* PAGING */
                            $num_new_list = 10;
                            $total = $countItemLib;
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
                            ?>

                            <!--GET CONTENT-->

                            <?php
                                $start  = 1;
                                $end    = 9;
                            ?>
                            <?php for($start = 1;$start <= $end;$start++){ ?>
                                <?php if(isset($arrLibItem[($start-1)][$idLibrary])){ ?>
                                    <div class="content-show-courses">
                                        <div class="content-show-courses-img">
                                            <a href="http://<?=$base_url?>/thu-vien/<?=$arrLibItem[($start-1)]['lib_cat_id']?>/<?=removeTitle($arrLibItem[($start-1)]['lib_cat_name'])?>/<?=$arrLibItem[($start-1)][$idLibrary]?>/<?=removeTitle($arrLibItem[($start-1)][$nameItem])?>.html">
                                                <img src="<?=$urlImgItem.$arrLibItem[($start-1)][$imgItem]?>" alt="<?=$arrLibItem[($start-1)][$imgItem]?>">
                                            </a>
                                        </div>
                                        <div class="content-show-courses-info">
                                            <div class="content-show-courses-info-price">
                                                <a href="http://<?=$base_url?>/thu-vien/<?=$arrLibItem[($start-1)]['lib_cat_id']?>/<?=removeTitle($arrLibItem[($start-1)]['lib_cat_name'])?>/<?=$arrLibItem[($start-1)][$idLibrary]?>/<?=removeTitle($arrLibItem[($start-1)][$nameItem])?>.html">
                                                    <span class="library-info-title"><?=truncateString_($arrLibItem[($start-1)][$nameItem],20)?></span>
                                                </a>
                                            </div>
                                            <div class="content-show-courses-info-details">
                                                <span class="font-bold"><?=$arrLibItem[($start-1)][$nameItem]?></span></br>
                                                <span><?=$arrLibItem[($start-1)]['lib_cat_name']?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                            <?php } ?>

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
                            </div> <!--END PAGING-->
                        <?php } ?>

                         <script type="text/javascript">
                           $(document).ready(function(){
                              $('.a_paging').click(function(){
                                 var page = $(this).attr('title');
                                 $.ajax({
                                    type:'POST',
                                    dataType:'json',
                                    url:'http://<?=$base_url?>/ajax/paging_library.php',
                                    data:{
                                        iCategory:<?=$iCategory?>,
                                        page:page,
                                        pageCount:<?=$pageCount?>,
                                    },
                                    success:function(data){
                                        $(".list-courses-main-content-show").fadeOut(0,function(){
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
                    <?php include_once('../includes/inc_sidebar_libraries.php');?>
                    <?php include_once('../includes/inc_sidebar_faq.php');?>
                </div>
            </div>
        </div>
    </div>
</div>