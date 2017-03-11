<?php for($j = 1;$j <= 4;$j++) { ?>
<div class="main_home_details">
    <div class="content">
        <div class="content-main">
            <div class="main_home_details_left">
                <div class="main_home_details_left_title">
                    Meet The Instructor
                </div>
                <div class="main_home_details_left_content">
                    <div class="home_content_left_list_details">
                        <div class="home_left_content_img">
                            <img src="http://<?=$base_url?>/themes/img/trainer-1.jpg">
                        </div>
                        <div class="home_left_content_details">
                            <div class="home_left_content_details_name">Michael Bubble</div>
                            <div class="home_left_content_details_project">Project Manager</div>
                            <div class="home_left_content_details_des">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                        </div>
                    </div>
                    <div class="home_content_left_list_details">
                        <div class="home_left_content_img">
                            <img src="http://<?=$base_url?>/themes/img/trainer-2.jpg">
                        </div>
                        <div class="home_left_content_details">
                            <div class="home_left_content_details_name">Michael Bubble</div>
                            <div class="home_left_content_details_project">Project Manager</div>
                            <div class="home_left_content_details_des">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                        </div>
                    </div>
                    <div class="home_content_left_list_details">
                        <div class="home_left_content_img">
                            <img src="http://<?=$base_url?>/themes/img/trainer-3.jpg">
                        </div>
                        <div class="home_left_content_details">
                            <div class="home_left_content_details_name">Michael Bubble</div>
                            <div class="home_left_content_details_project">Project Manager</div>
                            <div class="home_left_content_details_des">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main_home_details_right">
                <div class="main_home_details_right_title">
                    ACCA
                </div>
                <div class="main_home_details_right_content">
                    <?php for($i = 1;$i <= 8;$i++) { ?>
                    <div class="home_detail_right_details">
                        <div class="home_dtls_right_img">
                            <a href="http://<?=$base_url?>/cv-details.htm">
                                <img src="http://<?=$base_url?>/themes/img/course<?=$i?>.jpg">
                            </a>
                        </div>
                        <div class="home_dtls_right_name">
                            <a href="http://<?=$base_url?>/cv-details.htm">
                                Course Name
                            </a>
                        </div>
                        <div class="home_dtls_right_author">
                            Le Minh Dzung
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="main_home_url_category" style="background:<?=$arrayBgColor[$j-1]?>">
                <span>Hơn 500 khóa học cùng 107 đối tác </span>
                <a>XEM NGAY</a>
            </div>
        </div>
    </div>
</div>
<?php } ?>