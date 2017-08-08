<?php


$questionView = new Question_View($tpl);
$questionModel = new Question();
// all actions MUST set  the variable  $pageTitle
$pageTitle = $option->pageTitle->action->{$registry->requestAction};
$session = Zend_Registry::get('session');
switch ($registry->requestAction)
{
	default:
	case 'list':
		// call getQuestionList method to view the article pages
		$list = $questionModel->getQuestionList();
		$questionView->showAllQuestion("questionList",$list);
		//Zend_Debug::dump($list);
		//exit();
		break;
	break;

	case 'show_question':
		$userId = NULL;
		$id = $registry->request['id'];
		if(isset($session->user->id))
		{
			$userId = $session->user->id;
		}
		$questionData = $questionModel->getQuestionById($id);
		$questionView->showQuestion("question_pages",$questionData,$userId);
	break;

	case 'add' :
		$userId = (isset($session->user->id)) ? $session->user->id : '' ;

		//var_dump($userId);
		//exit();
		$questionView->postQuestion("addQuestion");
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$baseUrl = $registry->configuration->website->params->url;
			$questionModel->addQuestion($_POST,$userId);
			header("Location: " . $baseUrl . "/question/list");
		}
		break;

	case "comment":
		$userId = (isset($session->user->id)) ? $session->user->id : '';
		$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : '';

		if($_SERVER['REQUEST_METHOD']=='POST')
		{
		$data = ['userId'=>$userId,'comment'=>$_POST['comment'],'questionId'=>$questionId]; 
		//var_dump($data);	
		$questionModel->postComment($data);
		
		}
		else
		{
			var_dump("nu avem post");
			exit();
		}
		break;
}

