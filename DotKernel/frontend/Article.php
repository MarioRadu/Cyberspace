<?php

class Article extends Dot_Model
{

	public function getArticleList()
	{
		$select = $this->db->select()
						->from('article');
		$result = $this->db->fetchAll($select);
		return $result;
	}

	
	public function getArticleById($id)
	{
		// $select from table "article" where id = $id ; 
		$select = $this->db->select()
							->from("article")
							->where("id = ?",$id);

		// store in $result all the data from the database ;
		$result = $this->db->fetchAll($select);

		// return $result ; 
		return $result;
	}

}