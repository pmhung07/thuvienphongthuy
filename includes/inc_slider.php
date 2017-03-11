<?php
$bg_slide = get_banner(1);
?>
<div id="s3slider">
    <ul id="s3sliderContent">
        <?php 
        foreach($bg_slide as $key=>$value){ 
        ?>
        <li class="s3sliderImage">
            <div class="wrap_img_slice">
                <a href="<?=$value['slide_url']?>">
                <img src="http://<?=$base_url?>/pictures/slides/<?=$value['slide_img']?>"/>
                </a>
            </div>
            <?php if($value['slide_content_invi'] == 1){ ?>
            <span style="<?=($value['slide_position'] == 0)?'left: 120px!important':'right: 120px!important';?>">
                <?=$value['slide_content']?>
                <a style="display: -webkit-inline-box;
                background-color:#49E489;
                padding: 10px 20px;
                color: white;
                z-index: 1000;" href="<?=$value['slide_url']?>"><?=$value['slide_button']?></a>
            </span>
            <?php }else{ ?>
                <span style="display:none!important;"></span>
                <style type="text/css">
                .s3sliderImage span{
                    display: none!important;
                }
                </style>
            <?php } ?>
        </li>
        <?php } ?>
        <div class="clear s3sliderImage"></div>
   </ul>
</div>
    <script>
$(document).ready(function() { 
    $('#s3slider').s3Slider({
        timeOut: 7000
    });
});
</script>


<style type="text/css">

.banner-ad-content{
    width: 25%;
    float: left;
    height: 220px;
    background: #cecece;
    overflow: hidden;
    cursor: pointer;
    overflow: hidden;
    background-attachment: fixed;
    background-position: 50% 20%;
    background-repeat: no-repeat;
}
.banner-ad-content img{
    width: 100%;
    float: left;
    height: auto;
    background: #cecece;
    overflow: hidden;
}

.banner-ad{
    overflow: hidden;
    margin-bottom: 30px;
    padding: 5px 0px;
    background-attachment: fixed;
    background-position: 50% 41px;
    background-repeat: no-repeat;
}
.banner_nation_content{
    overflow: hidden;
    padding: 30px 30px 0px 30px;
    background-color: #F7F7F7;
}
.banner_nation_title{
    overflow: hidden;
    text-align: center;
    margin-top: 20px;
    /* height: 40px; */
    /* line-height: 27px; */
    margin-bottom: 30px;
    /* background-color: #ECECEC; */
    padding: 15px 0px;
    border-bottom: solid 5px #D83E3B;
}
.banner_nation_title span{
    font-size: 30px;
    text-transform: uppercase;
    color: rgb(93, 93, 93);
    font-family: SFUDinEngAlt;
}
.list_nation{
    padding: 5px;
}
.list_nation_img{
    width: 100%;
    height: 60px;
    margin-bottom: 5px;
    overflow: hidden;
}
.list_nation_img img{
    width: 100%;
}
.list_nation_title{
    width: 100%;
    display: inline-block;
    text-align: center;
    font-family: inherit;
    font-size: 12px;
    text-transform: uppercase;
    margin-bottom: 10px;
    font-weight: bold;
    color: rgb(50, 50, 50);
}
.list_nation_des{
    width: 100%;
    display: inline-block;
    text-align: center;
    font-family: sans-serif;
    font-size: 12px;
    /* text-transform: uppercase; */
    line-height: 14px;
    /* color: rgb(50, 49, 49); */
}
.list_nation:last-child{
    margin-right: 0%!important;
}
</style>