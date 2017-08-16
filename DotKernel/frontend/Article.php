<?php

class Article extends Dot_Model
{

	// get all questions from table "question" 
	public function getArticleList()
	{
		$select = $this->db->select()
						->from('question')
						->order('date DESC');
		$result = $this->db->fetchAll($select);
		return $result;
	}

	
	public function getArticleById($id)
	{
		// $select from table "question" where id = $id ; 
		$select = $this->db->select()
							->from("question")
							->where("id = ?",$id);
		// store in $result all the data from the database ;
		$result = $this->db->fetchAll($select);

		// return $result ; 
		return $result;
	}

	// add an question , $data is our question we want to add .
	public function addArticle($data)
	{
		// insert a question into the "question" table,with the data we want.
		$this->db->insert("question",$data);
	}

	// post a comment, $data is our comment we want to post . 
	public function postComment($data)
	{	
		//dataToBeInserted it's an array , we store in it our userId , questionId and content
		// insert intro table "comment" our array 
		$dataToBeInserted = array('userId'=>$data['userId'],'questionId'=>$data['questionId'],'content'=>$data['comment']);
		$this->db->insert("comment",$dataToBeInserted);
	}


	//get all comments from a question by questionId
	public function getCommentListByQuestionId($questionId)
	{	
		// select all from table "comment" where questionId is equal to "questionId"
		// we want to get all comments from table user where userId = id from table user, we use joinLeft .
		$select = $this->db->select()
							->from('comment')
							->where('questionId = ?',  $questionId)
							//->where('parent = ?', 0)
							->joinLeft("user","comment.userId=user.id",["username"=>"username"])
							;
		$result = $this->db->fetchAll($select);
		return $result;
	}

	// post a question into table "question" ; 
	public function postQuestion($data,$userId)
	{
		$title = $data['title'];
		$question=$data['question'];
		$dataToBeInserted = array('title'=>$title,'content'=>$question,'userId'=>$userId);
		$this->db->insert("question",$dataToBeInserted);
	}

	public function getReplyListByQuestionId($questionId)
	{
		//var_dump("ajuns in reply list" . $questionId);
		//exit();
		$select = $this->db->select()
							->from('comment')
							->where("parent <> 0");
		$result = $this->db->fetchAll($select);
		return $result ; 
	}

		public function postReply($questionId,$userId,$reply)
	{
		$dataToBeInserted = array('id'=>$questionId,'userId'=>$userId,'content'=>$reply,'parent'=>$questionId);
		$this->db->insert("comment",$dataToBeInserted);
		var_dump($dataToBeInserted);
		//exit();

	}


}