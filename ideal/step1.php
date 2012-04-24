<?php

	// Opvragen van order informatie.
	$sOrderId = rand(1000000, 9999999); // Uniek order ID
	$sOrderDescription = 'Order omschrijving'; // Omschrijving
	$fOrderAmount = rand(100, 99999) / 100; // Bedrag (in decimaal!!)

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>iDEAL - Stap 1: Samenstellen van een order</title>
	</head>
	<body>
		<form action="step2.php" method="post">
			<h1>Uw iDEAL transactie</h1>
			<p><b>Order ID:<br /><input type="text" name="order_id" size="30" value="<?php echo $sOrderId; ?>"><br /><br />Order omschrijving:<br /><textarea rows="8" name="order_description" cols="40"><?php echo $sOrderDescription; ?></textarea><br /><br />Order bedrag:<br /><input name="order_amount" size="30" type="text" value="<?php echo number_format($fOrderAmount, 2, ',', ''); ?>"> (EUR)<br /><br /><br /><input name="_submit" type="submit" value="verder &gt;&gt;"></b></p>
		</form>
	</body>
</html>