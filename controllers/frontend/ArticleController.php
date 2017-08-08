<?php


$articleView = new Article_View($tpl);
$articleModel = new Article();
// all actions MUST set  the variable  $pageTitle
$pageTitle = $option->pageTitle->action->{$registry->requestAction};
$session = Zend_Registry::get('session');
switch ($registry->requestAction)
{
	default:
	case 'list':
		// call getArticleList method to view the article pages
		$list = $articleModel->getArticleList();
		$articleView->showAllArticles("articleList",$list);
		//Zend_Debug::dump($list);
		//exit();
		break;
	break;
	case 'show_article':
		$userId = NULL;
		$id = $registry->request['id'];
		if(isset($session->user->id))
		{
			$userId = $session->user->id;
		}
		$articleData = $articleModel->getArticleById($id);
		$articleView->showArticle("article_pages",$articleData,$userId);
	break;
	case 'add' :
		$userId = (isset($session->user->id)) ? $session->user->id : '' ;

		//var_dump($userId);
		//exit();
		$articleView->postQuestion("addQuestion");
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$baseUrl = $registry->configuration->website->params->url;
			$articleModel->addQuestion($_POST,$userId);
			header("Location: " . $baseUrl . "/article/list");
		}
		break;

	case "comment":
		$userId = (isset($session->user->id)) ? $session->user->id : '';
		$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : '';

		if($_SERVER['REQUEST_METHOD']=='POST')
		{
		$data = ['userId'=>$userId,'comment'=>$_POST['comment'],'questionId'=>$questionId]; 
		//var_dump($data);	
		$articleModel->postComment($data);
		
		}
		else
		{
			var_dump("nu avem post");
			exit();
		}
		break;

}

