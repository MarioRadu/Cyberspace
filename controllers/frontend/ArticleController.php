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
		$articleView->showAllArticles("articleList",$list,$info[0],$info[1]);
		break;

	case 'show_article':




		$id = $registry->request['id'];
		if(isset($session->user->id))
		{
			$userId = $session->user->id;
			$articleModel->registerView($id);
			$setVotes = $articleModel->getUserLikes($id,$userId);

		}

		$allVotes = $articleModel->getRatings();
		$articleData[] = $articleModel->getArticleById($id);
		$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : NULL;
		$commentList = $articleModel->getCommentListByQuestionId($questionId);
		$profilePicture = $articleModel->getCommentProfilePictureById($questionId);
		$replyList = $articleModel->getReplyListByQuestionId($questionId);

		$articleView->showArticle("article_pages",$articleData,$commentList,$replyList, $userId,$allVotes,$profilePicture,$setVotes);
			
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

		case 'vote':


			$register = 'aa';
			$update = 'ss';
			$id = $registry->request['id'];

			if(isset($_POST) && !empty($_POST))
			{
				if(isset($session->user->id))
				{	
					$userId = $session->user->id;

					$vote = [];
              	 	$vote['commentId'] = $_POST['commentId'];
              	 	$vote['questionId'] = $_POST['questionId'];
              	 	$vote['userId'] = $session->user->id;
              	 	if($_POST['action'] == 'up')
              	 	{
              	 		$vote['vote'] = 1 ; 
              	 	}
              	 	else
              	 	{
              	 		$vote['vote'] = -1;
              	 	}

					$checkVote = $articleModel->checkVotes($vote['commentId'], $vote['userId']);


			    	if (empty($checkVote)) 
			    	{
                   	   $articleModel->registerVote($vote);
               	    }
               	    else
               	    {
                       $articleModel->updateVote($vote, $checkVote['commentId']);
                	}

                		$success = ['success' => 'true'];
	                	echo json_encode($success);
	                	exit();
				}
			}

		break;

		case 'profile':
			
			$id = $registry->request['id'];
			$username = $id;

			$userInfo = $articleModel->getUserInfo($username);
			$articleView->showProfileInfo("profileView",$userInfo);

			break;

	case "delete_comment":


		$id = (isset($registry->request['id'])) ? $registry->request['id'] : NULL;
		$questionId = (isset($registry->request['questionId'])) ? $registry->request['questionId'] : NULL;
		$userId = $session->user->id;

		$articleModel->deleteCommentById($id,$userId);

		header("Location: " . $baseUrl . "/article/show_article/id/" . $questionId);

		break;

	case "delete_question":

		
		if(isset($session->user->id))
		{
			$userId = $session->user->id;
			$id = (isset($registry->request['id'])) ? $registry->request['id'] : NULL;

			$articleModel->deleteQuestionById($id,$userId);
			header("Location: " . $baseUrl . "/article/list" );
		}
		else
		{
			header("Location: " . $baseUrl . "/article/list" );
		}
	break;


	case 'delete_reply':

		if(isset($session->user->id))
		{
			$userId = $session->user->id;
			$replyId = (isset($registry->request['id'])) ? $registry->request['id'] : NULL;
			$questionId = (isset($registry->request['questionId'])) ? $registry->request['questionId'] : NULL;
			$reply = $articleModel->deleteReplyByReplyId($replyId,$userId);
			header("Location: " . $baseUrl . "/article/show_article/id/" . $questionId);
		}
		else
		{
			$registry->session->message['txt'] = 'Please Login !';
			$registry->session->message['type'] = 'error';
			header("Location: " . $baseUrl . "/article/login");

		}

        break;


    case 'edit_reply':
    	
    	$id = $registry->request['id'];

		if(isset($session->user->id))
		{	
			$userId = $session->user->id;

			 if($_SERVER['REQUEST_METHOD']=='POST')
			 	{
			 		$redirectId = $_POST['id'];
			 		$reply = $_POST['reply'];
			 		$replyId = $_POST['replyId'];
			 		//$replyUserName = $_POST['replyUserName'];
			 		$articleModel->editReply($reply,$replyId,$userId);
			 		header("Location: " . $baseUrl . "/article/show_article/id/" . $redirectId);
				}
		}
		break;

	case 'edit_comment':

		$id = $registry->request['id'];

		if(isset($session->user->id))
		{	
			$userId = $session->user->id;

			 if($_SERVER['REQUEST_METHOD']=='POST')
			 	{
			 		$redirectId = $_POST['id'];
			 	    $comment = $_POST['comment'];
			 		$commentId = $_POST['commentId'];
			 		// //$replyUserName = $_POST['replyUserName'];
			 		$articleModel->editComment($comment,$commentId,$userId);
			 		// var_dump("ACIIC");
			 		//Zend_Debug::dump($_POST);
			 		//exit();
			 		header("Location: " . $baseUrl . "/article/show_article/id/" . $redirectId);
				}
		}
}
