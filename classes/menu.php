<?
class menu
{
	var $menu = array();
	var $stt = -1;
	var $id_root = 0;
	var $list_id	= "";

	/*
	getAllChild : lay het menu con

	Parameter
	$table_name			: Ten bang
	$id_field			: truong id (vd:mnu_id)
	$parent_id_field	: truong parent_id (vd : mnu_parent_id)
	$parent_id			: id cua nu't cha
	$where_clause		: Menh de where trong cau query
	$field_list			: danh sach truong can lay cach nhau = dau ,
	$order_clause		: sap xep theo gi` (sql)
	$has_child_field	: ten truong xac nhan tree do co' con hay ko (vd: mnu_has_child)
	$update				: co update has_child vao database hay khong
	*/
	function getAllChild($table_name,$id_field,$parent_id_field,$parent_id,$where_clause="1",$field_list,$order_clause,$has_child_field,$update=0,$level=0,$callback=0)
	{
		//select menu from database
		$db_menu = new db_query(" SELECT * " .
										"FROM " . $table_name . " " .
										"WHERE " . $parent_id_field . "=" . $parent_id . " AND " . $where_clause . " " .
										"ORDER BY " . $order_clause);
		//thiet lap $has_child_field = 0 khi menu ko co con
		if(mysqli_num_rows($db_menu->result) == 0 && $update == 1){
			$db_update = new db_query("UPDATE " . $table_name . " SET " . $has_child_field . "=0 WHERE " . $id_field . "=" . $parent_id);
		}

		$No = 0;
		//lap de lay menu
		while ($row=mysqli_fetch_array($db_menu->result)){

			//Tăng số No
			$No++;
			//tang so thu tu
			$this->stt++;
			//break field_list in to array
			$field_list_arr = explode(",",$field_list);
			//gan gia tri menu vao array
			for ($i=0;$i<count($field_list_arr);$i++){
				$this->menu[$this->stt][$field_list_arr[$i]] = $row[$field_list_arr[$i]];
			}
			//gan level cho menu
			$this->menu[$this->stt]["level"] = $level;

			//Kiểm tra xem có phải là cái cuối cùng trong menu hay ko
			if($No < mysqli_num_rows($db_menu->result)){
				$this->menu[$this->stt]["last"] = 0;
			}
			else{
				$this->menu[$this->stt]["last"] = 1;
			}

			//de quy de lap lai
			if ($row[$has_child_field] != 0){
				$this->getAllChild($table_name,$id_field,$parent_id_field,$row[$id_field],$where_clause,$field_list,$order_clause,$has_child_field,$update,$level+1,1);
			}
		}
		if ($callback==0){
			$db_menu->close();
		}
		unset($db_menu);
		//tra ve gia tri menu
		if ($callback==0) return $this->menu;
	}
	/*
	getListChild		: lay het menu con để đưa vào danh sách

	Parameter
	$table_name			: Ten bang
	$id_field			: truong id (vd:mnu_id)
	$parent_id_field	: truong parent_id (vd : mnu_parent_id)
	$parent_id			: id cua nu't cha
	$where_clause		: Menh de where trong cau query
	$has_child_field	: ten truong xac nhan tree do co' con hay ko (vd: mnu_has_child)
	*/
	function getListChild($table_name,$id_field,$parent_id_field,$parent_id,$where_clause="1",$has_child_field,$level=0,$callback=0)
	{
		//select menu from database
		$db_menu = new db_query("SELECT " . $id_field . ", " . $has_child_field . " " .
										"FROM " . $table_name . " " .
										"WHERE " . $parent_id_field . "=" . $parent_id . " AND " . $where_clause . "
										 ORDER BY " . $id_field . " ASC");
		//lap de lay menu
		while ($row=mysqli_fetch_array($db_menu->result)){

			//tang so thu tu
			$this->stt++;
			$this->list_id	.= $row[$id_field] . ",";

			//de quy de lap lai
			if ($row[$has_child_field] != 0){
				$this->getAllChild($table_name,$id_field,$parent_id_field,$row[$id_field],$where_clause,$has_child_field,$level+1,1);
			}

		}

		unset($db_menu);
		//tra ve gia tri menu
		if ($callback==0) return $this->list_id;
	}


	/*
	getChild : lay menu con

	Parameter
	$table_name			: Ten bang
	$id_field			: truong id (vd:mnu_id)
	$parent_id_field	: truong parent_id (vd : mnu_parent_id)
	$parent_id			: id cua nu't cha
	$where_clause		: Menh de where trong cau query
	$field_list			: danh sach truong can lay cach nhau = dau ,
	$order_clause		: sap xep theo gi` (sql)
	*/
	function getChild($table_name,$id_field,$parent_id_field,$parent_id,$where_clause="1",$field_list,$order_clause)
	{
		//select menu from database
		$db_menu = new db_query("SELECT * " .
										"FROM " . $table_name . " " .
										"WHERE " . $parent_id_field . "=" . $parent_id . " AND " . $where_clause . " " .
										"ORDER BY " . $order_clause);
		//thiet lap $has_child_field = 0 khi menu ko co con
		if(mysqli_num_rows($db_menu->result) ==0){
			$db_update = new db_query("UPDATE " . $table_name . " SET " . $has_child_field . "=0 WHERE " . $id_field . "=" . $parent_id);
		}
		//lap de lay menu
		while ($row=mysqli_fetch_array($db_menu->result)){
			//tang so thu tu
			$this->stt++;

			//break field_list in to array
			$field_list_arr = explode(",",$field_list);
			//gan gia tri menu vao array
			for ($i=0;$i<count($field_list_arr);$i++){
				$this->menu[$this->stt][$field_list_arr[$i]] = $row[$field_list_arr[$i]];
			}
			//gan level cho menu
			$this->menu[$this->stt]["level"] = 0;

		}

		$db_menu->close();
		unset($db_menu);
		//tra ve gia tri menu

		return $this->menu;
	}


	/*
	getOpenNode : Lay menu cua 1 nu't nao do

	Parameter
	$table_name			: Ten bang
	$id_field			: truong id (vd:mnu_id)
	$parent_id_field	: truong parent_id (vd : mnu_parent_id)
	$parent_id			: id cua nu't cha
	$where_clause		: Menh de where trong cau query
	$field_list			: danh sach truong can lay cach nhau = dau ,
	$order_clause		: sap xep theo gi` (sql)
	$array_parent_node: mang cac nut cha
	*/
	function getOpenNode($table_name,$id_field,$parent_id_field,$parent_id,$where_clause="1",$field_list,$order_clause,$array_parent_node,$level=0,$callback=0)
	{
		//select menu from database
		$db_menu = new db_query("SELECT * " .
										"FROM " . $table_name . " " .
										"WHERE " . $parent_id_field . "=" . $parent_id . " AND " . $where_clause . " " .
										"ORDER BY " . $order_clause);
		//lap de lay menu
		while ($row=mysqli_fetch_array($db_menu->result)){
			//tang so thu tu
			$this->stt++;

			//break field_list in to array
			$field_list_arr = explode(",",$field_list);
			//gan gia tri menu vao array
			for ($i=0;$i<count($field_list_arr);$i++){
				$this->menu[$this->stt][$field_list_arr[$i]] = $row[$field_list_arr[$i]];
			}
			//gan level cho menu
			$this->menu[$this->stt]["level"] = $level;
			$this->menu[$this->stt]["parent"] = 0;

			//de quy de lap lai, neu menu_id man trong array cac menu cha
			if (array_search($row[$id_field],$array_parent_node)!==false){
				//thiet lap de biet day la` 1 nut cha
				$this->menu[$this->stt]["parent"] = 1;
				$this->getOpenNode($table_name,$id_field,$parent_id_field,$row[$id_field],$where_clause,$field_list,$order_clause,$array_parent_node,$level+1,1);
			}
		}

		if ($callback==0){
			$db_menu->close();
		}
		unset($db_menu);
		//tra ve gia tri menu
		if ($callback==0) return $this->menu;
	}


	/*
	getAllParent : Lay ta ca cac nut cha

	$table_name			: Ten bang
	$id_field			: truong id (vd:mnu_id)
	$parent_id_field	: truong parent_id (vd : mnu_parent_id)
	$id					: id cua nu't can lay danh sach cha
	*/
	function getAllParent($table_name,$id_field,$parent_id_field,$id){
		$count_var =0;
		$array_parent_node[$count_var] = 0;

		$finish=false;
		$current_id = $id;
		while (!$finish){
			$db_getparent = new db_query ("SELECT " . $parent_id_field . " " .
													"FROM " . $table_name . " " .
													"WHERE " . $id_field . "=" . $current_id);
			if ($row=mysqli_fetch_array($db_getparent->result)){
				$count_var++;
				$array_parent_node[$count_var] = $current_id;
				$current_id = $row[$parent_id_field];
			}
			else{
				$finish=true;
			}
		}
		return $array_parent_node;
	}

	//get all parent list
	function getAllParentList($table_name,$id_field,$name_field,$parent_id_field,$id,$seperate_str,$class_link="link",$type_list=0){
		$count_var = 0;
		$parent_list = "";
		$finish = false;
		$current_id = $id;
		while (!$finish){
			$db_getparent = new db_query ("SELECT " . $id_field . "," . $parent_id_field . "," . $name_field . " " .
													"FROM " . $table_name . " " .
													"WHERE " . $id_field . "=" . $current_id);
			if ($row=mysqli_fetch_array($db_getparent->result)){
				$link		= generate_type_url($row[$name_field], $row[$id_field]);
				$count_var++;
				//ghep vao chuoi str
				if ($parent_list==""){
					if($type_list==0){
						$parent_list = '<span>' . $row[$name_field] . '</span>';
					}
					else{
						$parent_list = '<a href="' . $link . '">' . $row[$name_field] . '</a>';
					}
				}else{
					$parent_list = '<a href="' . $link . '">' . $row[$name_field] . '</a>' . $seperate_str . $parent_list;
				}

				$current_id = $row[$parent_id_field];
				$this->id_root = $row[$id_field];
			}
			else{
				$finish=true;
			}
		}
		return $parent_list;
	}
	//gan du lieu vao mot array (dinhtoan1905)
	/*
	table_name 				: tên bảng
	id_field 				: trường id của bảng đó
	parent_id_field 		: trường parent id
	where_clause	 		: điều kiện where
	lấy toàn bộ id và parent_id gán vào 1 array
	*/
	function getArray($table_name,$id_field,$parent_id_field,$where_clause = "1"){
		$db_getparent = new db_query ("SELECT " . $parent_id_field . ',' . $id_field .
												" FROM " . $table_name . " " .
												" WHERE " . $where_clause);
		while($row=mysqli_fetch_array($db_getparent->result)){
			if($row[$parent_id_field]==0){
				$this->arrayCount[$row[$id_field]] = 0;
			}else{
				$this->arrayCatId[$row[$id_field]] = $row[$parent_id_field];
			}
		}
		unset($db_getparent);
	}



	//lay category cap cha cao nhat (dinhtoan1905)
	/*
	hàm này chỉ chạy được sau khi gọi hàm getArray
	hàm này để lấy category cấp cao nhất của category hien tai (id)
	id: iCat hiện hành
	*/
	function getCatcha($id){
		while(@array_key_exists($id,$this->arrayCatId)){
			$id = $this->arrayCatId[$id];
		}
		return $id;
	}


	function getParentid($table_name,$id_field,$parent_id_field,$id){
		$current_id = $id;
		$finish		= false;
		while (!$finish){
			$db_getparent = new db_query ("SELECT " . $parent_id_field .
													" FROM " . $table_name . " " .
													" WHERE " . $id_field . "=" . $current_id . " AND "  . $parent_id_field . "<>0");
			if($row = mysqli_fetch_assoc($db_getparent->result)){
				$current_id = $row[$parent_id_field];
			}else{
				$finish	=	true;
			}
		}//end while
		return $current_id;
	}//end function


	//lay tat ca cap con (dinhtoan1905)
	/*
	hàm này chỉ chạy được sau khi gọi hàm getArray
	lấy ra tất cả cấp con cùa category hiện hành
	id: category hiện hành
	*/
	function getAllChildId($id){
		$strreturn 				= $id;
		$arrayreturn 			= array();
		$array 					= $this->arrayCatId;
		$finish 				= @in_array($id,$this->arrayCatId);
		while($finish){
			$finish = false;

			foreach($array as $key=>$value){
				if($value == $id){
					$strreturn				.= ',' . intval($key);
					$this->countId++;
					$arrayreturn[$key]	 = 0;
					unset($array[$key]);
				}
			}

			foreach($arrayreturn as $key1=>$value1){
				foreach($array as $key=>$value){
					if($value == $key1){
						$strreturn				.= ',' . intval($key);
						$this->countId++;
						$arrayreturn[$key] 	= 0;
						unset($array[$key]);
						$finish = true;
					}
				}
				unset($arrayreturn[$key1]);
			}
		}//end while
		unset($arrayreturn);
		unset($array);
		return $strreturn;
	}

}
?>