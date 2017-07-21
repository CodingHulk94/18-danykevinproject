<form class="" action="catalogue.php" method="get">
    <input type="text" name="motrecherche" value="" placeholder="Recherche...">
    <button type="submit" name="">OK</button>
</form>
<ul id="films_per_category">
    <?php foreach($Result as $key => $value) : ?>
        <li><a href="catalogue.php?category=<?=$value['cat_id']?>"><?=$value['cat_name']?> (<?=$value['nbmov']?>)</a></li>
    <?php endforeach; ?>
</ul>
<?php foreach ($lastMovies as $key => $value) : ?>
    <div class="">
        <img src="<?=$value['mov_image']?>" alt="">
        <!-- <h3><?=$value['mov_title']?></h3> -->
        <a href='details.php?movieID=<?=$value['mov_id']?>'><h3><?=$value['mov_title']?></h3></a>
    </div>
<?php endforeach; ?>
