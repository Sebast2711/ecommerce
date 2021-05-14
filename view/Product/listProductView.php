<?php 
$title = "Accueil";
$cssLink = '<link rel="stylesheet" href="public/card.css">'; 
ob_start();
?>




<div class="container mx-auto my-5 cards-grp">
    <?php foreach ($products as $product){ ?>

            <div class="card">

                <div class="card-image text-center">
                    <img src="public/images<?=$product['image']?>.png" alt="<?=$product['image']?>">
                </div>
                <p class = "text-center productName"><?=$product['name']?></p>

                <div class="d-flex justify-content-around price-qty">
                    <p class = "productPrice">Prix : <?=$product['unit_price']?>€</p>
                </div>
                
                <a href="index.php?action=productDetails&amp;id=<?=$product['id_prod']?>" class="d-flex justify-content-center productDetailBtn">
                    <button class="btn btn-showProduct">Voir le produit</button>               
                </a>
            </div>

        
    <?php } ?>
</div>




<?php
$content = ob_get_clean();
require_once 'view/template.php';
?>