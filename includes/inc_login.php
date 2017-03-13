<?php
    require_once("../classes/class.phpmailer.php");
    require_once("../classes/class.smtp.php");
    require_once("../classes/send_mail.php");

    if($myuser->logged == 1) {
        redirect('http://'.$base_url);
    }

    $msg = '';
    $action     =   getValue('action','str','POST','');
    /* CHECK LOGIN */
    if($action  == 'login'){
        $useEmail     = getValue('email','str','POST','');
        $usePassword  = getValue('password','str','POST','');
        $myuser->user($useEmail,$usePassword);
        if($myuser->logged == 1){
            $myuser->savecookie(30*24*3600);
            $msg .= 'Chúc mừng bạn đã đăng nhập thành công';
            redirect('http://'.$base_url);
        }else{
            $msg .= 'Tài khoản không tồn tại hoặc nhập sai mật khẩu';
        }
    /* CHECK REGIS */
    }elseif($action  == 'regis'){
        $useEmail     = getValue('email','str','POST');
        $usePhone     = getValue('phone','str','POST');
        $useName      = getValue('name','str','POST');
        $usePassword  = getValue('password','str','POST');
        if($useEmail != '' && $usePhone != '' && $useName != '' && $usePassword != ''){
            $dbCheckMail = new db_query('SELECT * FROM users WHERE use_email = "'.$useEmail.'"');
            $numRowMail  = mysqli_num_rows($dbCheckMail->result);
            if($numRowMail <= 0){
                $useSecurity  =  random();
                //Code activate email
                $message = "";
                $message .= "Cảm ơn bạn đã đăng ký tài khoản trên Hamhoc.edu.com <br/>";
                $message .= "Thông tin tài khoản: <br/>";
                $message .= "Email đăng nhập: ".$useEmail."<br/>";
                $message .= "Mật khẩu: ".$usePassword."<br/>";
                $message .= "Để kích hoạt tài khoản và sử dụng đầy đủ các dịch vụ của chúng tôi.Mời bạn click vào link dưới đây.<br/>";
                $message .= "<a href='http://".$base_url."/activate/".$useEmail."/".$useSecurity."'>http://".$base_url."/activate/".$useEmail."/".$useSecurity."</a>";
                //Code send mail........
                $sendMail = new sendMail();
                $sendMail->init();
                $isSuccess = $sendMail->send($message,$useEmail,"User");
                if($isSuccess == true){
                    $useDateIns         =  time();
                    $usePasswordIns     =  md5($usePassword.$useSecurity);
                    $sql                =  "INSERT INTO `users` (`use_id`, `use_active`, `use_login`, `use_password`, `use_birthdays`, `use_gender`, `use_phone`, `use_email`, `use_address`, `use_date`, `use_security`, `use_name`, `use_avatar`) VALUES (NULL, '0', 'Tân Binh', '$usePasswordIns', NULL, '1', NULL, '$useEmail', NULL, '$useDateIns', '$useSecurity', '$useName', NULL);";
                    $db_insert          =  new db_execute($sql);
                    $msg .= 'Chúc mừng bạn đã đăng ký thành công.Chúng tôi đã gửi cho bạn một Email kích hoạt tài khoản,hãy kích hoạt tài khoản của bạn để hoàn tất quá trình đăng ký.Chúc bạn có quãng thời gian vui vẻ và bổ ích cùng Hamhoc.edu.vn';
                }else{
                    $msg .= 'Có vấn đề xảy ra trong quá trình xử lý. Hãy liên lạc với quản trị viên của chúng tôi để được giúp đỡ';
                }
            }else{
                $msg .= 'Email này đã được đăng ký';
            }
        }else{
            $msg .= 'Bạn chưa nhập đầy đủ thông tin đăng ký';
        }
    }
?>
<div class="list-courses" style="margin=top:20px;">
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content-login">
                    <div class="list-courses-main-content-show-login">
                        <div class="login">
                            <div class="login-title">ĐĂNG NHẬP TRÊN THƯ VIỆN PHONG THUỶ</div>
                            <div class="login-content">
                                <form id="login-form" class="" enctype="multipart/form-data" method="POST">
                                    <?php if($msg != ''){ ?>
                                        <div class="control-group">
                                            <label class="control-label error-login"><span><?=$msg?></span></label>
                                        </div>
                                    <?php } ?>
                                    <div class="control-group">
                                        <label class="control-label">Email <span>*</span></label>
                                        <div class="controls">
                                            <input type="email" name="email" value="" id="use_email">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Mật khẩu <span>*</span></label>
                                        <div class="controls">
                                            <input name="password" type="password" value="" required="" id="use_password">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"></label>
                                        <div class="controls">
                                            <input type="hidden" name="action" value="login">
                                            <span class="act-button act-button-login" id="login-btn">Đăng nhập</span>
                                            <!--<span class="lost-password">Bạn quên mật khẩu ?</span>-->
                                        </div>
                                    </div>
                                    <!--<div class="control-group">
                                        <label class="control-label"></label>
                                        <div class="controls">
                                            <span class="regis-social-txt">Hoặc đăng nhập bằng tài khoản </span>
                                            <a href="http://<?=$base_url?>/dang-nhap/facebook.html"><img class="regispage-social" src="http://<?=$base_url?>/themes/img/icon-facebook.png"></a>
                                            <a href="http://<?=$base_url?>/dang-nhap/google.html"><img class="regispage-social" src="http://<?=$base_url?>/themes/img/icon-googlel.png"></a>
                                        </div>
                                    </div>-->
                                </form>
                            </div>
                            <!--<div class="login-social login-facebook">
                                <a href="">Đăng nhập bằng tài khoản Facebook</a>
                            </div>
                            <div class="login-social login-google">
                                <a href="">Đăng nhập bằng tài khoản Google+</a>
                            </div>-->
                        </div>
                        <!--END loGIN-->
                        <div class="regis">
                            <div class="login-title">ĐĂNG KÝ TRÊN THƯ VIỆN PHONG THUỶ</div>
                            <div class="login-content">
                                <form id="regis-form" class="" enctype="multipart/form-data" method="POST">
                                    <div class="control-group">
                                        <label class="control-label">Họ và tên <span>*</span></label>
                                        <div class="controls">
                                            <input type="email" name="name" value="" id="regis_use_name">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Số điện thoại <span>*</span></label>
                                        <div class="controls">
                                            <input type="email" name="email" value="" id="regis_use_phone">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Email <span>*</span></label>
                                        <div class="controls">
                                            <input type="email" name="email" value="" id="regis_use_email">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Mật khẩu <span>*</span></label>
                                        <div class="controls">
                                            <input name="password" type="password" value="" required="" id="regis_use_password">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"></label>
                                        <div class="controls">
                                            <input type="hidden" name="action" value="regis">
                                            <span class="act-button act-button-regis" id="login-btn">Đăng ký</span>
                                        </div>
                                    </div>
                                    <!--<div class="control-group">
                                        <label class="control-label"></label>
                                        <div class="controls">
                                            <span class="regis-social-txt">Hoặc đăng ký bằng tài khoản </span>
                                            <a href=""><img class="regispage-social" src="http://<?//=$base_url?>/themes/img/icon-facebook.png"></a>
                                            <a href=""><img class="regispage-social" src="http://<?//=$base_url?>/themes/img/icon-google.png"></a>
                                        </div>
                                    </div>-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
