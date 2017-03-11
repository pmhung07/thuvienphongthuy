<?php
    $mes_true = 0;
    $db1 = new db_query("SELECT * FROM class_user WHERE class_user_uid=".$myuser->u_id);
    $arrclass = $db1->resultArray();
    if(count($arrclass) > 0 ){
        $mes_true = 1;
        $db2 = new db_query("SELECT * FROM mesclass WHERE mesclass_class=".$arrclass[0]['class_user_class_id']." AND mesclass_type = 0");
        $arrclassMes = $db2->resultArray();
        if(count($arrclassMes > 0)){
            $mes_true = 1;
        }else{
            $mes_true = 0;
        }
    }else{
        $mes_true = 0;
    }

?>
<div class="user-manager-info">
    <div class="block-content-show-content">
        <div class="block-content-info">
            <div class="notice-update-info">TIN NHẮN LỚP</div>
            <?
            if($mes_true == 1){ 
                foreach($arrclassMes as $key=>$value){
                    ?>
                    <div class="listmes">
                        <?
                        $dbu = new db_query("SELECT * FROM users WHERE use_id =".$value['mesclass_teacher']);
                        $arru = $dbu->resultArray();
                        ?>
                        <div class="listmesteacher">Giáo viên  : <span><?=$arru[0]['use_name']?></span></div>
                        <div class="listmesdate">Tin nhắn vào lúc : <span><?=date('d/m/Y h:i:s',$value['mesclass_date'])?></span></div>
                        <div class="listmescontent">
                            <?=$value['mesclass_content']?>
                        </div>
                    </div>
                    <?
                }
            }else{
                echo "<span style='padding: 20px 10px;display: block;background-color: white;margin-top: 10px;'>Không có tin nhắn nào!</span>";
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