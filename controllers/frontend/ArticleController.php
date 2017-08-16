<?php
// Question Controller

// new instance of question View and Model .
$articleView = new Article_View($tpl);
$articleModel = new Article();
// all actions MUST set  the variable  $pageTitle
$pageTitle = $option->pageTitle->action->{$registry->requestAction};
//get the session from zend registry 
$session = Zend_Registry::get('session');
// get the base url 
$baseUrl = $registry->configuration->website->params->url;
$userId = NULL;
// get the action 
switch ($registry->requestAction)
{	
	default:
	case 'list':
		$list = $articleModel->getArticleList();
		$articleView->showAllArticles("articleList",$list);
		break;
	break;
	case 'show_article':
		$id = $registry->request['id'];
		$commentId = $id;
		if(isset($session->user->id))
		{
			$userId = $session->user->id;
		}

		$articleData = $articleModel->getArticleById($id);
		$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : '';
		$commentList = $articleModel->getCommentListByQuestionId($questionId);
		$replyList = $articleModel->getReplyListByQuestionId($questionId);
		$articleView->showArticle("article_pages",$articleData,$commentList,$replyList, $userId);
		//echo "<pre>";
		//var_dump($replyList);		
	break;
	case 'add' :
		$articleView->postComment("addArticle");
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$articleModel->addArticle($_POST);
		}
		else
		{
			var_dump("nu avem post");
		}
		break;

	case "comment":

		$userId = (isset($session->user->id)) ? $session->user->id : NULL;
		$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : '';

		if($userId == NULL) 
		{ 
			// if userId is NULL redirect to user login page .
			header("Location: " . $baseUrl . "/user/login");
		}
		else
		{
			if($_SERVER['REQUEST_METHOD']=='POST')
			{
				$data = ['userId'=>$userId,'comment'=>$_POST['comment'],'questionId'=>$questionId]; 
				$articleModel->postComment($data);
				header("Location: " . $baseUrl . "/article/show_article/id/".$questionId);
			}
			else
			{
				var_dump("nu avem post");
				exit();
			}
		}

		break;
	case "add_question" :
		$articleView->showPostQuestion("addQuestion");
		break;

	case "post_question":
	if(isset($session->user->id))
		{
			$userId = $session->user->id;
			$articleModel->postQuestion($_POST,$userId);
		}
		header("Location: " . $baseUrl . "/article/list");

	case "post_reply" :
		$id = $registry->request['id'];

		if(isset($session->user->id))
		{
			$userId = $session->user->id;
			if($_SERVER['REQUEST_METHOD']=='POST')
				{
					$reply = $_POST['reply'];
					$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : '';
					$articleModel->postReply($questionId,$userId,$reply);
					header("Location: " . $baseUrl . "/article/show_article/id/" . $_POST['id']);
				}
				else
				{
					var_dump("nu avem post"); //nu avem post"
				}
		}
		break;
}

