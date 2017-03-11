<?php 
/* *
// Comments Class
// Author: Trịnh Tuấn Tài
* */

// Class Comments
//Bảng csdl của comments gồm cái trường: com_id, com_user_id, com_post_id, com_content, com_date
//Bảng csdl của comments_reply gồm: rep_id, rep_user_id, rep_comment_id, rep_content, rep_date
class comments {
    var $id; // id của post hoặc comment
    var $type; //kiểu comment(1) hay trả lời comment
    var $page;
    var $table;
    var $type_comment; // kieu comment cho loai bai viet
    
    function comments($id = 1, $page = 1 ,$type = 1, $table = 'comments',$type_comment = 1) {
        $this->id = $id;
        $this->page = $page;
        $this->table = $table;
        $this->type = $type;
        $this->type_comment = $type_comment;
    }
    public function getComments() {
        $page = ($this->page >= 2) ? $this->page : 1;
        $rows_per_page = 10;
        $page_start = ($page - 1) * $rows_per_page;
        $page_end = $page * $rows_per_page;
        //type = 1 kiểu lấy comment
        if($this->type == 1) {
            $db_com = new db_query('SELECT com_id, com_user_id, com_post_id, com_content, com_date, com_type, use_id, use_name, use_avatar, use_vg_id, use_vg_avatar
                                     FROM '.$this->table.' 
                                     LEFT JOIN users ON use_id = com_user_id
                                     WHERE com_post_id = '.$this->id.' AND com_type = '.$this->type_comment.'
                                     ORDER BY  com_date DESC
                                     LIMIT '.$page_start . ', '. $rows_per_page);
            $res_com = $db_com->resultArray();
        }else {
            $db_com = new db_query('SELECT rep_id, rep_user_id, rep_comment_id, rep_content, rep_date, use_id, use_name, use_avatar, use_vg_id, use_vg_avatar
                                     FROM '.$this->table.' 
                                     LEFT JOIN users ON use_id = rep_user_id
                                     WHERE rep_comment_id = '.$this->id.'
                                     ORDER BY  rep_date ASC');
            $res_com = $db_com->resultArray();
        }
        return $res_com;
    }
    public function getCatComment(){
        if($this->type == 1) {
            $db_com = new db_query('SELECT com_id, com_user_id, com_post_id, com_content, com_date, com_type, use_id, use_name, use_avatar
                                     FROM '.$this->table.' 
                                     JOIN users ON use_id = com_user_id
                                     WHERE com_post_id = '.$this->id.' AND com_type = '.$this->type_comment.'
                                     GROUP BY com_id
                                     ORDER BY  com_date DESC');
            $res_com = $db_com->resultArray();
        }
        return $res_com;
    }
    public function setComments($use_id,$content,$date,$type_comment = 1) {
        //type = 1 kiểu insert comment
        if($this->type == 1) {
            $db_com = new db_execute('INSERT INTO 
                                    '.$this->table.'(com_user_id, 
                                                com_post_id, 
                                                com_content, 
                                                com_date,
                                                com_type)
                                     VALUES('.$use_id.',
                                            '.$this->id.',
                                            "'.$content.'",
                                            '.$date.',
                                            '.$type_comment.')');
        }else {
            $db_com = new db_execute('INSERT INTO 
                                    '.$this->table.'(rep_user_id, 
                                                rep_comment_id, 
                                                rep_content, 
                                                rep_date)
                                     VALUES('.$use_id.',
                                            '.$this->id.',
                                            "'.$content.'",
                                            '.$date.')');
        }
        return $db_com->total;
    }
    public function countComment() {
        if($this->type == 1) {
            $db_count = new db_count('SELECT count(*) as count FROM '.$this->table.' WHERE com_post_id ='.$this->id.' AND com_type = '.$this->type_comment);
        }
        else {
            $db_count = new db_count('SELECT count(*) as count FROM '.$this->table.' WHERE rep_comment_id ='.$this->id);
        }
        return $db_count->total;
    }
}

?>