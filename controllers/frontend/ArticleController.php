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
	break;
	case 'show_article':
		$id = $registry->request['id'];
		if(isset($session->user->id))
		{
			$userId = $session->user->id;
			$articleModel->registerView($id);

		}


		//$test = $articleModel->getAllVotes();
		$allVotes = $articleModel->getRatings();
		$articleData[] = $articleModel->getArticleById($id);
		$questionId = (isset($registry->request['id'])) ? $registry->request['id'] : NULL;
		$commentList = $articleModel->getCommentListByQuestionId($questionId);
		$profilePicture = $articleModel->getCommentProfilePictureById($questionId);

		//Zend_Debug::dump($commentList);
		//exit();

		$replyList = $articleModel->getReplyListByQuestionId($questionId);
		$articleView->showArticle("article_pages",$articleData,$commentList,$replyList, $userId,$allVotes,$profilePicture);	
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

		//Zend_Debug::dump($_POST);
		//exit();
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

		case 'vote':


		//	Zend_Debug::dump($_POST);
			$register = 'aa';
			$update = 'ss';
			$id = $registry->request['id'];

			if(isset($_POST) && !empty($_POST))
			{
				if(isset($session->user->id))
				{	

					// Zend_Debug::dump($_POST);exit;
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
               		//$vote['vote'] = ($_POST['action'] == 'up') ? 1 : -1;


               		//Zend_Debug::dump($vote);
               		//exit();
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

			//exit();
			//Zend_Debug::dump($userInfo);
			//exit();
			$articleView->showProfileInfo("profileView",$userInfo);

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


	case 'delete_reply':


        $replyId = (isset($registry->request['id'])) ? $registry->request['id'] : '';
       // Zend_Debug::dump($replyId, $label=null, $echo=true);exit;

        $reply = $articleModel->getReply($replyId);


        //Zend_Debug::dump($_POST);exit();
        if(count($_POST) > 0)
        {
            if(isset($_POST['confirm']) && $_POST['confirm'] == "on")
            {

                $articleModel->deleteReply($replyId);

                $registry->session->message['txt'] = 'Succes';
                $registry->session->message['type'] = 'info';

            }
            else
            {
                $registry->session->message['txt'] = 'Comment was not deleted';
                $registry->session->message['type'] = 'error';
            }

           // header('Location:' . $baseUrl . '/article/show_article/id/' . $reply['postId']);
           // exit;
        }


       // header('Location:' . $baseUrl . '/article/show_article/id/136');
        // $articleView->
        //$articleView->showDeleteReplyPage('article_pages', $reply);
        //         }

        //         if ($registry->requestAction == "delete_reply")
            //         {


            //             $replyList = $articleModel->getCommentReplytByCommentId($commentId);
            //            Zend_Debug::dump($replyList, $label=null, $echo=true);exit;
            //         }

        break;

}

