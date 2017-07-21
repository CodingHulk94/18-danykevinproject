<?php

require '../inc/config.php';

//Définition de variables
$Validator = 4;
$wordSearch = '';
$phraseRecherche = '';
$categorypageID = 0;


//Ici, on calcule une fois le nombre total de films disponibles pour déterminer le maximum de pages
// $sql='SELECT * FROM movies';
//
// $pdoStatement = $pdo->query($sql);
//
// if($pdoStatement === false){
//   print_r($pdo->errorInfo());
// }else{
//   $filmCount = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
// }
//
// $maxPages = count($filmCount)/3;


//FILTRES
//Category filter
 $sqlcatfilter='SELECT * FROM category';

 $pdoCatFilterStatement = $pdo->query($sqlcatfilter);

 if($pdoCatFilterStatement === false){
   print_r($pdo->errorInfo());
 }else{
   $CatFilterData = $pdoCatFilterStatement->fetchAll(PDO::FETCH_ASSOC);
 }



//Catégories
if(!empty($_GET['category'])){

    $Validator = 5;
    $categorypageID = isset($_GET['category']) ? intval($_GET['category']) : 0;

    //On redéfinit le maximum de pages pour la catégorie sélectionnée depuis l'accueil
    // $sqlpages='SELECT * FROM movies WHERE category_cat_id = :catid';
    // $pdoStatement = $pdo->prepare($sqlpages);
    // $pdoStatement->bindValue(':catid', $categorypageID);
    //
    // if($pdoStatement->execute() === false){
    //     print_r($pdo->errorInfo());
    // }else{
    //     $filmCount = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    // }
    //
    // $maxPages = count($filmCount)/3;

}


if (!empty($_GET['motrecherche'])) {
    $Validator = 6;

    $wordSearch = isset($_GET['motrecherche']) ? strip_tags(trim($_GET['motrecherche'])) : '';

    //On aurait pu faire ça avec Ajax (Phrase recherche)
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

    // Calculer le nombre de résultats trouvés
    $numberOfResults = 0;
    foreach ($filmCount as $key => $value) {
        $numberOfResults += 1;
    }
    $phraseRecherche = $numberOfResults.' résultat(s) trouvé(s)';
}




require'../view/header.php';
require dirname(dirname(__FILE__)).'/view/catalogue.php';

require'../view/footer.php';

 ?>
