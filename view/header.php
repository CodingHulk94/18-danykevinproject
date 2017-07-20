<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Header</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="add_edit_category.php">Catégories</a></li>
                    <li><a href="add_edit_movie.php">Ajouter un film</a></li>
                </ul>
                <form class="" action="catalogue.php" method="get">
                    <input type="text" name="motrecherche" value="" placeholder="Recherche...">
                    <button type="submit" name="">OK</button>
                </form>
            </nav>
        </header>
        <main>
