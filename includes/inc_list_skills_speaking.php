<?php
// $arrSkill : ARRAY SAVE INFO skill_lesson table
$iLes       = $arrSkill[0]['skl_les_id'];
?>
<div class="main in_content">
    <div class="main_bl">
        <div class="main_sk_content" id="main_speaking">
            <div class="content_bl no_border">

            <?php
            $dbCont = new db_query('SELECT * FROM skill_content WHERE skl_cont_les_id = '.$iLes.' AND skl_cont_pos = 1 AND skl_cont_active = 1 ORDER BY skl_cont_order ASC');
            while($rowCont = mysql_fetch_assoc($dbCont->result)){
                $content = trim($rowCont['skl_content']);
                if($content != ''){
                    echo '<div class="guide">'.removeHTML($content).'</div>';
                }else{
                    echo '<div class="guide">'.removeHTMl($arrSkill[0]['skl_les_desc']).'</div>';
                } 
                $sqlMain = new db_query("SElECT * FROM main_lesson WHERE main_skl_cont_id = ".$rowCont['skl_cont_id']." ORDER BY main_order");
                $mainpart = 'http://'.$base_url.'/data/skill_content/';
                $i = 0;
                while($rowMain  = mysql_fetch_assoc($sqlMain->result)){
                    $i++;
                    if($rowMain['main_media_type'] == 2){
                    ?>
                    <div class="video_lesson">
                        
                        <?php 
                        $file   = $mainpart.$rowMain['main_media_url1'];
                        get_media_skill_v2($file,$i); 
                        ?>

                        <div class="script_box">
                            <div style="clear: both;"></div>
                            <div class="scroll_script">
                                <div class="lib-tool-translate">
                                    <span class="tool-translate-trans">Xem bản dịch</span>
                                </div>
                                <div class="lib-trans">
                                    <?=getMainCTran($rowMain['main_content_en'],$rowMain['main_content_vi'])?>
                                </div>   
                            </div>
                        </div>
                    </div>

                    <?php }elseif($rowMain['main_media_type'] == 1){
                        $goi_y = getMainCNoTr($rowMain['main_content_en']); ?>
                            <center><img src="<?=$mainpart?>medium_<?=$rowMain['main_media_url1']?>" /></center>
                    <?php }
                }unset($sqlMain);
            }unset($dbCont); ?>

            </div>

            <!--<div class="content_bl">
                <div class="rc_guide">
                    <div>Bấm <img  class="pic" src="<?=$var_path_img?>/start_record.jpg" alt="start_record"/> để thu âm bài nói của bạn. Bấm <img class="pic" src="<?=$var_path_img?>/stop_record.jpg"  alt="stop_record"/> để dừng bài thu âm.</div>
                    <div>Bấm <img  class="pic1" src="<?=$var_path_img?>/au.png" alt="audio"/>  và Bấm <img  class="pic" src="<?=$var_path_img?>/play_button.jpg" alt="play"/> để chọn và nghe lại bài thu âm của bạn.</div>
                    <div>Bạn có thể ghi âm nhiều lần và chọn bản thu âm <img  class="pic1" src="<?=$var_path_img?>/au_selected.png"  alt="selected"/> ưng ý nhất để nộp bài.</div>
                </div>
                <div class="record_land">
                    <div id="wami" style=""></div>
                    <div class="remain">
                        <div id="loaded" class="loaded"><div class="end"></div></div>
                    </div>
                    <div class="tool_bar">
                        <?//php if($myuser->logged == 1){ ?>
                            <div class="tb btn_start_record"></div>
                        <?//php }else{ ?>
                            <a class="tb btn_start_record" rel="nofollow" onclick="idvg_popup()"></a>
                        <?//php } ?>
                        <div class="tb btn_stop_record"></div>
                        <div class="tb btn_start_play"></div>
                        <div class="tb btn_stop_play"></div>
                     
                        <div class="speaker"></div>
                        <div class="list_au">
                            <div class="au au5">05</div>
                            <div class="au au4">04</div>
                            <div class="au au3">03</div>
                            <div class="au au2 au_selected">02</div>
                            <div class="au au1">01</div>
                        </div>
                    </div>
                </div>
                <div class="lesson-content-block" style="margin-bottom: 0px;">
                    <input type="hidden" id="id_sp" value="<?//=$iLes?>"/>
         			<textarea id="script_spk" class="input-block-level" rows="7" placeholder="Nội dung bài nói của bạn"></textarea>
         			<div class="line_button">
             			<div class="orange_button submit_me pull-right_result" id="post_script">Hoàn thành</div>
                        <?//php if(@$goi_y != ''){ ?>
                            <div class="cyan_button" id="suggest_btn" style="float: left; width: 110px">Gợi ý</div>
                        <?//php } ?>
                        <div class="clearfix"></div>
         			</div>
                </div>
                <?//php if(@$goi_y != ''){ ?>
                    <div id="suggest_text" class="guide" style="display: none;"><?//=@$goi_y?></div>
                <?//php } ?>
            </div>-->
        </div><!-- end .wrap_faq -->
    </div><!-- end .main_bl -->
</div><!-- End main in_content -->