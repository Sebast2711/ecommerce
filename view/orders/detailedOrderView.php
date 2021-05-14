<?php
    $title = "Detail de commande";
    ob_start();
?>

<?php if (isset($order) && !empty($order)){ 
        if ($_SESSION['user']['role'] == "admin"){
    ?>
    <div class="container table-reponsive my-5">
        <table class="table table-striped">
            <tr>
                <th>Nom Prenom</th>
                <th>Email</th>
                <th>Reference</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <tr>
                <td><?=$order['lastname']?> <?=$order['firstname']?></td>
                <td><?=$order['email']?></td>
                <td><?=$order['ref_cde']?></td>
                <td><?=$order['date']?></td>
                <td><?=$order['order_status']?></td>
            </tr>
            
        </table>
        <?php } ?>
    
    </div>

    <?php if (isset($order_lines) && !empty($order_lines)) { ?>
        <div class = "container table-responsive my-5">
            <table class = "table table-striped">
                <tr>
                    <th>Nom produit</th>
                    <th>Qté commandé</th>
                    <th>Prix</th>
                </tr>
                <?php foreach ($order_lines as $order_line) { ?>
                    <tr>
                        <td><?=$order_line['name']?></td>
                        <td><?=$order_line['quantity']?></td>
                        <td><?=getTotalByProd($order_line['line_id'])[0]?>€</td>
                    </tr>
                <?php } ?>

                <tr>
                    <td colspan = "2" class = "text-right">Prix total</td>
                    <td ><?=$totalPrice['totalPriceCmd']?>€</td>
                </tr>
            </table>    
        </div>
    <?php } ?>

<?php } ?>


<?php
    $content = ob_get_clean();
    require_once 'view/template.php';
?>

