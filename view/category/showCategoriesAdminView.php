<?php
$title = "Page des categories";
ob_start();
?>

<h1 class = "text-center my-5">Liste des catégories</h1>


<a href="index.php?action=addCategory">
    <button class="btn btn-block btn-validate"> Ajouter une catégorie </button>
</a>

<div class="container-fluid  table-responsive">
    <table class = "table text-center table-striped">
        <tr>
            <td>Nom</td>
            <td>Actions</td>
        </tr>
        <?php foreach ($categories as $category){ ?>
            <tr>
                <td><?=$category['name']?></td>
                <td class = "d-flex justify-content-center">
                <a class = "mx-2" href="index.php?action=updateCategory&amp;id=<?=$category['id']?>">
                        <button class="btn btn-update">Modifer</button>
                    </a>
                <a href="index.php?action=deleteCategory&amp;id=<?=$category['id']?>">
                    <button class="btn btn-delete">Supprimer</button>
                </a>

                </td>
            </tr>    
        <?php } ?>
    </table>
</div>

<?php
$content = ob_get_clean();
require_once 'view/template.php';
?>
