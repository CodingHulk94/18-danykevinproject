<?php
require'../../inc/config.php';

if(!empty($_POST)){
    //On récupère la valeur envoyée par data dans la requête ajax.
    $pageajax = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $validatorvalue = isset($_POST['validator']) ? intval($_POST['validator']) : 4;
    $wordSearch = isset($_POST['motrecherche']) ? strip_tags(trim($_POST['motrecherche'])) : '';

    // JE calcule l'offset correspondant à la page

    $offset = $pageajax * 3 - 3;

    //Requête
    if($validatorvalue === 4){

        $sql = 'SELECT *
        FROM movies
        LIMIT 3
        OFFSET '.$offset.'';

    }
    else if($validatorvalue === 5){
        $sql = 'SELECT *
        FROM movies
        WHERE category_cat_id = 2
        LIMIT 3
        OFFSET '.$offset.'';
    }
    else if ($validatorvalue === 6){
        $sql = 'SELECT *
        FROM movies
        INNER JOIN category ON category_cat_id = cat_id
        WHERE mov_title LIKE :word
        OR mov_synopsis LIKE :word
        OR cat_name LIKE :word
        LIMIT 3
        OFFSET '.$offset.'';

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':word', "%{$wordSearch}%");

        if ($pdoStatement->execute() === false ) {
            print_r($pdoStatement->errorInfo());
        }
        else {
            $AllResults = $pdoStatement->fetchall(PDO::FETCH_ASSOC);
            echo json_encode($AllResults, JSON_PRETTY_PRINT);
            // print_r($AllResults);
        }

        // Calculer le nombre de résultats trouvés
        $numberOfResults = 0;
        foreach ($AllResults as $key => $value) {
            $numberOfResults += 1;
        }
        $phraseRecherche = $numberOfResults.' résultat(s) trouvé(s)';
    }

    if($validatorvalue !== 6){

        $ResultSet = $pdo->query($sql);


        if($ResultSet === false){
            print_r($pdo->errorInfo());
        }else{
            $AllResults = $ResultSet->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($AllResults, JSON_PRETTY_PRINT);
        }

    }
}


// RECHERCHE DE FILMS










?>
