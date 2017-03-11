<?php
	$iCategory 			= getValue('iCategory','int','GET',9);
	$menu 				= new menu();
	$listAll 			= $menu->getAllChild('post_category','pcat_id','pcat_parent_id',0,' pcat_type = 1 AND pcat_active = 1','pcat_id,pcat_name,pcat_order,pcat_type,pcat_parent_id,pcat_has_child,pcat_picture,pcat_active,admin_id','pcat_order ASC,pcat_order ASC, pcat_name ASC','pcat_has_child');
?>
<div class="menu-category">
	<div class="menu-category-titlte">
		<span>DANH MỤC TIN TỨC</span>
	</div>
	<div class="menu-category-content">
		<ul>
			<?php
			$i = 1;
			foreach($listAll as $key=>$row){ 
			?>
				<?php if($row['pcat_parent_id'] == 0){?>
					<li class="<?=($i==2)?'item-menu-last':'';?>">
						<?php $currentParentId = $row['pcat_id'];?>
						<a class="item-parent-menu-courses <?=($row['pcat_id']==$iCategory)?'item-menu-active':'';?>" href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($row['pcat_name'])?>-c<?=$row['pcat_id']?>.html">
							<?=$row['pcat_name']?>
						</a>
						<ul class="sub-menu-category">
							<?php foreach($listAll as $key=>$row){ ?>
								<?php if($row['pcat_parent_id'] == $currentParentId){?>
									<li class="sub_menu_courses">
										<a class="<?=($row['pcat_id']==$iCategory)?'item-menu-child-active':'';?>" href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($row['pcat_name'])?>-c<?=$row['pcat_id']?>.html"><?=$row['pcat_name']?></a>
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