<?php


require_once 'database.php';
// Order lines

function getOrderLines (){
    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT * FROM order_lines;";
        $req = $bdd -> query($sqlReq);
        $req -> execute();
        $rep = $req -> fetchAll();
        $req -> closeCursor();
        if ($rep){
            return $rep;
        }
        else {
            throw new Exception("Aucun résultat", 1);
            
        }
    }
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}




function getOrderLineByID ($orderLineId){
    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT * FROM order_lines WHERE id = ?;";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $orderLineId);
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
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}




function getOrderLinesByOrderID ($orderID){
    try {
        $bdd = dbConnect();
        $sqlReq = " SELECT ol.order_id as order_id, ol.id as line_id , ol.quantity, p.name, p.id_prod as product_id 
        FROM order_lines as ol 
        INNER JOIN products as p ON ol.product_id = p.id_prod  
        WHERE ol.order_id = ? ;";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $orderID);
        $req -> execute();
        $rep = $req -> fetchAll();
        $req -> closeCursor();
        if ($rep){
            return $rep;
        }
        else {
            throw new Exception("Aucun résultat", 1);
            
        }
    }
    catch (Exception $ex) {
        $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}


function addOrderLines ($orderID, $productID, $quantity){
    try {
        $bdd = dbConnect();
        $sqlReq = "INSERT INTO order_lines (order_id, product_id, quantity) VALUES (?,?,?);";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $orderID); 
        $req -> bindValue(2, $productID); 
        $req -> bindValue(3, $quantity);
        $req -> execute();
        $req -> closeCursor();
    }
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}


// addOrderLines(1,1, 14);



function updateOrderLine($orderLineID, $orderID, $productID, $quantity){
    try {
        $bdd = dbConnect();
        $sqlReq = "UPDATE order_lines SET order_id = ? , product_id = ?, quantity = ? WHERE id = ?;";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $orderID);
        $req -> bindValue(2, $productID);
        $req -> bindValue(3, $quantity);
        $req -> bindValue(4, $orderLineID);
        $req -> execute();
        $req -> closeCursor();
    }
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}

// updateOrderLine (2, 1, 9, 13);


function deleteOrderLine ($orderLineID){
    try {
        $bdd = dbConnect();
        $sqlReq = "DELETE FROM order_lines WHERE id = ?;";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $orderLineID);
        $req -> execute();
        $req -> closeCursor();
    }
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}




function getTotalByProd($cmdLineID){
    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT (ol.quantity * p.unit_price) as totalPriceByProd 
        FROM order_lines as ol 
        INNER JOIN products as p ON ol.product_id = p.id_prod 
        WHERE ol.id = ?";

        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $cmdLineID);
        $req -> execute();
        $rep = $req -> fetch();
        $req->closeCursor();
        return $rep;
    }

    catch (Exception $ex){
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}



function getTotalCmd ($cmdID){
    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT SUM(ol.quantity * p.unit_price) as totalPriceCmd 
        FROM order_lines as ol 
        INNER JOIN products as p ON ol.product_id = p.id_prod 
        WHERE ol.order_id = ?;";

        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $cmdID);
        $req -> execute();
        $rep = $req -> fetch();
        $req->closeCursor();
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

// var_dump(getTotalCmd(1));


// Order

function getOrders (){
    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT o.id as order_id, u.lastname, u.firstname, u.email, o.date, o.ref_cde,os.name as order_status 
        FROM orders as o 
        INNER JOIN users as u ON o.customer_id = u.id
        INNER JOIN order_status as os ON o.status = os.id 
        ORDER BY o.id;";
        $req = $bdd -> query($sqlReq);
        $req -> execute();
        $rep = $req -> fetchAll();
        $req -> closeCursor();
        if ($rep){
            return $rep;
        }
        else {
            throw new Exception("Aucun résultat", 1);
            
        }
    }
    catch (Exception $ex) {
        // Enregistrer dans un fichier l'excpetion
        $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}



function getOrderByID($orderID) {
    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT o.id as order_id, u.lastname, u.firstname, u.email, o.date, o.ref_cde,os.name as order_status 
        FROM orders as o 
        INNER JOIN users as u ON o.customer_id = u.id
        INNER JOIN order_status as os ON o.status = os.id 
        WHERE o.id = ?;";

        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $orderID);
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
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}



function getOrderByRef($orderRef) {
    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT o.id as order_id, u.lastname, u.firstname, u.email, o.date, o.ref_cde,os.name as order_status 
        FROM orders as o 
        INNER JOIN users as u ON o.customer_id = u.id
        INNER JOIN order_status as os ON o.status = os.id 
        WHERE o.ref_cde = ?;";

        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $orderRef);
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
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}



function getOrdersByCustomerID ($customerID){
    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT o.id as order_id, o.date, o.ref_cde, os.name as order_status 
        FROM orders as o 
        INNER JOIN order_status as os ON o.status = os.id
        WHERE o.customer_id = ?;";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $customerID);
        $req -> execute();
        $rep = $req -> fetchAll();
        $req -> closeCursor();
        if ($rep){
            return $rep;
        }
        else {
            throw new Exception("Aucun résultat pour les commandes de cette utilisateur", 1);
            
        }
    }
    catch (Exception $ex) {
        // Enregistrer dans un fichier  
        $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}



function addOrder ($customerID, $refCde, $date, $status){
    try {
        $bdd = dbConnect();
        $sqlReq = "INSERT INTO orders (customer_id, ref_cde, date, status) VALUES (?,?,?,?);";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $customerID);
        $req -> bindValue(2, $refCde);
        $req -> bindValue(3, $date);
        $req -> bindValue(4, $status);
        $req -> execute();
        $req -> closeCursor();
    }
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
    
}


function updateOrderToDB($orderID, $customerID, $refCde, $date){
    try {
        $bdd = dbConnect();
        $sqlReq = "UPDATE orders SET customer_id = ?, ref_cde = ?, date = ? WHERE id = ?;";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $customerID);
        $req -> bindValue(2, $refCde);
        $req -> bindValue(3, $date);
        $req -> bindValue(4, $orderID);
        $req -> execute();
        $req -> closeCursor();
    }
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}


// updateOrder(3, 1, "Commande Changé 3", strftime("%G-%m-%e %H:%M:%S", time()) );


function deleteOrder($orderID){
    try {
        $bdd = dbConnect();
        $sqlReq = "DELETE FROM orders WHERE id = ?;";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $orderID);
        $req -> execute();
        $req -> closeCursor();
    }
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}





function getStatus(){

    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT * FROM order_status;";
        $req = $bdd -> query($sqlReq);
        $req -> execute();
        $rep = $req -> fetchAll();
        $req -> closeCursor();
        if ($rep){
            return $rep;
        }
        else {
            throw new Exception("Aucun status", 1);
        }
    }
    catch(Exception $ex){
        echo $ex;
    }
}

function getStatusIdByName($name){
    try {
        $bdd = dbConnect();
        $sqlReq = "SELECT id FROM order_status WHERE name = ?;";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $name);
        $req -> execute();
        $rep = $req -> fetch();
        $req -> closeCursor();
        if ($rep) {
            return $rep;
        }
        else {
            throw new Exception("Aucun status trouvé", 1);
            
        }
    }
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}




function updateOrderStatus($orderID, $status){
    try {
        $bdd = dbConnect();
        $sqlReq = "UPDATE orders SET status = ? WHERE id = ?";
        $req = $bdd -> prepare($sqlReq);
        $req -> bindValue(1, $status);
        $req -> bindValue(2, $orderID);
        $req -> execute();
        $req -> closeCursor();
    }
    catch (Exception $ex) {
        echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
    }
}

?>