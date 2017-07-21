<form class="" action="catalogue.php" method="get">
    <input type="text" name="motrecherche" value="" placeholder="Recherche...">
    <button type="submit" name="">OK</button>
</form>
<ul id="films_per_category">
    <?php foreach($Result as $key => $value) : ?>
        <li><a href="catalogue.php?category=<?=$value['cat_id']?>"><?=$value['cat_name']?> (<?=$value['nbmov']?>)</a></li>
    <?php endforeach; ?>
</ul>
