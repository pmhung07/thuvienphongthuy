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
                <div class="list-courses-filter-wrap" style="background-color: #eee;background-image:none;">
                    <div class="list-courses-filter-title">
                        <div class="list-courses-filter-title-main">
                            <span style="color: rgb(6, 6, 6);"><h1>Covers Letters</h1></span>
                        </div>
                        <!--<span class="list-courses-filter-title-breadcrumb">
                            Kiểm toán
                        </span>-->
                    </div>
                    <div class="list-courses-filter-cate">
                        <select class="filter_category_courses">
                            <option value="-1">Danh mục CV</option>
                            <option value="1">ACCA</option>
                            <option value="2">FIA</option>
                            <option value="3">CFA</option>
                            <option value="4">PE</option>
                            <option value="5">Soft Skills</option>
                        </select>

                        <select class="filter_category_courses">
                            <option value="-1">Danh sách giảng viên</option>
                            <option value="1">Le Minh Dzung</option>
                            <option value="2">Pham Manh Hung</option>
                            <option value="3">Tran Hoang</option>
                            <option value="4">Nguyen Thi Minh Khai</option>
                            <option value="5">Hai Bà Trưng</option>
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
                    <div class="cv_content">
                        <div class="cv_content_img">
                            <img src="http://<?=$base_url?>/themes/img/coverletters_content.png">
                        </div>
                    </div>
                </div>
                <div class="list-courses-main-sidebar">
                    <div class="cv_info">
                        <div class="cv_info_price">
                            <span class="text_price">Mưc giá</span>
                            <span class="num_price">160.000 vnđ</span>
                        </div>
                        <div class="cv_sapo">
                            Use, by you or one client, in a single end product which end users are not charged for. The total price includes the item price and a buyer fee.
                        </div>
                        <div class="cv_buy">
                            <span>Mua ngay</span>
                        </div>
                        <div class="cv_info_details">
                            <div class="box -radius-all">
                                <div class="meta-attributes">
                                    <table class="meta-attributes__table" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td class="cv_details_title">Created</td>
                                            <td class="cv_details_detail">27 June 11</td>
                                        </tr>

                                        <tr>
                                            <td class="cv_details_title">Layered</td>
                                            <td class="cv_details_detail">
                                                Yes
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cv_details_title">Graphics Files Included</td>
                                            <td class="cv_details_detail">
                                                Photoshop PSD
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cv_details_title">Minimum Adobe CS Version</td>
                                            <td class="cv_details_detail">
                                               CS3
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cv_details_title">Print Dimensions</td>
                                            <td class="cv_details_detail">
                                                8.5x11
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cv_details_title">Tags</td>
                                            <td class="cv_details_detail">
                                                agreement form
                                            </td>
                                         </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>