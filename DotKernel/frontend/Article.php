<?php

class Article extends Dot_Model
{

	public function getArticleList()
	{
		$select = $this->db->select()
						->from('question');
		$result = $this->db->fetchAll($select);
		return $result;
	}

	
	public function getArticleById($id)
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

	public function addArticle($data)
	{

		$this->db->insert("question",$data);
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