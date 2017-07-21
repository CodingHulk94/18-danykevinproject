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
$wordSearch = '';


//FILTRES
//Category filter
// $sqlcatfilter='SELECT cat_name FROM category';
//
// $pdoCatFilterStatement = $pdo->query($sqlcatfilter);
//
// if($pdoCatFilterStatement === false){
//   print_r($pdo->errorInfo());
// }else{
//   $CatFilterData = $pdoCatFilterStatement->fetchAll(PDO::FETCH_ASSOC);
//   print_r($CatFilterData);
// }


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


if (!empty($_GET['motrecherche'])) {
    $Validator = 6;

    $wordSearch = isset($_GET['motrecherche']) ? strip_tags(trim($_GET['motrecherche'])) : '';

    $sql = 'SELECT *
    FROM movies
    INNER JOIN category ON category_cat_id = cat_id
    WHERE mov_title LIKE :word
    OR mov_synopsis LIKE :word
    OR cat_name LIKE :word';

    $pdoStatement = $pdo->prepare($sql);

    $pdoStatement->bindValue(':word', "%{$wordSearch}%");

    if ($pdoStatement->execute() === false ) {
        print_r($pdoStatement->errorInfo());
    }
    else {
        $filmCount = $pdoStatement->fetchall(PDO::FETCH_ASSOC);
    }
    $maxPages = count($filmCount)/3;
}




require'../view/header.php';
require dirname(dirname(__FILE__)).'/view/catalogue.php';

require'../view/footer.php';

 ?>
