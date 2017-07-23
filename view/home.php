<section id="homecontent">
  <article class="presentation">
    <img src="img/benjamovie.png" alt="">
    <p>If you stumbled upon us, you can consider yourself the luckiest guy on the planet!
    Why? Because Benjamovie is the best movie library out there! Why? Because it has been created by 2 dudes from
    the Webforce3 formation! So what? Webforce3 has the top-tier back-end coach who turns his students into top-tier web developpers!
    And who may that be? You're looking at him right now! Does the picture not speak already for itself? Rather than asking questions,
    just dive into our movie library and enjoy the experience. Believe me, it will end your urge for asking questions!
    </p>
  </article>
  <article class="mainsearch">
    <form class="" action="catalogue.php" method="get">
      <input type="text" name="motrecherche" value="" placeholder="Recherche...">
      <button type="submit" name=""><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
  </article>
  <article class="maincategories">
    <h2>Catégories</h2>
    <ul id="films_per_category">
      <?php foreach($Result as $key => $value) : ?>
        <li><a href="catalogue.php?category=<?=$value['cat_id']?>"><?=$value['cat_name']?> (<?=$value['nbmov']?>)</a></li>
      <?php endforeach; ?>
    </ul>
  </article>
  <article class="recentmovies">
      <div class="slideshow-container">
        <?php foreach ($lastMovies as $key => $value) : ?>
          <div class="mySlides fade">
            <div class="numbertext"><?=$key+1?> / <?=count($lastMovies)?></div>
              <img src="<?=$value['mov_image']?>" alt="">
              <div class="hovershowup">
                <a href='details.php?movieID=<?=$value['mov_id']?>'><h3><?=$value['mov_title']?></h3></a>
              </div>
          </div>
        <?php endforeach; ?>
      </div><br>
      <div style="text-align:center">
        <?php for ($index = 0; $index < count($lastMovies); $index++) : ?>
          <span class="dot" onclick="currentSlide(<?=$index?>)"></span>
        <?php endfor; ?>
      </div>
  </article>
</section>
<script>
var slideIndex = 0;
showSlides();

function currentSlide(n) {
  clearTimeout(Timer);
  showSlides(slideIndex = n);
}
function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");


    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex> slides.length) {slideIndex = 1}
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    Timer = setTimeout(showSlides, 10000); // Change image every 2 seconds
}


</script>
