<?php
class seopage{

	function init(){ }

	function getSeo($module, $id = NULL, $table = NULL){

        $base_url = $_SERVER['HTTP_HOST'];
        $title       = '';
        $description = '';
        $keywords    = '';
        $image       = '';    

		switch($module) {
        //Phan khoa hoc

        case "listCourses"          :
        case "listSkills"           :   
            $sql          = new db_query('SELECT * FROM categories_multi WHERE cat_id = '.$id);
            $row          = mysql_fetch_assoc($sql->result);
            unset($sql);
            
            $row['title']        == '' ?  $title       = $row['cat_name']        : $title = $row['title'];
            $row['description']  == '' ?  $description = $row['cat_description'] : $description = $row['description'];
            $row['keywords']     == '' ?  $keywords    = $row['cat_name']        : $keywords = $row['keywords'];

            $image        = "http://".$base_url."/pictures/categories/small_".$row['cat_picture'];   
            $title        = removeHTML(str_replace ('"', ' ', $title));
            $description  = removeHTML(str_replace ('"', ' ', $description));
            $keywords     = removeHTML(str_replace ('"', ' ', $keywords));
        break;

        case "listCommunity"        :
          
            if($id != 0){
                $sql          = new db_query('SELECT * FROM categories_multi WHERE cat_id = '.$id);
                $row          = mysql_fetch_assoc($sql->result);
                unset($sql);
                
                $row['title']        == '' ?  $title       = $row['cat_name']        : $title = $row['title'];
                $row['description']  == '' ?  $description = $row['cat_description'] : $description = $row['description'];
                $row['keywords']     == '' ?  $keywords    = $row['cat_name']        : $keywords = $row['keywords'];

                $image        = "http://".$base_url."/pictures/categories/small_".$row['cat_picture'];   
                $title        = removeHTML(str_replace ('"', ' ', $title));
                $description  = removeHTML(str_replace ('"', ' ', $description));
                $keywords     = removeHTML(str_replace ('"', ' ', $keywords));
            }else{
                $image        = "http://tienganh2020.com/themes/img/logo.png"; 
                $title        = "Vui học tiếng anh - Cộng đồng học tiếng anh tienganh2020.com";
                $description  = "Vui học tiếng anh - Cộng đồng học hỏi và trau dồi kiến thức tiếng anh online, dành cho tất cả học sinh, sinh viên và người đi làm tại Việt Nam";  
                $keywords     = "Cộng đồng học tiếng Anh,học sinh,sinh viên,người đi làm,người yêu thích tiếng Anh,người sử dụng tiếng Anh";    
            }
        break;

        case "listNews":
            if($id != 0){
                $db_cate = new db_query("SELECT pcat_id,pcat_name,pcat_type,pcat_description,pcat_keyword,pcat_active FROM post_category WHERE pcat_id = ".$id." AND pcat_type = 1 AND pcat_active = 1");
                $cat = mysql_fetch_assoc($db_cate->result);unset($db_cate);
                $title        = $cat['pcat_name'];
                $description  = $cat['pcat_description'];
                $keywords     = $cat['pcat_keyword'];
            }else{
                $image        = "http://tienganh2020.com/themes/img/logo.png"; 
                $title        = "Tin tức sự kiện,Tin tức hot,tin tức mới nhất,tin tức tienganh2020.com"; 
                $description  = "Tin tức hoạt động của tienganh2020 được cập nhật thường xuyên. Sự kiện tiếng anh, chương trình học tiếng anh, thông tin du học, thông tin trung tâm tiếng anh";  
                $keywords     = "Thông tin du học mới nhất, học bổng toàn phần, học tiếng Anh, hoc tieng anh online, hoc tieng anh truc tuyen, luyện thi toeic, toefl, ielts, Tiếng anh thiếu nhi";      
            }
        break;

        case "listLibraries"        :
            $arr_meta      = get_meta_lib_cat($id);
            $title         = $arr_meta['title'];
            $description   = $arr_meta['description'];
            $keywords      = $arr_meta['keywords'];
            $image         = $arr_meta['image'];
        break;     

        case "listCoursesMain":
            $arr_meta      = get_meta_courses($id);
            $title         = $arr_meta['title'];
            $description   = $arr_meta['description'];
            $keywords      = $arr_meta['keywords'];
            $image         = $arr_meta['image'];
        break;      

        case "listSkillsDetails":
            $sql          = new db_query("SELECT * FROM skill_lesson WHERE skl_les_id = ".$id);
            $row          = mysql_fetch_assoc($sql->result);
            unset($sql);
            
            $title          = $row['skl_les_name'];
            $description    = $row['skl_les_desc'];
            $keywords       = $row['skl_les_name'];
            
            $image        = "http://".$base_url."/pictures/skill_lesson/".$row['skl_les_img'];
            $title        = removeHTML(str_replace ('"', ' ', $title));
            $description  = removeHTML(str_replace ('"', ' ', $description));
            $keywords     = removeHTML(str_replace ('"', ' ', $keywords));
        break;

        case "listLibrariesDetails":
            $arr_meta      = get_meta_lib_post($id);
            $title         = $arr_meta['title'];
            $description   = $arr_meta['description'];
            $keywords      = $arr_meta['keywords'];
            $image         = $arr_meta['image'];
        break;       

        case 'listCommunityDetails':
            $sql           = new db_query("SELECT * FROM post_community WHERE postcom_id = ".$id);
            $row           = mysql_fetch_assoc($sql->result);
            unset($sql);
            
            $title          = $row['postcom_title'];
            $description    = $row['postcom_title'];
            $image          = "http://tienganh2020.com/themes/img/logo.png"; 
            $title          = removeHTML(str_replace ('"', ' ', $title));
            $description    = removeHTML(str_replace ('"', ' ', $description));
            $keywords       = removeHTML(str_replace ('"', ' ', $keywords));
        break;       

        case "listNewsDetails":
            $sql          = new db_query("SELECT * FROM posts WHERE post_id = ".$id);
            $row          = mysql_fetch_assoc($sql->result);
            unset($sql);
            
            $row['meta_title']       == '' ? $title          = $row['post_title']          : $title          = $row['meta_title'];
            $row['meta_description'] == '' ? $description    = $row['post_description']    : $description    = $row['meta_description'];
            $row['meta_keywords']    == '' ? $keywords       = $row['post_title']          : $keywords       = $row['meta_keywords'];
            $image        = "http://tienganh2020.com/themes/img/logo.png"; 
            $title        = removeHTML(str_replace ('"', ' ', $title));
            $description  = removeHTML(str_replace ('"', ' ', $description));
        break;                      
         
        default :
            $sql          = new db_query("SELECT * FROM configuration WHERE con_id = 1");
            $row          = mysql_fetch_assoc($sql->result);
            $title        = removeHTML($row['con_site_title']);
            $description  = removeHTML($row['con_meta_description']);
            $keywords     = $row['con_meta_keywords'];
            $image        = 'http://tienganh2020.com/themes/img/logo.png'; 
            unset($sql);
        break;
    } 
    echo '<title>'.$title.'</title>';
    echo '<meta property="og:type" content="website">';
    echo '<meta property="og:url" content="http://tienganh2020.com'.$_SERVER['REQUEST_URI'].'">';
    echo '<meta name="description" content="'.$description.'">';
    echo '<meta name="keywords" content="'.$keywords.'">';
    echo '<meta property="og:image" content="'.$image.'">';
    echo '<meta property="og:title" content="'.$title.'">';
    echo '<meta property="og:description" content="'.$description.'">';
    //echo '<meta property="fb:admins" content="100005076519335" />';
    echo '<meta property="fb:app_id" content="783590098395911">';
	}
}
?>
