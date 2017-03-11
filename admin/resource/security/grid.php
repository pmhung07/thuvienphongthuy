<?
/*
	Code : dinhtoan1905
	Classs tao listing trong admin
	
*/
class fsDataGird
{
	
	var $stt 					= 0;
	var $arrayField 			= array();
	var $arrayLabel 			= array();
	var $arrayType	 			= array();
	var $arrayAttribute		= array();
	var $field_id				=  '';
	var $field_name			=  '';
	var	$image_path			= '../../resource/images/grid/';
	var	$fs_border			= "#C3DAF9";
	var $html					= '';
	var $scriptText			= '';
	var $title					= '';
	var $arraySort				= array();
	var $arraySearch			= array();
	var $arrayAddSearch		= array();
	var $quickEdit 			= true;
	var $total_list			= 0;
	var	$total_record		= 0;
	var	$page_size			= 30;
	var $edit_ajax				= false;
	var $showid					= true;
	var $arrayFieldLevel		= array();
	var $delete 				= true;
	var $searchKeyword		= false;
	var $sql_keyword 			= '';
	
	
	//add cac truong va tieu de vao
	function fsDataGird($field_id,$field_name,$title){
		$this->field_id 	= $field_id;
		$this->field_name	= $field_name;
		$this->title 		= $title;
	}
	
	
	/*
	1: Ten truong trong bang
	2: Tieu de header
	3: kieu du lieu
	4: co sap xep hay khong, co thi de la 1, khong thi de la 0
	5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
	*/
	function add($field_name, $lable, $type = "string", $sort=0, $search=0, $attributes = ""){
		if($sort == 1) $this->arraySort[$this->stt] = $field_name;
		if($search == 1) $this->arraySearch[$this->stt] = $field_name;
		
		$this->arrayField[$this->stt] = $field_name;
		$this->arrayLabel[$this->stt] = $lable;
		$this->arrayType[$this->stt]  = $type;
		$this->arrayAttribute[$this->stt]  = $attributes;
		$this->stt++;
		if($type=="array"){
			global $$field_name;
			$arrayList = $$field_name;
			$strdata   = array();
			foreach($arrayList as $key=>$value){
				$strdata[] = $key . ':' . "'" . str_replace("'","\'",$value) . "'";
			}
			$strdata = implode(",",$strdata);
			$this->scriptText .= '<script type="text/javascript">';
			$this->scriptText .=  '$(function() {
										  $(".editable_select_' . $field_name . '").editable("listing.php?ajaxedit=1", { 
											 indicator : \'<img src="' . $this->image_path . 'indicator.gif">\',
											 tooltip   : "' . translate_text("No selected") . '",
											 data   : "{' . $strdata . '}",
											 type   : "select",
											 submit : "' . translate_text("Save") . '",
											 style  : "inherit",
											 submitdata : function() {
												return {id : $(this).attr("name"),array : \'' . $field_name . '\'};
											 }
										  });
										});';
			$this->scriptText .= '</script>';
		}
		
	}
	
	function showHeader($total_list){
		//goi phan template
		$str = template_top($this->title,$this->urlsearch());
		if($this->quickEdit){
			//phan quick edit
			$str .= '<form action="quickedit.php?url=' . base64_encode($_SERVER['REQUEST_URI']) . '" method="post" enctype="multipart/form-data" name="listing">
						<input type="hidden" name="iQuick" value="update">';
		}		
		// khoi tao table
		$str .= '<table id="listing" cellpadding="5" cellspacing="0" border="1" bordercolor="' . $this->fs_border . '" width="100%" class="table">';
		
		//phan header
		
		$str .= '</tr>';
		
		//tru?ng ID
		$str .= '<th class="h" width="30">ID</th>';
		
		//phan checkbok all
		if($this->delete) $str .= '<th class="h check"><input type="checkbox" id="check_all" onclick="checkall(' . $total_list . ')"></th>';
		
		if($this->quickEdit){
			//phan quick edit
			$str .= '<th class="h"><img src="' . $this->image_path . 'save.png" onclick="document.listing.submit()" style="cursor: pointer;" border="0"></th>';
		}
		
		foreach($this->arrayLabel as $key=>$lable){
			
			$str .= '<th class="h">' . $lable . $this->urlsort($this->arrayField[$key]) . ' </th>';
			
		}
		$str .= '</tr>';		
		
		return $str;		
	}
	
	/*
	Ham hien thi ra listing
	db : ket qua tra ve cua cau lenh query g?i t? class db_query
	*/
	
	function showTable($db,$multi=0){
		
		//phan html help
		$str = '';
		$str .= $this->showHeader(mysql_num_rows($db->result));

		$i=0;
		
		$page = getValue("page");
		if($page<1) $page = 1;
		
		while($row = mysql_fetch_assoc($db->result)){
			$i++;
			$str .= '<tbody id="tr_' . $row[$this->field_id] . '">';
			$str .= '<tr ' . (($i%2==0) ? 'bgcolor="#f7f7f7"' : '') . '>';
			
			//phan so thu tu
			if($this->showid){
				$str .= $this->showId($i, $page);
			}

			//phan checkbok cho tung record
			$str .= $this->showCheck($i, $row[$this->field_id]);
			
			foreach($this->arrayField as $key=>$field){
			
				$str .= $this->checkType($row,$key);
				
			}
			
			$str .= '</tr>';
			$str .= '</tbody>';
		}
		
		
		//phan footer
		
		$str .= $this->showFooter(mysql_num_rows($db->result));

		
		return $str;
	}
	
	function start_tr($i, $record_id, $add_html = ""){
		$page = getValue("page");
		if($page<1) $page = 1;
		
		$str = '<tbody id="tr_' . $record_id . '">
					<tr ' . (($i%2==0) ? 'bgcolor="#f7f7f7"' : '') . '>';
		$str .= $this->showid($i, $page);
		$str .= $this->showCheck($i, $record_id);
		return $str;
		
	}
	function end_tr(){
		$str = '</tr></tbody>';
		return $str;
	}
	
	function showId($i, $page){
		$str = '<td width=15 align="center"><span style="color:#142E62; font-weight:bold">' . ($i+(($page-1)*$this->page_size)) . '</span></td>';
		return $str;
	}
	function showCheck($i, $record_id){
		$str = (!$this->delete) ? "" : '<td class="check"><input type="checkbox" class="check" name="record_id[]" id="record_' . $i . '" value="' . $record_id . '"></td>';
		if($this->quickEdit){
			//phan quick edit
			$str .= '<td width=15><img src="' . $this->image_path . 'save.png" style="cursor: pointer;" onclick="document.getElementById(\'record_' . $i . '\').checked = true; document.listing.submit()" border="0"></td>';
		}
		return $str;				
	}
	function showEdit($record_id){
		return '<td width="10" align="center"><a class="edit"  rel="tooltip" title="' . translate_text("B?n mu?n s?a b?n ghi") . '" href="edit.php?record_id=' .  $record_id . '&url=' . base64_encode($_SERVER['REQUEST_URI']) . '"><img src="' . $this->image_path . 'edit.png" border="0"></a></td>';
	}
	function showDelete($record_id){
		return '<td width="10"  align="center"><a class="delete" href="#" onclick="if (confirm(\''  . str_replace("'","\'",translate_text("B?n mu?n x�a b?n ghi?")) . '\')){ deleteone(' . $record_id . '); }"><img src="' . $this->image_path . 'delete.gif" border="0"></a></td>';	
	}
	function showCopy($record_id){
		return '<td width="10" align="center"><a class="edit"  rel="tooltip"  title="' . translate_text("Copy th�m m?t b?n ghi m?i") . '" href="copy.php?record_id=' .  $record_id . '&url=' . base64_encode($_SERVER['REQUEST_URI']) . '"><img src="' . $this->image_path . 'copy.gif" border="0"></a></td>';
	}
	function addAttr($i, $name, $id = "", $class = "form_control"){
		if($id == "") $id = $name;
		return ' class="form_control" name="' . $name . '" id="' . $id . '" onkeyup="check_edit(\'record_' . $i . '\')"';
	}
	function showCheckbox($field, $value, $record_id){
		return '<td width="10" align="center"><a class="edit" onclick="update_check(this); return false" href="active.php?ajax=1&field=' . $field . '&checkbox=1&record_id=' .  $record_id . '&url=' . base64_encode($_SERVER['REQUEST_URI']) . '"><img src="' . $this->image_path . 'check_' . $value . '.gif" border="0"></a></td>';
	}
	function showFooter($total_list,$add_html=NULL){
		$str = '</tr>';
			
		//goi ham xu ly phan footer ra
		$str .= '<th class="f" colspan="' . (count($this->arrayLabel)+3) . '">' . $this->footer($total_list,$add_html).'</th>';
		$str .= '</tr>';
		$str .= '</table>';
		$str .= '</form>';
		//khet thuc phan template
		$str .= template_bottom();	
		return $str;	
	}
	
	/*
	ham xu ly hien thi theo dang multi
	*/
	
	function showTableMulti($db){
		
		//goi phan template
		$this->html .= template_top($this->title,$this->urlsearch());
		
		// khoi tao table
		$this->html .= '<table id="listing" cellpadding="5" cellspacing="0" border="1" bordercolor="' . $this->fs_border . '" width="100%" class="table">';
		
		//phan header
		
		$this->html .= '</tr>';
		
		$this->html .= '<th width="30">STT</th>';
		
		$this->total_list 		.= count($db);
		
		//phan checkbok all
		$this->html .= '<th class="h check"><input type="checkbox" id="check_all" onclick="checkall(' . $this->total_list . ')"></th>';
		
		if($this->quickEdit){
			//phan quick edit
			$this->html .= '<th class="h"><img src="' . $this->image_path . 'qedit.png" border="0"></th>';
		}
		
		//ph?n hi?n th? ti�u d?
		foreach($this->arrayLabel as $key=>$lable){
			
			$this->html .= '<th class="h">' . $lable . $this->urlsort($this->arrayField[$key]) . ' </th>';
			
		}
		
		$this->html .= '</tr>';
		
		$page = getValue("page");
		if($page<1) $page = 1;

		$i=0;
		foreach($db as $key=>$row){
			$i++;
			$this->html .= '<tbody id="tr_' . $row[$this->field_id] . '">';
			$this->html .= '<tr ' . (($i%2==0) ? 'bgcolor="#f7f7f7"' : '') . '>';
			
			//phan so thu tu
			//phan so thu tu
			if($this->showid){
				$this->html .= '<td width=15 align="center"><span style="color:#142E62; font-weight:bold">' . ($i+(($page-1)*$this->page_size)) . '</span></td>';
			}
			//phan checkbok cho tung record
			$this->html .= '<td class="check"><input type="checkbox" class="check" name="record_id[]" id="record_' . $i . '" value="' . $row[$this->field_id] . '"></td>';
			
			if($this->quickEdit){
				//phan quick edit
				$this->html .= '<td width=15 align="center"><a class="thickbox" rel="tooltip" title="' . translate_text("Do you want quick edit basic") . '" href="quickedit.php?record_id=' . $row[$this->field_id] . '&url=' . base64_encode($_SERVER['REQUEST_URI']) . '&KeepThis=true&TB_iframe=true&height=300&width=400"><img src="' . $this->image_path . 'qedit.png" border="0"></a></td>';
			}
			foreach($this->arrayField as $key=>$field){
			
				$this->html .= $this->checkType($row,$key);
				
			}
			
			$this->html .= '</tr>';
			$this->html .= '</tbody>';
		}
		
		
		//phan footer
		
		$this->html .= '</tr>';
			
			//goi ham xu ly phan footer ra
			$this->html .= '<th class="f" colspan="' . (count($this->arrayLabel)+3) . '">' . $this->footer() . '</th>';
			
		
		$this->html .= '</tr>';
		
		
		$this->html .= '</table>';
		
		//khet thuc phan template
		$this->html .= template_bottom();
		
		return $this->html;
	}
	/*
	
	Ham xu ly type hien thi
	x? l� c�c ki?u hi?n th? trong listing
	row  : truy?n array row g?i t? mysql_fetch_assoc ra
	key  : th? t? tru?ng add v�o 
	*/
	
	function checkType($row,$key){
		$level = "";
		if(isset($this->arrayFieldLevel[$this->arrayField[$key]])){
			for($i=0;$i<$row["level"];$i++){
				$level .= $this->arrayFieldLevel[$this->arrayField[$key]];
			}
		}
		switch($this->arrayType[$key]){
			
			//ki?u ti?n t? VN�
			case "vnd":
				return '<td ' . $this->arrayAttribute[$key] . '><span class="clickedit vnd" style="display:inline" id="' . $this->arrayField[$key] . ',' . $row[$this->field_id] . ',3">' .  formatNumber($row[$this->arrayField[$key]]) . '</span></td>';
			break;
			
			//ki?u ti?n t? USD
			case "usd":
				return '<td ' . $this->arrayAttribute[$key] . '><span class="clickedit vnd" style="display:inline" id="' . $this->arrayField[$key] . ',' . $row[$this->field_id] . ',3">' .  $row[$this->arrayField[$key]] . '</span></td>';
			break;
			
			//ki?u ng�y th�ng
			case "date":
				return '<td class="date" align="center" ' . $this->arrayAttribute[$key] . '>' .  date("d/m/Y",$row[$this->arrayField[$key]]) . '</td>';
			break;
			
			//ki?u h�nh ?nh
			case "picture":
				if($row[$this->arrayField[$key]]!=''){
					global $fs_filepath;
					return '<td width="30" align="center" style="padding:1px;" ><a rel="tooltip"  title="<img src=\'' . $fs_filepath . "small/small_" . $row[$this->arrayField[$key]] . '\' border=\'0\'>" href="#"><img src="' . $fs_filepath . "/small/small_" . $row[$this->arrayField[$key]] . '" width=30 height="20" border="0"></a></td>';
				}else{
					return '<td width="30">&nbsp;</td>';
				}
			break;
			
			//ki?u m�ng d�ng cho combobox c� th? edit
			case "array":
				$field = $this->arrayField[$key];
				global $$field;
				$arrayList = $$field;
				$value = isset($arrayList[$row[$this->arrayField[$key]]]) ? $arrayList[$row[$this->arrayField[$key]]] : '';
				return '<td ' . $this->arrayAttribute[$key] . '  class="tooltip"  title="' . translate_text("Click s?a d?i sau d� ch?n save") . '"><span class="editable_select_' . $this->arrayField[$key] . '" style="display:inline" id="select_2" name="' . $this->arrayField[$key] . ',' . $row[$this->field_id] . ',0">' . str_replace("-","",$value)  . '</span></td>';
			break;
			
			//ki?u m�ng ch? hi?n th? kh�ng edit du?c
			case "arraytext":
				$field = $this->arrayField[$key];
				global $$field;
				$arrayList = $$field;
				$value = isset($arrayList[$row[$this->arrayField[$key]]]) ? $arrayList[$row[$this->arrayField[$key]]] : '';
				return '<td ' . $this->arrayAttribute[$key] . '>' . str_replace("-","",$value)  . '</td>';
			break;
			
			//ki?u copy b?n ghi
			case "copy":
				return '<td width="10" align="center"><a class="edit"  rel="tooltip"  title="' . translate_text("Nh�n b?n th�m m?t b?n ghi m?i") . '" href="copy.php?record_id=' .  $row[$this->field_id] . '&url=' . base64_encode($_SERVER['REQUEST_URI']) . '"><img src="' . $this->image_path . 'copy.gif" border="0"></a></td>';
			break;
			
			//ki?u check box gi� tr? l� 0 ho?c 1
			case "checkbox":
				return '<td width="10" align="center"><a class="edit" onclick="update_check(this); return false" href="listing.php?field=' . $this->arrayField[$key] . '&checkbox=1&record_id=' .  $row[$this->field_id] . '&url=' . base64_encode($_SERVER['REQUEST_URI']) . '"><img src="' . $this->image_path . 'check_' . $row[$this->arrayField[$key]] . '.gif" border="0"></a></td>';
			break;
			
			//ki?u hi?n th? n�t edit
			case "edit":
				return '<td width="10" align="center"><a class="edit"  rel="tooltip" title="' . translate_text("B?n mu?n s?a d?i b?n ghi") . '" href="edit.php?record_id=' .  $row[$this->field_id] . '&url=' . base64_encode($_SERVER['REQUEST_URI']) . '"><img src="' . $this->image_path . 'edit.png" border="0"></a></td>';
			break;
			
			//k?u hi?n th? n�t x�a
			case "delete":
				if($this->delete){
					return '<td width="10"  align="center"><a class="delete" href="#" onclick="if (confirm(\''  . str_replace("'","\'",translate_text("B?n mu?n x�a b?n ghi?") . ': ' . $row[$this->field_name])  . '\')){ deleteone(' . $row[$this->field_id] . '); }"><img src="' . $this->image_path . 'delete.gif" border="0"></a></td>';
				}else{
					return '';
				}
			break;
			
			//k?u hi?n th? n�t xem to�n b? ph� gi� c?a doanh nghi?p
			case "view_phagia":
				return '<td width="80" align="center"><a class="edit"  rel="tooltip" title="' . translate_text("Xem to�n b? ph� gi�") . '" href="../phagia/listing.php?iBus=' .  $row[$this->field_id] . '&url=' . base64_encode($_SERVER['REQUEST_URI']) . '"><img src="' . $this->image_path . 'view.gif" border="0"></a></td>';
			break;
			
			//ki?u hi?n th? text c� s?a d?i
			case "string":
				return '<td ' . $this->arrayAttribute[$key] . ' class="tooltip"  title="' . translate_text("Click v�o d? s?a d?i sau d� enter d? luu l?i") . '">' . $level . '<span class="clickedit" style="display:inline" id="' . $this->arrayField[$key] . ',' . $row[$this->field_id] . ',0">' .  $row[$this->arrayField[$key]] . '</span></td>';
			break;
			
			//ki?u hi?n th? text kh�ng s?a d?i
			case "text":
				return '<td ' . $this->arrayAttribute[$key] . '>'  .  $row[$this->arrayField[$key]] . '</td>';
			break;
			
			//ki?u hi?n th? s? c� s?a d?i
			case "number":
				return '<td ' . $this->arrayAttribute[$key] . ' class="tooltip"  title="' . translate_text("Click v�o d? s?a d?i sau d� enter d? luu l?i") . '" align="center" width="10%" nowrap="nowrap">' . $level . '<span class="clickedit" style="display:inline" id="' . $this->arrayField[$key] . ',' . $row[$this->field_id] . ',0">' .  $row[$this->arrayField[$key]] . '</span></td>';
			break;
			
			//ki?u hi?n th? s? ko s?a d?i
			case "numbernotedit":
				return '<td ' . $this->arrayAttribute[$key] . ' align="center" width="10%" nowrap="nowrap">' . $level .  $row[$this->arrayField[$key]] . '</td>';
			break;
			
			//ki?u hi?n n�t reset
			case "resetpass":
				return '<td width="10"  align="center"><a href="#" onclick="if (confirm(\''  . str_replace("'","\'",translate_text("B?n mu?n reset l?i password c?a user n�y kh�ng?") . ': ' . $row[$this->field_name])  . '\')){ resetpass(' . $row[$this->field_id] . '); }"><img src="' . $this->image_path . 'reset.gif" border="0"></a></td>';
			break;
			
			//k?u hi?n th? n�t gui email
			case "sent_email":
				return '<td width="80" align="center"><a class="edit" href="#"  rel="tooltip" title="' . translate_text("G?i email th�ng b�o t?i th�nh vi�n") . '" onclick="sent_email(\'' . $row[$this->field_id] . '\')"><img src="' . $this->image_path . 'send.gif" border="0"></a></td>';
			break;
			
			//d?ng m?c d?nh
			default:
				return '<td ' . $this->arrayAttribute[$key] . '>' .  $row[$this->arrayField[$key]] . '</td>';
			break;
		}
	}
	
	/*
	ham format kieu so
	*/
	function formatNumber($number){
		$number = number_format(round($number/1000)*1000,0,"",".");
		return $number;
	}
	
	/*
	phan header javascript
	*/
	
	function headerScript(){
		$this->scriptText .= '<script type="text/javascript">';
		//phan script edit nhanh text box
		$this->scriptText .= '$(function() {
        
									  $(".clickedit").editable("listing.php?ajaxedit=1", { 
											indicator : "<img src=\'../../resource/images/grid/indicator.gif\'>",
											tooltip   : "' . translate_text("Click to edit...") . '",
											style  : "inherit"
									  });
									});
									';
									
		
		//phan javascript hover vao cac tr
		$this->scriptText .= "$( function(){
											var bg = '';
											$('table#listing tr').hover( function(){
												bg = $(this).css('background-color');
												$(this).css('background-color', '#FFFFCC');
											},
											function(){
												$(this).css('background-color', bg);
											});
							
									});";
		$this->scriptText .= '</script>';
		$this->scriptText .= '<script language="javascript" src="../../resource/js/grid.js"></script>';
		
		return $this->scriptText;						
		
	}
	
	/*
	ham tao ra nut sap xep
	field : t�n tru?ng
	*/
	function urlsort($field){
		$str 	= '';

		if(in_array($field,$this->arraySort)){

			$url 			= getURL(0,1,1,1,"sort|sortname");
			$sort 		= getValue("sort","str","GET","");
			$sortname 	= getValue("sortname","str","GET","");
			$img			= 'sort.gif';
			if($sortname!=$field) $sort = "";
			switch($sort){
				case "asc":
					$url 	= $url . "&sort=desc";
					$img	= 'sort-asc.gif';
				break;
				case "desc":
					$url 	= $url . "&sort=asc";
					$img	= 'sort-desc.gif';
				break;
				default:
					$url 	= $url . "&sort=asc";
					$img	= 'sort.gif';
				break;
			}
			
			$url 	= $url . "&sortname=" . $field;
					
			$str = '&nbsp;<span><a href="' . $url . '"  rel="tooltip"  title="' . translate_text("Sort A->Z or Z->A") . '" onclick="loadpage(this); return false" ><img src="' . $this->image_path . $img . '" align="absmiddle" border="0"></a></span>';

		}

		return $str;
	}
	
	/*
	ham tao cau lanh sql sort
	h�m sinh ra c�u l�nh query sort tuong ?ng
	*/
	
	function sqlSort(){
		$sort 		= getValue("sort","str","GET","");
		$field	 	= getValue("sortname","str","GET","");
		$str 			= '';
		if(in_array($field,$this->arraySort) && ($sort == "asc" || $sort == "desc")){
			$str 		= $field . ' ' . $sort . ',';
		}
		return $str;
	}
	/*
	ham add them cac truong search
	name : ti�u d?
	field : t�n tru?ng
	type : ki?u search
	value : gi� tr? n?u ki?u array th� truy?n v�o m?t array
	default: gi� tr? m?c d?nh
	*/
	function addSearch($name,$field,$type,$value = '',$default=""){
		$str = '';
		switch($type){
			//ki?u array
			case "array":
				$str .= '<select name="' . $field . '" id="' . $field . '" class="textbox">';
					foreach($value as $id=>$text){
						$str .= '<option value="' . $id . '" ' . (($default==$id) ? 'selected' : '') . '>' . $text . '</option>';
					}
				$str .= '</select>';
			break;
			
			//ki?u ng�y th�ng
			case "date":
				$value = getValue($field,"str","GET","dd/mm/yyyy");
				$str .= '<input type="text"  class="textbox" name="' . $field . '" id="' . $field . '" style="width:90px;"  onKeyPress="displayDatePicker(\'' . $field . '\', this);" onClick="displayDatePicker(\'' . $field . '\', this);" onfocus="if(this.value==\'' . translate_text("Enter date") . '\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'' . translate_text("Enter date")  . '\'" value="' . $value . '">';
			break;
			
			//ki?u text box
			case "text":
				$value = getValue($field,"str","GET",translate_text("Enter keyword"));
            $str .= '<input type="text"  class="textbox" name="' . $field . '" id="' . $field . '" style="width:130px;"  onfocus="if(this.value==\'' . translate_text("Enter keyword") . '\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'' . translate_text("Enter keyword")  . '\'" value="' . $value . '">';
         break;
        
		}
		$this->arrayAddSearch[] = array($str, $field, $name);
	}
	/*
	ham tao form search
	*/
	function urlsearch(){
		$str = '';
		
			
			$str = '<form action="' . $_SERVER['SCRIPT_NAME'] . '" methor="get" name="form_search" onsubmit="check_form_submit(this); return false">';
			$str .= '<input type="hidden" name="search" id="search" value="1" />';
			$str .= '<table cellpadding="0" cellspacing="0" border="0"><tr>';
			if($this->searchKeyword){
				$label = translate_text("Nh?p t? kh�a");
				$value = getValue("keyword", "str", "GET", $label);
				$str .= '<td><input type="text" class="textbox" name="keyword" id="keyword" onfocus="if(this.value==\'' . $label . '\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'' . $label . '\'" value="' . $value . '"></td>';
			}
			foreach($this->arraySearch as $key=>$field){
				
				switch($this->arrayType[$key]){
				
					case "string":
					case "text":
						$value = getValue($field,"str","GET",$this->arrayLabel[$key]);
						$str .= '<td><input type="text" class="textbox" name="' . $field . '" id="' . $field . '" onfocus="if(this.value==\'' . $this->arrayLabel[$key] . '\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'' . $this->arrayLabel[$key] . '\'" value="' . $value . '"></td>';
					break;
					case "numbernotedit":
						$value = getValue($field,"str","GET",$this->arrayLabel[$key]);
						$str .= '<td><input type="text" class="textbox" name="' . $field . '" id="' . $field . '" onfocus="if(this.value==\'' . $this->arrayLabel[$key] . '\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'' . $this->arrayLabel[$key] . '\'" value="' . $value . '"></td>';
					break;
					case "date":
						$value = getValue($field,"str","GET","dd/mm/yyyy");
						$str .= '<td>&nbsp;<input type="text"  class="textbox" name="' . $field . '" id="' . $field . '" style="width:70px;"  onKeyPress="displayDatePicker(\'' . $field . '\', this);" onClick="displayDatePicker(\'' . $field . '\', this);" onfocus="if(this.value==\'' . translate_text("Enter") . ' ' . $this->arrayLabel[$key] . '\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'' . translate_text("Enter") . ' ' . $this->arrayLabel[$key] . '\'" value="' . $value . '"></td>';
					break;
					
					
					case "array":
						$field = $this->arrayField[$key];
						global $$field;
						$arrayList = $$field;
						$str 			.= '<td>&nbsp;<select  class="textbox" name="' . $field . '" id="' . $field . '">';
						$str 			.= '<option value="-1">' . $this->arrayLabel[$key] . '</option>';
						$selected 		= getValue($field,"str","GET",-1);
						foreach($arrayList as $key=>$value){
							$str 		.= '<option value="' . $key . '" ' . (($selected==$key) ? 'selected' : '') . '>' . $value . '</option>';
						}
						$str .= '</select></td>';
					break;
					
				}
				
			}
			foreach($this->arrayAddSearch as $key=>$value){
			
				if($value[2]!=""){
					$str .= "<td>&nbsp;";
					$str .= $value[2];
					$str .= "&nbsp;:&nbsp;</td>";
				}
				
				$str .= "<td>";
				$str .= $value[0];
				$str .= "</td>";
			}
			
			$str .= '<td>&nbsp;<input type="submit" class="bottom" value="' . translate_text("T�m ki?m") . '"></td>';
			$str .= '</tr></table>';
			$str .= '</form>';
			
			//ph?n check javascript cho form t�m ki?m
			$str .= '<script type="text/javascript">';
			$str .= 'function check_form_submit(obj){';
			foreach($this->arraySearch as $key=>$field){
				switch($this->arrayType[$key]){
					case "string":
						$str .= 'if(document.getElementById("' . $field . '").value == \'' . translate_text("Enter") . ' ' . $this->arrayLabel[$key] . '\'){document.getElementById("' . $field . '").value = \'\'}';
					break;
				}
			}
			$str .= 'document.form_search.submit(); ';
			$str .= '};';
			$str .= '</script>';

		return $str;
	}
	
	/*
	ham tao ra cau lenh sql search
	*/
	function sqlSearch(){
	
		$search		= getValue("search","int","GET",0);
		$str 			= '';
		if($search == 1){
			
			foreach($this->arraySearch as $key=>$field){
			
				$keyword		= getValue($field,"str","GET","");
				if($keyword == $this->arrayLabel[$key]) $keyword = "";
				$keyword		= str_replace(" ","%",$keyword);
				$keyword		= str_replace("\'","'",$keyword);
				$keyword		= str_replace("'","''",$keyword);
				switch($this->arrayType[$key]){
					case "string":
					case "text":
						if(trim($keyword)!='') $str 		.= " AND " . $field . " LIKE '%" . $keyword . "%'";
					break;
					case "numbernotedit":
						if(intval($keyword)> 0) $str 		.= " AND " . $field . " = " . $keyword;
					break;
					case "array":
						if(intval($keyword)> -1) $str 		.= " AND " . $field . "=" . intval($keyword) . "";
					break;
				}
			}
		}
		return $str;
	}
	
	function searchKeyword($list_field = ""){
		$array = explode(",", $list_field);
		$str 	 = '';
		$keyword				= getValue("keyword", "str", "GET", translate_text("Nh?p t? kh�a"));
		$keyword_sql		= str_replace(" ", "%", $keyword);
		$keyword_sql		= str_replace("\'", "'", $keyword_sql);
		$keyword_sql		= str_replace("'", "''", $keyword_sql);	
			
		if(count($array) > 0){
			$this->searchKeyword = true;
			if($keyword != '' && $keyword != translate_text("Nh?p t? kh�a")){
				foreach($array as $key=>$field){
					$str 		.= " AND " . $field . " LIKE '%" . $keyword_sql . "%'";
				}
			}
		}
		
		return $str;
	}
	
	//ham xu ly phan footer
	
	function footer($total_list = 0,$add_html = NULL){
	
		$str = '<table cellpadding="5" cellspacing="0" width="100%" class="page"><tr>';
		
		if($this->delete){
		
			$str .= '<td width="150">';
			$str .= '<a href="#" onclick="if (confirm(\''  . str_replace("'","\'",translate_text("Do you want to delete the product you\'ve selected ?"))  . '\')){ deleteall(' . $total_list . '); }">' . translate_text("Delete all selected") . '</a>';
			$str .= ' <img src="' . $this->image_path . 'delete.gif" border="0" align="absmiddle" />';
			$str .= '</td>';
			$str .= '<td width="150">';
			$str .= '' . translate_text("Total record") . ' : ';
			$str .= '<span id="total_footer">' . $this->total_record . '</span>';
			$str .= '</td>';
		}
		$str .= '<td>';		
		$str .= $this->generate_page();
		$str .= '</td>';
      if($add_html){
         $str .= '<td>';		
   		$str .= $add_html;
   		$str .= '</td>';
      }      
      
		$str .= '</tr></table>';
		return $str;
		
	}
	
	//ham phan trang
	
	function generate_page(){
		$str = '';
		if($this->total_record>$this->page_size){
		
			$total_page 	= $this->total_record/$this->page_size;
			$page			   = getValue("page","int","GET",1);
			if($page<1) $page = 1;
			$str 				.= '<a href="' . getURL(0,1,1,1,"page") . '&page=1"><img src="' . $this->image_path . 'first.gif" border="0" align="absmiddle" /></a>';
			if($page>1) $str 	.= '<a href="' . getURL(0,1,1,1,"page") . '&page=' . ($page-1) .'" onclick="loadpage(this); return false;"><img src="' . $this->image_path . 'prev.gif" border="0" align="absmiddle" /></a>';
			
			$start = $page-5;
			if($start<1) $start = 1;
			
			$end = $page+5;
			if($page<5) $end = $end+(5-$page);
			
			if($end > $total_page) $end=intval($total_page);
			if($end < $total_page) $end++;
			
			for($i=$start;$i<=$end;$i++){
				$str 			.= '<a href="' . getURL(0,1,1,1,"page") . '&page=' . $i . '">' . (($i==$page) ? '<span class="s">[' . $i . ']</span>' : '<span>' . $i . '</span>') . '</a>';
			}
			
			if($page<$total_page) $str 	.= '<a href="' . getURL(0,1,1,1,"page") . '&page=' . ($page+1) .'"><img src="' . $this->image_path . 'next.gif" border="0" align="absmiddle" /></a>';
			$str 				.= '<a href="' . getURL(0,1,1,1,"page") . '&page=' . $total_page . '"><img src="' . $this->image_path . 'last.gif" border="0" align="absmiddle" /></a>';
		
		}
		
		return $str;
	}
	
	//ham tao linmit
	
	function limit($total_record){
		$this->total_record = $total_record;
		$page			   = getValue("page","int","GET",1);
		if($page<1) $page = 1;
		$str = "LIMIT " . ($page-1) * $this->page_size . "," . $this->page_size;
		return $str;
	}
	
	
	//ham sua nhanh bang ajax
	
	function ajaxedit($fs_table){
	
		$this->edit_ajax = true;
		
		//n?u truong h?p checkbox th� ch? thay d?i gi� tr? 0 v� 1 th�i
		
		$checkbox 	= getValue("checkbox","int","GET",0);
		if($checkbox==1){
			$record_id 	= getValue("record_id","int","GET",0);
			$field 		= getValue("field","str","GET","dfsfdsfdddddddddddddddd");
			if(trim($field) != '' && in_array($field,$this->arrayField)){
				$db_query = new db_query("SELECT " . $field . " FROM " . $fs_table . " WHERE " . $this->field_id . "=" . $record_id);
				if($row = mysql_fetch_assoc($db_query->result)){
					$value = ($row[$field]==1) ? 0 : 1;
					$db_update	= new db_execute("UPDATE " . $fs_table . " SET " . $field . " = " . $value . " WHERE " . $this->field_id . "=" . $record_id);
					unset($db_update);
					echo '<img src="' . $this->image_path . 'check_' . $value . '.gif" border="0">';
				}
				unset($db_query);
			}
			exit();
		}
		//ph?n s?a d?i gi� tr?  t?ng tru?ng
		$ajaxedit 	= getValue("ajaxedit","int","GET",0);
		$id 	 		= getValue("id","str","POST","");
		$value 	 	= getValue("value","str","POST","");
		$array 	 	= trim(getValue("array","str","POST",""));
		
		if($ajaxedit == 1){
		
			$arr 		= explode(",",$id);
			$id  		= isset($arr[1]) ? intval($arr[1]) : 0;
			$field  	= isset($arr[0]) ? strval($arr[0]) : '';
			$type  	= isset($arr[2]) ? intval($arr[2]) : 0;
			if($type == 3) $_POST["value"] = str_replace(array("."),"",$value);
			
			//print_r($_POST);
			if($id != 0 && in_array($field,$this->arrayField)){
				
				$myform = new generate_form();
				$myform->removeHTML(0);
				$myform->add($field,"value",$type,0,"",0,"",0,"");
				
				$myform->addTable($fs_table);
				$errorMsg = $myform->checkdata();
				
				if($errorMsg == ""){
					$db_ex = new db_execute($myform->generate_update_SQL($this->field_id,$id));
				}
				
				
			}
			
			if($array!=''){
				if(in_array($array,$this->arrayField)){
					global $$array;
					$arr = $$array;
					$value = isset($arr[$value]) ? $arr[$value] : 'error';
				}
			}
			echo $value;
			exit();
		}
	}
	
}
?>