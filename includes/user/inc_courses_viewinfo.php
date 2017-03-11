<?php
$msg = '';
$uid = getValue('uId','int','GET',0);

$dbSelectUser = new db_query('SELECT * FROM users WHERE use_id = '.$uid);
$arrUser = $dbSelectUser->resultArray();
unset($dbSelectUser);

?>
<div class="user-manager-info">
    <div class="content">
        <div class="content-main">
            <div class="block-content-show-content">
                <div class="block-content-info">

                    <form id="usersetting-form" class="" enctype="multipart/form-data" method="POST">
                        <?php foreach($arrUser as $key => $value){ ?>
                        <div class="notice-update-info">Thông tin học viên : <?=$value['use_name']?></div>
                        <div class="control-group">
                            <label class="control-label-info">Họ và tên  <span class="relation-notice">*</span></label>
                            <div class="controls">
                                <input type="text" name="use_name" value="<?=$value['use_name']?>" id="">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label-info">Email <span class="relation-notice">*</span></label>
                            <div class="controls">
                                <input type="text" name="use_email" value="<?=$value['use_email']?>" id="" readonly>
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
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>