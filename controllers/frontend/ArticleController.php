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
}

