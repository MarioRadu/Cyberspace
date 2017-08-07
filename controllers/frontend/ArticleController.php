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
		//var_dump($registry->request['page']);
		$articleView->postComment("addArticle");
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			//var_dump("avem post");
			$articleModel->addArticle($_POST);
		}
		else
		{
			var_dump("nu avem post");
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

