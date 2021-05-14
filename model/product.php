<?php
 
require_once 'database.php';

    // Fonction qui retourne tout les produits de la base de données
    function getProductsFromDB (){
        try {
            $bdd = dbConnect();
            $sqlReq = "SELECT p.id_prod, p.name, p.quantity, p.unit_price, p.description, p.image,  c.id, c.name as cat_name FROM products as p INNER JOIN categories as c ON category_id = c.id ORDER BY c.name, p.unit_price;";
            $req = $bdd -> query ($sqlReq);
            $req -> execute();
            $rep = $req -> fetchAll();
            $req -> closeCursor ();
            if ($rep){
                return $rep;
            }
            else {
                throw new Exception("Aucun produits", 1);
            }
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }        
    }
    

    // Retourne le produit ayant pour id $product_id
    function getProductByIdFromDB($product_id){    
        try {
            $bdd = dbConnect();
            $sqlReq = "SELECT p.id_prod, p.name, p.quantity, p.unit_price, p.description, p.image,  c.id, c.name as cat_name FROM products as p INNER JOIN categories as c ON category_id = c.id  WHERE id_prod = ?;";
            $req = $bdd -> prepare($sqlReq);
            $req -> bindValue (1, $product_id, PDO::PARAM_INT);
            $req->execute();
            $rep = $req -> fetch();
            $req -> closeCursor();
            if ($req){
                return $rep;
            }  
            else {
                throw new Exception("Le produit n'a pas été trouvé dans la base de donnée", 1);                
            }
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }


    // Création d'un produit 
    function addProductToDB($name, $category_id, $quantity, $unit_price, $description, $image=""){
        try {
            $bdd = dbConnect();
            $sqlReq = "INSERT INTO products (name, category_id, quantity, unit_price, description, image) VALUES (?,?,?,?,?,?);";
            $req = $bdd -> prepare($sqlReq);
            $req -> bindValue(1,$name, PDO::PARAM_STR);
            $req -> bindValue(2,$category_id, PDO::PARAM_INT);
            $req -> bindValue(3,$quantity, PDO::PARAM_INT);
            $req -> bindValue(4,$unit_price, PDO::PARAM_STR);
            $req -> bindValue(5,$description, PDO::PARAM_STR);
            $req -> bindValue(6,$image, PDO::PARAM_STR);
            $req -> execute();
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }


    // Modification d'un produit ayant pour id $product_id 
    function updateProductToDB($product_id, $name, $category_id, $quantity, $unit_price, $description){
        try {
            $bdd = dbConnect();
            $sqlReq = "UPDATE products SET name = ?, category_id = ?, quantity = ?, unit_price = ?, description = ? WHERE id_prod = ? ;";
            $req = $bdd -> prepare($sqlReq);
            $req -> bindValue(1, $name, PDO::PARAM_STR);
            $req -> bindValue(2, $category_id, PDO::PARAM_INT);
            $req -> bindValue(3, $quantity, PDO::PARAM_INT);
            $req -> bindValue(4, $unit_price, PDO::PARAM_STR);
            $req -> bindValue(5, $description, PDO::PARAM_STR);
            $req -> bindValue(6, $product_id, PDO::PARAM_INT);
            $req -> execute();
            $req -> closeCursor();
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }


    // updateProduct (10, "Jordan 5 bred", 1, 5, "200", "test667890669");

    // Suppression d'un produit grâce au $product_id
    function deleteProductFromDB($product_id){
        try {
            $bdd = dbConnect();
            $sqlReq = "DELETE FROM products WHERE id_prod = ?;";
            $req = $bdd -> prepare($sqlReq);
            $req -> bindValue(1, $product_id, PDO::PARAM_INT);
            $req -> execute();
            $req -> closeCursor();  
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }



    function getQtyByProd ($product_id){
        try {
            $bdd = dbConnect();
            $sqlReq = "SELECT quantity FROM products WHERE id_prod = ?;";
            $req = $bdd -> prepare($sqlReq);
            $req -> bindValue(1, $product_id, PDO::PARAM_INT);
            $req -> execute();
            $rep = $req -> fetch();
            $req -> closeCursor(); 
            if ($rep){
                return $rep;
            } 
            else {
                throw new Exception("Aucun résultat", 1);
                
            }
        }
        catch (Exception $ex){
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }



    function updateQtyByProd ($product_id, $quantity, $option){
        try {
            $bdd = dbConnect();
            // Decremente de $option  
            $sqlReq = "UPDATE products SET quantity = ? - ? WHERE id_prod = ?"; 
          
    
            $req = $bdd -> prepare($sqlReq);
            $req -> bindValue(1, $quantity);
            $req -> bindValue(2, $option);
            $req -> bindValue(3, $product_id);
            $req -> execute();
            $req -> closeCursor();
        }
        catch (Exception $ex) {
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }        
    }

    // updateQtyByProd(7, intVal(getQtyByProd(7)['quantity']), -60);



?>