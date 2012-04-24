<?php

class Page{
	
	private $s_title;
	private $s_content;
	private $s_root;

	public function setPageTitle($title){
		require 'config.php';
		$this->s_root = $root;
		$this->s_title = $title;
	}

	public function setPageContent($content){
		$this->s_content = $content;
	}

	public function displayPage(){
		echo '<!Doctype html>
				<html>
					<head>
	                    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
						<title>'.$this->s_title.' | Rollator Shoppa</title>
						<link rel="stylesheet" href="'.$this->s_root.'styles/style.css" type="text/css" media="screen" />
						<link rel="shortcut icon" href="'.$this->s_root.'images/favicon.png" />
					</head>
					<body>
						<div id="fullheader">
							<div id="header">
								<img id="logo" src="'.$this->s_root.'images/logo2.png" alt="logo" />
								<img id="doekoe" src="'.$this->s_root.'images/doekoe.png" alt="Veillig doekoe pasen met je plastic" />
							</div>
						</div>
						<div id="fullnav">
							<ul>
								<li><a href="'.$this->s_root.'">Home</a></li>
								<li><a href="'.$this->s_root.'producten/">Producten</a></li>
								<li><a href="'.$this->s_root.'winkelmand">Winkelmand</a></li>
								<li><a href="'.$this->s_root.'contact/">Contact</a></li>
								<li><a href="'.$this->s_root.'bezorging">Bezorging</a></li>	
								<li><a href="'.$this->s_root.'algemene_voorwaarden/">Algemene voorwaarden</a></li>

							</ul>
						</div>

						<div id="wrapper">
							'.$this->s_content.'
						</div>
						<div id="footer">
							&copy; Dmitri Chebotarev 2011-2012 (Dmitri.nl)
						</div>
					</body>
				</html>';
	}
}

?>