<?php
$title = "Ajout d'un nouveau produit";
$formLink = '<link rel="stylesheet" href="public/form.css">';

ob_start();
?>

<h1 class ="text-center my-5">Ajouter un nouveaux produit</h1>

<form action="index.php?action=addProduct" method = "post" enctype="multipart/form-data" class="mx-auto">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Nom produit</label>
            <input type="text" name = "name" id ="name" class ="form-control" placeholder="Nom du produit" required>
        </div>

        <div class="form-group col-md-6">
            <label for="category">Nom catégorie</label>
            <select name="category" id ="category" class = "form-control" required>
                <option value="" id ="default"> Catégories </option>
                <?php foreach ($categories as $category) { ?>
                    <option value="<?=$category['id']?>"><?=$category['name']?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="quantity">Quantité</label>        
            <input type="number" name = "quantity" id = "quantity" class = "form-control" placeholder = "Quantité en stock" required>
        </div>
        <div class="form-group col-md-6">
            <label for="unit_price">Prix unitaire en €</label>
            <input type="text" name = "unit_price" id="unit_price" class = "form-control" placeholder = "Prix unitaire" required>    
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group col-12">
            <label for="description">Description produit</label>        
            <textarea name="description" id="description" class = "form-control" placeholder = "Description du produit" required></textarea>    
        </div>                
    </div>
    
    <div class="form-row">
        <div class="col-12 custom-file">
            <input type="file" id="image" name="image" accept="image/*" class="custom-file-input" required>
            <label class="custom-file-label" for="image">Choisissez une image du produit</label>
        </div>                
    </div>
    
    
    
    <button type="submit" class = "btn btn-block btn-validate">Ajouter un produit</button>
    <button type="reset" class = "btn btn-block btn-update">Remettre à 0</button>

</form>


<?php
$content = ob_get_clean();
require_once 'view/template.php';
?>