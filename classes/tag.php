<?
class tag{

	var $store_term	= array();
	var $array_term	= array();
	var $id				= 0;
	var $text			= "";
	var $title			= "";
	var $teaser			= "";
   var $group_type   = 0;
   var $type         = 0;

	function tag($id, $text, $title, $teaser, $group_type, $type){
		$this->id		      = 	intval($id);
		$this->text 	      = 	$text;
		$this->title	      =	$title;
		$this->teaser	      = 	$teaser;
      $this->group_type    = $group_type;
      $this->type          = $type;
	}

	/*
	Function insert tag to database
	*/
	function insert_tag($min_cha = 1, $no_insert = false){
		// Remove hết các ký tự xuống dòng, Tab và thẻ HTML
		$str		= array(chr(9), chr(10), chr(13), "-", '"', ".", "?", ":", "*", "%", "#", "|", "/", "\\", ",", "‘", "’", '“', '”', "&nbsp;");
		$text 	= removeHTML($this->text);
		$title 	= removeHTML($this->title);
		$teaser 	= removeHTML($this->teaser);
		$text		= mb_strtolower(str_replace($str, "", $text), "UTF-8");
		$title	= mb_strtolower(str_replace($str, "", $title), "UTF-8");
		$teaser	= mb_strtolower(str_replace($str, "", $teaser), "UTF-8");
		$array_text	= explode(" ", $text);
		for($i=0; $i<count($array_text); $i++){
			if(mb_strlen($array_text[$i]) >= 3){
				if($min_cha <= 1) $this->store_term[] = $array_text[$i];
				$this->array_term[] = $array_text[$i];
			}
		}

		$num_arr = count($this->array_term);
		for($i=0; $i<$num_arr; $i++){
			// Lưu Term 2
			if($i < $num_arr-1){
				if($min_cha <= 2) $this->store_term[] = $this->array_term[$i] . " " . $this->array_term[$i+1];
			}
			// Lưu Term 3
			if($i < $num_arr-2){
				if($min_cha <= 3) $this->store_term[] = $this->array_term[$i] . " " . $this->array_term[$i+1] . " " . $this->array_term[$i+2];
			}
			// Lưu Term 4
			if($i < $num_arr-3){
				$this->store_term[] = $this->array_term[$i] . " " . $this->array_term[$i+1] . " " . $this->array_term[$i+2] . " " . $this->array_term[$i+3];
			}
			if($min_cha > 3){
				// Lưu Term 5
				if($i < $num_arr-4){
					$this->store_term[] = $this->array_term[$i] . " " . $this->array_term[$i+1] . " " . $this->array_term[$i+2] . " " . $this->array_term[$i+3] . " " . $this->array_term[$i+4];
				}
			}
		}

		$array_count	= array_count_values($this->store_term);
		$array_remove	= array(1);
		$array_temp	= array_diff($array_count, $array_remove);
		//print_r($array_temp);

		$new_array = array();
		foreach($array_temp as $key => $value){
			$arr_exp = explode(" ", $key);
			$num		= (count($arr_exp) > 1) ? $value*count($arr_exp)*1.5 : $value;
			if(mb_strpos($title, $key)){
				$num	*=	$num;
			}
			if(mb_strpos($teaser, $key)){
				$num	+= 5;
			}
			$new_array[$key] = $num;
		}

		arsort($new_array);


		//print_r($new_array);
		if(!$no_insert){
			array_splice($new_array, 10);
			foreach($new_array as $key => $value){

				$key = replaceMQ($key);
            //dump($key);
				// Check xem tag này đã tồn tại chưa
				$db_check = new db_query("SELECT tag_id, tag_name FROM tags WHERE tag_name = '" . $key  . "' LIMIT 1");
				if($check = mysqli_fetch_array($db_check->result)){
					$tag_id		= $check["tag_id"];
				}
				else{
					$db_insert	= new db_execute_return();
					$tag_id		= $db_insert->db_execute("INSERT INTO tags(tag_name) VALUES('" . $key . "')");
					unset($db_insert);
				}
				unset($db_check);

				// Insert vào bảng news_tag
				$post_id		  = $this->id;
            $group_type   = $this->group_type;
            $type         = $this->type;
				$db_insert	= new db_execute("INSERT IGNORE tags_posts(tp_tag_id,tp_post_id,tp_group_type,tp_type) VALUES(" . $tag_id . ", " . $post_id . ", ".$group_type.", ".$type.")");
				unset($db_insert);
				// Lấy sản phẩm liên quan từ khóa
		//		searchProductByTag($key,$tag_id);
			}
		}else{
			array_splice($new_array, 5);
		}
		return $new_array;
	}

}
/*
require_once("../classes/database.php");
require_once("../functions/functions.php");
$text	= '<P class=Lead><IMG height=151 src="/ngoisao/080401210659-837-477.jpg" width=200 align=left border=0>Thưa bác sĩ, em và bạn trai em đã đôi lần quan hệ qua quần áo. Nhưng chưa đến ngày đèn đỏ thì chúng em không làm chủ được mình và rồi có cởi ra nhưng luôn có ý thức về hậu quả sau này nên anh ấy không dám đưa "cái đó" vào bộ phận đó của em. </P>
<P class=Normal><EM>Em vẫn sợ, nhỡ đâu trong quá trình gần gũi như vậy, không chừng có một "chú" nào đó nhảy vào gặp "nàng" của em thì em không biết làm thế nào nữa. Chuyện đó mới xảy ra ngày hôm qua khiến em vẫn ám ảnh mãi. Em không biết nên dùng que thử ngay từ bây giờ không? Uống thuốc tránh thai khẩn cấp bây giờ liệu còn kịp không? Và nếu uống sẽ có ảnh hưởng gì không? Xin các bác sĩ cho em lời khuyên nhanh chóng (</EM><EM>pla_mond10@yahoo.com</EM><EM>).</EM></P>
<P class=normal>Hai bạn mới chớm quan hệ nghĩa là "cái ấy" của bạn trai bạn vẫn chưa đưa vào âm đạo của bạn thì khả năng bạn có thai là không có, nên bạn hoàn toàn có thể an tâm. Tuy nhiên lần sau bạn nên cẩn thận hơn vì đụng chạm sau đó là quan hệ cách nhau chẳng bao xa. </P>
<P class=normal>Điều bạn băn khoăn nữa là bạn có nên dùng que thử thai luôn không? Chỉ sau khi quan hệ 7-10 ngày bạn dùng que thử thai mới có hiệu quả, vì vậy muốn dùng ngay ngày hôm sau cũng sẽ không có kết quả gì. Còn với viên tránh thai khẩn cấp thì bạn nên dùng trong thời gian sớm nhất khi vừa quan hệ song thì sẽ có hiệu quả, càng để lâu hiệu quả càng kém. Thuốc chỉ có tác dụng trong 72h với Postinor và 120 h với Escapelle. Bạn nên đọc kỹ hướng dẫn sử dụng trước khi dùng.</P>
<P class=normal>Tuy nhiên trong trường hợp của bạn thì chưa phải là quan hệ mà mới chỉ là việc đụng chạm nên bạn không nên quá lo lắng. </P>';
$test	= new tag(1, $text,'','');
echo "<b>" . htmlspecialbo($text) . "</b><br><br>";
$test->insert_tag();
*/
?>