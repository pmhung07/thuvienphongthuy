<?php

$arrCategory        = array();
$arrCourses         = array();
$arrItemCourses     = array();

$iCategory          = getValue('iCategory','int','GET',0);

if($iCategory != 0){

    $menu               = new menu();
    $listAll            = $menu->getAllChild('categories_multi','cat_id','cat_parent_id',$iCategory,' cat_type = 1 AND cat_active = 1','cat_id','cat_order ASC,cat_order ASC, cat_name ASC','cat_has_child');
    $countCateChild     = count($listAll);

    //GET INFO CATEGORY
    $dbCategory         =   new db_query("SELECT * FROM categories_multi WHERE cat_id =".$iCategory);
    $arrInfoCategory    =   $dbCategory->resultArray();

    // SAVE ARR CATEGORY
    if($countCateChild != 0){
        foreach($listAll as $value){
            $arrCategory[] = $value['cat_id'];
        }
    }else{
        $arrCategory[] = $iCategory;
    }

    // GET ARRAY CAT TOEIC,TOEFL,IELTS
    // 9 - TOEFL ; 76,161,165,170 - TOEIC ; 35 IELTS
    $arrCateTest    = array(9,76,161,165,170,35);

    // GET COURSES BY CAT_ID
    $countCourses = 0;
    foreach($arrCategory as $value){
        if(!in_array($iCategory, $arrCateTest)){
            $dbCourses     =   new db_query('SELECT cou_id,
                                                    cou_name,
                                                    cou_avatar,
                                                    cat_id,
                                                    cat_name
                                               FROM courses a,
                                                    categories_multi b 
                                              WHERE a.cou_cat_id = b.cat_id 
                                                AND cou_cat_id = '.$value.' 
                                                AND cou_active = 1 ORDER BY cou_order');
            $arrCoursesChild    =   $dbCourses->resultArray();
            $countCourses       +=  count($arrCoursesChild);
            unset($dbCourses);
            array_push($arrCourses, $arrCoursesChild);
        }else{
            if($iCategory == 9){
                $table          = 'test';
                $idTable        = 'test_id';
                $nameTable      = 'test_name';
                $imgTable       = 'test_image';
                $catTable       = 'test_cat_id';
                $activeTable    = 'test_active';
                $urlTest        = 'http://'.$base_url.'/toefl/direction_first.php?test_id=';
            }elseif($iCategory == 76 || $iCategory == 161 || $iCategory == 165 || $iCategory == 170){
                $table          = 'toeic';
                $idTable        = 'toeic_id';
                $nameTable      = 'toeic_name';
                $imgTable       = 'toeic_image';
                $catTable       = 'toeic_cat_id';
                $activeTable    = 'toeic_active';
                $urlTest        = 'http://'.$base_url.'/toeic/toeic_listening.php?test_id=';
            }elseif($iCategory == 35){
                $table          = 'ielts';
                $idTable        = 'ielt_id';
                $nameTable      = 'ielt_name';
                $imgTable       = 'ielt_image';
                $catTable       = 'ielt_cat_id';
                $activeTable    = 'ielt_active';
                $urlTest        = 'http://'.$base_url.'/ielts/direction_first.php?test_id=';
            }

            $dbCourses     =   new db_query('SELECT '.$idTable.',
                                                    '.$nameTable.',
                                                    '.$imgTable.',
                                                      cat_id,
                                                      cat_name
                                               FROM '.$table.' a,
                                                      categories_multi b 
                                              WHERE   a.'.$catTable.' = b.cat_id  
                                                AND '.$activeTable.' = 1');
            $arrCoursesChild    =   $dbCourses->resultArray();
            $countCourses       +=  count($arrCoursesChild);
            unset($dbCourses);
            array_push($arrCourses, $arrCoursesChild);

        }
    }

    // LIST ITEM
    $countItemCount = 1; 
    for($i = 0;$i < count($arrCourses);$i++){
        for($j = 0;$j < count($arrCourses[$i]);$j++){ 
            if(!in_array($iCategory, $arrCateTest)){
                // COUNT LESSON SKILL
                $dbLessonCount = new db_query('SELECT COUNT(com_id) 
                                                   AS count_lesson 
                                                 FROM courses_multi 
                                                WHERE com_cou_id = '.$arrCourses[$i][$j]['cou_id']);
                $row_count = mysql_fetch_assoc($dbLessonCount->result);

                $arrItemCourses[$countItemCount] = array(
                    'cou_id'        => $arrCourses[$i][$j]['cou_id'],
                    'cou_name'      => $arrCourses[$i][$j]['cou_name'],
                    'cou_image'     => $arrCourses[$i][$j]['cou_avatar'],
                    'cat_id'        => $arrCourses[$i][$j]['cat_id'],
                    'cat_name'      => $arrCourses[$i][$j]['cat_name'],
                    'count_lesson'  => $row_count['count_lesson'] 
                ); 
            }else{
                $arrItemCourses[$countItemCount] = array(
                    'cou_id'        => $arrCourses[$i][$j][$idTable],
                    'cou_name'      => $arrCourses[$i][$j][$nameTable],
                    'cou_image'     => $arrCourses[$i][$j][$imgTable],
                    'cat_id'        => $arrCourses[$i][$j]['cat_id'],
                    'cat_name'      => $arrCourses[$i][$j]['cat_name'],
                ); 
            }

        $countItemCount++; } 
        unset($dbLessonCount);
        //dump($arrItemCourses);exit();
    }

}else{

    $arrInfoCategory                            =   array();
    $arrInfoCategory[0]['pcat_name']            =   'KHÓA HỌC';
    $arrInfoCategory[0]['pcat_description']     =   'Tiếng anh giao tiếp, Tiếng Anh Phổ thông, Tiếng anh văn phòng, Tiếng anh kinh doanh, Tiếng anh trẻ em..';
    redirect('http://'.$base_url.'');

}

/* PAGING */
$num_new_list = 9;
$total = $countCourses;
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
unset($dbCourses);
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
						<span><h1><?=$arrInfoCategory[0]['cat_name']?></h1></span>
					</div>
					<span class="list-courses-filter-title-breadcrumb">
                        <?=breadcrumb_cate_page($iCategory);?>
					</span>
				</div>
				<div class="list-courses-filter-search">
					<form method="get" id="courses-search" class="courses-search" action="http://<?=$base_url?>/home/search.php">
                        <input type="submit" class="search-searchtext-module" value="">
                        <input id="searchtext" class="searchtext-module" name="searchtext" type="text" value="" placeholder="Khóa học">
                        <input type="hidden" name="search-type" value="courses">
                    </form>
				</div>
                <div class="list-courses-filter-title-description">
                    <h2><?=removeHTML($arrInfoCategory[0]['cat_description'])?></h2>
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
                            $start  = 1;
                            if(!in_array($iCategory, $arrCateTest)){   
                                $end    = 9;
                            }else{
                                $end    = 20;
                            }
                        ?>

                        <?//dump($arrItemCourses);exit();?>

                        <?php $countItemCourse = 1; ?>
                        <?php for($start = 1;$start <= $end;$start++){ ?>
                            <?php if(isset($arrItemCourses[$start]['cou_id'])){ ?>

                                <?php

                                if(!in_array($iCategory, $arrCateTest)){   
                                    $url    = gen_course_details($arrItemCourses[$start]['cou_id'],0);
                                    $name   = truncateString_($arrItemCourses[$start]['cou_name'],20);
                                }else{
                                    //$url    = $urlTest.$arrItemCourses[$start]['cou_id'];
                                    $url    = "#";
                                    $name   = truncateString_($arrItemCourses[$start]['cou_name'],20);
                                }

                                ?>
                                <!---->
        						<div class="content-show-courses">
                                    <div class="content-show-courses-img">
                                        <a href="<?=gen_course($arrItemCourses[$start]['cou_id'],$arrItemCourses[$start]['cou_name'])?>">
                                            <img src="<?=$var_path_course_medium.$arrItemCourses[$start]['cou_image']?>" alt="<?=$name?>">
                                        </a>
                                    </div>
                                    <div class="content-show-courses-info">
                                        <a href="<?=gen_course($arrItemCourses[$start]['cou_id'],$arrItemCourses[$start]['cou_name'])?>">
                                            <div class="content-show-courses-info-title">
                                                <span><?=$name?></span>
                                            </div>
                                        </a>
                                        <div class="content-show-courses-info-details">
                                            <span><?=$name?> | <?=(!in_array($iCategory, $arrCateTest))?$arrItemCourses[$start]['count_lesson']:'0'?> Lessons</span>
                                        </div>
                                    </div>
        						</div>
                            <?php } ?>
                        <?php $countItemCourse++; } ?>

                        <?php /*PAGING*/ ?>
                        <div class="paging" style="<?=(in_array($iCategory, $arrCateTest))?'display:none;':'';?>">
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
                                    url:'http://<?=$base_url?>/ajax/paging_courses.php',
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
					<?php include_once('../includes/inc_sidebar_courses.php');?>
                    <?php include_once('../includes/inc_sidebar_faq.php');?>
				</div>
			</div>
		</div>
	</div>
</div>