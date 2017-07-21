<!-- Déroulant page à faire -->

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
                    'validator' : <?=$Validator?>
                },
                success: function(response){
                    console.log(response);
                    $("#pageindicator").html("Page "+currentpage);
                    $("#movieshowcase").html("");
                    movieshowcase = $("#movieshowcase");
                    for(var index=0; index<response.length; index++){
                        movieshowcase.append("<article class='movieshowcaseleft'>");
                        movieshowcase.append("<section class='affiche'>");
                        movieshowcase.append("<article>");
                        movieshowcase.append("<img src='' />");
                        movieshowcase.append("</article>");
                        movieshowcase.append("<article>");
                        movieshowcase.append("<h3>"+response[index]['mov_id']+response[index]['mov_title']+"</h3>");
                        movieshowcase.append("<p>"+response[index]['mov_synopsis']+"<p>");
                        movieshowcase.append("</article>");
                        movieshowcase.append("</section>");
                        movieshowcase.append("</article>");
                        movieshowcase.append("<article class='movieshowcaseright'>");
                        movieshowcase.append("<a href='details.php?movieID="+response[index]['mov_id']+"'>Détails</a>");
                        movieshowcase.append("<a href='add_edit_movie.php?movieID="+response[index]['mov_id']+"'>Modifier</a>");

                        //Conditions pour l'affiche des boutons suivant et précédent
                        if (currentpage <= 1){
                            $(".pagebuttonprec").css("display", "none");
                        }
                        else if (currentpage > 1){
                            $(".pagebuttonprec").css("display", "inline-block");
                        }

                        if(currentpage >= <?=$maxPages?>){
                            $(".pagebuttonsuiv").css("display", "none");
                        }
                        else if(currentpage < <?=$maxPages?>){
                            $(".pagebuttonsuiv").css("display", "inline-block");
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
            });
    </script>
