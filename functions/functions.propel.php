<?
/*
 * Lê Khánh Dương - Các hàm query sử dụng propel
 */

//Tạo breadcrumb

function getBreadcrumbData($context,$context_id){
	//global $base_url;
	
	$breadcrumb_data = array();
	
//Trang chủ
	array_push($breadcrumb_data,array(	'Text'	=> 'Trang chủ',
										'Url'	=> '/'));
	switch($context){
		case 'course_edit':
			//User Page
			array_push($breadcrumb_data,array(	'Text'	=> 'User',
												'Url'	=> '/user/course'));
			//current course
			array_push($breadcrumb_data,array(	'Text'	=> '',
												'Url'	=> '/user/course'));
			break;
		case 'course':
			//category
			//current course
			array_push($breadcrumb_data,array(	'Text'	=> 'Khóa học',
												'Url'	=> '/user/course'));
			break;
	}
	return $breadcrumb_data;
}

//Lấy thông tin khóa học & user tạo ra nó
function getCourseInfo($course_id){
	//global $myuser;
	
	$current_course = CourseQuery::create()->findPk($course_id);
	if(NULL===$current_course){
		return null;
	}
	
	$current_course->getHoc123User();
	$current_course_data = json_decode($current_course->toJSON(),true);
	
	//$current_course_data['Hoc123User']['DisplayName'] = $myuser->use_name;
	//$current_course_data['Hoc123User']['Avatar'] = ($myuser->use_avatar != '')?("http://".$base_url."/pictures/use_avatar/".$myuser->use_avatar):($var_path_img."community/noavatar_1.jpg");
	
	return $current_course_data;
}

//Lấy thông tin 1 trang bài học
function getLessonpageInfo($lessonpage_id){
	$current_lessonpage = LessonPageQuery::create()->findPk($lessonpage_id);
	if(NULL===$current_lessonpage){
		return null;
	}
	
	$current_lessonpage->getLesson();
	$current_lessonpage_data = json_decode($current_lessonpage->toJSON(),true);
	$current_lessonpage_data['Contentblocks'] = array();
	
	$contentblock_sorting = new Criteria();
	$contentblock_sorting->addAscendingOrderByColumn(ContentblockPeer::SORT_ORDER);

	foreach($current_lessonpage->getContentblocks($contentblock_sorting) as $contentblock){
		switch($contentblock->getType()){
			case 'text':
				$text_contentblock = TextContentblockQuery::create()->findOneBy('ContentblockId', $contentblock->getId());
				$text_contentblock->getContentblock();
				array_push($current_lessonpage_data['Contentblocks'],json_decode($text_contentblock->toJSON(),true));
				break;
			case 'audio':
				$audio_contentblock = AudioContentblockQuery::create()->findOneBy('ContentblockId', $contentblock->getId());
				$audio_contentblock->getContentblock();
				$audio_contentblock->getFile();
				array_push($current_lessonpage_data['Contentblocks'],json_decode($audio_contentblock->toJSON(),true));
				break;
			case 'video':
				$video_contentblock = VideoContentblockQuery::create()->findOneBy('ContentblockId', $contentblock->getId());
				$video_contentblock->getContentblock();
				$video_contentblock->getFile();
				array_push($current_lessonpage_data['Contentblocks'],json_decode($video_contentblock->toJSON(),true));
				break;
			case 'attachment':
				$attachment_contentblock = AttachmentContentblockQuery::create()->findOneBy('ContentblockId', $contentblock->getId());
				$attachment_contentblock->getContentblock();
				$attachment_contentblock->getFile();
				array_push($current_lessonpage_data['Contentblocks'],json_decode($attachment_contentblock->toJSON(),true));
				break;
			case 'vocabulary':
				$vocabulary_contentblock = VocabularyContentblockQuery::create()->findOneBy('ContentblockId', $contentblock->getId());
				$vocabulary_contentblock->getContentblock();
				
				$entry_sorting = new Criteria();
				$entry_sorting->addAscendingOrderByColumn(VocabularyContentblockEntryPeer::SORT_ORDER);
				$vocabulary_entries = $vocabulary_contentblock->getVocabularyContentblockEntrys($entry_sorting);
				foreach($vocabulary_entries as $entry){
					$entry->getFileRelatedByAudio();
					$entry->getFileRelatedByThumbnail();
				}
				array_push($current_lessonpage_data['Contentblocks'],json_decode($vocabulary_contentblock->toJSON(),true));
				break;
			case 'quiz':
				$quiz_contentblock = QuizContentblockQuery::create()->findOneBy('ContentblockId', $contentblock->getId());
				$quiz_contentblock->getContentblock();
				//$quiz_contentblock->getQuiz();
				$quiz_contentblock_data = json_decode($quiz_contentblock->toJSON(),true);
				$quiz_contentblock_data['Quiz'] = getQuizData($quiz_contentblock->getQuizId()); 
				array_push($current_lessonpage_data['Contentblocks'],$quiz_contentblock_data);
				break;
		}
	}

	return $current_lessonpage_data;
}

function getNextModule($module_id){
	
	return $next_module;
}

function getNextLessonPage($lessonpage_id){
	$c = new Criteria();
	$c->addAscendingOrderByColumn(LessonPagePeer::ID);
	
	$c->add(LessonPagePeer::ID, $lessonpage_id, Criteria::GREATER_THAN);
	$this->next = ItemPeer::doSelectOne($c);
	$c->toString();
}

function getQuizData($quiz_id){
	$current_quiz = QuizQuery::create()->findPk($quiz_id);
	
	$current_quiz_data = json_decode($current_quiz->toJSON(),true);
	$current_quiz_data['QuizPages'] = array();

	$quiz_page_sorting = new Criteria();
	$quiz_page_sorting->addAscendingOrderByColumn(QuizPagePeer::SORT_ORDER);
	
	$question_index = 0;
	
	foreach($current_quiz->getQuizPages($quiz_page_sorting) as $page){
		$page_data = json_decode($page->toJSON(),true);
		$page_data['Questions'] = array();
		
		$question_sorting = new Criteria();
		$question_sorting->addAscendingOrderByColumn(QuestionPeer::SORT_ORDER);
		$question_sorting->add(QuestionPeer::PARENT_ID,'0');
		foreach($page->getQuestions($question_sorting) as $question){
			switch($question->getType()){
				case 'multichoice':
					$multichoice_question = MultichoiceQuestionQuery::create()->findOneBy('QuestionId',$question->getId());
					foreach($multichoice_question->getQuestion()->getQuestionMedias() as $medium){
						$medium->getFile();
					}
					$multichoice_question->getQuestion()->getQuestionAnswers();
					$multichoice_question_data = json_decode($multichoice_question->toJSON(),true);
					$multichoice_question_data['Question']['Index'] = ++$question_index;
					
					array_push($page_data['Questions'],$multichoice_question_data);
					break;
				case 'shortanswer':
					$shortanswer_question = ShortAnswerQuestionQuery::create()->findOneBy('QuestionId',$question->getId());
					foreach($shortanswer_question->getQuestion()->getQuestionMedias() as $medium){
						$medium->getFile();
					}
					$shortanswer_question->getQuestion()->getQuestionAnswers();
					$shortanswer_question_data = json_decode($shortanswer_question->toJSON(),true);
					$shortanswer_question_data['Question']['Index'] = ++$question_index;
					
					array_push($page_data['Questions'],$shortanswer_question_data);
					break;
				case 'matching':
					$matching_question = MatchingQuestionQuery::create()->findOneBy('QuestionId',$question->getId());
					foreach($matching_question->getQuestion()->getQuestionMedias() as $medium){
						$medium->getFile();
					}
					foreach($matching_question->getMatchingQuestionPremises() as $premise){
						$premise->getFile();
					}
					$matching_question->getQuestion()->getQuestionAnswers();
					$matching_question_data = json_decode($matching_question->toJSON(),true);
					$matching_question_data['Question']['Index'] = ++$question_index;
					
					array_push($page_data['Questions'],$matching_question_data);
					break;
				case 'essay':
					$essay_question = EssayQuestionQuery::create()->findOneBy('QuestionId',$question->getId());
					foreach($essay_question->getQuestion()->getQuestionMedias() as $medium){
						$medium->getFile();
					}
					$essay_question_data = json_decode($essay_question->toJSON(),true);
					$essay_question_data['Question']['Index'] = ++$question_index;
					array_push($page_data['Questions'],$essay_question_data);
					
					break;
				case 'combined':
					$combined_question = CombinedQuestionQuery::create()->findOneBy('QuestionId',$question->getId());
					foreach($combined_question->getQuestion()->getQuestionMedias() as $medium){
						$medium->getFile();
					}
					
					$combined_question_data = json_decode($combined_question->toJSON(),true);
					$combined_question_data['Questions'] = array();
					foreach(QuestionQuery::create()->findBy('ParentId', $combined_question->getQuestionId()) as $child_question){
						switch($child_question->getType()){
							case 'multichoice':
								$multichoice_question = MultichoiceQuestionQuery::create()->findOneBy('QuestionId',$child_question->getId());
								foreach($multichoice_question->getQuestion()->getQuestionMedias() as $medium){
									$medium->getFile();
								}
								$multichoice_question->getQuestion()->getQuestionAnswers();
								$multichoice_question_data = json_decode($multichoice_question->toJSON(),true);
								$multichoice_question_data['Question']['Index'] = ++$question_index;
								
								array_push($combined_question_data['Questions'],$multichoice_question_data);
								break;
							case 'shortanswer':
								$shortanswer_question = ShortAnswerQuestionQuery::create()->findOneBy('QuestionId',$child_question->getId());
								foreach($shortanswer_question->getQuestion()->getQuestionMedias() as $medium){
									$medium->getFile();
								}
								$shortanswer_question_data = json_decode($shortanswer_question->toJSON(),true);
								$shortanswer_question_data['Question']['Index'] = ++$question_index;
								
								array_push($combined_question_data['Questions'],$shortanswer_question_data);
								break;
							case 'essay':
								$essay_question = EssayQuestionQuery::create()->findOneBy('QuestionId',$child_question->getId());
								foreach($essay_question->getQuestion()->getQuestionMedias() as $medium){
									$medium->getFile();
								}
								$essay_question_data = json_decode($essay_question->toJSON(),true);
								$essay_question_data['Question']['Index'] = ++$question_index;
								
								array_push($combined_question_data['Questions'],$essay_question_data);
								break;
						}
					}
					
					array_push($page_data['Questions'],$combined_question_data);
					break;
			}
		}
		array_push($current_quiz_data['QuizPages'],$page_data);
	}
return $current_quiz_data;
}

//Lấy danh sách các bài học của 1 khóa học
function getCourseData($course_id){
	global $base_url;
	
	$current_course = CourseQuery::create()->findPk($course_id);
	$current_course->getFileRelatedByImage();
	$current_course->getFileRelatedByPromotionVideo();
	$current_course_data = json_decode($current_course->toJSON(),true);
	$current_course_data['CourseSections'] = array();

	$course_section_sorting = new Criteria();
	$course_section_sorting->addAscendingOrderByColumn(CourseSectionPeer::SORT_ORDER);

	foreach($current_course->getCourseSections($course_section_sorting) as $section){
		$section_data = json_decode($section->toJSON(),true);
		$section_data['CourseModules'] = array();
		
		$course_module_sorting = new Criteria();
		$course_module_sorting->addAscendingOrderByColumn(CourseModulePeer::SORT_ORDER);
		foreach($section->getCourseModules($course_module_sorting) as $module){
			$module_data = json_decode($module->toJSON(),true);
			
			switch($module->getType()){
				case 'lesson':
					$current_lesson = LessonQuery::create()->findPk($module->getObjectId());
					$current_lesson_data = json_decode($current_lesson->toJSON(),true);
					$current_lesson_data['LessonPages'] = array();
					
					$lesson_page_sorting = new Criteria();
					$lesson_page_sorting->addAscendingOrderByColumn(LessonPagePeer::SORT_ORDER);
					foreach($current_lesson->getLessonPages($lesson_page_sorting) as $page){
						$page_data = json_decode($page->toJSON(),true);
						$page_data['Url'] = gen_module_link($module_data['Type'].'_page_detail',array('module_id'=>$module_data['Id'],
																																'page_id'=>$page_data['Id']));
						array_push($current_lesson_data['LessonPages'],$page_data);
					}
					$module_data['Lesson'] = $current_lesson_data;
					$module_data['Url'] = gen_module_link($module_data['Type'].'_page_detail',array('module_id'=>$module_data['Id'],
																								'page_id'=>$module_data['Lesson']['LessonPages'][0]['Id']));
					break;
				case 'quiz':
					$current_quiz = QuizQuery::create()->findPk($module->getObjectId());
					$module_data['Quiz'] = json_decode($current_quiz->toJSON(),true);
					$module_data['Url'] = gen_module_link($module_data['Type'].'_detail',array('module_id'=>$module_data['Id'],
																								'quiz_id'=>$module_data['ObjectId']));
					break;
			}
			array_push($section_data['CourseModules'],$module_data);
		}
		
		array_push($current_course_data['CourseSections'],$section_data);
	}
	return $current_course_data;
}

function getCourseDataWithOtherCourses($course_id){
	global $base_url;
	
	$current_course = CourseQuery::create()->findPk($course_id);
	$current_course->getFileRelatedByImage();
	$current_course->getFileRelatedByPromotionVideo();
	
	$c = new Criteria();
	$c->add(CoursePeer::ID,$current_course->getId(),Criteria::NOT_EQUAL);
	
	$current_course->getHoc123User();
	$current_course_data = json_decode($current_course->toJSON(),true);
	//dump($current_course_data);
	$current_course_data['CourseSections'] = array();

	foreach($current_course->getCourseSections() as $section){
		$section_data = json_decode($section->toJSON(),true);
		$section_data['CourseModules'] = array();
		
		foreach($section->getCourseModules() as $module){
			$module_data = json_decode($module->toJSON(),true);
			
			switch($module->getType()){
				case 'lesson':
					$current_lesson = LessonQuery::create()->findPk($module->getObjectId());
					$current_lesson_data = json_decode($current_lesson->toJSON(),true);
					$current_lesson_data['LessonPages'] = array();
					foreach($current_lesson->getLessonPages() as $page){
						$page_data = json_decode($page->toJSON(),true);
						array_push($current_lesson_data['LessonPages'],$page_data);
					}
					$module_data['Lesson'] = $current_lesson_data;
					$module_data['Url'] = gen_module_link($module_data['Type'].'_page_detail',array('module_id'=>$module_data['Id'],
																								'page_id'=>$module_data['Lesson']['LessonPages'][0]['Id']));
					break;
				case 'quiz':
					$current_quiz = QuizQuery::create()->findPk($module->getObjectId());
					$module_data['Quiz'] = json_decode($current_quiz->toJSON(),true);
					$module_data['Url'] = gen_module_link($module_data['Type'].'_detail',array('module_id'=>$module_data['Id'],
																								'quiz_id'=>$module_data['ObjectId']));
					break;
			}
			array_push($section_data['CourseModules'],$module_data);
		}
		
		array_push($current_course_data['CourseSections'],$section_data);
	}

	$current_course_data['Hoc123User']['Courses'] = array();
	foreach($current_course->getHoc123User()->getCourses($c) as $other_course){
		array_push($current_course_data['Hoc123User']['Courses'],json_decode($other_course->toJSON(),true));
	}
	$current_course_data['Hoc123User']['CoursesCount'] = sizeof($current_course->getHoc123User()->getCourses($c));
	
	return $current_course_data; 
}

/*
 * Các hàm xác định vị trí hiện tại (thuộc course nào, quiz nào...)
 */
function findCourseByCourseModule($course_module_id){
	$current_course_module = CourseModuleQuery::create()->findPk($course_module_id);
	return $current_course_module->getCourseSection()->getCourse()->getId();
}

function findCourseByCourseSection($course_section_id){
	$current_course_section = CourseSectionQuery::create()->findPk($course_section_id);
	return $current_course_section->getCourse()->getId();
}
?>