<?php

class Redirect{
	private $s_sitehost;
	private $s_root;
	public function __construct(){

		require 'config.php';
		$this->s_sitehost = $site_host;
		$this->s_root = $root;

	}

	public function location($location){
		$currentPage = $this->currentLocation();
		if($location === ''){
			$redirect = $currentPage;
		}
		else{
			$redirect = $this->s_root.$location;
		}
		header('location: '.$redirect);
	}

	private function currentLocation(){
		$location = $this->s_sitehost.$_SERVER['REQUEST_URI'];
		return $location;
	}
}

?>