<?php

class Article extends Dot_Model
{

	// get all questions from table "question" 
	public function getArticleList()
	{
		$select = $this->db->select()
						->from('question')
						->joinLeft('user',"question.userId = user.id","username")
						->order('question.date DESC');
		$result = $this->db->fetchAll($select);
	
		return $result;
	}
	public function getQuestionUsername($id)
	{
		$select = $this->db->select()
						->from('question');
						// /->joinLeft('user','question.userId = user.id',['username'=>'username']);

		$result = $this->db->fetchAll($select);
		//Zend_Debug::dump($result); exit;
		// var_dump($result['userId']); exit();

		//$username = self::getUserNameById(12);

		//Zend_Debug::dump($result); exit();


		return $result;
	}

	public function userIdToUsername($userId)
	{
		$select = $this->db->select()
						->from('user','username')
						->where("id = ?", $userId);
		$result = $this->db->fetchOne($select);
		return $result;
	}

		public function getVoteList()
	{

		 $select = $this->db->select()
                            ->from('vote');
        $result = $this->db->fetchAll($select);
        return $result;
	}

	
	public function getArticleById($id)
	{
		// $select from table "question" where id = $id ; 
		$select = $this->db->select()
							->from("question")
							//->joinLeft('user','question.userId = user.id', ['username'=>'username'])
							->where("question.id = ?",$id)
							->join('user','user.id = question.userId', ['username'=>'username'])
							;
		// store in $result all the data from the database ;
		$result = $this->db->fetchAll($select);
		//Zend_Debug::dump($result); exit();
		return $result;
	}

	// add an question , $data is our question we want to add .
	public function addArticle($data)
	{
		// insert a question into the "question" table,with the data we want.
		$this->db->insert("question",$data);
	}

	// post a comment, $data is our comment we want to post . 
	// post a comment, $data is our comment we want to post . 
	public function postComment($data)
	{	
		//dataToBeInserted it's an array , we store in it our userId , questionId and content
		// insert intro table "comment" our array 
		$dataToBeInserted = array('userId'=>$data['userId'],'questionId'=>$data['questionId'],'content'=>$data['comment']);
		$this->db->insert("comment",$dataToBeInserted);

		$id = $data['questionId'];
		$num = (int)$id;

		$data = array('comments' => new Zend_Db_Expr('comments + 1')); 
		$where = array('id = ?' => $num); 
		$this->db->update("question", $data, $where);
	}


	//get all comments from a question by questionId
	public function getCommentListByQuestionId($questionId)
	{	
		// select all from table "comment" where questionId is equal to "questionId"
		// we want to get all comments from table user where userId = id, we use joinLeft .

		$select = $this->db->select()
							->from('comment')
							->where('questionId = ?',  $questionId)
							//->where('parent = ?', 0)
							->joinLeft("user","comment.userId=user.id",["username"=>"username"])
							//->joinLeft("user","comment.userId=user.id",["picture"=>"picture"])
							;
		$result = $this->db->fetchAll($select);

		return $result;
	}

	public function postQuestion($data,$userId)
	{
		$title = $data['title'];
		$question=$data['question'];
		$dataToBeInserted = array('title'=>$title,'content'=>$question,'userId'=>$userId);
		$this->db->insert("question",$dataToBeInserted);
	}

	public function getReplyListByQuestionId($questionId)
	{
		$select = $this->db->select()
							->from('comment')
							->where("parent <> 0")
							->joinLeft("user","comment.userId=user.id",array("username"=>"username",'image'=>'image'));
							;
		$result = $this->db->fetchAll($select);

		return $result;
	}

	public function postReply($questionId,$userId,$reply)
	{

		$dataToBeInserted = array('userId'=>$userId,'content'=>$reply,'parent'=>$questionId);
	 	$save = $this->db->insert("comment",$dataToBeInserted);
	}


	public function editReply($reply,$replyId,$userId)
	{
		$select = $this->db->select()
							->from('comment')
							->where('id = ?', $replyId)
							;

		$result = $this->db->fetchRow($select);
		$data = ['content'=>$reply];
		$where = array('id = ?' => $replyId,'userId = ?' =>$userId);

		$this->db->update('comment', $data, $where);
	}



	public function editComment($comment,$commentId,$userId)
	{
		$select = $this->db->select()
							->from('comment')
							->where('id = ?', $commentId)
							;

		$result = $this->db->fetchRow($select);
		$data = ['content'=>$comment];
		$where = array('id = ?' => $commentId,'userId = ?' =>$userId);

		$this->db->update('comment', $data, $where);
	}


	public function searchQuestion($searchString)
	{
		$countResultByTitle = NULL ;
		$countResultByContent = NULL;
		$countSearchString = 3;
			
		if(strlen($searchString) > $countSearchString)
		{

			$selectByTitle = $this->db->select()
									  ->from("question")
									  ->where('title LIKE ?', '%' . $searchString .'%')
									;
			$resultByTitle = $this->db->fetchAll($selectByTitle);


			$selectByContent = $this->db->select()
									->from("question")
									->where('content LIKE ?', '%' . $searchString .'%')
									;
			$resultByContent = $this->db->fetchAll($selectByContent);


			if(count($resultByTitle) > 0)
			{
				$countResultByTitle = count($countResultByTitle);
			}
			elseif (count($resultByContent) > 0)
			{
				$countResultByContent = count($countResultByContent);
			}
				// 
			if($countResultByContent > $countResultByTitle)
			{
				return $resultByContent;
			}
			else
			{
				return $resultByTitle;
			}
		}
		else
		{
			var_dump("Please search by at least one key word !");
		}
	}


	public function getInfo()
	{

		$selectViews = $this->db->select()
							->from("question");

		$resultViews = $this->db->fetchAll($selectViews);

		foreach ($resultViews as $commentId=>$value) 
		{
			foreach ($value as $k => $v) 
			{
				if($k == 'views')
				{
					$views[] = $v;
				}
				if($k == 'comments')
				{
					$comments[] = $v;
				}
			}
		}	

		return array($views, $comments);	
	}


	public function getUserNameById($id)
	{
		$selectUserName = $this->db->select()
									->from("user")
									->where('id = ?', $id);
		$resultUserName = $this->db->fetchOne($selectUserName);

		return $resultUserName;
		var_dump($resultUserName);
		exit();
	}

	public function registerView($questionId)
	{
		$data = array('views' => new Zend_Db_Expr('views + 1')); 
		$where = array('id = ?' => $questionId);; 
		$this->db->update('question', $data, $where);
	}


	public function deleteCommentById($id , $userId)
	{	

		$selectReply = $this->db->select()
								->from('comment')
								->where('parent = ?', $id)
								;
		$resultReply = $this->db->fetchAll($selectReply);

		foreach ($resultReply as $replyKey => $replyValue)
		{	
			
			foreach ($replyValue as $key => $value)
			{
				if($key == 'id')
				{
					$data = ['id = ?'=>$value,'userId = ?'=>$userId];

					 $this->db->delete('comment', $data);
				}
			}
		}

			$commentData = ['id = ?'=>$id,'userId = ?'=>$userId];
	   	    $this->db->delete('comment', $commentData);

	}



	public function deleteQuestionById($id , $userId)
	{
		$data = ['id = ?'=>$id,
				'userId = ?'=>$userId
				];
	    $this->db->delete('question', $data);
	}


    public function deleteReplyByReplyId($id,$userId)
   	{

		$select = $this->db->select()
							->from('comment')
							->where('id = ?', $id)
							;

		$result = $this->db->fetchRow($select);

		$data = ['id = ?'=> $result['id'],'userId = ?' => $userId];

		$delete = $this->db->delete('comment',$data);


		if($delete > 0)
		{
			$registry->session->message['txt'] = 'Deleted Succesull !';
			$registry->session->message['type'] = 'error';
		}
		else
		{
			$registry->session->message['txt'] = "You can't delete that reply !";
			$registry->session->message['type'] = 'error';
		}

	}  


  public function registerVote($data)
    {
        $update = $this->db->insert('vote', $data);

        return 'succes';
    }


   public function updateVote($data, $id)
    {
        $update = $this->db->update('vote', $data, 'id = ' . $id);

        return 'succes';
    }
 

   public function checkVotes($commentId, $userId)
    {
        $select = $this->db->select()
                            ->from('vote')
                            ->where('commentId=?', $commentId)
                            ->where('userId=?', $userId);
        $result = $this->db->fetchRow($select);
        return $result;
    }


    public function getRatings()
    {

   		$selectLike = 'SELECT *,SUM(`vote`) as `voteCount` FROM `vote` GROUP BY `commentId`';

		$result = $this->db->fetchAll($selectLike);

		$finalData = [];
		foreach ($result as $key => $value)
		{
			$finalData[$value['commentId']] = $value['voteCount'];
		}
		return $finalData;
    }


    public function getCommentProfilePictureById($questionId)
	{
		$select = $this->db->select()
							->from('comment')
							->where('questionId = ?', $questionId)
							->joinLeft("user","comment.userId=user.id",["image"=>"image"])
							;
		$result = $this->db->fetchAll($select);

		$finalData = [];
		foreach ($result as $key => $value)
		{
			$finalData[$value['id']] = $value['image'];
		}

		return $finalData;
	}

	public function getUserInfo($username)
	{

		$finalData = [];
		$now = time();
		var_dump($now);
		$selectUserInfo = $this->db->select()
									->from('user')
									->where('username = ?',$username);
		$resultUserInfo = $this->db->fetchAll($selectUserInfo);

		foreach ($resultUserInfo as $resultKey => $resultValue)
		{
			foreach ($resultValue as $key => $value)
			{
				if($key != 'password')
				{
					$finalData[$key] = $value;
				}

				if($key == 'dateCreated')
				{
					$datePassed = self::getTimePassed($value);
					$finalData[$key] = 	$datePassed; 
				}
			}
		}
		return $finalData;


	}


	public function getTimePassed($date1)
	{
		$date2 = date('Y-m-d G:i:s');

		$diff = abs(strtotime($date2) - strtotime($date1));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$datePassed = "Years : " . $years . " months : " . $months . "  days " . $days;


		if($years > 0)
		{
			$datePassed = "Years : " . $years . " months : " . $months . "  days " . $days;

		}elseif ($months>0)
		{
			$datePassed = "Months : " . $months . "  days " . $days;

		}elseif ($days>0)
		{
			$datePassed = "Days " . $days;
		}
		return $datePassed;
	}

}