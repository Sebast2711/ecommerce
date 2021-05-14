<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="public/navbar.css">
    <link rel="stylesheet" href="public/buttons.css">
    <?php
      if (isset($cssLink)){
        echo $cssLink;
      }
      if (isset($formLink)){
        echo $formLink;
      }
      if (isset($tableLink)){
        echo $tableLink;
      }
      if (isset($detailedProductLink)){
        echo $detailedProductLink;
      }
      if (isset($cartLink)){
        echo $cartLink;
      }
    ?>
    
</head>
<body>




<nav class="navbar navbar-expand-lg navbar-light bg-light ">
<!-- Logo -->
<a class="navbar-brand" href="index.php">
  <img id="image4" src="public/images/LOGO4.svg" alt="brand-logo-top">
    <img id="image1" src="public/images/LOGO1.svg" alt="brand-logo-mid">
    <img id="image3" src="public/images/LOGO3.svg" alt="brand-logo-bottom">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end " id="navbarNavDropdown">
    <ul class="navbar-nav">
      <!-- Liens basique -->
      <li class="nav-item ">
        <a class="nav-link" href="index.php">Accueil</a>
      </li>

      <?php
        if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == "admin" || $_SESSION['user']['role'] == "client") ){
      ?>
        
      <li class="nav-item ">
        <a class="nav-link" href="index.php?action=monCompte"> Mon compte </a>
      </li>

      <a href="index.php?action=showCart" class = "d-flex align-items-center">
        <i class="fas fa-shopping-cart"></i>

        
        <!-- Calcul du nombre d'élément dans le panier  -->
        <?php
          $cartNumber = 0;
          for ($i = 0; $i < count ($_SESSION['user']['panier']); $i++){
            $cartNumber += intVal($_SESSION['user']['panier'][$i]["quantity"]); 
        }

        ?>

        <span class='badge badge-warning' id='lblCartCount'> <?=$cartNumber?> </span>
      </a>
      <!-- Lien pour l'admin  -->
        <?php
            if ($_SESSION['user']['role'] == "admin"){

        ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Fonctions Admin </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="index.php?action=showClientAdmin">Clients</a>
          <a class="dropdown-item" href="index.php?action=productAdmin">Produits</a>
          <a class="dropdown-item" href="index.php?action=categoriesAdmin">Categories</a>
          <a class="dropdown-item" href="index.php?action=OrdersAdmin">Commandes</a>
        </div>
      </li>
    </ul>
    <?php }
    } 
        else {
            
    ?>
    <!-- Bouttons pour enregistrer un utilisateur -->
    <div class="buttons ">
        <a href="index.php?action=login"><button class="btn btn-login">Se connecter</button></a>
        <a href="index.php?action=signup"><button class="btn btn-signup">S'inscrire</button></a>
    </div>
    <?php } ?>
  </div>
</nav>


<!-- <div class="container p-5 text-danger text-center">
    <h2>Ce site n'est pas un VRAI SITE d'achat (template et logique php)</h2>
</div> -->


    <?=$content?>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
