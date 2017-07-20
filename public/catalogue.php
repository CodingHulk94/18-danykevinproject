<?php

require '../inc/config.php';

//Ici, on calcule une fois le nombre total de films disponibles pour déterminer le maximum de pages

$sql='SELECT * FROM movies';

$pdoStatement = $pdo->query($sql);

if($pdoStatement === false){
  print_r($pdo->errorInfo());
}else{
  $filmCount = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
}

$maxPages = count($filmCount)/3;



require'../view/header.php';
require dirname(dirname(__FILE__)).'/view/catalogue.php';

require'../view/footer.php';

 ?>
