<?php
$msg = '';
$action     =   getValue('action','str','POST','');
if($action  == 'usersetting'){
    $usePassword    = getValue('use_password','str','POST');
    $reUsePassword  = getValue('re-use_password','str','POST');
    //$useLogin       = getValue('use_login','str','POST');
    $useName        = getValue('use_name','str','POST');
    $useGender      = getValue('use_gender','int','POST');
    $usePhone       = getValue('use_phone','str','POST');
    $useAddress     = getValue('use_address','str','POST');
    $useCapcha      = getValue('use_capcha','str','POST');

    if($useCapcha != "" && $useCapcha == $_SESSION['security_code_userinfo']){
        if($useName != "" && $usePhone != "" && $useAddress != "" && $useGender != 0 && ($useGender == 1 || $useGender == -1)){
            if($usePassword != ""){
                if($reUsePassword != "" && ($reUsePassword == $usePassword)){
                    $db_slUser = new db_query('SELECT use_security FROM users WHERE use_id='.$myuser->u_id);
                    $arr_slUser = $db_slUser->resultArray();
                    $newpassword = md5($usePassword.$arr_slUser[0]['use_security']);
                    $sql_update = "UPDATE users SET use_password='".$newpassword."',use_gender='".$useGender."',use_phone='".$usePhone."',use_address='".$useAddress."',use_name='".$useName."' WHERE use_id=".$myuser->u_id;
                    $db_update = new db_execute($sql_update);
                    unset($db_update); 
                    $msg .= 'Cập nhật thông tin thành công';
                }else{
                    $msg .= 'Mật khẩu không khớp nhau';
                }
            }else{
                $sql_update = "UPDATE users SET use_gender='".$useGender."',use_phone='".$usePhone."',use_address='".$useAddress."',use_name='".$useName."' WHERE use_id=".$myuser->u_id;
                $db_update = new db_execute($sql_update);
                unset($db_update); 
                $msg .= 'Cập nhật thông tin thành công';
            }
        }else{
            $msg .= 'Các thông tin có dấu " * " không được để trống';
        }
    }else{
        $msg .= 'Dãy số bảo mật không đúng';
    }
}

$dbSelectUser = new db_query('SELECT * FROM users WHERE use_id = '.$myuser->u_id);
$arrUser = $dbSelectUser->resultArray();
unset($dbSelectUser);

?>
<div class="user-manager-info">
    <div class="block-content-show-content">
        <div class="block-content-info">
            <div class="notice-update-info">Hãy cập nhật đầy đủ thông tin cá nhân của bạn để giáo viên của chúng tôi có thể hỗ trợ và chăm sóc cho bạn một cách tôt nhât.Xin chân thành cảm ơn.</div>
            <form id="usersetting-form" class="" enctype="multipart/form-data" method="POST">
                <?php if($msg != ''){ ?>
                    <div class="control-group">
                        <label class="control-label-info error-login"><span><?=$msg?></span></label>
                    </div>
                <?php } ?>
                <?php foreach($arrUser as $key => $value){ ?>
                <div class="control-group">
                    <label class="control-label-info">Email <span class="relation-notice">*</span></label>
                    <div class="controls">
                        <input type="text" name="use_email" value="<?=$value['use_email']?>" id="" readonly>
                    </div>
                </div>
                <?php if($value['use_openid'] != 1){ ?>
                    <div class="control-group">
                        <label class="control-label-info">Mật khẩu <span></span></label>
                        <div class="controls">
                            <input name="use_password" type="password" value="" required="" id="" placeholder="Nhập mật khẩu muốn thay">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label-info">Nhập lại mật khẩu <span></span></label>
                        <div class="controls">
                            <input name="re-use_password" type="password" value="" required="" id="" placeholder="Nhập lại mật khẩu muốn thay">
                        </div>
                    </div>
                <?php } ?>
                <!--<div class="control-group">
                    <label class="control-label-info">Tên hiển thị trên Website  <span class="relation-notice">*</span></label>
                    <div class="controls">
                        <input type="text" name="use_login" value="<?//=$value['use_login']?>" id="">
                    </div>
                </div>-->
                <div class="control-group">
                    <label class="control-label-info">Họ và tên  <span class="relation-notice">*</span></label>
                    <div class="controls">
                        <input type="text" name="use_name" value="<?=$value['use_name']?>" id="">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label-info">Số điện thoại  <span class="relation-notice">*</span></label>
                    <div class="controls">
                        <input type="text" name="use_phone" value="<?=$value['use_phone']?>" id="">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label-info">Giới tính  <span class="relation-notice">*</span></label>
                    <div class="controls">
                        <select id="select_update_user" name="use_gender">
                            <option <?=($value['use_gender'] == 0)?'selected':'';?> value="0">Chọn giới tính</option>
                            <option <?=($value['use_gender'] == -1)?'selected':'';?> value="-1">NỮ</option>
                            <option <?=($value['use_gender'] == 1)?'selected':'';?> value="1">NAM</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label-info">Địa chỉ  <span class="relation-notice">*</span></label>
                    <div class="controls">
                        <textarea name="use_address"><?=$value['use_address']?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label-info">
                        <img src="http://<?=$base_url?>/home/capcha_userinfo.php">
                        <span></span>
                    </label>
                    <div class="controls">
                        <input type="text" name="use_capcha" value="" id="" placeholder="Nhập chính xác dãy số bên trên">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="hidden" name="action" value="usersetting">
                        <span class="act-button act-button-update-user" id="login-btn">UPDATE</span>
                    </div>
                </div>
                <?php } ?>
            </form>
            <script type="text/javascript">
            $(".act-button-update-user").click(function(){
                $("#usersetting-form").submit();
            });
            </script>
        </div>
    </div>
</div>