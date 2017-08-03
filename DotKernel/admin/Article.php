<?php

class Article extends Dot_Model
{

	public function getArticleList($page=1)
	{
		//$page = 1 ;
		$select = $this->db->select()
						->from('article');
		$dotPaginator = new Dot_Paginator($select,$page,$this->settings->resultsPerPage);

		$result = $dotPaginator->getData();
		return $result;
	}

	public function addArticle($data)
	{
		//var_dump($data['name']);

		$dataToBeInserted = array('content'=>$data['name']);
		$this->db->insert("article",$dataToBeInserted);
	}

	public function deleteArticle($id)
	{
		//var_dump($data['name']);
		$delete = $this->db->delete('article','id = '.$id);
		//header("Location: localhost/dotkernel1/admin/article/list");
	}

		// get an article by id -> $id as parameter
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

	public function updateArticle($data,$id)
	{

		var_dump("ajuns in updateArticle");
		

		$update = $this->db->update('article',$data,'id = '.$id);
	}				/// where what 


}