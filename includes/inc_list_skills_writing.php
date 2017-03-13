<?php
// $arrSkill : ARRAY SAVE INFO skill_lesson table
$iLes       = $arrSkill[0]['skl_les_id'];
?>
<div class="main in_content">
   <div class="main_bl">
        <div class="main_sk_content white_tab" id="main_writing">
        <?php
        $dbChk = new db_query('SELECT * FROM skill_content WHERE skl_cont_les_id = '.$iLes.' AND skl_cont_pos = 1 AND skl_cont_active = 1 AND skl_cont_mark = 0 ORDER BY skl_cont_order ASC');
        $num   = mysqli_num_rows($dbChk->result);
        unset($dbChk);
        if($num > 0){
        ?>
            <div class="tab_m">
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active" class="li1"><a href="#tab1" data-toggle="tab">Lý thuyết</a></li>
                        <li class="li2"><a href="#tab2" data-toggle="tab">Luyện tập</a></li>
                    </ul><!-- End .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <?php include_once('inc_list_skills_content.php') ?>
                        </div><!-- End #tab1 -->
                        <div class="tab-pane" id="tab2">
                        <?php
                        $dbCont     = new db_query('SELECT * FROM skill_content WHERE skl_cont_les_id = '.$iLes.' AND skl_cont_pos = 1 AND skl_cont_active = 1 AND skl_cont_mark <> 0 ORDER BY skl_cont_order ASC');
                        while($rowCont = mysqli_fetch_assoc($dbCont->result)){
                            if($rowCont['skl_cont_type'] == 4){
                                $sqlWri     = new db_query('SELECT * FROM learn_writing WHERE learn_skl_cont_id = '.$rowCont["skl_cont_id"]);
                                $rowWri     = mysqli_fetch_assoc($sqlWri->result);
                                unset($sqlWri); ?>
                                <div class="bot_left_lightbox">
                          		    <div>Câu hỏi</div>
                                    <div><?=$rowWri['learn_wr_ques']?></div>
                                    <?php if($rowWri['learn_wr_content'] != ''){ ?>
                                        <div><?=$rowWri['learn_wr_content']?></div>
                                    <?php } ?>
                          	    </div><!-- End .bot_left_lightbox -->
                                <div class="top_left_lightbox">
                  		        <?php
                  			        $wripart = 'http://'.$base_url.'/data/skill_content/';
                  			        if($rowWri['learn_wr_media'] != ''){
                  			            if($rowWri['learn_wr_mtype'] == 1){ ?>
                  		                    <center><img src="<?=$wripart.$rowWri['learn_wr_media']?>"/></center>
                  		                <?php }elseif($rowWri['learn_wr_mtype'] == 2){ ?>
                                            <?php
                                            $file   =   $wripart.$rowWri['learn_wr_media'];
                                            get_media_library_v2($file,'');
                                            ?>
                  		                <?php } ?>
                  			        <?php } ?>
                  	            </div><!-- End .top_left_lightbox -->
                        <?php } }unset($dbCont); ?>

                        <div class="lesson-content-block">
                            <input type="hidden" id="id_wr" value="<?=$iLes?>"/>
     						<textarea id="input_text" class="input-block-level" rows="20" placeholder="Nhập bài viết của bạn"></textarea>
     						<div class="line_button">
     							<div class="orange_button submit_me pull-right_result">Gửi bài</div>
                                <?php if($rowWri['learn_wr_note'] != ''){ ?>
                                    <div class="cyan_button" id="goi_y">Gợi ý</div>
                                <?php } ?>
     						</div>
               			</div>

                        <?php if($rowWri['learn_wr_note'] != ''){ ?>
                            <div class="noi_dung_goi_y"><?php echo $rowWri['learn_wr_note']?></div>
                            <script type="text/javascript">
                               $(document).ready(function(){
                                  $('#goi_y').toggle(function(){
                                     $(this).addClass('active');
                                     $('.noi_dung_goi_y').show();
                                  },function(){
                                     $('.noi_dung_goi_y').hide();
                                     $(this).removeClass('active');
                                  });
                               });
                            </script>
                        <?php } ?>
                        </div><!-- End #tab2 -->
                    </div><!-- End .tab-content -->
                </div>
            </div><!-- End .tab_m -->

        <?php }else{ ?>
            <div class="content_bl no_border">
            <?php
            $dbCont = new db_query('SELECT * FROM skill_content WHERE skl_cont_les_id = '.$iLes.' AND skl_cont_pos = 1 AND skl_cont_active = 1 ORDER BY skl_cont_order ASC');
            while($rowCont = mysqli_fetch_assoc($dbCont->result)){
                if($rowCont['skl_cont_type'] == 4){
                    $sqlWri     = new db_query("SELECT * FROM learn_writing WHERE learn_skl_cont_id = ".$rowCont['skl_cont_id']);
                    $rowWri     = mysqli_fetch_assoc($sqlWri->result);
                    unset($sqlWri);
                    if($rowCont['skl_cont_type'] == 4){
                        $sqlWri     = new db_query("SELECT * FROM learn_writing WHERE learn_skl_cont_id = ".$rowCont['skl_cont_id']);
                        $rowWri     = mysqli_fetch_assoc($sqlWri->result);
                        unset($sqlWri);
                        ?>
                        <div class="bot_left_lightbox">
                  		    <div style="font-size: 16px;font-weight: bold;margin: 5px 0px; border-bottom: 1px dotted #666">Câu hỏi</div>
                            <div style="font-size: 12px; font-weight:bold;"><?=$rowWri['learn_wr_ques']?></div>
                            <?php if($rowWri['learn_wr_content'] != ''){ ?>
                                <div style="font-size: 12px;"><?=$rowWri['learn_wr_content']?></div>
                            <?php } ?>
                  	    </div><!-- End .bot_left_lightbox -->
                        <div class="top_left_lightbox" style="margin-bottom: 15px;">
                  		<?php
                  			$wripart = 'http://'.$base_url.'/data/skill_content/';
                  			if($rowWri['learn_wr_media'] != ''){
                  			    if($rowWri['learn_wr_mtype'] == 1){ ?>
                  		            <center><img style="max-width:420px" src="<?=$wripart.$rowWri['learn_wr_media']?>"/></center>
                  		        <?php }elseif($rowWri['learn_wr_mtype'] == 2){ ?>
                                    <?php
                                    $file   = $wripart.$rowWri['learn_wr_media'];
                                    get_media_library_v2($file,'');
                                    ?>
                  		        <?php } ?>
                  			<?php } ?>
                  		?>
                  	    </div><!-- End .top_left_lightbox -->
                    <?php } ?>
                <?php } ?>
            <?php }unset($db_cont); ?>
            ?>
            <div class="lesson-content-block">
                <input type="hidden" id="id_wr" value="<?=$iles?>"/>
        		<textarea id="input_text" class="input-block-level" rows="20" placeholder="Nhập bài viết của bạn"></textarea>
        		<div class="line_button">
            		<div class="orange_button submit_me">Gửi bài</div>
                    <?php if($rowWri['learn_wr_note'] != ''){ ?>
                    <div class="cyan_button" id="goi_y">Gợi ý</div>
                    <?php } ?>
        		</div>
        	</div>
            <?php if($rowWri['learn_wr_note'] != ''){ ?>
                <div class="noi_dung_goi_y"><?php echo $rowWri['learn_wr_note']?></div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('#goi_y').toggle(function(){
                        $(this).addClass('active');
                        $('.noi_dung_goi_y').show();
                        },function(){
                            $('.noi_dung_goi_y').hide();
                            $(this).removeClass('active');
                        });
                    });
                </script>
            <?php } ?>
            </div><!-- End .content_bl -->
        <?php } ?>
        </div><!-- end .main_bl -->
    </div><!-- End main in_content -->
</div>