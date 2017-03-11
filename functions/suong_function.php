<?
define(SUONG_POST_PICTURE,'/pictures/thuviencongdong/');
define(SUONG_THUMB_PICTURE,'/pictures/thuviencongdong_thumb/');
function getYouTubeIdFromURL($url) {
    //$url_string = parse_url($url, PHP_URL_QUERY);
    $url_string = parse_url($url);
    if(preg_match('/ytimg.com/i', $url) > 0) {
        $prts = explode('/', $url);
        return isset($prts[4]) ? $prts[4] : '';
    } else {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
        $tmp = isset($matches[0]) ? $matches[0] : '';
        if($tmp){
            $tmp = explode('#',$tmp);
            $tmp = $tmp[0];
        }
        return $tmp;
    }
}
function postedTimer($minutes) {
    $msg = "";
    if($minutes < 1) {
        $msg = "khoảng 1 phút trước";
    } else if($minutes >= 1 && $minutes < 60) {
        $msg = round($minutes) . " phút trước";
    } else if($minutes >= 60 && $minutes < 1140) {
        $msg = round($minutes / 60) . " giờ trước";
    } else {
    		$msg = round($minutes / (60 * 24)) . " ngày trước";
    }
    
    return $msg;       
}
function get_client_ip() {
     if (isset($_SERVER['HTTP_CLIENT_IP']))
         return $_SERVER['HTTP_CLIENT_IP'];
     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
         return $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if(isset($_SERVER['HTTP_X_FORWARDED']))
         return $_SERVER['HTTP_X_FORWARDED'];
     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
         return $_SERVER['HTTP_FORWARDED_FOR'];
     else if(isset($_SERVER['HTTP_FORWARDED']))
         return $_SERVER['HTTP_FORWARDED'];
     else if(isset($_SERVER['REMOTE_ADDR']))
         return $_SERVER['REMOTE_ADDR'];
     else
         return 'UNKNOWN';
}
function get_fb_statistics($links = array()){
        $posts = array();
        if(empty($links)){
            return $posts;
        }
        //echo '<pre>';print_r($links);echo '</pre>';
        $apiUrl = 'http://api.facebook.com/method/fql.query?query=select total_count,like_count,comment_count,share_count,click_count,commentsbox_count from link_stat where url IN (\''.implode('\',\'', $links).'\')&format=json';
        $apiUrl = str_replace(' ', '%20', $apiUrl);
        //$apiUrl = 'https://graph.facebook.com/?ids='.implode(',', $links);
        //echo $apiUrl,'<br />';
        //echo $_SERVER['HTTP_USER_AGENT'];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$apiUrl);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        //curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: Keep-Alive", "Content-type: application/x-www-form-urlencoded;charset=UTF-8"));
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            //print "Error: " . curl_error($ch);
            foreach($links as $pid => $url){
                $posts[$pid] = array(
                    'total_count' => '0',
                    'like_count' => '0',
                    'comment_count' => '0',
                    'share_count' => '0',
                    'click_count' => '0',
                    'commentsbox_count' => '0',
                );
            }
        } else {
            // Show me the result
            //echo '<pre>';print_r($response);echo '</pre>';
            $data = json_decode($response, true);
            curl_close($ch);
            foreach($links as $pid => $url){
                $posts[$pid] = array_shift($data);
            }
        }
        //echo '<pre>';print_r($posts);echo '</pre>';
        return $posts;
}
//Các function rewrite
function generate_suong_new_url($page = 0) {
    if($page == 0) {
        return '/thu-vien-cong-dong/moi-nhat/trang-1/';
    }else {
        return '/thu-vien-cong-dong/moi-nhat/trang-'.$page.'/';
    }
}
function generate_suong_home_url($page = 0) {
    if($page == 0) {
        return '/thu-vien-cong-dong/da-duyet/trang-1/';
    }else {
        return '/thu-vien-cong-dong/da-duyet/trang-'.$page.'/';
    }
}
function generate_suong_hot_url($page = 0) {
    if($page == 0) {
        return '/thu-vien-cong-dong/noi-bat/trang-1/';
    }else {
        return '/thu-vien-cong-dong/noi-bat/trang-'.$page.'/';
    }
}
function generate_suong_cat_new_url($cat,$page = 0) {
    if($page == 0) {
        return '/thu-vien-cong-dong/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/moi-nhat/trang-1/';
    }else {
        return '/thu-vien-cong-dong/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/moi-nhat/trang-'.$page.'/';
    }
}
function generate_suong_cat_home_url($cat,$page = 0) {
    if($page == 0) {
        return '/thu-vien-cong-dong/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/da-duyet/trang-1/';
    }else {
        return '/thu-vien-cong-dong/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/da-duyet/trang-'.$page.'/';
    }
}
function generate_suong_cat_hot_url($cat,$page = 0) {
    if($page == 0) {
        return '/thu-vien-cong-dong/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/noi-bat/trang-1/';
    }else {
        return '/thu-vien-cong-dong/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/noi-bat/trang-'.$page.'/';
    }
}

function generate_suong_user_new_url($user_id,$page = 0) {
    if($page == 0) {
        return '/thu-vien-cong-dong/trang-ca-nhan/user-'.$user_id.'/moi-nhat/trang-1/';
    }else {
        return '/thu-vien-cong-dong/trang-ca-nhan/user-'.$user_id.'/moi-nhat/trang-'.$page.'/';
    }
}
function generate_suong_user_hot_url($user_id,$page = 0) {
    if($page == 0) {
        return '/thu-vien-cong-dong/trang-ca-nhan/user-'.$user_id.'/xem-nhieu/trang-1/';
    }else {
        return '/thu-vien-cong-dong/trang-ca-nhan/user-'.$user_id.'/xem-nhieu/trang-'.$page.'/';
    }
}
function generate_suong_cat_url($cat){
	return '/thu-vien-cong-dong/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/';
}
function generate_suong_detail_url($suong,$cat){
	return '/thu-vien-cong-dong/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/'.removeTitle($suong['pos_title']).'-'.$suong['pos_id'].'.html';
}


function generate_user_community_cat_url($user_id,$cat){
	return '/user-'.$user_id.'/kho-kien-thuc/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/';
}
function generate_user_community_new_url($user_id,$page = 0) {
    if($page == 0) {
        return '/user-'.$user_id.'/kho-kien-thuc/moi-nhat/trang-1';
    }else {
        return '/user-'.$user_id.'/kho-kien-thuc/moi-nhat/trang-'.$page.'';
    }
}
function generate_user_community_hot_url($user_id,$page = 0) {
    if($page == 0) {
        return '/user-'.$user_id.'/kho-kien-thuc/xem-nhieu/trang-1';
    }else {
        return '/user-'.$user_id.'/kho-kien-thuc/xem-nhieu/trang-'.$page.'';
    }
}
function generate_user_community_cat_new_url($user_id,$cat,$page = 0) {
    if($page == 0) {
        return '/user-'.$user_id.'/kho-kien-thuc/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/moi-nhat/trang-1';
    }else {
        return '/user-'.$user_id.'/kho-kien-thuc/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/moi-nhat/trang-'.$page.'';
    }
}
function generate_user_community_cat_hot_url($user_id,$cat,$page = 0) {
    if($page == 0) {
        return '/user-'.$user_id.'/kho-kien-thuc/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/xem-nhieu/trang-1';
    }else {
        return '/user-'.$user_id.'/kho-kien-thuc/'.removeTitle($cat['cat_name']).'-'.$cat['cat_id'].'/xem-nhieu/trang-'.$page.'';
    }
}
?>