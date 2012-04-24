<?php
	require '../config.php';
	session_start();

	function valid_post($hash){
		$order_id_hashed = sha1($hash.$_SESSION['order']['order_id']);
		$order_amount_hashed = sha1($hash.$_SESSION['order']['order_amount']);

		if($_SESSION['order']['order_id_hash'] === $order_id_hashed && $_SESSION['order']['order_amount_hash'] === $order_amount_hashed){
			return true;
		}
		else{
			return false;
		} 		
	}
	if(valid_post($hash)){


		// Set default timezone for DATE/TIME functions
		if(function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('Europe/Amsterdam');
		}

		include(dirname(__FILE__) . '/library/ideallite.cls.php');

		$sOrderId = (empty($_SESSION['order']['order_id']) ? '' : $_SESSION['order']['order_id']);
		$sOrderDescription = (empty($_SESSION['order']['order_description']) ? '' : $_SESSION['order']['order_description']); // Upto 32 characters
		$fOrderAmount = floatval(empty($_SESSION['order']['order_amount']) ? '' : str_replace(',', '.', $_SESSION['order']['order_amount'])); 
		$oIdeal = new IdealLite();

		$sCurrentUrl = strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/')) . '://' . $_SERVER['SERVER_NAME'] . '/') . substr($_SERVER['SCRIPT_NAME'], 1);
		$sReturnUrl = substr($sCurrentUrl, 0, strrpos($sCurrentUrl, '/') + 1) . 'step3.php';

		// Set shop details
		$oIdeal->setUrlCancel($sReturnUrl . '?ideal[order]=' . urlencode($sOrderId) . '&ideal[status]=cancel');
		$oIdeal->setUrlError($sReturnUrl . '?ideal[order]=' . urlencode($sOrderId) . '&ideal[status]=error');
		$oIdeal->setUrlSuccess($sReturnUrl . '?ideal[order]=' . urlencode($sOrderId) . '&ideal[status]=success');

		// Set order details
		$oIdeal->setAmount($fOrderAmount);
		$oIdeal->setOrderId($sOrderId);
		$oIdeal->setOrderDescription($sOrderDescription);

		// Customize submit button
		$oIdeal->setButton('Doekoe pasen met iDEAL');

		// Generate form
		echo '<p>Uw bestelling afrekenen!</p>' . $oIdeal->createForm();
	}
	else{
		echo 'Er is een fout opgetreden, probeer het opnieuw';
	}

?>