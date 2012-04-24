<?php

class page_Tnx{
	public $title = 'Tnx';
	public $content = '<h1>Ewa...</h1>

		Bedankt voor je doekoe, we droppen je items bij je in de hood.';
	public function __construct(){
		unset($_SESSION);
	}	
}

?>