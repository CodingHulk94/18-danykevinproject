<?php

require '../inc/config.php';

if(!empty($_GET['movieID'])){
    $movieID = isset($_GET['movieID']) ? strip_tags(trim($_GET['movieID'])) : '';

    $sql = 'SELECT *
    FROM movies
    INNER JOIN category ON category_cat_id = cat_id
    INNER JOIN support ON support_sup_id = sup_id
    WHERE mov_id = :movid';
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':movid', $movieID);

    if($pdoStatement->execute() === false){
        print_r($pdoStatement->errorInfo());
    }
    else{
        $ResultSet = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    }
}










require'../view/header.php';
require dirname(dirname(__FILE__)).'/view/details.php';

require'../view/footer.php';

 ?>
