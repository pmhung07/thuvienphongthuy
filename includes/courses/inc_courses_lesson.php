<?php
$var_path_libjs  = '/js/';   
$var_path_js     = '/themes/js/';
$iCourses = getValue('iCourses','int','GET',0); 
$iUnit = getValue('iUnit','int','GET',0);
$iTab = getValue('iTab','int','GET',0);

$dbCourses = new db_query("SELECT * FROM courses WHERE cou_id =".$iCourses);
$arrCourses = $dbCourses->resultArray();

$dbUnit = new db_query("SELECT * FROM courses_multi WHERE com_cou_id =".$arrCourses[0]['cou_id']." ORDER BY com_num_unit");
$arrUnit = $dbUnit->resultArray();


$dbUnitabc = new db_query("SELECT * FROM courses_multi WHERE com_id =".$iUnit);
$arrUnitabc = $dbUnitabc->resultArray();

?>

<?
$db_query_content_ques_check = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_tabs_id=".$iTab." AND cou_tab_question_type = 'recording'");
$arrContentQuesCheck = $db_query_content_ques_check->resultArray();
//var_dump($arrContentQuesCheck);
if(count($arrContentQuesCheck) > 0){
?>

<script type="text/javascript" src="<?=$var_path_js?>lesson_speak.js"></script>
<script type="text/javascript" src="<?=$var_path_libjs?>recorder.js"></script>
<script type="text/javascript" src="<?=$var_path_libjs?>swfobject.js"></script>
<script type="text/javascript" src="<?=$var_path_libjs?>gui.js"></script>
<script type="text/javascript" src="<?=$var_path_js?>duration_bar.js"></script> 

<script type="text/javascript">
    $(document).ready(function() {
        var baseurl =  'http://<?=$base_url?>';
        setup();
    });
</script> 

<?}?>

<link href="<?=$var_path_js?>/jplayer/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>-->
<script type="text/javascript" src="<?=$var_path_js?>/jplayer/jquery.jplayer.min.js"></script>

<script type="text/javascript">                                
   $(document).ready(function(){ $('a.media').media( { 'backgroundColor' : 'transparent' , width: 300, height: 20 } ); });
</script>

<div class="list-courses" style="margin-top: 10px;">
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="learn_left">
                    <div class="learn_left_title">
                        <?=$arrCourses[0]['cou_name']?>
                    </div>
                    <div class="learn_left_content">
                        <ul>
                            <?php foreach($arrUnit as $key => $value){ ?>
                            <?php // Đoạn này lấy random tab, lay tab đầu tiền
                            $dbTab = new db_query("SELECT * FROM courses_multi_tabs WHERE cou_tab_com_id =".$value['com_id']." ORDER BY cou_tab_order");
                            $arrTab = $dbTab->resultArray();
                            ?>
                            <li>
                                <?php
                                @$iUnitdata = $value['com_id'];
                                @$iTabdata = $arrTab[0]['cou_tab_id'];
                                if($iUnitdata == 0 || $iTabdata == 0){
                                    $urlDetails = "#";
                                }else{
                                    $urlDetails = gen_course_lesson($iCourses,$arrCourses[0]['cou_name'],$value['com_id'],$arrTab[0]['cou_tab_id'],$value['com_name']);
                                }
                                ?>
                                <a href="<?=$urlDetails?>">
                                    <?=$value['com_name']?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="learn_right">
                <?php
                $dbcheckucou = new db_query("SELECT * FROM user_courses WHERE uc_uid =".$myuser->u_id." AND uc_couid=".$iCourses);
                $arrrow = $dbcheckucou->resultArray();

                //if(count($arrrow) > 0 && $arrrow[0]['uc_active'] == 1 || $arrUnitabc[0]['com_num_unit'] == 1 || $myuser->user_admin == 1){
                if($myuser->user_admin != 999999){
                ?>
                    <?php if($iUnit == 0){ ?>
                        <div class="learn_right_main_blank">
                            <div class="gioithieukhoahoc">Chào mừng các bạn đến với khóa học <?=$arrCourses[0]['cou_name']?></div>
                            <div class="huongdanhoc">&bull; Bên trái là danh sách bài học trong khóa học</div>
                            <div class="huongdanhoc">&bull; Nội dung bên dưới bao gồm các bài học và luyện tập</div>
                        </div>
                    <?php }else{ ?>
                        <div class="learn_right_main">
                            <?php
                            $db_mediaUnit = new db_query("SELECT * FROM courses_multi_tab_media WHERE cou_tab_media_unit_id=".$iUnit);
                            $arrMediaUnit = $db_mediaUnit->resultArray();
                            $mainpart = 'http://'.$base_url.'/data/courses/';
                            $countMedia = count($arrMediaUnit);
                            if($countMedia != 0){
                            ?>
                            <?=get_media_library_v2($mainpart.strtolower(@$arrMediaUnit[0]['cou_tab_media_url']),'')?>
                            <?php } ?>
                        </div>
                        <div class="slider_playlist">
                            <ul>
                                <?php for($i = 0;$i < $countMedia;$i++){ ?>
                                <li style="list-style: none;padding: 10px;background-color: #5dc4db;color: white;cursor: pointer;border-bottom:solid 1px white;">
                                    <input class="vid_url" type="hidden" value="<?=$mainpart.$arrMediaUnit[$i]['cou_tab_media_url']?>">
                                    <div class="playlist_title">Nội dung video thứ <?=($i+1)?></div>    
                                </li>
                                <?}?>
                            </ul>
                            <script type="text/javascript">
                            $(".slider_playlist ul li").click(function(){
                                var baseurl = 'http://<?=$base_url?>';
                                var vid_url = $(this).children(".vid_url").val();
                                $('.learn_right_main').load(baseurl+'/ajax/load_video.php?urlVid='+vid_url);
                                return false;
                            });
                            </script>
                        </div>
                    <?php } ?>
                    <div class="learn_right_bot">
                        <ul class="nav nav-tabs">
                            <?php
                            $dbTab = new db_query("SELECT * FROM courses_multi_tabs a,courses_multi b 
                                                   WHERE a.cou_tab_com_id = b.com_id AND cou_tab_com_id=".$iUnit." ORDER BY cou_tab_order");
                            $arrTab = $dbTab->resultArray();
                            $z = 3;
                            foreach($arrTab as $keyTab=>$valuetab){
                            ?>
                                <li class="li<?=$z?> <?=($iTab != 0 && $iTab == $valuetab['cou_tab_id'])?'active':'';?>">
                                    <a href="<?=gen_course_lesson($iCourses,$arrCourses[0]['cou_name'],$iUnit,$valuetab['cou_tab_id'],$valuetab['com_name']);?>">
                                    <?=$valuetab['cou_tab_name']?>
                                    </a>
                                </li>
                            <?php $z++;} ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?=($iTab != 0)?'active':'';?>" id="tab_content">

                                <!--Hiển thị nội dung học-->

                                <?php 
                                $db_query_block = new db_query("SELECT * FROM courses_multi_tabs_block WHERE com_block_tab_id=".$iTab." ORDER BY com_block_data_order");
                                $arrBlock = $db_query_block->resultArray();
                                //var_dump($arrBlock);
                                foreach($arrBlock as $keyBlock=>$valueBlock){
                                ?>
                                <div class="learn_main_content_block">

                                    <?php
                                    if($valueBlock['com_block_data_type'] == 'content_data'){?>
                                        <div class="guideques"><?=$valueBlock['com_block_data_name']?></div>
                                        <?
                                        $db_query_content = new db_query("SELECT * FROM courses_multi_tabs_content WHERE cou_tab_cont_block_id=".$valueBlock['com_block_id']." ORDER BY cou_tab_cont_order");
                                        $arrContent = $db_query_content->resultArray();
                                        foreach($arrContent as $keyContent => $valueContent){ ?>
                                            <?php if($valueContent['cou_tab_cont_text_type'] == 1){ ?>
                                                <?php if($valueContent['cou_tab_cont_title'] != " "){ ?>
                                                    <div class="learn_main_content_title">
                                                        <?=removeHTML($valueContent['cou_tab_cont_title'])?>
                                                    </div>
                                                <?php } ?>

                                                <?php if($valueContent['cou_tab_cont_text'] != " "){ ?>
                                                    <div class="learn_main_content_text">
                                                        <?=$valueContent['cou_tab_cont_text']?>
                                                    </div>
                                                <?php } ?>

                                                <?php if($valueContent['cou_tab_cont_media'] != ""){ ?>
                                                    <div class="learn_main_content_media">
                                                        <?php if($valueContent['cou_tab_cont_media_type'] == 1){ ?>
                                                            <?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
                                                            <?=get_media_library_v2($mainpart.strtolower($valueContent['cou_tab_cont_media']),'')?>
                                                        <?php } ?>

                                                        <?php if($valueContent['cou_tab_cont_media_type'] == 2){ ?>
                                                            <?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
                                                            <?
                                                            $urlfile = getURL(1,0,0,0).'data/courses/'.$valueContent['cou_tab_cont_media'];
                                                            $ref = "c".$valueContent['cou_tab_cont_id'];
                                                            $showaudio = showaudio($urlfile,$ref);
                                                            echo $showaudio;
                                                            ?>
                                                        <?php } ?>

                                                        <?php if($valueContent['cou_tab_cont_media_type'] == 3){ ?>
                                                            <?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
                                                            <img src="<?=$mainpart.$valueContent['cou_tab_cont_media']?>">
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>

                                            <?php if($valueContent['cou_tab_cont_text_type'] == 2){ ?>
                                                <div class="voc_detail">
                                                    <div class="voc_content">
                                                        <p class="tt_box_left_lb"><?=$valueContent['cou_tab_cont_main_voca']?></p>
                                                        <?
                                                        $urlfile = getURL(1,0,0,0).'data/courses/'.$valueContent['cou_tab_cont_audio_voca'];
                                                        $ref = "c".$valueContent['cou_tab_cont_id'];
                                                        $showaudio = showaudio($urlfile,$ref);
                                                        echo $showaudio;
                                                        ?>
                                                        <!--END TEST-->
                                                        <p class="phonetic"><?=$valueContent['cou_tab_cont_phonetic_voca']?><br /></p>
                                                        <p class="voc_eg">Eg(vd): <?=$valueContent['cou_tab_cont_exam_voca']?></p>
                                                    </div>              
                                                    <div class="voc_img">
                                                        <?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
                                                        <img width="130px" height="90px"  src="<?=$mainpart.$valueContent['cou_tab_cont_img_voca']?>">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?> 
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane <?=($iTab == 0)?'active':'';?>" id="tab1">
                                <?php include_once('../includes/inc_sidebar_faq.php');?>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <?php include_once('../includes/inc_sidebar_thanks.php');?>
                            </div>
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="wrap-log-login-payment">
                        <div class="notice-payment">Bạn cần <a href="http://<?=$base_url?>/payment.html"><span>mua khóa học</span></a> để có thể học được khóa học này.</div>
                    </div>
                <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function sendwriting(question_id){
        var baseurl =  'http://<?=$base_url?>';
            <?php if($myuser->logged == 1){?>
            var uid = <?=$myuser->u_id?>;
            var contentwriting = $(".sendwritinguser_"+question_id).val();
            if($.trim(contentwriting) != ""){
                $.ajax({
                    type : 'POST',                    
                    data : {
                        type : "request_writing", 
                        uid : uid,
                        question_id     : question_id, 
                        contentwriting  : contentwriting,
                    },
                    url  : 'http://<?=$base_url?>/ajax/request.php',
                    success:function(data){
                        if($.trim(data) == 1){
                            alert('Nội dung bài tập của bạn đã được gửi đi. Giáo viên sẽ chấm điểm và gửi kêt quả cho bạn trong thời gian sớm nhất');   
                            window.location.reload();
                        }else{
                            alert('Xảy ra lỗi trong quá trình xử lý');
                        }
                    }
                });
            }else{
                alert("Bạn vui lòng viết bài");
                return false;
            }
        <?php }else{ ?>     
            alert("Bạn vui lòng đăng nhập để tiến hành gửi bài");
            return false;
        <?}?>                 
    }          
</script>

<script type="text/javascript">
function request_recording(question_id){
    var baseurl =  'http://<?=$base_url?>';
    <?php if($myuser->logged == 1){ ?>
        var uid = <?=$myuser->u_id?>;
        $.ajax({
            type : 'POST',                    
            data : {
                type : "request_recording", 
                uid : uid,
                question_id : question_id, 
                strname : strname
            },
            url  : 'http://<?=$base_url?>/ajax/request.php',
            success:function(data){
                if($.trim(data) == 1){
                    alert('Nội dung bài tập của bạn đã được gửi đi. Giáo viên sẽ chấm điểm và gửi kêt quả cho bạn trong thời gian sớm nhất');   
                    window.location.reload();
                }else{
                    alert('Xảy ra lỗi trong quá trình xử lý');
                    window.location.reload();
                }
            }
        });
    <?php }else{ ?>     
        alert("Bạn vui lòng đăng nhập để tiến hành gửi bài");
        return false;
    <?php } ?>                    
}
</script>