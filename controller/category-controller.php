<?php

// Affiche les categories sous forme de tableau
function viewCategoriesTab(){

    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == "admin"){
        $categories = getCategories();
        require_once 'view/category/showCategoriesAdminView.php';
    }
    else {
        header('location:index.php');
    }
}


// Ajoute une catégorie
function addCategory(){

    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == "admin"){

        // Gestion des erreurs
        if (isset($_GET['error']) && !empty($_GET['error'])){
            switch ($_GET['error']) {
                case 'notMatchingName':
                    $errorMessage = "Le nom de la catégorie ne correspond pas à la valeur attendue.<br> Elle ne doit contenir que des lettre et les characteres (, . ' -)";
                    break;
                
                default:
                    $errorMessage ="";
                    break;
            }
        }
        else {
            $errorMessage ="";
        }


        if (isset($_POST['name']) && !empty($_POST['name'])){
            // Les informations dans le formulaire ont été remplits
            $cleanName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            if (preg_match("#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{1,49}$#", $cleanName)){
                // Le nom de la catégorie est valide
                addCategorytoDB($cleanName);
                header('location:index.php?action=categoriesAdmin');
            }
            else {
                header('location:index.php?action=addCategory&error=notMatchingName');
            }
        }
        else {
            // Les informations dans le formulaire n'ont pas encore été remplits
            require_once 'view/category/addCategoryFormView.php';
        }
    }
    else {
        // L'utilisateur n'est pas connecté ou n'est pas un admin
        header('location:index.php');
    }
}


// Modifier une catégorie
function updateCategory (){

    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == "admin"){
        

        // Gestion des erreurs
        if (isset($_GET['error']) && !empty($_GET['error'])){
            switch ($_GET['error']) {
                case 'notMatchingName':
                    $errorMessage = "Le nom de la catégorie ne correspond pas à la valeur attendue.<br> Elle ne doit contenir que des lettre et les characteres (, . ' -)";
                    break;
                
                default:
                    $errorMessage ="";
                    break;
            }
        }
        else {
            $errorMessage ="";
        }


        if (isset($_GET['id'])){
            $category = getCategoryById($_GET['id']);
        }
        if (isset($_POST['name']) && !empty($_POST['name'])){
            // Les informations dans le formulaire ont été remplits
            $cleanName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            if (preg_match("#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{1,49}$#", $cleanName)){
                // Le nom de la catégorie est valide
                updateCategoryToDB($category['id'], $cleanName);
                header('location:index.php?action=categoriesAdmin');
            }
            else {
                header('location:index.php?action=updateCategory&id='.$category['id'].'&error=notMatchingName');
            }
        }
        else {
            // Les informations dans le formulaire n'ont pas encore été remplits
            require_once 'view/category/updateCategoryFormView.php';
        }
    }
    else {
        // L'utilisateur n'est pas connecté ou n'est pas un admin
        header('location:index.php');
    }
}



// Supprimer une catégorie
function deleteCategory(){
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == "admin"){
        if (isset($_GET['id']) && !empty($_GET['id'])){
            deleteCategoryFromDB($_GET['id']);
            header('location:index.php?action=categoriesAdmin');
        }
    }
    else {
        header('location:index.php');
    }
}

?>