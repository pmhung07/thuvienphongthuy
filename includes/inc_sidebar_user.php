<?php
	$arrmesguitinnhanchungcalop = '';
	$arrmesguitinnhanchungcaloptieng = '';

    $mod = getValue("mod","str","GET","");

 
	$curtime1 = time();
	$seventime1 = 60 * 60 * 24 * 7;
    $dbmes6 = new db_query("SELECT * FROM  mesclass WHERE mesclass_type = 1");
    $arrmes6 = $dbmes6->resultArray();
    if(count($arrmes6) > 0){
        if($curtime1 < ($arrmes6[0]['mesclass_date'] + $seventime1)){
        	$countconlai = FLOOR((($arrmes6[0]['mesclass_date'] + $seventime1) - $curtime1) / (24*60*60));
        	$arrmesguitinnhanchungcalop1 = "</br><span style='padding-left:20px;color:red;font-weight:bold;font-size: 10px;'>( Có tin nhắn mới ".(7 - $countconlai)." ngày trước )</span>";
        }
    }
    



    $dbmes2 = new db_query("SELECT * FROM  class_user WHERE class_user_uid = ".$myuser->u_id);
    $arr2 = $dbmes2->resultArray();
    $totalmes2 = count($arr2);
    if($totalmes2 > 0){
    	$curtime = time();
    	$seventime = 60 * 60 * 24 * 7;
        $dbmes3 = new db_query("SELECT * FROM  mesclass WHERE mesclass_type = 0 AND mesclass_class= ".$arr2[0]['class_user_class_id']);
        $arrmes3 = $dbmes3->resultArray();
        if(count($arrmes3) > 0){
	        if($curtime < ($arrmes3[0]['mesclass_date'] + $seventime)){
	        	$arrmesguitinnhanchungcalop = "</br><span style='padding-left:20px;color:red;font-weight:bold;font-size: 10px;'>( Có tin nhắn mới )</span>";
	        }
	    }
    }

    $dbmes4 = new db_query("SELECT * FROM  mesclass WHERE mesclass_type = 3 AND mes_uid=".$myuser->u_id." AND mesclass_read = 0");
    $arr4 = $dbmes4->resultArray();
    $totalmes4 = count($arr4);
    if($totalmes4 > 0){
    	$arrmesguitinnhanchungcaloptieng = "</br><span style='padding-left:20px;color:red;font-weight:bold;font-size: 10px;'>( Có ".$totalmes4." tin nhắn mới ) </span>";
    }else{
    	$arrmesguitinnhanchungcaloptieng = '';
    }
?>
<div class="menu-category">
	<div class="menu-category-titlte">
		<span>DANH MỤC QUẢN LÝ</span>
	</div>
	<div class="menu-category-content-user">
		<ul>
			<li>	
				<a class="item-parent-menu-courses <?=($mod == 'userInfo')?'item-menu-active':'';?>" href="http://<?=$base_url?>/user/info.html">
					Thông tin cá nhân
				</a>
			</li>
			<li>	
				<a class="item-parent-menu-courses <?=($mod == 'userAcc')?'item-menu-active':'';?>" href="http://<?=$base_url?>/user/userAcc.html">
					Thông tin tài khoản
				</a>
			</li>
			<?php if($myuser->use_teacher == 1) {  ?>
			<li>	
				<a class="item-parent-menu-courses <?=($mod == 'userAssistant')?'item-menu-active':'';?>" href="http://<?=$base_url?>/user/assistant.html">				
					Hệ thống trợ giảng
				</a>
			</li>
			<li>	
				<a class="item-parent-menu-courses <?=($mod == 'userSendMesTeach')?'item-menu-active':'';?>" href="http://<?=$base_url?>/user/SendMesTeach.html">				
					Tin nhắn đã gửi
				</a>
			</li>
			<?php } ?>
			<li>	
				<a class="item-parent-menu-courses <?=($mod == 'userMypractice')?'item-menu-active':'';?>" href="http://<?=$base_url?>/user/myas.html">				
					Bài làm của bạn
				</a>
			</li>
			<li>	
				<a class="item-parent-menu-courses <?=($mod == 'userMes')?'item-menu-active':'';?>" href="http://<?=$base_url?>/user/mes.html">				
					Thông báo Lớp <?=$arrmesguitinnhanchungcalop?> 
				</a>
			</li>
			<li>	
				<a class="item-parent-menu-courses <?//=($mod == 'userMesAdmin')?'item-menu-active':'';?>" href="http://<?=$base_url?>/user/mesAdmin.html">				
					Thông báo từ Quản trị <?=$arrmesguitinnhanchungcalop1?> 
				</a>
			</li>
			<li>	
				<a class="item-parent-menu-courses <?=($mod == 'userMesAdminTeach')?'item-menu-active':'';?>" href="http://<?=$base_url?>/user/mesAdminTeach.html">				
					Thông báo từ Giáo viên <?=$arrmesguitinnhanchungcaloptieng?> 
				</a>
			</li>
			<li>	
				<a class="item-parent-menu-courses <?=($mod == 'userExp')?'item-menu-active':'';?>" href="http://<?=$base_url?>/user/userExp.html">				
					Điểm kinh nghiệm & Huy hiệu
				</a>
			</li>
		</ul>
	</div>
</div>