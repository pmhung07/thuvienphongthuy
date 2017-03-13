<?php
   $type	   = getValue("type","str","GET","");
   $unit       = getValue("iunit","int","GET","");
   $per_page   = 5;
   switch($type){
	   case "practice":
	   		if (checkLearn($unit,'writing') == 1) {
				$sqlWri     = new db_query("SELECT * FROM learn_writing WHERE learn_unit_id = ".$unit);
				$row        = mysqli_fetch_assoc($sqlWri->result);
				$ilesson    = $rowWri['learn_wr_id'];
				unset($sqlWri);
				$sql = "select * from learn_writing_result WHERE lwr_wri_id = ".$ilesson;
				break;
			}
			if (checkLearn($unit,'speaking') == 1) {
				$sqlSpe     = new db_query("SELECT * FROM learn_speaking WHERE learn_unit_id = ".$unit);
				$row        = mysqli_fetch_assoc($sqlSpe->result);
				$ilesson    = $row['learn_sp_id'];
				unset($sqlSpe);
				$sql = "select * from learn_speak_result WHERE lsr_spe_id = ".$ilesson;
				break;
			}
	   case "write"   :
	   		$sqlWri     = new db_query("SELECT * FROM learn_writing WHERE learn_unit_id = ".$unit);
   			$row        = mysqli_fetch_assoc($sqlWri->result);
			$ilesson    = $rowWri['learn_wr_id'];
			unset($sqlWri);
			$sql = "select * from learn_writing_result WHERE lwr_wri_id = ".$ilesson;
			break;
		case "speak" :
			$sqlSpe     = new db_query("SELECT * FROM learn_speaking WHERE learn_unit_id = ".$unit);
			$row        = mysqli_fetch_assoc($sqlSpe->result);
			$ilesson    = $row['learn_sp_id'];
			unset($sqlSpe);
			$sql = "select * from learn_speak_result WHERE lsr_spe_id = ".$ilesson;
			break;
   }
    $rsd = mysql_query($sql);
	if ($rsd != NULL){
		$count = mysqli_num_rows($rsd);
		$pages = ceil($count/$per_page);
	}
?>
<!----- Phần hiển thị điểm và comment của giáo viên ----->

<script type="text/javascript">
$(document).ready(function(){

	function showLoader(){

		$('.search-background').fadeIn(200);
	}

	function hideLoader(){

		$('.search-background').fadeOut(200);
	};

	$("#paging_button li").click(function(){

		showLoader();

		$("#paging_button li").css({'background-color' : '', 'color' : '#000'});
		$(this).css({'background-color' : '#006699' , 'color' : '#FFF'});

		$("#ct_center").load("http://<?=$base_url?>/ajax/data_user_lear.php?type=<?=$type?>&unit=<?=$unit?>&ilesson=<?=$ilesson?>&page=" + this.id, hideLoader);

		return false;
	});

	$("#1").css({'background-color' : '#006699' , 'color' : '#FFF'});
	showLoader();
	$("#ct_center").load("http://<?=$base_url?>/ajax/data_user_lear.php?type=<?=$type?>&unit=<?=$unit?>&ilesson=<?=$ilesson?>&page=1", hideLoader);

});
</script>

<div id="display_point">
<div class="search-background">
    <label><img src="http://<?=$base_url?>/themes/images/loading_bk.gif" alt="" /></label>
</div>
<div id="ct_center">

</div>
<?php if ($rsd != NULL){ ?>
<div id="paging_button" align="center">
    <ul>
    <?php
    //Show page links
    for($i=1; $i<=$pages; $i++)
    {
        echo '<li id="'.$i.'">'.$i.'</li>';
    }?>
    </ul>
</div>
<?php } ?>
</div>
