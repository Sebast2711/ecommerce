<?php
    $title = "Commandes";
    ob_start();
?>

    <h1 class = "my-5 text-center">Liste des commandes</h1>

<?php if (isset($orders) && !empty($orders)) {?>


    <div class="table-responsive container-fluid">
        <table class = "table table-striped">
            <tr>
                <td>Numero</td>
                <td>Nom Prenom</td>
                <td>Email</td>
                <td>Référence</td>
                <td>Date</td>
                <td>Status</td>
                <td>Actions</td>
            </tr>


        

            <?php foreach ($orders as $order) { ?>
    
                <tr>
                    <td><?=$order['order_id']?></td>
                    <td><?=$order['lastname']?> <?=$order['firstname']?></td>
                    <td><?=$order['email']?></td>
                    <td><?=$order['ref_cde']?></td>
                    <td><?=$order['date']?></td>

                    <td>

                    <form action="index.php?action=updateOrder&amp;id=<?=$order['order_id']?>" method = "post">
                        <select name="orderStatus" id="orderStatus">
                            <option value="<?=$order['order_status']?>"><?=$order['order_status']?></option>
                            <?php foreach ($status as $statut) {
                                    if ($order['order_status'] != $statut['name']) { ?>
                                    <option value="<?=$statut['name']?>"><?=$statut['name']?></option>
                                <?php } 
                                } ?>
                        </select>
                        <button type="submit" class = "btn btn-update">Validez</button>
                    </form>

                    </td>
                    
                    
                    
                    <td><a href="index.php?action=orderDetails&amp;id=<?=$order['order_id']?>"><button class = "btn btn-product">Details</button></a></td>
                </tr>

            <?php } ?>  
        </table>
    </div>
<?php }
else { ?>
    <h3 class = "text-center"> Aucune commandes pour l'instant</h2>

<?php }?>

<?php
    $content = ob_get_clean();
    require_once 'view/template.php';
?>