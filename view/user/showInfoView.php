<?php
$title = "Mes Informations";
$tableLink = '<link rel="stylesheet" href="public/table.css">'; 
ob_start();
?>

<h1 class="text-center my-5">Infomations personnelles</h1>

<div class ="table-responsive ">
    <table class ="table table-striped mx-auto">
        <tr>
            <td>Nom de famille</td>
            <td><?=$user['lastname']?></td>
        </tr>
        <tr>
            <td>Prénom</td>
            <td><?=$user['firstname']?></td>
        </tr>
        <tr>
            <td>Adresse Email</td>
            <td><?=$user['email']?></td>
        </tr>
        <tr>
            <td>Mot de passe</td>
            <td><?=$user['password']?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?=$user['status']?></td>
        </tr>

    </table>
</div>



<div class="text-center">

    <?php if ($_SESSION['user']['role'] == "client"){ ?> 
        <a href="index.php?action=updateUser"><button class="btn btn-update">Modifier mes informations</button></a>
    <?php } ?>

    <a href="index.php?action=deconnexion"><button class="btn btn-delete">Se deconnecter</button></a>
</div>


<?php if (isset ($_SESSION['user']) && $_SESSION['user']['role'] == "client") { 
        if (isset($orders) && !empty($orders)){
    ?>
<div class="table-responsive my-5">
    <table class = "table table-striped mx-auto">
        <tr>
            <td>Référence</td>
            <td>Date</td>
            <td>Status</td>
            <td>Actions</td>
        </tr>


        <?php foreach ($orders as $order) { ?>
            <tr>
                <td><?=$order['ref_cde']?></td>
                <td><?=$order['date']?></td>
                <td><?=$order['order_status']?></td>
                <td>
                    <a href="index.php?action=orderDetails&amp;id=<?=$order['order_id']?>"><button class="btn btn-product">Details</button></a>
                </td>
            </tr>

        <?php } ?>  

    </table>
</div>

<?php   } 
    }?>


<?php
$content = ob_get_clean();
require_once 'view/template.php';

?>