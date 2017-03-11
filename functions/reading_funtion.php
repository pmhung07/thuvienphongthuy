<?
// Reading type
function reading_ques($teque_id,$teque_tec_id,$teque_content,$teque_type,$teque_type_sub,$teque_score,$tec_id,$tec_name,$tec_content,$i){
   $myuser = new user();
   switch($teque_type){
      case "1":
      $arr_read_multi_use[$teque_id] = "";      
      ?>
         <div id="ques_slice">
            <div id="slice_detail">
               <input id="teque_type_<?=($i-1)?>" type="hidden" value="<?=$teque_type?>" />
               <input id="teque_id_<?=($i-1)?>" type="hidden" value="<?=$teque_id?>" />
               <input id="teque_score_<?=($i-1)?>" type="hidden" value="<?=$teque_score?>" />
               <p class="p_slice_detail"><?="<b>Question " .$i. " :</b> " .$teque_content?></p>
               <table cellspacing="10" class="tbl_slice_detail">
                  <?                                              
                  $db_select_ans = new db_query("SELECT * FROM test_answers WHERE tan_teques_id = ".$teque_id);
                  while($row_ans = mysql_fetch_assoc($db_select_ans->result)){
                     $ans_id = $row_ans['tan_id'];
                     if($row_ans['tan_true'] == 1){
                        $arr_read_multi_true[$teque_id] = $ans_id;                            
                     }                                          
                     ?>
                     <tr>  
                        <td>
                           <span class="rdo_box">
                           <input id="" <? if(isset($_SESSION["ques_".$myuser->u_id."_".$teque_id])){
                                              if($_SESSION["ques_".$myuser->u_id."_".$teque_id] == $ans_id){
                                                 echo "checked=''";
                                              }} ?> type="radio"  name="radio_ans_<?=$i?>" value="<?=$ans_id?>"/></span></td>
                        <td style="font-size: 13px;"><?=$row_ans['tan_content']?></td>                    
                     </tr>              
                  <?}unset($db_select_ans);?>
               </table>
            </div>
            <div id="direct_ques_multichoice">
               Click on an oval to select your answer.To choose a different answer,click on a different oval.
            </div>
         </div> 
         
         <div id="para_slice">         
            <?
            $db_select_highlight = new db_query("SELECT high_teque_id FROM test_highlight 
                                                 WHERE high_tec_id = ".$tec_id);
            $arrques_in_highlight[] = "";
            $i = 0;
            while($row_ques_highlight = mysql_fetch_assoc($db_select_highlight->result)){
               $arrques_in_highlight[$i] = $row_ques_highlight['high_teque_id'];
               $i++; 
            }unset($db_select_highlight);
            if(in_array($teque_id,$arrques_in_highlight)){
               $db_select_highlight = new db_query("SELECT * FROM test_highlight WHERE high_teque_id = ".$teque_id);
               if($row_highlight = mysql_fetch_assoc($db_select_highlight->result)){
                  echo "<p style='font-weight:bold;'>". $tec_name ."</p>";
                  echo $row_highlight['high_paragraph'];
               }unset($db_select_highlight);
            }else{  
               echo "<p style='font-weight:bold;'>". $tec_name ."</p>";
               echo $tec_content;
            }
            ?>
         </div>  
      <?
         break;
      case "2":
         if($teque_type_sub == 1){
         ?>
         <div id="slice_drag">
            <?//echo $_SESSION['ques_'.$teque_id][1] ."-". $_SESSION['ques_'.$teque_id][2] ."-". $_SESSION['ques_'.$teque_id][3];?>
            <input id="teque_type_<?=($i-1)?>" type="hidden" value="<?=$teque_type?>" />
            <input id="teque_type_sub_<?=($i-1)?>" type="hidden" value="<?=$teque_type_sub?>" />
            <input id="teque_id_<?=($i-1)?>" type="hidden" value="<?=$teque_id?>" />
            <input id="teque_score_<?=($i-1)?>" type="hidden" value="<?=$teque_score?>" />
            <div id="drag_first_direct">
               <span class="direct_drag_1"><?="<b>Question " .$i. " :</b> " ?>An introductory  sentence for a brief summary of the passage  is provided below.Complete the summary by 
               selecting the <b>THREE</b> answer choice that express the most important ideas in the passage.Some sentences
               do not belong in the summary bacause they express ideas that are not presented in the passage or are minor
               ideas in the passage.<b>This question is worth 2 points</b><br /><br />
               Drag your answer choices to the spaces where they belong.To review the passage, click on <b>View Text.</b></span>
            </div>
            <div id="drag_first_ques">
               <span style="margin: 3px 0px 0px 30px;float: left;"><b><?=$teque_content?></b></span>
            </div>
            <div id="drag_ans_true_ques">
               <?
               if(isset($_SESSION["ques_".$myuser->u_id."_".$teque_id])){
                  //var_dump($_SESSION['ques_'.$teque_id][1]);
                  //var_dump($_SESSION["ques_".$teque_id]);
                  for($i = 1 ; $i < 4 ; $i++){
                     $tan_choose = $_SESSION["ques_".$myuser->u_id."_".$teque_id][$i];
                     $db_select_ans_choose = new db_query("SELECT tan_content FROM test_answers WHERE tan_id = ".$tan_choose);
                     ?>
                     <div class="drag_ans_true_1">
                        <span id="droppable_<?=$i?>" class="drop_reading">
                           <span class='text-ct' style='color:red;font-weight: bold;font-size:11px;'>
                              <?
                              if($row_ans_choose = mysql_fetch_assoc($db_select_ans_choose->result)){
                                 echo $row_ans_choose['tan_content'];
                              }
                              ?>
                           </span>
                        </span>
                     </div>
                     <?   
                  }
               }else{
               ?>
                  <div class="drag_ans_true_1"><span id="droppable_<?=$teque_id?>_1" class="drop_reading"><span class="reading_dot"></span></span></div>
                  <div class="drag_ans_true_1"><span id="droppable_<?=$teque_id?>_2" class="drop_reading"><span class="reading_dot"></span></span></div>
                  <div class="drag_ans_true_1"><span id="droppable_<?=$teque_id?>_3" class="drop_reading"><span class="reading_dot"></span></span></div>
               <?}?>
            </div>
            <div id="catalog_drag_ans_ques">
               <ul id="drag_ans_ques">
                  <b style="float: left;padding: 10px 305px;">Answer choices</b>
                  <?
                  $db_select_ans = new db_query("SELECT * FROM test_answers WHERE tan_teques_id = ".$teque_id);
                  $i = 1;
                  while($row_ans = mysql_fetch_assoc($db_select_ans->result)){
                  ?>
                  <li id="draggable_<?=$teque_id?>_<?=$i?>" class="ans_drag_1"><b><?=$i." . "?></b>
                     <span>
                        <?=$row_ans['tan_content']?>
                        <input id="ip_<?=$teque_id?>" type="hidden" value="<?=$row_ans['tan_id']?>"/>
                     </span></li>
                  <?$i++;}unset($db_select_ans)?>
               </ul>
            </div>
         </div>
         <script>
         $(document).ready(function(){
            <?for($j = 1;$j <= $i;$j++){?>
               $("#draggable_<?=$teque_id?>_<?=$j?>").draggable({ appendTo: "body",helper: "clone" }); 
            <?}?> 
            <?for($j = 1;$j < 4;$j++){?>
               $("#droppable_<?=$teque_id?>_<?=$j?>").droppable({
                  activeClass: "ui-state-hover",
                  hoverClass: "ui-state-active",
                  drop:function( even, ui){
                     $( this ).addClass( "ui-state-highlight" );
                     $( this ).find( ".reading_dot" ).remove();
                     valuedrop<?=$j?> = ui.draggable.text();
                     $( this ).find( ".text-ct" ).remove();
                     $( "<span class='text-ct' style='color:red;font-weight: bold;font-size:11px;'></span>" ).html( ui.draggable.html()).appendTo( this );
                  }
               });
            <?}?>
            
         });
         </script>
         <?
         }else{
         ?>
         <div id="slice_drag">
            <div id="drag_second_direct">
               <span style="margin: 3px 0px 0px 30px;float: left;" class="direct_drag_2">
               <p><?="<b>Question " .$i. " :</b> " ?>Drag your answer choice to the spaces where they belong.To remove an answer choice,click on it.To review the passage,click on <b>View Text</b></p>
               </span>
            </div>
            <div id="drag_second_ques">
               <span style="margin: 3px 0px 0px 30px;float: left;">
               <p>Select the appropriate phrases from the answer choice and match them to the time in the history of radio
                  in which they occurred.You will NOT use TWO of the answer choice.<b>This question is worth 4 points</b></p>
               </span>
            </div>
            <div id="drag_ans_ques_2">
               <div id="drag_true_2">
                  <?
                  $db_select_ans = new db_query("SELECT * FROM test_answers 
                                                 WHERE tan_teques_id = ".$teque_id);
                  $count_ans = 1;
                  while($row_ans = mysql_fetch_assoc($db_select_ans->result)){
                  ?>
                  <div id="draggable_ans_<?=$teque_id?>_<?=$count_ans?>" class="drag_lis_ans">
                     <b><?=$count_ans." . "?></b><?=$row_ans['tan_content']?>
                     <input id="ip_ans_choose<?//=$row_ans['tan_quesub_id']?><?//=$row_ans['tan_id']?>" type="hidden" value="<?=$row_ans['tan_id']?>"/>
                  </div>
                  <?$count_ans++;}unset($db_select_ans)?>
               </div>
               <div id="ans_choose_2">
                  <ul class="ul_list_subques">
                  <?
                  $i = 0;
                  $arr_count = array();
                  $arr_ans_drag_2 = array();
                  $db_select_quessub = new db_query("SELECT * FROM  test_questions_sub 
                                                     WHERE quesub_teque_id = ".$teque_id);
                  //$total_ques_sub = mysql_num_rows($db_select_quessub->result);
                  $count_ques_sub = 1;                                  
                  while($row_quessub = mysql_fetch_assoc($db_select_quessub->result)){
                     $i++;
                     $arr_count[$i] = 0;
                     $row_sl_sub = new db_query("SELECT tan_id FROM test_answers WHERE tan_quesub_id = ".$row_quessub['quesub_id']);
                     //total count ans fil subques
                     $total_ans_sub = mysql_num_rows($row_sl_sub->result); 
                     //echo $total_ans_sub;      
                     ?>
                     <li id="id_list_subquest_<?=$count_ques_sub?>" class="li_list_subqques">
                     <input id="ip_subques_<?=$count_ques_sub?>" type="hidden" value="<?=$row_quessub['quesub_id']?>"/>
                        <b><?=$row_quessub['quesub_content']?></b>
                        <ul class="ul_list_ans">
                           <?
                           $count_ans_sub = 1;
                           while($row_sub = mysql_fetch_assoc($row_sl_sub->result)){
                              $arr_count[$i]++;
                              ?>
                              <li id="droppable_ans_<?=$teque_id?>_<?=$count_ques_sub?>_<?=$count_ans_sub?>" class="drag_ans_true_2"></li>
                              <?    
                              $count_ans_sub++;  
                           }unset($row_sl_sub);   
                           ?>
                        </ul>
                     </li>
                  <?$count_ques_sub++;}unset($db_select_quessub);?>
                  </ul>
               </div>
            </div>
         </div>                         
      <script>
      $(document).ready(function(){
         <?for($j = 1;$j <= $count_ans;$j++){?>
            $("#draggable_ans_<?=$teque_id?>_<?=$j?>").draggable({ appendTo: "body",helper: "clone" }); 
         <?}?> 
         <?for($j = 1;$j < $count_ques_sub;$j++){?>
            <?for($k = 1;$k < $count_ans_sub;$k++){?>
               $("#droppable_ans_<?=$teque_id?>_<?=$j?>_<?=$k?>").droppable({
                  activeClass: "ui-state-hover",
                  hoverClass: "ui-state-active",
                  drop:function( even, ui){
                     $( this ).addClass( "ui-state-highlight" );
                     $( this ).find( ".reading_dot" ).remove();
                     valuedrop<?=$j?><?$k?> = ui.draggable.text();
                     $( this ).find( ".text-ct" ).remove();
                     $( "<span class='text-ct' style='color:red;font-weight: bold;font-size:11px;'></span>" ).html( ui.draggable.html() ).appendTo( this );
                  }
               });
         <?}}?>   
      });
      </script>
         <?
         }
      break;
      case "3":
         ?>
         <div id="ques_slice">
            <input id="teque_type_<?=($i-1)?>" type="hidden" value="<?=$teque_type?>" />
            <input id="teque_id_<?=($i-1)?>" type="hidden" value="<?=$teque_id?>" />
            <input id="teque_score_<?=($i-1)?>" type="hidden" value="<?=$teque_score?>" />
            <div id="slice_detail">
               <p class="p_slice_detail"><?="<b>Question " .$i. " :</b> " ?>Look at the four squares [<span class='sp_fill'>+</span>] 
               that indicate where the following sentence could be added to the passage. </p>
               <?
               $db_select_fill = new db_query("SELECT * FROM test_fillwords WHERE fil_teque_id = ".$teque_id);
               $i = 0;
               if($row_ques_fil = mysql_fetch_assoc($db_select_fill->result)){  
                  $que_id = $row_ques_fil['fil_teque_id'];
                  $phrases = $row_ques_fil['fil_phrases'];
                  $para = $row_ques_fil['fil_paragraph'];
               }
               ?>
               <p id="fill_detail" class="p_slice_detail"><b><?=$phrases?></b></p>  
               <p class="p_slice_detail"><?=$teque_content?></p>             
            </div>
            <div id="direct_ques_multichoice">
               Click on a square [<span class='sp_fill'>+</span>] to add the sentence to the passage.To select a different location,click on a differnt square.
            </div>
         </div>   
         <div id="para_slice"> 
            <?echo "<p style='font-weight:bold;'>". $tec_name ."</p>";?>
            <?
               //count string
               //$para_rm = removeHTML($para);
               $para_split = explode("|",$para);
               $para_count = count($para_split);         
               for($i = 0;$i < $para_count;$i++){
                  if($i % 2 != 0){         
                     ?>
                     <span class='sp_fill' id='sp_fill_<?=$que_id?>_<?=$para_split[$i]?>' onclick="append_fillword(<?=$que_id?>,<?=$para_split[$i]?>,'<?=$phrases?>')">
                        +
                     </span>
                     <?
                  }else{
                     echo $para_split[$i];
                  }
                                 
               }                                  
            ?>
         </div>
         <script>
            function append_fillword(iQues,position,phrases){
               $(".sp_fill").text("+");
               $(".sp_fill").css("color","#4CB6E3");
               $("#sp_fill_"+iQues+"_"+position).append(phrases);
               $("#sp_fill_"+iQues+"_"+position).css("color","white");
               
               var currentPage = $currentPage + 1;
               var get_id_check = $currentPage + 1;
               var teque_type = $("#teque_type_"+$currentPage).val();
               var teque_id = $("#teque_id_"+$currentPage).val();
               var teque_score = $("#teque_score_"+$currentPage).val();
               
               $.ajax({
                  type:'POST',
                  dataType:'JSON',
                  data:{
                     currentPage:currentPage,
                     teque_type:teque_type,
                     teque_id:iQues,
                     position:position,
                     teque_score:teque_score
                  },
               url:'../ajax/save_questions.php',
               success:function(data){  
                  if(data.err == ''){
                  }else{
                  }}
               });         
            }
         </script>
         <?
      break;
   }
}?>