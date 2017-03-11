<?php
$iCategory          = getValue('iCategory','int','GET',0);
$iNew               = getValue('iNew','int','GET',0);

//GET INFO CATEGORY
$dbCategory         =   new db_query("SELECT * FROM post_category WHERE pcat_id =".$iCategory);
$arrInfoCategory    =   $dbCategory->resultArray();

// GET COMMUNITY BY CAT_ID
$dbNews         =   new db_query("SELECT *
                                   FROM posts 
                                  WHERE post_id = ".$iNew);
$arrNews        =   $dbNews->resultArray();
unset($dbNews);

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
                        <h1><span><?=$arrInfoCategory[0]['pcat_name']?></span></h1>
                    </div>
                    <span class="list-courses-filter-title-breadcrumb">
                        <?=breadcrumb_cate_news_page($iCategory);?>
                        </br>
                        <a><?=$arrNews[0]['post_title']?></a>
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
                    <?=removeHTML($arrInfoCategory[0]['pcat_description'])?>
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
                        <?php foreach($arrNews as $key => $value){ ?>
                            <!---->
                            <div class="content-show-news-details">
                                <div class="content-show-courses-info news-show-info-details">
                                    <div class="content-show-courses-info-price news-show-title-details">
                                        <span><?=$value['post_title']?></span>
                                    </div>
                                    <div class="content-show-courses-info-price news-show-des-details">
                                        <span><?=$value['post_description']?></span>
                                    </div>
                                    <div class="content-show-courses-info-details news-info-details">
                                        <span class="comunity-info-date"><?=date("d/m/Y",$value['post_time'])?></span>
                                    </div>
                                    <div class="news-show-content">
                                        <?=$value['post_content']?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="fb-wrap-comment">
                        <div class="fb-comments" data-href="http://tienganh2020.com" data-numposts="10" data-colorscheme="light"></div>
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