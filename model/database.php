<?php
    function dbConnect (){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=store;','root','');
            return $bdd;
        }
        catch (Exception $ex) {
            echo $ex->getMessage() . ' ' . $ex -> getLine() . ' ' . $ex->getFile();
        }
    }

?>