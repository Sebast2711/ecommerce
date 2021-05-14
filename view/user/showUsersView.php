<?php
    $title = "Utilisateurs du site";
    ob_start();
?>

<h1 class = "text-center my-5">Liste des clients</h1>

<a href="index.php?action=signup">
    <button class=" btn-block btn-validate btn no-deco"> Ajouter un client</button>
</a>

<div class="container-fluid table-responsive">
    <table class = "table table-striped">
        <tr>
            <td>Nom</td>
            <td>Prenom</td>
            <td>Email</td>
            <td>Mot de passe</td>
            <td>Actions</td>
        </tr>
    <?php
        // var_dump($users);
        foreach ($users as $user) {
    ?>
        <tr>
            <td><?=$user['lastname']?></td>
            <td><?=$user['firstname']?></td>
            <td><?=$user['email']?></td>
            <td><?=$user['password']?></td>

            <td>
                <a href="index.php?action=updateUser&amp;id=<?=$user['id']?>">
                    <button class="btn btn-update">Modifier</button>
                </a>
                <a href="index.php?action=deleteUser&amp;id=<?=$user['id']?>">
                    <button class="btn btn-delete">Supprimer</button>
                </a>
                
            </td>
        </tr>



    <?php        
        }
    ?>
    </table>
</div>


<?php
    $content = ob_get_clean();
    require_once 'view/template.php';
?>