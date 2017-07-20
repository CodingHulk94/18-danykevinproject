<!-- Déroulant page à faire -->

<section id="movieshowcase">

</section>
<section id="Pagination">
      <a class="pagebuttonprec" href="#">Précédent</a>
      <p id="pageindicator"></p>
      <a class="pagebuttonsuiv" href="#">Suivant</a>
</section>
<script>
function loadPage(currentpage){
    $.ajax({
        url: 'ajax/catalogue.php',
        method: 'POST',
        dataType: 'json',
        data: {'page': currentpage},
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
                movieshowcase.append("<a href='details.php?movieID='>Détails</a>");
                movieshowcase.append("<a href='add_edit_movie.php?movieID='>Modifier</a>");

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

        currentpage = 1;
        var currentHash = location.hash;
        if (currentHash !== ""){
            currentpage = parseInt(currentHash.replace("#", ""));
        }

        loadPage(currentpage);

        $(".pagebuttonsuiv").on("click", function(event){
            event.preventDefault();
            currentpage += 1;
            loadPage(currentpage);

            location.hash = currentpage;

        });
        $(".pagebuttonprec").on("click", function(event){
            event.preventDefault();
            currentpage -= 1;
            loadPage(currentpage);

            location.hash = currentpage;

        });
    });
</script>
