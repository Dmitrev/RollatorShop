<?php

class Winkelmand{


	private $product_id;
	private $product_aantal;
	public $error = '';
	private $o_Producten;
	private $s_root;
	private $o_Redirect;
	private $dupeKey;
	private $type = '';
	private $s_hash;


	public function __construct(){
		require 'config.php';
		$this->s_root = $root;
		$this->s_hash = $hash;
		$this->o_Producten = new Producten;
		$this->o_Redirect = new Redirect;
		if(isset($_POST['verder'])){
			header('location: '.$this->s_root.'winkelmand/stap1/');
		}
		if(isset($_POST['product_aantal']) && isset($_POST['product_id'])){
			$this->checkRequest();
		}
	}

	public function Afrekenen(){
		if(isset($_POST['checkout'])){
			
		}
	}

	public function empty_cart(){
		if(isset($_POST['empty_cart'])){
			$_SESSION['cart'] = array();
			unset($_SESSION['order']);
		}
	}

	public function save_cart(){
		if(isset($_POST['save_cart'])){
			$this->saveChanges();
		}
	}

	private function saveChanges(){
		foreach ($_POST as $key => $value) {
			if($key != 'save_cart'){
				$key = str_replace('cart_', '', $key);

				if($this->valid_aantal($value)){
					$_SESSION['cart'][$key]['aantal'] = $value;
				}

			}
		}
	}

	public function edit_cart(){

		if(isset($_POST['edit_cart'])){
			$this->type = 'edit';
		}
		else{
			$this->type = 'normal';
		}

	}

	public function delete_cart_id(){
		if(isset($_POST['cart_id'])){
			if(array_key_exists($_POST['cart_id'], $_SESSION['cart'])){
				array_splice($_SESSION['cart'], $_POST['cart_id'], 1);
				$this->o_Redirect->location('');
			}
		}
	}


	private function checkRequest(){

		if(empty($_POST['product_id'])){
			$this->error = 'Geen product geselecteerd';
		}
		elseif($_POST['product_aantal'] === ''){
			$this->error = 'Geef een aantal op!';
		}
		elseif(!is_numeric($_POST['product_aantal'])){
			$this->error = 'Het aantal moet numeriek zijn';
		}
		elseif($_POST['product_aantal'] < 1){
			$this->error = 'Je kan niet minder dan 1 product bestellen';
		}
		elseif(!ctype_digit($_POST['product_aantal'])){
			$this->error = 'Je mag alleen hele producten kopen, we gaan onze producten niet voor jou door de midden zagen';
		}
		elseif(!$this->o_Producten->product_exists($_POST['product_id'])){
			$this->error = 'Dit product bestaat niet';
		}
		else{
			$this->inCart();
		}

		
	}


	private function valid_aantal($aantal){
		if($aantal !== '' && is_numeric($aantal) && $aantal > 0 && ctype_digit($aantal)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	private function inCart(){
		$id = mysql_real_escape_string($_POST['product_id']);
		$aantal = mysql_real_escape_string($_POST['product_aantal']);
		if($this->checkDupe($id, $aantal) === false){
			$_SESSION['cart'][] = array('id' => $id, 'aantal' => $aantal);
		}
		else{
			$this->addTo($aantal);
		}
		$this->error = 'Het product is succevol aan uw winkel wagen toegevoegd <a href="'.$this->s_root.'winkelmand/">Klik hier</a> om uw winkelmand te bekijken';


	}

	private function checkDupe($id, $aantal){
		$dupe = false;
		foreach ($_SESSION['cart'] as $key => $value) {
			if($value['id'] == $id){
				$this->dupeKey = $key;
				$dupe = true;
			}
		}

		return $dupe;
	}

	private function addTo($aantal){
		if($this->dupeKey !== ''){
			$old = $_SESSION['cart'][$this->dupeKey]['aantal'] += $aantal;
			
		}
	}

	private function cartData(){
		$data = array();

		foreach($_SESSION['cart'] as $key => $value){
			$query = mysql_query("SELECT product_title, product_price FROM producten WHERE product_id = '".mysql_real_escape_string($value['id'])."'");
			$row = mysql_fetch_assoc($query);
			$money = $this->o_Producten->moneyDisplay($row['product_price'], $value['aantal']);
			$data[$key] = array('id' => $value['id'], 'aantal' => $value['aantal'], 'price_int' => $row['product_price'], 'price' => $money, 'title' => $row['product_title']);
		}

		return $data;
	}

	public function getTotals(){
		$data = $this->cartData();
		$totalMoney = 0;
		$aantal = 0;
		$price_int = 0;
		foreach ($data as $key => $value) {
			$totalMoney += ($value['price_int'] * $value['aantal']);
			$price_int+= $value['price_int'] * $value['aantal'];
			$aantal += $value['aantal'];
		}
		$totalMoney = $this->o_Producten->moneyDisplay($totalMoney, 1);

		$totals = array('total_price' => $totalMoney, 'total_items' => $aantal, 'price_int' => $price_int);
		return $totals;
	}

	public function getOrderId(){
		$query = mysql_query("SELECT bestelling_id as id FROM bestellingen ORDER BY bestelling_id DESC LIMIT 1");

		$row = mysql_fetch_assoc($query);
		$new_id = $row['id'] + 1;

		return $new_id;
	}

	private function cartValue($value, $key){
		if($this->type === 'edit'){
			return '<input type="text" name="cart_'.$key.'" class="p_aantal" value="'.$value.'" />';
		}
		else{
			return $value;
		}
	}

	private function checkOut(){
		if($this->type === 'normal'){


			return '		<form id="checkout" action="'.$this->s_root.'winkelmand/Stap1/" method="post">
								<input class="checkout" type="submit" name="verder" value="Verder" />
							</form>	';
		}
		else{
			return '';
		}
	}

	private function delete_btn($key){
		if($this->type === 'normal'){
			return '			<form action="" method="post">
								<input type="hidden" value="'.$key.'" name="cart_id" />
								<input type="image" src="'.$this->s_root.'images/delete.png" name="delete" />
								</form>';
		}
		else{
			return '';
		}
	}

	private function edit_btn(){
		if($this->type === 'normal'){
			return '<input type="submit" name="edit_cart" value="Winkelmand wijzigen" />';

			}
			else{ 
				return '<input type="submit" name="save_cart" value="Wijzigingen opslaan" />';
		}
	}

	public function getCart(){

		$cart = '';

		if(count($_SESSION['cart']) != 0){

			$data = $this->cartData();
			
			foreach ($data as $key => $value) {

				$delete = $this->delete_btn($key);
				$cart.= '<tr>
							<td class="delete_item">
								'.$delete.'
							<td><a href="'.$this->s_root.'product/'.$value['id'].'/">'.$value['title'].'</td>
							<td class="aantal">'.$this->cartValue($value['aantal'], $key).'</td>
							<td class="totaal">&euro;'.$value['price'].'</td>
						</tr>';
			}
		}

			

		
		return $cart;
	}

		public function returnCart(){
			if(count($_SESSION['cart']) != 0){
			$total = $this->getTotals();
			$checkout = $this->checkOut();
			$edit = $this->edit_btn();
			$items = $this->getCart();



			$cart = '
					<table id="winkelmand">
						<tr>
							<th colspan="2" id="artikel">Artikel</th>
							<th id="aantal">Aantal</th>
							<th id="bedrag">Bedrag</th>
						</tr>
							'.$items.'

						<tr>
							<th id="totaal"colspan="4">Totaal</th>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td class="aantal"><strong>'.$total['total_items'].'</strong></td>
							<td class="totaal"><strong>&euro;'.$total['total_price'].'</strong></td>
						</tr>
						</table>

			
							'.$checkout.'
						
						';



				if($this->type === 'normal'){

					$shopcart = '<p>
							<form action="" method="post">
							<input type="submit" name="empty_cart" value="Winkelmand legen"/>
				

							'.$edit.'

							</form>
						
							</p>'.$cart;
					}
					else{
							$shopcart = '<p>
							<form action="" method="post">
				

							'.$edit.'
							</p>
							'.$cart.'
							</form>
						
							';
					}

			}else{

	
					$shopcart = 'U heeft nog geen producten in uw winkelmand';
			}
			

		return $shopcart;
	}

	public function validate_step1(){
		if(isset($_POST['checkout'])){
			$ok = 1;

			foreach($_POST as $key => $value){
				if($key != 'checkout'){
					if($value == ''){
						$ok = 0;
					}
				}
			}

			if($ok == 1){
				$this->insertData();
			}
			else{
				$this->error = 'er zijn nog velden leeg';
			}
		}
	}



	private function bestelde_producten($id){
		if(isset($_SESSION['cart']) && count($_SESSION['cart']) !== 0){
			foreach ($_SESSION['cart'] as $key => $value) {
				$query = mysql_query("INSERT INTO bestelde_producten VALUES ('".$id."', '".$value['id']."', '".$value['aantal']."')");
			}
		}
	}
	private function insertData(){
			foreach($_POST as $key => $value){
				if($key != 'checkout'){
					$value = mysql_real_escape_string($value);
					$v[$key] = $value;
				}
			}

			$query = mysql_query("INSERT INTO klanten VALUES('', 
															'".$v['klant_firstname']."', 
															'".$v['klant_lastname']."', 
															'".$v['klant_postcode']."', 
															'".$v['klant_straat']."',
															'".$v['klant_huisnummer']."',
															'".$v['klant_telefoon']."'
															)") or die(mysql_error());
			$klant_id =  mysql_insert_id();
			$_SESSION['klant_id'] = $klant_id;
			$bestelling = mysql_query("INSERT INTO bestellingen VALUE('',
																	  '".$klant_id."',
																	  NOW())");
			$bestel_id = mysql_insert_id();

			$this->bestelde_producten($bestel_id);

			header("Location: ".$this->s_root.'ideal/step2.php');

			


	}


}

?>