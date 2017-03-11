<?php
    $arrayBgColor = array('#56BDC2','#E9BE34','#D66060','#DA670B');
?>
<?php include_once('../includes/inc_slider.php');?>

<div class="main_home_details">
    <div class="content">
        <div class="content-main">
            <div class="main_home_details_right">
                <div class="main_home_details_right_title">
                    KHOÁ HỌC MỚI NHẤT
                </div>
                <?php
                $dbCourses = new db_query('SELECT * FROM courses LIMIT 16');
                $arrCourses = $dbCourses->resultArray();

                ?>
                <div class="main_home_details_right_content">
                    <?php $count = 1; foreach($arrCourses as $key=>$value) { ?>
                    <div class="home_detail_right_details" <?=($count == 1)?'style="margin-left:0px;"':'';?>>
                        <div class="home_dtls_right_img">
                            <a href="<?=gen_course_info($value['cou_id'],$value['cou_name'])?>">
                                <?php if($value['cou_avatar'] != ''){ ?>
                                    <img src="<?=$var_path_course.$value['cou_avatar']?>">
                                <?php }else{ ?>
                                    <img src="http://thuvienphongthuy.vn/themes/img/no-image.png">
                                <?php } ?>
                            </a>
                        </div>
                        <div class="home_dtls_right_name">
                            <a href="<?=gen_course_info($value['cou_id'],$value['cou_name'])?>">
                                <span style="border-bottom: solid 3px;padding-bottom: 5px;" class="namecourse"><?=$value['cou_name']?></span>
                            </a>
                        </div>
                    </div>
                    <?php $count++;} ?>
                </div>
            </div>
    </div>
</div>