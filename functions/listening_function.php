<?
// Reading type
function content_listening($content_id,$content_audio,$tec_time_audio,$content_image,$var_path_test_reading,$i){
   ?>
   <div id="read_cont_slice">
      <input id="content_id_<?=($i-1)?>" type="hidden" value="<?=$content_id?>" />
      <input id="time_audio_<?=($i-1)?>" type="hidden" value="<?=$tec_time_audio?>" />
      <img src="<?=$var_path_test_reading.$content_image?>"/>
   </div>
   <?
}

function ques_listening($teque_id,$teque_content,$teque_audio,$teque_type,$teque_type_sub,$i,$teque_score){
   ?>
   <?$base_url = $_SERVER['HTTP_HOST'];?>
   <div id="read_ques_slice">
      <div id="read_ques_show_hide_<?=($i-1)?>">
         <input id="teque_type_<?=($i-1)?>" type="hidden" value="<?=$teque_type?>" />
         <input id="teque_id_<?=($i-1)?>" type="hidden" value="<?=$teque_id?>" />
         <input id="teque_score_<?=($i-1)?>" type="hidden" value="<?=$teque_score?>" />
         <input id="teque_type_sub_<?=($i-1)?>" type="hidden" value="<?=$teque_type_sub?>" />
         <div id="read_ques">
            <?=$teque_content?>
         </div>
         <div id="read_ans">
            <table cellspacing="10" class="tbl_ques_read">
               <?
               $db_select_ans = new db_query("SELECT * FROM test_answers WHERE tan_teques_id = ".$teque_id);
               $count_i = 1;
               while($row_ans = mysqli_fetch_assoc($db_select_ans->result)){
                  if($teque_type == 1 && $teque_type_sub == 1){
                     ?>
                     <tr>
                        <td>
                           <span class="rdo_box">
                              <input id="" type="radio" name="radio_ans_<?=$i?>" value="<?=$row_ans['tan_id']?>"/>
                           </span>
                        </td>
                        <td style="font-size: 12px;float: left;"><?=$row_ans['tan_content']?></td>
                     </tr>
                  <?}elseif($teque_type == 1 && $teque_type_sub == 2){
                     ?>
                     <tr>
                        <td>
                           <span class="rdo_box_mul">
                           <input type="checkbox" id="true_mul_<?=$i?>" name="check_ans_<?=$count_i?>" value="<?=$row_ans['tan_id']?>"/>
                           </span>
                        </td>
                        <td style="font-size: 12px;float: left;"><?=$row_ans['tan_content']?></td>
                     </tr>
                     <?
                  }?>
               <?$count_i++;}unset($db_select_ans)?>
            </table>
         </div>
         <div id='container_ques_<?=($i-1)?>'></div>
      </div>
   </div>
   <?
}

function ques_content_listening($teque_id,$var_path_test_listening,$teque_audio,$teque_time_audio,$teque_image,$i,$current_page){
   ?>
   <div id="read_cont_slice" class="read_cont_change_<?=$current_page?>">
      <img src="<?=$var_path_test_listening.$teque_image?>"/>
      <div id="barbox_ques">
         <div id="progress_<?=($current_page)?>">
            <div class="pbar"></div>
         </div>
      </div>
      <div id='container_part_<?=($i-1)?>'></div>
      <script>
      jwplayer("container_part_<?=$_SESSION['currentQuesPage']?>").setup({
       	autostart: true,
       	icons: false,
       	controlbar: "none",
           flashplayer: "../mediaplayer/player.swf",
           file: "../data/test_listening/<?=$teque_audio?>",
           height: "0",
           width: "0",
           events: {
           	  onComplete: function() {
                 jwplayer("container_part_<?=$_SESSION['currentQuesPage']?>").setVolume(<?=$_SESSION["volume"]?>);
           	  }
           }
       });
      </script>
      <script>
      $(document).ready(function(){
      count_progress(<?=$current_page?>,<?=$teque_time_audio?>);
      });
      </script>
   </div>
   <?
}
?>