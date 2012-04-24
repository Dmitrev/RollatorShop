<?php

function __autoload($class){
	$file = $class.'.php';

	if(preg_match('/^(page_)/', $file)){
		$dir = 'pages/';
	}
	else{
		$dir = 'classes/';
	}


	if(file_exists($dir.$file)){
		require $dir.$file;
	}
	else{
		//die('Class: '. $file. ' Niet gevonden');
	}
}

?>