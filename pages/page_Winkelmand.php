<?php

class page_Winkelmand{
	public $title = 'Winkelmand';
	public $content  = 'Winkelmand';
	private $o_Winkelmand;
	private $url;
	private $error = '';
	public function __construct(){
		require 'config.php';
		$this->s_hash = $hash;
		$this->url = new Url;
		$this->o_Winkelmand = new Winkelmand;
		$this->core();

	}

	private function core(){
		if(isset($this->url->var[1]) && $this->url->var[1] === 'stap1'){
			
			$total = $this->o_Winkelmand->getTotals();
			$_SESSION['order'] = array();
			$_SESSION['order']['order_id'] = $this->o_Winkelmand->getOrderId();
			$_SESSION['order']['order_id_hash'] = sha1($this->s_hash.$_SESSION['order']['order_id']);
			$_SESSION['order']['order_description'] = 'Uw bestelling van Rollator Shopppa';
			$_SESSION['order']['order_amount'] = $total['price_int'] / 100;
			$_SESSION['order']['order_amount_hash'] = sha1($this->s_hash.$_SESSION['order']['order_amount']);
			$this->o_Winkelmand->validate_step1();
			$this->error = $this->o_Winkelmand->error;
			if(!isset($_SESSION['order']) || count($_SESSION['order']) == 0 || $_SESSION['order']['order_amount'] == 0){
				$this->content = 'U moet eerst een bestelling plaatsen voordat u verder kunt!';
			}
			else{
				

				$this->displayStap1();
			}
			
			
		}
		else{
			$this->o_Winkelmand->Afrekenen();
			$this->o_Winkelmand->empty_cart(); //Checkt of de gebruiker zijn winkelwagen wilt legen
			$this->o_Winkelmand->delete_cart_id();
			$this->o_Winkelmand->edit_cart();
			$this->o_Winkelmand->save_cart();
			$this->displayWinkelmand();
		}
	}


	private function displayStap1(){
		$this->content = '<p>Vul a.u.b uw gegevens</p>
				'.$this->error.'
				<form action="" method="post" />
				<table>

						<tr>
							<td>Voornaam: </td>
							<td><input type="text" name="klant_firstname" />
						</tr>
						<tr>
							<td>Achternaam: </td>
							<td><input type="text" name="klant_lastname" /></td>
						</tr>
						<tr>
							<td>Postcode: </td>
							<td><input type="text" name="klant_postcode" /></td>
						</tr>
						<tr>
							<td>Straat: </td>
							<td><input type="text" name="klant_straat" /></td>
						</tr>
						<tr>
							<td>Huisnummer: </td>
							<td><input type="text" name="klant_huisnummer" /></td>
						</tr>
						<tr>
							<td>Telefoon: </td>
							<td><input type="text" name="klant_telefoon" /></td>
						</tr>
						<tr>
							<td></td>
							<td><input class="checkout" type="submit" name="checkout" value="Afrekenen" /></td>
						</tr>
				</table>
				</form>
				';
	}

	private function displayWinkelmand(){

		$cart = $this->o_Winkelmand->returnCart();
		$this->content = '
		<h1>Winkelmand</h1>

		'.$cart.'
	';
	}
}

?>