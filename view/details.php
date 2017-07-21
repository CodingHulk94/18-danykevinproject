<section id="detailmainsection">
    <article id="detailsectionleft">
        <img src="<?=$ResultSet['mov_image']?>">
        <h5>Sortie en <?=$ResultSet['mov_year']?><h5>
        <h5>Support: <?=$ResultSet['sup_device']?></h5>
    </article>
    <article id="detailsectionright">
        <section id="detailtitlecategory">
            <h3><a href="#">#<?=$ResultSet['mov_id']?> <?=$ResultSet['mov_title']?></a></h3>
            <p><?=$ResultSet['cat_name']?></p>
        </section>
        <section id="detaildescription">
            <p><?=$ResultSet['mov_synopsis']?></p>
            <p><?=$ResultSet['mov_actors']?></p>
            <p><?=$ResultSet['mov_path']?></p>
        </section>
    </article>
</section>
