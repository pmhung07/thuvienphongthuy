<script type="text/javascript">

function save_question(que_id){
   if(confirm("Bạn có muốn sửa câu hỏi này không?")){
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

//============================================================
function save_del_ques_tit(que_id,type){
   var conf = "";
   if(type == 1) conf = "Bạn có muốn sửa tiêu đề câu hỏi này không?";
   else if(type == 2) conf = "Bạn có muốn xóa tiêu đề câu hỏi này không?";
   if(confirm(conf)){
   var que_tit = $('#ques_tit_'+que_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   que_id:que_id,
         que_tit:que_tit,
         type:type
      },
		url:'save_del_ques_tit.php',
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
   if(confirm("Bạn có muốn sửa câu trả lời này không?")){
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
   if(confirm("Bạn có muốn xóa câu hỏi này không?")){
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
   if(confirm("Bạn có muốn xóa câu trả lời này không?")){
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

</script>
