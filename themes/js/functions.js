/**
Author: pmhung07@gmail.com
Version: 1
Description: TiengAnh2020
*/

/*SCROLL TOP HEADER*/
$(document).ready(function() {

	// SCROLL FIXED TOP
    /*$.event.add(window, "scroll", function() {
    	if(($( window ).width()) > 769){
	        var height_scroll = $(window).scrollTop();
	        if(height_scroll > 200){
				var style = {
					"position"    : "fixed",
					"background"  : "white",
					"padding-top" : "0px",
					"opacity"	  : "0.9"
				};
				var styletool = {
					"position"    : "fixed",
					"background"  : "rgb(3, 113, 133)",
					"padding-top" : "0px",
					"opacity"	  : "0.9",
					"top"		  : "110px"	
				}
				var stylechildmenu = {
					"top"		  : "150px"	
				}
				$(".header").css(style);
				$(".user-tool").css(styletool);
				$(".main-menu-child").css(stylechildmenu);
	        }else{
	        	var style = {
					"height"      : "110px",
					"padding-top" : "15px",
					"position"	  : "absolute",
					"width"  	  : "100%",
					"z-index"     : "1",
					"opacity"     : "1",
					"background"  : "none"
				};
				var styletool = {
					"top" 		  : "140px",	
					"height"      : "40px",
					"background"  : "rgb(3, 113, 133)",
					"position"	  : "absolute",
					"width"  	  : "100%",
					"z-index"     : "1",
					"opacity"     : "1",
					"background"  : "rgb(3, 113, 133)"
				}
				var stylechildmenu = {
					"top"		  : "165px"	
				}
	    		$('.header').css(style);
	    		$(".user-tool").css(styletool);
	    		$(".main-menu-child").css(stylechildmenu);
	        }
    	}
    });*/

    //ACTIVE MEGA MENU
    $(".main-menu-child").hide();

    if(($( window ).width()) > 769){
	    $(".main-menu-parent-courses-active").click(function(){
	    	$(".main-menu-child").fadeOut(300);
	    	$(this).parent(".main-menu-parent-courses").children(".main-menu-child").fadeIn(300);
			$(".main-menu-position").removeClass("main-menu-active");
			$(".main-menu-active-url").css("border","none");
			$(this).parent(".main-menu-parent-courses").children(".main-menu-position").addClass("main-menu-active");
			return false;
	    });

	    $(".main-menu-parent-skill-active").click(function(){
	     	$(".main-menu-child").fadeOut(300);
	    	$(this).parent(".main-menu-parent-skill").children(".main-menu-child").fadeIn(300);
			$(".main-menu-position").removeClass("main-menu-active");
			$(".main-menu-active-url").css("border","none");
			$(this).parent(".main-menu-parent-skill").children(".main-menu-position").addClass("main-menu-active");
			return false;
	    });

	    $(".main-menu-parent-library-active").click(function(){
	     	$(".main-menu-child").fadeOut(300);
	    	$(this).parent(".main-menu-parent-library").children(".main-menu-child").fadeIn(300);
			$(".main-menu-position").removeClass("main-menu-active");
			$(".main-menu-active-url").css("border","none");
			$(this).parent(".main-menu-parent-library").children(".main-menu-position").addClass("main-menu-active");
			return false;
	    });
	}
    //CLOSE MEGA MENU
    $(".close").click(function(){
    	$(".main-menu-child").fadeOut(300);
    	$(".main-menu-active-url").css("border","solid 2px #08bbb7");
    	$(".main-menu-position").removeClass("main-menu-active");
    	return false;
    });

    //ACTIVE MEGA MENU MOBILE
    $(".main-menu-toggle").click(function(){
    	if(!($(".main-menu").hasClass("main-menu-show"))){
	    	$(".main-menu").fadeIn(300);
	    	$(".main-menu").addClass("main-menu-show");
			return false;
		}else{
			$(".main-menu").fadeOut(300);
	    	$(".main-menu").removeClass("main-menu-show");
			return false;
		}
    });

    //ACTIVE MEGA MENU SERVICE 
    $(".item-menu-active").parent("li").children(".sub-menu-category").show();
    $(".item-menu-child-active").parent(".sub_menu_courses").parent(".sub-menu-category").parent("li").children(".item-parent-menu-courses").addClass("item-menu-active");
    $(".item-menu-child-active").parent(".sub_menu_courses").parent(".sub-menu-category").show();
    $(".item-menu-child-active").css("color","rgb(165, 1, 1)");

    //ACTIVE MENU SIDEBAR LIB
    $(".sp_active_lib_child").parent("ul").show();
	$(".lib-item-parent-menu-courses").click(function(){
    	$(".lib-sub-menu-category").fadeOut(300);
    	$(this).parent("li").children(".lib-sub-menu-category").fadeIn(300);
    });

    // ACTIVE TRANSLATE
    $(".masterTooltipTranslate").hide();
    $(".tool-translate-trans").click(function(){
    	if(!($(this).hasClass("activeTrans"))){
	    	$(this).addClass("activeTrans");
	    	$(".masterTooltipTranslate").fadeIn(300);
	    	return false;
    	}else{
    		$(this).removeClass("activeTrans");
    		$(".masterTooltipTranslate").fadeOut(300);
    		return false;
    	}
    });

    // LOGIN CHECK
	function check_login(){
		var email = $("#use_email").val();
		if(email == ""){
			alert("Bạn chưa nhập tên đăng nhập");
		 	return false ;
		}else{
		 	var pass = $("#use_password").val();
			if(pass.length == 0){
			    alert("Bạn chưa nhập mật khẩu");
			    $("#use_password").focus();
			    $("#use_password").select();
			    return false;
			}
		 else return true;
		}
    }

    $(".act-button-login").click(function(){
        if(check_login()== true){
            $("#login-form").submit();
        }return false;
    });

    // REGIS CHECK
 	function check_regis(){
 		var name 		= $("#regis_use_name").val();
 		var phone 		= $("#regis_use_phone").val();
		var email 		= $("#regis_use_email").val();
		var password 	= $("#regis_use_password").val();
		if(name == "" || phone == "" || email ==""){
			alert("Bạn chưa nhập đầy đủ thông tin đăng ký");
		 	return false ;
		}else{
		 	var pass = $("#regis_use_password").val();
			if(pass.length == 0){
			    alert("Bạn chưa nhập mật khẩu");
			    $("#regis_use_password").focus();
			    $("#regis_use_password").select();
			    return false;
			}
		 else return true;
		}
    }

    $(".act-button-regis").click(function(){
        if(check_regis()== true){
            $("#regis-form").submit();
        }return false;
    });

    // PAYMENT CHECK

	function IsEmail(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}

	function IsPhone(phoneNumber){
	   var phoneNumberPattern = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;  
	   return phoneNumberPattern.test(phoneNumber); 
	}

	function check_payment_step_info(){
		var name 	= $("#payment_name").val();
		var phone 	= $("#payment_phone").val();
		var email 	= $("#payment_email").val();
		var address = $("#payment_address").val();
		if(name == "" || phone == "" || email == "" || address == ""){
			alert("Bạn chưa nhập đầy đủ thông tin");
		 	return false ;
		}else if(name.length <= 4){
			alert("Họ và tên phải lớn hơn 4 ký tự");
		 	return false ;
		}else if(!IsPhone(phone)){
			alert("Bạn không nhập chính xác số điện thoại");
			$('.error-phone').show();
		 	return false ;
		}else if(!IsEmail(email)){
			alert("Bạn không nhập chính xác email");
		 	return false ;
		}else if(address.length <= 4){
			alert("Địa chỉ cung cấp phải lớn hơn 4 ký tự");
		 	return false ;
		}else{
			return true;
		}
    }

    $("#payment-btn-step-info").click(function(){
        if(check_payment_step_info()== true){
            $("#payment-form").submit();
        }return false;
    });

    /*function check_user_update_info(){
		var name 	= $("#payment_name").val();
		var phone 	= $("#payment_phone").val();
		var email 	= $("#payment_email").val();
		var address = $("#payment_address").val();
		if(name == "" || phone == "" || email == "" || address == ""){
			alert("Bạn chưa nhập đầy đủ thông tin");
		 	return false ;
		}else if(name.length <= 4){
			alert("Họ và tên phải lớn hơn 4 ký tự");
		 	return false ;
		}else if(!IsPhone(phone)){
			alert("Bạn không nhập chính xác số điện thoại");
			$('.error-phone').show();
		 	return false ;
		}else if(!IsEmail(email)){
			alert("Bạn không nhập chính xác email");
		 	return false ;
		}else if(address.length <= 4){
			alert("Địa chỉ cung cấp phải lớn hơn 4 ký tự");
		 	return false ;
		}else{
			return true;
		}
    }*/

    // PAYMENT
    $(".payment-list").click(function(){
    	$(".payment-list").removeClass('payment-method-active');
        $(this).addClass('payment-method-active');
        $(".payment_price_method").hide();
        var payment_title = $(this).attr('title');
        if(payment_title == "payment-method-visa"){
        	$(".payment_price_visa").fadeIn(300);
        }else if(payment_title == "payment-method-atm"){
        	$(".payment_price_atm").fadeIn(300);
        }else if(payment_title == "payment-method-internet-banking"){
        	$(".payment_price_internet_banking").fadeIn(300);
        }else if(payment_title == "payment-method-card"){
        	$(".payment_price_card").fadeIn(300);
        }
    });

    //SEARCH
	$('.homesearchtext').keypress(function (e) {
	    if (e.which == 13) {
	        $('form#home-search').submit();
	        return false;  
	    }
	});

	//HOVER MENU
	$( ".user-tool-info" ).hover(
		function() {
			$(".user-tool-info-list-date").css('display','block');
		}, function() {
			$(".user-tool-info-list-date").css('display','none');
		}
	);

	//CONFIRM REDIRECT PAYMENT
	$(".confirm-pay").click(function(){
		var txtConfirm;
		var btnComfirm = confirm("Chỉ với 30.000 vnđ bạn có thể học toàn bộ khóa học trên TiengAnh2020.");
		if (btnComfirm == true) {
		    location.href = "http://www.tienganh2020.com/payment.html";
		} else {
		    return false;
		}
	});

	//CONFIRM REDIRECT LOGGIN
	$(".confirm-loggin").click(function(){
		var txtConfirm;
		var btnComfirm = confirm("Bạn phải đăng nhập để có thể học thử các khóa học của TiengAnh2020.");
		if (btnComfirm == true) {
		    location.href = "http://tienganh2020.com/dang-nhap.html";
		} else {
		    return false;
		}
	});

	//ACTIVE MENU UNIT
    $(".menu-category-title-unit").click(function(){
    	if(!($(".menu-category-content-unit").hasClass("menu-category-content-unit-show"))){
	    	$(".menu-category-content-unit").fadeIn(300);
	    	$(".menu-category-content-unit").addClass("menu-category-content-unit-show");
		}else{
			$(".menu-category-content-unit").fadeOut(300);
	    	$(".menu-category-content-unit").removeClass("menu-category-content-unit-show");
		}
    });

    //ACTIVE MENU UNIT
    $(".menu-category-titlte").click(function(){
    	if(!($(this).hasClass("menu-category-content-active"))){
	    	$(".menu-category-content").fadeIn(300);
	    	$(this).addClass("menu-category-content-active");
		}else{
			$(".menu-category-content").fadeOut(300);
	    	$(this).removeClass("menu-category-content-active");
		}
    });

    $(".downinfo1").click(function(){
    	$('.learn-condition-content').hide();
    	if(!($(this).hasClass("down-active1"))){
	    	$(".downbotinfo1").fadeIn(300);
	    	$(this).addClass("down-active1");
		}else{
			$(".downbotinfo1").fadeOut(300);
	    	$(this).removeClass("down-active1");
		}
    });
    $(".downinfo2").click(function(){
    	$('.learn-condition-content').hide();
    	if(!($(this).hasClass("down-active2"))){
	    	$(".downbotinfo2").fadeIn(300);
	    	$(this).addClass("down-active2");
		}else{
			$(".downbotinfo2").fadeOut(300);
	    	$(this).removeClass("down-active2");
		}
    });
    $(".downinfo3").click(function(){
    	$('.learn-condition-content').hide();
    	if(!($(this).hasClass("down-active3"))){
	    	$(".downbotinfo3").fadeIn(300);
	    	$(this).addClass("down-active3");
		}else{
			$(".downbotinfo3").fadeOut(300);
	    	$(this).removeClass("down-active3");
		}
    });

	$( ".register_logged" ).hover(
	  	function() {
	  		$('.user_logged').css('font-weight','bold');
	    	$( '.user_dropdown' ).show();
	  	}, function() {
	  		$('.user_logged').css('font-weight','normal');
	    	$( '.user_dropdown' ).hide();
	  	}
	);

$( ".header_nal_parent" ).hover(
	  	function() {
	    	$( this ).children('.ul_child').show();
	  	}, function() {
	  		$( this ).children('.ul_child').hide();
	  	}
	);
});