<?php

class page_404{
	public $title = 'Pagina niet gevonden';
	public $content = 'De pagina die u zoekt bestaat niet!';

	public function __construct(){
		header('HTTP/1.0 404 Not Found');
	}
}

?>