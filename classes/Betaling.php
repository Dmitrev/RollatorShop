<?php
class Betaling{
	public $content = 'Ongeldige transactie ID';
	public $id = '';
	public function __construct(){
		require 'config.php';
		$this->hash = $hash;
		$this->root = $root;

		$this->producten = new Producten;
		$this->url = new Url;
	}

	public function check_ID(){
		if(isset($this->url->var[1]) && $this->url->var[1] !== ''){
			if($this->valid_id()){
				$this->content = $this->print_betaling();
			}
		}
		else{
			return FALSE;
		}
	}

	public function print_betaling(){
		$klant = $this->klant_gegevens();
		$bestelling = $this->bestelling();
		return '<h2>Uw Gegevens: </h2>'
			.$klant.
			'<h2>Uw bestelling: </h2>'.
			$bestelling ;

	}
	private function bestelling(){
		$data = array();
		$product = '';
		$data['items'] = 0;
		$data['total'] = 0;
		$query = mysql_query("SELECT bestelde_producten.product_aantal, producten.product_title, producten.product_price FROM bestellingen 
							JOIN bestelde_producten ON bestellingen.bestelling_id = bestelde_producten.bestelling_id 
							JOIN producten ON bestelde_producten.product_id = producten.product_id 
							WHERE klant_id = '".$_SESSION['klant_id']."'") or die(mysql_error());
		while($row = mysql_fetch_assoc($query)){
			$row['p_total'] = $this->producten->moneyDisplay($row['product_price'], $row['product_aantal']);
			$data['total'] += ($row['product_price'] * $row['product_aantal']);
			$data['items'] += $row['product_aantal'];

			$product.= '<tr>
						<td class="delete_item"></td>
						<td>'.$row['product_title'].'</td>
						<td class="aantal">'.$row['product_aantal'].'</td>
						<td class="totaal">&euro;'.$row['p_total'].'</td>
			</tr>';
		}

		return '<table id="winkelmand">
						<tr>
							<th colspan="2" id="artikel">Artikel</th>
							<th id="aantal">Aantal</th>
							<th id="bedrag">Bedrag</th>
						</tr>
							'.$product.'
						<tr>
							<th id="totaal"colspan="4">Totaal</th>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td class="aantal"><strong>'.$data['items'].'</strong></td>
							<td class="totaal"><strong>&euro;'.$this->producten->moneyDisplay($data['total'], 1).'</strong></td>
						</tr>
	
				</table>
					<div>
							<a href="'.$this->root.'tnx/" class="checkout_link">Bestelling afronden</a>
					</div>';
		
	}

	private function klant_gegevens(){
		$get_klant = mysql_query("SELECT * FROM klanten WHERE klant_id = '".$_SESSION['klant_id']."'");
		$row = mysql_fetch_assoc($get_klant);
		foreach ($row as $key => $value) {
			htmlspecialchars($value);
		}

		return '<table>
			<tr>
				<td>Voornaam: </td>
				<td><strong>'.$row['klant_firstname'].'</strong></td>
			</tr>
			<tr>
				<td>Achternaam: </td>
				<td><strong>'.$row['klant_lastname'].'</strong></td>
			</tr>
			<tr>
				<td>Postcode: </td>
				<td><strong>'.$row['klant_postcode'].'</strong></td>
			</tr>
			<tr>
				<td>Adres: </td>
				<td><strong>'.$row['klant_straat'].' '.$row['klant_huisnummer'].'</strong></td>
			</tr>
			<tr>
				<td>Telefoon: </td>
				<td><strong>'.$row['klant_telefoon'].'</strong></td>
			</tr>

		</table>';

		
	}
	private function valid_id(){
		if(!isset($_SESSION['Transactie_id']) || !isset($_SESSION['klant_id'])){
			return false;
		}
		else{
			$query = mysql_query("SELECT bestelling_id FROM bestellingen WHERE klant_id = '".$_SESSION['klant_id']."'");
			$row = mysql_fetch_assoc($query);
			$this->id = sha1($this->hash.$row['bestelling_id']);
			if($this->id === $_SESSION['Transactie_id']){
				return true;
			}
			else{
				return false;
			}
		}
	}
}

?>