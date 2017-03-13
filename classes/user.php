<?
/**
*class user
*Developed by FinalStyle.com
*/
class user{
	var $logged = 0;
	var $login_name;
	var $use_login;
	var $use_name;
	var $use_fullname;
	var $use_avatar;
	var $password;
	var $u_id = 0;
	var $level = 0;
	var $group_right = 0;
	var $user_right_name_array;
	var $user_right_quantity_array;
	var $use_security;
	var $use_admin = 0;
	var $useField = array();
	var $use_email;
	var $use_phone;
	var $use_address;
	var $use_experience;
	var $use_status;
	var $use_teacher;
	var $use_ex;
	var $user_wallet;
	var $user_admin;
	/*
	init class
	login_name : ten truy cap
	password  : password (no hash)
	level: nhom user; 0: Normal; 1: Admin (default level = 0)
	*/
	function __construct($login_name,$password){
		/*CHECK SYSTEM LOGIN*/
			$sys_login_name = $login_name;
			$sys_login_password = $password;
		/*------------------*/
		$checkcookie=0;
		$this->logged = 0;
		if ($login_name==""){
			if (isset($_COOKIE["login_name"])) $login_name = $_COOKIE["login_name"];
		}
		if ($password==""){
			if (isset($_COOKIE["PHPSESS1D"])) $password = $_COOKIE["PHPSESS1D"];
			$checkcookie=1;
		}
		else{
			//remove \' if gpc_magic_quote = on
			$password = str_replace("\'","'",$password);
		}

		if ($login_name=="" && $password=="") return;

		$db_user = new db_query("SELECT *
								   FROM users
								  WHERE use_email = '" . $this->removequote($login_name) . "'");

		if ($row=mysql_fetch_array($db_user->result)){
			//kiem tra password va use_active
			if($checkcookie == 0)	$password = md5($password . $row["use_security"]);

			// Nếu đăng nhập trên hệ thống
			if($sys_login_name != "" && $sys_login_password != ""){
				if ($password == $row["use_password"] && $row["use_active"] == 1) {
					$this->logged         	= 1;
					$this->login_name 	 	= $login_name;
					$this->use_name 	    = $row["use_name"];
					$this->use_email 	    = $row["use_email"];
					$this->password 	    = $password;
					$this->use_security	 	= $row["use_security"];
					$this->u_id 		    = intval($row["use_id"]);

		            $this->use_avatar	    = $row['use_avatar'];
		            $this->use_login      	= $row['use_login'];
		            $this->use_phone 	    = $row["use_phone"];
		            $this->use_address 	 	= $row["use_address"];
		            $this->use_status     	= $row['use_status'];
		            $this->use_teacher     	= $row['use_teacher'];
		            $this->use_ex     		= $row['use_ex'];
		            $this->user_wallet     	= $row['user_wallet'];
		            $this->user_admin       = $row['user_admin'];
				}
			}else{
				if($row['use_openid'] == 1){
					$this->logged 			= 1;
					$this->login_name 	  	= $login_name;
					$this->use_name 	    = $row["use_name"];
					$this->use_email 	    = $row["use_email"];
					$this->u_id 		    = intval($row["use_id"]);
					$this->use_login       	= $row['use_login'];
	                $this->use_phone 	    = $row["use_phone"];
	                $this->use_address 	  	= $row["use_address"];
	                $this->use_teacher     	= $row['use_teacher'];
	                $this->use_ex     		= $row['use_ex'];
	                $this->user_wallet     	= $row['user_wallet'];
	                $this->user_admin       = $row['user_admin'];
				}else if ($password == $row["use_password"] && $row["use_active"] == 1) {
					$this->logged         	= 1;
					$this->login_name 	 	= $login_name;
					$this->use_name 	    = $row["use_name"];
					$this->use_email 	    = $row["use_email"];
					$this->password 	    = $password;
					$this->use_security	 	= $row["use_security"];
					$this->u_id 		    = intval($row["use_id"]);
		            $this->use_avatar	    = $row['use_avatar'];
		            $this->use_login      	= $row['use_login'];
		            $this->use_phone 	    = $row["use_phone"];
		            $this->use_address 	 	= $row["use_address"];
		            $this->use_status     	= $row['use_status'];
		            $this->use_teacher     	= $row['use_teacher'];
		            $this->use_ex     		= $row['use_ex'];
		            $this->user_wallet     	= $row['user_wallet'];
		            $this->user_admin       = $row['user_admin'];
				}else if($password == $row["use_password"] && $row['use_active'] == 0){
	            	$this->logged = 2;
	         	}
			}
		} unset($db_user);
	}
	/*
	Ham lay truong thong tin ra
	*/
	function row($field){
		if(isset($this->useField[$field])){
			return $this->useField[$field];
		}else{
			return '';
		}
	}
	/*
	save to cookie
	time : thoi gian save cookie, neu = 0 thi` save o cua so hien ha`nh
	*/
	function savecookie($time=0){
		if ($this->logged!=1) return false;

		if ($time > 0){
			setcookie("login_name",$this->login_name,time()+$time,"/");
			setcookie("PHPSESS1D",$this->password,time()+$time,"/");
		}
		else{
			setcookie("login_name",$this->login_name,null,"/");
			setcookie("PHPSESS1D",$this->password,null,"/");
		}
	}

	function fake_login_openid($email, $nickname = "", $fullname = ""){
		$this->logged = 0;
		if($email == "") return '';
		$email		=	replaceMQ($email);
		$db_select 	= new	db_query('SELECT *
										FROM users
	 								   WHERE (use_email = "' . $email . '") AND use_openid = 1 LIMIT 1');
		//dump($db_select->resultArray());die();

		if($row = mysql_fetch_assoc($db_select->result)){
			$this->logged = 1;
			$timeCookie = 30*24*3600;
			setcookie("login_name", $email, time() + $timeCookie,"/");
			//setcookie("PHPSESS1D", $password, time()+$timeCookie,"/");
		}else{
			$use_date   = 	time();
			$password 	= 	md5(rand(11111,99999));

			$db_ex 		= 	new db_execute("INSERT INTO users(use_active,use_login,use_password,use_email,use_date,use_name,use_openid)
										         VALUES( 1,'" . $nickname . "','" . $password . "','" . $email . "','".$use_date."','" . $fullname ."',1)");
		 	unset($db_ex);

        	$db_user = new db_query("SELECT use_id FROM users WHERE use_email = '".$email."';");
         	$row_user = mysql_fetch_assoc($db_user->result);
         	unset($db_user);
		 	$timeCookie = 30*24*3600;
		 	setcookie("login_name", $email, time()+$timeCookie,"/");
			setcookie("PHPSESS1D", $password, time()+$timeCookie,"/");
			$this->logged = 1;
		}
	}

	/*
	Logout account
	*/
	function logout(){
		setcookie("login_name"," ",null,"/");
		setcookie("PHPSESS1D"," ",null,"/");
		$_COOKIE["login_name"] = "";
		$_COOKIE["PHPSESS1D"] = "";
		$this->logged=0;
	}

	//kiem tra password de thay doi email
	function check_password($password){

		$db_user = new db_query("SELECT use_password,use_security
								   FROM users, user_group
								  WHERE use_group = group_id
								    AND use_active=1
								    AND use_login = '" . $this->removequote($this->login_name) . "'");

		if ($row=mysql_fetch_array($db_user->result)){
			$password=md5($password . $row["use_security"]);
			if($password==$row["use_password"]) return 1;
		}
		unset($db_user);
	}

	/*
	Remove quote
	*/
	function removequote($str){
		$temp = str_replace("\'","'",$str);
		$temp = str_replace("'","''",$temp);
		return $temp;
	}

	/*
	check_user_level: Kiem tra xem User co thuoc nhom Admin hay khong. Mac dinh User thuoc nhom Normal.
	table_name: ten bang (Ex; Users)
	data_field: ten truong trong bang (Ex; use_level)
	data_level_value: Gia tri cua use_level (0: Normal member; 1: Admin member)
	where_clause: Dieu kien them
	dump_query: In cau lenh ra man hinh. (0: No; 1: Yes)
	*/
	function check_user_level($table_name,$data_field,$data_level_value,$where_clause="",$dump_query=0){
		if ($this->logged!=1) return 0;
		$level = "SELECT " . $data_field . "
					  FROM " . $table_name . "
					  WHERE " . $data_field . "=" . intval($data_level_value) . " " . $where_clause;
		//Dum_query
		if ($dump_query==1) echo $level;
		//kiem tra query
		$db_check_level = new db_query($level);
		//Check record > 0
		if (mysql_num_rows($db_check_level->result) > 0){
			unset($db_check_level);
			return 1;
		}
		else{
			unset($db_check_level);
			return 0;
		}
	}

	/*
	check_data_in_db : Kiem tra xem data hien thoi co phai thuoc user ko (check trong database)
	table_name : ten table
	data_id_field : Truong id vi du : new_id
	data_id_value : gia tri cua id vi du : 10
	user_id_field : ten truong user_id cua bang do vi du : new_userid, pro_userid....
	where_clause : cua query them va`o sau where vi du : new_approved = 1...
	dump_query : co hien thi query hay ko de debug loi. 0 : ko hien, 1: hien thi
	*/
	function check_data_in_db($table_name,$data_id_field,$data_id_value,$user_id_field,$where_clause="",$dump_query=0){
		if ($this->logged!=1) return 0;
		$my_query =  "SELECT " . $data_id_field . "
					  FROM " . $table_name . "
					  WHERE " . $data_id_field . "=" . $data_id_value . " AND " . $user_id_field . "=" . intval($this->u_id) . " " . $where_clause;

		//neu dump_query = 1 thi in ra ma`n hinh
		if ($dump_query==1) echo $my_query;

		//kiem tra query
		$db_check = new db_query($my_query);
		//neu ton tai record do thi` tra ve gia tri 1, neu ko thi` tra ve gia tri 0
		if (mysql_num_rows($db_check->result) > 0){
			unset($db_check);
			return 1;
		}
		else{
			unset($db_check);
			return 0;
		}
	}

	/*
	check_data : kiem tra xem data co phai thuoc user_id khong (check trong luc fetch_array)
	user_id : gia tri user id để so sánh
	*/
	function check_data($user_id){
		if ($this->logged!=1) return 0;
		if ($this->u_id != $user_id) return 0;
		return 1;
	}

	/*
	change password : Sau khi change password phải dùng hàm save cookie. Su dung trong truong hop Change Profile
	*/
	function change_password($old_password,$new_password){

		//replace quote if gpc_magic_quote = on
		$old_password = str_replace("\'","'",$old_password);
		$new_password = str_replace("\'","'",$new_password);

		//chua login -> fail
		if ($this->logged!=1) return 0;
		//old password ko đúng -> fail
		if (md5($old_password . $this->use_security)!=$this->password) return 0;

		//change password
		$db_update = new db_execute("UPDATE users
									 SET use_password = '" . md5($new_password . $this->use_security). "'
									 WHERE use_id = " . intval($this->u_id));
		//reset password
		$this->password = md5($new_password . $this->use_security);
		return 1;
	}

	/*
	check user access
	*/

	function check_access($right_list,$id_value=0){
		$right_array = explode(",",$right_list);
		//lap trong right_list de tim quyen (right)
		//print_r($this->user_right_name_array);

		for ($i=0;$i<count($right_array);$i++){
			//neu user_right_name_array ma bang rong tuc la khong co quyen nao ca thi return 0
			if(!is_array($this->user_right_name_array)) return 0;
			//Tim thay quyen cua trong right list
			//if (strpos($this->user_right_list,$right_array[$i])!==false){
			//Tim trong array

			$key = array_search($right_array[$i], $this->user_right_name_array);
			//co ton tai

			if ($key!==false){
				//eval global variable
				// global $$right_array["$i"];
				$temp = $$right_array["$i"];
				//Kiem tra xem bien dc eval co ton tai khong
				if (!isset($temp)) { echo "<b>Variable " . $right_array["$i"] . " is undefined. </b><br>"; return 0;}

				//Neu co soluong va` action ko phai fullaccess thi` kiem tra so luong
				if ($this->user_right_quantity_array[$key]!=0 && $temp["action"]!="fullaccess" ){
					//gan query
					$sql = "SELECT count(*) as count
							FROM " . $temp["table_name"] . "
							WHERE " . $temp["user_id_field"] . "=" . $this->u_id . " ";
					//echo $sql;
					//neu action = change value them sql
					if ($temp["action"]=="changevalue") $sql.= " AND " . $temp["change_field"] . "= 1 ";

					//neu id them va`o khac 0 thi` loai bo id khoi cau lenh sql
					if ($id_value!=0) $sql.=" AND " . $temp["id_field"] . "<>" . $id_value;

					//Execute SQL
					$db_sum = new db_query($sql);
					$row = mysql_fetch_array($db_sum->result);
					unset($db_sum);

					//Kiem tra count neu nho hon gia tri cho phep thi` return 1
					if ($row["count"] < $this->user_right_quantity_array[$key]) return 1;

				}
				else{
					return 1;
				}
			}
		}
		return 0;
	}


}
?>
<?
/*
defined right
Bao gom cac thong so sau :
right gom co :  insert : Them 1 ban ghi moi,
				update : Sua chua ban ghi,
				delete : Xoa ban ghi,
				changevalue : Sua 1 column (field) na`o day trong ban ghi, vi du : hot, news, approver
				fullaccess : Admin 1 muc nao do
*/
$right_list = array("right_admin_catalogue");
/*
Defined right detail
*/
//Right admin user access module Blogs
$right_admin_catalogue = array("table_name"    	 =>  "",
						   		"id_field"       =>  "",
						  		"user_id_field"  =>  "",
						   		"change_field"	 =>  "",
						   		"action"		 =>  "fullaccess",
						   		"quantity"		 =>  "",
						   		"description"	 =>  "Admin module Catalogue",
						   		"name"			 =>  "right_admin_catalogue");
?>