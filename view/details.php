<section id="detailmainsection">
    <article id="detailsectionleft">
        <img src="<?=$ResultSet['mov_image']?>">
        <div class="">
            <h5>Sortie en <?=$ResultSet['mov_year']?><h5>
            <h5>Support: <?=$ResultSet['sup_device']?></h5>
        </div>
    </article>
    <article id="detailsectionright">
        <section id="detailtitlecategory">
            <h3><?=$ResultSet['mov_id']?>. <?=$ResultSet['mov_title']?></a></h3>
            <h3>Category</h3>
            <p><?=$ResultSet['cat_name']?></p>
        </section>
        <section id="detaildescription">
            <h3>Storyline</h3>
            <p><?=$ResultSet['mov_synopsis']?></p>
            <h3>Actors</h3>
            <p><?=$ResultSet['mov_actors']?></p>
            <p><a href="<?=$ResultSet['mov_path']?>" target="_blank">Click here to watch!</a></p>
        </section>
    </article>
</section>
