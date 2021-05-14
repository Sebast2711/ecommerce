<?php

require_once 'model/product.php';
require_once 'model/category.php';

// Liste des produits sous forme de tableau
// Réservé aux administrateur
function listProductsTab(){
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin"){
        // L'utilisateur n'est pas un admin
        header('location:index.php');
    }
    $products = getProductsFromDB();
    require_once 'view/product/listProductTabView.php';
}

// Liste des produits sous forme de carte 
// Tout les utilisateurs peuvent voir cet affichage
function listProducts(){
    $products = getProductsFromDB();
    require_once 'view/product/listProductView.php';
}

function showDetailedProduct (){
    if (isset($_GET['error'])){
        if ($_GET['error'] == "notInStock"){
            $errorMessage = "Il n'y a plus de stock";
        }
        else {
            $errorMessage = "";
        }
    }
    else {
        $errorMessage = "";
    }


    if (isset ($_GET['id']) && !empty ($_GET['id']) ){
        $product = getProductByIdFromDB(htmlentities($_GET['id']));
        require_once 'view/product/detailedProductView.php';
    }
    else {
        echo "L'id n'a pas été trouvé";
        header('location:index.php');
    }
}






function addProduct(){
    // addProductToDB($name, $category_id, $quantity, $unit_price, $description)
    
    if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['category']) && !empty($_POST['category']) && isset($_POST['quantity']) && !empty($_POST['quantity']) && isset ($_POST['unit_price']) && !empty ($_POST['unit_price']) && isset($_POST['description']) && !empty($_POST['description'])){


        $cleanName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $cleanDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $cleanCategory = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
        $cleanQuantity = filter_input(INPUT_POST, 'quantity',  FILTER_SANITIZE_NUMBER_INT);
        $price = (float)str_replace(",",".",htmlentities($_POST['unit_price']));
        $cleanPrice = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if (preg_match("#^[a-zA-Z0-9-_][a-zA-Z0-9-_ ]{1,49}$#", $cleanName)){
            // Le nom du produit est valide 
            if (preg_match("#^[a-zA-Z-_0-9àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð.;,?!:/ ]{1,254}$#", $cleanDescription)){
                // La description du produit est valide
                if (preg_match("#^[0-9]{1,4}$#", $cleanCategory)){
                    // La categorie du produit est valide 
                    if (preg_match("#^[0-9]{1,5}$#", $cleanQuantity)){
                        // La quantité du produit est valide
                        if (preg_match("#^[0-9]+([.0-9])+$#", $cleanPrice)){
                            // Le prix du produit est valide
                            



                            // Verifier le format du fichier
                            // move_uploaded_file($_FILES['image']['tmp_name'], $image); 
        
                            // $image = $_SERVER['DOCUMENT_ROOT'] . '/ecommerce1/public/images/' . $_FILES['image']['name'];
                            // var_dump($image);

                            // addProductToDB($_POST['name'], intVal($_POST['category']), $_POST['quantity'], (float) $_POST['unit_price'], $_POST['description'], '/' . $_FILES['image']['name']);
                            header('location:index.php?action=productAdmin');




                        }
                    }
                }
            }
        }
    }
    
    else {
        $categories = getCategories();
        require_once 'view/product/addProductFormView.php';
    }



}




function showUpdateProductForm(){
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] != "admin"){
        header('location:index.php');
    }
    else {
        if (isset ($_GET['id']) && !empty ($_GET['id']) ){
            $product = getProductByIdFromDB(htmlentities($_GET['id']));
            $categories = getCategories();
        }
        require_once 'view/product/showUpdateProductForm.php';
    }

}


function updateProduct (){
    if (isset ($_GET['id']) && !empty ($_GET['id']) ){

        $categorie = getCategoryByName($_POST['categorie']);
        

        $cleanName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $cleanDesc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $cleanPrice = filter_input(INPUT_POST, 'unit_price', FILTER_SANITIZE_STRING);
        $cleanQuantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

        // $quantity = filter_var($cleanQuantity, FILTER_VALIDATE_INT);
        updateProductToDB(htmlentities($_GET['id']), $cleanName, intVal($categorie['id']), $cleanQuantity, $cleanPrice, $cleanDesc);
        header('location:index.php');
    }
    else {
        echo "L'id n'a pas été trouvé";
        header('location:index.php');
    } 
}

function deleteProduct (){
    if (isset ($_GET['id']) && !empty ($_GET['id']) ){
        deleteProductFromDB(htmlentities($_GET['id']));
        header('location:index.php');
    }
    else {
        echo "L'id n'a pas été trouvé";
    }
}




?>