<?php
// $arrSkill : ARRAY SAVE INFO skill_lesson table
$iLes       = $arrSkill[0]['skl_les_id'];
?>
    <div class="lesson-content-block lesson-content-tu-moi">
        <div class="voc">

        <?php
        $dbCont = new db_query('SELECT * FROM skill_content WHERE skl_cont_les_id = '.$iLes.' AND skl_cont_type = 3 AND skl_cont_active = 1 ORDER BY skl_cont_order ASC');
        while($rowCont = mysqli_fetch_assoc($dbCont->result)){
            $sqlVoc     = new db_query("SELECT * FROM vocabulary_lesson WHERE voc_skl_cont_id = ".$rowCont['skl_cont_id']);
            $voc_path   = 'http://'.$base_url.'/data/skill_content/';
            while($rowVoc  = mysqli_fetch_assoc($sqlVoc->result)){
            ?>
                <div class="single-item">
          	        <div class="pull-right">
          		        <div class="black-block"><img src="<?=$voc_path.$rowVoc['voc_media_url']?>" alt="<?=$rowVoc['voc_content_en']?>" /></div>
          	        </div>
                  	<div class="bold"><?=$rowVoc['voc_content_en']?>
                        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="25" height="20"
                            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab">
                            <param name="movie" value="http://<?=$base_url?>/themes/media/singlemp3player.swf?file=http://<?=$base_url?>/data/vocabulary/<?=$rowVoc['voc_audio_url']?>&backColor=990000&frontColor=ddddff&repeatPlay=false&songVolume=90" />
                            <param name="wmode" value="transparent" />
                            <embed wmode="transparent" width="25" height="20" src="http://<?=$base_url?>/themes/media/singlemp3player.swf?file=<?=$voc_path.$rowVoc['voc_audio_url']?>&backColor=990000&frontColor=ddddff&repeatPlay=false&songVolume=90"
                            type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                        </object>
                    </div>
          	        <div class="cyan"><?=$rowVoc['voc_phonetic']?>: <?=$rowVoc['voc_content_vi']?></div>
          	        <div class="italic"><?=$rowVoc['voc_exam']?></div>
                </div>
            <?php }unset($sqlVoc); ?>
        <?php }unset($dbCont); ?>
      </div>
   </div><!-- .lesson-content-block -->
