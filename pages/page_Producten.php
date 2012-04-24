<?php

class page_Producten{
	public $title = 'Producten pagina';
	public $content;
	private $a_data;
	private $s_root;
	private $o_Cart;
	private $o_Producten;
	public function __construct(){
		require 'config.php';
		$this->o_Cart = new Winkelmand;
		$this->error = $this->o_Cart->error;
		$this->s_root = $root;
		$this->getProducts();
		$this->displayProducten();
	}

	private function getProducts(){
		$this->o_Producten = new Producten;
		$this->o_Producten->getProducts();
		$this->o_Producten->getCats();
		$this->a_data = $this->o_Producten->data;
	}

	private function SortAndFetch(){
		$producten = '';
		foreach($this->a_data['cats'] as $key => $value){
			$items = '';

			foreach($this->a_data['products'] as $k => $v){
				if($v['product_cat'] == $value['categorie_id']){
					$price = $this->o_Producten->moneyDisplay($v['product_price'], 1);
					$items.= '<li>
									<h3 class="title product_title"><a href="'.$this->s_root.'product/'.$v['product_id'].'/">'.$v['product_title'] . '</a></h3>
									<div class="product_img">
										<a href="'.$this->s_root.'product/'.$v['product_id'].'/"><img src="'.$this->s_root.'images/rollators/'.$v['product_img'].'" /></a>
									</div>
									<strong class="center">&euro;'.$price.'</strong>
									<form class="product_option" action="" method="post">
										<input type="hidden" name="product_id" value="'.$v['product_id'].'" />
										Aantal: <input type="text" name="product_aantal" value="1" class="p_aantal" />
										<input type="submit" value="Toevoegen" />
									</form>

							</li>';
				}
			}
			$cat = '<h2 class="cat">'.$value['categorie_title'].'</h2>';
			$producten.= $cat;
			$producten.= '<ul class="product_wrap">'.$items.'</ul>';
		}

		return $producten;
	}

	private function displayProducten(){
		$producten = $this->SortAndFetch();
		$this->content = $this->error.$producten;
	}


}

?>