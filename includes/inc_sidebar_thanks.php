<?php
$iUnit = getValue('iUnit','int','GET',0);
?>
<div class="faq_wrap">
    <div class="question-learn-here">
    	<div class="faq_sub">
            <textarea name="content_ques content_ques_thanks" id="content_ques" placeholder="Đặt câu hỏi" class="content_ques content_ques_thanks"></textarea>
    		<input type="submit" name="sub_ques" class="sub_content_ques" value="Gửi"/>	
    	</div>
    </div>
	<div class="faq_content faq_content_thanks">
		<ul>
	        <li class="res_question res_question_thanks"></li>
	        <?php
	        $db_ques = new db_query('SELECT que_id,que_user_id,que_content,que_date, que_active, use_id,use_name
	                                 FROM faq_questions 
	                                 LEFT JOIN users ON use_id = que_user_id
	                                 WHERE 1 AND que_type LIKE "thanks" AND que_tab_id ='.$iUnit.'
	                                 ORDER BY  que_date DESC
	                                 LIMIT 5');
	        $res_ques = $db_ques->resultArray();
	        unset($db_ques);
	        foreach($res_ques as $ques) {
	            $db_count_ans = new db_count('SELECT count(*) as count FROM faq_answers WHERE 1 AND ans_question_id = '.$ques['que_id']);
	            $count_ans = $db_count_ans->total;
	            unset($db_count_ans);
	            ?>
	            <li data-id="<?=$ques['que_id']?>" class="nums_question">
	    			<h3 class="first_content_ques"><span><?=convertname($ques['use_name'])?>: </span><?=$ques['que_content']?></h3>
	    			<div class="det_content_ques det_content_ques_thanks">
	    				<a class="load_ans load_ans_thanks" data-page="0" data-total="<?=$count_ans?>" href="javascript:void();">
	    					<img src="/themes/img/community/icon_comunity.png" alt="answers"/> <?=$count_ans?>
	    				</a>
	    				<span><?=date('H:i - d/m/y',$ques['que_date'])?></span>
	    				<!--<a class="icon_reply"><img src="/themes_v2/images/community/icon_reply.png"></a>-->
	    			</div>
	                <div class="content_reply content_reply_thanks"></div>
	                <div class="reply_ques reply_ques_thanks">
	    				<img src="/themes/img/community/icon_answers.png" alt="reply"/>
	    				<input type="text" name="content_ans" id="content_ans" class="content_ans content_ans_thanks" placeholder="Trả lời"/>
	    			</div>
	    		</li>
	            <?
	        }
	        ?>
		</ul>
	</div>
	<div class="faq_control faq_control_thanks" data-page="1">
	<?php
	    $db_count_ques = new db_count('SELECT count(*) as count FROM faq_questions WHERE 1 AND que_type LIKE "thanks" AND que_tab_id ='.$iUnit.'');
	    $count_ques = $db_count_ques->total; unset($db_count_ques);
	    $count_ques = intval($count_ques/8) + 1;
	?>
	    <a class="prev_faq prev_faq_thanks"></a>
	    <div class="pagemid"><span>1</span>/<?=$count_ques?></div>
	    <a class="next_faq next_faq_thanks"></a>
	</div>
</div>
<script type="text/javascript">
    //bắt chiều cao của khối bên trái - gán cho khối hỏi đáp để tạo scroll
    var h = $('.faq_content_thanks').height();
    // $('.faq_content').css({height:h});
    // $('.faq_content').slimScroll({
    //     color: '#ccc',
    //     height : '"'+h+'"',
    //     height: 500,
    //     width: 236
    // });
    
    //phân trang câu hỏi
    $('.prev_faq_thanks').live('click',function(){
        var page_ques = $('.faq_control_thanks').attr("data-page");
        page_ques--;
        if(page_ques >= 1) {
            $.ajax({
                type:'post',
                url:'/ajax/request_thanks.php',
                data:{action:'control',page:page_ques,iTab:<?=$iUnit?>},
                success:function(resp){
                    $('.faq_control_thanks').attr("data-page",page_ques);
                    $('.faq_control_thanks span').html(page_ques);
                    $('.faq_control_thanks ul').html(resp.html);
                },
                dataType:"json"
            })    
        }
        else {
            $('.faq_control_thanks').attr("data-page",1);
        }        
    });
    $('.next_faq_thanks').live('click',function(){
        var page_ques = $('.faq_control_thanks').attr("data-page");
        page_ques++;
        if(page_ques <= <?=$count_ques?>) {
            $.ajax({
                type:'post',
                url:'/ajax/request_thanks.php',
                data:{action:'control',page:page_ques,iTab:<?=$iUnit?>},
                success:function(resp){
                    $('.faq_control_thanks').attr("data-page",page_ques);
                    $('.faq_control_thanks span').html(page_ques);
                    $('.faq_control_thanks ul').html(resp.html);
                },
                dataType:"json"
            })    
        }
        else {
            $('.faq_control_thanks').attr("data-page",<?=(intval($count_ques)-1)?>);
            $('.faq_control_thanks span').html(page_ques - 1);
        }        
    });
    
    //show input trả lời câu hỏi
    $('.icon_reply').live('click', function() {
        var cur_val = $(this).closest("li").find(".reply_ques_thanks").css("display");
        var reshtml = $(this).closest("li").find('.content_reply_thanks').html();
        if(reshtml == '') {
            if(cur_val == 'none') {
                $(this).closest("li").find(".reply_ques_thanks").css("display","block");
                var a = $(this).closest("li");
                var ques_id = $(this).closest("li").attr("data-id");
                $.ajax({
                    type:'post',
                    url:'/ajax/request_thanks.php',
                    data:{action:'load_ans_pre',ques_id:ques_id,iTab:<?=$iUnit?>},
                    success:function(resp){
                        a.find(".content_reply_thanks").append(resp.html);
                    },
                    dataType:"json"
                })
            }
            else {
                $(this).closest("li").find(".reply_ques_thanks").css("display","none");
                
            }    
        }
        else {
            if(cur_val == 'none') {
                $(this).closest("li").find(".reply_ques_thanks").css("display","block");
            }
            else {
                $(this).closest("li").find(".reply_ques_thanks").css("display","none");
                
            }
        }
            
    });

    
    //check độ dài câu hỏi
    $('.content_ques_thanks').keyup(function() {
        var len = $(this).val().length;
        if(len < 10) {
            $('.faq_notice').html('Độ dài câu hỏi phải lớn hơn 10 ký tự !');
        }else {
            $('.faq_notice').html('');
        }
    })
    
    //gửi câu hỏi
    $('.sub_content_ques').live('click',function(){
        var faq = $('.content_ques_thanks').val();
        if(faq.length > 10) {
            $.ajax({
                type:'post',
                url:'/ajax/request_thanks.php',
                data:{action:'add_ques',faq:faq,iTab:<?=$iUnit?>},
                success:function(resp){
                    $('.res_question_thanks').html(resp.html);
                    $('.content_ques_thanks').val("");
                    if(resp.success !='-2'){
                        $('.faq_notice').html("<span style='color: green;'>Gửi câu hỏi thành công !</span>");
                    }
                },
                dataType:"json"
            })
        }
        else {
            return false;
        }
    });
    
    //gửi câu trả lời
    $('.content_ans_thanks').live('keypress',function(event) {
        if(event.which == 13){
            var e = $(this).closest("li");
            var ques_id = $(this).closest("li").attr("data-id");
            var ans = $(this).val();
            $.ajax({
                type:'post',
                url:'/ajax/request_thanks.php',
                data:{action:'add_ans',ques_id:ques_id,ans:ans,iTab:<?=$iUnit?>},
                success:function(resp){
                    e.find(".content_ans_thanks").val("");
                    //e.find(".reply_ques").html("<img src='/themes_v2/images/community/icon_answers.png' style='float: left; margin-top: 10px; margin-left: 6px;'><input type='text' name='content_ans' id='content_ans' class='content_ans' placeholder='Trả lời'>");
                    e.find(".reply_ques_thanks").html("");
                    e.find(".content_reply_thanks").append(resp.html);
                },
                beforeSend: function() {
                   e.find(".reply_ques_thanks").html("<img src='/themes/img/community/ajax-loader.gif'>"); 
                },
                dataType:"json"
            })
        }
    });
    
    //load câu trả lời
    $('.load_ans_thanks').live('click',function(){
        var d = $(this);
        var page_ans = d.attr("data-page");
        var total_ans = d.attr("data-total");
        var e = $(this).closest("li");
        var ques_id = $(this).closest("li").attr("data-id");
        page_ans ++;
        var reshtml = e.find('.content_reply_thanks').html('');
        if(page_ans%2 !=0) {
            e.find(".reply_ques_thanks").css("display","block");
            $.ajax({
                type:'post',
                url:'/ajax/request_thanks.php',
                data:{action:'load_ans_pre',ques_id:ques_id,total_ans:total_ans,iTab:<?=$iUnit?>},
                success:function(resp){
                    d.attr("data-page",page_ans);
                    e.find(".reply_ques_thanks").append(resp.html);
                    var rh = e.find(".reply_ques_thanks").height();
                    if(rh > 150) {
                        e.find(".reply_ques_thanks").slimScroll({
                            color: '#ccc',
                            height : 150,
                            width: 216
                        });
                    }
                },
                dataType:"json"
            });
            
        }else {
            d.attr("data-page",page_ans);
            e.find(".reply_ques_thanks").css("display","none");
            e.find(".content_reply_thanks").remove();
            e.find(".slimScrollDiv").remove();
            e.find(".det_content_ques_thanks").after('<div class="content_reply"></div>');
        }
    });
    
    //load thêmmmmmm câu trả lời
    $('.load_ans_next').live('click',function(){
        var d = $(this);
        var e = $(this).closest("li");
        var ques_id = $(this).closest("li").attr("data-id");
        $.ajax({
            type:'post',
            url:'/ajax/request_thanks.php',
            data:{action:'load_ans_next',ques_id:ques_id,iTab:<?=$iUnit?>},
            success:function(resp){
                e.find(".content_reply_thanks").append(resp.html);
                d.remove();
                var rh = e.find(".content_reply_thanks").height();
                if(rh > 150) {
                    e.find(".content_reply_thanks").slimScroll({
                        color: '#ccc',
                        overflow: 'none',
                        height : 150,
                        width: 216
                    });
                }
            },
            dataType:"json"
        })
    });
</script>