<?php
    $title = "Modification de commande";
    ob_start();
    var_dump($order);
?>


<form action="index.php?action=updateOrder" method = "post">

    <select name="orderStatus" id="orderStatus">
        <?php foreach ($status as $statut) { ?>
            <option value="<?=$statut['id']?>"><?=$statut['name']?></option>
        <?php } ?>
    </select>

    <button type="submit">Validez</button>
</form>


<?php
    $content = ob_get_clean();
    require_once 'view/template.php';
?>
