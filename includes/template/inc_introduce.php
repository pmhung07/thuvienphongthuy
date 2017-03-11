<?php
$dbCategorysld         =   new db_query("SELECT * FROM slides WHERE slide_type = 4");
$arrInfoCategorysld    =   $dbCategorysld->resultArray();
?>
<div class="concec" style="width:100%;">
    <a href="<?=$arrInfoCategorysld[0]['slide_url']?>">
	   <img style="width:100%;height:auto;" src="http://hosoxinviec.vn/pictures/slides/<?=$arrInfoCategorysld[0]['slide_img']?>">
    </a>
</div>