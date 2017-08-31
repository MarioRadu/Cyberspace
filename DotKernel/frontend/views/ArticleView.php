<?php


class Article_View extends View
{


	public function __construct($tpl)
	{
		$this->tpl = $tpl;
	}

    // show a tpl file .
	public function showPage($templateFile = '')
	{
		if ($templateFile != '') $this->templateFile = $templateFile;//in some cases we need to overwrite this variable
		$this->tpl->setFile('tpl_main', 'page/' . $this->templateFile . '.tpl');
	}


	private function _getReplyList($replyList, $commentId)
	{
		$replies = [];
		foreach ($replyList as $reply) 
		{
			if($reply['parent'] == $commentId)
			{
				$replies[] = $reply;
			}
		}
		return $replies;
	}

   //
	private function _setData($data, $prefix='')
	{
		if(!is_array($data))
		{
			error_log('not an array' . __FILE__ .':'. __LINE__);
			return false;
		}
		foreach($data as $key => $value)
		{
			$this->tpl->setVar(strtoupper($prefix.$key), $value);
		}
		return true;
	}
	// show all questions, we have 2 parameters. The first one stores the name of the tpl file we want to show .
	// The second parameter "data" stores the data we want to load into our tpl file in order to be displayed.
	public function showAllArticles($templateFile="",$data,$views,$comments)
	{
		// if our tpl file exists set it 
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");
		// in ou tpl file we must have a article_list block, in order to set it .
		$this->tpl->setBlock('tpl_main','article_list','article_list_block');

		// for each value in our "data" array set to upper the key .
		foreach ($data as $key => $value) 
		{
			foreach ($value as $key => $value) 
			{
				$this->tpl->setVar(strtoupper($key),substr($value, 0, 205));
				if($key == 'content')
				{
					$this->tpl->setVar(strtoupper($key),substr($value, 0, 205) . "...");
				}
			}
			// parse the block with the value "true" in order to repeat it,if we have to . 
		 	$this->tpl->parse("article_list_block","article_list",true);
		}
	}



		// show question,we have 4 parameters 
		// templateFile stores the name of the tpl file .
		// data stores the data we want to display
		// commentList stores the commentList 
		// userId stores the userId, if userId it's not equal to NULL we have a user logged.
		public function showArticle($templateFile="",$data,$commentList,$replyList, $userId,$vote,$profilePicture,$setVotes)
		{	

			//Zend_Debug::dump($vote);
		    Zend_Debug::dump($setVotes);
			///exit();
			if($templateFile !="") $this->templateFile = $templateFile;
			$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");
			$this->tpl->setBlock('tpl_main','comment_form','comment_form_block');
			$this->tpl->setBlock('tpl_main','comment_list','comment_list_block');
			$this->tpl->setBlock('comment_list','reply_list','reply_list_block');

			$this->tpl->parse("comment_form_block","comment_form",true);

				foreach ($data as $dataKey => $dataValue) 
				{

					foreach ($dataValue[0] as $key => $value)
					{
						$this->tpl->setVar(strtoupper($key),$value);
					}

				}

				foreach ($commentList as $comment) 
				{
					foreach ($profilePicture as $pictureKey => $pictureValue)
					{	

						if($pictureKey == $comment['id'])
							{								
									$this->tpl->setVar('PICTURE',$pictureValue);
							}
					}

					foreach ($comment as $key => $value)
					{
						$this->tpl->setVar(strtoupper('COMMENT_' . $key),$value);
					}

				
					if(array_key_exists($comment['id'], $vote))
					{
						foreach ($vote as $voteKey => $voteValue)
						{
								if($voteKey == $comment['id'])
								{
									//Zend_Debug::dump("VOTE : " . $voteValue);
									if($voteValue != NULL)
									{	
									   $this->tpl->setVar('BUTTON_DISABLED',"disabled");
									   $this->tpl->setVar('RATING',$voteValue);
									}
								}
						}
					}else
					{
									//$this->tpl->setVar('RATING',0);
									$this->tpl->setVar('BUTTON_ENABLED',"false");
					}

					$currentReplyList = $this->_getReplyList($replyList, $comment['id']);


					$lastKey = count($currentReplyList)-1 ;
					if(empty($currentReplyList))
					{
						$this->tpl->parse("comment_list_block","comment_list",true);
						continue; 
					}

					foreach ($currentReplyList as $key => $reply) 
					{
						

						$this->_setData($reply,'REPLY_');	
						$this->tpl->parse("reply_list_block","reply_list",true);
						if($key == $lastKey)
						{
						$this->tpl->parse("comment_list_block","comment_list",true);
						$this->tpl->parse("reply_list_block","");
						}
					}
				}

		}

	// set the tpl file and display it .
	public function showPostQuestion($templateFile="")
	{
		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");
	}


	public function showProfileInfo($templateFile="",$userData)
	{

		if($templateFile !="") $this->templateFile = $templateFile;
		$this->tpl->setFile('tpl_main','article/'.$this->templateFile.".tpl");

		foreach ($userData as $userDataKey => $userDataValue)
		{
			$this->tpl->setVar(strtoupper('USER_' . $userDataKey),$userDataValue);
		}
	}

}