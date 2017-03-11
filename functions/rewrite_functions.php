<?
/*
Function generate module url
*/
function generate_module_url($module){
	global $con_mod_rewrite;
	if($con_mod_rewrite == 0){
		$link	= lang_path() . "module.php?module=" . $module;
	}
	else{
		$link	= lang_path() . $module . ".html";
	}
	return $link;
}
?>
<?
/*
Function generate country destination
*/
function generate_country_destination_url($nCou){
	global $con_mod_rewrite;
	$nCou	= urlencode($nCou);
	if($con_mod_rewrite == 0){
		$link	= lang_path() . "module.php?module=Destiantion&nCou=" . $nCou;
	}
	else{
		$link	= lang_path() . "Destination/" . $nCou . ".html";
	}
	return $link;
}
?>
<?
/*
Function generate detail destination
*/
function generate_detail_destination_url($nCou, $nData){
	global $con_mod_rewrite;
	$nCou		= urlencode($nCou);
	$nData	= urlencode($nData);
	if($con_mod_rewrite == 0){
		$link	= lang_path() . "detail_destination.php?module=Destiantion&nCou=" . $nCou . "&nData=" . $nData;
	}
	else{
		$link	= lang_path() . "Destination/" . $nCou . "/" . $nData . ".html";
	}
	return $link;
}
?>
<?
/*
Function generate type url
*/
function generate_cat_url($row, $type = "member"){
	$link	=	"/" . $type . "/" . $row['mem_username'] . "-" . removeTitle($row['mem_username']) . "/";
	return $link;
}

?>
<?
/*
Function generate type url
*/
function generate_mem_url($row){
	$link	=	"/member/" . $row['mem_ID'] . "/";
	return $link;
}

?>
<?
/*
Function generate type url
*/
function generate_catcon_url($rowcon ,$row , $html = 1){
	global	$path_root;
	$link	=	"/cate/" . $rowcon['cat_id'] . "-" . $rowcon['cat_parent_id']  .  "-" . removeTitle($row['cat_name']) . "/" .removeTitle($rowcon['cat_name']);
	return $link;
}

?>
<?
/*
Function generate link-list url
*/
function generate_detail_url($row){
	global	$path_root;
	$link	=  "/share/". $row['sha_catID'] . "/" . $row['sha_daID'] . "-" . removeTitle($row['sha_title'])	.	".html";
	return $link;
}
?>
<?
/*
Function generate link-list url
*/
function generate_down_url($row){
	global	$path_root;
	$link	=  "/download/". $row['sha_daName'];
	return $link;
}
?>
<?
/*
Function generate link-list url
*/
function generate_detail_news_url($row){
	global	$path_root;
	$link	=  "/news/" . $row['new_cat_id'] . "/". $row['new_id'] . "-" . removeTitle($row['new_title'])	.	".html";
	return $link;
}
?>
<?
/*
Function generate link-list url
*/
function generate_video_url($row){
	global	$path_root;
	$link	=  "/video/"	. $row['cat_id'] . "-" . removeTitle($row['cat_name'])	.	".html";
	return $link;
}
?>

<?
function generate_cat_item_url($row){
	$link	=  "/filter/"	. $row['cat_id'] . "/" . $row['cat_type']	."/". removeTitle($row['cat_name'])	.	"/";
	return $link;
}
?>

<?
function generate_cat_item_private_url($iMemm , $row){
	$link	=  "/filter/mem/" . $iMemm . "/"	. $row['cat_id'] . "-" . removeTitle($row['cat_name'])	.	"/";
	return $link;
}
?>

<?
function generate_url_comment($row){
	$link	=  "/comment/"	. $row['com_id'] . "-" . removeTitle($row['com_title']) .	".html";
	return $link;
	return $link;
}
?>
<?
function removeTitle($string,$keyReplace = "/"){
	 $string = removeAccent($string);
	 $string  =  trim(preg_replace("/[^A-Za-z0-9]/i"," ",$string)); // khong dau
	 $string  =  str_replace(" ","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace("--","-",$string);
	 $string = str_replace($keyReplace,"-",$string);
	 return strtolower($string);
}
?>
<?
/*
Function generate detail tour url
*/
function generate_detail_tour_url($nCou, $nTs, $nData, $nTab=""){
	global $con_mod_rewrite;
	$nCou		= replace_rewrite_url($nCou, "_");
	$nTs		= replace_rewrite_url($nTs, "_");
	$nData	= replace_rewrite_url($nData, "-");
	$nTab		= replace_rewrite_url($nTab, "-");
	
	$link		= lang_path();
	if($con_mod_rewrite == 0){
		$link	.= "detail_tour.php?nData=" . $nData;
		if($nTab != "") $link .= "&nTab=" . $nTab;
	}
	else{
		if($nTab != "") $link .= $nCou . "/" . $nTs . "/" . $nData . "/" . $nTab . ".thtml";
		else $link .= $nCou . "/" . $nTs . "/" . $nData . ".thtml";
	}
	return $link;
}
?>
<?
/*
Function generate detail hotel url
*/
function generate_detail_hotel_url($nCou, $nCity, $nData, $nTab=""){
	global $con_mod_rewrite;
	$nCou		= replace_rewrite_url($nCou, "_");
	$nCity	= replace_rewrite_url($nCity, "_");
	$nData	= replace_rewrite_url($nData, "-");
	$nTab		= replace_rewrite_url($nTab, "-");
	
	$link		= lang_path();
	if($con_mod_rewrite == 0){
		$link	.= "detail_hotel.php?nData=" . $nData;
		if($nTab != "") $link .= "&nTab=" . $nTab;
	}
	else{
		if($nTab != "") $link .= $nCou . "/" . $nCity . "/" . $nData . "/" . $nTab . ".hhtml";
		else $link .= $nCou . "/" . $nCity . "/" . $nData . ".hhtml";
	}
	return $link;
}
?>
<?
/*
Function replace rewrite url
*/
function replace_rewrite_url($string, $rc="-", $urlencode=1){
	//$string	= mb_strtolower($string, "UTF-8");
	$string	= removeAccent($string);
	$string	= preg_replace('/[^A-Za-z0-9]+/', ' ', $string);
	$string	= str_replace("   ", " ", trim($string));
	$string	= str_replace("  ", " ", trim($string));
	$string	= str_replace(" ", $rc, $string);
	$string	= str_replace($rc . $rc, $rc, $string);
	$string	= str_replace($rc . $rc, $rc, $string);
	if($urlencode == 1) $string	= urlencode($string);
	return $string;
}
?>
<?
/*
Function generate navbar
*/
function generate_navbar($iCat,$nCat){
    global	$base_url;
	$link	=  'http://'.$base_url."/courses/" .$iCat . "/" . removeTitle($nCat)	.	".html";
	return $link;
    // Hoan lv
}
?>
<?
/*
Function generate course detail
*/
function generate_detailCourse($iCourse,$nCourse){
    global	$base_url;
	$link	=  'http://'.$base_url."/course/" .$iCourse . "/" . removeTitle($nCourse)	.	".html";
	return $link;
    // Hoan lv
}
?>
<?
/*
Function generate game detail
*/
function generate_detailGame($iGame,$nGame){
    global	$base_url;
	$link	=  'http://'.$base_url."/game/s/" .$iGame . "/" . removeTitle($nGame)	.	".html";
	return $link;
    // Hoan lv
}
?>
<?
/*
Function generate jokes detail
*/
function generate_detailJokes($type,$iJokes,$nJokes){
    global	$base_url;
	$link	=  'http://'.$base_url."/jokes/s/" . $type ."/". $iJokes . "/" . removeTitle($nJokes)	.	".html";
	return $link;
    // Hoan lv
}
?>
<?
/*
Function generate song detail
*/
function generate_detailSong($iSong,$nSong){
    global	$base_url;
	$link	=  'http://'.$base_url."/song/s/" . $iSong . "/" . removeTitle($nSong)	.	".html";
	return $link;
    // Hoan lv
}
?>
<?
/*
Function generate video detail
*/
function generate_detailVideo($iVideo,$nVideo){
    global	$base_url;
	$link	=  'http://'.$base_url."/video/s/" . $iVideo . "/" . removeTitle($nVideo)	.	".html";
	return $link;
    // Hoan lv
}
?>
<?
/*
Function generate Posts Category
*/
function generate_posts_category($iCat,$nCat){
    global	$base_url;
	$link	=  'http://'.$base_url."/list/" .$iCat . "/" . removeTitle($nCat)	.	".html";
	return $link;
    // Hoan lv
}
?>

<?
/*
Function generate Posts detail
*/
function generate_detailPosts($iPosts,$nPosts){
    global	$base_url;
	$link	=  'http://'.$base_url."/posts/" .$iPosts . "/" . removeTitle($nPosts)	.	".html";
	return $link;
    // Hoan lv
}
/*
Function generate sub Category
*/
function generate_sub_cate($iCate,$nCate,$iLev,$nLev){
   global $base_url;
   $link = "http://".$base_url."/courses/".$iCate."/".removeTitle($nCate)."/".$iLev."/".removeTitle($nLev).".html";
   return $link;
}
/*
Function generate cate library
*/
function generate_cate_lib($type,$iCate){
   global $base_url;
   switch($type){
      case 1:
      case 11:
         $name = "games"; break;
      case 2:
      case 12:
         $name = "jokes"; break;
      case 3:
      case 13:
         $name = "songs"; break;
      case 4:
      case 14:
         $name = "videos"; break;         
   }
   $link = "http://".$base_url."/".$name."/".$type."/".$iCate.".html";
   return $link;
}

function generate_game($icate){
   global $base_url;
   $link = "http://".$base_url."/game/".$icate.".html";
   return $link;
}
function generate_game_top($icate){
   global $base_url;
   $link = "http://".$base_url."/game/".$icate."/top";
   return $link;
}
function generate_game_new($icate){
   global $base_url;
   $link = "http://".$base_url."/game/".$icate."/new";
   return $link;
}
function generate_jokes($icate){
   global $base_url;
   $link = "http://".$base_url."/joke/".$icate.".html";
   return $link;
}
function generate_jokes_top($icate){
   global $base_url;
   $link = "http://".$base_url."/joke/".$icate."/top";
   return $link;
}
function generate_jokes_new($icate){
   global $base_url;
   $link = "http://".$base_url."/joke/".$icate."/new";
   return $link;
}
function generate_song($icate){
   global $base_url;
   $link = "http://".$base_url."/song/".$icate.".html";
   return $link;
}
function generate_song_top($icate){
   global $base_url;
   $link = "http://".$base_url."/song/".$icate."/top";
   return $link;
}
function generate_song_new($icate){
   global $base_url;
   $link = "http://".$base_url."/song/".$icate."/new";
   return $link;
}
function generate_video($icate){
   global $base_url;
   $link = "http://".$base_url."/video/".$icate.".html";
   return $link;
}
function generate_video_top($icate){
   global $base_url;
   $link = "http://".$base_url."/video/".$icate."/top";
   return $link;
}
function generate_video_new($icate){
   global $base_url;
   $link = "http://".$base_url."/video/".$icate."/new";
   return $link;
}
function generate_lesson_detail($id,$nles){
	global $base_url;
   $link = "http://".$base_url."/lesson/".$id."/".removeTitle($nles).".html";
   return $link;
}
function generate_123doc_lesson_detail($id,$nles){
	global $base_url;
   $link = "http://".$base_url."/123doc/lesson/".$id."/".removeTitle($nles).".html";
   return $link;
}
function generate_user_profile($iUser){
   global $base_url;
   $link = "http://".$base_url."/member/".$iUser;
   return $link;
}

/*
Function generate skill language category
*/
/*
function generate_skill_cate($iCate,$nCate){
   global	$base_url;
	$link	=  'http://'.$base_url."/skills/" .$iCate . "/" . removeTitle($nCate)	.	".html";
	return $link;
}

function generate_skill_lesson($iLes,$nLes){
   global	$base_url;
	$link	=  'http://'.$base_url."/skill/" .$iLes . "/" . removeTitle($nLes)	.	".html";
	return $link;
}
*/
function gen_sk_cate($iCate,$nCate){
   global	$base_url;
	$link	=  'http://'.$base_url."/skill/category/" .$iCate . "/" . removeTitle($nCate)	.	".html";
	return $link;
}

function gen_sk_les($iLes,$nLes){
   global	$base_url;
	$link	=  'http://'.$base_url."/skill/lesson/" .$iLes . "/" . removeTitle($nLes)	.	".html";
	return $link;
}
/* 
 * Function rewrite Hochayv2 
 */
function gen_sk_cate_v2($iCate,$nCate){
   global	$base_url;
	$link	=  'http://'.$base_url."/ky-nang/" .$iCate . "-" . removeTitle($nCate)	.	".html";
	return $link;
}

function gen_sk_les_v2($nCate,$iLes,$nLes){
   global	$base_url;
	$link	=  'http://'.$base_url."/ky-nang/" .removeTitle($nCate). "/" .$iLes . "-" . removeTitle($nLes)	.	".html";
	return $link;
}

function gen_sk_les_v3($iLes){
	global	$base_url;
	//query skill lesson info
	$db_query = new db_query("SELECT * FROM skill_lesson WHERE skl_les_id = ".$iLes." AND skl_les_active = 1");
	$db_result = mysql_fetch_assoc($db_query->result);
		$lesson_info = $db_result;
	unset($db_result);
	unset($db_query);
	
	$category_nodes = array();
	$cat_trails = db_find_parents_trail($lesson_info['skl_les_cat_id'],'0','categories_multi','cat_id','cat_parent_id');
	foreach($cat_trails as $trail){
		array_unshift($category_nodes,$trail['cat_name']);
	}
	
	$category_name_part = removeTitle(implode('-',$category_nodes));
	$lesson_name_part = removeTitle($lesson_info['skl_les_name']);
	
	$link = 'http://'.$base_url.'/ky-nang/'.$category_name_part."/".$lesson_info['skl_les_id']."-".$lesson_name_part.".html";
	
	return $link;
}

function gen_course_cate_v2($iCate,$nCate,$iLev = 0,$nLev = ''){
   global	$base_url;
	$levString = '';
	if($iLev != 0){
		switch($iLev){
			case 1:$levString = '/1-beginner';
				break;
			case 2:$levString = '/2-intermediate';
				break;
			case 3:$levString = '/3-upperIntermediate';
				break;
			case 4:$levString = '/4-advanced';
				break;
		}
	}
	$link	= 'http://'.$base_url."/khoa-hoc/".$iCate."-".removeTitle($nCate).$levString.".html";
	return $link;
}

function gen_course_cate_v3($iCate){
	global $base_url;
	$link = '';
	$nodes = array();
	$cat_trails = db_find_parents_trail($iCate,'0','categories_multi','cat_id','cat_parent_id');
	foreach($cat_trails as $trail){
		array_unshift($nodes,$trail['cat_name']);
	}
	$category_name_part = removeTitle(implode('-',$nodes));
	
	$type = $cat_trails[0]['cat_type'];
	
	if($type==1){
		$link	= 'http://'.$base_url."/khoa-hoc/".$iCate."-".$category_name_part.".html";
	} elseif($type==0){
		$link	= 'http://'.$base_url."/ky-nang/".$iCate."-".$category_name_part.".html";
	}
	
	
	
	return $link;
}

function gen_first_les_v3 ($iCourse){
	global $base_url;
	$link = '';
	
	$db_query = new db_query("SELECT * FROM courses_multi WHERE com_cou_id = ".$iCourse." ORDER BY com_num_unit ASC");
	$db_result = mysql_fetch_assoc($db_query->result);
		$first_lesson_info = $db_result;
	unset($db_result);
	unset($db_query);
	
	$link.=gen_course_les_v3($first_lesson_info['com_id']);
	
	return $link;
}

function gen_course_les_v3($iCourse = 0,$iLes = 0){//actually it lead to the first tab of the lesson
	global $base_url;
	$link = '';
	if($iCourse != 0 && $iLes == 0){
		// GET ILES DEFAULT
		$db_query_com_degault = new db_query('SELECT * FROM courses_multi WHERE com_cou_id = '.$iCourse.' LIMIT 1');
		$arr_result_com_degault = mysql_fetch_assoc($db_query->result);
			$iLes = $arr_result_com_degault['com_id'];
		unset($db_query_com_degault);
	}

	//select the lesson info
	$db_query = new db_query('SELECT * FROM courses_multi WHERE com_id = '.$iLes);
	$db_result = mysql_fetch_assoc($db_query->result);
		$lesson_info = $db_result;
	unset($db_query);
	
	//get the course info
	$db_query = new db_query('SELECT * FROM courses WHERE cou_id = '.$lesson_info["com_cou_id"]);
	$db_result = mysql_fetch_assoc($db_query->result);
		$course_info = $db_result;
	unset($db_query);
	
	$course_name_part = removeTitle($course_info['cou_name']);
	if($course_info['cou_form'] == 3){
	  	if(checkLesson($lesson_info['com_id'],'main') == 1){
	     	$cou_df = "strategy"; 
	  	}else if(checkLesson($lesson_info['com_id'],'grammar') == 1){
	     	$cou_df = "grammar";
	  	}else if(checkLesson($lesson_info['com_id'],'vocabulary') == 1){
	     	$cou_df = "vocabulary";
	  	}else{
	     	$cou_df = "practice";
	  	}
   	}  
   	else{ 
      	$cou_df = "main";
   	}
	
	$link	= 'http://'.$base_url."/khoa-hoc/".$course_name_part."/".$course_info['cou_id']."-".$lesson_info['com_id']."-".$cou_df.".html";
	return $link;
}

function gen_course_les_v2($nCate,$iLes,$unit,$nLes){
   $db_cou = new db_query("SELECT cou_form FROM courses INNER JOIN courses_multi ON cou_id = com_cou_id WHERE com_id = ".$unit);
   $row_unit = mysql_fetch_assoc($db_cou->result);
   $cou_form = $row_unit['cou_form'];
   if($cou_form == 3){ $cou_df = "strategy"; }  else{ $cou_df = "main";}
   unset($db_unit);
	global	$base_url;
	$link =  'http://'.$base_url."/khoa-hoc/".removeTitle($nCate)."/" . removeTitle($nLes) . "/" . $iLes . "-" . $unit . "-" . $cou_df . ".html";
	return $link;
}

function gen_course_les_edit_v2($str_cate,$type,$iCou,$unit,$nLes){
	global	$base_url;
	$link =  'http://'.$base_url."/khoa-hoc/" . removeTitle($str_cate) . "/" . removeTitle($nLes) . "/edit/" . $iCou . "-" . $unit . "-" . $type . ".html";
	return $link;
}

function gen_lib_cat_v2($iCate,$nCate){
	global	$base_url;
	
	$link = '';
	$slug = '';
	if($iCate>0){
		$link = 'http://'.$base_url."/thu-vien/".$iCate."/".removeTitle($nCate).".html";
	} else {
		switch($iCate){
			case -1:$slug = 'tro-choi';
				break;
			case -2:$slug = 'truyen';
				break;
			case -3:$slug = 'bai-hat';
				break;
			case -4:$slug = 'video';
				break;
		}
		$link = 'http://'.$base_url."/thu-vien/".$slug.".html";
	}
	
	return $link;
}

function gen_lib_post_v2($lib_type,$id,$name){
	global	$base_url;
		
	switch($lib_type){
		case 1:
			$slug = 'tro-choi';
			$db_slug = 'game';
			break;
		case 2:
			$slug = 'truyen';
			$db_slug = 'story';
			break;
		case 3:
			$slug = 'bai-hat';
			$db_slug = 'song';
			break;
		case 4:
			$slug = 'video';
			$db_slug = 'video';
			break;
	}
	//get the parent catgories
	$db_query = new db_query("SELECT * FROM library_".$db_slug." WHERE lib_".$db_slug."_id = ".$id);
	$result = mysql_fetch_assoc($db_query->result);
		$db_query2 = new db_query("SELECT * FROM library_cate WHERE lib_cat_id = ".$result["lib_".$db_slug."_catid"]);
		$result2 = mysql_fetch_assoc($db_query2->result);
			$catid = $result2["lib_cat_id"];
			$catname = $result2["lib_cat_name"];
		unset($db_query2);
	unset($db_query);
	
	
	$link = 'http://'.$base_url.'/thu-vien/'.$slug.'/'.removeTitle($catname).'/'.$id.'/'.removeTitle($name).'.html';
	
	return $link;
}

function gen_news_detail($id,$title){
   global	$base_url;
   $link = 'http://'.$base_url.'/tin-tuc/'.$id.'/'.removeTitle($title).'.html';
   
   return $link;
}
function gen_commu_page_dt($name,$id,$title){
   global	$base_url;
   $link = 'http://'.$base_url.'/'.removeTitle($name).'/'.$id.'/'.removeTitle($title).'.html';
   
   return $link;
}
function gen_commnu_page_dtchild($id,$title,$id_child,$titlechild){
	global $base_url;
	$link = 'http://'.$base_url.'/cong-dong-hoc-hay/'.$id.'-'.removeTitle($title).'/'.$id_child.'-'.removeTitle($titlechild).'.html';
	return $link;
}
function gen_topic_detail($id,$title){
   global	$base_url;
   $link = 'http://'.$base_url.'/chu-de/'.$id.'/'.removeTitle($title).'.html';
   
   return $link;
}
function gen_page_teacher($name){
   global $base_url;
   $link = 'http://'.$base_url.'/'.removeTitle($name).'.html';
   return $link;
}
function gen_comm_details($name,$id,$title){
   global $base_url;
   return 'http://'.$base_url.'/'.removeTitle($name).'/'.$id.'/'.removeTitle($title).'.html';
}
function gen_commu_news_edit($id,$cat_title,$title){
	global	$base_url;
	$link = 'http://'.$base_url.'/cong-dong/'.$id.'/'.removeTitle($cat_title).'/'.removeTitle($title).'/edit.html';
	
	return $link;
}

function gen_commu_cat_new($title,$id){
   global $base_url;
   return 'http://'.$base_url.'/tin-tuc/'.removeTitle($title).'-'.$id.'.html';
}

function gen_commu_cat_newdt($titlecat,$idcat,$title,$id){
   global $base_url;
   return 'http://hoc123.vn/tin-tuc/'.removeTitle($titlecat).'-'.$idcat.'/'.removeTitle($title).'-'.$id.'.html';
}

function gen_commu_news($id,$cat_title,$title){
	global	$base_url;
	$link = 'http://'.$base_url.'/cong-dong/'.$id.'/'.removeTitle($cat_title).'/'.removeTitle($title).'.html';
	
	return $link;
}
?>
<?
/* Function generate admin preview link */
function generate_preview_link($nCate,$nLevel,$nCourse,$iCourse,$iCourseMulti,$style){
	return '/khoa-hoc/'.removeTitle($nCate).'-'.removeTitle($nLevel).'/'.removeTitle($nCourse).'/'.$iCourse.'-'.$iCourseMulti.'-'.$style.'.html';
}
function generate_user_link($user_id){
	global	$base_url;
	$link = 'http://'.$base_url.'/user/u-'.$user_id;
	return $link;
}
// Rewrite phần support
function genarate_cat_support($scat_id,$scat_name){
    global $base_url;
    return 'http://'.$base_url.'/support/'.removeTitle($scat_name).'-'.$scat_id.'.html';
}
function genarate_details_support($scat_id,$scat_name,$snew_title,$snew_id){
    global $base_url;
    return 'http://'.$base_url.'/support/'.removeTitle($scat_name).'-'.$scat_id.'/'.removeTitle($snew_title).'-'.$snew_id.'.html';
}
?>
<?
// Function generate courses create by user
function generate_crc_course($cou_id,$cou_name){
   global $base_url;
   $link = 'http://'.$base_url.'/course/'.$cou_id.'-'.removeTitle($cou_name).'.html';
   return $link;
}

function generate_organize_news($i_org,$n_org,$i_news,$n_news){
   global $base_url;
   $link = 'http://'.$base_url.'/to-chuc/'.removeTitle($n_org).'-'.$i_org.'/tin-tuc/'.$i_news.'-'.removeTitle($n_news).'.htm';
   return $link;
}

function generate_organize_cate($i_org,$n_org,$i_cate,$n_cate){
   global $base_url;
   $link = 'http://'.$base_url.'/to-chuc/'.removeTitle($n_org).'-'.$i_org.'/khoa-hoc/'.$i_cate.'-'.removeTitle($n_cate).'.htm';
   return $link;
}
?>
<?
// Rewrite trang giới thiệu chung của khóa học
function gen_intro_course($cou_id,$cou_name){
   global $base_url;
   $link = 'http://'.$base_url.'/khoa-hoc/'.$cou_id.'/'.removeTitle($cou_name).'.html';
   return $link;
}
?>
<?
function gen_tags_url($tag_id,$tag_name){
   global $base_url;
   $tag_name = str_replace(" ","+",$tag_name);
   $link = 'http://'.$base_url.'/tags/'.$tag_name.'-'.$tag_id.'.html';
   return $link;
}
?>

<?php
function gen_url_category($iCate){
	global $base_url;
	$link = '';
	$nodes = array();
	$cat_trails = db_find_parents_trail($iCate,'0','categories_multi','cat_id','cat_parent_id');
	foreach($cat_trails as $trail){
		array_unshift($nodes,$trail['cat_name']);
	}
	$category_name_part = removeTitle(implode('-',$nodes));
	
	$type = $cat_trails[0]['cat_type'];
	
	if($type==1){
		$link	= 'http://'.$base_url."/khoa-hoc/".$iCate."/".$category_name_part.".html";
	} elseif($type==0){
		$link	= 'http://'.$base_url."/ky-nang/".$iCate."/".$category_name_part.".html";
	}
	return $link;
}
?>

<?php
function gen_url_lib_category($iCate){
	global $base_url;
	$link = '';
	$nodes = array();
	$cat_trails = db_find_parents_trail($iCate,'0','library_cate','lib_cat_id','lib_cat_parent_id');
	foreach($cat_trails as $trail){
		array_unshift($nodes,$trail['lib_cat_name']);
	}
	$category_name_part = removeTitle(implode('-',$nodes));
	$link	= 'http://'.$base_url."/thu-vien/".$iCate."/".$category_name_part.".html";
	return $link;
}
?>

<?php
function gen_url_news_category($iCate){
	global $base_url;
	$link = '';
	$nodes = array();
	$cat_trails = db_find_parents_trail($iCate,'0','post_category','pcat_id','pcat_parent_id');
	foreach($cat_trails as $trail){
		array_unshift($nodes,$trail['pcat_name']);
	}
	$category_name_part = removeTitle(implode('-',$nodes));
	$link	= 'http://'.$base_url."/tin-tuc-su-kien/".$iCate."/".$category_name_part.".html";
	return $link;
}
?>

<?php
/*NEW*/
function generate_skill_details_link($iCat,$nCat,$iSkill,$nSkill){
	global	$base_url;
	$link = 'http://'.$base_url.'/ky-nang/'.$iCat.'/'.removeTitle($nCat).'/'.$iSkill.'/'.removeTitle($nSkill).'.html';
	return $link;
}

function gen_course_details_edit($nCourse,$iCourse,$iUnit,$type){
	global	$base_url;
	$link =  'http://'.$base_url."/khoa-hoc/" . removeTitle($nCourse) . "/" . $iCourse . "/" . $iUnit . "/" . $type . "/edit.html";
	return $link;
}

/*COURSES*/
function gen_course_list($iCate = 0,$nCate = ""){
	global	$base_url;
	$link =  'http://'.$base_url."/courses/" . $iCate . "/" . removeTitle($nCate) . ".htm";
	return $link;
}
function gen_course_info($iCourses = 0,$nCourses = ""){
	global	$base_url;
	$link =  'http://'.$base_url."/courses/info/" . $iCourses . "/" . removeTitle($nCourses) . ".htm";
	return $link;
}
function gen_course_lesson($iCourses = 0,$nCourses = "",$iUnit = 0,$iTab = 0,$nUnit = ""){
	global	$base_url;
	if($iUnit == 0 || $iTab == 0 || $nUnit == ""){
		$link =  'http://'.$base_url."/courses/lesson/" . $iCourses . "/" . removeTitle($nCourses) . ".htm";
	}else{
		$link =  'http://'.$base_url."/courses/lesson/" . $iCourses . "/" . removeTitle($nCourses) . "/" . $iUnit . "/" . $iTab . "/" .  removeTitle($nUnit) .".htm";
	}
	return $link;
}
/*CV*/
function gen_cv_list($iCate = 0,$nCate = ""){
	global	$base_url;
	$link =  'http://'.$base_url."/cv/" . $iCate . "/" . removeTitle($nCate) . ".htm";
	return $link;
}

function gen_cv_list_details($nCv,$iCate = 0,$iVc = 0){
	global	$base_url;
	$link =  'http://'.$base_url."/cvs/" . removeTitle($nCv) . "/c".$iCate."p".$iVc.".htm";
	return $link;
}

/*NEWS*/
function gen_news_list($iCate = 0,$nCate = ""){
	global	$base_url;
	$link =  'http://'.$base_url."/news/" . $iCate . "/" . removeTitle($nCate) . ".htm";
	return $link;
}

function gen_news_list_details($nNews,$iCate = 0,$iNews = 0){
	global	$base_url;
	$link =  'http://'.$base_url."/news/s/" . removeTitle($nNews) . "/c".$iCate."p".$iNews.".htm";
	return $link;
}
?>