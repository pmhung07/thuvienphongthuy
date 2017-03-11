<?php

$cusName    = getValue('name','str','POST','');
$cusPhone   = getValue('phone','str','POST','');
$cusEmail   = getValue('email','str','POST','');
$cusAddress = getValue('address','str','POST','');

$digits = 10;
$order_id = 'u_'.$myuser->u_id.'_'.str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$business = 'leminhdzung1980@gmail.com';
?>
<span class="price_visa_info">
<b>Sử dụng thẻ quốc tế Visa/MasterCard</b>
Chấp nhận giao dịch thẻ Visa / MasterCard do tất cả các ngân hàng trong nước phát hành.</br>
Thời gian hoàn thành: Hoàn thành ngay </br>
<!--<img src="http://<?=$base_url?>/themes/img/method_pay_visa.jpg">-->
</span>
<span class="price_visa_info price_card_info">
    <b>Chọn loại thẻ thanh toán</b>
</span>
<span class="payment_method_card">
	<?//php echo $baokim->generateBankImage($banks,PAYMENT_METHOD_TYPE_CREDIT_CARD); ?>
	<img class="img-bank" id="128" src="http://<?=$base_url?>/themes/img/payment/method_pay_visa.png" title="Thẻ tín dụng quốc tế (Visa/Mastercard)">
</span>
<span class="price_visa_info price_card_info">
    <b>Chọn số tiền muốn nạp</b>
</span>
<form action="http://<?=$base_url?>/request-bk" id="payment-visa" class="" enctype="multipart/form-data" method="POST">
	<div class="price_visa_list_bank">
        <div class="mobi-card" id="">
            <center>
            <label for="pay50000">50.000 vnđ</label>
            <input class="btn_visa_package" id="pay50000" name="radio_visa_package" type="radio" value="50000" />
            </center>
        </div>
        <div class="mobi-card" id="">
            <center>
            <label for="pay100000">100.000 vnđ</label>
            <input class="btn_visa_package" id="pay100000" name="radio_visa_package" type="radio" value="100000" /> 
            </center>
        </div>
        <div class="mobi-card" id="">
            <center>
            <label for="pay200000">200.000 vnđ</label>
            <input class="btn_visa_package" id="pay200000" name="radio_visa_package" type="radio" value="200000" /> 
            </center>
        </div>
        <div class="mobi-card" id="">
            <center>
            <label for="pay300000">300.000 vnđ</label>
            <input class="btn_visa_package" id="pay300000" name="radio_visa_package" type="radio" value="300000" /> 
            </center>
        </div>
        <div class="mobi-card" id="">
            <center>
            <label for="pay500000">500.000 vnđ</label>
            <input class="btn_visa_package" id="pay500000" name="radio_visa_package" type="radio" value="500000" /> 
            </center>
        </div>
	</div>

    <input type="hidden" name="order_id" value="<?=$order_id?>"/>
    <input type="hidden" name="business" value="<?=$business?>"/>

	<input type="hidden" name="payer_name" value="<?=$cusName?>"/>
	<input type="hidden" name="payer_phone_no" value="<?=$cusPhone?>"/>
	<input type="hidden" name="payer_email" value="<?=$cusEmail?>"/>
	<input type="hidden" name="address" value="<?=$cusAddress?>"/>
	<input type="hidden" name="total_amount" id="total_amount" value=""/>

	<input type="hidden" name="active_submit" value="submit"/>
	<input type="hidden" name="bank_payment_method_id" id="bank_payment_method_id" value="128"/>
	<input type="hidden" name="shipping_address" size="30" value="Hà Nội"/>
	<input type="hidden" name="payer_message" size="30" value="Ok"/>
	<input type="hidden" name="extra_fields_value" size="30" value=""/>
	<input type="hidden" name="extra_payment" id="extra_payment" value=""/>

</form>
<div class="login-content">
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <input type="hidden" name="action" value="payment">
            <span class="act-button act-button-payment-step-info" id="payment-btn-visa">Thanh toán</span>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){	
    	// CLICK IMAGES
    	$('.payment_method_card img').click(function(){
    		$('.payment_method_card img').removeClass('pay-img-active');
            $(this).addClass('pay-img-active');
            var id = $(this).attr('id');
			$('#bank_payment_method_id').val(id);
        });

        // CLICK PRICE PACKAGE
        $('.btn_visa_package').click(function(){
	        var total_amount = $(this).val();
	        $('#total_amount').val(total_amount);
        });

    	// CLICK SUBMIT
        $('#payment-btn-visa').click(function(){
            if(!$(".btn_visa_package").is(':checked')){
                alert('Bạn chưa chọn gói cước.Vui lòng xem kỹ lại thông tin');
                return false;
            }else{
               	$("#payment-visa").submit();
               	return false;
            }
        });
    });
</script>