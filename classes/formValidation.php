<?php

class formValidation{
	
	public function __construct(){

	}

	public function valid_name($input){
		return preg_match('/^[a-zA-Z ]+$/', $input);
	}

	public function valid_postcode($input){
		$input = strtoupper($input);
		return preg_match('/[1-9]{1}[0-9]{3}[ ]?[A-Z]{2}/i', $input);
	}
}

?>