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

// Récupérer tous les support de stockage
$sql = "SELECT *
        FROM support
        ";

$pdoStatement = $pdo->query($sql);

if ($pdoStatement === false) {
	print_r($pdo->errorInfo());
}
else {
	$supportList = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
}


// tableaux pour les messages d'erreurs et succès
$errorList = array();
$successList = array();

// AJOUT D'UN NOUVEAU FILM
// formulaire soumis
if (!empty($_POST)) {

    // id du film à modifier
    $editMovieID = isset($_POST['movieID']) ? strip_tags(trim($_POST['movieID'])) : 0;

    $movieTitle = isset($_POST['title']) ? strip_tags(trim($_POST['title'])) : '';
	$movieActors = isset($_POST['actors']) ? strip_tags(trim($_POST['actors'])) : '';
	// htmlentities-ENT_QUOTES pour enlever les guillemets
	$movieSynopsis = isset($_POST['synopsis']) ? strip_tags(trim(htmlentities($_POST['synopsis'], ENT_QUOTES))) : '';
	$movieYear = isset($_POST['year']) ? strip_tags(trim($_POST['year'])) : '';
    $movieCategory = isset($_POST['categoryID']) ? strip_tags(trim($_POST['categoryID'])) : '';
	$supportDevice = isset($_POST['supportID']) ? strip_tags(trim($_POST['supportID'])) : '';
	$moviePath = isset($_POST['path']) ? strip_tags(trim($_POST['path'])) : '';

    $formValide = true;

    if (empty($movieTitle)) {
        $errorList[] = "Veuillez renseigner le nom du film<br>";
        $formValide = false;
    }
    else if (strlen($movieTitle) < 4) {
        $errorList[] = "Le nom du film doit contenir au moins 4 caractères<br>";
        $formValide = false;
    }
    if (empty($movieActors)) {
        $errorList[] = "Veuillez renseigner les acteurs<br>";
        $formValide = false;
    }
    else if (strlen($movieActors) < 5) {
        $errorList[] = "Le champ des acteurs doit contenir au moins 5 caractères<br>";
        $formValide = false;
    }
    if (empty($movieSynopsis)) {
        $errorList[] = "Veuillez renseigner le synopsis<br>";
        $formValide = false;
    }
    else if (strlen($movieSynopsis) < 5) {
        $errorList[] = "Le synopsis doit contenir au moins 5 caractères<br>";
        $formValide = false;
    }
    if (empty($movieYear)) {
        $errorList[] = "Veuillez renseigner l'année de sortie du film'<br>";
        $formValide = false;
    }
    if (empty($movieCategory)) {
        $errorList[] = "Veuillez renseigner la catégorie du film'<br>";
        $formValide = false;
    }
    if (empty($supportDevice)) {
        $errorList[] = "Veuillez renseigner le support de stockage du film'<br>";
        $formValide = false;
    }
    if (empty($moviePath)) {
        $errorList[] = "Veuillez renseigner le chemin absolu vers le film'<br>";
        $formValide = false;
    }


else if ($formValide) {
    if ($editMovieID == 0) {
        $sql = "INSERT INTO movies (mov_title, mov_actors, mov_synopsis, mov_path, mov_year, support_sup_id, category_cat_id)
                VALUES (:title, :actors, :synopsis, :moviePath, :year, :supportID, :categoryID)";
                // , mov_image
                // , :image
    }
    else {
        $sql = "UPDATE movies
                SET mov_title = :title,
                mov_actors = :actors,
                mov_synopsis = :synopsis,
                mov_path = :moviePath,
                mov_year = :year,
                support_sup_id = :supportID,
                category_cat_id = :categoryID
                WHERE mov_id = $movieID";
    }

    $pdoStatement = $pdo->prepare($sql);

    $pdoStatement->bindValue(':title', $movieTitle, PDO::PARAM_STR);
    $pdoStatement->bindValue(':actors', $movieActors, PDO::PARAM_STR);
    // $pdoStatement->bindValue(':image', $studentBirhtdate);
    $pdoStatement->bindValue(':synopsis', $movieSynopsis, PDO::PARAM_STR);
    $pdoStatement->bindValue(':moviePath', $moviePath);
    $pdoStatement->bindValue(':year', $movieYear, PDO::PARAM_INT);
    $pdoStatement->bindValue(':supportID', $supportDevice, PDO::PARAM_INT);
    $pdoStatement->bindValue(':categoryID', $movieCategory, PDO::PARAM_INT);

    if ($pdoStatement->execute() === false ) {
    	print_r($pdoStatement->errorInfo());
    }
    else {
        $successList[] = "Votre film a été ajouté !";
    }

    $lastMovieID = $pdo->lastInsertId();

    // header('Location: details.php?MovieID='.$lastMovieID);
    // exit;
  }
}


// MODIFICATION D'UN FILM
// Je récupère toutes les données du film à modifier
if (!empty($_GET['editID'])) {
    $movieID = isset($_GET['editID']) ? strip_tags(trim($_GET['editID'])) : '';

    $sql = "SELECT *
            FROM movies
            WHERE mov_id = :movieID";

    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':movieID', $movieID);

    if ($pdoStatement->execute() === false ) {
        print_r($pdoStatement->errorInfo());
    }
    else {
        $movieResult = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        print_r($movieResult);
    }
}

// SUPPRIMER UN FILM
if (!empty($_GET['movieDeleteID'])) {
    $movieDeleteID = $_GET['movieDeleteID'];

    $sql = "DELETE FROM movies
            WHERE mov_id = :deleteID";

    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':deleteID', $movieDeleteID);

    if ($pdoStatement->execute() === false ) {
        print_r($pdoStatement->errorInfo());
    }
}


require'../view/header.php';
require dirname(dirname(__FILE__)).'/view/add_edit_movie.php';

require'../view/footer.php';

 ?>
