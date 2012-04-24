<?php

class page_Transactie{

	public $title = 'Uw betaling';
	public $content = 'Deze transactie ID is niet geldig!';
	public function __construct(){
		
		$_SESSION['cart'] = array();
		unset($_SESSION['order']);

		$this->betaling = new Betaling;
		$this->betaling->check_ID();
		$this->content = $this->betaling->content;

	}
}

?>