<?php
require_once('constants.php');
require_once('baokim_payment_pro.php');
require_once('baokim_payment.php');

$baokim = new BaoKimPaymentPro();
$banks = $baokim->get_seller_info();

$cusName    = getValue('name','str','POST','');
$cusPhone   = getValue('phone','str','POST','');
$cusEmail   = getValue('email','str','POST','');
$cusAddress = getValue('address','str','POST','');
if($cusName == '' || $cusPhone == '' || $cusEmail == '' || $cusAddress == ''){
    redirect('http://'.$base_url.'/payment.html');
}

?>
<div class="list-courses">
    <div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-title">
                    <div class="list-courses-filter-title-main">
                        <span>XÁC NHẬN THÔNG TIN THANH TOÁN</span>
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
                    Bạn vui lòng chọn phương thức thanh toán, mệnh giá để tiến hành thanh toán.Xin chân thành cảm ơn.
                </div>
            </div>
        </div>
    </div>

    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="payment-step">
                    <div class="payment-step-list">
                        <span>Bước 1 : Xác nhận thông tin người mua</span>
                    </div>
                    <div class="payment-step-list payment-step-list-active">
                        <span>Bước 2 : Xác nhận thông tin thanh toán</span>
                    </div>
                    <div class="payment-step-list">
                        <span>Bước 3 : Thanh toán thành công</span>
                    </div>
                </div>
                <div class="payment">
                    <div class="payment-method">
                        <div class="payment-list payment-method-card payment-method-active" title="payment-method-card">
                            <span><a>Bằng thẻ cào điện thoại</a></span>
                        </div>
                        <div class="payment-list payment-method-visa" title="payment-method-visa">
                            <span><a>Thẻ quốc tế Visa/MasterCard</a></span>
                        </div>
                        <div class="payment-list payment-method-atm" title="payment-method-atm">
                            <span><a>Bằng thẻ ATM nội địa</a></span>
                        </div>
                        <div class="payment-list payment-method-internet-banking" title="payment-method-internet-banking">
                            <span><a>Bằng thẻ Internet Banking</a></span>
                        </div>
                    </div>
                    <div class="payment-price">
                        <div class="payment_price_method payment_price_card">
                            <?php include_once('../includes/payment/inc_payment_method_card.php'); ?>
                        </div>
                        <div class="payment_price_method payment_price_visa">
                            <?php include_once('../includes/payment/inc_payment_method_visa.php'); ?>
                        </div>
                        <div class="payment_price_method payment_price_atm">
                            <?php include_once('../includes/payment/inc_payment_method_atm.php'); ?>
                        </div>
                        <div class="payment_price_method payment_price_internet_banking">
                            <?php include_once('../includes/payment/inc_payment_method_internet_banking.php'); ?>
                        </div>
                    </div>
                    <div class="payment-confirm">
                        <div class="payment_confirm_info">
                            <span class="price_confirm_info_details">
                                <b>Thông tin khách hàng</b>
                                <div class="price_confirm_cus">
                                    <b>Họ và tên : </b> <?=$cusName?>
                                </div>
                                <div class="price_confirm_cus">
                                    <b>Địa chỉ : </b> <?=$cusAddress?>
                                </div>
                                <div class="price_confirm_cus">
                                    <b>Phone : </b> <?=$cusPhone?>
                                </div>
                                <div class="price_confirm_cus">
                                    <b>Email : </b> <?=$cusEmail?>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>