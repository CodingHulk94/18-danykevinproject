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
$Validator = 4;


//FILTRES
//Category filter
$sqlcatfilter='SELECT cat_name FROM category';

$pdoCatFilterStatement = $pdo->query($sqlcatfilter);

if($pdoCatFilterStatement === false){
  print_r($pdo->errorInfo());
}else{
  $CatFilterData = $pdoCatFilterStatement->fetchAll(PDO::FETCH_ASSOC);
  print_r($CatFilterData);
}


if(!empty($_GET['category'])){

    $Validator = 5;
    $categorypage = isset($_GET['category']) ? intval($_GET['category']) : '';

    //On redéfinit le maximum de pages pour la catégorie sélectionnée
    $sqlpages='SELECT * FROM movies WHERE category_cat_id = :catid';
    $pdoStatement = $pdo->prepare($sqlpages);
    $pdoStatement->bindValue(':catid', $categorypage);

    if($pdoStatement->execute() === false){
        print_r($pdo->errorInfo());
    }else{
        $filmCount = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    $maxPages = count($filmCount)/3;

}




require'../view/header.php';
require dirname(dirname(__FILE__)).'/view/catalogue.php';

require'../view/footer.php';

 ?>
