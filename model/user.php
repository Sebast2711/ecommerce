<?php
require_once 'database.php';

    // Retourne tout les utilisateurs présents dans la base de données
    function getUsersFromDB (){
        try {
            $bdd = dbConnect();
            $sqlReq = "SELECT * FROM users WHERE statut_id = 2;";
            $req = $bdd -> query ($sqlReq);
            $req -> execute();
            $rep = $req -> fetchAll();
            $req -> closeCursor();
            if ($rep){
                return $rep;
            }
            else{
                throw new Exception("Aucun utilisateur", 1);
                return false;
            }
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }

    // Retourne l'utilisateur ayant pour id $user_id
    function getUserByIdFromDB ($user_id){
        try {
            $bdd = dbConnect();
            $sqlReq = "SELECT u.id, u.firstname, u.lastname, u.email, u.password,u.cart, us.status FROM users as u INNER JOIN user_status as us ON u.statut_id = us.id WHERE u.id = ? ;";
            $req = $bdd -> prepare ($sqlReq);
            $req -> bindValue(1, $user_id, PDO::PARAM_INT);
            $req -> execute();
            $rep = $req -> fetch();
            $req -> closeCursor();
            if ($rep){
                return $rep;    
            }
            else{
                return false;
                throw new Exception("Aucun utilisateur", 1);
            }
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }




    // Retourne l'utilisateur ayant pour email $user_email
    function getUserByEmailFromDB ($user_email){
        try {
            $bdd = dbConnect();
            $sqlReq = "SELECT u.id, u.firstname, u.lastname, u.email, u.password,u.cart, us.status FROM users as u INNER JOIN user_status as us ON u.statut_id = us.id WHERE u.email = ? ;";
            $req = $bdd -> prepare ($sqlReq);
            $req -> bindValue(1, $user_email, PDO::PARAM_STR);
            $req -> execute();
            $rep = $req -> fetch();
            $req -> closeCursor();
            if ($rep){
                return $rep;    
            }
            else{
                return false;
                throw new Exception("Aucun utilisateur", 1);
            }
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }



    // Ajoute un utilisateur à la base de données
    function addUserToDB ($lastname, $firstname, $email, $password, $statut_id = 2){
        try {
            $bdd = dbConnect();
            $sqlReq = "INSERT INTO users (lastname, firstname, email, password, statut_id) VALUES (?,?,?,?,?);";
            $req = $bdd -> prepare($sqlReq);
            $req -> bindValue(1, $lastname, PDO::PARAM_STR);
            $req -> bindValue(2, $firstname, PDO::PARAM_STR);
            $req -> bindValue(3, $email, PDO::PARAM_STR);
            $req -> bindValue(4, $password, PDO::PARAM_STR);
            $req -> bindValue(5, $statut_id, PDO::PARAM_INT);
            $req -> execute();
            $req -> closeCursor();
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }

    // Modification de l'utilisateur ayant pour id $user_id
    function updateUserToDB ($user_id, $lastname, $firstname, $email, $password, $statut_id, $panier = ""){
        try {
            $bdd = dbConnect();
            $sqlReq = "UPDATE users SET lastname = ?, firstname = ?, email = ?, password = ?, statut_id = ?, cart = ? WHERE id = ? ;";
            $req = $bdd -> prepare ($sqlReq);
            $req -> bindValue(1,$lastname, PDO::PARAM_STR); 
            $req -> bindValue(2,$firstname, PDO::PARAM_STR); 
            $req -> bindValue(3,$email, PDO::PARAM_STR); 
            $req -> bindValue(4,$password, PDO::PARAM_STR); 
            $req -> bindValue(5,$statut_id,PDO::PARAM_INT); 
            $req -> bindValue(6,$panier,PDO::PARAM_STR); 
            $req -> bindValue(7,$user_id,PDO::PARAM_INT); 
            $req -> execute();
            $req -> closeCursor();
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }


    // Suppression de l'utilisateur ayant pour id $user_id
    function deleteUserFromDB($user_id){
        try {
            $bdd = dbConnect();
            $sqlReq = "DELETE FROM users WHERE id = ?;";
            $req = $bdd -> prepare($sqlReq);
            $req -> bindValue(1, $user_id, PDO::PARAM_INT);
            $req -> execute();
            $req -> closeCursor();
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }


?>