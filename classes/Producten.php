<?php

class Producten{
	
	public $data;	

	public function __construct(){
		$this->prepareArrays();
	}

	private function prepareArrays(){
		$this->data = array(
				'cats' => array(),
				'products' => array()	
			);
	}

	public function getProducts(){
		$query = mysql_query("SELECT * FROM producten");
		while($row = mysql_fetch_assoc($query)){
			$this->data['products'][] = $row;
		}	
	}
	public function getCats(){
		$query = mysql_query("SELECT * FROM categorieen");
		while($row = mysql_fetch_assoc($query)){
			$this->data['cats'][] = $row;
		}		
	}

	public function getProductsArray($array){
		$products = $this->getProducts();

		if(is_array($array)){
			foreach ($array as $key => $value) {

			}
		}
		else{
			return 'ERROR: ARRAY VERWACHT';
		}
	}

	public function getProduct($id){
		$id = mysql_real_escape_string($id);
		$query = mysql_query("SELECT * FROM producten WHERE product_id = '".$id."'");
		$row = mysql_fetch_assoc($query);
		return $row;
	}

	public function product_exists($id){
		$id = mysql_real_escape_string($id);
		$query = mysql_query("SELECT product_id FROM producten WHERE product_id = '".$id."'");
		if(mysql_num_rows($query) == 1){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function moneyDisplay($int, $aantal){
		$int = $int * $aantal;

		$money = number_format(($int/100), 2, ',', '.');

		return $money;
	}

}


?>