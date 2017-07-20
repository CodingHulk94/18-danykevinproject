<?php
require'../../inc/config.php';

if(!empty($_POST)){
    $pageajax = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // JE calcule l'offset correspondant à la page

    $offset = $pageajax * 3 - 3;

    $sql = 'SELECT *
    FROM movies
    LIMIT 3
    OFFSET '.$offset.'';

    $ResultSet = $pdo->query($sql);


    if($ResultSet === false){
      print_r($pdo->errorInfo());
    }else{
      $AllResults = $ResultSet->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($AllResults, JSON_PRETTY_PRINT);
    }

}













?>
