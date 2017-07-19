<?php
$dsn = "mysql:dbname={$config['db_database']};host={$config['db_host']};charset=UTF8";

try {
	$pdo = new PDO($dsn, $config['db_user'], $config['db_password']);
}
catch (Exception $e) {
	echo $e->getMessage();
}


 ?>
