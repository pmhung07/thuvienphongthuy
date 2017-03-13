<?php
$arrCategory        = array();
$arrSkill           = array();
$arrItemSkill       = array();

$iCategory          = getValue('iCategory','int','GET',0);

if($iCategory != 0){

    $menu               = new menu();
    $listAll            = $menu->getAllChild('categories_multi','cat_id','cat_parent_id',$iCategory,' cat_type = 0 AND cat_active = 1','cat_id','cat_order ASC,cat_order ASC, cat_name ASC','cat_has_child');
    $countCateChild     = count($listAll);
    //GET INFO CATEGORY
    $dbCategory         =   new db_query('SELECT * FROM categories_multi WHERE cat_id ='.$iCategory);
    $arrInfoCategory    =   $dbCategory->resultArray();


    // SAVE ARR CATEGORY
    if($countCateChild != 0){
        foreach($listAll as $value){
            $arrCategory[] = $value['cat_id'];
        }
    }else{
        $arrCategory[] = $iCategory;
    }

    // GET Skill BY CAT_ID
    $countSkill = 0;
    foreach($arrCategory as $value){
        $dbCourses     =   new db_query("SELECT skl_les_id,
                                                skl_les_name,
                                                skl_les_img,
                                                cat_id,
                                                cat_name
                                           FROM skill_lesson a,
                                                categories_multi b
                                          WHERE a.skl_les_cat_id = b.cat_id
                                            AND skl_les_cat_id = ".$value." AND skl_les_active = 1 ORDER BY skl_les_order");
        $arrCoursesChild    =   $dbCourses->resultArray();
        $countSkill         +=   count($arrCoursesChild);
        unset($dbCourses);
        array_push($arrSkill, $arrCoursesChild);
    }

    // LIST ITEM
    $countItemSkill = 1;
    for($i = 0;$i < count($arrSkill);$i++){
        for($j = 0;$j < count($arrSkill[$i]);$j++){

            // COUNT LESSON SKILL
            $dbLessonCount = new db_query('SELECT COUNT(skl_cont_id)
                                               AS count_lesson
                                             FROM skill_content
                                            WHERE skl_cont_les_id = '.$arrSkill[$i][$j]['skl_les_id']);
            $row_count = mysqli_fetch_assoc($dbLessonCount->result);

            $arrItemSkill[$countItemSkill] = array(
                'skl_les_id'        => $arrSkill[$i][$j]['skl_les_id'],
                'skl_les_name'      => $arrSkill[$i][$j]['skl_les_name'],
                'skl_les_img'       => $arrSkill[$i][$j]['skl_les_img'],
                'cat_id'            => $arrSkill[$i][$j]['cat_id'],
                'cat_name'          => $arrSkill[$i][$j]['cat_name'],
                'count_lesson'      => $row_count['count_lesson']
            );
            $countItemSkill++; }
            unset($dbLessonCount);
    }

}else{

    $arrInfoCategory                            =   array();
    $arrInfoCategory[0]['pcat_name']            =   'LUYỆN THI';
    $arrInfoCategory[0]['pcat_description']     =   'Luyện kỹ năng, nghe, nói, đọc, viêt..hàng ngàn bài thi phong phú';
    redirect('http://'.$base_url.'');

}

/* PAGING */
$num_new_list = 9;
$total = $countSkill;
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
						<h1><span><?=$arrInfoCategory[0]['cat_name']?></span></h1>
					</div>
					<span class="list-courses-filter-title-breadcrumb">
                        <?=breadcrumb_cate_page($iCategory);?>
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
					<div class="list-courses-main-content-show">
                        <?php
                            $start  = 1;
                            $end    = 9;
                        ?>
                        <?php $countItemSkill = 1; ?>
                        <?php for($start = 1;$start <= $end;$start++){ ?>
                            <?php if(isset($arrItemSkill[$start]['skl_les_id'])){ ?>
                                <!---->
        						<div class="content-show-courses">
                                    <div class="content-show-courses-img">
                                        <a href="<?=generate_skill_details_link($arrItemSkill[$start]['cat_id'],$arrItemSkill[$start]['cat_name'],$arrItemSkill[$start]['skl_les_id'],$arrItemSkill[$start]['skl_les_name'])?>">
                                            <img src="<?=$var_path_skill_medium.$arrItemSkill[$start]['skl_les_img']?>" alt="<?=$arrItemSkill[$start]['skl_les_img']?>">
                                        </a>
                                    </div>
                                    <div class="content-show-courses-info">
                                        <!--<div class="content-show-courses-info-price">
                                            <span>200.000 VNĐ</span>
                                        </div>-->
                                        <div class="content-show-courses-info-title">
                                            <a href="<?=generate_skill_details_link($arrItemSkill[$start]['cat_id'],$arrItemSkill[$start]['cat_name'],$arrItemSkill[$start]['skl_les_id'],$arrItemSkill[$start]['skl_les_name'])?>">
                                                <span><?=truncateString_($arrItemSkill[$start]['skl_les_name'],20)?></span>
                                            </a>
                                        </div>
                                        <div class="content-show-courses-info-details">
                                            <span><?=$arrItemSkill[$start]['skl_les_name']?> | <b><?=$arrItemSkill[$start]['count_lesson']?> Lessons</b></span>
                                        </div>
                                    </div>
        						</div>
                            <?php } ?>
                        <?php $countItemSkill++; } ?>

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
                                    url:'http://<?=$base_url?>/ajax/paging_skill.php',
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
					<?php include_once('../includes/inc_sidebar_skills.php');?>
                    <?php include_once('../includes/inc_sidebar_faq.php');?>
				</div>
			</div>
		</div>
	</div>
</div>