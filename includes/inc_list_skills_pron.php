<?php
// $arrSkill : ARRAY SAVE INFO skill_lesson table
$iLes       = $arrSkill[0]['skl_les_id'];
?>
<div class="main in_content">
	<?php include_once('inc_list_skills_content.php') ?>
    
    <div class="main_bl">
        <div class="main_sk_content white_tab" id="main_pron">
            <div class="guide">Giả lập nghe nói với người bản ngữ. Bạn hãy xem Video để nghe câu hỏi & bấm vào nút &nbsp;<img src="<?=$var_path_img?>/start_record.jpg" /> &nbsp; ghi âm câu trả lời.</div>
            <div class="content_bl no_border">
                <?//include_once('inc_top_les.php')?>
            </div>
            <div class="tab_m">
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active" class="li1"><a href="#tab1" data-toggle="tab">Luyện tập</a></li>
                        <li class="li2"><a href="#tab2" data-toggle="tab">Từ mới</a></li>
                        <li class="li3"><a href="#tab3" data-toggle="tab">Bài tập</a></li>
                        <li class="li4"><a href="#tab4" data-toggle="tab">Games</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <?php
                            $dbCont = new db_query('SELECT * FROM skill_content WHERE skl_cont_les_id = '.$iLes.' AND skl_cont_pos = 1 AND skl_cont_active = 1 ORDER BY skl_cont_order ASC');
                            while($rowCont = mysql_fetch_assoc($dbCont->result)){
                                echo '<div class="cont_cont">'.$rowCont['skl_content'].'</div>';
                                $sqlMain = new db_query('SElECT * FROM main_lesson WHERE main_skl_cont_id = '.$rowCont["skl_cont_id"].' ORDER BY main_order');
                                $mainpart = 'http://'.$base_url.'/data/skill_content/';
                                $i = 0;
                                while($rowMain  = mysql_fetch_assoc($sqlMain->result)){
                                $i++;
                                    if($rowMain['main_media_type'] == 2){ ?>
                                        <div class="video_lesson">
                                            <div class="player">
                                                <?php 
                                                $file   = $mainpart.$rowMain['main_media_url1'];
                                                get_media_skill_v2($file,$i); 
                                                ?>
                                            </div><!-- End .player -->
                                            <div class="script_box">
                                                <div class="lib-tool-translate">
                                                    <span class="tool-translate-trans">Xem bản dịch</span>
                                                </div>
                                                <div class="lib-trans">
                                                    <?=getMainCTran($rowMain['main_content_en'],$rowMain['main_content_vi'])?>
                                                </div>   
                                            </div>
                                        </div><!-- End .video_lesson -->
                                    <?php } ?>
                                <?php }unset($sqlMain); ?>
                            <?php }unset($dbCont); ?>

                            <!--<div class="content_bl no_border">
                                <div class="rc_guide">
                                    <div>Bấm <img  class="pic" src="<?//=$var_path_img?>/start_record.jpg" alt="start_record"/> để thu âm bài nói của bạn. Bấm <img class="pic" src="<?//=$var_path_img?>/stop_record.jpg"  alt="stop_record"/> để dừng bài thu âm.</div>
                                    <div>Bấm <img  class="pic1" src="<?//=$var_path_img?>/au.png" alt="audio"/>  và Bấm <img  class="pic" src="<?//=$var_path_img?>/play_button.jpg" alt="play"/> để chọn và nghe lại bài thu âm của bạn.</div>
                                    <div>Bạn có thể nghe lại nhiều lần và chọn bản thu âm <img  class="pic1" src="<?//=$var_path_img?>/au_selected.png"  alt="select"/> ưng ý nhất để nộp bài.</div>
                                </div>
                                <div class="record_land">
                                    <div id="wami"></div>
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
                                <div class="lesson-content-block">
                                    <input type="hidden" id="id_sp" value="<?//=$iles?>"/>
                                    <textarea id="script_spk" class="input-block-level" rows="7" placeholder="Nội dung bài nói của bạn"></textarea>
                          			<div class="line_button">
                          				<div class="orange_button submit_me" id="post_script">Hoàn thành</div>
                          			</div>
                                </div>
                            </div>-->
                        </div><!-- End #tab1 -->
                        <div class="tab-pane" id="tab2">
                            <?include_once('inc_list_skills_vocabulary.php');?>
                        </div><!-- End #tab2 -->
                        <div class="tab-pane" id="tab3">
                            <?include_once('inc_list_skills_quiz.php');?>
                        </div><!-- End #tab3 -->
                        <div class="tab-pane" id="tab4">
                            <?include_once('inc_list_skills_game.php');?>
                        </div><!-- End #tab4 -->
                    </div><!-- End .tab-content -->
                </div>
            </div><!-- End .tab_m -->
        </div><!-- end .wrap_faq -->
    </div><!-- end .main_bl -->
</div><!-- End main in_content -->