// JavaScript Document
$(function(){
	/*$('.content_main').slimScroll({
		height: '550px'
	});
	$('.top_right_lightbox').slimScroll({
		height: '500px'
	});*/
	
	
	// Tooltip only Text
	$('.lessonTooltip').hover(function(){
			// Hover over code
			var title = $(this).attr('title');
			$(this).data('tipText', title).removeAttr('title');
			$('<p class="tooltip" style="text-align:center;width: 70px;z-index:1200;line-height: 16px;font-family:Arial, Helvetica, sans-serif;opacity:1;"></p>')
			.text(title)
			.appendTo('body')
			.fadeIn('slow');
	}, function() {
			// Hover out code
			$(this).css("background", "none");
			$(this).attr('title', $(this).data('tipText'));
			$('.tooltip').remove();
	}).mousemove(function(e) {
			var mousex = e.pageX - 24; //Get X coordinates
			var mousey = e.pageY + 10; //Get Y coordinates
			$('.tooltip')
			.css({ top: mousey, left: mousex, })
	});
	
	
	// Tooltip only Text
        $('.masterTooltip').hover(function(){
                // Hover over code
                $(this).css("background", "yellow");
                var title = $(this).attr('title');
                $(this).data('tipText', title).removeAttr('title');
                $('<p class="tooltip" style="border-radius:3px;font-size:12px;color:white;background:#16514B!important;width: 400px;z-index:1000;line-height: 20px;font-family:Arial, Helvetica, sans-serif;opacity:0.9!important;padding:5px!important;"></p>')
                .text(title)
                .appendTo('body')
                .fadeIn('slow');
        }, function() {
                // Hover out code
                $(this).css("background", "none");
                $(this).attr('title', $(this).data('tipText'));
                $('.tooltip').remove();
        }).mousemove(function(e) {
                var mousex = e.pageX + 20; //Get X coordinates
                var mousey = e.pageY + 10; //Get Y coordinates
                $('.tooltip')
                .css({ top: mousey, left: mousex, })
        });
	//Close Badge Notice
	 $(".closeb").click(function(){
		$("#b_notice").css("display","none");
		$("#fade").css("display","none");
		$("#light").css("display","none");
	 });
	 
	//Phan dich cho main
	$('.trans').css('display','none');
    $('.button_dich').click(function(){
        $(this).addClass('active');
       $('.bot_left_lightbox .notrans').css('display','none');
       $('.bot_left_lightbox .trans').css('display','block');
       $('#text_support').show(800);
    });
	
	// Phan dich cho main của toeic
	$('.trans').css('display','none');
    $('.button_dich').click(function(){
        $(this).addClass('active');
       $('.notrans').css('display','none');
       $('.trans').css('display','block');
       $('#text_support').show(800);
    });
   $(document).ready(function(){
      $('.top_nav').css("position","absolute");
   });
});