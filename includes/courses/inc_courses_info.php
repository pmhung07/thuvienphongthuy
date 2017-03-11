<?php
$iCourses = getValue('iCourses','int','GET',0);
$dbCourses = new db_query('SELECT * FROM courses INNER JOIN categories_multi ON courses.cou_cat_id=categories_multi.cat_id WHERE cou_id='.$iCourses);
$arrCourses = $dbCourses->resultArray();

$dbCoursesRelated = new db_query('SELECT * FROM courses INNER JOIN categories_multi ON courses.cou_cat_id=categories_multi.cat_id WHERE cou_cat_id='.$arrCourses[0]['cat_id'].' AND cou_id != '.$iCourses.' LIMIT 3');
$arrCoursesRelated = $dbCoursesRelated->resultArray();

$dbUnit = new db_query("SELECT * FROM courses_multi WHERE com_cou_id =".$arrCourses[0]['cou_id']." ORDER BY com_num_unit");
$arrUnit = $dbUnit->resultArray();
?>


<div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-wrap">
                    <div class="list-courses-filter-title">
                        <div class="list-courses-filter-title-main">
                            <span><h1><?=$arrCourses[0]['cou_name']?></h1></span>
                        </div>
                        <div class="list-description">
                            <?=$arrCourses[0]['cou_info']?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="courses-learn-left-listing">

    <div class="learn_left_title_listing_price" style="background: url('http://hosoxinviec.vn/themes/img/price.png') no-repeat;
    background-size: 35px;
    background-position: 30px;">
        Giá : <span><?=format_number($arrCourses[0]['cou_price'])?> vnđ</span>
    </div>

    <div class="learn_left_title_listing_buy"  style="">
        <a><span>Mua khóa học</span></a>
    </div>

    <div class="learn-condition-title downinfo1" style="background:#d4d4d4 url('http://hosoxinviec.vn/themes/img/users.png') no-repeat;
    background-size: 35px;
    background-position: 30px;">
        Đối tượng học
    </div>
    <div class="learn-condition-content downbotinfo1" >
        <?=$arrCourses[0]['cou_object']?>
    </div>
    <div class="learn-condition-title downinfo2" style="background:#d4d4d4 url('http://hosoxinviec.vn/themes/img/target.png') no-repeat;
    background-size: 35px;
    background-position: 30px;">
        Mục tiêu khóa học
    </div>
    <div class="learn-condition-content downbotinfo2">
        <?=$arrCourses[0]['cou_goal']?>
    </div>
    <div class="learn-condition-title downinfo3" style="background:#d4d4d4 url('http://hosoxinviec.vn/themes/img/condition.png') no-repeat;
    background-size: 35px;
    background-position: 30px;">
       Điều kiện
    </div>
    <div class="learn-condition-content downbotinfo3">
        <?=$arrCourses[0]['cou_condition']?>
    </div>
</div>
<div class="courses-learn-right-cac">
    <?php foreach($arrUnit as $key => $value){ ?>
    <?php // Đoạn này lấy random tab, lay tab đầu tiền
    $dbTab = new db_query("SELECT * FROM courses_multi_tabs WHERE cou_tab_com_id =".$value['com_id']);
    $arrTab = $dbTab->resultArray();
    ?>
    <div class="list-chitiet-hoc">
        <?php if($value['com_image'] != ""){ ?> 
        <img src="http://<?=$base_url?>/pictures/courses/<?=$value['com_image']?>" style="width:100%;height:auto;max-height:180px;">
        <?php }else{?>
        <img src="http://thuvienphongthuy.vn/themes/img/no-image.png">
        <?php } ?>
        <?php
        @$iUnitdata = $value['com_id'];
        @$iTabdata = $arrTab[0]['cou_tab_id'];
        if($iUnitdata == 0 || $iTabdata == 0){
            $urlDetails = "#";
        }else{
            $urlDetails = gen_course_lesson($iCourses,$arrCourses[0]['cou_name'],$value['com_id'],$arrTab[0]['cou_tab_id'],$value['com_name']);
        }
        ?>
        <div class="textunitcenter">
        <a href="<?=$urlDetails?>">
            <?=$value['com_name']?>
        </a>
        </div>
    </div>
    <?php } ?>
</div>