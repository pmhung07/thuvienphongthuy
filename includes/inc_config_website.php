<?
$db_con	=	new db_query("SELECT *
									FROM	configuration");
if($row = mysqli_fetch_array($db_con->result)){
	while(list($data_field, $data_value) = each($row)) {
		if (!is_int($data_field)){
			//tao ra cac bien config
			$$data_field = $data_value;
			//echo $data_field . " = " . $data_value . "<br>";
		}
	}
}
$db_con->close();
unset($db_con);

?>