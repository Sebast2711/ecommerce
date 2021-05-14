<?php
$title = "Modification de mes informations personnelles";
$formLink = '<link rel="stylesheet" href="public/form.css">';

ob_start();

    if (isset($_GET['id'])){
        $urlRedir = "index.php?action=updateUser&amp;id={$user['id']}";
    }
    else {
        $urlRedir = "index.php?action=updateUser";
    }

?>




<h1 class="text-center my-5">Modification du client</h1>

<form action="<?=$urlRedir?>" method = "post" class = "mx-auto">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstname">Nom de famille</label>
            <input type="text" name = "firstname" id = "firstname" class="form-control" value="<?=$user['firstname']?>"  required>
        </div>
        <div class="form-group col-md-6">
            <label for="lastnaem">Prénom</label>
            <input type="text" name = "lastname" id = "lastname" class = "form-control" value="<?=$user['lastname']?>" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-12">
            <label for="email">Adresse Email</label>
           <input type="email" name = "email" id = "email" class = "form-control" value="<?=$user['email']?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-12">
            <label for="passwd">Mot de passe</label>
            <input type="password" name = "passwd" id = "passwd" class = "form-control" value="<?=$user['password']?>" required>
        </div>
    </div>

    <div class="text-center">   
        <button type="submit" class="btn btn-block btn-update">Modifier</button>
    </div>

    <p><?=$errorMessage?></p>

</form>





<?php
$content = ob_get_clean();
require_once 'view/template.php';
?>