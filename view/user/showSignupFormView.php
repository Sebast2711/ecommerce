<?php
$title = "Page d'inscription";
$formLink = '<link rel="stylesheet" href="public/form.css">';
ob_start();
?>

    <h1 class="text-center my-5">Inscription</h1>

    <form action="index.php?action=signup" method = "post" class = "mx-auto">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="lastname">Nom de famille</label>
                <input type="text" name = "lastname" id ="lastname" class="form-control" placeholder = "Votre nom de famille">        
            </div>
            <div class="form-group col-md-6">
                <label for="firstname">Prénom</label>
                <input type="text" name = "firstname" id="firstname" class="form-control" placeholder = "Votre prenom">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="email">Adresse Email</label>
                <input type="email" name = "email" id ="email" class="form-control" placeholder = "Votre adresse email">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="passwd">Mot de passe</label>
                <input type="password" name = "passwd" id = "passwd" class="form-control" placeholder = "Votre mot de passe">
            </div>
            <div class="form-group col-md-6">
                <label for="passwdConf">Mot de passe</label>
                <input type="password" name = "passwdConf" id="passwdConf" class = "form-control" placeholder = "Confirmer votre mot de passe">
            </div>
        </div>

            <button class="btn btn-signup btn-block" type="submit">S'inscrire</button>
            <button class="btn btn-update btn-block " type="reset">Remettre à 0</button>


        
    </form>

<p>
<?=$errorMessage?>
</p>
      


<?php
$content = ob_get_clean();
require_once 'view/template.php';
?>