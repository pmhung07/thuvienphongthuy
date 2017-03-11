<?php
$iCategory = getValue('iCategory','int','GET',0);
$db_select = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = 0 AND cat_active = 1 AND cat_type = 2');
$arr_cat_parent = $db_select->resultArray();
$sb_sql = "";
?>
<div class="menu-category">
	<div class="menu-category-titlte">
		<span>DANH MỤC Cover Letters</span>
	</div>
	<div class="menu-category-content">
		<ul>
			<?php foreach($arr_cat_parent as $key => $value){ ?>
			<li>
				<a href="<?=gen_cv_list($value['cat_id'],$value['cat_name'])?>">
					<?=$value['cat_name']?>
				</a>
				<?php
				$db_select_child = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$value['cat_id'].' AND cat_active = 1 AND cat_type = 2');
				$arr_cat_child = $db_select_child->resultArray();
				$countarrchild = count($arr_cat_child);
				if($countarrchild != 0){
				?>
					<ul>
					<?php foreach($arr_cat_child as $keychild => $valuechild){ ?>
							<li>
								<a href="<?=gen_cv_list($valuechild['cat_id'],$valuechild['cat_name'])?>"><?=$valuechild['cat_name']?></a>
							</li>
					<?php } ?>
					</ul>
				<?php } ?>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>

<div class="list_related_courses">
	<div class="menu-category-titlte-related">
		<ul class="nav nav-tabs nav-sidebar">
			<li class="active li1"><a href="#tab1" data-toggle="tab">Tin tức</a></li>
			<li class="li2"><a href="#tab2" data-toggle="tab">Tài liệu khác</a></li>
		</ul>
	</div>
	<div class="content-show-course-sidebar">
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<?php
				if($iCategory == 0){
					$sb_sql .= ' 1';
				}else{
					$sb_sql .= ' post_cat_related_id = '.$iCategory;
				}
				$dbPost = new db_query("SELECT * FROM posts
                                              INNER JOIN categories_multi ON posts.post_cat_id=categories_multi.cat_id 
                                              WHERE ".$sb_sql." LIMIT 5");
    			$arrPost = $dbPost->resultArray();
    			foreach($arrPost as $key=>$value){
				?>
				<div class="wrap_related_courses">
			        <div class="news_show_img-course-sidebar">
			        	<a href="http://<?=$base_url?>/course-details.htm">
			            	<img src="<?=$var_path_post.$value['post_picture']?>">
			            </a>
			        </div>
			        <div class="content-show-courses-info-course-sidebar">
			            <div class="content-show-courses-info-price-course-sidebar news-show-price">
			                <a href="http://<?=$base_url?>/course-details.htm">
			                    <span><?=$value['post_title']?></span>
			                </a>
			            </div>
			            <div class="authorcourserelated">
			                <span><?=$value['cat_name']?></span>
			            </div>
			        </div>
		        </div>
		        <?php } ?>
			</div>
			<div class="tab-pane" id="tab2">
				<?php
				$dbCourses = new db_query("SELECT * FROM cover_letters 
											INNER JOIN categories_multi ON cover_letters.cv_cat_id=categories_multi.cat_id 
											ORDER BY RAND() LIMIT 5");
				$arrCourses = $dbCourses->resultArray();
				foreach($arrCourses as $key => $value){
				?>
				<div class="wrap_related_courses">
			        <div class="news_show_img-course-sidebar">
			        	<a href="http://<?=$base_url?>/course-details.htm">
			            	<img src="<?=$var_path_cv.$value['cv_avatar']?>">
			            </a>
			        </div>
			        <div class="content-show-courses-info-course-sidebar">
			            <div class="content-show-courses-info-price-course-sidebar news-show-price">
			                <a href="http://<?=$base_url?>/course-details.htm">
			                    <span><?=$value['cv_name']?></span>
			                </a>
			            </div>
			            <div class="authorcourserelated">
			                <span><?=$value['cat_name']?></span>
			            </div>
			        </div>
		        </div>
		        <?php } ?>
			</div>
		</div>
    </div>
</div>