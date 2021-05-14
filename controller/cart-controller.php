<?php

require_once 'model/cart.php';
require_once 'model/product.php';


// Ajoute un prduit au panier
function addToCart(){
    if (isset ($_GET['id']) && !empty ($_GET['id']) ){
        $product = getProductByIdFromDB($_GET['id']);
        if (isset ($_SESSION['user'])){
            if (isset($_SESSION['user']['panier'])){
                $find = false;
                for ($i = 0; $i < count ($_SESSION['user']['panier']); $i++){
                    if ($_GET['id'] == $_SESSION['user']['panier'][$i]['product']){
                        // L'id est déja dans le panier -> incrémentation de la quantité (deuxieme élément du tableau $_SESSION['user']['panier'][$i])
                        if ($_SESSION['user']['panier'][$i]['quantity'] + 1 <=  intVal($product['quantity'])){
                            // La quantité dans la panier + 1 est dans les stock
                            $_SESSION['user']['panier'][$i]["quantity"]++; 
                            $find = true;
                            header('location:index.php');
                        }
                        else {
                            // La quantité dans la panier + 1 n'est pas dans les stock
                            header('location:index.php?action=productDetails&id='.$product['id_prod'].'&error=notInStock');
                            $find=true;
                        }
                    }
                }
                if (!$find){
                    // L'id n'est pas dans le panier -> ajout du produit au panier
                    array_push($_SESSION['user']['panier'], 
                    [
                        "product" =>  intVal(htmlentities($_GET['id'])), 
                        "quantity" => 1 
                    ]);
                    $find = false;
                    header('location:index.php');
                }
            }        
        }
        else {
            echo "L'utilisateur n'est pas connecté";
            header('location:index.php');
        }
    }
    else {
        echo "L'id n'a pas été trouvé";
        header('location:index.php');
    }
}


// Affiche le panier sous forme de tableau
function showCart(){
    if (isset($_SESSION['user'])){
        if (isset($_SESSION['user']['panier'])){
            // Si le panier est vide
            if (count($_SESSION['user']['panier']) == 0){
                $panier = [];
            }
            else {
                for ($i = 0; $i < count($_SESSION['user']['panier']); $i++){
                    // Pour chaques articles du panier on récupère l'article et la quantité demandée par l'utilisateur 
                    $products[$i]['product'] = getProductByIdFromDB(intVal($_SESSION['user']['panier'][$i]['product']));
                    $products[$i]['quantity'] = $_SESSION['user']['panier'][$i]['quantity'];
                }    
            }
            require_once 'view/cart/showCartView.php';

        }
        else {
            echo 'le panier existe pas';
        }
    }
    else {
        header('location:index.php');
    }
}



// Supprime tout les articles du panier
function deleteCart(){
    if (isset ($_SESSION['user']['panier']) && !empty ($_SESSION['user']['panier'])){
        // Le panier est remplie au minimum de 1 article
        $_SESSION['user']['panier'] = [];
        header('location:index.php?action=showCart');
    }
    else {
        // Le panier est vide
        header('location:index.php?action=showCart');
    }

}  



// Supprime un article du panier ou modifie la quantité d'un article
function updateProductInCart(){
    if (isset($_POST) && !empty ($_POST)) {
        if (isset($_GET['id']) && !empty($_GET['id'])){

            $cleanQty = filter_var(intVal($_POST['quantity']), FILTER_SANITIZE_NUMBER_INT);

            if (filter_var(intVal($cleanQty), FILTER_VALIDATE_INT) !== false){
                if (intVal($cleanQty) == 0){
                    // Supprimer l'article du panier
                    for ($i = 0; $i < count ($_SESSION['user']['panier']); $i++){
                        if ($_SESSION['user']['panier'][$i]['product'] ==  htmlentities(($_GET['id']))){
                            array_splice($_SESSION['user']['panier'], $i, 1);
                            header('location:index.php?action=showCart');
                        }
                    }
                }
                else {
                    // Change la quantité de l'article dans le panier
                    for ($i = 0; $i < count ($_SESSION['user']['panier']); $i++){
                        if ($_SESSION['user']['panier'][$i]['product'] ==  htmlentities(($_GET['id']))){
                            $_SESSION['user']['panier'][$i]['quantity'] = intVal($cleanQty);
                            header('location:index.php?action=showCart');
                        }
                    }
                }
            }
            else {
                // L'entré du formulaire n'est pas un nombre
                header('location:index.php?action=showCart');
            }
        }
        else {
            // L'id n'est pas défini ou est nul
            header('location:index.php?action=showCart');
        }
    }
    else {
        // Le formulaire n'a pas bien été rempli
        header('location:index.php?action=showCart');
    }
}


?>