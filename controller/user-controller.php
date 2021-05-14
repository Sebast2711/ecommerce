<?php

require_once 'model/user.php';


// Connexion à la base de données et création de la session
function login(){

    // Switch case pour ecrire le message d'erreur
    if (isset($_GET['error'])){
        switch ($_GET['error']) {
            case 'notMatchingPasswd':
                $errorMessage = "Le mot de passe ne correspond pas";
                break;
            case 'userNotFound':
                $errorMessage = "Desolé l'email entrée ne correspond à aucun compte";
                break; 

            default:
            $errorMessage = "";
            break;
        }
    }
    else {
        $errorMessage = "";
    }


    if (isset($_SESSION['user'])){
        // L'utilisateur est deja connecté
        header('location:index.php');
    }
    else if (isset($_POST['email']) && isset($_POST['passwd'])){
        // Nous avons le résultat du formulaire de connexion
        if ($user = getUserByEmailFromDB(htmlentities($_POST['email']))){
            // L'email correspond a un enregistrement de la base de données
            if ($user ['password'] == $_POST['passwd']){
                // Le mot de passe correspond alors on initialise la session    
                $_SESSION['user'] = [
                    "id" => $user ['id'],
                    "lastname" => $user['lastname'],
                    "firstname" => $user ['firstname'],
                    "email" => $user ['email'],
                    "passwd" => $user ['password'],
                    "role" => $user ['status']
                ];
                if ($cart = unserialize($user ['cart'])){
                    // Le panier est deja rempli (dans la base de données)
                    $_SESSION['user']['panier'] = $cart;
                }
                else {
                    // Le panier est vide (dans la base de données)
                    $_SESSION['user']['panier'] = [];
                }

                // Redirige l'utilisateur sur la page d'accueils
                header('location:index.php');
            }
            else {
                // Le mot de passe ne correspond pas
                header('location:index.php?action=login&error=notMatchingPasswd');
            }           
        }
        else {
            // L'utilisateur n'a pas été trouvé
            header('location:index.php?action=login&error=userNotFound');
        }

    }
    else {
        // L'utilisateur n'est pas connecté et il n'a pas déjà rempli le formulaire de connexion
        require_once 'view/user/showLoginFormView.php'; 
    }

}


// Inscription d'un utilisateur ou création d'un nouvel utilisateur si Admin
function signup (){

    // Gestion des erreurs
    if (isset($_GET['error'])){
        switch ($_GET['error']) {

            case 'notCorrespondingPasswd':
                $errorMessage = "Le mot de passe et la confirmation du mot de passe ne sont pas identique";    
                break;
            case 'incorrectInput':
                $errorMessage = "Les champs n'ont pas bien été remplis";
                break;
            case 'notMatchingLastName':
                $errorMessage = "Le nom de famille n'a pas bien été remplie.<br>Vérifier qu'il ne contient pas de chiffre ou de caractère spéciaux";
                break;    
            case 'notMatchingFirstName':
                $errorMessage = "Le prénom n'a pas bien été remplie.<br>Vérifier qu'il ne contient pas de chiffre ou de caractère spéciaux";
                break;    
            case 'notMatchingEmail':
                $errorMessage = "L'adresse email n'a pas bien été remplie.";
                break;
            case 'notMatchingPasswd':
                $errorMessage = "Le mot de passe n'a pas bien été remplie.<br> Le mot de passe doit possédé 8 caractère <br> Obligatoire : Une lettre en majuscule, une lettre en minuscule, un chiffre <br> Falcultatif : Un caractère special (+-!?.)";
                break;
            case 'notMatchingPasswdConf':
                $errorMessage = "La confirmation du mot de passe n'a pas bien été remplie.";

            default:
            $errorMessage = "";
                break;
        }
    }
    else {
        $errorMessage = "";
    }



    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == "client"){
        // L'utilisateur est déjà connecté
        header('location:index.php');
    }
    else if (isset($_POST) && !empty($_POST)){
        // Les champs du formulaire d'inscription ont été remplits
        if (isset($_POST['lastname']) && !empty($_POST['lastname']) && isset($_POST['firstname']) && !empty($_POST['firstname']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['passwd']) && !empty($_POST['passwd']) && isset($_POST['passwdConf']) && !empty($_POST['passwdConf'])){
            // Tout les champs sont bien remplis et non vide
            if ($_POST['passwd'] == $_POST['passwdConf']){
                // Les mot de passe correspondent
                
                $cleanLastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
                $cleanFirstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
                $cleanEmail = filter_input (INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

                // Validation avec des Regex
                if (preg_match("#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{1,255}$#", $cleanLastname)){
                    // Le nom de famille est valide
                    if (preg_match("#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{1,255}$#", $cleanFirstname)){
                        // Le prénom est valide
                        if (preg_match("#^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$#", $cleanEmail) && !getUserByEmailFromDB($cleanEmail)){
                            // L'adresse mail est valide et n'est pas déjà dans la base de donnée
                            if (preg_match( "#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z!?._+\-\d]{8,}$#", htmlentities($_POST['passwd']))){
                                // Le mot de passe est valide
                                if (preg_match( "#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z!?._+\-\d]{8,}$#", htmlentities($_POST['passwdConf']))){
                                    // La confirmation du mot de passe est valide

                                    // On ajoute le client a la base de données
                                    addUserToDB ($cleanLastname, $cleanFirstname, $cleanEmail, $_POST['passwd']);
                                    if ($_SESSION['user']['role'] == "admin"){
                                        // On redirige l'admin sur la page showUser
                                        header('location:index.php?action=showClientAdmin');
                                    } 
                                    else {
                                        // On redirige le client sur la page de connexion
                                        header('location:index.php?action=login');
                                    }

                                }
                                else {
                                    header('location:index.php?action=signup&error=notMatchingPasswdConf');
                                }
                            }
                            else {
                                header('location:index.php?action=signup&error=notMatchingPasswd');
                            }
                        }
                        else {
                            header('location:index.php?action=signup&error=notMatchingEmail');
                        }
                    }
                    else {
                        header('location:index.php?action=signup&error=notMatchingFirstName');
                    }
                }
                else {
                    header('location:index.php?action=signup&error=notMatchingLastName');
                }

            }
            else {
                header('location:index.php?action=signup&error=notCorrespondingPasswd');
            }
        }
        else {
            // Les champs ne sont pas bien remplits 
            header('location:index.php?action=signup&error=incorrectInput');
        }
    }
    else {
        // Les champs du formulaire d'inscription n'ont pas encore été remplits
        require_once 'view/user/showSignupFormView.php';
    }
}


// Modifie les informations de l'utilisateur grace à la session
// On ne peux pas modifier un admin 
function updateUser (){

 // Gestion des erreurs
    if (isset($_GET['error'])){
        switch ($_GET['error']) {
            case 'incorrectInput':
                $errorMessage = "Les champs n'ont pas bien été remplis";
                break;
            case 'notMatchingLastName':
                $errorMessage = "Le nom de famille n'a pas bien été remplie.<br>Vérifier qu'il ne contient pas de chiffre ou de caractère spéciaux";
                break;    
            case 'notMatchingFirstname':
                $errorMessage = "Le prénom n'a pas bien été remplie.<br>Vérifier qu'il ne contient pas de chiffre ou de caractère spéciaux";
                break;    
            case 'notMatchingEmail':
                $errorMessage = "L'adresse email n'a pas bien été remplie.";
                break;
            case 'notMatchingPasswd':
                $errorMessage = "Le mot de passe n'a pas bien été remplie.<br> Le mot de passe doit possédé 8 caractère <br> Obligatoire : Une lettre en majuscule, une lettre en minuscule, un chiffre <br> Falcultatif : Un caractère special (+-!?.)";
                break;
         
            default:
            $errorMessage = "";
                break;
        }
    }
    else {
        $errorMessage = "";
    }
    


    if (isset ($_SESSION['user'])){
        if ($_SESSION['user']['role'] == "admin"){
            // L'utilisateur est un admin
            if (isset($_GET['id'])){
                $user = getUserByIdFromDB(htmlentities($_GET['id']));
            }
        }
        else {
            // L'utilisateur est un client
            $user = getUserByIdFromDB($_SESSION['user']['id']);
        }
    }
    else {
        // L'utilisateur n'est pas connecté
        header('location:index.php');
    }

    if ($user['status'] == 'admin'){
        // Quelqu'un essaye de modifier un admin
        header('location:index.php');
    }


    if (isset($_POST) && !empty ($_POST)){
        // Nous avons le resultat du formulaire de modification d'utilisateur
        if (isset($_POST['lastname']) && isset($_POST['firstname']) && isset($_POST['email']) && isset($_POST['passwd'])){  
            // Le formulaire est remplie avec des champs non vide            
            
            $cleanLastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
            $cleanFirstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
            $cleanEmail = filter_input (INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            if (preg_match("#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{1,255}$#", $cleanLastname)){
                // Le nom de famille est valide
                if (preg_match("#^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{1,255}$#", $cleanFirstname)){
                    // Le prénom est valide
                    if (preg_match("#^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$#", $cleanEmail)){
                        // L'adresse mail est valide
                        if (htmlentities($_POST['email']) == $user['email'] || !getUserByEmailFromDB($cleanEmail)) {
                            // L'adresse mail n'a pas été changé OU n'est pas présente dans la base de données 
                            if (preg_match( "#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z!?._+\-\d]{8,}$#", htmlentities($_POST['passwd']))){
                                // Modification dans la base de données
                                updateUserToDB ($user['id'], $cleanLastname, $cleanFirstname, $cleanEmail, htmlentities($_POST['passwd']), 2);
                                
                                $_SESSION['user']['lastname'] = $cleanLastname;
                                $_SESSION['user']['firstname'] = $cleanFirstname;
                                $_SESSION['user']['email'] = $cleanEmail;
                                $_SESSION['user']['passwd'] = $_POST['passwd'];



                                // Redirections
                                if ($_SESSION['user']['role'] == "client"){
                                    header('location:index.php?action=monCompte');
                                }
                                else if ($_SESSION['user']['role'] == "admin"){
                                    header('location:index.php?action=showClientAdmin');
                                }
                                else {
                                    header('location:index.php');
                                }
                            }
                            else {
                                header('location:index.php?action=updateUser&id='. $user['id'].'&error=notMatchingPasswd');
                            }
                        }
                        else {
                            header('location:index.php?action=updateUser&id='. $user['id'].'&error=notMatchingEmail');
                        }
                    }
                    else {
                        header('location:index.php?action=updateUser&id='. $user['id'].'&error=notMatchingEmail');
                    }
                }
                else {
                    header('location:index.php?action=updateUser&id='. $user['id'].'&error=notMatchingFirstname');
                }
            }
            else {
                header('location:index.php?action=updateUser&id='. $user['id'].'&error=notMatchingLastname');
            }
        } 
        else {
            header('location:index.php?action=updateUser&id='. $user['id'].'&error=notMatchingincorrectInput');
        }
    }
    else {        
        // Le formulaire d'inscription n'a pas encore été rempli
        if (isset($user)){
            require_once 'view/user/showUpdateFormView.php';
        }
        else{
            echo "Vous n'etes pas connecté";
        }
    }
}







// Récupere les informations de l'utilisateur depuis la session
function showAccountInfo (){
    if (isset ($_SESSION['user'])){
        $user = getUserByIdFromDB($_SESSION['user']['id']);
        $orders = getOrdersByCustomerID($_SESSION['user']['id']);
        require_once 'view/user/showInfoView.php';
    }
    else{
        // L'utilisateur n'est pas connecté
        header('location:index.php?action=login');
    }
}


// Deconnexion de l'utilisateur
function deconnectUser(){

    if (isset($_SESSION['user'])){
        if ($_SESSION['user']['role'] == "admin"){
            $role = 1;
        }
        else {
            $role = 2;
        }

        // Met a jour le panier avant de se deconnecter pour garder la panier quand l'utilisateur se reconnecte
        if (!empty($_SESSION['user']['panier'])){
            updateUserToDB ($_SESSION['user']['id'], $_SESSION['user']['lastname'], $_SESSION['user']['firstname'], $_SESSION['user']['email'], $_SESSION['user']['passwd'], $role, serialize($_SESSION['user']['panier']));
        }
        else {
            updateUserToDB ($_SESSION['user']['id'], $_SESSION['user']['lastname'], $_SESSION['user']['firstname'], $_SESSION['user']['email'], $_SESSION['user']['passwd'], $role, serialize($_SESSION['user']['panier']));
        }

        setcookie (session_id(), "", time() - 3600);
        session_destroy();
        session_write_close();
    }


    header('location:index.php');
}



// Affiche tout les clients
function showUsers (){
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'){
        $users = getUsersFromDB();
        require_once 'view/user/showUsersView.php';
    }
    else {
        header ('location:index.php');
    }    
}


// Supprime un client
function deleteUser () {
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == "admin"){
        if (isset($_GET['id']) && !empty($_GET['id'])){
            deleteUserFromDB($_GET['id']);
            header('location:index.php?action=showClientAdmin');
        }
    }
    else {
        header('location:index.php');
    }
}


?>