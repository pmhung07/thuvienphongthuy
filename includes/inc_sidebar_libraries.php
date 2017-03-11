<?php
	$iCategory 			= getValue('iCategory','int','GET',0);
	$menu 				= new menu();
	$arrLibraryItem 	= array();
	$arrayLibraryType 	= array(1 => "Game"
							   ,2 => "Truyện"
							   ,3 => "Bài hát"
							   ,4 => "Video");

	$dbCategory         	=   new db_query('SELECT * FROM library_cate WHERE lib_cat_id ='.$iCategory);
    $arrInfoCategory     	=   $dbCategory->resultArray();

	foreach($arrayLibraryType as $key => $value){
		$dbSelect 				= new db_query("SELECT * FROM library_cate WHERE lib_cat_parent_id = 0 AND lib_cat_active = 1 AND lib_cat_type =".$key);
		$arrLibraryItem[$key]  	= $dbSelect->resultArray();
		unset($dbSelect);
	}
?>
<div class="menu-category">
	<div class="menu-category-titlte">
		<span>DANH MỤC THƯ VIỆN</span>
	</div>
	<div class="menu-category-content">
		<ul>
			<?php
			$i = 1;
			foreach($arrLibraryItem as $key=>$row){ 
			?>
				<li class="<?=($i==4)?'item-menu-last':'';?>">
					<a class="item-parent-menu-courses lib-item-parent-menu-courses">
						<?=$arrayLibraryType[$key]?>
					</a>
					<ul class="sub-menu-category lib-sub-menu-category">
						<?php foreach($arrLibraryItem[$key] as $keyItem=>$rowItem){ ?>
							<?=($arrInfoCategory[0]['lib_cat_type'] == $rowItem['lib_cat_type'])?'<span class="sp_active_lib_child"></span>':'';?>
							<li class="sub_menu_courses">
								<a class="<?=($rowItem['lib_cat_id']==$iCategory)?'item-menu-child-active':'';?>" href="http://<?=$base_url?>/thu-vien/<?=$rowItem['lib_cat_id']?>/<?=removeTitle($rowItem['lib_cat_name'])?>.html"><?=$rowItem['lib_cat_name']?></a>
							</li>
						<?php } ?>
					</ul>
				</li>
				<?php $i++;	?>
			<?php } ?>
		</ul>
	</div>
</div>