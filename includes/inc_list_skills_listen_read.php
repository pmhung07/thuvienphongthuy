<?php
// $arrSkill : ARRAY SAVE INFO skill_lesson table
$iLes       = $arrSkill[0]['skl_les_id'];

$dbCont     = new db_query('SELECT * FROM skill_content
                                    WHERE skl_cont_les_id = '.$iLes.'
                                      AND skl_cont_type = 1 AND skl_cont_active = 1
                                    ORDER BY skl_cont_order ASC');
?>

<?php while($rowCont = mysqli_fetch_assoc($dbCont->result)){ ?>
    <?php
    $content = trim($rowCont['skl_content']);
    if($content != ''){
        echo '<div class="guide">'.$content.'</div>';
    }else{
        echo '<div class="guide">'.$arrSkill[0]['skl_les_desc'].'</div>';
    }

    $sqlMain = new db_query("SElECT * FROM main_lesson WHERE main_skl_cont_id = ".$rowCont['skl_cont_id']." ORDER BY main_order");
    $mainPart = 'http://'.$base_url.'/data/skill_content/';
    $i = 0;
    while($rowMain  = mysqli_fetch_assoc($sqlMain->result)){
    ?>
        <div class="main_media">
            <div class="center_box">
                <?php
                $i++;
                if($rowMain['main_media_type'] == 1){ ?>

                    <center><img src="<?=$mainPart?>medium_<?=$rowMain['main_media_url1']?>" /></center>

                <?php }else if($rowMain['main_media_type'] == 2){ ?>

                    <?php
                    $file   = $mainPart.$rowMain['main_media_url1'];
                    get_media_skill_v2($file,$i);
                    ?>

                <?php }elseif($rowMain['main_media_type'] == 3){ ?>

                    <?php echo "<center><object width='491' height='400'><embed src='". $mainPart.$rowMain['main_media_url1']."' width='491' height='400' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' menu='false' wmode='transparent'></embed></object></center>"; ?>

                <?php } ?>

                <?php
                $typeMain = $rowMain['main_type'];
                $mainContentEn = $rowMain['main_content_en'];
                $mainContentVi = $rowMain['main_content_vi'];
                ?>
            </div><!-- End .center_box -->
        </div><!-- End .main_media -->

    <?php }unset($sqlMain); ?>
<?php }unset($dbCont); ?>

<div class="tab_m">
    <div class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
            <li class="active" class="li1"><a href="#tab1" data-toggle="tab">Nội dung</a></li>
            <li class="li2"><a href="#tab2" data-toggle="tab">Lý thuyết</a></li>
            <li class="li4"><a href="#tab4" data-toggle="tab">Bài tập</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
            <?php if($typeMain == 1){ ?>
            <div>
                <div class="notrans" >
                    <div>
                        <?=getMainCTran($mainContentEn,$mainContentVi)?>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
                <div class="lib-tool-translate">
                    <span class="tool-translate-trans">Xem bản dịch</span>
                </div>
                <div class="lib-trans">
                    <?=getMainCTran($mainContentEn,$mainContentVi)?>
                </div>
            <?php } ?>
            </div><!-- End #tab1 -->
            <div class="tab-pane" id="tab2">
                <?php include_once('inc_list_skills_gramma.php');?>
            </div><!-- End #tab2 -->
            <div class="tab-pane" id="tab4">
                <?php include_once('inc_list_skills_quiz.php');?>
            </div><!-- End #tab4 -->
        </div><!-- End .tab-content -->
   </div>
</div><!-- End .tab_m -->