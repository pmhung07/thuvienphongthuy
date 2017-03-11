<link rel="stylesheet" type="text/css" href="<?=$var_path_css?>jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="<?=$var_path_js?>jquery.ui.js"></script>
<script type="text/javascript" src="<?=$var_path_js?>jquery.editinplace.js"></script>
<script type="text/javascript" src="<?=$var_path_js?>jquery.ui.core.js"></script>
<script type="text/javascript" src="<?=$var_path_js?>jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?=$var_path_js?>jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?=$var_path_js?>jquery.ui.draggable.js"></script>
<script type="text/javascript" src="<?=$var_path_js?>jquery.ui.droppable.js"></script>

<?php

$iCategory          =   getValue('iCategory','int','GET',0);
$Skill              =   getValue('iSkill','int','GET',0);

//GET INFO CATEGORY
$dbCategory         =   new db_query('SELECT * FROM categories_multi WHERE cat_id ='.$iCategory);
$arrInfoCategory    =   $dbCategory->resultArray();

// GET COMMUNITY BY CAT_ID
$dbSkill            =   new db_query('SELECT *
                                        FROM skill_lesson 
                                       WHERE skl_les_id = '.$Skill.'  AND skl_les_active = 1');
$arrSkill           =   $dbSkill->resultArray();
unset($dbSkill);

//FREE RAM
unset($dbCategory);
unset($dbSkill);
?>
<div class="list-courses">
    <div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-title">
                    <div class="list-courses-filter-title-main">
                        <span><?=$arrInfoCategory[0]['cat_name']?></span>
                    </div>
                    <span class="list-courses-filter-title-breadcrumb">
                        <?=breadcrumb_cate_page($iCategory);?>
                        </br>
                        <a><?=$arrSkill[0]['skl_les_name']?></a>
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
                    <?=removeHTML($arrSkill[0]['skl_les_desc'])?>
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

                    <div class="list-skill-main-content-show skill-content-show">
                        <?
                        switch($arrSkill[0]['skl_les_type']){
                            case 1:
                                include_once('inc_list_skills_listen_read.php');
                                break;
                            case 2:
                                include_once('inc_list_skills_speaking.php');
                                break;
                            case 3:
                            case 4:
                                include_once('inc_list_skills_writing.php');
                                break;
                            case 5:
                                include_once('inc_list_skills_pron.php');
                                break;      
                        }
                        ?>
                    </div>
                    <div class="fb-wrap-comment">
                        <div class="fb-comments" data-href="http://tienganh2020.com" data-numposts="10" data-colorscheme="light"></div>
                    </div>
                </div>
                <div class="list-courses-main-sidebar">
                    <?php include_once('../includes/inc_sidebar_skills.php');?>
                </div>
            </div>
        </div>
    </div>
</div>