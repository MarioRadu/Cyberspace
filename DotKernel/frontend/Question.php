<?php

class Question extends Dot_Model
{

	public function getQuestionList()
	{
		$select = $this->db->select()
						->from('question');
		$result = $this->db->fetchAll($select);
		return $result;
	}

	
	public function getQuestionById($id)
	{
		// $select from table "article" where id = $id ; 
		$select = $this->db->select()
							->from("question")
							->where("id = ?",$id);

		// store in $result all the data from the database ;
		$result = $this->db->fetchAll($select);

		// return $result ; 
		return $result;
	}

	public function addQuestion($data,$userId)
	{
		$title = $data['title'];
		$question = $data['question'];
		//var_dump($userId);
		//exit();
		//$questionData = array('title'=>$title,'content'=>$question);
		//var_dump($data['name']);
		//var_dump("ajuns in add question".$title.$question);
		//exit();
		$dataToBeInserted = array('title'=>$title,'content'=>$question,'userId'=>$userId);
		$this->db->insert("question",$dataToBeInserted);
	}

	public function postComment($data)
	{
		//var_dump("ajuns in post comment");
		//var_dump($data);
		//exit();
		$dataToBeInserted = array('userId'=>$data['userId'],'questionId'=>$data['questionId'],'content'=>$data['comment']);

		//var_dump($dataToBeInserted);
		//exit();
		$this->db->insert("comment",$dataToBeInserted);
	}
}