<?php
// $arrSkill : ARRAY SAVE INFO skill_lesson table
$iLes       = $arrSkill[0]['skl_les_id'];
?>

<?php
$dbCont = new db_query('SELECT * FROM skill_content WHERE skl_cont_les_id = '.$iLes.' AND skl_cont_pos = 3 AND skl_cont_active = 1 AND skl_cont_type = 5 ORDER BY skl_cont_order ASC');
while($rowCont = mysql_fetch_assoc($dbCont->result)){
    $dbExtend = new db_query("SElECT * FROM skill_ext WHERE skl_ext_skl_cont_id = ".$rowCont['skl_cont_id']);
    while($rowExt = mysql_fetch_assoc($dbExtend->result)){ ?>
		<div class="game_box">
		    <div class="huong_dan"><?=$rowExt['skl_ext_cont']?></div>
		    <div style="text-align: center;">
		        <object width="491" height="338">
		           <embed src="http://<?=$base_url?>/data/skill_content/<?=$rowExt['skl_ext_media']?>" width="500" height="490" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed>
		        </object>
		   </div>
		</div>   
	<?php }unset($db_extend); ?>
<?php }unset($db_cont); ?>