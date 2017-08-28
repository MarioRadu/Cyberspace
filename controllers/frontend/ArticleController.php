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
$views = 0 ; 
// get the action 
switch ($registry->requestAction)
{	
	default:
	case 'list':
		$info = $articleModel->getInfo();
		$list = $articleModel->getArticleList();
		//$userName = $articleModel->getUserNameById(3);

		$articleView->showAllArticles("articleList",$list,$info[0],$info[1]);

		break;
	break;
	case 'show_article':
		$id = $registry->request['id'];
		if(isset($session->user->id))
		{
			$userId = $session->user->id;
		}


		$articleModel->registerView($id);

		$views = $articleModel->getInfo();


		$articleData = $articleModel->getArticleById($id);
		$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : '';
		$commentList = $articleModel->getCommentListByQuestionId($questionId);
		$replyList = $articleModel->getReplyListByQuestionId($questionId);
		$articleView->showArticle("article_pages",$articleData,$commentList,$replyList, $userId);	
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
			$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : '';
			if($_SERVER['REQUEST_METHOD']=='POST')
				{
					$redirectId = $_POST['id'];
					$reply = $_POST['reply'];
					$articleModel->postReply($questionId,$userId,$reply);
					//var_dump($userId);
					//exit;
					header("Location: " . $baseUrl . "/article/show_article/id/" . $redirectId);

				}
				else
				{
					var_dump("nu avem post"); //nu avem post"
				}
		}
		break;

	case "search_question" :
				if($_SERVER['REQUEST_METHOD']=='POST')
				{
					$stringToSearch = $_POST['search'];

					$result = $articleModel->searchQuestion($stringToSearch);

					if($result != NULL)
					{
						$articleView->showAllArticles("articleList",$result,$test=NULL,$test=NULL,$test=NULL);
						break;	
					}
					else
					{
						var_dump("NULL");
					}
				}
				else
				{
					var_dump("nu avem post"); //nu avem post"
				}
		break;
	case "delete_comment":
		//$id = $registry->request['id'];

		//var_dump($id);
		//exit();
		$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : '';
		$userId = $session->user->id;
		$baseUrl = $registry->configuration->website->params->url;
		$articleModel->deleteCommentById($registry->request['id'],$userId);
		header("Location: " . $baseUrl . "/article/list");
		break;
	case "delete_question":
		$userId = $session->user->id;
		$baseUrl = $registry->configuration->website->params->url;
		$articleModel->deleteQuestionById($registry->request['id'],$userId);
		header("Location: " . $baseUrl . "/article/list" );
		break;
}

