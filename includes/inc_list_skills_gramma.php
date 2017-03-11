<?php
// $arrSkill : ARRAY SAVE INFO skill_lesson table
// $iLes       = $arrSkill[0]['skl_les_id'];

$dbCont         = new db_query('SELECT * FROM skill_content WHERE skl_cont_les_id = '.$iLes.' AND skl_cont_type = 2 AND skl_cont_active = 1 ORDER BY skl_cont_order ASC');
$numCont        = mysql_num_rows($dbCont->result);
if($numCont > 0){
?>
<div class="content_bl no_border cbox2"><!-- cbox2 -->
    <div class="grm">
    <?php while($rowCont = mysql_fetch_assoc($dbCont->result)){ ?>
        <?php
        echo '<div class="tit_cont">'.$rowCont['skl_cont_title'].'</div>';
        echo '<div class="cont_cont">'.$rowCont['skl_content'].'</div>';
        $sqlGram        = new db_query("SELECT * FROM grammar_lesson WHERE gram_skl_cont_id = ".$rowCont['skl_cont_id']." ORDER BY gram_order ASC");
        $gram_path      = 'http://'.$base_url.'/data/skill_content/';
        ?>
        <?php while($rowGram  = mysql_fetch_assoc($sqlGram->result)){ ?>
        <div class="gram_detail">
            <div class="gram_title">
                <?=$rowGram['gram_title']?>
            </div>
            <div class="main_igm">
                
                <?php if($rowGram['gram_audio_url'] != ''){ ?>

                    <a class="media" href="<?=$gram_path.$rowGram['gram_audio_url']?>"></a>

                <?php } else if($rowGram['gram_media_url'] != ''){ ?>

                    <?php if($rowGram['gram_media_type'] == 1){ ?>

                        <center><img width="300px" height="220px" src="<?=$gram_path?>medium_<?=$rowGram['gram_media_url']?>"/></center>
                    
                    <?php }else{ ?>
                    
                        <center><embed width='333' height='182' type='application/x-shockwave-flash' src='http://<?=$base_url?>/mediaplayer/player.swf' flashvars='file=<?=$gram_path.$rowGram["gram_media_url"]?>'</embed></center>     
                    
                    <?php } ?>
                
                <?php } ?>

            </div>
            <div>
                <?=$rowGram['gram_content_vi']?>
            </div>
            <div>
                <?=$rowGram['gram_exam']?>                        
            </div>
        </div>
        <?php }unset($sqlGram); ?>
    <?php }unset($dbCont); ?>
   </div>

</div>
<?php } ?>
