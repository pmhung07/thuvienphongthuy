<?
// Reading type
function content_writing($tec_id,$tec_name,$tec_content,$tec_audio,$tec_ques,$var_path_test_writing){
   ?>
   <div id="wri_cont_slice" style="display: none;">
      <span class="wri_title"><?=$tec_name?></span>
      <span class="wri_cont"><?=$tec_content?></span>
   </div>
   <div id="wri_ques">
      <p><?=$tec_ques?></p>
   </div>  
   <div id="wri_ans">
      <div id="wri_ans_tools">
      </div>
      <div id="wri_ans_content">
         <textarea class="wri_txt_content"></textarea>
      </div>
   </div>
   <?  
}
?>