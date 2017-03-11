<script>

function chk_true(tan_id){
   var change_true = $('#chk_true_'+tan_id).val();
   //alert(test);
   $.ajax({
      type:'POST',
      dataType:'json',
      data:{
      ans_id:tan_id,
      change_true:change_true
      },
      url:'chk_true.php',
      success:function(data){
   	if(data.err == ''){
   		alert(data.msg);	
   		window.location.reload();
   	}else{
   		alert(data.err);
   	}}
   });
}

//=============================================================

$('#para_select').change(function (){
   var iPara =	$("#para_select").val();
   window.location	=	"add_exercises.php?record_id=<?=$record_id?>&iPara=" + iPara;
});  

//=============================================================
$('#unit_select').change(function (){
   var iUnit =	$("#unit_select").val();
   if(iUnit == 1){$('#multi_choice').show();$('#drag').hide();$('#fill_word').hide();} 
   if(iUnit == 2){$('#drag').show();$('#multi_choice').hide();$('#fill_word').hide();} 
});

//=============================================================

function add_show(ans_id){
   $('#dv_add_action_invi_'+ans_id).show();
}

//======================MULTI CHOICE===========================

function add_multi_choice(exe_id){
   var iPara =	$("#para_select").val();
   if(iPara < 0){
      alert("Bạn chưa chọn Audio cho câu hỏi");
      return false;
   } 
   
   if($('#question').val() == ""){
      alert("Bạn chưa nhập câu hỏi");
      return false;
   } 
   if($('#ans_1').val() == ""){
      alert("Bạn chưa nhập câu trả lời : A");
      return false;
   } 
   if($('#ans_2').val() == ""){
      alert("Bạn chưa nhập câu trả lời : B");
      return false;
   } 
   if($('#ans_3').val() == ""){
      alert("Bạn chưa nhập câu trả lời : C");
      return false;
   } 
   if($('#ans_4').val() == ""){
      alert("Bạn chưa nhập câu trả lời : D");
      return false;
   } 

   var ans_1 = $('#ans_1').val();
   var ans_2 = $('#ans_2').val();
   var ans_3 = $('#ans_3').val();
   var ans_4 = $('#ans_4').val();
   var true_ans_1 = $('#rdo_1').val();
   var true_ans_2 = $('#rdo_2').val();
   var true_ans_3 = $('#rdo_3').val();
   var true_ans_4 = $('#rdo_4').val();
   var question = $('#question').val();
   var ans_true = $('#ans_true').val();
   var type_ques = $('#unit_select').val();
   $.ajax({
      type:'POST',
      dataType:'json',
      data:{
         iPara:iPara,
         ans_1:ans_1,
         ans_2:ans_2,
         ans_3:ans_3,
         ans_4:ans_4,
         true_ans_1:true_ans_1,
         true_ans_2:true_ans_2,
         true_ans_3:true_ans_3,
         true_ans_4:true_ans_4,
         question:question,
         ans_true:ans_true,
         type_ques:type_ques
      },
      url:'multi_choice_load.php',
      success:function(data){
      	if(data.err == ''){
      		alert(data.msg);	
      		window.location.reload();
      	}else{
      		alert(data.err);
      	}}
   });
}

//=========================DRAG AND DROP=======================

function add_multi_choice_1(exe_id){
   var iPara =	$("#para_select").val();
   if(iPara < 0){
      alert("Bạn chưa chọn audio cho câu hỏi");
      return false;
   } 
   
   if($('#question_mul').val() == ""){
      alert("Bạn chưa nhập câu hỏi");
      return false;
   } 
   if($('#ans_mul_1').val() == ""){
      alert("Bạn chưa nhập câu trả lời : 1");
      return false;
   } 
   if($('#ans_mul_2').val() == ""){
      alert("Bạn chưa nhập câu trả lời : 2");
      return false;
   } 
   if($('#ans_mul_3').val() == ""){
      alert("Bạn chưa nhập câu trả lời : 3");
      return false;
   } 
   if($('#ans_mul_4').val() == ""){
      alert("Bạn chưa nhập câu trả lời : 4");
      return false;
   }       

   var ans_1 = $('#ans_mul_1').val();
   var ans_2 = $('#ans_mul_2').val();
   var ans_3 = $('#ans_mul_3').val();
   var ans_4 = $('#ans_mul_4').val();
   
   var true_drag_1 = $('#true_mul_1').val();
   var true_drag_2 = $('#true_mul_2').val();
   var true_drag_3 = $('#true_mul_3').val();
   var true_drag_4 = $('#true_mul_4').val();
                                 
   var question = $('#question_mul').val();
   $.ajax({
      type:'POST',
      dataType:'json',
      data:{
         iPara:iPara,
         ans_1:ans_1,
         ans_2:ans_2,
         ans_3:ans_3,
         ans_4:ans_4,
         true_drag_1:true_drag_1,
         true_drag_2:true_drag_2,
         true_drag_3:true_drag_3,
         true_drag_4:true_drag_4,                                                                      
         question:question,
      },
      url:'multi_choice_load_1.php',
      success:function(data){
      	if(data.err == ''){
      		alert(data.msg);	
      		window.location.reload();
      	}else{
      		alert(data.err);
      	}}
   });
}

function add_drag(exe_id){
   var iPara =	$("#para_select").val();
   if(iPara < 0){
      alert("Bạn chưa chọn audio cho câu hỏi");
      return false;
   } 
   
   if($('#question_drag').val() == ""){
      alert("Bạn chưa nhập câu hỏi");
      return false;
   } 
   if($('#ans_drag_1').val() == ""){
      alert("Bạn chưa nhập câu trả lời : 1");
      return false;
   } 
   if($('#ans_drag_2').val() == ""){
      alert("Bạn chưa nhập câu trả lời : 2");
      return false;
   } 
   if($('#ans_drag_3').val() == ""){
      alert("Bạn chưa nhập câu trả lời : 3");
      return false;
   } 
   if($('#ans_drag_4').val() == ""){
      alert("Bạn chưa nhập câu trả lời : 4");
      return false;
   }       

   var ans_1 = $('#ans_drag_1').val();
   var ans_2 = $('#ans_drag_2').val();
   var ans_3 = $('#ans_drag_3').val();
   var ans_4 = $('#ans_drag_4').val();
   
   var true_drag_1 = $('#true_drag_1').val();
   var true_drag_2 = $('#true_drag_2').val();
   var true_drag_3 = $('#true_drag_3').val();
   var true_drag_4 = $('#true_drag_4').val();
                                 
   var question = $('#question_drag').val();
   $.ajax({
      type:'POST',
      dataType:'json',
      data:{
         iPara:iPara,
         ans_1:ans_1,
         ans_2:ans_2,
         ans_3:ans_3,
         ans_4:ans_4,
         true_drag_1:true_drag_1,
         true_drag_2:true_drag_2,
         true_drag_3:true_drag_3,
         true_drag_4:true_drag_4,                                                                      
         question:question,
      },
      url:'drag_load.php',
      success:function(data){
      	if(data.err == ''){
      		alert(data.msg);	
      		window.location.reload();
      	}else{
      		alert(data.err);
      	}}
   });
}

//=============================================================
function save_question(que_id){
   if(confirm("Bạn có chắc muốn sửa câu hỏi này không?")){
   var que_content = $('#ques_content_'+que_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   que_id:que_id,
         que_content:que_content,
      },
		url:'edit_ans_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}

//=============================================================

function save_answers(ans_id){
   if(confirm("Bạn có chắc muốn sửa câu hỏi này không?")){
   var ans_content = $('#ans_content_'+ans_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   ans_id:ans_id,
         ans_content:ans_content,
      },
		url:'edit_ans_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}

//=============================================================

function deny_media(media_id){
   if(confirm("B?n có ch?c mu?n xóa Media này không?")){
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   media_id:media_id,
      },
		url:'delete_media.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}

//=============================================================

function set_true(ans_id,ans_ques_id){
   $.ajax({
      type:'POST',
      dataType:'json',
      data:{
      ans_id:ans_id,
      ans_ques_id:ans_ques_id
      },
      url:'set_true.php',
      success:function(data){
   	if(data.err == ''){
   		alert(data.msg);	
   		window.location.reload();
   	}else{
   		alert(data.err);
   	}}
   });
}

//=============================================================

function del_question(que_id){
   if(confirm("Bạn có chắc muốn xóa câu hỏi này không?")){
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{que_id:que_id},
		url:'del_ans_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}

//=============================================================

function del_answers(ans_id){
   if(confirm("B?n có ch?c mu?n xóa câu tr? l?i này không?")){
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{ans_id:ans_id},
		url:'del_ans_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}

//=============================================================

function deny_med(med_id){
   if(confirm("B?n có ch?c mu?n h?y media c?a câu h?i này không?")){
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{med_id:med_id},
		url:'denymed.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}deny_med

//=============================================================

function add_ans_multi(que_id){
var add_ans_content = $('#add_ans_content_'+que_id).val();
$.ajax({
   type:'POST',
   dataType:'json',
   data:{que_id:que_id,
         add_ans_content:add_ans_content},
   url:'add_ans_ques.php',
   success:function(data){
   	if(data.err == ''){
   		alert(data.msg);	
   		window.location.reload();
   	}else{
   		alert(data.err);
   	}}
   });
}

//=============================================================

function add_media(que_id){
   var que_media_id = $('#media_select_'+que_id).val();
   if(que_media_id > 0){
   	$.ajax({
   		type:'POST',
   		dataType:'json',
   		data:{
   		   que_id:que_id,
            que_media_id:que_media_id,
         },
   		url:'add_media_ques.php',
   		success:function(data){
   			if(data.err == ''){
   				alert(data.msg);	
   				window.location.reload();
   			}else{
   				alert(data.err);
   			}
         }
      });
   }
}

function check_rdo_true(numtrue){
   for(var i=0;i < 5;i++){
      $('#rdo_'+i).attr("value","0");
   }
   $('#rdo_'+numtrue).attr("value","1");
}

function check_chb_true(numtrue){
   if($('#true_drag_'+numtrue).val() == 1){
       $('#true_drag_'+numtrue).attr("value","0");
   }else{
   $('#true_drag_'+numtrue).attr("value","1");
}}

function check_chb_mul_true(numtrue){
   if($('#true_mul_'+numtrue).val() == 1){
       $('#true_mul_'+numtrue).attr("value","0");
   }else{
   $('#true_mul_'+numtrue).attr("value","1");
}}
//============================================================
function score_ques(record_id){
   var score_ques = $('#score_ques_'+record_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   score_ques:score_ques,
         ques_id:record_id,
      },
		url:'score_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}

//============================================================
function order_ques(record_id){
   var order_ques = $('#order_ques_'+record_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   order_ques:order_ques,
         ques_id:record_id,
      },
		url:'order_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}
</script>