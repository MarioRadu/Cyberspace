<?php


$articleView = new Article_View($tpl);
$articleModel = new Article();


switch ($registry->requestAction) {
	default:
	case 'list':
		$page = (isset($registry->request['page']) && $registry->request['page']>0) ? $registry->request['page']:1;
		$list = $articleModel->getArticleList($page);
		$articleView->showAllArticles("listArticle",$list,$page);
		//$articleView->showAllArticles("")
		break;
	case 'edit' :
		$id = $registry->request['id'];
		$article = $articleModel->getArticleById($id);
		$articleView->editArticle("editArticle",$article);

		//$articleView->postComment("addArticle");
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			//var_dump($_POST);
			$articleModel->updateArticle($_POST,$id);
			$baseUrl = $registry->configuration->website->params->url;
			header("Location: " . $baseUrl . "/admin/article/list");
			exit();
		}
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
	case 'delete' :
		$baseUrl = $registry->configuration->website->params->url;
		$articleModel->deleteArticle($registry->request['id']);
		header("Location: " . $baseUrl . "/admin/article/list");
		exit;
		break;
	case 'show' :
		$id = $registry->request['id'];
		$articleData = $articleModel->getArticleById($id);
		$articleView->showArticle("showArticle",$articleData);
		break;

	case "add_comment":

		
		//$id = $registry->request['id'];
		//$articleComment = $articleModel->getArticleById($id);
		if($_SERVER['REQUEST_METHOD']=='POST')
		{	
			var_dump("Ajuns in add comment");
			$articleModel->postComment("test");
		}
		else
		{
			var_dump("nu a em post");
		}

}