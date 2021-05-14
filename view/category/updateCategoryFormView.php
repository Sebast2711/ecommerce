<?php
$title = "Modification d'une categorie";
$formLink = '<link rel="stylesheet" href="public/form.css">';

ob_start();
?>

<h1 class="text-center my-5">Modification d'une catégorie</h1>


<form action="index.php?action=updateCategory&amp;id=<?=$category['id']?>" method = "post" class = "mx-auto">
    <div class="form-row">
        <div class="form-group col-12">
            <label for="category-name">Nom de catégorie</label>
            <input type="text" name ='name' id ='category-name' class = "form-control" placeholder = "Nom de la catégorie" required value = "<?=$category['name']?>">
        </div>
    </div>
    <div class="text-center">
        <button type ="submit" class="btn btn-block btn-update">Modifier</button>
    </div>
</form>

<?=$errorMessage?>

<?php
$content = ob_get_clean();
require_once 'view/template.php';
?>