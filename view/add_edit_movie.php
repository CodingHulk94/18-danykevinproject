<section id="movieForm" class="formulaire">
    <!-- je check s'il existe des erreurs si oui je les affiche -->
    <?php if (!empty($errorList)) : ?>
        <?php foreach ($errorList as $message) : ?>
            <span class="error"><?= $message ?></span>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (!empty($successList)) : ?>
        <?php foreach ($successList as $message) : ?>
            <span class="success"><?= $message ?></span>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- vérifie s'il y a un ID dans l'url, si oui alors affiche le formulaire de modification sinon affiche le formulaire d'ajout -->
    <?php if (!empty($_GET['movieID'])) : ?>
        <h2>Gestion du film: <?= $movieResult['mov_title'] ?></h2>
        <form class="" action="add_edit_movie.php" method="post" enctype="multipart/form-data">
            <div class="left">
                <label for="title">Titre:</label>
                <input type="text" id="title" name="title" placeholder="Titre du film" value="<?= $movieResult['mov_title'] ?>"><br />
                <label for="actors" >Acteurs:</label>
                <input type="text" id="actors" name="actors" placeholder="Acteurs du film" value="<?= $movieResult['mov_actors'] ?>"><br />
                <label for="year" >Année de sortie:</label>
                <input type="number" id="year" name="year" min="1900" max="2020" value="<?= $movieResult['mov_year'] ?>"><br />
                <label for="movieImage" >Affiche du film</label>
                <input type="text" name="affiche" id="movieImage" placeholder="URL de l'image" value="<?= $movieResult['mov_image'] ?>"><br />
            </div>
            <div class="right">
                <label for="category">Catégorie:</label>
                <select id="category" name="categoryID">
                    <?php foreach ($categoryList as $key=>$value) :?>
                        <option value="<?= $value['cat_id'] ?>" <?php if ($movieResult['category_cat_id'] == $value['cat_id']) : ?> selected <?php endif; ?>><?= $value['cat_name'] ?></option>
                    <?php endforeach; ?>
                </select><span id=categoryError></span><br />
                <label for="supportDevice">Support de stockage du fichier</label>
                <select id="supportDevice" name="supportID">
                    <?php foreach ($supportList as $key => $value) : ?>
                        <option value="<?= $value['sup_id'] ?>" <?php if ($movieResult['category_cat_id'] == $value['sup_id']) : ?> selected <?php endif; ?>><?= $value['sup_device'] ?></option>
                    <?php endforeach; ?>
                </select><span id=supportDeviceError></span><br />
                <label for="path">Chemin absolu vers le fichier</label>
                <input type="text" id="path" name="path" placeholder="Chemin absolu" value="<?= $movieResult['mov_path'] ?>"></span><br />
            </div>
            <textarea id="synopsis" name="synopsis" placeholder="Synopsis du film"><?= $movieResult['mov_synopsis'] ?></textarea><br/>
            <div class="buttons">
                <a href="add_edit_movie.php?movieDeleteID=<?= $movieResult['mov_id'] ?>" class="button box bar" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">Supprimer</a>
                <!-- input caché qui envoie l'id du film à modifier -->
                <input type="hidden" id="movieID" name="movieID" value="<?= $movieResult['mov_id'] ?>">
                <button id="btn-validate" class="box bar" type="submit">Valider</button>
            </div>
        </form>
    <?php else: ?>
        <h2>Ajout d'un nouveau film</h2>
        <form id="form-api" class="" action="" method="post">
            <input type="text" id="movieAPI" placeholder="Rechercher film dans OMDb API">
            <button type="submit">Rechercher</button>
        </form>
        <!-- Formulaire d'ajout -->
        <form class="" action="add_edit_movie.php" method="post" enctype="multipart/form-data">
            <div class="left">
                <label for="title">Titre:</label>
                <input type="text" id="title" name="title" placeholder="Titre du film"><br />
                <label for="actors" >Acteurs:</label>
                <input type="text" id="actors" name="actors" placeholder="Acteurs du film"><br />
                <label for="year" >Année de sortie:</label>
                <input type="number" id="year" name="year" min="1900" max="2020" value="2000"><br />
                <label for="movieImage" >Affiche du film:</label>
                <input type="text" name="affiche" id="movieImage" placeholder="URL de l'image"><br />
            </div>
            <div class="right">
                <label for="category" >Catégorie:</label>
                <span id=categoryAPI></span><br/>
                <select id="category" name="categoryID">
                    <option value="">choisissez :</option>
                    <?php foreach ($categoryList as $key => $value) : ?>
                        <option value="<?= $value['cat_id'] ?>"><?= $value['cat_name'] ?></option>
                    <?php endforeach; ?>
                </select><span id=categoryError></span><br />
                <label for="supportDevice" movieID>Support de stockage du fichier:</label>
                <select id="supportDevice" name="supportID">
                    <option value="">choisissez :</option>
                    <?php foreach ($supportList as $key => $value) : ?>
                        <option value="<?= $value['sup_id'] ?>"><?= $value['sup_device'] ?></option>
                    <?php endforeach; ?>
                </select><span id=supportDeviceError></span><br />
                <label for="path">Chemin absolu vers le fichier:</label>
                <input type="text" id="path" name="path" placeholder="Chemin absolu"><span id=pathError></span><br />
            </div>
            <textarea id="synopsis"  name="synopsis" placeholder="Synopsis du film"></textarea><br/>
            <div class="buttons">
                <button id="btn-validate" class="box bar" type="submit">Valider</button>
            </div>
        </form>
    <?php endif; ?>
</section>
<script type="text/javascript">
    $('#form-api').submit(function(event){
        event.preventDefault();
        var title = $('#movieAPI').val();
        $.ajax({
        url: "http://www.omdbapi.com/?apikey=36df7672",
        type: "GET",
        dataType : 'json',
        data : {'t' : title},
        error : function() {
            console.log('Erreur d\'Ajax');;
        },
        success: function(response) {
            $("#title").val(response.Title);
            $("#actors").val(response.Actors);
            $("#synopsis").html(response.Plot);
            $("#year").val(response.Year);
            $( "#categoryAPI" ).html(' - Choisissez 1 parmi: '+response.Genre+' - ');
            $( "#movieImage" ).val(response.Poster);
        }
      });
    });
</script>
