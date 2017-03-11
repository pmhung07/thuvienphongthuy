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
    <b>Bằng thẻ ATM nội địa</b>
    Bạn cần đăng ký dịch vụ thanh toán trực tuyến của ngân hàng để sử dụng phương thức này.</br>
    Thời gian hoàn thành giao dịch: Hoàn thành ngay. </br>
</span>

<span class="price_visa_info price_card_info">
    <b>Chọn ngân hàng</b>
</span>

<span class="payment_atm_card">
    <?//php echo $baokim->generateBankImage($banks,PAYMENT_METHOD_TYPE_LOCAL_CARD); ?>
    <!--<img class="img-bank" id="128" src="http://<?=$base_url?>/themes/img/payment/method_pay_visa.png" title="Thẻ tín dụng quốc tế (Visa/Mastercard)">-->
    <img class="img-bank" id="15" src="https://www.baokim.vn/application/uploads/banks/vietcombank.png" title="Vietcombank - Ngân hàng TMCP Ngoại thương">
    <img class="img-bank" id="60" src="https://www.baokim.vn/application/uploads/banks/techcombank.png" title="Techcombank - Ngân hàng Kỹ thương Việt Nam">
    <img class="img-bank" id="91" src="https://www.baokim.vn/application/uploads/banks/vietinbank.png" title="Vietinbank - Ngân hàng Công thương Việt Nam">
    <img class="img-bank" id="131" src="https://www.baokim.vn/application/uploads/banks/bidvbank.png" title="BIDV - Ngân hàng Đầu tư và Phát triển Việt Nam">
    <img class="img-bank" id="105" src="https://www.baokim.vn/application/uploads/banks/maritimebank.png" title="MSB - Ngân hàng Hàng Hải Việt Nam">
    <img class="img-bank" id="124" src="https://www.baokim.vn/application/uploads/banks/Oceanbank.png" title="Ocean Bank - Ngân hàng Đại Dương">
    <img class="img-bank" id="113" src="https://www.baokim.vn/application/uploads/banks/vpbank.png" title="VPBank - Ngân hàng Việt Nam Thịnh Vượng">
    <img class="img-bank" id="101" src="https://www.baokim.vn/application/uploads/banks/dongabank.png" title="DongA Bank - Ngân hàng Đông Á">
    <img class="img-bank" id="64" src="https://www.baokim.vn/application/uploads/banks/acbbank.png" title="ACB - Ngân hàng Á Châu">
    <img class="img-bank" id="98" src="https://www.baokim.vn/application/uploads/banks/sacombank.png" title="Sacombank - Ngân hàng Sài Gòn Thương Tín">
    <img class="img-bank" id="61" src="https://www.baokim.vn/application/uploads/banks/mbbank.png" title="Ngânhàng Quân Đội (MB)">
    <img class="img-bank" id="112" src="https://www.baokim.vn/application/uploads/banks/agribank.png" title="Agribank - Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam">
    <img class="img-bank" id="62" src="https://www.baokim.vn/application/uploads/banks/vibbank.png" title="VIB - Ngân hàng Quốc Tế">
    <img class="img-bank" id="130" src="https://www.baokim.vn/application/uploads/banks/tienphongbank.png" title="TienPhongBank - Ngân hàng Tiên  Phong">
    <img class="img-bank" id="63" src="https://www.baokim.vn/application/uploads/banks/eximbank.png" title="Eximbank - Ngân hàng Xuất nhập khẩu">
    <img class="img-bank" id="148" src="https://www.baokim.vn/application/uploads/banks/shbbank.png" title="SHB - Ngân hàng Sài Gòn- Hà Nội">
    <img class="img-bank" id="150" src="https://www.baokim.vn/application/uploads/banks/baovietbank.png" title="BAOVIET Bank - Ngân hàng Bảo Việt">
    <img class="img-bank" id="151" src="https://www.baokim.vn/application/uploads/banks/50x34-ocb.png" title="OCB - Ngân hàng Phương Đông">
    <img class="img-bank" id="153" src="https://www.baokim.vn/application/uploads/banks/seabank.png" title="SeABank - Ngân hàng Đông Nam Á">
    <img class="img-bank" id="152" src="https://www.baokim.vn/application/uploads/banks/50x34-lienvietbank.png" title="LienVietBank - Ngân hàng Liên Việt">
    <img class="img-bank" id="154" src="https://www.baokim.vn/application/uploads/banks/abbank.png" title="ABBank - Ngân hàng An Bình">
    <img class="img-bank" id="94" src="https://www.baokim.vn/application/uploads/banks/hdbank.png" title="HDBank - Ngân hàng Phát triển nhà TPHCM">
    <img class="img-bank" id="96" src="https://www.baokim.vn/application/uploads/banks/namabank.png" title="Nam A Bank - Ngân hàng Nam Á">
    <img class="img-bank" id="114" src="https://www.baokim.vn/application/uploads/banks/vietabank.png" title="VietABank - Ngân hàng Việt Á">
    <img class="img-bank" id="115" src="https://www.baokim.vn/application/uploads/banks/gpbank.png" title="GP Bank - Ngân hàng dầu khí Toàn Cầu">
    <img class="img-bank" id="102" src="https://www.baokim.vn/application/uploads/banks/pgbank.png" title="PG Bank - Ngân Hàng TMCP Xăng Dầu">
    <img class="img-bank" id="127" src="https://www.baokim.vn/application/uploads/banks/abbank.png" title="ABBank - Ngân hàng An Bình">
    <img class="img-bank" id="129" src="https://www.baokim.vn/application/uploads/banks/bac_a.jpg" title="BACABank - Ngân hàng Bắc Á">
    <img class="img-bank" id="97" src="https://www.baokim.vn/application/uploads/banks/saigonbank.png" title="Saigonbank - Ngân hàng Sài Gòn Công Thương">
    <img class="img-bank" id="106" src="https://www.baokim.vn/application/uploads/banks/navibank.png" title="NaviBank - Ngân hàng Nam Việt"> 
    <!--<img class="img-bank" id="128" src="http://tienganh2020.com/themes/img/payment/method_pay_visa.png" title="Thẻ tín dụng quốc tế (Visa/Mastercard)">-->
</span>

<span class="price_visa_info price_card_info">
    <b>Chọn gói cước</b>
</span>
<form action="http://<?=$base_url?>/request-bk" id="payment-atm" class="" enctype="multipart/form-data" method="POST">
    <div class="price_visa_list_bank">

        <div class="mobi-card" id="">
            <center>
            <label for="pay50000">50.000 vnđ</label>
            <input class="btn_atm_package" id="pay50000" name="radio_atm_package" type="radio" value="50000" />
            </center>
        </div>
        <div class="mobi-card" id="">
            <center>
            <label for="pay100000">100.000 vnđ</label>
            <input class="btn_atm_package" id="pay100000" name="radio_atm_package" type="radio" value="100000" /> 
            </center>
        </div>
        <div class="mobi-card" id="">
            <center>
            <label for="pay200000">200.000 vnđ</label>
            <input class="btn_atm_package" id="pay200000" name="radio_atm_package" type="radio" value="200000" /> 
            </center>
        </div>
        <div class="mobi-card" id="">
            <center>
            <label for="pay300000">300.000 vnđ</label>
            <input class="btn_atm_package" id="pay300000" name="radio_atm_package" type="radio" value="300000" /> 
            </center>
        </div>
        <div class="mobi-card" id="">
            <center>
            <label for="pay500000">500.000 vnđ</label>
            <input class="btn_atm_package" id="pay500000" name="radio_atm_package" type="radio" value="500000" /> 
            </center>
        </div>

    </div>

    <input type="hidden" name="order_id" value="<?=$order_id?>"/>
    <input type="hidden" name="business" value="<?=$business?>"/>

    <input type="hidden" name="payer_name" value="<?=$cusName?>"/>
    <input type="hidden" name="payer_phone_no" value="<?=$cusPhone?>"/>
    <input type="hidden" name="payer_email" value="<?=$cusEmail?>"/>
    <input type="hidden" name="address" value="<?=$cusAddress?>"/>
    <input type="hidden" name="total_amount" id="total_amount_atm" value=""/>

    <input type="hidden" name="active_submit" value="submit"/>
    <input type="hidden" name="bank_payment_method_id" id="bank_payment_atm_id" value="0"/>
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
            <span class="act-button act-button-payment-step-info" id="payment-btn-atm">Thanh toán</span>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){   
        // CLICK IMAGES
        $('.payment_atm_card img').click(function(){
            $('.payment_atm_card img').removeClass('pay-img-active');
            $(this).addClass('pay-img-active');
            var id = $(this).attr('id');
            $('#bank_payment_atm_id').val(id);
        });

        // CLICK PRICE PACKAGE
        $('.btn_atm_package').click(function(){
            var total_amount = $(this).val();
            $('#total_amount_atm').val(total_amount);
        });

        // CLICK SUBMIT
        $('#payment-btn-atm').click(function(){
            if(!$(".btn_atm_package").is(':checked')){
                alert('Bạn chưa chọn gói cước.Vui lòng xem kỹ lại thông tin.');
                return false;
            }else if($("#bank_payment_atm_id").val()==0){
                alert('Xin vui lòng chọn ngân hàng thanh toán.');
                return false;
            }else{
                $("#payment-atm").submit();
                return false;
            }
        });
    });
</script>