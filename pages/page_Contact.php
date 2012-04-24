<?php

class page_Contact{
	
	public $title = 'Contact';
	public $content;
	public $message;


	public function __construct(){
		$this->formValidation = new formValidation;
		$this->contact = new Contact('c_name', 'c_subject', 'c_message');
		$this->content();
	}

	public function content(){

		$this->content = '<h1>Neem contact met ons op</h1>'.
							$this->contact->message.

							$this->contact->createForm();
	}
}

?>