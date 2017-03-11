<?
class quiz{
   
   var $table_hoc123_module_quizzes                      ;                      // table quiz
   var $table_hoc123_module_quiz_pages                   = 'hoc123_module_quiz_pages';                   // table quiz pages
   var $table_hoc123_module_quiz_questions               = 'hoc123_module_quiz_questions';               // table quiz questions
   var $table_hoc123_module_quiz_answers                 = 'hoc123_module_quiz_question_answers';        // table quiz answers
   var $table_hoc123_module_quiz_question_multichoice    = 'hoc123_module_quiz_question_multichoice';    // table hoc123_module_quiz_question_multichoice
   var $table_hoc123_module_quiz_question_shortanswer    = 'hoc123_module_quiz_question_shortanswer';    // table hoc123_module_quiz_question_shortanswer
   var $table_hoc123_module_quiz_question_matching       = 'hoc123_module_quiz_question_matching';       // table hoc123_module_quiz_question_matching
   var $table_hoc123_module_quiz_question_essay          = 'hoc123_module_quiz_question_essay';          // table hoc123_module_quiz_question_essay

   var $id_field_quiz               = 0;         // id quiz
   var $id_field_quiz_page          = array();   // mang quiz page
   
   var $id_field_question           = 0;         // id question
   var $type_question               = '';        // type question  
   var $text_question               = '';        // content question
   var $answers                     = array();   // mang answers
   
   
   /**
	 * Ham lay noi dung quiz
	 * @return array $arrayReturn : Mang page
    * lay ra mang id page trong quiz
	 */ 
   function get_quiz_page(){
      //$db_quiz_page = db_query('SELECT id FROM'.$this->$table_hoc123_module_quizzes.' WHERE quiz_id='.$id_field_quiz);
      echo $id_field_quiz;
   } 
    
    
   /**
	 * db_query::resultArray()
	 * Ham lay noi dung quiz
	 * @return array $arrayReturn : Mang
	 */ 
   function get_content_question($id_field_question){
      $array_quiz = array();
      $db_question = new db_query('SELECT * FROM '.$this->$table_hoc123_module_quiz_questions);
      $array_content_question = $db_question->resultArray();
      $array_quiz = $array_content_question;
      return $array_quiz;
   } 
      

}
?>