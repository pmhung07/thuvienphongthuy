<?php
   $type	   = getValue("type","str","GET","");
   $unit       = getValue("iunit","int","GET","");
   $notice = "";
   switch($type){
	   case "practice":
	   		if (checkLearn($unit,'writing') == 1) {
				$sqlWri     = new db_query("SELECT * FROM learn_writing WHERE learn_unit_id = ".$unit);
				$rowWri     = mysqli_fetch_assoc($sqlWri->result);
				unset($sqlWri);
				$sql        = new db_query("SELECT * FROM learn_writing_result WHERE lwr_wri_id = ".$rowWri['learn_wr_id']." AND lwr_point <> 0  ORDER BY lwr_point DESC LIMIT 10 ");
				break;
			}
			if (checkLearn($unit,'speaking') == 1) {
				$sqlSpe     = new db_query("SELECT * FROM learn_speaking WHERE learn_unit_id = ".$unit);
				$rowSpe     = mysqli_fetch_assoc($sqlSpe->result);
				unset($sqlWri);
				$sql        = new db_query("SELECT * FROM learn_speak_result WHERE lsr_spe_id = ".$rowSpe['learn_sp_id']." AND lsr_point <> 0  ORDER BY lsr_point DESC LIMIT 10 ");
				break;
			}
	   case "write"   :
	   		$sqlWri     = new db_query("SELECT * FROM learn_writing WHERE learn_unit_id = ".$unit);
   			$rowWri     = mysqli_fetch_assoc($sqlWri->result);
			unset($sqlWri);
	   		$sql        = new db_query("SELECT * FROM learn_writing_result WHERE lwr_wri_id = ".$rowWri['learn_wr_id']." AND lwr_point <> 0  ORDER BY lwr_point DESC LIMIT 10 ");
			break;
	   case "speak"  :
	   		$sqlSpe     = new db_query("SELECT * FROM learn_speaking WHERE learn_unit_id = ".$unit);
   			$rowSpe     = mysqli_fetch_assoc($sqlSpe->result);
			unset($sqlWri);
	   		$sql        = new db_query("SELECT * FROM learn_speak_result WHERE lsr_spe_id = ".$rowSpe['learn_sp_id']." AND lsr_point <> 0  ORDER BY lsr_point DESC LIMIT 10 ");
			break;

   }
?>
<div id="display_point_top">
	<div id="show_point_top">
        <div id="title_top">
            <span class="top10">Top 10</span>
            <span class="point">Điểm</span>
        </div>
        <div id="content_point_top">
        	<ul>
        	<?php
				if ($sql != NULL){
				while($row   = mysqli_fetch_assoc($sql->result)){
					switch($type){
						case "practice":
							if (checkLearn($unit,'writing') == 1) {
								$id_use = $row['lwr_use_id'] ;
								$point  = $row['lwr_point'];
								break;
							}
							if (checkLearn($unit,'speaking') == 1) {
								$id_use = $row['lsr_use_id'] ;
								$point  = $row['lsr_point'];
								$notice = "- Các bạn cố gắng nói to để giáo viên chấm dễ dàng hơn . <br />";
								break;
							}
						case "write" :
							$id_use = $row['lwr_use_id'] ;
							$point  = $row['lwr_point'];
							break;
						case "speak" :
							$id_use = $row['lsr_use_id'] ;
							$point  = $row['lsr_point'];
							$notice = "- Các bạn cố gắng nói to để giáo viên chấm dễ dàng hơn . <br />";
							break;
					}
					$sqlUser = mysql_query("SELECT use_name,use_avatar,use_exp,use_levtemp_id,use_date FROM users WHERE use_id = ".$id_use);
					$rowUser = mysqli_fetch_assoc($sqlUser);
			?>
            	<li>
                	<div class="left_ct"><?=$rowUser['use_name']?></div>
                    <div class="right_ct"><?=$point?></div>
                </li>
            <?php
				} }
			?>
            </ul>
        </div>
    </div>

    <div id="show_rules">
        <div id="title_rules">
            Nội quy
        </div>
        <div id="content_rules">
        	<?=$notice?>
            - Mỗi học viên chỉ có thể gửi được 1 bài. Bài viết sẽ được chấm sau 48 tiếng. <br />
            - Giáo viên sẽ chấm điểm từng bài theo thang điểm 10.<br />
			- Thứ tự xếp hạng được xác định bằng số điểm đạt được và thời gian gửi bài.
        </div>
    </div>
</div>