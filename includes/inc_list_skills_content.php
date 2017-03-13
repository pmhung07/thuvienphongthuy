<?php
// $arrSkill : ARRAY SAVE INFO skill_lesson table
$iLes       = $arrSkill[0]['skl_les_id'];
$gram_path  = 'http://'.$base_url.'/data/skill_content/';
?>
<div class="box1">
    <div class="box1_scroll">
    <?php
        $dbCont = new db_query('SELECT * FROM skill_content WHERE skl_cont_les_id = '.$iLes.' AND skl_cont_pos = 1 AND skl_cont_active = 1 AND skl_cont_mark = 0 ORDER BY skl_cont_order ASC');
        while($rowCont = mysqli_fetch_assoc($dbCont->result)){
        //Ở Box 1 lặp qua từng content có vị trí hiển thị là box 1, check kiểu content: chấp nhận kiểu 1,2,4.
        if($rowCont['skl_cont_type'] == 1){
            $sqlMain    = new db_query('SElECT * FROM main_lesson WHERE main_skl_cont_id = '.$rowCont['skl_cont_id'].' ORDER BY main_order');
            $mainpart   = 'http://'.$base_url.'/data/skill_content/';
		    $i = 0;
		    while($rowMain  = mysqli_fetch_assoc($sqlMain->result)){
    		    $i++; ?>
          	    <div class="media_content_main">

                <?php if($rowMain['main_media_type'] == 1){ ?>

                    <center><img src="<?=$mainpart?>medium_<?=$rowMain['main_media_url1']?>" /></center>

                <?php }else if($rowMain['main_media_type'] == 2){ ?>

                    <?php
                    $file   =   $wripart.$rowWri['learn_wr_media'];
                    get_media_skill_v2($file,$i);
                    ?>

                <?php }elseif($rowMain['main_media_type'] == 3){
                    echo "<center><object width='491' height='400'><embed src='". $mainpart.$rowMain['main_media_url1']."' width='491' height='400' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' menu='false' wmode='transparent'></embed></object></center>";
                }

                if($rowMain['main_type'] == 0){ ?>
                    <div class="script" style="width: 250px; margin: 10px auto; padding-left:0px;"><a title="Xem Script" class="script_btn_v2 script_<?=$i?> act_button">Nội dung</a>
                    <a class="icon_dich_lb_v2 button_dich act_button" href="javascript:;">Dịch</a></div>
                <?php }elseif($rowMain['main_type'] == 2){ ?>
                    <div class="script" style="width: 120px; margin: 10px auto; padding-left:0px;"><a class="icon_dich_lb_v2 button_dich act_button">Dịch</a></div>
                <?php } ?>

                </div>

                <div class="bot_left_lightbox">
                    <?php if($rowMain['main_type'] == 0){ ?>
                        <div class="lib-tool-translate">
                            <span class="tool-translate-trans">Xem bản dịch</span>
                        </div>
                        <div class="lib-trans">
                            <?=getMainCTran($rowMain['main_content_en'],$rowMain['main_content_vi'])?>
                        </div>

                    <?php }else{ ?>
                        <div class="lib-tool-translate">
                            <span class="tool-translate-trans">Xem bản dịch</span>
                        </div>
                        <div class="lib-trans">
                            <?=getMainCTran($rowMain['main_content_en'],$rowMain['main_content_vi'])?>
                        </div>

                    <?php } ?>
                </div>
            <?php }unset($sqlMain); ?>

        <?php }elseif($rowCont['skl_cont_type'] == 2){
            $sqlGram     = new db_query('SELECT * FROM grammar_lesson WHERE gram_skl_cont_id = '.$rowCont['skl_cont_id'].' ORDER BY gram_order ASC');
            $gramPath = 'http://'.$base_url.'/data/skill_content/';
            if($arrSkill[0]['skl_les_type'] != 5){
                while($rowGram  = mysqli_fetch_assoc($sqlGram->result)){ ?>
                    <div class="gram_detail" style="border: none;">
                        <div class="gram_title">
                            <?=$rowGram['gram_title']?>
                        </div>
                        <div class="main_igm">
                        <?php if($rowGram['gram_audio_url'] != ''){
                            echo '<a class="media" href="'.$gramPath.$rowGram['gram_audio_url'].'"></a>';
                        } else if($rowGram['gram_media_url'] != ''){
                            if($rowGram['gram_media_type'] == 1){ ?>
           	                    <center><img width="300px" height="220px" src="<?=$gramPath?>medium_<?=$rowGram['gram_media_url']?>"/></center>
                            <?php }else{
                                echo "<center><embed width='333' height='182' type='application/x-shockwave-flash' src='http://".$base_url."/mediaplayer/player.swf' flashvars='file=". $gram_path.$rowGram['gram_media_url'] ."'</embed></center>";
                            }
                        } ?>
                        </div>
                        <div> <?=$rowGram['gram_content_vi']?> </div>
                        <div> <?=$rowGram['gram_exam']?> </div>
                    </div>
                <?php }unset($sqlGram);
            }else{
                echo '<div class="rela">';
                $j = 0;
                while($rowGram  = mysqli_fetch_assoc($sqlGram->result)){
                $j++; ?>
                    <div class="gram_detail gram_<?=$j?>" style="border: none;">
                        <div class="gram_title">
                            <?=$rowGram['gram_title']?>
                        </div>
                        <div class="main_igm">
                            <?php if($rowGram['gram_audio_url'] != ''){
                                echo "<embed width='250' height='24' type='application/x-shockwave-flash' src='http://".$base_url."/mediaplayer/player.swf' flashvars='file=". $gram_path.$rowGram['gram_audio_url'] ."'</embed>";
                            } else if($rowGram['gram_media_url'] != ''){
                                if($rowGram['gram_media_type'] == 1){ ?>
               	                    <img src="<?=$gramPath?>medium_<?=$rowGram['gram_media_url']?>"/>
                                <?php }else{
                                    echo "<center><embed width='333' height='182' type='application/x-shockwave-flash' src='http://".$base_url."/mediaplayer/player.swf' flashvars='file=". $gram_path.$rowGram['gram_media_url'] ."'</embed></center>";
                                }
                            } ?>
                        </div>
                        <div class="content1">
                            <?=removeHTMl($rowGram['gram_content_vi'])?>
                        </div>
                        <div class="content2">
                            <?=removeHTML($rowGram['gram_exam'])?>
                        </div>
                    </div>
                <?php }unset($sqlGram);
                echo '</div>';
            } }elseif($rowCont['skl_cont_type'] == 4){
                $sqlWri     = new db_query('SELECT * FROM learn_writing WHERE learn_skl_cont_id = '.$row_cont["skl_cont_id"]);
                $rowWri     = mysqli_fetch_assoc($sqlWri->result);
                unset($sqlWri); ?>
                <div class="top_left_lightbox">
    	            <?php
    			    $wripart = 'http://'.$base_url.'/data/skill_content/';
    			    if($rowWri['learn_wr_media'] != ''){
    			        if($rowWri['learn_wr_mtype'] == 1){ ?>
    		                <center><img style="max-width:420px" src="<?=$wripart.$rowWri['learn_wr_media']?>"/></center>
    		            <?php }elseif($rowWri['learn_wr_mtype'] == 2){ ?>
                            <?php
                            $file   =   $wripart.$rowWri['learn_wr_media'];
                            get_media_library_v2($file,'');
                            ?>
    		            <?php } ?>
    			    <?php } ?>
	            </div>
                <div class="bot_left_lightbox">
		            <div>Câu hỏi</div>
                    <div><?=$rowWri['learn_wr_ques']?></div>
                    <div class="script"  style="width:100%;overflow:hidden;height:57px;margin-bottom:10px;">
		                <a id="hint" class="script_btn_wr script act_button">Gợi ý</a>
		            </div>
		            <div id="ct_hint" class="ct_scrip" >
			            <?php echo $rowWri['learn_wr_note']?>
		            </div>
                    <?php if($rowWri['learn_wr_content']!=""){ ?>
                		<div id="ct_conten" class="ct_scrip" >
                			<?php echo $rowWri['learn_wr_content'] ?>
                		</div>
                    <?php } ?>

            		<script type="text/javascript">
            		    $(document).ready(function(){
            				$("#ct_hint").hide();
            				$("a#hint").toggle(function(){
            					$("#ct_hint").show(200);
            				},
            				function(){
            					$("#ct_hint").hide(100);
            				});
            			})
            		</script>
	            </div>
            <?php } ?>
        <?php }unset($db_cont); ?>
    </div>
</div><!-- End .box1 -->

<script type="text/javascript">
var urlPoint      =   "";
var baseurl       =  'http://<?=$base_url?>';
$(document).ready(function(){
     //Transcript
    $('.trans').css('display','none');
    $('.script_btn_v2').toggle(function(){
        $(this).text('Ẩn');
        $(this).addClass('active');
    },function(){
        $(this).text('Nội dung');
        $(this).removeClass('active');
    });

    $('.button_dich').toggle(function(){
        $(this).addClass('active');
        $('.icon_dich_lb_v2').text('Bỏ dịch');
        //$('.icon_dich_lb_v2').css('background','url("http://<?=$base_url?>/themes/images/btn-bodich.png")');
        $('.bot_left_lightbox .notrans').css('display','none');
        $('.bot_left_lightbox .trans').css('display','block');
        $('#text_support').show(800);
    },function(){
        $(this).removeClass('active');
        $('.icon_dich_lb_v2').text('Dịch');
        //$('.icon_dich_lb_v2').css('background','url("http://<?=$base_url?>/themes/images/btn-05.png")');
        $('.bot_left_lightbox .notrans').css('display','block');
        $('.bot_left_lightbox .trans').css('display','none');
        $('#text_support').hide();
    });
});
</script>