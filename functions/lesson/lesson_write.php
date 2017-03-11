<?
function lesson_write($unit,$unit_num,$unit_name){
    $myuser          =  new user('','');
    $var_path_js     = '/themes/js/';
    $var_path_css    = '/themes/css/';
    $var_path_media  = '/mediaplayer/';
    $base_url        =  $_SERVER['HTTP_HOST'];
    $var_head_lib2   = '<link rel="stylesheet" type="text/css" href="'.$var_path_css.'jquery-ui-1.8.16.custom.css" />';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.editinplace.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.core.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.widget.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.mouse.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.draggable.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.droppable.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'slimScroll.min.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_media.'jwplayer.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript">jwplayer.key="IyBF3HN/WxYyCXbdjRCOrUH3C4FJGuzHP9SQ6mz/YQcKlam8eP/Fvm6VM6g=";</script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'lesson_page.js"></script>';
   
    //Lấy thông tin dạng bài học
    $sqlUnitMail = new db_query('SELECT * FROM lesson_details WHERE les_det_type = 1 AND les_com_id ='.$unit);
    $rowUnitMail = mysql_fetch_assoc($sqlUnitMail->result);
    $iUnit       = $rowUnitMail['les_det_id'];
    unset($sqlUnitMail);
    //Lấy nội dung bài học và bài tập
    $sqlWri     = new db_query('SELECT * FROM learn_writing WHERE learn_unit_id = '.$unit);
    $rowWri     = mysql_fetch_assoc($sqlWri->result);
   
?>
    <?=$var_head_lib2?>
    <div class="in_content_v2">
       	<div class="lesson-content-left">
       		<h2 class="lesson-content-title" title="Bài tập">
       			Bài <?=$unit_num?>: <?=$unit_name?>
       		</h2>
       	</div>
        <div class="clearfix"></div>
   	    <div class="lesson-content-right bg-lesson-content-details">
            <div class="gray-box1">
                <div class="top_right_lightbox">
                    <div class="write-title"> <?=removeHTML($rowWri['learn_wr_ques'])?> </div>
                    <div class="bottom_right_lightbox" >
                        <form name="frm_wri" id="frm_wri">
               	            <input type="hidden" value="<?=$rowWri['learn_wr_id']?>" name="id_wr" id="id_wr" />
               	            <textarea id="input_text" cols="48" rows="15"></textarea>                        
                        </form>
                        <div class="wri_send">
                            <a class="button_ht_wri pull-right" href="javascript:;">Gửi bài viết</a>
                        </div>
                        <div class="pull-right script_btn_wr script">
              			    <div class="button button-cyan goi-y">Gợi ý</div>
              		    </div>
                        <div class="bot_left_lightbox">    
                            <div id="ct_hint" class="ct_scrip" >
               	                <?php echo $rowWri['learn_wr_note'] ?>
                            </div>
                            <div id="ct_conten" class="ct_scrip" >
               	                <?php echo $rowWri['learn_wr_content'] ?>
                            </div>
                            <script type="text/javascript">
                            $(document).ready(function(){
                                $(".bot_left_lightbox").hide();
                                $(".button-cyan").toggle(function(){
                              	$(".bot_left_lightbox").show(200);
                                },function(){
                           	        $(".bot_left_lightbox").hide(100);  					 			 
                                });   
                            })
                           </script> 
                        </div>   	
                         <div class="lesson-content-left">
                            <?php
                            $wripart = 'http://'.$base_url.'/data/learn_wr/';
                            if($rowWri['learn_wr_media'] != ''){
                                if($rowWri['learn_wr_mtype'] == 1){ ?>
                                <div class="main_igm">
                                    <img src="<?=$wripart.$rowWri['learn_wr_media']?>" alt="Question_media"/>
                                </div>
                            <?php }elseif($rowWri['learn_wr_mtype'] == 2){ ?>
                                <?=get_media_library_v2($wripart.$rowWri['learn_wr_media'],'')?>
                            <?php } } ?>
                        </div>  
                    </div>
                    <div id="wri_load">&nbsp;</div>
                    <div id="error_wri"></div>
                </div>      
            </div>  		
   	    </div>
   	    <div class="clearfix"></div>
        <?//$link = signin_link();?>
        <script type="text/javascript">
            $(document).ready(function() {
                var baseurl =  'http://<?=$base_url?>';
      	        $('.button_ht_wri').click(function (){
      	        <?php if($myuser->logged == 1){?>
          		    var id_wri 	 = $('#id_wr').attr('value');
          		    var input_text = $('#input_text').attr('value');
                    $.ajax({
                        type : 'POST',            		  
                        data : {
                            type : "write", 
                            id   : id_wri, 
                            input: input_text,
                        },
                        url  : 'http://<?=$base_url?>/ajax/mark_writing.php',
                        success:function(data){
                            $('#wri_load').css("display","none");
                            var getdata = $.parseJSON(data);
                                suc     = getdata.suc;
                                error   = getdata.error;
                            if (suc == 0){
                                alert(error);
                                window.location.reload();
                            }else{
                                alert(error);
                                window.location.reload();
                            }
                        }
                    });
                <?php } ?>						  
      	    });                
        });
        </script>
    </div>
<?php } ?>

