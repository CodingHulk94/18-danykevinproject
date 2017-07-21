<h2>Gestion des catégories</h2>
<select id="category" name="categoryID">
    <option value="">Modifier une catégorie :</option>
    <?php foreach ($categoryList as $key => $value) : ?>
        <option value="<?= $value['cat_id'] ?>"><?= $value['cat_name'] ?></option>
    <?php endforeach; ?>
</select><br/>
<?php if (!empty($successList)) : ?>
	<?php foreach ($successList as $message) : ?>
		<span class="success"><?= $message ?></span>
	<?php endforeach; ?>
<?php endif; ?>
<form id="categoryEdit" action="add_edit_category.php" method="post" style="display:none">
    <label for="categoryName">Nom de la catégorie: </label>
    <input type="text" class="categoryName" name="categoryName" placeholder="Catégorie"><span class="titleError"></span><br />
    <input type="hidden" class="categoryID" name="categoryID">
    <button class="btn-validate" type="submit">Modifier</button>
</form>
<form id="categoryAdd" action="add_edit_category.php" method="post">
    <label for="categoryName">Nom de la catégorie: </label>
    <input type="text" class="categoryName" name="categoryName" placeholder="Catégorie"><span class="titleError"></span><br />
    <button class="btn-validate"  type="submit">Ajouter</button>
</form>
<script type="text/javascript">
    $('#category').change(function(event){
        !$('.success').html('');
        // si une catégorie a été choisie dans le select alors affiche formulaire de modification
        if( !$('#category').val() ) {
            $('#categoryEdit').css("display","none");
            $('#categoryAdd').css("display","block");
            $('.categoryName').val('');
            $('.titleError').html('');
            $('.btn-validate').prop('disabled', false);
        }
        // sinon affiche formulaire d'ajout
        else {
            $('#categoryEdit').css("display","block");
            $('#categoryAdd').css("display","none");
            $('.categoryName').val($('#category option:selected').text());
            $('.categoryID').val($('#category option:selected').val());
            $('.titleError').html('');
            $('.btn-validate').prop('disabled', false);
        }
    });

    $('.categoryName').keyup(function(event){
        if ( !$(this).val() || $(this).val().length < 4 ) {
            $('.btn-validate').prop('disabled', true);
            $(".titleError").html(' - La catégorie doit avoir au moins 4 caractères');
        }
        else {
            $('.btn-validate').prop('disabled', false);
            $(".titleError").html('');
        }
    });
</script>
