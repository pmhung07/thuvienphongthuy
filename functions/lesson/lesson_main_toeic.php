<?php
function lesson_main_toeic($unit,$unit_num,$unit_name){
    $var_path_js     = '/themes/js/';
    $var_path_css    = '/themes/css/';
    $var_path_media  = '/mediaplayer/';
    $base_url        =  $_SERVER['HTTP_HOST'];
    $var_head_lib2   = '<link rel="stylesheet" type="text/css" href="'.$var_path_css.'jquery-ui-1.8.16.custom.css" />';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.editinplace.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'ujquery.ui.core.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.widget.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.mouse.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.draggable.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.droppable.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'slimScroll.min.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_media.'jwplayer.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript">jwplayer.key="IyBF3HN/WxYyCXbdjRCOrUH3C4FJGuzHP9SQ6mz/YQcKlam8eP/Fvm6VM6g=";</script>';
   
    //Lấy thông tin dạng bài học
    $sqlUnitMail = new db_query('SELECT * FROM lesson_details WHERE les_det_type = 2 AND les_com_id ='.$unit);
    $rowUnitMail = mysql_fetch_assoc($sqlUnitMail->result);
    $iUnit       = $rowUnitMail['les_det_id'];
    unset($sqlUnitMail);
    //Lấy nội dung bài học và bài tập
    $sqlLes     =  new db_query('SELECT * FROM courses_multi,lesson_details WHERE lesson_details.les_com_id = courses_multi.com_id AND lesson_details.les_det_type = 1 AND courses_multi.com_id = '.$unit);
    $rowLes     = mysql_fetch_assoc($sqlLes->result);
    $sqlMain    = new db_query("SELECT * FROM main_lesson WHERE main_det_id = ".$rowLes['les_det_id'] ." ORDER BY main_order");
    $type       = array();
    //Lay thong tin Unit
    $db_unit = new db_query("SELECT * FROM courses_multi WHERE com_id = ".$unit);
    $row_unit = mysql_fetch_assoc($db_unit->result);
    unset($db_unit);

    $type    = "";
    $javaStr = "";
?>
   <?=$var_head_lib2?>
   <div class="in_content_v2">
   	<div class="lesson-content-left">
   		<h2 class="lesson-content-title" title="Bài <?=$unit_num?>: <?=$unit_name?>">
   			Bài <?=$unit_num?>: <?=$unit_name?>
   		</h2>
   	</div>
   	<div class="lesson-content-left">
   		<div class="lesson-content-block">
            <div class="gram_detail">
            <?php
            $mainpart = 'http://'.$base_url.'/data/main_content/';
            $i = 0; 
            while($rowMain  = mysql_fetch_assoc($sqlMain->result)){
            $i++;
            ?>
                <?if($rowMain['main_media_type'] == 1){ ?>
                    <img src="<?=$mainpart?><?=$rowMain['main_media_url1']?>"/>
                <?}else if($rowMain['main_media_type'] == 2){ ?>			     
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="25" height="20"
                    codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab">
                    <param name="movie" value="http://<?=$base_url?>/themes/media/singlemp3player.swf?file=http://<?=$base_url?>/data/main_content/<?=$rowMain['main_media_url1']?>&backColor=990000&frontColor=ddddff&repeatPlay=false&songVolume=90" />
                    <param name="wmode" value="transparent" />
                    <embed wmode="transparent" width="25" height="20" src="http://<?=$base_url?>/themes/media/singlemp3player.swf?file=http://<?=$base_url?>/data/main_content/<?=$rowMain['main_media_url1']?>&backColor=990000&frontColor=ddddff&repeatPlay=false&songVolume=90"
                    type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                    </object>    
                <?}?>
                <div class="notrans" >
                    <div id="scroll_ct_<?=$i?>">
                        <?=getMainCNoTr($rowMain['main_content_vi'])?>
                    </div>
                </div>
                <div class="trans" >
                    <div id="scroll_trans_ct_<?=$i?>">
                    <?=getMainCTran($rowMain['main_content_en'],$rowMain['main_content_vi']);?>
                    </div>
                </div>
             <?php } ?>
            </div>
   		</div>
   	</div>
   	<div class="clearfix"></div>
   </div>
<div id="fade" class="black_overlay"></div>
<?php } ?>