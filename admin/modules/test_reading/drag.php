   <b style="padding-top: 10px;padding-bottom: 10px;">----------- Dạng drag 1 -------------</b>
   <?
   $form = new form();
   $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
   ?>
   <tr>
      <td width="120px" class="form_name">Nhập câu hỏi :</td>
      <td><input type="text" name="question" id="question_drag" class="form_control" style="width:250px;" value=""/></td>
   </tr>
   <tr>
      <td width="120px" class="form_name">Nhập câu trả lời :</td>
      <td>
         <ul style="list-style: none;padding: 0px 6px;">
            <li style="margin: 5px 0px;"><b>1. </b>
               <input type="text" name="ans_1" id="ans_drag_1" class="form_control" style="width:200px;" value=""/>
               <input type="checkbox" id="true_drag_1" class="form_control" value="0" onclick="check_chb_true(1)" />
            </li>
            <li style="margin: 5px 0px;"><b>2. </b>
               <input type="text" name="ans_2" id="ans_drag_2" class="form_control" style="width:200px;" value=""/>
               <input type="checkbox" id="true_drag_2" class="form_control" value="0" onclick="check_chb_true(2)" />
            </li>
            <li style="margin: 5px 0px;"><b>3. </b>
               <input type="text" name="ans_3" id="ans_drag_3" class="form_control" style="width:200px;" value=""/>
               <input type="checkbox" id="true_drag_3" class="form_control" value="0" onclick="check_chb_true(3)" />
            </li>
            <li style="margin: 5px 0px;"><b>4. </b>
               <input type="text" name="ans_4" id="ans_drag_4" class="form_control" style="width:200px;" value=""/>
               <input type="checkbox" id="true_drag_4" class="form_control" value="0" onclick="check_chb_true(4)" />
            </li>
            <li style="margin: 5px 0px;"><b>5. </b>
               <input type="text" name="ans_5" id="ans_drag_5" class="form_control" style="width:200px;" value=""/>
               <input type="checkbox" id="true_drag_5" class="form_control" value="0" onclick="check_chb_true(5)" />
            </li>
            <li style="margin: 5px 0px;"><b>6. </b>
               <input type="text" name="ans_6" id="ans_drag_6" class="form_control" style="width:200px;" value=""/>
               <input type="checkbox" id="true_drag_6" class="form_control" value="0" onclick="check_chb_true(6)" />
            </li>
         </ul>                 
      </td>
   </tr>
    <tr>
      <td width="120px" class="form_name"></td>
      <td><input type="button" onclick="add_drag(<?=$record_id?>)" name="btn_add" id="btn_add" class="btn_add" value="Thêm mới"/></td>
   </tr>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>
   
   <b style="padding-top: 10px;padding-bottom: 10px;">------------ Dạng drag 2 -------------</b>
   <?
   $form_1 = new form();
   $form_1->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form_1->create_table();
   ?>
   <tr>
      <td width="120px" class="form_name">Nhập câu hỏi :</td>
      <td><input type="text" name="question" id="question_drag_1" class="form_control" style="width:250px;" value=""/></td>
   </tr>
   <tr>
      <td width="120px" class="form_name">Nhập câu trả lời :</td>
      <td>
         <ul style="list-style: none;padding: 0px 6px;">
            <li style="margin: 5px 0px;"><b>*. </b>
               Gợi ý :<input type="text" name="question" id="question_drag_sub_1" class="form_control" style="width:200px;" value=""/>
            </li>    
            <li style="margin: 5px 0px;"><b>1. </b>
               <input type="text" name="ans_1" id="ans_drag_sub_1" class="form_control" style="width:231px;" value=""/>
            </li>
            <li style="margin: 5px 0px;"><b>2. </b>
               <input type="text" name="ans_2" id="ans_drag_sub_2" class="form_control" style="width:231px;" value=""/>
            </li>
             <li style="margin: 5px 0px;"><b>*. </b>
               Gợi ý :<input type="text" name="question" id="question_drag_sub_2" class="form_control" style="width:200px;" value=""/>
            </li>
            <li style="margin: 5px 0px;"><b>3. </b>
               <input type="text" name="ans_3" id="ans_drag_sub_3" class="form_control" style="width:231px;" value=""/>
            </li>
            <li style="margin: 5px 0px;"><b>4. </b>
               <input type="text" name="ans_4" id="ans_drag_sub_4" class="form_control" style="width:231px;" value=""/>
            </li>
            <li style="margin: 5px 0px;"><b>5. </b>
               <input type="text" name="ans_5" id="ans_drag_sub_5" class="form_control" style="width:231px;" value=""/>
            </li>
            --------------------------Câu sai----------------------------
            <li style="margin: 5px 0px;"><b>6. </b>
               <input type="text" name="ans_6" id="ans_drag_sub_6" class="form_control" style="width:231px;" value=""/>
            </li>            
            <li style="margin: 5px 0px;"><b>7. </b>
               <input type="text" name="ans_7" id="ans_drag_sub_7" class="form_control" style="width:231px;" value=""/>
            </li>
            <li style="margin: 5px 0px;"><b>8. </b>
               <input type="text" name="ans_8" id="ans_drag_sub_8" class="form_control" style="width:231px;" value=""/>
            </li>            
         </ul>                 
      </td>
   </tr>
    <tr>
      <td width="120px" class="form_name"></td>
      <td><input type="button" onclick="add_drag_v1(<?=$record_id?>)" name="btn_add" id="btn_add" class="btn_add" value="Thêm mới"/></td>
   </tr>
   <?
   $form_1->close_table();
   $form_1->close_form();
   unset($form_1);
   ?>
   
