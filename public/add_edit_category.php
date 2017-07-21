<?php

require '../inc/config.php';

// Récupérer toutes les catégories
$sql = "SELECT *
        FROM category
        ORDER BY cat_name ASC
        ";

$pdoStatement = $pdo->query($sql);

if ($pdoStatement === false) {
	print_r($pdo->errorInfo());
}
else {
	$categoryList = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
}


$successList = array();

// AJOUT/MODIF CATEGORIE
if (!empty($_POST)) {

    $categoryName = isset($_POST['categoryName']) ? strip_tags(trim($_POST['categoryName'])) : '';

    // si un id a été envoyé alors requête de modif
    if (!empty($_POST['categoryID'])) {
        $editCategoryID = isset($_POST['categoryID']) ? intval($_POST['categoryID']) : 0;

        $sql = "UPDATE category
                SET cat_name = :category
                WHERE cat_id = :categoryID";

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':category', $categoryName, PDO::PARAM_STR);
        $pdoStatement->bindValue(':categoryID', $editCategoryID, PDO::PARAM_INT);

    }
    // sinon requête d'ajout
    else {
        $sql = "INSERT INTO category (cat_name)
                VALUES (:category)";

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':category', $categoryName, PDO::PARAM_STR);
    }

    if ($pdoStatement->execute() === false ) {
    	print_r($pdoStatement->errorInfo());
    }
    else {
        if (!empty($_POST['categoryID'])) {
            $successList[] = "La catégorie a été modifiée !";
        }
        else {
            $successList[] = "La catégorie a été ajoutée !";
        }
    }
}


require'../view/header.php';
require dirname(dirname(__FILE__)).'/view/add_edit_category.php';

require'../view/footer.php';

 ?>
