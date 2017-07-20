<?php if (empty($_GET['editID'])) : ?>
    <form id="form-api" class="" action="" method="post">
        <input type="text" id="movieAPI" placeholder="Rechercher dans OMDb API">
        <button type="submit" >Rechercher</button>
    </form>
<?php endif; ?>
<span>Gestion du film: TITRE DU FILM ICI</span></br>
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
<?php if (!empty($_GET['editID'])) : ?>
    <form class="" action="add_edit_movie.php" method="post" enctype="multipart/form-data">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" placeholder="Titre du film" value="<?= $movieResult['mov_title'] ?>"><span id=titleError></span><br />
        <label for="actors" >Acteurs</label>
        <input type="text" id="actors" name="actors" placeholder="Acteurs du film" value="<?= $movieResult['mov_actors'] ?>"><span id=actorsError></span><br />
        <label for="synopsis" >Synopsis</label>
        <textarea id="synopsis" rows="4" cols="80" name="synopsis" placeholder="Synopsis du film"><?= $movieResult['mov_synopsis'] ?></textarea><br/>
        <!-- <input type="text" id="synopsis" name="synopsis" placeholder="Synopsis du film" value="<?= $movieResult['mov_synopsis'] ?>"><span id=synopsisError></span><br /> -->
        <label for="year" >Année de sortie</label>
        <input type="number" id="year" name="year" min="1900" max="2020" value="<?= $movieResult['mov_year'] ?>"><span id=yearError></span><br />
        <label for="category" class="col-sm-2 control-label">Caégorie</label>
        <select id="category" name="categoryID">
            <!-- <option value="">choisissez :</option> -->
            <?php foreach ($categoryList as $key=>$value) :?>
                <option value="<?= $value['cat_id'] ?>" <?php if ($movieResult['category_cat_id'] == $value['cat_id']) : ?> selected <?php endif; ?>><?= $value['cat_name'] ?></option>
			<?php endforeach; ?>
        </select><span id=categoryError></span><br />
        <label for="supportDevice" class="col-sm-2 control-label">Support de stockage du fichier</label>
        <select id="supportDevice" name="supportID">
            <!-- <option value="">choisissez :</option> -->
            <?php foreach ($supportList as $key => $value) : ?>
                <option value="<?= $value['sup_id'] ?>" <?php if ($movieResult['category_cat_id'] == $value['sup_id']) : ?> selected <?php endif; ?>><?= $value['sup_device'] ?></option>
            <?php endforeach; ?>
        </select><span id=supportDeviceError></span><br />
        <label for="path">Chemin absolu vers le fichier</label>
        <input type="text" id="path" name="path" placeholder="Chemin absolu" value="<?= $movieResult['mov_path'] ?>"><span id=pathError></span><br />
        <label for="movieImage" >Affiche du film</label>
        <input type="hidden" name="submitFile" value="1" />
        <input type="file" name="affiche" id="movieImage" /><span id=titleError></span><br />

        <a href="add_edit_movie.php?movieDeleteID=<?= $movieResult['mov_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">Supprimer</a>
        <!-- input caché qui envoie l'id du film à modifier -->
        <input type="hidden" class="form-control" id="movieID" name="movieID" value="<?= $movieResult['mov_id'] ?>">
        <button id="btn-validate"type="submit">Valider</button>
    </form>
<?php else: ?>
    <!-- Formulaire d'ajout -->
    <form class="" action="add_edit_movie.php" method="post" enctype="multipart/form-data">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" placeholder="Titre du film"><span id=titleError></span><br />
        <label for="actors" >Acteurs</label>
        <input type="text" id="actors" name="actors" placeholder="Acteurs du film"><span id=actorsError></span><br />
        <label for="synopsis" >Synopsis</label>
        <textarea id="synopsis" rows="4" cols="80" name="synopsis" placeholder="Synopsis du film"></textarea><br/>
        <!-- <input type="text" id="synopsis" name="synopsis" placeholder="Synopsis du film"><span id=synopsisError></span><br /> -->
        <label for="year" >Année de sortie</label>
        <input type="number" id="year" name="year" min="1900" max="2020" value="2000"><span id=yearError></span><br />
        <label for="category" class="col-sm-2 control-label">Caégorie</label>
        <select id="category" name="categoryID">
            <option value="">choisissez :</option>
            <?php foreach ($categoryList as $key => $value) : ?>
                <option value="<?= $value['cat_id'] ?>"><?= $value['cat_name'] ?></option>
            <?php endforeach; ?>
        </select><span id=categoryError></span><span id=categoryAPI></span><br />
        <label for="supportDevice" class="col-sm-2 control-label">Support de stockage du fichier</label>
        <select id="supportDevice" name="supportID">
            <option value="">choisissez :</option>
            <?php foreach ($supportList as $key => $value) : ?>
                <option value="<?= $value['sup_id'] ?>"><?= $value['sup_device'] ?></option>
            <?php endforeach; ?>
        </select><span id=supportDeviceError></span><br />
        <label for="path">Chemin absolu vers le fichier</label>
        <input type="text" id="path" name="path" placeholder="Chemin absolu"><span id=pathError></span><br />
        <label for="movieImage" >Affiche du film</label>
        <input type="hidden" name="submitFile" value="1" />
        <input type="file" name="affiche" id="movieImage" /><span id=titleError></span><br />

        <button id="btn-validate"type="submit">Valider</button>
    </form>
<?php endif; ?>
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
            $("#year").val(2011);
            $( "#categoryAPI" ).html('Choisissez 1 parmi: '+response.Genre);
        }
      });
    });
</script>
