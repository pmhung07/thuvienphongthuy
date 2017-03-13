<?php
$var_path_libjs  = '/js/';
$var_path_js     = '/themes/js/';
$iCourses = getValue('iCourses','int','GET',0);
$iUnit = getValue('iUnit','int','GET',0);
$iTab = getValue('iTab','int','GET',0);

$dbCourses = new db_query("SELECT * FROM courses WHERE cou_id =".$iCourses);
$arrCourses = $dbCourses->resultArray();

$dbUnit = new db_query("SELECT * FROM courses_multi WHERE com_cou_id =".$arrCourses[0]['cou_id']);
$arrUnit = $dbUnit->resultArray();

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

<div class="list-courses">
	<div class="list-courses-main">
		<div class="breadcrumbcrop">
	        <div class="content">
	            <div class="content-main">
	                <a>Trang chủ</a>
	                <span>»</span>
	                <a><?=$arrCourses[0]['cou_name']?></a>
	            </div>
	        </div>
	    </div>
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
							$dbTab = new db_query("SELECT * FROM courses_multi_tabs WHERE cou_tab_com_id =".$value['com_id']);
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
					<?php if($iUnit == 0){ ?>
						<div class="learn_right_main_blank">
							<div class="gioithieukhoahoc">Chào mừng các bạn đến với khóa học <?=$arrCourses[0]['cou_name']?></div>
							<div class="huongdanhoc">&bull; Bên trái là danh sách bài học trong khóa học</div>
							<div class="huongdanhoc">&bull; Nội dung bên dưới bao gồm các bài học và luyện tập</div>
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
											<?php if($valueContent['cou_tab_cont_title'] != ""){ ?>
												<div class="learn_main_content_title">
													<?=removeHTML($valueContent['cou_tab_cont_title'])?>
												</div>
											<?php } ?>

											<?php if($valueContent['cou_tab_cont_text'] != ""){ ?>
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
														<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="25" height="20"
						                                    codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab">
						                                    <param name="movie" value="http://<?=$base_url?>/themes/media/singlemp3player.swf?file=http://<?=$base_url?>/data/courses/<?=$valueContent['cou_tab_cont_media']?>&backColor=990000&frontColor=ddddff&repeatPlay=false&songVolume=90" />
						                                    <param name="wmode" value="transparent" />
						                                    <embed wmode="transparent" width="25" height="20" src="http://<?=$base_url?>/themes/media/singlemp3player.swf?file=http://<?=$base_url?>/data/vocabulary/<?=$rowVoc['voc_audio_url']?>&backColor=990000&frontColor=ddddff&repeatPlay=false&songVolume=90"
						                                    type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
						                                </object>
													<?php } ?>

													<?php if($valueContent['cou_tab_cont_media_type'] == 3){ ?>
														<?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
														<img src="<?=$mainpart.$valueContent['cou_tab_cont_media']?>">
													<?php } ?>
												</div>
											<?php } ?>
										<?}
									}else if($valueBlock['com_block_data_type'] == 'question_matching'){ ?>
										<div class="guideques"><?=$valueBlock['com_block_data_name']?></div>
										<?php
										$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'matching' ORDER BY cou_tab_question_order");
										$arrContentQues = $db_query_content_ques->resultArray();
										foreach($arrContentQues as $keyContentQuest => $valueContentQuest){ ?>
											<?php if($valueContentQuest['cou_tab_question_title'] != ""){ ?>
												<div class="learn_main_content_title">
													<?=removeHTML($valueContentQuest['cou_tab_question_title'])?>
												</div>
											<?php } ?>

											<?php if($valueContentQuest['cou_tab_question_content'] != ""){ ?>
												<div class="learn_main_content_text">
													<?
													$arrayCont  =  getMainC($valueContentQuest['cou_tab_question_content']);
           						    				$cArrayCont =  count($arrayCont);
													?>
													<div class="ques_matching">
													<?php
			                                        $j = 0;
			                                        for($i=0;$i<$cArrayCont;$i++){
			                                            if($i%2 != 0) {
			                                                $j ++;
			                                                echo '<input type=text value=""/>';
			                                            }else{
			                                   	            echo $arrayCont[$i];
			                                            }
			                                        } ?>
			                                        </div>

												</div>
											<?php } ?>
										<?php } ?>

									<?php }else if($valueBlock['com_block_data_type'] == 'question_multiplechoice'){ ?>
										<div class="guideques">Hãy chọn đáp án đúng trong mỗi câu hỏi</div>
										<?php
										$in = 0;
										$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'multiplechoice' ORDER BY cou_tab_question_order");
										$arrContentQues = $db_query_content_ques->resultArray();
										foreach($arrContentQues as $keyContentQuest => $valueContentQuest){ $in++;?>
											<?php if($valueContentQuest['cou_tab_question_content'] != ""){ ?>
											<div class="wrap_ques_multiplechoice">
												<div class="tip_learn_main_content_title">
													<?=removeHTML($valueContentQuest['cou_tab_question_content'])?>
												</div>
												<?php
			           							$sqlAns    = new db_query("SELECT * FROM courses_multi_tab_answers WHERE cou_tab_answer_question_id = ".$valueContentQuest['cou_tab_question_id']);
			           							$arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
			           							$iA        = 0;
			           							while($rowAns = mysqli_fetch_assoc($sqlAns->result)){
			              							$iA ++;	?>
			           						            <div class="check_box-muc">
			                                                <input id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" value="<?=$rowAns['cou_tab_answer_true']?>" />
			                                                <label for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>. <?=$rowAns['cou_tab_answer_content']?></label>
			                                            </div>
			        				            <?php } ?>
											<?php } ?>
											</div>
										<?php } ?>

									<?php }else if($valueBlock['com_block_data_type'] == 'question_writing'){ ?>
										<div class="guideques"><?=$valueBlock['com_block_data_name']?></div>
										<?php
										$in = 0;
										$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'writing' ORDER BY cou_tab_question_order");
										$arrContentQues = $db_query_content_ques->resultArray();
										foreach($arrContentQues as $keyContentQuest => $valueContentQuest){ $in++;?>
											<?php if($valueContentQuest['cou_tab_question_title'] != ""){ ?>
												<div class="learn_main_content_title">
													<?=removeHTML($valueContentQuest['cou_tab_question_title'])?>
												</div>
											<?php } ?>

											<?php if($valueContentQuest['cou_tab_question_content'] != ""){ ?>
												<div class="learn_main_content_text">
													<?=($valueContentQuest['cou_tab_question_content'])?>
												</div>
											<?php } ?>
											<div class="sendwriteuserdetails">
												<textarea class="sendwriteuser">

												</textarea>
												<span class="requestsendwrite">
													Gửi bài
												</span>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>