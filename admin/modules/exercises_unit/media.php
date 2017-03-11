<?
include("inc_security.php");

//===== variable json=====//
$msg   = "";
$err 	 = "";
$json  = array();

//====== get variable =====//
$exe_id	   = getValue("exe_id","int","POST",0);
$type_id	   = getValue("med_select","int","POST",0);
$type_des	= getValue("med_des","str","POST","");
$media_name = getValue("media_name","str","POST","");

//=========================//
$myform = new generate_form();
$myform->add("media_exe_id" , "exe_id" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("media_type" , "type_id" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("media_des" , "type_des" , 0 , 1 , "" , 1,"" , 0 , "");

if($fs_errorMsg == ""){
   // up data
   $upload		= new upload($media_name,$fs_filepath_data,$fs_extension, $fs_filesize);
   $filename	= $upload->file_name;
   $msg = $filename;
   $err = $filename;
	if($filename != ""){
		$myform->add("media_name","filename", 0, 1, "", 0, "", 0, "");
	}
	$fs_errorMsg .= $upload->show_warning_error();
	
	if($fs_errorMsg == ""){
		$myform->addTable("media_exercies");
		//Insert to database
		$myform->removeHTML(0);
		$db_insert 	= new db_execute_return();
		$last_id		= $db_insert->db_execute($myform->generate_insert_SQL());
		$msg = "Thêm dữ liệu thành công";
	}
}else{
   $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
}
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);

?>