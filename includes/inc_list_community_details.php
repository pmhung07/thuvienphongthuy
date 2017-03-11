<?php
$iCategory          = getValue('iCategory','int','GET',0);
$iCommunity               = getValue('iCommunity','int','GET',0);

//GET INFO CATEGORY
$dbCategory         =   new db_query('SELECT * FROM categories_multi WHERE cat_id ='.$iCategory);
$arrInfoCategory    =   $dbCategory->resultArray();

// GET COMMUNITY BY CAT_ID
$dbCommunity        =   new db_query('SELECT *
                                        FROM post_community 
                                       WHERE postcom_id = '.$iCommunity);
$arrCommunity       =   $dbCommunity->resultArray();
unset($dbCommunity);

//FREE RAM
unset($dbCategory);
unset($dbCommunity);
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
                        <?=breadcrumb_cate_page($iCategory);?>
                        </br>
                        <a><?=$arrCommunity[0]['postcom_title']?></a>
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
                        <?php foreach($arrCommunity as $key => $value){ ?>
                            <!---->
                            <div class="content-show-news-details">
                                <div class="content-show-courses-info news-show-info-details">
                                    <div class="content-show-courses-info-price news-show-price">
                                        <span><?=$value['postcom_title']?></span>
                                    </div>
                                    <div class="content-show-courses-info-price news-show-des">
                                        <span><?//=$value['post_description']?></span>
                                    </div>
                                    <div class="content-show-courses-info-details news-info-details">
                                        <span class="comunity-info-date"><?=date("d/m/Y",$value['postcom_time'])?></span>
                                    </div>
                                    <div class="news-show-content">
                                        <?=$value['postcom_content']?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="fb-wrap-comment">
                            <div class="fb-comments" data-href="http://tienganh2020.com" data-numposts="10" data-colorscheme="light"></div>
                        </div>
                    </div>
                </div>
                <div class="list-courses-main-sidebar">
                    <?php include_once('../includes/inc_sidebar_community.php');?>
                </div>
            </div>
        </div>
    </div>
</div>