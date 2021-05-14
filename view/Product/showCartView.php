<?php
$title = "Panier";
$cartLink = '<link rel="stylesheet" href="public/cart.css">';
ob_start();
?>



<?php 
if (isset($products)){
    if (count($products) == 0){
        echo "<h2>Votre panier ne contient aucun article</h2>";
        // A tester
    }
    else { 
        $totalPrice = 0;    

        $cartNumber = 0;
        for ($i = 0; $i < count ($_SESSION['user']['panier']); $i++){
        $cartNumber += intVal($_SESSION['user']['panier'][$i]['quantity']); 
        }

    ?>
        <!-- Affichage du nombre d'article dans le panier -->
        <h1 class = "text-center my-5">Votre panier contient <?=$cartNumber?> article<?php if ($cartNumber>1) echo 's'?></h1>

        <div class="container">
            <table class = "table table-striped">
                <tr>
                    <td>Nom de l'article</td>
                    <td>Prix de l'article</td>
                    <td>Quantité</td>
                    <td>Prix cumulé</td>
                </tr>    

                <?php foreach ($products as $product) { 
                    $productXprice = 0;    
                ?>
                    <tr>
                        <td><?=$product['product']['name']?></td>
                        <td><?=$product['product']['unit_price']?></td>
                        
                        
                        <?php if ($product['product']['quantity'] <= 0){ ?>
                            <td class="text-danger">Aucun Stock</td>
                        <?php }
                            else {
                        ?>
                        
                        <td>
                            <div class="quantity">
                                <form action="index.php?action=updateProductInCart&amp;id=<?=$product['product']['id_prod']?>" method = "post">
                                <select name="quantity" id="quantity">
                                    <option value ="<?=$product['quantity']?>"> &lt; <?=$product['quantity']?> &gt; </option>
                                    <?php for ($i = 0; $i < $product['product']['quantity']; $i++ ) {
                                        if ($i != $product['quantity'])    {
                                    ?>
                                        <option value="<?=$i?>"><?=$i?></option>

                                    <?php }} ?>

                                </select>
                                <button type="submit" class="btn btn-update-quantity btn-update"><i class="fas fa-check"></i></button>
                                </form>
                            </div>
                        </td>
                        <?php } ?>
                        
                        
                        
                        
                        
                        
                        <?php
                            $productXprice = $product['quantity'] * $product['product']['unit_price'] ;
                            $totalPrice += $productXprice;
                        ?>

                        <td><?= $productXprice?> €</td>


                    </tr>    
                <?php } ?>

                <tr>
                    <td class="text-right" colspan ="3" >Prix total</td>
                    <td> <?=$totalPrice?> €</td>
                </tr>
            </table>
        </div>


    <?php } ?>


<div class ="buttons container text-center">

    <button class="btn btn-block btn-buyProduct">Commander <i class="fas fa-shopping-cart"></i></button>                                    

    <?php if ($cartNumber > 0){ ?>
        <a href="index.php?action=deleteCart">
            <button class="btn btn-block btn-delete"> Supprimer le panier </button>
        </a>
    <?php } ?>

</div>

<?php 
} 
else {
    echo "<h2 class='text-center my-3'>Votre panier ne contient aucun article</h2>";
}?>



    
<?php
$content = ob_get_clean();
require_once 'view/template.php';
?>