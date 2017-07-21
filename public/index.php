<?php

require '../inc/config.php';

//Nombre de films par catégories

$sql = 'SELECT cat_name, COUNT(mov_id) AS nbmov, cat_id FROM movies
INNER JOIN category ON category_cat_id = cat_id
GROUP BY cat_name';

$pdoStatement = $pdo->query($sql);

if($pdoStatement === false){
    print_r($pdo->errorInfo());
}
else{
    $Result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
}






require'../view/header.php';
require dirname(dirname(__FILE__)).'/view/home.php';

require'../view/footer.php';

 ?>
