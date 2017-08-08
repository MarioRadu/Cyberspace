<?php


class Question_View extends View
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


	public function showAllQuestion($templateFile="",$data)
	{
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','question/'.$this->templateFile.".tpl");
		$this->tpl->setBlock('tpl_main','question_list','question_list_block');

		foreach ($data as $key => $value) 
		{
			foreach ($value as $key => $value) 
			{
				$this->tpl->setVar(strtoupper($key),$value);
			}
		 	$this->tpl->parse("question_list_block","question_list",true);
		}
	}


	public function showQuestion($templateFile="",$data, $userId=null)
	{
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','question/'.$this->templateFile.".tpl");
		$this->tpl->setBlock('tpl_main','comment','comment_block');
			
			foreach ($data as $key => $value) 
			{
				foreach ($value as $k => $v) 
				{
					$this->tpl->setVar(strtoupper($k),$v);
				}
				if($userId !== null)
					{	 
						$this->tpl->parse("comment_block","comment",true);
					}
			}	
	}
	// 
	public function postQuestion($templateFile="")
	{
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','question/'.$this->templateFile.".tpl");
	}
}
