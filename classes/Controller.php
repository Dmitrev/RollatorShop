<?php

class Controller{
		
	//Objects
	private $o_Url;
	private $o_Page;
	private $o_Cart;

	//Strings
	private $s_class;

	//Parts of page
	private $s_content;
	private $s_title;



	public function __construct(){
		$this->o_Url = new Url;
		$this->o_Page = new Page;
		$this->o_Cart = new shopCart;
		//var_dump($this->o_Url->var);
		$this->checkUrl();
	}

	private function checkUrl(){
		if($this->o_Url->var[0] === '' || $this->o_Url->var[0] === 'index.php'){
			$this->s_class = 'home';
		}
		else{
			$this->s_class = $this->o_Url->var[0];
		}

		$this->setClassPrefix();
	}

	private function setClassPrefix(){
		$this->s_class = ucfirst($this->s_class);
		$this->s_class = 'page_'.$this->s_class;
		$this->loadClass();

	}

	private function loadClass(){
		if(class_exists($this->s_class)){
			$this->o_Object = new $this->s_class;
		}
		else{
			$this->o_Object = new page_404;
		}

		$this->setPage();
	}

	private function setPage(){
		$this->o_Page->setPageTitle($this->o_Object->title);
		$this->o_Page->setPageContent($this->o_Object->content);
		$this->o_Page->displayPage();

	}

}

?>