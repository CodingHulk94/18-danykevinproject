<?php
require'../../inc/config.php';

if(!empty($_POST)){
    //On récupère la valeur envoyée par data dans la requête ajax.
    $pageajax = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $validatorvalue = isset($_POST['validator']) ? intval($_POST['validator']) : 4;
    $wordSearch = isset($_POST['motrecherche']) ? strip_tags(trim($_POST['motrecherche'])) : '';
    $categoryID = isset($_POST['categoryID']) ? intval($_POST['categoryID']) : 0;
    $CategoryFilter = isset($_POST['filter']) ? intval($_POST['filter']) : 0;
    $DateFilter = isset($_POST['datefilter']) ? intval($_POST['datefilter']) : 1;
    // JE calcule l'offset correspondant à la page

    $offset = $pageajax * 3 - 3;

    //Requête
    if($DateFilter === 1){
      if($CategoryFilter === 0){
          if($validatorvalue === 4){

              $sql = 'SELECT *
              FROM movies
              LEFT OUTER JOIN (
                  SELECT COUNT(*) AS filmtotal FROM movies
              ) AS T ON filmtotal > 0
              ORDER BY mov_add_date DESC
              LIMIT 3
              OFFSET '.$offset.'';

          }
          else if($validatorvalue === 5){
              $sql = 'SELECT *
              FROM movies
              LEFT OUTER JOIN (
                  SELECT COUNT(*) AS filmtotal FROM movies WHERE category_cat_id = :catid
              ) AS T ON filmtotal > 0
              WHERE category_cat_id = :catid
              ORDER BY mov_add_date DESC
              LIMIT 3
              OFFSET '.$offset.'';

              $pdoStatement = $pdo->prepare($sql);

              $pdoStatement->bindValue(':catid', $categoryID);

              if ($pdoStatement->execute() === false ) {
                  print_r($pdoStatement->errorInfo());
              }
              else {
                  $AllResults = $pdoStatement->fetchall(PDO::FETCH_ASSOC);
                  echo json_encode($AllResults, JSON_PRETTY_PRINT);
                  // print_r($AllResults);
              }

          }
          else if ($validatorvalue === 6){
              $sql = 'SELECT *
              FROM movies
              INNER JOIN category ON category_cat_id = cat_id
              LEFT OUTER JOIN (
                  SELECT COUNT(*) AS filmtotal
                  FROM movies
                  INNER JOIN category ON category_cat_id = cat_id
                  WHERE mov_title LIKE :word
                  OR mov_synopsis LIKE :word
                  OR cat_name LIKE :word
              ) AS T ON filmtotal > 0
              WHERE mov_title LIKE :word
              OR mov_synopsis LIKE :word
              OR cat_name LIKE :word
              ORDER BY mov_add_date DESC
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

          if($validatorvalue !== 5 && $validatorvalue !== 6){

              $ResultSet = $pdo->query($sql);


              if($ResultSet === false){
                  print_r($pdo->errorInfo());
              }else{
                  $AllResults = $ResultSet->fetchAll(PDO::FETCH_ASSOC);
                  echo json_encode($AllResults, JSON_PRETTY_PRINT);
              }

          }
      }
      else{
          $sql = 'SELECT *
          FROM movies
          LEFT OUTER JOIN (
              SELECT COUNT(*) AS filmtotal FROM movies WHERE category_cat_id = :catfilter
          ) AS T ON filmtotal > 0
          WHERE category_cat_id = :catfilter
          ORDER BY mov_add_date ASC
          LIMIT 3
          OFFSET '.$offset.'';

          $pdoStatement = $pdo->prepare($sql);

          $pdoStatement->bindValue(':catfilter', $CategoryFilter);

          if ($pdoStatement->execute() === false ) {
              print_r($pdoStatement->errorInfo());
          }
          else {
              $AllResults = $pdoStatement->fetchall(PDO::FETCH_ASSOC);
              echo json_encode($AllResults, JSON_PRETTY_PRINT);
              // print_r($AllResults);
          }

      }
    }
    else if($DateFilter === 2){
      if($CategoryFilter === 0){
          if($validatorvalue === 4){

              $sql = 'SELECT *
              FROM movies
              LEFT OUTER JOIN (
                  SELECT COUNT(*) AS filmtotal FROM movies
              ) AS T ON filmtotal > 0
              ORDER BY mov_add_date ASC
              LIMIT 3
              OFFSET '.$offset.'';

          }
          else if($validatorvalue === 5){
              $sql = 'SELECT *
              FROM movies
              LEFT OUTER JOIN (
                  SELECT COUNT(*) AS filmtotal FROM movies WHERE category_cat_id = :catid
              ) AS T ON filmtotal > 0
              WHERE category_cat_id = :catid
              ORDER BY mov_add_date ASC
              LIMIT 3
              OFFSET '.$offset.'';

              $pdoStatement = $pdo->prepare($sql);

              $pdoStatement->bindValue(':catid', $categoryID);

              if ($pdoStatement->execute() === false ) {
                  print_r($pdoStatement->errorInfo());
              }
              else {
                  $AllResults = $pdoStatement->fetchall(PDO::FETCH_ASSOC);
                  echo json_encode($AllResults, JSON_PRETTY_PRINT);
                  // print_r($AllResults);
              }

          }
          else if ($validatorvalue === 6){
              $sql = 'SELECT *
              FROM movies
              INNER JOIN category ON category_cat_id = cat_id
              LEFT OUTER JOIN (
                  SELECT COUNT(*) AS filmtotal
                  FROM movies
                  INNER JOIN category ON category_cat_id = cat_id
                  WHERE mov_title LIKE :word
                  OR mov_synopsis LIKE :word
                  OR cat_name LIKE :word
              ) AS T ON filmtotal > 0
              WHERE mov_title LIKE :word
              OR mov_synopsis LIKE :word
              OR cat_name LIKE :word
              ORDER BY mov_add_date ASC
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

          if($validatorvalue !== 5 && $validatorvalue !== 6){

              $ResultSet = $pdo->query($sql);


              if($ResultSet === false){
                  print_r($pdo->errorInfo());
              }else{
                  $AllResults = $ResultSet->fetchAll(PDO::FETCH_ASSOC);
                  echo json_encode($AllResults, JSON_PRETTY_PRINT);
              }

          }
      }
      else{
          $sql = 'SELECT *
          FROM movies
          LEFT OUTER JOIN (
              SELECT COUNT(*) AS filmtotal FROM movies WHERE category_cat_id = :catfilter
          ) AS T ON filmtotal > 0
          WHERE category_cat_id = :catfilter
          ORDER BY mov_add_date ASC
          LIMIT 3
          OFFSET '.$offset.'';

          $pdoStatement = $pdo->prepare($sql);

          $pdoStatement->bindValue(':catfilter', $CategoryFilter);

          if ($pdoStatement->execute() === false ) {
              print_r($pdoStatement->errorInfo());
          }
          else {
              $AllResults = $pdoStatement->fetchall(PDO::FETCH_ASSOC);
              echo json_encode($AllResults, JSON_PRETTY_PRINT);
              // print_r($AllResults);
          }

      }
    }
}


// RECHERCHE DE FILMS










?>
