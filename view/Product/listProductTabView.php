<?php
    $title = "Page des produits";     
    ob_start();
?>

<h1 class = "text-center my-5">Liste des produits</h1>

<a href="index.php?action=addProduct">
    <button class="btn btn-block btn-validate">Ajouter un produit</button>
</a>

<div class="container-fluid table-responsive">
    <table class = "table table-striped ">        
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Catégorie</th>
        <th>Quantité</th>
        <th>Prix</th>
        <th>Actions</th>
    </tr>

    <?php 
    foreach ($products as $product) { 
    ?>
        <tr>
            <td><?= $product['name'] ?></td>
            <td class = "w-50"><?= $product['description'] ?></td>
            <td><?= $product['cat_name'] ?></td>
            <td><?= $product['quantity'] ?></td>
            <td><?= $product['unit_price']?> €</td>

            <td>
                <?php
                    if (isset ($_SESSION['user'])){
                        if ($_SESSION['user']['role'] == "admin"){ 
                ?>
                            <a href="index.php?action=updateProductForm&amp;id=<?=$product['id_prod'] ?>"><button class="btn btn-update">Modifier</button></a>
                            <a href="index.php?action=deleteProduct&amp;id=<?=$product['id_prod'] ?>"><button class="btn btn-delete">Supprimer</button></a>        
                <?php
                        }
                    }
                ?>

            </td>
        </tr>
        
        
    <?php 
    } 
    ?>


    </table>
</div>

<?php
    $content = ob_get_clean();
?>




<?php
require_once 'view/template.php';
?>