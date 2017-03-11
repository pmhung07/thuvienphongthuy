<?php
/* PAGING */
$count_news = 80;
$num_new_list = 10;
$total = $count_news;
$page = getValue('page','int','GET',0);
$start = $page;
if(intval($start) == 0){
   $page = 1;
}
$pageCount = (int)($total/$num_new_list);
$div = $total % $num_new_list;          
if($div!= 0){
   $pageCount = $pageCount + 1;
}
$pageCount;
if($page > $pageCount){
   $page = 1;
}
$start = ($page-1)*$num_new_list;
$str = '';

//FREE RAM
?>
<div class="list-courses">
    <div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-wrap">
                    <div class="list-courses-filter-title-post">
                        <span><h1>Tin tức hamhoc.edu.vn</h1></span>
                    </div>
                    <div class="list-courses-filter-cate-posts">
                        <select class="filter_category_courses">
                            <option value="-1">Danh mục Tin tức</option>
                            <option value="1">Lịch học</option>
                            <option value="2">Tin tức Hamhoc.edu.vn</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="list-courses-main-content-show-news community-content-show-news">  
                        <div class="main_category_left">
                            <div class="main_category_left_content_top">
                                <div class="main_category_left_content_top_images">
                                    <a href="#">
                                        <img src="http://<?=$base_url?>/themes/img/bninfo1.jpg">
                                    </a>
                                </div>
                                <div class="main_category_left_content_top_details">
                                    <div class="main_category_left_content_top_title">
                                        <a href="#">
                                            Nhận học bổng từ Hamhoc có giá trị lên tơi 2 tỷ đồng
                                        </a>
                                    </div>
                                    <div class="main_category_left_content_top_sapo">
                                        Lorem Ipsum chỉ đơn giản là một đoạn văn bản giả, được dùng vào việc trình bày và dàn trang phục vụ cho in ấn. Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500
                                    </div>
                                </div>
                            </div>
                            <div class="main_category_left_content_bot">
                                <ul>
                                    <li>
                                        <div class="main_category_left_content_bot_img">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[2]['post_title'])?>/c<?=$arrItemNews[2]['pcat_id']?>p<?=$arrItemNews[2]['post_id']?>.html">
                                                <img src="http://<?=$base_url?>/themes/img/bninfo2.jpg">
                                            </a>
                                        </div>
                                         <div class="main_category_left_content_bot_title">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[2]['post_title'])?>/c<?=$arrItemNews[2]['pcat_id']?>p<?=$arrItemNews[2]['post_id']?>.html">
                                                Lịch học tuần 3 quý II
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="main_category_left_content_bot_img">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[3]['post_title'])?>/c<?=$arrItemNews[3]['pcat_id']?>p<?=$arrItemNews[3]['post_id']?>.html">
                                                <img src="http://<?=$base_url?>/themes/img/bninfo3.jpg">
                                            </a>
                                        </div>
                                         <div class="main_category_left_content_bot_title">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[3]['post_title'])?>/c<?=$arrItemNews[3]['pcat_id']?>p<?=$arrItemNews[3]['post_id']?>.html">
                                                Danh sách các bạn nhận thưởng tuần 6 từ Hamhoc
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="main_category_left_content_bot_img">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[4]['post_title'])?>/c<?=$arrItemNews[4]['pcat_id']?>p<?=$arrItemNews[4]['post_id']?>.html">
                                                <img src="http://<?=$base_url?>/themes/img/blog16.jpg">
                                            </a>
                                        </div>
                                         <div class="main_category_left_content_bot_title">
                                            <a href="http://<?=$base_url?>/tin-tuc/<?=removeTitle($arrItemNews[4]['post_title'])?>/c<?=$arrItemNews[4]['pcat_id']?>p<?=$arrItemNews[4]['post_id']?>.html">
                                                Nguyễn Ngọc Anh nhận học bổng toàn phần từ Harvard
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>     

                            <div class="main_category_newest_title">
                                Mới nhất
                            </div>
                            <div class="community-content-show">
                                <?php 
                                    $start  = 1;
                                    $end    = 2;
                                ?>
                                <?php $countItemNews = 1; ?>

                                    <!---->
                                    <div class="content-show-news">
                                        <div class="news_show_img">
                                            <img src="http://<?=$base_url?>/themes/img/bninfo1.jpg">
                                        </div>
                                        <div class="content-show-courses-info news-show-info">
                                            <div class="content-show-courses-info-price news-show-price">
                                                <a href="#">
                                                    <span>Nguyễn Ngọc Anh nhận học bổng toàn phần từ Harvard</span>
                                                </a>
                                            </div>
                                            <div class="content-show-courses-info-price news-show-des">
                                                <span>Lorem Ipsum chỉ đơn giản là một đoạn văn bản giả, được dùng vào việc trình bày và dàn trang phục vụ cho in ấn. Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-show-news">
                                        <div class="news_show_img">
                                            <img src="http://<?=$base_url?>/themes/img/bninfo2.jpg">
                                        </div>
                                        <div class="content-show-courses-info news-show-info">
                                            <div class="content-show-courses-info-price news-show-price">
                                                <a href="#">
                                                    <span>Nguyễn Ngọc Anh nhận học bổng toàn phần từ Harvard</span>
                                                </a>
                                            </div>
                                            <div class="content-show-courses-info-price news-show-des">
                                                <span>Lorem Ipsum chỉ đơn giản là một đoạn văn bản giả, được dùng vào việc trình bày và dàn trang phục vụ cho in ấn. Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500</span>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <?php /*PAGING*/ ?>
                            <div class="paging">
                                <div class="paging_listing">
                                    <ul>
                                    <?if($pageCount > 1){?>
                                        <?php if($page > 1){
                                            $str .= '<a title="'.($page-1).'" class="a_paging listing_page_pre"> < </a>';
                                        }?>
                                        <?php
                                        if($pageCount > 10){
                                            if($page < 9){
                                                if($page < 6){
                                                    for ($i=1; $i<=9; $i++) {
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }else{
                                                    for ($i=1; $i<$page+4; $i++) {
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }
                                                $str .= '<a>…</a>';
                                                for ($j = ($pageCount - 1); $j <= $pageCount; $j++) { 
                                                    $str .= '<a class="a_paging" title="'.$j.'">'.$j.'</a>';
                                                }
                                            }else{
                                                $go_page = $page + 4;
                                                if($pageCount - $page > 8 && $go_page < $pageCount - 3){
                                                    for ($i=1; $i<=2; $i++) { 
                                                        $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                    }
                                                    $str .= '<a>…</a>';
                                                    $go_page = ($page + 3 > $pageCount)?$pageCount - 2: $page + 3;
                                                    for($i = ($page - 3); $i <= $go_page; $i++){
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                    $str .= '<span>…</span>';
                                                    for ($j = ($pageCount - 1); $j <= $pageCount; $j++) { 
                                                        $str .= '<a class="a_paging" title="'.$j.'">'.$j.'</a>';
                                                    }
                                                }else{
                                                    if($pageCount-$page < 6) {
                                                        for ($i=1; $i<=2; $i++) { 
                                                           $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                        $str .= '<span>…</span>';
                                                        for ($i= $pageCount - 8; $i<=$pageCount; $i++) {
                                                            if($i == $page){
                                                                $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                            }else{
                                                                $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                            }
                                                        }
                                                    }else{
                                                        for ($i=1; $i<=2; $i++) { 
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                        $str .= '<span>…</span>';
                                                        for ($i= $page - 3;$i<=$pageCount; $i++) {
                                                            if($i == $page){
                                                                $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                            }else{
                                                                $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                            }
                                                        }
                                                    }
                                                }}}else{
                                                    for ($i= 1;$i<=$pageCount; $i++) {
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }
                                                ?>
                                                <?if($page < $pageCount){
                                                    $str .= '<a title="'.($page+1).'" class="a_paging listing_page_next"> > </a>';
                                                }?>
                                            <?}?>
                                        <?echo $str;?>
                                    </ul>
                                </div>
                            </div>
                            <script type="text/javascript">
                            $(document).ready(function(){
                              $('.a_paging').click(function(){
                                 var page = $(this).attr('title');
                                 $.ajax({
                                    type:'POST',
                                    dataType:'json',
                                    url:'http://<?=$base_url?>/ajax/paging_news.php',
                                    data:{
                                        iCategory:<?=$iCategory?>,
                                        page:page,
                                        pageCount:<?=$pageCount?>,
                                    },
                                    success:function(data){
                                        $(".community-content-show").fadeOut(0,function(){
                                            $(this).html(data.list_cou).fadeIn(500);
                                        })
                                    }
                                 });
                              });
                            });
                            </script>
                        </div>  

                        <div class="main_category_right">
                            <div class="main_category_right_viewest">
                                <div class="main_category_right_viewest_title">
                                    Xem nhiều 
                                </div>
                                <div class="main_category_right_viewest_content">

                                    <div class="main_category_right_viewest_content_post">
                                        <div class="main_category_right_viewest_content_images">
                                            <a href="#">
                                                <img src="http://<?=$base_url?>/themes/img/bninfo1.jpg">
                                            </a>
                                        </div>
                                        <div class="main_category_right_viewest_content_title">
                                            <a href="#">
                                                Nguyễn Ngọc Anh nhận học bổng toàn phần từ Harvard
                                            </a>
                                        </div>
                                    </div>
                                    <div class="main_category_right_viewest_content_post">
                                        <div class="main_category_right_viewest_content_images">
                                            <a href="#">
                                                <img src="http://<?=$base_url?>/themes/img/bninfo2.jpg">
                                            </a>
                                        </div>
                                        <div class="main_category_right_viewest_content_title">
                                            <a href="#">
                                                Nguyễn Ngọc Anh nhận học bổng toàn phần từ Harvard
                                            </a>
                                        </div>
                                    </div>
                                    <div class="main_category_right_viewest_content_post">
                                        <div class="main_category_right_viewest_content_images">
                                            <a href="#">
                                                <img src="http://<?=$base_url?>/themes/img/bninfo3.jpg">
                                            </a>
                                        </div>
                                        <div class="main_category_right_viewest_content_title">
                                            <a href="#">
                                                Nguyễn Ngọc Anh nhận học bổng toàn phần từ Harvard
                                            </a>
                                        </div>
                                    </div>
                                    <div class="main_category_right_viewest_content_post">
                                        <div class="main_category_right_viewest_content_images">
                                            <a href="#">
                                                <img src="http://<?=$base_url?>/themes/img/bninfo4.jpg">
                                            </a>
                                        </div>
                                        <div class="main_category_right_viewest_content_title">
                                            <a href="#">
                                                Nguyễn Ngọc Anh nhận học bổng toàn phần từ Harvard
                                            </a>
                                        </div>
                                    </div>
                                    <div class="main_category_right_viewest_content_post">
                                        <div class="main_category_right_viewest_content_images">
                                            <a href="#">
                                                <img src="http://<?=$base_url?>/themes/img/bninfo1.jpg">
                                            </a>
                                        </div>
                                        <div class="main_category_right_viewest_content_title">
                                            <a href="#">
                                                Nguyễn Ngọc Anh nhận học bổng toàn phần từ Harvard
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="list-courses-main-sidebar">
                    <?//php include_once('../includes/inc_sidebar_news.php');?>
                    <?//php include_once('../includes/inc_sidebar_faq.php');?>
                    <div class="ad-sidebar">
                        <img src="http://<?=$base_url?>/themes/img/ad1.jpg">
                    </div>
                    <div class="ad-sidebar">
                        <img src="http://<?=$base_url?>/themes/img/ad2.jpg">
                    </div>
                    <div class="ad-sidebar">
                        <img src="http://<?=$base_url?>/themes/img/ad3.jpg">
                    </div>
                    <div class="ad-sidebar">
                        <iframe width="100%" height="300" src="https://www.youtube.com/embed/lDR04tkqwEE" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>