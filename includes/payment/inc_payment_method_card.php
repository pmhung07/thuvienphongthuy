<?php
$cusName    = getValue('name','str','POST','');
$cusPhone   = getValue('phone','str','POST','');
$cusEmail   = getValue('email','str','POST','');
$cusAddress = getValue('address','str','POST','');
?>
<span class="price_visa_info price_card_info">
    <b>Bằng thẻ cào điện thoại</b>
    Thanh toán trực tiếp bằng thẻ cào điện thoại , nhập số seri và nhập mã trên thẻ cào.</br>
    Thời gian hoàn thành giao dịch: Hoàn thành ngay. </br>
    <img src="http://<?=$base_url?>/themes/img/cardmobile.jpg">
    <b>Chọn nhà mạng và nhập thông tin thẻ</b>
</span>
<div class="price_visa_list_bank">
    <div class="mobi-card" id="mobiphone">
        <center>
        <label for="mobiphone">Mobiphone</label>
        <input class="btn_card" id="mobiphone" name="radio_card" type="radio" value="MOBI" />
        </center>
    </div>
    <div class="mobi-card" id="vinaphone">
        <center>
        <label for="vinaphone">Vinaphone</label>
        <input class="btn_card" id="vinaphone" name="radio_card" type="radio" value="VINA" /> 
        </center>
    </div>
    <div class="mobi-card" id="viettel">
        <center>
        <label for="viettel">Viettel</label>
        <input class="btn_card" id="viettel" name="radio_card" type="radio" value="VIETEL" />
        </center>
    </div>
    <div class="mobi-card" id="fptgate">
        <center>
        <label for="fptgate">FPT Gate</label>
        <input class="btn_card" id="fptgate" name="radio_card" type="radio" value="GATE" />
        </center>
    </div>
    <div class="mobi-card" id="vtc">
        <center>
        <label for="vtc">VTC</label>
        <input class="btn_card" id="vtc" name="radio_card" type="radio" value="VTC" />
        </center>
    </div>
    <div class="mobi-card" id="vnm">
        <center>
        <label for="vnm">Vietnamobile</label>
        <input class="btn_card" id="vnm" name="radio_card" type="radio" value="VNM" />
        </center>
    </div>
</div>
<span class="price_visa_info price_card_info">
    <b>Chọn gói cước</b>
</span>
<div class="price_visa_list_bank">
    <div class="mobi-card" id="vinaphone">
        <center>
        <label for="pay50000">50.000 vnđ</label>
        <input class="btn_card_package" id="pay50000" name="radio_card_package" type="radio" value="50000" />
        </center>
    </div>
    <div class="mobi-card" id="vinaphone">
        <center>
        <label for="pay100000">100.000 vnđ</label>
        <input class="btn_card_package" id="pay100000" name="radio_card_package" type="radio" value="100000" /> 
        </center>
    </div>
    <div class="mobi-card" id="vinaphone">
        <center>
        <label for="pay200000">200.000 vnđ</label>
        <input class="btn_card_package" id="pay200000" name="radio_card_package" type="radio" value="200000" /> 
        </center>
    </div>
    <div class="mobi-card" id="vinaphone">
        <center>
        <label for="pay300000">300.000 vnđ</label>
        <input class="btn_card_package" id="pay300000" name="radio_card_package" type="radio" value="300000" /> 
        </center>
    </div>
    <div class="mobi-card" id="vinaphone">
        <center>
        <label for="pay500000">500.000 vnđ</label>
        <input class="btn_card_package" id="pay500000" name="radio_card_package" type="radio" value="500000" /> 
        </center>
    </div>
</div>
<div class="login-content">
    <form action="" id="payment-card" class="" enctype="multipart/form-data" method="POST">
        <div class="control-group">
            <label class="control-label">Nhập số seri <span>*</span></label>
            <div class="controls">
                <input class="ip_payment_card" type="text" name="name" value="" id="payment_card_seri">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nhập mã thẻ cào <span>*</span></label>
            <div class="controls">
                <input class="ip_payment_card" type="text" name="phone" value="" id="payment_card_code">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <input type="hidden" name="action" value="payment">
                <span class="act-button act-button-payment-step-info" id="payment-btn-card">Thanh toán</span>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#payment-btn-card').click(function(){
            var card    = $('input[name=radio_card]:checked').val();
            var money   = $('input[name=radio_card_package]:checked').val();
            var seri    = $("#payment_card_seri").val();
            var code    = $("#payment_card_code").val();
            if(code == "" || seri == ""){
                alert("Bạn chưa nhập đầy đủ thông tin");
                return false ;
            }else if(!$(".btn_card").is(':checked') || !$(".btn_card_package").is(':checked')){
                alert('Bạn chưa chọn nhà mạng hoặc chưa chọn gói cước.Vui lòng xem kỹ lại thông tin');
                return false;
            }else{
                $.ajax({
                    type:'POST',
                    dataType:'json',
                    url:'http://<?=$base_url?>/ajax/payment_mobile_card.php',
                    data:{
                        card:card,
                        seri:seri,
                        code:code,
                        money:money,
                        cusName:'<?=$cusName?>',
                        cusPhone:'<?=$cusPhone?>',
                        cusEmail:'<?=$cusEmail?>',
                        cusAddress:'<?=$cusAddress?>',
                    },
                    success:function(data){
                        alert(data.result_pay);
                    }
                });
            }
        });
    });
</script>