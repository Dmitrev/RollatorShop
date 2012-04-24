<?php
require 'config.php';
$connect = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());

?>