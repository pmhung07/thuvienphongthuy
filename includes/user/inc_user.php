<?php
    $mod = getValue("mod","str","GET","");
?>
<div class="list-courses">
	<div class="list-courses-filter">
		<div class="content">
			<div class="content-main">
				<div class="list-courses-filter-title">
                    <div class="wrap-search-google-module">
                        <div class="search-google-module">
                            <script>
                            (function() {
                            var cx = '014392461875755904911:x7kjjrisdw4';
                            var gcse = document.createElement('script');
                            gcse.type = 'text/javascript';
                            gcse.async = true;
                            gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                            '//www.google.com/cse/cse.js?cx=' + cx;
                            var s = document.getElementsByTagName('script')[0];
                            s.parentNode.insertBefore(gcse, s);
                            })();
                            </script>
                            <gcse:search></gcse:search>
                        </div>
                    </div>
					<div class="list-courses-filter-title-main">
						<span>Quản lý thông tin cá nhân</span>
					</div>
					<span class="list-courses-filter-title-breadcrumb">
                        <a>Trang chủ</a> 
                        <span></span>
                        <a>QUẢN LÝ THÔNG TIN CÁ NHÂN</a>
					</span>
				</div>
				<div class="list-courses-filter-search">
					<form method="get" id="courses-search" class="courses-search" action="http://<?=$base_url?>/home/search.php">
                        <input type="submit" class="search-searchtext-module" value="">
                        <input id="searchtext" class="searchtext-module" name="searchtext" type="text" value="" placeholder="Khóa học">
                        <input type="hidden" name="search-type" value="courses">
                    </form>
				</div>
			</div>
		</div>
	</div>
	<div class="list-courses-main">
		<div class="content">
			<div class="content-main">
				<div class="list-courses-main-sidebar">
					<?php include_once('../includes/inc_sidebar_user.php');?>
				</div>
				<div class="list-courses-main-user">
                    <?php
                    switch ($mod) {
					    case 'userInfo':
					        include_once('../includes/user/inc_user_info.php');
					    break;
					    case 'userAssistant':
					        include_once('../includes/user/inc_user_assistant.php');
					    break;
					    case 'userMypractice':
					        include_once('../includes/user/inc_user_myas.php');
					    break;
					    case 'userMes':
					        include_once('../includes/user/inc_user_mes.php');
					    break;
					    case 'userMesAdmin':
					        include_once('../includes/user/inc_user_mes_admin.php');
					    break;
					    case 'userMesAdminTeach':
					        include_once('../includes/user/inc_user_mes_adminteach.php');
					    break;
					    case 'userExp':
					        include_once('../includes/user/inc_user_exp.php');
					    break;
					    case 'userAcc':
					        include_once('../includes/user/inc_user_acc.php');
					    break;
					    case 'SendMesTeach':
					    	include_once('../includes/user/inc_sendmesteach.php');
					    break;
					    default:
							include_once('../includes/user/inc_user_info.php');
					    break;
					}
                    ?>
				</div>
			</div>
		</div>
	</div>
</div>