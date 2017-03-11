<?
class dissection{
	
	var $arrayDefine;	
	var $array_type;

	function __construct(){
		$this->arrayDefine		=	array("tuyendung" => array("for_group" => array("label"=>"Nhóm danh sách", "name"=>"for_group", "id"=>"for_group", "type"=>"text", "require" => 1, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "","group" => 1)
																			 	,"for_title" => array("label"=>"Luật tiêu đề", "name"=>"for_title", "id"=>"for_title", "type"=>"text", "require" => 1, "detail" => 1, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																			 	,"for_link" => array("label"=>"Luật URL chi tiết", "name"=>"for_link", "id"=>"for_link", "type"=>"text", "require" => 1, "detail" => 1, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_city" => array("label"=>"Luật tỉnh thành phố", "name"=>"for_city", "id"=>"for_city", "type"=>"int", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_company" => array("label"=>"Luật công ty", "name"=>"for_company", "id"=>"for_company", "type"=>"int", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_status" => array("label"=>"Trạng thái", "name"=>"for_status", "id"=>"for_status", "type"=>"int", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				//,"for_comment" => array("label"=>"Luật comment", "name"=>"for_comment", "id"=>"for_comment", "type"=>"text", "require" => 0, "detail" => 1, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_date" => array("label"=>"Luật ngày tháng", "name"=>"for_date", "id"=>"for_date", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_salary" => array("label"=>"Mức lương", "name"=>"for_salary", "id"=>"for_salary", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_jobtype" => array("label"=>"Loại công việc", "name"=>"for_jobtype", "id"=>"for_jobtype", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_info" => array("label"=>"Thông tin tuyển dụng", "name"=>"for_info", "id"=>"for_info", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_info_company" => array("label"=>"Thông tin DN", "name"=>"for_info_company", "id"=>"for_info_company", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_info_email" => array("label"=>"Email", "name"=>"for_info_email", "id"=>"for_info_email", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_info_phone" => array("label"=>"Điện thoại", "name"=>"for_info_phone", "id"=>"for_info_phone", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_info_address" => array("label"=>"Địa chỉ", "name"=>"for_info_address", "id"=>"for_info_address", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_name_contact" => array("label"=>"Người liên hệ", "name"=>"for_name_contact", "id"=>"for_name_contact", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_experience" => array("label"=>"Số năm kinh nghiệm", "name"=>"for_experience", "id"=>"for_experience", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_career_level" => array("label"=>"Cấp bậc", "name"=>"for_career_level", "id"=>"for_career_level", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				,"for_level" => array("label"=>"Trình độ", "name"=>"for_level", "id"=>"for_level", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				
																				//,"for_afdsdl" => array("label"=>"Quy mo cong ty", "name"=>"for_afdsdl", "id"=>"for_afdsdl", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																				
																				
																				
																			 ),
 													"ungvien" => array("for_group" => array("label"=>"Nhóm list", "name"=>"for_group", "id"=>"for_group", "type"=>"text", "require" => 1, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																			,"for_picture" => array("label"=>"Luật lấy ảnh", "name"=>"for_picture", "id"=>"for_picture", "type"=>"file", "require" => 0, "detail" => 1, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																			,"for_city" => array("label"=>"Luật tỉnh thành phố", "name"=>"for_city", "id"=>"for_city", "type"=>"int", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																			,"for_comment" => array("label"=>"Luật comment", "name"=>"for_comment", "id"=>"for_comment", "type"=>"text", "require" => 0, "detail" => 1, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																			,"for_date" => array("label"=>"Luật ngày tháng", "name"=>"for_date", "id"=>"for_date", "type"=>"text", "require" => 0, "detail" => 0, "position" => "", "inner" => 0, "check_string" => "", "remove_string" => "")
																			 ),
													);
		$this->array_type 		=	array("tuyendung"=>translate_text("Nhà tuyển dụng")
													,"ungvien"=>translate_text("Ứng viên")
													);		
	} //end function
	
	/**
	 * Hàm show form lựa chon
	 */
	
	function get_url_html($url){
		$ini = curl_init($url);
		curl_setopt($ini, CURLOPT_HEADER, false);
		$userAgent  = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13";
		curl_setopt($ini, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ini, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ini, CURLOPT_REFERER, 'http://' . $_SERVER["SERVER_NAME"]);
	
		
		$result 	= curl_exec($ini);
		//echo $userAgent;
		unset($ini);
		$result	= replace_fck($result);
		$html 	= str_get_html($result); 
		unset($result);
		return $html;
	}
	
	function get_list_link($row){
		$foc_url			=	$row["foc_url"];
		$html				=	get_url_html($foc_url);	
		
		//nếu nhóm html khác rỗng thì lấy nhóm trước rồi lấy  phần tử con trong nhóm sau
		$for_group		=	isset($row["for_group"]) ? trim($row["for_group"]) : "";
		$arrayReturn	=	array();
		
		if($for_group != ""){
			$group				=	$html->find($row["for_group"]);
			$i	=	0;
			foreach($group as $tr){
				
				//lap array dinh nghia de lay du lieu
				foreach($this->arrayDefine as $field => $arr){
					if($field == "for_group") continue;
					if(isset($row[$field])){
						
						if($row[$field] != ""){
							//neu index khac rong thi co nghia 1 gia tri
							if($row[$field . "_index"] != ""){
								$field_value = "";
								switch($row[$field . "_inner"]){
									case 0:
										$field_value = @$tr->find($row[$field], intval($row[$field . "_index"]))->plaintext;
									break;
									case 1:
										$field_value = @$tr->find($row[$field], intval($row[$field . "_index"]))->innertext();
									break;
									case 2:
										$field_value = @$tr->find($row[$field], intval($row[$field . "_index"]))->src;
									break;
									case 3:
										$field_value = @$tr->find($row[$field], intval($row[$field . "_index"]))->href;
									break;
								}
								if($field_value != ""){
									if($row[$field . "_rm_string"] != ""){
										$field_value = preg_replace ('/' .  preg_quote($row[$field . "_rm_string"]) . '/si', '', $field_value);
									}
								}
							
								$arrayReturn[$i][$field]	= $field_value;
								$i++;
							}
							
						} //if($row[$field] != "")
						
					} // if(isset($row[$field]))
				}
				
			}
			
		}
		$html->clear();
		unset($html);
		return $arrayReturn;
	}
	
}
?>