<?php
$title = "Detail du produit";
$detailedProductLink = '<link rel="stylesheet" href="public/detailedProduct.css">';

ob_start();
?>

<div class="container">
    
    <img class = "mx-auto" id="productImage" src="public/images<?=$product['image']?>.png" alt="<?=$product['image']?>">

    <div class="info">
        <h2 id="productName"><?=$product['name']?></h2>
        <p id="productPrice" class = "productPrice">Prix : <?=$product['unit_price']?>€</p>
        <p id="productDescription" class = "description"><?=$product['description']?></p>


        <?php if ($product['quantity']> 0){ ?>
            <p id="productQuantity" class = "productQuantity">Quantité : <?=$product['quantity']?></p>

            <a id="productAddToCartAnchor" href="index.php?action=addToCart&amp;id=<?=$product['id_prod']?>">
                <button id="productAddToCartBtn" class="btn btn-buyProduct">
                    Ajouter au panier 
                    <i class="fas fa-cart-plus"></i>
                </button>
            </a>
        <?php } 
            else {?>
                <p class = "text-danger">Plus de stock</p>    
        <?php } ?>    
    </div>


</div>

<?=$errorMessage?>

<?php
$content = ob_get_clean();
require_once 'view/template.php';
?>