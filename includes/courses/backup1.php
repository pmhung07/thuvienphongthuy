<?php

$iCourses = getValue('iCourses','int','GET',0);
$iUnit = getValue('iUnit','int','GET',0);
$iTab = getValue('iTab','int','GET',0);

$dbCourses = new db_query("SELECT * FROM courses WHERE cou_id =".$iCourses);
$arrCourses = $dbCourses->resultArray();

$dbUnit = new db_query("SELECT * FROM courses_multi WHERE com_cou_id =".$arrCourses[0]['cou_id']);
$arrUnit = $dbUnit->resultArray();

?>

<div class="list-courses">
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
					<?php } ?>
					<div class="learn_right_bot">
						<ul class="nav nav-tabs">
				    		<li class="<?=($iTab == 0)?'active':'';?> li1"><a href="#tab1" data-toggle="tab">Questions</a></li>
				    		<li class="li2"><a href="#tab2" data-toggle="tab">Tip & Thanks</a></li>
				    		<?php
				    		$dbTab = new db_query("SELECT * FROM courses_multi_tabs a,courses_multi b
				    							   WHERE a.cou_tab_com_id = b.com_id AND cou_tab_com_id=".$iUnit);
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
									if($valueBlock['com_block_data_type'] == 'content_data'){
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

										<?php
										$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'draganddrop' ORDER BY cou_tab_question_order");
										$arrContentQues = $db_query_content_ques->resultArray();
										foreach($arrContentQues as $keyContentQuest => $valueContentQuest){ ?>
											<?php if($valueContentQuest['cou_tab_question_title'] != ""){ ?>
												<div class="learn_main_content_title">
													<?=removeHTML($valueContentQuest['cou_tab_question_title'])?>
												</div>
											<?php } ?>

											<?php if($valueContentQuest['cou_tab_question_content'] != ""){ ?>

			        						<?php
			        						$arrayAns  = getStringAns(removeHTML($valueContentQuest['cou_tab_question_content']));
			        						$result    = count($arrayAns);
			        						$rand_keys = array_random($arrayAns, $result);
			        						?>
			        						&nbsp;
			        						<ul class="menu_quiz">
			        							<?php for($i=0;$i<$result;$i++){?>
			        								<a href="#" ><?=$i+1?>.<span id="draggable<?=$i+1?>"><?=trim($rand_keys[$i])?></span></a>
			        							<?php } ?>
			        						</ul>
			        						<div class="tip_learn_main_content_title">
												Chọn đáp án thich hợp ở trên và điền vào chỗ trống
											</div>
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
										<?php
										$in = 0;
										$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'multiplechoice' ORDER BY cou_tab_question_order");
										$arrContentQues = $db_query_content_ques->resultArray();
										foreach($arrContentQues as $keyContentQuest => $valueContentQuest){ $in++;?>
											<?php if($valueContentQuest['cou_tab_question_title'] != ""){ ?>
												<div class="learn_main_content_title">
													<?=removeHTML($valueContentQuest['cou_tab_question_title'])?>
												</div>
											<?php } ?>

											<?php if($valueContentQuest['cou_tab_question_content'] != ""){ ?>
												<div class="learn_main_content_text">
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
			        				            <?php }
			        						    echo '</div>';?>


											<?php } ?>
										<?php } ?>

									<?php }else if($valueBlock['com_block_data_type'] == 'question_writing'){ ?>
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
													<?=removeHTML($valueContentQuest['cou_tab_question_content'])?>
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
								<?}?>
							</div>
				    		<div class="tab-pane <?=($iTab == 0)?'active':'';?>" id="tab1">

				    			<div class="question-learn-here">
				    				<textarea placeholder="Đặt câu hỏi tại đây"></textarea>
				    			</div>

								<div class="learn_right_question">
									In this example the Total Revenue is maximum when the elasticity of demand is unity, is this example specific or does it happen in any scenario? I mean, does the total revenue peak whenever the elasticity of demand is one and vice versa?
									<div class="learn_right_question_tool">
										16/4/2015 by HungPham
									</div>
								</div>
								<div class="learn_right_answers">
									Good question! Short answer: Yes! When the elasticity of demand equals 1, the Total Revenue is ALWAYS at a maximum.
									Long answer: If you're familiar with Differential Calculus, this fact is easy to prove because Total Revenue = Price x Quantity Demanded (which is the same as saying Price x Amount sold) and the maximum amount of Revenue occurs at the point where the derivative of Total Revenue with respect to Price is zero. Then, rearranging the terms gives us a definition of elasticity of demand.
									<div class="learn_right_answers_tool">
										16/4/2015 by HungPham
									</div>
								</div>
								<div class="learn_right_answers">
									Good question! Short answer: Yes! When the elasticity of demand equals 1, the Total Revenue is ALWAYS at a maximum.
									Long answer: If you're familiar with Differential Calculus, this fact is easy to prove because Total Revenue = Price x Quantity Demanded (which is the same as saying Price x Amount sold) and the maximum amount of Revenue occurs at the point where the derivative of Total Revenue with respect to Price is zero. Then, rearranging the terms gives us a definition of elasticity of demand.
									<div class="learn_right_answers_tool">
										16/4/2015 by HungPham
									</div>
								</div>
								<div class="learn_right_answers">
									<div class="answers-learn-here">
					    				<textarea placeholder="Viết câu trả lời"></textarea>
					    			</div>
					    		</div>

				    		</div>
				            <div class="tab-pane" id="tab2">
				              	<div class="question-learn-here">
				    				<textarea placeholder="Viết một lời cảm ơn"></textarea>
				    			</div>

								<div class="learn_right_question_thanks">
									YOU ARE AMAZING!!!
									<div class="learn_right_question_tool">
										16/4/2015 by HungPham
									</div>
								</div>
								<div class="learn_right_question_thanks">
									Thanks a lot Sal. I love the way you simplify every concept to make everyone understand.
									<div class="learn_right_question_tool">
										16/4/2015 by HungPham
									</div>
								</div>
								<div class="learn_right_question_thanks">
									This is called the Revenue Test.
									If price and total revenue move in the same directions, the curve is inelastic.
									If price and total revenue move in opposite directions, the curve is elastic.
									If total revenue barely changes or does not change, the curve is unit elastic.
									<div class="learn_right_question_tool">
										16/4/2015 by HungPham
									</div>
								</div>
								<div class="learn_right_question_thanks">
									gracias !
									<div class="learn_right_question_tool">
										16/4/2015 by HungPham
									</div>
								</div>
								<div class="learn_right_question_thanks">
									Use calculus for Pete's sake! (><) Please identify the audience already; do we know calculus or not? If yes, please spare us the 10 minutes here with one simple equation. Thanks a lot though :))
									<div class="learn_right_question_tool">
										16/4/2015 by HungPham
									</div>
								</div>
				            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>