<?php
$iCategory          = getValue('iCategory','int','GET',0);
$iLibrary           = getValue('iLibrary','int','GET',0);

//GET INFO CATEGORY
$dbCategory         =   new db_query('SELECT * FROM library_cate WHERE lib_cat_id ='.$iCategory);
$arrInfoCategory    =   $dbCategory->resultArray();
$libraryType        =   $arrInfoCategory[0]['lib_cat_type']; 

switch ($libraryType) {
    case 1:
        $tableLibrary   = 'library_game';
        $idLibrary      = 'lib_game_id';
        $titleLibrary   = 'lib_game_title';
        $infoLibrary    = 'lib_game_info';
        $urlLibrary     = 'lib_game_url';
        break;
    case 2:
        $tableLibrary   = 'library_story';
        $idLibrary      = 'lib_story_id';
        $titleLibrary   = 'lib_story_title';
        $enLibrary      = 'lib_story_en';
        $viLibrary      = 'lib_story_vi';
        $typeLibrary    = 'lib_story_type';
        $imgLibrary     = 'lib_story_image';
        $infoLibrary    = 'lib_story_title';
        break;
    case 3:
        $tableLibrary   = 'library_song';
        $idLibrary      = 'lib_song_id';
        $titleLibrary   = 'lib_song_title';
        $infoLibrary    = 'lib_song_info';
        $urlLibrary     = 'lib_song_url';
        $enLibrary      = 'lib_song_en';
        $viLibrary      = 'lib_song_vi';
        $imgLibrary     =  $var_path_img.'course15.jpg';
        break;
    case 4:
        $tableLibrary   = 'library_video';
        $idLibrary      = 'lib_video_id';
        $titleLibrary   = 'lib_video_title';
        $infoLibrary    = 'lib_video_info';
        $urlLibrary     = 'lib_video_url';
        $imgLibrary     =  $var_path_img.'/course15.jpg';
        break;
    default:
        # code...
        break;
}

$dbItemLibrary      =   new db_query('SELECT * FROM '.$tableLibrary.' WHERE '.$idLibrary.' ='.$iLibrary);
$arrItemLibrary     =   $dbItemLibrary->resultArray();

//FREE RAM
unset($dbCategory);
unset($dbItemLibrary);
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
                        <span><?=$arrItemLibrary[0][$titleLibrary]?></span>
                    </div>
                    <span class="list-courses-filter-title-breadcrumb">
                        <?=breadcrumb_cate_lib_page($iCategory);?>
                        <span></span>
                        <a><?=$arrItemLibrary[0][$titleLibrary]?></a>
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
                    <?=$arrItemLibrary[0][$infoLibrary]?>
                </div>
            </div>
        </div>
    </div>
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="social-tool">
                        <span class="fb-like-scl"><div class="fb-like" data-href="http://<?=$base_url.$_SERVER['REQUEST_URI']?>" data-width="450" data-layout="button_count" data-show-faces="false" data-send="false"></div></span>
                        <span class="fb-like-scl">
                            <div class="fb-share-button" data-href="http://<?=$base_url.$_SERVER['REQUEST_URI']?>" data-layout="button_count"></div>
                        </span>
                        <span class="google-like">
                            <script src="https://apis.google.com/js/platform.js" async defer></script>
                            <g:plusone></g:plusone>
                        </span>
                        <span class="google-share">
                            <div class="g-plus" data-action="share" data-annotation="none"></div>
                        </span>
                        <span class="twttr-like">
                            <a class="twitter-share-button" href="https://twitter.com/share"></a>
                            <script>
                            window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
                            </script>
                        </span>
                    </div>    
                    <div class="list-courses-main-content-show community-content-show">
                        <?
                        switch ($libraryType) {
                            case 1:
                                ?>
                                <div class="text-center">
                                    <object width="491" height="491">
                                        <embed src="<?=$var_path_library_game_file.$arrItemLibrary[0][$urlLibrary]?>" width="500" height="490" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed>
                                    </object>
                                </div>
                                <?
                                break;
                            case 2:
                                if($arrItemLibrary[0][$typeLibrary] == 1){
                                ?>
                                    <div class="lib-tool-translate">
                                        <span class="tool-translate-trans">Xem bản dịch</span>
                                    </div>
                                    <div class="lib-trans">
                                        <?=getMainCTran($arrItemLibrary[0][$enLibrary],$arrItemLibrary[0][$viLibrary])?>
                                    </div>       
                                <?php
                                }else{
                                    $dbImagesStory      =   new db_query('SELECT * FROM images_story WHERE img_story_id = '.$arrItemLibrary[0][$idLibrary].' ORDER BY img_order DESC');
                                    $arrItemImgStory    =   $dbImagesStory->resultArray();
                                ?>
                                    <ul class="lib-story-img-list">
                                        <li>
                                            <img src="http://<?=$base_url?>/themes/img/course15.jpg">
                                        </li>
                                        <?php foreach($arrItemImgStory as $key => $value){?>
                                        <li>
                                            <img src="http://<?=$base_url.$var_path_library_story_file.$value['img_url']?>">
                                        </li>
                                        <?php } ?>
                                    </ul>
                                <?php
                                }
                                break;
                            case 3:
                                ?>
                                <div class="text-center">
                                    <?=get_media_library_v2('http://'.$base_url.$var_path_library_song_file.$arrItemLibrary[0][$urlLibrary],'http://'.$base_url.$imgLibrary)?>              
                                    <div class="lib-tool-translate">
                                        <span class="tool-translate-trans">Xem bản dịch</span>
                                    </div>
                                    <div class="lib-trans">
                                        <?=getMainCTran($arrItemLibrary[0][$enLibrary],$arrItemLibrary[0][$viLibrary])?>
                                    </div>                                              
                                </div>
                                <?
                                break;
                            case 4:
                                ?>
                                <div class="text-center">
                                    <?=get_media_library_v2('http://'.$base_url.$var_path_library_video_file.$arrItemLibrary[0][$urlLibrary],'http://'.$base_url.$imgLibrary)?>
                                </div>
                                <?
                                break;
                            default:
                                break;
                        }
                        ?>
                    </div>
                    <div class="fb-wrap-comment">
                        <div class="fb-comments" data-href="http://tienganh2020.com" data-numposts="10" data-colorscheme="light"></div>
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