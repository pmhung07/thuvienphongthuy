<?php
$iCategory = getValue("iCategory","int","GET",0);    
$iCv = getValue("iCv","int","GET",0);    
  
$db_select = new db_query("SELECT * FROM cover_letters WHERE cv_id=".$iCv);
$arrCv = $db_select->resultArray();

$digits = 10;
$order_id = 'CV_u'.$myuser->u_id.'_'.str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
?>
<div class="list-courses">
    <div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-wrap">
                    <div class="list-courses-filter-title">
                        <div class="list-courses-filter-title-main-cv">
                            <?=$arrCv[0]['cv_name']?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="cv_content">
                        <div class="cv_content_img">
                            <img src="http://<?=$base_url?>/data/cover_letters/<?=$arrCv[0]['cv_imgcontent']?>">
                        </div>
                    </div>
                </div>
                <div class="list-courses-main-sidebar">
                    <div class="cv_info">
                        <div class="cv_info_price">
                            <span class="text_price">Mưc giá</span>
                            <span class="num_price"><?=format_number($arrCv[0]['cv_price'])?> vnđ</span>
                        </div>
                        <div class="cv_sapo">
                            <?=$arrCv[0]['cv_name']?>
                        </div>
                        <!--<div class="cv_buy">
                            <a target="_blank" href="http://<?=$base_url?>/data/cover_letters/<?//=$arrCv[0]['cv_data']?>">
                                <span>Tải xuống</span>
                            </a>
                        </div>-->
                        <div class="cv_info_details">
                            <div class="box -radius-all">
                                <?=$arrCv[0]['cv_info']?>
                            </div>
                        </div>
                        <div class="buycv">
                            <div class="buycv_title">
                                Mua tài liệu này
                            </div>
                            <div class="buycv_content">
                                <form action="http://<?=$base_url?>/home/process_opt.php" id="payment-sms" class="" enctype="multipart/form-data" method="POST">
                                    <input class="msisdn" name="msisdn" value="" placeholder="Nhập chính xác số điện thoại của bạn">
                                    <input type="hidden" name="amount" value="<?=$arrCv[0]['cv_price']?>"/>
                                    <input type="hidden" name="requestId" value="<?=$order_id?>"/>
                                    <input type="hidden" name="content" value="<?=$order_id?>"/>
                                    <input type="hidden" name="cv_id" value="<?=$arrCv[0]['cv_id']?>"/>
                                </form>
                                <span class="request_sms">XÁC NHẬN</span>
                            </div>
                        </div>
                        <!--<div style="padding: 10px;
                        background: #e4ffff;
                        text-align: center;
                        text-transform: uppercase;
                        font-size: 13px;">
                        <a target="_blank" href="http://<?=$base_url?>/data/cover_letters/<?//=$arrCv[0]['cv_data']?>">Tải xuống</a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$( ".request_sms" ).click(function() {
    $('form#payment-sms').submit();
    return false;  
});
</script>