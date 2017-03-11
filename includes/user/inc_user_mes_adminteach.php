<?php
    $mes_true = 0;
    $db2 = new db_query("SELECT * FROM mesclass WHERE mesclass_type = 3 AND mes_uid =".$myuser->u_id);

    $arrclassMes = $db2->resultArray();

    if(count($arrclassMes) > 0){
         $db2 = new db_query("SELECT * FROM users WHERE use_id =".$arrclassMes[0]['mesclass_teacher']);
        $artech = $db2->resultArray();
        $mes_true = 1;
    }else{
        $mes_true = 0;
    }

    $update     =   "UPDATE mesclass SET mesclass_read = 1 WHERE mes_uid = ".$myuser->u_id." AND mesclass_type = 3";
        $db_update  =   new db_execute($update);
        unset($db_update);  


?>
<div class="user-manager-info">
    <div class="block-content-show-content">
        <div class="block-content-info">
            <div class="notice-update-info">TIN NHẮN GIÁO VIÊN</div>
            <?
            if($mes_true == 1){ 
                foreach($arrclassMes as $key=>$value){
                    ?>
                    <div class="listmes">
                        <?
                        $dbu = new db_query("SELECT * FROM users WHERE use_id =".$value['mesclass_teacher']);
                        $arru = $dbu->resultArray();
                        ?>
                        <div class="listmesteacher">TIN NHẮN TỪ GIÁO VIÊN : <?=$artech[0]['use_email']?> <span></span></div>
                        <div class="listmesdate">Tin nhắn vào lúc : <span><?=date('d/m/Y h:i:s',$value['mesclass_date'])?></span></div>
                        <div class="listmescontent">
                            <?=$value['mesclass_content']?>
                        </div>
                    </div>
                    <?
                }
            }else{
                echo '<span style="padding: 20px 10px;display: block;background-color: white;margin-top: 10px;">Không có tin nhắn nào!</span>';
            }
            ?>
        </div>
    </div>
</div>

<style type="text/css">
.listmes{
    padding: 15px 15px;
    background-color: white;
    border: solid 1px #cecece;
    margin: 6px 0px;
}
.listmesteacher{
    color: rgb(3, 113, 133);
}
.listmesdate{
    color: rgb(187, 3, 3);
    margin-top: 5px;
}
.listmescontent{
    margin-top: 10px;
    background-color: #E8E8E8;
    padding: 9px;
    text-align: justify;
}
</style>