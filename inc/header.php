<?php
$filepath = realpath(dirname(__FILE__));

//Vérification de la session 
include_once $filepath."/../lib/Session.php";
Session::init();

error_reporting(0);

spl_autoload_register(function($classes){

  include 'classes/'.$classes.".php";

});
$users = new Users();
?>



<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Ecoit</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/style.css">
  </head>
  <body>

<?php
//Méthode de Deconnexion
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    Session::destroy();
}
?>

 <!--Image de la formation-->
<img src="./image/logo.png" alt="logo">
   <br>
   <br>

    <div class="container">
      <nav class="navbar navbar-expand-md navbar-dark  bg-success text-white card-header">
        <a class="navbar-brand" href="index.php"></i>Accueil</a>      
        <div >
          <ul class="navbar-nav ml-auto">
          
          <!--Si utilisateur est admin affiche dans le header -->
          <?php if (Session::get('id') == TRUE) { ?>
            <?php if (Session::get('roleid') == '1') { ?>

              <li class="nav-item">
                  <a class="nav-link" href="addUser.php"><i class="fas fa-users mr-2"></i>Valider les demandes</span></a>
              </li>
            <?php  } ?>
            <!--Si utilisateur est Apprenant affiche dans le header -->
            <?php if (Session::get('roleid') == '3'){ ?>
              <li class="nav-item">
                <a class="nav-link" href="join_formation.php"></i>Rejoindre une Formation<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="postuler.php"></i>Devenir Instructeur<span class="sr-only">(current)</span></a>
              </li>
            <?php } ?>

            <!--Si utilisateur est Instructeur affiche dans le header -->
            <?php if (Session::get('roleid') == '2'){ ?>
              <li class="nav-item">
                <a class="nav-link" href="creer_formation.php"></i>Créer une Formation<span class="sr-only">(current)</span></a>
              <li class="nav-item">
                <a class="nav-link" href="creer_section.php"></i></i>Créer une Section
                <span class="sr-only">(current)</span></a>
              <li class="nav-item">
                <a class="nav-link" href="creer_lecon.php"></i>Créer une lecon
                <span class="sr-only">(current)</span></a>
              <li class="nav-item">
                <a class="nav-link" href="edit_lecon.php"></i>Modifier une lecon
                <span class="sr-only">(current)</span></a>
              </li>
                <?php }?>

             
            <li class="nav-item
            
            <?php
            //Methode pour activer / desactiver un profil
      				$path = $_SERVER['SCRIPT_FILENAME'];
      				$current = basename($path, '.php');
      				if ($current == 'profile') {
      					echo "active ";
      				}
      			 ?>
            ">
            <!--Lien de redirection avec l'id de l'utilisateur -->
              <a class="nav-link" href="profile.php?id=<?php echo Session::get("id"); ?>"><i class="fab fa-500px mr-2"></i>Mon Profil <span class="sr-only">(current)</span></a>
            </li>
            
              <!--Déconnexion Methode logout-->
            <li class="nav-item">
              <a class="nav-link" href="?action=logout"><i class="fas fa-sign-out-alt mr-2"></i>Deconnexion</a>
            </li>
  
          <?php }?>
          </ul>

        </div>
      </nav>