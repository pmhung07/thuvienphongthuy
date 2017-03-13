<?php
if($myuser->use_teacher != 1){
    redirect('http://'.$base_url);
}
$msg = '';
$action     =   getValue('action','str','POST','');
if($action  == 'addclass'){
    $class     = getValue('class','str','POST');
    if($class != ''){
        $dbCheckMail = new db_query('SELECT * FROM class WHERE class_name = "'.$class.'"');
        $numRowMail  = mysqli_num_rows($dbCheckMail->result);
        if($numRowMail <= 0){
            $curtime         =  time();
            $uid = $myuser->u_id;
            $sql                =  "INSERT INTO `class` (`class_id`, `class_name`, `class_university_code`, `class_user_created`, `class_time_created`) VALUES (NULL, '$class', NULL, '$uid', '$curtime');";
            $db_insert          =  new db_execute($sql);
            $msg .= 'Đăng ký lớp thành công';
        }else{
            $msg .= 'Lơp học này đã được đăng ký';
        }
    }else{
        $msg .= 'Bạn chưa nhập đầy đủ thông tin lớp';
    }
}
?>
<div class="user-manager-info">
    <div class="block-content-show-content">
        <div class="block-content-info">
            <div class="notice-update-info">Hệ thống trợ giảng</div>
            <div class="block-content-info-activity">
		        <div class="assistant-add-class">
		        	<form id="add-class" class="" enctype="multipart/form-data" method="POST">
		        		<?php if($msg != ''){ ?>
		                    <div class="control-group">
		                        <label class="control-label error-login"><span><?=$msg?></span></label>
		                    </div>
		                <?php } ?>
		        		<div class="contactfree_content">
		                    <div class="contactfree_content_left">
		                        <div class="control-group control-group-class">
		                            <label class="control-label control_label_class">Thêm lớp học <span>*</span></label>
		                            <div class="controls controls_contact">
		                                <input style="height: 18px;border: solid 1px #037185;" type="text" name="class" value="" id="class">
		                            </div>
		                        </div>
		                    </div>
		                    <div class="contactfree_content_right">
		                        <div class="control-group">
		                        	<input type="hidden" name="action" value="addclass">
		                            <span class="requestaddclass">Save</span>
		                        </div>
		                    </div>
		                </div>
		        	</form>
		        	<script type="text/javascript">
		        	$(".requestaddclass").click(function(){
				        $("#add-class").submit();
				    });
		        	</script>
		        </div>
		        <div class="list_student">
		        	<?php
		        	$db_query_class = new db_query('SELECT * FROM class WHERE class_user_created='.$myuser->u_id);
		        	$arrClass = $db_query_class->resultArray();
		        	foreach($arrClass as $keyClass=>$valueClass){
		        	?>
		        		<div class="wrap_class">
		        			<div class="asshead">
				        		<div class="list_student_class">Lớp : <span><?=$valueClass['class_name']?></span></div>
				        		<div class="list_student_adduser">
				        			Thêm học viên :
				        			<input class="email_student_add_<?=$valueClass['class_id']?>" type="text" value="" placeholder="Email học viên">
				        			<span class="add_student" onclick="addStudent(<?=$valueClass['class_id']?>)">Save</span>
				        		</div>
				        		<div class="manclassdetails" style="width:100%;">Quản lý chi tiết</div>

				        		<div class="assbot">
				        		<div class="ccd">
				        			<span class="cctd">Gửi tin nhắn cho lớp <?=$valueClass['class_name']?></span>
				        			<div class="mesnone">
					        			<textarea class="messclass" style="resize:none;width:98%;height:50px;"></textarea>
					        			<span style="cursor:pointer;" onclick="sendmesclass(<?=$valueClass['class_id']?>)" class="ccdgtn">Gửi tin nhắn</span>
				        			</div>
				        		</div>
				        		<div class="list_student_details">
				        			<div class="list_student_details_head">
				        				<div class="list_student_details_head_col_1">ID</div>
				        				<div class="list_student_details_head_col_2">Mail</div>
				        				<div class="list_student_details_head_col_3">Name</div>
				        				<div class="list_student_details_head_col_4">Chấm điểm</div>
				        			</div>
				        			<?php
				        			$dbgetuser = new db_query("SELECT * FROM class_user a,users b
				        									   WHERE a.class_user_uid = b.use_id AND class_user_class_id=".$valueClass['class_id']);
				        			$arrUser = $dbgetuser->resultArray();
				        			$i = 1;
				        			foreach($arrUser as $keyu => $valu){
				        			?>
				        			<div class="list_student_details_head">
				        				<div class="list_student_details_head_col_show_1"><?=$i?></div>
				        				<a target="_blank" href="http://<?=$base_url?>/userview/view-info/<?=$valu['use_id']?>.html">
				        					<div class="list_student_details_head_col_show_2"><?=$valu['use_email']?></div>
				        				</a>
				        				<div class="list_student_details_head_col_show_3">
				        					<?
				        					if($valu['use_name'] != ''){
				        						echo $valu['use_name'];
				        					}else{
				        						echo "Account cũ ! Chưa update.";
				        					}

				        					?>
				        				</div>
				        				<div class="list_student_details_head_col_show_4">
				        					<a class="chamdiem" onclick="resultquiz(<?=$valu['use_id']?>)">Chi tiết</a>
				        				</div>
				        			</div>
				        			<div class="list_student_details_mark list_student_details_mark_<?=$valu['use_id']?>">

				        			</div>
				        			<div class="guitnchodung">
				        				<textarea placeholder="Gửi tin nhắn cho học viên <?=$valu['use_name']?>" class="messclassrieng" style="resize:none;width:98%;height:50px;"></textarea>
				        				<span style="float:left;cursor:pointer;background-color: #060606;font-size: 11px;padding: 10px;color: white;" onclick="sendmesclassrieng(<?=$valueClass['class_id']?>,<?=$valu['use_id']?>)" class="ccdgtnass">Gửi tin nhắn cho <?=$valu['use_name']?></span>
				        			</div>
				        			<?php $i++;} ?>
				        		</div>
				        	</div>

			        		</div>

		        		</div>
		        	<?php }unset($db_query_class); ?>
		        </div>
		    </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function resultquiz(uid){
	var baseurl       =  'http://<?=$base_url?>';
	$(".list_student_details_mark").hide();
	$(".list_student_details_mark_"+uid).fadeIn(400);
    $('.list_student_details_mark_'+uid).load(baseurl+'/ajax/mark_quiz.php?uid='+uid);
}

function addStudent(class_id){
   	var email_student = $('.email_student_add_'+class_id).val();
	$.ajax({
		type:'POST',
		dataType:'text',
		data:{
			class_id:class_id,
			email_student:email_student,
			type:"add_student"
      	},
		url:'http://<?=$base_url?>/ajax/request.php',
		success:function(data){
			if($.trim(data) == 1){
				alert('Thêm học viên thành công');
				window.location.reload();
			}else{
				alert('Xảy ra lỗi trong quá trình xử lý hoặc không tồn tại địa chỉ Email');
			}
      	}
   	});
}

function sendmesclass(class_id){
   	var contentmes = $('.messclass').val();
   	if(contentmes.length > 10 && contentmes != "" ){
		$.ajax({
			type:'POST',
			dataType:'text',
			data:{
				class_id:class_id,
				teacher:<?=$myuser->use_teacher?>,
				contentmes:contentmes
	      	},
			url:'http://<?=$base_url?>/ajax/sendmesclass.php',
			success:function(data){
				if($.trim(data) == 1){
					alert('Gửi tin nhắn thành công');
					window.location.reload();
				}else{
					alert('Xảy ra lỗi trong quá trình xử lý hoặc không tồn tại địa chỉ Email');
				}
	      	}
	   	});
	}else{
		alert('Tin nhắn không được để trống hoặc phải lớn hơn 10 ký tự');
	}
}

function sendmesclassrieng(class_id,u_id){
   	var contentmes = $('.messclassrieng').val();
   	if(contentmes.length > 10 && contentmes != "" ){
		$.ajax({
			type:'POST',
			dataType:'text',
			data:{
				class_id:class_id,
				teacher:<?=$myuser->use_teacher?>,
				u_id:u_id,
				contentmes:contentmes
	      	},
			url:'http://<?=$base_url?>/ajax/sendmesclassrieng.php',
			success:function(data){
				if($.trim(data) == 1){
					alert('Gửi tin nhắn thành công');
					window.location.reload();
				}else{
					alert('Xảy ra lỗi trong quá trình xử lý hoặc không tồn tại địa chỉ Email');
				}
	      	}
	   	});
   	}else{
		alert('Tin nhắn không được để trống hoặc phải lớn hơn 10 ký tự');
	}
}

$(".manclassdetails").click(function(){
	$('.assbot').hide();
	$(this).parent().children('.assbot').fadeIn(400);
});


$(".cctd").click(function(){
	$(this).parent().children('.mesnone').fadeIn(400);
});

</script>

<style type="text/css">
	.assbot{
		display: none;
		overflow: hidden;
		margin-top: 10px;
	}
	.asshead{
		overflow: hidden;
	}
	.manclassdetails{
		width: 100%;
		/* display: -webkit-box; */
		padding: 6px 0px;
		font-size: 11px;
		text-align: center;
		background-color: #666666;
		color: rgb(255, 255, 255);
		overflow: hidden;
		text-transform: uppercase;
		cursor: pointer;
	}
</style>