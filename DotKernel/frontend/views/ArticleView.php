<?php

class Article_View extends View
{


	public function __construct($tpl)
	{
		$this->tpl = $tpl;
	}

	public function showPage($templateFile = '')
	{
		if ($templateFile != '') $this->templateFile = $templateFile;//in some cases we need to overwrite this variable
		$this->tpl->setFile('tpl_main', 'page/' . $this->templateFile . '.tpl');
	}


	public function showAllArticles($templateFile="",$data)
	{
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");
		$this->tpl->setBlock('tpl_main','article_list','article_list_block');

		foreach ($data as $key => $value) 
		{
			foreach ($value as $key => $value) 
			{
				$this->tpl->setVar(strtoupper($key),$value);
			}
		 	$this->tpl->parse("article_list_block","article_list",true);
		}
	}


		public function showArticle($templateFile="",$data)
		{
			if($templateFile !="") $this->templateFile = $templateFile;
			$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");

			foreach ($data as $key => $value) 
			{
				foreach ($value as $k => $v) 
				{
					$this->tpl->setVar(strtoupper($k),$v);
				}
			}
		}


}