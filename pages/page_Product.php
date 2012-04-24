<?php

class page_Product{

public $title = 'Geen product gevonden';
public $content = 'Meer info over dit product';
private $producten;
private $url;
private $product_id;
private $s_root;
private $tr;
private $error = '';
private $winkelmand;
	public function __construct(){
		require 'config.php';
		$this->s_root = $root;
		$this->winkelmand = new Winkelmand;
		$this->error = '<p>'.$this->winkelmand->error.'</p>';
		$this->tr = new Text_replace;
		$this->producten = new Producten;
		$this->url = new Url;
		$this->checkUrl();
	}

	public function checkUrl(){
		if(!isset($this->url->var[1]) || $this->url->var[1] === ''){
			$this->content = 'geen product';
		}
		elseif(!is_numeric($this->url->var[1])){
			$this->content = 'Geen geldig product';
		}
		elseif(!$this->producten->product_exists($this->url->var[1])){
			$this->content = 'Dit product bestaat niet!!';
		}
		else{
			$this->product_id = $this->url->var[1];

			$this->getProductInfo();
		}
	}

	private function getProductInfo(){
		$this->product = $this->producten->getProduct($this->product_id);
		$this->title = $this->product['product_title'];
		$this->display();
	}

	private function display(){
		$this->content = '
			'.$this->error.'
			<div class="product_info_top">

				<div class="product_info_img">

					<img src="'.$this->s_root.'images/rollators/'.$this->product['product_img'].'" alt="'.$this->product['product_title'].'" title="'.$this->product['product_title'].'" />
				</div> 

				<div class="product_info_desc">
				<a href="'.$this->s_root.'producten/">Terug naar de producten pagina</a>
					<h1>'.$this->product['product_title'].'</h1>

					<div class="cart_options">
						Prijs: &euro;'.$this->producten->moneyDisplay($this->product['product_price'], 1).'
						<form action="" method="post">
							<input type="text" class="p_aantal" name="product_aantal" value="1" />
							<input type="hidden" name="product_id" value="'.$this->product['product_id'].'" />
							<input type="submit" value="Toevoegen aan winkelwagen" />
						</form>
					</div>
					<h2>Beschrijving</h2>
					'.$this->tr->forumPost($this->product['product_desc']).'

				</div>
			</div>

			<div class="product_info_bottom">
			</div>
		';
	}



}

?>