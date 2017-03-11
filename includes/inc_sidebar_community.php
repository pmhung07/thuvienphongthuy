<?php
	$iCategory 			= getValue('iCategory','int','GET',83);
	$menu 				= new menu();
	$listAll 			= $menu->getAllChild('categories_multi','cat_id','cat_parent_id',0,' cat_type = 2 AND cat_active = 1','cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child,cat_picture,cat_active,admin_id','cat_order ASC,cat_order ASC, cat_name ASC','cat_has_child');
?>
<div class="menu-category">
	<div class="menu-category-titlte">
		<span>DANH MỤC CỘNG ĐỒNG</span>
	</div>
	<div class="menu-category-content">
		<ul>
			<?php
			$i = 1;
			foreach($listAll as $key=>$row){ 
			?>
				<?php if($row['cat_parent_id'] == 0){?>
					<li class="<?=($i==13)?'item-menu-last':'';?>">
						<?php $currentParentId = $row['cat_id'];?>
						<a class="item-parent-menu-courses <?=($row['cat_id']==$iCategory)?'item-menu-active':'';?>" href="http://<?=$base_url?>/cong-dong/<?=$row['cat_id']?>/<?=removeTitle($row['cat_name'])?>.html">
							<?=$row['cat_name']?>
						</a>
						<ul class="sub-menu-category">
							<?php foreach($listAll as $key=>$row){ ?>
								<?php if($row['cat_parent_id'] == $currentParentId){?>
									<li class="sub_menu_courses">
										<a class="<?=($row['cat_id']==$iCategory)?'item-menu-child-active':'';?>" href="http://<?=$base_url?>/cong-dong/<?=$row['cat_id']?>/<?=removeTitle($row['cat_name'])?>.html"><?=$row['cat_name']?></a>
									</li>
								<?php } ?>
							<?php } ?>
						</ul>
					</li>
				<?php $i++;} ?>
			<?php } ?>
		</ul>
	</div>
</div>