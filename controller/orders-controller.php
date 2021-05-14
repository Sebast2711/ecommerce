<?php
    require_once 'model/orders.php';


    function viewOrdersTab(){
        if ($_SESSION['user']['role'] == "admin"){
            $orders = getOrders();
            $status = getStatus();
            require_once 'view/orders/orderTabView.php';
        }
        else {
            header('location:index.php');
        }
    }


    function viewDetailedOrder(){
        if (isset($_GET['id']) && !empty($_GET['id'])){
            $order = getOrderByID($_GET['id']);
            $status = getStatus();

            $order_lines = getOrderLinesByOrderID($order['order_id']);
            $totalPrice = getTotalCmd($_GET['id']);
        }
        else {
            header('location:index.php');
        }

        require_once 'view/orders/detailedOrderView.php';
    }


    function placeOrder(){

        $date = strftime("%G-%m-%e", time());

        if (isset($_SESSION['user']['panier']) && !empty($_SESSION['user']['panier'])){
            // Creer une commande

            $refOrder = "CMD#".time().$_SESSION['user']['id'];
            $date = strftime("%G-%m-%d", time());
            $status = 1;

            addOrder($_SESSION['user']['id'], $refOrder, $date, $status);



            // recuperer la commande

            $order = getOrderByRef($refOrder);

            // creer des lignes de commandes 

            foreach($_SESSION['user']['panier'] as $order_line){
                addOrderLines($order['order_id'], $order_line["product"], $order_line["quantity"]);

                if ($order_line["quantity"] > 0) {
                    // Supprimer la quantité dans le stock
                    $qty = getQtyByProd($order_line["product"]);
                    if ($qty['quantity'] - $order_line["quantity"] > 0) {
                        updateQtyByProd($order_line["product"], $qty['quantity'], $order_line["quantity"]);
                        header('location:index.php?action=orderDetails&id='.$order['order_id']);
                    }
                    else {
                        echo 'Pas assez de stock désolé';

                    }
                }

            }

            // Vider le panier
            $_SESSION['user']['panier'] = [];
        }
        else {
            header('location:index.php');
        }
    }



    function updateOrder(){
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] == "admin"){
            if (isset($_GET['id']) && !empty($_GET['id'])){
                $order = getOrderByID($_GET['id']);
                $status = getStatus();

                if (isset($_POST['orderStatus']) && !empty($_POST['orderStatus'])){
                    // Le formulaire a été rempli

                    updateOrderStatus($_GET['id'], intVal(getStatusIdByName($_POST['orderStatus'])[0]));
                    header('location:index.php?action=OrdersAdmin');
                
                }
                else {
                    // Le formulaire n'a pas encore été rempli
                    echo "pas ok";
                }
            }   
            else {
                header('location:index.php?action=OrdersAdmin');
            }         
        }
        else {
            header('location:index.php');
        }
    }


?>