<?php
 class shopCart{

 	public function __construct(){
 		$this->createCart();
 	}

	private function createCart(){
		if(!isset($_SESSION['cart'])){
			$_SESSION['cart'] = array();
		}

	}


 }

?>