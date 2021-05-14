<?php

require_once 'database.php';

    // Retourne toutes les catégories présentes dans la base de données
    function getCategories (){
        try{
            $bdd = dbConnect();
            $sqlReq = "SELECT * FROM categories;";
            $req = $bdd -> query ($sqlReq);
            $req -> execute();
            $rep = $req -> fetchAll();
            $req -> closeCursor();
            if ($rep){
                return $rep;
            }
            else {
                throw new Exception("Aucun resultat", 1);
            }
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }

    function getCategoryById($id){
        try {
            $bdd = dbConnect();
            $sqlReq = "SELECT * FROM categories WHERE id = ?;";
            $req = $bdd -> prepare ($sqlReq);
            $req -> bindValue(1, $id, PDO::PARAM_INT);
            $req -> execute();
            $rep = $req->fetch();
            $req -> closeCursor();
            return $rep;
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }


    function getCategoryByName($name){
        try {
            $bdd = dbConnect();
            $sqlReq = "SELECT * FROM categories WHERE name = ?;";
            $req = $bdd -> prepare ($sqlReq);
            $req -> bindValue(1, $name, PDO::PARAM_STR);
            $req -> execute();
            $rep = $req->fetch();
            $req -> closeCursor();
            return $rep;
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }

    // Ajoute une catégorie à la base de données
    function addCategoryToDB($name){
        try {
            $bdd = dbConnect();
            $sqlReq = "INSERT INTO categories (name) VALUES (?)";
            $req = $bdd -> prepare ($sqlReq);
            $req -> bindValue(1, $name, PDO::PARAM_STR);
            $req -> execute();
            $req -> closeCursor();
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }


    // Modification de la catégorie ayant pour id $category_id
    function updateCategoryToDB($category_id, $name){
        try{
            $bdd = dbConnect();
            $sqlReq = " UPDATE categories SET name = ? WHERE id = ? ;";
            $req = $bdd -> prepare($sqlReq);
            $req -> bindValue(1, $name, PDO::PARAM_STR);
            $req -> bindValue(2, $category_id, PDO::PARAM_INT);
            $req -> execute();
            $req -> closeCursor();
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }      
    }

    // Supprime la catégorie ayant pour id $category_id
    function deleteCategoryFromDB($category_id){
        try {
            $bdd = dbConnect();
            $sqlReq = "DELETE FROM categories WHERE id = ?;";
            $req = $bdd -> prepare ($sqlReq);
            $req -> bindValue(1, $category_id, PDO::PARAM_INT);
            $req -> execute();
            $req -> closeCursor();
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }


?>