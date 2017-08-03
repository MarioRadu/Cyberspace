<?php


class Article_View extends View
{
	public function __construct($tpl)
	{
		$this->tpl = $tpl;
	}


	public function showAllArticles($templateFile="",$data,$page)
	{
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");
		$this->tpl->setBlock('tpl_main','list_article','list_article_block');

		$this->tpl->paginator($data['pages']);
		$this->tpl->setVar("PAGE",$page);

		foreach ($data['data'] as $art => $artValue) {
			foreach ($artValue as $key => $value) {
				if ($key == 'content') {
					$this->tpl->setVar(strtoupper($key),substr($value, 0, 5));
				} else {
					$this->tpl->setVar(strtoupper($key),$value);
				}
			}
			$this->tpl->parse("list_article_block","list_article",true);
		}
	}

	public function postComment($templateFile="")
	{
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");
		//$this->tpl->setBlock('tpl_main','post_comment','post_comment_block');
		//s$this->tpl->parse("post_comment_block","post_comment",true);
	}

	public function showArticle($templateFile="",$data)
	{
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");
			
		foreach ($data as $key => $value) 
		{
			foreach ($value as $k => $v) 
			{
				//set the tamplate
				$this->tpl->setVar(strtoupper($k),$v);
			}
		}
	}


	public function editArticle($templateFile="",$data)
	{
			//var_dump("AICIIII");
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");
		foreach ($data as $key => $value) 
		{
			foreach ($value as $k => $v) 
			{
				//set the tamplate
				$this->tpl->setVar(strtoupper($k),$v);
			}
		}

	}
} 