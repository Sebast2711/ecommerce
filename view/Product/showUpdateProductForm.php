<?php
    $title = "Modification d'un produit"; 
    $formLink = '<link rel="stylesheet" href="public/form.css">';

    if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] != "admin"){
        header('location:index.php');
    }
    ob_start();
?>

<h1 class = "text-center my-5">Modification du produit</h1>





<form action="index.php?action=updateProduct&amp;id=<?=$product['id_prod']?>" method = "post" class="mx-auto">

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Nom produit</label>
            <input type="text" name = "name" id = "name" class="form-control" placeholder = "Nom du produit" required value="<?=$product['name']?>" >
        </div>
        <div class="form-group col-md-6">
            <label for="category">Nom catégorie</label>
            <select name="categorie" id="category" class = "form-control">    
                <option value="<?=$product['cat_name']?>"><?=$product['cat_name']?></option>
                <?php foreach ($categories as $categorie){ 
                        if ($categorie['name'] != $product['cat_name']){        
                    ?>
                    <option value="<?=$categorie['name']?>"><?=$categorie['name']?></option>
                <?php   }
                    } ?>
            </select>        
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="quantity">Quantité</label>        
            <input type="number" name = "quantity" id ="quantity" class="form-control" placeholder = "Quantité disponible" required value="<?=$product['quantity']?>">

        </div>           
        <div class="form-group col-md-6">
            <label for="unit_price">Prix unitaire en €</label> 
            <input type="text" name = "unit_price" id="unit_price" class="form-control" placeholder = "Prix du produit" required value="<?=$product['unit_price']?>">
        </div>            
    </div>                

  


    <div class="form-row">
        <div class="form-group col-12">
            <label for="desc">Description produit</label>
            <textarea name = "description" id = "desc" class = "form-control" placeholder = "Description du produit" required rows="5" ><?=$product['description']?></textarea>
        
        </div>
    </div>

   
    <button type = "submit" class="btn btn-update btn-block"> Modifier le produit </button>

</form>






<?php
$content = ob_get_clean();
require_once 'view/template.php';
?>