<!-- Déroulant page à faire -->
    <section id="filtres">
        <select id="pageselect" class="" name="">

        </select>
        <select id="catfilterselect" class="" name="catfilter">
            <option value="">Choisissez</option>
            <?php foreach($CatFilterData as $CatKey => $CatValue) : ?>
                <option value="<?=$CatValue['cat_id']?>" <?php if(!empty($_GET['category'])) : ?><?php if($_GET['category'] == $CatValue['cat_id']) : ?> selected <?php endif; ?><?php endif; ?>><?=$CatValue['cat_name']?></option>
            <?php endforeach; ?>
        </select>
        <select id="tripardateselect" class="" name="">
          <option value="1">Les plus récents</option>
          <option value="2">Les plus anciens</option>
        </select>
    </section>
    <section id="movieshowcase">

    </section>
    <section id="Pagination">
          <a class="pagebuttonprec" href="#">Précédent</a>
          <p id="pageindicator"></p>
          <a class="pagebuttonsuiv" href="#">Suivant</a>
    </section>
    <script>
        //Reqûete Ajax pour afficher les films selon la page choisie
        function loadPage(currentpage){
            $.ajax({
                url: 'ajax/catalogue.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    'page': currentpage,
                    'validator' : <?=$Validator?>,
                    'motrecherche' : '<?=$wordSearch?>',
                    'categoryID' : <?=$categorypageID?>,
                    'filter' : parseInt($("#catfilterselect option:selected").val()),
                    'datefilter' : parseInt($("#tripardateselect option:selected").val())
                },
                success: function(response){
                    console.log(response);
                    $("#pageindicator").html("Page "+currentpage);
                    $("#movieshowcase").html("");
                    movieshowcase = $("#movieshowcase");
                    movieshowcase.append("<span><?=$phraseRecherche?></span>");
                    //Suppression des boutons suivants et précédents quand aucun film affiché!
                    if(response.length < 1){
                      $(".pagebuttonprec").css("display", "none");
                      $(".pagebuttonsuiv").css("display", "none");
                    }

                    for(var index=0; index<response.length; index++){
                        movieshowcase.append("<article class='movieshowcaseleft'><section class='affiche'><article><img src='"+response[index]['mov_image']+"'/></article><article><h3>"+response[index]['mov_id']+response[index]['mov_title']+"</h3><p>"+response[index]['mov_synopsis']+"<p></article></section></article><article class='movieshowcaseright'><a href='details.php?movieID="+response[index]['mov_id']+"'>Détails</a><a href='add_edit_movie.php?movieID="+response[index]['mov_id']+"'>Modifier</a>");
                        console.log(Math.floor(parseInt(response[index]['filmtotal'])/3));

                        //Conditions pour l'affiche des boutons suivant et précédent


                        if (currentpage <= 1){
                            $(".pagebuttonprec").css("display", "none");
                        }
                        else if (currentpage > 1){
                            $(".pagebuttonprec").css("display", "inline-block");
                        }

                        if(currentpage >= parseInt(response[index]['filmtotal'])/3){
                            $(".pagebuttonsuiv").css("display", "none");
                        }
                        else{
                            $(".pagebuttonsuiv").css("display", "inline-block");
                        }
                        pageselecter = $("#pageselect");
                        pageselecter.html("");
                        for(var index1=0; index1 < parseInt(response[0]['filmtotal'])/3; index1++){
                          if((index1+1) !== currentpage){
                            pageselecter.append("<option value="+(index1+1)+" >"+(index1+1)+"</option>");
                            console.log("nonegus");
                          }
                          else {
                            pageselecter.append("<option value="+currentpage+" selected >"+currentpage+"</option>");
                            console.log("negus");
                          }
                        }
                    }



                },
                error: function(){
                    alert("You failed");
                }
            })
        }
            $(document).ready(function(){
                validator = <?=$Validator?>
                //On définit comme page de défault la page 1
                currentpage = 1;
                //On définit la variable currentHash qui a comme valeur le hash actuel de l'URL
                var currentHash = location.hash;
                //Si le hash existe, on attribue la valeur du hash à la page, sinon la page reste 1 par défaut
                if (currentHash !== ""){
                    currentpage = parseInt(currentHash.replace("#", ""));
                }

                loadPage(currentpage);

                //Bouton Suivant
                $(".pagebuttonsuiv").on("click", function(event){
                    //Empêchement de recharger
                    event.preventDefault();
                    currentpage += 1;
                    loadPage(currentpage);
                    //On définit le hash en lui donnant la valeur de la page actuelle
                    location.hash = currentpage;

                });
                //Bouton Précédent
                $(".pagebuttonprec").on("click", function(event){
                    event.preventDefault();
                    currentpage -= 1;
                    loadPage(currentpage);

                    location.hash = currentpage;

                });
                //****************************** FILTRES **************************//
                //Catégories
                $("#catfilterselect").on("change", function(){
                    history.pushState("", "", "catalogue.php?category="+$(this).val()+"");
                    currentpage = 1;
                    loadPage(currentpage);

                })

                $("#pageselect").on("change", function(){
                  currentpage = parseInt($("#pageselect option:selected").val());
                  console.log(currentpage);
                  loadPage(currentpage);
                  location.hash = currentpage;
                })

                $("#tripardateselect").on("change", function(){
                  validator = <?=$Validator?>
                  //On définit comme page de défault la page 1
                  currentpage = 1;
                  //On définit la variable currentHash qui a comme valeur le hash actuel de l'URL
                  var currentHash = location.hash;
                  //Si le hash existe, on attribue la valeur du hash à la page, sinon la page reste 1 par défaut
                  if (currentHash !== ""){
                      currentpage = parseInt(currentHash.replace("#", ""));
                  }

                  loadPage(currentpage);

                })
            });
    </script>
