
<?php
    $iCou = getValue('iCou','int','GET',0);
?>
<div class="list-courses">
    <div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-title">
                    <div class="list-courses-filter-title-main">
                        <span>XÁC NHẬN THÔNG TIN NGƯỜI MUA</span>
                    </div>
                    <!--<span class="list-courses-filter-title-breadcrumb list-courses-filter-title-breadcrumb-pay">              
                        <a>Trang chủ</a> 
                        <span></span>
                        <a>THANH TOÁN</a>
                    </span>-->
                </div>
                <div class="list-courses-filter-search">
                    <form method="get" id="courses-search" class="courses-search" action="#">
                        <input type="submit" class="search-searchtext-module" value="">
                        <input id="searchtext" class="searchtext-module" name="searchtext" type="text" value="" placeholder="Khóa học">
                        <input type="hidden" name="search-type" value="courses">
                    </form>
                </div>
                <div class="list-courses-filter-title-description">
                    Bạn vui lòng nhập đầy đủ thông tin để tiến hành thanh toán.Xin chân thành cảm ơn.
                </div>
            </div>
        </div>
    </div>

    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="payment-step">
                    <div class="payment-step-list payment-step-list-active">
                        <span>Bước 1 : Xác nhận thông tin người mua</span>
                    </div>
                    <div class="payment-step-list">
                        <span>Bước 2 : Xác nhận thông tin thanh toán</span>
                    </div>
                    <div class="payment-step-list">
                        <span>Bước 3 : Thanh toán thành công</span>
                    </div>
                </div>
                <div class="list-courses-main-content-login">
                    <div class="list-courses-main-content-show-hh">
                        <div class="regis">
                            <!--<div class="login-title">XÁC NHẬN THÔNG TIN NGƯỜI MUA</div>-->
                            <div class="login-content">
                                <form action="http://<?=$base_url?>/payment/method.html" id="payment-form" class="" enctype="multipart/form-data" method="POST">
                                    <div class="control-group">
                                        <label class="control-label">Họ và tên <span>*</span></label>
                                        <div class="controls">
                                            <input type="text" name="name" value="<?=($myuser->use_name!="")?$myuser->use_name:'';?>" id="payment_name">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Số điện thoại <span>*</span></label>
                                        <div class="controls">
                                            <input type="text" name="phone" value="<?=($myuser->use_phone!="")?$myuser->use_phone:'';?>" id="payment_phone">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Email <span>*</span></label>
                                        <div class="controls">
                                            <input type="text" name="email" value="<?=$myuser->use_email?>" id="payment_email" readonly>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Địa chỉ <span>*</span></label>
                                        <div class="controls">
                                            <input type="text" name="address" value="<?=($myuser->use_address!="")?$myuser->use_address:'';?>" required="" id="payment_address">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"></label>
                                        <div class="controls">
                                            <input type="hidden" name="action" value="payment">
                                            <span class="act-button act-button-payment-step-info" id="payment-btn-step-info">Tiếp tục</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="iCou" value="<?=$iCou?>" required="" id="icou">
                                </form>
                            </div>
                        </div>
                        <div class="bg-payment">
                            <img src="http://<?=$base_url?>/themes/img/online-payment.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>