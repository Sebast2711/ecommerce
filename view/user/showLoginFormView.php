<?php
$title = "Formulaire de connexion";
$formLink = '<link rel="stylesheet" href="public/form.css">';

ob_start ();
?>

<h1 class="text-center my-5">Connexion</h1>

<?=$errorMessage?>

<form action="index.php?action=login" method = "post" class="mx-auto">
    <div class="form-row">
        <div class="form-group col-12">
        <label for="email">Adresse Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder = "Votre email" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-12">
            <label for="passwd">Mot de passe</label>
            <input type="password" name="passwd" id="passwd" class="form-control" placeholder = "Votre mot de passe" required>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class = "btn btn-block btn-login">Se connecter</button>
    </div>

</form>


<?php
$content = ob_get_clean();
require_once "view/template.php";
?>